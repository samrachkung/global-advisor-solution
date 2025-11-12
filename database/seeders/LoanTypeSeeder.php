<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LoanType;
use App\Models\LoanTypeTranslation;
use App\Models\LoanCondition;
use App\Models\Language;

class LoanTypeSeeder extends Seeder
{
    public function run()
    {
        $enLang = Language::where('code', 'en')->first();
        $kmLang = Language::where('code', 'km')->first();

        $loanTypes = [
            [
                'slug' => 'agriculture-loan',
                'icon' => 'fas fa-seedling',
                'order' => 1,
                'translations' => [
                    'en' => [
                        'title' => 'Agriculture Loan',
                        'description' => 'Financial support for agricultural activities, farming operations, crop cultivation, and livestock management.',
                        'conditions' => "Currency: Riel or US Dollar\nLoan Amount: Up to $50,000\nDuration: Up to 8 years (96 months)\nAge Requirement: 18-65 years\nDebt Ratio: Not exceeding 70%",
                        'collateral_info' => 'Soft title or hard title, Vehicle registration card, Other negotiable assets, Guarantor group'
                    ],
                    'km' => [
                        'title' => 'ឥណទានកសិកម្ម',
                        'description' => 'ការគាំទ្រហិរញ្ញវត្ថុសម្រាប់សកម្មភាពកសិកម្ម ការដាំដុះ និងការចិញ្ចឹមសត្វ។',
                        'conditions' => "ប្រភេទរូបិយប័ណ្ណ៖ ប្រាក់រៀល ឬដុល្លារអាមេរិក\nទំហំឥណទាន៖ រហូតដល់ ៥០,០០០ ដុល្លារអាមេរិក\nរយៈពេលខ្ចីប្រាក់៖ រហូតដល់ ៨ឆ្នាំ ឬ ៩៦ខែ\nអាយុ៖ ១៨ ដល់ ៦៥ ឆ្នាំ\nសមត្ថភាពសង៖ មិនលើសពី ៧០%",
                        'collateral_info' => 'ប្លង់ទន់ ឬ ប្លង់រឹង, កាតគ្រីម៉ូតូ/ឡាន, ទ្រព្យបញ្ចាំផ្សេងទៀត, ក្រុមធានា'
                    ]
                ],
                'condition' => [
                    'currency_type' => 'Both',
                    'min_amount' => 250,
                    'max_amount' => 50000,
                    'max_duration_months' => 96,
                    'min_age' => 18,
                    'max_age' => 65,
                    'max_debt_ratio' => 70.00
                ]
            ],
            [
                'slug' => 'business-loan',
                'icon' => 'fas fa-briefcase',
                'order' => 2,
                'translations' => [
                    'en' => [
                        'title' => 'Business Loan',
                        'description' => 'Loans for commercial activities, trading operations, import-export business, retail stores, and manufacturing enterprises.',
                        'conditions' => "Currency: Riel or US Dollar\nLoan Amount: Up to $50,000\nDuration: Up to 8 years (96 months)\nAge Requirement: 18-65 years\nNot harmful to society and environment\nGood credit history",
                        'collateral_info' => 'Business assets, Property titles, Vehicle registration, Equipment, Guarantor group'
                    ],
                    'km' => [
                        'title' => 'ឥណទានអាជីវកម្ម',
                        'description' => 'ឥណទានអាជីវកម្ម គឺសំដៅលើប្រភេទឥណទានទាំងឡាយណាដែលត្រូវបានយកទៅប្រើប្រាស់ក្នុងសកម្មភាពដូចជា៖ សកម្មភាពអាជីវកម្ម ឬពាណិជ្ជកម្ម ឬជំនួញ មានន័យថាអតិថិជនបានស្នើសុំឥណទានដើម្បីប្រើប្រាស់ក្នុងគោលបំណងធ្វើអាជីវកម្ម ឬពាណិជ្ជកម្ម ឬជំនួញដែលអាចរកចំណូលបានមកពីការនាំចេញ នាំចូល ទិញចូល លក់ចេញ បើកហាងលក់ដូរទំនិញដើម្បីបានប្រាក់ចំណេញឬការទិញសម្ភារៈផ្សេងៗសម្រាប់ផ្គត់ផ្គង់លើអាជីវកម្មបែបជំនួញរបស់ខ្លួនដូចជា៖ ការទិញលក់គ្រឿងទេស គ្រឿងសំណង់ គ្រឿងឧបភោគ បន្លែ ត្រីសាច់ នំចំណី កសិផល ការទិញលក់គ្រឿងអលង្ការ ប្តូរប្រាក់ ការទិញលក់តូប ទីតាំងសម្រាប់លក់ដូរទំនិញ ការទិញលក់គ្រឿងម៉ាស៊ីន គ្រឿងចក្រ គ្រឿងអេឡិចត្រូនិច ការទិញលក់ឡាន ទិញលក់ម៉ូតូ ទូរស័ព្ទ កុំព្យូទ័រ ការទិញលក់សត្វពាហនៈ ការម៉ៅចម្ការសម្រាប់យកកសិផលមកលក់ដូរ។',
                        'conditions' => "ប្រភេទរូបិយប័ណ្ណ៖ ប្រាក់រៀល ឬដុល្លារអាមេរិក\nទំហំឥណទាន៖ រហូតដល់ ៥០,០០០ ដុល្លារអាមេរិក\nរយៈពេលខ្ចីប្រាក់៖ រហូតដល់ ៨ឆ្នាំ ឬ ៩៦ខែ\nអ្នកខ្ចីត្រូវមានអាយុចាប់ពី ១៨ ដល់ ៦៥ ឆ្នាំ\nមិនមែនជាអាជីវកម្មដែលបង្កគ្រោះថ្នាក់ដល់សង្គម និងបរិស្ថាន\nមានប្រវត្តិឥណទានល្អ",
                        'collateral_info' => 'ប្លង់ទន់ ឬ ប្លង់រឹង, កាតគ្រីម៉ូតូ/ឡាន, ទ្រព្យបញ្ចាំផ្សេងទៀត (តាមការចរចា), ក្រុមធានា'
                    ]
                ],
                'condition' => [
                    'currency_type' => 'Both',
                    'min_amount' => 250,
                    'max_amount' => 50000,
                    'max_duration_months' => 96,
                    'min_age' => 18,
                    'max_age' => 65,
                    'max_debt_ratio' => 70.00
                ]
            ],
            [
                'slug' => 'construction-loan',
                'icon' => 'fas fa-building',
                'order' => 3,
                'translations' => [
                    'en' => [
                        'title' => 'Construction Loan',
                        'description' => 'Financing for building construction, home renovation, property development, and infrastructure projects.',
                        'conditions' => "Currency: Riel or US Dollar\nLoan Amount: Up to $50,000\nDuration: Up to 8 years\nAge: 18-65 years\nConstruction permits required\nProperty documentation",
                        'collateral_info' => 'Land title, Construction plans, Property under construction, Other assets'
                    ],
                    'km' => [
                        'title' => 'ឥណទានសំណង់',
                        'description' => 'ហិរញ្ញប្បទានសម្រាប់សាងសង់អគារ ជួសជុលផ្ទះ អភិវឌ្ឍន៍អចលនទ្រព្យ និងគម្រោងហេដ្ឋារចនាសម្ព័ន្ធ។',
                        'conditions' => "ប្រភេទរូបិយប័ណ្ណ៖ ប្រាក់រៀល ឬដុល្លារអាមេរិក\nទំហំឥណទាន៖ រហូតដល់ ៥០,០០០ ដុល្លារ\nរយៈពេល៖ ៨ឆ្នាំ\nអាយុ៖ ១៨-៦៥ ឆ្នាំ\nត្រូវមានលិខិតអនុញ្ញាតសាងសង់\nឯកសារទ្រព្យសម្បត្តិ",
                        'collateral_info' => 'ប្លង់ដី, គម្រោងសំណង់, អចលនទ្រព្យកំពុងសាងសង់, ទ្រព្យបញ្ចាំផ្សេង'
                    ]
                ],
                'condition' => [
                    'currency_type' => 'Both',
                    'min_amount' => 500,
                    'max_amount' => 50000,
                    'max_duration_months' => 96,
                    'min_age' => 18,
                    'max_age' => 65,
                    'max_debt_ratio' => 70.00
                ]
            ],
            [
                'slug' => 'vehicle-loan',
                'icon' => 'fas fa-car',
                'order' => 4,
                'translations' => [
                    'en' => [
                        'title' => 'Vehicle Loan',
                        'description' => 'Auto loans for purchasing cars, motorcycles, trucks, and commercial vehicles with flexible repayment terms.',
                        'conditions' => "Currency: US Dollar or Riel\nAmount: Up to $50,000\nTerm: Up to 5 years\nDown payment: 10-30%\nAge: 18-65 years",
                        'collateral_info' => 'Vehicle registration card, Vehicle insurance, Guarantor (if required)'
                    ],
                    'km' => [
                        'title' => 'ឥណទានយានជំនិះ',
                        'description' => 'ឥណទានរថយន្តសម្រាប់ការទិញរថយន្ត ម៉ូតូ ឡានដឹកទំនិញ និងយានជំនិះពាណិជ្ជកម្ម ជាមួយនឹងលក្ខខណ្ឌសង់មានភាពបត់បែន។',
                        'conditions' => "រូបិយប័ណ្ណ៖ ដុល្លារ ឬរៀល\nទំហំ៖ ដល់ ៥០,០០០ដុល្លារ\nរយៈពេល៖ ៥ឆ្នាំ\nប្រាក់កក់៖ ១០-៣០%\nអាយុ៖ ១៨-៦៥ឆ្នាំ",
                        'collateral_info' => 'កាតគ្រីយានជំនិះ, ធានារ៉ាប់រងយានជំនិះ, អ្នកធានា (បើចាំបាច់)'
                    ]
                ],
                'condition' => [
                    'currency_type' => 'Both',
                    'min_amount' => 1000,
                    'max_amount' => 50000,
                    'max_duration_months' => 60,
                    'min_age' => 18,
                    'max_age' => 65,
                    'max_debt_ratio' => 70.00
                ]
            ],
            [
                'slug' => 'realestate-mortgage-loan',
                'icon' => 'fas fa-home',
                'order' => 5,
                'translations' => [
                    'en' => [
                        'title' => 'Real Estate Mortgage Loan',
                        'description' => 'Home mortgage loans for purchasing residential or commercial properties with competitive interest rates.',
                        'conditions' => "Currency: US Dollar\nAmount: Up to $200,000\nTerm: Up to 20 years\nDown payment: 20-30%\nProperty appraisal required",
                        'collateral_info' => 'Property hard title, Land ownership certificate, Property valuation report'
                    ],
                    'km' => [
                        'title' => 'ឥណទានបញ្ចាំអចលនទ្រព្យ',
                        'description' => 'ឥណទានបញ្ចាំផ្ទះសម្រាប់ទិញអចលនទ្រព្យលំនៅឋាន ឬពាណិជ្ជកម្ម ជាមួយនឹងអត្រាការប្រាក់ប្រកួតប្រជែង។',
                        'conditions' => "រូបិយប័ណ្ណ៖ ដុល្លារ\nទំហំ៖ ដល់ ២០០,០០០ដុល្លារ\nរយៈពេល៖ ២០ឆ្នាំ\nប្រាក់កក់៖ ២០-៣០%\nត្រូវការវាយតម្លៃអចលនទ្រព្យ",
                        'collateral_info' => 'ប្លង់រឹង, លិខិតកម្មសិទ្ធិដី, របាយការណ៍វាយតម្លៃអចលនទ្រព្យ'
                    ]
                ],
                'condition' => [
                    'currency_type' => 'USD',
                    'min_amount' => 5000,
                    'max_amount' => 200000,
                    'max_duration_months' => 240,
                    'min_age' => 21,
                    'max_age' => 65,
                    'max_debt_ratio' => 60.00
                ]
            ],
            [
                'slug' => 'education-loan',
                'icon' => 'fas fa-graduation-cap',
                'order' => 6,
                'translations' => [
                    'en' => [
                        'title' => 'Education Loan',
                        'description' => 'Student loans for tuition fees, educational expenses, overseas studies, and vocational training programs.',
                        'conditions' => "Currency: US Dollar or Riel\nAmount: Up to $30,000\nTerm: Up to 10 years\nAge: 18-60 years\nAdmission letter required",
                        'collateral_info' => 'Guarantor (parent/guardian), Property title, Salary assignment'
                    ],
                    'km' => [
                        'title' => 'ឥណទានអប់រំ',
                        'description' => 'ឥណទានសិស្សសម្រាប់ថ្លៃសិក្សា ចំណាយអប់រំ ការសិក្សានៅបរទេស និងកម្មវិធីបណ្តុះបណ្តាលវិជ្ជាជីវៈ។',
                        'conditions' => "រូបិយប័ណ្ណ៖ ដុល្លារ ឬរៀល\nទំហំ៖ ដល់ ៣០,០០០ដុល្លារ\nរយៈពេល៖ ១០ឆ្នាំ\nអាយុ៖ ១៨-៦០ឆ្នាំ\nត្រូវការលិខិតចូលរៀន",
                        'collateral_info' => 'អ្នកធានា (ឪពុកម្តាយ/អាណាព្យាបាល), ប្លង់ទ្រព្យសម្បត្តិ, ចាត់ចែងប្រាក់ខែ'
                    ]
                ],
                'condition' => [
                    'currency_type' => 'Both',
                    'min_amount' => 500,
                    'max_amount' => 30000,
                    'max_duration_months' => 120,
                    'min_age' => 18,
                    'max_age' => 60,
                    'max_debt_ratio' => 70.00
                ]
            ],
            [
                'slug' => 'fast-loan',
                'icon' => 'fas fa-bolt',
                'order' => 7,
                'translations' => [
                    'en' => [
                        'title' => 'Fast Loan',
                        'description' => 'Quick approval loans for urgent financial needs with minimal documentation and rapid disbursement.',
                        'conditions' => "Currency: US Dollar or Riel\nAmount: Up to $5,000\nTerm: Up to 2 years\nAge: 21-65 years\nQuick approval: 24-48 hours",
                        'collateral_info' => 'ID card, Proof of income, Guarantor'
                    ],
                    'km' => [
                        'title' => 'ឥណទានរហ័ស',
                        'description' => 'ឥណទានអនុម័តរហ័សសម្រាប់តម្រូវការហិរញ្ញវត្ថុបន្ទាន់ ជាមួយឯកសារតិចតួច និងការចេញប្រាក់លឿន។',
                        'conditions' => "រូបិយប័ណ្ណ៖ ដុល្លារ ឬរៀល\nទំហំ៖ ដល់ ៥,០០០ដុល្លារ\nរយៈពេល៖ ២ឆ្នាំ\nអាយុ៖ ២១-៦៥ឆ្នាំ\nអនុម័តលឿន៖ ២៤-៤៨ម៉ោង",
                        'collateral_info' => 'អត្តសញ្ញាណប័ណ្ណ, បញ្ជាក់ប្រាក់ចំណូល, អ្នកធានា'
                    ]
                ],
                'condition' => [
                    'currency_type' => 'Both',
                    'min_amount' => 100,
                    'max_amount' => 5000,
                    'max_duration_months' => 24,
                    'min_age' => 21,
                    'max_age' => 65,
                    'max_debt_ratio' => 70.00
                ]
            ],
            [
                'slug' => 'personal-loan',
                'icon' => 'fas fa-user',
                'order' => 8,
                'translations' => [
                    'en' => [
                        'title' => 'Personal Loan',
                        'description' => 'Unsecured personal loans for various purposes including weddings, medical expenses, travel, and debt consolidation.',
                        'conditions' => "Currency: US Dollar or Riel\nAmount: Up to $20,000\nTerm: Up to 5 years\nAge: 21-65 years\nRegular income required",
                        'collateral_info' => 'Salary certificate, Bank statements, Guarantor, ID documents'
                    ],
                    'km' => [
                        'title' => 'ឥណទានផ្ទាល់ខ្លួន',
                        'description' => 'ឥណទានផ្ទាល់ខ្លួនគ្មានការធានាសម្រាប់គោលបំណងផ្សេងៗ រួមទាំងពិធីមង្គលការ ចំណាយវេជ្ជសាស្ត្រ ការធ្វើដំណើរ និងការបង្រួបបង្រួមបំណុល។',
                        'conditions' => "រូបិយប័ណ្ណ៖ ដុល្លារ ឬរៀល\nទំហំ៖ ដល់ ២០,០០០ដុល្លារ\nរយៈពេល៖ ៥ឆ្នាំ\nអាយុ៖ ២១-៦៥ឆ្នាំ\nត្រូវការប្រាក់ចំណូលទៀងទាត់",
                        'collateral_info' => 'សំបុត្រប្រាក់ខែ, របាយការណ៍ធនាគារ, អ្នកធានា, ឯកសារអត្តសញ្ញាណ'
                    ]
                ],
                'condition' => [
                    'currency_type' => 'Both',
                    'min_amount' => 500,
                    'max_amount' => 20000,
                    'max_duration_months' => 60,
                    'min_age' => 21,
                    'max_age' => 65,
                    'max_debt_ratio' => 70.00
                ]
            ]
        ];

        foreach ($loanTypes as $data) {
            $loanType = LoanType::create([
                'slug' => $data['slug'],
                'icon' => $data['icon'],
                'order' => $data['order'],
                'status' => 'active'
            ]);

            // Create translations
            foreach ($data['translations'] as $lang => $trans) {
                $language = $lang == 'en' ? $enLang : $kmLang;

                LoanTypeTranslation::create([
                    'loan_type_id' => $loanType->id,
                    'language_id' => $language->id,
                    'title' => $trans['title'],
                    'description' => $trans['description'],
                    'conditions' => $trans['conditions'],
                    'collateral_info' => $trans['collateral_info'],
                ]);
            }

            // Create loan condition
            LoanCondition::create(array_merge(
                ['loan_type_id' => $loanType->id],
                $data['condition']
            ));
        }
    }
}
