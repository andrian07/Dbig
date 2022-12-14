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

    //--------------------------------------------------------------------


    public function tblhdsubmission()
    {

        $this->validationRequest(TRUE);
        if ($this->role->hasRole('submission.view')) {
            helper('datatable');

            $table = new \App\Libraries\Datatables('hd_submission');
            $table->db->select('submission_id, submission_inv, submission_date, user_realname, submission_desc, submission_status, submission_admin_remark ,hd_submission.created_at,submission_product_name');
            $table->db->join('user_account', 'user_account.user_id = hd_submission.submission_user_id');
            $table->db->orderBy('hd_submission.created_at', 'desc');
            $table->renderColumn(function ($row, $i) {
                $column = [];
                $column[] = $i;
                $column[] = esc($row['submission_inv']);
                $column[] = indo_short_date($row['submission_date'], FALSE);
                $column[] = esc($row['user_realname']);
                $column[] = esc($row['submission_product_name']);
                $column[] = esc($row['submission_desc']);
                if($row['submission_status'] == 'Pending'){
                $column[] = '<span class="badge badge-primary">Pending</span>';
                }else if($row['submission_status'] == 'Accept'){
                $column[] = '<span class="badge badge-success">Diterima</span>';
                }else if($row['submission_status'] == 'Decline'){
                $column[] = '<span class="badge badge-danger">Ditolak</span>'; 
                }else{
                $column[] = '<span class="badge badge-danger">Dibatalkan</span>';  
                }
                $column[] = esc($row['submission_admin_remark']);
                $btns = [];
                $prop =  'data-id="'.$row['submission_id'].'" data-name="'.esc($row['submission_inv']).'"';
                $btns[] = button_edit($prop);
                $btns[] = button_delete($prop);
                $btns[] = '<a href="javascript:;" data-fancybox data-type="iframe" data-src="'.base_url().'/webmin/submission/get-submission-detail/'.$row['submission_id'].'" class="margins btn btn-sm btn-default mb-2" data-toggle="tooltip" data-placement="top" data-title="Detail"><i class="fas fa-eye"></i></a>';
                $btns[] = '<button data-id="'.$row['submission_id'] .'" data-name="'. esc($row['submission_inv']) .'" class="margins btn btn-sm btn-default mb-2 btndecline" data-toggle="tooltip" data-placement="top" data-title="Approve" data-original-title="" title=""><i class="fas fa-ban"></i></button>';
                
                $column[] = implode('&nbsp;', $btns);
                return $column;
            });

            $table->orderColumn  = ['', 'submission_inv', 'submission_date','','submission_status','submission_status',''];
            $table->searchColumn = ['submission_inv', 'submission_date','submission_status','submission_status'];
            $table->generate();
        }
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

   
    public function searchProductSubmission()
    {

        $this->validationRequest(TRUE, 'GET');

        $supplier = $this->request->getGet('sup');

        $keyword = $this->request->getGet('term');

        if($supplier == 'null'){

            $result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => 'Silahkan Isi Nama Supplier Terlebih Dahulu'];

        }else{

            $result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => ''];

            if (!($keyword == '' || $keyword == NULL)) {

                $M_product = model('M_product');

                $find = $M_product->searchProductUnitByName($keyword)->getResultArray();

                $find_result = [];

                foreach ($find as $row) {

                    $diplay_text = $row['product_name'];

                    $find_result[] = [

                        'id'                  => $diplay_text,

                        'value'               => $diplay_text.'('.$row['unit_name'].')',

                        'item_id'             => $row['item_id'],
                        
                        'item_code'           => $row['item_code']

                    ];

                }

                $result = ['success' => TRUE, 'num_product' => count($find_result), 'data' => $find_result, 'message' => ''];

            }
        }

        resultJSON($result);
    }



    public function save($type)
    {


        $this->validationRequest(TRUE, 'POST');

        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];

        $validation =  \Config\Services::validation();

        $input = [

            'submission_id'              => $this->request->getPost('submission_id'),
            'submission_warehouse_id'    => $this->request->getPost('submission_warehouse_id'),
            'submission_item_id'         => $this->request->getPost('item_id'),
            'submission_product_name'    => $this->request->getPost('product_name'),
            'submission_qty'             => $this->request->getPost('qty'),
            'submission_item_status'     => $this->request->getPost('temp_status'), 
            'submission_date'            => $this->request->getPost('submission_order_date'),
            'submission_salesman_id'     => $this->request->getPost('salesman_id'),
            'submission_desc'            => $this->request->getPost('desc')
        ];

        $validation->setRules([

            'submission_warehouse_id'        => ['rules' => 'required'],
            'submission_desc'                => ['rules' => 'max_length[500]'],
            'submission_item_id'             => ['rules' => 'required'],
        ]);

        if ($validation->run($input) === FALSE) {

            $result = ['success' => FALSE, 'message' => 'Input tidak valid'];

        } else {

            if ($type == 'add') {

                if ($this->role->hasRole('submission.add')) {

                    unset($input['submission_id']);

                    $input['submission_user_id']= $this->userLogin['user_id'];

                    $input['submission_status'] = 'Pending';

                    $save = $this->M_submission->insertSubmission($input);

                    if ($save['success']) {

                        $result = ['success' => TRUE, 'message' => 'Data pengajuan berhasil disimpan', 'submission_id' => $save['submission_id']];

                    } else {

                        $result = ['success' => FALSE, 'message' => 'Data pengajuan gagal disimpan'];

                    }

                } else {

                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menambah pengajuan'];

                }

            } else if ($type == 'edit') {

                if ($this->role->hasRole('submission.edit')) {

                    $input['submission_user_id'] = $this->userLogin['user_id'];

                    $save = $this->M_submission->updateOrder($input);

                    if ($save['success']) {

                        $result = ['success' => TRUE, 'message' => 'Data Pengajuan berhasil diperbarui', 'submission_id' => $save['submission_id']];

                    } else {

                        $result = ['success' => FALSE, 'message' => 'Data Pengajuan gagal diperbarui'];

                    }

                } else {

                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk mengubah Data Pengajuan'];

                }

            }

        }


        $result['csrfHash'] = csrf_hash();
        resultJSON($result);

    }

    public function cancelOrder($submission_id = '')
    {

        $this->validationRequest(TRUE, 'GET');

        $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk Membatalkan pegajuan pesanan'];

        if ($this->role->hasRole('submission.delete')) {

            $getSubmissiondetail = $this->M_submission->getSubmissiondetaildata($submission_id)->getRowArray();

            $submission_inv = $getSubmissiondetail['submission_inv'];

            if ($getSubmissiondetail == NULL) {

                $result = ['success' => FALSE, 'message' => 'Transaksi dengan No invoice <b>' . $submission_inv . '</b> tidak ditemukan'];

            } else if($getSubmissiondetail['submission_status'] != 'Pending'){

                $result = ['success' => FALSE, 'message' => 'Transaksi Yang Sudah Di Proses Tidak Dapat Di Batalkan'];

            }else{

                $user_id = $this->userLogin['user_id'];

                $cancelOrder = $this->M_submission->cancelOrder($submission_inv, $submission_id);

                $result = ['success' => TRUE, 'message' => 'Pengajuan Berhasil Di Batalkan'];

            }

        }

        $result['csrfHash'] = csrf_hash();
        resultJSON($result);
    }


    public function declineOrder()
    {

        $this->validationRequest(TRUE, 'POST');

        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];

        $validation =  \Config\Services::validation();

        $input = [

            'submission_id_decline'      => $this->request->getPost('submission_id_decline'),
            'submission_admin_remark'    => $this->request->getPost('desc_decline')
        ];

        if ($this->role->hasRole('submission.decline')) {

            $getSubmissiondetail = $this->M_submission->getSubmissiondetaildata($input['submission_id_decline'])->getRowArray();

            $submission_inv = $getSubmissiondetail['submission_inv'];

            if ($getSubmissiondetail == NULL) {

                $result = ['success' => FALSE, 'message' => 'Transaksi dengan No invoice <b>' . $submission_inv . '</b> tidak ditemukan'];

            } else {

                $input['user_id'] = $this->userLogin['user_id'];

                $declineOrder = $this->M_submission->declineOrder($input);

                $result = ['success' => TRUE, 'message' => 'Pengajuan Berhasil Di Tolak'];

            }
        }

        $result['csrfHash'] = csrf_hash();
        resultJSON($result);
    }


    public function getSubmissionDetail($submission_id = '')
    {
        if ($submission_id == '') {

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        } else {

            $getOrder =  $this->M_submission->getSubmissiondetaildata($submission_id)->getRowArray();

            if ($getOrder == NULL) {

                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

            } else {

                $data = [

                    'hdsubmission' => $getOrder,

                    'logupdate' => $this->M_submission->getLogEditOrder($submission_id)->getResultArray()

                ];

                return view('webmin/purchase/submission_detail', $data);

            }

        }

    }


    public function getById($submission_id = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Data Pengajuan tidak ditemukan'];
        if ($this->role->hasRole('submission.view')) {
            if ($submission_id != '') {
                $find = $this->M_submission->getSubmissiondetaildata($submission_id)->getRowArray();
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


}
