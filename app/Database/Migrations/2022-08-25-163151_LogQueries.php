<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class LogQueries extends Migration
{
    protected $DBGroup = 'logs';

    public function up()
    {
        // Create hd_log_queries table //
        $this->forge->addField([
            'log_id' => [
                'type'              => 'BIGINT',
                'constraint'        => 20,
                'unsigned'          => true,
                'auto_increment'    => true
            ],
            'module' => [
                'type'              => 'VARCHAR',
                'constraint'        => '100',
            ],
            'ref_id' => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
            ],
            'log_remark' => [
                'type'              => 'VARCHAR',
                'constraint'        => '250',
            ],
            'user_id' => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
            ],
        ]);
        $this->forge->addField('created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->forge->addKey('log_id', TRUE);
        $this->forge->addKey('module', FALSE, FALSE);
        $this->forge->addKey('ref_id', FALSE, FALSE);
        $this->forge->addKey('user_id', FALSE, FALSE);
        $this->forge->createTable('hd_log_queries');

        // Create dt_log_queries table //
        $this->forge->addField([
            'detail_id'          => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'log_id'          => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
            ],
            'query_text' => [
                'type' => 'LONGTEXT',
            ],
        ]);
        $this->forge->addField('created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->forge->addKey('detail_id', TRUE);
        $this->forge->addForeignKey('log_id', 'hd_log_queries', 'log_id');
        $this->forge->createTable('dt_log_queries');
    }

    public function down()
    {
        //
        $this->forge->dropTable('dt_log_queries');
        $this->forge->dropTable('hd_log_queries');
    }
}
