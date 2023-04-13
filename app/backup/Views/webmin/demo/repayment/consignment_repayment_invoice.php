<?= $this->extend('webmin/template/report_A4_template') ?>

<?= $this->section('css') ?>
<style>
    #sample {
        color: red;
    }
</style>
<?= $this->endSection() ?>


<?= $this->section('content') ?>
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
            <table width="780px">
                <tbody>
                    <tr>
                        <td colspan="2" align="center">
                            <p class="header2">REKAP PEMBAYARAN KONSINYASI<br><br></p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td width="65%" class="loseborder">
                            <table>
                                <tbody>
                                    <tr align="left" class="loseborder">
                                        <td width="120" class="loseborder">Tanggal</td>
                                        <td class="loseborder">: 03/09/2022&nbsp;</td>
                                    </tr>
                                    <tr align="left">
                                        <td class="loseborder">Supplier</td>
                                        <td class="loseborder">: PT NIPPON INDONESIA&nbsp;</td>
                                    </tr>
                                    <tr align="left">
                                        <td class="loseborder"></td>
                                        <td class="loseborder">&nbsp;&nbsp;Jl Sungai Raya Dalam Komplek ABC No.10&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td width="35%" class="loseborder">
                            <table>
                                <tbody>
                                    <tr align="left">
                                        <td width="120" class="text-right">Hal</td>
                                        <td>:&nbsp;1/1&nbsp;</td>
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
            <div style="width:780px; margin:auto;">
                <table width="100%" celpadding="0" cellspacing="0" class="table-bordered table-detail">
                    <thead>
                        <tr>
                            <th class="header-table" width="10%" nowrap="">NO FAKTUR</th>
                            <th class="header-table" width="10%" nowrap="">KODE <br>PRODUK</th>
                            <th class="header-table" width="45%">NAMA PRODUK</th>
                            <th class="header-table" width="15%">HARGA SATUAN</th>
                            <th class="header-table" width="15%">QTY</th>
                            <th class="header-table" width="15%">SUBTOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr align="left">
                            <td align="text-left" nowrap="">FK0001&nbsp;</td>
                            <td align="text-left" nowrap="">1234567899999&nbsp;</td>
                            <td class="col-fixed text-left">Toto Gantungan Double Robe Hook (TX04AES)&nbsp;</td>
                            <td class="text-right">110,000.00&nbsp;</td>
                            <td class="text-right">5.00&nbsp;</td>
                            <td class="text-right">550,000.00&nbsp;</td>
                        </tr>
                        <tr align="left">
                            <td align="text-left" nowrap="">FK0002&nbsp;</td>
                            <td align="text-left" nowrap="">1234567899999&nbsp;</td>
                            <td class="col-fixed text-left">Toto Gantungan Double Robe Hook (TX04AES)&nbsp;</td>
                            <td class="text-right">111,000.00&nbsp;</td>
                            <td class="text-right">5.00&nbsp;</td>
                            <td class="text-right">555,000.00&nbsp;</td>
                        </tr>
                        <tr align="left">
                            <td align="text-left" nowrap="">FK0001&nbsp;</td>
                            <td align="text-left" nowrap="">12089898398&nbsp;</td>
                            <td class="col-fixed text-left">Toto Floor Drain (TX1DA)&nbsp;</td>
                            <td class="text-right">27,750.00&nbsp;</td>
                            <td class="text-right">50.00&nbsp;</td>
                            <td class="text-right">1,387,500.00&nbsp;</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5" align="right">TOTAL</th>
                            <th align="right">2,442,500.00</th>
                        </tr>
                    </tfoot>
                </table>

                <br><br>
            </div>

            <br>
            <div style="width:780px; margin:auto;">
                <table class="table-noborder" width="80%" border="0">
                    <tbody>
                        <tr>
                            <td align="center">Hormat Kami</td>
                            <td width="35%"></td>
                            <td align="center">Tanda Terima</td>
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