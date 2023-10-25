<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\Auth\M_user_account;
use App\Models\Auth\M_log_login;

class WebminAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // $loginData = [
        //     'user_code'     => $getUser['user_code'],
        //     'user_name'     => $getUser['user_name'],
        //     'group'         => $getUser['user_group'],
        //     'login_id'      => $saveLog['login_id'],
        //     'session_code'  => $saveLog['session_code'],
        //     'is_valid'      => 'N',
        //     'exp_login'     => $exp_login
        // ];

        $getLoginData = session()->get('user_login');
        if ($getLoginData == NULL) {
            return redirect()->to(base_url('webmin/auth'));
        } else {
            $M_user_account = new M_user_account();
            $getUser = $M_user_account->getUser($getLoginData['user_code'])->getRowArray();
            if ($getUser == NULL) {
                session()->remove('user_login');
                return redirect()->to(base_url('webmin/auth'));
            } else {
                $getLoginData['user_id'] = $getUser['user_id'];
                $getLoginData['user_code'] = esc($getUser['user_code']);
                $getLoginData['user_name'] = esc($getUser['user_name']);
                $getLoginData['user_realname'] = esc($getUser['user_realname']);
                $getLoginData['user_group'] = esc($getUser['user_group']);
                $getLoginData['group_name'] = esc($getUser['group_name']);
                $getLoginData['store_id'] = esc($getUser['store_id']);
                $getLoginData['store_code'] = esc($getUser['store_code']);
                $getLoginData['store_name'] = esc($getUser['store_name']);
                session()->set('user_login',  $getLoginData);



                if ($getLoginData['is_valid'] == 'Y') {
                    if ($getUser['active'] == 'N') {
                        session()->remove('user_login');
                        session()->setFlashdata('alert', array('type' => 'info', 'message' => 'Akun anda berstatus tidak aktif harap hubungi administrator'));
                        return redirect()->to(base_url('webmin/auth'));
                    }
                } else {
                    $M_log_login = new M_log_login();
                    $getLog = $M_log_login->getLog($getLoginData['login_id'])->getRowArray();
                    if ($getLog['is_valid'] == 'Y') {
                        $getLoginData['is_valid'] = 'Y';
                        session()->set('user_login',  $getLoginData);

                        $uri = $request->getUri();
                        if ($uri->getSegment(2) != 'verification-login') {
                            return redirect()->to(base_url('webmin/profile'));
                        }
                    }


                    $cur_time    = time();
                    $exp_login  = $getLoginData['exp_login'];
                    if ($cur_time >= $exp_login) {
                        $log_data = [
                            'is_expired'    => 'Y',
                            'login_id'      => $getLoginData['login_id']
                        ];

                        $M_log_login->updateLog($log_data);
                        session()->remove('user_login');
                        session()->setFlashdata('alert', array('type' => 'info', 'message' => 'Sesi login anda sudah habis, harap coba lagi'));
                        return redirect()->to(base_url('webmin/auth'));
                    } else {
                        $uri = $request->getUri();
                        if ($uri->getSegment(2) != 'verification-login') {
                            return redirect()->to(base_url('webmin/verification-login'));
                        }
                    }
                }
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
