<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterExchangePointAddRewardPoint extends Migration
{
    public function up()
    {
        $fields = [
            'reward_point' => [
                'type' => 'DECIMAL',
                'constraint' => '8,2',
                'default' => 0.00,
                'after' => 'reward_id',
            ]
        ];
        $this->forge->addColumn('exchange_point', $fields);
    }

    public function down()
    {
        //
    }
}
