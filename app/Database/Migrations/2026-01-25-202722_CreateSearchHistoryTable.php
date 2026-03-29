<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSearchHistoryTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id'    => [
                'type'     => 'BIGINT',
                'unsigned' => true,
                'null'     => true,
            ],
            'query'      => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'filters'    => [
                'type' => 'JSON',
                'null' => true,
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'null'    => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('search_history');
    }

    public function down()
    {
        $this->forge->dropTable('search_history');
    }
}
