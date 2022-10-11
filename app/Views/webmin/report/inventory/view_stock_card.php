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
                                    <div class="col-sm-4">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Produk:</label>
                                            <select id="product_id" name="product_id" class="form-control">
                                                <option value="1">P000001 - Toto Gantungan Double Robe Hook (TX04AES)</option>
                                                <option value="2">P000002 - Toto Floor Drain (TX1DA)</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Bulan:</label>
                                            <select id="period_month" name="period_month" class="form-control">
                                                <?php
                                                $cur_month = date('m');
                                                $month_list = [
                                                    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                                                ];

                                                foreach ($month_list as $i => $v) {
                                                    $month = substr('00' . strval($i + 1), -2);
                                                    $isSelected = $month == $cur_month ? 'selected' : '';
                                                ?>
                                                    <option value="<?= $month ?>" <?= $isSelected ?>><?= $v ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Tahun:</label>

                                            <select id="period_year" name="period_year" class="form-control">
                                                <?php
                                                for ($year = 2020; $year <= 2050; $year++) {
                                                    $isSelected = intval(date('Y')) == $year ? 'selected' : '';
                                                ?>
                                                    <option value="<?= $year ?>" <?= $isSelected ?>><?= $year ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-sm-2">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Gudang:</label>
                                            <select id="warehouse_id" name="warehouse_id" class="form-control">
                                                <option value="0" selected>SEMUA</option>
                                                <option value="1">UTM - PUSAT</option>
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
                            <iframe id="preview" src="<?= base_url('webmin/report/stock-card') ?>" width="100%" height="1000px"></iframe>
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