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
                <h1>Akun Pengguna</h1>
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
                    </div>
                    <div class="card-body">
                        <table id="tbluseraccount" class="table table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th data-priority="1">#</th>
                                    <th data-priority="2">Username</th>
                                    <th data-priority="4">Nama Pengguna</th>
                                    <th data-priority="5">Toko</th>
                                    <th data-priority="6">Grup Pengguna</th>
                                    <th data-priority="7">Status</th>
                                    <th data-priority="3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>robby88</td>
                                    <td>Robby</td>
                                    <td>PUSAT</td>
                                    <td>Admin</td>
                                    <td>
                                        <span class="badge badge-success">Aktif</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-default btnaddfingerprint mb-2" data-toggle="tooltip" data-placement="top" data-title="Tambah Fingerprint"><i class="fas fa-fingerprint"></i></button>&nbsp;
                                        <button class="btn btn-sm btn-default btnresetpassword mb-2" data-toggle="tooltip" data-placement="top" data-title="Reset Kata Sandi"><i class="fas fa-key"></i></button>
                                        <br>
                                        <button class="btn btn-sm btn-warning btnedit" data-toggle="tooltip" data-placement="top" data-title="Edit"><i class="fas fa-edit"></i></button>&nbsp;
                                        <button class="btn btn-sm btn-danger btndelete" data-toggle="tooltip" data-placement="top" data-title="Hapus"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>

                                <tr>
                                    <td>2</td>
                                    <td>ani8899</td>
                                    <td>Ani</td>
                                    <td>PUSAT</td>
                                    <td>Kasir</td>
                                    <td>
                                        <span class="badge badge-danger">Tidak Aktif</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-default btnaddfingerprint mb-2" data-toggle="tooltip" data-placement="top" data-title="Tambah Fingerprint"><i class="fas fa-fingerprint"></i></button>&nbsp;
                                        <button class="btn btn-sm btn-default btnresetpassword mb-2" data-toggle="tooltip" data-placement="top" data-title="Reset Kata Sandi"><i class="fas fa-key"></i></button>
                                        <br>
                                        <button class="btn btn-sm btn-warning btnedit" data-toggle="tooltip" data-placement="top" data-title="Edit"><i class="fas fa-edit"></i></button>&nbsp;
                                        <button class="btn btn-sm btn-danger btndelete" data-toggle="tooltip" data-placement="top" data-title="Hapus"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>

                                <tr>
                                    <td>3</td>
                                    <td>budi2022</td>
                                    <td>Budi</td>
                                    <td>PUSAT</td>
                                    <td>Supervisor</td>
                                    <td>
                                        <span class="badge badge-success">Aktif</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-default btnaddfingerprint mb-2" data-toggle="tooltip" data-placement="top" data-title="Tambah Fingerprint"><i class="fas fa-fingerprint"></i></button>&nbsp;
                                        <button class="btn btn-sm btn-default btnresetpassword mb-2" data-toggle="tooltip" data-placement="top" data-title="Reset Kata Sandi"><i class="fas fa-key"></i></button>
                                        <br>
                                        <button class="btn btn-sm btn-warning btnedit" data-toggle="tooltip" data-placement="top" data-title="Edit"><i class="fas fa-edit"></i></button>&nbsp;
                                        <button class="btn btn-sm btn-danger btndelete" data-toggle="tooltip" data-placement="top" data-title="Hapus"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>

                                <tr>
                                    <td>4</td>
                                    <td>joko</td>
                                    <td>Joko</td>
                                    <td>CABANG KOTA BARU</td>
                                    <td>Admin</td>
                                    <td>
                                        <span class="badge badge-success">Aktif</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-default btnaddfingerprint mb-2" data-toggle="tooltip" data-placement="top" data-title="Tambah Fingerprint"><i class="fas fa-fingerprint"></i></button>&nbsp;
                                        <button class="btn btn-sm btn-default btnresetpassword mb-2" data-toggle="tooltip" data-placement="top" data-title="Reset Kata Sandi"><i class="fas fa-key"></i></button>
                                        <br>
                                        <button class="btn btn-sm btn-warning btnedit" data-toggle="tooltip" data-placement="top" data-title="Edit"><i class="fas fa-edit"></i></button>&nbsp;
                                        <button class="btn btn-sm btn-danger btndelete" data-toggle="tooltip" data-placement="top" data-title="Hapus"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>

                                <tr>
                                    <td>5</td>
                                    <td>reni2022</td>
                                    <td>Reni</td>
                                    <td>CABANG KOTA BARU</td>
                                    <td>Supervisor</td>
                                    <td>
                                        <span class="badge badge-success">Aktif</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-default btnaddfingerprint mb-2" data-toggle="tooltip" data-placement="top" data-title="Tambah Fingerprint"><i class="fas fa-fingerprint"></i></button>&nbsp;
                                        <button class="btn btn-sm btn-default btnresetpassword mb-2" data-toggle="tooltip" data-placement="top" data-title="Reset Kata Sandi"><i class="fas fa-key"></i></button>
                                        <br>
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

            <div class="modal fade" id="modal-useraccount">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="title-frmuseraccount"></h4>
                            <button type="button" class="close close-modal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="frmuseraccount" class="form-horizontal">
                            <div class="modal-body">
                                <input id="user_code" name="user_code" value="" type="hidden">
                                <div class="form-group">
                                    <label for="user_name" class="col-sm-12">Username</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Username" value="" data-parsley-pattern="^[a-zA-Z0-9]+$" data-parsley-minlength="5" data-parsley-maxlength="25" data-parsley-vusername required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="user_realname" class="col-sm-12">Nama Pengguna</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="user_realname" name="user_realname" placeholder="Nama Pengguna" value="" data-parsley-pattern="^[a-zA-Z ]+$" data-parsley-maxlength="200" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="user_password" class="col-sm-12" id="label_password">Password</label>
                                    <div class="col-sm-12">
                                        <input type="password" class="form-control" id="user_password" name="user_password" placeholder="Password" value="" data-parsley-pattern="^[a-zA-Z0-9]+$" data-parsley-minlength="8" data-parsley-maxlength="100" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="confirm_password" class="col-sm-12">Ulangi Password</label>
                                    <div class="col-sm-12">
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Ulangi Password" data-parsley-equalto="#user_password" value="" data-parsley-pattern="^[a-zA-Z0-9]+$" data-parsley-minlength="8" data-parsley-maxlength="100" required>
                                    </div>
                                </div>

                                <div class="form-check">
                                    <div class="col-sm-12">
                                        <input type="checkbox" class="form-check-input" id="show_password" name="show_password">
                                        <label class="form-check-label" for="show_password">Tampilkan Password</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="user_group" class="col-sm-12">Grup Pengguna</label>
                                    <div class="col-sm-12 sel2">
                                        <select class="form-control" id="user_group" name="user_group" required>
                                            <option value="1" selected>Admin</option>
                                            <option value="2">Kasir</option>
                                            <option value="3">Supervisor</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="store_id" class="col-sm-12">Toko</label>
                                    <div class="col-sm-12">
                                        <select id="store_id" name="store_id" class="form-control">
                                            <option value="1">UTM - UTAMA</option>
                                            <option value="2">KBR - CABANG KOTA BARU</option>
                                        </select>
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
        $("#user_group").select2();

        // datatables //
        let tbluseraccount = $("#tbluseraccount").DataTable({
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
                    width: 100,
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

        function showPassword(option) {
            if (option) {
                $('#user_password').prop("type", "text");
                $('#confirm_password').prop("type", "text");
            } else {
                $('#user_password').prop("type", "password");
                $('#confirm_password').prop("type", "password");
            }
        }

        $('#show_password').change(function(e) {
            let opt = $(this).prop('checked');
            showPassword(opt);
        })

        function addMode() {
            let form = $('#frmuseraccount');
            $('#title-frmuseraccount').html('Tambah Pengguna');
            form[0].reset();
            form.parsley().reset();
            formMode = 'add';
            $('#user_code').val('9999');
            $('#user_name').val('').prop('readonly', false);
            let label_password = 'Password';
            $('#label_password').html(label_password);
            $('#user_password').prop('placeholder', label_password).prop('required', true);
            $('#confirm_password').prop('required', true);
            $('#store_id').val('1');
            $('#active').val('Y');

            $('#show_password').prop('checked', false);
            showPassword(false);
            $('#active').val('Y');
            $('#modal-useraccount').modal(configModal);
        }

        function editMode(data) {
            let form = $('#frmuseraccount');
            $('#title-frmuseraccount').html('Ubah Pengguna');
            form[0].reset();
            form.parsley().reset();
            formMode = 'edit';
            $('#user_code').val('');
            $('#user_name').val('robby88').prop('readonly', true);
            $('#user_realname').val('Robby');
            let label_password = 'Password Baru';
            $('#label_password').html(label_password);
            $('#user_password').prop('placeholder', label_password).prop('required', false);
            $('#confirm_password').prop('required', false);
            $('#store_id').val('1');
            $('#active').val('Y');

            $('#show_password').prop('checked', false);
            showPassword(false);

            $('#modal-useraccount').modal(configModal);

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
            let form = $('#frmuseraccount');
            let btnSubmit = $('#btnsave')
            form.parsley().validate();
            if (form.parsley().isValid()) {
                let question = 'Yakin ingin menyimpan data pengguna?';
                let actUrl = base_url + '/user-account/save/add';
                if (formMode == 'edit') {
                    question = 'Yakin ingin memperbarui data pengguna?';
                    actUrl = base_url + '/user-account/save/edit';
                }

                message.question(question).then(function(answer) {
                    let yes = parseMessageResult(answer);
                    if (yes) {
                        notification.success('Akun pengguna berhasil disimpan');
                        $('#modal-useraccount').modal('hide');
                    }

                })

            }
        })

        // crud section //
        $("#tbluseraccount").on('click', '.btnedit', function(e) {
            e.preventDefault();
            editMode({
                a: 1
            });

        })

        $("#tbluseraccount").on('click', '.btndelete', function(e) {
            e.preventDefault();
            let question = 'Yakin ingin menghapus pengguna <b>robby88</b>?';
            message.question(question).then(function(answer) {
                let yes = parseMessageResult(answer);
                if (yes) {
                    notification.success('Akun <b>robby88</b> berhasil dihapus');
                }
            })
        })

        $('#tbluseraccount').on('click', '.btnaddfingerprint', function(e) {
            e.preventDefault();
            message.success('Coming Soon');
        })

        $("#tbluseraccount").on('click', '.btnresetpassword', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let customer_name = $(this).attr('data-name');
            let question = 'Yakin ingin melakukan reset password <b>robby88</b>?';
            let actUrl = base_url + '/customer/delete/' + id;
            message.question(question).then(function(answer) {
                let yes = parseMessageResult(answer);
                if (yes) {
                    message.success('Password <b>robby88</b> adalah <b>1AS4562SA</b>');
                }
            })
        })


        $('.close-modal').click(function(e) {
            e.preventDefault();
            message.question('Yakin ingin menutup halaman ini?').then(function(answer) {
                let yes = parseMessageResult(answer);
                if (yes) {
                    $('#modal-useraccount').modal('hide');
                }
            })
        })

    })
</script>
<?= $this->endSection() ?>