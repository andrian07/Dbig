<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PointExchange extends Migration
{
    public function up()
    {
        // Create ms_point_reward //
        $this->forge->addField([
            'reward_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'reward_code' => [
                'type' => 'VARCHAR',
                'constraint' => '8',
            ],
            'reward_name' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
            ],
            'reward_point' => [
                'type' => 'DECIMAL',
                'constraint' => '8,2',
                'default' => 0.00
            ],
            'reward_stock' => [
                'type' => 'DECIMAL',
                'constraint' => '8,2',
                'default' => 0.00
            ],
            'reward_description' => [
                'type' => 'TEXT',
                'constraint' => '500',
            ],
            'reward_image' => [
                'type' => 'TEXT',
                'constraint' => '100',
            ],
            'start_date' => [
                'type' => 'DATE',
            ],
            'end_date' => [
                'type' => 'DATE',
            ],
            'active' => [
                'type' => 'ENUM',
                'constraint' => ['Y', 'N'],
                'default' => 'Y'
            ],
            'deleted' => [
                'type' => 'ENUM',
                'constraint' => ['Y', 'N'],
                'default' => 'N'
            ],

        ]);

        $this->forge->addField('created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->forge->addKey('reward_id', TRUE);
        $this->forge->addKey('reward_code', FALSE, TRUE);
        $this->forge->createTable('ms_point_reward');


        $this->forge->addField([
            'exchange_id'          => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'exchange_code' => [
                'type' => 'VARCHAR',
                'constraint' => '15',
            ],
            'exchange_date' => [
                'type' => 'DATE',
            ],
            'reward_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'customer_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'store_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'user_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'default'        => 0,
            ],
            'exchange_status' => [
                'type' => 'ENUM',
                'constraint' => ['pending', 'cancel', 'success'],
                'default' => 'pending'
            ],
            'completed_by'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'           => true
            ],
            'completed_at' => [
                'type'          => 'DATETIME',
                'null'          => true
            ],
        ]);

        $this->forge->addField('created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->forge->addKey('exchange_id', TRUE);
        $this->forge->addKey('exchange_code', FALSE, TRUE);
        $this->forge->addForeignKey('reward_id', 'ms_point_reward', 'reward_id');
        $this->forge->addForeignKey('customer_id', 'ms_customer', 'customer_id');
        $this->forge->addKey('store_id', FALSE, FALSE);
        $this->forge->createTable('exchange_point');
    }

    public function down()
    {
        //
        $this->forge->dropTable('exchange_point', true);
        $this->forge->dropTable('ms_point_reward', true);
    }
}
