<?php
$themeUrl = base_url('assets/adminlte3');
$assetsUrl = base_url('assets');
?>

<?= $this->extend('pos/template/pos_template') ?>

<?= $this->section('content') ?>
<!-- Content Header (Page header) -->

<div class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-2">
                <button class="btn btn-block btn-danger">
                    <i class="fas fa-cash-register"></i> Tutup Kas
                </button>
            </div>
            <div class="col-sm-2">
                <button class="btn btn-block btn-success">
                    <i class="fas fa-dollar-sign"></i> Kas Masuk
                </button>
            </div>
            <div class="col-sm-2">
                <button class="btn btn-block btn-danger">
                    <i class="fas fa-hand-holding-usd"></i> Kas Keluar
                </button>
            </div>
            <div class="col-sm-2">
                <button class="btn btn-block btn-primary">
                    <i class="fas fa-plus"></i> Tambah Penjualan
                </button>
            </div>
            <div class="col-sm-2">
                <button class="btn btn-block btn-primary">
                    <i class="fas fa-plus"></i> Tambah Retur
                </button>
            </div>
            <div class="col-sm-2">
                <button class="btn btn-block btn-primary">
                    <i class="fas fa-file"></i> Rekap Penjualan
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-cash-register"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Saldo Awal</span>
                        <span class="info-box-number">Rp 200,000.00</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-cash-register"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Saldo Kas</span>
                        <span class="info-box-number">Rp 203,400.00</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="clearfix hidden-md-up"></div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total Sales</span>
                        <span class="info-box-number">Rp 3,400.00</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total Retur</span>
                        <span class="info-box-number">Rp 0</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>
    </div>
</div>


<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <h3 class="text-center">Histori Penjualan</h3>
                        <div class="row mb-1">
                            <div class="col-12">
                                <table id="tblsales" class="table table-bordered table-hover" width="100%">
                                    <thead>
                                        <tr>
                                            <th data-priority="1">No Invoice</th>
                                            <th data-priority="4">Tanggal</th>
                                            <th data-priority="5">Customer</th>
                                            <th data-priority="2">Total</th>
                                            <th data-priority="3">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                SI/22/08/00001
                                            </td>
                                            <td>
                                                24/08/2022
                                            </td>
                                            <td>
                                                BUDI
                                            </td>
                                            <td>
                                                51,500.00
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btnedit btn-sm btn-default"><i class="fas fa-print"></i></button>
                                                    <button type="button" class="btn btndelete btn-sm btn-danger"><i class="fas fa-times"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                SI/22/08/00002
                                            </td>
                                            <td>
                                                24/08/2022
                                            </td>
                                            <td>
                                                CASH
                                            </td>
                                            <td>
                                                100,000.00
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btnedit btn-sm btn-default"><i class="fas fa-print"></i></button>
                                                    <button type="button" class="btn btndelete btn-sm btn-danger"><i class="fas fa-times"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                SI/22/08/00003
                                            </td>
                                            <td>
                                                24/08/2022
                                            </td>
                                            <td>
                                                CASH
                                            </td>
                                            <td>
                                                50,000.00
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btnedit btn-sm btn-default"><i class="fas fa-print"></i></button>
                                                    <button type="button" class="btn btndelete btn-sm btn-danger"><i class="fas fa-times"></i></button>
                                                </div>
                                            </td>
                                        </tr>


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-danger card-outline">
                    <div class="card-body">
                        <h3 class="text-center">Histori Retur Penjualan</h3>
                        <div class="row mb-1">
                            <div class="col-12">
                                <table id="tblsalesreturn" class="table table-bordered table-hover" width="100%">
                                    <thead>
                                        <tr>
                                            <th data-priority="1">No Invoice</th>
                                            <th data-priority="4">Tanggal</th>
                                            <th data-priority="5">Customer</th>
                                            <th data-priority="2">Total</th>
                                            <th data-priority="3">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                SR/22/08/00001
                                            </td>
                                            <td>
                                                24/08/2022
                                            </td>
                                            <td>
                                                BUDI
                                            </td>
                                            <td>
                                                10,300.00
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btnedit btn-sm btn-default"><i class="fas fa-print"></i></button>
                                                    <button type="button" class="btn btndelete btn-sm btn-danger"><i class="fas fa-times"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>







                    </div>
                </div>
            </div>


        </div>

    </div>
</div>

<!-- /.content -->
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    $(document).ready(function() {
        const config_tblsales = {
            scrollY: "240px",
            scrollCollapse: true,
            paging: false,
            pageLength: 10,
            autoWidth: false,
            select: true,
            responsive: true,
            fixedColumns: true,
            order: [
                [0, 'desc']
            ],
            "language": {
                "url": lang_datatables,
            },
            "columnDefs": [{
                    width: 70,
                    targets: 4
                },
                {
                    targets: [4],
                    orderable: false,
                    searchable: false,
                },

                {
                    targets: [3],
                    className: "text-right",
                }
            ]
        };

        let tblsales = $('#tblsales').DataTable(config_tblsales);
        let tblsalesreturn = $('#tblsalesreturn').DataTable(config_tblsales);


    })
</script>
<?= $this->endSection() ?>