<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class MyApp extends BaseConfig
{
    public $allowedHosts        = ['localhost','dbig.stoklogistiksks.com'];
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

        'unit' => [
            'text'   => 'Satuan',
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

        'brand' => [
            'text'   => 'Brand',
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

        'mapping_area' => [
            'text'   => 'Mapping Area',
            'roles'   => [
                'view'   => ['text' => 'Lihat'],
                'add'    => ['text' => 'Tambah'],
                'edit'   => ['text' => 'Ubah'],
                'delete' => ['text' => 'Hapus'],
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

        'password_control' => [
            'text'      => 'Password Control',
            'roles'     => [
                'view'              => ['text' => 'Lihat'],
                'add'               => ['text' => 'Tambah'],
                'edit'              => ['text' => 'Ubah'],
                'delete'            => ['text' => 'Hapus'],
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

        'purchase' => [
            'text'   => 'Pembelian',
            'roles'   => [
                'view'      => ['text' => 'Lihat'],
                'add'       => ['text' => 'Tambah'],
                'repayment' => ['text' => 'Pelunasan Hutang']
            ]
        ],

        'purchase_return' => [
            'text'   => 'Retur Pembelian',
            'roles'   => [
                'view'      => ['text' => 'Lihat'],
                'add'       => ['text' => 'Tambah'],
                'edit'      => ['text' => 'Ubah'],
                'repayment' => ['text' => 'Pelunasan Retur'],
            ]
        ],

        'sales' => [
            'text'   => 'Penjualan',
            'roles'   => [
                'view'      => ['text' => 'Lihat'],
            ]
        ],

        'sales_admin' => [
            'text'   => 'penjualan admin',
            'roles'   => [
                'view'      => ['text' => 'Lihat'],
                'add'       => ['text' => 'Tambah'],
                'edit'      => ['text' => 'Ubah'],
                'delete'    => ['text' => 'hapus'],
            ]
        ],

        'sales_return' => [
            'text'   => 'Retur Penjualan',
            'roles'   => [
                'view'      => ['text' => 'Lihat'],
            ]
        ],

        'stock_opname' => [
            'text'   => 'Stok Opname',
            'roles'   => [
                'view'   => ['text' => 'Lihat'],
                'add'    => ['text' => 'Tambah'],
            ]
        ],

        'pos' => [
            'text'   => 'Point Of Sales (POS)',
            'roles'   => [
                'view'   => ['text' => 'Lihat'],
            ]
        ],

        'password_control' => [
            'text'   => 'Password Control',
            'roles'   => [
                'view'   => ['text' => 'Lihat'],
                'add'    => ['text' => 'Tambah'],
                'edit'   => ['text' => 'Ubah'],
                'delete' => ['text' => 'Hapus'],
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

        'report' => [
            'text'   => 'Laporan',
            'roles'   => [
                'view'                      => ['text' => 'Lihat'],
                'product_list'              => ['text' => 'Daftar Produk'],
                'point_exchange_list'       => ['text' => 'Daftar Penukaran Poin'],
                'stock_opname_list'         => ['text' => 'Daftar Stok Opname'],
                'customer_point_history_chart' => ['text' => 'Grafik Histori Poin Customer'],

                'purchase_list'             => ['text' => 'Daftar Pembelian'],
                'supplier_purchase_list'    => ['text' => 'Daftar Pembelian Per Supplier'],
                'purchase_repayment_list'   => ['text' => 'Daftar Pelunasan Pembelian'],
                'purchase_debt_due_list'    => ['text' => 'Daftar Tagihan Jatuh Tempo'],
                'product_purchase_recap'    => ['text' => 'Rekap Pembelian Produk'],
                'product_purchase_history'  => ['text' => 'Histori Pembelian Produk'],

                'purchase_return_list'             => ['text' => 'Daftar Retur Pembelian'],
                'product_purchase_return_recap'    => ['text' => 'Rekap Retur Pembelian Produk'],

                'sales_list'                => ['text' => 'Daftar Penjualan'],
                'user_sales_list'           => ['text' => 'Daftar Penjualan Per User'],
                'product_sales_recap'       => ['text' => 'Rekap Penjualan Produk'],
                'category_product_sales_recap' => ['text' => 'Rekap Penjualan Produk Per Kategori'],
                'invoice_sales_recap'       => ['text' => 'Rekap Penjualan Per Nota'],
                'invoice_sales_recap_group_date' => ['text' => 'Rekap Penjualan Nota Harian'],
                'income_recap'              => ['text' => 'Laporan Laba Rugi'],

                'sales_return_list'         => ['text' => 'Daftar Retur Penjualan'],
                'user_sales_return_list'    => ['text' => 'Daftar Retur Penjualan Per User'],

                'accounting'                => ['text' => 'Akuntansi'],
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
            'thumb_width'   => 150,
            'thumb_height'  => 150,
            'maintainRatio' => FALSE,
            'masterDim'     => 'auto',
        ],
        'product' => [
            'width'         => 800,
            'height'        => 800,
            'create_thumb'  => TRUE,
            'thumb_width'   => 150,
            'thumb_height'  => 150,
            'upload_dir'    => 'contents/upload/product/',
            'thumb_dir'     => 'contents/thumb/product/',
        ],
        'banner' => [
            'width'         => 1000,
            'height'        => 700,
            'create_thumb'  => TRUE,
            'thumb_width'   => 320,
            'thumb_height'  => 150,
            'upload_dir'    => 'contents/upload/banner/',
            'thumb_dir'     => 'contents/thumb/banner/',
        ],
        'reward_point' => [
            'width'         => 1000,
            'height'        => 1000,
            'create_thumb'  => TRUE,
            'thumb_width'   => 300,
            'thumb_height'  => 300,
            'upload_dir'    => 'contents/upload/reward/',
            'thumb_dir'     => 'contents/thumb/reward/',
        ],
        'voucher' => [
            'width'         => 1000,
            'height'        => 700,
            'create_thumb'  => FALSE,
            'thumb_width'   => 320,
            'thumb_height'  => 150,
            'upload_dir'    => 'contents/upload/voucher/',
            'thumb_dir'     => 'contents/thumb/voucher/',
        ],
    ];
}
