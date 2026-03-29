<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserAcademicProfilesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'null' => true,
            ],
            'academic_data' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'course_choice' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'target_level' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'target_country' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'ielts_score' => [
                'type' => 'DECIMAL',
                'constraint' => '3,1',
                'null' => true,
            ],
            'gre_score' => [
                'type' => 'INT',
                'constraint' => 5,
                'null' => true,
            ],
            'backlogs' => [
                'type' => 'INT',
                'constraint' => 2,
                'null' => true,
            ],
            'is_15_years_education' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
            'stem_interest' => [
                'type' => 'BOOLEAN',
                'default' => false,
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
        $this->forge->addKey('user_id');
        $this->forge->createTable('user_academic_profiles');
    }

    public function down()
    {
        $this->forge->dropTable('user_academic_profiles');
    }
}
