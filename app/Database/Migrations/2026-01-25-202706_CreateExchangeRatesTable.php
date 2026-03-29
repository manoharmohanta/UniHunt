<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateExchangeRatesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'currency'    => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
            ],
            'rate_to_usd' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,4',
                'null'       => true,
            ],
            'updated_at'  => [
                'type'    => 'TIMESTAMP',
                'null'    => true,
            ],
        ]);
        $this->forge->addKey('currency', true);
        $this->forge->createTable('exchange_rates');
    }

    public function down()
    {
        $this->forge->dropTable('exchange_rates');
    }
}
