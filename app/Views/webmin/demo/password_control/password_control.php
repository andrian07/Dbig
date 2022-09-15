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

        $('#user_id').select2({
            data: [{
                    id: '1',
                    text: 'Ani'
                },
                {
                    id: '2',
                    text: 'Joko'
                },
                {
                    id: '3',
                    text: 'Budi'
                },

            ]
        })

        // datatables //
        let tblpasswordcontrol = $("#tblpasswordcontrol").DataTable({
            select: true,
            responsive: true,
            fixedColumns: true,
            language: {
                url: lang_datatables,
            },
            drawCallback: function(settings) {
                _initTooltip();
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

        $('#btnreload').click(function(e) {
            e.preventDefault();
        })

        function addMode() {
            let form = $('#frmpasswordcontrol');
            $('#title-frmpasswordcontrol').html('Tambah Akun');
            form[0].reset();
            form.parsley().reset();
            formMode = 'add';
            $('#password_control_id').val('0');
            $('#store_id').val('1').prop('disabled', false);
            $('#user_id').val('1').prop('disabled', false);
            $('#active').val('Y');
            $('#modal-passwordcontrol').modal(configModal);
        }

        function editMode(data) {
            let form = $('#frmpasswordcontrol');
            $('#title-frmpasswordcontrol').html('Ubah Akun');
            form.parsley().reset();
            formMode = 'add';
            $('#password_control_id').val('0');
            $('#store_id').val('1').prop('disabled', true);
            $('#user_id').val('1').prop('disabled', true);
            $('#active').val('Y');
            $('#modal-passwordcontrol').modal(configModal);

        }

        $('#user_password').change(function() {
            let val = $(this).val();
            if (formMode == 'edit') {
                if (!(val == '')) {
                    $('#confirm_password').prop('required', true);
                } else {
                    $('#confirm_password').prop('required', false);
                }
            }
        })

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
                let question = 'Yakin ingin menyimpan data pengguna?';
                let actUrl = base_url + '/password-control/save/add';
                if (formMode == 'edit') {
                    question = 'Yakin ingin memperbarui data pengguna?';
                    actUrl = base_url + '/password-control/save/edit';
                }

                message.question(question).then(function(answer) {
                    let yes = parseMessageResult(answer);
                    if (yes) {
                        let formValues = {
                            password_control_id: $('#password_control_id').val(),
                            user_id: $('#user_id').val(),
                            password_control: $('#user_password').val(),
                            active: $('#active').val()
                        };
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
            let actUrl = base_url + '/webmin/password-control/logs';
            window.location.href = actUrl;
        })

        $("#tblpasswordcontrol").on('click', '.btnedit', function(e) {
            e.preventDefault();
            editMode({
                a: 1
            });
        })

        $("#tblpasswordcontrol").on('click', '.btndelete', function(e) {
            e.preventDefault();
            let question = 'Yakin ingin menghapus akses pengguna <b>Budi</b>?';
            message.question(question).then(function(answer) {
                let yes = parseMessageResult(answer);
                if (yes) {
                    notification.success('Akses pengguna <b>Budi</b> berhasil dihapus');
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