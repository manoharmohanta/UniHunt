<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateVisitorsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'ip_address' => [
                'type'       => 'VARCHAR',
                'constraint' => '45',
                'null'       => true,
            ],
            'country'    => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'user_agent' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'visited_at' => [
                'type'    => 'TIMESTAMP',
                'null'    => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('visitors');
    }

    public function down()
    {
        $this->forge->dropTable('visitors');
    }
}
