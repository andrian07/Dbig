<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Auth extends Migration
{
    public function up()
    {
        // table ms_store //
        $this->forge->addField([
            'store_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'store_code' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
            ],
            'store_name' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
            ],
            'store_phone' => [
                'type' => 'VARCHAR',
                'constraint' => '15',
            ],
            'store_address' => [
                'type' => 'TEXT',
                'constraint' => '500',
            ],
            'store_api_key' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
            ],
            'deleted' => [
                'type' => 'ENUM',
                'constraint' => ['Y', 'N'],
                'default' => 'N'
            ],
        ]);
        $this->forge->addField('created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->forge->addKey('store_id', TRUE);
        $this->forge->addKey('store_code', FALSE, TRUE);
        $this->forge->addKey('store_name', FALSE, TRUE);
        $this->forge->addKey('store_api_key', FALSE, TRUE);
        $this->forge->createTable('ms_store');

        //Create user_group table//
        $this->forge->addField([
            'group_code' => [
                'type' => 'VARCHAR',
                'constraint' => '3',
            ],
            'group_name' => [
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
        $this->forge->addKey('group_code', TRUE);
        $this->forge->addKey('group_name', FALSE, TRUE);
        $this->forge->createTable('user_group');

        //Create user_role table//
        $this->forge->addField([
            'group_code' => [
                'type' => 'VARCHAR',
                'constraint' => '3',
            ],
            'module_name' => [
                'type' => 'VARCHAR',
                'constraint' => '30',
            ],
            'role_name' =>  [
                'type' => 'VARCHAR',
                'constraint' => '30',
            ],
            'role_value' => [
                'type' => 'VARCHAR',
                'constraint' => '1',
            ],
        ]);
        $this->forge->addField('created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->forge->addKey(['group_code', 'module_name', 'role_name'], FALSE, TRUE);
        $this->forge->addForeignKey('group_code', 'user_group', 'group_code');
        $this->forge->createTable('user_role');

        //Create user_account table//
        $this->forge->addField([
            'user_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'store_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true
            ],
            'user_code' => [
                'type' => 'VARCHAR',
                'constraint' => '4',
            ],
            'user_name' => [
                'type' => 'VARCHAR',
                'constraint' => '25',
            ],
            'user_realname' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
            ],
            'user_password' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
            ],
            'user_group' => [
                'type' => 'VARCHAR',
                'constraint' => '3',
            ],
            'user_fingerprint' => [
                'type' => 'BLOB',
                'null' => TRUE
            ],
            'active' => [
                'type' => 'ENUM',
                'constraint' => ['Y', 'N'],
                'default' => 'Y',
            ],
            'deleted' => [
                'type' => 'ENUM',
                'constraint' => ['Y', 'N'],
                'default' => 'N'
            ],
        ]);
        $this->forge->addField('created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->forge->addKey('user_id', TRUE);
        $this->forge->addKey('user_code', FALSE, TRUE);
        $this->forge->addKey('user_name', FALSE, TRUE);
        $this->forge->addForeignKey('user_group', 'user_group', 'group_code');
        $this->forge->addForeignKey('store_id', 'ms_store', 'store_id');
        $this->forge->createTable('user_account');
    }

    public function down()
    {
        $this->forge->dropTable('ms_store', true);
        $this->forge->dropTable('user_group', true);
        $this->forge->dropTable('user_role', true);
        $this->forge->dropTable('user_account', true);
    }
}
