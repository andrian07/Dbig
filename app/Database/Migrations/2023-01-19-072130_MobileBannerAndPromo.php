<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MobileBannerAndPromo extends Migration
{
    public function up()
    {
        // Create ms_mobile_banner table //
        $this->forge->addField([
            'mobile_banner_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'mobile_banner_title' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
            ],
            'mobile_banner_image' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
            ],
            'active' => [
                'type' => 'ENUM',
                'constraint' => ['Y', 'N'],
                'default' => 'Y'
            ],
            'deleted' => [
                'type' => 'ENUM',
                'constraint' => ['Y', 'N'],
                'default' => 'N'
            ],
        ]);

        $this->forge->addField('created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->forge->addKey('mobile_banner_id', TRUE);
        $this->forge->createTable('ms_mobile_banner');

        // Create ms_mobile_promo table //
        $this->forge->addField([
            'mobile_promo_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'mobile_promo_title' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
            ],
            'mobile_promo_image' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
            ],
            'mobile_promo_desc' => [
                'type' => 'TEXT',
            ],
            'mobile_promo_start_date' => [
                'type' => 'DATE',
            ],
            'mobile_promo_end_date' => [
                'type' => 'DATE',
            ],
            'active' => [
                'type' => 'ENUM',
                'constraint' => ['Y', 'N'],
                'default' => 'Y'
            ],
            'deleted' => [
                'type' => 'ENUM',
                'constraint' => ['Y', 'N'],
                'default' => 'N'
            ],
        ]);

        $this->forge->addField('created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->forge->addKey('mobile_promo_id', TRUE);
        $this->forge->createTable('ms_mobile_promo');
    }

    public function down()
    {
        $this->forge->dropTable('ms_mobile_promo', true);
        $this->forge->dropTable('ms_mobile_banner', true);
    }
}
