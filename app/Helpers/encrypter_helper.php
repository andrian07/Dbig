<?php
if (!function_exists('strEncode')) {
    function strEncode($plaintext)
    {
        $encrypter = \Config\Services::encrypter();
        if ($plaintext != '') {
            $ciphertext = base64_encode($encrypter->encrypt($plaintext));
            $search = array('=', '+', '/');
            $to = array('-', '_', '~');
            return urlencode(str_replace($search, $to, $ciphertext));
        } else {
            return '';
        }
    }
}

if (!function_exists('strDecode')) {
    function strDecode($ciphertext)
    {
        $encrypter = \Config\Services::encrypter();
        if ($ciphertext != '') {
            $search = array('-', '_', '~');
            $to = array('=', '+', '/');
            $sss = str_replace($search, $to, urldecode($ciphertext));
            return $encrypter->decrypt(base64_decode($sss));
        } else {
            return '';
        }
    }
}
