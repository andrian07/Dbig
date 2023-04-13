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
                <h1>Voucher</h1>
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
            <div id="list_voucher" class="col-md-12">
                <div class="card">
                    <div class="card-header p-2">
                        <button id="btnadd" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah</button>
                        <button id="btnreload" class="btn btn-secondary"><i class="fas fa-sync"></i> Reload</button>
                    </div>
                    <div class="card-body">

                        <table id="tblvoucher" class="table table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th data-priority="1">#</th>
                                    <th data-priority="2">Nama Voucher</th>
                                    <th data-priority="4">Keterangan</th>
                                    <th data-priority="5">Nominal Voucher</th>
                                    <th data-priority="6">Jlh. Voucher</th>
                                    <th data-priority="7">Exp. Date</th>
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

            <div id="input_voucher" class="col-md-12">
                <div class="card">
                    <div class="card-header p-2">
                        <h4>Pengaturan Voucher</h4>
                    </div>
                    <div class="card-body">
                        <table width="100%" class="border-primary border-bottom mb-3">
                            <tr>
                                <th width="15%">Nama Voucher</th>
                                <td width="1%">:</td>
                                <td width="84%" id="manage_voucher_name"></td>
                            </tr>
                            <tr>
                                <th>Nominal Voucher</th>
                                <td>:</td>
                                <td id="manage_voucher_value"></td>
                            </tr>
                            <tr>
                                <th>Keterangan Voucher</th>
                                <td>:</td>
                                <td id="manage_voucher_remark"></td>
                            </tr>
                            <tr>
                                <th>Exp.Date</th>
                                <td>:</td>
                                <td id="manage_voucher_exp_date"></td>
                            </tr>
                        </table>

                        <form id="frmgenerate" class="mb-2">
                            <div class="row">
                                <div class="col-md-2">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Jumlah Voucher</label>
                                        <input id="voucher_count" name="voucher_count" type="text" class="form-control" value="0" placeholder="Jumlah Voucher" required>
                                    </div>
                                </div>
                                <div class="col-md-3 ">
                                    <!-- text input -->
                                    <label>&nbsp;</label>
                                    <div class="form-group">
                                        <div class="col-12">
                                            <button id="btngenerate" class="btn btn-md btn-primary"><i class="fas fa-plus"></i> Generate Voucher</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <table id="tblmanagevoucher" class="table table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th data-priority="1">#</th>
                                    <th data-priority="2">Kode Voucher</th>
                                    <th data-priority="4">Status</th>
                                    <th data-priority="5">Digunakan Pada</th>
                                    <th data-priority="6">Oleh Customer</th>
                                    <th data-priority="3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <!-- /.tab-content -->


                        <div class="justify-content-between mt-2">
                            <button class="btn btn-danger close-manage-voucher"><i class="fas fa-arrow-circle-left"></i> Kembali</button>

                        </div>
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>

            <div class="modal fade" id="modal-voucher">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="title-frmvoucher"></h4>
                            <button type="button" class="close close-modal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <form id="frmvoucher" class="form-horizontal">
                                        <input type="hidden" id="voucher_group_id" name="voucher_group_id" value="0">
                                        <input type="hidden" id="old_cover_image" name="old_cover_image" value="">
                                        <input type="hidden" id="old_backcover_image" name="old_backcover_image" value="">
                                        <div class="form-group">
                                            <label for="voucher_name" class="col-sm-12">Nama Voucher</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="voucher_name" name="voucher_name" placeholder="Nama Voucher" value="" data-parsley-maxlength="200" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="voucher_value" class="col-sm-12">Nilai Voucher</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="voucher_value" name="voucher_value" placeholder="Nilai Voucher" value="" data-parsley-vvouchervalue required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="voucher_remark" class="col-sm-12">Keterangan</label>
                                            <div class="col-sm-12">
                                                <textarea id="voucher_remark" name="voucher_remark" class="form-control" placeholder="Keterangan" data-parsley-maxlength="500" rows="3" required></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="category_restriction" class="col-sm-12">Filter Kategori</label>
                                            <div class="col-sm-12 sel2">
                                                <select id="category_restriction" name="category_restriction[]" class="form-control" multiple="multiple"></select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="brand_restriction" class="col-sm-12">Filter Brand</label>
                                            <div class="col-sm-12 sel2">
                                                <select id="brand_restriction" name="brand_restriction[]" class="form-control" multiple="multiple"></select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="exp_date" class="col-sm-12">Exp. Date</label>
                                            <div class="col-sm-12">
                                                <input type="date" class="form-control" id="exp_date" name="exp_date" placeholder="Exp. Date" value="" required>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <?php
                                    $defaultImage = base_url('assets/images/no-image.PNG');
                                    $allow_ext = [];
                                    foreach ($upload_file_type['image'] as $ext) {
                                        $allow_ext[] = '.' . $ext;
                                    }
                                    ?>
                                    <div class="mb-3 border">
                                        <p class="text-center"><b>Cover Voucher</b></p>
                                        <img id="preview_image_cover" src="<?= $defaultImage ?>" width="100%" height="200px">

                                        <input type="file" name="upload_image_cover" id="upload_image_cover" accept="<?= implode(',', $allow_ext) ?>" hidden>
                                        <button id="btnuploadcover" class="btn btn-primary btn-block mt-0"><i class="fas fa-cloud-upload-alt"></i> Unggah Gambar</button>
                                    </div>

                                    <div class="mb-3 border">
                                        <p class="text-center"><b>Back Cover Voucher</b></p>
                                        <img id="preview_image_backcover" src="<?= $defaultImage ?>" width="100%" height="200px">
                                        <input type="file" name="upload_image_backcover" id="upload_image_backcover" accept="<?= implode(',', $allow_ext) ?>" hidden>
                                        <button id="btnuploadbackcover" class="btn btn-primary btn-block mt-0"><i class="fas fa-cloud-upload-alt"></i> Unggah Gambar</button>

                                    </div>



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
        const default_date = '<?= date('Y-m-d') ?>';
        const default_image = '<?= $defaultImage ?>';

        let formMode = '';
        let manage_voucher_group_id = 0;

        function _initButton() {
            $('#btnadd').prop('disabled', !hasRole('voucher.add'));

            if (!hasRole('voucher.edit')) {
                $('.btnedit').prop('disabled', true);
            }

            if (!hasRole('voucher.delete')) {
                $('.btndelete').prop('disabled', true);
            }


            $('#btngenerate').prop('disabled', !hasRole('voucher.generate_voucher'));

            if (hasRole('voucher.generate_voucher') == false && hasRole('voucher.delete') == false) {
                $('.btnmanagevoucher').prop('disabled', true);
            }
        }

        let voucher_value = new AutoNumeric('#voucher_value', configRp);
        let voucher_count = new AutoNumeric('#voucher_count', configQty);


        function showInput(x) {
            if (x) {
                $('#list_voucher').hide();
                $('#input_voucher').show();
            } else {
                $('#list_voucher').show();
                $('#input_voucher').hide();
            }
        }

        Parsley.addMessages('id', {
            vvouchervalue: 'Nominal voucher wajib diisi'
        });

        Parsley.setLocale('id');

        window.Parsley.addValidator("vvouchervalue", {
            validateString: function(value) {
                if (parseFloat(voucher_value.getNumericString()) > 0) {
                    return true;
                } else {
                    return false;
                }
            },
        });

        // datatables //
        let tblvoucher = $("#tblvoucher").DataTable({
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
                url: base_url + '/webmin/voucher/table',
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
                    targets: [4, 6],
                    orderable: false,
                    searchable: false,
                },
                {
                    targets: [0, 3, 4],
                    className: "text-right",
                },
            ],
        });

        function updateTable() {
            tblvoucher.ajax.reload(null, false);
        }

        $('#btnreload').click(function(e) {
            e.preventDefault();
            updateTable();
        })

        let tblmanagevoucher = $("#tblmanagevoucher").DataTable({
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
                url: base_url + '/webmin/voucher/table-voucher',
                type: "POST",
                data: function(d) {
                    return $.extend({}, d, {
                        'voucher_group_id': manage_voucher_group_id,
                    });
                },
                error: function() {
                    notification.danger('Gagal memuat table, harap coba lagi');
                },
            },
            drawCallback: function(settings) {
                _initTooltip();
                _initButton();
            },
            columnDefs: [{
                    width: 50,
                    targets: 5
                },
                {
                    targets: [5],
                    orderable: false,
                    searchable: false,
                },
                {
                    targets: [0],
                    className: "text-right",
                },
            ],
        });

        function updateTableVoucher() {
            tblmanagevoucher.ajax.reload(null, false);
        }

        $("#category_restriction").select2({
            placeholder: '-- Pilih Kategori --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/category",
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

        $("#brand_restriction").select2({
            placeholder: '-- Pilih Brand --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/brand",
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


        function clearUploadCover() {
            let file = $("#upload_image_cover");
            file.wrap("<form>").closest("form").get(0).reset();
            file.unwrap();
            $('#preview_image_cover').attr('src', default_image);
        }

        function clearUploadBackCover() {
            let file = $("#upload_image_backcover");
            file.wrap("<form>").closest("form").get(0).reset();
            file.unwrap();
            $('#preview_image_backcover').attr('src', default_image);
        }


        function readUploadImageCover(file) {
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
                            $("#preview_image_cover").attr("src", e.target.result);
                        };
                        reader.readAsDataURL(file.files[0]);
                    }
                }
            }
        }

        $("#upload_image_cover").change(function() {
            readUploadImageCover(this);
        });

        $('#btnuploadcover').click(function(e) {
            e.preventDefault();
            $("#upload_image_cover").trigger('click');
        })


        function readUploadImageBackCover(file) {
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
                            $("#preview_image_backcover").attr("src", e.target.result);
                        };
                        reader.readAsDataURL(file.files[0]);
                    }
                }
            }
        }

        $("#upload_image_backcover").change(function() {
            readUploadImageBackCover(this);
        });

        $('#btnuploadbackcover').click(function(e) {
            e.preventDefault();
            $("#upload_image_backcover").trigger('click');
        })



        function addMode() {
            let form = $('#frmvoucher');
            $('#title-frmvoucher').html('Tambah Voucher');
            form.parsley().reset();
            formMode = 'add';
            $('#voucher_group_id').val('0');
            $('#voucher_name').val('');
            voucher_value.set(0);
            $('#voucher_remark').val('');
            setSelect2('#category_restriction');
            setSelect2('#brand_restriction');
            $('#exp_date').val(default_date);

            clearUploadCover();
            clearUploadBackCover();
            $('#old_cover_image').val('');
            $('#old_backcover_image').val('');

            $('#modal-voucher').modal(configModal);
        }

        function editMode(res) {
            let data = res.data;
            let category_restriction = res.category_restriction;
            let brand_restriction = res.brand_restriction;

            let form = $('#frmvoucher');
            $('#title-frmvoucher').html('Ubah Voucher');
            form.parsley().reset();
            formMode = 'edit';
            $('#voucher_group_id').val(htmlEntities.decode(data.voucher_group_id));
            $('#voucher_name').val(htmlEntities.decode(data.voucher_name));
            voucher_value.set(parseFloat(data.voucher_value));
            $('#voucher_remark').val(htmlEntities.decode(data.voucher_remark));

            if (category_restriction.length > 0) {
                let selectCategoryId = Array();
                category_restriction.forEach(function(val, i) {
                    selectCategoryId.push({
                        'id': val.category_id,
                        'label': val.category_name
                    });
                })
                setSelect2('#category_restriction', selectCategoryId);
            } else {
                setSelect2('#category_restriction');
            }

            if (brand_restriction.length > 0) {
                let selectBrandId = Array();
                brand_restriction.forEach(function(val, i) {
                    selectBrandId.push({
                        'id': val.brand_id,
                        'label': val.brand_name
                    });
                })
                setSelect2('#brand_restriction', selectBrandId);
            } else {
                setSelect2('#brand_restriction');
            }
            clearUploadCover();
            clearUploadBackCover();
            $('#preview_image_cover').attr('src', data.voucher_image_cover_url);
            $('#preview_image_backcover').attr('src', data.voucher_image_backcover_url);
            $('#old_cover_image').val(data.voucher_image_cover);
            $('#old_backcover_image').val(data.voucher_image_backcover);



            $('#exp_date').val(htmlEntities.decode(data.exp_date));
            $('#modal-voucher').modal(configModal);
        }

        $('#voucher_value').on('change blur', function(e) {
            let val = voucher_value.getNumericString();
            if (val == '' || val == null) {
                voucher_value.set(0);
            }
        });

        $('#btnadd').click(function(e) {
            e.preventDefault();
            addMode();
        })

        $('.close-modal').click(function(e) {
            e.preventDefault();
            message.question('Yakin ingin menutup halaman ini?').then(function(answer) {
                let yes = parseMessageResult(answer);
                if (yes) {
                    $('#modal-voucher').modal('hide');
                }
            })
        })

        $('#btnsave').click(function(e) {
            e.preventDefault();
            let form = $('#frmvoucher');
            let btnSubmit = $('#btnsave')
            form.parsley().validate();
            if (form.parsley().isValid()) {
                let question = 'Yakin ingin menyimpan data voucher?';
                let actUrl = base_url + '/webmin/voucher/save/add';
                if (formMode == 'edit') {
                    question = 'Yakin ingin memperbarui data voucher?';
                    actUrl = base_url + '/webmin/voucher/save/edit';
                }

                message.question(question).then(function(answer) {
                    let yes = parseMessageResult(answer);
                    if (yes) {
                        let fileCover = $('#upload_image_cover');
                        let fileBackCover = $('#upload_image_backcover');

                        let formValues = new FormData();
                        formValues.append('voucher_group_id', $('#voucher_group_id').val());
                        formValues.append('voucher_name', $('#voucher_name').val());
                        formValues.append('voucher_value', parseFloat(voucher_value.getNumericString()));
                        formValues.append('voucher_remark', $('#voucher_remark').val());
                        formValues.append('exp_date', $('#exp_date').val());
                        formValues.append('category_restriction', $("#category_restriction").val());
                        formValues.append('brand_restriction', $("#brand_restriction").val());

                        if (fileCover[0].files[0] != undefined) {
                            formValues.append('upload_image_cover', fileCover[0].files[0]);
                        }

                        if (fileBackCover[0].files[0] != undefined) {
                            formValues.append('upload_image_backcover', fileBackCover[0].files[0]);
                        }

                        formValues.append('old_cover_image', $('#old_cover_image').val());
                        formValues.append('old_backcover_image', $('#old_backcover_image').val());



                        btnSubmit.prop('disabled', true);
                        ajax_post(actUrl, formValues, {
                            success: function(response) {
                                if (response.success) {
                                    if (response.result.success) {
                                        notification.success(response.result.message);
                                        form.parsley().reset();
                                        $('#modal-voucher').modal('hide');
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

        $("#tblvoucher").on('click', '.btnedit', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let actUrl = base_url + '/webmin/voucher/getbyid/' + id;
            ajax_get(actUrl, null, {
                success: function(response) {
                    if (response.success) {
                        if (response.result.exist) {
                            editMode(response.result);
                        } else {
                            message.error(response.result.message);
                        }
                    }
                }
            })

        })

        $("#tblvoucher").on('click', '.btndelete', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let voucher_name = $(this).attr('data-name');
            let question = 'Yakin ingin menghapus voucher <b>' + voucher_name + '</b>?';
            let actUrl = base_url + '/webmin/voucher/delete/' + id;
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

        $('#voucher_count').on('change blur', function(e) {
            let val = voucher_count.getNumericString();
            if (val == '' || val == null) {
                voucher_count.set(1);
            } else {
                let ival = Math.ceil(parseFloat(val));
                if (ival <= 0) {
                    voucher_count.set(1);
                } else if (ival >= 9999) {
                    voucher_count.set(9999);
                } else {
                    voucher_count.set(ival);
                }
            }
        });

        $("#tblvoucher").on('click', '.btnmanagevoucher', function(e) {
            e.preventDefault();

            let id = $(this).attr('data-id');
            let actUrl = base_url + '/webmin/voucher/getbyid/' + id;
            ajax_get(actUrl, null, {
                success: function(response) {
                    if (response.success) {
                        if (response.result.exist) {
                            let data = response.result.data;
                            manage_voucher_group_id = data.voucher_group_id;
                            $('#manage_voucher_name').html(data.voucher_name);
                            $('#manage_voucher_remark').html(data.voucher_remark);
                            $('#manage_voucher_exp_date').html(data.indo_exp_date);
                            $('#manage_voucher_value').html(numberFormat(parseFloat(data.voucher_value), true));
                            tblmanagevoucher.ajax.reload();
                            $('#frmgenerate').parsley().reset();
                            voucher_count.set(1);

                            showInput(true);
                        } else {
                            message.error(response.result.message);
                        }
                    }
                }
            })

        })

        $("#tblvoucher").on('click', '.btndownload', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            Swal.fire({
                title: "Download",
                html: "Ingin <b>Export Excel</b> atau <b>Cetak Voucher</b>?",
                icon: "question",
                showCancelButton: true,
                allowOutsideClick: false,
                confirmButtonColor: "#28a745",
                cancelButtonColor: "#007bff",
                confirmButtonText: 'Export Excel',
                cancelButtonText: 'Cetak Voucher',
            }).then(function(answer) {
                let yes = parseMessageResult(answer);
                if (yes) {
                    let uri = base_url + '/webmin/voucher/export-voucher/' + id;
                    window.open(uri, '_blank');
                } else {
                    let uri = base_url + '/webmin/voucher/print-voucher/' + id;
                    window.open(uri, '_blank');
                }
            })
        })

        $('#btngenerate').click(function(e) {
            e.preventDefault();
            let form = $('#frmgenerate');
            let btnSubmit = $('#btngenerate');
            form.parsley().validate();
            if (form.parsley().isValid()) {
                let nVoucher = parseFloat(voucher_count.getNumericString());
                let question = 'Yakin ingin mengenerate ' + nVoucher + ' voucher?';
                let actUrl = base_url + '/webmin/voucher/generate-voucher/' + manage_voucher_group_id + '/' + nVoucher;

                message.question(question).then(function(answer) {
                    let yes = parseMessageResult(answer);
                    if (yes) {
                        btnSubmit.prop('disabled', true);
                        ajax_get(actUrl, {}, {
                            success: function(response) {
                                if (response.success) {
                                    if (response.result.success) {
                                        notification.success(response.result.message);
                                        form.parsley().reset();
                                    } else {
                                        message.error(response.result.message);
                                    }
                                }
                                btnSubmit.prop('disabled', false);
                                updateTableVoucher();
                            },
                            error: function(response) {
                                btnSubmit.prop('disabled', false);
                                updateTableVoucher();
                            }
                        });
                    }

                })

            }
        })

        $("#tblmanagevoucher").on('click', '.btndelete', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let voucher_code = $(this).attr('data-code');
            let question = 'Yakin ingin menghapus voucher <b>' + voucher_code + '</b>?';
            let actUrl = base_url + '/webmin/voucher/delete-voucher/' + id + '?voucher_code=' + voucher_code;
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
                            updateTableVoucher();
                        },
                        error: function(response) {
                            updateTableVoucher();
                        }
                    })
                }
            })
        })

        $('.close-manage-voucher').click(function(e) {
            e.preventDefault();
            message.question('Yakin ingin menutup halaman ini?').then(function(answer) {
                let yes = parseMessageResult(answer);
                if (yes) {
                    updateTable();
                    showInput(false);
                }
            })

        })


        showInput(false);
        _initButton();
    })
</script>
<?= $this->endSection() ?>