<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Product extends Migration
{
    public function up()
    {
        // CREATE TABLE ms_warehouse
        $this->forge->addField([
            'warehouse_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'warehouse_code' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
            ],
            'warehouse_name' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
            ],
            'warehouse_address' => [
                'type' => 'TEXT',
                'constraint' => '500',
            ],
            'store_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true
            ],
            'deleted' => [
                'type' => 'ENUM',
                'constraint' => ['Y', 'N'],
                'default' => 'N'
            ],
        ]);
        $this->forge->addField('created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->forge->addKey('warehouse_id', TRUE);
        $this->forge->addKey('warehouse_code', FALSE, TRUE);
        $this->forge->addKey('warehouse_name', FALSE, TRUE);
        $this->forge->addForeignKey('store_id', 'ms_store', 'store_id');
        $this->forge->createTable('ms_warehouse');

        // Create Product 
        $this->forge->addField([
            'product_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'product_code' => [
                'type' => 'VARCHAR',
                'constraint' => '7',
            ],
            'product_name' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
            ],
            'category_id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'brand_id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'base_purchase_price' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'base_purchase_tax' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'base_cogs' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'product_description' => [
                'type' => 'TEXT',
                'constraint' => '500',
            ],
            'product_image' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'min_stock' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0.00
            ],
            'has_tax' => [
                'type' => 'ENUM',
                'constraint' => ['Y', 'N'],
                'default' => 'N'
            ],
            'is_parcel' => [
                'type' => 'ENUM',
                'constraint' => ['Y', 'N'],
                'default' => 'N'
            ],
            'active' => [
                'type' => 'ENUM',
                'constraint' => ['Y', 'N'],
                'default' => 'Y'
            ],
            'sales_point' => [
                'type' => 'ENUM',
                'constraint' => ['Y', 'N'],
                'default' => 'Y'
            ],
            'deleted' => [
                'type' => 'ENUM',
                'constraint' => ['Y', 'N'],
                'default' => 'N'
            ],
        ]);
        $this->forge->addField('created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->forge->addKey('product_id', TRUE);
        $this->forge->addKey('product_code', FALSE, TRUE);
        $this->forge->addKey('product_name', FALSE, TRUE);
        $this->forge->addForeignKey('category_id', 'ms_category', 'category_id');
        $this->forge->addForeignKey('brand_id', 'ms_brand', 'brand_id');
        $this->forge->createTable('ms_product');

        // Create product_supplier table //
        $this->forge->addField([
            'product_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'supplier_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ]
        ]);
        $this->forge->addKey(['product_id', 'supplier_id'], TRUE);
        $this->forge->addForeignKey('product_id', 'ms_product', 'product_id');
        $this->forge->addForeignKey('supplier_id', 'ms_supplier', 'supplier_id');
        $this->forge->createTable('ms_product_supplier');

        // Create product_unit table //
        $this->forge->addField([
            'item_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'item_code' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
            'product_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'unit_id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'base_unit' => [
                'type' => 'ENUM',
                'constraint' => ['Y', 'N'],
            ],
            'product_content' => [
                'type' => 'DECIMAL',
                'constraint' => '7,2',
                'default' => 1.00
            ],


            'G1_margin_rate' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'G1_sales_price' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],

            'G2_margin_rate' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'G2_sales_price' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],


            'G3_margin_rate' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'G3_sales_price' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],


            'G4_margin_rate' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'G4_sales_price' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],


            'G5_margin_rate' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'G5_sales_price' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],


            'G6_margin_rate' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'G6_sales_price' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],

            'disc_seasonal' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],

            'disc_start_date' => [
                'type' => 'DATE',
                'null' => TRUE
            ],
            'disc_end_date' => [
                'type' => 'DATE',
                'null' => TRUE
            ],


            'G1_disc_price' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'G1_promo_price' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],


            'G2_disc_price' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'G2_promo_price' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],

            'G3_disc_price' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'G3_promo_price' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],

            'G4_disc_price' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'G4_promo_price' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],


            'G5_disc_price' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'G5_promo_price' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],

            'G6_disc_price' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'G6_promo_price' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],

            'margin_allocation' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],

            'G1_margin_allocation' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'G2_margin_allocation' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'G3_margin_allocation' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'G4_margin_allocation' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'G5_margin_allocation' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'G6_margin_allocation' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'is_sale' => [
                'type' => 'ENUM',
                'constraint' => ['Y', 'N'],
                'default' => 'Y'
            ],
            'show_on_mobile_app' => [
                'type' => 'ENUM',
                'constraint' => ['Y', 'N'],
                'default' => 'Y'
            ],
            'allow_change_price' => [
                'type' => 'ENUM',
                'constraint' => ['Y', 'N'],
                'default' => 'N'
            ],
        ]);
        $this->forge->addField('created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->forge->addKey('item_id', TRUE);
        $this->forge->addKey('item_code', FALSE, TRUE);
        $this->forge->addForeignKey('product_id', 'ms_product', 'product_id');
        $this->forge->addForeignKey('unit_id', 'ms_unit', 'unit_id');
        $this->forge->createTable('ms_product_unit');


        $this->forge->addField([
            'product_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true
            ],

            'item_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'item_qty' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00
            ],
        ]);
        $this->forge->addField('created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->forge->addKey(['product_id', 'item_id'], TRUE);
        $this->forge->addForeignKey('product_id', 'ms_product', 'product_id');
        $this->forge->addForeignKey('item_id', 'ms_product_unit', 'item_id');
        $this->forge->createTable('ms_product_parcel');

        $this->forge->addField([
            'product_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'warehouse_id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'stock' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
        ]);
        $this->forge->addField('updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->forge->addKey(['product_id', 'warehouse_id'], TRUE);
        $this->forge->addForeignKey('product_id', 'ms_product', 'product_id');
        $this->forge->addForeignKey('warehouse_id', 'ms_warehouse', 'warehouse_id');
        $this->forge->createTable('ms_product_stock');


        // CREATE TABLE ms_warehouse_stock
        $this->forge->addField([
            'stock_id'          => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'product_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'warehouse_id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'purchase_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'exp_date'          => [
                'type'          => 'DATE',
                'null'          => TRUE
            ],
            'stock' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
        ]);

        $this->forge->addKey('stock_id', TRUE);
        $this->forge->addKey('purchase_id', FALSE, FALSE);
        $this->forge->addForeignKey('product_id', 'ms_product', 'product_id');
        $this->forge->addForeignKey('warehouse_id', 'ms_warehouse', 'warehouse_id');
        $this->forge->createTable('ms_warehouse_stock');

        $this->forge->addField([
            'item_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'product_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true
            ],
            'item_qty' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00
            ],
            'user_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true
            ],
            'temp_add' => [
                'type' => 'ENUM',
                'constraint' => ['Y', 'N'],
                'default' => 'N'
            ],
            'temp_delete' => [
                'type' => 'ENUM',
                'constraint' => ['Y', 'N'],
                'default' => 'N'
            ],
        ]);
        $this->forge->addKey(['item_id', 'product_id', 'user_id'], TRUE);
        $this->forge->createTable('temp_parcel');
    }

    public function down()
    {
        //
        $this->forge->dropTable('temp_parcel', true);
        $this->forge->dropTable('ms_warehouse_stock', true);
        $this->forge->dropTable('ms_product_stock', true);
        $this->forge->dropTable('ms_product_parcel', true);
        $this->forge->dropTable('ms_product_unit', true);
        $this->forge->dropTable('ms_product_supplier', true);
        $this->forge->dropTable('ms_product', true);
        $this->forge->dropTable('ms_warehouse', true);
    }
}
