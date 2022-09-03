<?php
$themeUrl = base_url('assets/adminlte3');
$assetsUrl = base_url('assets');
?>

<?= $this->extend('pos/template/pos_template') ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary"><i class="fas fa-plus"></i> New</button>
                    <button type="button" class="btn btn-default"><i class="fas fa-print"></i> Print</button>
                    <button type="button" id="btnpayment" class="btn btn-success"><i class="fas fa-dollar-sign"></i> Pembayaran</button>
                </div>

            </div>
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-12">
                        <div class="btn-group float-right">
                            <button type="button" class="btn btn-primary font-weight-bold">#01</button>
                            <button type="button" class="btn btn-default font-weight-bold">#02</button>
                            <button type="button" class="btn btn-default font-weight-bold">#03</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Barcode / Nama Produk</label>
                                            <input id="scanner" name="scanner" type="text" class="form-control fs-20" placeholder="ketikkan nama produk atau barcode" value="" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Salesman</label>
                                            <select id="salesman_id" name="salesman_id" class="form-control select-salesman fs-20"></select>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <div class="col-12">
                                                <button id="btnadd_temp" class="btn btn-md btn-primary rounded-circle float-right"><i class="fas fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 border-primary border-left">
                                        <div class="form-group">
                                            <label>
                                                Customer <span class="badge badge-light">Member Silver</span> <a id="detail-customer" href="#"><i class="fas fa-info-circle"></i></a>
                                            </label>
                                            <select class="form-control select-customer fs-20" id="customer_id" name="customer_id" placeholder="Customer" value="" required>
                                                <option value="3" selected>Samsul (0896-7899-8899)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="row mb-1">
                            <div class="col-12">
                                <table id="tbltemp" class="table table-bordered table-hover" width="100%">
                                    <thead>
                                        <tr>

                                            <th data-priority="1">Produk</th>
                                            <th data-priority="4">Harga <small>(Rp)</small></th>
                                            <th data-priority="5">Disc <small>(Rp)</small></th>
                                            <th data-priority="2">Qty</th>
                                            <th data-priority="6">Subtotal</th>
                                            <th data-priority="7">Salesman</th>
                                            <th data-priority="3">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                Indomie Kaldu Ayam <small>(BKS)</small>
                                            </td>
                                            <td>
                                                3,500.00
                                            </td>
                                            <td>
                                                0.00
                                            </td>
                                            <td>
                                                10.00
                                            </td>
                                            <td>
                                                35,000.00
                                            </td>
                                            <td>
                                                NO SALESMAN
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btnedit btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                                                    <button type="button" class="btn btndelete btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Indomie Goreng <small>(BKS)</small>
                                            </td>
                                            <td>
                                                3,500.00
                                            </td>
                                            <td>
                                                200.00
                                            </td>
                                            <td>
                                                5.00
                                            </td>
                                            <td>
                                                16,500.00
                                            </td>
                                            <td>
                                                Andy
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-warning btnedit"><i class="fas fa-edit"></i></button>
                                                    <button type="button" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>


                                    </tbody>
                                </table>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-6"></div>
                            <div class="col-6">
                                <table class="invoice-summary" width="100%">
                                    <tbody>
                                        <tr>
                                            <th>Subtotal</th>
                                        </tr>
                                        <tr>
                                            <td class="display-total text-right">
                                                51,500.00
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>




                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<div class="modal fade" id="modal-editproduct">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">1234567890123 - indomie Soto Ayam (BKS)</h4>
                <button type="button" class="close close-modal-editproduct">
                    <span aria-hidden="true">[END]</span>
                </button>
            </div>
            <form id="frmeditproduct" class="form-horizontal ">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="set_salesman" class="col-sm-12">Salesman</label>
                                <div class="col-sm-12">
                                    <select class="form-control select-salesman" id="set_salesman" name="set_salesman" placeholder="Salesman" value="" required>
                                        <option value="3">ANDY</option>
                                    </select>
                                </div>
                            </div>



                            <div class="form-group">
                                <label for="set_disc_one" class="col-sm-12">Disc (1)</label>
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <input id="set_disc_one" name="set_disc_one" type="text" class="form-control text-right pos-input percent-input" value="5.71" />
                                        </div>
                                        <div class="col-sm-8">
                                            <input id="set_price_disc_one" name="set_price_disc_one" type="text" class="form-control text-right pos-input currency-input" value="3300" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="set_disc_two" class="col-sm-12">Disc (2)</label>
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <input id="set_disc_two" name="set_disc_two" type="text" class="form-control text-right pos-input percent-input" value="0" />
                                        </div>
                                        <div class="col-sm-8">
                                            <input id="set_price_disc_two" name="set_price_disc_two" type="text" class="form-control text-right pos-input currency-input" value="0" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="set_disc_three" class="col-sm-12">Disc (3)</label>
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <input id="set_disc_three" name="set_disc_three" type="text" class="form-control text-right pos-input percent-input" value="0" />
                                        </div>
                                        <div class="col-sm-8">
                                            <input id="set_price_disc_three" name="set_price_disc_three" type="text" class="form-control text-right pos-input currency-input" value="0" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6 border-left border-primary">
                            <div class="form-group">
                                <label for="set_product_price" class="col-sm-12">Harga Jual</label>
                                <div class="col-sm-12">
                                    <input id="set_product_price" name="set_product_price" type="text" class="form-control text-right pos-input currency-input" readonly value="3500" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="set_disc_total" class="col-sm-12">Diskon</label>
                                <div class="col-sm-12">
                                    <input id="set_disc_total" name="set_disc_total" type="text" class="form-control text-right pos-input currency-input" readonly value="200" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="set_qty" class="col-sm-12">Qty</label>
                                <div class="col-sm-12">
                                    <input id="set_qty" name="set_qty" type="text" class="form-control text-right pos-input number-input" value="5" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="set_subtotal" class="col-sm-12">Subtotal</label>
                                <div class="col-sm-12">
                                    <input id="set_subtotal" name="set_subtotal" type="text" class="form-control text-right pos-input currency-input" readonly value="16500" />
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
                <div class="modal-footer ">
                    <div class="btn-group col-12">
                        <button type="button" class="btn btn-success col-6 close-modal-editproduct"><i class="fas fa-check"></i> Ok</button>
                        <button type="button" class="btn btn-danger col-6 close-modal-editproduct"><i class="fas fa-times-circle"></i> Batal</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-payment">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">PEMBAYARAN</h4>
                <button type="button" class="close close-modal-payment">
                    <span aria-hidden="true">[END]</span>
                </button>
            </div>
            <form id="frmpayment" class="form-horizontal ">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="col-12">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" checked>
                                    <label class="form-check-label font-weight-bold" for="exampleCheck1">CASH</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input id="cash_display" name="cash_display" type="text" class="form-control text-right pos-input fs-35 currency-input" value="10000" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" checked>
                                    <label class="form-check-label font-weight-bold" for="exampleCheck1">VOUCHER</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input id="voucher_code" name="voucher_code" type="text" class="form-control pos-input fs-35" value="0001AX57C652" />
                                        </div>
                                        <div class="col-sm-6">
                                            <input id="voucher_value" name="voucher_value" type="text" class="form-control text-right pos-input fs-35 currency-input" value="40000" readonly />
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" checked>
                                    <label class="form-check-label" for="exampleCheck1"> <span class="font-weight-bold">BCA</span> a/n DBIG (0123456789012)</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input id="appr_code" name="appr_code" type="text" class="form-control pos-input fs-35" value="1234567890" placeholder="KODE APPR" />
                                        </div>
                                        <div class="col-sm-6">
                                            <input id="bca_value" name="bca_value" type="text" class="form-control text-right pos-input fs-35 currency-input" value="10000" />
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="col-12">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1"> <span class="font-weight-bold">BNI</span> a/n DBIG2 (0123456789012)</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input id="appr_code" name="appr_code" type="text" class="form-control pos-input fs-35" value="" placeholder="KODE APPR" readonly />
                                        </div>
                                        <div class="col-sm-6">
                                            <input id="bca_value" name="bca_value" type="text" class="form-control text-right pos-input fs-35" value="0" readonly />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 border-left border-primary">
                            <div class="form-group">
                                <label for="transaction_total" class="col-sm-12">Subtotal</label>
                                <div class="col-sm-12">
                                    <input id="transaction_total" name="transaction_total" type="text" class="form-control text-right pos-input fs-35 currency-input" readonly value="51500" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="payment_total" class="col-sm-12">Total Pembayaran</label>
                                <div class="col-sm-12">
                                    <input id="payment_total" name="payment_total" type="text" class="form-control text-right pos-input fs-35 currency-input" readonly value="60000" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="set_subtotal" class="col-sm-12">Kembalian</label>
                                <div class="col-sm-12">
                                    <input id="set_subtotal" name="set_subtotal" type="text" class="form-control text-right pos-input fs-35 currency-input" readonly value="8500" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="set_product_price" class="col-sm-12">Penambahan Poin</label>
                                <div class="col-sm-12">
                                    <input id="set_product_price" name="set_product_price" type="text" class="form-control text-right pos-input fs-35 number-input" readonly value="52" />
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
                <div class="modal-footer ">
                    <div class="btn-group col-12">
                        <button type="button" class="btn btn-success col-6 close-modal-payment"><i class="fas fa-check"></i> Ok</button>
                        <button type="button" class="btn btn-danger col-6 close-modal-payment"><i class="fas fa-times-circle"></i> Batal</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-detail-customer">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">INFO CUSTOMER</h4>
                <button type="button" class="close close-modal-detail-customer">
                    <span aria-hidden="true">[END]</span>
                </button>
            </div>
            <div class="modal-body">
                <table width="100%" class="table">
                    <tr>
                        <th width="30%">Nama</th>
                        <td width="70%" class="text-right">Samsul</td>
                    </tr>
                    <tr>
                        <th>Grup</th>
                        <td class="text-right">
                            <span class="badge badge-light">Member Silver</span>
                        </td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td class="text-right">
                            Jl.Sui raya km 8.5 no 25
                        </td>
                    </tr>

                    <tr>
                        <th>No Telp</th>
                        <td class="text-right">
                            0896-7899-8899
                        </td>
                    </tr>
                    <tr>
                        <th>Poin</th>
                        <td class="text-right">
                            <b>100</b>
                        </td>
                    </tr>
                    <tr>
                        <th>Exp. Date</th>
                        <td class="text-right">
                            15/10/2022
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer ">
                <div class="btn-group col-12">
                    <button type="button" class="btn btn-danger col-12 close-modal-detail-customer"><i class="fas fa-times-circle"></i> Batal</button>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    $(document).ready(function() {

        const dsCustomer = [{
                id: 1,
                text: "CASH"
            },
            {
                id: 2,
                text: "089655556666 - ANI"
            },
            {
                id: 3,
                text: "089666677777 - BUDI"
            }
        ];

        const dsSalesman = [{
                id: 1,
                text: 'NO SALESMAN'
            },
            {
                id: 2,
                text: 'JOKO'
            },
            {
                id: 3,
                text: 'ANDY'
            }
        ];

        const config_tbltemp = {
            scrollY: "240px",
            scrollCollapse: true,
            paging: false,
            pageLength: 10,
            autoWidth: false,
            select: true,
            responsive: true,
            fixedColumns: true,
            order: [
                [0, 'desc']
            ],
            "language": {
                "url": lang_datatables,
            },
            "columnDefs": [{
                    width: 70,
                    targets: 6
                },
                {
                    targets: [6],
                    orderable: false,
                    searchable: false,
                },

                {
                    targets: [1, 2, 3, 4],
                    className: "text-right",
                }
            ]
        };

        let temp_table = $('#tbltemp').DataTable(config_tbltemp);

        $('.select-salesman').select2({
            data: dsSalesman,
        })

        $('.select-customer').select2({
            data: dsCustomer,
        })

        $('.close-modal-editproduct').click(function(e) {
            $('#modal-editproduct').modal('hide');
        })

        $('#tbltemp').on('click', '.btnedit', function(e) {
            $('#modal-editproduct').modal('show');
        })

        $('#btnpayment').click(function(e) {
            $('#modal-payment').modal('show');
        })

        $('.close-modal-payment').click(function(e) {
            $('#modal-payment').modal('hide');
        })

        $('#detail-customer').click(function(e) {
            e.preventDefault();
            $('#modal-detail-customer').modal('show');

        })

        let obj = new AutoNumeric.multiple('.currency-input', configRp);
        let obj2 = new AutoNumeric.multiple('.number-input', configQty);
        let obj4 = new AutoNumeric.multiple('.percent-input', configDisc);

    })
</script>
<?= $this->endSection() ?>