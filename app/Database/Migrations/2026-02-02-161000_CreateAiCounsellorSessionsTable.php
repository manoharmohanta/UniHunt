<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAiCounsellorSessionsTable extends Migration
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
                'type' => 'BIGINT',
                'unsigned' => true,
                'null' => true,
            ],
            'student_profile' => [
                'type' => 'JSON',
                'null' => true,
                'comment' => 'Student academic background, preferences, budget, goals',
            ],
            'recommendations' => [
                'type' => 'JSON',
                'null' => true,
                'comment' => 'AI-generated university and course recommendations',
            ],
            'conversation_history' => [
                'type' => 'JSON',
                'null' => true,
                'comment' => 'Chat messages between student and AI counsellor',
            ],
            'payment_status' => [
                'type' => 'VARCHAR', 'constraint' => '50',
                'default' => 'pending',
            ],
            'razorpay_order_id' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'razorpay_payment_id' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'coupon_code' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'final_amount' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 99.00,
            ],
            'session_status' => [
                'type' => 'VARCHAR', 'constraint' => '50',
                'default' => 'active',
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('ai_counsellor_sessions');
    }

    public function down()
    {
        $this->forge->dropTable('ai_counsellor_sessions');
    }
}
