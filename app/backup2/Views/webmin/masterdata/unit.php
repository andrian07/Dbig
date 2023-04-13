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
                <h1>Satuan</h1>
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
                        <table id="tblunit" class="table table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th data-priority="1">#</th>
                                    <th data-priority="2">Nama Satuan</th>
                                    <th data-priority="4">Deskripsi</th>
                                    <th data-priority="3">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->

            <div class="modal fade" id="modal-unit">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="title-frmunit"></h4>
                            <button type="button" class="close close-modal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="frmunit" class="form-horizontal">
                            <div class="modal-body">
                                <input id="unit_id" name="unit_id" value="" type="hidden">
                                <div class="form-group">
                                    <label for="unit_name" class="col-sm-12">Nama Satuan</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="unit_name" name="unit_name" placeholder="Nama Satuan" value="" data-parsley-maxlength="200" data-parsley-trigger-after-failure="focusout" data-parsley-vunitname required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="unit_description" class="col-sm-12">Deskripsi</label>
                                    <div class="col-sm-12">
                                        <textarea id="unit_description" name="unit_description" class="form-control" placeholder="Deskripsi" data-parsley-maxlength="500" rows="3"></textarea>
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
            $('#btnadd').prop('disabled', !hasRole('unit.add'));
            $('.btnedit').prop('disabled', !hasRole('unit.edit'));
            $('.btndelete').prop('disabled', !hasRole('unit.delete'));
        }



        // datatables //
        let tblunit = $("#tblunit").DataTable({
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
                url: base_url + '/webmin/unit/table',
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
                    targets: 3
                },
                {
                    targets: [0, 3],
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
            tblunit.ajax.reload(null, false);
        }

        $('#btnreload').click(function(e) {
            e.preventDefault();
            updateTable();
        })

        // crud  //
        function checkName(unit_name) {
            let actUrl = base_url + '/webmin/unit/getbyname';
            useLoader = false;
            let getData = ajax_get(actUrl, {
                unit_name: unit_name
            }, {}, false);
            useLoader = true;

            if (getData.success) {
                let result = getData.result;
                if (result.exist) {
                    let uCode = result.data.unit_id;
                    if (uCode.toUpperCase() == $("#unit_id").val().toUpperCase()) {
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
            vunitname: 'Nama satuan sudah terdaftar'
        });

        Parsley.setLocale('id');

        window.Parsley.addValidator("vunitname", {
            validateString: function(value) {
                return checkName(value)
            },
        });

        function addMode() {
            let form = $('#frmunit');
            $('#title-frmunit').html('Tambah Satuan');
            form[0].reset();
            form.parsley().reset();
            formMode = 'add';
            $('#unit_id').val('0');
            $('#unit_name').val('');
            $('#unit_description').val('');
            $('#modal-unit').modal(configModal);
        }

        function editMode(data) {
            let form = $('#frmunit');
            $('#title-frmunit').html('Ubah Satuan');
            form[0].reset();
            form.parsley().reset();
            formMode = 'edit';
            $('#unit_id').val(htmlEntities.decode(data.unit_id));
            $('#unit_name').val(htmlEntities.decode(data.unit_name));
            $('#unit_description').val(htmlEntities.decode(data.unit_description));
            $('#modal-unit').modal(configModal);
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
                    $('#modal-unit').modal('hide');
                }
            })
        })


        $('#btnsave').click(function(e) {
            e.preventDefault();
            let form = $('#frmunit');
            let btnSubmit = $('#btnsave')
            form.parsley().validate();
            if (form.parsley().isValid()) {
                let question = 'Yakin ingin menyimpan data satuan?';
                let actUrl = base_url + '/webmin/unit/save/add';
                if (formMode == 'edit') {
                    question = 'Yakin ingin memperbarui data satuan?';
                    actUrl = base_url + '/webmin/unit/save/edit';
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
                                        $('#modal-unit').modal('hide');
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

        $("#tblunit").on('click', '.btnedit', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let actUrl = base_url + '/webmin/unit/getbyid/' + id;
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

        $("#tblunit").on('click', '.btndelete', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let unit_name = $(this).attr('data-name');
            let question = 'Yakin ingin menghapus satuan <b>' + unit_name + '</b>?';
            let actUrl = base_url + '/webmin/unit/delete/' + id;
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