<?php


namespace App\Controllers\Webmin;

use Dompdf\Dompdf;
use App\Models\M_stock_opname;
use App\Controllers\Base\WebminController;

class StockOpnameV2 extends WebminController
{
    protected $M_stock_opname;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->M_stock_opname = new M_stock_opname;
    }

    public function index()
    {

        $data = [
            'title'         => 'Stok Opname'
        ];

        return $this->renderView('stock_opname/stock_opname', $data, 'stock_opname.view');
    }

    public function table()
    {
        $this->validationRequest(TRUE);
        if ($this->role->hasRole('stock_opname.view')) {
            helper('datatable');
            $table = new \App\Libraries\Datatables('hd_opname');
            $table->db->select('hd_opname.opname_id,hd_opname.opname_code,hd_opname.opname_date,ms_warehouse.warehouse_code,ms_warehouse.warehouse_name,hd_opname.opname_total,user_account.user_realname');
            $table->db->join('ms_warehouse', 'ms_warehouse.warehouse_id=hd_opname.warehouse_id');
            $table->db->join('user_account', 'user_account.user_id=hd_opname.user_id');
            $table->renderColumn(function ($row, $i) {
                $column = [];
                $column[] = $i;
                $column[] = esc($row['opname_code']);
                $column[] = indo_short_date($row['opname_date']);
                $column[] = esc($row['warehouse_code'] . ' - ' . $row['warehouse_name']);
                $column[] = numberFormat($row['opname_total'], TRUE);
                $column[] = esc($row['user_realname']);

                $btns = [];
                $prop =  'data-id="' . $row['opname_id'] . '" data-code="' . esc($row['opname_code']) . '"';
                $btns[] = '<a href="javascript:;" data-fancybox data-type="iframe" data-src="' . base_url() . '/webmin/stock-opname/detail/' . $row['opname_id'] . '" class="btn btn-sm btn-default mb-2" data-toggle="tooltip" data-placement="top" data-title="Detail"><i class="fas fa-eye"></i></a>';
                $btns[] = '<button ' . $prop . ' class="btn btn-sm btn-default mb-2 btnprint" data-toggle="tooltip" data-placement="top" data-title="Print"><i class="fas fa-print"></i></button>';

                $column[] = implode('&nbsp;', $btns);
                return $column;
            });

            $table->orderColumn  = ['hd_opname.opname_id', 'hd_opname.opname_code', 'hd_opname.opname_date', 'ms_warehouse.warehouse_code', 'hd_opname.opname_total', 'user_account.user_realname', ''];
            $table->searchColumn = ['hd_opname.opname_code'];
            $table->generate();
        }
    }

    public function detail($opname_id)
    {
        $find = $this->M_stock_opname->getOpname($opname_id)->getRowArray();
        if ($find == NULL) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        } else {
            $getDetail = $this->M_stock_opname->getDetailOpname($opname_id)->getResultArray();

            $data = [
                'header' => $find,
                'detail' => $getDetail
            ];
            return view('webmin/stock_opname/stock_opname_detail', $data);
        }
    }

    public function report($opname_id)
    {
        $find = $this->M_stock_opname->getOpname($opname_id)->getRowArray();
        if ($find == NULL) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        } else {
            $getDetail = $this->M_stock_opname->getDetailOpname($opname_id)->getResultArray();

            $agent = $this->request->getUserAgent();
            $isDownload = $this->request->getGet('download') == 'Y' ? TRUE : FALSE; // param export
            $fileType   = $this->request->getGet('file'); // jenis file pdf|xlsx 

            if (!in_array($fileType, ['pdf'])) {
                $fileType = 'pdf';
            }

            $max_item_page  = 9;
            $paging_data    = array_chunk($getDetail, $max_item_page);
            $max_page       = count($paging_data);


            $data = [
                'header'    => $find,
                'page_data' => $paging_data,
                'max_page'  => $max_page
            ];


            $htmlView   = $this->renderView('stock_opname/stock_opname_report', $data);


            if ($agent->isMobile() && !$isDownload) {
                return $htmlView;
            } else {
                if ($fileType == 'pdf') {
                    $dompdf = new Dompdf();
                    $dompdf->loadHtml($htmlView);
                    $dompdf->setPaper('A4', 'landscape');
                    $dompdf->render();
                    $dompdf->stream('report.pdf', array("Attachment" => $isDownload));
                    exit();
                }
            }
        }
    }

    public function opnameProduct()
    {
        $this->validationRequest(TRUE);
        $user_id = $this->userLogin['user_id'];
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        $validation =  \Config\Services::validation();
        $input = [
            'warehouse_id'              => $this->request->getPost('warehouse_id'),
            'product_id'                => $this->request->getPost('product_id'),
        ];

        $validation->setRules([
            'warehouse_id'              => ['rules' => 'required'],
            'product_id'                => ['rules' => 'required'],
        ]);
        $warehouse_id   = $input['warehouse_id'];
        if ($validation->run($input) === FALSE) {
            $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        } else {
            if ($this->role->hasRole('stock_opname.add')) {
                $product_id     = is_array($input['product_id']) ? $input['product_id'] : explode(',', $input['product_id']);
                $result = $this->M_stock_opname->opnameProductV2($warehouse_id, $product_id, $user_id);
            } else {
                $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menambah stok opname'];
            }
        }
        $result['data'] = $this->getTemp($warehouse_id);
        $result['csrfHash'] = csrf_hash();
        resultJSON($result);
    }

    private function getTemp($warehouse_id)
    {
        $user_id    = $this->userLogin['user_id'];
        $tempData   = [];
        $getTemp    = $this->M_stock_opname->getTemp($warehouse_id, $user_id)->getResultArray();

        foreach ($getTemp as $row) {
            $pid = 'P' . $row['product_id'];
            $product_id             = $row['product_id'];
            $product_code           = $row['product_code'];
            $product_name           = $row['product_name'];
            $temp_base_cogs         = floatval($row['temp_base_cogs']);
            $temp_warehouse_stock   = floatval($row['temp_warehouse_stock']);
            $temp_system_stock      = floatval($row['temp_system_stock']);
            $unit_name              = $row['unit_name'];

            if (isset($tempData[$pid])) {
                $tempData[$pid]['temp_warehouse_stock'] += $temp_warehouse_stock;
                $tempData[$pid]['temp_system_stock']    += $temp_system_stock;
            } else {
                $tempData[$pid] = [
                    'product_id'            => $product_id,
                    'product_code'          => $product_code,
                    'product_name'          => $product_name,
                    'temp_base_cogs'        => $temp_base_cogs,
                    'temp_warehouse_stock'  => $temp_warehouse_stock,
                    'temp_system_stock'     => $temp_system_stock,
                    'unit_name'             => $unit_name
                ];
            }
        }

        $jsonData = [];
        foreach ($tempData  as $row) {
            $jsonData[] = $row;
        }

        return $jsonData;
    }

    private function getTempOpname($product_id, $warehouse_id)
    {
        $user_id    = $this->userLogin['user_id'];
        $tempData   = [];
        $getTemp    = $this->M_stock_opname->getTempByProductId($product_id, $warehouse_id, $user_id)->getResultArray();
        foreach ($getTemp as $row) {
            $row['indo_exp_date'] = indo_short_date($row['temp_exp_date']);
            $tempData[] = $row;
        }

        return  $tempData;
    }

    public function temp($warehouse_id)
    {
        $clear          = $this->request->getGet('clear');
        $user_id        = $this->userLogin['user_id'];
        $result         = [];
        if ($clear == 'Y') {
            $this->M_stock_opname->clearTemp($user_id);
        }
        $result['success'] = TRUE;
        $result['data'] = $this->getTemp($warehouse_id);
        resultJSON($result);
    }

    public function tempOpname($warehouse_id, $product_id)
    {

        $user_id        = $this->userLogin['user_id'];
        $result         = [];
        $result['success'] = TRUE;
        $result['data'] = $this->getTempOpname($product_id, $warehouse_id);
        resultJSON($result);
    }

    public function tempUpdate($warehouse_id)
    {
        $this->validationRequest(TRUE);
        $user_id        = $this->userLogin['user_id'];

        $result         = ['success' => FALSE, 'message' => 'Input tidak valid'];
        $validation     =  \Config\Services::validation();
        $input = [
            'product_key'               => $this->request->getPost('product_key'),
            'product_id'                => $this->request->getPost('product_id'),
            'warehouse_id'              => $warehouse_id,
            'temp_warehouse_stock'      => $this->request->getPost('temp_warehouse_stock'),
            'temp_system_stock'         => $this->request->getPost('temp_system_stock'),
            'temp_base_cogs'            => $this->request->getPost('temp_base_cogs'),
            'temp_stock_difference'     => $this->request->getPost('temp_stock_difference'),
            'temp_exp_date'             => $this->request->getPost('temp_exp_date'),
            'temp_detail_remark'        => $this->request->getPost('temp_detail_remark'),
            'user_id'                   => $user_id
        ];

        $validation->setRules([
            'product_id'               => ['rules' => 'required'],
            'temp_warehouse_stock'     => ['rules' => 'required'],
            'temp_system_stock'        => ['rules' => 'required'],
            'temp_base_cogs'           => ['rules' => 'required'],
            'temp_stock_difference'    => ['rules' => 'required'],
        ]);

        if ($validation->run($input) === FALSE) {
            $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        } else {
            $save = $this->M_stock_opname->updateTemp($input);
            if ($save) {
                $result = ['success' => TRUE, 'message' => 'Data item berhasil ditambahkan'];
            } else {
                $result = ['success' => FALSE, 'message' => 'Data item gagal ditambahkan'];
            }
        }

        $result['data'] = $this->getTempOpname($input['product_id'], $warehouse_id);
        resultJSON($result);
    }

    public function tempDelete($warehouse_id = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        $product_id     = $this->request->getGet('product_id');
        $product_key    = $this->request->getGet('product_key');
        $user_id        = $this->userLogin['user_id'];

        if ($warehouse_id == '' || ($product_id == NULL && $product_key == NULL)) {
            $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        } else {
            $delete = 0;
            if ($product_key == NULL) {
                $delete  = $this->M_stock_opname->deleteTemp($product_id, $warehouse_id, $user_id, TRUE);
            } else {
                $delete  = $this->M_stock_opname->deleteTemp($product_key, $warehouse_id, $user_id, FALSE);
            }

            if ($delete) {
                $result = ['success' => TRUE, 'message' => 'Data item berhasil dihapus'];
            } else {
                $result = ['success' => FALSE, 'message' => 'Data item gagal dihapus'];
            }
        }
        if ($product_key == NULL) {
            $result['data'] = $this->getTemp($warehouse_id);
        } else {
            $result['data'] = $this->getTempOpname($product_id, $warehouse_id);
        }
        resultJSON($result);
    }

    public function api_post_accounting_opname($opname_id)
    {
        $getOpname = $this->M_stock_opname->getOpname($opname_id)->getRowArray();

        if ($getOpname != null) {
            // setup connection //
            $db                 = \Config\Database::connect('accounting');
            $M_warehouse        = model('M_warehouse');
            $M_journal          = model('Accounting/M_journal');


            $getWarehouse       = $M_warehouse->getWarehouse($getOpname['warehouse_id'])->getRowArray();
            $store_id           = $getWarehouse['store_id'];
            $store_code         = $getWarehouse['store_code'];
            $journal_date       = $getOpname['opname_date'];
            $journal_period     = substr($journal_date, 5, 2) . substr($journal_date, 0, 4);
            $journal_remark     = 'Opname ' . $getOpname['opname_code'];
            $api_post_user_id   = intval($store_id) == 1 ? 2 : 3;

            $listApiAccount = [];
            $getApiAccount = $db->table('ms_account_api')->get()->getResultArray();
            foreach ($getApiAccount as $cfg) {
                $acc_name =  $cfg['account_api_name'];
                $listApiAccount[$acc_name] = $cfg;
            }

            $hpp_account_id         = isset($listApiAccount['penjualan_hpp']) ? $listApiAccount['penjualan_hpp']['account_id'] : '0';
            $hpp_account_name       = isset($listApiAccount['penjualan_hpp']) ? $listApiAccount['penjualan_hpp']['account_name'] : 'NO NAME';

            $pbd_account_id         = isset($listApiAccount['purchase_persediaan']) ? $listApiAccount['purchase_persediaan']['account_id'] : '0';
            $pbd_account_name       = isset($listApiAccount['purchase_persediaan']) ? $listApiAccount['purchase_persediaan']['account_name'] : 'NO NAME';

            $opname_total           = floatval($getOpname['opname_total']);
            if ($opname_total < 0 || $opname_total > 0) {
                $total_journal  = 0;
                $dtJournal      = [];

                if ($opname_total < 0) {
                    $total_journal  = $opname_total * -1;
                    $dtJournal = [
                        [
                            'account_id'            => $hpp_account_id,
                            'debit_balance'         => $total_journal,
                            'credit_balance'        => 0
                        ],
                        [
                            'account_id'            => $pbd_account_id,
                            'debit_balance'         => 0,
                            'credit_balance'        => $total_journal
                        ]
                    ];
                } else if ($opname_total > 0) {
                    $total_journal = $opname_total;
                    $dtJournal = [
                        [
                            'account_id'            => $pbd_account_id,
                            'debit_balance'         => $total_journal,
                            'credit_balance'        => 0
                        ],
                        [
                            'account_id'            => $hpp_account_id,
                            'debit_balance'         => 0,
                            'credit_balance'        => $total_journal
                        ]
                    ];
                }

                $hdJournal = [
                    'store_code'                => $store_code,
                    'store_id'                  => $store_id,
                    'journal_period'            => $journal_period,
                    'journal_date'              => $journal_date,
                    'journal_remark'            => $journal_remark,
                    'journal_debit_balance'     => $total_journal,
                    'journal_credit_balance'    => $total_journal,
                    'can_edit'                  => 'Y',
                    'user_id'                   => $api_post_user_id,
                ];
                return $M_journal->insertJournal($hdJournal, $dtJournal);
            }
            return true;
        } else {
            return false;
        }
    }

    public function save()
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        $validation =  \Config\Services::validation();
        $input = [
            'opname_date'               => $this->request->getPost('opname_date'),
            'warehouse_id'              => $this->request->getPost('warehouse_id'),
            'opname_total'              => $this->request->getPost('opname_total'),
            'user_id'                   => $this->userLogin['user_id'],
            'store_code'                => $this->userLogin['store_code'],
            'store_id'                  => $this->userLogin['store_id'],
        ];

        $validation->setRules([
            'opname_date'            => ['rules' => 'required'],
            'warehouse_id'           => ['rules' => 'required'],
            'opname_total'           => ['rules' => 'required'],
        ]);

        if ($validation->run($input) === FALSE) {
            $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        } else {
            if ($this->role->hasRole('stock_opname.add')) {
                $opname_id = $this->M_stock_opname->insertOpnameV2($input, true);
                if ($opname_id > 0) {
                    $this->api_post_accounting_opname($opname_id);
                    $result = ['success' => TRUE, 'message' => 'Data stok opname berhasil disimpan'];
                } else {
                    $result = ['success' => FALSE, 'message' => 'Data stok opname gagal disimpan'];
                }
            } else {
                $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menambah stok opname'];
            }
        }


        $result['csrfHash'] = csrf_hash();
        resultJSON($result);
    }



    //--------------------------------------------------------------------

}
