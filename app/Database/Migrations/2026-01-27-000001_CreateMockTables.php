<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMockTables extends Migration
{
    public function up()
    {
        // Mock Questions Table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'test_type' => [
                'type' => 'VARCHAR',
                'constraint' => '50', // IELTS, PTE, etc.
            ],
            'section' => [
                'type' => 'VARCHAR',
                'constraint' => '50', // Reading, Writing, Speaking, Math
            ],
            'content' => [
                'type' => 'LONGTEXT', // The question text/context
            ],
            'options' => [
                'type' => 'LONGTEXT', // JSON for MCQs, null for subjective
                'null' => true,
            ],
            'correct_answer' => [
                'type' => 'LONGTEXT', // JSON or string
                'null' => true,
            ],
            'difficulty' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'default' => 'Medium',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('mock_questions');

        // Mock Attempts Table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
            ],
            'test_type' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'score_summary' => [
                'type' => 'LONGTEXT', // JSON summary of scores
            ],
            'detailed_report' => [
                'type' => 'LONGTEXT', // Full AI feedback
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('mock_attempts');
    }

    public function down()
    {
        $this->forge->dropTable('mock_attempts');
        $this->forge->dropTable('mock_questions');
    }
}
