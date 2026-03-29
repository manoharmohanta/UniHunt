<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateVisaKnowledgeBaseTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'country' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'visa_type' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'document_checklist' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'travel_plan' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'places_to_visit' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'things_to_carry' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'useful_links' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'image_keyword' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
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
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['country', 'visa_type']);
        $this->forge->createTable('visa_knowledge_base');
    }

    public function down()
    {
        $this->forge->dropTable('visa_knowledge_base');
    }
}
