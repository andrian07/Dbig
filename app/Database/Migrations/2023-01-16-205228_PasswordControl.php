<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PasswordControl extends Migration
{
    public function up()
    {
        //Create password_control table//
        $this->forge->addField([
            'password_control_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'user_pin'  => [
                'type'          => 'VARCHAR',
                'constraint'    => '200',
                'null'          => true
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
        $this->forge->addKey('password_control_id', TRUE);
        $this->forge->addForeignKey('user_id', 'user_account', 'user_id');
        $this->forge->createTable('password_control');


        //Create password_control_log table//
        $this->forge->addField([
            'log_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'password_control_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'request_user_id'    => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'log_remark' => [
                'type' => 'TEXT',
                'constraint' => '500',
            ],
        ]);
        $this->forge->addField('log_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addKey('log_id', TRUE);
        $this->forge->addKey('password_control_id', FALSE, FALSE);
        $this->forge->createTable('log_password_control');
    }

    public function down()
    {
        //
        $this->forge->dropTable('log_password_control', true);
        $this->forge->dropTable('password_control', true);
    }
}
