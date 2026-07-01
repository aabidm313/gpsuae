<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Fixed admin/test account — always available
        User::create([
            'name'              => 'Admin User',
            'email'             => 'admin@example.com',
            'email_verified_at' => now(),
            'password'          => Hash::make('password'),
        ]);

        // A second fixed user to test participant registration
        User::create([
            'name'              => 'Jane Doe',
            'email'             => 'jane@example.com',
            'email_verified_at' => now(),
            'password'          => Hash::make('password'),
        ]);

        // 8 more random users
        User::factory(8)->create();
    }
}
