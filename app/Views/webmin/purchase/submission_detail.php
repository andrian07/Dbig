<?php

$themeUrl = base_url('assets/adminlte3');

$assetsUrl = base_url('assets');

?>

<!DOCTYPE html>

<html lang="en">



<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Detail Pesanan Pembelian</title>



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

                        <small class="float-right"><?= COMPANY_REGION ?>, <?= indo_date($hdsubmission['submission_date'], FALSE) ?></small>

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

                    <b><?= esc($hdsubmission['submission_inv']) ?></b><br>

                </div>

                <div class="col-sm-4 invoice-col">

                       <p>Supplier:<b> <?= esc($hdsubmission['supplier_name']) ?></b></p>
                       <p>Gudang:<b> <?= esc($hdsubmission['warehouse_name']) ?></b></p>
                       <p>Sales:<b> <?= esc($hdsubmission['salesman_name']) ?></b></p>
                       <p>Status:<b> <?= esc($hdsubmission['submission_item_status']) ?></b></p>
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

                                <th>Kode Item</th>

                                <th>Nama Produk</th>

                                <th class="text-right">Qty Order</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php

                            foreach ($dtsubmision as $row) :

                                $dt_submission_qty = floatval($row['dt_submission_qty']);
                                ?>

                                <tr>

                                    <th><?= esc($row['product_code']) ?></th>

                                    <th><?= esc($row['product_name']) ?>(<?= esc($row['unit_name']) ?>)</th>

                                    <th class="text-right">Rp <?= numberFormat($dt_submission_qty, TRUE) ?></th>

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

                                <th>Catatan:</th>

                                <td><?= esc($hdsubmission['submission_desc']) ?></td>

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

                                <td><?= esc($hdsubmission['user_realname']) ?></td>

                                <td><?= indo_date($hdsubmission['created_at']) ?></td>

                            </tr>


                            <?php foreach ($logupdate as $log) : ?>

                                <tr>

                                    <th>Edit</th>

                                    <td><?= esc($log['user_realname']) ?></td>

                                    <td><?= indo_date($log['created_at']) ?></td>

                                </tr>

                            <?php endforeach;  ?>



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