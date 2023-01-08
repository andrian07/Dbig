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
                            <?= indo_date($header['opname_date'], false) ?>
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
                    <b>#<?= esc($header['opname_code']) ?></b><br>
                    <br>
                    <b>Kode Gudang:</b> <?= esc($header['warehouse_code']) ?><br>
                    <b>Nama Gudang:</b> <?= esc($header['warehouse_name']) ?><br>
                    <b>Alamat:</b> <?= esc($header['warehouse_address']) ?><br>
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
                                        <th>Exp Date</th>
                                        <th class="text-right">HPP</th>
                                        <th class="text-right">Stok Fisik</th>
                                        <th class="text-right">Stok System</th>
                                        <th class="text-right">Selisih <small>Unit</small></th>
                                        <th>Keterangan</th>
                                        <th class="text-right">Selisih <small>Rp</small></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($detail as $row) :
                                        $base_cogs                  = floatval($row['base_cogs']);
                                        $warehouse_stock            = floatval($row['warehouse_stock']);
                                        $system_stock               = floatval($row['system_stock']);
                                        $diff_stock                 = $warehouse_stock - $system_stock;
                                        $opname_stock_difference    = floatval($row['opname_stock_difference']);
                                    ?>
                                        <tr>
                                            <td><?= esc($row['product_code']) ?></td>
                                            <td><?= esc($row['product_name']) ?></td>
                                            <td><?= indo_short_date($row['exp_date']) ?></td>
                                            <td class="text-right"><?= numberFormat($base_cogs, TRUE) ?></td>
                                            <td class="text-right"><?= numberFormat($warehouse_stock, TRUE) ?></td>
                                            <td class="text-right"><?= numberFormat($system_stock, TRUE) ?></td>
                                            <td class="text-right"><?= numberFormat($diff_stock, TRUE) ?></td>
                                            <td><?= esc($row['detail_remark']) ?></td>
                                            <td class="text-right"><?= numberFormat($opname_stock_difference, TRUE) ?></td>
                                        </tr>
                                    <?php
                                    endforeach;
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-right" colspan="8">TOTAL</th>
                                        <th class="text-right"><?= numberFormat($header['opname_total'], true) ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.col -->
                    </div>
                </div>
                <div class="col-md-8 col-xs-12">

                </div>
                <div class="col-md-4 col-xs-12">
                    <table width="100%">
                        <tr>
                            <th class="text-right" width="50%">Diopname Oleh :</th>
                            <td class="text-right" width="50%"><?= esc($header['user_realname']) ?></td>
                        </tr>
                        <tr>
                            <th class="text-right">Pada :</th>
                            <td class="text-right"><?= indo_short_date($header['created_at'], false) ?></td>
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