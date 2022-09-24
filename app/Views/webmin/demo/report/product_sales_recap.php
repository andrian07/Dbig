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
                            <p class="header2">REKAPITULASI PENJUALAN PER PRODUK<br><br></p>
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
                                        <td class="loseborder">Golongan</td>
                                        <td class="loseborder">: BKP - BARANG KENA PAJAK&nbsp;</td>
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
                            <th class="header-table" width="3%">NO</th>
                            <th class="header-table" width="10%" nowrap="">BARCODE</th>
                            <th class="header-table" width="42%">NAMA PRODUK</th>
                            <th class="header-table" width="15%">QTY</th>
                            <th class="header-table" width="15%">SATUAN</th>
                            <th class="header-table" width="15%">TOTAL PENJUALAN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr align="left">
                            <td class="text-right">1&nbsp;</td>
                            <td align="text-left" nowrap="">1234567899999&nbsp;</td>
                            <td class="col-fixed text-left">Toto Gantungan Double Robe Hook (TX04AES)&nbsp;</td>
                            <td class="text-right">10.00&nbsp;</td>
                            <td class="text-left">DUS&nbsp;</td>
                            <td class="text-right">12,500,000.00&nbsp;</td>
                        </tr>
                        <tr align="left">
                            <td class="text-right">2&nbsp;</td>
                            <td align="text-left" nowrap="">1234567899777&nbsp;</td>
                            <td class="col-fixed text-left">Toto Gantungan Double Robe Hook (TX04AES)&nbsp;</td>
                            <td class="text-right">10.00&nbsp;</td>
                            <td class="text-left">PCS &nbsp;</td>
                            <td class="text-right">277,500.00&nbsp;</td>
                        </tr>
                        <tr align="left">
                            <td class="text-right">3&nbsp;</td>
                            <td class="text-left" nowrap="">12089898398&nbsp;</td>
                            <td class="col-fixed text-left">Toto Floor Drain (TX1DA)&nbsp;</td>
                            <td class="text-right">5.00&nbsp;</td>
                            <td class="text-left">PCS &nbsp;</td>
                            <td class="text-right">125,000.00&nbsp;</td>
                        </tr>
                        <?php for ($i = 4; $i <= 25; $i++) { ?>
                            <tr align="left">
                                <td class="text-right"><?= $i ?>&nbsp;</td>
                                <td class="text-left" nowrap="">00000000000&nbsp;</td>
                                <td class="col-fixed text-left">Dummy Item&nbsp;</td>
                                <td class="text-right">0.00&nbsp;</td>
                                <td class="text-left">PCS &nbsp;</td>
                                <td class="text-right">0.00&nbsp;</td>
                            </tr>
                        <?php  } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5" align="right">TOTAL</th>
                            <th align="right">12,902,500.00</th>
                        </tr>
                    </tfoot>
                </table>
                <br>
            </div>

        </div>
    </div>
</div>

<div style="margin:0px;padding:0px;">
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
                            <p class="header2">REKAPITULASI PENJUALAN PER PRODUK<br><br></p>
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
                                        <td class="loseborder">Golongan</td>
                                        <td class="loseborder">: BKP - BARANG KENA PAJAK&nbsp;</td>
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
                                        <td>:&nbsp;2/2&nbsp;</td>
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
                            <th class="header-table" width="3%">NO</th>
                            <th class="header-table" width="10%" nowrap="">BARCODE</th>
                            <th class="header-table" width="42%">NAMA PRODUK</th>
                            <th class="header-table" width="15%">QTY</th>
                            <th class="header-table" width="15%">SATUAN</th>
                            <th class="header-table" width="15%">TOTAL PENJUALAN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i = 26; $i <= 50; $i++) { ?>
                            <tr align="left">
                                <td class="text-right"><?= $i ?>&nbsp;</td>
                                <td class="text-left" nowrap="">00000000000&nbsp;</td>
                                <td class="col-fixed text-left">Dummy Item&nbsp;</td>
                                <td class="text-right">0.00&nbsp;</td>
                                <td class="text-left">PCS &nbsp;</td>
                                <td class="text-right">0.00&nbsp;</td>
                            </tr>
                        <?php  } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5" align="right">TOTAL</th>
                            <th align="right">12,902,500.00</th>
                        </tr>
                    </tfoot>
                </table>
                <br>
            </div>

        </div>
    </div>
</div>



<?= $this->endSection() ?>