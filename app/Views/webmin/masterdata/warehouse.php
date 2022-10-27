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
                <h1>Gudang</h1>
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
                        <table id="tblwarehouse" class="table table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th data-priority="1">#</th>
                                    <th data-priority="2">Kode Gudang</th>
                                    <th data-priority="5">Nama Gudang</th>
                                    <th data-priority="4">Toko</th>
                                    <th data-priority="6">Alamat</th>
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

            <div class="modal fade" id="modal-warehouse">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="title-frmwarehouse"></h4>
                            <button type="button" class="close close-modal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="frmwarehouse" class="form-horizontal">
                            <div class="modal-body">
                                <input type="hidden" name="warehouse_id" id="warehouse_id">
                                <div class="form-group">
                                    <label for="warehouse_code" class="col-sm-12">Kode Gudang</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="warehouse_code" name="warehouse_code" placeholder="Kode Gudang" value="" data-parsley-maxlength="10" data-parsley-trigger-after-failure="focusout" data-parsley-vwarehousecode required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="warehouse_name" class="col-sm-12">Nama Gudang</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="warehouse_name" name="warehouse_name" placeholder="Nama Gudang" value="" data-parsley-maxlength="200" data-parsley-trigger-after-failure="focusout" data-parsley-vwarehousename required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="warehouse_address" class="col-sm-12">Alamat</label>
                                    <div class="col-sm-12">
                                        <textarea id="warehouse_address" name="warehouse_address" class="form-control" placeholder="Alamat" data-parsley-maxlength="500" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="store_id" class="col-sm-12">Toko</label>
                                    <div class="col-sm-12 sel2">
                                        <select id="store_id" name="store_id" class="form-control" required></select>
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
            $('#btnadd').prop('disabled', !hasRole('warehouse.add'));
            $('.btnedit').prop('disabled', !hasRole('warehouse.edit'));
            $('.btndelete').prop('disabled', !hasRole('warehouse.delete'));
        }

        // select2 //
        $("#store_id").select2({
            placeholder: '-- Pilih Toko --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/store",
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
        let tblwarehouse = $("#tblwarehouse").DataTable({
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
                url: base_url + '/webmin/warehouse/table',
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
            tblwarehouse.ajax.reload(null, false);
        }

        $('#btnreload').click(function(e) {
            e.preventDefault();
            updateTable();
        })

        // crud  //
        function checkCode(warehouse_code) {
            let actUrl = base_url + '/webmin/warehouse/getbycode';
            useLoader = false;
            let getData = ajax_get(actUrl, {
                warehouse_code: warehouse_code
            }, {}, false);
            useLoader = true;

            if (getData.success) {
                let result = getData.result;
                if (result.exist) {
                    let uID = result.data.warehouse_id;
                    if (uID.toUpperCase() == $("#warehouse_id").val().toUpperCase()) {
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

        function checkName(warehouse_name) {
            let actUrl = base_url + '/webmin/warehouse/getbyname';
            useLoader = false;
            let getData = ajax_get(actUrl, {
                warehouse_name: warehouse_name
            }, {}, false);
            useLoader = true;

            if (getData.success) {
                let result = getData.result;
                if (result.exist) {
                    let uID = result.data.warehouse_id;
                    if (uID.toUpperCase() == $("#warehouse_id").val().toUpperCase()) {
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
            vwarehousecode: 'Kode gudang sudah terdaftar',
            vwarehousename: 'Nama gudang sudah terdaftar'
        });

        Parsley.setLocale('id');

        window.Parsley.addValidator("vwarehousecode", {
            validateString: function(value) {
                return checkCode(value)
            },
        });

        window.Parsley.addValidator("vwarehousename", {
            validateString: function(value) {
                return checkName(value)
            },
        });

        function addMode() {
            let form = $('#frmwarehouse');
            $('#title-frmwarehouse').html('Tambah Gudang');
            form.parsley().reset();
            formMode = 'add';
            $('#warehouse_id').val(0);
            $('#warehouse_code').val('');
            $('#warehouse_name').val('');
            $('#warehouse_address').val('');
            setSelect2('#store_id');
            $('#modal-warehouse').modal(configModal);
        }

        function editMode(data) {
            let form = $('#frmwarehouse');
            $('#title-frmwarehouse').html('Ubah Gudang');
            form.parsley().reset();
            formMode = 'edit';
            $('#warehouse_id').val(data.warehouse_id);
            $('#warehouse_code').val(htmlEntities.decode(data.warehouse_code));
            $('#warehouse_name').val(htmlEntities.decode(data.warehouse_name));
            $('#warehouse_address').val(htmlEntities.decode(data.warehouse_address));
            let store_text = htmlEntities.decode(data.store_code + ' - ' + data.store_name);
            setSelect2('#store_id', data.store_id, store_text);
            $('#modal-warehouse').modal(configModal);
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
                    $('#modal-warehouse').modal('hide');
                }
            })
        })


        $('#btnsave').click(function(e) {
            e.preventDefault();
            let form = $('#frmwarehouse');
            let btnSubmit = $('#btnsave')
            form.parsley().validate();
            if (form.parsley().isValid()) {
                let question = 'Yakin ingin menyimpan data gudang?';
                let actUrl = base_url + '/webmin/warehouse/save/add';
                if (formMode == 'edit') {
                    question = 'Yakin ingin memperbarui data gudang?';
                    actUrl = base_url + '/webmin/warehouse/save/edit';
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
                                        $('#modal-warehouse').modal('hide');
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

        $("#tblwarehouse").on('click', '.btnedit', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let actUrl = base_url + '/webmin/warehouse/getbyid/' + id;
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

        $("#tblwarehouse").on('click', '.btndelete', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let warehouse_code = $(this).attr('data-code');
            let warehouse_name = $(this).attr('data-name');
            let question = 'Yakin ingin menghapus gudang <b>' + warehouse_code + ' - ' + warehouse_name + '</b>?';
            let actUrl = base_url + '/webmin/warehouse/delete/' + id;
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