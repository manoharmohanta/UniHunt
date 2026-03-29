<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCoursesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'university_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'null' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'level' => [
                'type' => 'VARCHAR', 'constraint' => '50',
                'null' => true,
            ],
            'field' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'stem' => [
                'type' => 'BOOLEAN',
                'null' => true,
            ],
            'duration_months' => [
                'type' => 'INT',
                'null' => true,
            ],
            'tuition_fee' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
            'credits' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'intake_months' => [
                'type' => 'JSON',
                'null' => true,
            ],
            'metadata' => [
                'type' => 'JSON',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('university_id', 'universities', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('courses');
    }

    public function down()
    {
        $this->forge->dropTable('courses');
    }
}
