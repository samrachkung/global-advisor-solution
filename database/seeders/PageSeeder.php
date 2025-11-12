<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Models\PageTranslation;
use App\Models\Language;

class PageSeeder extends Seeder
{
    public function run()
    {
        $enLang = Language::where('code', 'en')->first();
        $kmLang = Language::where('code', 'km')->first();

        $pages = [
            [
                'slug' => 'about-us',
                'template' => 'about',
                'translations' => [
                    'en' => [
                        'title' => 'About Us',
                        'content' => 'About Us page content...',
                    ],
                    'km' => [
                        'title' => 'អំពីយើង',
                        'content' => 'ខ្លឹមសារទំព័រអំពីយើង...',
                    ]
                ]
            ],
        ];

        foreach ($pages as $pageData) {
            $page = Page::create([
                'slug' => $pageData['slug'],
                'template' => $pageData['template'],
                'status' => 'active'
            ]);

            foreach ($pageData['translations'] as $lang => $trans) {
                $language = $lang == 'en' ? $enLang : $kmLang;

                PageTranslation::create([
                    'page_id' => $page->id,
                    'language_id' => $language->id,
                    'title' => $trans['title'],
                    'content' => $trans['content'],
                ]);
            }
        }
    }
}
