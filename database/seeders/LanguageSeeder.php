<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language;

class LanguageSeeder extends Seeder
{
    public function run()
    {
        Language::create([
            'code' => 'en',
            'name' => 'English',
            'is_default' => true,
            'status' => 'active'
        ]);

        Language::create([
            'code' => 'km',
            'name' => 'ខ្មែរ',
            'is_default' => false,
            'status' => 'active'
        ]);
    }
}
