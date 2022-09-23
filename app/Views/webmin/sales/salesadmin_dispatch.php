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
<title></title>
</head>
<body>
	<div class="faktur-print">

		<table class="header-invoice">
			<tr>
				<td style="width: 30%;"></td> <td rowspan="5" class="text-center" width="25%"><h3>SURAT JALAN</h3><p>J/22/09/00000231</p></td><td width="45%">Kepada Yth,</td>
			</tr>
			<tr>
				<td></td><td>Bpk Budi Sulaiman</td>
			</tr>
			<tr>
				<td></td><td rowspan="2">Jl. Sei Raya Dalam GG. Dango 1  No A.32 PONTIANAK Kalimantan Barat</td>
			</tr>
			<tr>
				<td></td>
			</tr>
			<tr><td></td><td>Telp:</td></tr>
		</table>

		<table class="invoice-item">
			
			<tbody>
			<tr>
				<th width="5%">No</th>
				<th width="35%">Nama Barang</th>
				<th width="10%">Kuantitas</th>
			</tr>
			<tr>
				<td>1</td>
				<td>DULUX CAT BASE CATYLAC INTERIOR BASE T911AY</td>
				<td>6 Pail</td>
			<tr>
				<td>2</td>
				<td>NIPPON PAINT CAT BASE NIPPON SATIN GLO - PASTEL ...</td>
				<td>2 Pail</td>
			</tr>
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