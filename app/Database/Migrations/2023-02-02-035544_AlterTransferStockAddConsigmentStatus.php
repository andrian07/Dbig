<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTransferStockAddConsigmentStatus extends Migration
{
    public function up()
    {
        $fields = [
            'hd_transfer_stock_consignment_status' => [
                'type' => 'ENUM',
                'constraint' => ['Lunas', 'Pending'],
                'default' => 'Pending',
                'after' => 'hd_transfer_stock_remark',
                'null' => true
            ]
        ];
        $this->forge->addColumn('hd_transfer_stock', $fields);

        $fields = [
            'is_consignment' => [
                'type' => 'ENUM',
                'constraint' => ['Y', 'N'],
                'default' => 'N',
                'after' => 'hd_transfer_stock_consignment_status',
                'null' => true
            ]
        ];
        $this->forge->addColumn('hd_transfer_stock', $fields);
    }

    public function down()
    {
        //
    }
}
