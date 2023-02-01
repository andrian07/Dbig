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
	<!-- My URL CSS -->
	<link rel="stylesheet" href="<?= $assetsUrl ?>/app/invoice.css">
<style>

		body {

			background-color: #f4f6f9;

			font-size: 13px;

		}



		.faktur-print {

			width: 21.59cm !important;

			height: 13.97cm !important;

			margin: auto;

			word-wrap: break-word;

			background-color: #ffffff;

			background-clip: border-box;

			padding: 10px;

		}



		table {

			width: 100%;

		}



		.text-left {

			text-align: left;

		}



		.title-faktur {

			text-decoration: underline;

			font-size: 16px;

		}



		.text-right {

			text-align: right;

		}



		.text-center {

			text-align: center;

		}



		.header-invoice tr {

			line-height: 11px;

		}



		.header-invoice h3 {

			font-size: 17px;

			text-decoration: underline;

		}



		.header-invoice p {

			font-size: 13px;

			margin-top: -10px;

			text-decoration: none;

		}



		.invoice-item {

			width: 100%;

			border-top: double !important;

		}



		.invoice-item,

		.invoice-item th {

			border-bottom: 1px solid;

			border-collapse: collapse;

		}



		.invoice-item th {

			text-align: left;

		}



		.invoice-item tbody {

			min-height: 280px;

			width: 100%;

			display: block;

		}



		.footer-ttd {

			padding-top: 50px;

		}



		.total-all {

			padding-top: 20px;

			padding-left: 80px;

			font-size: 16px;

			font-weight: 600;

		}



		.dispatch {

			margin-top: 30px;

		}



		@media print {



			html,

			body {

				width: 21.59cm !important;

				height: 13.97cm !important;

			}



			#debug-icon {

				display: none !important;

			}

		}

	</style>

	<title>Surat Jalan</title>
</head>
<body>
	<div class="faktur-print">

		<table class="header-invoice">
			<tr>
				<td style="width: 30%;"></td> <td rowspan="5" class="text-center" width="25%"><h3>SURAT JALAN</h3><p><?= $hdSales['sales_admin_invoice'] ?></p></td><td width="45%">Kepada Yth,</td>
			</tr>
			<tr>
				<td></td><td><?= $hdSales['customer_name'] ?></td>
			</tr>
			<tr>
				<td></td><td rowspan="2"><?= $hdSales['customer_address'] ?></td>
			</tr>
			<tr>
				<td></td>
			</tr>
			<tr><td></td><td>Telp:<?= $hdSales['customer_phone'] ?></td></tr>
		</table>

		<table class="invoice-item">
			
			<tbody>
			<tr>
				<th width="5%">No</th>
				<th width="10%">Kode Barang</th>
				<th width="35%">Nama Barang</th>
				<th width="10%">Kuantitas</th>
			</tr>
			</tr>
				<?php $i = 1; ?>
				<?php foreach ($dtSales as $row) : 
					$detail_sales_qty = floatval($row['dt_temp_qty']);
					?>

					<tr>

						<td><?= $i; ?></td>

						<td><?= esc($row['product_code']) ?></td>

						<td><?= esc($row['product_name']) ?></td>

						<td><?= $detail_sales_qty ?></td>

					</tr>
				<?php $i++ ?>
				<?php endforeach;  ?>
			</tbody>
		</table>

		<table class="footer-invoice dispatch">
				<tr>
					<td width="25%" class="text-center">Tanda Terima,</td>
					<td width="25%" class="text-center">Yang Menyerahkan,</td>
					<td width="25%" class="text-center">Mengetahui,</td>
					<td width="25%" class="text-center">Hormat Kami,</td>
				</tr>
				<tr>
					<td class="footer-ttd text-center">--------------------------</td>
					<td class="footer-ttd text-center">--------------------------</td>
					<td class="footer-ttd text-center">--------------------------</td>
					<td class="footer-ttd text-center">--------------------------</td>
				</tr>
		</table>

	</div>
</body>
</html>