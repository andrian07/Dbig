<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PosSales extends Migration
{
    public function up()
    {
        // Create hd_pos_sales table //
        $this->forge->addField([
            'pos_sales_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'pos_sales_invoice' => [
                'type' => 'VARCHAR',
                'constraint' => '25',
            ],
            'pos_sales_date' => [
                'type' => 'DATE',
            ],
            'pos_sales_type' => [
                'type' => 'ENUM',
                'constraint' => ['A', 'B'],
                'default' => 'A'
            ],
            'customer_id'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'customer_group' => [
                'type' => 'ENUM',
                'constraint' => ['G1', 'G2', 'G3', 'G4', 'G5', 'G6'],
                'default' => 'G1'
            ],
            'store_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true
            ],
            'pos_sales_remark' => [
                'type' => 'TEXT',
                'constraint' => '500',
            ],
            'pos_sales_total' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'pos_total_payment' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'pos_total_margin_allocation' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'customer_initial_point' => [
                'type' => 'DECIMAL',
                'constraint' => '8,2',
                'default' => 0.00
            ],
            'customer_add_point' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'payment_list' => [
                'type'          => 'VARCHAR',
                'constraint'    => '255'
            ],
            'payment_remark' => [
                'type'          => 'VARCHAR',
                'constraint'    => '255'
            ],
            'user_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'has_sales_return' => [
                'type' => 'ENUM',
                'constraint' => ['Y', 'N'],
                'default' => 'N'
            ],
            'pos_sales_cancel' => [
                'type' => 'ENUM',
                'constraint' => ['Y', 'N'],
                'default' => 'N'
            ],
        ]);
        $this->forge->addField('created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->forge->addKey('pos_sales_id', TRUE);
        $this->forge->addKey('pos_sales_invoice', FALSE, TRUE);
        $this->forge->addForeignKey('customer_id', 'ms_customer', 'customer_id');
        $this->forge->addForeignKey('store_id', 'ms_store', 'store_id');
        $this->forge->addForeignKey('user_id', 'user_account', 'user_id');
        $this->forge->createTable('hd_pos_sales');

        // Create dt_pos_sales_payment //
        $this->forge->addField([
            'detail_id'          => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'pos_sales_id'       => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'payment_method_id'  => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'payment_card_number' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'payment_appr_code' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'payment_balance' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'payment_remark' => [
                'type' => 'TEXT',
                'constraint' => '500',
            ],
        ]);
        $this->forge->addField('created_at DATETIME DEFAULT CURRENT_TIMESTAMP');

        $this->forge->addKey('detail_id',  TRUE);
        $this->forge->createTable('dt_pos_sales_payment');


        //Create dt_pos_sales
        $this->forge->addField([
            'detail_id'          => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'pos_sales_id'  => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'item_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'sales_qty' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00
            ],
            'product_cogs'   => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'purchase_price' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'product_price' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'disc' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'default' => 0.00
            ],
            'price_disc' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'sales_price' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'sales_dpp' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'sales_ppn' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'margin_allocation' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'salesman_id'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
        ]);
        $this->forge->addField('created_at DATETIME DEFAULT CURRENT_TIMESTAMP');

        $this->forge->addKey('detail_id', TRUE);
        $this->forge->addKey(['pos_sales_id', 'item_id'], FALSE, TRUE);
        $this->forge->addForeignKey('pos_sales_id', 'hd_pos_sales', 'pos_sales_id');
        $this->forge->addForeignKey('item_id', 'ms_product_unit', 'item_id');
        $this->forge->createTable('dt_pos_sales');

        // Create temp_pos_sales table //
        $this->forge->addField([
            'queue_key'          => [
                'type'           => 'VARCHAR',
                'constraint'     => '6',
            ],
            'item_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'temp_qty' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00
            ],
            'temp_purchase_price' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'temp_purchase_tax' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'temp_product_price' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'temp_disc' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'default' => 0.00
            ],
            'temp_price_disc' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'temp_sales_price' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'temp_sales_dpp' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'temp_sales_ppn' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'salesman_id'      => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'user_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
        ]);
        $this->forge->addKey(['queue_key', 'item_id', 'user_id'], TRUE);
        $this->forge->addField('created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->forge->createTable('temp_pos_sales');

        // Create temp_pos_voucher table //
        $this->forge->addField([
            'queue_key'          => [
                'type'           => 'VARCHAR',
                'constraint'     => '6',
            ],
            'voucher_id'          => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
            ],
            'temp_voucher_code'          => [
                'type'           => 'VARCHAR',
                'constraint'     => '50',
            ],
            'temp_voucher_name'          => [
                'type' => 'VARCHAR',
                'constraint' => '200',
            ],
            'temp_voucher_value' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'temp_voucher_remark' => [
                'type' => 'TEXT',
                'constraint' => '500',
            ],
            'user_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
        ]);
        $this->forge->addKey(['queue_key', 'voucher_id', 'user_id'], TRUE);
        $this->forge->addField('created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->forge->createTable('temp_pos_voucher');
    }

    public function down()
    {
        $this->forge->dropTable('temp_pos_voucher', true);
        $this->forge->dropTable('temp_pos_sales', true);
        $this->forge->dropTable('dt_pos_sales', true);
        $this->forge->dropTable('dt_pos_sales_payment', true);
        $this->forge->dropTable('hd_pos_sales', true);
    }
}
