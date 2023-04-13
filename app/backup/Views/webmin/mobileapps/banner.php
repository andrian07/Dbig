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
                <h1>Banner Mobile Apps</h1>
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
                        <table id="tblmobilebanner" class="table table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th data-priority="1">#</th>
                                    <th data-priority="2">Title</th>
                                    <th data-priority="3">Gambar</th>
                                    <th data-priority="4">Status</th>
                                    <th data-priority="5">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->

            <!-- popup modal add -->
            <div class="modal fade" id="modal-addbanner">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="title-frmaddbanner"></h4>
                            <button type="button" class="close close-modal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <input id="banner_id" name="banner_id" value="0" type="hidden">
                                    <input id="old_banner_image" name="old_banner_image" value="" type="hidden">
                                    <div class="form-group">
                                        <img id="banner_image" src="" width="100%" height="200px">
                                        <?php
                                        $allow_ext = [];
                                        foreach ($upload_file_type['image'] as $ext) {
                                            $allow_ext[] = '.' . $ext;
                                        }
                                        ?>
                                        <input type="file" name="upload_image" id="upload_image" accept="<?= implode(',', $allow_ext) ?>" hidden>
                                        <button id="btnupload" class="btn btn-primary btn-block mt-2"><i class="fas fa-cloud-upload-alt"></i> Unggah Gambar</button>
                                    </div>
                                    <form id="frmaddbanner" class="form-horizontal">

                                        <div class="form-group">
                                            <label for="title_banner" class="col-sm-12">Judul Banner</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="title_banner" name="title_banner" placeholder="Judul Banner" value="" data-parsley-maxlength="200" data-parsley-trigger-after-failure="focusout" required>
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
                                    </form>

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button id="btncancel" class="btn btn-danger close-modal"><i class="fas fa-times-circle"></i> Batal</button>
                            <button id="btnsave" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
                        </div>

                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- end popup modal -->


        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    $(document).ready(function() {
        const noImage = '<?= base_url('assets/images/no-image.PNG') ?>';
        let formMode = '';

        function _initButton() {
            $('#btnadd').prop('disabled', !hasRole('mobilebanner.add'));
            $('.btnedit').prop('disabled', !hasRole('mobilebanner.edit'));
            $('.btndelete').prop('disabled', !hasRole('mobilebanner.delete'));
        }


        // datatables //
        let tblmobilebanner = $("#tblmobilebanner").DataTable({
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
                url: base_url + '/webmin/mobileapps/banner/table',
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
                    targets: 4
                },
                {
                    targets: [2, 4],
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
            tblmobilebanner.ajax.reload(null, false);
        }

        $('#btnreload').click(function(e) {
            e.preventDefault();
            updateTable();
        })

        function clearUploadImage() {
            let file = $("#upload_image");
            file.wrap("<form>").closest("form").get(0).reset();
            file.unwrap();
            $('#banner_image').attr('src', noImage);
        }

        function readUploadImage(file) {
            if (file.files && file.files[0]) {
                let img_name = file.files[0].name;
                let img_ext = img_name.split(".").pop().toLowerCase();
                let ext = upload_file_type.image;

                if (jQuery.inArray(img_ext, ext) == -1) {
                    let message_text = 'File wajib berekstensi ' + ext.join(", ");
                    message.info(message_text);
                    file.value = "";
                } else {
                    let img_size = file.files[0].size;
                    let size = max_upload_size.b;
                    if (img_size > size) {
                        let message_text = 'Ukuran file maksimum ' + max_upload_size.mb + ' MB'
                        message.info(message_text);
                        file.value = "";
                    } else {
                        let reader = new FileReader();
                        reader.onload = function(e) {
                            $("#banner_image").attr("src", e.target.result);
                        };
                        reader.readAsDataURL(file.files[0]);
                    }
                }
            }
        }

        $('#btnupload').click(function(e) {
            e.preventDefault();
            $('#upload_image').click();
        })

        function addMode() {
            let form = $('#frmaddbanner');
            form.parsley().reset();
            $('#title-frmaddbanner').html('Tambah Banner');
            $('#old_banner_image').val('');
            $('#banner_id').val('0');
            $('#title_banner').val('');
            $('#active').val('Y');
            formMode = 'add';
            clearUploadImage();
            $('#modal-addbanner').modal(configModal);
        }

        function editMode(data) {
            let form = $('#frmaddbanner');
            form.parsley().reset();
            $('#title-frmaddbanner').html('Ubah Promo Banner');
            formMode = 'edit';
            $('#banner_id').val(htmlEntities.decode(data.mobile_banner_id));
            $('#title_banner').val(htmlEntities.decode(data.mobile_banner_title));
            $('#active').val(htmlEntities.decode(data.active));
            $('#old_banner_image').val(data.mobile_banner_image);
            clearUploadImage();
            $('#banner_image').attr('src', data.image_url);
            $('#modal-addbanner').modal(configModal);
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
                    $('#modal-addbanner').modal('hide');
                }
            })
        })





        $("#upload_image").change(function() {
            readUploadImage(this);
        });


        $('#btnsave').click(function(e) {
            e.preventDefault();
            let form = $('#frmaddbanner');
            let btnSubmit = $('#btnsave')
            form.parsley().validate();
            if (form.parsley().isValid()) {
                let question = 'Yakin ingin menyimpan data Banner?';
                let actUrl = base_url + '/webmin/mobileapps/banner/save/add';

                if (formMode == 'edit') {
                    question = 'Yakin ingin memperbarui data Banner?';
                    actUrl = base_url + '/webmin/mobileapps/banner/save/edit';
                }

                message.question(question).then(function(answer) {
                    let yes = parseMessageResult(answer);
                    if (yes) {
                        let formValues = new FormData();
                        let file = $('#upload_image');

                        formValues.append('banner_id', $('#banner_id').val());
                        formValues.append('title_banner', $('#title_banner').val());
                        formValues.append('active', $('#active').val());
                        if (file[0].files[0] != undefined) {
                            formValues.append('upload_image', file[0].files[0]);
                        }

                        formValues.append('old_banner_image', $('#old_banner_image').val());

                        btnSubmit.prop('disabled', true);
                        ajax_post(actUrl, formValues, {
                            success: function(response) {
                                if (response.success) {
                                    if (response.result.success) {
                                        notification.success(response.result.message);
                                        $('#modal-addbanner').modal('hide');
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
                        }, true, true);
                    }
                })

            }
        })

        $("#tblmobilebanner").on('click', '.btnedit', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let actUrl = base_url + '/webmin/mobileapps/banner/getbyid/' + id;
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

        $("#tblmobilebanner").on('click', '.btndelete', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let banner_name = $(this).attr('data-name');
            let question = 'Yakin ingin menghapus Banner Promo <b>' + banner_name + '</b>?';
            let actUrl = base_url + '/webmin/mobileapps/banner/delete/' + id;
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