<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Add Admin User
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'password_hash' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Add Staff User
        User::updateOrCreate(
            ['username' => 'staff'],
            [
                'password_hash' => Hash::make('password'),
                'role' => 'staff',
            ]
        );
    }
}
