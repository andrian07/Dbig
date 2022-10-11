<?php
require ROOTPATH . 'vendor/autoload.php';
function generate_barcode($text, $type = 'auto')
{
    $generator = new Picqer\Barcode\BarcodeGeneratorSVG();
    $width_factor   = 1;
    $height         = 15;
    $barcode        = FALSE;

    $barcode_type_config = [
        'code_128'      => $generator::TYPE_CODE_128,
        'code_128_a'    => $generator::TYPE_CODE_128_A,
        'code_128_b'    => $generator::TYPE_CODE_128_B,
        'code_128_c'    => $generator::TYPE_CODE_128_C,
        'upc_a'         => $generator::TYPE_UPC_A,
        'ean_13'        => $generator::TYPE_EAN_13,
        'ean_8'         => $generator::TYPE_EAN_8,
        'code_39'       => $generator::TYPE_CODE_93,
    ];

    if ($type == 'auto') {
        $nLen = strlen($text);
        try {
            if ($nLen == 12) {
                $barcode = $generator->getBarcode($text, $generator::TYPE_UPC_A,  $width_factor, $height);
            } elseif ($nLen == 13) {
                $barcode = $generator->getBarcode($text, $generator::TYPE_CODE_128, $width_factor, $height);
            } elseif ($nLen == 11) {
                $barcode = $generator->getBarcode($text, $generator::TYPE_UPC_A,  $width_factor, $height);
            }
        } catch (Exception $ex) {
            $barcode = FALSE;
        }

        foreach ($barcode_type_config as $btype) {
            if ($barcode == FALSE) {
                try {
                    $barcode = $generator->getBarcode($text, $btype, $width_factor, $height);
                } catch (Exception $ex) {
                    $barcode = FALSE;
                }
            }
        }
    } else {
        try {
            $btype = isset($barcode_type_config[$type]) ? $barcode_type_config[$type] : $generator::TYPE_CODE_128;
            $barcode = $generator->getBarcode($text, $btype, $width_factor, $height);
        } catch (Exception $ex) {
            $barcode = FALSE;
        }
    }
    return $barcode;
}
