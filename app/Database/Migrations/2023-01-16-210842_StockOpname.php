<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class StockOpname extends Migration
{
    public function up()
    {
        //Create Table hd_opname
        $this->forge->addField([
            'opname_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'opname_code' => [
                'type' => 'VARCHAR',
                'constraint' => '25',
            ],
            'opname_date' => [
                'type' => 'DATE',
            ],
            'warehouse_id'        => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'opname_total' => [
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
        $this->forge->addKey('opname_id', TRUE);
        $this->forge->addKey('opname_code', FALSE, TRUE);
        $this->forge->addForeignKey('warehouse_id', 'ms_warehouse', 'warehouse_id');
        $this->forge->addForeignKey('user_id', 'user_account', 'user_id');
        $this->forge->createTable('hd_opname');

        //Create Table dt_opname
        $this->forge->addField([
            'detail_id'          => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'opname_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'product_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'detail_remark' => [
                'type' => 'TEXT',
                'constraint' => '500',
            ],
            'exp_date' => [
                'type'  => 'DATE',
                'null'  => TRUE,
            ],
            'warehouse_stock' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00
            ],
            'system_stock' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00
            ],
            'base_cogs' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'opname_stock_difference' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],

        ]);
        $this->forge->addKey('detail_id', TRUE);
        $this->forge->addForeignKey('product_id', 'ms_product', 'product_id');
        $this->forge->addForeignKey('opname_id', 'hd_opname', 'opname_id');
        $this->forge->createTable('dt_opname');

        //Create Table temp_opname
        $this->forge->addField([
            'product_key'      => [
                'type'          => 'VARCHAR',
                'constraint'    => '32',
            ],
            'product_id'           => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'stock_id'          => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'default'        => 0,
            ],
            'warehouse_id'      => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'temp_warehouse_stock' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00
            ],
            'temp_system_stock' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00
            ],
            'temp_base_cogs' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'temp_stock_difference' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'temp_exp_date' => [
                'type'  => 'DATE',
                'null'  => TRUE,
            ],
            'temp_detail_remark' => [
                'type' => 'TEXT',
                'constraint' => '500',
            ],
            'user_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'temp_add'          => [
                'type' => 'ENUM',
                'constraint' => ['Y', 'N'],
                'default' => 'Y'
            ],
        ]);
        $this->forge->addField('updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->forge->addKey('product_key', TRUE);
        $this->forge->createTable('temp_opname');
    }

    public function down()
    {
        $this->forge->dropTable('temp_opname', true);
        $this->forge->dropTable('dt_opname', true);
        $this->forge->dropTable('hd_opname', true);
    }
}
