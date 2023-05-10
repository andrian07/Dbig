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
                    <h1>Cetak Label Harga</h1>
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
                                                    <label>Pilih Produk:</label>
                                                    <select id="item_id" name="item_id" class="form-control" multiple></select>
                                                </div>
                                            </div>


                                            <div class="col-md-4">
                                                <!-- text input -->
                                                <div class="form-group">
                                                    <label>Brand:</label>
                                                    <select id="brand_id" name="brand_id" class="form-control" multiple></select>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <div class="col-sm-12">
                                                            <input type="checkbox" class="form-check-input" id="price_G1" checked>
                                                            <label class="form-check-label" for="price_G1">Umum</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <div class="col-sm-12">
                                                            <input type="checkbox" class="form-check-input" id="price_G2" checked>
                                                            <label class="form-check-label" for="price_G2">Silver</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <div class="col-sm-12">
                                                            <input type="checkbox" class="form-check-input" id="price_G3" checked>
                                                            <label class="form-check-label" for="price_G3">Gold</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <div class="col-sm-12">
                                                            <input type="checkbox" class="form-check-input" id="price_G4" checked>
                                                            <label class="form-check-label" for="price_G4">Platinum</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <!-- text input -->
                                                <div class="form-group">
                                                    <label>Cetak Versi</label>
                                                    <select id="print_version" name="print_version" class="form-control">
                                                        <option value="1">Tanpa Diskon</option>
                                                        <option value="2">Diskon</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <!-- text input -->
                                                <div class="form-group">
                                                    <label>Jumlah</label>
                                                    <input type="number" id="print_count" name="print_count" class="form-control" value="1">
                                                </div>
                                            </div>



                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <!-- text input -->

                                        <label>&nbsp;</label>
                                        <div class="form-group">
                                            <div class="btn-group">
                                                <button id="btnsearch" type="button" class="btn btn-default"><i class="fas fa-search"></i> Cari</button>
                                                <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu" role="menu">
                                                    <a id="btnexportpdf" class="dropdown-item" href="#">Export PDF</a>
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
                            <iframe id="preview" src="<?= base_url('webmin/report/price-tag-v3') ?>" width="100%" height="1000px"></iframe>
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
        $("#item_id").select2({
            placeholder: '-- Pilih --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/product-unit",
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
            placeholder: '-- Pilih --',
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

        $('#item_id').change(function() {
            setSelect2('#brand_id');
        })

        $('#brand_id').change(function() {
            setSelect2('#item_id');
        })


        function reportUrl(params = '') {
            let item_id = $("#item_id").val();
            let brand_id = $('#brand_id').val();
            let print_version = $('#print_version').val();
            let print_count = $('#print_count').val();
            let print_group = [];
            let price_G1 = $('#price_G1').prop('checked');
            let price_G2 = $('#price_G2').prop('checked');
            let price_G3 = $('#price_G3').prop('checked');
            let price_G4 = $('#price_G4').prop('checked');
            let reportUrl = base_url + '/webmin/report/price-tag-v3?';


            if (item_id == null) {
                item_id = '';
            }

            if (brand_id == null) {
                brand_id = '';
            }

            if (price_G1) {
                print_group.push('G1');
            }

            if (price_G2) {
                print_group.push('G2');
            }

            if (price_G3) {
                print_group.push('G3');
            }

            if (price_G4) {
                print_group.push('G4');
            }

            reportUrl += 'item_id=' + item_id;
            reportUrl += '&brand_id=' + brand_id;
            reportUrl += '&print_version=' + print_version;
            reportUrl += '&print_count=' + print_count;
            reportUrl += '&print_group=' + print_group.join(',');


            if (params != '') {
                reportUrl += '&' + params;
            }

            return reportUrl;
        }



        $('#btnsearch').click(function(e) {
            e.preventDefault();
            $('#preview').prop('src', reportUrl());
        })

        $('#btnexportpdf').click(function(e) {
            e.preventDefault();
            window.open(reportUrl('download=Y'), '_blank');
        })


    })
</script>
<?= $this->endSection() ?>