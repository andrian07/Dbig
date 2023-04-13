<?= $this->extend('webmin/template/report_A4_landscape_template') ?>

<?= $this->section('css') ?>
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
        background-color: white;
        margin: auto;
        border: 1px solid #000;
    }

    .price-tag tbody tr {
        margin: 0px;
        padding: 0px;
    }

    .price-tag tbody tr td {
        margin: 0px;
        padding: 0px 3px;
        text-overflow: ellipsis;
        word-wrap: break-word;
    }

    .price-tag .tag-header {
        color: #FFF;
        padding: 2px 3px;
        font-size: 14px;
        font-weight: bold;
        vertical-align: top;

    }

    .va-top {
        vertical-align: top;
    }

    .va-bottom {
        vertical-align: bottom;
    }

    .fs-15 {
        font-size: 15px;
    }

    .fs-16 {
        font-size: 16px;
    }

    .fs-18 {
        font-size: 18px;
    }

    .fs-25 {
        font-size: 25px;
    }

    .fs-20 {
        font-size: 20px;
    }

    .fs-12 {
        font-size: 12px;
    }

    .disc-price {
        color: black;

    }

    .bg-blue {
        background-color: dodgerblue;
    }

    .bg-yellow {
        background-color: yellow;
    }

    .text-left {
        text-align: left;
    }

    .text-right {
        text-align: right;
    }

    .text-center {
        text-align: center;
    }



    .label-group {
        font-weight: bold;
        font-style: italic;
        font-size: 10;
    }


    .label-currency {
        vertical-align: top;
        font-size: 14px;
    }

    .label-price {
        font-weight: bold;
        font-style: italic;
        vertical-align: top;
        font-size: 22px;
    }



    .label-unit {
        font-style: italic;
        vertical-align: bottom;
        font-size: 12px;
    }

    .label-info {
        font-size: 12px;
    }

    .group-G2 {
        color: grey;
    }

    .group-G3 {
        color: orange;
    }

    .group-G4 {
        color: gray;
    }
</style>
<?= $this->endSection() ?>


<?= $this->section('content') ?>

