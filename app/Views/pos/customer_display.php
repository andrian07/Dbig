<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


    <style>
        body {
            background-color: #F5F5F5;
        }

        #promotion,
        #invoice {
            padding-top: 10px;
        }

        #list-item {
            width: 100%;

        }

        #list-item thead {
            width: 100%;
            display: inline-table;
        }



        #list-item thead tr td {
            background-color: #D0CDCD;
            font-size: 13px;
        }

        #list-item tbody tr td {
            background-color: #F5F5F5;
            font-size: 13px;
        }

        #list-item .row-item {
            width: 55%;
        }



        #list-item .row-qty {
            width: 5%;
        }

        #list-item .row-price,
        #list-item .row-total {
            width: 20%;
        }


        #summary,
        #customer-info {
            font-size: 20px;
        }


        .video video {
            object-fit: cover;
        }

        #product-info .card-body {
            padding: 0px;
        }


        #product-info .product-image {
            padding: 2px 2px;
        }

        #product-info .product-detail {
            padding: 2px 2px 5px 2px;
        }

        #product-info .product-detail h5 {
            margin: 0px;
            font-size: 20px;
            max-width: 470px;
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
        }

        #product-info .product-detail p {
            margin: 0px;
            font-size: 18px;
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
        }

        #product-info .product-detail p .text-end {
            margin: 0px;
            font-size: 25px;
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
        }



        .font-color-blue {
            color: #0D48AA;
        }

        .font-color-red {
            color: #D10101;
        }

        .font-color-yellow {
            color: #FFC90C;
        }


        .font-color-green {
            color: #25D366;
        }
    </style>
    <title>Customer Display</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div id="invoice" class="col-5">
                <div class="header mb-2">
                    <img src="<?= base_url('assets/images/logo.png') ?>" alt="logo" class="float-right" width="200px" height="100px">
                </div>

                <div class="row" id="customer-info">
                    <div class="col-4">Customer</div>
                    <div class="col-8 fw-bold text-end">Budi</div>
                    <div class="col-4">Member</div>
                    <div class="col-8 fw-bold text-end">
                        <span>GOLD</span>
                    </div>
                    <div class="col-4">Poin Anda</div>
                    <div class="col-8 fw-bold text-end font-color-green">10</div>
                </div>
                <table id="list-item" class="table" width="100%">
                    <thead>
                        <tr>
                            <td class="row-item fw-bold">ITEM</td>
                            <td class="text-end row-price fw-bold">HARGA</td>
                            <td class="text-end row-qty fw-bold">QTY</td>
                            <td class="text-end row-total fw-bold">TOTAL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                    </thead>
                    <tbody style="display: block; height: 320px; overflow-y: scroll">
                        <tr>
                            <td class="row-item">
                                <span class="row-item-name">Indomie Kaldu Ayam</span>

                            </td>
                            <td class="text-end row-price">3,500.00</td>
                            <td class="text-end row-qty">10.00</td>
                            <td class="text-end row-total">35,000.00</td>
                        </tr>
                        <tr>
                            <td class="row-item">
                                <span class="row-item-name">
                                    Indomie Goreng
                                </span>
                                <br>Diskon : <span class="font-color-red">200.00</span>
                            </td>
                            <td class="text-end row-price">3,300</td>
                            <td class="text-end row-qty">5</td>
                            <td class="text-end row-total">16,500.00</td>
                        </tr>


                    </tbody>
                </table>

                <div class="row" id="summary">
                    <div class="col-4">Subtotal</div>
                    <div class="col-8 text-end fw-bold font-color-blue">51,500.00</div>
                    <div class="col-4">Pembayaran</div>
                    <div class="col-8 text-end fw-bold font-color-blue">60,000.00</div>
                    <div class="col-4">Kembalian</div>
                    <div class="col-8 text-end fw-bold font-color-blue">8,500.00</div>

                    <div class="col-4">Anda Hemat</div>
                    <div class="col-8 text-end fw-bold font-color-green">1,000.00</div>
                </div>


            </div>
            <div id="promotion" class="col-7">
                <div class="row mb-2">
                    <div class="col-6 fs-3 font-color-blue fw-bold">Rabu, 24 Agustus 2022</div>
                    <div class="col-6 text-end fs-3 font-color-blue fw-bold">22:00:00</div>
                </div>


                <div class="video mb-2" height="400px">
                    <video width="100%" autoplay="autoplay" loop="loop" muted controls>
                        <source src="<?= base_url('assets/demo/ads.mp4') ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>

                <div id="product-info" class="card">
                    <div class="card-body">
                        <table width="100%">
                            <tr>
                                <td width="25%" class="product-image">
                                    <img src="<?= base_url('assets/demo/indomie.PNG') ?>" width="100%" height="100px">
                                </td>
                                <td width="75%" class="product-detail">
                                    <h5>INDOMIE GORENG</h5>
                                    <p>5.00 x 3,300.00
                                        <br>Diskon : <span class="font-color-red">200.00</span>
                                    </p>
                                    <p class="text-end fw-bold font-color-blue">16,500.00</p>
                                </td>
                            </tr>
                        </table>

                    </div>
                </div>




            </div>

        </div>


        <!-- Optional JavaScript; choose one of the two! -->

        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

        <script src="assets/adminlte3/plugins/jquery/jquery.min.js"></script>

        <!-- Option 2: Separate Popper and Bootstrap JS -->
        <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>

</html>