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

        <table class="table table-striped">
            <tr>
                <th width="120px">Username</th>
                <td>: <?= esc($userLogin['user_name']) ?></td>
            </tr>
            <tr>
                <th>Nama User</th>
                <td>: <?= esc($userLogin['user_realname']) ?></td>
            </tr>
            <tr>
                <th>Sisa durasi</th>
                <td id="exp-duration">: 00:00:00</td>
            </tr>
        </table>


        <!-- START LOCK SCREEN ITEM -->
        <div class="lockscreen-item">

            <div class="alert alert-info">
                <h5>KODE SESSION : <?= $userLogin['session_code'] ?></h5>
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
        <div class="help-block text-center">
            Harap tunggu verifikasi login dari admin.
        </div>
        <div class="text-center">
            <button id="btncheckstatus" class="btn btn-primary" disabled>Cek Status</button>
            <button class="btn btn-danger" onclick="window.location.href='<?= base_url('webmin/auth/logout') ?>'">Logout</button>
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


    <script>
        <?php
        $duration = $userLogin['exp_login'] - time();
        ?>
        //in seconds
        let exp_duration = <?= $duration ?>;


        const minute = 60;
        const hour = 60 * 60;

        function formatDuration(seconds) {
            if (isNaN(seconds)) {
                return "Invalid input";
            }

            const hours = Math.floor(seconds / 3600);
            const minutes = Math.floor((seconds % 3600) / 60);
            const remainingSeconds = seconds % 60;

            const formattedHours = String(hours).padStart(2, "0");
            const formattedMinutes = String(minutes).padStart(2, "0");
            const formattedSeconds = String(remainingSeconds).padStart(2, "0");

            return `${formattedHours}:${formattedMinutes}:${formattedSeconds}`;
        }


        $('#exp-duration').html(': ' + formatDuration(exp_duration));


        setInterval(function() {
            exp_duration--;
            if (exp_duration < 0) {
                window.location.reload();
            }
            $('#exp-duration').html(': ' + formatDuration(exp_duration));
        }, 1000);

        $(document).ready(function() {
            // Ajax Helper //
            const ajaxErrorText =
                "Terjadi kesalahan dalam menjalankan perintah. Harap coba lagi";

            function printError(error, explicit) {
                let print = `[${explicit ? "EXPLICIT" : "INEXPLICIT"}] ${error.name}: ${
    error.message
  }`;
                console.log(print);
                return print;
            }

            function parseJSON(json_val) {
                let parse;
                let is_json;
                let error;
                try {
                    parse = JSON.parse(json_val);
                    is_json = true;
                    error = "";
                } catch (e) {
                    parse = JSON.parse("{}");
                    is_json = false;
                    if (e instanceof SyntaxError) {
                        error = printError(e, true);
                    } else {
                        error = printError(e, false);
                    }
                }
                return [parse, is_json, error];
            }

            let message = {
                success: function(_message, _title = "Info") {
                    return Swal.fire({
                        title: _title,
                        html: _message,
                        allowOutsideClick: false,
                        icon: "success",
                    });
                },
                info: function(_message, _title = "Info") {
                    return Swal.fire({
                        title: _title,
                        html: _message,
                        allowOutsideClick: false,
                        icon: "info",
                    });
                },
                warning: function(_message, _title = "Peringatan") {
                    return Swal.fire({
                        title: _title,
                        html: _message,
                        icon: "warning",
                        showCancelButton: true,
                        allowOutsideClick: false,
                        cancelButtonColor: "#d33",
                        confirmButtonText: buttons.yes,
                        cancelButtonText: buttons.cancel,
                    });
                },
                question: function(_message, _title = "Konfirmasi") {
                    return Swal.fire({
                        title: _title,
                        html: _message,
                        icon: "question",
                        showCancelButton: true,
                        allowOutsideClick: false,
                        cancelButtonColor: "#d33",
                        confirmButtonText: buttons.yes,
                        cancelButtonText: buttons.cancel,
                    });
                },
                error: function(_message, _title = "Error") {
                    return Swal.fire({
                        title: _title,
                        html: _message,
                        icon: "error",
                        allowOutsideClick: false,
                    });
                },
            };

            function ajax_get(_url, _data = null, _callback = {}, _async = true) {
                let results = {
                    success: false,
                    result: {}
                };
                $.ajax({
                    url: _url,
                    data: _data,
                    async: _async,
                    beforeSend: function() {
                        if (typeof _callback.beforeSend === "function") {
                            _callback.beforeSend();
                        }
                    },
                    success: function(request_results) {
                        let [json, is_json, error] = parseJSON(request_results);
                        results = {
                            success: true,
                            result: json,
                        };
                        if (typeof _callback.success === "function") {
                            _callback.success(results);
                        }
                    },
                    error: function() {

                        results = {
                            success: false,
                            result: {},
                        };
                        message.error(ajaxErrorText);
                        if (typeof _callback.error === "function") {
                            _callback.error(results);
                        }
                    },
                    complete: function() {
                        if (typeof _callback.complete === "function") {
                            _callback.complete();
                        }
                    },
                });
                return results;
            }

            $('#btncheckstatus').prop('disabled', false);

            function checkStatus() {
                const btn = $('#btncheckstatus');

                const actUrl = base_url + '/webmin/verification-login/check-status';

                ajax_get(actUrl, {}, {
                    beforeSend: function() {
                        btn.prop('disabled', true);
                    },
                    success: function(response) {
                        btn.prop('disabled', false);
                        if (response.success) {
                            if (response.result.is_valid) {
                                window.location.href = base_url + "/webmin/profile";
                            } else {
                                message.error(response.result.message);
                            }
                        }
                    },
                    error: function(response) {
                        btn.prop('disabled', false);
                    }
                });
            }

            $('#btncheckstatus').click(function(e) {
                e.preventDefault();
                const btn = $('#btncheckstatus');

                const actUrl = base_url + '/webmin/verification-login/check-status';

                ajax_get(actUrl, {}, {
                    beforeSend: function() {
                        btn.prop('disabled', true);
                    },
                    success: function(response) {
                        btn.prop('disabled', false);
                        if (response.success) {
                            if (response.result.is_valid) {
                                window.location.href = base_url + "/webmin/profile";
                            } else {
                                message.error(response.result.message);
                            }
                        }
                    },
                    error: function(response) {
                        btn.prop('disabled', false);
                    }
                });

            })

            setInterval(function() {
                const btn = $('#btncheckstatus');

                const actUrl = base_url + '/webmin/verification-login/check-status';

                ajax_get(actUrl, {}, {
                    beforeSend: function() {
                        btn.prop('disabled', true);
                    },
                    success: function(response) {
                        btn.prop('disabled', false);
                        if (response.success) {
                            if (response.result.is_valid) {
                                window.location.href = base_url + "/webmin/profile";
                            }
                        }
                    },
                    error: function(response) {
                        btn.prop('disabled', false);
                    }
                });
            }, 5000);
        })
    </script>
</body>

</html>