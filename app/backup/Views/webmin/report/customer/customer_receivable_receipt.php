<?= $this->extend('webmin/template/report_A4_template') ?>

<?= $this->section('css') ?>
<style>
    #sample {
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
                    &nbsp;
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
            <table width="780px">
                <tbody>
                    <tr>
                        <td colspan="2" align="center">
                            <p class="header2">TAGIHAN PIUTANG CUSTOMER<br><br></p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td width="50%" class="loseborder">
                            <table>
                                <tbody>
                                    <tr align="left" class="loseborder">
                                        <td width="120" class="loseborder">Nama Customer</td>
                                        <td class="loseborder">: Samsul&nbsp;</td>
                                    </tr>
                                    <tr align="left" class="loseborder">
                                        <td width="120" class="loseborder">Alamat</td>
                                        <td class="loseborder">: Jl.Sui raya km 8.5 no 25&nbsp;</td>
                                    </tr>
                                    <tr align="left" class="loseborder">
                                        <td width="120" class="loseborder">Telp</td>
                                        <td class="loseborder">: 0896-7899-8899&nbsp;</td>
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
                                        <td class="text-right">Tanggal</td>
                                        <td class="">: 10 Oktober 2022</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- END HEADER -->
            <br>
            <div style="width:780px; margin:auto;">
                <table width="100%" celpadding="0" cellspacing="0" class="table-bordered table-detail">
                    <thead>
                        <tr>
                            <th class="header-table" width="3%">NO</th>
                            <th class="header-table" width="20%" nowrap="">NO INVOICE</th>
                            <th class="header-table" width="17%" nowrap="">TGL. INVOICE</th>
                            <th class="header-table" width="20%">TGL. JATUH TEMPO</th>
                            <th class="header-table" width="20%">TOTAL TRANSAKSI</th>
                            <th class="header-table" width="20%">SISA PIUTANG</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr align="left">
                            <td class="text-right">1&nbsp;</td>
                            <td class="col-fixed text-left" nowrap="">SI/UTM/22/09/P000001&nbsp;</td>
                            <td class="text-left">10/09/2022</td>
                            <td class="text-left">01/10/2022&nbsp;</td>
                            <td class="text-right">10,000,000.00&nbsp;</td>
                            <td class="text-right">5,000,000.00&nbsp;</td>
                        </tr>
                        <tr align="left">
                            <td class="text-right">2&nbsp;</td>
                            <td class="col-fixed text-left" nowrap="">SI/UTM/22/09/P000003&nbsp;</td>
                            <td class="text-left">25/09/2022</td>
                            <td class="text-left">10/10/2022&nbsp;</td>
                            <td class="text-right">5,000,000.00&nbsp;</td>
                            <td class="text-right">3,000,000.00&nbsp;</td>
                        </tr>
                        <tr align="left">
                            <td class="text-right" nowrap="" colspan="5"><b>TOTAL</b>&nbsp;</td>
                            <td class="text-right">8,000,000.00&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
                <br>
            </div>

            <div style="width:780px; margin:auto;">
                <table class="table-noborder" width="100%" border="0">
                    <tbody>
                        <tr>
                            <td align="center">Hormat Kami</td>
                            <td width="35%"></td>
                            <td align="center">Penerima</td>
                        </tr>
                        <tr>
                            <td height="75px"></td>
                            <td height="75px"></td>
                            <td height="75px"></td>
                        </tr>
                        <tr>
                            <td align="center" nowrap=""><span class="signature">_________________________</span></td>
                            <td></td>
                            <td align="center" nowrap=""><span class="signature">_________________________</span></td>
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