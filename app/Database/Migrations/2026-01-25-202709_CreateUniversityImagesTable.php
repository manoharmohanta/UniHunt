<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUniversityImagesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'university_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
            ],
            'file_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'image_type' => [
                'type' => 'ENUM',
                'constraint' => ['logo', 'cover', 'gallery'],
                'default' => 'gallery',
            ],
            'caption' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'is_main' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
            'uploaded_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('university_id', 'universities', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('university_images');
    }

    public function down()
    {
        $this->forge->dropTable('university_images');
    }
}
