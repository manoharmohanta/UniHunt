<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateReviewsTable extends Migration
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
            'user_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'null' => true,
            ],
            'university_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'null' => true,
            ],
            'course_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'null' => true,
            ],
            'rating' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'unsigned' => true,
                'default' => 5,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'review' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'reviewer_name' => [
                'type' => 'VARCHAR', 'constraint' => '50',
                'null' => true,
            ],
            'reviewer_designation' => [
                'type' => 'VARCHAR', 'constraint' => '50',
                'null' => true,
            ],
            'comment' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'status' => [
                'type' => 'VARCHAR', 'constraint' => '50',
                'default' => 'pending',
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
        $this->forge->addForeignKey('user_id', 'users', 'id', 'SET NULL', 'CASCADE');
        // Assuming universities and courses tables exist based on listing
        // If strict constraints cause issues during dev, we can skip FKs, but good practice to have them.
        // I will add them assuming tables exist.
        $this->forge->addForeignKey('university_id', 'universities', 'id', 'CASCADE', 'CASCADE');
        // $this->forge->addForeignKey('course_id', 'courses', 'id', 'CASCADE', 'CASCADE'); 

        $this->forge->createTable('reviews');
    }

    public function down()
    {
        $this->forge->dropTable('reviews');
    }
}
