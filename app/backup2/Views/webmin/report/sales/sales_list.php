<?= $this->extend('webmin/template/report_A4_landscape_template') ?>

<?= $this->section('css') ?>
<style>
    .text-red {
        color: red;
    }
</style>
<?= $this->endSection() ?>


<?= $this->section('content') ?>
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
                            <p class="header2">LAPORAN PENJUALAN<br><br></p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td width="65%" class="loseborder">
                            <table>
                                <tbody>
                                    <tr align="left" class="loseborder">
                                        <td width="120" class="loseborder">Tanggal Transaksi</td>
                                        <td class="loseborder">: 01/09/2022 s.d 30/09/2022</td>
                                    </tr>
                                    <tr align="left">
                                        <td class="loseborder">User</td>
                                        <td class="loseborder">: -&nbsp;</td>
                                    </tr>
                                    <tr align="left">
                                        <td class="loseborder">Toko</td>
                                        <td class="loseborder">: -</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td width="35%" class="loseborder">
                            <table>
                                <tbody>
                                    <tr align="left">
                                        <td width="120" class="text-right">Hal</td>
                                        <td>:&nbsp;1/2&nbsp;</td>
                                    </tr>
                                    <tr align="left">
                                        <td class="text-right">PPN&nbsp;</td>
                                        <td class="">: -&nbsp;</td>
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
                        <tr align="left">
                            <td class="text-right">1&nbsp;</td>
                            <td class="text-left">UTM</td>
                            <td class="text-left">ANI</td>
                            <td class="text-left" nowrap="">SI/UTM/22/09/R00001&nbsp;</td>
                            <td class="text-left">01/09/2022&nbsp;</td>
                            <td class="col-fixed text-left">CASH,VOUCHER,BNI REK 123</td>
                            <td class="text-right">27,027.00&nbsp;</td>
                            <td class="text-right">2,973.00&nbsp;</td>
                            <td class="text-right">30,000.00&nbsp;</td>
                        </tr>
                        <tr align="left">
                            <td class="text-right">2&nbsp;</td>
                            <td class="text-left">UTM</td>
                            <td class="text-left">ANI</td>
                            <td class="text-left" nowrap="">SI/UTM/22/09/R00002&nbsp;</td>
                            <td class="text-left">02/09/2022&nbsp;</td>
                            <td class="col-fixed text-left">CASH,BCA</td>
                            <td class="text-right">50,000.00&nbsp;</td>
                            <td class="text-right">0.00&nbsp;</td>
                            <td class="text-right">50,000.00&nbsp;</td>
                        </tr>
                        <tr align="left">
                            <td class="text-right">3&nbsp;</td>
                            <td class="text-left">KBR</td>
                            <td class="text-left">REZA</td>
                            <td class="text-left" nowrap="">SI/UTM/22/09/R00003&nbsp;</td>
                            <td class="text-left">02/09/2022&nbsp;</td>
                            <td class="col-fixed text-left">BRI</td>
                            <td class="text-right">200,000.00&nbsp;</td>
                            <td class="text-right">0.00&nbsp;</td>
                            <td class="text-right">200,000.00&nbsp;</td>
                        </tr>
                        <tr align="left">
                            <td class="text-right">4&nbsp;</td>
                            <td class="text-left">UTM</td>
                            <td class="text-left">ANI</td>
                            <td class="text-left" nowrap="">SI/UTM/22/09/R00001&nbsp;</td>
                            <td class="text-left">01/09/2022&nbsp;</td>
                            <td class="col-fixed text-left">CASH,VOUCHER,BNI REK 123</td>
                            <td class="text-right text-red">-27,027.00&nbsp;</td>
                            <td class="text-right text-red">-2,973.00&nbsp;</td>
                            <td class="text-right text-red">-30,000.00&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
                <br>
            </div>

        </div>
    </div>
</div>




<?= $this->endSection() ?>