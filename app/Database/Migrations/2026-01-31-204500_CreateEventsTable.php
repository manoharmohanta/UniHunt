<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEventsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'unique' => true,
            ],
            'short_description' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'description' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'event_type' => [
                'type' => 'VARCHAR', // Webinar, Fair, Workshop, etc.
                'constraint' => '50',
                'default' => 'Webinar',
            ],
            'organizer' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'start_date' => [
                'type' => 'DATE',
            ],
            'start_time' => [
                'type' => 'TIME',
                'null' => true,
            ],
            'end_time' => [
                'type' => 'TIME',
                'null' => true,
            ],
            'timezone' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'default' => 'UTC',
            ],
            'location_type' => [
                'type' => 'VARCHAR', 'constraint' => '50',
                'default' => 'online',
            ],
            'location_name' => [
                'type' => 'VARCHAR', // "Zoom" or "Excel Centre"
                'constraint' => '255',
                'null' => true,
            ],
            'address' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'registration_link' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'cost' => [
                'type' => 'VARCHAR', // "Free", "$50"
                'constraint' => '100',
                'default' => 'Free',
            ],
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'agenda' => [
                'type' => 'JSON', // [{time, title, description}]
                'null' => true,
            ],
            'speakers' => [
                'type' => 'JSON', // [{name, role, image}]
                'null' => true,
            ],
            'learning_points' => [
                'type' => 'JSON', // ["Point 1", "Point 2"]
                'null' => true,
            ],
            'is_featured' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
            'is_premium' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
            'status' => [
                'type' => 'VARCHAR', 'constraint' => '50',
                'default' => 'draft',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('events', true);
    }

    public function down()
    {
        $this->forge->dropTable('events');
    }
}
