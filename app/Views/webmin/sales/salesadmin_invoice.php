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
				<td>Tanggal</td><td>:</td><td width="20%">15/09/2012</td><td rowspan="5" class="text-center title-faktur" width="25%">FAKTUR</td><td width="45%">Kepada Yth,</td>
			</tr>
			<tr>
				<td>Nomor</td><td>:</td><td>J/22/09/00003211</td><td>Bpk Budi Sulaiman</td>
			</tr>
			<tr>
				<td>Salesman</td><td>:</td><td>Hendri</td><td rowspan="2">Jl. Sei Raya Dalam GG. Dango 1  No A.32 PONTIANAK Kalimantan Barat</td>
			</tr>
			<tr>
				<td>J. Tempo</td><td>:</td><td>30/10/2022</td>
			</tr>
			<tr><td colspan="3"></td><td>Telp:</td></tr>
		</table>

		<table class="invoice-item">
			
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
			<tr>
				<td>1</td>
				<td>0002312</td>
				<td>DULUX CAT BASE CATYLAC INTERIOR BASE T911AY</td>
				<td>6</td>
				<td>704,400</td>
				<td></td>
				<td>4,226,400</td>
			</tr>
			<tr>
				<td>2</td>
				<td>000231</td>
				<td>123456789101234567891012345678910123456789101234567891012345678910 12345678910123456789101234567891012345678910</td>
				<td>2</td>
				<td>500,000</td>
				<td>200,000</td>
				<td>480,000</td>
			</tr>
			<tr>
				<td>1</td>
				<td>0002312</td>
				<td>DULUX CAT BASE CATYLAC INTERIOR BASE T911AY</td>
				<td>6</td>
				<td>704,400</td>
				<td></td>
				<td>4,226,400</td>
			</tr>
			</tbody>
		</table>

		<table class="footer-invoice">
				<tr>
					<td colspan="3"></td>
					<td class="text-right">Subtotal:</td>
					<td class="text-right">4.226.400</td>
				</tr>
				<tr>
					<td colspan="3"></td>
					<td class="text-right">Disc: 0,00%</td>
					<td class="text-right">0</td>
				</tr>
				<tr>
					<td colspan="3"></td>
					<td class="text-right">Disc: 0,00%</td>
					<td class="text-right">0</td>
				</tr>
				<tr>
					<td width="20%" class="text-center">Tanda Terima,</td>
					<td width="20%" class="text-center">Hormat Kami,</td>
					<td width="20%" class="text-center">Gudang,</td>
					<td class="text-right">Disc: 0,00%</td>
					<td class="text-right">0</td>
				</tr>
				<tr>
					<td class="footer-ttd text-center">--------------------------</td>
					<td class="footer-ttd text-center">--------------------------</td>
					<td class="footer-ttd text-center">--------------------------</td>
					<td colspan="3" class="text-center total-all">TOTAL: 4.226.400</td>
				</tr>
		</table>

	</div>
</body>
</html>