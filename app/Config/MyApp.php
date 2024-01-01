<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class MyApp extends BaseConfig
{
    public $allowedHosts        = ['localhost', 'dashboard-dbig.com'];
    public $uploadFileType      = [
        'image' => ['jpg', 'jpeg', 'png']
    ];

    public $userRole = [
        'dashboard' => [
            'text'   => 'Dasbor',
            'roles'   => [
                'view'   => ['text' => 'Lihat'],
            ]
        ],
        'find_product' => [
            'text'   => 'Cari Produk',
            'roles'   => [
                'view'   => ['text' => 'Lihat'],
            ]
        ],
        'brand' => [
            'text'   => 'Brand',
            'roles'   => [
                'view'   => ['text' => 'Lihat'],
                'add'    => ['text' => 'Tambah'],
                'edit'   => ['text' => 'Ubah'],
                'delete' => ['text' => 'Hapus'],
            ]
        ],
        'category' => [
            'text'   => 'Kategori',
            'roles'   => [
                'view'   => ['text' => 'Lihat'],
                'add'    => ['text' => 'Tambah'],
                'edit'   => ['text' => 'Ubah'],
                'delete' => ['text' => 'Hapus'],
            ]
        ],
        'unit' => [
            'text'   => 'Satuan',
            'roles'   => [
                'view'   => ['text' => 'Lihat'],
                'add'    => ['text' => 'Tambah'],
                'edit'   => ['text' => 'Ubah'],
                'delete' => ['text' => 'Hapus'],
            ]
        ],
        'warehouse' => [
            'text'   => 'Gudang',
            'roles'   => [
                'view'      => ['text' => 'Lihat'],
                'add'       => ['text' => 'Tambah'],
                'edit'      => ['text' => 'Ubah'],
                'delete'    => ['text' => 'Hapus'],
            ]
        ],
        'product' => [
            'text'   => 'Produk',
            'roles'   => [
                'view'      => ['text' => 'Lihat'],
                'manage'    => ['text' => 'Tambah/Ubah'],
                'delete'    => ['text' => 'Hapus'],
            ]
        ],
        'supplier' => [
            'text'   => 'Supplier',
            'roles'   => [
                'view'   => ['text' => 'Lihat'],
                'add'    => ['text' => 'Tambah'],
                'edit'   => ['text' => 'Ubah'],
                'delete' => ['text' => 'Hapus'],
            ]
        ],
        'customer' => [
            'text'   => 'Customer',
            'roles'   => [
                'view'              => ['text' => 'Lihat'],
                'add'               => ['text' => 'Tambah'],
                'edit'              => ['text' => 'Ubah'],
                'delete'            => ['text' => 'Hapus'],
                'reset_password'    => ['text' => 'Reset Password'],
            ]
        ],
        'mapping_area' => [
            'text'   => 'Mapping Area',
            'roles'   => [
                'view'   => ['text' => 'Lihat'],
                'add'    => ['text' => 'Tambah'],
                'edit'   => ['text' => 'Ubah'],
                'delete' => ['text' => 'Hapus'],
            ]
        ],
        'salesman' => [
            'text'   => 'Salesman',
            'roles'   => [
                'view'      => ['text' => 'Lihat'],
                'add'       => ['text' => 'Tambah'],
                'edit'      => ['text' => 'Ubah'],
                'delete'    => ['text' => 'Hapus'],
            ]
        ],

        'voucher'       => [
            'text'      => 'Voucher',
            'roles'     => [
                'view'              => ['text' => 'Lihat'],
                'add'               => ['text' => 'Tambah'],
                'edit'              => ['text' => 'Ubah'],
                'delete'            => ['text' => 'Hapus'],
                'generate_voucher'  => ['text' => 'Generate Voucher']
            ]
        ],

        'stock_opname' => [
            'text'   => 'Stok Opname',
            'roles'   => [
                'view'   => ['text' => 'Lihat'],
                'add'    => ['text' => 'Tambah'],
            ]
        ],

        'transfer_stock' => [
            'text'   => 'Transfer Stock',
            'roles'   => [
                'view'          => ['text' => 'Lihat'],
                'add'           => ['text' => 'Tambah'],
                'edit'          => ['text' => 'Ubah'],
            ]
        ],


        'point_reward' => [
            'text'   => 'Hadiah Point',
            'roles'   => [
                'view'   => ['text' => 'Lihat'],
                'add'    => ['text' => 'Tambah'],
                'edit'   => ['text' => 'Ubah'],
                'delete' => ['text' => 'Hapus'],
            ]
        ],

        'point_exchange' => [
            'text'   => 'Tukar Point',
            'roles'   => [
                'view'   => ['text' => 'Lihat'],
                'add_point' => ['text' => 'Tambah Poin'],
            ]
        ],

        'submission' => [
            'text'   => 'Pengajuan Pembelian',
            'roles'   => [
                'view'          => ['text' => 'Lihat'],
                'add'           => ['text' => 'Tambah'],
                'edit'          => ['text' => 'Ubah'],
                'delete'        => ['text' => 'Hapus'],
                'decline'       => ['text' => 'Tolak'],
            ]
        ],
        'purchase_order' => [
            'text'   => 'Pesanan Pembelian',
            'roles'   => [
                'view'          => ['text' => 'Lihat'],
                'add'           => ['text' => 'Tambah'],
                'edit'          => ['text' => 'Ubah'],
                'delete'        => ['text' => 'Hapus'],
                'print'         => ['text' => 'Cetak'],
                'status'        => ['text' => 'status'],
                'cancel_order'  => ['text' => 'Pembatalan Pesanan'],
            ]
        ],
        'purchase' => [
            'text'   => 'Pembelian',
            'roles'   => [
                'view'      => ['text' => 'Lihat'],
                'add'       => ['text' => 'Tambah'],
                'repayment' => ['text' => 'Pelunasan Hutang']
            ]
        ],
        'retur_purchase' => [
            'text'   => 'Retur Pembelian',
            'roles'   => [
                'view'          => ['text' => 'Lihat'],
                'add'           => ['text' => 'Tambah'],
                'edit'          => ['text' => 'Ubah'],
                'delete'        => ['text' => 'Hapus'],
                'print'         => ['text' => 'Cetak'],
                'update_payment' => ['text' => 'Update Pembayaran'],
            ]
        ],

        // 
        // 'purchase_return' => [
        //     'text'   => 'Retur Pembelian',
        //     'roles'   => [
        //         'view'      => ['text' => 'Lihat'],
        //         'add'       => ['text' => 'Tambah'],
        //         'edit'      => ['text' => 'Ubah'],
        //         'repayment' => ['text' => 'Pelunasan Retur'],
        //     ]
        // ],

        'purchase_order_consignment' => [
            'text'   => 'Input Pemesanan Konsinyasi',
            'roles'   => [
                'view'          => ['text' => 'Lihat'],
                'add'           => ['text' => 'Tambah'],
                'edit'          => ['text' => 'Ubah'],
                'cancel_order'  => ['text' => 'Pembatalan Pesanan'],
            ]
        ],

        'input_consignment' => [
            'text'   => 'Input Pembelian Konsinyasi',
            'roles'   => [
                'view'          => ['text' => 'Lihat'],
                'add'           => ['text' => 'Tambah'],
                'edit'          => ['text' => 'Ubah'],
                'delete'        => ['text' => 'Hapus'],
                'cancel_order'  => ['text' => 'Pembatalan Pesanan'],
            ]
        ],

        'debt_repayment' => [
            'text'   => 'Pelunasan Hutang',
            'roles'   => [
                'view'          => ['text' => 'Lihat'],
                'add'           => ['text' => 'Tambah'],
                'edit'          => ['text' => 'Ubah'],
                'delete'        => ['text' => 'Hapus'],
            ]
        ],

        'receivable_repayment' => [
            'text'   => 'Pelunasan Piutang',
            'roles'   => [
                'view'          => ['text' => 'Lihat'],
                'add'           => ['text' => 'Tambah'],
                'edit'          => ['text' => 'Ubah'],
                'delete'        => ['text' => 'Hapus'],
            ]
        ],


        // 'sales' => [
        //     'text'   => 'Penjualan',
        //     'roles'   => [
        //         'view'      => ['text' => 'Lihat'],
        //     ]
        // ],

        'sales_admin' => [
            'text'   => 'penjualan admin',
            'roles'   => [
                'view'      => ['text' => 'Lihat'],
                'add'       => ['text' => 'Tambah'],
                'edit'      => ['text' => 'Ubah'],
                'delete'    => ['text' => 'hapus'],
                'print'     => ['text' => 'cetak'],
                'download'  => ['text' => 'download'],
            ]
        ],


        // 'sales_return' => [
        //     'text'   => 'Retur Penjualan',
        //     'roles'   => [
        //         'view'      => ['text' => 'Lihat'],
        //     ]
        // ],

        'retur_sales_admin' => [
            'text'   => 'Retur Penjualan Admin',
            'roles'   => [
                'view'          => ['text' => 'Lihat'],
                'add'           => ['text' => 'Tambah'],
                'edit'          => ['text' => 'Ubah'],
                'delete'        => ['text' => 'Hapus'],
                'print'         => ['text' => 'Cetak']
            ]
        ],

        'sales_pos' => [
            'text'   => 'Penjualan POS',
            'roles'   => [
                'view'      => ['text' => 'Lihat'],
                'edit'      => ['text' => 'Ubah']
            ]
        ],

        'pos' => [
            'text'   => 'Point Of Sales (POS)',
            'roles'   => [
                'view'   => ['text' => 'Lihat'],
            ]
        ],


        'mobilebanner' => [
            'text'   => 'Mobile Banner',
            'roles'   => [
                'view'      => ['text' => 'Lihat'],
                'add'       => ['text' => 'Tambah'],
                'edit'      => ['text' => 'Ubah'],
                'delete'    => ['text' => 'Hapus'],
            ]
        ],

        'mobilepromo' => [
            'text'   => 'Mobile Promo',
            'roles'   => [
                'view'      => ['text' => 'Lihat'],
                'add'       => ['text' => 'Tambah'],
                'edit'      => ['text' => 'Ubah'],
                'delete'    => ['text' => 'Hapus'],
            ]
        ],


        'user_group' => [
            'text'   => 'Grup Pengguna',
            'roles'   => [
                'view'   => ['text' => 'Lihat'],
                'add'    => ['text' => 'Tambah'],
                'edit'   => ['text' => 'Ubah'],
                'delete' => ['text' => 'Hapus'],
            ]
        ],

        'user_account' => [
            'text'   => 'Akun Pengguna',
            'roles'   => [
                'view'   => ['text' => 'Lihat'],
                'add'    => ['text' => 'Tambah'],
                'edit'   => ['text' => 'Ubah'],
                'delete' => ['text' => 'Hapus'],
                'add_fingerprint'   => ['text' => 'Tambah Fingerprint'],
                'reset_password'    => ['text' => 'Reset Password'],
            ]
        ],

        'password_control' => [
            'text'      => 'Password Control',
            'roles'     => [
                'view'              => ['text' => 'Lihat'],
                'add'               => ['text' => 'Tambah'],
                'edit'              => ['text' => 'Ubah'],
                'delete'            => ['text' => 'Hapus'],
            ]
        ],

        'report' => [
            'text'   => 'Laporan',
            'roles'   => [
                'view'                      => ['text' => 'Lihat'],

                /* customer */
                'customer_list'             => ['text' => 'Daftar Customer'],
                'point_exchange_list'       => ['text' => 'Laporan Penukaran Poin'],
                'receivable_list'           => ['text' => 'Laporan Aging Piutang'],
                'receivable_list_report'    => ['text' => 'Laporan Penerimaan Piutang'],
                'receivable_list_receipt'   => ['text' => 'Cetak Kwitansi Penagihan'],
                'customer_mapping_list'     => ['text' => 'Daftar Mapping Customer'],

                /* inventory */
                'stock_list'                => ['text' => 'Laporan Stok Produk'],
                'safety_stock'              => ['text' => 'Laporan Safety Stok'],
                'stock_card'                => ['text' => 'Kartu Stok'],
                'stock_opname_list'         => ['text' => 'Laporan Stok Opname'],
                'stock_transfer_list'       => ['text' => 'Laporan Stok Transfer'],
                'dead_stock_list'           => ['text' => 'Laporan Dead Stock'],
                'exp_stock_list'            => ['text' => 'Laporan Stok Kadaluarsa'],
                'price_change_list'         => ['text' => 'Laporan Perubahan Harga Jual & Beli'],

                /* Laporan Pembelian */
                'po_list'                   => ['text' => 'Laporan PO'],
                'purchase_list'             => ['text' => 'Laporan Pembelian'],
                'po_consignment_list'       => ['text' => 'Laporan PO Konsinyasi'],
                'retur_purchase_list'       => ['text' => 'Laporan Retur Pembelian'],
                'memo_po'                   => ['text' => 'Laporan Memo Pengambilan Barang'],

                /* Laporan Hutang */
                'debt_card_list'            => ['text' => 'Laporan Kartu Hutang'],
                'pending_debt_list'         => ['text' => 'Laporan Sisa Hutang Belum Lunas'],
                'debt_due_date_list'        => ['text' => 'Laporan Hutang Jatuh Tempo'],
                'debt_list'                 => ['text' => 'Laporan Pembayaran Hutang'],

                /* Penjualan */
                'pos_sales_list'                        => ['text' => 'Laporan Penjualan Retail'],
                'pos_sales_list_group_customer'         => ['text' => 'Laporan Penjualan Retail Per Customer'],
                'pos_sales_list_group_salesman'         => ['text' => 'Laporan Penjualan Retail Per Salesman'],
                'pos_sales_list_group_brand'            => ['text' => 'Laporan Penjualan Retail Per Brand'],
                'pos_sales_list_group_category'         => ['text' => 'Laporan Penjualan Retail Per Kategori'],
                'pos_sales_list_group_payment'          => ['text' => 'Laporan Penjualan Retail Per Metode Pembayaran'],
                'pos_sales_allocation_margin'           => ['text' => 'Laporan Alokasi Margin Penjualan Retail'],
                'project_sales_list'                    => ['text' => 'Laporan Penjualan Proyek'],
                'project_retur_sales_list'              => ['text' => 'Laporan Retur Penjualan Proyek'],

                /* Utilitas */
                'barcode_generate'                      => ['text' => 'Cetak Barcode'],
                'price_tag'                             => ['text' => 'Cetak Label Harga'],
            ]
        ],

        'configs' => [
            'text'   => 'Pengaturan',
            'roles'   => [
                'view'   => ['text' => 'Lihat'],
            ]
        ]
    ];

    public $barcodeType = [
        'auto'          => 'AUTO',
        'code_128'      => 'CODE 128',
        'code_128_a'    => 'CODE 128 A',
        'code_128_b'    => 'CODE 128 B',
        'code_128_c'    => 'CODE 128 C',
        'upc_a'         => 'UPC A',
        'ean_13'        => 'EAN 13',
        'ean_8'         => 'EAN 8',
        'code_39'       => 'CODE 39',
    ];

    public $uploadImage = [
        'default' => [
            // gd or imagick
            'module'        => 'gd',
            'width'         => 800,
            'height'        => 800,
            'create_thumb'  => FALSE,
            'thumb_width'   => 400,
            'thumb_height'  => 400,
            'maintainRatio' => FALSE,
            'masterDim'     => 'auto',
        ],
        'product' => [
            'width'         => 800,
            'height'        => 800,
            'create_thumb'  => TRUE,
            'thumb_width'   => 400,
            'thumb_height'  => 400,
            'upload_dir'    => 'contents/upload/product/',
            'thumb_dir'     => 'contents/thumb/product/',
        ],
        'banner' => [
            'width'         => 1900,
            'height'        => 600,
            'create_thumb'  => TRUE,
            'thumb_width'   => 950,
            'thumb_height'  => 300,
            'upload_dir'    => 'contents/upload/banner/',
            'thumb_dir'     => 'contents/thumb/banner/',
        ],

        'promo' => [
            'width'         => 1448,
            'height'        => 2048,
            'create_thumb'  => TRUE,
            'thumb_width'   => 905,
            'thumb_height'  => 1280,
            'upload_dir'    => 'contents/upload/promo/',
            'thumb_dir'     => 'contents/thumb/promo/',
        ],

        'reward_point' => [
            'width'         => 800,
            'height'        => 800,
            'create_thumb'  => TRUE,
            'thumb_width'   => 400,
            'thumb_height'  => 400,
            'upload_dir'    => 'contents/upload/reward/',
            'thumb_dir'     => 'contents/thumb/reward/',
        ],
        'voucher' => [
            'width'         => 886,
            'height'        => 413,
            'create_thumb'  => FALSE,
            'thumb_width'   => 443,
            'thumb_height'  => 206,
            'upload_dir'    => 'contents/upload/voucher/',
            'thumb_dir'     => 'contents/thumb/voucher/',
        ],
    ];

    public $email = [
        'default' => [
            'protocol'      => 'smtp',
            'host'          => 'mail.borneoeternityswiftlet.co.id',
            'port'          => 465,
            'SMTPAuth'      => true,
            'senderName'    => 'DBIG',
            'username'      => 'admin@borneoeternityswiftlet.co.id',
            'password'      => 'IbiRn$dXoDkH',
            'SMTPSecure'    => 'ssl'
        ]
    ];

    public $telebot = [
        'botBaseUrl'            => 'https://api.telegram.org/bot',
        'botToken'              => '6680984388:AAFw0EmT1BjxpR8ZAUFr8bhzBCtt5jRgCWw',
        'sendVerificationTo'    => [
            'dbig_group'    => '-4073658050'
            // 'eric'          => '5927339770',
			// 'andrian'		=> '6281274356'		
        ], //chatIds
        'allowedChatIds' => [
            'dbig_group'    => '-4073658050',
        ],
        'devIds' => [
            'eric'          => '5927339770',
        ]
    ];
}
