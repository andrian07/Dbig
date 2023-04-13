<?php

$themeUrl = base_url('assets/adminlte3');

$assetsUrl = base_url('assets');

?>

<!DOCTYPE html>

<html lang="en">



<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Detail Penjualan</title>



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

                        <small class="float-right"><?= COMPANY_REGION ?>, <?= indo_date($hdSales['sales_date'], FALSE) ?></small>

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
                        <b><?= esc($hdSales['customer_name']) ?></b><br>
                        <?= esc($hdSales['customer_address']) ?><br>
                        <?= esc($hdSales['customer_phone']) ?>
                    </p>

                </div>

                <div class="col-sm-4 invoice-col">
                    <p><b><?= esc($hdSales['sales_admin_invoice']) ?></b><br>
                     Status :
                     <?php if($hdSales['sales_admin_remaining_payment'] <= 0){ ?>
                        <span class="badge badge-success">Lunas</span>
                    <?php }else{ ?>
                        <span class="badge badge-danger">Belum Lunas</span>
                    <?php } ?>
                    <br>
                    Store : <b><?= esc($hdSales['store_code']) ?>/<?= esc($hdSales['store_name']) ?></b>
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
                          <th width="5%">No</th>

                          <th width="15%">Kode Barang</th>

                          <th width="40%">Nama Barang</th>

                          <th width="10%">Kuantitas</th>

                          <th width="10%">Harga</th>

                          <th width="10%">Discount</th>

                          <th width="10%">Jumlah</th>

                      </tr>

                  </thead>

                  <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($dtSales as $row) : 

                        $detail_product_price = floatval($row['dt_product_price']);
                        $detail_sales_qty = floatval($row['dt_temp_qty']);
                        $detail_sales_discount = floatval($row['dt_disc1'] + $row['dt_disc2'] + $row['dt_disc3']);
                        $detail_sales_price= floatval($row['dt_sales_price']);

                        ?>


                        <tr>

                            <td><?= $i; ?></td>

                            <td><?= esc($row['product_code']) ?></td>

                            <td><?= esc($row['product_name']) ?></td>

                            <td class="text-center"><?= $detail_sales_qty ?></td>

                            <td>Rp. <?= numberFormat($detail_product_price) ?></td>

                            <td>Rp. <?= numberFormat($detail_sales_discount) ?></td>

                            <td>Rp. <?= numberFormat($detail_sales_price) ?></td>

                        </tr>
                        <?php $i++ ?>
                    <?php endforeach;  ?>

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

                        <td class="text-right">Rp. <?= numberFormat($hdSales['sales_admin_subtotal']) ?></td>

                    </tr>

                    <tr>

                        <th>Discount 1: (<?= floatval($hdSales['sales_admin_discount1_percentage']) ?>%)</th>

                        <td class="text-right">Rp. <?= numberFormat($hdSales['sales_admin_discount1']) ?></td>

                    </tr>

                    <tr>

                        <th>Discount 2: (<?= floatval($hdSales['sales_admin_discount2_percentage']) ?>%)</th>

                        <td class="text-right">Rp. <?= numberFormat($hdSales['sales_admin_discount2']) ?></td>

                    </tr>

                    <tr>

                        <th>Discount 3: (<?= floatval($hdSales['sales_admin_discount3_percentage']) ?>%)</th>

                        <td class="text-right">Rp. <?= numberFormat($hdSales['sales_admin_discount3']) ?></td>

                    </tr>

                    <tr>

                        <th>PPN:</th>

                        <td class="text-right">Rp. <?= numberFormat($hdSales['sales_admin_ppn']) ?></td>

                    </tr>

                    <tr>

                        <th>Grand Total:</th>

                        <td class="text-right">Rp. <?= numberFormat($hdSales['sales_admin_grand_total']) ?></td>

                    </tr>

                    <tr>

                        <th>DP:</th>

                        <td class="text-right">Rp. <?= numberFormat($hdSales['sales_admin_down_payment']) ?></td>

                    </tr>

                    <tr>

                        <th>Sisa Pembayaran:</th>

                        <td class="text-right">Rp. <?= numberFormat($hdSales['sales_admin_remaining_payment']) ?></td>

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

                        <td><?= esc($hdSales['user_realname']) ?></td>

                        <td><?= indo_date($hdSales['created_at']) ?></td>

                    </tr>


                    <tr>

                        <th>Catatan:</th>

                        <td colspan="2"><?= esc($hdSales['sales_admin_remark']) ?></td>

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