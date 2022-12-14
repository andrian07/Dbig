<?php
$themeUrl = base_url('assets/adminlte3');
$assetsUrl = base_url('assets');
?>

<?= $this->extend('webmin/template/admin_template') ?>

<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Cetak Label Harga</h1>
                </div>
                <div class="col-sm-6"></div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- /.col -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Pilih Produk:</label>
                                            <select id="item_id" name="item_id" class="form-control" multiple></select>
                                        </div>
                                    </div>


                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Cetak Versi</label>
                                            <select id="print_version" name="print_version" class="form-control">
                                                <option value="1">Tanpa Diskon</option>
                                                <option value="2">Diskon</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <!-- text input -->

                                        <label>&nbsp;</label>
                                        <div class="form-group">
                                            <div class="btn-group">
                                                <button id="btnsearch" type="button" class="btn btn-default"><i class="fas fa-search"></i> Cari</button>
                                                <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu" role="menu">
                                                    <a id="btnexportpdf" class="dropdown-item" href="#">Export PDF</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->


        <div class="container-fluid">
            <div class="row">
                <!-- /.col -->
                <div class="col-md-12 ">
                    <div class="card">
                        <div class="card-body">
                            <h5>Preview</h5>
                            <iframe id="preview" src="<?= base_url('webmin/report/price-tag') ?>" width="100%" height="1000px"></iframe>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
</div>
<!-- /.content -->
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    $(document).ready(function() {
        $("#item_id").select2({
            placeholder: '-- Semua --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/product-unit",
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

        $('#btnsearch').click(function(e) {
            e.preventDefault();
            let item_id = $("#item_id").val();
            let print_version = $('#print_version').val();
            if (item_id == null) {
                item_id = '';
            }

            let reportUrl = '<?= base_url('webmin/report/price-tag') ?>?';
            reportUrl += 'item_id=' + item_id;
            reportUrl += '&print_version=' + print_version;
            $('#preview').prop('src', reportUrl);
        })

        $('#btnexportpdf').click(function(e) {
            e.preventDefault();
            let item_id = $("#item_id").val();
            let print_version = $('#print_version').val();
            if (item_id == null) {
                item_id = '';
            }

            let reportUrl = '<?= base_url('webmin/report/price-tag') ?>?';
            reportUrl += 'item_id=' + item_id;
            reportUrl += '&print_version=' + print_version;
            reportUrl += '&download=Y';
            window.open(reportUrl, '_blank');
        })


    })
</script>
<?= $this->endSection() ?>