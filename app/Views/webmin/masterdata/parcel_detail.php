<?php
$themeUrl = base_url('assets/adminlte3');
$assetsUrl = base_url('assets');
?>
<?php
$product_status = $product['active'] == 'Y' ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-danger">Tidak Aktif</span>';
$product_type   = $product['has_tax'] == 'Y' ? 'Barang Kena Pajak (BKP)' : 'Barang Tidak Dikenakan Pajak (NON BKP)';

$list_supplier = [];
foreach ($product_supplier as $ps) {
    $list_supplier[] = '<span class="badge badge-primary">' . $ps['supplier_name'] . '</span>';
}

$parcel_price   = 0;
$parcel_tax     = 0;
$parcel_cost    = 0;

$total_SPG1     = 0;
$total_SPG2     = 0;
$total_SPG3     = 0;
$total_SPG4     = 0;
$total_SPG5     = 0;
$total_SPG6     = 0;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Paket</title>

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
                        Detail Paket
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
                    <b>#<?= esc($product['product_code']) ?></b><br>
                    <br>
                    <b>Nama Produk:</b> <?= esc($product['product_name']) ?><br>
                    <b>Kategori:</b> <?= esc($product['category_name']) ?><br>
                    <b>Brand:</b> <?= esc($product['brand_name']) ?><br>

                    <b>Supplier:</b> <?= implode('&nbsp;', $list_supplier) ?>&nbsp;<br>
                    <b>Jenis Produk:</b> <?= $product_type ?><br>
                    <b>Status:</b> <?= $product_status ?><br>
                </div>
                <!-- /.col -->
            </div>
            <br>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <p class="lead">Daftar Produk Paket</p>
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th rowspan="2">Kode Item</th>
                                        <th rowspan="2">Nama Item</th>
                                        <th rowspan="2" class="text-right">Qty</th>
                                        <th rowspan="2">Satuan</th>
                                        <th rowspan="2" class="text-right">Harga Beli</th>
                                        <th colspan="2" class="text-center">G1 - <?= isset($customer_group['G1']) ? $customer_group['G1'] : 'NO CONFIG' ?></th>
                                        <th colspan="2" class="text-center">G2 - <?= isset($customer_group['G2']) ? $customer_group['G2'] : 'NO CONFIG' ?></th>
                                        <th colspan="2" class="text-center">G3 - <?= isset($customer_group['G3']) ? $customer_group['G3'] : 'NO CONFIG' ?></th>
                                        <th colspan="2" class="text-center">G4 - <?= isset($customer_group['G4']) ? $customer_group['G4'] : 'NO CONFIG' ?></th>
                                        <th colspan="2" class="text-center">G5 - <?= isset($customer_group['G5']) ? $customer_group['G5'] : 'NO CONFIG' ?></th>
                                        <th colspan="2" class="text-center">G6 - <?= isset($customer_group['G6']) ? $customer_group['G6'] : 'NO CONFIG' ?></th>

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
                                    <?php
                                    foreach ($parcel_item as $row) {
                                        $item_qty       = floatval($row['item_qty']);
                                        $purchase_price = floatval($row['purchase_price']) * $item_qty;
                                        $purchase_tax   = floatval($row['purchase_tax']) * $item_qty;
                                        $product_cost   = $purchase_price + $purchase_tax;

                                        $parcel_price   += $purchase_price;
                                        $parcel_tax     += $purchase_tax;
                                        $parcel_cost    += $product_cost;



                                        $SPG1           = floatval($row['G1_sales_price']) * $item_qty;
                                        $SPG2           = floatval($row['G2_sales_price']) * $item_qty;
                                        $SPG3           = floatval($row['G3_sales_price']) * $item_qty;
                                        $SPG4           = floatval($row['G4_sales_price']) * $item_qty;
                                        $SPG5           = floatval($row['G5_sales_price']) * $item_qty;
                                        $SPG6           = floatval($row['G6_sales_price']) * $item_qty;

                                        $MRG1           = calcPercentRate($product_cost, $SPG1);
                                        $MRG2           = calcPercentRate($product_cost, $SPG2);
                                        $MRG3           = calcPercentRate($product_cost, $SPG3);
                                        $MRG4           = calcPercentRate($product_cost, $SPG4);
                                        $MRG5           = calcPercentRate($product_cost, $SPG5);
                                        $MRG6           = calcPercentRate($product_cost, $SPG6);

                                        $total_SPG1     += $SPG1;
                                        $total_SPG2     += $SPG2;
                                        $total_SPG3     += $SPG3;
                                        $total_SPG4     += $SPG4;
                                        $total_SPG5     += $SPG5;
                                        $total_SPG6     += $SPG6;
                                    ?>
                                        <tr>
                                            <td><?= esc($row['item_code']) ?></td>
                                            <td><?= esc($row['product_name']) ?></td>
                                            <td class="text-right"><?= numberFormat($item_qty, true) ?></td>
                                            <td><?= esc($row['unit_name']) ?></td>
                                            <td class="text-right"><?= numberFormat($product_cost, true) ?></td>
                                            <td class="text-right"><?= numberFormat($MRG1, true) ?>%</td>
                                            <td class="text-right"><?= numberFormat($SPG1, true) ?></td>

                                            <td class="text-right"><?= numberFormat($MRG2, true) ?>%</td>
                                            <td class="text-right"><?= numberFormat($SPG2, true) ?></td>

                                            <td class="text-right"><?= numberFormat($MRG3, true) ?>%</td>
                                            <td class="text-right"><?= numberFormat($SPG3, true) ?></td>

                                            <td class="text-right"><?= numberFormat($MRG4, true) ?>%</td>
                                            <td class="text-right"><?= numberFormat($SPG4, true) ?></td>

                                            <td class="text-right"><?= numberFormat($MRG5, true) ?>%</td>
                                            <td class="text-right"><?= numberFormat($SPG5, true) ?></td>

                                            <td class="text-right"><?= numberFormat($MRG6, true) ?>%</td>
                                            <td class="text-right"><?= numberFormat($SPG6, true) ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4" class="text-right">TOTAL</th>
                                        <th class="text-right"><?= numberFormat($parcel_cost, true) ?></th>
                                        <th colspan="2" class="text-right"><?= numberFormat($total_SPG1, true) ?></th>
                                        <th colspan="2" class="text-right"><?= numberFormat($total_SPG2, true) ?></th>
                                        <th colspan="2" class="text-right"><?= numberFormat($total_SPG3, true) ?></th>
                                        <th colspan="2" class="text-right"><?= numberFormat($total_SPG4, true) ?></th>
                                        <th colspan="2" class="text-right"><?= numberFormat($total_SPG5, true) ?></th>
                                        <th colspan="2" class="text-right"><?= numberFormat($total_SPG6, true) ?></th>
                                    </tr>
                                </tfoot>
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
                    <p class="lead">Harga Jual Paket</p>
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th rowspan="2">Kode Item</th>
                                        <th rowspan="2">Satuan</th>
                                        <th rowspan="2" class="text-right">TOTAL DPP</th>
                                        <th rowspan="2" class="text-right">TOTAL PPN</th>
                                        <th rowspan="2" class="text-right">MODAL PAKET</th>
                                        <th colspan="2" class="text-center">G1 - <?= isset($customer_group['G1']) ? $customer_group['G1'] : 'NO CONFIG' ?></th>
                                        <th colspan="2" class="text-center">G2 - <?= isset($customer_group['G2']) ? $customer_group['G2'] : 'NO CONFIG' ?></th>
                                        <th colspan="2" class="text-center">G3 - <?= isset($customer_group['G3']) ? $customer_group['G3'] : 'NO CONFIG' ?></th>
                                        <th colspan="2" class="text-center">G4 - <?= isset($customer_group['G4']) ? $customer_group['G4'] : 'NO CONFIG' ?></th>
                                        <th colspan="2" class="text-center">G5 - <?= isset($customer_group['G5']) ? $customer_group['G5'] : 'NO CONFIG' ?></th>
                                        <th colspan="2" class="text-center">G6 - <?= isset($customer_group['G6']) ? $customer_group['G6'] : 'NO CONFIG' ?></th>
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
                                    <?php
                                    foreach ($product_unit as $row) {
                                        $SPG1           = floatval($row['G1_sales_price']);
                                        $SPG2           = floatval($row['G2_sales_price']);
                                        $SPG3           = floatval($row['G3_sales_price']);
                                        $SPG4           = floatval($row['G4_sales_price']);
                                        $SPG5           = floatval($row['G5_sales_price']);
                                        $SPG6           = floatval($row['G6_sales_price']);

                                        $MRG1           = calcPercentRate($parcel_cost, $SPG1);
                                        $MRG2           = calcPercentRate($parcel_cost, $SPG2);
                                        $MRG3           = calcPercentRate($parcel_cost, $SPG3);
                                        $MRG4           = calcPercentRate($parcel_cost, $SPG4);
                                        $MRG5           = calcPercentRate($parcel_cost, $SPG5);
                                        $MRG6           = calcPercentRate($parcel_cost, $SPG6);
                                    ?>
                                        <tr>
                                            <td><?= esc($row['item_code']) ?></td>
                                            <td><?= esc($row['unit_name']) ?></td>
                                            <td class="text-right"><?= numberFormat($parcel_price, true) ?></td>
                                            <td class="text-right"><?= numberFormat($parcel_tax, true) ?></td>
                                            <td class="text-right"><?= numberFormat($parcel_cost, true) ?></td>
                                            <td class="text-right"><?= numberFormat($MRG1, true) ?>%</td>
                                            <td class="text-right"><?= numberFormat($SPG1, true) ?></td>

                                            <td class="text-right"><?= numberFormat($MRG2, true) ?>%</td>
                                            <td class="text-right"><?= numberFormat($SPG2, true) ?></td>

                                            <td class="text-right"><?= numberFormat($MRG3, true) ?>%</td>
                                            <td class="text-right"><?= numberFormat($SPG3, true) ?></td>

                                            <td class="text-right"><?= numberFormat($MRG4, true) ?>%</td>
                                            <td class="text-right"><?= numberFormat($SPG4, true) ?></td>

                                            <td class="text-right"><?= numberFormat($MRG5, true) ?>%</td>
                                            <td class="text-right"><?= numberFormat($SPG5, true) ?></td>

                                            <td class="text-right"><?= numberFormat($MRG6, true) ?>%</td>
                                            <td class="text-right"><?= numberFormat($SPG6, true) ?></td>

                                        </tr>
                                    <?php
                                    }
                                    ?>

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