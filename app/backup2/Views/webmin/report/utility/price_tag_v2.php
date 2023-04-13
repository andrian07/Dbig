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
foreach ($pages as $pageData) {
?>
    <div style="margin:0px;padding:0px;<?= $page == $max_page ? '' : 'page-break-after:always;' ?>">
        <table width="100%">
            <?php
            foreach ($pageData as $row) {
            ?>
                <tr>
                    <td width="25%">
                        <?= isset($row[0]) ? $row[0] : '&nbsp;' ?>
                    </td>
                    <td width="25%">
                        <?= isset($row[1]) ? $row[1] : '&nbsp;' ?>
                    </td>
                    <td width="25%">
                        <?= isset($row[2]) ? $row[2] : '&nbsp;' ?>
                    </td>
                    <td width="25%">
                        <?= isset($row[3]) ? $row[3] : '&nbsp;' ?>
                    </td>
                </tr>
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