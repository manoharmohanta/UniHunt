<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSubscribersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'email'        => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
                'unique'     => true,
            ],
            'subscribed_at' => [
                'type'    => 'TIMESTAMP',
                'null'    => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('subscribers');
    }

    public function down()
    {
        $this->forge->dropTable('subscribers');
    }
}
