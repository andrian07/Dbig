<?php

$themeUrl = base_url('assets/adminlte3');

$assetsUrl = base_url('assets');

?>

<!DOCTYPE html>

<html lang="en">



<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Detail PO</title>



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

                        <small class="float-right"><?= COMPANY_REGION ?>, <?= indo_date($hdPO['purchase_order_date'], FALSE) ?></small>

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
                    <b><?= esc($hdPO['supplier_name']) ?></b><br>
                       <?= esc($hdPO['supplier_address']) ?><br>
                       <?= esc($hdPO['supplier_phone']) ?>
                   </p>

                </div>

                <div class="col-sm-4 invoice-col">
                    <p><b>PO-<?= esc($hdPO['purchase_order_invoice']) ?></b><br>
                       No Pengajuan: <b><?= esc($hdPO['purchase_order_submission_inv']) ?></b><br>
                       Status :
                        <?php if($hdPO['purchase_order_status'] == 'Pending'){ ?>
                        <span class="badge badge-primary">Pending</span>
                        <?php } ?>
                        <?php if($hdPO['purchase_order_status'] == 'Selesai'){ ?>
                        <span class="badge badge-success">Selesai</span>
                        <?php } ?>
                        <?php if($hdPO['purchase_order_status'] == 'Batal'){ ?>
                        <span class="badge badge-danger">Batal</span>
                        <?php } ?>
                        <br>
                        Gudang : <b><?= esc($hdPO['store_code']) ?>/<?= esc($hdPO['store_name']) ?></b>
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

                                <th class="text-right">Harga Satuan</th>

                                <th class="text-right">Qty</th>

                                <th class="text-right">Diskon</th>

                                <th class="text-right">Ongkir</th>

                                <th class="text-right">E.D</th>

                                <th class="text-right">Total</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php

                            foreach ($dtPO as $row) :

                                $detail_purchase_po_price = floatval($row['detail_purchase_po_price']);
                                $detail_purchase_po_qty = floatval($row['detail_purchase_po_qty']);
                                $detail_purchase_po_total_discount = floatval($row['detail_purchase_po_total_discount']);
                                $detail_purchase_po_ongkir = floatval($row['detail_purchase_po_ongkir']);
                                $detail_purchase_po_total = floatval($row['detail_purchase_po_total']);
                                ?>

                                <tr>

                                    <th><?= esc($row['product_code']) ?></th>

                                    <th><?= esc($row['product_name']) ?>(<?= esc($row['unit_name']) ?>)</th>

                                    <th class="text-right">Rp <?= numberFormat($detail_purchase_po_price, TRUE) ?></th>

                                    <th class="text-right"><?= numberFormat($detail_purchase_po_qty, TRUE) ?></th>

                                    <th class="text-right">Rp <?= numberFormat($detail_purchase_po_total_discount, TRUE) ?></th>

                                    <th class="text-right">Rp <?= numberFormat($detail_purchase_po_ongkir, TRUE) ?></th>

                                    <th class="text-right"><?= esc($row['detail_purchase_po_expire_date']) ?></th>

                                    <th class="text-right">Rp <?= numberFormat($detail_purchase_po_total, TRUE) ?></th>

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

                                <th>Sub Total:</th>

                                <td class="text-right">Rp. <?= numberFormat($hdPO['purchase_order_sub_total']) ?></td>

                            </tr>

                            <tr>

                                <th>Discount:</th>

                                <td class="text-right">Rp. <?= numberFormat($hdPO['purchase_order_total_discount']) ?></td>

                            </tr>

                            <tr>

                                <th>DPP:</th>

                                <td class="text-right">Rp. <?= numberFormat($hdPO['purchase_order_total_dpp']) ?></td>

                            </tr>

                            <tr>

                                <th>PPN:</th>

                                <td class="text-right">Rp. <?= numberFormat($hdPO['purchase_order_total_ppn']) ?></td>

                            </tr>

                            <tr>

                                <th>Ongkir:</th>

                                <td class="text-right">Rp. <?= numberFormat($hdPO['purchase_order_total_ongkir']) ?></td>

                            </tr>

                            <tr>

                                <th>Grand Total:</th>

                                <td class="text-right">Rp. <?= numberFormat($hdPO['purchase_order_total']) ?></td>

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

                                <td><?= esc($hdPO['user_realname']) ?></td>

                                <td><?= indo_date($hdPO['created_at']) ?></td>

                            </tr>


                            <?php foreach ($logupdate as $log) : ?>

                                <tr>

                                    <th>Edit</th>

                                    <td><?= esc($log['user_realname']) ?></td>

                                    <td><?= indo_date($log['created_at']) ?></td>

                                </tr>

                            <?php endforeach;  ?>


                            <tr>

                                <th>Catatan:</th>

                                <td colspan="2"><?= esc($hdPO['purchase_order_remark']) ?></td>

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