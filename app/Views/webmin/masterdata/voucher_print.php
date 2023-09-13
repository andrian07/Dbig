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
    }

    .voucher-list tr {
        margin: 0px;
        padding: 0px 0px;
    }

    .voucher-list tr td {
        margin: 0px;
        padding: 3px 3px;
    }

    .container {
        position: relative;
    }

    .voucher-image {
        height: 220px;
        width: 100%;
        margin: 0px 0px;
        border: 1px solid #000;
    }

    .voucher-data-code {
        font-size: 12;
        position: absolute;
        right: 10px;
        top: 5px;
    }

    .voucher-data-exp {
        font-size: 12;
        position: absolute;
        left: 10px;
        top: 200px;
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
                    <td width="2%"></td>
                    <td width="45%" class="container">
                        <?php if (isset($voucherData[$iLeft])) : ?>
                            <img class="voucher-image" src="data:image/png;base64,<?= $voucher_cover ?>" alt="cover.png">
                            <p class="voucher-data-code"><?= $voucherData[$iLeft]['voucher_code'] ?></p>
                            <p class="voucher-data-exp">Exp Date : <?= indo_short_date($voucher_group['exp_date']) ?></p>
                        <?php endif; ?>
                    </td>
                    <td width="1%"></td>
                    <td width="45%" class="container">
                        <?php if (isset($voucherData[$iRight])) : ?>
                            <img class="voucher-image" src="data:image/png;base64,<?= $voucher_cover ?>" alt="cover.png">
                            <p class="voucher-data-code"><?= $voucherData[$iRight]['voucher_code'] ?></p>
                            <p class="voucher-data-exp">Exp Date : <?= indo_short_date($voucher_group['exp_date']) ?></p>

                        <?php endif; ?>

                    </td>
                    <td width="7%"></td>
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
                <td width="7%"></td>
                <td width="45%" class="container">
                    <img class="voucher-image" src="data:image/png;base64,<?= $voucher_backcover ?>" alt="backcover.png">
                </td>
                <td width="1%"></td>
                <td width="45%" class="container">
                    <img class="voucher-image" src="data:image/png;base64,<?= $voucher_backcover ?>" alt="backcover.png">
                </td>
                <td width="2%"></td>
            </tr>
        <?php } ?>
    </table>
</div>


<?= $this->endSection() ?>