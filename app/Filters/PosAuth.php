<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\Auth\M_user_account;
use App\Models\Auth\M_user_role;

class PosAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $getLoginData = session()->get('pos_login');
        if ($getLoginData == NULL) {
            return redirect()->to(base_url('pos/auth'));
        } else {
            $M_user_account = new M_user_account();
            $M_user_role    = new M_user_role();
            $getUser = $M_user_account->getUser($getLoginData['user_code'])->getRowArray();
            if ($getUser == NULL) {
                session()->remove('pos_login');
                return redirect()->to(base_url('pos/auth'));
            } else {
                if ($getUser['active'] == 'N') {
                    session()->remove('pos_login');
                    session()->setFlashdata('alert', array('type' => 'info', 'message' => 'Akun anda berstatus tidak aktif harap hubungi administrator'));
                    return redirect()->to(base_url('pos/auth'));
                } else {
                    $hasAccess = 0;
                    if ($getUser['user_group'] != 'L00') {
                        $hasAccess = $M_user_role->hasRole($getUser['user_group'], 'pos', 'view');
                    }

                    if ($hasAccess) {
                        $loginData = [
                            'user_id'       => $getUser['user_id'],
                            'user_code'     => esc($getUser['user_code']),
                            'user_name'     => esc($getUser['user_name']),
                            'user_realname' => esc($getUser['user_realname']),
                            'user_group'    => esc($getUser['user_group']),
                            'group_name'    => esc($getUser['group_name']),
                            'store_id'      => esc($getUser['store_id']),
                            'store_code'    => esc($getUser['store_code']),
                            'store_name'    => esc($getUser['store_name']),
                        ];
                        session()->set('pos_login', $loginData);
                    } else {
                        session()->remove('pos_login');
                        session()->setFlashdata('alert', array('type' => 'danger', 'message' => 'Anda tidak memiliki akses ke module POS'));
                        return redirect()->to(base_url('pos/auth'));
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
