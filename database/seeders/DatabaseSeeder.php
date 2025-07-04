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

        // User 2: John Smith
        $user2 = User::create([
            'name' => 'John Smith',
            'email' => 'john@example.com',
            'phone' => '2233445566',
            'city' => 'Springfield',
            'password' => Hash::make('password'),
        ]);
        $spouse2 = FamilyMember::create([
            'user_id' => $user2->id,
            'parent_id' => null,
            'name' => 'Jane Smith',
            'relationship' => 'Spouse',
            'age' => 34,
            'city' => 'Springfield',
            'phone' => '6655443322',
            'email' => 'jane@example.com',
        ]);
        $child1_2 = FamilyMember::create([
            'user_id' => $user2->id,
            'parent_id' => null,
            'name' => 'Kevin Smith',
            'relationship' => 'Child',
            'age' => 12,
            'city' => 'Springfield',
            'phone' => null,
            'email' => null,
        ]);
        $child2_2 = FamilyMember::create([
            'user_id' => $user2->id,
            'parent_id' => null,
            'name' => 'Lily Smith',
            'relationship' => 'Child',
            'age' => 9,
            'city' => 'Springfield',
            'phone' => null,
            'email' => null,
        ]);
        $sibling2 = FamilyMember::create([
            'user_id' => $user2->id,
            'parent_id' => null,
            'name' => 'Mike Smith',
            'relationship' => 'Sibling',
            'age' => 30,
            'city' => 'Springfield',
            'phone' => null,
            'email' => null,
        ]);
        $grandchild1_2 = FamilyMember::create([
            'user_id' => $user2->id,
            'parent_id' => $child1_2->id,
            'name' => 'Nina Smith',
            'relationship' => 'Grandchild',
            'age' => 3,
            'city' => 'Springfield',
            'phone' => null,
            'email' => null,
        ]);
        $grandchild2_2 = FamilyMember::create([
            'user_id' => $user2->id,
            'parent_id' => $child1_2->id,
            'name' => 'Oscar Smith',
            'relationship' => 'Grandchild',
            'age' => 1,
            'city' => 'Springfield',
            'phone' => null,
            'email' => null,
        ]);

        // User 3: Maria Garcia
        $user3 = User::create([
            'name' => 'Maria Garcia',
            'email' => 'maria@example.com',
            'phone' => '3344556677',
            'city' => 'Riverdale',
            'password' => Hash::make('password'),
        ]);
        $spouse3 = FamilyMember::create([
            'user_id' => $user3->id,
            'parent_id' => null,
            'name' => 'Carlos Garcia',
            'relationship' => 'Spouse',
            'age' => 36,
            'city' => 'Riverdale',
            'phone' => '7766554433',
            'email' => 'carlos@example.com',
        ]);
        $child1_3 = FamilyMember::create([
            'user_id' => $user3->id,
            'parent_id' => null,
            'name' => 'Sofia Garcia',
            'relationship' => 'Child',
            'age' => 11,
            'city' => 'Riverdale',
            'phone' => null,
            'email' => null,
        ]);
        $child2_3 = FamilyMember::create([
            'user_id' => $user3->id,
            'parent_id' => null,
            'name' => 'Tomas Garcia',
            'relationship' => 'Child',
            'age' => 7,
            'city' => 'Riverdale',
            'phone' => null,
            'email' => null,
        ]);
        $sibling3 = FamilyMember::create([
            'user_id' => $user3->id,
            'parent_id' => null,
            'name' => 'Lucia Garcia',
            'relationship' => 'Sibling',
            'age' => 33,
            'city' => 'Riverdale',
            'phone' => null,
            'email' => null,
        ]);
        $grandchild1_3 = FamilyMember::create([
            'user_id' => $user3->id,
            'parent_id' => $child1_3->id,
            'name' => 'Vera Garcia',
            'relationship' => 'Grandchild',
            'age' => 4,
            'city' => 'Riverdale',
            'phone' => null,
            'email' => null,
        ]);
        $grandchild2_3 = FamilyMember::create([
            'user_id' => $user3->id,
            'parent_id' => $child1_3->id,
            'name' => 'Waldo Garcia',
            'relationship' => 'Grandchild',
            'age' => 2,
            'city' => 'Riverdale',
            'phone' => null,
            'email' => null,
        ]);
    }
}
