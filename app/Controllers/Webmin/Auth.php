<?php

namespace App\Controllers\Webmin;

use App\Controllers\Base\BaseController;
use App\Models\Auth\M_user_account;
use App\Models\Auth\M_log_login;

class Auth extends BaseController
{
    protected $M_user_account;
    protected $M_log_login;
    protected $helpers = [];

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->M_user_account = new M_user_account();
        $this->M_log_login = new M_log_login();
    }

    public function index()
    {
        if (session()->get('user_login') != NULL) {
            return redirect()->to(base_url('webmin/profile'));
        }

        $data = [
            'alert' => session()->getFlashdata('alert'),
            'input' => session()->getFlashdata('input')
        ];
        return view('webmin/auth/login', $data);
    }

    public function login()
    {
        $this->validationRequest();
        helper(['telebot', 'encrypter']);
        if (session()->get('user_login') != NULL) {
            return redirect()->to(base_url('webmin/profile'));
        }

        $validation =  \Config\Services::validation();
        $validation->setRules([
            'username' => ['label' => 'Username', 'rules' => 'required|min_length[5]|max_length[100]'],
            'password' => ['label' => 'Password', 'rules' => 'required|min_length[8]|max_length[100]'],
        ]);

        $input = [
            'username' => $this->request->getPost('username'),
            'password' => $this->request->getPost('password')
        ];

        if ($validation->run($input)) {
            $getUser = $this->M_user_account->getUserByName($input['username'])->getRowArray();
            if ($getUser != NULL) {
                if ($getUser['active'] == 'N') {
                    session()->remove('user_login');
                    session()->setFlashdata('alert', ['type' => 'info', 'message' => 'Akun anda berstatus tidak aktif harap hubungi administrator']);
                    return redirect()->to(base_url('webmin/auth'));
                }

                if (password_verify($input['password'], $getUser['user_password'])) {

                    $agent = $this->request->getUserAgent();

                    $currentAgent = 'Unidentified User Agent';
                    if ($agent->isBrowser()) {
                        $currentAgent = $agent->getBrowser() . ' ' . $agent->getVersion();
                    } elseif ($agent->isRobot()) {
                        $currentAgent = $agent->getRobot();
                    } elseif ($agent->isMobile()) {
                        $currentAgent = $agent->getMobile();
                    }

                    $platform = $agent->getPlatform();
                    $ip = $this->request->getIPAddress();

                    $log_data = [
                        'user_id'           => $getUser['user_id'],
                        'login_date'        => date('Y-m-d'),
                        'login_agent'       => $currentAgent,
                        'login_platform'    => $platform,
                        'login_ip'          => $ip,
                        'is_valid'          => 'N',
                        'is_expired'        => 'N'
                    ];

                    $saveLog = $this->M_log_login->insertLog($log_data);
                    if ($saveLog['login_id'] == 0) {
                        //login failed with error
                        session()->remove('user_login');
                        session()->setFlashdata('alert', ['type' => 'info', 'message' => 'Error! Coba lagi sesaat']);
                        return redirect()->to(base_url('webmin/auth'));
                    } else {
                        $exp_login = time() + 1800;
                        $loginData = [
                            'user_code'     => $getUser['user_code'],
                            'user_name'     => $getUser['user_name'],
                            'group'         => $getUser['user_group'],
                            'login_id'      => $saveLog['login_id'],
                            'session_code'  => $saveLog['session_code'],
                            'is_valid'      => 'N',
                            'exp_login'     => $exp_login
                        ];
                        session()->set('user_login', $loginData);


                        $params = [
                            'login_id'          => $saveLog['login_id'],
                            'session_code'      => $saveLog['session_code'],
                            'exp_time'          => $exp_login
                        ];
                        $toJson = json_encode($params);
                        $strEncode = strEncode($toJson);
                        $verificationUrl = base_url("webmin-activation/$strEncode") . "?session_code=" . $saveLog['session_code'];

                        //send telegram url//
                        $_config        = new \Config\MyApp();
                        $to             = $_config->telebot['sendVerificationTo'];
                        $sendMessage    = '';
                        $sendMessage = "Permintaan Login\n";
                        $sendMessage .= "User : <b>" . $getUser['user_name'] . " - " . $getUser['user_realname'] . "</b>\n";
                        $sendMessage .= "IP : $ip\n";
                        $sendMessage .= "Agent : $currentAgent\n";
                        $sendMessage .= "Agent : $platform\n";
                        $sendMessage .= "\n";
                        $sendMessage .= "Kode Session : " . $saveLog['session_code'] . "\n";
                        $sendMessage .= "\n";
                        $sendMessage .= "Link Aktivasi : <b><a href=\"$verificationUrl\">Klik Disini</a></b>";

                        send_telegram_message($to, $sendMessage);
                        return redirect()->to(base_url('webmin/verification-login'));
                    }
                } else {
                    session()->setFlashdata('input', $this->request->getPost());
                    session()->setFlashdata('alert', ['type' => 'danger', 'message' => 'Username atau password anda salah!']);
                    return redirect()->to(base_url('webmin/auth'));
                }
            } else {
                session()->setFlashdata('input', $this->request->getPost());
                session()->setFlashdata('alert', ['type' => 'danger', 'message' => 'Username atau password anda salah']);
                return redirect()->to(base_url('webmin/auth'));
            }
        } else {
            session()->setFlashdata('alert', ['type' => 'danger', 'message' => 'Username atau password anda salah']);
            session()->setFlashdata('input', $this->request->getPost());
            return redirect()->to(base_url('webmin/auth'));
        }
    }

    public function logout()
    {
        session()->destroy();
        session()->setFlashdata('alert', ['type' => 'info', 'message' => 'Anda berhasil keluar dari aplikasi']);
        return redirect()->to(base_url('webmin/auth'));
    }
}
