<?php
$themeUrl = base_url('assets/adminlte3');
$assetsUrl = base_url('assets');
?>

<?= $this->extend('webmin/template/admin_template') ?>

<?= $this->section('content') ?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Pengaturan</h1>
            </div><!-- /.col -->
            <div class="col-sm-6"></div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->



<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <?php if ($alert != null) : ?>
                <div class="col-12">
                    <div class="alert alert-<?= $alert['type'] ?>">
                        <?= $alert['message'] ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="col-12">
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <button class="btn btn-block btn-primary btn-url" data-href="<?= base_url('cjob/update-safety-stock-balance?user_request=Y') ?>">Update Safety Stok</button>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <button class="btn btn-block btn-primary btn-url" data-href="<?= base_url('cjob/update-po-safety-stock?user_request=Y') ?>">Buat PO Otomatis</button>
                    </div>
                </div>
            </div>
        </div>





    </div><!-- /.container-fluid -->


</section>
<!-- /.content -->


<?= $this->endSection() ?>


<?= $this->section('js') ?>
<script>
    $(document).ready(function() {
        console.log('init');

        $('.btn-url').click(function(e) {
            e.preventDefault();
            let openUrl = $(this).data('href');
            window.location.href = openUrl;
        })
    })
</script>

<?= $this->endSection() ?>