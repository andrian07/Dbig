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
                            <h3 class="card-title">Customer</h3>

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
                                <li class="list-group-item"><a href="<?= base_url('webmin/report/view-customer-list') ?>" class="text-primary">Daftar Customer</a></li>
                                <li class="list-group-item"><a href="<?= base_url('webmin/report/view-point-exchange-list') ?>" class="text-primary">Laporan Penukaran Poin</a></li>
                                <!--
                                <li class="list-group-item"><a href="<?= base_url('webmin/report/view-customer-point-history-chart') ?>" class="text-primary">Grafik Histori Poin Customer</a></li>
                            -->
                                <li class="list-group-item"><a href="<?= base_url('webmin/report/view-customer-receivable-list') ?>" class="text-primary">Daftar Tagihan Piutang</a></li>
                                <li class="list-group-item"><a href="<?= base_url('webmin/report/view-customer-receivable-receipt') ?>" class="text-primary">Cetak Kwitansi Penagihan</a></li>

                            </ul>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>


                <div class="col-md-4">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Inventory</h3>

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
                                <!--
                                <li class="list-group-item"><a href="<?= base_url('webmin/report/view-product-list') ?>" class="text-primary">Daftar Produk</a></li>
                            -->
                                <li class="list-group-item"><a href="<?= base_url('webmin/report/view-stock-list') ?>" class="text-primary">Laporan Stok Produk</a></li>
                                <li class="list-group-item"><a href="<?= base_url('webmin/report/view-stock-card') ?>" class="text-primary">Kartu Stok</a></li>
                                <li class="list-group-item"><a href="<?= base_url('webmin/report/view-stock-opname-list') ?>" class="text-primary">Laporan Stok Opname</a></li>
                                <li class="list-group-item"><a href="<?= base_url('webmin/report/view-stock-transfer-list') ?>" class="text-primary">Laporan Stok Transfer</a></li>
                                <li class="list-group-item"><a href="<?= base_url('webmin/report/view-dead-stock-list') ?>" class="text-primary">Laporan Dead Stock</a></li>
                                <li class="list-group-item"><a href="<?= base_url('webmin/report/view-exp-stock-list') ?>" class="text-primary">Laporan Stok Kadaluarsa</a></li>
                                <li class="list-group-item"><a href="<?= base_url('webmin/report/view-point-exchange-list') ?>" class="text-primary">Laporan Penukaran Poin</a></li>
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
                                <li class="list-group-item"><a href="<?= base_url('webmin/report/view-stock-list') ?>" class="text-primary">Laporan PO</a></li>
                                <li class="list-group-item"><a href="<?= base_url('webmin/report/view-stock-card') ?>" class="text-primary">Laporan Pembelian</a></li>
                                <li class="list-group-item"><a href="<?= base_url('webmin/report/view-stock-card') ?>" class="text-primary">Laporan Pembelian Rinci</a></li>
                                <li class="list-group-item"><a href="<?= base_url('webmin/report/view-stock-card') ?>" class="text-primary">Laporan Pembelian Per Supplier</a></li>
                                <li class="list-group-item"><a href="<?= base_url('webmin/report/view-stock-card') ?>" class="text-primary">Laporan Pembelian Per Merek</a></li>
                                <li class="list-group-item"><a href="<?= base_url('webmin/report/view-stock-card') ?>" class="text-primary">Laporan Pembelian Per Kategori</a></li>
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
                                <!--
                                <li class="list-group-item"><a href="<?= base_url('report/view-purchase-return-list') ?>" class="text-primary">Daftar Retur Pembelian</a></li>
                                <li class="list-group-item"><a href="<?= base_url('report/view-product-purchase-return-recap') ?>" class="text-primary">Rekap Retur Pembelian Produk</a></li>
                            -->
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
                                <li class="list-group-item"><a href="<?= base_url('webmin/report/view-sales-list') ?>" class="text-primary">Laporan Penjualan Retail</a></li>
                                <li class="list-group-item"><a href="<?= base_url('webmin/report/view-sales-list-group-customer') ?>" class="text-primary">Laporan Penjualan Retail Per Customer</a></li>
                                <li class="list-group-item"><a href="<?= base_url('webmin/report/view-sales-list-group-salesman') ?>" class="text-primary">Laporan Penjualan Retail Per Salesman</a></li>
                                <li class="list-group-item"><a href="<?= base_url('webmin/report/view-sales-list-group-brand') ?>" class="text-primary">Laporan Penjualan Retail Per Brand</a></li>
                                <li class="list-group-item"><a href="<?= base_url('webmin/report/view-sales-list-group-category') ?>" class="text-primary">Laporan Penjualan Retail Per Kategori</a></li>
                                <li class="list-group-item"><a href="<?= base_url('webmin/report/view-sales-list-group-payment') ?>" class="text-primary">Laporan Penjualan Retail Per Metode Pembayaran</a></li>
                                <li class="list-group-item"><a href="<?= base_url('webmin/report/view-sales-allocation-margin') ?>" class="text-primary">Laporan Alokasi Margin Penjualan Retail</a></li>

                                <li class="list-group-item"><a href="<?= base_url('webmin/report/view-project-sales-list') ?>" class="text-primary">Laporan Penjualan Proyek </a></li>
                                <li class="list-group-item"><a href="<?= base_url('webmin/report/view-project-sales-list-group-salesman') ?>" class="text-primary">Laporan Penjualan Proyek Per Salesman</a></li>
                                <li class="list-group-item"><a href="<?= base_url('webmin/report/view-project-sales-list-group-customer') ?>" class="text-primary">Laporan Penjualan Proyek Per Customer</a></li>
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
                                <!--
                                <li class="list-group-item"><a href="<?= base_url('report/view-sales-return-list') ?>" class="text-primary">Daftar Retur Penjualan</a></li>
                                <li class="list-group-item"><a href="<?= base_url('report/view-user-sales-return-list') ?>" class="text-primary">Daftar Retur Penjualan Per User</a></li>
                            -->
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
                                <li class="list-group-item"><a href="<?= base_url('webmin/report/view-barcode-generate') ?>" class="text-primary">Cetak Barcode</a></li>
                                <li class="list-group-item"><a href="<?= base_url('webmin/report/view-price-tag-v3') ?>" class="text-primary">Cetak Label Harga</a></li>
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