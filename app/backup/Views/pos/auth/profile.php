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
                <h1>Profile</h1>
            </div>
            <div class="col-sm-6"></div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="<?= $themeUrl ?>/dist/img/avatar5.png" alt="User profile picture">
                        </div>
                        <h3 class="profile-username text-center"><?= $user['user_realname'] ?></h3>
                        <p class="text-muted text-center"><?= $user['group_name'] ?></p>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->


            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Ganti Password</a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="settings">
                                <form id="frmchangepassword" class="form-horizontal">
                                    <div class="form-group row">
                                        <label for="old_password" class="col-sm-4 col-form-label">Password Lama</label>
                                        <div class="col-sm-8">
                                            <input type="password" class="form-control" id="old_password" name="old_password" placeholder="Password Lama" value="" data-parsley-pattern="^[a-zA-Z0-9]+$" data-parsley-minlength="8" data-parsley-maxlength="100" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="new_password" class="col-sm-4 col-form-label">Password Baru</label>
                                        <div class="col-sm-8">
                                            <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Password Baru" value="" data-parsley-pattern="^[a-zA-Z0-9]+$" data-parsley-minlength="8" data-parsley-maxlength="100" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="repeat_password" class="col-sm-4 col-form-label">Ulangi Password</label>
                                        <div class="col-sm-8">
                                            <input type="password" class="form-control" id="repeat_password" name="repeat_password" placeholder="Ulangi Password" value="" data-parsley-pattern="^[a-zA-Z0-9]+$" data-parsley-minlength="8" data-parsley-maxlength="100" data-parsley-equalto="#new_password" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-12">
                                            <button id="btnsave" class="btn btn-success float-right"><i class="fas fa-save"></i> Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
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
        $('#btnsave').click(function(e) {
            e.preventDefault();
            let form = $('#frmchangepassword');
            form.parsley().validate();
            if (form.parsley().isValid()) {
                let btnSubmit = $('#btnsave')
                let question = 'Yakin ingin menggganti password anda?';
                message.question(question).then(answer => {
                    let yes = parseMessageResult(answer);
                    if (yes) {
                        let formValues = form.serialize();
                        let actUrl = base_url + '/profile/update-password';
                        btnSubmit.prop('disabled', true);
                        ajax_post(actUrl, formValues, {
                            success: function(response) {
                                if (response.success) {
                                    if (response.result.success) {
                                        form[0].reset();
                                        notification.success(response.result.message);
                                        form.parsley().reset();
                                    } else {
                                        message.error(response.result.message);
                                    }
                                }
                                btnSubmit.prop('disabled', false);

                            },
                            error: function(response) {
                                btnSubmit.prop('disabled', false);
                            }
                        });

                    }
                })

            }
        })
    })
</script>
<?= $this->endSection() ?>