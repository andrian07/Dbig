<?php
$themeUrl = base_url('assets/adminlte3');
$assetsUrl = base_url('assets');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Produk</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= $themeUrl ?>/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= $themeUrl ?>/dist/css/adminlte.min.css">
</head>

<body>
    <div class="wrapper">
        <!-- Main content -->
        <section class="invoice">
            <!-- title row -->
            <div class="row">
                <div class="col-12">
                    <h2 class="page-header">
                        Detail Penukaran
                        <small class="float-right"></small>
                    </h2>
                </div>
                <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                    <address>
                        <strong><?= COMPANY_NAME ?></strong><br>
                        <?= COMPANY_ADDRESS ?><br>
                        <i class="fa fas-phone"></i> <?= COMPANY_PHONE ?><br>
                    </address>
                </div>
                <div class="col-sm-4 invoice-col">

                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    <b>#0000000001</b><br>
                    <br>
                    <b>Nama Customer:</b> Samsul<br>
                    <b>Grup:</b> <span class="badge badge-light">Member Silver</span><br>
                    <b>Alamat:</b> Jl.Sui raya km 8.5 no 25<br>
                    <b>No Telp:</b> 0896-7899-8899<br>
                    <b>Status Penukaran:</b> <span class="badge badge-success">Selesai</span><br>
                </div>
                <!-- /.col -->
            </div>
            <br>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <p class="lead">Detail Penukaran</p>
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Tanggal Penukaran</th>
                                        <th>Hadiah</th>
                                        <th class="text-right">Jumlah Poin</th>
                                        <th>Tanggal Penyelesaian</th>
                                        <th>Oleh</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>01/08/2022</td>
                                        <td>Kopin Mangkok Vegetable Bowl 9″ Kukuruyuk (KPQ-9VB)</td>
                                        <td class="text-right">50.00</td>
                                        <td>05/08/2022</td>
                                        <td>Reza</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.col -->
                    </div>
                </div>
                <div class="col-md-12 col-xs-12">
                    <p>Lokasi Pengambilan Hadiah: <b><?= COMPANY_NAME ?></b><br> <?= COMPANY_ADDRESS ?>
                    <p>


                </div>

            </div>
            <!-- /.row -->


        </section>
        <!-- /.content -->
    </div>
    <!-- ./wrapper -->
    <!-- Page specific script -->
</body>

</html>