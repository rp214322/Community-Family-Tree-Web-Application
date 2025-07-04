<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FamilyMember;
use App\Models\User;

class DashboardController extends Controller
{
    private function buildTree($user, $members, $parentId = null, $directFamilyIds = [])
    {
        $children = $members->where('parent_id', $parentId);
        $tree = [];
        foreach ($children as $child) {
            $isDirect = in_array($child->id, $directFamilyIds);
            $node = [
                'text' => [
                    'name' => $child->name,
                    'title' => $child->relationship,
                    'city' => $child->city,
                ],
                'data' => [
                    'isDirect' => $isDirect,
                    'phone' => $isDirect ? $child->phone : null,
                    'email' => $isDirect ? $child->email : null,
                ],
                'children' => $this->buildTree($user, $members, $child->id, $directFamilyIds),
            ];
            $tree[] = $node;
        }
        return $tree;
    }

    public function index()
    {
        $user = Auth::user();
        $familyMembers = $user->familyMembers()->get();
        $directFamilyIds = $familyMembers->pluck('id')->toArray();
        $tree = [
            'text' => [
                'name' => $user->name,
                'title' => 'You',
                'city' => $user->city,
            ],
            'data' => [
                'isDirect' => true,
                'phone' => $user->phone,
                'email' => $user->email,
            ],
            'children' => $this->buildTree($user, $familyMembers, null, $directFamilyIds),
        ];

        // Fetch all other users and their family members for community trees
        $otherUsers = User::where('id', '!=', $user->id)->with('familyMembers')->get();
        $allFamilyMembers = FamilyMember::all();
        $otherUserTrees = [];
        foreach ($otherUsers as $otherUser) {
            $otherUserTree = [
                'text' => [
                    'name' => $otherUser->name,
                    'title' => 'Community Member',
                    'city' => $otherUser->city,
                ],
                'data' => [
                    'isDirect' => false,
                ],
                'children' => $this->buildCommunityTreePrivacy($otherUser, $allFamilyMembers, null),
            ];
            $otherUserTrees[] = $otherUserTree;
        }

        return view('dashboard', compact('user', 'familyMembers', 'tree', 'directFamilyIds', 'otherUserTrees'));
    }

    public function communityTree()
    {
        $authUser = Auth::user();
        $allUsers = User::with('familyMembers')->get();
        $allFamilyMembers = FamilyMember::all();

        // Helper: get all descendant IDs for a user
        $getDescendantIds = function($userId) use ($allFamilyMembers) {
            $ids = [];
            $direct = $allFamilyMembers->where('user_id', $userId);
            foreach ($direct as $member) {
                $ids[] = $member->id;
                $ids = array_merge($ids, $this->getDescendants($member->id, $allFamilyMembers));
            }
            return $ids;
        };

        // Build tree for each user
        $communityTree = [];
        foreach ($allUsers as $user) {
            $isAuthUser = $user->id === $authUser->id;
            $directFamilyIds = $user->familyMembers->pluck('id')->toArray();
            $descendantIds = $getDescendantIds($user->id);
            $node = [
                'text' => [
                    'name' => $user->name,
                    'title' => $isAuthUser ? 'You' : 'Community Member',
                    'city' => $user->city,
                ],
                'data' => [
                    'isDirect' => $isAuthUser,
                    'phone' => $isAuthUser ? $user->phone : null,
                    'email' => $isAuthUser ? $user->email : null,
                ],
                'children' => $this->buildCommunityTree($user, $allFamilyMembers, null, $authUser, $directFamilyIds, $descendantIds),
            ];
            $communityTree[] = $node;
        }
        return view('community_tree', ['communityTree' => $communityTree]);
    }

    // Helper to get all descendants of a family member
    private function getDescendants($parentId, $allFamilyMembers)
    {
        $descendants = [];
        $children = $allFamilyMembers->where('parent_id', $parentId);
        foreach ($children as $child) {
            $descendants[] = $child->id;
            $descendants = array_merge($descendants, $this->getDescendants($child->id, $allFamilyMembers));
        }
        return $descendants;
    }

    // Build the community tree with privacy masking
    private function buildCommunityTree($user, $allFamilyMembers, $parentId, $authUser, $directFamilyIds, $descendantIds)
    {
        $children = $allFamilyMembers->where('user_id', $user->id)->where('parent_id', $parentId);
        $tree = [];
        foreach ($children as $child) {
            $isDirect = $user->id === $authUser->id && in_array($child->id, $directFamilyIds);
            $isDescendant = $user->id === $authUser->id && in_array($child->id, $descendantIds);
            $node = [
                'text' => [
                    'name' => $child->name,
                    'title' => $child->relationship,
                    'city' => $child->city,
                ],
                'data' => [
                    'isDirect' => $isDirect,
                    'isDescendant' => $isDescendant,
                    'phone' => $isDirect ? $child->phone : ($isDescendant ? 'Masked' : null),
                    'email' => $isDirect ? $child->email : ($isDescendant ? 'Masked' : null),
                ],
                'children' => $this->buildCommunityTree($user, $allFamilyMembers, $child->id, $authUser, $directFamilyIds, $descendantIds),
            ];
            $tree[] = $node;
        }
        return $tree;
    }

    // Helper for privacy-masked community trees (only name and city)
    private function buildCommunityTreePrivacy($user, $allFamilyMembers, $parentId)
    {
        $children = $allFamilyMembers->where('user_id', $user->id)->where('parent_id', $parentId);
        $tree = [];
        foreach ($children as $child) {
            $node = [
                'text' => [
                    'name' => $child->name,
                    'title' => $child->relationship,
                    'city' => $child->city,
                ],
                'data' => [
                    'isDirect' => false,
                ],
                'children' => $this->buildCommunityTreePrivacy($user, $allFamilyMembers, $child->id),
            ];
            $tree[] = $node;
        }
        return $tree;
    }
}
