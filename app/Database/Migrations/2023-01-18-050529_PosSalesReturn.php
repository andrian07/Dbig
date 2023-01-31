<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PosSalesReturn extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'pos_sales_return_id'    => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'pos_sales_return_invoice' => [
                'type' => 'VARCHAR',
                'constraint' => '25',
            ],
            'pos_sales_return_date' => [
                'type' => 'DATE',
            ],
            'pos_sales_id'    => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'customer_id'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'store_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true
            ],
            'pos_sales_return_remark' => [
                'type' => 'TEXT',
                'constraint' => '500',
            ],
            'pos_sales_return_total' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'customer_initial_point' => [
                'type' => 'DECIMAL',
                'constraint' => '8,2',
                'default' => 0.00
            ],
            'customer_reduce_point' => [
                'type' => 'DECIMAL',
                'constraint' => '8,2',
                'default' => 0.00
            ],
            'user_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'pos_sales_return_cancel' => [
                'type' => 'ENUM',
                'constraint' => ['Y', 'N'],
                'default' => 'N'
            ],
            'posted' => [
                'type' => 'ENUM',
                'constraint' => ['Y', 'N'],
                'default' => 'N'
            ],
        ]);
        $this->forge->addField('created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->forge->addKey('pos_sales_return_id', TRUE);
        $this->forge->addKey('pos_sales_return_invoice', FALSE, TRUE);
        $this->forge->addForeignKey('customer_id', 'ms_customer', 'customer_id');
        $this->forge->addForeignKey('pos_sales_id', 'hd_pos_sales', 'pos_sales_id');
        $this->forge->addForeignKey('store_id', 'ms_store', 'store_id');
        $this->forge->addForeignKey('user_id', 'user_account', 'user_id');
        $this->forge->createTable('hd_pos_sales_return');

        // Create dt_sales table //
        $this->forge->addField([
            'detail_id'          => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'pos_sales_return_id'  => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'item_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'sales_return_qty' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00
            ],
            'product_cogs'  => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'purchase_price'    => [
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
            'sales_return_price' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
        ]);

        $this->forge->addKey('detail_id', TRUE);
        $this->forge->addKey(['pos_sales_return_id', 'item_id'], FALSE, TRUE);
        $this->forge->addForeignKey('pos_sales_return_id', 'hd_pos_sales_return', 'pos_sales_return_id');
        $this->forge->addForeignKey('item_id', 'ms_product_unit', 'item_id');
        $this->forge->createTable('dt_pos_sales_return');


        // Create temp_sales table //
        $this->forge->addField([
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
            'max_return' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00
            ],
            'product_cogs' => [
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
            'temp_price' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'user_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
        ]);
        $this->forge->addField('created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->forge->addKey(['item_id', 'user_id'], TRUE);
        $this->forge->createTable('temp_pos_sales_return');
    }

    public function down()
    {
        $this->forge->dropTable('temp_pos_sales_return', true);
        $this->forge->dropTable('dt_pos_sales_return', true);
        $this->forge->dropTable('hd_pos_sales_return', true);
    }
}
