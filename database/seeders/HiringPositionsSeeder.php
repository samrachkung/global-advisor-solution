<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobPosition;
use App\Models\JobPositionTranslation;
use App\Models\Language;

class HiringPositionsSeeder extends Seeder
{
    public function run()
    {
        $en = Language::where('code', 'en')->value('id') ?? 1;
        $km = Language::where('code', 'km')->value('id') ?? 2;

        $positions = [
            [
                'slug' => 'sales-officer',
                'department' => 'Sales & Marketing',
                'location' => 'Phnom Penh',
                'employment_type' => 'full-time',
                'salary_range' => '$400 - $700 + Commission',
                'application_deadline' => '2025-12-31',
                'status' => 'open',
                'en' => [
                    'title' => 'Sales Officer',
                    'description' => 'Drive loan product sales, build client relationships, and achieve monthly targets.',
                    'requirements' => "- Bachelor degree in Business or related field\n- 1+ year in sales (bank/MFI preferred)\n- Good communication and negotiation\n- Able to travel and work under pressure",
                    'responsibilities' => "- Promote loan products to new and existing clients\n- Conduct basic assessment and collect documents\n- Maintain pipeline and report activities\n- Coordinate with operations for disbursement",
                    'benefits' => "- Base salary + attractive commission\n- Training and career growth\n- Fuel/phone allowance\n- Friendly, supportive team",
                ],
                'km' => [
                    'title' => 'មន្ត្រីផ្នែកលក់',
                    'description' => 'ជំរុញការលក់ផលិតផលកម្ចី បង្កើតទំនាក់ទំនងអតិថិជន និងសម្រេចគោលដៅប្រចាំខែ',
                    'requirements' => "- បរិញ្ញាបត្រផ្នែកអាជីវកម្ម ឬជាប់ពាក់ព័ន្ធ\n- បទពិសោធន៍លក់ពី ១ ឆ្នាំ (ធនាគារ/មីក្រូ ជា​អទិភាព)\n- មានជំនាញទំនាក់ទំនង និងចរចា\n- អាចដំណើរទស្សនកិច្ច និងធ្វើការក្រោមសំពាធ",
                    'responsibilities' => "- ផ្សព្វផ្សាយផលិតផលកម្ចីទៅអតិថិជនថ្មី និងចាស់\n- ធ្វើការវាយតម្លៃដំបូង និងប្រមូលឯកសារ\n- គ្រប់គ្រងបណ្តាញអតិថិជន និងរាយការណ៍\n- សហការជាមួយប្រតិបត្តិការសម្រាប់ការចេញប្រាក់កម្ចី",
                    'benefits' => "- ប្រាក់ខែ + កម្រைជើងសារ\n- បណ្តុះបណ្តាល និងឱកាសឆ្ពោះទៅមុខ\n- អត្ថប្រយោជន៍ប្រេង/ទូរស័ព្ទ\n- ក្រុមការងាររួសរាយរាក់ទាក់",
                ],
            ],
            [
                'slug' => 'operations-officer',
                'department' => 'Operations',
                'location' => 'Phnom Penh',
                'employment_type' => 'full-time',
                'salary_range' => '$500 - $800',
                'application_deadline' => '2025-12-31',
                'status' => 'open',
                'en' => [
                    'title' => 'Operations Officer',
                    'description' => 'Support end-to-end loan operations, documentation control, and customer experience.',
                    'requirements' => "- Bachelor degree in Finance/Business\n- Detail-oriented and organized\n- Basic knowledge of loan process\n- MS Office proficiency",
                    'responsibilities' => "- Verify customer documents and data entry\n- Coordinate with sales and compliance\n- Schedule and follow up disbursements\n- Maintain proper filing and reports",
                    'benefits' => "- Competitive salary\n- Training and development\n- Annual leave and allowances\n- Dynamic work environment",
                ],
                'km' => [
                    'title' => 'មន្ត្រីប្រតិបត្តិការ',
                    'description' => 'គាំទ្រប្រតិបត្តិការ​កម្ចីពីដើមដល់ចុង ការគ្រប់គ្រងឯកសារ និងបទពិសោធន៍អតិថិជន',
                    'requirements' => "- បរិញ្ញាបត្រផ្នែកហិរញ្ញវត្ថុ/អាជីវកម្ម\n- ស្មារតីពិស្តារ និងមានរបៀបរៀបចំល្អ\n- មានចំណេះដឹងមូលដ្ឋានអំពីដំណើរការកម្ចី\n- ចេះប្រើ MS Office",
                    'responsibilities' => "- ពិនិត្យឯកសារអតិថិជន និងវាយបញ្ចូលទិន្នន័យ\n- សម្របសម្រួលជាមួយផ្នែកលក់ និងធានាគុណភាព\n- កំណត់ពេល និងតាមដានការចេញប្រាក់កម្ចី\n- រក្សាទុកឯកសារយោង និងរាយការណ៍",
                    'benefits' => "- ប្រាក់ខែប្រកបដោយការប្រកួតប្រជែង\n- បណ្តុះបណ្តាល និងអភិវឌ្ឍន៍\n- ឈប់សម្រាកប្រចាំឆ្នាំ និងអត្ថប្រយោជន៍ផ្សេងៗ\n- បរិយាកាសការងារសើចសប្បាយ",
                ],
            ],
        ];

        foreach ($positions as $p) {
            $job = JobPosition::create([
                'slug' => $p['slug'],
                'department' => $p['department'],
                'location' => $p['location'],
                'employment_type' => $p['employment_type'],
                'salary_range' => $p['salary_range'],
                'application_deadline' => $p['application_deadline'],
                'status' => $p['status'],
            ]);

            JobPositionTranslation::insert([
                [
                    'job_position_id' => $job->id,
                    'language_id' => $en,
                    'title' => $p['en']['title'],
                    'description' => $p['en']['description'],
                    'requirements' => $p['en']['requirements'],
                    'responsibilities' => $p['en']['responsibilities'],
                    'benefits' => $p['en']['benefits'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'job_position_id' => $job->id,
                    'language_id' => $km,
                    'title' => $p['km']['title'],
                    'description' => $p['km']['description'],
                    'requirements' => $p['km']['requirements'],
                    'responsibilities' => $p['km']['responsibilities'],
                    'benefits' => $p['km']['benefits'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }

        $this->command->info('Sales & Operations positions seeded!');
    }
}
