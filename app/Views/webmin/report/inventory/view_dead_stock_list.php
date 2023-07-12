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
                    <h1>Daftar Dead Stok</h1>
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
                                    <!--
                                    <div class="col-sm-2">
                                      
                                        <div class="form-group">
                                            <label>Dari Tanggal:</label>
                                            <input id="date_from" name="date_from" type="date" class="form-control" value="<?= date('Y-m') ?>-01">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                       
                                        <div class="form-group">
                                            <label>Sampai Tanggal:</label>
                                            <input id="date_until" name="date_until" type="date" class="form-control" value="<?= date('Y-m-d') ?>">
                                        </div>
                                    </div>
                                    -->


                                    <div class="col-md-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Tanggal CutOff:</label>
                                            <input id="cutoff_date" name="cutoff_date" type="date" class="form-control" value="<?= date('Y-m') ?>-01">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Persentase Penjualan:</label>
                                            <input id="percent_sales" name="percent_sales" type="text" class="form-control">
                                        </div>
                                    </div>


                                    <div class="col-sm-2">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <div class="form-group">
                                                <button id="btnexportexcel" type="button" class="btn btn-default"><i class="fas fa-file-xls"></i> Export Excel</button>

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


    </section>
</div>
<!-- /.content -->
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    $(document).ready(function() {
        let percent_sales = new AutoNumeric('#percent_sales', configDisc);
        percent_sales.set(20);

        function reportUrl(params = '') {
            let reportUrl = base_url + '/webmin/report/dead-stock-list?';
            let psales = 20;
            if (percent_sales.getNumericString() != null) {
                psales = parseFloat(percent_sales.getNumericString());
            }

            reportUrl += '&cutoff_date=' + $('#cutoff_date').val();
            reportUrl += '&percent_sales=' + psales;

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