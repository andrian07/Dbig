<?php

if (!function_exists('indo_date')) {
    function indo_date($str, $icon = FALSE,  $datetime_separator = ' ')
    {
        if ($str == '' || $str == NULL || $str == '0000-00-00' || $str == '0000-00-00 00:00:00') {
            return  '';
        }
        $iDate = $icon == TRUE ? '<i class="fas fa-calendar-alt"></i> ' : '';
        $iTime = $icon == TRUE ? '<i class="fas fa-clock"></i> ' : '';

        $month = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        $expDateTime = explode(' ', $str);
        $sDate = $expDateTime[0];
        $sTime = isset($expDateTime[1]) ? $expDateTime[1] : '';

        $expDate = explode('-', $sDate);
        $m = intval($expDate[1]) - 1;

        $fDate = $expDate[2] . ' ' . $month[$m] . ' ' . $expDate[0];
        return $sTime == '' ? $iDate . $fDate : $iDate . $fDate . $datetime_separator . $iTime . $sTime;
    }
}

if (!function_exists('indo_short_date')) {
    function indo_short_date($str, $icon = FALSE,  $datetime_separator = ' ')
    {
        if ($str == '' || $str == NULL || $str == '0000-00-00' || $str == '0000-00-00 00:00:00') {
            return  '';
        }
        $iDate = $icon == TRUE ? '<i class="fas fa-calendar-alt"></i> ' : '';
        $iTime = $icon == TRUE ? '<i class="fas fa-clock"></i> ' : '';

        $expDateTime = explode(' ', $str);
        $sDate = $expDateTime[0];
        $sTime = isset($expDateTime[1]) ? $expDateTime[1] : '';

        $expDate = explode('-', $sDate);
        $fDate = $expDate[2] . '/' . $expDate[1] . '/' . $expDate[0];
        return $sTime == '' ? $iDate . $fDate : $iDate . $fDate . $datetime_separator . $iTime . $sTime;
    }
}

if (!function_exists('threeDigitRound')) {
    function threeDigitRound($value)
    {
        // value = 1999.87
        $cval               = floor($value); // = 1999.87 => 1999
        $sval               = strval($cval); // = '1999'
        $three_digit        = floatval(substr($sval, -3));
        $remain_value       = $cval - $three_digit;
        $round_three_digit  = ceil($three_digit / 100) * 100;
        $result             = $round_three_digit + $remain_value;
        return $result;
    }
}

if (!function_exists('numberFormat')) {
    function numberFormat($value, $show_decimal = FALSE)
    {
        $number =  floatval($value);
        $decimals = $show_decimal ? DECIMAL_DIGIT : 0;
        return number_format($number, $decimals, DECIMAL_SEPARATOR, THOUSAND_SEPARATOR);
    }
}

if (!function_exists('resultJSON')) {
    function resultJSON($json_data)
    {
        echo json_encode($json_data, JSON_HEX_APOS | JSON_HEX_QUOT);
    }
}

if (!function_exists('calcPercentRate')) {
    function calcPercentRate($start_value, $end_value)
    {
        if ($start_value == 0 && $end_value == 0) {
            $mr = 0;
        } elseif ($start_value == 0) {
            $mr = 100;
        } else {
            $mr = (($end_value - $start_value) / $start_value) * 100;
        }
        return $mr;
    }
}

if (!function_exists('displayDisc')) {
    function displayDisc($d1 = 0, $d2 = 0, $d3 = 0, $separator = ' + ')
    {
        $aDisc = NULL;
        if ($d1 > 0) {
            $aDisc[] = numberFormat($d1, TRUE) . '%';
        }

        if ($d2 > 0) {
            $aDisc[] = numberFormat($d2, TRUE) . '%';
        }

        if ($d3 > 0) {
            $aDisc[] = numberFormat($d3, TRUE) . '%';
        }


        return $aDisc == NULL ? numberFormat(0, TRUE) . '%' : implode($separator, $aDisc);
    }
}


if (!function_exists('saveQueries')) {
    function saveQueries($queries, $module, $ref_id = 0, $log_remark = '')
    {
        if (APP_LOG_QUERIES) {
            $user_id = 0;
            $M_log_queries = model('Log/M_log_queries',);
            $user_login = session()->get('user_login');

            if ($user_login != NULL) {
                $user_id = $user_login['user_id'];
            }

            $M_log_queries->insertLog($queries, $log_remark, $user_id, $module, $ref_id);
        }
    }
}

if (!function_exists('logQueries')) {
    function logQueries($queries, $module, $ref_id = 0, $log_remark = '', $user_id = 0)
    {
        if (APP_LOG_QUERIES) {
            $M_log_queries = model('Log/M_log_queries',);
            $M_log_queries->insertLog($queries, $log_remark, $user_id, $module, $ref_id);
        }
    }
}

if (!function_exists('saveEditQueries')) {
    function saveEditQueries($queries, $module, $ref_id = 0, $log_remark = '')
    {
        if (APP_LOG_QUERIES) {
            $user_id = 0;
            $M_log_queries = model('Log/M_log_queries',);
            $user_login = session()->get('user_login');

            if ($user_login != NULL) {
                $user_id = $user_login['user_id'];
            }

            $M_log_queries->insertLogEdit($queries, $log_remark, $user_id, $module, $ref_id);
        }
    }
}

/* Get Upload File */
if (!function_exists('getImage')) {
    function getImage($filename, $_configImageName, $isThumb = FALSE, $noImage = '')
    {
        $image_uri = $noImage;
        if ($filename != '') {
            $_get_config    = config('MyApp');
            $config         = $_get_config->uploadImage[$_configImageName];
            $dir = $isThumb == FALSE ?  $config['upload_dir'] : $config['thumb_dir'];

            if (file_exists($dir . $filename)) {
                $image_uri = base_url($dir . $filename);
            } else {
                $image_uri = $noImage;
            }
        }
        return $image_uri;
    }
}

if (!function_exists('deleteImage')) {
    function deleteImage($filename, $_configImageName)
    {
        if (!($filename == '')) {
            $_get_config    = config('MyApp');
            $config         = $_get_config->uploadImage[$_configImageName];

            $image = $config['upload_dir'] . $filename;
            $thumb = $config['thumb_dir'] . $filename;
            if (file_exists($image)) {
                unlink($image);
            }

            if (file_exists($thumb)) {
                unlink($thumb);
            }
        }
    }
}
