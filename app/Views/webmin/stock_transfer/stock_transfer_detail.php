<?php

$themeUrl = base_url('assets/adminlte3');

$assetsUrl = base_url('assets');

?>

<!DOCTYPE html>

<html lang="en">



<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Detail Transfer Stock</title>



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

                        Detail Transfer Stock

                        <small class="float-right"><?= COMPANY_REGION ?>, <?= indo_date($hdTransfer['hd_transfer_stock_date'], FALSE) ?></small>

                    </h2>

                </div>

                <!-- /.col -->

            </div>

            <!-- info row -->

            <div class="row invoice-info">

                <div class="col-sm-4 invoice-col">

                    <p>Dari Gudang:<br />
                    <b><?= esc($hdTransfer['warehouse_from_code']) ?> - <?= esc($hdTransfer['warehouse_from_name']) ?></b><br>
                       <?= esc($hdTransfer['warehouse_from_address']) ?><br>
                   </p>


                </div>

                <div class="col-sm-4 invoice-col">

                    <p>Ke Gudang:<br />
                    <b><?= esc($hdTransfer['warehouse_to_code']) ?> - <?= esc($hdTransfer['warehouse_to_name']) ?></b><br>
                       <?= esc($hdTransfer['warehouse_to_address']) ?><br>
                   </p>

                </div>

                <div class="col-sm-4 invoice-col">
                    <p><b><?= esc($hdTransfer['hd_transfer_stock_no']) ?></b><br>
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

                                <th class="text-right">Qty</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php

                            foreach ($dtTransfer as $row) :

                                $detai_item_qty = floatval($row['item_qty']);
                                ?>

                                <tr>

                                    <td><?= esc($row['product_code']) ?></td>

                                    <td><?= esc($row['product_name']) ?>(<?= esc($row['unit_name']) ?>)</td>

                                    <td class="text-right">Rp <?= numberFormat($detai_item_qty, TRUE) ?></td>

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

                                <td><?= esc($hdTransfer['user_realname']) ?></td>

                                <td><?= indo_date($hdTransfer['created_at']) ?></td>

                            </tr>


                            <tr>

                                <th>Catatan:</th>

                                <td colspan="2"><?= esc($hdTransfer['hd_transfer_stock_remark']) ?></td>

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