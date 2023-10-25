<?php

namespace App\Controllers\Webmin;

use App\Controllers\Base\BaseController;

class VerificationLogin extends BaseController
{
    public $session;
    public $isLogin = false;
    public $userLogin = [];

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->session = \Config\Services::session();
        $this->userLogin = $this->session->get('user_login');

        if ($this->userLogin == null) {
            $this->isLogin = false;
        } else {
            $this->isLogin = true;
        }
    }

    public function index()
    {
        if ($this->userLogin['is_valid'] == 'Y') {
            return redirect()->to(base_url('webmin/profile'));
        }

        $data = [
            'userLogin' => $this->userLogin
        ];
        return view('webmin/verification_login/verification_login', $data);
    }


    public function checkStatus()
    {
        if ($this->userLogin['is_valid'] == 'Y') {
            $result = ['is_valid' => true, 'message' => 'Sesi login terverifikasi'];
        } else {
            $result = ['is_valid' => false, 'message' => 'Sesi login masih dalam proses verifikasi'];
        }
        echo json_encode($result, true);
    }


    public function activation($activation_key)
    {
        helper(['global', 'encrypter']);
        $result = ['success' => false, 'message' => 'Verifikasi Akun Gagal'];
        $decodeKey = strDecode($activation_key);
        $activationData = json_decode($decodeKey, true);
        $confirm = $this->request->getGet('confirm');
        $session_code = $this->request->getGet('session_code') == NULL ? 0 : $this->request->getGet('session_code');
        if (isset($activationData['login_id']) && isset($activationData['session_code']) && isset($activationData['exp_time'])) {
            $M_log_login  = model('Auth/M_log_login');
            if ($confirm == 'Y') {
                if ($session_code == intval($activationData['session_code'])) {
                    $curTime    = time();
                    $exp_time   = intval($activationData['exp_time']);
                    if ($curTime > $exp_time) {
                        $result = ['success' => false, 'message' => 'Masa berlaku link aktivasi sudah habis. Harap Login Kembali'];
                    } else {
                        $update_log = [
                            'login_id'  => $activationData['login_id'],
                            'is_valid'  => 'Y'
                        ];

                        $M_log_login->updateLog($update_log);
                        $result = ['success' => true, 'message' => 'Verifikasi login untuk sesi <b>' . $session_code . '</b> berhasil'];
                    }
                } else {
                    $result = ['success' => false, 'message' => 'Link verifikasi tidak valid'];
                }
                return view('webmin/verification_login/verification_message', $result);
            } else {

                $confirmUri = base_url("webmin-activation/$activation_key") . "?session_code=" . $activationData['session_code'] . "&confirm=Y";
                $getLog = $M_log_login->getLog($activationData['login_id'])->getRowArray();
                $data = [
                    'userData'      => $getLog,
                    'confirmUri'    => $confirmUri
                ];
                return view('webmin/verification_login/verification_activation', $data);
            }
        } else {
            $result = ['success' => false, 'message' => 'Link verifikasi tidak valid'];
            return view('webmin/verification_login/verification_message', $result);
        }
    }


    //--------------------------------------------------------------------

}
