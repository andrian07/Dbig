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
                        Detail Produk
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
                    <b>#P000002</b><br>
                    <br>
                    <b>Nama Produk:</b> Toto Gantungan Double Robe Hook (TX04AES)<br>
                    <b>Kategori:</b> Gantungan<br>
                    <b>Brand:</b> Toto<br>
                    <b>Supplier:</b> <span class="badge badge-primary">PT IKAD INDONESIA</span>&nbsp;<span class="badge badge-primary">PT NIPPON INDONESIA</span><br>
                    <b>Jenis Produk:</b> Barang Tidak Dikenakan Pajak (NON BKP)<br>
                    <b>Status:</b> <span class="badge badge-success">Aktif</span><br>
                </div>
                <!-- /.col -->
            </div>
            <br>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <p class="lead">Harga dan Satuan</p>
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th rowspan="2">Kode Item</th>
                                        <th rowspan="2">Satuan</th>
                                        <th rowspan="2" class="text-right">Isi</th>
                                        <th rowspan="2" class="text-right">DPP</th>
                                        <th rowspan="2" class="text-right">PPN</th>
                                        <th rowspan="2" class="text-right">Harga Beli</th>
                                        <th colspan="2" class="text-center">G1 - UMUM</th>
                                        <th colspan="2" class="text-center">G2 - SILVER</th>
                                        <th colspan="2" class="text-center">G3 - GOLD</th>
                                        <th colspan="2" class="text-center">G4 - PLATINUM</th>
                                        <th colspan="2" class="text-center">G5 - PROYEK</th>
                                        <th colspan="2" class="text-center">G6 - CUSTOM</th>
                                        <th rowspan="2" class="text-right">Dijual</th>
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
                                        <td>1234567890123</td>
                                        <td>PCS</td>
                                        <td class="text-right">1.00</td>
                                        <td class="text-right">25,000.00</td>
                                        <td class="text-right">2,750.00</td>
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
                                        <td class="text-center">
                                            <span class="badge badge-success"><i class="fas fa-check-circle"></i></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>1234567899999</td>
                                        <td>DUS</td>
                                        <td class="text-right">50.00</td>
                                        <td class="text-right">1,250,000.00</td>
                                        <td class="text-right">137,500.00</td>
                                        <td class="text-right">1,387,500.00</td>
                                        <td class="text-right">50.00</td>
                                        <td class="text-right">2,081,300.00</td>
                                        <td class="text-right">40.00</td>
                                        <td class="text-right">1,942,500.00</td>
                                        <td class="text-right">30.00</td>
                                        <td class="text-right">1,803,800.00</td>
                                        <td class="text-right">20.00</td>
                                        <td class="text-right">1,665,000.00</td>
                                        <td class="text-right">20.00</td>
                                        <td class="text-right">1,665,000.00</td>
                                        <td class="text-right">50.00</td>
                                        <td class="text-right">2,081,300.00</td>
                                        <td class="text-center">
                                            <span class="badge badge-danger"><i class="fas fa-times-circle"></i></span>
                                        </td>
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
                    <p class="lead">Stock List</p>
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Kode Gudang</th>
                                        <th>Toko</th>
                                        <th>Nama Gudang</th>
                                        <th class="text-right">Stok</th>
                                        <th>Satuan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>KBR</td>
                                        <td>CABANG KOTA BARU</td>
                                        <td>KOTA BARU</td>
                                        <td class="text-right">250.00</td>
                                        <td>PCS</td>
                                    </tr>
                                    <tr>
                                        <td>UTM</td>
                                        <td>PUSAT</td>
                                        <td>PUSAT</td>
                                        <td class="text-right">500.00</td>
                                        <td>PCS</td>
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