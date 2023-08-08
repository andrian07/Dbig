<?= $this->extend('webmin/template/report_A4_template') ?>

<?= $this->section('css') ?>
<style>
    * {
        margin: 0px;
        padding: 0px;
    }

    div.barcode-label {
        width: 200px;
        height: 80px;
        text-align: center;
        margin-top: 0px;
        margin-bottom: 2px;
    }


    .title {
        width: 98%;
        height: 24px;
        margin: 0px auto;
        font-size: 9px;

        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }


    .barcode-text {
        font-size: 12px;
        font-weight: bold;
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
                    <p class="barcode-text"><?= esc($row['item_code']) ?><br></p>
                    <div class="title">
                        <?= $row['product_name'] . ' (' . $row['unit_name'] . ')' ?>
                    </div>
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