<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MappingArea extends Migration
{
    public function up()
    {
        //
        // Create ms_mapping_area table //
        $this->forge->addField([
            'mapping_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'mapping_code' => [
                'type' => 'VARCHAR',
                'constraint' => '5',
            ],
            'prov_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'city_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'dis_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'subdis_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'postal_code' => [
                'type' => 'VARCHAR',
                'constraint' => '5',
            ],
            'mapping_address' => [
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
        $this->forge->addKey('mapping_id', TRUE);
        $this->forge->addKey('mapping_code', FALSE, TRUE);
        $this->forge->addKey('prov_id', FALSE, FALSE);
        $this->forge->addKey('city_id', FALSE, FALSE);
        $this->forge->addKey('dis_id', FALSE, FALSE);
        $this->forge->addKey('subdis_id', FALSE, FALSE);
        $this->forge->addKey('mapping_address', FALSE, FALSE);
        $this->forge->createTable('ms_mapping_area');
    }

    public function down()
    {
        //
        $this->forge->dropTable('ms_mapping_area', true);
    }
}
