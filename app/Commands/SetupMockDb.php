<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class SetupMockDb extends BaseCommand
{
    protected $group       = 'Custom';
    protected $name        = 'setup:mockdb';
    protected $description = 'Force create mock_attempts table';

    public function run(array $params)
    {
        $forge = \Config\Database::forge();
        $db = \Config\Database::connect();

        CLI::write('Checking tables...', 'yellow');

        // Mock Questions
        if (!$db->tableExists('mock_questions')) {
            $forge->addField([
                'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
                'test_type' => ['type' => 'VARCHAR', 'constraint' => '50'],
                'section' => ['type' => 'VARCHAR', 'constraint' => '50'],
                'content' => ['type' => 'TEXT'],
                'options' => ['type' => 'TEXT', 'null' => true],
                'correct_answer' => ['type' => 'TEXT', 'null' => true],
                'difficulty' => ['type' => 'VARCHAR', 'constraint' => '20', 'default' => 'Medium'],
                'created_at' => ['type' => 'DATETIME', 'null' => true],
            ]);
            $forge->addKey('id', true);
            $forge->createTable('mock_questions');
            CLI::write('mock_questions created.', 'green');
        } else {
            CLI::write('mock_questions already exists.', 'white');
        }

        // Mock Attempts
        if (!$db->tableExists('mock_attempts')) {
            $forge->addField([
                'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
                'user_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
                'test_type' => ['type' => 'VARCHAR', 'constraint' => '50'],
                'score_summary' => ['type' => 'TEXT'],
                'detailed_report' => ['type' => 'LONGTEXT'],
                'created_at' => ['type' => 'DATETIME', 'null' => true],
            ]);
            $forge->addKey('id', true);
            $forge->createTable('mock_attempts');
            CLI::write('mock_attempts created.', 'green');
        } else {
            CLI::write('mock_attempts already exists.', 'white');
        }

        CLI::write('Done.', 'green');
    }
}
