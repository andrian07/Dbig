<?php
$themeUrl = base_url('assets/adminlte3');
$assetsUrl = base_url('assets');
?>

<?= $this->extend('webmin/template/admin_template') ?>

<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<div id="po_list">

    <section class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h1>Pesanan Pembelian</h1>

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

                        <div class="card-header p-2">

                            <button id="btnadd" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah</button>

                            <button id="btnreload" class="btn btn-secondary"><i class="fas fa-sync"></i> Reload</button>

                        </div>

                        <div class="card-body">

                            <table id="tblpurchaseorders" class="table table-bordered table-hover" width="100%">

                                <thead>

                                    <tr>

                                        <th data-priority="1">#</th>

                                        <th data-priority="2">No Invoice</th>

                                        <th data-priority="4">Tanggal Transaksi</th>

                                        <th data-priority="6">Nama Supplier</th>

                                        <th data-priority="7">Total Transaksi</th>

                                        <th data-priority="5">Status</th>

                                        <th data-priority="3">Aksi</th>

                                    </tr>

                                </thead>

                                <tbody></tbody>

                            </table>



                            <!-- /.tab-content -->

                        </div><!-- /.card-body -->

                    </div>

                    <!-- /.card -->

                </div>

                <!-- /.col -->

            </div>

            <!-- /.row -->

        </div><!-- /.container-fluid -->

    </section>

</div>



<div id="po_input">

    <section class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h1 id="title-frmpurchaseorder">Tambah Pesanan</h1>

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

                            <form id="frmsubmission">

                                <div class="row">

                                    <div class="col-sm-2">

                                        <!-- text input -->

                                        <div class="form-group">

                                            <label>Tanggal Transaksi</label>

                                            <input id="purchase_order_date" name="purchase_order_date" type="date" class="form-control" value="<?= date('Y-m-d') ?>" readonly>

                                        </div>

                                    </div>

                                    <div class="col-sm-3">

                                        <!-- text input -->

                                        <div class="form-group">

                                            <label>No Referensi Pengajuan</label>

                                            <input type="hidden" id="purchase_order_id" name="purchase_order_id" value="0">



                                            <input id="purchase_order_invoice" name="purchase_order_invoice" type="text" class="form-control" value="AUTO" readonly>

                                        </div>

                                    </div>

                                   

                                 <div class="col-sm-3">

                                    <!-- text input -->

                                    <div class="form-group">

                                        <label>Diajukan Oleh:</label>

                                        <input id="display_user" type="text" class="form-control" value="Marketing 01" readonly>

                                    </div>

                                </div>




                            </div>



                        </form>

                    </div><!-- /.card-body -->

                </div>

                <!-- /.card -->

            </div>

            <!-- /.col -->

        </div>

        <!-- /.row -->

    </div><!-- /.container-fluid -->





    <div class="container-fluid">

        <div class="row">

            <!-- /.col -->

            <div class="col-md-12">

                <div class="card">

                    <div class="card-body">

                        <form id="frmaddtemp" class="mb-2">

                            <div class="row">

                                <input id="item_id" name="item_id" type="hidden" value="">

                                <input id="product_tax" name="product_tax" type="hidden" value="">

                                <div class="col-sm-3">

                                    <!-- text input -->

                                    <div class="form-group">

                                        <label>Produk</label>

                                        <input id="product_name" name="product_name" type="text" class="form-control" placeholder="ketikkan nama produk" value="" data-parsley-vproductname required>

                                    </div>

                                </div>

                                <div class="col-sm-2">

                                    <!-- text input -->

                                    <div class="form-group">

                                        <label>Qty</label>

                                        <input id="temp_qty" name="temp_qty" type="text" class="form-control text-right" value="0" data-parsley-vqty required>

                                    </div>

                                </div>

                                <div class="col-sm-2">

                                    <!-- text input -->

                                    <div class="form-group">

                                        <label>Status</label>

                                        <input id="temp_status" name="temp_status" type="text" class="form-control text-right" required>

                                    </div>

                                </div>



                                <div class="col-sm-1">

                                    <!-- text input -->

                                    <label>&nbsp;</label>

                                    <div class="form-group">

                                        <div class="col-12">

                                            <button id="btnadd_temp" class="btn btn-md btn-primary rounded-circle float-right"><i class="fas fa-plus"></i></button>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </form>



                        <div class="row mb-2">

                            <div class="col-12">

                                <table id="tbltemp" class="table table-bordered table-hover" width="100%">

                                    <thead>

                                        <tr>

                                            <th data-priority="1">#</th>

                                            <th data-priority="2">Produk</th>

                                            <th data-priority="5">Qty</th>

                                            <th data-priority="6">Keterangan</th>

                                            <th data-priority="3">Aksi</th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                    </tbody>

                                </table>

                                <template id="template_row_temp">

                                    <tr>

                                        <td>{row}</td>

                                        <td>{product_name}</td>

                                        <td>{temp_price}</td>

                                        <td>{temp_tax}</td>

                                        <td>

                                            <button data-id="{item_id}" data-json="{data_json}" class="btn btn-sm btn-warning btnedit rounded-circle" data-toggle="tooltip" data-placement="top" data-title="Edit">

                                                <i class="fas fa-edit"></i>

                                            </button>

                                            &nbsp;

                                            <button data-id="{item_id}" class="btn btn-sm btn-danger btndelete rounded-circle" data-toggle="tooltip" data-placement="top" data-title="Hapus">

                                                <i class="fas fa-minus"></i>

                                            </button>

                                        </td>

                                    </tr>

                                </template>

                            </div>

                        </div>



                        <div class="row">

                            <div class="col-lg-6 col-md-6 col-sm-12">

                                <div class="form-group">

                                    <label for="purchase_order_remark" class="col-sm-12">Catatan</label>

                                    <div class="col-sm-12">

                                        <textarea id="purchase_order_remark" name="purchase_order_remark" class="form-control" placeholder="Catatan" maxlength="500" rows="3"></textarea>

                                    </div>

                                </div>

                            </div>

                            <div class="col-12">

                                <div class="col-12">

                                    <button id="btncancel" class="btn btn-danger"><i class="fas fa-times-circle"></i> Batal</button>

                                    <button id="btnsave" class="btn btn-success float-right"><i class="fas fa-save"></i> Simpan</button>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- /.card -->

            </div>

            <!-- /.col -->

        </div>

        <!-- /.row -->

    </div><!-- /.container-fluid -->

