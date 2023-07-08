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
                    <h1>Daftar Stok Transfer</h1>
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
                                    <div class="col-sm-2">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Dari Tanggal:</label>
                                            <input id="date_from" name="date_from" type="date" class="form-control" value="<?= date('Y-m') ?>-01">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Sampai Tanggal:</label>
                                            <input id="date_until" name="date_until" type="date" class="form-control" value="<?= date('Y-m-d') ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Dari Gudang:</label>
                                            <select id="source_warehouse_id" name="source_warehouse_id" class="form-control">
                                                <option value="1" selected>UTM - PUSAT</option>
                                                <option value="2">KBR - KOTA BARU</option>
                                                <option value="3">KNY - KONSINYASI</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Ke Gudang:</label>
                                            <select id="dest_warehouse_id" name="dest_warehouse_id" class="form-control">
                                                <option value="1" selected>UTM - PUSAT</option>
                                                <option value="2">KBR - KOTA BARU</option>
                                                <option value="3">KNY - KONSINYASI</option>
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
                            <iframe id="preview" src="<?= base_url('webmin/report/stock-transfer-list') ?>" width="100%" height="1000px"></iframe>
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
       $('#btnsearch').click(function(e) {
            e.preventDefault();
            let start_date = $('#date_from').val();
            let end_date = $('#date_until').val();
            let source_warehouse_id = $('#source_warehouse_id').val();
            let dest_warehouse_id = $('#dest_warehouse_id').val();
            let reportUrl = '<?= base_url('webmin/report/stock-transfer-list') ?>?';
            reportUrl += '&start_date=' + start_date;
            reportUrl += '&end_date=' + end_date;
            reportUrl += '&source_warehouse_id=' + source_warehouse_id;
            reportUrl += '&dest_warehouse_id=' + dest_warehouse_id;
            $('#preview').prop('src', reportUrl);
        })
        

        $('#btnexportexcel').click(function(e) {
            e.preventDefault();
            let start_date = $('#date_from').val();
            let end_date = $('#date_until').val();
            let source_warehouse_id = $('#source_warehouse_id').val();
            let dest_warehouse_id = $('#dest_warehouse_id').val();
            let reportUrl = '<?= base_url('webmin/report/stock-transfer-list') ?>?';
            reportUrl += '&start_date=' + start_date;
            reportUrl += '&end_date=' + end_date;
            reportUrl += '&source_warehouse_id=' + source_warehouse_id;
            reportUrl += '&dest_warehouse_id=' + dest_warehouse_id;
            reportUrl += '&file=xls';
            reportUrl += '&download=Y';
            window.open(reportUrl, '_blank');
        })
</script>
<?= $this->endSection() ?>