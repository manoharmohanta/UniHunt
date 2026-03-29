<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBookmarksTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id'     => [
                'type'     => 'BIGINT',
                'unsigned' => true,
                'null'     => true,
            ],
            'entity_type' => [
                'type' => 'VARCHAR', 'constraint' => '50',
                'null'       => true,
            ],
            'entity_id'   => [
                'type'     => 'BIGINT',
                'unsigned' => true,
                'null'     => true,
            ],
            'created_at'  => [
                'type'    => 'TIMESTAMP',
                'null'    => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('bookmarks');
    }

    public function down()
    {
        $this->forge->dropTable('bookmarks');
    }
}
