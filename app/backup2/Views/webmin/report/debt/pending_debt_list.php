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
foreach ($pages as $remainingDebtData) :
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
                                <p class="header2">DAFTAR SISA FAKTUR BELUM LUNAS</p>
                                <br>
                            </td>
                        </tr>
                        <tr valign="top">
                            <td width="30%" class="loseborder">
                                <table>
                                    <tbody>
                                        <tr align="left" class="loseborder">
                                            <td width="60" class="loseborder">Supplier</td>
                                            <td width="160" class="loseborder">: <?= $supplier_name ?></td>
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
                                <th class="header-table" width="15%">NO BUKTI</th>
                                <th class="header-table" width="15%">TANGGAL</th>  
                                <th class="header-table" width="15%">J. TEMPO</th>
                                <th class="header-table" width="15%">JUMLAH TRANSAKSI</th>
                                <th class="header-table" width="15%">DP</th>
                                <th class="header-table" width="15%">TOTAL SETORAN</th> 
                                <th class="header-table" width="15%">SISA</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            foreach ($remainingDebtData as $row) :
                                $purchase_total  = floatval($row['purchase_total']);
                                $purchase_down_payment = floatval($row['purchase_down_payment']);
                                $purchase_remaining_debt = floatval($row['purchase_remaining_debt']);
                                $total_bayar_cal = $purchase_remaining_debt - $purchase_remaining_debt;
                                
                                ?>
                                <tr align="left">
                                    <td class="text-left"><?= $row['purchase_invoice'] ?>&nbsp;</td>
                                    <td class="text-left"><?= indo_short_date($row['purchase_date'], FALSE) ?>&nbsp;</td>
                                    <td class="text-left"><?= indo_short_date($row['purchase_due_date'], FALSE) ?>&nbsp;</td>
                                    <td class="text-right"><?= numberFormat($purchase_total, TRUE) ?>&nbsp;</td>
                                    <td class="text-right"><?= numberFormat($purchase_down_payment, TRUE) ?>&nbsp;</td>
                                    <td class="text-right"><?= numberFormat($total_bayar_cal, TRUE) ?>&nbsp;</td>
                                    <td class="text-right"><?= numberFormat($purchase_remaining_debt, TRUE) ?>&nbsp;</td> 
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