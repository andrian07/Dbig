<?php

if (!function_exists('send_telegram_message')) {
    function send_telegram_message($to = "", $message = '', $parse_mode = 'html')
    {
        // to = string ids or array ids
        $_config        = new \Config\MyApp();
        $botBaseUrl     = $_config->telebot['botBaseUrl'];
        $botToken       = $_config->telebot['botToken'];
        $text           = urlencode($message);

        if (is_string($to)) {
            $uri            = $botBaseUrl . $botToken . "/sendmessage?chat_id=$to&text=$text";
            if ($parse_mode != '') {
                $uri        = $botBaseUrl . $botToken . "/sendmessage?chat_id=$to&text=$text&parse_mode=html";
            }
            file_get_contents($uri);
        } elseif (is_array($to)) {
            foreach ($to as $key => $chat_id) {
                $uri            = $botBaseUrl . $botToken . "/sendmessage?chat_id=$chat_id&text=$text";
                if ($parse_mode != '') {
                    $uri        = $botBaseUrl . $botToken . "/sendmessage?chat_id=$chat_id&text=$text&parse_mode=html";
                }
                file_get_contents($uri);
            }
        }
    }
}
