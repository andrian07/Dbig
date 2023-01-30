<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PaymentDebt extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'payment_debt_id'    => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'payment_debt_invoice' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'purchase_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'payment_debt_supplier_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'payment_debt_total_invoice' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'payment_debt_total_pay' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'payment_debt_method_id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'payment_debt_method_name' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
            ],
            'payment_debt_date' => [
                'type' => 'DATE',
            ],
            'user_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
        ]);
        $this->forge->addField('created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->forge->addKey('payment_debt_id', TRUE);
        $this->forge->addKey('payment_debt_invoice', FALSE, TRUE);
        $this->forge->addForeignKey('payment_debt_supplier_id', 'ms_supplier', 'supplier_id');
        $this->forge->addForeignKey('user_id', 'user_account', 'user_id');
        $this->forge->createTable('hd_payment_debt');

        // Create dt_purchase table //
        $this->forge->addField([
            'dt_payment_debt_id' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'payment_debt_id'  => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'dt_payment_debt_purchase_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'dt_payment_debt_discount' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'dt_payment_debt_desc' => [
                'type' => 'TEXT',
            ],
            'dt_payment_debt_nominal' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
        ]);
        $this->forge->addField('created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        //$this->forge->addField('updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->forge->addKey('dt_payment_debt_id', TRUE);
        $this->forge->addForeignKey('payment_debt_id', 'hd_payment_debt', 'payment_debt_id');
        $this->forge->createTable('dt_payment_debt');


        // Create temp_purchase table //
        $this->forge->addField([
            'temp_payment_debt_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'temp_purchase_nominal' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'temp_payment_debt_purchase_id' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
            ],

            'temp_payment_debt_discount' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'temp_payment_debt_nominal' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],

            'temp_payment_debt_desc' => [
                'type' => 'TEXT'
            ],

            'temp_payment_debt_user_id'    => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'temp_payment_isedit' => [
                'type' => 'ENUM',
                'constraint' => ['Y', 'N'],
                'default' => 'N'
            ],
        ]);
        $this->forge->addField('created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->forge->addKey('temp_payment_debt_id', TRUE);
        $this->forge->addKey('temp_payment_debt_user_id', FALSE, FALSE);
        $this->forge->createTable('temp_payment_debt');
    }

    public function down()
    {
        $this->forge->dropTable('temp_payment_debt', true);
        $this->forge->dropTable('dt_payment_debt', true);
        $this->forge->dropTable('hd_payment_debt', true);
    }
}
