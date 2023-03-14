<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitSeeder extends Seeder
{
    public function run()
    {
        // INSERT ms_store //
        $stores = [];
        $stores[] = [
            'store_id'          => 1,
            'store_code'        => 'UTM',
            'store_name'        => 'd\'BIG',
            'store_phone'       => '6281268880819',
            'store_address'     => 'Jl. Serdam No A2-A3-A4(Arah RS Soedarso)',
            'store_api_key'     => 'P1VUE5MDTOBJFKUTJYP81RTVJMJWHK8I'
        ];

        $stores[] = [
            'store_id'          => 2,
            'store_code'        => 'KBR',
            'store_name'        => 'd\'BIG (KOBAR)',
            'store_phone'       => '6281268880819',
            'store_address'     => 'Jl. Prof. M. Yamin No 5, Perempatan Jalan Ampera',
            'store_api_key'     => 'MEC5JRO1H38SKW2NHQHIX6LQYURIZ24V'
        ];

        $this->db->table('ms_store')->ignore(true)->insertBatch($stores);

        // INSERT user_group & user_account //
        $user_groups = [];
        $user_groups[] = [
            'group_code'    => 'L00',
            'group_name'    => 'OWNER'
        ];
        $this->db->table('user_group')->ignore(true)->insertBatch($user_groups);

        $user_accounts = [];
        $user_accounts[] = [
            'user_id'       => 1,
            'store_id'      => 1,
            'user_code'     => 'U000',
            'user_name'     => 'dbig22',
            'user_realname' => 'Owner',
            'user_password' => password_hash('12345678', PASSWORD_BCRYPT),
            'user_group'    => 'L00',
        ];
        $this->db->table('user_account')->ignore(true)->insertBatch($user_accounts);



        // INSERT ms_warehouse //
        $warehouse = [];
        $warehouse[] = [
            'warehouse_id'      => 1,
            'warehouse_code'    => 'UTM',
            'warehouse_name'    => 'Cabang Utama',
            'warehouse_address' => '-',
            'store_id'          => 1
        ];

        $warehouse[] = [
            'warehouse_id'      => 2,
            'warehouse_code'    => 'KBR',
            'warehouse_name'    => 'Cabang Kota Baru',
            'warehouse_address' => '-',
            'store_id'          => 2
        ];

        $warehouse[] = [
            'warehouse_id'      => 3,
            'warehouse_code'    => 'KNY',
            'warehouse_name'    => 'Gudang Konsinyasi',
            'warehouse_address' => '-',
            'store_id'          => 1
        ];

        $this->db->table('ms_warehouse')->ignore(true)->insertBatch($warehouse);



        // INSERT ms_customer //
        $customers = [];
        $customers[] = [
            'customer_id'       => 1,
            'customer_code'     => 'CASH',
            'customer_name'     => 'CASH',
            'customer_phone'    => '-',
            'customer_email'    => 'cash@dbig.com',
            'exp_date'          =>  '2050-12-12'
        ];
        $this->db->table('ms_customer')->ignore(true)->insertBatch($customers);


        // INSERT ms_payment_method //
        $payment = [];
        $payment[] = [
            'payment_method_id'         => 1,
            'store_id'                  => 0,
            'payment_method_name'       => 'CASH',
            'bank_account_name'         => '',
            'bank_account_number'       => '',
            'show_on_purchase'          => 'Y',
            'show_on_purchase_return'   => 'Y',
            'show_on_sales'             => 'Y',
            'input_serial_number'       => 'N',
        ];

        $payment[] = [
            'payment_method_id'         => 2,
            'store_id'                  => 0,
            'payment_method_name'       => 'VOUCHER',
            'bank_account_name'         => '',
            'bank_account_number'       => '',
            'show_on_purchase'          => 'N',
            'show_on_purchase_return'   => 'N',
            'show_on_sales'             => 'Y',
            'input_serial_number'       => 'Y',
        ];

        $payment[] = [
            'payment_method_id'         => 3,
            'store_id'                  => 1,
            'payment_method_name'       => 'BCA',
            'bank_account_name'         => 'DBIG',
            'bank_account_number'       => '1234567890123',
            'show_on_purchase'          => 'Y',
            'show_on_purchase_return'   => 'Y',
            'show_on_sales'             => 'Y',
            'input_serial_number'       => 'Y',
        ];

        $payment[] = [
            'payment_method_id'         => 4,
            'store_id'                  => 1,
            'payment_method_name'       => 'BNI',
            'bank_account_name'         => 'DBIG',
            'bank_account_number'       => '777777777777',
            'show_on_purchase'          => 'Y',
            'show_on_purchase_return'   => 'Y',
            'show_on_sales'             => 'Y',
            'input_serial_number'       => 'Y',
        ];

        $payment[] = [
            'payment_method_id'         => 5,
            'store_id'                  => 2,
            'payment_method_name'       => 'BCA',
            'bank_account_name'         => 'DBIG KOBAR',
            'bank_account_number'       => '8888888888888',
            'show_on_purchase'          => 'Y',
            'show_on_purchase_return'   => 'Y',
            'show_on_sales'             => 'Y',
            'input_serial_number'       => 'Y',
        ];

        $payment[] = [
            'payment_method_id'         => 6,
            'store_id'                  => 2,
            'payment_method_name'       => 'BNI',
            'bank_account_name'         => 'DBIG KOBAR',
            'bank_account_number'       => '9999999999999',
            'show_on_purchase'          => 'Y',
            'show_on_purchase_return'   => 'Y',
            'show_on_sales'             => 'Y',
            'input_serial_number'       => 'Y',
        ];

        $this->db->table('ms_payment_method')->ignore(true)->insertBatch($payment);

        // INSERT ms_config //
        $cfg = [];

        // -- CONFIG CUSTOMER GROUP -- //
        $cfg[] = [
            'config_group'      => 'default',
            'config_subgroup'   => 'customer_group',
            'config_name'       => 'G1',
            'config_value'      => 'UMUM'
        ];
        $cfg[] = [
            'config_group'      => 'default',
            'config_subgroup'   => 'label_customer_group',
            'config_name'       => 'G1',
            'config_value'      => '<span class="badge badge-info">Umum</span>'
        ];

        $cfg[] = [
            'config_group'      => 'default',
            'config_subgroup'   => 'customer_group',
            'config_name'       => 'G2',
            'config_value'      => 'SILVER'
        ];
        $cfg[] = [
            'config_group'      => 'default',
            'config_subgroup'   => 'label_customer_group',
            'config_name'       => 'G2',
            'config_value'      => '<span class="badge badge-light">Member Silver</span>'
        ];



        $cfg[] = [
            'config_group'      => 'default',
            'config_subgroup'   => 'customer_group',
            'config_name'       => 'G3',
            'config_value'      => 'GOLD'
        ];
        $cfg[] = [
            'config_group'      => 'default',
            'config_subgroup'   => 'label_customer_group',
            'config_name'       => 'G3',
            'config_value'      => '<span class="badge badge-warning">Member Gold</span>'
        ];

        $cfg[] = [
            'config_group'      => 'default',
            'config_subgroup'   => 'customer_group',
            'config_name'       => 'G4',
            'config_value'      => 'PLATINUM'
        ];
        $cfg[] = [
            'config_group'      => 'default',
            'config_subgroup'   => 'label_customer_group',
            'config_name'       => 'G4',
            'config_value'      => '<span class="badge badge-secondary">Member Platinum</span>'
        ];

        $cfg[] = [
            'config_group'      => 'default',
            'config_subgroup'   => 'customer_group',
            'config_name'       => 'G5',
            'config_value'      => 'PROYEK'
        ];
        $cfg[] = [
            'config_group'      => 'default',
            'config_subgroup'   => 'label_customer_group',
            'config_name'       => 'G5',
            'config_value'      => '<span class="badge badge-primary">Proyek</span>'
        ];

        $cfg[] = [
            'config_group'      => 'default',
            'config_subgroup'   => 'customer_group',
            'config_name'       => 'G6',
            'config_value'      => 'CUSTOM'
        ];
        $cfg[] = [
            'config_group'      => 'default',
            'config_subgroup'   => 'label_customer_group',
            'config_name'       => 'G6',
            'config_value'      => '<span class="badge bg-purple">Custom</span>'
        ];

        // -- CONFIG CUSTOMER POINT -- //
        $cfg[] = [
            'config_group'      => 'default',
            'config_subgroup'   => 'customer_point_value',
            'config_name'       => 'G2',
            'config_value'      => '100000'
        ];

        $cfg[] = [
            'config_group'      => 'default',
            'config_subgroup'   => 'customer_point_value',
            'config_name'       => 'G3',
            'config_value'      => '50000'
        ];

        $cfg[] = [
            'config_group'      => 'default',
            'config_subgroup'   => 'customer_point_value',
            'config_name'       => 'G4',
            'config_value'      => '25000'
        ];


        // -- CONFIG POS -- //
        $cfg[] = [
            'config_group'      => 'default',
            'config_subgroup'   => 'pos',
            'config_name'       => 'customer_id',
            'config_value'      => '1'
        ];

        $cfg[] = [
            'config_group'      => 'default',
            'config_subgroup'   => 'pos',
            'config_name'       => 'transaction_type_A_payment',
            'config_value'      => '1,2'
        ];

        foreach ($stores as $store) {
            $store_code     = $store['store_code'];
            $store_name     = $store['store_name'];
            $store_addr     = $store['store_address'];
            $store_phone    = $store['store_phone'];
            $WID            = $store['store_id'];

            $cfg[] = [
                'config_group'      => $store_code,
                'config_subgroup'   => 'pos',
                'config_name'       => 'warehouse_id',
                'config_value'      => $WID
            ];

            $cfg[] = [
                'config_group'      => $store_code,
                'config_subgroup'   => 'pos',
                'config_name'       => 'last_update',
                'config_value'      => '2010-01-01 00:00:00'
            ];

            $cfg[] = [
                'config_group'      => $store_code,
                'config_subgroup'   => 'pos',
                'config_name'       => 'last_sync',
                'config_value'      => '2010-01-01 00:00:00'
            ];

            $cfg[] = [
                'config_group'      => $store_code,
                'config_subgroup'   => 'pos',
                'config_name'       => 'receipt_header',
                'config_value'      => trim("$store_name\r\n$store_addr\r\nTelp.$store_phone")
            ];


            $cfg[] = [
                'config_group'      => $store_code,
                'config_subgroup'   => 'pos',
                'config_name'       => 'receipt_footer',
                'config_value'      => trim("BARANG YANG SUDAH DIBELI\nTIDAK DAPAT DIKEMBALIKAN\nTERIMA KASIH TELAH BERBELANJA\n--- INFO LENGKAP ---\nW: dbigdepo.com\nI: www.instagram.com/dbig.depo\nF: www.facebook.com/dbig.depo")
            ];
        }

        // -- OTHER CONFIG -- //
        $cfg[] = [
            'config_group'      => 'default',
            'config_subgroup'   => 'project',
            'config_name'       => 'customer_group',
            'config_value'      => 'G1'
        ];

        $cfg[] = [
            'config_group'      => 'default',
            'config_subgroup'   => 'consignment',
            'config_name'       => 'warehouse_id',
            'config_value'      => '3'
        ];

        $cfg[] = [
            'config_group'      => 'default',
            'config_subgroup'   => 'customer_group',
            'config_name'       => 'referral_point',
            'config_value'      => '20'
        ];

        $this->db->table('ms_config')->ignore(true)->insertBatch($cfg);
    }
}
