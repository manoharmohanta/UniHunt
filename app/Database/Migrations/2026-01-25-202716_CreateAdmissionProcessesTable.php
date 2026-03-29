<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAdmissionProcessesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'country_id'     => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true,
            ],
            'version'        => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => true,
            ],
            'steps'          => [
                'type' => 'JSON',
                'null' => true,
            ],
            'effective_from' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'effective_to'   => [
                'type' => 'DATE',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('country_id', 'countries', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('admission_processes');
    }

    public function down()
    {
        $this->forge->dropTable('admission_processes');
    }
}
