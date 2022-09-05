<?php

namespace App\Controllers\Pos;

use App\Controllers\Base\BaseController;
use App\Models\Auth\M_user_account;

class Auth extends BaseController
{
    protected $M_user_account;
    protected $helpers = [];

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->M_user_account = new M_user_account();
    }

    public function index()
    {
        if (session()->get('pos_login') != NULL) {
            return redirect()->to(base_url('pos/dashboard'));
        }

        $data = [
            'alert' => session()->getFlashdata('alert'),
            'input' => session()->getFlashdata('input')
        ];
        return view('pos/auth/login', $data);
    }

    public function login()
    {
        $this->validationRequest();
        if (session()->get('pos_login') != NULL) {
            return redirect()->to(base_url('pos/dashboard'));
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
                    session()->remove('pos_login');
                    session()->setFlashdata('alert', ['type' => 'info', 'message' => 'Akun anda berstatus tidak aktif harap hubungi administrator']);
                    return redirect()->to(base_url('pos/auth'));
                }

                if (password_verify($input['password'], $getUser['user_password'])) {
                    $loginData = [
                        'user_code' => $getUser['user_code'],
                        'user_name' => $getUser['user_name'],
                        'group'     => $getUser['user_group']
                    ];
                    session()->set('pos_login', $loginData);
                    return redirect()->to(base_url('pos/dashboard'));
                } else {
                    session()->setFlashdata('input', $this->request->getPost());
                    session()->setFlashdata('alert', ['type' => 'danger', 'message' => 'Username atau password anda salah!']);
                    return redirect()->to(base_url('pos/auth'));
                }
            } else {
                session()->setFlashdata('input', $this->request->getPost());
                session()->setFlashdata('alert', ['type' => 'danger', 'message' => 'Username atau password anda salah']);
                return redirect()->to(base_url('pos/auth'));
            }
        } else {
            session()->setFlashdata('alert', ['type' => 'danger', 'message' => 'Username atau password anda salah']);
            session()->setFlashdata('input', $this->request->getPost());
            return redirect()->to(base_url('pos/auth'));
        }
    }

    public function logout()
    {
        session()->destroy();
        session()->setFlashdata('alert', ['type' => 'info', 'message' => 'Anda berhasil keluar dari aplikasi']);
        return redirect()->to(base_url('pos/auth'));
    }
}
