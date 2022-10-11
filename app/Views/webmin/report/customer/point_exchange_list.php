<?= $this->extend('webmin/template/report_A4_landscape_template') ?>

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
                            <p class="header2">DAFTAR PENUKARAN POIN<br><br></p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td width="50%" class="loseborder">
                            <table>
                                <tbody>
                                    <tr align="left" class="loseborder">
                                        <td width="120" class="loseborder">Customer</td>
                                        <td class="loseborder">: -&nbsp;</td>
                                    </tr>
                                    <tr align="left">
                                        <td class="loseborder">Periode</td>
                                        <td class="loseborder">: 01/10/2022 s.d 30/10/2022</td>
                                    </tr>
                                    <tr align="left" class="loseborder">
                                        <td width="120" class="loseborder">Status</td>
                                        <td class="loseborder">: -&nbsp;</td>
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
                                        <td class=""></td>
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
                            <th class="header-table" width="10%" nowrap="">KODE<br>CUSTOMER</th>
                            <th class="header-table" width="15%">NAMA<br>CUSTOMER</th>
                            <th class="header-table" width="22%" nowrap="">NAMA ITEM</th>
                            <th class="header-table" width="5%" nowrap="">POIN</th>
                            <th class="header-table" width="10%">TGL<br>PENUKARAN</th>
                            <th class="header-table" width="10%">TGL<br>PENGAMBILAN</th>
                            <th class="header-table" width="15%" nowrap="">LOKASI <br>PENGAMBILAN HADIAH</th>
                            <th class="header-table" width="10%" nowrap="">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr align="left">
                            <td class="text-right">1&nbsp;</td>
                            <td class="text-left" nowrap="">0000000001&nbsp;</td>
                            <td class="text-left">Samsul&nbsp;</td>
                            <td class="col-fixed text-left" nowrap="">Kopin Mangkok Vegetable Bowl 9″ Kukuruyuk (KPQ-9VB)&nbsp;</td>
                            <td class="col-fixed text-right">50.00</td>
                            <td class="text-left">01/10/2022&nbsp;</td>
                            <td class="text-left">05/10/2022&nbsp;</td>
                            <td class="col-fixed text-left">DBIG&nbsp;</td>
                            <td class="col-fixed text-left">SELESAI&nbsp;</td>
                        </tr>
                        <tr align="left">
                            <td class="text-right">2&nbsp;</td>
                            <td class="text-left" nowrap="">0000000003&nbsp;</td>
                            <td class="text-left">Ricky Acinda&nbsp;</td>
                            <td class="col-fixed text-left" nowrap="">Kopin Mangkok Vegetable Bowl 9″ Kukuruyuk (KPQ-9VB)&nbsp;</td>
                            <td class="col-fixed text-right">50.00</td>
                            <td class="text-left">01/10/2022&nbsp;</td>
                            <td class="text-left">-&nbsp;</td>
                            <td class="col-fixed text-left">-&nbsp;</td>
                            <td class="col-fixed text-left">CANCEL&nbsp;</td>
                        </tr>

                        <tr align="left">
                            <td class="text-right">3&nbsp;</td>
                            <td class="text-left" nowrap="">0000000002&nbsp;</td>
                            <td class="text-left">Udin&nbsp;</td>
                            <td class="col-fixed text-left" nowrap="">Kopin Mangkok Vegetable Bowl 9″ Kukuruyuk (KPQ-9VB)&nbsp;</td>
                            <td class="col-fixed text-right">50.00</td>
                            <td class="text-left">01/10/2022&nbsp;</td>
                            <td class="text-left">-&nbsp;</td>
                            <td class="col-fixed text-left">-&nbsp;</td>
                            <td class="col-fixed text-left">PROSES&nbsp;</td>
                        </tr>


                        <tr align="left">
                            <td class="text-right">4&nbsp;</td>
                            <td class="text-left" nowrap="">0000000003&nbsp;</td>
                            <td class="text-left">Ricky Acinda&nbsp;</td>
                            <td class="col-fixed text-left" nowrap="">Kopin Mangkok Vegetable Bowl 9″ Kukuruyuk (KPQ-9VB)&nbsp;</td>
                            <td class="col-fixed text-right">50.00</td>
                            <td class="text-left">10/10/2022&nbsp;</td>
                            <td class="text-left">10/10/2022&nbsp;</td>
                            <td class="col-fixed text-left">-&nbsp;</td>
                            <td class="col-fixed text-left">SELESAI&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
                <br>
            </div>

        </div>
    </div>
</div>



<?= $this->endSection() ?>