<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
        ]);

        // Create a default admin user
        \App\Models\User::create([
            'name' => 'Admin User',
            'email' => 'admin@school.com',
            'password' => bcrypt('password'),
            'role_id' => 1, // Admin role
            'status' => 'active',
        ]);

        // Create a sample teacher
        \App\Models\User::create([
            'name' => 'John Teacher',
            'email' => 'teacher@school.com',
            'password' => bcrypt('password'),
            'role_id' => 2, // Teacher role
            'status' => 'active',
        ]);

        // Create a sample student
        \App\Models\User::create([
            'name' => 'Jane Student',
            'email' => 'student@school.com',
            'password' => bcrypt('password'),
            'role_id' => 3, // Student role
            'status' => 'active',
        ]);

        // Create a sample parent
        \App\Models\User::create([
            'name' => 'Bob Parent',
            'email' => 'parent@school.com',
            'password' => bcrypt('password'),
            'role_id' => 4, // Parent role
            'status' => 'active',
        ]);
    }
}
