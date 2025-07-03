<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\FamilyMember;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a sample user
        $user = User::create([
            'name' => 'Alice Example',
            'email' => 'alice@example.com',
            'phone' => '1234567890',
            'city' => 'Wonderland',
            'password' => Hash::make('password'),
        ]);

        // Add direct family members (children, spouse, sibling)
        $spouse = FamilyMember::create([
            'user_id' => $user->id,
            'parent_id' => null,
            'name' => 'Bob Example',
            'relationship' => 'Spouse',
            'age' => 35,
            'city' => 'Wonderland',
            'phone' => '0987654321',
            'email' => 'bob@example.com',
        ]);
        $child1 = FamilyMember::create([
            'user_id' => $user->id,
            'parent_id' => null,
            'name' => 'Charlie Example',
            'relationship' => 'Child',
            'age' => 10,
            'city' => 'Wonderland',
            'phone' => null,
            'email' => null,
        ]);
        $child2 = FamilyMember::create([
            'user_id' => $user->id,
            'parent_id' => null,
            'name' => 'Daisy Example',
            'relationship' => 'Child',
            'age' => 8,
            'city' => 'Wonderland',
            'phone' => null,
            'email' => null,
        ]);
        $sibling = FamilyMember::create([
            'user_id' => $user->id,
            'parent_id' => null,
            'name' => 'Eve Example',
            'relationship' => 'Sibling',
            'age' => 32,
            'city' => 'Wonderland',
            'phone' => null,
            'email' => null,
        ]);

        // Add grandchildren (children of Charlie)
        $grandchild1 = FamilyMember::create([
            'user_id' => $user->id,
            'parent_id' => $child1->id,
            'name' => 'Fay Example',
            'relationship' => 'Grandchild',
            'age' => 2,
            'city' => 'Wonderland',
            'phone' => null,
            'email' => null,
        ]);
        $grandchild2 = FamilyMember::create([
            'user_id' => $user->id,
            'parent_id' => $child1->id,
            'name' => 'Gus Example',
            'relationship' => 'Grandchild',
            'age' => 1,
            'city' => 'Wonderland',
            'phone' => null,
            'email' => null,
        ]);
    }
}
