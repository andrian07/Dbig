<?= $this->extend('webmin/template/report_A4_landscape_template') ?>

<?= $this->section('css') ?>
<style>
    #sample {
        color: red;
    }

    font-family:
</style>
<?= $this->endSection() ?>


<?= $this->section('content') ?>
<?php
$currentPage = 1;
$num_row = 1;
?>

<?php
foreach ($pages as $RetursalesmanAdminData) :
    ?>
    <div style="<?= $currentPage == $maxPage ? '' : 'page-break-after:always;' ?>margin:0px;padding:0px;">
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
                <table width="100%">
                    <tbody>
                        <tr>
                            <td colspan="3" align="center">
                                <p class="header2">DAFTAR RETUR PENJUALAN ADMIN</p>
                                <br>
                            </td>
                        </tr>
                        <tr valign="top">
                            <td width="30%" class="loseborder">
                                <table>
                                    <tbody>
                                        <tr align="left" class="loseborder">
                                            <td width="60" class="loseborder">Cabang</td>
                                            <td width="160" class="loseborder">: <?= $store_name ?></td>
                                        </tr>
                                        <tr align="left">
                                            <td class="loseborder">Customer</td>
                                            <td class="col-fixed">: <?= $customer_name ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td width="40%" class="loseborder">
                               
                            </td>
                            <td width="30%" class="loseborder">
                                <table>
                                    <tbody>
                                        <tr align="left" class="loseborder">
                                            <td width="70" class="loseborder">Hal</td>
                                            <td width="150" class="loseborder">:&nbsp;<?= $currentPage ?>/<?= $maxPage ?>&nbsp;</td>
                                        </tr>

                                        <tr align="left">
                                            <td class="loseborder">Tanggal</td>
                                            <td class="col-fixed">: <?= $start_date ?> - <?= $end_date ?></td>
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
                                <th class="header-table" width="10%">CABANG</th>
                                <th class="header-table" width="10%">KODE CUSTOMER</th>
                                <th class="header-table" width="10%">NAMA CUSTOMER</th>
                                <th class="header-table" width="10%">NO RETUR</th>
                                <th class="header-table" width="10%">TANGGAL</th>
                                <th class="header-table" width="10%">DPP</th>
                                <th class="header-table" width="10%">PPN</th>
                                <th class="header-table" width="10%">TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $last_invoice = '';

                            foreach ($RetursalesmanAdminData as $row) :

                                $hd_retur_total_dpp = floatval($row['hd_retur_total_dpp']);
                                $hd_retur_total_ppn = floatval($row['hd_retur_total_ppn']);
                                $hd_retur_total_transaction = floatval($row['hd_retur_total_transaction']);
                                ?>
                                <tr align="left">
                                    <td class="text-left"><?= $row['store_code'] ?> - <?= $row['store_name'] ?>&nbsp;</td>
                                    <td class="text-left"><?= $row['customer_code'] ?>&nbsp;</td>
                                    <td class="text-left"><?= $row['customer_name'] ?>&nbsp;</td>
                                    <td class="text-left"><?= $row['hd_retur_sales_admin_invoice'] ?>&nbsp;</td>
                                    <td class="text-left"><?= indo_short_date($row['hd_retur_date'], FALSE) ?>&nbsp;</td>

                                    <td class="text-right"><?= numberFormat($hd_retur_total_dpp, TRUE) ?>&nbsp;</td>
                                    <td class="text-right"><?= numberFormat($hd_retur_total_ppn, TRUE) ?>&nbsp;</td>
                                    <td class="text-right"><?= numberFormat($hd_retur_total_transaction, TRUE) ?>&nbsp;</td>
                                </tr>
                                <?php
                                $num_row++;
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
    $currentPage++;
endforeach;
?>



<?= $this->endSection() ?>  