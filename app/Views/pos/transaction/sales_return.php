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
                    <button type="button" id="btnsave" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
                </div>

            </div>
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-12">
                        <!--
                                    <div class="btn-group float-right">
                                        <button type="button" class="btn btn-primary font-weight-bold">#01</button>
                                        <button type="button" class="btn btn-default font-weight-bold">#02</button>
                                        <button type="button" class="btn btn-default font-weight-bold">#03</button>
                                    </div>
                                    -->
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
                                            <label>Qty Retur</label>
                                            <input type="text" id="return_qty" name="return_qty" class="form-control pos-input number-input text-right" value="1" />
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
                                            <label>Invoice Penjualan</label>
                                            <select class="form-control select-customer fs-20" id="customer_id" name="customer_id" placeholder="Customer" value="" required>
                                                <option value="1" selected>SI/UTM/22/08/00001</option>
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
                                            <th data-priority="5">Qty Beli</th>
                                            <th data-priority="2">Qty Retur</th>
                                            <th data-priority="6">Subtotal</th>
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
                                                10.00
                                            </td>
                                            <td>
                                                2.00
                                            </td>
                                            <td>
                                                7,000.00
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
                                                3,300.00
                                            </td>
                                            <td>
                                                5.00
                                            </td>
                                            <td>
                                                1.00
                                            </td>
                                            <td>
                                                3,300.00
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
                                            <td class="display-total text-right">10,300.00</td>
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
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">1234567890123 - Indomie Kaldu Ayam </h4>
                <button type="button" class="close close-modal-editproduct">
                    <span aria-hidden="true">[END]</span>
                </button>
            </div>
            <form id="frmeditproduct" class="form-horizontal ">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="set_product_price" class="col-sm-12">Harga Jual</label>
                                <div class="col-sm-12">
                                    <input id="set_product_price" name="set_product_price" type="text" class="form-control text-right pos-input currency-input" readonly value="3500" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="set_qty" class="col-sm-12">Qty Beli</label>
                                <div class="col-sm-12">
                                    <input id="set_qty" name="set_qty" type="text" class="form-control text-right pos-input number-input" value="10" readonly />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="set_qty" class="col-sm-12">Qty Retur</label>
                                <div class="col-sm-12">
                                    <input id="set_qty" name="set_qty" type="text" class="form-control text-right pos-input number-input" value="2" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="set_subtotal" class="col-sm-12">Subtotal</label>
                                <div class="col-sm-12">
                                    <input id="set_subtotal" name="set_subtotal" type="text" class="form-control text-right pos-input currency-input" readonly value="7000" />
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

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    $(document).ready(function() {

        const dsCustomer = [{
                id: 1,
                text: "SI/UTM/22/08/00001"
            },
            {
                id: 2,
                text: "SI/UTM/22/08/00002"
            },
            {
                id: 3,
                text: "SI/UTM/22/08/00003"
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
                    targets: 5
                },
                {
                    targets: [5],
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

        let obj = new AutoNumeric.multiple('.currency-input', configRp);
        let obj2 = new AutoNumeric.multiple('.number-input', configQty);
        let obj4 = new AutoNumeric.multiple('.percent-input', configDisc);

    })
</script>
<?= $this->endSection() ?>