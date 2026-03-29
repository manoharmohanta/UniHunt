<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCareerPredictionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'course_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'home_country' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'job_titles' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'payscales' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'top_mncs' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'career_roadmap' => [
                'type' => 'LONGTEXT',
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
        $this->forge->addUniqueKey(['course_name', 'home_country']);
        $this->forge->createTable('career_predictions');
    }

    public function down()
    {
        $this->forge->dropTable('career_predictions');
    }
}
