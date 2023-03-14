<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Purchase extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'purchase_id'    => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'purchase_invoice' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'purchase_po_invoice' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'purchase_suplier_no' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
            ],
            'purchase_date' => [
                'type' => 'DATE',
            ],
            'purchase_faktur_date' => [
                'type' => 'DATE',
            ],
            'purchase_supplier_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'purchase_user_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'purchase_warehouse_id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true
            ],
            'purchase_remark' => [
                'type' => 'TEXT',
            ],



            'purchase_sub_total' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],

            'purchase_discount1' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'purchase_discount1_percentage' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],

            'purchase_discount2' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'purchase_discount2_percentage' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],


            'purchase_discount3' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'purchase_discount3_percentage' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],

            'purchase_total_discount' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'purchase_total_dpp' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'purchase_total_ppn' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'purchase_total_ongkir' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'purchase_total' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'purchase_due_date' => [
                'type' => 'DATE',
            ],
            'purchase_payment_method_id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'purchase_down_payment' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'purchase_remaining_debt' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
        ]);
        $this->forge->addField('created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->forge->addKey('purchase_id', TRUE);
        $this->forge->addKey('purchase_invoice', FALSE, TRUE);
        $this->forge->addForeignKey('purchase_supplier_id', 'ms_supplier', 'supplier_id');
        $this->forge->addForeignKey('purchase_warehouse_id', 'ms_warehouse', 'warehouse_id');
        $this->forge->addForeignKey('purchase_user_id', 'user_account', 'user_id');
        $this->forge->addForeignKey('purchase_payment_method_id', 'ms_payment_method', 'payment_method_id');
        $this->forge->createTable('hd_purchase');

        // Create dt_purchase table //
        $this->forge->addField([
            'dt_purchase_id' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'dt_purchase_po_id'  => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'           => TRUE
            ],
            'dt_purchase_po_invoice' => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
                'null'           => TRUE
            ],
            'dt_purchase_invoice' => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
                'null'           => TRUE
            ],

            'dt_purchase_item_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'dt_purchase_qty' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00
            ],
            'dt_purchase_ppn' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'dt_purchase_dicount_nota' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'dt_purchase_dpp' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'dt_purchase_price' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'dt_purchase_discount1' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'dt_purchase_discount1_percentage' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'dt_purchase_discount2' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'dt_purchase_discount2_percentage' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'dt_purchase_discount3' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'dt_purchase_discount3_percentage' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'dt_purchase_discount_total' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'dt_purchase_ongkir' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'dt_purchase_expire_date' => [
                'type'  => 'DATE',
                'null'  => true
            ],
            'dt_purchase_total' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'dt_purchase_supplier_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'dt_purchase_supplier_name' => [
                'type'           => 'VARCHAR',
                'constraint'     => '250',
            ],
            'dt_purchase_user_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
        ]);
        // $this->forge->addField('dt_purchase_create_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('dt_purchase_update_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->forge->addKey('dt_purchase_id', TRUE);
        $this->forge->addForeignKey('dt_purchase_item_id', 'ms_product_unit', 'item_id');
        $this->forge->createTable('dt_purchase');


        // Create temp_purchase table //
        $this->forge->addField([
            'temp_purchase_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'temp_purchase_po_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'temp_purchase_po_invoice' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'temp_purchase_item_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'temp_purchase_qty' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00
            ],
            'temp_purchase_ppn' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'temp_purchase_dpp' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'temp_purchase_price' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'temp_purchase_discount1' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'temp_purchase_discount1_percentage' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'temp_purchase_discount2' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'temp_purchase_discount2_percentage' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'temp_purchase_discount3' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'temp_purchase_discount3_percentage' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'temp_purchase_discount_total' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'temp_purchase_ongkir' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'temp_purchase_expire_date' => [
                'type'  => 'DATE',
                'null'  => true
            ],
            'temp_purchase_total' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],

            'temp_purchase_supplier_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'temp_purchase_supplier_name' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
            ],
            'temp_purchase_user_id'    => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
        ]);
        $this->forge->addField('temp_purchase_create_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('temp_purchase_update_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->forge->addKey('temp_purchase_id', TRUE);
        $this->forge->createTable('temp_purchase');
    }

    public function down()
    {
        $this->forge->dropTable('temp_purchase', true);
        $this->forge->dropTable('dt_purchase', true);
        $this->forge->dropTable('hd_purchase', true);
    }
}
