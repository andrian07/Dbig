<?php
$themeUrl = base_url('assets/adminlte3');
$assetsUrl = base_url('assets');
?>

<?= $this->extend('pos/template/pos_template') ?>

<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
                <div class="btn-group">
                    <button type="button" class="btn btn-default"><i class="fas fa-print"></i> Print</button>
                </div>
            </div>
            <div class="col-sm-6">
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <h3 class="text-center">Rekap Penjualan</h3>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="show_detail" value="N" checked>
                                <label class="form-check-label">Rekapitulasi</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="show_detail" value="Y">
                                <label class="form-check-label">Detail</label>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <iframe id="preview" src="<?= base_url('pos/sales-recap') ?>" width="100%" height="1000px"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<!-- /.content -->
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    $(document).ready(function(e) {
        let show_detail = $('input[name="show_detail"]:checked').val();
        let report_url = '<?= base_url('pos/sales-recap') ?>?';

        function view_report() {
            show_detail = $('input[name="show_detail"]:checked').val();
            let view_url = report_url + 'detail=' + show_detail;
            $('#preview').attr('src', view_url);
        }

        $('input[name="show_detail"]').change(function() {
            view_report();
        });

    })
</script>

<?= $this->endSection() ?>