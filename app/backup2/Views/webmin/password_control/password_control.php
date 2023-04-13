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
                <h1>Password Control</h1>
            </div>
            <div class="col-sm-6">

            </div>
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
                        <button class="btn btn-default" onclick="window.location.href='<?= base_url('webmin/password-control/logs') ?>'"><i class="fas fa-list"></i> Logs</button>
                    </div>
                    <div class="card-body">
                        <table id="tblpasswordcontrol" class="table table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th data-priority="1">#</th>
                                    <th data-priority="2">Username</th>
                                    <th data-priority="4">Nama Pengguna</th>
                                    <th data-priority="4">Toko</th>
                                    <th data-priority="5">Grup Pengguna</th>
                                    <th data-priority="6">Status</th>
                                    <th data-priority="3">Aksi</th>
                                </tr>

                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>budi2022</td>
                                    <td>Budi</td>
                                    <td>PUSAT</td>
                                    <td>Supervisor</td>
                                    <td>
                                        <span class="badge badge-success">Aktif</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-default btnlogs"><i class="fas fa-list"></i></button>&nbsp;
                                        <button class="btn btn-sm btn-warning btnedit" data-toggle="tooltip" data-placement="top" data-title="Edit"><i class="fas fa-edit"></i></button>&nbsp;
                                        <button class="btn btn-sm btn-danger btndelete" data-toggle="tooltip" data-placement="top" data-title="Hapus"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>reni2022</td>
                                    <td>Reni</td>
                                    <td>CABANG KOTA BARU</td>
                                    <td>Supervisor</td>
                                    <td>
                                        <span class="badge badge-success">Aktif</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-default btnlogs"><i class="fas fa-list"></i></button>&nbsp;
                                        <button class="btn btn-sm btn-warning btnedit" data-toggle="tooltip" data-placement="top" data-title="Edit"><i class="fas fa-edit"></i></button>&nbsp;
                                        <button class="btn btn-sm btn-danger btndelete" data-toggle="tooltip" data-placement="top" data-title="Hapus"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->

            <div class="modal fade" id="modal-passwordcontrol">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="title-frmpasswordcontrol"></h4>
                            <button type="button" class="close close-modal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="frmpasswordcontrol" class="form-horizontal">
                            <div class="modal-body">
                                <input id="password_control_id" name="password_control_id" value="" type="hidden">

                                <div class="form-group">
                                    <label for="user_id" class="col-sm-12">Toko</label>
                                    <div class="col-sm-12 sel2">
                                        <select class="form-control" id="store_id" name="store_id" data-parsley-trigger-after-failure="focusout" data-parsley-vstoreid required>
                                            <option value="1">UTM - UTAMA</option>
                                            <option value="2">KBR - CABANG KOTA BARU</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="user_id" class="col-sm-12">User</label>
                                    <div class="col-sm-12 sel2">
                                        <select class="form-control" id="user_id" name="user_id" data-parsley-trigger-after-failure="focusout" data-parsley-vuserid required></select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="active" class="col-sm-12">Status</label>
                                    <div class="col-sm-12">
                                        <select id="active" name="active" class="form-control">
                                            <option value="Y" selected>Aktif</option>
                                            <option value="N">Tidak Aktif</option>
                                        </select>
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
        // datatables //
        let tblpasswordcontrol = $("#tblpasswordcontrol").DataTable({
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
                url: base_url + '/webmin/password-control/table',
                type: "POST",
                error: function() {
                    notification.danger('Gagal memuat table, harap coba lagi');
                },
            },
            drawCallback: function(settings) {
                _initTooltip();
                //_initButton();
            },
            columnDefs: [{
                    width: 120,
                    targets: 6
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
                {
                    targets: [5],
                    className: "text-center",
                },
            ],
        });

        function updateTable() {
            tblpasswordcontrol.ajax.reload(null, false);
        }

        $('#btnreload').click(function(e) {
            e.preventDefault();
            updateTable();
        })

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

        $("#user_id").select2({
            placeholder: '-- Pilih User --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/user-account",
                dataType: "json",
                type: "GET",
                delay: select2Delay,
                data: function(params) {
                    let store_id = $('#store_id').val();
                    return {
                        store_id: store_id,
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

        function addMode() {
            let form = $('#frmpasswordcontrol');
            $('#title-frmpasswordcontrol').html('Tambah Akun');
            form.parsley().reset();
            formMode = 'add';
            $('#password_control_id').val('0');
            setSelect2('#store_id');
            $('#store_id').prop('disabled', false);
            setSelect2('#user_id');
            $('#user_id').prop('disabled', false);
            $('#active').val('Y');
            $('#modal-passwordcontrol').modal(configModal);
        }

        function editMode(data) {
            let form = $('#frmpasswordcontrol');
            $('#title-frmpasswordcontrol').html('Ubah Akun');
            form.parsley().reset();
            formMode = 'edit';
            $('#password_control_id').val(data.password_control_id);

            let store_text = data.store_code + ' - ' + data.store_name;
            let user_text = data.user_name + ' - ' + data.user_realname;
            setSelect2('#store_id', data.store_id, store_text);
            $('#store_id').prop('disabled', true);
            setSelect2('#user_id', data.user_id, user_text);
            $('#user_id').prop('disabled', true);

            $('#active').val(data.active);
            $('#modal-passwordcontrol').modal(configModal);
        }

        $('#btnadd').click(function(e) {
            e.preventDefault();
            addMode();
        })

        $('#btnsave').click(function(e) {
            e.preventDefault();

            let form = $('#frmpasswordcontrol');
            let btnSubmit = $('#btnsave')
            form.parsley().validate();
            if (form.parsley().isValid()) {
                let question = 'Yakin ingin menyimpan data akun?';
                let actUrl = base_url + '/webmin/password-control/save/add';
                if (formMode == 'edit') {
                    question = 'Yakin ingin memperbarui data akun?';
                    actUrl = base_url + '/webmin/password-control/save/edit';
                }

                message.question(question).then(function(answer) {
                    let yes = parseMessageResult(answer);
                    if (yes) {
                        let formValues = {
                            password_control_id: $('#password_control_id').val(),
                            store_id: $('#store_id').val(),
                            user_id: $('#user_id').val(),
                            active: $('#active').val()
                        }
                        btnSubmit.prop('disabled', true);
                        ajax_post(actUrl, formValues, {
                            success: function(response) {
                                if (response.success) {
                                    if (response.result.success) {
                                        form[0].reset();
                                        notification.success(response.result.message);
                                        form.parsley().reset();
                                        $('#modal-passwordcontrol').modal('hide');
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

        // crud section //
        $("#tblpasswordcontrol").on('click', '.btnlogs', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let actUrl = base_url + '/webmin/password-control/logs/' + id;
            window.location.href = actUrl;
        })

        $("#tblpasswordcontrol").on('click', '.btnedit', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let actUrl = base_url + '/webmin/password-control/getbyid/' + id;
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

        $("#tblpasswordcontrol").on('click', '.btndelete', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let user_name = $(this).attr('data-name');
            let question = 'Yakin ingin menghapus akses user <b>' + user_name + '</b>?';
            let actUrl = base_url + '/webmin/password-control/delete/' + id;
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

        $('.close-modal').click(function(e) {
            e.preventDefault();
            message.question('Yakin ingin menutup halaman ini?').then(function(answer) {
                let yes = parseMessageResult(answer);
                if (yes) {
                    $('#modal-passwordcontrol').modal('hide');
                }
            })
        })
    })
</script>
<?= $this->endSection() ?>