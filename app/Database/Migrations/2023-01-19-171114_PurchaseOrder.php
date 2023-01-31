<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PurchaseOrder extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'purchase_order_id'    => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'purchase_order_invoice' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'purchase_order_date' => [
                'type' => 'DATE',
            ],
            'purchase_order_supplier_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'purchase_order_user_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'purchase_order_warehouse_id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true
            ],

            'purchase_order_status' => [
                'type' => 'ENUM',
                'constraint' => ['Pending', 'Selesai', 'Batal'],
                'default' => 'Pending'
            ],
            'purchase_order_remark' => [
                'type' => 'TEXT',
            ],
            'purchase_order_item_status' => [
                'type' => 'TEXT',
            ],

            'purchase_order_sub_total' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],

            'purchase_order_discount1' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'purchase_order_discount1_percentage' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],

            'purchase_order_discount2' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'purchase_order_discount2_percentage' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],

            'purchase_order_discount3' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'purchase_order_discount3_percentage' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],

            'purchase_order_total_discount' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'purchase_order_total_dpp' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'purchase_order_total_ppn' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'purchase_order_total_ongkir' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'purchase_order_total' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
        ]);
        $this->forge->addField('created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->forge->addKey('purchase_order_id', TRUE);
        $this->forge->addKey('purchase_order_invoice', FALSE, TRUE);
        $this->forge->addForeignKey('purchase_order_supplier_id', 'ms_supplier', 'supplier_id');
        $this->forge->addForeignKey('purchase_order_warehouse_id', 'ms_warehouse', 'warehouse_id');
        $this->forge->addForeignKey('purchase_order_user_id', 'user_account', 'user_id');
        $this->forge->createTable('hd_purchase_order');

        // Create dt_sales table //
        $this->forge->addField([
            'detail_purchase_order_id' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'purchase_order_id'  => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'detail_submission_id'  => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'detail_submission_invoice' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'detail_purchase_po_item_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'detail_purchase_po_qty' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00
            ],
            'detail_purchase_po_ppn' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'detail_purchase_po_dpp' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'detail_purchase_po_price' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'detail_purchase_po_discount1' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'detail_purchase_po_discount1_percentage' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'detail_purchase_po_discount2' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'detail_purchase_po_discount2_percentage' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'detail_purchase_po_discount3' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'detail_purchase_po_discount3_percentage' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'detail_purchase_po_total_discount' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'detail_purchase_po_ongkir' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'detail_purchase_po_expire_date' => [
                'type'  => 'DATE',
                'null'  => true
            ],

            'detail_purchase_po_total' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
        ]);
        // $this->forge->addField('detail_purchase_po_create_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('detail_purchase_po_update_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');

        $this->forge->addKey('detail_purchase_order_id', TRUE);
        $this->forge->addForeignKey('purchase_order_id', 'hd_pos_sales_return', 'pos_sales_return_id');
        $this->forge->addForeignKey('detail_purchase_po_item_id', 'ms_product_unit', 'item_id');
        $this->forge->createTable('dt_purchase_order');


        // Create temp_sales table //
        $this->forge->addField([
            'temp_po_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'temp_po_submission_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'temp_po_submission_invoice' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'temp_po_item_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'temp_po_qty' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00
            ],
            'temp_po_ppn' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'temp_po_dpp' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'temp_po_price' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'temp_po_discount1' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'temp_po_discount1_percentage' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'temp_po_discount2' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'temp_po_discount2_percentage' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'temp_po_discount3' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'temp_po_discount3_percentage' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'temp_po_discount_total' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'temp_po_ongkir' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'temp_po_expire_date' => [
                'type'  => 'DATE',
                'null'  => true
            ],
            'temp_po_total' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],

            'temp_po_supplier_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'temp_po_supplier_name' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
            ],
            'temp_po_user_id'    => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
        ]);
        $this->forge->addField('temp_po_create_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('temp_po_update_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->forge->addKey('temp_po_id', TRUE);
        $this->forge->createTable('temp_purchase_order');
    }

    public function down()
    {
        $this->forge->dropTable('temp_purchase_order', true);
        $this->forge->dropTable('dt_purchase_order', true);
        $this->forge->dropTable('hd_purchase_order', true);
    }
}