<?php
$page = 1;
foreach ($list_product as $pageData) {

?>
    <div style="margin:0px;padding:0px;<?= $page == $max_page ? '' : 'page-break-after:always;' ?>">
        <table width="100%">
            <?php
            foreach ($pageData as $product) {
                $item_code      = $product['item_code'];
                $product_name   = $product['product_name'];
                $unit_name      = $product['unit_name'];
            ?>

                <?php if ($print_version == 1) { ?>
                    <tr>
                        <td width="25%">
                            <table class="price-tag" cellspacing="0" cellpadding="0">
                                <tbody>
                                    <tr>
                                        <td class="bg-blue tag-header" colspan="4" height="50px"><?= $product_name ?></td>
                                    </tr>
                                    <tr>
                                        <td class="label-info" colspan="4" height="12px">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td class="label-currency" height="18px">Rp.</td>
                                        <td class="text-right label-price" colspan="2"><?= numberFormat($product['G1_sales_price']) ?></td>
                                        <td class="text-left label-unit">Per <?= $unit_name ?></td>
                                    </tr>
                                    <tr>
                                        <td class="label-group group-G1" colspan="2" height="15px" colspan="2">Harga Umum</td>
                                        <td class="label-group" colspan="2" height="15px" colspan="2"><?= $item_code ?></td>
                                    </tr>
                                    <tr>
                                        <td class="label-info text-center font-primary" style="border-bottom: black solid 1px;" colspan="4" height="15px">&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td width="25%">
                            <table class="price-tag" cellspacing="0" cellpadding="0">
                                <tbody>
                                    <tr>
                                        <td class="bg-blue tag-header" colspan="4" height="50px"><?= $product_name ?></td>
                                    </tr>
                                    <tr>
                                        <td class="label-info" colspan="4" height="12px">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td class="label-currency" height="18px">Rp.</td>
                                        <td class="text-right label-price" colspan="2"><?= numberFormat($product['G2_sales_price']) ?></td>
                                        <td class="text-left label-unit">Per <?= $unit_name ?></td>
                                    </tr>
                                    <tr>
                                        <td class="label-group group-G2" colspan="2" height="15px" colspan="2">Member Silver</td>
                                        <td class="label-group" colspan="2" height="15px" colspan="2"><?= $item_code ?></td>
                                    </tr>
                                    <tr>
                                        <td class="label-info text-center font-primary" style="border-bottom: black solid 1px;" colspan="4" height="15px">&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td width="25%">
                            <table class="price-tag" cellspacing="0" cellpadding="0">
                                <tbody>
                                    <tr>
                                        <td class="bg-blue tag-header" colspan="4" height="50px"><?= $product_name ?></td>
                                    </tr>
                                    <tr>
                                        <td class="label-info" colspan="4" height="12px">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td class="label-currency" height="18px">Rp.</td>
                                        <td class="text-right label-price" colspan="2"><?= numberFormat($product['G3_sales_price']) ?></td>
                                        <td class="text-left label-unit">Per <?= $unit_name ?></td>
                                    </tr>
                                    <tr>
                                        <td class="label-group group-G3" colspan="2" height="15px" colspan="2">Member Gold</td>
                                        <td class="label-group" colspan="2" height="15px" colspan="2"><?= $item_code ?></td>
                                    </tr>
                                    <tr>
                                        <td class="label-info text-center font-primary" colspan="4" height="15px">&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td width="25%">
                            <table class="price-tag" cellspacing="0" cellpadding="0">
                                <tbody>
                                    <tr>
                                        <td class="bg-blue tag-header" colspan="4" height="50px"><?= $product_name ?></td>
                                    </tr>
                                    <tr>
                                        <td class="label-info" colspan="4" height="12px">&nbsp;</td>
                                    </tr>
                                    <tr class="">
                                        <td class="label-currency" height="18px">Rp.</td>
                                        <td class="text-right label-price" colspan="2"><?= numberFormat($product['G4_sales_price']) ?></td>
                                        <td class="text-left label-unit">Per <?= $unit_name ?></td>
                                    </tr>
                                    <tr>
                                        <td class="label-group group-G4" colspan="2" height="15px" colspan="2">Member Platinum</td>
                                        <td class="label-group" colspan="2" height="15px" colspan="2"><?= $item_code ?></td>
                                    </tr>
                                    <tr>
                                        <td class="label-info text-center font-primary" colspan="4" height="15px">&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                <?php } else { ?>
                    <tr>
                        <td width="25%">
                            <table class="price-tag" cellspacing="0" cellpadding="0">
                                <tbody>
                                    <tr>
                                        <td class="bg-blue tag-header" colspan="4" height="50px"><?= $product_name ?></td>
                                    </tr>
                                    <tr>
                                        <td class="label-info" colspan="4" height="12px">Harga Normal&nbsp;&nbsp;<del class="disc-price fs-15">Rp <?= numberFormat($product['G1_sales_price']) ?></del></td>
                                    </tr>
                                    <tr class="">
                                        <td class="label-currency" height="18px">Rp.</td>
                                        <td class="text-right label-price" style="color:red;" colspan="2"><?= numberFormat($product['G1_promo_price']) ?></td>
                                        <td class="text-left label-unit">Per <?= $unit_name ?></td>
                                    </tr>
                                    <tr>
                                        <td class="label-group group-G1" colspan="2" height="15px" colspan="2">Harga Umum</td>
                                        <td class="label-group" colspan="2" height="15px" colspan="2"><?= $item_code ?></td>
                                    </tr>
                                    <tr>
                                        <td class="label-info text-center font-primary" style="border-bottom: black solid 1px;" colspan="4" height="15px">s.d <?= indo_date($product['disc_end_date']) ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td width="25%">
                            <table class="price-tag" cellspacing="0" cellpadding="0">
                                <tbody>
                                    <tr>
                                        <td class="bg-blue tag-header" colspan="4" height="50px"><?= $product_name ?></td>
                                    </tr>
                                    <tr>
                                        <td class="label-info" colspan="4" height="12px">Harga Normal&nbsp;&nbsp;<del class="disc-price fs-15">Rp <?= numberFormat($product['G2_sales_price']) ?></del></td>
                                    </tr>
                                    <tr>
                                        <td class="label-currency" height="18px">Rp.</td>
                                        <td class="text-right label-price" style="color:red;" colspan="2"><?= numberFormat($product['G2_promo_price']) ?></td>
                                        <td class="text-left label-unit">Per <?= $unit_name ?></td>
                                    </tr>
                                    <tr>
                                        <td class="label-group group-G2" colspan="2" height="15px" colspan="2">Member Silver</td>
                                        <td class="label-group" colspan="2" height="15px" colspan="2"><?= $item_code ?></td>
                                    </tr>
                                    <tr>
                                        <td class="label-info text-center font-primary" style="border-bottom: black solid 1px;" colspan="4" height="15px">s.d <?= indo_date($product['disc_end_date']) ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td width="25%">
                            <table class="price-tag" cellspacing="0" cellpadding="0">
                                <tbody>
                                    <tr>
                                        <td class="tag-header bg-blue" colspan="4" height="50px"><?= $product_name ?></td>
                                    </tr>
                                    <tr>
                                        <td class="label-info" colspan="4" height="12px">Harga Normal&nbsp;&nbsp;<del class="disc-price fs-15">Rp <?= numberFormat($product['G3_sales_price']) ?></del></td>
                                    </tr>
                                    <tr>
                                        <td class="label-currency" height="18px">Rp.</td>
                                        <td class="text-right label-price" style="color:red;" colspan="2"><?= numberFormat($product['G3_promo_price']) ?></td>
                                        <td class="text-left label-unit">Per <?= $unit_name ?></td>
                                    </tr>
                                    <tr>
                                        <td class="label-group group-G3" colspan="2" height="15px" colspan="2">Member Gold</td>
                                        <td class="label-group" colspan="2" height="15px" colspan="2"><?= $item_code ?></td>
                                    </tr>
                                    <tr>
                                        <td class="label-info text-center font-primary" style="border-bottom: black solid 1px;" colspan="4" height="15px">s.d <?= indo_date($product['disc_end_date']) ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td width="25%">
                            <table class="price-tag" cellspacing="0" cellpadding="0">
                                <tbody>
                                    <tr>
                                        <td class="tag-header bg-blue" colspan="4" height="50px"><?= $product_name ?></td>
                                    </tr>
                                    <tr>
                                        <td class="label-info" colspan="4" height="12px">Harga Normal&nbsp;&nbsp;<del class="disc-price fs-15">Rp <?= numberFormat($product['G4_sales_price']) ?></del></td>
                                    </tr>
                                    <tr>
                                        <td class="label-currency" height="18px">Rp.</td>
                                        <td class="text-right label-price" style="color:red;" colspan="2"><?= numberFormat($product['G4_promo_price']) ?></td>
                                        <td class="text-left label-unit">Per <?= $unit_name ?></td>
                                    </tr>
                                    <tr>
                                        <td class="label-group group-G4" colspan="2" height="15px" colspan="2">Member Platinum</td>
                                        <td class="label-group" colspan="2" height="15px" colspan="2"><?= $item_code ?></td>
                                    </tr>
                                    <tr>
                                        <td class="label-info text-center font-primary" style="border-bottom: black solid 1px;" colspan="4" height="15px">s.d <?= indo_date($product['disc_end_date']) ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                <?php } ?>
            <?php
            }
            ?>
        </table>

    </div>
<?php
    $page++;
}
?>

<?= $this->endSection() ?>