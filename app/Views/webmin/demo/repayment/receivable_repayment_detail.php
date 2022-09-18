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
                        <small class="float-right"><?= indo_date('2022-08-24', false) ?></small>
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
                    <b>#PH/UTM/22/08/00001</b><br>
                    <br>
                    <b>Kode Supplier:</b> NPPI<br>
                    <b>Nama Supplier:</b> PT NIPPON INDONESIA<br>
                    <b>Alamat:</b> Jl Sungai Raya Dalam Komplek ABC No.10<br>
                    <b>No Telp:</b> 0896-0899-0888<br>
                    <b>Metode Pembayaran:</b> BCA a/n DBIG (0123456789012)<br>
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
                                        <th>No Faktur</th>
                                        <th>Tanggal<br>Invoice</th>
                                        <th>Keterangan</th>
                                        <th class="text-right">Pembulatan/Disc</th>
                                        <th class="text-right">Pembayaran</th>
                                        <th class="text-right">Total Pelunasan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>SI/UTM/22/09/00001</td>
                                        <td>FK00001</td>
                                        <td>20/08/22</td>
                                        <td>-</td>
                                        <td class="text-right"><?= numberFormat(0, true) ?></td>
                                        <td class="text-right"><?= numberFormat(1000000, true) ?></td>
                                        <td class="text-right"><?= numberFormat(1000000, true) ?></td>
                                    </tr>
                                    <tr>
                                        <td>SI/UTM/22/09/00002</td>
                                        <td>FK00002</td>
                                        <td>25/08/22</td>
                                        <td>Potongan 200rb</td>
                                        <td class="text-right"><?= numberFormat(200000, true) ?></td>
                                        <td class="text-right"><?= numberFormat(3000000, true) ?></td>
                                        <td class="text-right"><?= numberFormat(3200000, true) ?></td>
                                    </tr>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4" class="text-right">TOTAL</th>
                                        <th class="text-right"><?= numberFormat(200000, true) ?></th>
                                        <th class="text-right"><?= numberFormat(4000000, true) ?></th>
                                        <th class="text-right"><?= numberFormat(4200000, true) ?></th>
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