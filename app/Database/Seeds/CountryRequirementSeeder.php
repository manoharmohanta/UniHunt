<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CountryRequirementSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        // Get Countries
        $usa = $db->table('countries')->where('code', 'USA')->get()->getRow();
        $can = $db->table('countries')->where('code', 'CAN')->get()->getRow();
        $gbr = $db->table('countries')->where('code', 'GBR')->get()->getRow();
        $aus = $db->table('countries')->where('code', 'AUS')->get()->getRow();

        // Get common parameters
        $ielts = $db->table('requirement_parameters')->where('code', 'ielts_score')->get()->getRow();
        $gpa = $db->table('requirement_parameters')->where('code', 'gpa_requirement')->get()->getRow();
        $deposit = $db->table('requirement_parameters')->where('code', 'deposit_fee')->get()->getRow();

        $requirements = [];

        // USA Defaults
        if ($usa && $ielts) {
            $requirements[] = [
                'country_id' => $usa->id,
                'parameter_id' => $ielts->id,
                'value' => json_encode(['min' => 6.5, 'target' => 7.0]),
                'is_mandatory' => true
            ];
        }

        // Canada Defaults
        if ($can && $ielts) {
            $requirements[] = [
                'country_id' => $can->id,
                'parameter_id' => $ielts->id,
                'value' => json_encode(['min' => 6.0, 'sds_requirement' => 6.0]),
                'is_mandatory' => true
            ];
        }

        // UK Defaults
        if ($gbr && $ielts) {
            $requirements[] = [
                'country_id' => $gbr->id,
                'parameter_id' => $ielts->id,
                'value' => json_encode(['min' => 6.0, 'london_min' => 6.5]),
                'is_mandatory' => true
            ];
        }

        // General Deposit Requirement
        if ($deposit) {
            foreach ([$usa, $can, $gbr, $aus] as $country) {
                if ($country) {
                    $requirements[] = [
                        'country_id' => $country->id,
                        'parameter_id' => $deposit->id,
                        'value' => json_encode(['required' => true]),
                        'is_mandatory' => true
                    ];
                }
            }
        }

        if (!empty($requirements)) {
            foreach ($requirements as $req) {
                $db->table('country_requirements')->ignore(true)->insert($req);
            }
        }
    }
}
