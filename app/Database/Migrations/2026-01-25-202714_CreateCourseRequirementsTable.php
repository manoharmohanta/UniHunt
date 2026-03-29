<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCourseRequirementsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'course_id'    => [
                'type'     => 'BIGINT',
                'unsigned' => true,
                'null'     => true,
            ],
            'parameter_id' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true,
            ],
            'value'        => [
                'type' => 'JSON',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('course_id', 'courses', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('parameter_id', 'requirement_parameters', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('course_requirements');
    }

    public function down()
    {
        $this->forge->dropTable('course_requirements');
    }
}
