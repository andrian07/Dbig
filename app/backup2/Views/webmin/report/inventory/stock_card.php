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
                            <p class="header2">KARTU STOK<br><br></p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td width="70%" class="loseborder">
                            <table>
                                <tbody>
                                    <tr align="left" class="loseborder">
                                        <td width="120" class="loseborder">Kode Produk</td>
                                        <td class="loseborder">: P000001&nbsp;</td>
                                    </tr>
                                    <tr align="left">
                                        <td class="loseborder">Nama Produk</td>
                                        <td class="loseborder">: Toto Gantungan Double Robe Hook (TX04AES)&nbsp;</td>
                                    </tr>
                                    <tr align="left">
                                        <td class="loseborder">Periode</td>
                                        <td class="loseborder">: OKTOBER 2022&nbsp;</td>
                                    </tr>
                                    <tr align="left">
                                        <td class="loseborder">Gudang</td>
                                        <td class="loseborder">: UTM - UTAMA&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td width="30%" class="loseborder">
                            <table>
                                <tbody>
                                    <tr align="left">
                                        <td width="70" class="text-right">Hal</td>
                                        <td>:&nbsp;1/2&nbsp;</td>
                                    </tr>
                                    <tr align="left">
                                        <td class="text-right">Satuan Dasar</td>
                                        <td class="">:&nbsp;PCS</td>
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
                            <th class="header-table" width="5%" nowrap="">TGL</th>
                            <th class="header-table" width="65%" colspan="2">KETERANGAN</th>
                            <th class="header-table" width="10%">MASUK</th>
                            <th class="header-table" width="10%">KELUAR</th>
                            <th class="header-table" width="10%" nowrap="">SISA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr align="left">
                            <td align="text-left" nowrap="">01&nbsp;</td>
                            <td class="text-left col-fixed" width="80px">SA&nbsp;</td>
                            <td class="col-fixed text-left">SALDO AWAL</td>
                            <td class="text-right">0.00</td>
                            <td class="text-right">0.00</td>
                            <td class="text-right">10.00&nbsp;</td>
                        </tr>
                        <tr align="left">
                            <td class="text-left">&nbsp;</td>
                            <td align="text-left" nowrap="">SI&nbsp;</td>
                            <td class="text-left col-fixed">PENJUALAN SI/UTM/22/10/00001&nbsp;</td>
                            <td class="text-right">0.00</td>
                            <td class="text-right">2.00</td>
                            <td class="text-right">8.00&nbsp;</td>
                        </tr>
                        <tr align="left">
                            <td align="text-left" nowrap="">02&nbsp;</td>
                            <td class="text-left col-fixed">PI&nbsp;</td>
                            <td class="col-fixed text-left">PEMBELIAN PI/UTM/22/09/000001</td>
                            <td class="text-right">15.00</td>
                            <td class="text-right">0.00</td>
                            <td class="text-right">23.00&nbsp;</td>
                        </tr>

                        <tr align="left">
                            <td align="text-left" nowrap="">03&nbsp;</td>
                            <td class="text-left col-fixed">OP&nbsp;</td>
                            <td class="col-fixed text-left">OPNAME OP/UTM/22/09/000001</td>
                            <td class="text-right">20.00</td>
                            <td class="text-right">0.00</td>
                            <td class="text-right">20.00&nbsp;</td>
                        </tr>

                        <tr align="left">
                            <td class="text-left">&nbsp;</td>
                            <td align="text-left" nowrap="">SI&nbsp;</td>
                            <td class="text-left col-fixed">PENJUALAN SI/UTM/22/10/00002&nbsp;</td>
                            <td class="text-right">0.00</td>
                            <td class="text-right">5.00</td>
                            <td class="text-right">15.00&nbsp;</td>
                        </tr>

                        <tr align="left">
                            <td align="text-left" nowrap="">05&nbsp;</td>
                            <td class="text-left col-fixed">SR&nbsp;</td>
                            <td class="col-fixed text-left">RETUR PENJUALAN SR/UTM/22/09/000001</td>
                            <td class="text-right">2.00</td>
                            <td class="text-right">0.00</td>
                            <td class="text-right">17.00&nbsp;</td>
                        </tr>

                        <tr align="left">
                            <td align="text-left" nowrap="">06&nbsp;</td>
                            <td class="text-left col-fixed">PR&nbsp;</td>
                            <td class="col-fixed text-left">RETUR PEMBELIAN PR/UTM/22/09/000001</td>
                            <td class="text-right">0.00</td>
                            <td class="text-right">10.00</td>
                            <td class="text-right">7.00&nbsp;</td>
                        </tr>

                    </tbody>
                </table>
                <br>
            </div>

        </div>
    </div>
