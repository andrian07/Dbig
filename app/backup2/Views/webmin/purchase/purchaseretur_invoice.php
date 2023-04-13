<?php
$themeUrl = base_url('assets/adminlte3');
$assetsUrl = base_url('assets');
?>
<!DOCTYPE html>
<html>
<head>
	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?= $themeUrl ?>/plugins/fontawesome-free/css/all.min.css">
	<link rel="stylesheet" href="<?= $assetsUrl ?>/app/invoice_dbig.css">
	<title></title>
</head>
<body>
	<div class="invoice-a4">

		<div class="letterhead">
			<div class="left letterhead-left text-right"><img src="<?= base_url('assets/images/logo.png') ?>" alt="d'BIG Logo" width="80%" height="100px;"></div>
			<div class="right letterhead-right">
				<h2><?= COMPANY_NAME ?></h2>
				<P><?= COMPANY_ADDRESS ?> </P>
				<P>Kabupaten Kubu Raya. Kalimantan Barat, Indonesia</P>
				<P>Telepon: +62 561 6733572 <?php echo str_repeat('&nbsp;', 3);?> Email:dbig.depo@gmail.com</P>
			</div>
		</div>
		<div class="letterhead-border"><?php echo  str_repeat('&nbsp;', 2);?></div>

		<div class="content-invoice">
			<h3 class="text-center">RETUR PEMBELIAN</h3>
			<table class="info-date">
				<tr>
					<td>Date</td><td>:</td><td><?= indo_date($hdRetur['hd_retur_date']) ?></td>
				</tr>
				<tr>
					<td>No Retur</td><td>:</td><td><?= esc($hdRetur['hd_retur_purchase_invoice']) ?></td>
				</tr>
			</table>

			<div class="address-content">
				<div class="left address-content-left">
					<h4 style="text-decoration: underline;">Kepada Yth</h4>
					<h4 style="margin-top: -19px;"><?= esc($hdRetur['supplier_name']) ?></h4>
					<P style="width: 80%;"><?= esc($hdRetur['supplier_address']) ?></P>
				</div>
				<div class="right address-content-right">
					<h4 style="text-decoration: underline;">Dari </h4>
					<h4 style="margin-top: -19px;">CV. Depo Bangunan Indo Global </h4>
					<p> <?= COMPANY_ADDRESS ?> <br />Kab. Kubu Raya, Kalimantan Barat <br /> Telp. +62 561 6733572</p>
				</div>
			</div>

			<table class="item">
				<thead>
					<tr>
						<th>No</th>
						<th>Kode</th>
						<th>Description(Jenis Barang)</th>
						<th colspan="2">Qty</th>
						<th>Harga</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>

					<?php

					foreach ($dtRetur as $row) :

						$number = 1;
						
						$dt_retur_qty = floatval($row['dt_retur_qty']);
						$dt_retur_price = floatval($row['dt_retur_price']);
						$dt_retur_total = floatval($row['dt_retur_total']);
						?>

						<tr>

							<td><?= $number ?> </td>

							<td><?= esc($row['product_code']) ?></td>

							<td><?= esc($row['product_name']) ?></td>

							<td><?= esc($row['unit_name']) ?></td>

							<td class="text-center"><?= numberFormat($dt_retur_qty, TRUE) ?></td>

							<td class="text-center">Rp. <?= numberFormat($dt_retur_price, TRUE) ?></td>

							<td class="text-center">Rp <?= numberFormat($dt_retur_total, TRUE) ?></td>

						</tr>

						<?php
						$number = $number++;

					endforeach;

					?>
	
				</tbody>
				<tfoot>
					<tr>
						<td colspan="5"></td>
						<th>Grand Total</th>
						<th class="text-center"><?= 'Rp. '.numberFormat($hdRetur['hd_retur_total_transaction']) ?></th>
					</tr>
				</tfoot>
			</table>
		</div>

		<div class="ttd-div">
			<p class="text-right" style="margin-right: 130px;">Hormat Kami,</p>
			<table class="ttd" style="margin-top: -10px;">
				<tr>
					<td class="text-center">Dibuat Oleh,</td><td class="text-center">Disetujui Oleh ,</td>
				</tr>
				<tr>
					<td style="height: 80px;"></td><td></td>
				</tr>
				<tr>
					<td class="text-center">Bag.Pembelian</td><td class="text-center">Direktur</td>
				</tr>
			</table>
			<p class="text-right" style="text-decoration: underline; margin-right: 60px; font-size: 17px;margin-top: 5px;">CV. Depo Bangunan Indo Global</p>
		</div>
	</div>
</body>
</html>