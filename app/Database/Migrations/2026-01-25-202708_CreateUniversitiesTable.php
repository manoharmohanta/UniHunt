<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUniversitiesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
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
                'constraint' => '255',
                'null' => true,
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'unique' => true,
                'null' => true,
            ],
            'type' => [
                'type' => 'VARCHAR', 'constraint' => '50',
                'null' => true,
            ],
            'website' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'ranking' => [
                'type' => 'INT',
                'null' => true,
            ],
            'stem_available' => [
                'type' => 'BOOLEAN',
                'null' => true,
            ],
            'classification' => [
                'type' => 'VARCHAR', 'constraint' => '50',
                'null' => true,
            ],
            'tuition_fee_min' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
            'tuition_fee_max' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
            'metadata' => [
                'type' => 'JSON',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('country_id', 'countries', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('state_id', 'states', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('universities');
    }

    public function down()
    {
        $this->forge->dropTable('universities');
    }
}
