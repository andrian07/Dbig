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
foreach ($pages as $customerData) :
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
                                <p class="header2">DAFTAR CUSTOMER</p>
                                <br>
                            </td>
                        </tr>
                        <tr valign="top">
                            <td width="30%" class="loseborder">
                                <table>
                                    <tbody>
                                        <tr align="left" class="loseborder">
                                            <td width="60" class="loseborder">Provinsi</td>
                                            <td width="160" class="loseborder">: <?= $prov_name ?></td>
                                        </tr>
                                        <tr align="left">
                                            <td class="loseborder">Kota/Kab</td>
                                            <td class="col-fixed">: <?= $city_name ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td width="40%" class="loseborder">
                                <table>
                                    <tbody>
                                        <tr align="left" class="loseborder">
                                            <td width="60" class="loseborder">Kecamatan</td>
                                            <td width="160" class="loseborder">: <?= $dis_name ?></td>
                                        </tr>
                                        <tr align="left">
                                            <td class="loseborder">Kelurahan</td>
                                            <td class="col-fixed">: <?= $subdis_name ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td width="30%" class="loseborder">
                                <table>
                                    <tbody>
                                        <tr align="left" class="loseborder">
                                            <td width="70" class="loseborder">Hal</td>
                                            <td width="150" class="loseborder">:&nbsp;<?= $currentPage ?>/<?= $maxPage ?>&nbsp;</td>
                                        </tr>
                                        <tr align="left">
                                            <td class="loseborder">Grup</td>
                                            <td class="col-fixed">: <?= $customer_group == '' ? '-' : $customer_group_text ?></td>
                                        </tr>
                                        <tr align="left">
                                            <td class="loseborder">Masa Berlaku</td>
                                            <td class="col-fixed">: <?= $exp_date == '' ? '-' : $exp_date_text ?></td>
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
                            <?php
                            foreach ($customerData as $row) :
                            ?>
                                <tr align="left">
                                    <td class="text-right"><?= $num_row ?>&nbsp;</td>
                                    <td align="text-left" nowrap=""><?= $row['customer_code'] ?>&nbsp;</td>
                                    <td class="text-left"><?= $row['customer_name'] ?>&nbsp;</td>
                                    <td class="col-fixed text-left"><?= $row['customer_address'] ?>&nbsp;</td>
                                    <td class="col-fixed text-left"><?= $row['customer_phone'] ?></td>
                                    <td class="text-left"><?= isset($configGroup[$row['customer_group']]) ? $configGroup[$row['customer_group']] : 'ERROR' ?>&nbsp;</td>
                                    <td class="text-left"><?= indo_short_date($row['exp_date'], FALSE) ?>&nbsp;</td>
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