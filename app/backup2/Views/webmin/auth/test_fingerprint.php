<?php
$themeUrl = base_url('assets/adminlte3');
$assetsUrl = base_url('assets');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Test Fingerprint</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= $themeUrl ?>/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= $themeUrl ?>/dist/css/adminlte.min.css">

    <link rel="stylesheet" href="<?= $assetsUrl ?>/plugins/fingerprint/fingerprint.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a class="h1">Test Fingerprint</a>
            </div>
            <div class="card-body">
                <div class="fp_message"></div>

                <div class="form-group">
                    <label for="fp_reader" class="col-sm-12">Fingerprint Reader</label>
                    <div class="col-sm-12">
                        <select class="form-control" id="fp_reader" name="fp_reader" required>
                            <option>Select Fingerprint Reader</option>
                        </select>
                    </div>
                </div>

                <div id="fp_verificationfingers">
                    <div id="fp_verificationfinger" class="col mb-md-0 text-center">
                        <span class="icon icon-indexfinger-not-enrolled" title="not_enrolled"></span>
                    </div>
                </div>

                <table id="result" width="100%">
                    <tr>
                        <th></th>
                        <td></td>
                        <td></td>
                    </tr>
                </table>



                <div class="social-auth-links text-center mt-2 mb-3">
                    <button class="btn btn-block btn-primary">
                        <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
                    </button>
                    <button href="#" class="btn btn-block btn-danger">
                        <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
                    </button>
                </div>
                <!-- /.social-auth-links -->

                <p class="mb-1">
                    <a href="forgot-password.html">I forgot my password</a>
                </p>
                <p class="mb-0">
                    <a href="register.html" class="text-center">Register a new membership</a>
                </p>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="<?= $themeUrl ?>/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= $themeUrl ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= $themeUrl ?>/dist/js/adminlte.js"></script>

    <script src="<?= $assetsUrl ?>/plugins/fingerprint/js/es6-shim.js"></script>
    <script src="<?= $assetsUrl ?>/plugins/fingerprint/js/websdk.client.bundle.min.js"></script>
    <script src="<?= $assetsUrl ?>/plugins/fingerprint/js/fingerprint.sdk.min.js"></script>
</body>

</html>