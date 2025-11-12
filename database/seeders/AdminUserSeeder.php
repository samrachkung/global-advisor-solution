<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@globaladvisorsolution.com',
            'password' => Hash::make('adminglobaladvisorsolution@123'),
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);
    }
}
