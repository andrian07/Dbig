<?php

namespace App\Controllers\Webmin;

use App\Models\Auth\M_user_group;
use App\Models\Auth\M_user_role;
use App\Controllers\Base\WebminController;

class UserGroup extends WebminController
{
    protected $M_user_group;
    protected $M_user_role;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->M_user_group = new M_user_group;
        $this->M_user_role  = new M_user_role;
    }

    public function index()
    {
        $data = [
            'title'      => 'Grup Pengguna',
            'configRole' => $this->myConfig->userRole
        ];

        return $this->renderView('auth/user_group', $data, 'user_group.view');
    }

    public function table()
    {
        $this->validationRequest(TRUE);
        if ($this->role->hasRole('user_group.view')) {
            helper('datatable');
            $table = new \App\Libraries\Datatables('user_group');
            $table->db->select('user_group.group_code,user_group.group_name');
            $table->db->where('user_group.deleted', 'N');
            $table->db->where('user_group.group_code!=', 'L00');

            $table->renderColumn(function ($row, $i) {
                $column = [];

                $column[] = $i;
                $column[] = esc($row['group_name']);

                $btns = [];
                $prop =  'data-id="' . $row['group_code'] . '" data-name="' . esc($row['group_name']) . '"';
                $btns[] = '<button ' . $prop . ' class="btn btn-sm btn-info btnsetup" data-toggle="tooltip" data-placement="top" data-title="Pengaturan Peran"><i class="fas fa-cog"></i></button>';
                $btns[] = button_edit($prop);
                $btns[] = button_delete($prop);
                $column[] = implode('&nbsp;', $btns);

                return $column;
            });

            $table->orderColumn  = ['', 'user_group.group_name', ''];
            $table->searchColumn = ['user_group.group_name'];
            $table->generate();
        }
    }

    public function getByCode($group_code = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Grup tidak ditemukan'];
        if ($this->role->hasRole('user_group.view')) {
            if ($group_code != '') {
                $find = $this->M_user_group->getGroup($group_code)->getRowArray();
                if ($find == NULL) {
                    $result = ['success' => TRUE, 'exist' => FALSE, 'message' => 'Grup tidak ditemukan'];
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

    public function getByName()
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Grup tidak ditemukan'];
        if ($this->role->hasRole('user_group.view')) {
            $group_name = $this->request->getGet('group_name');
            if (!($group_name == '' ||  $group_name == NULL)) {
                $find = $this->M_user_group->getGroupByName($group_name)->getRowArray();
                if ($find == NULL) {
                    $result = ['success' => TRUE, 'exist' => FALSE, 'message' => 'Grup tidak ditemukan'];
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
        $result = ['success' => FALSE, 'message' => 'Request tidak valid'];

        $validation =  \Config\Services::validation();
        $input = [
            'group_code'     => $this->request->getPost('group_code'),
            'group_name'     => $this->request->getPost('group_name')
        ];

        $validation->setRules([
            'group_code'     => ['label' => 'group_code', 'rules' => 'required|exact_length[3]'],
            'group_name'     => ['label' => 'group_name', 'rules' => 'required|max_length[100]|is_unique[user_group.group_name,group_code,{group_code}]'],
        ]);

        if ($validation->run($input) === FALSE) {
            $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        } else {
            if ($type == 'add') {
                if ($this->role->hasRole('user_group.add')) {
                    $save = $this->M_user_group->insertGroup($input);
                    if ($save) {
                        $result = ['success' => TRUE, 'message' => 'Data grup berhasil disimpan'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data grup gagal disimpan'];
                    }
                } else {
                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menambah grup'];
                }
            } else if ($type == 'edit') {
                if ($this->role->hasRole('user_group.edit')) {
                    $save = $this->M_user_group->updateGroup($input);
                    if ($save) {
                        $result = ['success' => TRUE, 'message' => 'Data grup berhasil diperbarui'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data grup gagal diperbarui'];
                    }
                } else {
                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk mengubah grup'];
                }
            }
        }


        resultJSON($result);
    }

    public function delete($group_code = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];

        if ($this->role->hasRole('user_group.delete')) {
            if ($group_code != '') {
                $hasUser = $this->M_user_group->hasUser($group_code);
                if ($hasUser) {
                    $result = ['success' => FALSE, 'message' => 'Data grup tidak dapat dihapus'];
                } else {
                    $delete = $this->M_user_group->deleteGroup($group_code);
                    if ($delete) {
                        $result = ['success' => TRUE, 'message' => 'Data grup berhasil dihapus'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data grup gagal dihapus'];
                    }
                }
            }
        } else {
            $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menghapus grup'];
        }
        resultJSON($result);
    }

    public function getGroupRole($group_code = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Grup tidak ditemukan'];
        if ($this->role->hasRole('user_group.view')) {
            if (!($group_code == '')) {
                $user_group = $this->M_user_group->getGroup($group_code)->getRowArray();
                if (!($user_group == NULL)) {
                    $role =  new \App\Libraries\Roles($this->myConfig->userRole, $group_code);
                    $getRoles = $this->M_user_role->getRole($group_code);
                    foreach ($getRoles->getResultArray() as $user_role) {
                        $role->set($user_role['module_name'], $user_role['role_name'], intval($user_role['role_value']));
                    };

                    $group_roles = [];
                    foreach ($role->get() as $mod_name => $mod_val) {
                        foreach ($mod_val as $role_name => $role_val) {
                            $group_roles[] = [
                                'module_name' => $mod_name,
                                'role_name' => $role_name,
                                'role_value' => $role_val
                            ];
                        }
                    }

                    $group_data = [
                        'group_code' => esc($user_group['group_code']),
                        'group_name' => esc($user_group['group_name']),
                        'roles'      =>  $group_roles
                    ];

                    $result = ['success' => TRUE, 'exist' => TRUE, 'data' => $group_data, 'message' => ''];
                } else {
                    $result = ['success' => TRUE, 'exist' => FALSE, 'message' => 'Grup tidak ditemukan'];
                }
            }
        }
        resultJSON($result);
    }

    public function setGroupRole()
    {
        $this->validationRequest(TRUE);
        $responseCode = 400;
        $result = ['status' => FALSE, 'message' => 'Anda tidak memiliki akses untuk mengatur peran'];
        if ($this->role->hasRole('user_group.add') || $this->role->hasRole('user_group.edit')) {
            $group_code     = $this->request->getPost('pk');
            $module_name    = $this->request->getPost('name');
            $value          = $this->request->getPost('value[]');

            if (!($group_code == '')) {
                $user_group = $this->M_user_group->getGroup($group_code)->getRowArray();
                if (!($user_group == NULL)) {
                    $role =  new \App\Libraries\Roles($this->myConfig->userRole, $group_code);
                    $module_role = $role->get($module_name);
                    if ($value != NULL) {
                        foreach ($value as $role_name) {
                            if (isset($module_role[$role_name])) {
                                $module_role[$role_name] = 1;
                            }
                        }

                        if (count($value) > 0) {
                            if (isset($module_role['view'])) {
                                $module_role['view'] = 1;
                            }
                        }
                    }

                    $group_role = [];
                    foreach ($module_role as $role_name => $role_value) {
                        $group_role[] = [
                            'group_code' => $group_code,
                            'module_name' => $module_name,
                            'role_name' => $role_name,
                            'role_value' => $role_value
                        ];
                    }

                    $save = $this->M_user_role->updateRole($group_role);
                    if ($save) {
                        $responseCode = 200;
                        $result = ['status' => TRUE, 'message' => 'Pengaturan berhasil disimpan'];
                    } else {
                        $result = ['status' => FALSE, 'message' => 'Pengaturan gagal disimpan'];
                    }
                }
            }
        }
        $result['csrfHash'] = csrf_hash();
        return $this->response->setStatusCode($responseCode)->setBody(json_encode($result, JSON_HEX_APOS | JSON_HEX_QUOT));
    }
    //--------------------------------------------------------------------

}
