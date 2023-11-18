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
                <?php
                $showMenuReportCustomer = false;
                $listReportCustomer     = [
                    'customer_list',
                    'point_exchange_list',
                    'receivable_list',
                    'receivable_list_report',
                    'receivable_list_receipt',
                    'customer_mapping_list'
                ];

                foreach ($listReportCustomer as $report_name) {
                    if ($role->hasRole('report.' . $report_name)) {
                        $showMenuReportCustomer = true;
                    }
                }

                if ($showMenuReportCustomer) :
                ?>

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
                                    <?php if ($role->hasRole('report.customer_list')) : ?>
                                        <li class="list-group-item"><a href="<?= base_url('webmin/report/view-customer-list') ?>" class="text-primary">Daftar Customer</a></li>
                                    <?php endif ?>

                                    <?php if ($role->hasRole('report.point_exchange_list')) : ?>
                                        <li class="list-group-item"><a href="<?= base_url('webmin/report/view-point-exchange-list') ?>" class="text-primary">Laporan Penukaran Poin</a></li>
                                    <?php endif ?>

                                    <?php if ($role->hasRole('report.receivable_list')) : ?>
                                        <li class="list-group-item"><a href="<?= base_url('webmin/report/view-customer-receivable-list') ?>" class="text-primary">Laporan Aging Piutang</a></li>
                                    <?php endif ?>

                                    <?php if ($role->hasRole('report.receivable_list_report')) : ?>
                                        <li class="list-group-item"><a href="<?= base_url('webmin/report/view-customer-receivable-list-report') ?>" class="text-primary">Laporan Penerimaan Piutang</a></li>
                                    <?php endif ?>

                                    <?php if ($role->hasRole('report.receivable_list_receipt')) : ?>
                                        <li class="list-group-item"><a href="<?= base_url('webmin/report/view-customer-receivable-receipt') ?>" class="text-primary">Cetak Kwitansi Penagihan</a></li>
                                    <?php endif ?>

                                    <?php if ($role->hasRole('report.customer_mapping_list')) : ?>
                                        <li class="list-group-item"><a href="<?= base_url('webmin/report/view-customer-mapping-list') ?>" class="text-primary">Daftar Mapping Customer</a></li>
                                    <?php endif ?>
                                </ul>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                <?php endif ?>


                <?php
                $showMenuReportInventory = false;
                $listReportInventory    = [
                    'stock_list',
                    'safety_stock',
                    'stock_card',
                    'stock_opname_list',
                    'stock_transfer_list',
                    'dead_stock_list',
                    'exp_stock_list',
                    'price_change_list'
                ];

                foreach ($listReportInventory as $report_name) {
                    if ($role->hasRole('report.' . $report_name)) {
                        $showMenuReportCustomer = true;
                    }
                }

                if ($listReportInventory) :
                ?>
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
                                    <?php if ($role->hasRole('report.stock_list')) : ?>
                                        <li class="list-group-item"><a href="<?= base_url('webmin/report/view-stock-list-v2') ?>" class="text-primary">Laporan Stok Produk</a></li>
                                    <?php endif ?>

                                    <?php if ($role->hasRole('report.safety_stock')) : ?>
                                        <li class="list-group-item"><a href="<?= base_url('webmin/report/view-safety-stock') ?>" class="text-primary">Laporan Safety Stok</a></li>
                                    <?php endif ?>

                                    <?php if ($role->hasRole('report.stock_card')) : ?>
                                        <li class="list-group-item"><a href="<?= base_url('webmin/report/view-stock-card') ?>" class="text-primary">Kartu Stok</a></li>
                                    <?php endif ?>

                                    <?php if ($role->hasRole('report.stock_opname_list')) : ?>
                                        <li class="list-group-item"><a href="<?= base_url('webmin/report/view-stock-opname-list') ?>" class="text-primary">Laporan Stok Opname</a></li>
                                    <?php endif ?>

                                    <?php if ($role->hasRole('report.stock_transfer_list')) : ?>
                                        <li class="list-group-item"><a href="<?= base_url('webmin/report/view-stock-transfer-list') ?>" class="text-primary">Laporan Stok Transfer</a></li>
                                    <?php endif ?>

                                    <?php if ($role->hasRole('report.dead_stock_list')) : ?>
                                        <li class="list-group-item"><a href="<?= base_url('webmin/report/view-dead-stock-list') ?>" class="text-primary">Laporan Dead Stock</a></li>
                                    <?php endif ?>

                                    <?php if ($role->hasRole('report.exp_stock_list')) : ?>
                                        <li class="list-group-item"><a href="<?= base_url('webmin/report/view-exp-stock-list') ?>" class="text-primary">Laporan Stok Kadaluarsa</a></li>
                                    <?php endif ?>

                                    <?php if ($role->hasRole('report.price_change_list')) : ?>
                                        <li class="list-group-item"><a href="<?= base_url('webmin/report/view-price-change-list') ?>" class="text-primary">Laporan Perubahan Harga Jual & Beli</a></li>
                                    <?php endif ?>
                                </ul>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                <?php endif ?>


                <?php
                $showMenuReportPurchase = false;
                $listReportPurchase    = [
                    'po_list',
                    'purchase_list',
                    'po_consignment_list',
                    'retur_purchase_list',
                ];

                foreach ($listReportPurchase as $report_name) {
                    if ($role->hasRole('report.' . $report_name)) {
                        $showMenuReportPurchase = true;
                    }
                }

                if ($showMenuReportPurchase) :
                ?>
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
                                    <?php if ($role->hasRole('report.po_list')) : ?>
                                        <li class="list-group-item"><a href="<?= base_url('webmin/report/view-po-list') ?>" class="text-primary">Laporan PO</a></li>
                                    <?php endif ?>

                                    <?php if ($role->hasRole('report.purchase_list')) : ?>
                                        <li class="list-group-item"><a href="<?= base_url('webmin/report/view-purchase-list') ?>" class="text-primary">Laporan Pembelian</a></li>
                                    <?php endif ?>

                                    <?php if ($role->hasRole('report.po_consignment_list')) : ?>
                                        <li class="list-group-item"><a href="<?= base_url('webmin/report/view-po-consignment-list') ?>" class="text-primary">Laporan PO Konsinyasi</a></li>
                                    <?php endif ?>

                                    <?php if ($role->hasRole('report.retur_purchase_list')) : ?>
                                        <li class="list-group-item"><a href="<?= base_url('webmin/report/view-retur-purchase-list') ?>" class="text-primary">Laporan Retur Pembelian</a></li>
                                    <?php endif ?>
                                </ul>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                <?php endif ?>


                <?php
                $showMenuReportDebt = false;
                $listReportDebt    = [
                    'debt_card_list',
                    'pending_debt_list',
                    'debt_due_date_list',
                    'debt_list',
                ];

                foreach ($listReportDebt  as $report_name) {
                    if ($role->hasRole('report.' . $report_name)) {
                        $showMenuReportDebt = true;
                    }
                }

                if ($showMenuReportDebt) :
                ?>
                    <div class="col-md-4">
                        <div class="card card-danger">
                            <div class="card-header">
                                <h3 class="card-title">Laporan Hutang</h3>

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
                                    <?php if ($role->hasRole('report.debt_card_list')) : ?>
                                        <li class="list-group-item"><a href="<?= base_url('webmin/report/view-debt-card-list') ?>" class="text-primary">Laporan Kartu Hutang</a></li>
                                    <?php endif ?>

                                    <?php if ($role->hasRole('report.pending_debt_list')) : ?>
                                        <li class="list-group-item"><a href="<?= base_url('webmin/report/view-debt-pending-list') ?>" class="text-primary">Laporan Sisa Hutang Belum Lunas</a></li>
                                    <?php endif ?>

                                    <?php if ($role->hasRole('report.debt_due_date_list')) : ?>
                                        <li class="list-group-item"><a href="<?= base_url('webmin/report/view-debt-duedate-list') ?>" class="text-primary">Laporan Hutang Jatuh Tempo</a></li>
                                    <?php endif ?>

                                    <?php if ($role->hasRole('report.debt_list')) : ?>
                                        <li class="list-group-item"><a href="<?= base_url('webmin/report/view-debt-list') ?>" class="text-primary">Laporan Pembayaran Hutang</a></li>
                                    <?php endif ?>
                                </ul>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                <?php endif ?>



                <?php
                $showMenuReportSales = false;
                $listReportSales    = [
                    'pos_sales_list',
                    'pos_sales_list_group_customer',
                    'pos_sales_list_group_salesman',
                    'pos_sales_list_group_brand',
                    'pos_sales_list_group_category',
                    'pos_sales_list_group_payment',
                    'pos_sales_allocation_margin',
                    'project_sales_list',
                    'project_retur_sales_list',
                ];

                foreach ($listReportSales  as $report_name) {
                    if ($role->hasRole('report.' . $report_name)) {
                        $showMenuReportSales = true;
                    }
                }

                if ($showMenuReportSales) :
                ?>
                    <div class="col-md-4">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Laporan Penjualan</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <ul class="list-group">
                                    <?php if ($role->hasRole('report.pos_sales_list')) : ?>
                                        <li class="list-group-item"><a href="<?= base_url('webmin/report/view-sales-list') ?>" class="text-primary">Laporan Penjualan Retail</a></li>
                                    <?php endif ?>

                                    <?php if ($role->hasRole('report.pos_sales_list_group_customer')) : ?>
                                        <li class="list-group-item"><a href="<?= base_url('webmin/report/view-sales-list-group-customer') ?>" class="text-primary">Laporan Penjualan Retail Per Customer</a></li>
                                    <?php endif ?>

                                    <?php if ($role->hasRole('report.pos_sales_list_group_salesman')) : ?>
                                        <li class="list-group-item"><a href="<?= base_url('webmin/report/view-sales-list-group-salesman') ?>" class="text-primary">Laporan Penjualan Retail Per Salesman</a></li>
                                    <?php endif ?>

                                    <?php if ($role->hasRole('report.pos_sales_list_group_brand')) : ?>
                                        <li class="list-group-item"><a href="<?= base_url('webmin/report/view-sales-list-group-brand') ?>" class="text-primary">Laporan Penjualan Retail Per Brand</a></li>
                                    <?php endif ?>

                                    <?php if ($role->hasRole('report.pos_sales_list_group_category')) : ?>
                                        <li class="list-group-item"><a href="<?= base_url('webmin/report/view-sales-list-group-category') ?>" class="text-primary">Laporan Penjualan Retail Per Kategori</a></li>
                                    <?php endif ?>

                                    <?php if ($role->hasRole('report.pos_sales_list_group_payment')) : ?>
                                        <li class="list-group-item"><a href="<?= base_url('webmin/report/view-sales-list-group-payment') ?>" class="text-primary">Laporan Penjualan Retail Per Metode Pembayaran</a></li>
                                    <?php endif ?>

                                    <?php if ($role->hasRole('report.pos_sales_allocation_margin')) : ?>
                                        <li class="list-group-item"><a href="<?= base_url('webmin/report/view-sales-allocation-margin') ?>" class="text-primary">Laporan Alokasi Margin Penjualan Retail</a></li>
                                    <?php endif ?>

                                    <?php if ($role->hasRole('report.project_sales_list')) : ?>
                                        <li class="list-group-item"><a href="<?= base_url('webmin/report/view-project-sales-list') ?>" class="text-primary">Laporan Penjualan Proyek </a></li>
                                    <?php endif ?>

                                    <?php if ($role->hasRole('report.project_retur_sales_list')) : ?>
                                        <li class="list-group-item"><a href="<?= base_url('webmin/report/view-project-retur-sales-list') ?>" class="text-primary">Laporan Retur Penjualan Proyek </a></li>
                                    <?php endif ?>
                                </ul>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                <?php endif ?>



                <?php
                $showMenuReportUtility = false;
                $listReportUtility    = [
                    'barcode_generate',
                    'price_tag',
                ];

                foreach ($listReportUtility  as $report_name) {
                    if ($role->hasRole('report.' . $report_name)) {
                        $showMenuReportUtility = true;
                    }
                }

                if ($showMenuReportUtility) :
                ?>
                    <div class="col-md-4">
                        <div class="card card-success">
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
                                    <?php if ($role->hasRole('report.barcode_generate')) : ?>
                                        <li class="list-group-item"><a href="<?= base_url('webmin/report/view-barcode-generate') ?>" class="text-primary">Cetak Barcode</a></li>
                                    <?php endif ?>

                                    <?php if ($role->hasRole('report.price_tag')) : ?>
                                        <li class="list-group-item"><a href="<?= base_url('webmin/report/view-price-tag-v3') ?>" class="text-primary">Cetak Label Harga</a></li>
                                    <?php endif ?>
                                </ul>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->


                    </div>
                <?php endif ?>



            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->


    </section>
</div>
<!-- /.content -->
<?= $this->endSection() ?>