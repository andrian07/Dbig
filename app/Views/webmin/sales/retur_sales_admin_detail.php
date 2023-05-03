<?php

$themeUrl = base_url('assets/adminlte3');

$assetsUrl = base_url('assets');

?>

<!DOCTYPE html>

<html lang="en">



<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Detail Retur Penjualan Admin</title>



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

                        Detail Transaksi

                        <small class="float-right"><?= COMPANY_REGION ?>, <?= indo_date($hdRetur['hd_retur_date'], FALSE) ?></small>

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

                    <p>Customer:<br />
                    <b><?= esc($hdRetur['customer_name']) ?></b><br>
                       <?= esc($hdRetur['customer_address']) ?><br>
                       <?= esc($hdRetur['customer_phone']) ?>
                   </p>

                </div>

                <div class="col-sm-4 invoice-col">
                    <p><b><?= esc($hdRetur['hd_retur_sales_admin_invoice']) ?></b><br>
                    </p>
                </div>

                <!-- /.col -->

            </div>

            <br>

            <!-- /.row -->



            <!-- Table row -->

            <div class="row">

                <div class="col-12 table-responsive">

                    <table class="table table-striped">

                        <thead>

                            <tr>

                                <th>Kode Produk</th>

                                <th>Nama Produk</th>

                                <th class="text-right">Harga</th>

                                <th class="text-right">Qty</th>

                                <th class="text-right">PPN</th>

                                <th class="text-right">Total</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php

                            foreach ($dtRetur as $row) :

            
                                $retur_price = floatval($row['dt_retur_price']);
                                $retur_qty = floatval($row['dt_retur_qty']);
                                $retur_ppn = floatval($row['dt_retur_ppn']);
                                $retur_total = floatval($row['dt_retur_total']);
                                ?>

                                <tr>

                                    <th><?= esc($row['product_code']) ?></th>

                                    <th><?= esc($row['product_name']) ?>(<?= esc($row['unit_name']) ?>)</th>

                                    <th class="text-right">Rp <?= numberFormat($retur_price, TRUE) ?></th>

                                    <th class="text-right"><?= numberFormat($retur_qty, TRUE) ?></th>

                                    <th class="text-right">Rp <?= numberFormat($retur_ppn, TRUE) ?></th>

                                    <th class="text-right">Rp <?= numberFormat($retur_total, TRUE) ?></th>

                                </tr>

                                <?php

                            endforeach;

                            ?>

                        </tbody>

                    </table>

                </div>

                <!-- /.col -->

            </div>

            <!-- /.row -->



            <div class="row">

                <!-- accepted payments column -->

                <div class="col-md-6 col-xs-12 order-md-2">

                    <p class="lead">&nbsp;</p>

                    <div class="table-responsive">

                        <table class="table">

                            <tr>

                                <th>Total:</th>

                                <td class="text-right">Rp. <?= numberFormat($hdRetur['hd_retur_total_transaction']) ?></td>

                            </tr>

                        </table>

                    </div>

                </div>




                <div class="col-md-6 col-xs-12 order-md-1">

                    <p class="lead">Logs:</p>

                    <div class="table-responsive">

                        <table class="table">

                            <tr>

                                <th>Action</th>

                                <th>User</th>

                                <th>DateTime</th>

                            </tr>

                            <tr>

                                <th style="width:10%">Created</th>

                                <td><?= esc($hdRetur['user_realname']) ?></td>

                                <td><?= indo_date($hdRetur['created_at']) ?></td>

                            </tr>

                            <?php /*
                            <?php foreach ($logupdate as $log) : ?>

                                <tr>

                                    <th>Edit</th>

                                    <td><?= esc($hdRetur['user_realname']) ?></td>

                                    <td><?= indo_date($hdRetur['created_at']) ?></td>

                                </tr>

                            <?php endforeach;  ?>

                            */ ?>
                            <tr>

                                <th>Catatan:</th>

                                <td colspan="2"><?= esc($hdRetur['hd_retur_desc']) ?></td>

                            </tr>

                        </table>

                    </div>

                </div>


                <!-- /.col -->



                <!-- /.col -->

            </div>

            <!-- /.row -->

        </section>

        <!-- /.content -->

    </div>

    <!-- ./wrapper -->

    <!-- Page specific script -->

</body>



</html>