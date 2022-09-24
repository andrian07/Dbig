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
	<title>test</title>
</head>

<body>
	<div class="faktur-print">

		<table class="header-invoice" width="100%">
			<tr>
				<td width="8%">Tanggal</td>
				<td width="2%">:</td>
				<td width="20%">15/09/2012</td>
				<td rowspan="5" class="text-center title-faktur" width="25%">FAKTUR</td>
				<td width="45%">Kepada Yth,</td>
			</tr>
			<tr>
				<td>Nomor</td>
				<td>:</td>
				<td>J/22/09/00003211</td>
				<td>Bpk Budi Sulaiman</td>
			</tr>
			<tr>
				<td>Salesman</td>
				<td>:</td>
				<td>Hendri</td>
				<td rowspan="2">Jl. Sei Raya Dalam GG. Dango 1 No A.32 PONTIANAK Kalimantan Barat</td>
			</tr>
			<tr>
				<td>J. Tempo</td>
				<td>:</td>
				<td>30/10/2022</td>
			</tr>
			<tr>
				<td colspan="3"></td>
				<td>Telp:</td>
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