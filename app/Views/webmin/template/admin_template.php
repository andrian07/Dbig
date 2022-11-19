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

	<!-- Tempusdominus Bootstrap 4 -->
	<link rel="stylesheet" href="<?= $themeUrl ?>/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

	<?= $this->renderSection('css') ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse">
	<div class="wrapper">
		<!-- Preloader -->
		<div class="preloader flex-column justify-content-center align-items-center">
			<img src="<?= base_url('assets/images/logo.png') ?>" alt="d'BIG Logo" height="100" width="200">
		</div>

		<?= $this->include('webmin/template/navbar') ?>
		<?= $this->include('webmin/template/sidebar') ?>

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<?= $this->renderSection('content') ?>
		</div>

		<!-- /.content-wrapper -->
		<footer class="main-footer">
			<strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
			All rights reserved.
			<div class="float-right d-none d-sm-inline-block">
				<b>Version</b> 3.1.0
			</div>
		</footer>

		<!-- Control Sidebar -->
		<aside class="control-sidebar control-sidebar-dark">
			<!-- Control sidebar content goes here -->
		</aside>
		<!-- /.control-sidebar -->
	</div>
	<!-- ./wrapper -->

	<script>
		const base_url = '<?= base_url() ?>';
		const user_role = <?= json_encode($user_role) ?>;
		const PPN = <?= PPN ?>;
		const PPN_TEXT = '<?= PPN_TEXT ?>';

		const THOUSAND_SEPARATOR = '<?= THOUSAND_SEPARATOR ?>';
		const DECIMAL_SEPARATOR = '<?= DECIMAL_SEPARATOR ?>';
		const DECIMAL_DIGIT = <?= DECIMAL_DIGIT ?>;

		const max_upload_size = <?= json_encode($max_upload_size) ?>;
		const upload_file_type = <?= json_encode($upload_file_type) ?>;

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
	<script src="<?= $assetsUrl ?>/app/helper.js?ver=<?= date('dmYHis') ?>"></script>
	<?= $this->renderSection('js') ?>
</body>

</html>