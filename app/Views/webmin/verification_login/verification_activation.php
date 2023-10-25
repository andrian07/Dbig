<?php
$themeUrl = base_url('assets/adminlte3');
$assetsUrl = base_url('assets');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi Login</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= $themeUrl ?>/plugins/fontawesome-free/css/all.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?= $themeUrl ?>/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="<?= $themeUrl ?>/plugins/toastr/toastr.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= $themeUrl ?>/dist/css/adminlte.min.css">
</head>

<body class="hold-transition lockscreen">
    <!-- Automatic element centering -->
    <div class="lockscreen-wrapper">
        <div class="lockscreen-logo">
            <a href="#"><b><?= APPS_NAME ?></b></a>
        </div>
        <h4 class="text-center">Verifikasi Login</h4>
        <table class="table table-striped">
            <tr>
                <th width="120px">Username</th>
                <td>: <?= esc($userData['user_name']) ?></td>
            </tr>
            <tr>
                <th>Nama User</th>
                <td>: <?= esc($userData['user_realname']) ?></td>
            </tr>
            <tr>
                <th>IP</th>
                <td>: <?= esc($userData['login_ip']) ?></td>
            </tr>
            <tr>
                <th>Agent</th>
                <td>: <?= esc($userData['login_agent']) ?></td>
            </tr>
            <tr>
                <th>Platform</th>
                <td>: <?= esc($userData['login_platform']) ?></td>
            </tr>

        </table>


        <!-- START LOCK SCREEN ITEM -->
        <div class="lockscreen-item">

            <div class="alert alert-info">
                <h5>KODE SESSION : <?= $userData['session_code'] ?></h5>
            </div>
            <!-- lockscreen image -->
            <!--
            <div class="lockscreen-image">
                <img src="<?= $themeUrl ?>/dist/img/avatar5.png" alt="User Image">
            </div>
            -->
            <!-- /.lockscreen-image -->

            <!-- lockscreen credentials (contains the form) -->
            <!--
            <form class="lockscreen-credentials">
                <div class="input-group">
                    <input type="password" class="form-control" placeholder="password">

                    <div class="input-group-append">
                        <button type="button" class="btn">
                            <i class="fas fa-arrow-right text-muted"></i>
                        </button>
                    </div>
                </div>
            </form>
            -->
            <!-- /.lockscreen credentials -->

        </div>
        <!-- /.lockscreen-item -->

        <div class="text-center">
            <button id="btnconfirm" class="btn btn-primary" onclick="window.location.href='<?= $confirmUri ?>'">Berikan Ijin Akses</button>
        </div>
        <div class="lockscreen-footer text-center">
            Copyright &copy; 2014-2021 <b><a href="https://adminlte.io" class="text-black">AdminLTE.io</a></b><br>
            All rights reserved
        </div>
    </div>
    <!-- /.center -->

    <!-- jQuery -->
    <script>
        const base_url = '<?= base_url() ?>';
        let csrfName = '<?= csrf_token() ?>'; // CSRF Token name
        let csrfHash = '<?= csrf_hash() ?>'; // CSRF hash
    </script>
    <script src="<?= $themeUrl ?>/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= $themeUrl ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="<?= $themeUrl ?>/plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="<?= $themeUrl ?>/plugins/toastr/toastr.min.js"></script>



</body>

</html>