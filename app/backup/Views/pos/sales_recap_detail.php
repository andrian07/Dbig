<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Rekap Penjualan</title>
    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="pragma" content="no-cache" />
    <style type="text/css" media="all">
        * {
            font-size: 11px;
            font-family: 'Times New Roman';
        }


        .border-top {
            border-top: 1px solid black;
            border-collapse: collapse;
        }

        .border-bottom {
            border-bottom: 1px solid black;
            border-collapse: collapse;
        }





        .text-right {
            text-align: right;
        }

        .centered {
            text-align: center;
            align-content: center;
        }

        .ticket {
            width: 155px;
            max-width: 155px;
        }

        img {
            max-width: inherit;
            width: inherit;
        }

        td.description,
        th.description {
            width: 155px;
            max-width: 155px;
            word-break: break-all;
        }

        td.sub-description,
        th.sub-description {
            width: 75px;
            max-width: 75px;
            word-break: break-all;
        }


        td.qty,
        th.qty {
            width: 30px;
            max-width: 30px;
            word-break: break-all;
            font-size: 10px;
        }

        td.exp-symbol,
        th.exp-symbol {
            font-size: 8px;
        }


        td.price,
        th.price {
            width: 45px;
            font-size: 10px;
            max-width: 45px;
            word-break: break-all;
        }

        td.total,
        th.total {
            width: 80px;
            max-width: 80px;
            word-break: break-all;
        }


        td.col-1,
        th.col-1 {
            width: 35px;
            max-width: 35px;
            word-break: break-all;
        }

        td.col-2,
        th.col-2 {
            width: 120px;
            max-width: 120px;
            word-break: break-all;
        }



        @media print {

            .hidden-print,
            .hidden-print * {
                display: none !important;
            }
        }
    </style>
</head>

<body>
    <div class="ticket">
        <!--
        <img src="./logo.png" alt="Logo">
        -->
        <p class="centered">
            <?= COMPANY_NAME ?>
            <br><?= COMPANY_ADDRESS ?>
            <br>Telp.<?= COMPANY_PHONE ?>
            <br>
            <br>
            <b>Rekap Penjualan</b>
        </p>
        <table id="info">
            <tbody>
                <tr>
                    <td class="col-1">KSR</td>
                    <td>:</td>
                    <td class="col-2">Reza</td>
                </tr>
                <tr>
                    <td class="col-1">OPEN</td>
                    <td>:</td>
                    <td class="col-2">24/08/22</td>
                </tr>
            </tbody>
        </table>
        <table>
            <tbody>

                <tr>
                    <td class="description border-top" colspan="4"><b>Penjualan</b></td>
                </tr>
                <tr>
                    <td class="description border-top" colspan="4">SI/UTM/22/08/00001 </td>
                </tr>
                <tr>
                    <td colspan="2">CASH</td>
                    <td class="total text-right" colspan="2"><?= numberFormat(51500, TRUE) ?></td>
                </tr>
                <tr>
                    <td class="description border-top" colspan="4">SI/UTM/22/08/00002 </td>
                </tr>
                <tr>
                    <td colspan="2">CASH</td>
                    <td class="total text-right" colspan="2"><?= numberFormat(40000, TRUE) ?></td>
                </tr>
                <tr>
                    <td colspan="2">BCA</td>
                    <td class="total text-right" colspan="2"><?= numberFormat(60000, TRUE) ?></td>
                </tr>
                <tr>
                    <td class="description border-top" colspan="4">SI/UTM/22/08/00003 </td>
                </tr>
                <tr>
                    <td colspan="2">VOUCHER</td>
                    <td class="total text-right" colspan="2"><?= numberFormat(20000, TRUE) ?></td>
                </tr>
                <tr>
                    <td colspan="2">CASH</td>
                    <td class="total text-right" colspan="2"><?= numberFormat(30000, TRUE) ?></td>
                </tr>


                <tr>
                    <td class="description border-top" colspan="4"><b>Retur Penjualan</b></td>
                </tr>

                <tr>
                    <td class="description border-top" colspan="4">SR/UTM/22/08/00001</td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td class="total text-right" colspan="2"><?= numberFormat(10300, TRUE) ?></td>
                </tr>

                <tr>
                    <td class="description border-top" colspan="4"><b>KAS MASUK/KELUAR</b></td>
                </tr>
                <tr>
                    <td colspan="2">Kas Keluar</td>
                    <td class="total text-right" colspan="2"><?= numberFormat(100000, TRUE) ?></td>
                </tr>
                <tr>
                    <td colspan="2">Kas Masuk</td>
                    <td class="total text-right" colspan="2"><?= numberFormat(50000, TRUE) ?></td>
                </tr>



                <tr>
                    <td class="sub-description text-right border-top" colspan="3">Kas Awal</td>
                    <td class="total text-right border-top"><?= numberFormat(200000, true) ?></td>
                </tr>

                <tr>
                    <td class="sub-description text-right" colspan="3">Kas Masuk</td>
                    <td class="total text-right"><?= numberFormat(50000, true) ?></td>
                </tr>

                <tr>
                    <td class="sub-description text-right" colspan="3">Kas Keluar</td>
                    <td class="total text-right"><?= numberFormat(100000, true) ?></td>
                </tr>

                <tr>
                    <td class="sub-description text-right" colspan="3">Total Sales</td>
                    <td class="total text-right"><?= numberFormat(201500, true) ?></td>
                </tr>


                <tr>
                    <td class="sub-description text-right border-top" colspan="3">Kas Akhir</td>
                    <td class="total text-right border-top"><?= numberFormat(351500, true) ?></td>
                </tr>
                <tr>
                    <td class="sub-description text-right border-top" colspan="3">Cash</td>
                    <td class="total text-right border-top"><?= numberFormat(271500, true) ?></td>
                </tr>
                <tr>
                    <td class="sub-description text-right " colspan="3">BCA</td>
                    <td class="total text-right "><?= numberFormat(60000, true) ?></td>
                </tr>
                <tr>
                    <td class="sub-description text-right " colspan="3">VOUCHER</td>
                    <td class="total text-right "><?= numberFormat(20000, true) ?></td>
                </tr>

            </tbody>
        </table>
        <p class="centered">

        </p>
    </div>
</body>

</html>