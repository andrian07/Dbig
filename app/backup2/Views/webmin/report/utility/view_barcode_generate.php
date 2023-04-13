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
                    <h1>Cetak Barcode</h1>
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
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Pilih Produk:</label>
                                            <select id="item_id" name="item_id" class="form-control"></select>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Jenis Barcode:</label>
                                            <select id="barcode_type" name="barcode_type" class="form-control">
                                                <?php
                                                foreach ($barcode_type_list  as $key => $val) {
                                                ?>
                                                    <option value="<?= $key ?>"><?= $val ?></option>
                                                <?php

                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Jumlah:</label>
                                            <input type="number" id="print_count" name="print_count" class="form-control" value="1" />

                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <!-- text input -->

                                        <label>&nbsp;</label>
                                        <div class="form-group">
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
                            <iframe id="preview" src="<?= base_url('webmin/report/barcode-generate') ?>" width="100%" height="1000px"></iframe>
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
            placeholder: '-- Semua --',
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

        $('#print_count').change(function() {
            let val = $(this).val();

            if (val == '') {
                $('#print_count').val(1);
            } else if (parseFloat(val) <= 0) {
                $('#print_count').val(1);
            }
        })

        $('#btnsearch').click(function(e) {
            e.preventDefault();
            let item_id = $("#item_id").val();
            let barcode_type = $("#barcode_type").val();
            let print_count = $('#print_count').val();
            if (item_id == null) {
                item_id = '';
            }

            let reportUrl = '<?= base_url('webmin/report/barcode-generate') ?>?';
            reportUrl += 'item_id=' + item_id + '&barcode_type=' + barcode_type;
            reportUrl += '&print_count=' + print_count;
            $('#preview').prop('src', reportUrl);
        })

    })
</script>
<?= $this->endSection() ?>