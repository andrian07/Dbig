<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Voucher extends Migration
{
    public function up()
    {
        // Create ms_voucher_group table //
        $this->forge->addField([
            'voucher_group_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'voucher_name' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
            ],
            'voucher_value' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'voucher_remark' => [
                'type' => 'TEXT',
                'constraint' => '500',
            ],
            'last_voucher_number' => [
                'type'           => 'INT',
                'constraint'     => 4,
                'unsigned'       => true,
                'default'        => 0
            ],
            'exp_date' => [
                'type' => 'DATE',
            ],
            'voucher_image_cover' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'voucher_image_backcover' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'deleted' => [
                'type' => 'ENUM',
                'constraint' => ['Y', 'N'],
                'default' => 'N'
            ],
        ]);

        $this->forge->addField('created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->forge->addKey('voucher_group_id', TRUE);
        $this->forge->createTable('ms_voucher_group');

        // Create ms_voucher table //
        $this->forge->addField([
            'voucher_id'          => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'voucher_group_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'voucher_code' => [
                'type' => 'VARCHAR',
                'constraint' => '12',
            ],
            'voucher_status' => [
                'type' => 'ENUM',
                'constraint' => ['not used', 'used', 'expired'],
                'default' => 'not used'
            ],
            'deleted' => [
                'type' => 'ENUM',
                'constraint' => ['Y', 'N'],
                'default' => 'N'
            ],
            'used_by'            => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'default'        => 0
            ],
            'used_at'           => [
                'type'          => 'DATETIME',
                'null'          => true
            ],
            'created_by'         => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
        ]);
        $this->forge->addField('created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->forge->addKey('voucher_id', TRUE);
        $this->forge->addKey('voucher_code', FALSE, TRUE);
        $this->forge->addKey('used_by', FALSE, FALSE);
        $this->forge->addForeignKey('voucher_group_id', 'ms_voucher_group', 'voucher_group_id');
        $this->forge->createTable('ms_voucher');

        // Create ms_voucher_category_restriction
        $this->forge->addField([
            'voucher_group_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'category_id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ]
        ]);

        $this->forge->addKey(['voucher_group_id', 'category_id'], TRUE);
        $this->forge->addForeignKey('voucher_group_id', 'ms_voucher_group', 'voucher_group_id');
        $this->forge->addForeignKey('category_id', 'ms_category', 'category_id');
        $this->forge->createTable('ms_voucher_category_restriction');

        // Create ms_voucher_brand_restriction
        $this->forge->addField([
            'voucher_group_id'   => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'brand_id'           => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ]
        ]);

        $this->forge->addKey(['voucher_group_id', 'brand_id'], TRUE);
        $this->forge->addForeignKey('voucher_group_id', 'ms_voucher_group', 'voucher_group_id');
        $this->forge->addForeignKey('brand_id', 'ms_brand', 'brand_id');
        $this->forge->createTable('ms_voucher_brand_restriction');
    }

    public function down()
    {
        //
        $this->forge->dropTable('ms_voucher_brand_restriction', true);
        $this->forge->dropTable('ms_voucher_category_restriction', true);
        $this->forge->dropTable('ms_voucher', true);
        $this->forge->dropTable('ms_voucher_group', true);
    }
}
