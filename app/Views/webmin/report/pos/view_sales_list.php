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
                    <h1>Daftar Penjualan Retail</h1>
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
                                                    <label>User:</label>
                                                    <select id="user_id" name="user_id" class="form-control"></select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <!-- text input -->
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
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>&nbsp;</label>
                                                    <div class="form-check">
                                                        <div class="col-sm-12">
                                                            <input type="checkbox" class="form-check-input" id="show_detail">
                                                            <label class="form-check-label" for="show_detail">Tampilkan Detail</label>
                                                        </div>
                                                    </div>
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
                            <iframe id="preview" src="<?= base_url('webmin/report/sales-list') ?>" width="100%" height="1000px"></iframe>
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
            let detail = $('#show_detail').prop('checked');
            let user_id = $('#user_id').val();
            if (user_id == null) {
                user_id = '';
            }
            let store_id = $('#store_id').val();
            if (store_id == null) {
                store_id = '';
            }
            let product_tax = $('#product_tax').val();

            let reportUrl = base_url + '/webmin/report/sales-list?';
            if (detail) {
                reportUrl = base_url + '/webmin/report/detail-sales-list?'
            }

            reportUrl += 'start_date=' + $('#start_date').val();
            reportUrl += '&end_date=' + $('#end_date').val();
            reportUrl += '&user_id=' + user_id;
            reportUrl += '&store_id=' + store_id;
            reportUrl += '&product_tax=' + product_tax;

            if (params != '') {
                reportUrl += '&' + params;
            }

            console.log('reportUrl : ' + reportUrl);
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

        $("#user_id").select2({
            placeholder: '-- Semua --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/user-account",
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

    })
</script>
<?= $this->endSection() ?>