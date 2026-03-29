<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SystemSettingsSeeder extends Seeder
{
    public function run()
    {
        // 1. Site Config
        $configs = [
            [
                'config_key' => 'site_identity',
                'config_value' => json_encode([
                    'site_name' => 'UniHunt',
                    'tagline' => 'Search. Apply. Fly.',
                    'contact_email' => 'unihunt.overseas@gmail.com',
                    'contact_phone' => '+91 9876543210',
                    'address' => 'Global Education Hub'
                ])
            ],
            [
                'config_key' => 'admission_settings',
                'config_value' => json_encode([
                    'allow_guest_reviews' => false,
                    'moderation_required' => true,
                    'default_currency' => 'USD'
                ])
            ],
            // AI Configuration Defaults
            [
                'config_key' => 'openai_api_key',
                'config_value' => json_encode('')
            ],
            [
                'config_key' => 'ai_model',
                'config_value' => json_encode('arcee-ai/trinity-large-preview:free')
            ],
            [
                'config_key' => 'ai_temperature',
                'config_value' => json_encode(0.7)
            ],
            // Payment Configuration
            [
                'config_key' => 'payments_enabled',
                'config_value' => json_encode('1')
            ],
            [
                'config_key' => 'razorpay_key_id',
                'config_value' => json_encode(env('RAZORPAY_KEY_ID', ''))
            ],
            [
                'config_key' => 'razorpay_key_secret',
                'config_value' => json_encode(env('RAZORPAY_KEY_SECRET', ''))
            ],
            [
                'config_key' => 'razorpay_live_mode',
                'config_value' => json_encode('0')
            ]
        ];

        foreach ($configs as $config) {
            $this->db->table('site_config')->where('config_key', $config['config_key'])->delete();
            $this->db->table('site_config')->insert($config);
        }

        // 2. Exchange Rates
        $rates = [
            ['currency' => 'USD', 'rate_to_usd' => 1.000, 'updated_at' => date('Y-m-d H:i:s')],
            ['currency' => 'GBP', 'rate_to_usd' => 0.735, 'updated_at' => date('Y-m-d H:i:s')],
            ['currency' => 'EUR', 'rate_to_usd' => 0.857, 'updated_at' => date('Y-m-d H:i:s')],
            ['currency' => 'AUD', 'rate_to_usd' => 1.460, 'updated_at' => date('Y-m-d H:i:s')],
            ['currency' => 'CAD', 'rate_to_usd' => 1.360, 'updated_at' => date('Y-m-d H:i:s')],
            ['currency' => 'NZD', 'rate_to_usd' => 1.660, 'updated_at' => date('Y-m-d H:i:s')],
            ['currency' => 'INR', 'rate_to_usd' => 90.39, 'updated_at' => date('Y-m-d H:i:s')],
            ['currency' => 'AED', 'rate_to_usd' => 3.670, 'updated_at' => date('Y-m-d H:i:s')],
            ['currency' => 'SGD', 'rate_to_usd' => 1.370, 'updated_at' => date('Y-m-d H:i:s')],
        ];

        foreach ($rates as $rate) {
            $this->db->table('exchange_rates')->where('currency', $rate['currency'])->delete();
            $this->db->table('exchange_rates')->insert($rate);
        }

        // 3. Visa Types
        $countries = $this->db->table('countries')->get()->getResult();
        $visaData = [
            'USA' => ['F1 Student Visa', 'J1 Exchange Visitor', 'M1 Vocational Student'],
            'GBR' => ['Student Visa (Tier 4)', 'Short-term Student Visa', 'Graduate Route'],
            'CAN' => ['Study Permit', 'Post-Graduation Work Permit (PGWP)'],
            'AUS' => ['Student Visa (Subclass 500)', 'Temporary Graduate Visa (485)'],
            'DEU' => ['Student Applicant Visa', 'Student Visa', 'Language Course Visa'],
            'IRL' => ['Study Visa (Stamp 2)', 'Stamp 1G (Graduate Route)'],
            'NZL' => ['Fee Paying Student Visa', 'Post Study Work Visa'],
            'ARE' => ['Student Visa (1 Year)', 'Golden Visa for Students'],
            'SGP' => ['Student\'s Pass', 'Training Employment Pass'],
        ];

        foreach ($countries as $country) {
            if (isset($visaData[$country->code])) {
                foreach ($visaData[$country->code] as $visa) {
                    $exists = $this->db->table('visa_types')
                        ->where('country_id', $country->id)
                        ->where('name', $visa)
                        ->countAllResults();

                    if ($exists == 0) {
                        $this->db->table('visa_types')->insert([
                            'country_id' => $country->id,
                            'name' => $visa
                        ]);
                    }
                }
            }
        }
    }
}
