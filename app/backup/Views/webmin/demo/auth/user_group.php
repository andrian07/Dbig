<?php
$themeUrl = base_url('assets/adminlte3');
$assetsUrl = base_url('assets');
?>

<?= $this->extend('template/admin_template') ?>

<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Grup Pengguna</h1>
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
                        <table id="tblusergroup" class="table table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th data-priority="1">#</th>
                                    <th data-priority="2">Nama Grup</th>
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

            <div class="modal fade" id="modal-usergroup">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="title-frmusergroup"></h4>
                            <button type="button" class="close close-modal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="frmusergroup" class="form-horizontal">
                            <div class="modal-body">
                                <input id="group_code" name="group_code" value="" type="hidden">
                                <div class="form-group">
                                    <label for="group_name" class="col-sm-12">Nama Grup</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="group_name" name="group_name" placeholder="Nama Grup" value="" data-parsley-pattern="^[a-zA-Z0-9 ]+$" data-parsley-maxlength="100" data-parsley-vgroupname required>
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

            <div class="modal fade" id="modal-userroles">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="title-frmuserroles"></h4>
                            <button type="button" class="close close-modal-roles">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="frmuserroles" class="form-horizontal">
                            <div class="modal-body">
                                <table id="tblroles" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Module</th>
                                            <th>Hak Akses</th>
                                        </tr>
                                    </thead>
                                    <tbody id="user-roles">
                                        <?php
                                        foreach ($configRole as $mod_name => $mod_val) :
                                            $title = $mod_val['text'];
                                            $roles = [];
                                            foreach ($mod_val['roles'] as $role_name => $role_val) {
                                                $roles[] = [
                                                    'value' => $role_name,
                                                    'text' => $role_val['text']
                                                ];
                                            }
                                        ?>
                                            <tr>
                                                <td><?= esc($title) ?></td>
                                                <td>
                                                    <a id="<?= $mod_name ?>" data-pk="" class="config-module" data-type="checklist" data-value="" data-role="<?= esc(json_encode($roles)) ?>"></a>
                                                </td>
                                            </tr>
                                        <?php
                                        endforeach;
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button id="btncancel" class="btn btn-danger close-modal-roles"><i class="fas fa-times-circle"></i> Batal</button>
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
        $.fn.editable.defaults.mode = "inline";
        $.fn.editable.defaults.ajaxOptions = {
            type: "POST"
        };
        $.fn.editable.defaults.emptytext = 'Tidak memiliki akses';
        $.fn.editable.defaults.url = base_url + '/user-group/setgrouprole';
        $.fn.editable.defaults.showbuttons = "bottom";
        $.fn.editableform.buttons = '<button type="submit" class="editable-submit btn btn-sm btn-success"><i class="fas fa-save"></i> Simpan</button><button type="button" class="editable-cancel btn btn-sm btn-danger"><i class="fas fa-times-circle"></i> Batal</button>';

        function _initButton() {
            $('#btnadd').prop('disabled', !hasRole('user_group.add'));
            $('.btnedit').prop('disabled', !hasRole('user_group.edit'));
            $('.btndelete').prop('disabled', !hasRole('user_group.delete'));

            const gearOption = hasRole('user_group.edit') || hasRole('user_group.add');
            $('.btnsetup').prop('disabled', !gearOption);
        }

        // init xeditable //
        if ($('.config-module').length) {
            let module = $(".config-module");
            let nModule = module.length;
            for (i = 0; i < nModule; i++) {
                let mod_id = $(module[i]).prop("id");
                let mod_ds = $(module[i]).attr("data-role");
                $("#" + mod_id).editable({
                    source: JSON.parse(htmlEntities.decode(mod_ds)),
                    display: function(value, sourceData) {
                        let html = [],
                            checked = $.fn.editableutils.itemsByValue(value, sourceData);

                        if (checked.length) {
                            $.each(checked, function(i, v) {
                                html.push($.fn.editableutils.escape(v.text));
                            });
                            $(this).html(html.join(", "));
                        } else {
                            $(this).empty();
                        }
                    },
                    ajaxOptions: {
                        beforeSend: function(xhr) {
                            xhr.setRequestHeader('X-CSRF-TOKEN', csrfHash);
                        },
                    },
                    success: function(response, newValue) {
                        // Update csrfHash
                        let [json, is_json, error] = parseJSON(response);
                        if (is_json) {
                            if (typeof json.csrfHash == 'string') {
                                csrfHash = json.csrfHash;
                            };
                        }
                    },
                    error: function(x, status, error) {
                        if (x.status == 403) {
                            location.reload();
                        }
                    },
                });
            }
        }

        // datatables //
        let tblusergroup = $("#tblusergroup").DataTable({
            processing: true,
            select: true,
            serverSide: true,
            responsive: true,
            fixedColumns: true,
            language: {
                url: lang_datatables,
            },
            ajax: {
                url: base_url + '/table/user-group',
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
                    width: 150,
                    targets: 2
                },
                {
                    targets: [0, 2],
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
            tblusergroup.ajax.reload(null, false);
        }

        $('#btnreload').click(function(e) {
            e.preventDefault();
            updateTable();
        })

        // crud  //
        function checkGroupName(group_name) {
            let actUrl = base_url + '/user-group/getbyname';
            useLoader = false;
            let getGroup = ajax_get(actUrl, {
                group_name: group_name
            }, {}, false);
            useLoader = true;

            if (getGroup.success) {
                let result = getGroup.result;
                if (result.exist) {
                    let gCode = result.data.group_code;
                    if (gCode.toUpperCase() == $("#group_code").val().toUpperCase()) {
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
            vgroupname: 'Nama grup sudah terdaftar'
        });

        Parsley.setLocale('id');

        window.Parsley.addValidator("vgroupname", {
            validateString: function(value) {
                return checkGroupName(value)
            },
        });

        function addMode() {
            let form = $('#frmusergroup');
            $('#title-frmusergroup').html('Tambah Grup');
            form[0].reset();
            form.parsley().reset();
            formMode = 'add';
            $('#group_code').val('999');
            $('#group_name').val('');
            $('#modal-usergroup').modal(configModal);
        }

        function editMode(data) {
            let form = $('#frmusergroup');
            $('#title-frmusergroup').html('Ubah Grup');
            form[0].reset();
            form.parsley().reset();
            formMode = 'edit';
            console.log(data.group_code);
            console.log(data.group_name);
            $('#group_code').val(htmlEntities.decode(data.group_code));
            $('#group_name').val(htmlEntities.decode(data.group_name));
            $('#modal-usergroup').modal(configModal);
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
                    $('#modal-usergroup').modal('hide');
                }
            })
        })


        $('#btnsave').click(function(e) {
            e.preventDefault();
            let form = $('#frmusergroup');
            let btnSubmit = $('#btnsave')
            form.parsley().validate();
            if (form.parsley().isValid()) {
                let question = 'Yakin ingin menyimpan data grup?';
                let actUrl = base_url + '/user-group/save/add';
                if (formMode == 'edit') {
                    question = 'Yakin ingin memperbarui data grup?';
                    actUrl = base_url + '/user-group/save/edit';
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
                                        $('#modal-usergroup').modal('hide');
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

        $("#tblusergroup").on('click', '.btnedit', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let actUrl = base_url + '/user-group/getbycode/' + id;
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

        $("#tblusergroup").on('click', '.btndelete', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let group_name = $(this).attr('data-name');
            let question = 'Yakin ingin menghapus grup <b>' + group_name + '</b>?';
            let actUrl = base_url + '/user-group/delete/' + id;
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

        function configMode(data) {
            let form_title = 'Pengaturan - ' + data.group_name;
            $(".config-module").editable("setValue", null);
            $(".config-module").html("");
            $(".config-module").editable("option", "pk", data.group_code);
            $('#title-frmuserroles').html(form_title);

            let module_list = {};
            $.each(data.roles, function(key, val) {
                let mod_name = val.module_name;
                let role_name = val.role_name;
                let role_value = val.role_value;
                if (parseInt(role_value) > 0) {
                    if (typeof module_list[mod_name] == "undefined") {
                        module_list[mod_name] = {
                            role: [],
                        };
                    }
                    module_list[mod_name].role.push(role_name);
                }
            });

            $.each(module_list, function(key, val) {
                let html = [];
                let mod_ds = JSON.parse(
                    htmlEntities.decode($("#" + key).attr("data-role"))
                );

                $.each(mod_ds, function(i, e) {
                    let ds_value = e.value;
                    let ds_text = e.text;
                    if (val.role.indexOf(ds_value) != -1) {
                        html.push(ds_text);
                    }
                });

                $("#" + key).editable("setValue", val.role.join(","));
                $("#" + key).html(html.join(", "));
            });

            $('#modal-userroles').modal(configModal);
        }

        $("#tblusergroup").on('click', '.btnsetup', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let actUrl = base_url + '/user-group/getgrouprole/' + id;
            ajax_get(actUrl, null, {
                success: function(response) {
                    if (response.success) {
                        if (response.result.exist) {
                            configMode(response.result.data);
                        } else {
                            message.error(response.result.message);
                        }
                    }
                }
            })

        })

        $('.close-modal-roles').click(function(e) {
            e.preventDefault();
            message.question('Yakin ingin menutup halaman ini?').then(function(answer) {
                let yes = parseMessageResult(answer);
                if (yes) {
                    $('#modal-userroles').modal('hide');
                }
            })
        })

        _initButton();

    })
</script>
<?= $this->endSection() ?>