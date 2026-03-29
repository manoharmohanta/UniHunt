<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIpCacheTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'ip_address' => [
                'type' => 'VARCHAR',
                'constraint' => '45',
            ],
            'country_code' => [
                'type' => 'VARCHAR',
                'constraint' => '5',
                'null' => true,
            ],
            'currency' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('ip_address'); // Index for faster lookups
        $this->forge->createTable('ip_cache');
    }

    public function down()
    {
        $this->forge->dropTable('ip_cache');
    }
}
