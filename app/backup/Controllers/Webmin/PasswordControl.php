<?php

namespace App\Controllers\Webmin;

use App\Models\M_password_control;
use App\Controllers\Base\WebminController;

class PasswordControl extends WebminController
{
    protected $M_password_control;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->M_password_control = new M_password_control;
    }

    public function index()
    {
        $data = [
            'title'      => 'Password Control',
        ];

        return $this->renderView('password_control/password_control', $data, 'password_control.view');
    }

    public function table()
    {
        $this->validationRequest(TRUE);
        if ($this->role->hasRole('password_control.view')) {
            helper('datatable');
            $table = new \App\Libraries\Datatables('password_control');
            $table->db->select('password_control.password_control_id,password_control.user_id,password_control.active,user_account.user_name,user_account.user_realname,ms_store.store_name,user_group.group_name');
            $table->db->join('user_account', 'user_account.user_id=password_control.user_id');
            $table->db->join('user_group', 'user_group.group_code=user_account.user_group');
            $table->db->join('ms_store', 'ms_store.store_id=user_account.store_id');
            $table->db->where('password_control.deleted', 'N');

            $table->renderColumn(function ($row, $i) {
                $column = [];

                $column[] = $i;
                $column[] = esc($row['user_name']);
                $column[] = esc($row['user_realname']);
                $column[] = esc($row['store_name']);
                $column[] = esc($row['group_name']);
                $column[] = $row['active'] == 'Y' ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-danger">Tidak Aktif</span>';


                $btns = [];
                $prop =  'data-id="' . $row['password_control_id'] . '" data-name="' . esc($row['user_name']) . '"';
                $btns[] = button_edit($prop);
                $btns[] = button_delete($prop);
                $column[] = implode('&nbsp;', $btns);

                return $column;
            });

            $table->orderColumn  = ['', 'user_account.user_name', 'user_account.user_realname', 'ms_store.store_name', 'user_group.group_name', 'password_control.active', ''];
            $table->searchColumn = ['user_account.user_name', 'user_account.user_realname'];
            $table->generate();
        }
    }

    public function getById($password_control_id = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Data akun tidak ditemukan'];
        if ($this->role->hasRole('password_control.view')) {
            if ($password_control_id != '') {
                $find = $this->M_password_control->getPasswordControl($password_control_id, FALSE)->getRowArray();
                if ($find == NULL) {
                    $result = ['success' => TRUE, 'exist' => FALSE, 'message' => 'Data kategori tidak ditemukan'];
                } else {
                    $find_result = [];
                    foreach ($find as $k => $v) {
                        $find_result[$k] = esc($v);
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
            'password_control_id'       => $this->request->getPost('password_control_id'),
            'user_id'                   => $this->request->getPost('user_id'),
            'active'                    => $this->request->getPost('active'),
        ];

        $validation->setRules([
            'password_control_id'       => ['rules' => 'required'],
            'user_id'                   => ['rules' => 'required'],
            'active'                    => ['rules' => 'required|in_list[Y,N]']
        ]);


        if ($validation->run($input) === FALSE) {
            $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        } else {
            if ($type == 'add') {
                if ($this->role->hasRole('password_control.add')) {
                    helper('text');
                    unset($input['password_control_id']);
                    $input['user_pin'] = md5(random_string('numeric', 8));
                    $save = $this->M_password_control->insertPasswordControl($input);
                    if ($save) {
                        $result = ['success' => TRUE, 'message' => 'Data akun berhasil disimpan'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data akun gagal disimpan'];
                    }
                } else {
                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menambah akses akun'];
                }
            } else if ($type == 'edit') {
                if ($this->role->hasRole('password_control.edit')) {
                    $save = $this->M_password_control->updatePasswordControl($input);
                    if ($save) {
                        $result = ['success' => TRUE, 'message' => 'Data akun berhasil diperbarui'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data akun gagal diperbarui'];
                    }
                } else {
                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk mengubah akses akun'];
                }
            }
        }


        $result['csrfHash'] = csrf_hash();
        resultJSON($result);
    }

    public function delete($password_control_id = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        if ($this->role->hasRole('password_control.delete')) {
            $hasLog = $this->M_password_control->hasLog($password_control_id);
            if ($hasLog) {
                $result = ['success' => FALSE, 'message' => 'Akses akun tidak dapat dihapus'];
            } else {
                if ($password_control_id != '') {
                    $delete = $this->M_password_control->deletePasswordControl($password_control_id);
                    if ($delete) {
                        $result = ['success' => TRUE, 'message' => 'Data akun berhasil dihapus'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data akun gagal dihapus'];
                    }
                }
            }
        } else {
            $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menghapus akun'];
        }
        resultJSON($result);
    }

    public function logs()
    {
        $data = [
            'title'      => 'Logs Password Control',
        ];

        return $this->renderView('password_control/password_control_logs', $data, 'password_control.view');
    }

    public function tableLogs()
    {
        $this->validationRequest(TRUE);
        if ($this->role->hasRole('password_control.view')) {
            $date_from          = $this->request->getPost('date_from') == NULL ? date('Y-m-d') : $this->request->getPost('date_from');
            $date_until         = $this->request->getPost('date_until') == NULL ? date('Y-m-d') : $this->request->getPost('date_until');
            $user_id            = $this->request->getPost('user_id');
            $request_user_id    = $this->request->getPost('request_user_id');
            $store_id           = $this->request->getPost('store_id');

            helper('datatable');
            $table = new \App\Libraries\Datatables('log_password_control');

            $select = 'log_password_control.*,password_control.user_id,user_account.user_realname,request_user.user_realname as request_user_realname,ms_store.store_name';

            $table->db->select($select);
            $table->db->join('password_control', 'password_control.password_control_id=log_password_control.password_control_id');
            $table->db->join('user_account', 'user_account.user_id=password_control.user_id');
            $table->db->join('user_account as request_user', 'request_user.user_id=log_password_control.request_user_id');
            $table->db->join('ms_store', 'ms_store.store_id=user_account.store_id');
            $table->db->where("(date(log_password_control.log_at) BETWEEN '$date_from' AND '$date_until')");

            if ($store_id != NULL) {
                $table->db->where('user_account.store_id', $store_id);
            }

            if ($request_user_id != NULL) {
                $table->db->where('log_password_control.request_user_id', $request_user_id);
            }

            if ($user_id != NULL) {
                $table->db->where('password_control.user_id', $user_id);
            }


            $table->renderColumn(function ($row, $i) {
                $column = [];

                $column[] = $i;
                $column[] = indo_short_date($row['log_at'], TRUE, '<br>');
                $column[] = esc($row['log_remark']);
                $column[] = esc($row['request_user_realname']);
                $column[] = esc($row['user_realname']);
                $column[] = esc($row['store_name']);

                return $column;
            });

            $table->orderColumn  = ['', 'log_password_control.log_at', 'log_password_control.log_remark', 'log_password_control.request_user_id', 'user_account.user_realname', 'ms_store.store_name'];
            $table->searchColumn = ['log_password_control.log_remark'];
            $table->generate();
        }
    }


    //--------------------------------------------------------------------

}
