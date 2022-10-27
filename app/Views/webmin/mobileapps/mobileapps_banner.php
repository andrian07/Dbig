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
                        <form id="frmaddbanner" class="form-horizontal">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input id="product_id" name="product_id" value="0" type="hidden">

                                        <div class="form-group">
                                             <img id="image_product" src="<?= base_url('assets/images/no-image.PNG') ?>" width="100%" height="200px">
                                             <button class="btn btn-primary btn-block mt-2"><i class="fas fa-cloud-upload-alt"></i> Unggah Gambar</button>
                                        </div>
                                        <div class="form-group">
                                            <label for="product_name" class="col-sm-12">Judul Banner</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="title_banner" name="title_banner" placeholder="Judul Banner" value="" data-parsley-maxlength="200" data-parsley-trigger-after-failure="focusout" data-parsley-vproductname required>
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
        let formMode = '';


        
        function _initButton() {
            $('#btnadd').prop('disabled', !hasRole('category.add'));
            $('.btnedit').prop('disabled', !hasRole('category.edit'));
            $('.btndelete').prop('disabled', !hasRole('category.delete'));
        }
        
        
        // datatables //
        let tblmobilebanner = $("#tblmobilebanner").DataTable({
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
                url: base_url + '/webmin/mobileapps/table',
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
            tblmobilebanner.ajax.reload(null, false);
        }

        $('#btnreload').click(function(e) {
            e.preventDefault();
            updateTable();
        })

        function addMode() {
            let form = $('#frmaddbanner');
            $('#title-frmaddbanner').html('Tambah Banner');
            formMode = 'add';
            $('#modal-addbanner').modal(configModal);
        }

        function editMode(data) {
            let form = $('#frmaddbanner');
            $('#title-frmaddbanner').html('Ubah Kategori');
            formMode = 'edit';
            $('#category_id').val(htmlEntities.decode(data.category_id));
            $('#title_banner').val(htmlEntities.decode(data.title_banner));
            $('#active').val(htmlEntities.decode(data.active));
            $('#modal-category').modal(configModal);
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


        $('#btnsave').click(function(e) {
            e.preventDefault();
            let form = $('#frmcategory');
            let btnSubmit = $('#btnsave')
            form.parsley().validate();
            if (form.parsley().isValid()) {
                let question = 'Yakin ingin menyimpan data kategori?';
                let actUrl = base_url + '/webmin/category/save/add';
                if (formMode == 'edit') {
                    question = 'Yakin ingin memperbarui data kategori?';
                    actUrl = base_url + '/webmin/category/save/edit';
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
                                        $('#modal-category').modal('hide');
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

        $("#tblmobilebanner").on('click', '.btnedit', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let actUrl = base_url + '/webmin/category/getbyid/' + id;
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
            let category_name = $(this).attr('data-name');
            let question = 'Yakin ingin menghapus kategori <b>' + category_name + '</b>?';
            let actUrl = base_url + '/webmin/category/delete/' + id;
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