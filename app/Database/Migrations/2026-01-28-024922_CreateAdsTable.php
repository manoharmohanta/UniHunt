<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAdsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'tracking_id' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
                'null' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'source_type' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'default' => 'network',
            ],
            'network_name' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'ad_content' => [
                'type' => 'LONGTEXT', // JSON for direct ads (image_url, link, cta_text) or script tag for network
                'null' => true,
            ],
            'format' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'placement' => [
                'type' => 'VARCHAR',
                'constraint' => 50, // e.g. 'home_top', 'dashboard_sidebar'
            ],
            'start_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'end_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'total_days' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'targeting' => [
                'type' => 'LONGTEXT', // JSON: {"role": ["student"], "country": ["US"], "device": ["mobile"]}
                'null' => true,
            ],
            'frequency_capping' => [
                'type' => 'LONGTEXT', // JSON: {"max_impressions": 3, "cooldown_minutes": 60}
                'null' => true,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'default' => 'active',
            ],
            'price_paid' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
            ],
            'impressions' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'clicks' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('ads');
    }

    public function down()
    {
        $this->forge->dropTable('ads');
    }
}
