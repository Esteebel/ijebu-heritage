<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin user already exists
        if (!User::where('email', 'admin@example.com')->exists()) {
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'admin'
            ]);
        }

        // Check if editor user already exists
        if (!User::where('email', 'editor@example.com')->exists()) {
            User::create([
                'name' => 'Editor User',
                'email' => 'editor@example.com',
                'password' => Hash::make('password'),
                'role' => 'editor'
            ]);
        }
    }
}