</div>


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
                            <p class="header2">KARTU STOK<br><br></p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td width="70%" class="loseborder">
                            <table>
                                <tbody>
                                    <tr align="left" class="loseborder">
                                        <td width="120" class="loseborder">Kode Produk</td>
                                        <td class="loseborder">: P000001&nbsp;</td>
                                    </tr>
                                    <tr align="left">
                                        <td class="loseborder">Nama Produk</td>
                                        <td class="loseborder">: Toto Gantungan Double Robe Hook (TX04AES)&nbsp;</td>
                                    </tr>
                                    <tr align="left">
                                        <td class="loseborder">Periode</td>
                                        <td class="loseborder">: OKTOBER 2022&nbsp;</td>
                                    </tr>
                                    <tr align="left">
                                        <td class="loseborder">Gudang</td>
                                        <td class="loseborder">: KBR - KOTA BARU&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td width="30%" class="loseborder">
                            <table>
                                <tbody>
                                    <tr align="left">
                                        <td width="70" class="text-right">Hal</td>
                                        <td>:&nbsp;2/2&nbsp;</td>
                                    </tr>
                                    <tr align="left">
                                        <td class="text-right">Satuan Dasar</td>
                                        <td class="">:&nbsp;PCS</td>
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
                            <th class="header-table" width="5%" nowrap="">TGL</th>
                            <th class="header-table" width="65%" colspan="2">KETERANGAN</th>
                            <th class="header-table" width="10%">MASUK</th>
                            <th class="header-table" width="10%">KELUAR</th>
                            <th class="header-table" width="10%" nowrap="">SISA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr align="left">
                            <td align="text-left" nowrap="">01&nbsp;</td>
                            <td class="text-left col-fixed" width="80px">SA&nbsp;</td>
                            <td class="col-fixed text-left">SALDO AWAL</td>
                            <td class="text-right">0.00</td>
                            <td class="text-right">0.00</td>
                            <td class="text-right">10.00&nbsp;</td>
                        </tr>
                        <tr align="left">
                            <td class="text-left">&nbsp;</td>
                            <td align="text-left" nowrap="">SI&nbsp;</td>
                            <td class="text-left col-fixed">PENJUALAN SI/UTM/22/10/00001&nbsp;</td>
                            <td class="text-right">0.00</td>
                            <td class="text-right">2.00</td>
                            <td class="text-right">8.00&nbsp;</td>
                        </tr>
                        <tr align="left">
                            <td align="text-left" nowrap="">02&nbsp;</td>
                            <td class="text-left col-fixed">PI&nbsp;</td>
                            <td class="col-fixed text-left">PEMBELIAN PI/UTM/22/09/000001</td>
                            <td class="text-right">15.00</td>
                            <td class="text-right">0.00</td>
                            <td class="text-right">23.00&nbsp;</td>
                        </tr>

                        <tr align="left">
                            <td align="text-left" nowrap="">03&nbsp;</td>
                            <td class="text-left col-fixed">OP&nbsp;</td>
                            <td class="col-fixed text-left">OPNAME OP/UTM/22/09/000001</td>
                            <td class="text-right">20.00</td>
                            <td class="text-right">0.00</td>
                            <td class="text-right">20.00&nbsp;</td>
                        </tr>

                        <tr align="left">
                            <td class="text-left">&nbsp;</td>
                            <td align="text-left" nowrap="">SI&nbsp;</td>
                            <td class="text-left col-fixed">PENJUALAN SI/UTM/22/10/00002&nbsp;</td>
                            <td class="text-right">0.00</td>
                            <td class="text-right">5.00</td>
                            <td class="text-right">15.00&nbsp;</td>
                        </tr>

                        <tr align="left">
                            <td align="text-left" nowrap="">05&nbsp;</td>
                            <td class="text-left col-fixed">SR&nbsp;</td>
                            <td class="col-fixed text-left">RETUR PENJUALAN SR/UTM/22/09/000001</td>
                            <td class="text-right">2.00</td>
                            <td class="text-right">0.00</td>
                            <td class="text-right">17.00&nbsp;</td>
                        </tr>

                        <tr align="left">
                            <td align="text-left" nowrap="">06&nbsp;</td>
                            <td class="text-left col-fixed">PR&nbsp;</td>
                            <td class="col-fixed text-left">RETUR PEMBELIAN PR/UTM/22/09/000001</td>
                            <td class="text-right">0.00</td>
                            <td class="text-right">10.00</td>
                            <td class="text-right">7.00&nbsp;</td>
                        </tr>

                    </tbody>
                </table>
                <br>
            </div>

        </div>
    </div>
</div>




<?= $this->endSection() ?>