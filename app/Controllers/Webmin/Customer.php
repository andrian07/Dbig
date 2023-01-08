<?php


namespace App\Controllers\Webmin;

use App\Models\M_customer;
use App\Controllers\Base\WebminController;

class Customer extends WebminController
{
    protected $M_customer;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->M_customer = new M_customer;
    }

    public function index()
    {
        $data = [
            'title'         => 'Customer',
            'customerGroup' => $this->appConfig->get('default', 'customer_group')
        ];

        return $this->renderView('masterdata/customer', $data, 'customer.view');
    }

    public function table()
    {
        $this->validationRequest(TRUE);
        if ($this->role->hasRole('customer.view')) {
            helper('datatable');

            $filter_customer_group  = $this->request->getPost('filter_customer_group');
            $filter_point_by        = $this->request->getPost('filter_point_by');
            $filter_point_value     = $this->request->getPost('filter_point_value');

            $table = new \App\Libraries\Datatables('ms_customer');
            $table->db->select('customer_id,customer_code,customer_name,customer_address,customer_phone,customer_group,customer_point,exp_date');
            $table->db->where('deleted', 'N');

            if (!($filter_customer_group == NULL || $filter_customer_group == '')) {
                $table->db->where('customer_group',  $filter_customer_group);
            }

            if (!($filter_point_by == NULL || $filter_point_by == '')) {
                $operator = [
                    'greater_than'          => '>',
                    'lower_than'            => '<',
                    'greater_than_equal'    => '>=',
                    'lower_than_equal'      => '<='
                ];
                $fp     = isset($operator[$filter_point_by]) ? $operator[$filter_point_by] : '';
                $point  = (int)$filter_point_value;

                $table->db->where('customer_point' . $fp,  $point);
            }

            $config_label_group = $this->appConfig->get('default', 'label_customer_group');

            $table->renderColumn(function ($row, $i) use ($config_label_group) {
                $column = [];
                $column[] = $i;
                $column[] = esc($row['customer_code']);
                $column[] = esc($row['customer_name']);
                $column[] = esc($row['customer_address']);
                $column[] = esc($row['customer_phone']);

                $column[] = isset($config_label_group[$row['customer_group']]) ? $config_label_group[$row['customer_group']] : 'ERROR';
                $column[] = numberFormat($row['customer_point'], TRUE);
                $column[] = indo_short_date($row['exp_date']);
                $btns = [];
                $prop =  'data-id="' . $row['customer_id'] . '" data-name="' . esc($row['customer_name']) . '"';
                $btns[] = '<button ' . $prop . ' class="btn btn-sm btn-default btndetail mb-2" data-toggle="tooltip" data-placement="top" data-title="Detail"><i class="fas fa-eye"></i></button>&nbsp;';
                $btns[] = '<button ' . $prop . ' class="btn btn-sm btn-default btnresetpassword mb-2" data-toggle="tooltip" data-placement="top" data-title="Reset Kata Sandi"><i class="fas fa-key"></i></button><br>';
                $btns[] = button_edit($prop);
                $btns[] = '&nbsp;';
                $btns[] = button_delete($prop);
                $column[] = implode('', $btns);

                return $column;
            });

            $table->orderColumn  = ['customer_id', 'customer_code', 'customer_name', 'customer_address', 'customer_phone', 'customer_group', 'customer_point', 'exp_date', ''];
            $table->searchColumn = ['customer_code', 'customer_name', 'customer_email', 'customer_phone'];
            $table->generate();
        }
    }

    public function detail($customer_id)
    {
        echo "Detail!";
    }

    public function getById($customer_id = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Data customer tidak ditemukan'];
        if ($this->role->hasRole('customer.view')) {
            if ($customer_id != '') {
                $find = $this->M_customer->getCustomer($customer_id)->getRowArray();
                if ($find == NULL) {
                    $result = ['success' => TRUE, 'exist' => FALSE, 'message' => 'Data customer tidak ditemukan'];
                } else {
                    $find_result = [];
                    foreach ($find as $k => $v) {
                        if ($k != 'customer_password') {
                            $find_result[$k] = esc($v);
                        }
                    }
                    $result = ['success' => TRUE, 'exist' => TRUE, 'data' => $find_result, 'message' => ''];
                }
            }
        }

        resultJSON($result);
    }

    public function getByEmail()
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Data customer tidak ditemukan'];
        if ($this->role->hasRole('customer.view')) {
            $customer_email = $this->request->getGet('customer_email');

            if (!($customer_email == '' || $customer_email == NULL)) {
                $find = $this->M_customer->getCustomerByEmail($customer_email, TRUE)->getRowArray();
                if ($find == NULL) {
                    $result = ['success' => TRUE, 'exist' => FALSE, 'message' => 'Data customer tidak ditemukan'];
                } else {
                    $find_result = array();
                    foreach ($find as $k => $v) {
                        if ($k != 'customer_password') {
                            $find_result[$k] = esc($v);
                        }
                    }
                    $result = ['success' => TRUE, 'exist' => TRUE, 'data' => $find_result, 'message' => ''];
                }
            }
        }
        resultJSON($result);
    }

    public function getByCode()
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Data customer tidak ditemukan'];
        if ($this->role->hasRole('customer.view')) {
            $customer_code = $this->request->getGet('customer_code');
            if (!($customer_code == '' || $customer_code == NULL)) {
                $find = $this->M_customer->getCustomerByCode($customer_code, TRUE)->getRowArray();
                if ($find == NULL) {
                    $result = ['success' => TRUE, 'exist' => FALSE, 'message' => 'Data customer tidak ditemukan'];
                } else {
                    $find_result = array();
                    foreach ($find as $k => $v) {
                        if ($k != 'customer_password') {
                            $find_result[$k] = esc($v);
                        }
                    }
                    $result = ['success' => TRUE, 'exist' => TRUE, 'data' => $find_result, 'message' => ''];
                }
            }
        }
        resultJSON($result);
    }

    public function getByPhone()
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Data customer tidak ditemukan'];
        if ($this->role->hasRole('customer.view')) {
            $customer_phone = $this->request->getGet('customer_phone');
            if (!($customer_phone == '' || $customer_phone == NULL)) {
                $find = $this->M_customer->getCustomerByPhone($customer_phone, TRUE)->getRowArray();
                if ($find == NULL) {
                    $result = ['success' => TRUE, 'exist' => FALSE, 'message' => 'Data customer tidak ditemukan'];
                } else {
                    $find_result = array();
                    foreach ($find as $k => $v) {
                        if ($k != 'customer_password') {
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
            'customer_id'                   => $this->request->getPost('customer_id'),
            'customer_code'                 => $this->request->getPost('customer_code'),
            'customer_name'                 => $this->request->getPost('customer_name'),
            'customer_address'              => $this->request->getPost('customer_address'),
            'customer_phone'                => $this->request->getPost('customer_phone'),
            'customer_email'                => $this->request->getPost('customer_email'),
            'customer_group'                => $this->request->getPost('customer_group'),
            'mapping_id'                    => $this->request->getPost('mapping_id'),
            'exp_date'                      => $this->request->getPost('exp_date'),
            'active'                        => $this->request->getPost('active'),

            'customer_gender'               => $this->request->getPost('customer_gender'),
            'customer_job'                  => $this->request->getPost('customer_job'),
            'customer_birth_date'           => $this->request->getPost('customer_birth_date'),
            'salesman_id'                   => $this->request->getPost('salesman_id'),
            'customer_remark'               => $this->request->getPost('customer_remark'),
            'customer_delivery_address'     => $this->request->getPost('customer_delivery_address'),
            'customer_npwp'                 => $this->request->getPost('customer_npwp'),
            'customer_nik'                  => $this->request->getPost('customer_nik'),
            'customer_tax_invoice_name'     => $this->request->getPost('customer_tax_invoice_name'),
            'customer_tax_invoice_address'  => $this->request->getPost('customer_tax_invoice_address'),
        ];

        $validation->setRules([
            'customer_id'                   => ['rules' => 'required'],
            'customer_code'                 => ['rules' => 'required|max_length[10]'],
            'customer_name'                 => ['rules' => 'required|max_length[200]'],
            'customer_address'              => ['rules' => 'max_length[500]'],
            'customer_phone'                => ['rules' => 'required|min_length[8]|max_length[15]'],
            'customer_email'                => ['rules' => 'required|max_length[200]'],
            'customer_group'                => ['rules' => 'required|in_list[G1,G2,G3,G4,G5,G6]'],
            'exp_date'                      => ['rules' => 'required'],
            'active'                        => ['rules' => 'required|in_list[Y,N]'],

            'customer_gender'               => ['rules' => 'required|in_list[P,L]'],
            'customer_job'                  => ['rules' => 'max_length[200]'],
            'customer_remark'               => ['rules' => 'max_length[500]'],
            'customer_delivery_address'     => ['rules' => 'max_length[500]'],
            'customer_npwp'                 => ['rules' => 'max_length[50]'],
            'customer_nik'                  => ['rules' => 'max_length[50]'],
            'customer_tax_invoice_name'     => ['rules' => 'max_length[200]'],
            'customer_tax_invoice_address'  => ['rules' => 'max_length[500]'],
        ]);

        if ($validation->run($input) === FALSE) {
            $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        } else {
            if ($input['mapping_id'] == NULL) {
                $input['mapping_id'] = 0;
            }

            if ($input['salesman_id'] == NULL) {
                $input['salesman_id'] = 0;
            }

            if ($type == 'add') {
                if ($this->role->hasRole('customer.add')) {
                    helper('text');
                    unset($input['customer_id']);

                    $customer_password = strtoupper(random_string('alnum', 8));
                    $input['customer_password'] = password_hash($customer_password, PASSWORD_BCRYPT);

                    $isFound        = FALSE;
                    $referral_code  = '';
                    while ($isFound == FALSE) {
                        $referral_code = strtoupper(random_string('alnum', 6));
                        $check = $this->M_customer->getCustomerByReferralCode($referral_code, TRUE)->getRowArray();
                        if ($check == NULL) {
                            $isFound = TRUE;
                        }
                    }

                    $input['referral_code'] = $referral_code;

                    $save = $this->M_customer->insertCustomer($input);
                    if ($save) {
                        $result = ['success' => TRUE, 'message' => 'Data customer berhasil disimpan'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data customer gagal disimpan'];
                    }
                } else {
                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menambah customer'];
                }
            } else if ($type == 'edit') {
                if ($this->role->hasRole('customer.edit')) {
                    $save = $this->M_customer->updateCustomer($input);
                    if ($save) {
                        $result = ['success' => TRUE, 'message' => 'Data customer berhasil diperbarui'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data customer gagal diperbarui'];
                    }
                } else {
                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk mengubah customer'];
                }
            }
        }


        $result['csrfHash'] = csrf_hash();
        resultJSON($result);
    }

    public function delete($customer_id = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        if ($this->role->hasRole('customer.delete')) {
            if ($customer_id != '') {
                $hasTransaction = $this->M_customer->hasTransaction($customer_id);
                if ($hasTransaction) {
                    $result = ['success' => FALSE, 'message' => 'Customer tidak dapat dihapus'];
                } else {
                    $delete = $this->M_customer->deleteCustomer($customer_id);
                    if ($delete) {
                        $result = ['success' => TRUE, 'message' => 'Data customer berhasil dihapus'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data customer gagal dihapus'];
                    }
                }
            }
        } else {
            $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menghapus customer'];
        }
        resultJSON($result);
    }

    public function resetPassword($customer_id = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        if ($this->role->hasRole('customer.reset_password')) {
            if ($customer_id != '') {
                helper('text');
                $new_password = strtoupper(random_string('alnum', 8));
                $updateData = [
                    'customer_id'       => $customer_id,
                    'customer_password' => password_hash($new_password, PASSWORD_BCRYPT)
                ];

                $reset_password = $this->M_customer->updateCustomer($updateData);
                if ($reset_password) {
                    $result = ['success' => TRUE, 'new_password' => $new_password, 'message' => 'Reset password customer berhasil'];
                } else {
                    $result = ['success' => FALSE, 'message' => 'Reset password customer gagal'];
                }
            }
        } else {
            $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk mereset password customer'];
        }
        resultJSON($result);
    }
    //--------------------------------------------------------------------
}
