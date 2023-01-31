<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PosSession extends Migration
{
    public function up()
    {
        // Create hd_pos_session table //
        $this->forge->addField([
            'session_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'session_key' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'store_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true
            ],
            'open_balance' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'close_balance' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'close_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'closed' => [
                'type' => 'ENUM',
                'constraint' => ['Y', 'N'],
                'default' => 'N'
            ],
            'session_remark' => [
                'type' => 'TEXT',
                'constraint' => '500',
            ],
            'user_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ]
        ]);

        $this->forge->addField('created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->forge->addKey('session_id', TRUE);
        $this->forge->addKey('session_key', FALSE, TRUE);
        $this->forge->addForeignKey('store_id', 'ms_store', 'store_id');
        $this->forge->addForeignKey('user_id', 'user_account', 'user_id');
        $this->forge->createTable('hd_pos_session');

        // Create dt_pos_session_transaction table //
        $this->forge->addField([
            'detail_id'          => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'session_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'transaction_id'  => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'transaction_type' => [
                'type' => 'ENUM',
                'constraint' => ['SI', 'SR'],
                'default' => 'SI'
            ],
            'posted' => [
                'type' => 'ENUM',
                'constraint' => ['Y', 'N'],
                'default' => 'N'
            ],
        ]);

        $this->forge->addKey('detail_id', TRUE);
        $this->forge->addForeignKey('session_id', 'hd_pos_session', 'session_id');
        $this->forge->createTable('dt_pos_session_transaction');

        // Create dt_pos_session_cash table //
        $this->forge->addField([
            'detail_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'session_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'cash_balance' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'cash_type' => [
                'type' => 'ENUM',
                'constraint' => ['IN', 'OUT'],
                'default' => 'IN'
            ],
            'cash_remark' => [
                'type' => 'TEXT',
                'constraint' => '500',
            ],
            'posted' => [
                'type' => 'ENUM',
                'constraint' => ['Y', 'N'],
                'default' => 'N'
            ],
        ]);

        $this->forge->addField('created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addKey('detail_id', TRUE);
        $this->forge->addForeignKey('session_id', 'hd_pos_session', 'session_id');
        $this->forge->createTable('dt_pos_session_cash');
    }

    public function down()
    {
        $this->forge->dropTable('dt_pos_session_cash', true);
        $this->forge->dropTable('dt_pos_session_transaction', true);
        $this->forge->dropTable('hd_pos_session', true);
    }
}
