<?php


namespace App\Controllers\Webmin;

use App\Models\M_sales_pos;
use App\Controllers\Base\WebminController;

class SalesPos extends WebminController
{
    protected $M_sales_pos;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->M_sales_pos = new M_sales_pos;
    }

    public function index()
    {
        $data = [
            'title'             => 'Penjualan POS',
        ];
        return $this->renderView('sales_pos/sales_pos', $data, 'sales_pos.view');
    }


    public function table()
    {
        $this->validationRequest(TRUE);
        if ($this->role->hasRole('sales_pos.view')) {
            helper('datatable');
            $table = new \App\Libraries\Datatables('hd_pos_sales');
            $table->db->select('hd_pos_sales.*,ms_store.store_name,ms_customer.customer_name');
            $table->db->join('ms_store', 'ms_store.store_id=hd_pos_sales.store_id');
            $table->db->join('ms_customer', 'ms_customer.customer_id=hd_pos_sales.customer_id');


            $table->renderColumn(function ($row, $i) {
                $column = [];
                $column[] = $i;
                $column[] = esc($row['pos_sales_invoice']);
                $column[] = indo_short_date($row['pos_sales_date']);
                $column[] = esc($row['store_name']);
                $column[] = esc($row['customer_name']);
                $column[] = esc($row['pos_sales_type']);
                $column[] = numberFormat($row['pos_sales_total'], true);
                $btns = [];
                $prop =  'data-id="' . $row['pos_sales_id'] . '"';
                $btns[] = button_print($prop);
                $btns[] = button_edit($prop);

                $column[] = implode('&nbsp;', $btns);

                return $column;
            });

            $table->orderColumn  = ['hd_pos_sales.pos_sales_id', 'hd_pos_sales.pos_sales_invoice', 'hd_pos_sales.pos_sales_date', 'ms_store.store_name', 'ms_customer.customer_name', 'hd_pos_sales.pos_sales_type', 'hd_pos_sales.pos_sales_total', ''];
            $table->searchColumn = ['hd_pos_sales.pos_sales_invoice', 'ms_customer.customer_name'];
            $table->generate();
        }
    }

    public function tableDetailSales()
    {
        $this->validationRequest(TRUE);
        if ($this->role->hasRole('sales_pos.view')) {
            helper('datatable');
            $pos_sales_id = $this->request->getPost('pos_sales_id') == NULL ? 0 : $this->request->getPost('pos_sales_id');

            $table = new \App\Libraries\Datatables('dt_pos_sales');
            $table->db->select('dt_pos_sales.*,ms_product_unit.item_code,ms_product.product_name,ms_salesman.salesman_code,ms_salesman.salesman_name,ms_unit.unit_name');
            $table->db->join('ms_product_unit', 'ms_product_unit.item_id=dt_pos_sales.item_id');
            $table->db->join('ms_product', 'ms_product.product_id=ms_product_unit.product_id');
            $table->db->join('ms_unit', 'ms_unit.unit_id=ms_product_unit.unit_id');
            $table->db->join('ms_salesman', 'ms_salesman.salesman_id=dt_pos_sales.salesman_id', 'left');
            $table->db->where('dt_pos_sales.pos_sales_id', $pos_sales_id);



            $table->renderColumn(function ($row, $i) {
                $column = [];
                $column[] = $i;
                $column[] = esc($row['item_code']) . '<br>' . esc($row['product_name']) . ' (' . esc($row['unit_name']) . ')';

                $subtotal       = floatval($row['sales_price']) * floatval($row['sales_qty']);
                $salesman_text  = '&nbsp;';
                if (intval($row['salesman_id']) > 0) {
                    $salesman_text = $row['salesman_code'] . ' - ' . $row['salesman_name'];
                }

                $column[] = numberFormat($row['product_price'], true);
                $column[] = numberFormat($row['price_disc'], true);
                $column[] = numberFormat($row['sales_qty'], true);
                $column[] = numberFormat($subtotal, true);
                $column[] = $salesman_text;

                $prop =  'data-id="' . $row['detail_id'] . '"';
                $column[] = button_edit($prop);

                return $column;
            });

            $table->orderColumn  = ['dt_pos_sales.detail_id', 'ms_product.product_name', '', '', '', '', 'ms_salesman.salesman_code', ''];
            $table->searchColumn = ['ms_product_unit.item_code', 'ms_product.product_name'];
            $table->generate();
        }
    }

    public function getById($pos_sales_id = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Data transaksi tidak ditemukan'];
        if ($this->role->hasRole('sales_pos.view')) {
            if ($pos_sales_id != '') {
                $find = $this->M_sales_pos->getSales($pos_sales_id)->getRowArray();
                if ($find == NULL) {
                    $result = ['success' => TRUE, 'exist' => FALSE, 'message' => 'Data transaksi tidak ditemukan'];
                } else {
                    $find_result = [];
                    foreach ($find as $k => $v) {
                        $find_result[$k] = esc($v);
                    }

                    $result = [
                        'success' => TRUE,
                        'exist' => TRUE,
                        'data' => $find_result,
                        'message' => ''
                    ];
                }
            }
        }

        resultJSON($result);
    }

    public function getDetailById($detail_id = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Data transaksi tidak ditemukan'];
        if ($this->role->hasRole('sales_pos.view')) {
            if ($detail_id != '') {
                $find = $this->M_sales_pos->getDetailSales('', $detail_id)->getRowArray();
                if ($find == NULL) {
                    $result = ['success' => TRUE, 'exist' => FALSE, 'message' => 'Data transaksi tidak ditemukan'];
                } else {
                    $find_result = [];
                    foreach ($find as $k => $v) {
                        $find_result[$k] = esc($v);
                    }

                    $result = [
                        'success' => TRUE,
                        'exist' => TRUE,
                        'data' => $find_result,
                        'message' => ''
                    ];
                }
            }
        }

        resultJSON($result);
    }

    public function changeSalesman($detail_id = '', $salesman_id = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        if ($detail_id == '' || $salesman_id == '') {
            $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        } else {
            if ($this->role->hasRole('sales_pos.edit')) {
                $update = $this->M_sales_pos->changeSalesman($detail_id, $salesman_id);
                if ($update) {
                    $result = ['success' => TRUE, 'message' => 'Data salesman berhasil diubah'];
                } else {
                    $result = ['success' => TRUE, 'message' => 'Data salesman gagal diubah'];
                }
            } else {
                $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk mengubah data penjualan'];
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
            'reward_id'             => $this->request->getPost('reward_id'),
            'reward_code'           => $this->request->getPost('reward_code'),
            'reward_name'           => $this->request->getPost('reward_name'),
            'reward_point'          => $this->request->getPost('reward_point'),
            'reward_description'    => $this->request->getPost('reward_description'),
            'reward_stock'          => $this->request->getPost('reward_stock'),
            'start_date'            => $this->request->getPost('start_date'),
            'end_date'              => $this->request->getPost('end_date'),
            'active'                => $this->request->getPost('active'),
            'upload_image'          => $this->request->getFile('upload_image')
        ];

        $old_reward_image  = $this->request->getPost('old_reward_image');
        $isUploadFile       = FALSE;

        $validation->setRules([
            'reward_id'            => ['rules' => 'required'],
            'reward_code'          => ['rules' => 'required|max_length[8]'],
            'reward_name'          => ['rules' => 'required|max_length[200]'],
            'reward_point'         => ['rules' => 'required'],
            'reward_stock'         => ['rules' => 'required'],
            'start_date'           => ['rules' => 'required'],
            'end_date'             => ['rules' => 'required'],
            'end_date'             => ['rules' => 'required'],
            'active'               => ['rules' => 'required|in_list[Y,N]'],
        ]);

        if ($input['upload_image'] != NULL) {
            $maxUploadSize = $this->maxUploadSize['kb'];
            $ext = implode(',', $this->myConfig->uploadFileType['image']);
            $validation->setRules([
                'upload_image' => ['rules' => 'max_size[upload_image,' . $maxUploadSize . ']|ext_in[upload_image,' . $ext . ']|is_image[upload_image]'],
            ]);
        }

        if ($validation->run($input) === FALSE) {
            $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        } else {
            if ($input['upload_image'] != NULL) {
                helper(['upload', 'text']);
                $renameTo       = random_string('alnum', 10)  . date('dmyHis');;
                $uploadImage    = upload_image('upload_image', $renameTo, 'reward_point');
                if ($uploadImage != '') {
                    $isUploadFile  = TRUE;
                    $input['reward_image'] = $uploadImage;
                }
            }
            unset($input['upload_image']);

            if ($type == 'add') {
                if ($this->role->hasRole('point_reward.add')) {
                    unset($input['reward_id']);
                    $save = $this->M_point_reward->insertReward($input);
                    if ($save) {
                        if ($isUploadFile) {
                            deleteImage($old_reward_image, 'reward_point');
                        }
                        $result = ['success' => TRUE, 'message' => 'Data hadiah berhasil disimpan'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data hadiah gagal disimpan'];
                    }
                } else {
                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menambah hadiah'];
                }
            } else if ($type == 'edit') {
                if ($this->role->hasRole('point_reward.edit')) {
                    $save = $this->M_point_reward->updateReward($input);
                    if ($save) {
                        if ($isUploadFile) {
                            deleteImage($old_reward_image, 'reward_point');
                        }
                        $result = ['success' => TRUE, 'message' => 'Data hadiah berhasil diperbarui'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data hadiah gagal diperbarui'];
                    }
                } else {
                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk mengubah hadiah'];
                }
            }
        }


        $result['csrfHash'] = csrf_hash();
        resultJSON($result);
    }

    public function printDispatch($pos_sales_id = '')
    {
        if ($pos_sales_id  == '') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        } else {
            $find = $this->M_sales_pos->getSales($pos_sales_id)->getRowArray();
            if ($find == NULL) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            } else {

                $detail     = $this->M_sales_pos->getDetailSales($pos_sales_id)->getResultArray();
                $max_item   = 6;
                $pages      = array_chunk($detail, $max_item);

                $data = [
                    'title'     => 'Surat Jalan',
                    'header'    => $find,
                    'pages'     => $pages,
                    'agent'     => $this->request->getUserAgent()
                ];

                return view('webmin/sales_pos/dispatch_invoice', $data);
            }
        }
    }
    //--------------------------------------------------------------------

}
