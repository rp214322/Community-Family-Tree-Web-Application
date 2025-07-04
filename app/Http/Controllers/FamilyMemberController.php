<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FamilyMember;

class FamilyMemberController extends Controller
{
    public function create()
    {
        $familyMembers = Auth::user()->familyMembers()->get();
        return view('family_members.create', compact('familyMembers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'relationship' => 'required|string|max:255',
            'age' => 'nullable|integer|min:0',
            'city' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'parent_id' => 'nullable|exists:family_members,id',
        ]);

        $user = Auth::user();
        $familyMember = new FamilyMember($request->only(['name', 'relationship', 'age', 'city', 'phone', 'email', 'parent_id']));
        $familyMember->user_id = $user->id;
        $familyMember->save();

        return redirect()->route('dashboard')->with('success', 'Family member added successfully.');
    }

    public function edit(FamilyMember $familyMember)
    {
        $this->authorizeAction($familyMember);
        $familyMembers = Auth::user()->familyMembers()->where('id', '!=', $familyMember->id)->get();
        return view('family_members.edit', compact('familyMember', 'familyMembers'));
    }

    public function update(Request $request, FamilyMember $familyMember)
    {
        $this->authorizeAction($familyMember);
        $request->validate([
            'name' => 'required|string|max:255',
            'relationship' => 'required|string|max:255',
            'age' => 'nullable|integer|min:0',
            'city' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'parent_id' => 'nullable|exists:family_members,id',
        ]);
        $familyMember->update($request->only(['name', 'relationship', 'age', 'city', 'phone', 'email', 'parent_id']));
        return redirect()->route('dashboard')->with('success', 'Family member updated successfully.');
    }

    public function destroy(FamilyMember $familyMember)
    {
        $this->authorizeAction($familyMember);
        $familyMember->delete();
        return redirect()->route('dashboard')->with('success', 'Family member deleted successfully.');
    }

    private function authorizeAction(FamilyMember $familyMember)
    {
        if ($familyMember->user_id !== auth()->id()) {
            abort(403);
        }
    }
}
