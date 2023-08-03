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
            size: A4;
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
        }

        .header1 {
            font-size: 14pt;
            font-weight: bold;
        }

        .header2 {
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

    <style>
        * {
            margin: 0px;
            padding: 0px;
        }

        div.barcode-label {
            width: 200px;
            height: 80px;
            text-align: center;
            margin-top: 0px;
            margin-bottom: 2px;
        }


        .title {
            width: 98%;
            height: 24px;
            margin: 0px auto;
            font-size: 9px;

            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }


        .barcode-text {
            font-size: 12px;
            font-weight: bold;
        }
    </style>
</head>

<body class="cetak">

    <?php
    $page = 1;
    $ubarcode = str_replace('svg width="95"', 'svg width="80"', $barcode);
    foreach ($pages as $pageData) {
    ?>
        <div style="margin:0px;padding:0px;<?= $page == $max_page ? '' : 'page-break-after:always;' ?>">
            <table width="100%">
                <?php
                foreach ($pageData as $row) {
                ?>
                    <div class="barcode-label">
                        <img src="data:image/svg+xml;base64,<?= base64_encode($ubarcode)  ?>" />
                        <p class="barcode-text"><?= esc($row['item_code']) ?><br></p>
                        <div class="title">
                            <?= $row['product_name'] . ' (' . $row['unit_name'] . ')' ?>
                        </div>
                    </div>
                <?php
                }
                ?>
            </table>

        </div>
    <?php
        $page++;
    }
    ?>

    <?php if (isset($_GET['print'])) : ?>
        <script>
            // For Print //
            window.print();
            <?php
            if (isset($agent)) :
                if ($agent->isMobile() == FALSE) :
            ?>
                    window.onafterprint = closePage;

                    function closePage() {
                        window.close();
                    }
            <?php
                endif;
            endif;
            ?>
        </script>
    <?php endif; ?>

</body>