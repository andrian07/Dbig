<?= $this->extend('webmin/template/report_A4_landscape_template') ?>
<?php
$num_row        = 1;
$current_page   = 1;
$view_max_page  = $max_page + 1;
?>

<?= $this->section('css') ?>
<style>
    #sample {
        color: red;
    }

    .header-table small {
        font-size: 8pt;
    }
</style>
<?= $this->endSection() ?>


<?= $this->section('content') ?>
<?php
foreach ($page_data as $opname_data) :
?>
    <div style="page-break-after:always;margin:0px;padding:0px;">
        <table width="100%" border="0" cellpadding="1" cellspacing="1" style="background-color:#FFFFFF;  ">
            <tbody>
                <tr style="background-color:#FFFFFF;">
                    <td nowrap="" align="left" valign="top" width="100%" style="background-color:#FFFFFF;" class="text-right">
                        <br>
                        <i>Dicetak oleh <?= $user['user_realname'] ?> pada tanggal <?= indo_date(date('Y-m-d H:i:s'), FALSE) ?></i>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="text-center">
            <div class="text-center">
                <div width="1100px">
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
                                <p class="header2">STOK OPNAME<br><?= esc($header['opname_code']) ?><br></p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <td width="65%" class="loseborder">
                                <table>
                                    <tbody>
                                        <tr align="left" class="loseborder">
                                            <td width="120" class="loseborder">Tanggal Opname</td>
                                            <td class="loseborder">:&nbsp;<?= indo_short_date($header['opname_date']) ?>&nbsp;</td>
                                        </tr>
                                        <tr align="left">
                                            <td class="loseborder">Gudang</td>
                                            <td class="loseborder">:&nbsp;<?= $header['warehouse_code'] ?> - <?= $header['warehouse_name'] ?>&nbsp;</td>
                                        </tr>
                                        <tr align="left">
                                            <td class="loseborder"></td>
                                            <td class="loseborder">&nbsp;&nbsp;<?= $header['warehouse_address'] ?>&nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td width="35%" class="loseborder">
                                <table>
                                    <tbody>
                                        <tr align="left">
                                            <td width="120" class="text-right">Hal</td>
                                            <td>:&nbsp;<?= $current_page ?>/<?= $view_max_page ?>&nbsp;</td>
                                        </tr>
                                        <tr align="left">
                                            <td class="text-right">&nbsp;</td>
                                            <td class="text-right">&nbsp;</td>
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
                                <th class="header-table" rowspan="2" width="3%">NO</th>
                                <th class="header-table" rowspan="2" width="10%" nowrap="">KODE <br>PRODUK</th>
                                <th class="header-table" rowspan="2" width="27%">NAMA PRODUK</th>
                                <th class="header-table" rowspan="2" width="10%">HPP</th>
                                <th class="header-table" width="15%" colspan="3">STOK</th>
                                <th class="header-table" rowspan="2" width="25%">CATATAN</th>
                                <th class="header-table" rowspan="2" width="10%">SUBTOTAL<br><small>HPP X SELISIH</small></th>
                            </tr>
                            <tr>
                                <th class="header-table">FISIK</th>
                                <th class="header-table">SISTEM</th>
                                <th class="header-table">SELISIH</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($opname_data as $row) :
                                $base_cogs                  = floatval($row['base_cogs']);
                                $warehouse_stock            = floatval($row['warehouse_stock']);
                                $system_stock               = floatval($row['system_stock']);
                                $diff_stock                 = $warehouse_stock - $system_stock;
                                $opname_stock_difference    = floatval($row['opname_stock_difference']);
                            ?>
                                <tr align="left">
                                    <td class="text-right"><?= $num_row ?>&nbsp;</td>
                                    <td align="text-left" nowrap=""><?= esc($row['product_code']) ?>&nbsp;</td>
                                    <td class="col-fixed text-left"><?= esc($row['product_name']) ?>&nbsp;</td>
                                    <td class="text-right"><?= numberFormat($base_cogs, TRUE) ?>&nbsp;</td>
                                    <td class="text-right"><?= numberFormat($warehouse_stock, TRUE) ?>&nbsp;</td>
                                    <td class="text-right"><?= numberFormat($system_stock, TRUE) ?>&nbsp;</td>
                                    <td class="text-right"><?= numberFormat($diff_stock, TRUE) ?>&nbsp;</td>
                                    <td class="col-fixed text-left"><?= esc($row['detail_remark']) ?>&nbsp;</td>
                                    <td class="text-right"><?= numberFormat($opname_stock_difference, TRUE) ?>&nbsp;</td>
                                </tr>
                            <?php
                                $num_row++;
                            endforeach;
                            ?>




                            <tr>
                                <td colspan="8" align="right"><b>TOTAL</b></td>
                                <td align="right"><?= numberFormat($header['opname_total'], TRUE) ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <br><br>
                </div>


            </div>
        </div>
    </div>
<?php
    $current_page++;
endforeach;
?>

<div style="margin:0px;padding:0px;">
    <table width="100%" border="0" cellpadding="1" cellspacing="1" style="background-color:#FFFFFF;  ">
        <tbody>
            <tr style="background-color:#FFFFFF;">
                <td nowrap="" align="left" valign="top" width="100%" style="background-color:#FFFFFF;" class="text-right">
                    <br>
                    <i>Dicetak oleh <?= $user['user_realname'] ?> pada tanggal <?= indo_date(date('Y-m-d H:i:s'), FALSE) ?></i>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="text-center">
        <div class="text-center">
            <div width="1100px">
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
                            <p class="header2">STOK OPNAME<br><?= esc($header['opname_code']) ?><br></p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td width="65%" class="loseborder">
                            <table>
                                <tbody>
                                    <tr align="left" class="loseborder">
                                        <td width="120" class="loseborder">Tanggal Opname</td>
                                        <td class="loseborder">:&nbsp;<?= indo_short_date($header['opname_date']) ?>&nbsp;</td>
                                    </tr>
                                    <tr align="left">
                                        <td class="loseborder">Gudang</td>
                                        <td class="loseborder">:&nbsp;<?= $header['warehouse_code'] ?> - <?= $header['warehouse_name'] ?>&nbsp;</td>
                                    </tr>
                                    <tr align="left">
                                        <td class="loseborder"></td>
                                        <td class="loseborder">&nbsp;&nbsp;<?= $header['warehouse_address'] ?>&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td width="35%" class="loseborder">
                            <table>
                                <tbody>
                                    <tr align="left">
                                        <td width="120" class="text-right">Hal</td>
                                        <td>:&nbsp;<?= $current_page ?>/<?= $view_max_page ?>&nbsp;</td>
                                    </tr>
                                    <tr align="left">
                                        <td class="text-right">&nbsp;</td>
                                        <td class="text-right">&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- END HEADER -->
            <br>

            <br>
            <div style="width:1100px; margin:auto;">
                <table class="table-noborder" width="80%" border="0">
                    <tbody>
                        <tr>
                            <td align="center">Disetujui Oleh</td>
                            <td width="35%"></td>
                            <td align="center">Dinput Oleh</td>
                        </tr>
                        <tr>
                            <td height="75px"></td>
                            <td height="75px"></td>
                            <td height="75px"></td>
                        </tr>
                        <tr>
                            <td align="center" nowrap=""><span class="signature">_________________________</span></td>
                            <td></td>
                            <td align="center" nowrap=""><b style="font-size:11pt"><?= esc($header['user_realname']) ?></b></td>
                        </tr>
                        <tr>
                            <td align="center"></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>