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


            $config_label_group     = $this->appConfig->get('default', 'label_customer_group');

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
                if ($row['customer_code'] == 'CASH') {
                    $prop .= ' disabled';
                    $detailBtn = '<button ' . $prop . ' class="btn btn-sm btn-default btndetail mb-2" data-toggle="tooltip" data-placement="top" data-title="Detail"><i class="fas fa-eye"></i></button>&nbsp;';
                } else {
                    $detailBtn = '<a href="javascript:;" data-fancybox data-type="iframe" data-src="' . base_url('webmin/customer/detail/' . $row['customer_id']) . '" class="btn btn-sm btn-default mb-2" data-toggle="tooltip" data-placement="top" data-title="Detail"><i class="fas fa-eye"></i></a>&nbsp;';
                }

                $btns[] = $detailBtn;
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

    public function detail($customer_id = '')
    {
        if ($this->role->hasRole('customer.view')) {
            if ($customer_id == '') {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            } else {

                $find = $this->M_customer->getCustomer($customer_id)->getRowArray();
                if ($find == NULL) {
                    throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
                } else {
                    $config_label_group     = $this->appConfig->get('default', 'label_customer_group');
                    $member_group_label     = isset($config_label_group[$find['customer_group']]) ? $config_label_group[$find['customer_group']] : 'ERROR';
                    $invite_by_referral_code = $find['invite_by_referral_code'];
                    $invite_by_user          = NULL;
                    if (!empty($invite_by_referral_code)) {
                        $invite_by_user = $this->M_customer->getCustomerByReferralCode($invite_by_referral_code)->getRowArray();
                    }
                    $data = [
                        'customer'              => $find,
                        'invite_by'             => $invite_by_user,
                        'member_group_label'    =>  $member_group_label
                    ];
                    return view('webmin/masterdata/customer_detail', $data);
                }
            }
        } else {
            die('<h1>ANDA TIDAK MEMILIKI AKSES KE LAMAN INI</h1>');
        }
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
            'customer_address_block'        => $this->request->getPost('customer_address_block'),
            'customer_address_number'       => $this->request->getPost('customer_address_number'),
            'customer_address_rt'           => $this->request->getPost('customer_address_rt'),
            'customer_address_rw'           => $this->request->getPost('customer_address_rw'),
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
            'customer_address_block'        => ['rules' => 'max_length[200]'],
            'customer_address_number'       => ['rules' => 'max_length[200]'],
            'customer_address_rt'           => ['rules' => 'max_length[200]'],
            'customer_address_rw'           => ['rules' => 'max_length[200]'],
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

                    $customer_password = 'dbig1234';
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

    public function downloadImportExcel()
    {
        $M_mapping_area = model('M_mapping_area');
        $M_salesman     = model('M_salesman');
        $getMap         = $M_mapping_area->getMap()->getResultArray();
        $getSalesman    = $M_salesman->getSalesman()->getResultArray();

        $template = WRITEPATH . '/template/template_import_customer.xlsx';
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($template);

        $sheet2     = $spreadsheet->setActiveSheetIndex(1);
        $iRow       = 2;
        foreach ($getMap as $row) {
            $sheet2->getCell('A' . $iRow)->setValue($row['mapping_id']);
            $sheet2->getCell('B' . $iRow)->setValue($row['mapping_code']);
            $sheet2->getCell('C' . $iRow)->setValue($row['mapping_address']);
            $sheet2->getCell('D' . $iRow)->setValue($row['prov_name']);
            $sheet2->getCell('E' . $iRow)->setValue($row['city_name']);
            $sheet2->getCell('F' . $iRow)->setValue($row['dis_name']);
            $sheet2->getCell('G' . $iRow)->setValue($row['subdis_name']);
            $sheet2->getCell('H' . $iRow)->setValue($row['postal_code']);
            $iRow++;
        }

        $sheet3     = $spreadsheet->setActiveSheetIndex(2);
        foreach ($getSalesman as $row) {
            $sheet3->getCell('A' . $iRow)->setValue($row['salesman_id']);
            $sheet3->getCell('B' . $iRow)->setValue($row['salesman_code']);
            $sheet3->getCell('C' . $iRow)->setValue($row['salesman_name']);
            $sheet3->getCell('D' . $iRow)->setValue($row['salesman_address']);
            $sheet3->getCell('E' . $iRow)->setValue($row['salesman_phone']);
            $sheet3->getCell('F' . $iRow)->setValue($row['store_name']);
            $iRow++;
        }

        $filename = 'import_data_customer';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit();
    }

    public function uploadExcel()
    {
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        $validation =  \Config\Services::validation();

        $input = [
            'file_import'         => $this->request->getFile('file_import')
        ];

        $maxUploadSize = $this->maxUploadSize['kb'];
        $ext = 'xlsx';
        $validation->setRules([
            'file_import' => ['rules' => 'max_size[file_import,' . $maxUploadSize . ']|ext_in[file_import,' . $ext . ']'],
        ]);
        if ($validation->run($input) === FALSE) {
            $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        } else {
            $path = $input['file_import']->store();
            if (!$path) {
                $result = ['success' => FALSE, 'message' => 'Upload file excel gagal, Harap coba lagi'];
            } else {
                helper(['import_excel', 'text']);
                $file_path = WRITEPATH . "/uploads/$path";
                //$file_path = WRITEPATH . "/uploads/20230420/import_data_customer.xlsx";
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($file_path);
                $reader->setReadDataOnly(TRUE);

                $spreadsheet = $reader->load($file_path);
                $sheet1 = $spreadsheet->getSheet(0)->toArray(); //customer
                $sheet2 = $spreadsheet->getSheet(1)->toArray(); //kode area
                $sheet3 = $spreadsheet->getSheet(2)->toArray(); //kode salesman


                $salesmanData       = [];
                $mappingData        = [];
                $listNewReffCode    = [];
                $customerData       = [];

                $listGroupCustomer = [
                    'G1'        => 'G1',
                    'G2'        => 'G2',
                    'G3'        => 'G3',
                    'G4'        => 'G4',
                    'G5'        => 'G5',
                    'G6'        => 'G6',
                    'UMUM'      => 'G1',
                    'SILVER'    => 'G2',
                    'GOLD'      => 'G3',
                    'PLATINUM'  => 'G4',
                    'PROYEK'    => 'G5',
                    'CUSTOM'    => 'G6',

                ];
                // read salesman //
                // delete header //
                unset($sheet3[0]);
                foreach ($sheet3 as $row) {
                    $salesman_id                    = $row[0] == null ? 0 : intval($row[0]);
                    $salesman_code                  = $row[1];
                    $salesmanData[$salesman_code]   = $salesman_id;
                }

                // read mapping //
                // delete header //
                unset($sheet2[0]);
                foreach ($sheet2 as $row) {
                    $mapping_id                     = $row[0];
                    $mapping_code                   = strtoupper($row[1]);
                    $mappingData[$mapping_code]     = $mapping_id;
                }

                // read customer //
                // delete header //
                unset($sheet1[0]);
                unset($sheet1[1]);
                foreach ($sheet1 as $row) {
                    if ($row[1] != null) {
                        $verification_email             = 'N';
                        $customer_code                  = $row[0] == null ? '' : $row[0];
                        $customer_name                  = $row[1];
                        $group_name                     = strtoupper($row[2]);
                        $customer_group                 = isset($listGroupCustomer[$group_name]) ? $listGroupCustomer[$group_name] : $group_name;

                        $customer_gender                = $row[3];
                        $customer_birth_date            = indo_to_mysql_date($row[4]);
                        $customer_job                   = $row[5] == null ? '' : $row[5];
                        $customer_email                 = $row[6] == null ? '' : $row[6];
                        if ($customer_email == '') {
                            $customer_email = 'u' . random_string('alnum', 12) . '@dbig.com';
                        } else {
                            $verification_email = 'Y';
                        }

                        $customer_phone                 = $row[7];
                        $customer_address               = $row[8];
                        $customer_address_block         = $row[9] == null ? '' : $row[9];
                        $customer_address_number        = $row[10] == null ? '' : $row[10];
                        $customer_address_rt            = $row[11] == null ? '' : $row[11];
                        $customer_address_rw            = $row[12] == null ? '' : $row[12];

                        $salesman_code                  = $row[13];
                        $mapping_code                   = $row[14];
                        $salesman_id                    = isset($salesmanData[$salesman_code]) ? $salesmanData[$salesman_code] : 0;
                        $mapping_id                     = isset($mappingData[$mapping_code]) ? $mappingData[$mapping_code] : 0;

                        $customer_tax_invoice_name      = $row[15] == null ? '' : $row[15];
                        $customer_tax_invoice_address   = $row[16] == null ? '' : $row[16];
                        $customer_npwp                  = $row[17] == null ? '' : $row[17];
                        $customer_nik                   = $row[18] == null ? '' : $row[18];
                        $customer_delivery_address      = $row[19] == null ? $customer_address : $row[19];
                        $customer_remark                = $row[20] == null ? '' : $row[20];
                        $exp_date                       = $row[21] == null ? '2050-01-01' : indo_to_mysql_date($row[21], '2050-01-01');
                        $customer_point                 = $row[22] == null ? 0 : floatval($row[22]);
                        $customer_password              = password_hash('dbig021254', PASSWORD_BCRYPT);

                        $isFound        = FALSE;
                        $referral_code  = '';
                        while ($isFound == FALSE) {
                            $referral_code = strtoupper(random_string('alnum', 6));
                            $check = $this->M_customer->getCustomerByReferralCode($referral_code, TRUE)->getRowArray();
                            if ($check == NULL && !isset($listNewReffCode[$referral_code])) {
                                $isFound = TRUE;
                            }
                        }
                        $listNewReffCode[$referral_code] = 1;
                        $invite_by_referral_code        = '';

                        $customerData[] = [
                            'customer_code'                     => $customer_code,
                            'customer_name'                     => $customer_name,
                            'customer_phone'                    => $customer_phone,
                            'customer_email'                    => $customer_email,
                            'customer_password'                 => $customer_password,
                            'customer_address'                  => $customer_address,
                            'customer_address_block'            => $customer_address_block,
                            'customer_address_number'           => $customer_address_number,
                            'customer_address_rt'               => $customer_address_rt,
                            'customer_address_rw'               => $customer_address_rw,
                            'customer_point'                    => $customer_point,
                            'customer_group'                    => $customer_group,
                            'customer_gender'                   => $customer_gender,
                            'customer_birth_date'               => $customer_birth_date,
                            'customer_job'                      => $customer_job,
                            'salesman_id'                       => $salesman_id,
                            'customer_remark'                   => $customer_remark,
                            'customer_delivery_address'         => $customer_delivery_address,
                            'customer_npwp'                     => $customer_npwp,
                            'customer_nik'                      => $customer_nik,
                            'customer_tax_invoice_name'         => $customer_tax_invoice_name,
                            'customer_tax_invoice_address'      => $customer_tax_invoice_address,
                            'mapping_id'                        => $mapping_id,
                            'exp_date'                          => $exp_date,
                            'referral_code'                     => $referral_code,
                            'invite_by_referral_code'           => $invite_by_referral_code,
                            'verification_email'                => $verification_email,
                            'active'                            => 'Y'
                        ];
                    }
                }

                $result = $this->M_customer->importCustomer($customerData);

                if (file_exists($file_path)) {
                    unlink($file_path);
                };
            }
        }

        $result['title']    = 'Import Data Customer';
        $result['back_url'] = base_url('webmin/customer');
        return $this->renderView('import_result', $result);
    }
    //--------------------------------------------------------------------
}
