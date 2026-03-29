<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateVisaTypesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'country_id' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true,
            ],
            'name'       => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('country_id', 'countries', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('visa_types');
    }

    public function down()
    {
        $this->forge->dropTable('visa_types');
    }
}
