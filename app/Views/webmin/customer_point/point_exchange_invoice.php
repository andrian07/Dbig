<?= $this->extend('webmin/template/report_A4_template') ?>

<?= $this->section('css') ?>
<style>
    .text-red {
        color: red;
    }

    .ttd {
        text-align: center;
    }

    .underline {
        border-bottom: 1px #000;

    }
</style>
<?= $this->endSection() ?>


<?= $this->section('content') ?>
<div style="margin:0px;padding:0px;">
    <table width="100%" border="0" cellpadding="1" cellspacing="1" style="background-color:#FFFFFF;  ">
        <tbody>
            <tr style="background-color:#FFFFFF;">
                <td nowrap="" align="left" valign="top" width="100%" style="background-color:#FFFFFF;" class="text-right">
                    <br>

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
            <table width="780px">
                <tbody>
                    <tr>
                        <td colspan="2" align="center">
                            <p class="header2">INVOICE PENUKARAN POIN<br><br></p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td width="50%" class="loseborder">
                            <table>
                                <tbody>
                                    <tr align="left" class="loseborder">
                                        <td width="120" class="loseborder">NO PENUKARAN</td>
                                        <td class="loseborder">: <?= $detail['exchange_code'] ?></td>
                                    </tr>
                                    <tr align="left">
                                        <td class="loseborder">CUSTOMER</td>
                                        <td class="loseborder">: <?= $detail['customer_name'] ?></td>
                                    </tr>
                                    <tr align="left">
                                        <td class="loseborder"></td>
                                        <td class="loseborder">&nbsp;&nbsp;<?= $detail['customer_address'] ?></td>
                                    </tr>
                                    <tr align="left">
                                        <td class="loseborder"></td>
                                        <td class="loseborder">&nbsp;&nbsp;<?= $detail['customer_phone'] ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td width="50%" class="loseborder">
                            <table>
                                <tbody>
                                    <?php
                                    $store_name     = '-';
                                    $store_address  = '';
                                    $store_phone    = '';
                                    if (intval($detail['store_id']) > 0) {
                                        $store_name     = $detail['store_name'];
                                        $store_address  = $detail['store_address'];
                                        $store_phone    = $detail['store_phone'];
                                    }
                                    ?>
                                    <tr align="left">
                                        <td width="60" class="text-right">&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr align="left">
                                        <td class="text-right">LOKASI&nbsp;</td>
                                        <td class="">:&nbsp;<?= $store_name ?></td>
                                    </tr>
                                    <tr align="left">
                                        <td class="text-right">&nbsp;</td>
                                        <td class="">&nbsp;&nbsp;<?= $store_address ?></td>
                                    </tr>
                                    <tr align="left">
                                        <td class="text-right">&nbsp;</td>
                                        <td class="">&nbsp;&nbsp;<?= $store_phone ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- END HEADER -->
            <br>
            <div style="width:780px; height:100px;margin:auto;">
                <table width="100%" celpadding="0" cellspacing="0" class="table-bordered table-detail">
                    <thead>
                        <tr>
                            <th class="header-table" width="8%" nowrap="">TGL.TUKAR</th>
                            <th class="header-table" width="8%" nowrap="">KODE ITEM</th>
                            <th class="header-table" width="22%" nowrap="">NAMA ITEM</th>
                            <th class="header-table" width="5%" nowrap="">POIN</th>
                            <th class="header-table" width="8%" nowrap="">TGL.SELESAI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr align="left">
                            <?php
                            $ttd            = COMPANY_NAME;
                            $completed_at   = '-';
                            if (!($detail['completed_at'] == null || $detail['completed_at'] == '')) {
                                $completed_at  = indo_short_date(substr($detail['completed_at'], 0, 10));
                                $ttd           = $detail['completed_by_realname'];
                            }
                            ?>
                            <td class="text-left"><?= indo_short_date($detail['exchange_date']) ?>&nbsp;</td>
                            <td class="text-left"><?= $detail['reward_code'] ?></td>
                            <td class="text-left"><?= $detail['reward_name'] ?></td>
                            <td class="text-right"><?= numberFormat($detail['reward_point'], true) ?>&nbsp;</td>
                            <td class="text-left"><?= $completed_at ?>&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
                <br>
            </div>
            <table width="100%">
                <tr>
                    <td width="3%"></td>
                    <td width="32%" class="ttd">HORMAT KAMI</td>
                    <td width="30%">&nbsp;</td>
                    <td width="32%" class="ttd">PENERIMA</td>
                    <td width="3%"></td>
                </tr>
                <tr>
                    <td height="70px;" colspan="5">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td class="ttd"><span class="underline">Customer Service</span></td>
                    <td>&nbsp;</td>
                    <td class="ttd"><span class="underline"><?= $detail['customer_name'] ?></span></td>
                    <td>&nbsp;</td>
                </tr>
            </table>

        </div>
    </div>
</div>

<?= $this->endSection() ?>