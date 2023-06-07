<?= $this->extend('webmin/template/report_A4_template') ?>

<?= $this->section('css') ?>
<style>
    * {
        margin: 0px;
        padding: 0px;
        font-size: 10px;
    }

    div.barcode-label {
        width: 160px;
        height: 50px;
        text-align: center;
        margin-left: 5px;
        margin-top: 5px;
        margin-bottom: 20px;
    }

    .title {
        text-overflow: ellipsis;
        width: 80%;
        margin-left: 19px;
        font-size: 9px;
    }

    .fs-20 {
        font-size: 9px;
    }
</style>
<?= $this->endSection() ?>


<?= $this->section('content') ?>
<?php
$page = 1;
$ubarcode = str_replace('svg width="95"', 'svg width="80"', $barcode);
foreach ($pages as $pageData) {
?>
    <div style="margin:0px;padding:0px;<?= $page == $max_page ? '' : 'page-break-after:always;' ?>">
        <table width="100%">
            <?php
            foreach ($pageData as $row) {
            ?>
                <div class="barcode-label">
                    <img src="data:image/svg+xml;base64,<?= base64_encode($ubarcode)  ?>" />
                    <p class="info fs-20"><?= esc($row['item_code']) ?><br></p>
                    <div class="title"> <?= esc($row['product_name'] . ' (' . $row['unit_name'] . ')') ?></div>
                </div>
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