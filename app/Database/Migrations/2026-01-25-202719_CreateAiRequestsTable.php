<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAiRequestsTable extends Migration
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
            'tool_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'payment_status' => [
                'type' => 'VARCHAR', 'constraint' => '50',
                'default' => 'free',
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
            'final_amount' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
            ],
            'coupon_code' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'input_data' => [
                'type' => 'JSON',
                'null' => true,
            ],
            'output_data' => [
                'type' => 'JSON',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('tool_id', 'ai_tools', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('ai_requests');
    }

    public function down()
    {
        $this->forge->dropTable('ai_requests');
    }
}
