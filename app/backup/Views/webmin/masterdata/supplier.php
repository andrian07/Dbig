<?php
$themeUrl = base_url('assets/adminlte3');
$assetsUrl = base_url('assets');
?>

<?= $this->extend('webmin/template/admin_template') ?>

<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Supplier</h1>
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
                        <table id="tblsupplier" class="table table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th data-priority="1">#</th>
                                    <th data-priority="2">Kode Supplier</th>
                                    <th data-priority="4">Nama Supplier</th>
                                    <th data-priority="5">Alamat</th>
                                    <th data-priority="6">No Telp</th>
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

            <div class="modal fade" id="modal-supplier">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="title-frmsupplier"></h4>
                            <button type="button" class="close close-modal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="frmsupplier" class="form-horizontal">
                            <div class="modal-body">
                                <input type="hidden" name="supplier_id" id="supplier_id">
                                <div class="form-group">
                                    <label for="supplier_code" class="col-sm-12">Kode Supplier</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="supplier_code" name="supplier_code" placeholder="Kode Supplier" value="" data-parsley-maxlength="10" data-parsley-trigger-after-failure="focusout" data-parsley-vsuppliercode required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="supplier_name" class="col-sm-12">Nama Supplier</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="supplier_name" name="supplier_name" placeholder="Nama Supplier" value="" data-parsley-maxlength="200" data-parsley-trigger-after-failure="focusout" data-parsley-vsuppliername required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="supplier_address" class="col-sm-12">Alamat</label>
                                    <div class="col-sm-12">
                                        <textarea id="supplier_address" name="supplier_address" class="form-control" placeholder="Alamat" data-parsley-maxlength="500" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="supplier_phone" class="col-sm-12">No Telp</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="supplier_phone" name="supplier_phone" placeholder="No Telp" value="" data-parsley-minlength="8" data-parsley-maxlength="15" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="mapping_id" class="col-sm-12">Mapping Area</label>
                                    <div class="col-sm-12 sel2">
                                        <select id="mapping_id" name="mapping_id" class="form-control" required></select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="supplier_npwp" class="col-sm-12">NPWP</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="supplier_npwp" name="supplier_npwp" placeholder="NPWP" value="" data-parsley-maxlength="200">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="supplier_address" class="col-sm-12">Catatan</label>
                                    <div class="col-sm-12">
                                        <textarea id="supplier_remark" name="supplier_remark" class="form-control" placeholder="Catatan" data-parsley-maxlength="500" rows="3"></textarea>
                                    </div>
                                </div>

                            </div>

                            <div class="modal-footer justify-content-between">
                                <button id="btncancel" class="btn btn-danger close-modal"><i class="fas fa-times-circle"></i> Batal</button>
                                <button id="btnsave" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
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
<script>
    $(document).ready(function() {
        let formMode = '';

        function _initButton() {
            $('#btnadd').prop('disabled', !hasRole('supplier.add'));
            $('.btnedit').prop('disabled', !hasRole('supplier.edit'));
            $('.btndelete').prop('disabled', !hasRole('supplier.delete'));
        }

        // select2 //
        $("#mapping_id").select2({
            placeholder: '-- Pilih Area --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/mapping-area",
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

        // datatables //
        let tblsupplier = $("#tblsupplier").DataTable({
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
                url: base_url + '/webmin/supplier/table',
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
                    width: 100,
                    targets: 5
                },
                {
                    targets: [0, 5],
                    orderable: false,
                    searchable: false,
                },
                {
                    targets: [0],
                    className: "text-right",
                },
            ],
        });

        function updateTable() {
            tblsupplier.ajax.reload(null, false);
        }

        $('#btnreload').click(function(e) {
            e.preventDefault();
            updateTable();
        })

        // crud  //
        function checkCode(supplier_code) {
            let actUrl = base_url + '/webmin/supplier/getbycode';
            useLoader = false;
            let getData = ajax_get(actUrl, {
                supplier_code: supplier_code
            }, {}, false);
            useLoader = true;

            if (getData.success) {
                let result = getData.result;
                if (result.exist) {
                    let uID = result.data.supplier_id;
                    if (uID.toUpperCase() == $("#supplier_id").val().toUpperCase()) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return true;
                }
            } else {
                return false;
            }
        }

        function checkName(supplier_name) {
            let actUrl = base_url + '/webmin/supplier/getbyname';
            useLoader = false;
            let getData = ajax_get(actUrl, {
                supplier_name: supplier_name
            }, {}, false);
            useLoader = true;

            if (getData.success) {
                let result = getData.result;
                if (result.exist) {
                    let uID = result.data.supplier_id;
                    if (uID.toUpperCase() == $("#supplier_id").val().toUpperCase()) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return true;
                }
            } else {
                return false;
            }
        }

        Parsley.addMessages('id', {
            vsuppliercode: 'Kode supplier sudah terdaftar',
            vsuppliername: 'Nama supplier sudah terdaftar'
        });

        Parsley.setLocale('id');

        window.Parsley.addValidator("vsuppliercode", {
            validateString: function(value) {
                return checkCode(value)
            },
        });

        window.Parsley.addValidator("vsuppliername", {
            validateString: function(value) {
                return checkName(value)
            },
        });

        function addMode() {
            let form = $('#frmsupplier');
            $('#title-frmsupplier').html('Tambah Supplier');
            form.parsley().reset();
            formMode = 'add';
            $('#supplier_id').val(0);
            $('#supplier_code').val('');
            $('#supplier_name').val('');
            $('#supplier_address').val('');
            $('#supplier_phone').val('');
            setSelect2('#mapping_id');
            $('#supplier_npwp').val('');
            $('#supplier_remark').val('');
            $('#modal-supplier').modal(configModal);
        }

        function editMode(data) {
            let form = $('#frmsupplier');
            $('#title-frmsupplier').html('Ubah Supplier');
            form.parsley().reset();
            formMode = 'edit';
            $('#supplier_id').val(data.supplier_id);
            $('#supplier_code').val(htmlEntities.decode(data.supplier_code));
            $('#supplier_name').val(htmlEntities.decode(data.supplier_name));
            $('#supplier_address').val(htmlEntities.decode(data.supplier_address));
            $('#supplier_phone').val(htmlEntities.decode(data.supplier_phone));
            let mapping_text = htmlEntities.decode(data.mapping_code + ' - ' + data.mapping_address);
            setSelect2('#mapping_id', data.mapping_id, mapping_text);
            $('#supplier_npwp').val(htmlEntities.decode(data.supplier_npwp));
            $('#supplier_remark').val(htmlEntities.decode(data.supplier_remark));
            $('#modal-supplier').modal(configModal);
        }

        $('#btnadd').click(function(e) {
            e.preventDefault();
            addMode();
        })

        $('.close-modal').click(function(e) {
            e.preventDefault();
            message.question('Yakin ingin menutup halaman ini?').then(function(answer) {
                let yes = parseMessageResult(answer);
                if (yes) {
                    $('#modal-supplier').modal('hide');
                }
            })
        })


        $('#btnsave').click(function(e) {
            e.preventDefault();
            let form = $('#frmsupplier');
            let btnSubmit = $('#btnsave')
            form.parsley().validate();
            if (form.parsley().isValid()) {
                let question = 'Yakin ingin menyimpan data supplier?';
                let actUrl = base_url + '/webmin/supplier/save/add';
                if (formMode == 'edit') {
                    question = 'Yakin ingin memperbarui data supplier?';
                    actUrl = base_url + '/webmin/supplier/save/edit';
                }

                message.question(question).then(function(answer) {
                    let yes = parseMessageResult(answer);
                    if (yes) {
                        let formValues = form.serialize();
                        btnSubmit.prop('disabled', true);
                        ajax_post(actUrl, formValues, {
                            success: function(response) {
                                if (response.success) {
                                    if (response.result.success) {
                                        form[0].reset();
                                        notification.success(response.result.message);
                                        form.parsley().reset();
                                        $('#modal-supplier').modal('hide');
                                    } else {
                                        message.error(response.result.message);
                                    }
                                }
                                btnSubmit.prop('disabled', false);
                                updateTable();
                            },
                            error: function(response) {
                                btnSubmit.prop('disabled', false);
                                updateTable();
                            }
                        });
                    }

                })

            }
        })

        $("#tblsupplier").on('click', '.btnedit', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let actUrl = base_url + '/webmin/supplier/getbyid/' + id;
            ajax_get(actUrl, null, {
                success: function(response) {
                    if (response.success) {
                        if (response.result.exist) {
                            editMode(response.result.data);
                        } else {
                            message.error(response.result.message);
                        }
                    }
                }
            })

        })

        $("#tblsupplier").on('click', '.btndelete', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let supplier_code = $(this).attr('data-code');
            let supplier_name = $(this).attr('data-name');
            let question = 'Yakin ingin menghapus supplier <b>' + supplier_code + ' - ' + supplier_name + '</b>?';
            let actUrl = base_url + '/webmin/supplier/delete/' + id;
            message.question(question).then(function(answer) {
                let yes = parseMessageResult(answer);
                if (yes) {
                    ajax_get(actUrl, null, {
                        success: function(response) {
                            if (response.success) {
                                if (response.result.success) {
                                    notification.success(response.result.message);
                                } else {
                                    message.error(response.result.message);
                                }
                            }
                            updateTable();
                        },
                        error: function(response) {
                            updateTable();
                        }
                    })
                }
            })
        })



        _initButton();

    })
</script>
<?= $this->endSection() ?>