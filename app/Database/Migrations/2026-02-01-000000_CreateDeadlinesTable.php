<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDeadlinesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'auto_increment' => true,
                'unsigned' => true,
            ],
            'entity_type' => [
                'type' => 'VARCHAR', 'constraint' => '50',
            ],
            'entity_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
            ],
            'intake' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'deadline_type' => [
                'type' => 'VARCHAR', 'constraint' => '50',
            ],
            'deadline_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'is_rolling' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
            'notes' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey(['entity_type', 'entity_id']);
        $this->forge->addKey('intake');
        $this->forge->addKey('deadline_type');
        $this->forge->createTable('deadlines', true);
    }

    public function down()
    {
        $this->forge->dropTable('deadlines');
    }
}
