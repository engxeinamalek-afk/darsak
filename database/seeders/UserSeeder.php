<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->instructor()->create([
            'name' => 'Teacher Accountant',
            'email' => 'teacher@example.com',
        ]);

        User::factory()->student()->create([
            'name' => 'Student Accountant',
            'email' => 'student@example.com',
        ]);

        User::factory()->count(10)->instructor()->create();

        User::factory()->count(10)->student()->create();
    }
}
