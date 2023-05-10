<?php
$themeUrl = base_url('assets/adminlte3');
$assetsUrl = base_url('assets');
?>

<?= $this->extend('webmin/template/admin_template') ?>

<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<div id="returpurchase_list">

    <section class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h1>Retur Pembelian</h1>

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


                    <!-- popup modal add -->
                    <div class="modal fade" id="modal-addreturpayment">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="title-frmaddbanner">Pembayaran Retur</h4>
                                    <button type="button" class="close close-modal">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form id="frmaddpaymentretur" class="form-horizontal">
                                                <div class="form-group">
                                                    <label for="title_payment_retur" class="col-sm-12">No Invoice</label>
                                                    <div class="col-sm-12">
                                                        <input type="hidden" id="hd_retur_purchase_id" class="form-control">
                                                        <input type="text" id="hd_retur_purchase_invoice" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="title_payment_retur" class="col-sm-12">Total Pembayaran</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" id="hd_retur_total_transaction" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="active" class="col-sm-12">Jenis Pembayaran</label>
                                                    <div class="col-sm-12">
                                                        <select id="payment_type" name="payment_type" class="form-control">
                                                            <option></option>
                                                            <option value="Ya">Potong Nota</option>
                                                            <option value="Tidak">Cash</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button id="btncancel" class="btn btn-danger close-modal"><i class="fas fa-times-circle"></i> Batal</button>
                                    <button id="btnsavepayment" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
                                </div>

                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- end popup modal -->

                    <div class="card">

                        <div class="card-header p-2">

                            <button id="btnadd" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah</button>

                            <button id="btnreload" class="btn btn-secondary"><i class="fas fa-sync"></i> Reload</button>

                        </div>

                        <div class="card-body">

                            <table id="tblreturpurcase" class="table table-bordered table-hover" width="100%">

                                <thead>

                                    <tr>

                                        <th data-priority="1">#</th>

                                        <th data-priority="2">No Invoice</th>

                                        <th data-priority="3">Tanggal</th>

                                        <th data-priority="4">Nama Suplier</th>

                                        <th data-priority="5">Total Transaksi</th>

                                        <th data-priority="6">Status</th>

                                        <th data-priority="7">Aksi</th>

                                    </tr>

                                </thead>

                                <tbody>

                                </tbody>

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



