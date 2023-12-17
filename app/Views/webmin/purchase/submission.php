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

                                        <th data-priority="5">Keterangan</th>

                                        <th data-priority="6">Status</th>

                                        <th data-priority="7">Catatan Ditolak</th>

                                        <th data-priority="8">Aksi</th>

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
                                    <textarea id="desc_decline" name="desc_decline" type="text"
                                    class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button class="btn btn-danger close-modal-decline"><i class="fas fa-times-circle"></i>
                    Batal</button>
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

<div id="submission_input">

    <section class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h1 id="title-frmsubmission">Tambah Pengajuan</h1>

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


                            <form id="frmaddsubmission" class="form-horizontal form-space">

                                <div class="form-group row">

                                    <label for="noinvoice" class="col-sm-1 col-form-label text-right">No Invoice
                                    :</label>

                                    <div class="col-sm-3">

                                        <input id="submission_inv" name="submission_inv" type="text"
                                        class="form-control" value="AUTO" readonly>
                                        <input id="submission_id" name="purchase_order_id" type="hidden"
                                        class="form-control">

                                    </div>

                                    <div class="col-md-4"></div>
                                    <label for="tanggal" class="col-sm-1 col-form-label text-right">Tanggal :</label>

                                    <div class="col-sm-3">

                                        <input id="submission_order_date" name="submission_order_date" type="date"
                                        class="form-control" value="<?= date('Y-m-d') ?>" readonly>

                                    </div>
                                </div>



                                
                                <div class="form-group row">


                                    <label for="has_tax" class="col-sm-1 col-form-label text-right">Tipe :</label>

                                    <div class="col-sm-3">
                                        <select id="submission_type" type="text" class="form-control"
                                        data-parsley-vsubmissiontype required>
                                        <option value="Pembelian">Pembelian</option>
                                        <option value="Konsinyasi">Konsinyasi</option>
                                    </select>
                                </div>

                                <div class="col-md-4"></div>

                                <label for="user" class="col-sm-1 col-form-label text-right">User :</label>

                                <div class="col-sm-3">

                                    <input id="display_user" type="text" class="form-control"
                                    value="<?= $user['user_realname'] ?>" readonly>

                                </div>

                            </div>

                            <div class="form-group row">


                                <label for="salesman_id" class="col-sm-1 col-form-label text-right">Sales :</label>

                                <div class="col-sm-3">
                                    <select id="salesman_id" type="text" class="form-control"></select>
                                </div>

                                <div class="col-md-4"></div>
                                
                                <label for="status" class="col-sm-1 col-form-label text-right">Status :</label>
                                <div class="col-sm-3">
                                    <select id="temp_status" name="temp_status" class="form-control"
                                    data-parsley-vtempstatus required>
                                    <option></option>
                                    <option value="Urgent">Urgent</option>
                                    <option value="New">New</option>
                                    <option value="Restock">Restock</option>
                                </select>
                            </div>

                        </div>


                        <div class="form-group row">
                           <label for="user" class="col-sm-1 col-form-label text-right">Gudang :</label>

                           <div class="col-sm-3">

                            <div style="display: none;">
                                <select id="supplier_id" name="supplier_id"  style="display:none;"></select>
                            </div>
                            <select id="warehouse" type="text" class="form-control" data-parsley-vwarehousecode
                            required></select>

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

                            <input id="temp_submission_id" name="temp_submission_id" type="hidden" value="">

                            <input id="item_id" name="item_id" type="hidden" value="">

                            <div class="col-sm-4">

                                <!-- text input -->

                                <div class="form-group">

                                    <label>Produk</label>

                                    <input id="product_name" name="product_name" type="text"
                                    class="form-control" placeholder="ketikkan nama produk" value=""
                                    data-parsley-vproductname required>

                                </div>

                            </div>

                            <div class="col-sm-2">

                                <!-- text input -->

                                <div class="form-group">

                                    <label>Qty</label>

                                    <input id="temp_qty" name="temp_qty" type="text"
                                    class="form-control text-right" value="0" data-parsley-vqty required>

                                </div>

                            </div>




                            <div class="col-sm-1" style="padding-right: 62px;">

                                <!-- text input -->

                                <label>&nbsp;</label>

                                <div class="form-group">

                                    <button id="btnadd_temp"
                                    class="btn btn-md btn-primary rounded-circle float-right"><i
                                    class="fas fa-plus"></i></button>

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

                                        <th data-priority="2">Item Code</th>

                                        <th data-priority="3" width="25%;">Product</th>                                        

                                        <th data-priority="4">Qty</th>

                                        <th data-priority="5">Aksi</th>

                                    </tr>

                                </thead>

                                <tbody></tbody>

                            </table>

                            <template id="template_row_temp">

                                <tr>

                                    <td>{row}</td>

                                    <td>{item_code}</td>

                                    <td>{product_name}</td>

                                    <td>{temp_qty}</td>

                                    <td>
                                        <button data-id="{temp_id}" data-json="{data_json}"
                                        class="btn btn-sm btn-warning btnedit rounded-circle"
                                        data-toggle="tooltip" data-placement="top" data-title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button data-id="{temp_id}"
                                    class="btn btn-sm btn-danger btndelete rounded-circle"
                                    data-toggle="tooltip" data-placement="top" data-title="Hapus">
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

                            <textarea id="submission_desc" name="submission_desc" class="form-control" placeholder="Catatan" maxlength="500" rows="3"></textarea>

                        </div>

                    </div>

                </div>

                <div class="col-lg-6 text-right">

                    <div class="form-group row">
                        <div class="col-sm-12">
                            <button id="btncancel" class="btn btn-danger"><i
                                class="fas fa-times-circle"></i> Batal</button>
                                <button id="btnsave_submission" class="btn btn-success button-header-custom-save"><i
                                    class="fas fa-save"></i> Simpan</button>
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

