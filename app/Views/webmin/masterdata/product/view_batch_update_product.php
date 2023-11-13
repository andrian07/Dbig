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
                <h1>Batch Update Produk</h1>
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
            <div class="card col-12">
                <div class="card-header p-2">
                    <form id="frmuploadexcel" name="frmupload" method="POST" action="<?= base_url('webmin/product/upload-excel-batch-update-product') ?>" enctype="multipart/form-data">
                        <input type="file" id="file_import" name="file_import" hidden />
                    </form>
                    <button id="btnimport" class="btn btn-success"><i class="fas fa-file-excel"></i> Import Excel</button>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Brand:</label>
                                    <select id="brand_id" name="brand_id" class="form-control" multiple></select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Kategori:</label>
                                    <select id="category_id" name="category_id" class="form-control" multiple></select>
                                </div>
                            </div>

                            <div class="col-md-9">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Supplier:</label>
                                    <select id="supplier_id" name="supplier_id" class="form-control" multiple></select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button id="btnexport" class="btn btn-primary form-control"><i class="fas fa-file-excel"></i> Export Excel</button>

                                </div>
                            </div>

                        </div>
                    </form>
                </div><!-- /.card-body -->
            </div>

        </div>
        <!-- /.row -->
    </div>
</section>

<!-- /.content -->
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    $(document).ready(function() {
        $("#brand_id").select2({
            placeholder: '-- Pilih --',
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

        $("#supplier_id").select2({
            placeholder: '-- Pilih --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/supplier",
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

        $("#category_id").select2({
            placeholder: '-- Pilih --',
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


        $('#brand_id').change(function(e) {
            setSelect2("#supplier_id");
            setSelect2("#category_id");
        })

        $('#supplier_id').change(function(e) {
            setSelect2("#brand_id");
            setSelect2("#category_id");
        })

        $('#category_id').change(function(e) {
            setSelect2("#supplier_id");
            setSelect2("#brand_id");
        })

        $('#btnexport').click(function(e) {
            e.preventDefault();
            let brand_id = $('#brand_id').val();
            let category_id = $('#category_id').val();
            let supplier_id = $('#supplier_id').val();

            let reportUrl = base_url + '/webmin/product/download-product-data?v=1';
            reportUrl += '&brand_id=' + brand_id;
            reportUrl += '&category_id=' + category_id;
            reportUrl += '&supplier_id=' + supplier_id;
            window.open(reportUrl, '_blank');
        })

        $('#btnimport').click(function(e) {
            e.preventDefault();
            $('#file_import').click();
        });


        function readUploadFile(file) {
            if (file.files && file.files[0]) {
                let file_name = file.files[0].name;
                let file_ext = file_name.split(".").pop().toLowerCase();
                let ext = ['xlsx'];

                if (jQuery.inArray(file_ext, ext) == -1) {
                    let message_text = 'File wajib berekstensi ' + ext.join(", ");
                    message.info(message_text);
                    file.value = "";
                } else {
                    let file_size = file.files[0].size;
                    let size = max_upload_size.b;
                    if (file_size > size) {
                        let message_text = 'Ukuran file maksimum ' + max_upload_size.mb + ' MB'
                        message.info(message_text);
                        file.value = "";
                    } else {
                        $('#frmuploadexcel').submit();
                    }
                }
            }
        }

        $("#file_import").change(function() {
            readUploadFile(this);
        });

    })
</script>
<?= $this->endSection() ?>