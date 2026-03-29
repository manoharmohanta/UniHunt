<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'role_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'university_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
                'unique' => true,
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
                'unique' => true,
                'null' => true,
            ],
            'registered_from' => [
                'type' => 'ENUM',
                'constraint' => ['web', 'app'],
                'default' => 'web',
            ],
            'is_verified' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['active', 'inactive', 'banned'],
                'default' => 'active',
            ],
            'marketing_consent' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('role_id', 'roles', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
