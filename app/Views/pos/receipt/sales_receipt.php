<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Struk Belanja</title>
    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="pragma" content="no-cache" />
    <style type="text/css" media="all">
        * {
            top: 0;
            margin-top: 0;
            font-size: 10px;
            font-family: calibri;
            line-height: 10px;
        }

        .border-top {
            border-top: 1px solid black;
            border-collapse: collapse;
        }

        .border-bottom {
            border-bottom: 1px solid black;
            border-collapse: collapse;
        }

        table {
            width: 100%;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .centered {
            text-align: center;
            align-content: center;
        }

        .ticket {
            width: 255px;
            max-width: 255px;
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
            width: 25px;
            max-width: 25px;
            word-break: break-all;
        }

        td.col-2,
        th.col-2 {
            // width: 70px; 
            max-width: 70px;
            word-break: break-all;
        }

        td.col-3,
        th.col-3 {
            width: 60px;
            max-width: 60px;
            word-break: break-all;
        }

        .fs-16 {
            font-size: 8px;
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
        <p class="centered"><?= COMPANY_NAME ?>
            <br><?= COMPANY_ADDRESS ?>
            <br>Telp.<?= COMPANY_PHONE ?>
        </p>
        <table id="info">
            <tbody>
                <tr>
                    <td class="col-1">NO</td>
                    <td>:</td>
                    <td class="col-2">SI/UTM/22/09/00001</td>
                    <td class="col-3 text-right"></td>
                </tr>
                <tr>
                    <td class="col-1">TGL</td>
                    <td>:</td>
                    <td class="col-2"><?= indo_short_date('2022-08-24 22:00:00', false) ?></td>
                    <td class="col-3 text-right"></td>
                </tr>

                <tr>
                    <td class="col-1">KSR</td>
                    <td>:</td>
                    <td class="col-2">Ani</td>
                    <td class="col-3 text-right"></td>
                </tr>
                <tr>
                    <td class="col-1">CUST</td>
                    <td>:</td>
                    <td class="col-2" colspan="2">Samsul (089678998899)</td>
                </tr>

            </tbody>
        </table>
        <table>
            <tbody>

                <tr>
                    <td class="description border-top" colspan="4">Indomie Kaldu Ayam (BKS)</td>
                </tr>
                <tr>
                    <td class="qty text-right">10.00</td>
                    <td class="exp-symbol">x</td>
                    <td class="price">3,500.00</td>
                    <td class="total text-right">35,000.00</td>
                </tr>
                <tr>
                    <td class="description border-top" colspan="4">Indomie Goreng (BKS)</td>
                </tr>
                <tr>
                    <td class="qty text-right">5.00</td>
                    <td class="exp-symbol">x</td>
                    <td class="price">3,300.00</td>
                    <td class="total text-right">16,500.00</td>
                </tr>
                <tr>
                    <td class="text-right" colspan="3">Diskon</td>
                    <td class="total text-right">(1,000.00)</td>
                </tr>


                <tr>
                    <td class="sub-description text-right border-top" colspan="3">Total</td>
                    <td class="total text-right border-top">51,500.00</td>
                </tr>
                <tr>
                    <td class="sub-description text-right" colspan="3">Tunai</td>
                    <td class="total text-right">10,000.00</td>
                </tr>
                <tr>
                    <td class="sub-description text-right" colspan="3">Voucher</td>
                    <td class="total text-right">40,000.00</td>
                </tr>
                <tr>
                    <td class="sub-description text-right" colspan="3">BCA</td>
                    <td class="total text-right">10,000.00</td>
                </tr>
                <tr>
                    <td class="sub-description text-right" colspan="3">Kembali</td>
                    <td class="total text-right">8,500.00</td>
                </tr>

                <tr>
                    <td class="sub-description text-right border-bottom" colspan="3">Anda Hemat</td>
                    <td class="total text-right border-bottom">1,000.00</td>
                </tr>

                <tr>
                    <td class="sub-description text-right" colspan="3">Poin Awal</td>
                    <td class="total text-right ">10.00</td>
                </tr>
                <tr>
                    <td class="sub-description text-right" colspan="3">Tambah Poin</td>
                    <td class="total text-right ">52.00</td>
                </tr>
                <tr>
                    <td class="sub-description text-right" colspan="3">Poin Anda</td>
                    <td class="total text-right ">62.00</td>
                </tr>



            </tbody>
        </table>
        <p class="centered fs-16">
            BCA No.1234567890 #APPR:090908<BR>
            Voucher 0000100001<BR>

            BARANG YANG SUDAH DIBELI TIDAK DAPAT DIKEMBALIKAN <BR>
            TERIMA KASIH TELAH BERBELANJA<BR>
            --- INFO LENGKAP ---<BR>
            W: dbigdepo.com<BR>
            I: www.instagram.com/dbig.depo<BR>
            F: www.facebook.com/dbig.depo<BR>
        </p>
    </div>
    <?php if (isset($_GET['print'])) : ?>
        <script>
            window.print();
            <?php if ($agent->isMobile() == FALSE) : ?>
                window.onafterprint = closePage;

                function closePage() {
                    window.close();
                }
            <?php endif; ?>
        </script>
    <?php endif; ?>
</body>

</html>