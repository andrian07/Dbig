<?php


namespace App\Controllers\Webmin;

use App\Models\M_submission;
use App\Controllers\Base\WebminController;


class Submission extends WebminController
{
    protected $M_submission;


    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->M_submission = new M_submission;
    }

    public function index()
    {
        $data = [
            'title'         => 'Pengajuan' 
        ];
        return $this->renderView('purchase/submission', $data);
    }

    public function submissiondetaildemo()
    {

        $data = [
            'title'         => 'Pengajuan' 
        ];
        return $this->renderView('purchase/submissiondemo', $data);
    }

    //--------------------------------------------------------------------


    public function tblhdsubmission()
    {

        $this->validationRequest(TRUE);
        if ($this->role->hasRole('submission.view')) {
            helper('datatable');

            $table = new \App\Libraries\Datatables('hd_submission');
            $table->db->select('submission_id, submission_inv, submission_date, user_realname, submission_desc, submission_status');
            $table->db->join('user_account', 'user_account.user_id = hd_submission.submission_user_id');
            $table->renderColumn(function ($row, $i) {
                $column = [];
                $column[] = $i;
                $column[] = esc($row['submission_date']);
                $column[] = esc($row['user_realname']);
                $column[] = esc($row['submission_desc']);
                $column[] = esc($row['submission_status']);

                $btns = [];
                $prop =  'data-id="' . $row['submission_id'] . '" data-name="' . esc($row['submission_inv']) . '"';
                $btns[] = '<a href="javascript:;" data-fancybox data-type="iframe" data-src="'.base_url().'/webmin/submission/get-submission-detail/'.$row['submission_id'].'" class="margins btn btn-sm btn-default mb-2" data-toggle="tooltip" data-placement="top" data-title="Detail"><i class="fas fa-eye"></i></a>';
                $btns[] = button_edit($prop);
                $btns[] = button_delete($prop);
                $column[] = implode('&nbsp;', $btns);
                return $column;
            });

            $table->orderColumn  = ['', 'submission_inv', 'submission_date','','submission_status',''];
            $table->searchColumn = ['submission_inv', 'submission_date','submission_status'];
            $table->generate();
        }
    }


    public function getSubmissionTemp()
    {

        //$this->validationRequest(TRUE, 'GET');

        $getTemp = $this->M_submission->getTemp($this->userLogin['user_id'])->getResultArray();

        $find_result = [];

        foreach ($getTemp as $k => $v) {

            $find_result[$k] = esc($v);

        }

        $result['data'] = $find_result;

        $result['csrfHash'] = csrf_hash();

        $result['success'] = 'TRUE';

        resultJSON($result);

    }


    public function search_product()

    {

        $this->validationRequest(TRUE, 'GET');

        $keyword = $this->request->getGet('term');

        $result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => ''];

        if (!($keyword == '' || $keyword == NULL)) {

            $M_product = model('M_product');

            $find = $M_product->searchProductUnitByName($keyword)->getResultArray();

            $find_result = [];

            foreach ($find as $row) {

                $diplay_text = $row['product_name'];

                $find_result[] = [

                    'id'                => $diplay_text,

                    'value'             => $diplay_text,

                    'item_id'           => $row['item_id'],

                    'product_id'        => $row['product_id']

                ];

            }

            $result = ['success' => TRUE, 'num_product' => count($find_result), 'data' => $find_result, 'message' => ''];

        }

        resultJSON($result);

    }

   


    public function tempadd(){

        $this->validationRequest(TRUE, 'POST');

        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];

        $validation =  \Config\Services::validation();

        $input = [
            'temp_submission_id'           => $this->request->getPost('temp_id'),
            'temp_submission_product_id'   => $this->request->getPost('item_id'),
            'temp_submission_order_qty'    => $this->request->getPost('temp_qty'),
            'temp_submission_status'       => $this->request->getPost('temp_status'),
            'temp_submission_desc'         => $this->request->getPost('temp_desc'),
            'temp_submission_product_name' => $this->request->getPost('product_name')
        ];

        $validation->setRules([
            'temp_submission_order_qty'    => ['rules' => 'required|greater_than[0]'],
            'temp_submission_status'       => ['rules' => 'required'],
            'temp_submission_product_name' => ['rules' => 'required']
        ]);


        if ($validation->run($input) === FALSE) {

            $result = ['success' => FALSE, 'message' => 'Input tidak valid'];

        } else {

            $input['temp_submission_user_id'] = $this->userLogin['user_id'];
            if($input['temp_submission_id'] == ''){
                $save = $this->M_submission->insertTemp($input);
            }else{
                $save = $this->M_submission->editTemp($input);
            }

            if ($save) {

                $result = ['success' => TRUE, 'message' => 'Data item berhasil ditambahkan'];

            } else {

                $result = ['success' => FALSE, 'message' => 'Data item gagal ditambahkan'];

            }

        }



        $getTemp = $this->M_submission->getTemp($this->userLogin['user_id'])->getResultArray();

        $find_result = [];

        foreach ($getTemp as $k => $v) {

            $find_result[$k] = esc($v);

        }



        $result['data'] = $find_result;

        $result['csrfHash'] = csrf_hash();

        resultJSON($result);
    }


    public function deleteTemp($temp_submission_id = '')
    {
        //$this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        if ($this->role->hasRole('submission.delete')) {
            if ($temp_submission_id != '') {
                $delete = $this->M_submission->deletetemp($temp_submission_id);
                if ($delete) {
                   $getTemp = $this->M_submission->getTemp($this->userLogin['user_id'])->getResultArray();
                   $find_result = [];
                   foreach ($getTemp as $k => $v) {
                   $find_result[$k] = esc($v);
                }
                $result['data'] = $find_result;
                $result['csrfHash'] = csrf_hash();
                $result['success'] = 'TRUE';
                $result['message'] = 'Data Berhasil Di Hapus';
            } else {
                $result = ['success' => FALSE, 'message' => 'Data Gagal Di Hapus'];
            }
        }
        } else {
            $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menghapus data ini'];
        }
    resultJSON($result);
    }


    public function save($type)
    {

        $this->validationRequest(TRUE, 'POST');

        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];

        $validation =  \Config\Services::validation();

        $input = [

            'submission_date'            => $this->request->getPost('submission_order_date'),
            'submission_desc'            => $this->request->getPost('submission_desc'),

        ];

        $validation->setRules([

            'submission_date'            => ['rules' => 'required'],
            'submission_desc'            => ['rules' => 'max_length[500]'],

        ]);

        if ($validation->run($input) === FALSE) {

            $result = ['success' => FALSE, 'message' => 'Input tidak valid'];

        } else {

            if ($type == 'add') {

                if ($this->role->hasRole('submission.add')) {

                    unset($input['purchase_order_id']);

                    $input['submission_user_id']= $this->userLogin['user_id'];

                    $input['submission_status'] = 'Pending';

                    $save = $this->M_submission->insertSubmission($input);

                    if ($save['success']) {

                        $result = ['success' => TRUE, 'message' => 'Data pengajuan berhasil disimpan', 'purchase_order_id' => $save['submission_id']];

                    } else {

                        $result = ['success' => FALSE, 'message' => 'Data pengajuan gagal disimpan'];

                    }

                } else {

                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menambah pengajuan'];

                }

            } else if ($type == 'edit') {

                if ($this->role->hasRole('purchase_order.edit')) {

                    $input['user_id']       = $this->userLogin['user_id'];

                    $save = $this->M_purchase_order->updateOrder($input);

                    if ($save['success']) {

                        $result = ['success' => TRUE, 'message' => 'Data pesanan berhasil diperbarui', 'purchase_order_id' => $save['purchase_order_id']];

                    } else {

                        $result = ['success' => FALSE, 'message' => 'Data pesanan gagal diperbarui'];

                    }

                } else {

                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk mengubah pesanan pembelian'];

                }

            }

        }

        $result['csrfHash'] = csrf_hash();

        resultJSON($result);

    }


    public function editSubmission($submission_id = '')
    {

        $this->validationRequest(TRUE, 'GET');

        $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk mengubah pengajuan pembelian'];

        if ($this->role->hasRole('submission.edit')) {

            $getSubmission = $this->M_submission->getSubmission($submission_id)->getRowArray();

            if ($getSubmission == NULL) {

                $result = ['success' => FALSE, 'message' => 'Pengajuan dengan No invoice <b>' . $submission_inv . '</b> tidak ditemukan'];

            } else {

                $user_id = $this->userLogin['user_id'];

                $getTemp = $this->M_purchase_order->copyDtOrderToTemp($submission_id, $user_id)->getResultArray();

                $find_result = [];

                foreach ($getTemp as $k => $v) {

                    $find_result[$k] = esc($v);

                }

                $result = ['success' => TRUE, 'header' => $getSubmission, 'data' => $find_result, 'message' => ''];

            }

        }

        resultJSON($result);

    }

    public function getSubmissionDetail($submission_id = '')
    {
        if ($submission_id == '') {

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        } else {

            $getOrder =  $this->M_submission->getSubmission($submission_id)->getRowArray();

            if ($getOrder == NULL) {

                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

            } else {

                $invoice_num= $getOrder['submission_inv'];

                $data = [

                    'hdsubmission' => $getOrder,

                    'dtsubmission' => $this->M_submission->getDtSubmission($invoice_num)->getResultArray(),

                    //'logupdate' => $this->M_purchase_order->getLogEditOrder($purchase_order_id)->getResultArray()

                ];

                return view('webmin/purchase/submission_detail', $data);

            }

        }

    }

}
