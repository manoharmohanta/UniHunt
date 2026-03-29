<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RequirementParameterSeeder extends Seeder
{
    public function run()
    {
        // Fetch USA ID dynamically
        $usa = $this->db->table('countries')->where('code', 'USA')->get()->getRow();
        $usaId = $usa ? $usa->id : null;

        $params = [
            // USA Specific (Masters)
            ['code' => '15_years_edu_allowed', 'label' => 'Accepts 15 Years Education', 'type' => 'boolean', 'applies_to' => 'Course', 'country_id' => $usaId, 'category_tags' => 'USA,Masters'],
            ['code' => 'gmat_score', 'label' => 'MIN. GMAT Score', 'type' => 'number', 'applies_to' => 'Course', 'country_id' => $usaId, 'category_tags' => 'USA,Masters'],
            ['code' => 'gre_score', 'label' => 'MIN. GRE Score', 'type' => 'number', 'applies_to' => 'Course', 'country_id' => $usaId, 'category_tags' => 'USA,Masters'],

            // USA Specific (Bachelors)
            ['code' => 'sat_score', 'label' => 'MIN. SAT Score', 'type' => 'number', 'applies_to' => 'Course', 'country_id' => $usaId, 'category_tags' => 'USA,Bachelors'],
            ['code' => 'act_score', 'label' => 'MIN. ACT Score', 'type' => 'number', 'applies_to' => 'Course', 'country_id' => $usaId, 'category_tags' => 'USA,Bachelors'],

            // USA General
            ['code' => 'stem_course', 'label' => 'STEM Available', 'type' => 'boolean', 'applies_to' => 'Course', 'country_id' => $usaId, 'category_tags' => 'USA'],

            // Language & Academic (Global)
            ['code' => 'ielts_score', 'label' => 'MIN. IELTS Score', 'type' => 'number', 'applies_to' => 'Both', 'country_id' => null, 'category_tags' => 'General,International'],
            ['code' => 'toefl_score', 'label' => 'MIN. TOEFL Score', 'type' => 'number', 'applies_to' => 'Both', 'country_id' => null, 'category_tags' => 'General,International'],
            ['code' => 'pte_score', 'label' => 'MIN. PTE Score', 'type' => 'number', 'applies_to' => 'Both', 'country_id' => null, 'category_tags' => 'General,International'],
            ['code' => 'duolingo_score', 'label' => 'MIN. Duolingo Score', 'type' => 'number', 'applies_to' => 'Both', 'country_id' => null, 'category_tags' => 'General,International'],
            ['code' => 'gpa_requirement', 'label' => 'MIN. GPA', 'type' => 'string', 'applies_to' => 'Course', 'country_id' => null, 'category_tags' => 'General'],
            ['code' => 'max_backlogs', 'label' => 'MAX. Backlogs Allowed', 'type' => 'number', 'applies_to' => 'Course', 'country_id' => null, 'category_tags' => 'General'],

            // Experience (Global Masters)
            ['code' => 'work_exp', 'label' => 'Work Experience (Years)', 'type' => 'number', 'applies_to' => 'Course', 'country_id' => null, 'category_tags' => 'Masters,General'],

            // Fees
            ['code' => 'application_fee', 'label' => 'Application Fee', 'type' => 'number', 'applies_to' => 'Course', 'country_id' => null, 'category_tags' => 'General'],
            ['code' => 'deposit_fee', 'label' => 'Deposit Fee', 'type' => 'boolean', 'applies_to' => 'Course', 'country_id' => null, 'category_tags' => 'General'],

            // Course Details (Global)
            ['code' => 'doc_deadline', 'label' => 'Document Submission Deadline', 'type' => 'string', 'applies_to' => 'Course', 'country_id' => null, 'category_tags' => 'General'],
            ['code' => 'app_deadline', 'label' => 'Application Deadline', 'type' => 'string', 'applies_to' => 'Course', 'country_id' => null, 'category_tags' => 'General'],
            ['code' => 'apply_link', 'label' => 'Application URL', 'type' => 'string', 'applies_to' => 'Course', 'country_id' => null, 'category_tags' => 'General'],
            ['code' => 'course_link', 'label' => 'Official Course URL', 'type' => 'string', 'applies_to' => 'Course', 'country_id' => null, 'category_tags' => 'General'],
            ['code' => 'credits', 'label' => 'Total Credits', 'type' => 'number', 'applies_to' => 'Course', 'country_id' => null, 'category_tags' => 'General'],

            // Specific Country Course Requirements
            ['code' => 'scholarship_deadline', 'label' => 'Scholarship Deadline', 'type' => 'string', 'applies_to' => 'Course', 'country_id' => null, 'category_tags' => 'UK,Canada,Ireland,Australia,General'],
            ['code' => 'deposit_deadline', 'label' => 'Tuition Deposit Deadline', 'type' => 'string', 'applies_to' => 'Course', 'country_id' => null, 'category_tags' => 'UK,Canada,Ireland,Australia,General'],
        ];

        foreach ($params as $param) {
            $existing = $this->db->table('requirement_parameters')
                ->where('code', $param['code'])
                ->get()
                ->getRow();

            if ($existing) {
                // Determine if we should update country_id. 
                // Using null if not specified in $param
                $this->db->table('requirement_parameters')
                    ->where('id', $existing->id)
                    ->update($param);
            } else {
                $this->db->table('requirement_parameters')->insert($param);
            }
        }
    }
}
