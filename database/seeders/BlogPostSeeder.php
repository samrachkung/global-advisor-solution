<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlogPost;
use App\Models\BlogPostTranslation;
use App\Models\Language;
use App\Models\User;

class BlogPostSeeder extends Seeder
{
    public function run()
    {
        $admin = User::where('is_admin', true)->first();

        if (!$admin) {
            $this->command->error('No admin user found.');
            return;
        }

        $posts = [
            [
                'category_id' => 1,
                'slug' => 'top-10-financial-tips-2025',
                'status' => 'published',
                'published_at' => '2025-01-15 10:00:00',
                'en' => [
                    'title' => 'Top 10 Financial Tips for 2025',
                    'excerpt' => 'Learn essential financial management tips to secure your financial future in 2025.',
                    'content' => '<h2>Introduction</h2><p>Managing your finances effectively is crucial for long-term success.</p>',
                ],
                'km' => [
                    'title' => 'គន្លឹះហិរញ្ញវត្ថុ ១០ យ៉ាងសំខាន់សម្រាប់ឆ្នាំ ២០២៥',
                    'excerpt' => 'ស្វែងយល់អំពីគន្លឹះគ្រប់គ្រងហិរញ្ញវត្ថុដ៏សំខាន់។',
                    'content' => '<h2>ផ្នែកណែនាំ</h2><p>ការគ្រប់គ្រងហិរញ្ញវត្ថុប្រកបដោយប្រសិទ្ធភាព។</p>',
                ],
            ],
            [
                'category_id' => 2,
                'slug' => 'complete-guide-agriculture-loans',
                'status' => 'published',
                'published_at' => '2025-02-01 14:30:00',
                'en' => [
                    'title' => 'Complete Guide to Agriculture Loans',
                    'excerpt' => 'Everything you need to know about agriculture loans.',
                    'content' => '<h2>Agriculture Financing</h2><p>Loans for farmers.</p>',
                ],
                'km' => [
                    'title' => 'មគ្គុទ្ទេសក៍កម្ចីកសិកម្ម',
                    'excerpt' => 'អ្វីគ្រប់យ៉ាងអំពីកម្ចីកសិកម្ម។',
                    'content' => '<h2>ហិរញ្ញប្បទានកសិកម្ម</h2><p>កម្ចីសម្រាប់កសិករ។</p>',
                ],
            ],
        ];

        $enLang = Language::where('code', 'en')->first();
        $kmLang = Language::where('code', 'km')->first();

        foreach ($posts as $postData) {
            $post = BlogPost::create([
                'category_id' => $postData['category_id'],
                'author_id' => $admin->id,
                'slug' => $postData['slug'],
                'status' => $postData['status'],
                'views_count' => 0,
                'published_at' => $postData['published_at'],
            ]);

            BlogPostTranslation::create([
                'post_id' => $post->id,  // Correct column name
                'language_id' => $enLang->id,
                'title' => $postData['en']['title'],
                'excerpt' => $postData['en']['excerpt'],
                'content' => $postData['en']['content'],
            ]);

            BlogPostTranslation::create([
                'post_id' => $post->id,  // Correct column name
                'language_id' => $kmLang->id,
                'title' => $postData['km']['title'],
                'excerpt' => $postData['km']['excerpt'],
                'content' => $postData['km']['content'],
            ]);
        }

        $this->command->info('Blog posts seeded successfully!');
    }
}
