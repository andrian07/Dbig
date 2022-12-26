<html>

<head>
    <title> Cetak Label Harga </title>
    <style>
        * {
            margin: 0px;
            padding: 0px;
            font-size: 10px;
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
        }

        .price-tag {
            width: 226.77px;
            height: 151.18px;
            background-color: #1034A6;
            margin: auto;
        }

        .price-tag .tag-header {
            width: 226.77px;
            height: 60px;
            background-color: #1034A6;
            color: #FFF;
            padding: 2px 3px;
            font-size: 15px;
            overflow: hidden;
        }

        .price-tag .tag-body {
            width: 226.77px;
            height: 80px;
            background-color: #FFF;
            padding: 2px 3px;
            font-size: 15px;
            overflow: hidden;
            position: relative;
        }

        .price-tag .tag-body small {
            font-size: 15px;
        }

        .price-tag .tag-body .label-price {
            float: right;
            position: absolute;
            font-size: 25px;
            top: 18;
            right: 3;
        }

        .price-tag .tag-body .label-unit {
            float: right;
            position: absolute;
            font-size: 15px;
            top: 43;
            right: 3;
        }

        .price-tag .tag-body .label-promo {
            float: right;
            position: absolute;
            font-size: 15px;
            top: 2;
            right: 3;
        }

        .price-tag .tag-body .label-promo del {

            font-size: 15px;
        }
    </style>
</head>



<body>
    <table width="100%">
        <?php
        $label_promo = '';
        $sales_price = 0;
        $promo_price = 0;
        $label_promo = '<del>' . numberFormat(30000, true) . '</del> s.d ' . indo_short_date('2022-10-10', FALSE);

        ?>
        <?php for ($i = 1; $i <= $printCount; $i++) { ?>
            <tr>
                <td width="50%">
                    <div class="price-tag">
                        <div class="tag-header">
                            <?= esc($product['product_name']) ?>
                        </div>
                        <div class="tag-body">
                            <small>Rp</small>
                            <span class="label-promo"></span>
                            <span class="label-price"><?= numberFormat(30000, true) ?></span>
                            <span class="label-unit">per PCS</span>
                        </div>
                    </div>
                </td>
                <td width="50%">
                    <div class="price-tag">
                        <div class="tag-header">
                            <?= esc($product['product_name']) ?>
                        </div>
                        <div class="tag-body">
                            <small>Rp</small>
                            <span class="label-promo"><?= $label_promo ?></span>
                            <span class="label-price"><?= numberFormat(25000, true) ?></span>
                            <span class="label-unit">per PCS</span>
                        </div>
                    </div>
                </td>
            </tr>
        <?php } ?>
    </table>




</body>

</html>