<?php
$themeUrl = base_url('assets/adminlte3');
$assetsUrl = base_url('assets');
$report_role = $user_role['report'];
?>

<?= $this->extend('webmin/template/admin_template') ?>

<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Laporan</h1>
                </div>
                <div class="col-sm-6"></div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Daftar & Laporan</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item"><a href="<?= base_url('report/view-product-list') ?>" class="text-primary">Daftar Produk</a></li>
                                <li class="list-group-item"><a href="<?= base_url('report/view-stock-opname-list') ?>" class="text-primary">Daftar Stok Opname</a></li>
                                <li class="list-group-item"><a href="<?= base_url('report/view-point-exchange-list') ?>" class="text-primary">Daftar Penukaran Poin</a></li>
                                <li class="list-group-item"><a href="<?= base_url('report/view-customer-point-history-chart') ?>" class="text-primary">Grafik Histori Poin Customer</a></li>
                            </ul>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>


                <div class="col-md-4">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Laporan Pembelian</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item"><a href="<?= base_url('report/view-purchase-list') ?>" class="text-primary">Daftar Pembelian</a></li>
                                <li class="list-group-item"><a href="<?= base_url('report/view-supplier-purchase-list') ?>" class="text-primary">Daftar Pembelian Per Supplier</a></li>
                                <li class="list-group-item"><a href="<?= base_url('report/view-product-purchase-recap') ?>" class="text-primary">Rekap Pembelian Produk</a></li>
                                <li class="list-group-item"><a href="<?= base_url('report/view-product-purchase-history') ?>" class="text-primary">Histori Pembelian Produk</a></li>
                                <li class="list-group-item"><a href="<?= base_url('report/view-purchase-debt-due-list') ?>" class="text-primary">Daftar Tagihan Jatuh Tempo</a></li>
                                <li class="list-group-item"><a href="<?= base_url('report/view-purchase-repayment-list') ?>" class="text-primary">Daftar Pelunasan Pembelian</a></li>
                            </ul>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>



                <div class="col-md-4">
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title">Laporan Retur Pembelian</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item"><a href="<?= base_url('report/view-purchase-return-list') ?>" class="text-primary">Daftar Retur Pembelian</a></li>
                                <li class="list-group-item"><a href="<?= base_url('report/view-product-purchase-return-recap') ?>" class="text-primary">Rekap Retur Pembelian Produk</a></li>
                            </ul>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>



                <div class="col-md-4">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Laporan Penjualan</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item"><a href="<?= base_url('webmin/report/view-sales-list') ?>" class="text-primary">Daftar Penjualan</a></li>

                                <li class="list-group-item"><a href="<?= base_url('report/view-user-sales-list') ?>" class="text-primary">Daftar Penjualan Per User</a></li>


                                <li class="list-group-item"><a href="<?= base_url('report/view-product-sales-recap') ?>" class="text-primary">Rekap Penjualan Per Produk</a></li>


                                <li class="list-group-item"><a href="<?= base_url('report/view-category-product-sales-recap') ?>" class="text-primary">Rekap Penjualan Produk Per Kategori</a></li>


                                <li class="list-group-item"><a href="<?= base_url('report/view-invoice-sales-recap') ?>" class="text-primary">Rekap Penjualan Per Nota</a></li>


                                <li class="list-group-item"><a href="<?= base_url('report/view-invoice-sales-recap-group-date') ?>" class="text-primary">Rekap Penjualan Nota Harian</a></li>

                                <li class="list-group-item"><a href="<?= base_url('report/view-income-recap') ?>" class="text-primary">Laporan Laba Rugi</a></li>


                            </ul>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>

                <div class="col-md-4">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Laporan Retur Penjualan</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item"><a href="<?= base_url('report/view-sales-return-list') ?>" class="text-primary">Daftar Retur Penjualan</a></li>
                                <li class="list-group-item"><a href="<?= base_url('report/view-user-sales-return-list') ?>" class="text-primary">Daftar Retur Penjualan Per User</a></li>

                            </ul>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>

                <div class="col-md-4">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Utilitas</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item"><a href="<?= base_url('report/view-print-barcode') ?>" class="text-primary">Cetak Barcode</a></li>
                            </ul>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>



            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->


    </section>
</div>
<!-- /.content -->
<?= $this->endSection() ?>