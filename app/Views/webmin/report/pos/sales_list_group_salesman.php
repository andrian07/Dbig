<?= $this->extend('webmin/template/report_A4_landscape_template') ?>

<?= $this->section('css') ?>
<style>
    .text-red {
        color: red;
    }
</style>
<?= $this->endSection() ?>


<?= $this->section('content') ?>
<?php
$iPage          = 1;
foreach ($pages as $page) :
?>
    <!-- page 1/2 -->
    <div style="<?= $iPage == $max_page ? '' : 'page-break-after:always;' ?>margin:0px;padding:0px;">
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
                                <p class="header2">LAPORAN PENJUALAN PER SALESMAN<br><br></p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <td width="65%" class="loseborder">
                                <table>
                                    <tbody>
                                        <tr align="left" class="loseborder">
                                            <td width="120" class="loseborder">Tanggal Transaksi</td>
                                            <td class="loseborder">: <?= indo_short_date($start_date) ?> s.d <?= indo_short_date($end_date) ?></td>
                                        </tr>
                                        <tr align="left">
                                            <td class="loseborder">Salesman</td>
                                            <td class="loseborder">: <?= $salesman_name ?>&nbsp;</td>
                                        </tr>
                                        <tr align="left">
                                            <td class="loseborder">Toko</td>
                                            <td class="loseborder">: <?= $store_name ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td width="35%" class="loseborder">
                                <table>
                                    <tbody>
                                        <tr align="left">
                                            <td width="120" class="text-right">Hal</td>
                                            <td>:&nbsp;<?= $iPage ?>/<?= $max_page ?>&nbsp;</td>
                                        </tr>
                                        <tr align="left">
                                            <td class="text-right">PPN&nbsp;</td>
                                            <td class="">: <?= $product_tax ?>&nbsp;</td>
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
                                <th class="header-table" width="3%">NO</th>
                                <th class="header-table" width="10%" nowrap="">CABANG</th>
                                <th class="header-table" width="10%" nowrap="">KASIR</th>
                                <th class="header-table" width="10%" nowrap="">INVOICE</th>
                                <th class="header-table" width="10%">TANGGAL</th>
                                <th class="header-table" width="27%">METODE PEMBAYARAN</th>
                                <th class="header-table" width="10%">DPP</th>
                                <th class="header-table" width="10%">PPN</th>
                                <th class="header-table" width="10%">TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            foreach ($page as $row) :
                            ?>
                                <tr>
                                    <?php
                                    foreach ($row  as $col) :
                                        $class = isset($col['class']) ? 'class="' . $col['class'] . '"' : '';
                                        $colspan = isset($col['colspan']) ? 'colspan="' . $col['colspan'] . '"' : '';
                                    ?>
                                        <td <?= $colspan . ' ' . $class ?>><?= $col['text'] ?></td>
                                    <?php
                                    endforeach;
                                    ?>
                                </tr>
                            <?php
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