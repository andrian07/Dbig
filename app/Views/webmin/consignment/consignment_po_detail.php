<?php

$themeUrl = base_url('assets/adminlte3');

$assetsUrl = base_url('assets');

?>

<!DOCTYPE html>

<html lang="en">



<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Detail PO Konsinyasi</title>



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

                        <small class="float-right"><?= COMPANY_REGION ?>, <?= indo_date($hdConsignment['purchase_order_consignment_date'], FALSE) ?></small>

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

                    <p>Supplier:<br />
                    <b><?= esc($hdConsignment['supplier_name']) ?></b><br>
                       <?= esc($hdConsignment['supplier_address']) ?><br>
                       <?= esc($hdConsignment['supplier_phone']) ?>
                   </p>

                </div>

                <div class="col-sm-4 invoice-col">
                    <p><b><?= esc($hdConsignment['purchase_order_consignment_invoice']) ?></b><br>
                       Status :
                        <?php if($hdConsignment['purchase_order_consignment_status'] == 'Pending'){ ?>
                        <span class="badge badge-primary">Pending</span>
                        <?php } ?>
                        <?php if($hdConsignment['purchase_order_consignment_status'] == 'Selesai'){ ?>
                        <span class="badge badge-success">Selesai</span>
                        <?php } ?>
                        <?php if($hdConsignment['purchase_order_consignment_status'] == 'Batal'){ ?>
                        <span class="badge badge-danger">Batal</span>
                        <?php } ?>
                        <br>
                        Gudang : <b><?= esc($hdConsignment['warehouse_code']) ?>/<?= esc($hdConsignment['warehouse_name']) ?></b>
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

                                <th>No Pengajuan</th>

                                <th>Kode Produk</th>

                                <th>Nama Produk</th>

                                <th class="text-right">Qty</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php

                            foreach ($dtConsignment as $row) :

                                $dt_po_consignment_qty = floatval($row['dt_po_consignment_qty']);
                                ?>

                                <tr>

                                    <th><?= esc($row['dt_po_consignment_submission_invoice']) ?></th>

                                    <th><?= esc($row['product_code']) ?></th>

                                    <th><?= esc($row['product_name']) ?>(<?= esc($row['unit_name']) ?>)</th>

                                    <th class="text-right"><?= numberFormat($dt_po_consignment_qty, TRUE) ?></th>

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

                                <td><?= esc($hdConsignment['user_realname']) ?></td>

                                <td><?= indo_date($hdConsignment['created_at']) ?></td>

                            </tr>


                            <?php /*foreach ($logupdate as $log) : ?>

                                <tr>

                                    <th>Edit</th>

                                    <td><?= esc($log['user_realname']) ?></td>

                                    <td><?= indo_date($log['created_at']) ?></td>

                                </tr>

                            <?php endforeach; */ ?>


                            <tr>

                                <th>Catatan:</th>

                                <td colspan="2"><?= esc($hdConsignment['purchase_order_consignment_remark']) ?></td>

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