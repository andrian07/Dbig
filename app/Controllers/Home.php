<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Home extends Controller
{
    public function index()
    {
        echo "DBIG VER 1.0";
    }


    public function verificationAccount($activation_key)
    {
        helper(['global', 'encrypter']);
        $result = ['success' => false, 'message' => 'Verifikasi Akun Gagal', 'customer_data' => null];
        $decodeKey = strDecode($activation_key);
        $activationData = json_decode($decodeKey, true);
        $cid = $this->request->getGet('cid') == NULL ? 0 : $this->request->getGet('cid');
        if (isset($activationData['customer_id']) && isset($activationData['customer_code']) && isset($activationData['exp_time'])) {
            if (intval($cid) == intval($activationData['customer_id'])) {
                $curTime    = time();
                $exp_time   = intval($activationData['exp_time']);

                if ($curTime > $exp_time) {
                    $result = ['success' => false, 'message' => 'Masa berlaku link aktivasi sudah habis (1x24 jam). Harap ajukan kembali aktivasi lewat mobile apps', 'customer_data' => null];
                } else {
                    $M_customer = model('M_customer');
                    $result = $M_customer->verificationEmail($activationData['customer_id']);
                }
            } else {
                $result = ['success' => false, 'message' => 'Link verifikasi tidak valid', 'customer_data' => null];
            }
        } else {
            $result = ['success' => false, 'message' => 'Link verifikasi tidak valid', 'customer_data' => null];
        }

        return view('mobile/verification', $result);
    }
}
