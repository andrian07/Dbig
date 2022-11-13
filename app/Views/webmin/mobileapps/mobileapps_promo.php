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
                <h1>Promo Mobile Apps</h1>
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
                        <table id="tblmobilepromo" class="table table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th data-priority="1">#</th>
                                    <th data-priority="2">Title</th>
                                    <th data-priority="3">Gambar</th>
                                    <th data-priority="4">Keterangan</th>
                                    <th data-priority="5">Tanggal Mulai</th>
                                    <th data-priority="6">Tanggal Akhir</th>
                                    <th data-priority="7">Status</th>
                                    <th data-priority="8">Aksi</th>
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
            <div class="modal fade" id="modal-addpromo">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="title-frmaddpromo"></h4>
                            <button type="button" class="close close-modal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="frmaddpromo" class="form-horizontal">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input id="mobile_promo_id " name="mobile_promo_id " value="0" type="hidden">
                                        <div class="form-group">
                                         <img id="mobile_promo_image" src="" width="100%" height="200px">
                                         <?php
                                         $allow_ext = [];
                                         foreach ($upload_file_type['image'] as $ext) {
                                            $allow_ext[] = '.' . $ext;
                                        }
                                        ?>
                                        <input type="file" name="upload_image" id="upload_image" accept="<?= implode(',', $allow_ext) ?>" hidden>
                                        <button id="btnupload" class="btn btn-primary btn-block mt-2"><i class="fas fa-cloud-upload-alt"></i> Unggah Gambar</button>
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile_promo_title" class="col-sm-12">Judul Promo</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="mobile_promo_title" name="mobile_promo_title" placeholder="Judul Promo" value="" data-parsley-maxlength="200" data-parsley-trigger-after-failure="focusout" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="mobile_promo_desc" class="col-sm-12">Keterangan</label>
                                        <div class="col-sm-12">
                                            <textarea class="form-control" id="mobile_promo_desc" name="mobile_promo_desc" placeholder="Keterangan" value="" data-parsley-trigger-after-failure="focusout" required></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="mobile_promo_start_date" class="col-sm-12">Tanggal Mulai Promo</label>
                                        <div class="col-sm-12">
                                            <input type="date" class="form-control" id="mobile_promo_start_date" name="mobile_promo_start_date"required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="mobile_promo_end_date" class="col-sm-12">Tanggal Akhir Promo</label>
                                        <div class="col-sm-12">
                                            <input type="date" class="form-control" id="mobile_promo_end_date" name="mobile_promo_end_date"required>
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
        $('#btnadd').prop('disabled', !hasRole('mobilepromo.add'));
        $('.btnedit').prop('disabled', !hasRole('mobilepromo.edit'));
        $('.btndelete').prop('disabled', !hasRole('mobilepromo.delete'));
    }
        
        
        // datatables //
    let tblmobilepromo = $("#tblmobilepromo").DataTable({
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
                url: base_url + '/webmin/mobileapps/tablepromo',
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
                targets: [0, 2, 3, 6],
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
        tblmobilepromo.ajax.reload(null, false);
    }

    $('#btnreload').click(function(e) {
        e.preventDefault();
        updateTable();
    })

    $('#btnupload').click(function(e) {
            e.preventDefault();
            $('#upload_image').click();
    })

     function addMode() {
        let form = $('#frmaddpromo');
        $('#title-frmaddpromo').html('Tambah Promo');
        formMode = 'add';
        clearUploadImage();
        $('#modal-addpromo').modal(configModal);
    }

    function editMode(data) {
        let form = $('#frmaddpromo');
        $('#title-frmaddpromo').html('Ubah Promo');
        formMode = 'edit';
        $('#banner_id').val(htmlEntities.decode(data.mobile_banner_id));
        $('#title_banner').val(htmlEntities.decode(data.mobile_banner_title));
        $('#active').val(htmlEntities.decode(data.active));
        const image_banner = '<?= base_url('contents/upload/banner') ?>/' + data.mobile_promo_image;
        $('#product_image').attr('src', image_banner);
        $('#modal-addpromo').modal(configModal);
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
                $('#modal-addpromo').modal('hide');
            }
        })
    })



    function clearUploadImage() {
        let file = $("#upload_image");
        file.wrap("<form>").closest("form").get(0).reset();
        file.unwrap();
        $('#mobile_promo_image').attr('src', noImage);
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
                let size = max_upload_size.kb;
                if (img_size > size) {
                    let message_text = 'Ukuran file maksimum ' + max_upload_size.mb + ' MB'
                    message.info(message_text);
                    file.value = "";
                } else {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        $("#mobile_promo_image").attr("src", e.target.result);
                    };
                    reader.readAsDataURL(file.files[0]);
                }
            }
        }
    }

    $("#upload_image").change(function() {
        readUploadImage(this);
    });


     $('#btnsave').click(function(e) {
            e.preventDefault();
            let form = $('#frmaddpromo');
            let btnSubmit = $('#btnsave')
            form.parsley().validate();
            if (form.parsley().isValid()) {
                let question = 'Yakin ingin menyimpan data Promo?';
                let actUrl = base_url + '/webmin/mobileapps/savepromo/add';
                
                if (formMode == 'edit') {
                    question = 'Yakin ingin memperbarui data Promo?';
                let actUrl = base_url + '/webmin/mobileapps/savepromo/edit';
                }

                message.question(question).then(function(answer) {
                    let yes = parseMessageResult(answer);
                    if (yes) {
                        let formValues = new FormData();
                        let file = $('#upload_image');
                        formValues.append('banner_id', $('#banner_id').val());
                        formValues.append('mobile_promo_title', $('#mobile_promo_title').val());
                        formValues.append('mobile_promo_desc', $('#mobile_promo_desc').val());
                        formValues.append('mobile_promo_start_date', $('#mobile_promo_start_date').val());
                        formValues.append('mobile_promo_end_date', $('#mobile_promo_end_date').val());
                        formValues.append('active', $('#active').val());
                        if (file[0].files[0] != undefined) {
                            formValues.append('upload_image', file[0].files[0]);
                        }
                       // formValues.append('old_product_image', $('#old_product_image').val());

                        btnSubmit.prop('disabled', true);
                        ajax_post(actUrl, formValues, {
                            success: function(response) {
                                if (response.success) {
                                    if (response.result.success) {
                                        notification.success(response.result.message);
                                        $('#modal-addpromo').modal('hide');
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

    $("#tblmobilepromo").on('click', '.btnedit', function(e) {
        e.preventDefault();
        let id = $(this).attr('data-id');
        let actUrl = base_url + '/webmin/mobileapps/getbyid/' + id;
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

    $("#tblmobilepromo").on('click', '.btndelete', function(e) {
        e.preventDefault();
        let id = $(this).attr('data-id');
        let promo_name = $(this).attr('data-name');
        let question = 'Yakin ingin menghapus Banner Promo <b>' + promo_name + '</b>?';
        let actUrl = base_url + '/webmin/mobileapps/deletepromo/' + id;
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