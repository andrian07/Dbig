<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PurchaseConsignment extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'purchase_consignment_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'purchase_consignment_invoice' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'purchase_consignment_po' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'purchase_consignment_date' => [
                'type' => 'DATE',
            ],
            'purchase_consignment_supplier_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'purchase_consignment_user_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'purchase_consignment_warehouse_id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true
            ],
            'purchase_consignment_remark' => [
                'type' => 'TEXT',
            ],
        ]);
        $this->forge->addField('created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->forge->addKey('purchase_consignment_id', TRUE);
        $this->forge->addKey('purchase_consignment_invoice', FALSE, TRUE);
        // FK NAME TO LONG //
        //$this->forge->addForeignKey('purchase_order_consignment_supplier_id', 'ms_supplier', 'supplier_id', 'RESTRICT', 'RESTRICT', 'consigment_supplier_id');
        //$this->forge->addForeignKey('purchase_order_consignment_warehouse_id', 'ms_warehouse', 'warehouse_id', 'RESTRICT', 'RESTRICT', 'consigment_warehouse_id');
        //$this->forge->addForeignKey('purchase_order_consignment_user_id', 'user_account', 'user_id', 'RESTRICT', 'RESTRICT', 'consigment_user_id');

        // CHANGE TO INDEX //
        $this->forge->addKey('purchase_consignment_supplier_id', FALSE, FALSE);
        $this->forge->addKey('purchase_consignment_warehouse_id', FALSE, FALSE);
        $this->forge->addKey('purchase_consignment_user_id', FALSE, FALSE);
        $this->forge->createTable('hd_purchase_consignment');

        // Create dt_sales table //
        $this->forge->addField([
            'dt_consignment_id' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'dt_consignment_invoice'  => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],
            'dt_consignment_item_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'dt_consignment_qty' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00
            ],
            'dt_consignment_expire_date' => [
                'type'  => 'DATE',
                'null'  => true
            ],
        ]);
        // $this->forge->addField('dt_consignment_create_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('dt_consignment_update_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');

        $this->forge->addKey('dt_consignment_id', TRUE);
        $this->forge->addForeignKey('dt_consignment_item_id', 'ms_product_unit', 'item_id');
        $this->forge->createTable('dt_purchase_consignment');


        // Create temp_sales table //
        $this->forge->addField([
            'temp_consignment_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'temp_consignment_item_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'temp_consignment_qty' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00
            ],
            'temp_consignment_expire_date' => [
                'type'  => 'DATE',
                'null'  => true
            ],
            'temp_consignment_suplier_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'temp_consignment_suplier_name' => [
                'type'           => 'VARCHAR',
                'constraint'     => '250',
            ],
            'temp_consignment_user_id'  => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
        ]);
        $this->forge->addField('temp_consignment_create_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('temp_consignment_update_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->forge->addKey('temp_consignment_id', TRUE);
        $this->forge->createTable('temp_purchase_consignment');
    }

    public function down()
    {
        $this->forge->dropTable('temp_purchase_consignment', true);
        $this->forge->dropTable('dt_purchase_consignment', true);
        $this->forge->dropTable('hd_purchase_consignment', true);
    }
}
