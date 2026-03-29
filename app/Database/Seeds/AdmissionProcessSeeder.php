<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdmissionProcessSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        $usa = $db->table('countries')->where('code', 'USA')->get()->getRow();
        $can = $db->table('countries')->where('code', 'CAN')->get()->getRow();

        $processes = [];

        if ($usa) {
            $processes[] = [
                'country_id' => $usa->id,
                'version' => '1.0',
                'steps' => json_encode([
                    ['step' => 1, 'title' => 'Counseling', 'description' => 'Profile assessment and university selection'],
                    ['step' => 2, 'title' => 'Test Prep', 'description' => 'IELTS/TOEFL and GRE/GMAT preparations'],
                    ['step' => 3, 'title' => 'Application', 'description' => 'Submitting documents to universities'],
                    ['step' => 4, 'title' => 'Offer Letter', 'description' => 'Receiving I-20'],
                    ['step' => 5, 'title' => 'Visa Process', 'description' => 'SEVIS fee and F1 Visa interview']
                ]),
                'effective_from' => date('Y-m-d')
            ];
        }

        if ($can) {
            $processes[] = [
                'country_id' => $can->id,
                'version' => '1.0',
                'steps' => json_encode([
                    ['step' => 1, 'title' => 'University Selection', 'description' => 'Selecting DLI universities'],
                    ['step' => 2, 'title' => 'Application', 'description' => 'Submitting application'],
                    ['step' => 3, 'title' => 'LOA', 'description' => 'Letter of Acceptance'],
                    ['step' => 4, 'title' => 'GIC & Fee', 'description' => 'Paying GIC and 1 year tuition fee'],
                    ['step' => 5, 'title' => 'Visa', 'description' => 'Study Permit application (SDS/Non-SDS)']
                ]),
                'effective_from' => date('Y-m-d')
            ];
        }

        if (!empty($processes)) {
            foreach ($processes as $proc) {
                $db->table('admission_processes')->ignore(true)->insert($proc);
            }
        }
    }
}
