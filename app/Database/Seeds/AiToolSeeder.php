<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AiToolSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'name' => 'LOR Generator',
                'description' => 'Letter of Recommendation writer',
                'price' => 19.00
            ],
            [
                'id' => 2,
                'name' => 'Resume Builder',
                'description' => 'AI-powered resume generation and styling',
                'price' => 39.00
            ],
            [
                'id' => 3,
                'name' => 'Career Outcome Predictor',
                'description' => 'AI-based career growth forecasting',
                'price' => 39.00
            ],
            [
                'id' => 4,
                'name' => 'Visa Checker',
                'description' => 'AI-powered visa requirement analysis',
                'price' => 39.00
            ],
            [
                'id' => 5,
                'name' => 'SOP Generator',
                'description' => 'Statement of Purpose writing assistant',
                'price' => 99.00
            ],
            [
                'id' => 6,
                'name' => 'Mock Interview',
                'description' => 'Real-time AI visa interview simulation',
                'price' => 199.00
            ],
            [
                'id' => 7,
                'name' => 'SEO Metadata Generator',
                'description' => 'AI generation of meta titles and descriptions',
                'price' => 0.00
            ],
            [
                'id' => 8,
                'name' => 'University Discovery',
                'description' => 'Complete university data retrieval via AI',
                'price' => 0.00
            ],
            [
                'id' => 9,
                'name' => 'Resume Summary/Highlights',
                'description' => 'Micro AI tasks for resume improvement',
                'price' => 0.00
            ],
            [
                'id' => 10,
                'name' => 'Proficiency Mock Test Generator',
                'description' => 'AI generation of IELTS/PTE/GRE style tests',
                'price' => 599.00
            ],
            [
                'id' => 11,
                'name' => 'AI University Counsellor',
                'description' => 'Personalized university and course recommendations with an interactive AI agent.',
                'price' => 399.00
            ]
        ];

        $db = \Config\Database::connect();
        $builder = $db->table('ai_tools');

        foreach ($data as $tool) {
            $id = $tool['id'];
            $exists = $builder->where('id', $id)->countAllResults();

            // Add timestamps if missing in array (dynamic)
            // But usually we just let DB handle it or set it manually if we want to "touch" the record.
            // Let's just use replace() as it was before, BUT adding the price fields which were missing.
            // AND adding 11 explicitly here too so AiToolSeeder is the "master" seeder.

            // However, replace() deletes and re-inserts, which changes created_at if not careful.
            // Upsert is better for maintaining ID and updating fields. Use `upsert` or manual check.

            if ($exists) {
                $tool['updated_at'] = date('Y-m-d H:i:s');
                $builder->where('id', $id)->update($tool);
            } else {
                $tool['created_at'] = date('Y-m-d H:i:s');
                $tool['updated_at'] = date('Y-m-d H:i:s');
                $builder->insert($tool);
            }
        }
    }
}
