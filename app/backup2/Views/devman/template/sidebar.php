<?php $themeUrl = base_url('assets/adminlte3'); ?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<!-- Brand Logo -->
	<a href="#" class="brand-link">
		<img src="<?= $themeUrl ?>/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
		<span class="brand-text font-weight-light">
			<h3>DEVMAN</h3>
		</span>
	</a>

	<!-- Sidebar -->
	<div class="sidebar">
		<!-- Sidebar user panel (optional) -->
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image">
				<img src="<?= $themeUrl ?>/dist/img/avatar5.png" class="img-circle elevation-2" alt="User Photo">
			</div>
			<div class="info">
				<a href="#" class="d-block">DEV</a>
			</div>
		</div>

		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<!-- Add icons to the links using the .nav-icon class
			   with font-awesome or any other icon font library -->

				<li class="nav-item">
					<a href="<?= base_url('devman/log-queries') ?>" class="nav-link">
						<i class="nav-icon fas fa-history"></i>
						<p>
							Log Queries
							<span class="right badge badge-danger"></span>
						</p>
					</a>
				</li>


				<li class="nav-item">
					<a id="btnlogout" href="<?= base_url('devman/auth/logout') ?>" data-question="Yakin ingin keluar dari aplikasi?" class="nav-link">
						<i class="nav-icon fas fa-power-off text-danger"></i>
						<p class="text text-danger"><b>Logout</b></p>
					</a>
				</li>

			</ul>
		</nav>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>