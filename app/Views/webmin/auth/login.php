<?php
$theme_path = base_url('assets/adminlte3');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?= $theme_path ?>/plugins/fontawesome-free/css/all.min.css">
	<!-- icheck bootstrap -->
	<link rel="stylesheet" href="<?= $theme_path ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?= $theme_path ?>/dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
	<div class="login-box">
		<!-- /.login-logo -->
		<div class="card card-outline card-primary">
			<div class="card-header text-center">
				<a href="javascript:void(0);" class="h1"><b><?= APPS_NAME ?></b></a>
			</div>
			<div class="card-body">
				<?php
				if ($alert != NULL) :
				?>
					<div class="alert alert-<?= esc($alert['type']) ?>"><?= esc($alert['message']) ?></div>
				<?php
				endif;
				?>

				<?php
				if ($input != NULL) {
					$username = esc($input['username']);
					$password = esc($input['password']);
				} else {
					$username = '';
					$password = '';
				}
				?>
				<form action="<?= base_url('webmin/auth/login') ?>" method="POST">
					<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
					<div class="input-group mb-3">
						<input id="username" name="username" type="text" class="form-control" placeholder="Username" value="<?= $username ?>" required>
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-user"></span>
							</div>
						</div>
					</div>
					<div class="input-group mb-3">
						<input id="password" name="password" type="password" class="form-control" placeholder="Password" value="<?= $password ?>" required>
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-lock"></span>
							</div>
						</div>
					</div>
					<div class="row">
						<!-- /.col -->
						<div class="col-12">
							<button type="submit" class="btn btn-primary btn-block col-12">Login</button>
						</div>
						<!-- /.col -->
					</div>
				</form>

				<!-- /.social-auth-links -->
				<!--
				<p class="mb-1">
					<a href="forgot-password.html">I forgot my password</a>
				</p>
				<p class="mb-0">
					<a href="register.html" class="text-center">Register a new membership</a>
				</p>
				-->
			</div>
			<!-- /.card-body -->
		</div>
		<!-- /.card -->
	</div>
	<!-- /.login-box -->

	<!-- jQuery -->
	<script src="<?= $theme_path ?>/plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap 4 -->
	<script src="<?= $theme_path ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- AdminLTE App -->
	<script src="<?= $theme_path ?>/dist/js/adminlte.min.js"></script>
</body>

</html>