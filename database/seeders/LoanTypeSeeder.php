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
        // Ensure languages exist beforehand (en, km) [best practice]
        $en = Language::where('code', 'en')->firstOrFail(); // throws if missing [web:6]
        $km = Language::where('code', 'km')->firstOrFail(); // throws if missing [web:6]

        $items = [
            // 1) Agriculture Loan
            [
                'slug' => 'agriculture-loan',
                'icon' => 'fas fa-seedling',
                'order' => 5,
                'translations' => [
                    'en' => [
                        'title' => 'Agriculture Loan',
                        'description' => 'Power your farm cycle with financing for seeds, fertilizer, irrigation, livestock, equipment, and seasonal cash flow smoothing tailored to harvest timelines.', // enriched [web:6][web:3]
                        'conditions' =>
                            "Currency: Riel or US Dollar\n" .
                            "Loan Amount: Up to $50,000 (example: inputs, pumps, greenhouse, feed)\n" .
                            "Duration: Up to 8 years (96 months), with grace options aligned to crop seasons\n" .
                            "Eligibility: Farmers, cooperatives, agri‑SMEs with simple income proof\n" .
                            "Debt Ratio: ≤ 70% and stable repayment history\n" .
                            "Documents: National ID, farm proof (photos/leases), simple cashbook or buyer receipts",
                        'collateral_info' => 'Soft/hard title, vehicle registration, agri equipment, or guarantor/group acceptable as alternative security',
                    ],
                    'km' => [
                        'title' => 'ឥណទានកសិកម្ម',
                        'description' => 'បន្ថែមកម្លាំងដល់វដ្តកសិកម្មរបស់អ្នក សម្រាប់ពូជ ប៉ូស្វាត ប្រព័ន្ធស្រោចស្រព ចិញ្ចឹមសត្វ ឧបករណ៍ និងគ្រប់គ្រងលំហូរសាច់ប្រាក់តាមរដូវកាល។', // enriched [web:10][web:6]
                        'conditions' =>
                            "រូបិយប័ណ្ណ៖ រៀល ឬ ដុល្លារ\n" .
                            "ទំហំឥណទាន៖ រហូតដល់ 50,000 ដុល្លារ (ឧ. បរិច្ឆេទ កប់ម៉ូទ័រស្រោច សួនកញ្ចក់ អាហារសត្វ)\n" .
                            "រយៈពេល៖ រហូតដល់ 8 ឆ្នាំ (96 ខែ) អាចផ្តល់ពេលអនុគ្រោះតាមរដូវដាំ/ចម្រាញ់\n" .
                            "លក្ខខណ្ឌ៖ កសិករ សហកសិករ អាជីវកម្មកសិកម្ម មានភស្តុតាងចំណូលសាមញ្ញ\n" .
                            "សមត្ថភាពសង៖ មិនលើស 70% និងប្រវត្តិសងល្អ\n" .
                            "ឯកសារ៖ អត្តសញ្ញាណប័ណ្ណ ភស្តុតាងកសិដ្ឋាន (រូបថត/កិច្ចសន្យា) សៀវភៅសាច់ប្រាក់ ឬ វិក័យប័ត្រអ្នកទិញ",
                        'collateral_info' => 'ប្លង់ទន់/ប្លង់រឹង កាតគ្រីយានយន្ត ឧបករណ៍កសិកម្ម ឬ អ្នកធានា/ក្រុមធានា ជាជម្រើសធានា',
                    ],
                ],
                'condition' => [
                    'currency_type' => 'Both',
                    'min_amount' => 250,
                    'max_amount' => 50000,
                    'max_duration_months' => 96,
                    'min_age' => 18,
                    'max_age' => 65,
                    'max_debt_ratio' => 70.00,
                ],
            ],

            // 2) Business Loan
            [
                'slug' => 'business-loan',
                'icon' => 'fas fa-briefcase',
                'order' => 4,
                'translations' => [
                    'en' => [
                        'title' => 'Business Loan',
                        'description' => 'Fuel SME growth with working capital, inventory top‑ups, equipment purchases, cash‑cycle bridging, and branch expansion for trade, retail, import/export, and services.', // enriched [web:6][web:3]
                        'conditions' =>
                            "Currency: Riel or US Dollar\n" .
                            "Amount: Up to $50,000 (stocking, POS, cold‑chain, fit‑out)\n" .
                            "Term: Up to 8 years (96 months), monthly or flexible repayment\n" .
                            "Eligibility: Valid business proof (license, invoices, or bank statements)\n" .
                            "Credit: Good standing and no serious delinquencies\n" .
                            "Documents: ID, business docs, 6–12 months bank statements or cashbook",
                        'collateral_info' => 'Business assets, property titles, vehicle registration, equipment, or guarantor group as needed',
                    ],
                    'km' => [
                        'title' => 'ឥណទានអាជីវកម្ម',
                        'description' => 'ជំរុញកំណើន SME ដោយបំពេញមូលធនបណ្តោះអាសន្ន ទំនិញស្តុក ឧបករណ៍ ការឆ្លើយតបទៅលំហូរសាច់ប្រាក់ និងពង្រីកសាខា សម្រាប់ពាណិជ្ជកម្ម ឡេឡុង នាំចូល/នាំចេញ និងសេវាកម្ម។',
                        'conditions' =>
                            "រូបិយប័ណ្ណ៖ រៀល ឬ ដុល្លារ\n" .
                            "ទំហំ៖ រហូតដល់ 50,000 ដុល្លារ (ស្តុក POS ត្រជാക്കងូត ការតុបតែងសាខា)\n" .
                            "រយៈពេល៖ រហូតដល់ 8 ឆ្នាំ (96 ខែ) បង់ប្រចាំខែ ឬ បត់បែន\n" .
                            "លក្ខខណ្ឌ៖ មានភស្តុតាងអាជីវកម្ម (អាជ្ញាប័ណ្ណ វិក័យប័ត្រ ឬ របាយការណ៍ធនាគារ)\n" .
                            "ឥណទាន៖ ប្រវត្តិល្អ គ្មានបំណុលខកខានធ្ងន់ធ្ងរ\n" .
                            "ឯកសារ៖ អត្តសញ្ញាណប័ណ្ណ ឯកសារអាជីវកម្ម របាយការណ៍ធនាគារ 6–12 ខែ ឬ សៀវភៅសាច់ប្រាក់",
                        'collateral_info' => 'ទ្រព្យសម្បត្តិអាជីវកម្ម ប្លង់កាន់កម្មសិទ្ធិ កាតគ្រីយានយន្ត ឧបករណ៍ ឬ ក្រុមអ្នកធានា តាមតម្រូវការ',
                    ],
                ],
                'condition' => [
                    'currency_type' => 'Both',
                    'min_amount' => 250,
                    'max_amount' => 50000,
                    'max_duration_months' => 96,
                    'min_age' => 18,
                    'max_age' => 65,
                    'max_debt_ratio' => 70.00,
                ],
            ],

            // 3) Construction Loan
            [
                'slug' => 'construction-loan',
                'icon' => 'fas fa-building',
                'order' => 8,
                'translations' => [
                    'en' => [
                        'title' => 'Construction Loan',
                        'description' => 'Finance ground‑up builds, home renovations, property development, and small infrastructure with stage‑based disbursements and documentation support.', // enriched [web:6][web:3]
                        'conditions' =>
                            "Currency: Riel or US Dollar\n" .
                            "Amount: Up to $50,000 (materials, contractors, permits)\n" .
                            "Term: Up to 8 years (96 months) with phased drawdowns\n" .
                            "Eligibility: Owner/developer with clear plan and cost estimates\n" .
                            "Requirements: Building permit and property documents\n" .
                            "Disbursement: Tranches upon milestone verification",
                        'collateral_info' => 'Land title, construction plan, property under construction, or other acceptable assets',
                    ],
                    'km' => [
                        'title' => 'ឥណទានសំណង់',
                        'description' => 'ហិរញ្ញប្បទានសម្រាប់សាងសង់ថ្មី ជួសជុលផ្ទះ អភិវឌ្ឍអចលនទ្រព្យ និងគម្រោងហេដ្ឋារចនាសម្ព័ន្ធតូចៗ ជាមួយការចែកចាយទឹកប្រាក់ជាដំណាក់កាល។',
                        'conditions' =>
                            "រូបិយប័ណ្ណ៖ រៀល ឬ ដុល្លារ\n" .
                            "ទំហំ៖ រហូតដល់ 50,000 ដុល្លារ (សម្ភារៈ ក្រុមហ៊ុនសាងសង់ អនុញ្ញាត)\n" .
                            "រយៈពេល៖ រហូតដល់ 8 ឆ្នាំ (96 ខែ) ចែកចាយតាមដំណាក់កាល\n" .
                            "លក្ខខណ្ឌ៖ ម្ចាស់/អ្នកអភិវឌ្ឍ មានផែនការ និងប៉ាន់ស្មានតម្លៃច្បាស់លាស់\n" .
                            "តម្រូវការ៖ លិខិតអនុញ្ញាតសាងសង់ និងឯកសារអចលនទ្រព្យ\n" .
                            "ចេញប្រាក់៖ តាមកំណត់គោលដៅ និងការផ្ទៀងផ្ទាត់",
                        'collateral_info' => 'ប្លង់ដី គម្រោងសំណង់ អចលនទ្រព្យកំពុងសាងសង់ ឬ ទ្រព្យបញ្ចាំផ្សេងៗ',
                    ],
                ],
                'condition' => [
                    'currency_type' => 'Both',
                    'min_amount' => 500,
                    'max_amount' => 50000,
                    'max_duration_months' => 96,
                    'min_age' => 18,
                    'max_age' => 65,
                    'max_debt_ratio' => 70.00,
                ],
            ],

            // 4) Vehicle Loan
            [
                'slug' => 'vehicle-loan',
                'icon' => 'fas fa-car',
                'order' => 3,
                'translations' => [
                    'en' => [
                        'title' => 'Vehicle Loan',
                        'description' => 'Drive sooner with financing for new/used cars, motorbikes, trucks, and commercial vehicles, plus flexible down payments and terms.', // enriched [web:6][web:3]
                        'conditions' =>
                            "Currency: Riel or US Dollar\n" .
                            "Amount: Up to $50,000\n" .
                            "Term: Up to 5 years (60 months)\n" .
                            "Down payment: 10–30% depending on vehicle age/condition\n" .
                            "Eligibility: 18–65 years, stable income and valid ID\n" .
                            "Insurance: Comprehensive recommended",
                        'collateral_info' => 'Vehicle registration, insurance policy, and guarantor if required by assessment',
                    ],
                    'km' => [
                        'title' => 'ឥណទានយានជំនិះ',
                        'description' => 'ទិញយានជំនិះថ្មី ឬប្រើរួច រថយន្ត ម៉ូតូ ឡានដឹកទំនិញ និងយានជំនិះពាណិជ្ជកម្ម ជាមួយលក្ខខណ្ឌបត់បែន និងប្រាក់កក់សមរម្យ។',
                        'conditions' =>
                            "រូបិយប័ណ្ណ៖ រៀល ឬ ដុល្លារ\n" .
                            "ទំហំ៖ រហូតដល់ 50,000 ដុល្លារ\n" .
                            "រយៈពេល៖ រហូតដល់ 5 ឆ្នាំ (60 ខែ)\n" .
                            "ប្រាក់កក់៖ 10–30% អាស្រ័យលើអាយុ/ស្ថានភាពយានជំនិះ\n" .
                            "លក្ខខណ្ឌ៖ អាយុ 18–65 ឆ្នាំ ប្រាក់ចំណូលមានស្ថេរភាព និងអត្តសញ្ញាណប័ណ្ណត្រឹមត្រូវ\n" .
                            "ធានារ៉ាប់រង៖ ផ្ដល់អនុសាសន៍ឲ្យមាន",
                        'collateral_info' => 'កាតគ្រីយានជំនិះ វិញ្ញាបនប័ត្រធានារ៉ាប់រង និង អ្នកធានា (បើត្រូវការ)',
                    ],
                ],
                'condition' => [
                    'currency_type' => 'Both',
                    'min_amount' => 1000,
                    'max_amount' => 50000,
                    'max_duration_months' => 60,
                    'min_age' => 18,
                    'max_age' => 65,
                    'max_debt_ratio' => 70.00,
                ],
            ],

            // 5) Real Estate Mortgage Loan
            [
                'slug' => 'realestate-mortgage-loan',
                'icon' => 'fas fa-home',
                'order' => 9,
                'translations' => [
                    'en' => [
                        'title' => 'Real Estate Mortgage Loan',
                        'description' => 'Purchase or refinance residential/commercial properties with long terms, competitive rates, and professional appraisal support.', // enriched [web:3][web:6]
                        'conditions' =>
                            "Currency: US Dollar\n" .
                            "Amount: Up to $200,000\n" .
                            "Term: Up to 20 years (240 months)\n" .
                            "Down payment: 20–30%\n" .
                            "Eligibility: Clear ownership and stable income\n" .
                            "Appraisal: Independent valuation required",
                        'collateral_info' => 'Hard title, ownership certificate, and valuation report',
                    ],
                    'km' => [
                        'title' => 'ឥណទានបញ្ចាំអចលនទ្រព្យ',
                        'description' => 'ទិញ ឬប្ដូរឥណទានអចលនទ្រព្យលំនៅឋាន/ពាណិជ្ជកម្ម ជាមួយរយៈពេលវែង អត្រាការប្រាក់ប្រកួតប្រជែង និងរបាយការណ៍វាយតម្លៃវិជ្ជាជីវៈ។',
                        'conditions' =>
                            "រូបិយប័ណ្ណ៖ ដុល្លារ\n" .
                            "ទំហំ៖ រហូតដល់ 200,000 ដុល្លារ\n" .
                            "រយៈពេល៖ រហូតដល់ 20 ឆ្នាំ (240 ខែ)\n" .
                            "ប្រាក់កក់៖ 20–30%\n" .
                            "លក្ខខណ្ឌ៖ កម្មសិទ្ធិស្អាត និងចំណូលមានស្ថេរភាព\n" .
                            "វាយតម្លៃ៖ ត្រូវការវាយតម្លៃដោយអង្គភាពឯករាជ្យ",
                        'collateral_info' => 'ប្លង់រឹង លិខិតកម្មសិទ្ធិដី និងរបាយការណ៍វាយតម្លៃ',
                    ],
                ],
                'condition' => [
                    'currency_type' => 'USD',
                    'min_amount' => 5000,
                    'max_amount' => 200000,
                    'max_duration_months' => 240,
                    'min_age' => 21,
                    'max_age' => 65,
                    'max_debt_ratio' => 60.00,
                ],
            ],

            // 6) Mortgage Loan (explicit)
            [
                'slug' => 'mortgage-loan',
                'icon' => 'fas fa-home',
                'order' => 2,
                'translations' => [
                    'en' => [
                        'title' => 'Mortgage Loan',
                        'description' => 'Home mortgages for buying primary homes, investment units, or shophouses, with expert guidance through the process.', // enriched [web:3][web:6]
                        'conditions' =>
                            "Currency: US Dollar\n" .
                            "Amount: Up to $200,000\n" .
                            "Term: Up to 20 years (240 months)\n" .
                            "Down payment: 20–30%\n" .
                            "Income: Debt‑to‑income capped at policy threshold\n" .
                            "Processing: Title check, appraisal, and insurance",
                        'collateral_info' => 'Hard title, ownership certificate, and valuation report',
                    ],
                    'km' => [
                        'title' => 'ឥណទានបញ្ចាំផ្ទះ',
                        'description' => 'សម្រាប់ទិញផ្ទះលំនៅដ្ឋាន បន្ទប់ជួល ឬផ្ទះប៉ាហាំង ជាមួយការណែនាំវិជ្ជាជីវៈក្នុងដំណើរការទាំងមូល។',
                        'conditions' =>
                            "រូបិយប័ណ្ណ៖ ដុល្លារ\n" .
                            "ទំហំ៖ រហូតដល់ 200,000 ដុល្លារ\n" .
                            "រយៈពេល៖ រហូតដល់ 20 ឆ្នាំ (240 ខែ)\n" .
                            "ប្រាក់កក់៖ 20–30%\n" .
                            "ចំណូល៖ សមាមាត្របំណុល-ចំណូល មិនលើសតាមគោលនយោបាយ\n" .
                            "ដំណើរការ៖ ពិនិត្យកម្មសិទ្ធិ វាយតម្លៃ និងធានារ៉ាប់រង",
                        'collateral_info' => 'ប្លង់រឹង លិខិតកម្មសិទ្ធិដី និងរបាយការណ៍វាយតម្លៃ',
                    ],
                ],
                'condition' => [
                    'currency_type' => 'USD',
                    'min_amount' => 5000,
                    'max_amount' => 200000,
                    'max_duration_months' => 240,
                    'min_age' => 21,
                    'max_age' => 65,
                    'max_debt_ratio' => 60.00,
                ],
            ],

            // 7) Education Loan
            [
                'slug' => 'education-loan',
                'icon' => 'fas fa-graduation-cap',
                'order' => 6,
                'translations' => [
                    'en' => [
                        'title' => 'Education Loan',
                        'description' => 'Invest in learning with funding for tuition, fees, study abroad, and vocational programs, with flexible grace during study.', // enriched [web:3][web:6]
                        'conditions' =>
                            "Currency: Riel or US Dollar\n" .
                            "Amount: Up to $30,000\n" .
                            "Term: Up to 10 years (120 months)\n" .
                            "Age: 18–60 years\n" .
                            "Eligibility: Admission letter and basic income/guarantor\n" .
                            "Repayment: Interest‑only during study (if eligible)",
                        'collateral_info' => 'Guarantor (parent/guardian), property title, or salary assignment',
                    ],
                    'km' => [
                        'title' => 'ឥណទានអប់រំ',
                        'description' => 'វិនិយោគក្នុងការសិក្សា សម្រាប់ថ្លៃសិក្សា ថ្លៃធ្វើឯកសារ សិក្សានៅបរទេស និងការបណ្តុះបណ្តាលវិជ្ជាជីវៈ ជាមួយពេលអនុគ្រោះក្នុងពេលរៀន។',
                        'conditions' =>
                            "រូបិយប័ណ្ណ៖ រៀល ឬ ដុល្លារ\n" .
                            "ទំហំ៖ រហូតដល់ 30,000 ដុល្លារ\n" .
                            "រយៈពេល៖ រហូតដល់ 10 ឆ្នាំ (120 ខែ)\n" .
                            "អាយុ៖ 18–60 ឆ្នាំ\n" .
                            "លក្ខខណ្ឌ៖ លិខិតចូលរៀន និងអ្នកធានា/ចំណូលមូលដ្ឋាន\n" .
                            "ការបង់៖ អាចបង់ការប្រាក់តែប៉ុណ្ណោះក្នុងពេលរៀន (បើមាន)",
                        'collateral_info' => 'អ្នកធានា (ឪពុកម្តាយ/អាណាព្យាបាល) ប្លង់ទ្រព្យ ឬ ចាត់ចែងប្រាក់ខែ',
                    ],
                ],
                'condition' => [
                    'currency_type' => 'Both',
                    'min_amount' => 500,
                    'max_amount' => 30000,
                    'max_duration_months' => 120,
                    'min_age' => 18,
                    'max_age' => 60,
                    'max_debt_ratio' => 70.00,
                ],
            ],

            // 8) Fast Loan
            [
                'slug' => 'fast-loan',
                'icon' => 'fas fa-bolt',
                'order' => 7,
                'translations' => [
                    'en' => [
                        'title' => 'Fast Loan',
                        'description' => 'Get quick approvals for urgent needs with minimal documents and rapid disbursement to handle medical, travel, or emergency expenses.', // enriched [web:6][web:3]
                        'conditions' =>
                            "Currency: Riel or US Dollar\n" .
                            "Amount: Up to $5,000\n" .
                            "Term: Up to 2 years (24 months)\n" .
                            "Age: 21–65 years\n" .
                            "Approval: 24–48 hours for qualified applicants\n" .
                            "Documents: ID and simple income proof",
                        'collateral_info' => 'ID, income proof, and guarantor if required by risk review',
                    ],
                    'km' => [
                        'title' => 'ឥណទានរហ័ស',
                        'description' => 'អនុម័តលឿនសម្រាប់តម្រូវការបន្ទាន់ ជាមួយឯកសារតិច និងចេញប្រាក់ឆាប់រហ័ស ដើម្បីគ្រប់គ្រងចំណាយបន្ទាន់ៗ។',
                        'conditions' =>
                            "រូបិយប័ណ្ណ៖ រៀល ឬ ដុល្លារ\n" .
                            "ទំហំ៖ រហូតដល់ 5,000 ដុល្លារ\n" .
                            "រយៈពេល៖ រហូតដល់ 2 ឆ្នាំ (24 ខែ)\n" .
                            "អាយុ៖ 21–65 ឆ្នាំ\n" .
                            "អនុម័ត៖ 24–48 ម៉ោង សម្រាប់អ្នកបំពេញលក្ខណៈ\n" .
                            "ឯកសារ៖ អត្តសញ្ញាណប័ណ្ណ និងភស្តុតាងចំណូលសាមញ្ញ",
                        'collateral_info' => 'អត្តសញ្ញាណប័ណ្ណ បញ្ជាក់ប្រាក់ចំណូល និង អ្នកធានា តាមការវាយតម្លៃហានិភ័យ',
                    ],
                ],
                'condition' => [
                    'currency_type' => 'Both',
                    'min_amount' => 100,
                    'max_amount' => 5000,
                    'max_duration_months' => 24,
                    'min_age' => 21,
                    'max_age' => 65,
                    'max_debt_ratio' => 70.00,
                ],
            ],

            // 9) Personal Loan
            [
                'slug' => 'personal-loan',
                'icon' => 'fas fa-user',
                'order' => 1,
                'translations' => [
                    'en' => [
                        'title' => 'Personal Loan',
                        'description' => 'Unsecured financing for weddings, medical care, travel, home upgrades, or debt consolidation with transparent fees and predictable payments.', // enriched [web:6][web:3]
                        'conditions' =>
                            "Currency: Riel or US Dollar\n" .
                            "Amount: Up to $20,000\n" .
                            "Term: Up to 5 years (60 months)\n" .
                            "Age: 21–65 years\n" .
                            "Eligibility: Stable income and acceptable credit profile\n" .
                            "Documents: Salary certificate, bank statements, ID, and guarantor if needed",
                        'collateral_info' => 'No collateral required for qualified borrowers; guarantor or proof of income may be requested',
                    ],
                    'km' => [
                        'title' => 'ឥណទានផ្ទាល់ខ្លួន',
                        'description' => 'ឥណទានគ្មានទ្រព្យបញ្ចាំ សម្រាប់មង្គលការ វេជ្ជសាស្ត្រ ដំណើរកំសាន្ត កែលំអផ្ទះ ឬបង្រួបបង្រួមបំណុល ជាមួយថ្លៃសេវាផ្ទាល់ត្រឹមត្រូវ។',
                        'conditions' =>
                            "រូបិយប័ណ្ណ៖ រៀល ឬ ដុល្លារ\n" .
                            "ទំហំ៖ រហូតដល់ 20,000 ដុល്ലារ\n" .
                            "រយៈពេល៖ រហូតដល់ 5 ឆ្នាំ (60 ខែ)\n" .
                            "អាយុ៖ 21–65 ឆ្នាំ\n" .
                            "លក្ខខណ្ឌ៖ ប្រាក់ចំណូលមានស្ថេរភាព និងប្រវត្តិឥណទានទទួលយកបាន\n" .
                            "ឯកសារ៖ សំបុត្រប្រាក់ខែ របាយការណ៍ធនាគារ អត្តសញ្ញាណប័ណ្ណ និង អ្នកធានា (បើចាំបាច់)",
                        'collateral_info' => 'មិនត្រូវការទ្រព្យបញ្ចាំសម្រាប់អ្នកដែលមានលក្ខណៈ គ្រាន់តែអាចត្រូវការ អ្នកធានា ឬ ភស្តុតាងចំណូល',
                    ],
                ],
                'condition' => [
                    'currency_type' => 'Both',
                    'min_amount' => 500,
                    'max_amount' => 20000,
                    'max_duration_months' => 60,
                    'min_age' => 21,
                    'max_age' => 65,
                    'max_debt_ratio' => 70.00,
                ],
            ],
        ];

        foreach ($items as $item) {
            // Upsert LoanType (idempotent) [web:6]
            $loanType = LoanType::updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'icon' => $item['icon'],
                    'order' => $item['order'],
                    'status' => 'active',
                ]
            );

            // Upsert translations for EN and KM [web:6]
            foreach (['en' => $en, 'km' => $km] as $code => $langModel) {
                $t = $item['translations'][$code];

                LoanTypeTranslation::updateOrCreate(
                    [
                        'loan_type_id' => $loanType->id,
                        'language_id' => $langModel->id,
                    ],
                    [
                        'title' => $t['title'],
                        'description' => $t['description'],
                        'conditions' => $t['conditions'],
                        'collateral_info' => $t['collateral_info'],
                    ]
                );
            }

            // Upsert conditions [web:6]
            LoanCondition::updateOrCreate(
                ['loan_type_id' => $loanType->id],
                $item['condition']
            );
        }
    }
}
