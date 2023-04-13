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
                        <h3 class="text-center">Sample Struk Retur Penjualan</h3>

                        <div class="row mb-1">
                            <iframe id="preview" src="<?= base_url('pos/sales-return-receipt') ?>" width="100%" height="1000px"></iframe>
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


<?= $this->endSection() ?>