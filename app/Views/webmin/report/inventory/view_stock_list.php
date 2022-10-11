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
                    <h1>Daftar Stok Produk</h1>
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
                                            <label>Gudang:</label>
                                            <select id="warehouse_id" name="warehouse_id" class="form-control">
                                                <option value="1" selected>UTM - PUSAT</option>
                                                <option value="2">KBR - KOTA BARU</option>
                                                <option value="3">KNY - KONSINYASI</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Golongan:</label>
                                            <select id="product_tax" name="product_tax" class="form-control">
                                                <option value="" selected>SEMUA</option>
                                                <option value="Y">BKP - BARANG KENA PAJAK</option>
                                                <option value="N">NON BKP - BARANG TIDAK KENA PAJAK</option>
                                            </select>
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
                            <iframe id="preview" src="<?= base_url('webmin/report/stock-list') ?>" width="100%" height="1000px"></iframe>
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