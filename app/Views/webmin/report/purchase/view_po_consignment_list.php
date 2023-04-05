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
                    <h1>Daftar PO Konsinyasi</h1>
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
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Dari Tanggal:</label>
                                            <input id="start_date" name="start_date" type="date" class="form-control" value="<?= date('Y-m') ?>-01">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Sampai Tanggal:</label>
                                            <input id="end_date" name="end_date" type="date" class="form-control" value="<?= date('Y-m-d') ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Merek:</label>
                                            <select id="brand_id" name="brand_id" class="form-control"></select>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Kategori:</label>
                                            <select id="category_id" name="category_id" class="form-control"></select>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Supplier:</label>
                                            <select id="supplier_id" name="supplier_id" class="form-control"></select>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>STATUS PESANAN:</label>
                                            <select id="status_po" name="status_po" class="form-control">
                                                 <option value="">SEMUA</option>
                                                <option value="Pending">Pending</option>
                                                <option value="Selesai">Selesai</option>
                                                <option value="Cancel">Cancel</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <div class="form-group">
                                                <div class="btn-group">
                                                    <button type="button" id="btnsearch" class="btn btn-default"><i class="fas fa-search"></i> Cari</button>
                                                    <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <div class="dropdown-menu" role="menu">
                                                        <a id="btnexportexcel" class="dropdown-item" href="#">Export Excel</a>
                                                    </div>
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
                            <iframe id="preview" src="<?= base_url('webmin/report/po-consignment-list') ?>" width="100%" height="1000px"></iframe>
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

        // select2 //`1q`

        $("#supplier_id").select2({
            placeholder: '-- Pilih Supplier --',
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

        $("#brand_id").select2({
            placeholder: '-- SEMUA --',
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

        $("#category_id").select2({
            placeholder: '-- SEMUA --',
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



        $('#btnsearch').click(function(e) {
            e.preventDefault();
            let start_date = $('#start_date').val();
            let end_date = $('#end_date').val();
            let product_tax = $('#product_tax').val();
            let supplier_id = $('#supplier_id').val();
            let brand_id = $('#brand_id').val();
            let category_id = $('#category_id').val();
            let status_po = $('#status_po').val();

            let reportUrl = '<?= base_url('webmin/report/po-consignment-list') ?>?';
            reportUrl += '&start_date=' + start_date;
            reportUrl += '&end_date=' + end_date;
            if (supplier_id != null && supplier_id != '') {
                reportUrl += '&supplier_id=' + supplier_id;
            }
            if (brand_id != null && brand_id != '') {
                reportUrl += '&brand_id=' + brand_id;
            }
            if (category_id != null && category_id != '') {
                reportUrl += '&category_id=' + category_id;
            }
            if (status_po != null && status_po != '') {
                reportUrl += '&status_po=' + status_po;
            }
            $('#preview').prop('src', reportUrl);
        })
        

        $('#btnexportexcel').click(function(e) {
            e.preventDefault();
            let start_date = $('#start_date').val();
            let end_date = $('#end_date').val();
            let product_tax = $('#product_tax').val();
            let supplier_id = $('#supplier_id').val();
            let brand_id = $('#brand_id').val();
            let category_id = $('#category_id').val();
            let status_po = $('#status_po').val();

            let reportUrl = '<?= base_url('webmin/report/po-consignment-list') ?>?';
            reportUrl += '&start_date=' + start_date;
            reportUrl += '&end_date=' + end_date;
            if (supplier_id != null && supplier_id != '') {
                reportUrl += '&supplier_id=' + supplier_id;
            }
            if (brand_id != null && brand_id != '') {
                reportUrl += '&brand_id=' + brand_id;
            }
            if (category_id != null && category_id != '') {
                reportUrl += '&category_id=' + category_id;
            }
            if (status_po != null && status_po != '') {
                reportUrl += '&status_po=' + status_po;
            }
            reportUrl += '&file=xls';
            reportUrl += '&download=Y';

            window.open(reportUrl, '_blank');
        })

    })
</script>
<?= $this->endSection() ?>