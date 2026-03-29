<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDestinationInterestTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'country_slug' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'ip_address' => [
                'type' => 'VARCHAR',
                'constraint' => '45',
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('country_slug');
        $this->forge->createTable('destination_interest', true);
    }

    public function down()
    {
        $this->forge->dropTable('destination_interest');
    }
}
