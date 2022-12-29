<?php

namespace App\Controllers\Webmin\Payment;

use Dompdf\Dompdf;
use Config\App as AppConfig;
use App\Models\M_receivable_repayment;
use App\Controllers\Base\WebminController;


class Receivable_repayment extends WebminController
{

    protected $M_receivable_repayment;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->M_receivable_repayment = new M_receivable_repayment;
    }

    public function index()
    {
        $data = [
            'title'         => 'Pelunasan Piutang'
        ];
        return $this->renderView('payment/receivable_repayment', $data);
    }

    public function tbl_receivable_repayment()
    {
        $this->validationRequest(TRUE);
        if ($this->role->hasRole('receivable_repayment.view')) {
            helper('datatable');

            $table = new \App\Libraries\Datatables('hd_sales_admin');
            $table->db->select('sales_customer_id, customer_name, customer_code, customer_address, customer_phone, count(*) as total_invoice, sum(sales_admin_remaining_payment) as total_remaining_receivable');
            $table->db->join('ms_customer', 'ms_customer.customer_id = hd_sales_admin.sales_customer_id');
            $table->db->where('sales_admin_remaining_payment >', '0');
            $table->db->groupBy('sales_customer_id');
            $table->renderColumn(function ($row, $i) {
                $column = [];
                $column[] = $i;
                $column[] = esc($row['customer_code']);
                $column[] = esc($row['customer_name']);
                $column[] = esc($row['customer_address']);
                $column[] = esc($row['customer_phone']);
                $column[] = esc($row['total_invoice']);
                $column[] = 'Rp. '.esc(number_format($row['total_remaining_receivable']));
                $btns = [];
                $btns[] = '<button data-customerid="' . $row['sales_customer_id'] . '" data-customercode="' . $row['customer_code'] . '" data-customername="' . $row['customer_name'] . '" data-totalremainingdebt="' . $row['total_remaining_receivable'] . '" class="btn btn-sm btn-success btnrepayment" data-toggle="tooltip" data-placement="top" data-title="Pelunasan" data-original-title="" title=""><i class="fas fa-money-bill-wave"></i></button>';
                $column[] = implode('&nbsp;', $btns);
                return $column;
            });

            $table->orderColumn  = ['customer_code', 'customer_name'];
            $table->searchColumn = ['customer_code', 'customer_name'];
            $table->generate();
        }
    }

    public function tbl_receivablehistory()
    {
        $this->validationRequest(TRUE);
        if ($this->role->hasRole('receivable_repayment.view')) {
            helper('datatable');
            $table = new \App\Libraries\Datatables('hd_payment_receivable');
            $table->db->select('payment_receivable_id,payment_receivable_invoice, customer_name, payment_receivable_date, payment_receivable_method_name, payment_receivable_total_invoice, payment_receivable_total_pay');
            $table->db->join('ms_customer', 'ms_customer.customer_id  = hd_payment_receivable.payment_receivable_customer_id');
            $table->db->orderBy('payment_receivable_id', 'desc');
            $table->renderColumn(function ($row, $i) {
                $column = [];
                $column[] = $i;
                $column[] = esc($row['payment_receivable_invoice']);
                $column[] = esc($row['customer_name']);
                $column[] = indo_short_date($row['payment_receivable_date']);
                $column[] = esc($row['payment_receivable_method_name']);
                $column[] = esc($row['payment_receivable_total_invoice']);
                $column[] = 'Rp. '.esc(number_format($row['payment_receivable_total_pay']));
                $btns = [];
                 $btns[] = '<a href="javascript:;" data-fancybox data-type="iframe" data-src="'.base_url().'/webmin/purchase-order/get-purchase-order-detail/'.$row['payment_receivable_id'].'" class="margins btn btn-sm btn-default mb-2" data-toggle="tooltip" data-placement="top" data-title="Detail"><i class="fas fa-eye"></i></a>';
                $column[] = implode('&nbsp;', $btns);
                return $column;
            });

            $table->orderColumn  = ['payment_receivable_invoice', 'customer_name'];
            $table->searchColumn = ['payment_receivable_invoice', 'customer_name'];
            $table->generate();
        }
    }

     public function tempadd(){

        $this->validationRequest(TRUE, 'POST');

        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];

        $validation =  \Config\Services::validation();


        $input = [
            'temp_payment_receivable_id'           => $this->request->getPost('temp_payment_receivable_id'),
            'temp_payment_receivable_sales_id'     => $this->request->getPost('temp_payment_receivable_sales_id'),
            'temp_payment_receivable_discount'     => $this->request->getPost('temp_payment_receivable_discount'),
            'temp_payment_receivable_nominal'      => $this->request->getPost('temp_payment_receivable_nominal'),
            'temp_payment_receivable_desc'         => $this->request->getPost('temp_payment_receivable_desc'),
            'temp_payment_isedit'                  => 'Y'
        ];



        $validation->setRules([
            'temp_payment_receivable_nominal'    => ['rules' => 'required']
        ]);

        if ($validation->run($input) === FALSE) {   

            $result = ['success' => FALSE, 'message' => 'Input tidak valid'];

        } else {

            $input['temp_payment_receivable_user_id'] = $this->userLogin['user_id'];

            $save = $this->M_receivable_repayment->insertTemp($input);


            if ($save) {

                    $result = ['success' => TRUE, 'message' => 'Data item berhasil Diubah'];

            } else {

                $result = ['success' => FALSE, 'message' => 'Data item gagal ditambahkan'];

            }

        }

        $getTemp = $this->M_receivable_repayment->getTemp($this->request->getPost('customer_id'))->getResultArray();

        $find_result = [];

        foreach ($getTemp as $k => $v) {

            $find_result[$k] = esc($v);

        }

        $result['data'] = $find_result;

        $result['csrfHash'] = csrf_hash();

        resultJSON($result);
    }


     public function copyDataTempRepayment()
    {
       // $this->validationRequest(TRUE, 'GET');

        $customerid = $this->request->getPost('customerid');

        $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk mengubah pelunasan piutang'];

        if ($this->role->hasRole('receivable_repayment.add')) {

            $getSaleseData = $this->M_receivable_repayment->getSaleseData($customerid)->getRowArray();

            if ($getSaleseData == NULL) {

                $result = ['success' => FALSE, 'message' => 'Transaksi tidak ditemukan'];

            } else {

                $user_id = $this->userLogin['user_id'];

                $copySalesTemp = $this->M_receivable_repayment->copySalesTemp($customerid, $user_id)->getResultArray();

                $find_result = [];

                foreach ($copySalesTemp as $k => $v) {

                    $find_result[$k] = esc($v);

                }

                $result = ['success' => TRUE, 'header' => $getSaleseData, 'data' => $find_result, 'message' => ''];


            }

        }
        $result['csrfHash'] = csrf_hash();
        
        resultJSON($result); 
    }

    public function saveReceivable()
    {
        $this->validationRequest(TRUE, 'POST');

        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];

        $validation =  \Config\Services::validation();

        $input = [
            'payment_receivable_customer_id'            => $this->request->getPost('payment_receivable_customer_id'),
            'payment_receivable_total_pay'              => $this->request->getPost('payment_receivable_total_pay'),
            'payment_receivable_method_id'              => $this->request->getPost('payment_receivable_method_id'),
            'payment_receivable_method_name'            => $this->request->getPost('payment_receivable_method_name'),
            'payment_receivable_date'                   => $this->request->getPost('payment_receivable_date'),
        ];

        $validation->setRules([
            'payment_receivable_total_pay'            => ['rules' => 'required']
        ]);

        if ($validation->run($input) === FALSE) {

            $result = ['success' => FALSE, 'message' => 'Input tidak valid'];

        } else {

            if ($this->role->hasRole('receivable_repayment.add')) {

                $input['user_id']= $this->userLogin['user_id'];

                $save = $this->M_receivable_repayment->insertPayment($input);

                if ($save['success']) {

                    $result = ['success' => TRUE, 'message' => 'Data pelunasan Piutang berhasil disimpan', 'payment_receivable_id' => $save['payment_receivable_id']];

                } else {

                    $result = ['success' => FALSE, 'message' => 'Data pelunasan Piutang gagal disimpan / Tidak ada data yang di Lunasi'];

                }

            } else {

                $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menambah pelunasan Piutang'];

            }

        }

        $result['csrfHash'] = csrf_hash();

        resultJSON($result);
    }

    public function getReceivableFooter()
    {
        $getReceivableFooter = $this->M_receivable_repayment->getReceivableFooter($this->userLogin['user_id'])->getResultArray();

        $find_result = [];

        foreach ($getReceivableFooter as $k => $v) {

            $find_result[$k] = esc($v);

        }

        $result['data'] = $find_result;

        $result['csrfHash'] = csrf_hash();

        $result['success'] = 'TRUE';

        resultJSON($result);
    }


}
