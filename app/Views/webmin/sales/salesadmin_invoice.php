<?php

$themeUrl = base_url('assets/adminlte3');

$assetsUrl = base_url('assets');

?>

<!DOCTYPE html>

<html>



<head>

	<style>

		body {

			background-color: #f4f6f9;

			font-size: 14px;

		}

		@page {     margin: 0 !important; }


		.faktur-print {

			width: 21.59cm !important;

			height: 13.67cm !important;

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

			min-height: 260px;

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

	<title>Faktur Penjualan</title>

</head>



<body>

	<div class="faktur-print">

		<table class="header-invoice" width="100%">

			<tr>

				<td width="8%">Tanggal</td>

				<td width="2%">:</td>

				<td width="20%"><?= indo_date($hdSales['sales_date']) ?></td>

				<td rowspan="5" class="text-center title-faktur" width="25%">FAKTUR</td>

				<td width="45%">Kepada Yth,</td>

			</tr>

			<tr>

				<td>Nomor</td>

				<td>:</td>

				<td><?= $hdSales['sales_admin_invoice'] ?></td>

				<td><?= $hdSales['customer_name'] ?></td>

			</tr>

			<tr>

				<td>Salesman</td>

				<td>:</td>

				<td><?= $hdSales['salesman_name'] ?> (<?= $hdSales['salesman_code'] ?>)</td>

				<td><?= $hdSales['customer_address'] ?></td>

			</tr>

			<tr>

				<td>J. Tempo</td>

				<td>:</td>

				<td><?= indo_date($hdSales['sales_due_date']) ?></td>

				<td>Telp:<?= $hdSales['customer_phone'] ?></td>

			</tr>

			
		</table>



		<table class="invoice-item" width="100%">



			<tbody>

				<tr>

					<th width="5%">No</th>

					<th width="15%">Kode Barang</th>

					<th width="40%">Nama Barang</th>

					<th width="10%">Kuantitas</th>

					<th width="10%">Harga</th>

					<th width="10%">Discount</th>

					<th width="10%">Jumlah</th>

					<th width="1%"></th>

				</tr>
				<?php $i = 1; ?>
				<?php foreach ($dtSales as $row) : 

					$detail_product_price = floatval($row['dt_product_price']);
					$detail_sales_qty = floatval($row['dt_temp_qty']);
					$detail_sales_discount = floatval($row['dt_disc1'] + $row['dt_disc2'] + $row['dt_disc3']);
					$detail_sales_price= floatval($row['dt_sales_price']);

					?>


					<tr>

						<td><?= $i; ?></td>

						<td><?= esc($row['product_code']) ?></td>

						<td><?= esc($row['product_name']) ?></td>

						<td class="text-center"><?= $detail_sales_qty ?></td>

						<td>Rp. <?= numberFormat($detail_product_price) ?></td>

						<td>Rp. <?= numberFormat($detail_sales_discount) ?></td>

						<td>Rp. <?= numberFormat($detail_sales_price) ?></td>

					</tr>
					<?php $i++ ?>
				<?php endforeach;  ?>

			</tbody>

		</table>



		<table class="footer-invoice" width="100%">

			<tr>

				<td width="20%" class="text-center"></td>

				<td width="20%" class="text-center"></td>

				<td width="20%" class="text-center"></td>

				<td class="text-right"></td>

				<td class="text-right"></td>

			</tr>

			<tr>

				<td colspan="3"></td>

				<td class="text-right">Subtotal:</td>

				<td class="text-right">Rp. <?= numberFormat($hdSales['sales_admin_subtotal']) ?></td>

			</tr>

			<tr>

				<td colspan="3"></td>

				<td class="text-right">Disc: <?= floatval($hdSales['sales_admin_discount1_percentage']) ?>%</td>

				<td class="text-right">Rp. <?= numberFormat($hdSales['sales_admin_discount1']) ?></td>

			</tr>

			<tr>

				<td width="20%" class="text-center">Tanda Terima,</td>

				<td width="20%" class="text-center">Hormat Kami,</td>

				<td width="20%" class="text-center">Gudang,</td>

				<td class="text-right">Disc: <?= floatval($hdSales['sales_admin_discount2_percentage']) ?>%</td>

				<td class="text-right">Rp. <?= numberFormat($hdSales['sales_admin_discount2']) ?></td>

			</tr>

			<tr>

				<td colspan="3"></td>

				<td class="text-right">Disc: <?= floatval($hdSales['sales_admin_discount3_percentage']) ?>%</td>

				<td class="text-right">Rp. <?= numberFormat($hdSales['sales_admin_discount3']) ?></td>

			</tr>



			<tr>
				<td colspan="3"></td>

				<td class="text-right">PPN 11%</td>

				<td class="text-right">Rp. <?= numberFormat($hdSales['sales_admin_ppn']) ?></td>

			</tr>

			<tr>

				<td class="footer-ttd text-center">--------------------------</td>

				<td class="footer-ttd text-center">--------------------------</td>

				<td class="footer-ttd text-center">--------------------------</td>

				<td colspan="3" class="text-center total-all">TOTAL: Rp. <?= numberFormat($hdSales['sales_admin_grand_total']) ?></td>

			</tr>

		</table>



	</div>

</body>



</html>