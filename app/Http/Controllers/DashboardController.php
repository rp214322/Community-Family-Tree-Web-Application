<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FamilyMember;

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
        return view('dashboard', compact('user', 'familyMembers', 'tree', 'directFamilyIds'));
    }
}
