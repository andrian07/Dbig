<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PaymentMethodAndLastRecordNumber extends Migration
{
    public function up()
    {
        // Create ms_payment_method table //
        $this->forge->addField([
            'payment_method_id'  => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'store_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'default'        => 0
            ],
            'payment_method_name' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
            ],
            'bank_account_name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'bank_account_number' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'show_on_purchase' => [
                'type' => 'ENUM',
                'constraint' => ['Y', 'N'],
                'default' => 'Y'
            ],
            'show_on_purchase_return' => [
                'type' => 'ENUM',
                'constraint' => ['Y', 'N'],
                'default' => 'Y'
            ],
            'show_on_sales' => [
                'type' => 'ENUM',
                'constraint' => ['Y', 'N'],
                'default' => 'Y'
            ],
            'input_serial_number' => [
                'type' => 'ENUM',
                'constraint' => ['Y', 'N'],
                'default' => 'N'
            ],
            'deleted' => [
                'type' => 'ENUM',
                'constraint' => ['Y', 'N'],
                'default' => 'N'
            ],
        ]);
        $this->forge->addField('created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->forge->addKey('payment_method_id', TRUE);
        $this->forge->addKey(['payment_method_name', 'bank_account_name'], FALSE, TRUE);
        $this->forge->createTable('ms_payment_method');


        // Create last_record_number table //
        $this->forge->addField([
            'record_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'record_module' => [
                'type'          => 'VARCHAR',
                'constraint'    => '100',
            ],
            'store_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'default'        => 0
            ],
            'record_period' => [
                'type'          => 'VARCHAR',
                'constraint'    => '6',
                'default'       => '000000'
            ],
            'last_number'         => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
        ]);
        $this->forge->addField('created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');

        $this->forge->addKey('record_id', TRUE);
        $this->forge->addKey(['record_module', 'store_id', 'record_period'], FALSE, TRUE);
        $this->forge->createTable('last_record_number');
    }

    public function down()
    {
        //
        $this->forge->dropTable('last_record_number', true);
        $this->forge->dropTable('ms_payment_method', true);
    }
}
