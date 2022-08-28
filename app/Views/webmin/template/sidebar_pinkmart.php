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

				<?php if ($role->hasRole('dashboard.view')) : ?>
					<li class="nav-item">
						<a href="<?= base_url('dashboard') ?>" class="nav-link">
							<i class="nav-icon fas fa-tachometer-alt"></i>
							<p>
								Dashboard
								<span class="right badge badge-danger"></span>
							</p>
						</a>
					</li>
				<?php endif; ?>

				<?php if ($role->hasRole('category.view') || $role->hasRole('unit.view') || $role->hasRole('product.view') || $role->hasRole('supplier.view') || $role->hasRole('customer.view')) : ?>
					<li class="nav-item">
						<a href="javascript:void(0)" class="nav-link">
							<i class="nav-icon fas fa-newspaper"></i>
							<p>
								Master Data
								<i class="right fas fa-angle-left"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">
							<?php if ($role->hasRole('category.view')) : ?>
								<li class="nav-item">
									<a href="<?= base_url('category') ?>" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Kategori</p>
									</a>
								</li>
							<?php endif; ?>

							<?php if ($role->hasRole('unit.view')) : ?>
								<li class="nav-item">
									<a href="<?= base_url('unit') ?>" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Satuan</p>
									</a>
								</li>
							<?php endif; ?>

							<?php if ($role->hasRole('product.view')) : ?>
								<li class="nav-item">
									<a href="<?= base_url('product') ?>" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Produk</p>
									</a>
								</li>
							<?php endif; ?>

							<?php if ($role->hasRole('supplier.view')) : ?>
								<li class="nav-item">
									<a href="<?= base_url('supplier') ?>" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Supplier</p>
									</a>
								</li>
							<?php endif; ?>

							<?php if ($role->hasRole('customer.view')) : ?>
								<li class="nav-item">
									<a href="<?= base_url('customer') ?>" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Customer</p>
									</a>
								</li>
							<?php endif; ?>
						</ul>
					</li>
				<?php endif; ?>

				<?php if ($role->hasRole('promo.view')) : ?>
					<li class="nav-item">
						<a href="<?= base_url('promo') ?>" class="nav-link">
							<i class="nav-icon fas fa-percent"></i>
							<p>
								Promo
								<span class="right badge badge-danger"></span>
							</p>
						</a>
					</li>
				<?php endif; ?>

				<?php if ($role->hasRole('stock_opname.view')) : ?>
					<li class="nav-item">
						<a href="<?= base_url('stock-opname') ?>" class="nav-link">
							<i class="nav-icon fas fa-box"></i>
							<p>
								Stok Opname
								<span class="right badge badge-danger"></span>
							</p>
						</a>
					</li>
				<?php endif; ?>

				<?php if ($role->hasRole('purchase_order.view') || $role->hasRole('purchase.view') || $role->hasRole('purchase_return.view')) : ?>
					<li class="nav-item">
						<a href="javascript:void(0)" class="nav-link">
							<i class="nav-icon fas fa-shopping-cart"></i>
							<p>
								Transaksi Pembelian
								<i class="right fas fa-angle-left"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">
							<?php if ($role->hasRole('purchase_order.view')) : ?>
								<li class="nav-item">
									<a href="<?= base_url('purchase-order') ?>" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Pesanan Pembelian</p>
									</a>
								</li>
							<?php endif; ?>

							<?php if ($role->hasRole('purchase.view')) : ?>
								<li class="nav-item">
									<a href="<?= base_url('purchase') ?>" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Pembelian</p>
									</a>
								</li>
							<?php endif; ?>

							<?php if ($role->hasRole('purchase.repayment')) : ?>
								<li class="nav-item">
									<a href="<?= base_url('purchase-repayment') ?>" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Pelunasan Hutang</p>
									</a>
								</li>
							<?php endif; ?>

							<?php if ($role->hasRole('purchase_return.view')) : ?>
								<li class="nav-item">
									<a href="<?= base_url('purchase-return') ?>" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Retur Pembelian</p>
									</a>
								</li>
							<?php endif; ?>
						</ul>
					</li>
				<?php endif; ?>

				<?php if ($role->hasRole('sales.view') || $role->hasRole('sales_return.view')) : ?>
					<li class="nav-item">
						<a href="javascript:void(0)" class="nav-link">
							<i class="nav-icon fas fa-shopping-cart"></i>
							<p>
								Transaksi Penjualan
								<i class="right fas fa-angle-left"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">
							<?php if ($role->hasRole('sales.view')) : ?>
								<li class="nav-item">
									<a href="<?= base_url('sales') ?>" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Penjualan</p>
									</a>
								</li>
							<?php endif; ?>

							<?php if ($role->hasRole('sales_return.view')) : ?>
								<li class="nav-item">
									<a href="<?= base_url('sales-return') ?>" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Retur Penjualan</p>
									</a>
								</li>
							<?php endif; ?>
						</ul>
					</li>
				<?php endif; ?>

				<?php if ($role->hasRole('pos.view')) : ?>
					<li class="nav-item">
						<a href="<?= base_url('pos') ?>" class="nav-link">
							<i class="nav-icon fas fa-desktop"></i>
							<p>
								Point of Sales
								<span class="right badge badge-danger"></span>
							</p>
						</a>
					</li>
				<?php endif; ?>

				<?php if ($role->hasRole('password_control.view')) : ?>
					<li class="nav-item">
						<a href="<?= base_url('password-control') ?>" class="nav-link">
							<i class="nav-icon fas fa-key"></i>
							<p>
								Password Control
								<span class="right badge badge-danger"></span>
							</p>
						</a>
					</li>
				<?php endif; ?>


				<?php if ($role->hasRole('user_account.view') || $role->hasRole('user_group.view')) : ?>
					<li class="nav-item">
						<a href="javascript:void(0)" class="nav-link">
							<i class="nav-icon fas fa-user"></i>
							<p>
								Admin
								<i class="right fas fa-angle-left"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">
							<?php if ($role->hasRole('user_account.view')) : ?>
								<li class="nav-item">
									<a href="<?= base_url('user-account') ?>" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Akun Pengguna</p>
									</a>
								</li>
							<?php endif; ?>
							<?php if ($role->hasRole('user_group.view')) : ?>
								<li class="nav-item">
									<a href="<?= base_url('user-group') ?>" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Grup Pengguna</p>
									</a>
								</li>
							<?php endif; ?>
						</ul>
					</li>
				<?php endif; ?>



				<?php if ($role->hasRole('accounting.view')) : ?>
					<li class="nav-item">
						<a href="javascript:void(0)" class="nav-link">
							<i class="nav-icon fas fa-book"></i>
							<p>
								Akuntansi
								<i class="right fas fa-angle-left"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">
							<li class="nav-item">
								<a href="<?= base_url('accounting/account-group') ?>" class="nav-link">
									<i class="far fa-circle nav-icon"></i>
									<p>Grup Akun</p>
								</a>
								<a href="<?= base_url('accounting/account') ?>" class="nav-link">
									<i class="far fa-circle nav-icon"></i>
									<p>Akun</p>
								</a>
								<a href="<?= base_url('accounting/journal') ?>" class="nav-link">
									<i class="far fa-circle nav-icon"></i>
									<p>Jurnal</p>
								</a>
								<a href="<?= base_url('accounting/setting') ?>" class="nav-link">
									<i class="far fa-circle nav-icon"></i>
									<p>Pengaturan</p>
								</a>
							</li>
						</ul>
					</li>
				<?php endif; ?>

				<?php if ($role->hasRole('report.view')) : ?>
					<li class="nav-item">
						<a href="<?= base_url('report') ?>" class="nav-link">
							<i class="nav-icon fas fa-file"></i>
							<p>
								Laporan
								<span class="right badge badge-danger"></span>
							</p>
						</a>
					</li>
				<?php endif; ?>



				<li class="nav-item">
					<a id="btnlogout" href="<?= base_url('auth/logout') ?>" data-question="Yakin ingin keluar dari aplikasi?" class="nav-link">
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