<?php $themeUrl = base_url('assets/adminlte3'); ?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<!-- Brand Logo -->
	<a href="<?= base_url('webmin/profile') ?>" class="brand-link">
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
				<a href="<?= base_url('webmin/profile') ?>" class="d-block"><?= $user['user_realname'] ?></a>
			</div>
		</div>

		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<!-- Add icons to the links using the .nav-icon class
			   with font-awesome or any other icon font library -->

				<?php if ($role->hasRole('dashboard.view')) : ?>
					<li class="nav-item">
						<a href="<?= base_url('webmin/dashboard') ?>" class="nav-link">
							<i class="nav-icon fas fa-tachometer-alt"></i>
							<p>
								Dashboard
								<span class="right badge badge-danger"></span>
							</p>
						</a>
					</li>
				<?php endif ?>

				<?php if ($role->hasRole('find_product.view')) : ?>
					<li class="nav-item">
						<a href="<?= base_url('webmin/product/view-info-product-v3') ?>" class="nav-link">
							<i class="nav-icon fas fa-search"></i>
							<p>
								Cari Produk
								<span class="right badge badge-danger"></span>
							</p>
						</a>
					</li>
				<?php endif ?>

				<?php if ($role->hasRole('brand.view') || $role->hasRole('category.view') || $role->hasRole('unit.view') || $role->hasRole('warehouse.view') || $role->hasRole('product.view') || $role->hasRole('supplier.view') || $role->hasRole('customer.view') || $role->hasRole('mapping_area.view') || $role->hasRole('salesman.view')) : ?>
					<li class="nav-item">
						<a href="javascript:void(0)" class="nav-link">
							<i class="nav-icon fas fa-newspaper"></i>
							<p>
								Master Data
								<i class="right fas fa-angle-left"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">

							<?php if ($role->hasRole('brand.view')) : ?>
								<li class="nav-item">
									<a href="<?= base_url('webmin/brand') ?>" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Brand</p>
									</a>
								</li>
							<?php endif ?>

							<?php if ($role->hasRole('category.view')) : ?>
								<li class="nav-item">
									<a href="<?= base_url('webmin/category') ?>" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Kategori</p>
									</a>
								</li>
							<?php endif ?>

							<?php if ($role->hasRole('unit.view')) : ?>
								<li class="nav-item">
									<a href="<?= base_url('webmin/unit') ?>" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Satuan</p>
									</a>
								</li>
							<?php endif ?>

							<?php if ($role->hasRole('warehouse.view')) : ?>
								<li class="nav-item">
									<a href="<?= base_url('webmin/warehouse') ?>" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Gudang</p>
									</a>
								</li>
							<?php endif ?>

							<?php if ($role->hasRole('product.view')) : ?>
								<li class="nav-item">
									<a href="<?= base_url('webmin/product') ?>" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Produk</p>
									</a>
								</li>
							<?php endif ?>

							<?php if ($role->hasRole('supplier.view')) : ?>
								<li class="nav-item">
									<a href="<?= base_url('webmin/supplier') ?>" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Supplier</p>
									</a>
								</li>
							<?php endif ?>

							<?php if ($role->hasRole('customer.view')) : ?>
								<li class="nav-item">
									<a href="<?= base_url('webmin/customer') ?>" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Customer</p>
									</a>
								</li>
							<?php endif ?>

							<?php if ($role->hasRole('mapping_area.view')) : ?>
								<li class="nav-item">
									<a href="<?= base_url('webmin/mapping-area') ?>" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Mapping Area</p>
									</a>
								</li>
							<?php endif ?>

							<?php if ($role->hasRole('salesman.view')) : ?>
								<li class="nav-item">
									<a href="<?= base_url('webmin/salesman') ?>" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Salesman</p>
									</a>
								</li>
							<?php endif ?>
						</ul>
					</li>
				<?php endif ?>


				<?php if ($role->hasRole('voucher.view')) : ?>
					<li class="nav-item">
						<a href="<?= base_url('webmin/voucher') ?>" class="nav-link">
							<i class="nav-icon fas fa-ticket-alt"></i>
							<p>
								Voucher
								<span class="right badge badge-danger"></span>
							</p>
						</a>
					</li>
				<?php endif ?>

				<?php if ($role->hasRole('stock_opname.view')) : ?>
					<li class="nav-item">
						<a href="<?= base_url('webmin/stock-opname') ?>" class="nav-link">
							<i class="nav-icon fas fa-box"></i>
							<p>
								Stok Opname
								<span class="right badge badge-danger"></span>
							</p>
						</a>
					</li>
				<?php endif ?>

				<?php if ($role->hasRole('transfer_stock.view')) : ?>
					<li class="nav-item">
						<a href="<?= base_url('webmin/stock-transfer') ?>" class="nav-link">
							<i class="nav-icon fas fa-exchange-alt"></i>
							<p>
								Transfer Stok
								<span class="right badge badge-danger"></span>
							</p>
						</a>
					</li>
				<?php endif ?>


				<?php if ($role->hasRole('point_reward.view') || $role->hasRole('point_exchange.view')) : ?>
					<li class="nav-item">
						<a href="javascript:void(0)" class="nav-link">
							<i class="nav-icon fas fa-coins"></i>
							<p>
								Poin Customer
								<i class="right fas fa-angle-left"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">
							<?php if ($role->hasRole('point_reward.view')) : ?>
								<li class="nav-item">
									<a href="<?= base_url('webmin/point-reward') ?>" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Hadiah Poin</p>
									</a>
								</li>
							<?php endif ?>

							<?php if ($role->hasRole('point_exchange.view')) : ?>
								<li class="nav-item">
									<a href="<?= base_url('webmin/point-exchange') ?>" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Penukaran Poin</p>
									</a>
								</li>
							<?php endif ?>
						</ul>
					</li>
				<?php endif ?>


				<?php if ($role->hasRole('submission.view') || $role->hasRole('purchase_order.view') || $role->hasRole('purchase.view') || $role->hasRole('retur_purchase.view')) : ?>
					<li class="nav-item">
						<a href="#" class="nav-link">
							<i class="nav-icon fas fa-shopping-cart"></i>
							<p>
								Transaksi Pembelian
								<i class="fas fa-angle-left right"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">
							<?php if ($role->hasRole('submission.view')) : ?>
								<li class="nav-item">
									<a href="<?= base_url('webmin/submission') ?>" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Pengajuan</p>
										<span class="right badge badge-danger"></span>
									</a>
								</li>
							<?php endif ?>

							<?php if ($role->hasRole('purchase_order.view')) : ?>
								<li class="nav-item">
									<a href="<?= base_url('webmin/purchase-order') ?>" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Purchase Order</p>
										<span class="right badge badge-danger"></span>
									</a>
								</li>
							<?php endif ?>

							<?php if ($role->hasRole('purchase.view')) : ?>
								<li class="nav-item">
									<a href="<?= base_url('webmin/purchase') ?>" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Pembelian</p>
										<span class="right badge badge-danger"></span>
									</a>
								</li>
							<?php endif ?>

							<?php if ($role->hasRole('retur_purchase.view')) : ?>
								<li class="nav-item">
									<a href="<?= base_url('webmin/retur') ?>" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Retur Pembelian</p>
										<span class="right badge badge-danger"></span>
									</a>
								</li>
							<?php endif ?>
						</ul>
					</li>
				<?php endif ?>


				<?php if ($role->hasRole('purchase_order_consignment.view') || $role->hasRole('input_consignment.view')) : ?>
					<li class="nav-item">
						<a href="#" class="nav-link">
							<i class="nav-icon fas fa-shopping-cart"></i>
							<p>
								Konsinyasi
								<i class="fas fa-angle-left right"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">
							<?php if ($role->hasRole('purchase_order_consignment.view')) : ?>
								<li class="nav-item">
									<a href="<?= base_url('webmin/consignment/purchase-order-consignment') ?>" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>PO Konsinyasi</p>
										<span class="right badge badge-danger"></span>
									</a>
								</li>
							<?php endif ?>

							<?php if ($role->hasRole('input_consignment.view')) : ?>
								<li class="nav-item">
									<a href="<?= base_url('webmin/consignment/stock-input-consignment') ?>" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Input Stok Konsinyasi</p>
										<span class="right badge badge-danger"></span>
									</a>
								</li>
							<?php endif ?>

						</ul>
					</li>
				<?php endif ?>

				<?php if ($role->hasRole('debt_repayment.view') || $role->hasRole('receivable_repayment.view')) : ?>
					<li class="nav-item">
						<a href="javascript:void(0)" class="nav-link">
							<i class="nav-icon fas fa-money-bill"></i>
							<p>
								Pelunasan
								<i class="right fas fa-angle-left"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">
							<?php if ($role->hasRole('debt_repayment.view')) : ?>
								<li class="nav-item">
									<a href="<?= base_url('webmin/payment/debt-repayment') ?>" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Pelunasan Hutang</p>
									</a>
								</li>
							<?php endif ?>

							<?php if ($role->hasRole('receivable_repayment.view')) : ?>
								<li class="nav-item">
									<a href="<?= base_url('webmin/payment/receivable-repayment') ?>" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Pelunasan Piutang</p>
									</a>
								</li>
							<?php endif ?>
						</ul>
					</li>
				<?php endif ?>


				<?php if ($role->hasRole('sales_admin.view') || $role->hasRole('retur_sales_admin.view') || $role->hasRole('sales_pos.view')) : ?>
					<li class="nav-item">
						<a href="#" class="nav-link">
							<i class="nav-icon fas fa-shopping-cart"></i>
							<p>
								Transaksi Penjualan
								<i class="fas fa-angle-left right"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">
							<?php if ($role->hasRole('sales_admin.view')) : ?>
								<li class="nav-item">
									<a href="<?= base_url('webmin/sales-admin') ?>" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Penjualan Admin</p>
										<span class="right badge badge-danger"></span>
									</a>
								</li>
							<?php endif ?>

							<?php if ($role->hasRole('retur_sales_admin.view')) : ?>
								<li class="nav-item">
									<a href="<?= base_url('webmin/retur/sales-admin-retur') ?>" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Retur Penjualan Admin</p>
										<span class="right badge badge-danger"></span>
									</a>
								</li>
							<?php endif ?>

							<?php if ($role->hasRole('sales_pos.view')) : ?>
								<li class="nav-item">
									<a href="<?= base_url('webmin/sales-pos') ?>" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Penjualan Pos</p>
										<span class="right badge badge-danger"></span>
									</a>
								</li>
							<?php endif ?>
						</ul>
					</li>
				<?php endif ?>


				<?php if ($role->hasRole('mobilebanner.view') || $role->hasRole('mobilepromo.view')) : ?>
					<li class="nav-item">
						<a href="javascript:void(0)" class="nav-link">
							<i class="nav-icon fas fa-mobile"></i>
							<p>
								Mobile APPS
								<i class="right fas fa-angle-left"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">
							<?php if ($role->hasRole('mobilebanner.view')) : ?>
								<li class="nav-item">
									<a href="<?= base_url('webmin/mobileapps/banner') ?>" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Banner Slider</p>
									</a>
								</li>
							<?php endif ?>

							<?php if ($role->hasRole('mobilepromo.view')) : ?>
								<li class="nav-item">
									<a href="<?= base_url('webmin/mobileapps/promo') ?>" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Mobile Promo</p>
									</a>
								</li>
							<?php endif ?>
						</ul>
					</li>
				<?php endif ?>

				<?php if ($role->hasRole('user_group.view') || $role->hasRole('user_account.view') || $role->hasRole('password_control.view')) : ?>
					<li class="nav-item">
						<a href="javascript:void(0)" class="nav-link">
							<i class="nav-icon fas fa-user"></i>
							<p>
								Admin
								<i class="right fas fa-angle-left"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">
							<?php if ($role->hasRole('user_group.view')) : ?>
								<li class="nav-item">
									<a href="<?= base_url('webmin/user/user-group') ?>" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Grup Pengguna</p>
									</a>
								</li>
							<?php endif ?>

							<?php if ($role->hasRole('user_account.view')) : ?>
								<li class="nav-item">
									<a href="<?= base_url('webmin/user/user-account') ?>" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Akun Pengguna</p>
									</a>
								</li>
							<?php endif ?>

							<?php if ($role->hasRole('password_control.view')) : ?>
								<li class="nav-item">
									<a href="<?= base_url('webmin/password-control') ?>" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Password Control</p>
									</a>
								</li>
							<?php endif ?>
						</ul>
					</li>
				<?php endif ?>


				<?php if ($role->hasRole('report.view')) : ?>
					<li class="nav-item">
						<a href="<?= base_url('webmin/report') ?>" class="nav-link">
							<i class="nav-icon fas fa-file"></i>
							<p>
								Laporan
								<span class="right badge badge-danger"></span>
							</p>
						</a>
					</li>
				<?php endif ?>


				<?php if ($role->hasRole('configs.view')) : ?>
					<li class="nav-item">
						<a href="<?= base_url('webmin/configs') ?>" class="nav-link">
							<i class="nav-icon fas fa-cogs"></i>
							<p>
								Pengaturan
								<span class="right badge badge-danger"></span>
							</p>
						</a>
					</li>
				<?php endif ?>

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