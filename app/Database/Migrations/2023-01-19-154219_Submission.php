<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Submission extends Migration
{
    public function up()
    {
        // Create hd_submission table //
        $this->forge->addField([
            'submission_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'submission_inv' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
            ],
            'submission_warehouse_id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'submission_type' => [
                'type' => 'ENUM',
                'constraint' => ['Konsinyasi', 'Pembelian'],
                'default' => 'Pembelian'
            ],
            'submission_item_id'  => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'submission_product_name' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
            ],
            'submission_qty' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'submission_item_status' => [
                'type' => 'ENUM',
                'constraint' => ['New', 'Restock', 'Urgent'],
                'default' => 'Restock'
            ],
            'submission_date' => [
                'type' => 'DATE',
            ],
            'submission_salesman_id'  => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'submission_desc' => [
                'type' => 'TEXT',
            ],
            'submission_admin_remark' => [
                'type' => 'TEXT',
            ],
            'submission_status' => [
                'type' => 'ENUM',
                'constraint' => ['Pending', 'Accept', 'Decline', 'Cancel'],
                'default' => 'Pending'
            ],
            'submission_user_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'deleted' => [
                'type' => 'ENUM',
                'constraint' => ['Y', 'N'],
                'default' => 'N'
            ],
        ]);
        $this->forge->addField('created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->forge->addKey('submission_id', TRUE);
        $this->forge->addKey('submission_item_id', FALSE, FALSE);
        $this->forge->addForeignKey('submission_warehouse_id', 'ms_warehouse', 'warehouse_id');
        $this->forge->addForeignKey('submission_salesman_id', 'ms_salesman', 'salesman_id');
        $this->forge->addForeignKey('submission_user_id', 'user_account', 'user_id');
        $this->forge->createTable('hd_submission');
    }

    public function down()
    {
        $this->forge->dropTable('hd_submission', true);
    }
}
