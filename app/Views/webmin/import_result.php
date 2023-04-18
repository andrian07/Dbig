<?php
$themeUrl = base_url('assets/adminlte3');
$assetsUrl = base_url('assets');
?>

<?= $this->extend('webmin/template/admin_template') ?>

<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?= $title ?></h1>
            </div>
            <div class="col-sm-6"></div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- /.col -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header p-2">
                        <button id="btnback" class="btn btn-default"><i class="fas fa-chevron-circle-left"></i> Kembali</button>
                    </div>
                    <div class="card-body">
                        <?php if ($success) { ?>
                            <div class="row">
                                <div class="alert alert-success col-12">
                                    <?= $message ?>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="row">
                                <div class="alert alert-danger col-12">
                                    <?= $message ?>
                                </div>
                                <?php
                                foreach ($errors as $err) :
                                    if (intval($err['code']) != 0) {
                                ?>
                                        <div class="alert alert-danger col-12">
                                            <?= $err['message'] ?>
                                        </div>
                                <?php
                                    }
                                endforeach;
                                ?>
                            </div>
                        <?php } ?>

                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->


        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    $(document).ready(function() {
        $('#btnback').click(function(e) {
            e.preventDefault();
            window.location.href = '<?= $back_url ?>';
        })
    })
</script>
<?= $this->endSection() ?>