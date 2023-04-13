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
                <h1>Hadiah Poin</h1>
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
                        <table id="tblpointreward" class="table table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th data-priority="1">#</th>
                                    <th data-priority="2">Kode Item</th>
                                    <th data-priority="4">Nama Item</th>
                                    <th data-priority="5">Point</th>
                                    <th data-priority="7">Dari Tgl</th>
                                    <th data-priority="8">Sampai Tgl</th>
                                    <th data-priority="6">Stok</th>
                                    <th data-priority="9">Aktif</th>
                                    <th data-priority="10">Gambar Produk</th>
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

            <div class="modal fade" id="modal-reward">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="title-frmreward"></h4>
                            <button type="button" class="close close-modal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <img id="reward_image" src="<?= base_url('assets/images/no-image.PNG') ?>" width="100%" height="200px">
                                    <?php
                                    $allow_ext = [];
                                    foreach ($upload_file_type['image'] as $ext) {
                                        $allow_ext[] = '.' . $ext;
                                    }
                                    ?>
                                    <input type="hidden" name="old_reward_image" id="old_reward_image" value="">
                                    <input type="file" name="upload_image" id="upload_image" accept="<?= implode(',', $allow_ext) ?>" hidden>
                                    <button id="btnupload" class="btn btn-primary btn-block mt-2"><i class="fas fa-cloud-upload-alt"></i> Unggah Gambar</button>

                                </div>
                                <div class="col-md-9">
                                    <form id="frmreward" class="form-horizontal">
                                        <input id="reward_id" name="reward_id" value="0" type="hidden">

                                        <div class="form-group">
                                            <label for="reward_code" class="col-sm-12">Kode Hadiah</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="reward_code" name="reward_code" placeholder="Kode Hadiah" value="" data-parsley-maxlength="8" readonly required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="reward_name" class="col-sm-12">Nama Hadiah</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="reward_name" name="reward_name" placeholder="Nama Hadiah" value="" data-parsley-maxlength="200" required>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="reward_point" class="col-sm-12">Poin</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="reward_point" name="reward_point" placeholder="Poin" value="" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="start_date" class="col-sm-12">Dari Tgl</label>
                                            <div class="col-sm-12">
                                                <input type="date" class="form-control" id="start_date" name="start_date" placeholder="Dari Tgl" value="" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="end_date" class="col-sm-12">Sampai Tgl</label>
                                            <div class="col-sm-12">
                                                <input type="date" class="form-control" id="end_date" name="end_date" placeholder="Sampai Tgl" value="" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="reward_stock" class="col-sm-12">Stok</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="reward_stock" name="reward_stock" placeholder="Stok" value="" required>
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

                                        <div class="form-group">
                                            <label for="reward_description" class="col-sm-12">Deskripsi</label>
                                            <div class="col-sm-12">
                                                <textarea id="reward_description" name="reward_description" class="form-control" rows="10"></textarea>
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
        const noImage = '<?= base_url('assets/images/no-image.PNG') ?>';
        let reward_point = new AutoNumeric('#reward_point', configQty);
        let reward_stock = new AutoNumeric('#reward_stock', configQty);

        function _initButton() {
            $('#btnadd').prop('disabled', !hasRole('point_reward.add'));
            $('.btnedit').prop('disabled', !hasRole('point_reward.edit'));
            $('.btndelete').prop('disabled', !hasRole('point_reward.delete'));
        }

        // datatables //
        let tblpointreward = $("#tblpointreward").DataTable({
            processing: true,
            select: true,
            serverSide: true,
            responsive: true,
            fixedColumns: true,
            order: [
                [1, 'desc']
            ],
            language: {
                url: lang_datatables,
            },
            ajax: {
                url: base_url + '/webmin/point-reward/table',
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
                    targets: 9
                },
                {
                    targets: [0, 9],
                    orderable: false,
                    searchable: false,
                },
                {
                    targets: [7, 8],
                    className: "text-center",
                },
                {
                    targets: [0, 6, 3],
                    className: "text-right",
                },
            ],
        });

        function updateTable() {
            tblpointreward.ajax.reload(null, false);
        }

        $('#btnreload').click(function(e) {
            e.preventDefault();
            updateTable();
        })

        function clearUploadImage() {
            let file = $("#upload_image");
            file.wrap("<form>").closest("form").get(0).reset();
            file.unwrap();
            $('#reward_image').attr('src', noImage);
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
                            $("#reward_image").attr("src", e.target.result);
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


        $("#upload_image").change(function() {
            readUploadImage(this);
        });

        function addMode() {
            let form = $('#frmreward');
            $('#title-frmreward').html('Tambah Hadiah');
            form.parsley().reset();
            formMode = 'add';
            $('#reward_id').val('0');
            $('#reward_code').val('AUTO');
            $('#reward_name').val('');
            $('#active').val('Y');
            $('#start_date').val('');
            $('#end_date').val('');
            $('#reward_description').val('');
            $('#old_reward_image').val('');
            reward_point.set(0);
            reward_stock.set(0);
            clearUploadImage();
            $('#modal-reward').modal(configModal);
        }

        function editMode(data) {
            let form = $('#frmreward');
            $('#title-frmreward').html('Ubah Hadiah');
            form.parsley().reset();
            formMode = 'edit';
            clearUploadImage();
            $('#reward_id').val(data.reward_id);
            $('#reward_code').val(data.reward_code);
            $('#reward_name').val(htmlEntities.decode(data.reward_name));
            $('#active').val(data.active);
            $('#start_date').val(data.start_date);
            $('#end_date').val(data.end_date);
            $('#reward_description').val(htmlEntities.decode(data.reward_description));
            $('#old_reward_image').val(htmlEntities.decode(data.reward_image));
            reward_point.set(parseFloat(data.reward_point));
            reward_stock.set(parseFloat(data.reward_stock));
            $('#reward_image').attr('src', data.image_url);
            $('#modal-reward').modal(configModal);
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
                    $('#modal-reward').modal('hide');
                }
            })
        })

        $('#btnsave').click(function(e) {
            e.preventDefault();
            let form = $('#frmreward');
            let btnSubmit = $('#btnsave')
            form.parsley().validate();
            if (form.parsley().isValid()) {
                let question = 'Yakin ingin menyimpan data hadiah?';
                let actUrl = base_url + '/webmin/point-reward/save/add';
                if (formMode == 'edit') {
                    question = 'Yakin ingin memperbarui data hadiah?';
                    actUrl = base_url + '/webmin/point-reward/save/edit';
                }

                message.question(question).then(function(answer) {
                    let yes = parseMessageResult(answer);
                    if (yes) {
                        let formValues = new FormData();
                        let file = $('#upload_image');
                        formValues.append('reward_id', $('#reward_id').val());
                        formValues.append('reward_code', $('#reward_code').val());
                        formValues.append('reward_name', $('#reward_name').val());
                        formValues.append('start_date', $('#start_date').val());
                        formValues.append('end_date', $('#end_date').val());
                        formValues.append('reward_description', $('#reward_description').val());
                        formValues.append('active', $('#active').val());
                        formValues.append('reward_point', parseFloat(reward_point.getNumericString()));
                        formValues.append('reward_stock', parseFloat(reward_stock.getNumericString()));

                        if (file[0].files[0] != undefined) {
                            formValues.append('upload_image', file[0].files[0]);
                        }
                        formValues.append('old_reward_image', $('#old_reward_image').val());

                        btnSubmit.prop('disabled', true);
                        ajax_post(actUrl, formValues, {
                            success: function(response) {
                                if (response.success) {
                                    if (response.result.success) {
                                        form[0].reset();
                                        notification.success(response.result.message);
                                        form.parsley().reset();
                                        $('#modal-reward').modal('hide');
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


        $("#tblpointreward").on('click', '.btnedit', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let actUrl = base_url + '/webmin/point-reward/getbyid/' + id;
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


        $("#tblpointreward").on('click', '.btndelete', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let mCode = $(this).attr('data-code');
            let mName = $(this).attr('data-name');
            let question = 'Yakin ingin menghapus hadiah <b>' + mCode + ' - ' + mName + '</b>?';
            let actUrl = base_url + '/webmin/point-reward/delete/' + id;
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