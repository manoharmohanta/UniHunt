<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCountryRequirementsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'country_id'   => [
                'type'     => 'INT',
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
            'is_mandatory' => [
                'type'    => 'BOOLEAN',
                'default' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('country_id', 'countries', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('parameter_id', 'requirement_parameters', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('country_requirements');
    }

    public function down()
    {
        $this->forge->dropTable('country_requirements');
    }
}
