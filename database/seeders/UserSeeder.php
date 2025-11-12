<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@globaladvisorsolution.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
    }
}
