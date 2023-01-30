<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Config extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'config_group' => [
                'type'          => 'VARCHAR',
                'constraint'    => '100',
                'default'       => 'default'
            ],
            'config_subgroup' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'config_name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'config_value' => [
                'type' => 'LONGTEXT',
            ]
        ]);
        $this->forge->addField('created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->forge->addKey(['config_group', 'config_subgroup', 'config_name'], FALSE, TRUE);
        $this->forge->createTable('ms_config');
    }

    public function down()
    {
        //
        $this->forge->dropTable('ms_config', true);
    }
}
