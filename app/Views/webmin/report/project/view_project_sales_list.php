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
                    <h1>Daftar Penjualan Proyek</h1>
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
                                        <label>Cabang :</label>
                                        <select id="store_id" name="store_id" class="form-control"></select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Customer:</label>
                                        <select id="customer_id" name="customer_id" class="form-control"></select>

                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Salesman:</label>
                                        <select id="salesman_id" name="salesman_id" class="form-control select-salesman fs-20"></select>

                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Status:</label>
                                        <select id="status" name="status" class="form-control">
                                            <option value="1">SEMUA</option>
                                            <option value="2" SELECTED>JATUH TEMPO SAJA</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-2">
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


                                <div class="col-sm-2">
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
                        <iframe id="preview" src="<?= base_url('webmin/report/project-sales-list') ?>" width="100%" height="1000px"></iframe>
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

    $("#customer_id").select2({
        placeholder: '-- Pilih Customer --',
        width: "100%",
        allowClear: true,
        ajax: {
            url: base_url + "/webmin/select/customer",
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


    $("#store_id").select2({
        placeholder: '-- Pilih Store --',
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


    $("#salesman_id").select2({
        placeholder: '-- Pilih Salesman --',
        width: "100%",
        allowClear: true,
        ajax: {
            url: base_url + "/webmin/select/salesman",
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
        let store_id = $('#store_id').val();
        let customer_id = $('#customer_id').val();
        let salesman_id = $('#salesman_id').val();
        let status = $('#status').val();
        let show_detail = $("#show_detail:checked").val();

        let reportUrl = '<?= base_url('webmin/report/project-sales-list') ?>?';
        reportUrl += '&start_date=' + start_date;
        reportUrl += '&end_date=' + end_date;
        reportUrl += '&show_detail=' + show_detail;
        reportUrl += '&status=' + status;
        if (store_id != null && store_id != '') {
            reportUrl += '&store_id=' + store_id;
        }
        if (customer_id != null && customer_id != '') {
            reportUrl += '&customer_id=' + customer_id;
        }
        if (salesman_id != null && salesman_id != '') {
            reportUrl += '&salesman_id=' + salesman_id;
        }
        $('#preview').prop('src', reportUrl);
    })


    $('#btnexportexcel').click(function(e) {
        e.preventDefault();
        let start_date = $('#start_date').val();
        let end_date = $('#end_date').val();
        let store_id = $('#store_id').val();
        let customer_id = $('#customer_id').val();
        let salesman_id = $('#salesman_id').val();
        let status = $('#status').val();
        let show_detail = $("#show_detail:checked").val();

        let reportUrl = '<?= base_url('webmin/report/project-sales-list') ?>?';
        reportUrl += '&start_date=' + start_date;
        reportUrl += '&end_date=' + end_date;
        reportUrl += '&show_detail=' + show_detail;
        reportUrl += '&status=' + status;
        if (store_id != null && store_id != '') {
            reportUrl += '&store_id=' + store_id;
        }
        if (customer_id != null && customer_id != '') {
            reportUrl += '&customer_id=' + customer_id;
        }
        if (salesman_id != null && salesman_id != '') {
            reportUrl += '&salesman_id=' + salesman_id;
        }
        reportUrl += '&file=xls';
        reportUrl += '&download=Y';

        window.open(reportUrl, '_blank');
    })

</script>




<?= $this->endSection() ?>