<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@travel.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('123456789'),
                'role' => 'admin',
            ]
        );
    }
}