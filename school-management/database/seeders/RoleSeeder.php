<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'description' => 'Administrator with full system access',
            ],
            [
                'name' => 'Teacher',
                'slug' => 'teacher',
                'description' => 'Teacher who can manage classes and students',
            ],
            [
                'name' => 'Student',
                'slug' => 'student',
                'description' => 'Student enrolled in the school',
            ],
            [
                'name' => 'Parent',
                'slug' => 'parent',
                'description' => 'Parent or guardian of a student',
            ],
        ];

        foreach ($roles as $role) {
            \App\Models\Role::create($role);
        }
    }
}
