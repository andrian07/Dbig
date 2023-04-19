<?php
if (!function_exists('indo_to_mysql_date')) {
    function indo_to_mysql_date($str, $default = '')
    {
        if ($str == '' || $str == NULL || $str == '0000-00-00' || $str == '0000-00-00 00:00:00') {
            return  $default;
        }


        $expDate    = explode('/', $str);
        $dd         = isset($expDate[0]) ? substr('00' . $expDate[0], -2) : '00';
        $mm         = isset($expDate[1]) ? $expDate[1] : '00';
        $yyyy       = isset($expDate[2]) ? $expDate[2] : '0000';

        return  "$yyyy-$mm-$dd";
    }
}
