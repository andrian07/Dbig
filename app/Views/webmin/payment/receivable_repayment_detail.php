<?php
$themeUrl = base_url('assets/adminlte3');
$assetsUrl = base_url('assets');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Pelunasan PIUTANG</title>

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
                        Pelunasan Piutang
                        <small class="float-right"><?= indo_date($hdReceivable['payment_receivable_date'], false) ?></small>
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
                    <h2>#<?= esc($hdReceivable['payment_receivable_invoice']) ?></b></h2>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    <b>Kode Pelanggan:</b> <?= esc($hdReceivable['customer_code']) ?><br>
                    <b>Nama Pelanggan:</b> <?= esc($hdReceivable['customer_name']) ?><br>
                    <b>Alamat:</b> <?= esc($hdReceivable['customer_address']) ?><br>
                    <b>No Telp:</b> <?= esc($hdReceivable['customer_phone']) ?><br>
                    <b>Metode Pembayaran:</b> <?= esc($hdReceivable['payment_receivable_method_name']) ?><br>
                </div>
                <!-- /.col -->
            </div>
            <br>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <p class="lead">Detail Pelunasan</p>
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No Invoice</th>
                                        <th>Tanggal<br>Invoice</th>
                                        <th>Keterangan</th>
                                        <th class="text-right">Pembulatan/Disc</th>
                                        <th class="text-right">Pembayaran</th>
                                        <th class="text-right">Total Pelunasan</th>
                                    </tr>
                                </thead>
                                <tbody>

                                   <?php

                                   foreach ($dtReceivable as $row) :

                                    $sales_admin_invoice               = $row['sales_admin_invoice'];
                                    $sales_date                        = $row['sales_date'];
                                    $dt_payment_receivable_desc        = $row['dt_payment_receivable_desc'];
                                    $dt_payment_receivable_discount    = floatval($row['dt_payment_receivable_discount']);
                                    $dt_payment_receivable_nominal     = floatval($row['dt_payment_receivable_nominal']);
                                    $detail_sales_po_total             = $dt_payment_receivable_nominal + $dt_payment_receivable_discount;
                                    ?>

                                    <tr>
                                        <td><?= esc($sales_admin_invoice) ?></td>
                                        <td><?= indo_short_date($sales_date) ?></td>
                                        <td><?= esc($dt_payment_receivable_desc) ?></td>
                                        <td class="text-right">Rp. <?= numberFormat($dt_payment_receivable_discount, true) ?></td>
                                        <td class="text-right">Rp. <?= numberFormat($dt_payment_receivable_nominal, true) ?></td>
                                        <td class="text-right">Rp. <?= numberFormat($detail_sales_po_total, true) ?></td>
                                    </tr>

                                    <?php
                                    endforeach;
                                    ?>
                            </tfoot>
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