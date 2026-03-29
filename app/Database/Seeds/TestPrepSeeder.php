<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TestPrepSeeder extends Seeder
{
    public function run()
    {
        $exams = [
            'IELTS' => ['Listening', 'Reading', 'Writing', 'Speaking'],
            'TOEFL' => ['Reading', 'Listening', 'Speaking', 'Writing'],
            'PTE' => ['Speaking & Writing', 'Reading', 'Listening'],
            'Duolingo' => ['Adaptive Test', 'Video Interview'],
            'GRE' => ['Verbal Reasoning', 'Quantitative Reasoning', 'Analytical Writing'],
            'GMAT' => ['Analytical Writing', 'Integrated Reasoning', 'Quantitative', 'Verbal'],
            'SAT' => ['Reading', 'Writing and Language', 'Math'],
            'ACT' => ['English', 'Math', 'Reading', 'Science', 'Writing'],
        ];

        foreach ($exams as $examName => $modules) {
            // Check if exam exists
            $existingExam = $this->db->table('test_prep_exams')->where('name', $examName)->get()->getRow();

            if (!$existingExam) {
                $this->db->table('test_prep_exams')->insert([
                    'name' => $examName,
                    'slug' => strtolower($examName),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
                $examId = $this->db->insertID();
            } else {
                $examId = $existingExam->id;
            }

            foreach ($modules as $moduleName) {
                // Check if module exists
                $existingModule = $this->db->table('test_prep_modules')
                    ->where('exam_id', $examId)
                    ->where('name', $moduleName)
                    ->get()->getRow();

                if (!$existingModule) {
                    $this->db->table('test_prep_modules')->insert([
                        'exam_id' => $examId,
                        'name' => $moduleName,
                        'slug' => url_title($moduleName, '-', true),
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                }
            }
        }
    }
}
