<?php
$themeUrl = base_url('assets/adminlte3');
$assetsUrl = base_url('assets');
?>


<?= $this->extend('webmin/template/admin_template') ?>

<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<div id="submission_list">

    <section class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h1>Daftar Pengajuan</h1>

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

                            <table id="tblhdsubmission" class="table table-bordered table-hover" width="100%">

                                <thead>

                                    <tr>

                                        <th data-priority="1">#</th>

                                        <th data-priority="2">No Invoice Pengajuan</th>

                                        <th data-priority="3">Tanggal Pengajuan</th>

                                        <th data-priority="4">Diajukan</th>

                                        <th data-priority="5">Nama Produk</th>

                                        <th data-priority="6">Keterangan</th>

                                        <th data-priority="7">Status</th>

                                        <th data-priority="8">Catatan Admin</th>

                                        <th data-priority="9">Aksi</th>

                                    </tr>

                                </thead>


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

<!-- add submission -->
<div class="modal fade" id="modal-addsubmission">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="title-addsubmission"></h4>
                <button type="button" class="close close-modal-addsubmission">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="frmaddsubmission" class="form-horizontal">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 border-right border-primary">
                            <div class="form-group">
                                <label for="submission_order_invoice" class="col-sm-12">No Invoice:</label>
                                <div class="col-sm-12">
                                    <input type="hidden" id="submission_id" name="submission_id">
                                    <input id="submission_order_invoice" name="submission_order_invoice" type="text" class="form-control" value="AUTO" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="submission_order_date" class="col-sm-12">Tanggal:</label>
                                <div class="col-sm-12">
                                    <input id="submission_order_date" name="submission_order_date" type="date" class="form-control" value="<?= date('Y-m-d') ?>" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="warehouse" class="col-sm-1 col-form-label text-right">Gudang:</label>
                                <div class="col-sm-12">
                                    <select id="warehouse" type="text" class="form-control" data-parsley-vwarehousecode required></select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="salesman_id" class="col-sm-1 col-form-label text-right">Sales:</label>
                                <div class="col-sm-12">
                                    <select id="salesman_id" type="text" class="form-control" data-parsley-vsalesman required></select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="display_user" class="col-sm-1 col-form-label text-right">User:</label>
                                <div class="col-sm-12">
                                    <input id="display_user" type="text" class="form-control" value="<?= $user['user_realname'] ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">



                            <div class="form-group">
                               <label for="temp_status" class="col-sm-12">Status:</label>
                               <div class="col-sm-12">
                                <select id="temp_status" name="temp_status" class="form-control" data-parsley-vtempstatus required> 
                                    <option></option>
                                    <option value="Urgent">Urgent</option>
                                    <option value="New">New</option>
                                    <option value="Restock">Restock</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                           <label for="item_code" class="col-sm-12">Produk Code:</label>
                           <div class="col-sm-12">
                            <input id="item_id" name="item_id" class="form-control" type="hidden">
                            <input id="item_code" name="item_code" class="form-control" type="text" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                       <label for="product_name" class="col-sm-12">Produk:</label>
                       <div class="col-sm-12">
                        <input id="product_name" name="product_name" type="text" class="form-control" placeholder="ketikkan nama produk" value="" data-parsley-vproductname required>
                    </div>
                </div>

                <div class="form-group">
                   <label for="temp_qty" class="col-sm-12">Qty:</label>
                   <div class="col-sm-12">
                    <input id="temp_qty" name="temp_qty"  class="form-control" value="0" data-parsley-vqty required>
                </div>
            </div>

            <div class="form-group">
               <label for="desc" class="col-sm-12">Keterangan:</label>
               <div class="col-sm-12">
                <textarea id="desc" name="desc" type="text" class="form-control"></textarea>
            </div>
        </div>


    </div>
</div>
</div>
<div class="modal-footer justify-content-between">
    <button class="btn btn-danger close-modal-addsubmission"><i class="fas fa-times-circle"></i> Batal</button>
    <button id="btnsave_submission" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
</div>
</form>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- end submission -->


<!-- decline -->
<div class="modal fade" id="modal-decline">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="title-frmdecline"></h4>
                <button type="button" class="close close-modal-decline">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="frmdecline" class="form-horizontal">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                           <div class="form-group">
                               <label for="desc" class="col-sm-12">Keterangan:</label>
                               <div class="col-sm-12">
                                <input type="hidden" id="submission_id_decline" name="submission_id_decline">
                                <textarea id="desc_decline" name="desc_decline" type="text" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button class="btn btn-danger close-modal-decline"><i class="fas fa-times-circle"></i> Batal</button>
                <button id="btn_decline" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
            </div>
        </form>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>

<!-- end Decline -->


<!-- /.content -->

<?= $this->endSection() ?>



<?= $this->section('js') ?>

