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
                    <h1>Daftar Penjualan</h1>
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
                                            <label>Customer:</label>
                                            <select id="customer_id" name="customer_id" class="form-control">
                                                <option value="1" selected>Samsul (0896-7899-8899)</option>
                                                <option value="2">Udin (0896-7899-5555)</option>
                                                <option value="3">Ricky Acinda (0896-8888-5656)</option>
                                                <option value="4">PT Aneka Jaya (0896-7899-8899)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Toko:</label>
                                            <select id="store_id" name="store_id" class="form-control">
                                                <option value="1">UTM - UTAMA</option>
                                                <option value="2">KBR - CABANG KOTA BARU</option>
                                            </select>
                                        </div>
                                    </div>
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
                                    <div class="col-sm-2">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <div class="form-group">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default"><i class="fas fa-search"></i> Cari</button>
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
        // $("#customer_id").select2({
        //     placeholder: '-- Semua --',
        //     width: "100%",
        //     allowClear: true,
        //     ajax: {
        //         url: base_url + "/select/customer",
        //         dataType: "json",
        //         type: "POST",
        //         delay: select2Delay,
        //         data: function(params) {
        //             return {
        //                 search: params.term,
        //             };
        //         },
        //         processResults: function(data, page) {
        //             return {
        //                 results: data,
        //             };
        //         },
        //     },
        // });


        $('#btnexportpdf').click(function(e) {
            e.preventDefault();
            let reportUrl = '<?= base_url('webmin/report/sales-list') ?>?download=Y';
            window.open(reportUrl);
        })

    })
</script>
<?= $this->endSection() ?>