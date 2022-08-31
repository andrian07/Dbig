<?php $themeUrl = base_url('assets/adminlte3'); ?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<!-- Brand Logo -->
	<a href="<?= base_url('profile') ?>" class="brand-link">
		<img src="<?= $themeUrl ?>/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
		<span class="brand-text font-weight-light">
			<h3><?= APPS_NAME ?></h3>
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
				<a href="<?= base_url('profile') ?>" class="d-block"><?= $user['user_realname'] ?></a>
			</div>
		</div>

		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<!-- Add icons to the links using the .nav-icon class
			   with font-awesome or any other icon font library -->

				<li class="nav-item">
					<a href="<?= base_url('webmin/category') ?>" class="nav-link">
						<i class="nav-icon fas fa-tachometer-alt"></i>
						<p>
							Kategori
							<span class="right badge badge-danger"></span>
						</p>
					</a>
				</li>

				<li class="nav-item">
		            <a href="#" class="nav-link">
		              <i class="nav-icon fas fa-shopping-cart"></i>
		              <p>
		                 Transaksi
		                <i class="fas fa-angle-left right"></i>
		              </p>
		            </a>
		            <ul class="nav nav-treeview">
		              <li class="nav-item">
		                <a href="<?= base_url('webmin/submission') ?>" class="nav-link">
		                  <i class="far fa-circle nav-icon"></i>
		                  <p>Pengajuan</p>
		                  <span class="right badge badge-danger"></span>
		                </a>
		              </li>
		              <li class="nav-item">
		                <a href="<?= base_url('webmin/purchase-order') ?>" class="nav-link">
		                  <i class="far fa-circle nav-icon"></i>
		                  <p>Purchase Order</p>
		                  <span class="right badge badge-danger"></span>
		                </a>
		              </li>
		            </ul>
		         </li>

				<li class="nav-item">
					<a id="btnlogout" href="<?= base_url('webmin/auth/logout') ?>" data-question="Yakin ingin keluar dari aplikasi?" class="nav-link">
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