<script>



    $(document).ready(function() {

        let temp_qty = new AutoNumeric('#temp_qty', configQty);


       // init component //

       function _initButton() {
           $('#btnadd').prop('disabled', !hasRole('submission.add'));
           $('.btnedit').prop('disabled', !hasRole('submission.edit'));
           $('.btndelete').prop('disabled', !hasRole('submission.delete'));
           $('.btndecline').prop('disabled', !hasRole('submission.decline'));
       }

        // select2 //

        let tblhdsubmission = $("#tblhdsubmission").DataTable({
            processing: true,
            select: true,
            serverSide: true,
            responsive: true,
            fixedColumns: true,
            order: [
            [1, 'asc']
            ],
            language: {
                url: lang_datatables,
            },
            ajax: {
                url: base_url + '/webmin/submission/tblhdsubmission',
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
                targets: [0, 8],
                orderable: false,
                searchable: false,
            },
            {
                targets: [0],
                className: "text-right",
            },
            ],
        });


        $('#btnadd').click(function(e) {
            e.preventDefault();
            let form = $('#frmaddsubmission');
            $('#title-addsubmission').html('Tambah Pengajuan');
            $('#modal-addsubmission').modal(configModal);
            clearItemInput();
            formMode = 'add';

        })

        $('.close-modal-addsubmission').click(function(e) {
            e.preventDefault();
            message.question('Yakin ingin menutup halaman ini?').then(function(answer) {
                let yes = parseMessageResult(answer);
                if (yes) {
                    $('#modal-addsubmission').modal('hide');
                }
            })
        })

        $('.close-modal-decline').click(function(e) {
            e.preventDefault();
            message.question('Yakin ingin menutup halaman ini?').then(function(answer) {
                let yes = parseMessageResult(answer);
                if (yes) {
                    $('#modal-decline').modal('hide');
                }
            })
        })

        $("#tblhdsubmission").on('click', '.btnedit', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let actUrl = base_url + '/webmin/submission/getbyid/' + id;
            ajax_get(actUrl, null, {
                success: function(response) {
                    if (response.success) {
                        if (response.result.exist){
                            if(response.result.data.submission_status == 'Pending'){
                                editMode(response.result.data);
                            }else{
                                message.info('Pesanan yang sudah selesai atau dibatalkan tidak dapat di ubah lagi');
                            }
                        } else {
                            message.error(response.result.message);
                        }
                    }
                }
            })

        })

        function editMode(data) {
            let form = $('#frmaddsubmission');
            $('#title-frmaddsubmission').html('Ubah Pengajuan');
            form.parsley().reset();
            formMode = 'edit';
            $('#submission_id').val(htmlEntities.decode(data.submission_id));
            $('#submission_order_invoice').val(htmlEntities.decode(data.submission_inv));
            $('#submission_order_date').val(htmlEntities.decode(data.submission_date));
            setSelect2("#warehouse",htmlEntities.decode(data.submission_warehouse_id),htmlEntities.decode(data.warehouse_code)+' - '+htmlEntities.decode(data.warehouse_name));
            setSelect2("#salesman_id",htmlEntities.decode(data.submission_salesman_id),htmlEntities.decode(data.salesman_code)+' - '+htmlEntities.decode(data.salesman_name));
            $('#temp_status').val(htmlEntities.decode(data.submission_item_status));
            $('#item_code').val(htmlEntities.decode(data.item_code));
            $('#item_id').val(htmlEntities.decode(data.submission_item_id));
            $('#product_name').val(htmlEntities.decode(data.submission_product_name));
            temp_qty.set(data.submission_qty);
            $('#desc').val(htmlEntities.decode(data.submission_desc));
            $('#modal-addsubmission').modal(configModal);
        }

        $("#tblhdsubmission").on('click', '.btndecline', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let actUrl = base_url + '/webmin/submission/getbyid/' + id;
            ajax_get(actUrl, null, {
                success: function(response) {
                    if (response.success) {
                        if (response.result.exist){
                            if(response.result.data.submission_status == 'Pending'){
                                declineMode(response.result.data);
                            }else{
                                message.info('Pesanan yang sudah selesai atau dibatalkan tidak dapat di ubah lagi');
                            }
                        } else {
                            message.error(response.result.message);
                        }
                    }
                }
            })

        })

        function declineMode(data) {
            let form = $('#frmdecline');
            $('#title-frmdecline').html('Tolak Pengajuan');
            form.parsley().reset();
            $('#submission_id_decline').val(htmlEntities.decode(data.submission_id));
            $('#modal-decline').modal(configModal);
        }

        $('#product_name').autocomplete({   

            minLength: 2,

            source: function(req, add) {

             $.ajax({

                 url: base_url + '/webmin/submission/search-product-submission',

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

            $('#item_code').val(ui.item.item_code);

        },

    });

        

        $("#tblhdsubmission").on('click', '.btndelete', function(e) {

            e.preventDefault();

            let submission_id_decline = $('#submission_id_decline').val();

            message.question('Yakin ingin Menolak pengajuan ini?').then(function(answer) {

                let yes = parseMessageResult(answer);

                if (yes) {

                    let actUrl = base_url + '/webmin/submission/cancel-order/' + submission_id_decline;

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

        $('#btn_decline').click(function(e) {

            e.preventDefault();

            let form = $('#frmdecline');

            let btnSubmit = $('#btn_decline');

            let question = 'Yakin ingin Menolak data Pengajuan?';

            let actUrl = base_url + '/webmin/submission/decline-order';

            message.question(question).then(function(answer) {

                let yes = parseMessageResult(answer);

                if (yes) {

                    let formValues = {

                        submission_id_decline: $('#submission_id_decline').val(),

                        desc_decline: $('#desc_decline').val()

                    };

                    btnSubmit.prop('disabled', true);

                    ajax_post(actUrl, formValues, {

                        success: function(response) {

                            if (response.success) {

                                if (response.result.success) {

                                    notification.success(response.result.message);

                                    $('#modal-decline').modal('hide');

                                } else {

                                    message.error(response.result.message);

                                }

                            }

                            btnSubmit.prop('disabled', false);

                            updateTableHeader();

                        },

                        error: function(response) {

                            btnSubmit.prop('disabled', false);

                            updateTable();

                        }
                    });
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

        $("#salesman_id").select2({
            placeholder: '-- Pilih Salesman --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/salesman",
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

        $('#btnsave_submission').click(function(e) {

            e.preventDefault();

            let qty = parseFloat(temp_qty.getNumericString());

            let form = $('#frmaddsubmission');

            let btnSubmit = $('#btnsave');

            let question = 'Yakin ingin menyimpan data Pengajuan?';


            form.parsley().validate();

            if (form.parsley().isValid()) {

                let actUrl = base_url + '/webmin/submission/save/add';

                if (formMode == 'edit') {

                    question = 'Yakin ingin memperbarui data Pengajuan?';

                    actUrl = base_url + '/webmin/submission/save/edit';

                }

                message.question(question).then(function(answer) {


                    let yes = parseMessageResult(answer);

                    if (yes) {

                        let formValues = {

                            submission_id: $('#submission_id').val(),

                            submission_order_date: $('#submission_order_date').val(),

                            submission_warehouse_id: $('#warehouse').val(),

                            salesman_id: $('#salesman_id').val(),

                            temp_status: $('#temp_status').val(),

                            item_id: $('#item_id').val(),

                            product_name: $('#product_name').val(),

                            qty:qty,

                            desc:$('#desc').val(),

                        };

                        btnSubmit.prop('disabled', true);

                        ajax_post(actUrl, formValues, {

                            success: function(response) {

                                if (response.success) {

                                    if (response.result.success) {

                                        form[0].reset();

                                        notification.success(response.result.message);

                                        form.parsley().reset();

                                        clearItemInput();

                                        let invoice = response.result.purchase_order_id;

                                        $('#modal-addsubmission').modal('hide');

                                    } else {

                                        message.error(response.result.message);

                                    }

                                }

                                btnSubmit.prop('disabled', false);

                                updateTableHeader();

                        //window.location.href = base_url + '/webmin/submission/';

                    },

                    error: function(response) {

                        btnSubmit.prop('disabled', false);

                        updateTable();

                    }

                });

                    }

                })
            }
        });

        Parsley.addMessages('id', {

            vwarehousecode: 'Gudang Harus Di Pilih',

            vsalesman: 'Salesman Harus Di Isi',

            vproductname: 'Harap pilih produk terlebih dahulu',

            vprice: 'Harga beli wajib diatas Rp 0',

            vqty: 'Qty wajib diatas Rp 0',

            vtempstatus: 'Status wajib di pilih ',

        });


        Parsley.setLocale('id');

        window.Parsley.addValidator("vwarehousecode", {

            validateString: function(value) {

                if ($('#warehouse').val() == '') {

                    return false;

                } else {

                    return true;

                }
            },

        });

        window.Parsley.addValidator("vsalesman", {

            validateString: function(value) {

                if ($('#salesman_id').val() == '') {

                    return false;

                } else {

                    return true;

                }
            },

        });


        window.Parsley.addValidator("vproductname", {

            validateString: function(value) {

                if ($('#product_name').val() == '') {

                    return false;

                } else {

                    return true;

                }
            },

        });

        window.Parsley.addValidator("vtempstatus", {

            validateString: function(value) {

                if ($('#temp_status').val() == '') {

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

                let vqty = parseFloat(temp_qty.getNumericString());

                if (vqty <= 0) {

                    return false;

                } else {

                    return true;

                }
            },

        });

        function updateTableHeader() {

         tblhdsubmission.ajax.reload(null, false);

     }

     function clearItemInput() {

         let form = $('#frmaddsubmission');

         form.parsley().reset();

         setSelect2("#warehouse", '', '');

         setSelect2("#salesman_id", '', '');

         $('#temp_status').val('');

         $('#item_id').val('');

         $('#item_code').val('');

         $('#product_name').val('');

         temp_qty.set(0);

         $('#desc').val('');

     }


     _initButton();

 })

</script>

<?= $this->endSection() ?>