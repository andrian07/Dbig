<?php
$themeUrl = base_url('assets/adminlte3');
$assetsUrl = base_url('assets');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="/favicon.ico" />

	<title><?= isset($title) ? APPS_NAME . ' - ' . $title : APPS_NAME ?></title>

	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?= $themeUrl ?>/plugins/fontawesome-free/css/all.min.css">

	<!-- Ionicons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

	<!-- flag-icon-css -->
	<link rel="stylesheet" href="<?= $themeUrl ?>/plugins/flag-icon-css/css/flag-icon.min.css">

	<!-- JQuery Loading Modal -->
	<link rel="stylesheet" href="<?= $assetsUrl ?>/plugins/JQueryLoadingModal/css/jquery.loadingModal.min.css">

	<!-- SweetAlert2 -->
	<link rel="stylesheet" href="<?= $themeUrl ?>/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

	<!-- Toastr -->
	<link rel="stylesheet" href="<?= $themeUrl ?>/plugins/toastr/toastr.min.css">

	<!-- iCheck -->
	<link rel="stylesheet" href="<?= $themeUrl ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">

	<!-- Select2 -->
	<link rel="stylesheet" href="<?= $themeUrl ?>/plugins/select2/css/select2.min.css">
	<link rel="stylesheet" href="<?= $themeUrl ?>/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

	<!-- DataTables -->
	<link rel="stylesheet" href="<?= $themeUrl ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="<?= $themeUrl ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
	<link rel="stylesheet" href="<?= $themeUrl ?>/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

	<!-- fancybox -->
	<link rel="stylesheet" href="<?= $assetsUrl ?>/plugins/fancybox-master/dist/jquery.fancybox.min.css">

	<!-- Parsley -->
	<link rel="stylesheet" href="<?= $assetsUrl ?>/plugins/parsleyjs/dist/parsley.min.css">

	<!-- x-editable -->
	<link rel="stylesheet" href="<?= $assetsUrl ?>/plugins/bootstrap3-editable-1.5.1/bootstrap3-editable/css/bootstrap-editable.css">

	<!-- Jquery Ui -->
	<link rel="stylesheet" href="<?= $themeUrl ?>/plugins/jquery-ui/jquery-ui.min.css">

	<!-- Theme style -->
	<link rel="stylesheet" href="<?= $themeUrl ?>/dist/css/adminlte.min.css">

	<!-- overlayScrollbars -->
	<link rel="stylesheet" href="<?= $themeUrl ?>/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">

	<!-- My Css -->
	<link rel="stylesheet" href="<?= $assetsUrl ?>/app/app.css">
	<link rel="stylesheet" href="<?= $assetsUrl ?>/app/pos.css">
	<style>
		.table-product-price {
			font-size: 20px;

		}



		.table-product-price .label-price {
			font-size: 30px;
		}

		.table-history-scan {
			font-size: 18px;
		}
	</style>
	<!-- Tempusdominus Bootstrap 4 -->
	<link rel="stylesheet" href="<?= $themeUrl ?>/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

</head>

