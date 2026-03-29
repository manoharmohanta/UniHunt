<?php
namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run()
    {
        // 1. Core Lookups
        $this->call('RoleSeeder');
        $this->call('LocationSeeder');

        // 2. Settings & Config
        $this->call('SystemSettingsSeeder');
        $this->call('RequirementParameterSeeder');
        $this->call('CountryRequirementSeeder');
        $this->call('AdmissionProcessSeeder');

        // 3. Module Data
        $this->call('AiToolSeeder');

        // 4. Dummy/Test Data (Optional, but good for starting)
    }
}
