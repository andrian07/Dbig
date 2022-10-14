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
				<P>Jalan Sungai Raya Dalam. Ruko Ceria No. A2 - A3 (Samping Gg. Ceria 1) </P>
				<P>Kabupaten Kubu Raya. Kalimantan Barat, Indonesia</P>
				<P>Telepon: +62 561 6733572 <?php echo str_repeat('&nbsp;', 3);?> Email:dbig.depo@gmail.com</P>
			</div>
		</div>
		<div class="letterhead-border"><?php echo  str_repeat('&nbsp;', 2);?></div>

		<div class="content-invoice">
			<h3 class="text-center">PURCHASE ORDER</h3>
			<table class="info-date">
				<tr>
					<td>Date</td><td>:</td><td>01/09/2022</td>
				</tr>
				<tr>
					<td>PO</td><td>:</td><td>001/d'BIG/IX/2022</td>
				</tr>
			</table>

			<div class="address-content">
				<div class="left address-content-left">
					<h4 style="text-decoration: underline;">Kepada Yth</h4>
					<h4 style="margin-top: -19px;">PT Granit Indonesia</h4>
					<P>Jln. Raya PLP Curug KM 5 NO.168 RT/RW 000/000 <br />Kel.Curug Wetan, Kec. Curug <br /> Kab. Tangerang, Banten</P>
				</div>
				<div class="right address-content-right">
					<h4 style="text-decoration: underline;">Dari </h4>
					<h4 style="margin-top: -19px;">CV. Depo Bangunan Indo Global </h4>
					<p> Jalan Sungai Raya Dalam. Ruko Ceria No.A2-A3 <br />Kab. Kubu Raya, Kalimantan Barat <br /> Telp. +62 561 6733572</p>
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
				<tr>
					<td>1</td>
					<td>8014</td>
					<td>ESSENZA GRANIT ABSOLUTE WHITE POLISH KW 1 60X60</td>
					<td>10</td>
					<td>Dus</td>
					<td>85.000</td>
					<td>Rp85.000.000</td>
				</tr>
				</tbody>
				<tfoot>
				<tr>
					<td colspan="5"></td>
					<th>Grand Total</th>
					<th>Rp85.000.000</th>
				</tr>
				</tfoot>
			</table>
		</div>

		<p>- FAKTUR PAJAK STANDAR DIBUKA A/N : CV.DEPO BANGUNAN INDO GLOBAL <br /> 
		   - NPWP         : 92.233.181.4-704.000
		</p>

		<p class="note">
			NOTE : <br />- UNTUK SETIAP MOTIF KERAMIK/ GRANIT HARAP DAPAT DIMUATKAN DENGAN NOMOR SERI YANG SAMA<br />
				   - Kami meminta support dari Bapak/Ibu jika terdapat brosur & souvenir Sehingga bisa membantu memasarkan produk ke konsumen<br />
				   - Kami juga mengharapakan jika untuk keramik bisa mensupport rak display dan sample keramik untuk display <br /><br /><br />
			Via EMKL CV. Jasa Karya <br />
			Telp  : (021) 66600635- 66600638 <br />
			Hub  :  Bp. ACHUA / Bpk Adrian
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