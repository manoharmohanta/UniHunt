<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'name' => 'admin',
                'description' => 'Administrator with full access to all settings and data.'
            ],
            [
                'id' => 2,
                'name' => 'student',
                'description' => 'Regular user looking for universities and courses.'
            ],
            [
                'id' => 3,
                'name' => 'counselor',
                'description' => 'Verified counselor who can guide students.'
            ],
            [
                'id' => 4,
                'name' => 'university_rep',
                'description' => 'Representative from a university managing their profile.'
            ],
            [
                'id' => 5,
                'name' => 'Study Abroad Agent',
                'description' => 'Agent who can post ads and events'
            ]
        ];

        // Using REPLACE INTO or similar logic to avoid duplicates if re-seeding
        // Simple insertBatch might fail on duplicate keys, so we check first or just use query builder
        $db = \Config\Database::connect();
        $builder = $db->table('roles');

        foreach ($data as $role) {
            // Check if exists
            $exists = $builder->where('id', $role['id'])->countAllResults();
            if (!$exists) {
                $builder->insert($role);
            }
        }
    }
}
