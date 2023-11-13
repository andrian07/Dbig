<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class TeleBot extends Controller
{
    public function index()
    {
        echo "Telebot V.1.0";
    }

    public function webhook()
    {
        helper('telebot');
        $_config        = new \Config\MyApp();
        $allowedChatIds = $_config->telebot['allowedChatIds'];
        $devIds         = $_config->telebot['devIds'];

        $allowed_from   = array_merge($allowedChatIds, $devIds);

        $update     = json_decode(file_get_contents("php://input"), true);
        $chatId     = isset($update["message"]["chat"]["id"]) ? $update["message"]["chat"]["id"] : "";
        $first_name = isset($update["message"]["chat"]["first_name"]) ? $update["message"]["chat"]["first_name"] : "";
        $last_name  = isset($update["message"]["chat"]["last_name"]) ? $update["message"]["chat"]["last_name"] : "";
        $message    = isset($update["message"]["text"]) ? $update["message"]["text"] : "";
        if (!is_string($chatId)) {
            $chatId = strval($chatId);
        }

        if (strpos($message, "/daftar") === 0) {
            $response = "Pendaftaran [$chatId] $first_name $last_name";
            send_telegram_message($devIds['eric'], $response);
            exit();
        }

        if (strpos($message, "/about") === 0) {
            $response = 'DBIG BOT By CodeID 2023';
            send_telegram_message($chatId, $response);
            exit();
        }


        if (strpos($message, "/menu") === 0) {
            $response = "<b>Menu :</b>\n";
            $response .= "1. /list_verifikasi \n";
            send_telegram_message($chatId, $response);
            exit();
        }


        if (!($chatId == '' && $message == '')) {
            if (in_array($chatId, $allowed_from)) {
                if (strpos($message, "/list_verifikasi") === 0) {
                    $M_log_login = model('Auth/M_log_login');
                    $getList = $M_log_login->getActiveSession()->getResultArray();

                    if (count($getList) > 0) {
                        helper('encrypter');

                        $response = "List Sesi Login : \n";
                        foreach ($getList as $list) {
                            $session_code   = $list['session_code'];
                            $login_id       = $list['login_id'];
                            $exp_login      = floatval($list['expired_time']);
                            $login_ip       = $list['login_ip'];
                            $login_platform = $list['login_platform'];
                            $login_agent    = $list['login_agent'];
                            $cur_time       = time();

                            if ($cur_time < $exp_login) {
                                $params = [
                                    'login_id'          => $login_id,
                                    'session_code'      => $session_code,
                                    'exp_time'          => $exp_login
                                ];
                                $toJson = json_encode($params);
                                $strEncode = strEncode($toJson);
                                $verificationUrl = base_url("webmin-activation/$strEncode") . "?session_code=" . $session_code;


                                $response .= "<b>#<a href=\"$verificationUrl\">$session_code</a></b>\n";
                                $response .= "User : <b>" . $list['user_name'] . " - " . $list['user_realname'] . "</b>\n";
                                $response .= "IP : $login_ip\n";
                                $response .= "Agent : $login_agent\n";
                                $response .= "Platform : $login_platform\n";
                                $response .= "==========================\n";
                            }
                        }
                        $response .= "\nLink Verifikasi Di <b>KODE SESSION</b>";
                        send_telegram_message($chatId, $response);
                        exit();
                    } else {
                        $response = "Tidak ada sesi login untuk diverifikasi";
                        send_telegram_message($chatId, $response);
                        exit();
                    }
                }
            }
        }
    }
}