<div id="returpurchase_input">

    <section class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h1 id="title-frmreturpurchase"></h1>

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


                          <form id="frmreturpurchase" class="form-horizontal form-space">

                            <div class="form-group row">

                                <label for="noinvoice" class="col-sm-1 col-form-label text-right">No Invoice :</label>

                                <div class="col-sm-3">

                                    <input type="hidden" id="hd_retur_purchase_id_edit" class="form-control">

                                    <input id="retur_invoice_no" name="retur_invoice_no" type="text" class="form-control" value="AUTO" readonly>

                                </div>

                                <div class="col-md-5"></div>

                                <label for="tanggal" class="col-sm-1 col-form-label text-right">Tanggal :</label>

                                <div class="col-sm-2">

                                    <input id="retur_date" name="retur_date" type="date" class="form-control" value="<?= date('Y-m-d') ?>" readonly>

                                </div>
                            </div>


                            <div class="form-group row">

                                <label for="suplier" class="col-sm-1 col-form-label text-right">Supplier :</label>

                                <div class="col-sm-3">

                                    <select id="supplier_id" name="supplier_id" class="form-control"></select>

                                </div>


                                <div class="col-sm-5"> </div>

                                <label for="user" class="col-sm-1 col-form-label text-right">User :</label>

                                <div class="col-sm-2">

                                    <input id="display_user" type="text" class="form-control" value="<?= $user['user_realname'] ?>" readonly>

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

                            <div class="row well well-sm">

                                <input id="item_id" name="item_id" type="hidden" value="">

                                <input id="product_tax" name="product_tax" type="hidden" value="">

                                <div class="col-sm-4">

                                    <!-- text input -->

                                    <div class="form-group">

                                        <label>No Invoice Pembelian</label>

                                        <input id="purchase_no" name="purchase_no" type="text" class="form-control" placeholder="ketikkan nomor invoice pembelian" value="" data-parsley-vpurchaseno required>

                                    </div>

                                </div>

                                <div class="col-sm-4">

                                    <!-- text input -->

                                    <div class="form-group">

                                        <label>Produk</label>

                                        <input id="product_name" name="product_name" type="text" class="form-control" placeholder="ketikkan nama produk" value="" data-parsley-vproductname required>

                                    </div>

                                </div>

                                <div class="col-sm-2">

                                    <!-- text input -->

                                    <div class="form-group">

                                        <label>Gudang</label>

                                        <select id="warehouse" type="text" class="form-control"></select>

                                    </div>

                                </div>

                                <div class="col-sm-2">

                                    <!-- text input -->

                                    <div class="form-group">

                                        <label>DPP</label>

                                        <input id="temp_dpp" name="temp_dpp" type="text" class="form-control text-right" value="0" readonly>

                                    </div>

                                </div>

                                <div class="col-sm-2">

                                    <!-- text input -->

                                    <div class="form-group">

                                        <label>Disc</label>

                                        <input id="temp_disc" name="temp_disc" type="text" class="form-control text-right" value="0" readonly>

                                    </div>

                                </div>

                                <div class="col-sm-2">

                                    <!-- text input -->

                                    <div class="form-group">

                                        <label>Disc Nota</label>

                                        <input id="temp_disc_nota" name="temp_disc_nota" type="text" class="form-control text-right" value="0" readonly>

                                    </div>

                                </div>



                                <div class="col-sm-2">

                                    <!-- text input -->

                                    <div class="form-group">

                                        <label>PPN <?= PPN_TEXT ?></label>

                                        <input id="temp_tax" name="temp_tax" type="text" class="form-control text-right" value="0" readonly>

                                    </div>

                                </div>

                                <div class="col-sm-2">

                                    <!-- text input -->

                                    <div class="form-group">

                                        <label>Ongkir</label>

                                        <input id="temp_ongkir" name="temp_ongkir" type="text" class="form-control text-right" value="0" readonly>

                                    </div>

                                </div>

                                <div class="col-sm-2">

                                    <!-- text input -->

                                    <div class="form-group">

                                        <label>Harga</label>

                                        <input id="temp_price" name="temp_price" type="text" class="form-control text-right" value="0" readonly>

                                    </div>

                                </div>

                                <div class="col-sm-2">

                                    <!-- text input -->

                                    <div class="form-group">

                                        <label>Qty Retur</label>
                                        <input id="temp_qty_buy" name="temp_qty_buy" type="hidden" class="form-control text-right" value="0" required readonly>
                                        <input id="temp_qty_retur" name="temp_qty_retur" type="text" class="form-control text-right" value="0" data-parsley-vqty required>

                                    </div>

                                </div>

                                <div class="col-sm-6"></div>
                                <div class="col-sm-5">

                                    <!-- text input -->

                                    <div class="form-group">

                                        <label>Total</label>

                                        <input id="temp_total" name="temp_total" type="text" class="form-control text-right" value="0" readonly>

                                    </div>

                                </div>

                                <div class="col-sm-1">

                                    <!-- text input -->

                                    <label>&nbsp;</label>

                                    <div class="form-group">

                                        <div class="col-12">

                                            <button id="btnadd_temp" class="btn btn-md btn-primary rounded-circle" ><i class="fas fa-plus"></i></button>

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

                                            <th data-priority="2">No Pembelian</th>

                                            <th data-priority="3">Kode Produk</th>

                                            <th data-priority="4" width="25%;">Produk</th>

                                            <th data-priority="5">Harga</th>

                                            <th data-priority="6">Qty Retur</th>

                                            <th data-priority="7">Total</th>

                                            <th data-priority="8">Aksi</th>

                                        </tr>

                                    </thead>

                                    <tbody> </tbody>

                                </table>

                                <template id="template_row_temp">

                                    <tr>

                                        <td>{row}</td>

                                        <td>{invoice_no}</td>

                                        <td>{item_code}</td>

                                        <td width="20%">{product_name}</td>

                                        <td>Rp. {price}</td>

                                        <td>{qty_retur}</td>

                                        <td>Rp. {total}</td>

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



                     <div class="row form-space">

                        <div class="col-lg-6">

                            <div class="form-group">

                                <div class="col-sm-12">

                                    <textarea id="retur_remark" name="retur_remark" class="form-control" placeholder="Catatan" maxlength="500" rows="3"></textarea>

                                </div>

                            </div>

                        </div>

                        <div class="col-lg-6 text-right">

                            <div class="form-group row">
                                <label for="footer_sub_total" class="col-sm-4 col-form-label text-right:">Total :</label>
                                <div class="col-sm-8">
                                    <input id="footer_sub_total" name="footer_sub_total" type="text" class="form-control text-right" value="0" readonly>
                                </div>
                            </div>

                            <div class="form-group row" style="margin-top: 30px;">
                                <div class="col-sm-12">
                                    <button id="btncancel-input" class="btn btn-danger"><i class="fas fa-times-circle"></i> Batal</button>
                                    <button id="btnsave" class="btn btn-success button-header-custom-save"><i class="fas fa-save"></i> Simpan</button>
                                </div>
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

        let temp_price = new AutoNumeric('#temp_price', configRp);

        let temp_tax = new AutoNumeric('#temp_tax', configRp);

        let temp_qty_buy = new AutoNumeric('#temp_qty_buy', configQty);

        let temp_qty_retur = new AutoNumeric('#temp_qty_retur', configQty);

        let temp_total = new AutoNumeric('#temp_total', configRp);

        let temp_disc = new AutoNumeric('#temp_disc', configRp);

        let temp_disc_nota = new AutoNumeric('#temp_disc_nota', configRp);

        let temp_dpp = new AutoNumeric('#temp_dpp', configRp);

        let temp_ongkir = new AutoNumeric('#temp_ongkir', configRp);

        let footer_sub_total = new AutoNumeric('#footer_sub_total', configRp);

        let hd_retur_total_transaction = new AutoNumeric('#hd_retur_total_transaction', configRp);

        $('#warehouse').prop('disabled', true);

        // init component //

        function _initButton() {
            $('#btnadd').prop('disabled', !hasRole('retur_purchase.add'));
            $('.btnedit').prop('disabled', !hasRole('retur_purchase.edit'));
            $('.btndelete').prop('disabled', !hasRole('retur_purchase.delete'));
            $('.btnprint').prop('disabled', !hasRole('retur_purchase.print'));
        }

        // select2 //


        $("#tblreturpurcase").on('click', '.btnrepayment', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let actUrl = base_url + '/webmin/retur/getByid/' + id;
            ajax_get(actUrl, null, {
                success: function(response) {
                    console.log(response);
                    if (response.success) {
                        if (response.result.success) {
                            if(response.result.data.hd_retur_status == 'Pending'){
                                editMode(response.result.data);
                            }else{
                                message.info('Transaksi yang sudah selesai atau dibatalkan tidak dapat di ubah lagi');
                            }
                        } else {
                            message.error(response.result.message);
                        }
                    }
                }
            })

        })


        function editMode(data) {
            console.log(data);
            let form = $('#frmaddpaymentretur');
            $('#hd_retur_purchase_id').val(data.hd_retur_purchase_id);
            $('#hd_retur_purchase_invoice').val(data.hd_retur_purchase_invoice);
            hd_retur_total_transaction.set(data.hd_retur_total_transaction);
            $('#modal-addreturpayment').modal(configModal);
        }

        $('.close-modal').click(function(e) {
            e.preventDefault();
            message.question('Yakin ingin menutup halaman ini?').then(function(answer) {
                let yes = parseMessageResult(answer);
                if (yes) {
                    $('#modal-addreturpayment').modal('hide');
                }
            })
        })

        $("#warehouse").select2({
            placeholder: '-- Pilih Gudang --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/warehouse",
                dataType: "json",
                type: "GET",
                delay: select2Delay,
                data: function(params) {
                    return {
                        search: params.term,
                    };
                },
                processResults: function(data, page) {
                    return {
                        results: data,
                    };
                },
            },
        });


        $("#supplier_id").select2({

            placeholder: '-- Pilih Supplier --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/supplier",
                dataType: "json",
                type: "GET",
                delay: select2Delay,
                data: function(params) {
                    return {
                        search: params.term,
                    };
                },
                processResults: function(data, page) {
                    return {
                        results: data,
                    };
                },
            },
        });

        let tblreturpurcase = $("#tblreturpurcase").DataTable({
            processing: true,
            select: true,
            serverSide: true,
            responsive: true,
            fixedColumns: true,
            order: [
            [1, 'desc']
            ],
            language: {
                url: lang_datatables,
            },
            ajax: {
                url: base_url + '/webmin/retur/tblreturpurchase',
                type: "POST",
                error: function() {
                    notification.danger('Gagal memuat table, harap coba lagi');
                },
            },
            drawCallback: function(settings) {
                _initTooltip();
                _initButton();
            },
            columnDefs: [{
                width: 100
            },
            {
                targets: [0, 6],
                orderable: false,
                searchable: false,
            },
            {
                targets: [0],
                className: "text-right",
            },
            ],
        });

        $('#purchase_no').autocomplete({   

            minLength: 2,

            source: function(req, add) {

                $.ajax({

                    url: base_url + '/webmin/retur/get-no-purchase?sup='+$('#supplier_id').val(),

                    dataType: 'json',

                    type: 'GET',

                    data: req,

                    success: function(res) {

                        if (res.success == true) {

                            add(res.data);

                        }else{

                           message.error(res.message);

                           $('#purchase_no').val('');

                       }

                   },

               });

            }

        });
        


        $('#product_name').autocomplete({   

            minLength: 2,

            source: function(req, add) {

                $.ajax({

                    url: base_url + '/webmin/retur/search-product-noinvoice?purchase_no='+$('#purchase_no').val(),

                    dataType: 'json',

                    type: 'GET',

                    data: req,

                    success: function(res) {

                        if (res.success == true) {

                            add(res.data);

                        }else{

                           message.error(res.message);

                           $('#product_name').val('');

                       }

                   },

               });

            },

            select: function(event, ui) {

                $('#item_id').val(ui.item.item_id);

                temp_dpp.set(parseFloat(ui.item.purchase_dpp));

                temp_disc.set(parseFloat(ui.item.purchase_discount));

                temp_disc_nota.set(parseFloat(ui.item.purchase_discount_nota));

                temp_disc_nota.set(parseFloat(ui.item.purchase_discount_nota));

                temp_ongkir.set(parseFloat(ui.item.purchase_ongkir));

                temp_qty_buy.set(parseFloat(ui.item.purchase_qty));

                temp_tax.set(parseFloat(ui.item.purchase_ppn));

                temp_price.set(parseFloat(ui.item.purchase_price));

                setSelect2('#warehouse', ui.item.warehouse_id, ui.item.warehouse_name);

            },

        });

        $('#btnsave').click(function(e) {

            e.preventDefault();


            let btnSubmit = $('#btnsave');

            let hd_retur_purchase_id = $('#hd_retur_purchase_id_edit').val();

            let supplier_id = $('#supplier_id').val();

            let retur_date = $('#retur_date').val();

            let retur_remark = $('#retur_remark').val();

            let footer_sub_total_val = parseFloat(footer_sub_total.getNumericString());

            let question = 'Yakin ingin menyimpan data Pembelian?';

            let actUrl = base_url + '/webmin/retur/save/add';

            if (formMode == 'edit') {

                question = 'Yakin ingin memperbarui data Retur?';

                actUrl = base_url + '/webmin/retur/save/edit';

            }

            if(supplier_id == null){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Silahkan Isi Nama Supplier!'
                })

            }else{

                message.question(question).then(function(answer) {

                    let yes = parseMessageResult(answer);

                    if (yes) {

                        let formValues = {

                            hd_retur_purchase_id:hd_retur_purchase_id,

                            hd_retur_date: retur_date,

                            hd_retur_supplier_id: supplier_id,

                            hd_retur_total_transaction: footer_sub_total_val,

                            hd_retur_desc: retur_remark,

                        };

                        btnSubmit.prop('disabled', true);

                        ajax_post(actUrl, formValues, {

                            success: function(response) {

                                if (response.success) {

                                    if (response.result.success) {

                                        //form[0].reset();

                                        notification.success(response.result.message);

                                        //orm.parsley().reset();

                                        showInputPage(false);

                                    } else {

                                        message.error(response.result.message);

                                    }

                                }

                                btnSubmit.prop('disabled', false);

                                updateTableHeader();

                            },

                            error: function(response) {

                                btnSubmit.prop('disabled', false);

                                updateTableHeader();

                            }

                        });

                    }

                })

            }

        });

        $('#btnsavepayment').click(function(e) {

            e.preventDefault();


            let btnSubmit = $('#btnsavepayment');

            let hd_retur_purchase_invoice = $('#hd_retur_purchase_invoice').val();

            let hd_retur_purchase_id = $('#hd_retur_purchase_id').val();

            let hd_retur_total_transaction_val = parseFloat(hd_retur_total_transaction.getNumericString());

            let payment_type = $('#payment_type').val();

            let question = 'Yakin ingin menyimpan data Pembayaran?';

            let actUrl = base_url + '/webmin/retur/savepayment';

            message.question(question).then(function(answer) {

                let yes = parseMessageResult(answer);

                if (yes) {

                    let formValues = {

                        hd_retur_purchase_id: hd_retur_purchase_id,

                        payment_type: payment_type,

                        hd_retur_total_transaction:hd_retur_total_transaction_val

                    };

                    btnSubmit.prop('disabled', true);

                    ajax_post(actUrl, formValues, {

                        success: function(response) {

                            if (response.success) {

                                if (response.result.success) {

                                    notification.success(response.result.message);

                                    showInputPage(false);



                                    $('#payment_type').val('');

                                    $('#modal-addreturpayment').modal('hide');



                                } else {

                                    message.error(response.result.message);

                                }

                            }

                            btnSubmit.prop('disabled', false);

                            updateTableHeader();

                        },

                        error: function(response) {

                            btnSubmit.prop('disabled', false);

                            updateTableHeader();

                        }

                    });

                }

            })

        });

        $("#btncancel-input").click(function(e) {

            e.preventDefault();

            message.question('Yakin ingin batal input retur pembelian?').then(function(answer) {

                let yes = parseMessageResult(answer);

                if (yes) {

                    let actUrl = base_url + '/webmin/retur/cancel-input-retur/';

                    ajax_get(actUrl, null, {

                        success: function(response) {

                            if (response.success) {

                                if (response.result.success) {

                                    clearHeader();

                                    clearItemInput();

                                } else {

                                    message.error(response.result.message);

                                }

                                updateTableHeader();

                                showInputPage(false);

                            }

                        }

                    })

                }

            })

        });

        $("#tblreturpurcase").on('click', '.btndelete', function(e) {

            e.preventDefault();

            let id = $(this).attr('data-id');

            message.question('Yakin ingin membatalkan retur?').then(function(answer) {

                let yes = parseMessageResult(answer);

                if (yes) {

                    let actUrl = base_url + '/webmin/retur/cancel-retur/' + id;

                    ajax_get(actUrl, null, {

                        success: function(response) {

                            if (response.success) {

                                if (response.result.success) {

                                    notification.success(response.result.message);


                                } else {

                                    message.error(response.result.message);

                                }

                                updateTableHeader();

                            }

                        }

                    })

                }

            })

        })

        $("#tblreturpurcase").on('click', '.btnedit', function(e) {

            e.preventDefault();


            let id = $(this).attr('data-id');

            let actUrl = base_url + '/webmin/retur/edit-retur-purchase/' + id;

            ajax_get(actUrl, null, {

                success: function(response) {

                    console.log(response.result.data);

                    if (response.success) {

                        if (response.result.success) {

                            let form = $('#frm-purchase-order-consignment');

                            let items = response.result.data;

                            let header = response.result.header;

                            let supplier_id = header.supplier_id;

                            let supplier_name = header.supplier_name;

                            let warehouse_id = header.purchase_order_consignment_warehouse_id;

                            let warehouse_name  = header.warehouse_name;

                            let purchase_order_consignment_invoice = header.purchase_order_consignment_invoice;

                            let purchase_order_consignment_id = header.purchase_order_consignment_id;

                            if (header.hd_retur_status == 'Pending') {

                                $('#title-frm-purchase-order-consignment').html('Ubah Pengajuan Pesanan');

                                formMode = 'edit';

                                setSelect2('#supplier_id', supplier_id, supplier_name);

                                $('#supplier_id').prop("disabled", true);

                                setSelect2('#warehouse', warehouse_id, warehouse_name);

                                $('#warehouse').prop("disabled", true);

                                $('#purchase_order_consignment_invoice').val(purchase_order_consignment_invoice);

                                $('#purchase_order_consignment_id').val(purchase_order_consignment_id);

                                $('#hd_retur_purchase_id_edit').val(header.hd_retur_purchase_id);

                                loadTempData(items);

                                showInputPage(true);

                            } else {

                                message.info('Pesanan yang sudah selesai atau dibatalkan tidak dapat di ubah lagi');

                            }

                        } else {

                            message.error(response.result.message);

                        }

                        updateTableHeader();

                    }

                }

            })
        })

        function updateTableHeader() {
            tblreturpurcase.ajax.reload(null, false);
        }


        $('#btnadd_temp').click(function(e) {

            e.preventDefault();

            let purchase_no = $('#purchase_no').val();

            let supplier_id = $('#supplier_id').val();

            let supplier_name = $("#supplier_id option:selected" ).text();

            let item_id = $('#item_id').val();

            let warehouse = $('#warehouse').val();

            let price = parseFloat(temp_price.getNumericString());

            let tax = parseFloat(temp_tax.getNumericString());

            let dpp = parseFloat(temp_dpp.getNumericString());

            let disc = parseFloat(temp_disc.getNumericString());

            let disc_nota = parseFloat(temp_disc_nota.getNumericString());

            let ongkir = parseFloat(temp_ongkir.getNumericString());

            let qty_buy = parseFloat(temp_qty_buy.getNumericString());

            let qty_retur = parseFloat(temp_qty_retur.getNumericString());

            let total = parseFloat(temp_total.getNumericString());

            let btnSubmit = $('#btnadd_temp');

            let form = $('#frmaddtemp');

            form.parsley().validate();

            if (form.parsley().isValid()) {

                let actUrl = base_url + '/webmin/retur/temp-add';

                let formValues = {

                    retur_invoice_no: purchase_no,

                    retur_supplier_id:supplier_id,

                    retur_supplier_name:supplier_name,

                    retur_item_id: item_id,

                    retur_price: price,

                    retur_ppn: tax,

                    retur_dpp: dpp,

                    retur_disc: disc,

                    retur_disc_nota: disc_nota,

                    retur_ongkir: ongkir,

                    retur_warehouse: warehouse,

                    retur_qty_buy: qty_buy,

                    retur_qty: qty_retur,

                    retur_total: total

                };

                btnSubmit.prop('disabled', true);

                ajax_post(actUrl, formValues, {

                    success: function(response) {

                        if (response.success) {

                            if (response.result.success) {

                                $('#product_name').focus();

                                setSelect2('#supplier_id', supplier_id, supplier_name);

                                $('#supplier_id').attr("disabled", true);

                                notification.success(response.result.message);

                            } else {

                               message.error(response.result.message);

                           }

                           clearItemInput();
                           loadTempData(response.result.data);

                       }

                       btnSubmit.prop('disabled', false);

                   },

                   error: function(response) {

                    btnSubmit.prop('disabled', false);

                }
            });
            }
        })


        Parsley.addMessages('id', {

            vpurchaseno: 'Harap pilih no invoice terlebih dahulu',

            vproductname: 'Harap pilih produk terlebih dahulu',

            vprice: 'Harga beli wajib diatas Rp 0',

            vqty: 'Qty wajib diatas Rp 0',

        });



        Parsley.setLocale('id');

        window.Parsley.addValidator("vpurchaseno", {

            validateString: function(value) {

                if ($('#purchase_no').val() == '') {

                    return false;

                } else {

                    return true;

                }

            },

        });


        window.Parsley.addValidator("vproductname", {

            validateString: function(value) {

                if ($('#item_id').val() == '' || $('#item_id').val() == '0') {

                    return false;

                } else {

                    return true;

                }

            },

        });


        window.Parsley.addValidator("vprice", {

            validateString: function(value) {

                let vprice = parseFloat(temp_price.getNumericString());

                if (vprice <= 0) {

                    return false;

                } else {

                    return true;

                }
            },

        });


        window.Parsley.addValidator("vqty", {

            validateString: function(value) {

                let vqty = parseFloat(temp_qty_retur.getNumericString());

                if (vqty <= 0) {

                    return false;

                } else {

                    return true;

                }

            },

        });


        $("#tbltemp").on('click', '.btnedit', function(e) {

            e.preventDefault();

            let json_data = $(this).attr('data-json');

            let [json, is_json, error] = parseJSON(htmlEntities.decode(json_data));

            if (is_json) {

                $('#item_id').val(json.retur_item_id);

                $('#purchase_no').val(json.retur_purchase_invoice);

                $('#product_name').val(json.product_name +'('+json.unit_name+')');

                temp_dpp.set(json.retur_dpp);

                temp_disc.set(json.retur_disc);

                temp_disc_nota.set(json.retur_disc_nota);

                temp_ongkir.set(json.retur_ongkir);

                temp_price.set(json.retur_price);

                temp_tax.set(json.retur_ppn);

                setSelect2('#warehouse', json.retur_warehouse, json.warehouse_name);

                temp_qty_buy.set(json.retur_qty_buy);

                temp_qty_retur.set(json.retur_qty);

                temp_total.set(json.retur_total);

                $('#temp_qty_retur').focus();

            } else {

                message.error('Terjadi kesalahan dalam memproses data, harap coba lagi');

            }

        })


        $("#tbltemp").on('click', '.btndelete', function(e) {

            e.preventDefault();

            let id = $(this).attr('data-id');

            let actUrl = base_url + '/webmin/retur/temp-delete/' + id;

            ajax_get(actUrl, null, {

                success: function(response) {

                    if (response.success) {

                        if (response.result.success) {

                            notification.success(response.result.message);

                        } else {

                            message.error(response.result.message);

                        }

                        //setfootervalue();

                        loadTempData(response.result.data);

                    }

                },

                error: function(response) {

                    getTemp();

                }

            })

        })


        function loadTempData(items) {

            let template = $('#template_row_temp').html();

            let tbody = '';

            let row = 1;

            let temp_total_order = 0;

            items.forEach((val, key) => {

                let item = template;

                let data_json = htmlEntities.encode(JSON.stringify(val));

                let purchase_invoice_no = val.retur_purchase_invoice;

                let item_code = val.item_code;

                let item_id = val.retur_item_id;

                let product_name  = val.product_name+'('+val.unit_name+')';

                let price = parseFloat(val.retur_price);

                let warehouse = val.warehouse_name;

                let qty_retur = parseFloat(val.retur_qty);

                let tax = parseFloat(val.retur_ppn);

                let total = parseFloat(val.retur_total);

                item = item.replaceAll('{row}', row)

                .replaceAll('{item_id}', item_id)

                .replaceAll('{invoice_no}', purchase_invoice_no)

                .replaceAll('{item_code}', item_code)

                .replaceAll('{product_name}', product_name)

                .replaceAll('{price}', numberFormat(price, true))

                .replaceAll('{warehouse}', warehouse)

                .replaceAll('{qty_retur}', numberFormat(qty_retur, true))

                .replaceAll('{tax}', numberFormat(tax, true))

                .replaceAll('{total}', numberFormat(total, true))

                .replaceAll('{data_json}', data_json);

                tbody += item;

                row++;

            });


            if ($.fn.DataTable.isDataTable('#tbltemp')) {

                $('#tbltemp').DataTable().destroy();

            }


            $('#tbltemp tbody').html('');

            $('#tbltemp tbody').html(tbody);

            tbltemp = $('#tbltemp').DataTable(config_tbltemp);

            setfootervalue();

            _initTooltip();

        }

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

                width: 100

            },
            {

                targets: [0, 7],

                orderable: false,

                searchable: false,

            },
            {

                targets: [0],

                className: "text-right",

            }

            ]

        };

        let tbltemp = $('#tbltemp').DataTable(config_tbltemp);


        $('#temp_qty_retur').on('input', function() {
            let qtybuy_compare = parseFloat(temp_qty_buy.getNumericString());
            let qtyretur_compare = parseFloat(temp_qty_retur.getNumericString());
            let temp_price_cal = parseFloat(temp_price.getNumericString());
            if(qtybuy_compare < qtyretur_compare){
                Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Qty Retur Tidak Boleh Melebih Qty Beli'
              })
                temp_qty_retur.set(0);
                temp_total.set(0);
            }else{
                temp_total.set(qtyretur_compare * temp_price_cal);
            }
        });

        $('#temp_price').on('input', function() {
            let qtyretur_val = parseFloat(temp_qty_retur.getNumericString());
            let temp_price_cal = parseFloat(temp_price.getNumericString());
            temp_total.set(qtyretur_val * temp_price_cal);
        });

        // Table //



        //End Table //

        function showInputPage(x) {

            if (x) {

                $('#returpurchase_list').hide();

                $('#returpurchase_input').show();



            } else {

                $('#returpurchase_list').show();

                $('#returpurchase_input').hide();

            }

        }

        function setfootervalue() {
            let actUrl = base_url + '/webmin/retur/get-retur-footer';
            ajax_get(actUrl, null, {
                success: function(response) {   
                    if (response.result.success == 'TRUE') {
                        if(response.result.data.length > 0){
                            if(response.result.data[0].subTotal == null){
                                footer_sub_total.set(0);
                            }else{
                                footer_sub_total.set(response.result.data[0].subTotal);
                            }
                        }
                    } else {
                        message.error(response.result.message);
                    }
                }
            });
        }


        function clearHeader()
        {
            setSelect2('#supplier_id', '', '');
        }

        function clearItemInput() {

            let form = $('#frmaddtemp');

            form.parsley().reset();

            $('#item_id').val('');

            $('#purchase_no').val('');

            $('#product_name').val('');

            temp_price.set(0);

            temp_tax.set(0);

            temp_qty_buy.set(0);

            temp_qty_retur.set(0);

            temp_total.set(0);

            temp_dpp.set(0);

            temp_disc.set(0);

            temp_disc_nota.set(0);

            temp_ongkir.set(0);

            setSelect2('#warehouse', '', '');

        }

        $("#tblreturpurcase").on('click', '.btnprint', function(e) {

            e.preventDefault();

            let id = $(this).attr('data-id');

            let actUrl = base_url + '/webmin/retur/printinvoice/' + id;

            window.open(actUrl, '_blank').focus();

        })


        $('#btnadd').click(function(e) {
            e.preventDefault();
            let actUrl = base_url + '/webmin/retur/get-retur-temp';
            ajax_get(actUrl, null, {
                success: function(response) {   
                    if (response.result.success == 'TRUE') {
                        let form = $('#frmreturpurchase');
                        let items = response.result.data;
                        $('#title-frmreturpurchase').html('Tambah Retur Pembelian');
                        formMode = 'add';
                        setSelect2('#supplier_id', "", "");
                        $('#supplier_id').prop("disabled", false);
                        loadTempData(items);
                        if(items.length != 0){
                            let supplier_ids = items[0].retur_supplier_id;
                            let supplier_names = items[0].retur_supplier_name;
                            setSelect2('#supplier_id', supplier_ids, supplier_names);
                            $('#supplier_id').attr("disabled", true);
                        }
                        clearItemInput();
                        showInputPage(true);
                    } else {
                        message.error(response.result.message);
                    }

                }
            })

        })



        _initButton();

        showInputPage(false);

    })

</script>

<?= $this->endSection() ?>