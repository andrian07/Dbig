<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class StockTransfer extends Migration
{
    public function up()
    {
        // Create hd_transfer_stock table //
        $this->forge->addField([
            'hd_transfer_stock_id'    => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'hd_transfer_stock_no' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'hd_transfer_stock_warehose_from' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'hd_transfer_stock_warehose_to' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'hd_transfer_stock_date' => [
                'type' => 'DATE',
            ],
            'hd_transfer_stock_remark' => [
                'type' => 'TEXT',
            ],
            'user_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
        ]);
        $this->forge->addField('created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->forge->addKey('hd_transfer_stock_id', TRUE);
        $this->forge->addKey('hd_transfer_stock_no', FALSE, FALSE);
        //$this->forge->addKey('hd_transfer_stock_warehose_from', FALSE, FALSE);
        //$this->forge->addKey('hd_transfer_stock_warehose_to', FALSE, FALSE);
        $this->forge->addForeignKey('user_id', 'user_account', 'user_id');
        $this->forge->createTable('hd_transfer_stock');

        // Create dt_transfer_stock table //
        $this->forge->addField([
            'dt_transfer_stock_id' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'hd_transfer_stock_id'  => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'item_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'item_qty' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00
            ],
        ]);
        //$this->forge->addField('created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('item_update_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->forge->addKey('dt_transfer_stock_id', TRUE);
        $this->forge->createTable('dt_transfer_stock');


        // Create temp_transfer_stock table //
        $this->forge->addField([
            'item_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'item_qty' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00
            ],
            'item_last_stock' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00
            ],
            'item_warehouse_from_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'item_warehouse_from_text' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
            ],
            'item_warehouse_destination_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'item_warehouse_destination_text' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
            ],
            'item_user_id'    => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
        ]);
        //$this->forge->addField('created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('item_update_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        //$this->forge->addKey('temp_sales_admin_id', TRUE);
        $this->forge->addKey('item_id', FALSE, FALSE);
        $this->forge->addKey('user_id', FALSE, FALSE);
        $this->forge->createTable('temp_transfer_stock');
    }

    public function down()
    {
        $this->forge->dropTable('temp_transfer_stock', true);
        $this->forge->dropTable('dt_transfer_stock', true);
        $this->forge->dropTable('hd_transfer_stock', true);
    }
}
