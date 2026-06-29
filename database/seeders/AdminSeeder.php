<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'name' => 'Admin User',
                'email' => 'admin@hospitally.com',
                'password' => Hash::make('admin123'),
                'phone' => '0321-1234567',
                'cnic' => '42101-1234567-1',
                'address' => 'Block A, Gulberg III, Lahore, Punjab, Pakistan',
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Muhammad Bilal',
                'email' => 'bilal.admin@hospitally.com',
                'password' => Hash::make('admin123'),
                'phone' => '0322-9876543',
                'cnic' => '42101-9876543-2',
                'address' => 'DHA Phase 5, Karachi, Sindh, Pakistan',
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
        ];

        foreach ($admins as $admin) {
            User::create($admin);
        }
    }
}