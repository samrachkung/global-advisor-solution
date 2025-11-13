<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
             AdminUserSeeder::class,
            LanguageSeeder::class,
            UserSeeder::class,
            LoanTypeSeeder::class,
            PageSeeder::class,
        ]);
    }
}
