<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEmailQueueTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'recipient'  => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
                'null'       => true,
            ],
            'email_subject' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'email_body_html' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'email_body_text' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'target_audience_rules' => [
                'type' => 'JSON',
                'null' => true,
            ],
            'priority' => [
                'type' => 'VARCHAR', 'constraint' => '50',
                'default' => 'medium',
            ],
            'scheduled_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'campaign_tag' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'status'     => [
                'type' => 'VARCHAR', 'constraint' => '50',
                'null'       => true,
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'null'    => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('email_queue');
    }

    public function down()
    {
        $this->forge->dropTable('email_queue');
    }
}
