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

                                    <input id="search" name="search" type="text" class="form-control" placeholder="Barcode atau Nama Produk" value="00088890">
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
                                                        <th rowspan="2" class="text-right">DPP</th>
                                                        <th rowspan="2" class="text-right">PPN</th>
                                                        <th rowspan="2" class="text-right">Harga Beli</th>
                                                        <th colspan="2" class="text-center">G1 - <?= isset($customer_group['G1']) ? $customer_group['G1'] : 'NO CONFIG' ?></th>
                                                        <th colspan="2" class="text-center">G2 - <?= isset($customer_group['G2']) ? $customer_group['G2'] : 'NO CONFIG' ?></th>
                                                        <th colspan="2" class="text-center">G3 - <?= isset($customer_group['G3']) ? $customer_group['G3'] : 'NO CONFIG' ?></th>
                                                        <th colspan="2" class="text-center">G4 - <?= isset($customer_group['G4']) ? $customer_group['G4'] : 'NO CONFIG' ?></th>
                                                        <th colspan="2" class="text-center">G5 - <?= isset($customer_group['G5']) ? $customer_group['G5'] : 'NO CONFIG' ?></th>
                                                        <th colspan="2" class="text-center">G6 - <?= isset($customer_group['G6']) ? $customer_group['G6'] : 'NO CONFIG' ?></th>


                                                        <th colspan="9" class="text-center">Diskon Seasonal</th>

                                                        <!-- Sisa Margin -->
                                                        <th colspan="2" class="text-center">G1 - <?= isset($customer_group['G1']) ? $customer_group['G1'] : 'NO CONFIG' ?></th>
                                                        <th colspan="2" class="text-center">G2 - <?= isset($customer_group['G2']) ? $customer_group['G2'] : 'NO CONFIG' ?></th>
                                                        <th colspan="2" class="text-center">G3 - <?= isset($customer_group['G3']) ? $customer_group['G3'] : 'NO CONFIG' ?></th>
                                                        <th colspan="2" class="text-center">G4 - <?= isset($customer_group['G4']) ? $customer_group['G4'] : 'NO CONFIG' ?></th>
                                                        <th colspan="2" class="text-center">G5 - <?= isset($customer_group['G5']) ? $customer_group['G5'] : 'NO CONFIG' ?></th>
                                                        <th colspan="2" class="text-center">G6 - <?= isset($customer_group['G6']) ? $customer_group['G6'] : 'NO CONFIG' ?></th>

                                                        <th colspan="7" class="text-center">Alokasi Margin</th>




                                                        <th rowspan="2" class="text-center">Dijual</th>
                                                        <th rowspan="2" class="text-center">Tampilkan&nbsp;Di<br>Mobile&nbsp;Apps</th>
                                                        <th rowspan="2" class="text-center">Ijinkan<br>Ubah&nbsp;Harga</th>
                                                    </tr>
                                                    <tr>
                                                        <!-- Margin-->
                                                        <th class="text-right">Margin </th>
                                                        <th class="text-right">Hrg.Jual</th>
                                                        <th class="text-right">Margin </th>
                                                        <th class="text-right">Hrg.Jual</th>
                                                        <th class="text-right">Margin </th>
                                                        <th class="text-right">Hrg.Jual</th>
                                                        <th class="text-right">Margin </th>
                                                        <th class="text-right">Hrg.Jual</th>
                                                        <th class="text-right">Margin </th>
                                                        <th class="text-right">Hrg.Jual</th>
                                                        <th class="text-right">Margin </th>
                                                        <th class="text-right">Hrg.Jual</th>

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

                                                        <!-- Margin-->
                                                        <th class="text-right">Sisa&nbsp;Margin </th>
                                                        <th class="text-right">Margin</th>
                                                        <th class="text-right">Sisa&nbsp;Margin </th>
                                                        <th class="text-right">Margin</th>
                                                        <th class="text-right">Sisa&nbsp;Margin </th>
                                                        <th class="text-right">Margin</th>
                                                        <th class="text-right">Sisa&nbsp;Margin </th>
                                                        <th class="text-right">Margin</th>
                                                        <th class="text-right">Sisa.&nbsp;Margin </th>
                                                        <th class="text-right">Margin</th>
                                                        <th class="text-right">Sisa.&nbsp;Margin </th>
                                                        <th class="text-right">Margin</th>

                                                        <!-- Alokasi Margin -->
                                                        <th class="text-right">Alokasi</th>
                                                        <th class="text-right">G1&nbsp;-&nbsp;<?= isset($customer_group['G1']) ? $customer_group['G1'] : 'NO CONFIG' ?></th>
                                                        <th class="text-right">G2&nbsp;-&nbsp;<?= isset($customer_group['G2']) ? $customer_group['G2'] : 'NO CONFIG' ?></th>
                                                        <th class="text-right">G3&nbsp;-&nbsp;<?= isset($customer_group['G3']) ? $customer_group['G3'] : 'NO CONFIG' ?></th>
                                                        <th class="text-right">G4&nbsp;-&nbsp;<?= isset($customer_group['G4']) ? $customer_group['G4'] : 'NO CONFIG' ?></th>
                                                        <th class="text-right">G5&nbsp;-&nbsp;<?= isset($customer_group['G5']) ? $customer_group['G5'] : 'NO CONFIG' ?></th>
                                                        <th class="text-right">G6&nbsp;-&nbsp;<?= isset($customer_group['G6']) ? $customer_group['G6'] : 'NO CONFIG' ?></th>




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
                    data: "product_dpp"
                },
                {
                    data: "product_ppn"
                },
                {
                    data: "product_hpp"
                },
                {
                    data: "G1_margin_rate"
                },
                {
                    data: "G1_sales_price"
                },
                {
                    data: "G2_margin_rate"
                },
                {
                    data: "G2_sales_price"
                },
                {
                    data: "G3_margin_rate"
                },
                {
                    data: "G3_sales_price"
                },
                {
                    data: "G4_margin_rate"
                },
                {
                    data: "G4_sales_price"
                },
                {
                    data: "G5_margin_rate"
                },
                {
                    data: "G5_sales_price"
                },
                {
                    data: "G6_margin_rate"
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
                {
                    data: "remain_margin_G1"
                },
                {
                    data: "margin_G1"
                },
                {
                    data: "remain_margin_G2"
                },
                {
                    data: "margin_G2"
                },
                {
                    data: "remain_margin_G3"
                },
                {
                    data: "margin_G3"
                },
                {
                    data: "remain_margin_G4"
                },
                {
                    data: "margin_G4"
                },
                {
                    data: "remain_margin_G5"
                },
                {
                    data: "margin_G5"
                },
                {
                    data: "remain_margin_G6"
                },
                {
                    data: "margin_G6"
                },
                {
                    data: "margin_allocation"
                },
                {
                    data: "margin_allocation_G1"
                },
                {
                    data: "margin_allocation_G2"
                },
                {
                    data: "margin_allocation_G3"
                },
                {
                    data: "margin_allocation_G4"
                },
                {
                    data: "margin_allocation_G5"
                },
                {
                    data: "margin_allocation_G6"
                },
                {
                    data: "is_sale"
                },
                {
                    data: "show_on_mobile_app"
                },
                {
                    data: "allow_change_price"
                },

            ],
            order: [
                [0, 'asc']
            ],
            "language": {
                "url": lang_datatables,
            },
            columnDefs: [{
                targets: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45],
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
            let base_purchase_price = parseFloat(res.productData.base_purchase_price);
            let base_purchase_tax = parseFloat(res.productData.base_purchase_tax);

            unitData.forEach(function(item, i) {
                let product_content = parseFloat(item.product_content);
                let product_dpp = base_purchase_price * product_content;
                let product_ppn = base_purchase_tax * product_content;
                let product_hpp = product_dpp + product_ppn;

                let G1_sales_price = parseFloat(item.G1_sales_price);
                let G2_sales_price = parseFloat(item.G2_sales_price);
                let G3_sales_price = parseFloat(item.G3_sales_price);
                let G4_sales_price = parseFloat(item.G4_sales_price);
                let G5_sales_price = parseFloat(item.G5_sales_price);
                let G6_sales_price = parseFloat(item.G6_sales_price);

                let G1_margin_rate = calcPercentRate(product_hpp, G1_sales_price);
                let G2_margin_rate = calcPercentRate(product_hpp, G2_sales_price);
                let G3_margin_rate = calcPercentRate(product_hpp, G3_sales_price);
                let G4_margin_rate = calcPercentRate(product_hpp, G4_sales_price);
                let G5_margin_rate = calcPercentRate(product_hpp, G5_sales_price);
                let G6_margin_rate = calcPercentRate(product_hpp, G6_sales_price);

                let disc_seasonal = parseFloat(item.disc_seasonal);

                let G1_promo_price = parseFloat(item.G1_promo_price);
                let G2_promo_price = parseFloat(item.G2_promo_price);
                let G3_promo_price = parseFloat(item.G3_promo_price);
                let G4_promo_price = parseFloat(item.G4_promo_price);
                let G5_promo_price = parseFloat(item.G5_promo_price);
                let G6_promo_price = parseFloat(item.G6_promo_price);


                let margin_G1 = G1_promo_price - product_hpp;
                let margin_G2 = G2_promo_price - product_hpp;
                let margin_G3 = G3_promo_price - product_hpp;
                let margin_G4 = G4_promo_price - product_hpp;
                let margin_G5 = G5_promo_price - product_hpp;
                let margin_G6 = G6_promo_price - product_hpp;

                let remain_margin_G1 = calcPercentRate(product_hpp, G1_promo_price);
                let remain_margin_G2 = calcPercentRate(product_hpp, G2_promo_price);
                let remain_margin_G3 = calcPercentRate(product_hpp, G3_promo_price);
                let remain_margin_G4 = calcPercentRate(product_hpp, G4_promo_price);
                let remain_margin_G5 = calcPercentRate(product_hpp, G5_promo_price);
                let remain_margin_G6 = calcPercentRate(product_hpp, G6_promo_price);

                let margin_allocation = parseFloat(item.margin_allocation);
                let margin_allocation_G1 = (margin_allocation / 100) * margin_G1;
                let margin_allocation_G2 = (margin_allocation / 100) * margin_G2;
                let margin_allocation_G3 = (margin_allocation / 100) * margin_G3;
                let margin_allocation_G4 = (margin_allocation / 100) * margin_G4;
                let margin_allocation_G5 = (margin_allocation / 100) * margin_G5;
                let margin_allocation_G6 = (margin_allocation / 100) * margin_G6;

                let is_sale = item.is_sale == 'Y' ? badgeStatus.active : badgeStatus.notActive;
                let show_on_mobile_app = item.show_on_mobile_app == 'Y' ? badgeStatus.active : badgeStatus.notActive;
                let allow_change_price = item.allow_change_price == 'Y' ? badgeStatus.active : badgeStatus.notActive;

                if (product_content == 1) {
                    base_unit_name = item.unit_name;
                }

                let unitRow = {
                    item_code: item.item_code,
                    unit_name: item.unit_name,
                    product_content: product_content,
                    product_dpp: numberFormat(product_dpp, true),
                    product_ppn: numberFormat(product_ppn, true),
                    product_hpp: numberFormat(product_hpp, true),
                    G1_margin_rate: numberFormat(G1_margin_rate, true),
                    G1_sales_price: numberFormat(G1_sales_price, true),
                    G2_margin_rate: numberFormat(G2_margin_rate, true),
                    G2_sales_price: numberFormat(G2_sales_price, true),
                    G3_margin_rate: numberFormat(G3_margin_rate, true),
                    G3_sales_price: numberFormat(G3_sales_price, true),
                    G4_margin_rate: numberFormat(G4_margin_rate, true),
                    G4_sales_price: numberFormat(G4_sales_price, true),
                    G5_margin_rate: numberFormat(G5_margin_rate, true),
                    G5_sales_price: numberFormat(G5_sales_price, true),
                    G6_margin_rate: numberFormat(G6_margin_rate, true),
                    G6_sales_price: numberFormat(G6_sales_price, true),
                    disc_seasonal: numberFormat(disc_seasonal, true),
                    G1_promo_price: numberFormat(G1_promo_price, true),
                    G2_promo_price: numberFormat(G2_promo_price, true),
                    G3_promo_price: numberFormat(G3_promo_price, true),
                    G4_promo_price: numberFormat(G4_promo_price, true),
                    G5_promo_price: numberFormat(G5_promo_price, true),
                    G6_promo_price: numberFormat(G6_promo_price, true),
                    disc_start_date: mysqlToIndoDate(item.disc_start_date),
                    disc_end_date: mysqlToIndoDate(item.disc_end_date),
                    remain_margin_G1: numberFormat(remain_margin_G1, true),
                    margin_G1: numberFormat(margin_G1, true),
                    remain_margin_G2: numberFormat(remain_margin_G2, true),
                    margin_G2: numberFormat(margin_G2, true),
                    remain_margin_G3: numberFormat(remain_margin_G3, true),
                    margin_G3: numberFormat(margin_G3, true),
                    remain_margin_G4: numberFormat(remain_margin_G4, true),
                    margin_G4: numberFormat(margin_G4, true),
                    remain_margin_G5: numberFormat(remain_margin_G5, true),
                    margin_G5: numberFormat(margin_G5, true),
                    remain_margin_G6: numberFormat(remain_margin_G6, true),
                    margin_G6: numberFormat(margin_G6, true),
                    margin_allocation: numberFormat(margin_allocation, true),
                    margin_allocation_G1: numberFormat(margin_allocation_G1, false),
                    margin_allocation_G2: numberFormat(margin_allocation_G2, false),
                    margin_allocation_G3: numberFormat(margin_allocation_G3, false),
                    margin_allocation_G4: numberFormat(margin_allocation_G4, false),
                    margin_allocation_G5: numberFormat(margin_allocation_G5, false),
                    margin_allocation_G6: numberFormat(margin_allocation_G6, false),
                    is_sale: is_sale,
                    show_on_mobile_app: show_on_mobile_app,
                    allow_change_price: allow_change_price
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