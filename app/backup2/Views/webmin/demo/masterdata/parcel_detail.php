<?php
$themeUrl = base_url('assets/adminlte3');
$assetsUrl = base_url('assets');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Paket</title>

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
                        Detail Paket
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
                    <b>#P000003</b><br>
                    <br>
                    <b>Nama Produk:</b> Paket Double Toto<br>
                    <b>Kategori:</b> Paket<br>
                    <b>Brand:</b> Paket<br>
                    <b>Supplier:</b> <span class="badge badge-primary">d'BIG</span><br>
                    <b>Jenis Produk:</b> Barang Dikenakan Pajak (BKP)<br>
                    <b>Status:</b> <span class="badge badge-success">Aktif</span><br>
                </div>
                <!-- /.col -->
            </div>
            <br>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <p class="lead">Daftar Produk Paket</p>
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th rowspan="2">Item</th>
                                        <th rowspan="2" class="text-right">Qty</th>
                                        <th rowspan="2">Satuan</th>
                                        <th rowspan="2" class="text-right">Harga Beli</th>
                                        <th colspan="2" class="text-center">G1 - UMUM</th>
                                        <th colspan="2" class="text-center">G2 - SILVER</th>
                                        <th colspan="2" class="text-center">G3 - GOLD</th>
                                        <th colspan="2" class="text-center">G4 - PLATINUM</th>
                                        <th colspan="2" class="text-center">G5 - PROYEK</th>
                                        <th colspan="2" class="text-center">G6 - CUSTOM</th>
                                    </tr>
                                    <tr>
                                        <th class="text-right">Margin</th>
                                        <th class="text-right">Hrg.Jual</th>
                                        <th class="text-right">Margin</th>
                                        <th class="text-right">Hrg.Jual</th>
                                        <th class="text-right">Margin</th>
                                        <th class="text-right">Hrg.Jual</th>
                                        <th class="text-right">Margin</th>
                                        <th class="text-right">Hrg.Jual</th>
                                        <th class="text-right">Margin</th>
                                        <th class="text-right">Hrg.Jual</th>
                                        <th class="text-right">Margin</th>
                                        <th class="text-right">Hrg.Jual</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <b>1234567890123</b> <br />
                                            Toto Gantungan Double Robe Hook (TX04AES)
                                        </td>
                                        <td class="text-right">1.00</td>
                                        <td>PCS</td>
                                        <td class="text-right">27,750.00</td>
                                        <td class="text-right">50.00</td>
                                        <td class="text-right">41,700.00</td>
                                        <td class="text-right">40.00</td>
                                        <td class="text-right">38,900.00</td>
                                        <td class="text-right">30.00</td>
                                        <td class="text-right">36,100.00</td>
                                        <td class="text-right">20.00</td>
                                        <td class="text-right">33,300.00</td>
                                        <td class="text-right">20.00</td>
                                        <td class="text-right">33,300.00</td>
                                        <td class="text-right">50.00</td>
                                        <td class="text-right">41,700.00</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>1234567877777</b> <br />
                                            Toto Floor Drain (TX1DA)
                                        </td>
                                        <td class="text-right">2.00</td>
                                        <td>PCS</td>
                                        <td class="text-right">50,000.00</td>
                                        <td class="text-right">50.00</td>
                                        <td class="text-right">75,000.00</td>
                                        <td class="text-right">40.00</td>
                                        <td class="text-right">70,000.00</td>
                                        <td class="text-right">30.00</td>
                                        <td class="text-right">65,000.00</td>
                                        <td class="text-right">20.00</td>
                                        <td class="text-right">60,000.00</td>
                                        <td class="text-right">20.00</td>
                                        <td class="text-right">60,000.00</td>
                                        <td class="text-right">50.00</td>
                                        <td class="text-right">75,000.00</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                        <!-- /.col -->
                    </div>
                </div>

            </div>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <p class="lead">Harga Jual Paket</p>
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th rowspan="2">Kode Item</th>
                                        <th rowspan="2">Satuan</th>
                                        <th rowspan="2" class="text-right">TOTAL DPP</th>
                                        <th rowspan="2" class="text-right">TOTAL PPN</th>
                                        <th rowspan="2" class="text-right">MODAL PAKET</th>
                                        <th colspan="2" class="text-center">G1 - UMUM</th>
                                        <th colspan="2" class="text-center">G2 - SILVER</th>
                                        <th colspan="2" class="text-center">G3 - GOLD</th>
                                        <th colspan="2" class="text-center">G4 - PLATINUM</th>
                                        <th colspan="2" class="text-center">G5 - PROYEK</th>
                                        <th colspan="2" class="text-center">G6 - CUSTOM</th>
                                    </tr>
                                    <tr>
                                        <th class="text-right">Margin</th>
                                        <th class="text-right">Hrg.Jual</th>
                                        <th class="text-right">Margin</th>
                                        <th class="text-right">Hrg.Jual</th>
                                        <th class="text-right">Margin</th>
                                        <th class="text-right">Hrg.Jual</th>
                                        <th class="text-right">Margin</th>
                                        <th class="text-right">Hrg.Jual</th>
                                        <th class="text-right">Margin</th>
                                        <th class="text-right">Hrg.Jual</th>
                                        <th class="text-right">Margin</th>
                                        <th class="text-right">Hrg.Jual</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>9999999888777</td>
                                        <td>PCS</td>
                                        <td class="text-right">75,000.00</td>
                                        <td class="text-right">2,750.00</td>
                                        <td class="text-right">77,750.00</td>
                                        <td class="text-right">45.00</td>
                                        <td class="text-right">112,800.00</td>
                                        <td class="text-right">35.00</td>
                                        <td class="text-right">105,000.00</td>
                                        <td class="text-right">25.00</td>
                                        <td class="text-right">97,200.00</td>
                                        <td class="text-right">15.00</td>
                                        <td class="text-right">89,500.00</td>
                                        <td class="text-right">15.00</td>
                                        <td class="text-right">89,500.00</td>
                                        <td class="text-right">45.00</td>
                                        <td class="text-right">112,800.00</td>

                                    </tr>
                                </tbody>
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