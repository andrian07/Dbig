<?php
$themeUrl = base_url('assets/adminlte3');
$assetsUrl = base_url('assets');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Stok Transfer</title>

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
                        Detail Transfer Stok
                        <small class="float-right">
                            <?= indo_date('2022-09-01', false) ?>
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
                    <b>#ST/UTM/22/09/000002 </b><br>
                    <br>
                    <b>Dari Gudang:</b> KNY - KONSINYASI<br>
                    <b>Ke Gudang:</b> UTM - PUSAT<br>
                </div>
                <!-- /.col -->
            </div>
            <br>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <p class="lead">Detail Item</p>
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-right">#</th>
                                        <th>Barcode</th>
                                        <th>Nama Produk</th>
                                        <th>Satuan</th>
                                        <th class="text-right">Qty<small>Unit</small></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-right">1</td>
                                        <td>1234567899999</td>
                                        <td>Toto Gantungan Double Robe Hook (TX04AES)</td>
                                        <td>DUS</td>
                                        <td class="text-right">10.00</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right">2</td>
                                        <td>12089898398</td>
                                        <td>Toto Floor Drain (TX1DA)</td>
                                        <td>PCS</td>
                                        <td class="text-right">50.00</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-right" colspan="4">TOTAL</th>
                                        <th class="text-right">60.00</th>
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
                            <th class="text-right" width="50%">Diinput Oleh :</th>
                            <td class="text-right" width="50%">Reza</td>
                        </tr>
                        <tr>
                            <th class="text-right">Pada :</th>
                            <td class="text-right"><?= indo_short_date('2022-09-01 10:00:00', false) ?></td>
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