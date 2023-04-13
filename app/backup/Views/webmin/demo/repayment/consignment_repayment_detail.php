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
                        Pelunasan Konsinyasi
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
                    <b>#PK/UTM/22/08/00001</b><br>
                    <br>
                    <b>Kode Supplier:</b> NPPI<br>
                    <b>Nama Supplier:</b> PT NIPPON INDONESIA<br>
                    <b>Alamat:</b> Jl Sungai Raya Dalam Komplek ABC No.10<br>
                    <b>No Telp:</b> 0896-7899-8888<br>
                    <b>Metode Pembayaran:</b> BCA a.n d'BIG (089989889888888)<br>
                </div>
                <!-- /.col -->
            </div>
            <br>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <p class="lead">Detail Pembayaran</p>
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-right">#</th>
                                        <th>No Pembelian</th>
                                        <th>No Faktur</th>
                                        <th>Barcode</th>
                                        <th>Nama Produk</th>
                                        <th class="text-right">DPP</th>
                                        <th class="text-right">PPN</th>
                                        <th class="text-right">QTY</th>
                                        <th class="text-right">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-right">1</td>
                                        <td>PI/UTM/22/08/00001</td>
                                        <td>FK0001</td>
                                        <td>1234567899999</td>
                                        <td>Toto Gantungan Double Robe Hook (TX04AES)</td>
                                        <td class="text-right">100,000.00</td>
                                        <td class="text-right">10,000.00</td>
                                        <td class="text-right">5.00</td>
                                        <td class="text-right">550,000.00</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right">2</td>
                                        <td>PI/UTM/22/08/00002</td>
                                        <td>FK0002</td>
                                        <td>1234567899999</td>
                                        <td>Toto Gantungan Double Robe Hook (TX04AES)</td>
                                        <td class="text-right">100,000.00</td>
                                        <td class="text-right">11,000.00</td>
                                        <td class="text-right">5.00</td>
                                        <td class="text-right">555,000.00</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right">3</td>
                                        <td>PI/UTM/22/08/00001</td>
                                        <td>FK0001</td>
                                        <td>12089898398</td>
                                        <td>Toto Floor Drain (TX1DA) </td>
                                        <td class="text-right">25,000.00</td>
                                        <td class="text-right">2,750.00</td>
                                        <td class="text-right">50.00</td>
                                        <td class="text-right">1,387,500.00</td>
                                    </tr>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="8" class="text-right">TOTAL</th>
                                        <th class="text-right">2,442,500.00</th>
                                    </tr>
                                </tfoot>
                            </table>

                            <p><b>Keterangan</b> : -</p>
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