<?= $this->endSection() ?>



<?= $this->section('js') ?>

<script>



    $(document).ready(function () {

        let temp_qty = new AutoNumeric('#temp_qty', configQty);


        //$('#supplier_id').hide();
        // init component //

        function _initButton() {
            $('#btnadd').prop('disabled', !hasRole('submission.add'));
            $('.btnedit').prop('disabled', !hasRole('submission.edit'));
            $('.btndelete').prop('disabled', !hasRole('submission.delete'));
            $('.btndecline').prop('disabled', !hasRole('submission.decline'));
        }

        function showInputPage(x) {

            if (x) {

                $('#submission_list').hide();

                $('#submission_input').show();

            } else {

                $('#submission_list').show();

                $('#submission_input').hide();

            }
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
                error: function () {
                    notification.danger('Gagal memuat table, harap coba lagi');
                },
            },
            drawCallback: function (settings) {
                _initTooltip();
                _initButton();
            },
            columnDefs: [{
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
            },
            ],
        });

        function loadTempData(items) {

            if (items['length'] < 1) {
                setSelect2('#supplier_id', "", "");
                $('#supplier_id').prop('disabled', false);
            }
            let template = $('#template_row_temp').html();

            let tbody = '';

            let row = 1;

            let temp_total_order = 0;

            items.forEach((val, key) => {

                let item = template;

                let data_json = htmlEntities.encode(JSON.stringify(val));

                let temp_submission_id = val.temp_submission_id;

                let item_code = val.item_code;

                let product_name = val.product_name+'('+val.unit_name+')';

                let temp_submission_qty = parseFloat(val.temp_submission_qty);

                item = item.replaceAll('{row}', row)

                .replaceAll('{item_code}', item_code)

                .replaceAll('{product_name}', product_name)

                .replaceAll('{temp_qty}', numberFormat(temp_submission_qty, true))

                .replaceAll('{temp_id}', temp_submission_id)

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

            clearTempInput();

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

                targets: [0, 4],

                orderable: false,

                searchable: false,

            },
            {

                targets: [0, 2, 3, 4],

                className: "text-right",

            }

            ]

        };


        

        $('#btnadd').click(function (e) {
            e.preventDefault();
            let actUrl = base_url + '/webmin/submission/get-submission-temp';
            ajax_get(actUrl, null, {
                success: function (response) {
                    if (response.result.success == 'TRUE') {
                        let form = $('#frmsubmission');
                        let items = response.result.data;
                        $('#title-frmsubmission').html('Pengajuan');
                        formMode = 'add';
                        setSelect2('#supplier_id', "", "");
                        $('#supplier_id').prop("disabled", false);
                        loadTempData(items);
                        if (items.length != 0) {
                            let supplier_ids = items[0].temp_submission_supplier_id;
                            let supplier_names = items[0].temp_submission_supplier_name;
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

        $('.close-modal-decline').click(function (e) {
            e.preventDefault();
            message.question('Yakin ingin menutup halaman ini?').then(function (answer) {
                let yes = parseMessageResult(answer);
                if (yes) {
                    $('#modal-decline').modal('hide');
                }
            })
        })



        let tbltemp = $('#tbltemp').DataTable(config_tbltemp);

        $('#btnadd_temp').click(function(e) {

            e.preventDefault();

            let qty = parseFloat(temp_qty.getNumericString());

            let supplier_id = $('#supplier_id').val();

            let supplier_name = $("#supplier_id option:selected" ).text();

            let submission_type = $('#submission_type').val();

            let salesman_id = $('#salesman_id').val();

            let salesman_name = $("#salesman_id option:selected" ).text();

            let warehouse_id = $('#warehouse').val();

            let warehouse_name = $("#warehouse option:selected" ).text();

            let temp_status = $('#temp_status').val();

            let item_id = $('#item_id').val();

            let product_name = $('#product_name').val();

            let btnSubmit = $('#btnadd_temp');

            let form = $('#frmaddtemp');

            form.parsley().validate();

            if (form.parsley().isValid()) {

                let actUrl = base_url + '/webmin/submission/temp-add';

                let formValues = {

                    supplier_id: $('#supplier_id').val(),

                    supplier_name: supplier_name,

                    product_name:product_name,

                    item_id:item_id,

                    temp_qty:qty,

                    salesman_id:salesman_id,

                    salesman_name:salesman_name,

                    warehouse_id:warehouse_id,

                    warehouse_name:warehouse_name
                };

                btnSubmit.prop('disabled', true);

                ajax_post(actUrl, formValues, {

                    success: function(response) {

                        if (response.success) {

                            if (response.result.success) {

                                $('#product_name').focus();

                                setSelect2('#supplier_id', supplier_id, supplier_name);

                                $('#supplier_id').attr("disabled", true);

                                if(warehouse_id != null)
                                {
                                    setSelect2('#warehouse', warehouse_id, warehouse_name);
                                }
                                if(salesman_id != null)
                                {
                                    setSelect2('#salesman_id', salesman_id, salesman_name);
                                }

                                notification.success(response.result.message);

                            } else {

                               message.error(response.result.message);

                           }

                           clearTempInput();

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

        $("#tbltemp").on('click', '.btnedit', function(e) {

            e.preventDefault();

            let json_data = $(this).attr('data-json');

            let [json, is_json, error] = parseJSON(htmlEntities.decode(json_data));

            if (is_json) {

                $('#temp_submission_id').val(json.temp_submission_id);

                $('#item_id').val(json.temp_submission_item_id);

                $('#product_name').val(json.temp_submission_item_name);

                temp_qty.set(json.temp_submission_qty);

            } else {

                getTemp();

                message.error('Terjadi kesalahan dalam memproses data, harap coba lagi');

            }

        })  


        $("#tbltemp").on('click', '.btndelete', function(e) {

            e.preventDefault();

            let id = $(this).attr('data-id');

            let actUrl = base_url + '/webmin/submission/temp-delete/' + id;

            ajax_get(actUrl, null, {

                success: function(response) {

                    if (response.success) {

                        if (response.result.success) {

                            notification.success(response.result.message);

                        } else {

                            message.error(response.result.message);

                        }

                        loadTempData(response.result.data);

                    }

                },

                error: function(response) {

                    getTemp();

                }

            })


            $('#btncancel').click(function (e) {

                e.preventDefault();

                let actUrl = base_url + '/webmin/submission/clearTemp/';

                ajax_get(actUrl, null, {

                    success: function(response) {

                        if (response.success) {

                            if (response.result.success) {

                                clearTempInput();

                                clearItemInput();

                                showInputPage(false);

                            } else {

                                message.error(response.result.message);

                            }


                        }

                    },

                    error: function(response) {

                        getTemp();

                    }

                })

            })

        })

        $("#tblhdsubmission").on('click', '.btndecline', function (e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let actUrl = base_url + '/webmin/submission/getbyid/' + id;
            ajax_get(actUrl, null, {
                success: function (response) {
                    if (response.success) {
                        if (response.result.exist) {
                            if (response.result.data.submission_status == 'Pending') {
                                declineMode(response.result.data);
                            } else {
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

                    url: base_url + '/webmin/purchase-order/search-product-non-suplier',

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
                setSelect2('#supplier_id', ui.item.supplier_id, ui.item.supplier_name);

            },

        });

        $("#tblhdsubmission").on('click', '.btndelete', function (e) {

            e.preventDefault();

            let id = $(this).attr('data-id');

            let submission_id_decline = $('#submission_id_decline').val();

            message.question('Yakin ingin Menghapus pengajuan ini?').then(function (answer) {

                let yes = parseMessageResult(answer);

                if (yes) {

                    let actUrl = base_url + '/webmin/submission/cancel-order/' + id;

                    ajax_get(actUrl, null, {

                        success: function (response) {

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

        $('#btn_decline').click(function (e) {

            e.preventDefault();

            let form = $('#frmdecline');

            let btnSubmit = $('#btn_decline');

            let question = 'Yakin ingin Menolak data Pengajuan?';

            let actUrl = base_url + '/webmin/submission/decline-order';

            message.question(question).then(function (answer) {

                let yes = parseMessageResult(answer);

                if (yes) {

                    let formValues = {

                        submission_id_decline: $('#submission_id_decline').val(),

                        desc_decline: $('#desc_decline').val()

                    };

                    btnSubmit.prop('disabled', true);

                    ajax_post(actUrl, formValues, {

                        success: function (response) {

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

                        error: function (response) {

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
                data: function (params) {
                    return {
                        search: params.term,
                    };
                },
                processResults: function (data, page) {
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
                data: function (params) {
                    return {
                        search: params.term,
                    };
                },
                processResults: function (data, page) {
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
                data: function (params) {
                    return {
                        search: params.term,
                    };
                },
                processResults: function (data, page) {
                    return {
                        results: data,
                    };
                },
            },
        });


        $("#tblhdsubmission").on('click', '.btnedit', function(e) {

            e.preventDefault();

            let id = $(this).attr('data-id');

            let actUrl = base_url + '/webmin/submission/edit-submission/' + id;

            ajax_get(actUrl, null, {

                success: function(response) {

                    if (response.success) {

                        if (response.result.success) {

                            let form = $('#frmpurchaseorder');

                            let items = response.result.data;

                            $('#title-frmpurchaseorder').html('Ubah PO');

                            let header = response.result.header;

                            supplier_id = header.submission_supplier_id;

                            supplier_name = header.supplier_name;

                            salesman_id = header.submission_salesman_id;

                            salesman_name = header.salesman_name;

                            warehouse_id = header.submission_warehouse_id;

                            warehouse_name = header.warehouse_name;

                            if (header.submission_status == 'Pending') {

                                console.log(header);

                                $('#title-frmpurchaseorder').html('Ubah Pengajuan Pesanan');

                                formMode = 'edit';

                                $('#submission_id').val(header.submission_id);

                                $('#submission_inv').val(header.submission_inv);

                                setSelect2('#supplier_id', supplier_id, supplier_name);

                                $('#supplier_id').prop("disabled", true);

                                $('#submission_type').val(header.submission_type);

                                setSelect2('#salesman_id', salesman_id, salesman_name);

                                setSelect2('#warehouse', warehouse_id, warehouse_name);

                                $('#display_user').val(header.user_realname);

                                $('#temp_status').val(header.submission_item_status);

                                $('#submission_desc').val(header.submission_desc);

                                loadTempData(items);

                                showInputPage(true);

                            } else {

                                message.info('Pesanan yang sudah selesai atau dibatalkan tidak dapat di ubah lagi');

                            }

                        } else {

                            message.error(response.result.message);

                        }

                    }

                }

            })
        })

        $('#btnsave_submission').click(function (e) {

            e.preventDefault();

            let qty = parseFloat(temp_qty.getNumericString());

            let form = $('#frmaddsubmission');

            let btnSubmit = $('#btnsave_submission');

            let question = 'Yakin ingin menyimpan data Pengajuan?';

            form.parsley().validate();

            if (form.parsley().isValid()) {

                let actUrl = base_url + '/webmin/submission/save/add';

                if (formMode == 'edit') {

                    question = 'Yakin ingin memperbarui data Pengajuan?';

                    actUrl = base_url + '/webmin/submission/save/edit';

                }

                message.question(question).then(function (answer) {


                    let yes = parseMessageResult(answer);

                    if (yes) {

                        let formValues = {

                            submission_id: $('#submission_id').val(),

                            submission_inv: $('#submission_inv').val(),

                            submission_order_date: $('#submission_order_date').val(),

                            supplier_id: $('#supplier_id').val(),

                            submission_warehouse_id: $('#warehouse').val(),

                            submission_type: $('#submission_type').val(),

                            salesman_id: $('#salesman_id').val(),

                            temp_status: $('#temp_status').val(),

                            desc: $('#submission_desc').val(),

                        };

                        btnSubmit.prop('disabled', true);

                        ajax_post(actUrl, formValues, {

                            success: function (response) {

                                if (response.success) {

                                    if (response.result.success) {

                                        form[0].reset();

                                        notification.success(response.result.message);

                                        form.parsley().reset();

                                        clearItemInput();

                                        showInputPage(false);

                                    } else {

                                        message.error(response.result.message);

                                    }

                                }

                                btnSubmit.prop('disabled', false);

                                updateTableHeader();

                                //window.location.href = base_url + '/webmin/submission/';

                            },

                            error: function (response) {

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

            vsubmissiontype: 'Jenis Pengajuan Harus Di Pilih',

            vsalesman: 'Salesman Harus Di Isi',

            vproductname: 'Harap pilih produk terlebih dahulu',

            vprice: 'Harga beli wajib diatas Rp 0',

            vqty: 'Qty wajib diatas Rp 0',

            vtempstatus: 'Status wajib di pilih ',

        });


        Parsley.setLocale('id');

        window.Parsley.addValidator("vwarehousecode", {

            validateString: function (value) {

                if ($('#warehouse').val() == '') {

                    return false;

                } else {

                    return true;

                }
            },

        });

        window.Parsley.addValidator("vsubmissiontype", {

            validateString: function (value) {

                if ($('#submissiontype').val() == '') {

                    return false;

                } else {

                    return true;

                }
            },

        });

        window.Parsley.addValidator("vsalesman", {

            validateString: function (value) {

                if ($('#salesman_id').val() == '') {

                    return false;

                } else {

                    return true;

                }
            },

        });


        window.Parsley.addValidator("vproductname", {

            validateString: function (value) {

                if ($('#product_name').val() == '') {

                    return false;

                } else {

                    return true;

                }
            },

        });

        window.Parsley.addValidator("vtempstatus", {

            validateString: function (value) {

                if ($('#temp_status').val() == '') {

                    return false;

                } else {

                    return true;

                }
            },

        });

        window.Parsley.addValidator("vprice", {

            validateString: function (value) {

                let vprice = parseFloat(temp_price.getNumericString());

                if (vprice <= 0) {

                    return false;

                } else {

                    return true;

                }

            },

        });



        window.Parsley.addValidator("vqty", {

            validateString: function (value) {

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

            let form = $('#frmaddtemp');

            form.parsley().reset();

            setSelect2("#warehouse", '', '');

            setSelect2("#salesman_id", '', '');

            $('#item_id').val('');

            $('#item_code').val('');

            $('#product_name').val('');

            temp_qty.set(0);

            $('#submission_desc').val('');

        }

        function clearTempInput() {

            let form = $('#frmaddtemp');

            form.parsley().reset();

            $('#item_id').val('');

            $('#item_code').val('');

            $('#product_name').val('');

            temp_qty.set(0);

        }


        _initButton();

        showInputPage(false);

    })

</script>

<?= $this->endSection() ?>