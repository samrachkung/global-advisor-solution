<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'superadmin@globaladvisorsolution.com'],
            ['name' => 'Super Admin', 'role' => 'superadmin', 'is_admin' => true, 'password' => Hash::make(env('SEED_PWD_SUPERADMIN', 'Super@12345')), 'email_verified_at' => now()]
        );
        User::updateOrCreate(
            ['email' => 'admin@globaladvisorsolution.com'],
            ['name' => 'Admin', 'role' => 'admin', 'is_admin' => true, 'password' => Hash::make(env('SEED_PWD_ADMIN', 'Admin@12345')), 'email_verified_at' => now()]
        );
        User::updateOrCreate(
            ['email' => 'sale@globaladvisorsolution.com'],
            ['name' => 'Sale User', 'role' => 'sale', 'is_admin' => false, 'password' => Hash::make(env('SEED_PWD_SALE', 'Sale@12345')), 'email_verified_at' => now()]
        );
        User::updateOrCreate(
            ['email' => 'marketing@globaladvisorsolution.com'],
            ['name' => 'Marketing User', 'role' => 'marketing', 'is_admin' => false, 'password' => Hash::make(env('SEED_PWD_MARKETING', 'Marketing@12345')), 'email_verified_at' => now()]
        );

    }
}
