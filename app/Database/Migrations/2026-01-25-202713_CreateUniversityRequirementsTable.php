<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUniversityRequirementsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'university_id' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
                'null'     => true,
            ],
            'parameter_id'  => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true,
            ],
            'value'         => [
                'type' => 'JSON',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('university_id', 'universities', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('parameter_id', 'requirement_parameters', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('university_requirements');
    }

    public function down()
    {
        $this->forge->dropTable('university_requirements');
    }
}
