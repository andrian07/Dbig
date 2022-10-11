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
                            <p class="header2">DAFTAR STOK PRODUK<br><br></p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td width="50%" class="loseborder">
                            <table>
                                <tbody>
                                    <tr align="left" class="loseborder">
                                        <td width="120" class="loseborder">Gudang</td>
                                        <td class="loseborder">: UTM - UTAMA&nbsp;</td>
                                    </tr>
                                    <tr align="left">
                                        <td class="loseborder">Golongan</td>
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
                                        <td>:&nbsp;2/2&nbsp;</td>
                                    </tr>
                                    <tr align="left">
                                        <td class="text-right"></td>
                                        <td class="">&nbsp;</td>
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
                            <th class="header-table" width="10%" nowrap="">KODE PRODUK</th>
                            <th class="header-table" width="37%">NAMA PRODUK</th>
                            <th class="header-table" width="10%">KATEGORI</th>
                            <th class="header-table" width="5%">PPN</th>
                            <th class="header-table" width="20%">GUDANG</th>
                            <th class="header-table" width="5%" nowrap="">STOK</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr align="left">
                            <td class="text-right">1&nbsp;</td>
                            <td align="text-left" nowrap="">P000001&nbsp;</td>
                            <td class="text-left col-fixed">Toto Gantungan Double Robe Hook (TX04AES)&nbsp;</td>
                            <td class="col-fixed text-left">Gantungan</td>
                            <td class="col-fixed text-left">Y</td>
                            <td class="col-fixed text-left">UTM - UTAMA</td>
                            <td class="text-right">10.00&nbsp;</td>
                        </tr>

                        <tr align="left">
                            <td class="text-right">2&nbsp;</td>
                            <td align="text-left" nowrap="">P000002&nbsp;</td>
                            <td class="text-left col-fixed">Toto Floor Drain (TX1DA)&nbsp;</td>
                            <td class="col-fixed text-left">Floor Drain</td>
                            <td class="col-fixed text-left">N</td>
                            <td class="col-fixed text-left">UTM - UTAMA</td>
                            <td class="text-right">30.00&nbsp;</td>
                        </tr>
                        <?php for ($i = 3; $i <= 15; $i++) { ?>
                            <tr align="left">
                                <td class="text-right"><?= $i ?>&nbsp;</td>
                                <td align="text-left" nowrap="">P999999&nbsp;</td>
                                <td class="text-left col-fixed">Dummy Item&nbsp;</td>
                                <td class="col-fixed text-left">Floor Drain</td>
                                <td class="col-fixed text-left">N</td>
                                <td class="col-fixed text-left">UTM - UTAMA</td>
                                <td class="text-right">10.00&nbsp;</td>
                            </tr>
                        <?php  } ?>


                    </tbody>
                </table>
                <br>
            </div>

        </div>
    </div>
</div>

<?php for ($page = 2; $page <= 10; $page++) { ?>
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
                                <p class="header2">DAFTAR STOK PRODUK<br><br></p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <td width="50%" class="loseborder">
                                <table>
                                    <tbody>
                                        <tr align="left" class="loseborder">
                                            <td width="120" class="loseborder">Gudang</td>
                                            <td class="loseborder">: UTM - UTAMA&nbsp;</td>
                                        </tr>
                                        <tr align="left">
                                            <td class="loseborder">Golongan</td>
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
                                            <td>:&nbsp;<? $page ?>/9999&nbsp;</td>
                                        </tr>
                                        <tr align="left">
                                            <td class="text-right"></td>
                                            <td class="">&nbsp;</td>
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
                                <th class="header-table" width="10%" nowrap="">KODE PRODUK</th>
                                <th class="header-table" width="37%">NAMA PRODUK</th>
                                <th class="header-table" width="10%">KATEGORI</th>
                                <th class="header-table" width="5%">PPN</th>
                                <th class="header-table" width="20%">GUDANG</th>
                                <th class="header-table" width="5%" nowrap="">STOK</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $start_row = (($page - 1) * 15) + 1;
                            $end_row = $start_row + 15;
                            ?>
                            <?php for ($i = $start_row; $i <= $end_row; $i++) { ?>
                                <tr align="left">
                                    <td class="text-right"><?= $i ?>&nbsp;</td>
                                    <td align="text-left" nowrap="">P000001&nbsp;</td>
                                    <td class="text-left col-fixed">Toto Gantungan Double Robe Hook (TX04AES)&nbsp;</td>
                                    <td class="col-fixed text-left">Gantungan</td>
                                    <td class="col-fixed text-left">Y</td>
                                    <td class="col-fixed text-left">UTM - UTAMA</td>
                                    <td class="text-right">10.00&nbsp;</td>
                                </tr>
                            <?php  } ?>
                        </tbody>
                    </table>
                    <br>
                </div>

            </div>
        </div>
    </div>
<?php } ?>



<?= $this->endSection() ?>