<?php


namespace App\Controllers\Webmin;

use App\Models\Auth\M_user_account;
use App\Models\Auth\M_user_group;
use App\Controllers\Base\WebminController;

class UserAccount extends WebminController
{
    protected $M_user_account;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->M_user_account   = new M_user_account;
        $this->M_user_group     = new M_user_group;
    }

    public function index()
    {
        $data = [
            'title'         => 'Akun Pengguna',
            'user_group'    => $this->M_user_group->getGroup()->getResultArray()
        ];

        return $this->renderView('auth/user_account', $data, 'user_account.view');
    }

    public function table()
    {
        $this->validationRequest(TRUE);
        if ($this->role->hasRole('user_account.view')) {
            helper('datatable');
            $table = new \App\Libraries\Datatables('user_account');
            $table->db->select('user_account.user_id,user_account.user_code,user_account.user_name,user_account.user_realname,ms_store.store_name,user_group.group_name,user_account.active,user_account.user_index_fingerprint');
            $table->db->join('ms_store', 'ms_store.store_id=user_account.store_id');
            $table->db->join('user_group', 'user_group.group_code=user_account.user_group');


            $table->db->where('user_account.deleted', 'N');

            $table->db->where('user_account.user_code!=', 'U000');

            $table->renderColumn(function ($row, $i) {
                $column = [];
                $column[] = $i;
                $column[] = esc($row['user_name']);
                $column[] = esc($row['user_realname']);
                $column[] = esc($row['store_name']);
                $column[] = esc($row['group_name']);
                $column[] = $row['active'] == 'Y' ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-danger">Tidak Aktif</span>';

                $has_fingerprint = $row['user_index_fingerprint'] == '' ? FALSE : TRUE;

                $btns = [];
                $prop =  'data-id="' . $row['user_code'] . '" data-name="' . esc($row['user_name']) . '" data-realname="' . esc($row['user_realname']) . '"';
                if ($has_fingerprint) {
                    $btns[] = '<button ' . $prop . ' class="btn btn-sm btn-warning btnaddfingerprint mb-2" data-toggle="tooltip" data-placement="top" data-title="Ubah Fingerprint"><i class="fas fa-fingerprint"></i></button>&nbsp';
                } else {
                    $btns[] = '<button ' . $prop . ' class="btn btn-sm btn-default btnaddfingerprint mb-2" data-toggle="tooltip" data-placement="top" data-title="Tambah Fingerprint"><i class="fas fa-fingerprint"></i></button>&nbsp';
                }

                $btns[] = '<button ' . $prop . ' class="btn btn-sm btn-default btnresetpassword mb-2" data-toggle="tooltip" data-placement="top" data-title="Reset Kata Sandi"><i class="fas fa-key"></i></button><br>';
                $btns[] = button_edit($prop) . '&nbsp;';
                $btns[] = button_delete($prop);
                $column[] = implode('', $btns);
                return $column;
            });

            $table->orderColumn  = ['', 'user_account.user_name', 'user_account.user_realname', 'ms_store.store_name', 'user_group.group_name', 'user_account.active', ''];
            $table->searchColumn = ['user_account.user_name', 'user_account.user_realname'];
            $table->generate();
        }
    }

    public function getByCode($user_code = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Data pengguna tidak ditemukan'];
        if ($this->role->hasRole('user_account.view')) {
            if ($user_code != '') {
                $find = $this->M_user_account->getUser($user_code)->getRowArray();
                if ($find == NULL) {
                    $result = ['success' => TRUE, 'exist' => FALSE, 'message' => 'Data pengguna tidak ditemukan'];
                } else {
                    $find_result = array();
                    foreach ($find as $k => $v) {
                        if ($k != 'user_password') {
                            $find_result[$k] = esc($v);
                        }
                    }
                    $result = ['success' => TRUE, 'exist' => TRUE, 'data' => $find_result, 'message' => ''];
                }
            }
        }

        resultJSON($result);
    }

    public function getByName()
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Data pengguna tidak ditemukan'];
        if ($this->role->hasRole('user_account.view')) {
            $user_name = $this->request->getGet('user_name');
            if (!($user_name == '' || $user_name == NULL)) {
                $find = $this->M_user_account->getUserByName($user_name, TRUE)->getRowArray();
                if ($find == NULL) {
                    $result = ['success' => TRUE, 'exist' => FALSE, 'message' => 'Data pengguna tidak ditemukan'];
                } else {
                    $find_result = array();
                    foreach ($find as $k => $v) {
                        if ($k != 'user_password') {
                            $find_result[$k] = esc($v);
                        }
                    }
                    $result = ['success' => TRUE, 'exist' => TRUE, 'data' => $find_result, 'message' => ''];
                }
            }
        }
        resultJSON($result);
    }

    public function save($type)
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        $validation =  \Config\Services::validation();
        $input = [
            'user_code'     => $this->request->getPost('user_code'),
            'user_name'     => $this->request->getPost('user_name'),
            'user_realname' => $this->request->getPost('user_realname'),
            'user_group'    => $this->request->getPost('user_group'),
            'store_id'      => $this->request->getPost('store_id'),
            'active'        => $this->request->getPost('active')
        ];

        $validation->setRules([
            'user_code'     => ['label' => 'user_code', 'rules' => 'required|exact_length[4]'],
            'user_name'     => ['label' => 'username', 'rules' => 'required|min_length[5]|max_length[25]|is_unique[user_account.user_name,user_code,{user_code}]'],
            'user_realname' => ['label' => 'Nama Pengguna', 'rules' => 'required|max_length[200]'],
            'user_group'    => ['label' => 'Grup Pengguna', 'rules' => 'required|exact_length[3]'],
            'store_id'      => ['label' => 'Toko', 'rules' => 'required'],
            'active'        => ['label' => 'aktif', 'rules' => 'required|in_list[Y,N]'],
        ]);


        $plain_password = $this->request->getPost('user_password');
        if ($type == 'add' || !empty($plain_password)) {
            $input['user_password'] = $this->request->getPost('user_password');
            $validation->setRules([
                'user_password' => ['label' => 'user_password', 'rules' => 'required|min_length[8]|max_length[100]'],
            ]);
        }

        if ($validation->run($input) === FALSE) {
            $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        } else {
            if ($plain_password != '') {
                $input['user_password'] = password_hash($plain_password, PASSWORD_BCRYPT);
            }

            if ($type == 'add') {
                if ($this->role->hasRole('user_account.add')) {
                    $save = $this->M_user_account->insertUser($input);
                    if ($save) {
                        $result = ['success' => TRUE, 'message' => 'Data pengguna berhasil disimpan'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data pengguna gagal disimpan'];
                    }
                } else {
                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menambah pengguna'];
                }
            } else if ($type == 'edit') {
                if ($this->role->hasRole('user_account.edit')) {
                    $save = $this->M_user_account->updateUser($input);
                    if ($save) {
                        $result = ['success' => TRUE, 'message' => 'Data pengguna berhasil diperbarui'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data pengguna gagal diperbarui'];
                    }
                } else {
                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk mengubah pengguna'];
                }
            }
        }

        resultJSON($result);
    }

    public function delete($user_code = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        if ($this->role->hasRole('user_account.delete')) {
            if ($user_code != '') {
                $delete = $this->M_user_account->deleteUser($user_code);
                if ($delete) {
                    $result = ['success' => TRUE, 'message' => 'Data pengguna berhasil dihapus'];
                } else {
                    $result = ['success' => FALSE, 'message' => 'Data pengguna gagal dihapus'];
                }
            }
        } else {
            $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menghapus pengguna'];
        }
        resultJSON($result);
    }

    public function resetPassword($user_code = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        if ($this->role->hasRole('user_account.reset_password')) {
            if ($user_code != '') {
                helper('text');
                $new_password = strtoupper(random_string('alnum', 8));
                $updateData = [
                    'user_code'     => $user_code,
                    'user_password' => password_hash($new_password, PASSWORD_BCRYPT)
                ];

                $reset_password = $this->M_user_account->updateUser($updateData);
                if ($reset_password) {
                    $result = ['success' => TRUE, 'new_password' => $new_password, 'message' => 'Reset password pengguna berhasil'];
                } else {
                    $result = ['success' => FALSE, 'message' => 'Reset password pengguna gagal'];
                }
            }
        } else {
            $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk mereset password pengguna'];
        }
        resultJSON($result);
    }

    public function addFingerPrint($user_id)
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        if ($this->role->hasRole('user_account.add_fingerprint')) {
            $fingerdata = $this->request->getPost('fingerdata');

            if ($user_id != '' && $fingerdata != NULL) {
                $user_data = json_decode($fingerdata, true);
                helper('fingerprint');
                $index_finger   = isset($user_data['index_finger']) ? $user_data['index_finger'] : [];
                $middle_finger  = isset($user_data['middle_finger']) ? $user_data['middle_finger'] : [];

                $pre_reg_fmd_array = [
                    "index_finger"  => $index_finger,
                    "middle_finger" => $middle_finger
                ];


                $list_fingerprints = [];
                $getData = $this->M_user_account->getUserHasFingerPrint()->getResultArray();
                foreach ($getData as $row) {
                    $list_fingerprints[] = [
                        'indexfinger'   => $row['user_index_fingerprint'],
                        'middlefinger'  => $row['user_middle_fingerprint']
                    ];
                }

                $isDuplicate = FALSE;

                if (count($list_fingerprints) > 0) {
                    $json_response = is_duplicate_fingerprint($index_finger[0],  $list_fingerprints);
                    $response = json_decode($json_response);
                    if ($response) {
                        $isDuplicate = TRUE;
                    }
                }

                if (count($list_fingerprints) > 0) {
                    $json_response = is_duplicate_fingerprint($middle_finger[0],  $list_fingerprints);
                    $response = json_decode($json_response);
                    if ($response) {
                        $isDuplicate = TRUE;
                    }
                }


                if ($isDuplicate) {
                    $result = ['success' => FALSE, 'message' => 'Sidik jari sudah terdaftar'];
                } else {
                    $json_response = enroll_fingerprint($pre_reg_fmd_array);
                    $response = json_decode($json_response);
                    if ($response !== "enrollment failed") {
                        $enrolled_index_finger_fmd_string = $response->enrolled_index_finger;
                        $enrolled_middle_finger_fmd_string = $response->enrolled_middle_finger;

                        $update = $this->M_user_account->updateFingerPrint($user_id, $enrolled_index_finger_fmd_string, $enrolled_middle_finger_fmd_string);
                        if ($update) {
                            $result = ['success' => TRUE, 'message' => 'Sidik jari pengguna berhasil didaftarkan'];
                        } else {
                            $result = ['success' => FALSE, 'message' => 'Sidik jari pengguna gagal didaftarkan'];
                        }
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Terjadi kesalahan dalam mendaftarkan sidik jari pengguna'];
                    }
                }
            }
        } else {
            $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk mendaftarkan sidik jari pengguna'];
        }
        resultJSON($result);
    }

    public function testFingerPrint()
    {
        $data = [
            'title'         => 'Test Fingerprint',
        ];

        return $this->renderView('auth/test_fingerprint', $data, 'user_account.view');
    }



    //--------------------------------------------------------------------

}
