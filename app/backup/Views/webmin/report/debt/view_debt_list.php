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
                    <h1>Daftar Pembayaran Hutang</h1>
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
                                    <!-- text input -->
                                    <div class="col-sm-2">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Tanggal Dari:</label>
                                            <input id="start_date" name="start_date" type="date" class="form-control" value="<?= date('Y-m') ?>-01">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Tanggal Sampai:</label>
                                            <input id="end_date" name="end_date" type="date" class="form-control" value="<?= date('Y-m-d') ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>No Pembelian:</label>
                                            <select id="purchase_invoice" name="purchase_invoice" class="form-control"></select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Supplier:</label>
                                            <select id="supplier_id" name="supplier_id" class="form-control"></select>
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
                            <iframe id="preview" src="<?= base_url('webmin/report/debt-list') ?>" width="100%" height="1000px"></iframe>
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

        // select2 //

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



        $("#purchase_invoice").select2({
            placeholder: '-- Pilih Invoice Pembelian --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/no-purchase-report",
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
            let supplier_id = $('#supplier_id').val();
            let purchase_invoice = $('#purchase_invoice').val();
            let reportUrl = '<?= base_url('webmin/report/debt-list') ?>?';
            reportUrl += '&start_date=' + start_date;
            reportUrl += '&end_date=' + end_date;
            if (supplier_id != null && supplier_id != '') {
                reportUrl += '&supplier_id=' + supplier_id;
            }
            if (purchase_invoice != null && purchase_invoice != '') {
                reportUrl += '&purchase_invoice=' + purchase_invoice;
            }
            $('#preview').prop('src', reportUrl);
        })
        

        $('#btnexportexcel').click(function(e) {
            e.preventDefault();
            let start_date = $('#start_date').val();
            let end_date = $('#end_date').val();
            let supplier_id = $('#supplier_id').val();
            let purchase_invoice = $('#purchase_invoice').val();
            let reportUrl = '<?= base_url('webmin/report/debt-list') ?>?';
            reportUrl += '&start_date=' + start_date;
            reportUrl += '&end_date=' + end_date;
            if (supplier_id != null && supplier_id != '') {
                reportUrl += '&supplier_id=' + supplier_id;
            }
            if (purchase_invoice != null && purchase_invoice != '') {
                reportUrl += '&purchase_invoice=' + purchase_invoice;
            }
            reportUrl += '&file=xls';
            reportUrl += '&download=Y';

            window.open(reportUrl, '_blank');
        })

    })
</script>
<?= $this->endSection() ?>