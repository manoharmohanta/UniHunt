<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCouponsTables extends Migration
{
    public function up()
    {
        // Coupons Table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'code' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'unique' => true,
            ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'discount_type' => [
                'type' => 'VARCHAR', 'constraint' => '50',
                'default' => 'percentage',
            ],
            'discount_value' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'min_purchase_amount' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
            ],
            'max_discount_amount' => [ // Useful for % caps
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
            'usage_limit' => [ // Global limit (e.g., first 100 people)
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'usage_limit_per_user' => [ // Limit per person (e.g. 1 per user)
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'usage_count' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'starts_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'expires_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'status' => [
                'type' => 'VARCHAR', 'constraint' => '50',
                'default' => 'active',
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('coupons');

        // Coupon Usage History Table (For tracking who used what)
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'coupon_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true, // Nullable if used by guest? But we track per user mostly.
            ],
            'order_id' => [ // Future proofing
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'discount_amount' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'used_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('coupon_id', 'coupons', 'id', 'CASCADE', 'CASCADE');
        // $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'SET NULL'); // Assuming users table exists
        $this->forge->createTable('coupon_usage');
    }

    public function down()
    {
        $this->forge->dropTable('coupon_usage');
        $this->forge->dropTable('coupons');
    }
}
