<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOtpsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'    => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
            ],
            'otp'   => [
                'type'       => 'VARCHAR',
                'constraint' => '6',
            ],
            'expires_at' => [
                'type' => 'DATETIME',
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('email');
        $this->forge->createTable('otps');
    }

    public function down()
    {
        $this->forge->dropTable('otps');
    }
}
