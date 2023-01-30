<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PaymentReceivable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'payment_receivable_id'    => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'payment_receivable_invoice' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'payment_receivable_customer_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'payment_receivable_total_invoice' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'payment_receivable_total_pay' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'payment_receivable_method_id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'payment_receivable_method_name' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
            ],
            'payment_receivable_date' => [
                'type' => 'DATE',
            ],
            'user_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
        ]);
        $this->forge->addField('create_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('update_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->forge->addKey('payment_receivable_id', TRUE);
        $this->forge->addKey('payment_receivable_invoice', FALSE, TRUE);
        $this->forge->addForeignKey('payment_receivable_customer_id', 'ms_customer', 'customer_id');
        $this->forge->addForeignKey('user_id', 'user_account', 'user_id');
        $this->forge->createTable('hd_payment_receivable');

        // Create dt_purchase table //
        $this->forge->addField([
            'dt_payment_receivablet_id' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'payment_receivable_id'  => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'dt_payment_receivable_sales_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'dt_payment_receivable_discount' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'dt_payment_receivable_desc' => [
                'type' => 'TEXT',
            ],
            'dt_payment_receivable_nominal' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
        ]);
        $this->forge->addField('created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        //$this->forge->addField('updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->forge->addKey('dt_payment_receivablet_id', TRUE);
        $this->forge->addForeignKey('payment_receivable_id', 'hd_payment_receivable', 'payment_receivable_id');
        $this->forge->addForeignKey('dt_payment_receivable_sales_id', 'ms_salesman', 'salesman_id');
        $this->forge->createTable('dt_payment_receivable');


        // Create temp_purchase table //
        $this->forge->addField([
            'temp_payment_receivable_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'temp_sales_nominal' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'temp_payment_receivable_sales_id' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
            ],

            'temp_payment_receivable_discount' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'temp_payment_receivable_nominal' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],

            'temp_payment_receivable_desc' => [
                'type' => 'TEXT'
            ],

            'temp_payment_receivable_user_id'    => [
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
        $this->forge->addKey('temp_payment_receivable_id', TRUE);
        $this->forge->addKey('temp_payment_receivable_user_id', FALSE, FALSE);
        $this->forge->createTable('temp_payment_receivable');
    }

    public function down()
    {
        $this->forge->dropTable('temp_payment_receivable', true);
        $this->forge->dropTable('dt_payment_receivable', true);
        $this->forge->dropTable('hd_payment_receivable', true);
    }
}
