<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Salesman extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'salesman_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'salesman_code' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
            ],
            'salesman_name' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
            ],
            'salesman_address' => [
                'type' => 'TEXT',
                'constraint' => '500',
            ],
            'salesman_phone' => [
                'type' => 'VARCHAR',
                'constraint' => '15',
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
        $this->forge->addKey('salesman_id', TRUE);
        $this->forge->addKey('salesman_code', FALSE, TRUE);
        $this->forge->addKey('salesman_name', FALSE, FALSE);
        $this->forge->addForeignKey('store_id', 'ms_store', 'store_id');
        $this->forge->createTable('ms_salesman');
    }

    public function down()
    {
        //
        $this->forge->dropTable('ms_salesman', true);
    }
}
