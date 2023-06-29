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
                    <h1>Kartu Stok Produk</h1>
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
                                            <div class="col-md-8">
                                                <!-- text input -->
                                                <div class="form-group">
                                                    <label>Produk:</label>
                                                    <select id="product_id" name="product_id" class="form-control"></select>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <!-- text input -->
                                                <div class="form-group">
                                                    <label>Dari:</label>
                                                    <input id="start_date" name="start_date" type="date" class="form-control" value="<?= date('Y-m') ?>-01">

                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <!-- text input -->
                                                <div class="form-group">
                                                    <label>Sampai:</label>
                                                    <input id="end_date" name="end_date" type="date" class="form-control" value="<?= date('Y-m-d') ?>">

                                                </div>
                                            </div>




                                        </div>
                                    </div>



                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <div class="form-group">
                                                <button id="btnexportexcel" type="button" class="btn btn-default"><i class="fas fa-search"></i> Export Excel</button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 
                                         <div class="col-md-2">
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
                                    -->
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



    </section>
</div>
<!-- /.content -->
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    $(document).ready(function() {
        $("#product_id").select2({
            placeholder: '-- Semua --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/product",
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

        function reportUrl(params = '') {
            let selProduct = $('#product_id').select2('data');

            let product_id = $('#product_id').val();
            if (product_id == null) {
                product_id = '';
            }



            let reportUrl = base_url + '/webmin/report/price-change-list?';
            reportUrl += '&product_id=' + product_id;
            reportUrl += '&start_date=' + $('#start_date').val();
            reportUrl += '&end_date=' + $('#end_date').val();

            if (params != '') {
                reportUrl += '&' + params;
            }

            return reportUrl;
        }

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