<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InitDatabase extends Migration
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
    }

    public function down()
    {
        //
        $this->forge->dropTable('ms_category', true);
    }
}
