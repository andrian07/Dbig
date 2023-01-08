<?= $this->extend('webmin/template/report_F4_landscape_template') ?>

<?= $this->section('css') ?>
<style>
    * {
        margin: 0px;
        padding: 0px;
        font-size: 10px;
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        font-family: Calibri, Candara, Segoe, Segoe UI, Optima, Arial, sans-serif;
    }

    .font-primary {
        font-family: Arial, Helvetica, sans-serif;
    }

    .font-secondary {
        font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    }

    .voucher-list tr {
        margin: 0px;
        padding: 0px;
    }

    .voucher-list tr td {
        margin: 0px;
        padding: 3px;
    }


    .voucher {
        width: 100%;
        height: 220px;
        margin: 0px 0px;
        border: 1px solid #000;
        background-image: url("data:image/png;base64,<?= $voucher_cover ?>");
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
    }

    .voucher-code {
        padding: 0px 10px;
        font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        vertical-align: top;
        text-align: right;
        font-size: 20;
    }

    .voucher-exp-date {
        padding: 0px 0px;
        font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        vertical-align: bottom;
        text-align: left;
        font-size: 20;
    }


    .voucher-detail {
        width: 100%;
        height: 220px;
        margin: 0px 0px;
        border: 1px solid #000;
        background-image: url("data:image/png;base64,<?= $voucher_backcover ?>");
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
    }
</style>
<?= $this->endSection() ?>


<?= $this->section('content') ?>


<!-- page 1/2 -->
<?php foreach ($voucher_list as $voucherData) : ?>
    <div style="page-break-after:always;margin:0px;padding:0px;">
        <table id="voucher-list" width="100%">
            <?php
            for ($i = 1; $i <= 3; $i++) {
                $iLeft  = ($i - 1) * 2; //0,2,4
                $iRight = ($i * 2) - 1; //1,3,5 
            ?>
                <tr>
                    <td width="45%">
                        <?php if (isset($voucherData[$iLeft])) : ?>
                            <table class="voucher">
                                <tr>
                                    <td class="voucher-code" style="height:100px;"><?= $voucherData[$iLeft]['voucher_code'] ?></td>
                                </tr>
                                <tr>
                                    <td style="height:60px;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class="voucher-exp-date" style="height:20px;">Exp Date : <?= indo_short_date($voucher_group['exp_date']) ?></td>
                                </tr>
                            </table>
                        <?php endif; ?>

                    </td>
                    <td width="45%">
                        <?php if (isset($voucherData[$iRight])) : ?>
                            <table class="voucher">
                                <tr>
                                    <td class="voucher-code" style="height:100px;"><?= $voucherData[$iRight]['voucher_code'] ?></td>
                                </tr>
                                <tr>
                                    <td style="height:60px;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class="voucher-exp-date" style="height:20px;">Exp Date : <?= indo_short_date($voucher_group['exp_date']) ?></td>
                                </tr>
                            </table>
                        <?php endif; ?>

                    </td>
                    <td width="10%"></td>
                </tr>
            <?php } ?>
        </table>
    </div>
<?php endforeach; ?>


<div style="margin:0px;padding:0px;">
    <table id="voucher-list" width="100%">
        <?php
        for ($i = 1; $i <= 3; $i++) {
        ?>
            <tr>
                <td width="45%">
                    <table class="voucher-detail">
                        <tr>
                            <td class="voucher-code" style="height:100px;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="height:60px;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="voucher-exp-date" style="height:20px;">&nbsp;</td>
                        </tr>
                    </table>
                </td>
                <td width="45%">
                    <table class="voucher-detail">
                        <tr>
                            <td class="voucher-code" style="height:100px;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="height:60px;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="voucher-exp-date" style="height:20px;">&nbsp;</td>
                        </tr>
                    </table>
                </td>
                <td width="10%"></td>
            </tr>
        <?php } ?>
    </table>
</div>


<?= $this->endSection() ?>