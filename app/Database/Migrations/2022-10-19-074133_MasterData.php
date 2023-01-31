<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MasterData extends Migration
{
    public function up()
    {
        // Create category table //
        $this->forge->addField([
            'category_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'category_name' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
            ],
            'category_description' => [
                'type' => 'TEXT',
                'constraint' => '500',
            ],
            'G1_custom_point' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'G2_custom_point' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'G3_custom_point' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'G4_custom_point' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'G5_custom_point' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'G6_custom_point' => [
                'type' => 'DECIMAL',
                'constraint' => '25,2',
                'default' => 0.00
            ],
            'deleted' => [
                'type' => 'ENUM',
                'constraint' => ['Y', 'N'],
                'default' => 'N'
            ],
        ]);
        $this->forge->addField('created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->forge->addKey('category_id', TRUE);
        $this->forge->addKey('category_name', FALSE, TRUE);
        $this->forge->createTable('ms_category');

        // Create brand table //
        $this->forge->addField([
            'brand_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'brand_name' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
            ],
            'brand_description' => [
                'type' => 'TEXT',
                'constraint' => '500',
            ],
            'deleted' => [
                'type' => 'ENUM',
                'constraint' => ['Y', 'N'],
                'default' => 'N'
            ],
        ]);
        $this->forge->addField('created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->forge->addKey('brand_id', TRUE);
        $this->forge->addKey('brand_name', FALSE, TRUE);
        $this->forge->createTable('ms_brand');

        // Create unit table //
        $this->forge->addField([
            'unit_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'unit_name' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
            ],
            'unit_description' => [
                'type' => 'TEXT',
                'constraint' => '500',
            ],
            'deleted' => [
                'type' => 'ENUM',
                'constraint' => ['Y', 'N'],
                'default' => 'N'
            ],
        ]);
        $this->forge->addField('created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->forge->addKey('unit_id', TRUE);
        $this->forge->addKey('unit_name', FALSE, TRUE);
        $this->forge->createTable('ms_unit');
    }

    public function down()
    {
        //
        $this->forge->dropTable('ms_category', true);
        $this->forge->dropTable('ms_brand', true);
        $this->forge->dropTable('ms_unit', true);
    }
}
