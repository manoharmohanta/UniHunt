<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAiHistoryTables extends Migration
{
    public function up()
    {
        // 1. AI Documents - Moved to 2024-02-01-000000_CreateAiDocumentsTable.php

        // 2. Mock Interviews (Visa Interviews)
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
            'country' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'visa_type' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'transcript' => [
                'type' => 'LONGTEXT', // JSON chat history
            ],
            'feedback' => [
                'type' => 'LONGTEXT', // JSON report
                'null' => true,
            ],
            'score' => [
                'type' => 'INT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        if (!$this->db->tableExists('mock_interviews')) {
            $this->forge->createTable('mock_interviews', true);
        }

        // 3. AI Search History (Visa Checker, Career Predictor)
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
            'tool_type' => [
                'type' => 'VARCHAR',
                'constraint' => '50', // VISA_CHECKER, CAREER_PREDICTOR
            ],
            'search_params' => [
                'type' => 'LONGTEXT', // JSON: {country: 'USA', ...}
            ],
            'result_id' => [
                'type' => 'INT', // Linked ID in visa_knowledge_base or career_predictions
                'unsigned' => true,
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        if (!$this->db->tableExists('ai_search_history')) {
            $this->forge->createTable('ai_search_history', true);
        }
    }

    public function down()
    {
        $this->forge->dropTable('ai_search_history');
        $this->forge->dropTable('mock_interviews');
        $this->forge->dropTable('ai_documents');
    }
}