<body class="hold-transition sidebar-collapse layout-top-nav">
	<div class="wrapper">
		<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
			<div class="container">
				<a href="<?= base_url('pos/dashboard') ?>" class="navbar-brand">
					<img src="<?= base_url('assets/images/logo.png') ?>" alt="d'BIG Logo" class="brand-image " style="opacity: .8">
				</a>
				<button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse order-3" id="navbarCollapse">
					<!-- <ul class="navbar-nav">
						<li class="nav-item">
							<a href="<?= base_url('pos/dashboard') ?>" class="nav-link">Dashboard</a>
						</li>
						<li class="nav-item">
							<a href="<?= base_url('pos/sales') ?>" class="nav-link">Penjualan</a>
						</li>
						<li class="nav-item">
							<a href="<?= base_url('pos/sales-return') ?>" class="nav-link">Retur Penjualan</a>
						</li>
						<li class="nav-item">
							<a href="<?= base_url('pos/auth/logout') ?>" target="_blank" class="nav-link text-danger"><i class="fas fa-power-off"></i> Logout</a>
						</li>
						</ul>
						-->
				</div>

				<ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
					<li class="nav-item">
						<a class="nav-link">
							<i class="fa fa-calendar text-primary"></i> <span id="current-date" class="text-dark">24 Agustus 2022</span>
							<i class="fa fa-clock text-primary"></i> <span id="current-time" class="text-dark">22:00:00</span>
						</a>
					</li>

					<li class="nav-item">
						<a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
							<i class="fas fa-th-large"></i>
						</a>
					</li>
				</ul>
			</div>
		</nav>

		<aside class="main-sidebar sidebar-dark-primary elevation-4">
			<a href="#" class="brand-link">
				<span class="brand-text font-weight-light">AdminLTE 3</span>
			</a>

			<div class="sidebar">
				<div class="user-panel mt-3 pb-3 mb-3 d-flex">
					<div class="image">
					</div>
					<div class="info">
						<a href="#" class="d-block">Alexander Pierce</a>
					</div>
				</div>



				<nav class="mt-2">
					<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="nav-icon fas fa-tachometer-alt"></i>
								<p>
									Dashboard
									<i class="right fas fa-angle-left"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="../../index.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Dashboard v1</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="../../index2.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Dashboard v2</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="../../index3.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Dashboard v3</p>
									</a>
								</li>
							</ul>
						</li>



					</ul>
				</nav>

			</div>

		</aside>

		<div class="content-wrapper">
			<div class="content-header">
				<div class="container">
					<div class="row">

					</div>
				</div>
			</div>


			<div class="content">
				<div class="container">
					<div class="row">
						<div class="col-lg-12">
							<div class="card card-primary card-outline">
								<div class="card-body">
									<div class="row">
										<div class="col-md-12">
											<div class="row">
												<div class="col-md-8">
													<div class="form-group">
														<label><i class="fas fa-search"></i> CEK HARGA</label>
														<input id="scanner" name="scanner" type="text" class="form-control fs-20" placeholder="Scan barcode atau ketik manual dan tekan [ENTER]" value="" required>
													</div>
												</div>
											</div>
										</div>

										<div class="col-md-12 border-top border-primary">
											<div class="row">
												<div class="col-12">
													<table width="100%" class="table table-product-price">
														<tr>
															<th width="15%">Barcode</th>
															<td width="1%">:</td>
															<td>1234567890123</td>
														</tr>
														<tr>
															<th>Nama Produk</th>
															<td>:</td>
															<td>Indomie Kaldu Ayam</td>
														<tr>
														<tr>
															<th>Harga</th>
															<td>:</td>
															<td>
																<sup>Rp</sup>&nbsp;&nbsp;<del>99,999,999.00</del> sampai 02 Agustus 2022 <br>
																<span class="label-price"><sup>Rp</sup>&nbsp;&nbsp;99,999,999.00 per BKS</span>

															</td>
														<tr>
													</table>
												</div>
											</div>
										</div>
									</div>




								</div>
							</div>


							<div class="card card-outline">
								<div class="card-body">
									<div class="row">
										<div class="col-md-12">
											<table width="100%" class="table table-bordered table-striped table-history-scan">
												<thead>
													<tr>
														<th>Barcode</th>
														<th>Nama Produk</th>
														<th>Harga</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>1234567890</td>
														<td>Indomie Kaldu Ayam</td>
														<td>Rp 99,999,999.00</td>
													</tr>
													<tr>
														<td>1234567890</td>
														<td>Indomie Kaldu Ayam</td>
														<td>
															<del>Rp 99,999,999.00</del><br>
															Rp 99,999,999.00
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>





								</div>
							</div>
						</div>

					</div>

				</div>
			</div>
		</div>


		<aside class="control-sidebar control-sidebar-dark"></aside>
	</div>


	<script>
		const base_url = '<?= base_url() ?>';
		const PPN = <?= PPN ?>;
		const PPN_TEXT = '<?= PPN_TEXT ?>';

		const THOUSAND_SEPARATOR = '<?= THOUSAND_SEPARATOR ?>';
		const DECIMAL_SEPARATOR = '<?= DECIMAL_SEPARATOR ?>';
		const DECIMAL_DIGIT = <?= DECIMAL_DIGIT ?>;

		let csrfName = '<?= csrf_token() ?>'; // CSRF Token name
		let csrfHash = '<?= csrf_hash() ?>'; // CSRF hash
	</script>

	<!-- jQuery -->
	<script src="<?= $themeUrl ?>/plugins/jquery/jquery.min.js"></script>
	<!-- jQuery UI 1.11.4 -->
	<script src="<?= $themeUrl ?>/plugins/jquery-ui/jquery-ui.min.js"></script>
	<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
	<script>
		$.widget.bridge('uibutton', $.ui.button)
	</script>

	<!-- Bootstrap 4 -->
	<script src="<?= $themeUrl ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

	<!-- moment -->
	<script src="<?= $themeUrl ?>/plugins/moment/moment.min.js"></script>

	<!-- JQuery Loading Modal -->
	<script src="<?= $assetsUrl ?>/plugins/JQueryLoadingModal/js/jquery.loadingModal.min.js"></script>

	<!-- Select2 -->
	<script src="<?= $themeUrl ?>/plugins/select2/js/select2.full.min.js"></script>

	<!-- tinymce -->
	<script src="<?= $assetsUrl ?>/plugins/tinymce/tinymce.min.js"></script>

	<!-- DataTables  & Plugins -->
	<script type="text/javascript">
		let lang_datatables = '<?= $themeUrl ?>/plugins/datatables/language/id.json';
	</script>
	<script src="<?= $themeUrl ?>/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="<?= $themeUrl ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="<?= $themeUrl ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
	<script src="<?= $themeUrl ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
	<script src="<?= $themeUrl ?>/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
	<script src="<?= $themeUrl ?>/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
	<script src="<?= $themeUrl ?>/plugins/jszip/jszip.min.js"></script>
	<script src="<?= $themeUrl ?>/plugins/pdfmake/pdfmake.min.js"></script>
	<script src="<?= $themeUrl ?>/plugins/pdfmake/vfs_fonts.js"></script>
	<script src="<?= $themeUrl ?>/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
	<script src="<?= $themeUrl ?>/plugins/datatables-buttons/js/buttons.print.min.js"></script>
	<script src="<?= $themeUrl ?>/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

	<!-- fancybox -->
	<script src="<?= $assetsUrl ?>/plugins/fancybox-master/dist/jquery.fancybox.min.js"></script>

	<!-- ParsleyJS -->
	<script src="<?= $assetsUrl ?>/plugins/parsleyjs/dist/parsley.min.js"></script>
	<script src="<?= $assetsUrl ?>/plugins/parsleyjs/dist/i18n/id.js"></script>

	<!-- x-editable -->
	<script src="<?= $assetsUrl ?>/plugins/bootstrap3-editable-1.5.1/bootstrap3-editable/js/bootstrap-editable.min.js"></script>

	<!-- Tempusdominus Bootstrap 4 -->
	<script src="<?= $themeUrl ?>/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>

	<!-- SweetAlert2 -->
	<script src="<?= $themeUrl ?>/plugins/sweetalert2/sweetalert2.min.js"></script>

	<!-- Toastr -->
	<script src="<?= $themeUrl ?>/plugins/toastr/toastr.min.js"></script>

	<!-- AutoNumeric -->
	<script src="<?= $assetsUrl ?>/plugins/autonumeric/autoNumeric.min.js"></script>

	<!-- overlayScrollbars -->
	<script src="<?= $themeUrl ?>/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
	<!-- AdminLTE App -->
	<script src="<?= $themeUrl ?>/dist/js/adminlte.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="<?= $themeUrl ?>/dist/js/demo.js"></script>

	<!-- My JS -->
	<script src="<?= $assetsUrl ?>/app/theme.js"></script>
	<script src="<?= $assetsUrl ?>/app/app.js?ver=<?= date('dmYHis') ?>"></script>

</body>


</html>