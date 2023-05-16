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
                    <?php
                    $label_status = '';
                    switch ($detail['exchange_status']) {
                        case 'pending':
                            $label_status = '<span class="badge badge-primary">Proses</span>';
                            break;
                        case 'success':
                            $label_status = ' <span class="badge badge-success">Selesai</span>';
                            break;
                        case 'cancel':
                            $label_status = '<span class="badge badge-danger">Batal</span>';
                            break;
                    }
                    ?>
                    <b>#<?= $detail['exchange_code'] ?></b><br>
                    <br>
                    <b>Nama Customer:</b> <?= $detail['customer_name'] ?><br>
                    <b>Grup:</b> <?= isset($config_label_group[$detail['customer_group']]) ? $config_label_group[$detail['customer_group']] : 'NO CONFIG' ?><br>
                    <b>Alamat:</b> <?= $detail['customer_address'] ?><br>
                    <b>Alamat Pengiriman:</b> <?= $detail['customer_delivery_address'] ?><br>
                    <b>No Telp:</b> <?= $detail['customer_phone'] ?><br>
                    <b>Status Penukaran:</b> <?= $label_status ?><br>
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
                            <?php
                            $exchange_date = $detail['exchange_date'];
                            $completed_at  = substr($detail['completed_at'], 0, 10);
                            $completed_by  = $detail['completed_by'] == '0' ? '-' : $detail['completed_by_realname'];
                            ?>
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
                                        <td><?= indo_short_date($exchange_date) ?></td>
                                        <td><b><?= $detail['reward_code'] ?></b><br><?= $detail['reward_name'] ?></td>
                                        <td class="text-right"><?= numberFormat($detail['reward_point']) ?></td>
                                        <td><?= indo_short_date($completed_at) ?></td>
                                        <td><?= $completed_by ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.col -->
                    </div>
                </div>
                <div class="col-md-12 col-xs-12">
                    <?php
                    $lokasi_pengambilan = '-';
                    if (intval($detail['store_id']) > 0) {
                        $lokasi_pengambilan = '<b>' . $detail['store_name'] . '</b><br>' . $detail['store_address'];
                    }
                    ?>
                    <p>
                        Lokasi Pengambilan Hadiah: <?= $lokasi_pengambilan ?>
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