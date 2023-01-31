<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class LogTransactionEditQueries extends Migration
{
    public function up()
    {
        // Create log_transaction_edit_queries table //
        $this->forge->addField([
            'log_edit_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'log_transaction_code' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
            ],
            'log_transaction_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'log_user_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'log_remark' => [
                'type' => 'TEXT',
                'constraint' => '500',
            ],
            'log_detail' => [
                'type' => 'TEXT',
                'constraint' => '500',
            ],
            'log_header' => [
                'type' => 'TEXT',
                'constraint' => '500',
            ],
        ]);
        $this->forge->addField('created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addKey('log_edit_id', TRUE);
        $this->forge->addKey('log_transaction_id', FALSE, FALSE);
        $this->forge->addForeignKey('log_user_id', 'user_account', 'user_id');
        $this->forge->createTable('log_transaction_edit_queries');
    }

    public function down()
    {
        //
        $this->forge->dropTable('log_transaction_edit_queries', true);
    }
}
