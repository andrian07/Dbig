<?php
$themeUrl = base_url('assets/adminlte3');
$assetsUrl = base_url('assets');
?>

<?= $this->extend('webmin/template/admin_template') ?>
<?= $this->section('css') ?>
<link rel="stylesheet" href="<?= $assetsUrl ?>/plugins/fingerprint/fingerprint.css">
<?= $this->endSection() ?>

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
                            <tbody></tbody>
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
                                        <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Username" value="" data-parsley-pattern="^[a-zA-Z0-9]+$" data-parsley-minlength="5" data-parsley-maxlength="25" data-parsley-trigger-after-failure="focusout" data-parsley-vusername required>
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
                                        <select class="form-control" id="user_group" name="user_group" required></select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="store_id" class="col-sm-12">Toko</label>
                                    <div class="col-sm-12 sel2">
                                        <select class="form-control" id="store_id" name="store_id" required></select>
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

            <div class="modal fade" id="modal-addfingerprint">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="title-frmaddfingerprint">Tambah Fingerprint</h4>
                            <button type="button" class="close close-modal-addfingerprint">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="frmaddfingerprint" class="form-horizontal">
                            <div class="modal-body">
                                <input id="fp_user_code" name="fp_user_code" value="" type="hidden">
                                <div class="form-group">
                                    <label for="fp_user_name" class="col-sm-12">Username</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="fp_user_name" name="fp_user_name" placeholder="Username" value="" readonly>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="fp_user_realname" class="col-sm-12">Nama Pengguna</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="fp_user_realname" name="fp_user_realname" placeholder="Nama Pengguna" readonly>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="user_group" class="col-sm-12">Fingerprint Reader</label>
                                    <div class="col-sm-12 sel2">
                                        <select class="form-control" id="fp_reader" name="fp_reader" required>
                                            <option value="0" disabled>-- Pilih Fingerprint Reader --</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="fp_indexfinger" class="col-sm-12">Index Finger</label>
                                    <div class="col-12">
                                        <div class="row">
                                            <div id="fp_indexfinger1" class="col-3 text-center"><span class="icon icon-indexfinger-not-enrolled" title="not_enrolled"></span></div>
                                            <div id="fp_indexfinger2" class="col-3 text-center"><span class="icon icon-indexfinger-not-enrolled" title="not_enrolled"></span></div>
                                            <div id="fp_indexfinger3" class="col-3 text-center"><span class="icon icon-indexfinger-not-enrolled" title="not_enrolled"></span></div>
                                            <div id="fp_indexfinger4" class="col-3 text-center"><span class="icon icon-indexfinger-not-enrolled" title="not_enrolled"></span></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="fp_middlefinger" class="col-sm-12">Middle Finger</label>
                                    <div class="col-12">
                                        <div class="row">
                                            <div id="fp_middlefinger1" class="col-3 text-center"><span class="icon icon-middlefinger-not-enrolled" title="not_enrolled"></span></div>
                                            <div id="fp_middlefinger2" class="col-3 text-center"><span class="icon icon-middlefinger-not-enrolled" title="not_enrolled"></span></div>
                                            <div id="fp_middlefinger3" class="col-3 text-center"><span class="icon icon-middlefinger-not-enrolled" title="not_enrolled"></span></div>
                                            <div id="fp_middlefinger4" class="col-3 text-center"><span class="icon icon-middlefinger-not-enrolled" title="not_enrolled"></span></div>
                                        </div>
                                    </div>
                                </div>




                            </div>
                            <div class="modal-footer justify-content-between">
                                <button id="" class="btn btn-danger close-modal-addfingerprint"><i class="fas fa-times-circle"></i> Batal</button>
                                <button id="btncapture" class="btn btn-warning"><i class="fas fa-fingerprint"></i> Mulai Capture</button>
                                <button id="btnsave_fingerprint" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
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
        let formMode;


        function _initButton() {

            $('#btnadd').prop('disabled', !hasRole('user_account.add'));
            $('.btnresetpassword').prop('disabled', !hasRole('user_account.reset_password'));
            $('.btnaddfingerprint').prop('disabled', !hasRole('user_account.add_fingerprint'));
            $('.btnedit').prop('disabled', !hasRole('user_account.edit'));
            $('.btndelete').prop('disabled', !hasRole('user_account.delete'));
        };

        $("#user_group").select2({
            placeholder: '-- Pilih Grup --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/user-group",
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
        let tbluseraccount = $("#tbluseraccount").DataTable({
            select: true,
            serverSide: true,
            responsive: true,
            fixedColumns: true,
            language: {
                url: lang_datatables,
            },
            ajax: {
                url: base_url + '/webmin/user/user-account/table',
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
            tbluseraccount.ajax.reload(null, false);
        }

        $('#btnreload').click(function(e) {
            e.preventDefault();
            updateTable();
        })


        function checkUsername(user_name) {
            let actUrl = base_url + '/webmin/user/user-account/getbyname';
            useLoader = false;
            let getUser = ajax_get(actUrl, {
                user_name: user_name
            }, {}, false);
            useLoader = true;

            if (getUser.success) {
                let result = getUser.result;
                if (result.exist) {
                    let uCode = result.data.user_code;
                    if (uCode.toUpperCase() == $("#user_code").val().toUpperCase()) {
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
            vusername: 'Username sudah terdaftar'
        });

        Parsley.setLocale('id');

        window.Parsley.addValidator("vusername", {
            validateString: function(value) {
                return checkUsername(value)
            },
        });

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
            form.parsley().reset();
            formMode = 'add';
            $('#user_code').val('0');
            $('#user_name').val('').prop('readonly', false);
            $('#user_realname').val('');
            let label_password = 'Password';
            $('#label_password').html(label_password);
            $('#user_password').prop('placeholder', label_password).prop('required', true);
            $('#confirm_password').prop('required', true);
            setSelect2('#user_group');
            setSelect2('#store_id');
            $('#show_password').prop('checked', false);
            showPassword(false);
            $('#active').val('Y');
            $('#modal-useraccount').modal(configModal);
        }

        function editMode(data) {
            let form = $('#frmuseraccount');
            $('#title-frmuseraccount').html('Ubah Pengguna');
            form.parsley().reset();
            formMode = 'edit';
            $('#user_code').val(htmlEntities.decode(data.user_code));
            $('#user_name').val(htmlEntities.decode(data.user_name)).prop('readonly', true);
            $('#user_realname').val(htmlEntities.decode(data.user_realname));
            let label_password = 'Password Baru';
            $('#label_password').html(label_password);
            $('#user_password').prop('placeholder', label_password).prop('required', false);
            $('#confirm_password').prop('required', false);
            let group_code = htmlEntities.decode(data.user_group);
            let group_name = htmlEntities.decode(data.group_name);
            setSelect2('#user_group', group_code, group_name);

            let store_id = htmlEntities.decode(data.store_id);
            let store_name = htmlEntities.decode(data.store_code + ' - ' + data.store_name);
            setSelect2('#store_id', store_id, store_name);
            $('#active').val(htmlEntities.decode(data.active));

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

        // crud section //
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
                let actUrl = base_url + '/webmin/user/user-account/save/add';
                if (formMode == 'edit') {
                    question = 'Yakin ingin memperbarui data pengguna?';
                    actUrl = base_url + '/webmin/user/user-account/save/edit';
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
                                        $('#modal-useraccount').modal('hide');
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

        $("#tbluseraccount").on('click', '.btnedit', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let actUrl = base_url + '/webmin/user/user-account/getbycode/' + id;
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

        $("#tbluseraccount").on('click', '.btndelete', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let realname = $(this).attr('data-realname');
            let question = 'Yakin ingin menghapus pengguna <b>' + realname + '</b>?';
            let actUrl = base_url + '/webmin/user/user-account/delete/' + id;
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

        $("#tbluseraccount").on('click', '.btnresetpassword', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let realname = $(this).attr('data-realname');
            let question = 'Yakin ingin mereset password pengguna <b>' + realname + '</b>?';
            let actUrl = base_url + '/webmin/user/user-account/reset-password/' + id;
            message.question(question).then(function(answer) {
                let yes = parseMessageResult(answer);
                if (yes) {
                    ajax_get(actUrl, null, {
                        success: function(response) {
                            if (response.success) {
                                if (response.result.success) {
                                    let info_text = 'password pengguna <b>' + realname + '</b> berhasil direset menjadi <b>' + response.result.new_password + '</b>';
                                    message.info(info_text);
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
                    $('#modal-useraccount').modal('hide');
                }
            })
        })

        // fingerprint //
        $('#tbluseraccount').on('click', '.btnaddfingerprint', function(e) {
            e.preventDefault();
            $('#modal-addfingerprint').modal(configModal);
        })

        $('.close-modal-addfingerprint').click(function(e) {
            e.preventDefault();
            message.question('Yakin ingin menutup halaman ini?').then(function(answer) {
                let yes = parseMessageResult(answer);
                if (yes) {
                    $('#modal-addfingerprint').modal('hide');
                }
            })
        })

    })
</script>
<?= $this->endSection() ?>