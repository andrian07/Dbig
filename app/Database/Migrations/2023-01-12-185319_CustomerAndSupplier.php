<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CustomerAndSupplier extends Migration
{
    public function up()
    {
        // Create customer table //
        $this->forge->addField([
            'customer_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'customer_code' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
            ],
            'customer_name' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
            ],
            'customer_phone' => [
                'type' => 'VARCHAR',
                'constraint' => '15',
            ],
            'customer_email'    => [
                'type' => 'VARCHAR',
                'constraint' => '200',
            ],
            'customer_password' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
            ],
            'customer_address' => [
                'type' => 'TEXT',
                'constraint' => '500',
            ],
            'customer_point' => [
                'type' => 'DECIMAL',
                'constraint' => '8,2',
                'default' => 0.00
            ],
            'customer_group' => [
                'type' => 'ENUM',
                'constraint' => ['G1', 'G2', 'G3', 'G4', 'G5', 'G6'],
                'default' => 'G1'
            ],
            'customer_gender' => [
                'type' => 'ENUM',
                'constraint' => ['P', 'L'],
                'default' => 'L'
            ],
            'customer_birth_date' => [
                'type'  => 'DATE',
                'null'  => TRUE
            ],
            'customer_job' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
            ],
            'salesman_id'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'default'        => 0,
            ],
            'customer_remark' => [
                'type' => 'TEXT',
                'constraint' => '500',
            ],
            'customer_delivery_address' => [
                'type' => 'TEXT',
                'constraint' => '500',
            ],
            'customer_npwp' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'customer_nik' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'customer_tax_invoice_name' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
            ],
            'customer_tax_invoice_address' => [
                'type' => 'TEXT',
                'constraint' => '500',
            ],
            'mapping_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'default'        => 0,
            ],
            'exp_date' => [
                'type' => 'DATE',
            ],
            'referral_code' => [
                'type' => 'VARCHAR',
                'constraint' => '6',
            ],
            'invite_by_referral_code' => [
                'type' => 'VARCHAR',
                'constraint' => '6',
            ],
            'verification_email' => [
                'type' => 'ENUM',
                'constraint' => ['Y', 'N'],
                'default' => 'N'
            ],
            'last_login' => [
                'type'  => 'DATETIME',
                'null'  => TRUE
            ],
            'active' => [
                'type' => 'ENUM',
                'constraint' => ['Y', 'N'],
                'default' => 'N'
            ],
            'deleted' => [
                'type' => 'ENUM',
                'constraint' => ['Y', 'N'],
                'default' => 'N'
            ],
        ]);
        $this->forge->addField('created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->forge->addKey('customer_id', TRUE);
        $this->forge->addKey('customer_code', FALSE, TRUE);
        $this->forge->addKey('customer_email', FALSE, TRUE);
        $this->forge->addKey('referral_code', FALSE, TRUE);
        $this->forge->addKey('mapping_id', FALSE, FALSE);
        $this->forge->addKey('salesman_id', FALSE, FALSE);
        $this->forge->createTable('ms_customer');


        // Create customer_history_point //
        $this->forge->addField([
            'log_point_id'          => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'customer_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'log_point_remark' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'customer_point' => [
                'type' => 'DECIMAL',
                'constraint' => '8,2',
                'default' => 0.00
            ]
        ]);

        $this->forge->addField('created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addKey('log_point_id', TRUE);
        $this->forge->addForeignKey('customer_id', 'ms_customer', 'customer_id');
        $this->forge->createTable('customer_history_point');



        // Create supplier table //
        $this->forge->addField([
            'supplier_id'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'supplier_code' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
            ],
            'supplier_name' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
            ],
            'supplier_phone' => [
                'type' => 'VARCHAR',
                'constraint' => '15',
            ],
            'supplier_address' => [
                'type' => 'TEXT',
                'constraint' => '500',
            ],
            'mapping_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'supplier_npwp' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
            ],
            'supplier_remark' => [
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
        $this->forge->addKey('supplier_id', TRUE);
        $this->forge->addKey('supplier_name', FALSE, TRUE);
        $this->forge->addForeignKey('mapping_id', 'ms_mapping_area', 'mapping_id');
        $this->forge->createTable('ms_supplier');
    }

    public function down()
    {
        //
        $this->forge->dropTable('customer_history_point', true);
        $this->forge->dropTable('ms_customer', true);
        $this->forge->dropTable('ms_supplier', true);
    }
}
