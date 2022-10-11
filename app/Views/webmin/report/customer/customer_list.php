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
                            <p class="header2">Daftar Customer<br><br></p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td width="50%" class="loseborder">
                            <table>
                                <tbody>
                                    <tr align="left" class="loseborder">
                                        <td width="120" class="loseborder">Kabupaten</td>
                                        <td class="loseborder">: -&nbsp;</td>
                                    </tr>
                                    <tr align="left">
                                        <td class="loseborder">Kecamatan</td>
                                        <td class="loseborder">: -</td>
                                    </tr>
                                    <tr align="left">
                                        <td class="loseborder">Kelurahan</td>
                                        <td class="loseborder">: -</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td width="50%" class="loseborder">
                            <table>
                                <tbody>
                                    <tr align="left">
                                        <td width="120" class="text-right">Hal</td>
                                        <td>:&nbsp;1/2&nbsp;</td>
                                    </tr>
                                    <tr align="left">
                                        <td class="text-right">Grup</td>
                                        <td class="">:&nbsp;G1 - UMUM</td>
                                    </tr>
                                    <tr align="left">
                                        <td class="text-right">Masa Berlaku</td>
                                        <td class="">:&nbsp;Masih Berlaku</td>
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
                            <th class="header-table" width="10%" nowrap="">KODE CUSTOMER</th>
                            <th class="header-table" width="15%">NAMA CUSTOMER</th>
                            <th class="header-table" width="35%">ALAMAT</th>
                            <th class="header-table" width="17%">NO TELP</th>
                            <th class="header-table" width="10%" nowrap="">GRUP CUSTOMER</th>
                            <th class="header-table" width="10%" nowrap="">EXP DATE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr align="left">
                            <td class="text-right">1&nbsp;</td>
                            <td align="text-left" nowrap="">0000000001&nbsp;</td>
                            <td class="text-left">Samsul&nbsp;</td>
                            <td class="col-fixed text-left">Jl.Sui raya km 8.5 no 25&nbsp;</td>
                            <td class="col-fixed text-left">
                                0896-7899-8899
                            </td>
                            <td class="text-left">G1 - Silver&nbsp;</td>
                            <td class="text-left">15/10/2022&nbsp;</td>
                        </tr>
                        <tr align="left">
                            <td class="text-right">2&nbsp;</td>
                            <td align="text-left" nowrap="">0000000002&nbsp;</td>
                            <td class="col-fixed text-left">Udin&nbsp;</td>
                            <td class="col-fixed text-left">Jl.Sui raya km 8.5 no 39
                                (Sebelah Smk Immanuel II)&nbsp;</td>
                            <td class="col-fixed text-left">
                                0896-7899-5555
                            </td>
                            <td class="text-left">G2 - Gold&nbsp;</td>
                            <td class="text-left">31/10/2022&nbsp;</td>
                        </tr>
                        <tr align="left">
                            <td class="text-right">3&nbsp;</td>
                            <td class="text-left" nowrap="">0000000003&nbsp;</td>
                            <td class="text-left">Ricky Acinda&nbsp;</td>
                            <td class="col-fixed text-left">Jl.Gajah Mada GG.XYZ No 10&nbsp;</td>
                            <td class="col-fixed text-left">0896-8888-5656&nbsp;</td>
                            <td class="text-left">G3 - Platinum&nbsp;</td>
                            <td class="text-left">31/12/2022&nbsp;</td>
                        </tr>
                        <tr align="left">
                            <td class="text-right">4&nbsp;</td>
                            <td class="text-left" nowrap="">0000000004&nbsp;</td>
                            <td class="text-left">PT Aneka Jaya&nbsp;</td>
                            <td class="col-fixed text-left">Jl.Gajah Mada No.5&nbsp;</td>
                            <td class="col-fixed text-left">0896-7899-8899&nbsp;</td>
                            <td class="text-left">G4 - Proyek&nbsp;</td>
                            <td class="text-left">31/12/2022&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
                <br>
            </div>

        </div>
    </div>
</div>



<?= $this->endSection() ?>