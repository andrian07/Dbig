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
                    <h1>Laporan Penjualan Per Brand</h1>
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
                                    <div class="col-md-10">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <!-- text input -->
                                                <div class="form-group">
                                                    <label>Toko:</label>
                                                    <select id="store_id" name="store_id" class="form-control"></select>
                                                </div>

                                            </div>

                                            <div class="col-sm-4">
                                                <!-- text input -->
                                                <div class="form-group">
                                                    <label>Brand:</label>
                                                    <select id="brand_id" name="brand_id" class="form-control"></select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Jenis Produk:</label>
                                                    <select id="product_tax" name="product_tax" class="form-control">
                                                        <option value="">Semua</option>
                                                        <option value="Y">PPN</option>
                                                        <option value="N">NON PPN</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <!-- text input -->
                                                <div class="form-group">
                                                    <label>Dari Tanggal:</label>
                                                    <input id="start_date" name="start_date" type="date" class="form-control" value="<?= date('Y-m') ?>-01">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <!-- text input -->
                                                <div class="form-group">
                                                    <label>Sampai Tanggal:</label>
                                                    <input id="end_date" name="end_date" type="date" class="form-control" value="<?= date('Y-m-d') ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <div class="form-group">
                                                <div class="btn-group">
                                                    <button id="btnsearch" type="button" class="btn btn-default"><i class="fas fa-search"></i> Cari</button>
                                                    <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <div class="dropdown-menu" role="menu">
                                                        <a id="btnexportpdf" class="dropdown-item" href="#">Export PDF</a>
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
                            <iframe id="preview" src="<?= base_url('webmin/report/detail-sales-list-group-brand') ?>" width="100%" height="1000px"></iframe>
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
        function reportUrl(params = '') {
            let selBrand = $('#brand_id').select2('data');
            let selStore = $('#store_id').select2('data');

            let brand_id = $('#brand_id').val();
            if (brand_id == null) {
                brand_id = '';
            }

            let brand_name = '';
            if (selBrand[0]) {
                brand_name = selBrand[0].text;
            }

            let store_id = $('#store_id').val();
            if (store_id == null) {
                store_id = '';
            }

            let store_name = '';
            if (selStore[0]) {
                store_name = selStore[0].text;
            }

            let product_tax = $('#product_tax').val();
            let reportUrl = base_url + '/webmin/report/detail-sales-list-group-brand?';

            reportUrl += 'start_date=' + $('#start_date').val();
            reportUrl += '&end_date=' + $('#end_date').val();
            reportUrl += '&brand_id=' + brand_id;
            reportUrl += '&brand_name=' + brand_name;
            reportUrl += '&store_id=' + store_id;
            reportUrl += '&store_name=' + store_name;
            reportUrl += '&product_tax=' + product_tax;

            if (params != '') {
                reportUrl += '&' + params;
            }

            return reportUrl;
        }

        $("#store_id").select2({
            placeholder: '-- Semua --',
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

        $("#brand_id").select2({
            placeholder: '-- Semua --',
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

        $('#btnsearch').click(function(e) {
            e.preventDefault();
            $('#preview').attr('src', reportUrl());
        })

        $('#btnexportpdf').click(function(e) {
            e.preventDefault();
            window.open(reportUrl('download=Y'));
        })

        $('#btnexportexcel').click(function(e) {
            e.preventDefault();
            window.open(reportUrl('file=xls'));
        })

    })
</script>
<?= $this->endSection() ?>