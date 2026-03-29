<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCitiesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'country_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'state_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'living_cost' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('country_id', 'countries', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('state_id', 'states', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('cities');
    }

    public function down()
    {
        $this->forge->dropTable('cities');
    }
}
