<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DemoSeeder extends Seeder
{
    public function run()
    {
        // INSERT ms_unit //
        $units      = [];
        $units[]    = [
            'unit_id'           => 1,
            'unit_name'         => 'PCS',
            'unit_description'  => '-',
        ];
        $units[]    = [
            'unit_id'           => 2,
            'unit_name'         => 'DUS',
            'unit_description'  => '-',
        ];
        $units[]    = [
            'unit_id'           => 3,
            'unit_name'         => 'LSN',
            'unit_description'  => 'LUSIN = 12 PCS',
        ];
        $units[]    = [
            'unit_id'           => 4,
            'unit_name'         => 'KTK',
            'unit_description'  => 'KOTAK',
        ];
        $units[]    = [
            'unit_id'           => 5,
            'unit_name'         => 'PCK',
            'unit_description'  => 'PACK',
        ];
        $units[]    = [
            'unit_id'           => 6,
            'unit_name'         => 'KLG',
            'unit_description'  => 'KALENG',
        ];
        $this->db->table('ms_unit')->ignore(true)->insertBatch($units);


        // INSERT ms_brand //
        $brands     = [];
        $brands[]   = [
            'brand_id'          => 1,
            'brand_name'        => 'TOTO',
            'brand_description' => '-',
        ];
        $brands[]   = [
            'brand_id'          => 2,
            'brand_name'        => 'PHILIPS',
            'brand_description' => '-',
        ];
        $brands[]   = [
            'brand_id'          => 3,
            'brand_name'        => 'HEMMEN',
            'brand_description' => '-',
        ];
        $this->db->table('ms_brand')->ignore(true)->insertBatch($brands);

        // INSERT ms_category
        $categories = [];
        $categories[] = [
            'category_id'           => 1,
            'category_name'         => 'Elektronik',
            'category_description'  => 'Custom Point',
            'G1_custom_point'       => 0,
            'G2_custom_point'       => 120000,
            'G3_custom_point'       => 60000,
            'G4_custom_point'       => 35000,
            'G5_custom_point'       => 0,
            'G6_custom_point'       => 0,
        ];

        $categories[] = [
            'category_id'           => 2,
            'category_name'         => 'Floor Drain',
            'category_description'  => '-',
            'G1_custom_point'       => 0,
            'G2_custom_point'       => 0,
            'G3_custom_point'       => 0,
            'G4_custom_point'       => 0,
            'G5_custom_point'       => 0,
            'G6_custom_point'       => 0,
        ];

        $categories[] = [
            'category_id'           => 3,
            'category_name'         => 'Gantungan',
            'category_description'  => '-',
            'G1_custom_point'       => 0,
            'G2_custom_point'       => 0,
            'G3_custom_point'       => 0,
            'G4_custom_point'       => 0,
            'G5_custom_point'       => 0,
            'G6_custom_point'       => 0,
        ];
        $this->db->table('ms_category')->ignore(true)->insertBatch($categories);


        // INSERT ms_mapping_area
        $maps       = [];
        $maps[]     = [
            'mapping_id'        => 1,
            'mapping_code'      => 'A0001',
            'prov_id'           => 12,
            'city_id'           => 199,
            'dis_id'            => 5267,
            'subdis_id'         => 68603,
            'postal_code'       => '78391',
            'mapping_address'   => 'JL SERDAM, PTK'
        ];
        $maps[]     = [
            'mapping_id'        => 2,
            'mapping_code'      => 'A0002',
            'prov_id'           => 12,
            'city_id'           => 348,
            'dis_id'            => 4662,
            'subdis_id'         => 60106,
            'postal_code'       => '78113',
            'mapping_address'   => 'JL GAJAH MADA, PTK'
        ];
        $this->db->table('ms_mapping_area')->ignore(true)->insertBatch($maps);


        // INSERT ms_supplier
        $suppliers = [];
        $suppliers[] = [
            'supplier_id'           => 1,
            'supplier_code'         => 'PTMJ',
            'supplier_name'         => 'PT Makmur Jaya',
            'supplier_phone'        => '089988998899',
            'supplier_address'      => 'JL Serdam Komp.XYZ No.10',
            'mapping_id'            => 1,
            'supplier_npwp'         => '888888888888888888888',
            'supplier_remark'       => ''
        ];

        $suppliers[] = [
            'supplier_id'           => 2,
            'supplier_code'         => 'PDU',
            'supplier_name'         => 'PD Untung',
            'supplier_phone'        => '089988998877',
            'supplier_address'      => 'JL Serdam Komp.ABC No.5',
            'mapping_id'            => 1,
            'supplier_npwp'         => '',
            'supplier_remark'       => ''
        ];

        $suppliers[] = [
            'supplier_id'           => 3,
            'supplier_code'         => 'PDSJ',
            'supplier_name'         => 'PD Sumber Jaya',
            'supplier_phone'        => '089988998866',
            'supplier_address'      => 'JL Gajah Mada No.5',
            'mapping_id'            => 2,
            'supplier_npwp'         => '7777777777777777',
            'supplier_remark'       => ''
        ];

        $this->db->table('ms_supplier')->ignore(true)->insertBatch($suppliers);
    }
}
