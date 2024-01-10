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
        
        
       
        <div class="content-invoice" style="margin-top:10px;margin-bottom:40px;height: 40px;">
            <div class="col-md-6">
            <table class="info-date item" style="width:40%;">
				<tr>
					<th colspan="2" style="text-align: center;">DBIG <?= esc($hdPO['purchase_order_invoice']) ?></th>
				</tr>
                <tr>
					<td style="text-align: center;">Tgl</td><td style="text-align: center;"><?= indo_date($hdPO['purchase_order_date']) ?></td>
				</tr>
				<tr>
					<th colspan="2" style="text-align: center;"><?= esc($hdPO['user_name']) ?></th>
				</tr>
			</table>
            </div>

        </div>
		<div class="content-invoice">
			<h3 class="text-center">MEMO PENGAMBILAN BARANG</h3>
			<div class="address-content" style="margin-top:-20px;">
				<div class="left address-content-left">
					<h4 style="text-decoration: underline;">Kepada Yth</h4>
                    <p style="width: 80%;"><?= nl2br($hdPO['purchase_order_remark2']) ?></p>
				</div>
				<div class="right address-content-right">
					<h4 style="text-decoration: underline;">Dari</h4>
					<p style="width: 80%;"><?= nl2br($hdPO['purchase_order_remark3']) ?></p>
				</div>
			</div>
            <p style="margin-top:155px;font-size:15px;">Mohon di berikan barang-barang yang tertera di bawah ini:</p>    
			<table class="item">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama Barang</th>
						<th>QTY</th>
						<th>SAT</th>
					</tr>
				</thead>
				<tbody>

					<?php
					$number = 1;
					foreach ($dtPO as $row) :

						
						$detail_purchase_po_price = floatval($row['detail_purchase_po_price']);
						$detail_purchase_po_qty = floatval($row['detail_purchase_po_qty']);
						$detail_purchase_po_total_discount = floatval($row['detail_purchase_po_total_discount']);
						$detail_purchase_po_ongkir = floatval($row['detail_purchase_po_ongkir']);
						$detail_purchase_po_total = floatval($row['detail_purchase_po_total']);
						?>

						<tr>

							<td class="text-center"><?php echo $number; ?></td>

							<td class="text-center"><?= esc($row['product_name']) ?><br />(<?= esc($row['detail_purchase_po_ket']) ?>)</td>

							<td class="text-center"><?= numberFormat($detail_purchase_po_qty, TRUE) ?></td>

							<td class="text-center"><?= esc($row['unit_name']) ?></td>

						</tr>

						<?php
						$number = $number++;

					endforeach;

					?>
	
				</tbody>
		
			</table>
		</div>

		<div class="ttd-div">
			<table class="ttd" style="margin-top: -10px; width:50%;    margin-left: 402px;">
				<tr>
					<td class="text-center">Dibuat Oleh,</td><td class="text-center">Memo Diterima Oleh,</td>
				</tr>
				<tr>
					<td style="height: 80px;"><img src="<?= $assetsUrl ?>/images/TTD_Bag_Pembelian.png" style="width: 80%;"></td><td>
				</td>
				</tr>
				<tr>
					<td class="text-center">Bag.Pembelian</td><td class="text-center"><?= esc($hdPO['supplier_name']) ?></td>
				</tr>
			</table>
		</div>
	</div>
</body>
</html>