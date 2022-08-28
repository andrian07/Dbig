<?php

namespace App\Controllers\Webmin;

use App\Models\Auth\M_user_account;
use App\Controllers\Base\WebminController;

class Profile extends WebminController
{
    protected $M_user_account;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->M_user_account = new M_user_account;
    }

    public function index()
    {
        $data = [
            'title'     => 'Profil',
        ];
        return $this->renderView('auth/profile', $data);
    }

    public function update_password()
    {
        $this->validationRequest(TRUE);
        $validation =  \Config\Services::validation();

        $input = [
            'user_code' => $this->userLogin['user_code'],
            'old_password' => $this->request->getPost('old_password'),
            'new_password' => $this->request->getPost('new_password'),
            'repeat_password' => $this->request->getPost('repeat_password'),
        ];


        $validation->setRules([
            'user_code' => ['label' => 'user_code', 'rules' => 'required|exact_length[4]'],
            'old_password' => ['label' => 'old_password', 'rules' => 'required|min_length[8]|max_length[100]'],
            'new_password' => ['label' => 'new_password', 'rules' => 'required|min_length[8]|max_length[100]'],
            'repeat_password' => ['label' => 'repeat_password', 'rules' => 'required|min_length[8]|max_length[100]|matches[new_password]'],
        ]);

        if ($validation->run($input) === FALSE) {
            $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        } else {
            $old_user_data = $this->M_user_account->getUser($input['user_code'])->getRowArray();
            if ($old_user_data == NULL) {
                $result = ['success' => FALSE, 'message' => 'User tidak ditemukan'];
            } else {
                if (password_verify($input['old_password'], $old_user_data['user_password'])) {
                    $change_password = [
                        'user_code' => $input['user_code'],
                        'user_password' => password_hash($input['new_password'], PASSWORD_BCRYPT),
                    ];
                    $save = $this->M_user_account->updateUser($change_password);
                    if ($save) {
                        $result = ['success' => TRUE, 'message' => 'Password berhasil diganti'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Password gagal diganti'];
                    }
                } else {
                    $result = ['success' => FALSE, 'message' => 'Password lama anda salah'];
                }
            }
        }
        resultJSON($result);
    }



    //--------------------------------------------------------------------

}