</section>

</div>



<!-- /.content -->

<?= $this->endSection() ?>



<?= $this->section('js') ?>

<script>

    $(document).ready(function() {

          let temp_qty = new AutoNumeric('#temp_qty', configQty);

        // init component //

        function _initButton() {

    
        }



        // select2 //

        $("#employee_id").select2({

            data: [{
                    id:'1',
                    text: 'Marketing 01'
            }]

        });




        // Table //
        let total_transaction = 0;

        const config_tbltemp = {

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

                    width: 100,

                    targets: 6

                },

                {

                    targets: [6],

                    orderable: false,

                    searchable: false,

                },



                {

                    targets: [0, 2, 3, 4, 5],

                    className: "text-right",

                }

            ]

        };



        let tbltemp = $('#tbltemp').DataTable(config_tbltemp);

         function loadTempData(items) {

            let template = $('#template_row_temp').html();

            let tbody = '';

            let row = 1;

            let temp_total_order = 0;

            items.forEach((val, key) => {

                if (val.temp_delete == 'N') {

                    let item = template;

                    let data_json = htmlEntities.encode(JSON.stringify(val));

                    let product_name = val.item_code + ' - ' + val.product_name;

                    product_name += ' (' + val.unit_name + ')';



                    let tprice = parseFloat(val.temp_price);

                    let ttax = parseFloat(val.temp_tax);

                    let tqty = parseFloat(val.temp_qty);

                    let stotal = (tprice + ttax) * tqty;

                    temp_total_order += stotal;



                    item = item.replaceAll('{row}', row)

                        .replaceAll('{item_id}', val.item_id)

                        .replaceAll('{product_name}', product_name)

                        .replaceAll('{temp_price}', 'Rp ' + numberFormat(tprice, true))

                        .replaceAll('{temp_tax}', 'Rp ' + numberFormat(ttax, true))

                        .replaceAll('{temp_qty}', numberFormat(tqty, true))

                        .replaceAll('{subtotal}', 'Rp ' + numberFormat(stotal, true))

                        .replaceAll('{data_json}', data_json);



                    tbody += item;

                    row++;

                }

            });



            total_transaction = temp_total_order;

            if (total_transaction > 0) {

                $('#supplier_id').prop('disabled', true);

            } else {

                $('#supplier_id').prop('disabled', false);

            }



            $('#purchase_order_total').val(total_transaction);

            display_total.set(total_transaction);

            if ($.fn.DataTable.isDataTable('#tbltemp')) {

                $('#tbltemp').DataTable().destroy();

            }



            $('#tbltemp tbody').html('');

            $('#tbltemp tbody').html(tbody);

            tbltemp = $('#tbltemp').DataTable(config_tbltemp);

            _initTooltip();

        }


        //End Table //

        function showInputPage(x) {

            if (x) {

                $('#po_list').hide();

                $('#po_input').show();

            } else {

                $('#po_list').show();

                $('#po_input').hide();

            }

        }



        $('#btnadd').click(function(e) {

            e.preventDefault();

            let form = $('#frmsubmission');
                            //let items = response.result.data;
             $('#title-frmsubmission').html('Pengajuan Pesanan');

            formMode = 'add';

            showInputPage(true);

        })
       


        _initButton();

        showInputPage(false);

    })

</script>

<?= $this->endSection() ?>