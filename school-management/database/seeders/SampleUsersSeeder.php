<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SampleUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a sample teacher
        \App\Models\User::firstOrCreate(
            ['email' => 'teacher@school.com'],
            [
                'name' => 'John Teacher',
                'password' => bcrypt('password'),
                'role_id' => 2, // Teacher role
                'status' => 'active',
            ]
        );

        // Create a sample student
        \App\Models\User::firstOrCreate(
            ['email' => 'student@school.com'],
            [
                'name' => 'Jane Student',
                'password' => bcrypt('password'),
                'role_id' => 3, // Student role
                'status' => 'active',
            ]
        );

        // Create a sample parent
        \App\Models\User::firstOrCreate(
            ['email' => 'parent@school.com'],
            [
                'name' => 'Bob Parent',
                'password' => bcrypt('password'),
                'role_id' => 4, // Parent role
                'status' => 'active',
            ]
        );
    }
}
