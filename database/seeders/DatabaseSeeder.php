<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            LanguageSeeder::class,
            UserSeeder::class,
            LoanTypeSeeder::class,
            PageSeeder::class,
        ]);
    }
}
