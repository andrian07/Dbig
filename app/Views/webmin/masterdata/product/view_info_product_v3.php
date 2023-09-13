<?php
$themeUrl = base_url('assets/adminlte3');
$assetsUrl = base_url('assets');
?>



<?= $this->extend('webmin/template/admin_template') ?>

<?= $this->section('css') ?>
<style>
    td.nowrap {
        min-width: 129px;
    }

    .dtHorizontalExampleWrapper {
        max-width: 600px;
        margin: 0 auto;
    }

    #tblsearchproduct th,
    td {
        white-space: nowrap;
    }

    table.dataTable thead .sorting:after,
    table.dataTable thead .sorting:before,
    table.dataTable thead .sorting_asc:after,
    table.dataTable thead .sorting_asc:before,
    table.dataTable thead .sorting_asc_disabled:after,
    table.dataTable thead .sorting_asc_disabled:before,
    table.dataTable thead .sorting_desc:after,
    table.dataTable thead .sorting_desc:before,
    table.dataTable thead .sorting_desc_disabled:after,
    table.dataTable thead .sorting_desc_disabled:before {
        bottom: .5em;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Informasi Produk</h1>
            </div>
            <div class="col-sm-6"></div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- /.col -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div id="info" class="col-12"></div>

                            <div class="col-12">
                                <label>Barcode / Nama Produk</label>
                            </div>
                            <div class="col-sm-10">
                                <!-- text input -->
                                <div class="form-group">

                                    <input id="search" name="search" type="text" class="form-control" placeholder="Barcode atau Nama Produk" value="">
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <!-- text input -->
                                <button class="btn btn-primary  btn-md" id="btncapture">
                                    <i class="fas fa-camera"></i>
                                </button>
                            </div>
                        </div>

                        <div class="row">
                            <div class=" col-12 border-top border-primary mt-2">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-2"><b>Kode Produk</b></div>
                                            <div class="col-md-10" id="result_product_code">-</div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-2"><b>Nama Produk</b> </div>
                                            <div class="col-md-10" id="result_product_name">-</div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-2"><b>Jenis</b></div>
                                            <div class="col-md-10" id="result_product_type">-</div>
                                        </div>
                                    </div>


                                    <div class="col-12 mt-3">
                                        <h5>Harga & Promo</h5>
                                        <div class="table-responsive">
                                            <table id="tblitem" class="table table-bordered table-hover" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2">Barcode</th>
                                                        <th rowspan="2" class="" width="120px">Satuan</th>
                                                        <th rowspan="2" class="text-right">Isi</th>
                                                        <th colspan="6" class="text-center">Harga Jual</th>
                                                        <th colspan="9" class="text-center">Diskon Seasonal</th>
                                                    </tr>
                                                    <tr>
                                                        <!-- Harga Jual -->
                                                        <th class="text-right">G1 - <?= isset($customer_group['G1']) ? $customer_group['G1'] : 'NO CONFIG' ?></th>
                                                        <th class="text-right">G2 - <?= isset($customer_group['G2']) ? $customer_group['G2'] : 'NO CONFIG' ?></th>
                                                        <th class="text-right">G3 - <?= isset($customer_group['G3']) ? $customer_group['G3'] : 'NO CONFIG' ?></th>
                                                        <th class="text-right">G4 - <?= isset($customer_group['G4']) ? $customer_group['G4'] : 'NO CONFIG' ?></th>
                                                        <th class="text-right">G5 - <?= isset($customer_group['G5']) ? $customer_group['G5'] : 'NO CONFIG' ?></th>
                                                        <th class="text-right">G6 - <?= isset($customer_group['G6']) ? $customer_group['G6'] : 'NO CONFIG' ?></th>


                                                        <!-- Diskon Seasonal -->
                                                        <th class="text-right">Diskon</th>
                                                        <th class="text-right">G1&nbsp;-&nbsp;<?= isset($customer_group['G1']) ? $customer_group['G1'] : 'NO CONFIG' ?></th>
                                                        <th class="text-right">G2&nbsp;-&nbsp;<?= isset($customer_group['G2']) ? $customer_group['G2'] : 'NO CONFIG' ?></th>
                                                        <th class="text-right">G3&nbsp;-&nbsp;<?= isset($customer_group['G3']) ? $customer_group['G3'] : 'NO CONFIG' ?></th>
                                                        <th class="text-right">G4&nbsp;-&nbsp;<?= isset($customer_group['G4']) ? $customer_group['G4'] : 'NO CONFIG' ?></th>
                                                        <th class="text-right">G5&nbsp;-&nbsp;<?= isset($customer_group['G5']) ? $customer_group['G5'] : 'NO CONFIG' ?></th>
                                                        <th class="text-right">G6&nbsp;-&nbsp;<?= isset($customer_group['G6']) ? $customer_group['G6'] : 'NO CONFIG' ?></th>
                                                        <th class="">Mulai&nbsp;Tanggal</th>
                                                        <th class="">S.d&nbsp;Tanggal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-3">
                                        <h5>Stok</h5>
                                        <div class="table-responsive">
                                            <table id="tblstock" class="table table-bordered table-hover" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>Kode Gudang</th>
                                                        <th>Nama Gudang</th>
                                                        <th class="text-right">Stok</th>
                                                        <th>Satuan</th>
                                                    </tr>

                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>

                                <!-- /.tab-content -->
                            </div><!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>


                    <div class="modal fade" id="modal-barcodescanner">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Barcode Scanner</h4>
                                    <button type="button" class="close close-modal-scanner">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form class="form-horizontal">
                                    <div class="modal-body">
                                        <div id="barcode-reader" style="width: 100%"></div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button id="btnclose" class="btn btn-danger btn-block close-modal-scanner"><i class="fas fa-times-circle"></i> Batal</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>


                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
</section>

<!-- /.content -->
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<!-- barcode reader -->
<script src="<?= $assetsUrl ?>/plugins/html5-qrcode/html5-qrcode.min.js"></script>
<script>
    $(document).ready(function() {
        let history_scan = [];
        let scannerPause = false;

        const badgeStatus = {
            active: '<span class="badge badge-success"><i class="fas fa-check-circle"></i></span>',
            notActive: '<span class="badge badge-danger"><i class="fas fa-times-circle"></i></span>'
        };




        const html5QrcodeScanner = new Html5QrcodeScanner(
            "barcode-reader", {
                fps: 10,
                qrbox: 250
            });

        function showInfo(msgText, msgType = 'info') {
            $('#info').html(`<div class="alert alert-${msgType}">${msgText}<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></div>`)
        }

        const tblitem = $('#tblitem').DataTable({
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            bFilter: false,
            pageLength: 10,
            autoWidth: false,
            select: true,
            responsive: false,
            fixedColumns: true,
            data: [],
            columns: [{
                    data: "item_code"
                },
                {
                    data: "unit_name"
                },
                {
                    data: "product_content"
                },
                {
                    data: "G1_sales_price"
                },
                {
                    data: "G2_sales_price"
                },
                {
                    data: "G3_sales_price"
                },
                {
                    data: "G4_sales_price"
                },
                {
                    data: "G5_sales_price"
                },
                {
                    data: "G6_sales_price"
                },
                {
                    data: "disc_seasonal"
                },
                {
                    data: "G1_promo_price"
                },
                {
                    data: "G2_promo_price"
                },
                {
                    data: "G3_promo_price"
                },
                {
                    data: "G4_promo_price"
                },
                {
                    data: "G5_promo_price"
                },
                {
                    data: "G6_promo_price"
                },
                {
                    data: "disc_start_date"
                },
                {
                    data: "disc_end_date"
                },
            ],
            order: [
                [0, 'asc']
            ],
            "language": {
                "url": lang_datatables,
            },
            columnDefs: [{
                targets: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15],
                className: "text-right",
            }, ],
        });

        const tblstock = $('#tblstock').DataTable({
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            bFilter: false,
            pageLength: 10,
            autoWidth: false,
            select: true,
            responsive: false,
            fixedColumns: true,
            data: [],
            columns: [{
                    data: "warehouse_code"
                },
                {
                    data: "warehouse_name"
                },
                {
                    data: "stock"
                },
                {
                    data: "unit_name"
                }
            ],
            order: [
                [0, 'asc']
            ],
            "language": {
                "url": lang_datatables,
            },
            columnDefs: [{
                targets: [2],
                className: "text-right",
            }, ],
        });

        function mysqlToIndoDate(str) {

            if (str == '' || str == null || str == '0000-00-00' || str == '0000-00-00 00:00:00') {
                return '';
            }

            let expDate = str.split('-');
            return `${expDate[2]}/${expDate[1]}/${expDate[0]}`;
        }

        function renderResult(res) {
            $('#result_product_code').html(res.productData.product_code);
            $('#result_product_name').html(res.productData.product_name);
            $('#result_product_type').html(res.productData.is_parcel == 'Y' ? 'Paket' : 'Produk');

            let productUnitRows = [];
            let unitData = res.unitData;
            let base_unit_name = '';

            unitData.forEach(function(item, i) {
                let product_content = parseFloat(item.product_content);

                let G1_sales_price = parseFloat(item.G1_sales_price);
                let G2_sales_price = parseFloat(item.G2_sales_price);
                let G3_sales_price = parseFloat(item.G3_sales_price);
                let G4_sales_price = parseFloat(item.G4_sales_price);
                let G5_sales_price = parseFloat(item.G5_sales_price);
                let G6_sales_price = parseFloat(item.G6_sales_price);

                let disc_seasonal = parseFloat(item.disc_seasonal);

                let G1_promo_price = parseFloat(item.G1_promo_price);
                let G2_promo_price = parseFloat(item.G2_promo_price);
                let G3_promo_price = parseFloat(item.G3_promo_price);
                let G4_promo_price = parseFloat(item.G4_promo_price);
                let G5_promo_price = parseFloat(item.G5_promo_price);
                let G6_promo_price = parseFloat(item.G6_promo_price);

                if (product_content == 1) {
                    base_unit_name = item.unit_name;
                }

                let unitRow = {
                    item_code: item.item_code,
                    unit_name: item.unit_name,
                    product_content: product_content,
                    G1_sales_price: numberFormat(G1_sales_price, true),
                    G2_sales_price: numberFormat(G2_sales_price, true),
                    G3_sales_price: numberFormat(G3_sales_price, true),
                    G4_sales_price: numberFormat(G4_sales_price, true),
                    G5_sales_price: numberFormat(G5_sales_price, true),
                    G6_sales_price: numberFormat(G6_sales_price, true),
                    disc_seasonal: numberFormat(disc_seasonal, true),
                    G1_promo_price: numberFormat(G1_promo_price, true),
                    G2_promo_price: numberFormat(G2_promo_price, true),
                    G3_promo_price: numberFormat(G3_promo_price, true),
                    G4_promo_price: numberFormat(G4_promo_price, true),
                    G5_promo_price: numberFormat(G5_promo_price, true),
                    G6_promo_price: numberFormat(G6_promo_price, true),
                    disc_start_date: mysqlToIndoDate(item.disc_start_date),
                    disc_end_date: mysqlToIndoDate(item.disc_end_date)
                }
                productUnitRows.push(unitRow);
            })

            tblitem.clear();
            tblitem.rows.add(productUnitRows);
            tblitem.draw(false);


            let stockRows = [];
            let stockData = res.stockData;

            stockData.forEach(function(item, i) {
                let stockRow = {
                    warehouse_code: item.warehouse_code,
                    warehouse_name: item.warehouse_name,
                    stock: numberFormat(parseFloat(item.stock), false),
                    unit_name: base_unit_name
                }
                stockRows.push(stockRow);
            })

            tblstock.clear();
            tblstock.rows.add(stockRows);
            tblstock.draw(false);
        }

        function scanBarcode(barcode) {
            if (barcode == '') {
                showInfo('Isi barcode atau cari nama produk yang dinginkan', 'info');
            } else {
                let actUrl = base_url + '/webmin/product/info-product-v2/' + barcode;
                ajax_get(actUrl, {}, {
                    success: function(response) {
                        if (response.success) {
                            const res = response.result;
                            if (res.exist) {
                                renderResult(res);
                            } else {
                                showInfo('Produk tidak ditemukan', 'danger');
                            }
                        }
                    },
                })
            }
        }

        $('#search').keydown(function(e) {
            let barcodeText = $(this).val();
            if (e.keyCode == 13) {
                expCode = barcodeText.split(' - ');
                scanBarcode(expCode[0]);
            }
        })

        function closeScanner() {
            $('#modal-barcodescanner').modal('hide');
            html5QrcodeScanner.pause();
            scannerPause = true;
        }

        $('.close-modal-scanner').click(function(e) {
            e.preventDefault();
            closeScanner();
        })

        function onScanSuccess(decodedText, decodedResult) {
            //console.log(`Code scanned = ${decodedText}`, decodedResult);
            scanBarcode(decodedText);
            closeScanner();
        }

        html5QrcodeScanner.render(onScanSuccess);

        $('#btncapture').click(function(e) {
            e.preventDefault();
            $('#modal-barcodescanner').modal(configModal);
            if (scannerPause) {
                html5QrcodeScanner.resume();
            }
        })

        $('#search').autocomplete({
            minLength: 2,
            source: function(req, add) {
                $.ajax({
                    url: base_url + '/webmin/product/search-product-v2',
                    dataType: 'json',
                    type: 'GET',
                    data: req,
                    success: function(res) {
                        if (res.success == true) {
                            add(res.data);
                        }
                    },
                });
            },
            select: function(event, ui) {
                scanBarcode(ui.item.item_code);
            },
        });

    })
</script>
<?= $this->endSection() ?>