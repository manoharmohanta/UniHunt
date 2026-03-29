<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTestPrepTables extends Migration
{
    public function up()
    {
        // 1. Create test_prep_exams table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('test_prep_exams');

        // 2. Create test_prep_modules table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'exam_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('exam_id', 'test_prep_exams', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('test_prep_modules');

        // 3. Create test_prep_resources table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'module_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'type' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'default' => 'text', // text, audio, image, video
            ],
            'media_path' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'content' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('module_id', 'test_prep_modules', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('test_prep_resources');

        // 4. Create test_prep_questions table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'module_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'resource_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'question_text' => [
                'type' => 'LONGTEXT',
            ],
            'media_path' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'type' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'default' => 'mcq',
            ],
            'options' => [
                'type' => 'JSON',
                'null' => true,
            ],
            'correct_answer' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('module_id', 'test_prep_modules', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('resource_id', 'test_prep_resources', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('test_prep_questions');
    }

    public function down()
    {
        $this->forge->dropTable('test_prep_questions');
        $this->forge->dropTable('test_prep_resources');
        $this->forge->dropTable('test_prep_modules');
        $this->forge->dropTable('test_prep_exams');
    }
}
