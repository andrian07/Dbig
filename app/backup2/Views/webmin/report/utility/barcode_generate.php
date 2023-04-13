<html>

<head>
    <title> Cetak Barcode </title>
    <style>
        * {
            margin: 0px;
            padding: 0px;
            font-size: 10px;
        }

        table tbody tr td {
            text-align: center;
            padding: 0px;
        }

        .info {
            margin-top: 2px;
        }

        .title {
            text-overflow: ellipsis;
            width: 80%;
            margin-left: 19px;
            font-size: 9px;
        }

        table {
            /*margin-top: 25px;*/
            margin-bottom: 25px;
        }

        td.left {
            padding-left: 64px !important;
        }

        td.right {
            padding-right: 62px;
        }

        .fs-20 {
            font-size: 9px;
        }
    </style>
</head>

<body>
    <?php
    $ubarcode = str_replace('svg width="95"', 'svg width="80"', $barcode);
    for ($i = 1; $i <= $printCount; $i++) {
    ?>
        <table width="100%">
            <tbody>
                <tr>
                    <td class="left">
                        <img src="data:image/svg+xml;base64,<?= base64_encode($ubarcode)  ?>" />
                        <p class="info fs-20"><?= esc($product['item_code']) ?><br></p>
                        <div class="title">
                            <?= esc($product['product_name'] . ' (' . $product['unit_name'] . ')') ?>
                        </div>
                    </td>
                    <td class="right">

                    </td>
                </tr>

            </tbody>
        </table>
    <?php
    }
    ?>
</body>

</html>