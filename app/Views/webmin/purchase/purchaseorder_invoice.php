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
				<h2>CV DEPO BANGUNAN INDO GLOBAL</h2>
				<P><?= COMPANY_ADDRESS ?> </P>
				<P>Kabupaten Kubu Raya. Kalimantan Barat, Indonesia</P>
				<P>Telepon: +62 561 6733572 <?php echo str_repeat('&nbsp;', 3);?> Email:dbig.depo@gmail.com</P>
			</div>
		</div>
		<div class="letterhead-border"><?php echo  str_repeat('&nbsp;', 2);?></div>

		<div class="content-invoice">
			<h3 class="text-center">PURCHASE ORDER</h3>
			<table class="info-date">
				<tr>
					<td>Date</td><td>:</td><td><?= indo_date($hdPO['purchase_order_date']) ?></td>
				</tr>
				<tr>
					<td>PO</td><td>:</td><td><?= esc($hdPO['purchase_order_invoice']) ?></td>
				</tr>
			</table>

			<div class="address-content">
				<div class="left address-content-left">
					<h4 style="text-decoration: underline;">Kepada Yth</h4>
					<h4 style="margin-top: -19px;"><?= esc($hdPO['supplier_name']) ?></h4>
					<P style="width: 80%;"><?= esc($hdPO['supplier_address']) ?></P>
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

					foreach ($dtPO as $row) :

						$number = 1;
						$detail_purchase_po_price = floatval($row['detail_purchase_po_price']);
						$detail_purchase_po_qty = floatval($row['detail_purchase_po_qty']);
						$detail_purchase_po_total_discount = floatval($row['detail_purchase_po_total_discount']);
						$detail_purchase_po_ongkir = floatval($row['detail_purchase_po_ongkir']);
						$detail_purchase_po_total = floatval($row['detail_purchase_po_total']);
						?>

						<tr>

							<td>1</td>

							<td><?= esc($row['product_code']) ?></td>

							<td><?= esc($row['product_name']) ?></td>

							<td class="text-center"><?= numberFormat($detail_purchase_po_qty, TRUE) ?></td>

							<td class="text-center"><?= esc($row['unit_name']) ?></td>

							<td class="text-center">Rp. <?= numberFormat($detail_purchase_po_price, TRUE) ?></td>

							<td class="text-center">Rp <?= numberFormat($detail_purchase_po_total, TRUE) ?></td>

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
						<th class="text-center"><?= 'Rp. '.numberFormat($hdPO['purchase_order_total']) ?></th>
					</tr>
				</tfoot>
			</table>
		</div>
		
		<?php if($hdPO['purchase_show_tax_desc'] == 'Y'){ ?>
		<p>- FAKTUR PAJAK STANDAR DIBUKA A/N : CV.DEPO BANGUNAN INDO GLOBAL <br /> 
			- NPWP         : 92.233.181.4-704.000
		</p>
		<?php } ?>

		<p class="note" style="white-space: pre-line;">
			NOTE : <br />
			<?= $hdPO['purchase_order_remark'] ?>
		</p>

		<p>Penerima : CV DEPO BANGUNAN INDO GLOBAL <br />Tlp (+62 561 6733572) / Hp (0822 1999 6819 / SESE )<br />Untuk Semua Koresponden Dikirim Ke Alamat : Jalan Sungai Raya Dalam Ruko Ceria No. A2-A3 </p>

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