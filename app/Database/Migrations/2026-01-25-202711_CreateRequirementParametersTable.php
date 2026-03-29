<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRequirementParametersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'code' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'unique' => true,
            ],
            'label' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'country_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'applies_to' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'default' => 'Both',
            ],
            'type' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'category_tags' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('country_id', 'countries', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('requirement_parameters');
    }

    public function down()
    {
        $this->forge->dropTable('requirement_parameters');
    }
}
