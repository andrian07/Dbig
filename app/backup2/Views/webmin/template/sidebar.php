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

				<li class="nav-item">
					<a href="#" class="nav-link">
						<i class="nav-icon fas fa-tachometer-alt"></i>
						<p>
							Dashboard
							<span class="right badge badge-danger"></span>
						</p>
					</a>
				</li>

				<li class="nav-item">
					<a href="javascript:void(0)" class="nav-link">
						<i class="nav-icon fas fa-newspaper"></i>
						<p>
							Master Data
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?= base_url('webmin/brand') ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Brand</p>
							</a>
						</li>

						<li class="nav-item">
							<a href="<?= base_url('webmin/category') ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Kategori</p>
							</a>
						</li>

						<li class="nav-item">
							<a href="<?= base_url('webmin/unit') ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Satuan</p>
							</a>
						</li>

						<li class="nav-item">
							<a href="<?= base_url('webmin/warehouse') ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Gudang</p>
							</a>
						</li>

						<li class="nav-item">
							<a href="<?= base_url('webmin/product') ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Produk</p>
							</a>
						</li>

						<li class="nav-item">
							<a href="<?= base_url('webmin/supplier') ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Supplier</p>
							</a>
						</li>

						<li class="nav-item">
							<a href="<?= base_url('webmin/customer') ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Customer</p>
							</a>
						</li>

						<li class="nav-item">
							<a href="<?= base_url('webmin/mapping-area') ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Mapping Area</p>
							</a>
						</li>

						<li class="nav-item">
							<a href="<?= base_url('webmin/salesman') ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Salesman</p>
							</a>
						</li>
					</ul>
				</li>

				<li class="nav-item">
					<a href="<?= base_url('webmin/voucher') ?>" class="nav-link">
						<i class="nav-icon fas fa-ticket-alt"></i>
						<p>
							Voucher
							<span class="right badge badge-danger"></span>
						</p>
					</a>
				</li>

				<li class="nav-item">
					<a href="<?= base_url('webmin/stock-opname') ?>" class="nav-link">
						<i class="nav-icon fas fa-box"></i>
						<p>
							Stok Opname
							<span class="right badge badge-danger"></span>
						</p>
					</a>
				</li>

				<li class="nav-item">
					<a href="<?= base_url('webmin/stock-transfer') ?>" class="nav-link">
						<i class="nav-icon fas fa-exchange-alt"></i>
						<p>
							Transfer Stok
							<span class="right badge badge-danger"></span>
						</p>
					</a>
				</li>

				<li class="nav-item">
					<a href="javascript:void(0)" class="nav-link">
						<i class="nav-icon fas fa-coins"></i>
						<p>
							Poin Customer
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?= base_url('webmin/point-reward') ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Hadiah Poin</p>
							</a>
						</li>

						<li class="nav-item">
							<a href="<?= base_url('webmin/point-exchange') ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Penukaran Poin</p>
							</a>
						</li>
					</ul>
				</li>

				<li class="nav-item">
					<a href="#" class="nav-link">
						<i class="nav-icon fas fa-shopping-cart"></i>
						<p>
							Transaksi Pembelian
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
						<li class="nav-item">
							<a href="<?= base_url('webmin/purchase') ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Pembelian</p>
								<span class="right badge badge-danger"></span>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= base_url('webmin/retur') ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Retur Pembelian</p>
								<span class="right badge badge-danger"></span>
							</a>
						</li>
					</ul>
				</li>

				<li class="nav-item">
					<a href="#" class="nav-link">
						<i class="nav-icon fas fa-shopping-cart"></i>
						<p>
							Transaksi Penjualan
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?= base_url('webmin/sales-admin') ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Penjualan Admin</p>
								<span class="right badge badge-danger"></span>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= base_url('webmin/sales-pos') ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Penjualan Pos</p>
								<span class="right badge badge-danger"></span>
							</a>
						</li>
					</ul>
				</li>

				<li class="nav-item">
					<a href="#" class="nav-link">
						<i class="nav-icon fas fa-shopping-cart"></i>
						<p>
							Konsinyasi
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?= base_url('webmin/consignment/purchase-order-consignment') ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>PO Konsinyasi</p>
								<span class="right badge badge-danger"></span>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= base_url('webmin/consignment/stock-input-consignment') ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Input Stok Konsinyasi</p>
								<span class="right badge badge-danger"></span>
							</a>
						</li>
						<?php /*<li class="nav-item">
							<a href="<?= base_url('webmin/consignment/recap-consignment') ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Rekap Konsinyasi</p>
								<span class="right badge badge-danger"></span>
							</a>
						</li> */ ?>
					</ul>
				</li>

				<li class="nav-item">
					<a href="javascript:void(0)" class="nav-link">
						<i class="nav-icon fas fa-money-bill"></i>
						<p>
							Pelunasan
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?= base_url('webmin/payment/debt-repayment') ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Pelunasan Hutang</p>
							</a>
						</li>

						<li class="nav-item">
							<a href="<?= base_url('webmin/payment/receivable-repayment') ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Pelunasan Piutang</p>
							</a>
						</li>
						<?php /*
						<li class="nav-item">
							<a href="<?= base_url('webmin/payment/consignment-repayment') ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Pelunasan Konsinyasi</p>
							</a>
						</li>
						*/ ?>
					</ul>
				</li>

				<li class="nav-item">
					<a href="javascript:void(0)" class="nav-link">
						<i class="nav-icon fas fa-mobile"></i>
						<p>
							Mobile APPS
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?= base_url('webmin/mobileapps/banner') ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Banner Slider</p>
							</a>
						</li>
					</ul>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?= base_url('webmin/mobileapps/promo') ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Mobile Promo</p>
							</a>
						</li>
					</ul>
				</li>

				<li class="nav-item">
					<a href="javascript:void(0)" class="nav-link">
						<i class="nav-icon fas fa-user"></i>
						<p>
							Admin
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?= base_url('webmin/user/user-group') ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Grup Pengguna</p>
							</a>
						</li>

						<li class="nav-item">
							<a href="<?= base_url('webmin/user/user-account') ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Akun Pengguna</p>
							</a>
						</li>

						<li class="nav-item">
							<a href="<?= base_url('webmin/password-control') ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Password Control</p>
							</a>
						</li>
					</ul>
				</li>

				<li class="nav-item">
					<a href="<?= base_url('webmin/report') ?>" class="nav-link">
						<i class="nav-icon fas fa-file"></i>
						<p>
							Laporan
							<span class="right badge badge-danger"></span>
						</p>
					</a>
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