<?= $this->extend('webmin/template/report_A4_landscape_template') ?>

<?= $this->section('css') ?>
<style>
    #sample {
        color: red;
    }
</style>
<?= $this->endSection() ?>


<?= $this->section('content') ?>

<?php
$iPage          = 1;
$numRow         = 1;
foreach ($pages as $page) :
?>

<!-- page 1/2 -->
<div style="page-break-after:always;margin:0px;padding:0px;">
    <table width="100%" border="0" cellpadding="1" cellspacing="1" style="background-color:#FFFFFF;  ">
        <tbody>
            <tr style="background-color:#FFFFFF;">
                <td nowrap="" align="left" valign="top" width="100%" style="background-color:#FFFFFF;" class="text-right">
                    <br>
                    <i>Dicetak oleh <?= $userLogin['user_realname'] ?> pada tanggal <?= indo_date(date('Y-m-d H:i:s'), FALSE) ?></i>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="text-center">
        <div class="text-center">
            <div width="780px">
                <table width="100%">
                    <tbody>
                        <tr>
                            <td align="left" class="header1"><?= COMPANY_NAME ?></td>
                        </tr>
                        <tr>
                            <td align="left"><?= COMPANY_ADDRESS ?></td>
                        </tr>
                        <tr>
                            <td align="left">No. Telp: <?= COMPANY_PHONE ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="border-bottom:solid 1px black"></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="border-bottom:solid 3px black"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="content" class="text-center">
            <!-- HEADER -->
            <table width="1100px">
                <tbody>
                    <tr>
                        <td colspan="2" align="center">
                            <p class="header2">DAFTAR STOK TRANSFER<br><br></p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td width="50%" class="loseborder">
                            <table>
                                <tbody>
                                    <tr align="left" class="loseborder">
                                        <td width="120" class="loseborder">Periode</td>
                                        <td class="loseborder">: <?= indo_short_date($start_date) ?> s.d <?= indo_short_date($end_date) ?>&nbsp;</td>
                                    </tr>
                                    <tr align="left">
                                        <td class="loseborder">Dari Gudang</td>
                                        <td class="loseborder">:<?= $warehouse_from_name?></td>
                                    </tr>
                                    <tr align="left">
                                        <td class="loseborder">Ke Gudang</td>
                                        <td class="loseborder">:<?= $warehouse_to_name ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td width="50%" class="loseborder">
                            <table>
                                <tbody>
                                    <tr align="left">
                                        <td width="120" class="text-right">Hal</td>
                                        <td>:&nbsp;1/1&nbsp;</td>
                                    </tr>
                                    <tr align="left">
                                        <td class="text-right"></td>
                                        <td class="">&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- END HEADER -->
            <br>
            <div style="width:1100px; margin:auto;">
                <table width="100%" celpadding="0" cellspacing="0" class="table-bordered table-detail">
                    <thead>
                        <tr>
                            <th class="header-table" width="10%">TANGGAL</th>
                            <th class="header-table" width="10%">DARI GUDANG</th>
                            <th class="header-table" width="10%">KE GUDANG</th>
                            <th class="header-table" width="10%">KODE PRODUK</th>
                            <th class="header-table" width="40%">NAMA PRODUK</th>
                            <th class="header-table" width="10%">SATUAN</th>
                            <th class="header-table" width="10%">STOK</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                            $hd_transfer_stock_no = '';
                            foreach ($page as $row) :
                                ?>
                                <tr>
                                    <td class="text-left" colspan="7"><b><?= $hd_transfer_stock_no == $row['hd_transfer_stock_no'] ? '' : $row['hd_transfer_stock_no'] ?></b>&nbsp;</td>
                                </tr>
                                <tr align="left">
                                    <td class="text-left"><?= indo_short_date($row['hd_transfer_stock_date'], FALSE) ?>&nbsp;</td>
                                    <td class="text-left col-fixed"><?= $row['warehouse_from_code'] ?>&nbsp;</td>
                                    <td class="text-left col-fixed"><?= $row['warehouse_to_code'] ?>&nbsp;</td>
                                    <td align="text-left" nowrap=""><?= $row['product_code'] ?>&nbsp;</td>
                                    <td class="text-left col-fixed"><?= $row['product_name'] ?>&nbsp;</td>
                                    <td class="text-left col-fixed"><?= $row['unit_name'] ?></td>
                                    <td class="text-right"><?= numberFormat($row['item_qty'], false) ?>&nbsp;</td>
                                </tr>
                                <?php
                                $hd_transfer_stock_no = $row['hd_transfer_stock_no'];
                            endforeach;
                            ?>
                    </tbody>
                </table>
                <br>

            </div>

        </div>
    </div>
</div>
<?php
    $iPage++;
endforeach;
?>


<?= $this->endSection() ?>