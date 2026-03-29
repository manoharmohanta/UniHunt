<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSiteConfigTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'config_key'   => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'config_value' => [
                'type' => 'JSON',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('config_key', true);
        $this->forge->createTable('site_config');
    }

    public function down()
    {
        $this->forge->dropTable('site_config');
    }
}
