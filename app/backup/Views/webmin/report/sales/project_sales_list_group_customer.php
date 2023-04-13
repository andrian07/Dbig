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
                            <p class="header2">LAPORAN PENJUALAN PROYEK PER CUSTOMER<br><br></p>
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
                                        <td class="loseborder">Customer</td>
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
                                        <td class="text-right">PPN</td>
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
                            <th class="header-table" width="18%" nowrap="">INVOICE</th>
                            <th class="header-table" width="17%">TANGGAL</th>
                            <th class="header-table" width="17%">JT.TEMPO</th>
                            <th class="header-table" width="15%">DPP</th>
                            <th class="header-table" width="15%">PPN</th>
                            <th class="header-table" width="15%">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="7"><b>PT ABC</b></td>
                        </tr>
                        <tr align="left">
                            <td class="text-right">1&nbsp;</td>
                            <td class="text-left" nowrap="">FJ/22/09/000001&nbsp;</td>
                            <td class="text-left">01/09/2022&nbsp;</td>
                            <td class="text-left">-&nbsp;</td>
                            <td class="text-right">100,000.00&nbsp;</td>
                            <td class="text-right">10,000.00&nbsp;</td>
                            <td class="text-right">110,000.00&nbsp;</td>
                        </tr>
                        <tr align="left">
                            <td class="text-right">2&nbsp;</td>
                            <td class="text-left" nowrap="">FJ/22/09/000002&nbsp;</td>
                            <td class="text-left">05/09/2022&nbsp;</td>
                            <td class="text-left">30/09/2022&nbsp;</td>
                            <td class="text-right">100,000.00&nbsp;</td>
                            <td class="text-right">10,000.00&nbsp;</td>
                            <td class="text-right">110,000.00&nbsp;</td>
                        </tr>
                        <tr align="left">
                            <td class="text-right">3&nbsp;</td>
                            <td class="text-left" nowrap="">FJ/22/09/000004&nbsp;</td>
                            <td class="text-left">12/09/2022&nbsp;</td>
                            <td class="text-left">10/10/2022&nbsp;</td>
                            <td class="text-right">80,000.00&nbsp;</td>
                            <td class="text-right">8,000.00&nbsp;</td>
                            <td class="text-right">88,000.00&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="text-right" colspan="6"><b>TOTAL</b></td>
                            <td class="text-right">308,000.00</td>
                        </tr>
                        <tr>
                            <td colspan="7"><b>PT XYZ</b></td>
                        </tr>
                        <tr align="left">
                            <td class="text-right">1&nbsp;</td>
                            <td class="text-left" nowrap="">FJ/22/09/000003&nbsp;</td>
                            <td class="text-left">08/09/2022&nbsp;</td>
                            <td class="text-left">30/09/2022&nbsp;</td>
                            <td class="text-right">90,000.00&nbsp;</td>
                            <td class="text-right">9,000.00&nbsp;</td>
                            <td class="text-right">99,000.00&nbsp;</td>
                        </tr>

                        <tr>
                            <td class="text-right" colspan="6"><b>TOTAL</b></td>
                            <td class="text-right">99,000.00</td>
                        </tr>

                    </tbody>
                </table>
                <br>
            </div>

        </div>
    </div>
</div>




<?= $this->endSection() ?>