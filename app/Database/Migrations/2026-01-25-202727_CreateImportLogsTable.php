<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateImportLogsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'entity'     => [
                'type' => 'VARCHAR', 'constraint' => '50',
                'null'       => true,
            ],
            'total'      => [
                'type'    => 'INT',
                'null'    => true,
            ],
            'success'    => [
                'type'    => 'INT',
                'null'    => true,
            ],
            'failed'     => [
                'type'    => 'INT',
                'null'    => true,
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'null'    => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('import_logs');
    }

    public function down()
    {
        $this->forge->dropTable('import_logs');
    }
}
