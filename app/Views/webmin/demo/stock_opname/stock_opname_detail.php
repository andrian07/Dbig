<?php
$themeUrl = base_url('assets/adminlte3');
$assetsUrl = base_url('assets');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Opname</title>

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
                        Detail Opname
                        <small class="float-right">
                            <?= indo_date('2022-09-03', false) ?>
                        </small>
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
                    <b>#OP/KBR/22/09/000001</b><br>
                    <br>
                    <b>Kode Gudang:</b> KBR<br>
                    <b>Nama Gudang:</b> CABANG KOTA BARUl<br>
                    <b>Alamat:</b> Jalan Prof. M. Yamin No 5, Perempatan Jalan Ampera<br>
                </div>
                <!-- /.col -->
            </div>
            <br>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <p class="lead">Detail Opname</p>
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Kode Produk</th>
                                        <th>Nama Produk</th>
                                        <th>Satuan</th>
                                        <th class="text-right">HPP</th>
                                        <th class="text-right">Stok Fisik</th>
                                        <th class="text-right">Stok System</th>
                                        <th>Selisih <small>Unit</small></th>
                                        <th>Selisih <small>Rp</small></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>P000001</td>
                                        <td>Toto Gantungan Double Robe Hook (TX04AES)</td>
                                        <td>PCS</td>
                                        <td class="text-right">27,750.00</td>
                                        <td class="text-right">240.00</td>
                                        <td class="text-right">250.00</td>
                                        <td class="text-right">-10.00</td>
                                        <td class="text-right">-277,500.00</td>
                                    </tr>
                                    <tr>
                                        <td>P000002</td>
                                        <td>Toto Floor Drain (TX1DA)</td>
                                        <td>PCS</td>
                                        <td class="text-right">25,000.00</td>
                                        <td class="text-right">100.00</td>
                                        <td class="text-right">105.00</td>
                                        <td class="text-right">5.00</td>
                                        <td class="text-right">125,000.00</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-right" colspan="7">TOTAL</th>
                                        <th class="text-right">-152,500.00</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.col -->
                    </div>
                </div>
                <div class="col-md-8 col-xs-12">
                    <p>
                        <b>Keterangan</b> : <br>
                        -
                    </p>
                </div>
                <div class="col-md-4 col-xs-12">
                    <table width="100%">
                        <tr>
                            <th class="text-right" width="50%">Diopname Oleh :</th>
                            <td class="text-right" width="50%">Ani</td>
                        </tr>
                        <tr>
                            <th class="text-right">Pada :</th>
                            <td class="text-right"><?= indo_short_date('2022-09-03 12:00:00', false) ?></td>
                        </tr>
                    </table>
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