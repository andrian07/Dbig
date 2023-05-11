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
                    <h1>Daftar Pembelian</h1>
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
                                            <label>Gudang:</label>
                                            <select id="warehouse" type="text" class="form-control"></select>
                                        </div>
                                    </div>
                                    

                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Supplier:</label>
                                            <select id="supplier_id" name="supplier_id" class="form-control"></select>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Merek:</label>
                                            <select id="brand_id" name="brand_id" class="form-control"></select>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Kategori:</label>
                                            <select id="category_id" name="category_id" class="form-control"></select>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
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
                            <iframe id="preview" src="<?= base_url('webmin/report/purchase-list') ?>" width="100%" height="1000px"></iframe>
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
        $("#warehouse").select2({
            placeholder: '-- SEMUA --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/warehouse",
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

        $("#supplier_id").select2({
            placeholder: '-- SEMUA --',
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


        $("#brand_id").select2({
            placeholder: '-- SEMUA --',
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

        $("#category_id").select2({
            placeholder: '-- SEMUA --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/category",
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
            let warehouse = $('#warehouse').val();
            let product_tax = $('#product_tax').val();
            let supplier_id = $('#supplier_id').val();
            let brand_id = $('#brand_id').val();
            let category_id = $('#category_id').val();
            let show_detail = $("#show_detail:checked").val();

            if(show_detail != 'on'){
                if (brand_id != null && brand_id != '') {
                    Swal.fire({
                      icon: 'info',
                      title:'Oops...',
                      text: 'Filter merek hanya untuk tampilan detail'
                  })
                }

                if (category_id != null && category_id != '') {
                    Swal.fire({
                      icon: 'error',
                      title:'Oops...',
                      text: 'Filter kategori hanya untuk tampilan detail'
                  })
                }
            }

            let reportUrl = '<?= base_url('webmin/report/purchase-list') ?>?';
            reportUrl += '&start_date=' + start_date;
            reportUrl += '&end_date=' + end_date;
            reportUrl += '&show_detail=' + show_detail;
            if (warehouse != null && warehouse != '') {
                reportUrl += '&warehouse=' + warehouse;
            }
            if (product_tax != null && product_tax != '') {
                reportUrl += '&product_tax=' + product_tax;
            }
            if (supplier_id != null && supplier_id != '') {
                reportUrl += '&supplier_id=' + supplier_id;
            }
            if (brand_id != null && brand_id != '') {
                reportUrl += '&brand_id=' + brand_id;
            }
            if (category_id != null && category_id != '') {
                reportUrl += '&category_id=' + category_id;
            }
            $('#preview').prop('src', reportUrl);
        })
        

        $('#btnexportpdf').click(function(e) {
            e.preventDefault();
            let reportUrl = '<?= base_url('webmin/report/sales-list') ?>?download=Y';
            window.open(reportUrl);
        })

        $('#btnexportexcel').click(function(e) {
            e.preventDefault();

            let start_date = $('#start_date').val();
            let end_date = $('#end_date').val();
            let warehouse = $('#warehouse').val();
            let product_tax = $('#product_tax').val();
            let supplier_id = $('#supplier_id').val();
            let brand_id = $('#brand_id').val();
            let category_id = $('#category_id').val();
            let show_detail = $("#show_detail:checked").val();

            if(show_detail != 'on'){
                if (brand_id != null && brand_id != '') {
                    Swal.fire({
                      icon: 'info',
                      title:'Oops...',
                      text: 'Filter merek hanya untuk tampilan detail'
                  })
                }

                if (category_id != null && category_id != '') {
                    Swal.fire({
                      icon: 'error',
                      title:'Oops...',
                      text: 'Filter kategori hanya untuk tampilan detail'
                  })
                }
            }

            let reportUrl = '<?= base_url('webmin/report/purchase-list') ?>?';
            reportUrl += '&start_date=' + start_date;
            reportUrl += '&end_date=' + end_date;
            reportUrl += '&show_detail=' + show_detail;
            if (warehouse != null && warehouse != '') {
                reportUrl += '&warehouse=' + warehouse;
            }
            if (product_tax != null && product_tax != '') {
                reportUrl += '&product_tax=' + product_tax;
            }
            if (supplier_id != null && supplier_id != '') {
                reportUrl += '&supplier_id=' + supplier_id;
            }
            if (brand_id != null && brand_id != '') {
                reportUrl += '&brand_id=' + brand_id;
            }
            if (category_id != null && category_id != '') {
                reportUrl += '&category_id=' + category_id;
            }
            reportUrl += '&file=xls';
            reportUrl += '&download=Y';

            window.open(reportUrl, '_blank');
        })

    })
</script>
<?= $this->endSection() ?>