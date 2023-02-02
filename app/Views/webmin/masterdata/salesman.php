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
                <h1>Salesman</h1>
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
                        <table id="tblsalesman" class="table table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th data-priority="1">#</th>
                                    <th data-priority="2">Kode Salesman</th>
                                    <th data-priority="4">Nama Salesman</th>
                                    <th data-priority="5">Alamat</th>
                                    <th data-priority="6">No Telp</th>
                                    <th data-priority="7">Cabang</th>
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

            <div class="modal fade" id="modal-salesman">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="title-frmsalesman"></h4>
                            <button type="button" class="close close-modal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="frmsalesman" class="form-horizontal">
                            <div class="modal-body">
                                <input type="hidden" name="salesman_id" id="salesman_id">
                                <div class="form-group">
                                    <label for="salesman_code" class="col-sm-12">Kode Salesman</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="salesman_code" name="salesman_code" placeholder="Kode Salesman" value="" data-parsley-maxlength="10" data-parsley-trigger-after-failure="focusout" data-parsley-vsalesmancode required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="salesman_name" class="col-sm-12">Nama Salesman</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="salesman_name" name="salesman_name" placeholder="Nama Salesman" value="" data-parsley-maxlength="200" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="salesman_address" class="col-sm-12">Alamat</label>
                                    <div class="col-sm-12">
                                        <textarea id="salesman_address" name="salesman_address" class="form-control" placeholder="Alamat" data-parsley-maxlength="500" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="salesman_phone" class="col-sm-12">No Telp</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="salesman_phone" name="salesman_phone" placeholder="No Telp" value="" data-parsley-minlength="8" data-parsley-maxlength="15" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="store_id" class="col-sm-12">Cabang</label>
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
            $('#btnadd').prop('disabled', !hasRole('salesman.add'));
            $('.btnedit').prop('disabled', !hasRole('salesman.edit'));
            $('.btndelete').prop('disabled', !hasRole('salesman.delete'));
        }

        // select2 //
        $("#store_id").select2({
            placeholder: '-- Pilih Area --',
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
        let tblsalesman = $("#tblsalesman").DataTable({
            processing: true,
            select: true,
            serverSide: true,
            responsive: true,
            fixedColumns: true,
            order: [
                [0, 'desc']
            ],
            language: {
                url: lang_datatables,
            },
            ajax: {
                url: base_url + '/webmin/salesman/table',
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
                    targets: 6
                },
                {
                    targets: [6],
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
            tblsalesman.ajax.reload(null, false);
        }

        $('#btnreload').click(function(e) {
            e.preventDefault();
            updateTable();
        })

        // crud  //
        function checkCode(salesman_code) {
            let actUrl = base_url + '/webmin/salesman/getbycode';
            useLoader = false;
            let getData = ajax_get(actUrl, {
                salesman_code: salesman_code
            }, {}, false);
            useLoader = true;

            if (getData.success) {
                let result = getData.result;
                if (result.exist) {
                    let uID = result.data.salesman_id;
                    if (uID.toUpperCase() == $("#salesman_id").val().toUpperCase()) {
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
            vsalesmancode: 'Kode salesman sudah terdaftar',
        });

        Parsley.setLocale('id');

        window.Parsley.addValidator("vsalesmancode", {
            validateString: function(value) {
                return checkCode(value)
            },
        });

        function addMode() {
            let form = $('#frmsalesman');
            $('#title-frmsalesman').html('Tambah Salesman');
            form.parsley().reset();
            formMode = 'add';
            $('#salesman_id').val(0);
            $('#salesman_code').val('');
            $('#salesman_name').val('');
            $('#salesman_address').val('');
            $('#salesman_phone').val('');
            setSelect2('#store_id');
            $('#modal-salesman').modal(configModal);
        }

        function editMode(data) {
            let form = $('#frmsalesman');
            $('#title-frmsalesman').html('Ubah Salesman');
            form.parsley().reset();
            formMode = 'edit';
            $('#salesman_id').val(data.salesman_id);
            $('#salesman_code').val(htmlEntities.decode(data.salesman_code));
            $('#salesman_name').val(htmlEntities.decode(data.salesman_name));
            $('#salesman_address').val(htmlEntities.decode(data.salesman_address));
            $('#salesman_phone').val(htmlEntities.decode(data.salesman_phone));

            let store_text = htmlEntities.decode(data.store_code + ' - ' + data.store_name);
            setSelect2('#store_id', data.store_id, store_text);
            $('#modal-salesman').modal(configModal);
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
                    $('#modal-salesman').modal('hide');
                }
            })
        })


        $('#btnsave').click(function(e) {
            e.preventDefault();
            let form = $('#frmsalesman');
            let btnSubmit = $('#btnsave')
            form.parsley().validate();
            if (form.parsley().isValid()) {
                let question = 'Yakin ingin menyimpan data salesman?';
                let actUrl = base_url + '/webmin/salesman/save/add';
                if (formMode == 'edit') {
                    question = 'Yakin ingin memperbarui data salesman?';
                    actUrl = base_url + '/webmin/salesman/save/edit';
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
                                        notification.success(response.result.message);
                                        form.parsley().reset();
                                        $('#modal-salesman').modal('hide');
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

        $("#tblsalesman").on('click', '.btnedit', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let actUrl = base_url + '/webmin/salesman/getbyid/' + id;
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

        $("#tblsalesman").on('click', '.btndelete', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let salesman_code = $(this).attr('data-code');
            let salesman_name = $(this).attr('data-name');
            let question = 'Yakin ingin menghapus salesman <b>' + salesman_code + ' - ' + salesman_name + '</b>?';
            let actUrl = base_url + '/webmin/salesman/delete/' + id;
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