<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?= isset($title) ? $title : 'Report' ?></title>
	<style>
		* {
			-webkit-print-color-adjust: exact;
		}

		@page {
			size: 21cm 33cm landscape;
			margin: 25mm, 25mm, 25mm, 25mm;
		}

		html {
			width: 800px;
			margin: auto;
		}

		.text-center {
			text-align: center;
		}

		.text-right {
			text-align: right;
		}

		.text-left {
			text-align: left;
		}

		hr {
			border-bottom: none;
			border-top: 1px solid black;
		}

		body {
			font-size: 11pt;
			font-family: 'Times New Roman', Times, serif;
		}

		.header1 {
			font-family: 'Times New Roman', Times, serif;
			font-size: 14pt;
			font-weight: bold;
		}

		.header2 {
			font-family: 'Times New Roman', Times, serif;
			font-size: 12pt;
			font-weight: bold;
		}

		.table-bordered {
			border-left: 1px solid black;
			border-bottom: 1px solid black;
		}

		.table-bordered td {
			border-right: 1px solid black;
			border-top: 1px solid black;
			padding: 5px;
		}

		.table-bordered th {
			border-right: 1px solid black;
			border-top: 1px solid black;
			padding: 5px;
		}

		.table-detail thead tr th,
		.table-detail tfoot tr th {
			background-color: #D4D0C8;
		}

		.table-noborder {
			border: none;
		}

		.table-noborder td {
			border: none;
			font-size: 11pt;
		}

		.signature {
			font-size: 11pt;
			font-weight: bold;
			line-height: 20px;
			padding-bottom: 4px;
			background: linear-gradient(0deg, black 1px, black 1px, transparent 3px);
			background-position: 3 100%;
		}


		.col-fixed {
			max-width: 0;
			overflow: hidden;
			text-overflow: ellipsis;
			white-space: nowrap;
		}
	</style>

	<?= $this->renderSection('css') ?>
</head>

<body class="cetak">
	<?= $this->renderSection('content') ?>



	<?= $this->renderSection('js') ?>
</body>