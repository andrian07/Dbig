<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Surat Jalan</title>
    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="pragma" content="no-cache" />
    <style type="text/css" media="all">
        @media print {
            .pagebreak {
                page-break-before: always;
            }
        }

        body {
            color: #000;
        }

        td.no-border {
            font-size: 12px;

        }

        .product-name {
            max-width: 0;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        #wrapper {
            max-width: 1100px;
            margin: 0 auto;
        }

        .btn {
            border-radius: 0;
            margin-bottom: 5px;
        }

        .bootbox .modal-footer {
            border-top: 0;
            text-align: center;
        }

        h3 {
            margin: 5px 0;
        }

        .order_barcodes img {
            float: none !important;
            margin-top: 5px;
        }

        .center-store-name {
            text-align: center;
        }

        .center-store-name {
            text-align: left;
        }

        .right-store-name {
            text-align: right;
        }

        p {
            margin: 0 0 5px;
        }

        .header-table {
            border-bottom: 1px solid;
            border-top: 1px solid !important;
        }

        .right {
            text-align: right;
        }

        .table {
            width: 100%;
        }

        .left {
            text-align: left;
        }

        .center {
            text-align: center;
        }

        .total-table {
            border-top: 1px solid !important;
        }

        .body-table {
            min-height: 220px;
            display: table-caption;
            width: 100%;
        }

        .sign {
            padding-top: 70px !important;
        }

        .ttd p {
            display: inline;
        }

        .ttd_word {
            margin-right: 40%;
        }



        .table {
            margin-bottom: 0px;
        }

        p {
            font-size: 13px;
        }

        h3 {
            font-size: 17px;
        }

        h4 {
            font-size: 16px;
        }

        .invoice-number p {
            margin-left: 19%;
        }

        /* @media print {
                .no-print { display: none; }
                #wrapper { max-width: 1100px; width: 100%; min-width: 250px; margin: 0 auto; }
                .no-border { border: none !important; }
                table tfoot { display: table-row-group; }
            }*/
    </style>
</head>

<body>
    <?php
    $countPage = count($pages);
    for ($page = 1; $page <= $countPage; $page++) {
        $pageItem = $pages[$page - 1];
    ?>
        <div id="wrapper">
            <div id="receiptData">
                <div class="no-print"></div>
                <div id="receipt-data">
                    <table class="table table-condensed">
                        <tbody>
                            <tr>
                                <td class="no-border center-store-name">
                                    <h4><?= COMPANY_NAME ?></h4>
                                    <p><?= COMPANY_ADDRESS ?></p>
                                    <p><?= COMPANY_PHONE ?></p>
                                </td>
                                <td class="no-border center-store-name invoice-number">
                                    <p style="text-transform:uppercase; text-align: center;font-size: 20px;">SURAT JALAN</p>
                                    <p style="font-size: 20px;text-align: center;"><?= esc($header['pos_sales_invoice']) ?></p>
                                </td>
                                <td class="no-border right-store-name">
                                    <p><?= COMPANY_REGION ?>, <?= indo_date($header['pos_sales_date'], FALSE) ?></p>
                                    <p><?= esc($header['customer_name']) ?></p>
                                    <?php
                                    $address = $header['customer_address'];
                                    if (!($header['customer_delivery_address'] == '' || $header['customer_delivery_address'] == '-')) {
                                        $address = $header['customer_delivery_address'];
                                    }
                                    ?>
                                    <p><?= $address ?></p>
                                    <p><?= $page ?>/<?= $countPage ?></p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div style="clear:both;"></div>
                    <table class="table table-condensed">
                        <tbody class="body-table">
                            <tr>
                                <td class="header-table" width="15%">KODE ITEM</td>
                                <td class="header-table product-name" width="60%">Nama Barang</td>
                                <td class="header-table right" width="10%">Satuan</td>
                                <td class="header-table right" width="15%">Jumlah</td>
                                <td width="1%"></td>
                            </tr>

                            <?php foreach ($pageItem as $row) :
                                $product_name   = $row['product_name'];
                                $unit_name      = $row['unit_name'];
                                $sales_qty      = floatval($row['sales_qty']);
                            ?>
                                <tr>
                                    <td class="no-border"><?= esc($row['item_code']) ?></td>
                                    <td class="no-border product-name"><?= esc($product_name) ?></td>
                                    <td class="no-border"><?= esc($unit_name) ?></td>
                                    <td class="no-border right"><?= numberFormat($sales_qty, true) ?></td>
                                </tr>
                            <?php
                            endforeach;
                            ?>


                        </tbody>

                        <tfoot>
                            <tr>
                                <td colspan="4" class="total-table no-border">
                                    &nbsp;

                                </td>
                                <td class="right total-table no-border"></td>
                                <td class="right total-table no-border"></td>
                            </tr>

                            <tr>
                                <td class="no-border">Hormat Kami, </td>
                                <td class="no-border" style="text-align:left;">Penerima, </td>
                                <td></td>
                                <td></td>
                                <td class="right no-border" style="text-align:right;"></td>
                                <td class="right no-border" style="text-align:right;"></td>

                            </tr>
                            <tr>
                                <td colspan="4"></td>
                                <td class="right" style="text-align:right;">&nbsp;</td>
                                <td class="right no-border" style="text-align:right;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="4"></td>
                                <td class="right no-border" style="text-align:right;"></td>
                                <td class="right no-border" style="text-align:right;"></td>
                            </tr>
                            <tr>
                                <td colspan="4"></td>
                                <td class="right no-border" style="text-align:right;"></td>
                                <td class="right no-border" style="text-align:right;"></td>
                            </tr>
                            <tr>
                                <td colspan="4"></td>
                                <td class="right no-border" style="text-align:right;"></td>
                                <td class="right no-border" style="text-align:right;"></td>
                            </tr>

                            <tr>
                                <td class="no-border sign-border" colspan="2">
                                    <div class="ttd">
                                        <p class="ttd_word">----------------------------</p>
                                        <p style="margin-left: -70px;">----------------------------</p>
                                    </div>
                                </td>
                                <td class="right no-border"> </td>
                                <td class="no-border"></td>
                                <td class="no-border"></td>
                            </tr>



                        </tfoot>
                    </table>

                    </table>
                </div>


                <div style="clear:both;"></div>
            </div>
        </div>
        <?php if ($page < $countPage) : ?>
            <div class="pagebreak"></div>
        <?php endif; ?>
    <?php
    }
    ?>
    <script>
        window.print();
        <?php if ($agent->isMobile() == FALSE) : ?>
            window.onafterprint = closePage;

            function closePage() {
                window.close();
            }
        <?php endif; ?>
    </script>
</body>