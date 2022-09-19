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
                        Pelunasan Piutang
                        <small class="float-right"><?= indo_date('2022-09-05', false) ?></small>
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
                    <b>#PP/UTM/22/09/00001</b><br>
                    <br>
                    <b>Kode Customer:</b> 0000000004<br>
                    <b>Nama Customer:</b> PT Aneka Jaya<br>
                    <b>Alamat:</b> Jl.Gajah Mada No.5<br>
                    <b>No Telp:</b> 0896-7899-8899<br>
                    <b>Metode Pembayaran:</b> CASH<br>
                </div>
                <!-- /.col -->
            </div>
            <br>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <p class="lead">Detail Pelunasan</p>
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No Invoice</th>
                                        <th>Tanggal<br>Invoice</th>
                                        <th>Jatuh<br>Tempo</th>
                                        <th>Keterangan</th>
                                        <th class="text-right">Pembulatan/Disc</th>
                                        <th class="text-right">Pembayaran</th>
                                        <th class="text-right">Total Pelunasan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>SI/UTM/22/08/00001</td>
                                        <td>24/08/2022</td>
                                        <td>03/09/2022</td>
                                        <td>Potong 100RB</td>
                                        <td class="text-right"><?= numberFormat(4900000, true) ?></td>
                                        <td class="text-right"><?= numberFormat(100000, true) ?></td>
                                        <td class="text-right"><?= numberFormat(5000000, true) ?></td>
                                    </tr>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4" class="text-right">TOTAL</th>
                                        <th class="text-right"><?= numberFormat(4900000, true) ?></th>
                                        <th class="text-right"><?= numberFormat(100000, true) ?></th>
                                        <th class="text-right"><?= numberFormat(5000000, true) ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.col -->
                    </div>
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