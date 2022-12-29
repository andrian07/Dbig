<?php

namespace App\Controllers\Webmin\Payment;

use Dompdf\Dompdf;
use Config\App as AppConfig;
use App\Models\M_debt_repayment;
use App\Controllers\Base\WebminController;


class Debt_repayment extends WebminController
{

    protected $M_debt_repayment;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->M_debt_repayment = new M_debt_repayment;
    }

    public function index()
    {
        $data = [
            'title'         => 'Pelunasan Hutang'
        ];
        return $this->renderView('payment/debt_repayment', $data);
    }

    public function tbl_debtrepayment()
    {
        $this->validationRequest(TRUE);
        if ($this->role->hasRole('debt_repayment.view')) {
            helper('datatable');

            $table = new \App\Libraries\Datatables('hd_purchase');
            $table->db->select('purchase_supplier_id, supplier_name, supplier_code, supplier_address, supplier_phone, count(*) as total_invoice, sum(purchase_remaining_debt) as total_remaining_debt');
            $table->db->join('ms_supplier', 'ms_supplier.supplier_id  = hd_purchase.purchase_supplier_id');
            $table->db->where('purchase_remaining_debt >', '0');
            $table->db->groupBy('purchase_supplier_id');
            $table->renderColumn(function ($row, $i) {
                $column = [];
                $column[] = $i;
                $column[] = esc($row['supplier_code']);
                $column[] = esc($row['supplier_name']);
                $column[] = esc($row['supplier_address']);
                $column[] = esc($row['supplier_phone']);
                $column[] = esc($row['total_invoice']);
                $column[] = 'Rp. '.esc(number_format($row['total_remaining_debt']));
                $btns = [];
                $btns[] = '<button data-supplierid="' . $row['purchase_supplier_id'] . '" data-suppliercode="' . $row['supplier_code'] . '" data-suppliername="' . $row['supplier_name'] . '" data-totalremainingdebt="' . $row['total_remaining_debt'] . '" class="btn btn-sm btn-success btnrepayment" data-toggle="tooltip" data-placement="top" data-title="Pelunasan" data-original-title="" title=""><i class="fas fa-money-bill-wave"></i></button>';
                $column[] = implode('&nbsp;', $btns);
                return $column;
            });

            $table->orderColumn  = ['supplier_code', 'supplier_name'];
            $table->searchColumn = ['supplier_code', 'supplier_name'];
            $table->generate();
        }
    }

    public function tbl_debtrepaymenthistory()
    {
        $this->validationRequest(TRUE);
        if ($this->role->hasRole('debt_repayment.view')) {
            helper('datatable');

            $table = new \App\Libraries\Datatables('hd_payment_debt');
            $table->db->select('payment_debt_id,payment_debt_invoice, supplier_name, payment_debt_date, payment_debt_method_name,payment_debt_total_invoice,payment_debt_total_pay');
            $table->db->join('ms_supplier', 'ms_supplier.supplier_id  = hd_payment_debt.payment_debt_supplier_id');
            $table->db->orderBy('payment_debt_id', 'desc');
            $table->renderColumn(function ($row, $i) {
                $column = [];
                $column[] = $i;
                $column[] = esc($row['payment_debt_invoice']);
                $column[] = esc($row['supplier_name']);
                $column[] = indo_short_date($row['payment_debt_date']);
                $column[] = esc($row['payment_debt_method_name']);
                $column[] = esc($row['payment_debt_total_invoice']);
                $column[] = 'Rp. '.esc(number_format($row['payment_debt_total_pay']));
                $btns = [];
                $btns[] = '<a href="javascript:;" data-fancybox data-type="iframe" data-src="'.base_url().'/webmin/payment/get-debt-history-detail/'.$row['payment_debt_id'].'" class="margins btn btn-sm btn-default mb-2" data-toggle="tooltip" data-placement="top" data-title="Detail"><i class="fas fa-eye"></i></a>';
                $column[] = implode('&nbsp;', $btns);
                return $column;
            });

            $table->orderColumn  = ['payment_debt_invoice', 'supplier_name'];
            $table->searchColumn = ['payment_debt_invoice', 'supplier_name'];
            $table->generate();
        }
    }

    public function getDebtHistoryDetail($payment_debt_id = '')
    {
        if ($payment_debt_id == '') {

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        } else {

            $getHdDebtdetail =  $this->M_debt_repayment->getHdDebtdetail($payment_debt_id)->getRowArray();

            if ($getHdDebtdetail == NULL) {

                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

            } else {

                $data = [

                    'hdDebt' => $getHdDebtdetail,

                    'dtDebt' => $this->M_debt_repayment->getDtDebtdetail($payment_debt_id)->getResultArray(),

                    //'log' => $this->M_debt_repayment->getLog($purchase_order_id)->getResultArray()

                ];

                return view('webmin/payment/debt_repayment_detail', $data);

            }

        }

    }

    public function copyDataTemp()
    {
       // $this->validationRequest(TRUE, 'GET');

        $supplierid = $this->request->getPost('supplierid');

        $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk mengubah pesanan pembelian'];

        if ($this->role->hasRole('debt_repayment.add')) {

            $getPurchaseData = $this->M_debt_repayment->getPurchaseData($supplierid)->getRowArray();

            if ($getPurchaseData == NULL) {

                $result = ['success' => FALSE, 'message' => 'Transaksi tidak ditemukan'];

            } else {

                $purchase_id = $getPurchaseData['purchase_id'];

                $user_id = $this->userLogin['user_id'];

                $copyPurchaseTemp = $this->M_debt_repayment->copyPurchaseTemp($supplierid, $user_id)->getResultArray();

                $find_result = [];

                foreach ($copyPurchaseTemp as $k => $v) {

                    $find_result[$k] = esc($v);

                }

             

                $result = ['success' => TRUE, 'header' => $getPurchaseData, 'data' => $find_result, 'message' => ''];


            }

        }
        $result['csrfHash'] = csrf_hash();
        
        resultJSON($result); 
    }



    public function tempadd(){

        $this->validationRequest(TRUE, 'POST');

        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];

        $validation =  \Config\Services::validation();


        $input = [
            'temp_payment_debt_id'              => $this->request->getPost('temp_payment_debt_id'),
            'temp_payment_debt_purchase_id'     => $this->request->getPost('temp_payment_debt_purchase_id'),
            'temp_payment_debt_discount'        => $this->request->getPost('temp_payment_debt_discount'),
            'temp_payment_debt_nominal'         => $this->request->getPost('temp_payment_debt_nominal'),
            'temp_payment_debt_desc'            => $this->request->getPost('temp_payment_debt_desc'),
            'temp_payment_isedit'               => 'Y'
        ];

        $validation->setRules([
            'temp_payment_debt_nominal'    => ['rules' => 'required']
        ]);

        if ($validation->run($input) === FALSE) {

            $result = ['success' => FALSE, 'message' => 'Input tidak valid'];

        } else {

            $input['temp_payment_debt_user_id'] = $this->userLogin['user_id'];

            $save = $this->M_debt_repayment->insertTemp($input);


            if ($save) {

                    $result = ['success' => TRUE, 'message' => 'Data item berhasil Diubah'];

            } else {

                $result = ['success' => FALSE, 'message' => 'Data item gagal ditambahkan'];

            }

        }

        $getTemp = $this->M_debt_repayment->getTemp($this->request->getPost('supplier_id'))->getResultArray();

        $find_result = [];

        foreach ($getTemp as $k => $v) {

            $find_result[$k] = esc($v);

        }

        $result['data'] = $find_result;

        $result['csrfHash'] = csrf_hash();

        resultJSON($result);
    }

    public function save($type)
    {

        $this->validationRequest(TRUE, 'POST');

        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];

        $validation =  \Config\Services::validation();

        $input = [
            'payment_debt_supplier_id'            => $this->request->getPost('payment_debt_supplier_id'),
            'payment_debt_total_pay'              => $this->request->getPost('payment_debt_total_pay'),
            'payment_debt_method_id'              => $this->request->getPost('payment_debt_method_id'),
            'payment_debt_method_name'            => $this->request->getPost('payment_debt_method_name'),
            'payment_debt_date'                   => $this->request->getPost('repayment_date'),
        ];

        $validation->setRules([
            'payment_debt_total_pay'            => ['rules' => 'required']
        ]);

        if ($validation->run($input) === FALSE) {

            $result = ['success' => FALSE, 'message' => 'Input tidak valid'];

        } else {

            if ($this->role->hasRole('purchase_order.add')) {

                $input['user_id']= $this->userLogin['user_id'];

                $save = $this->M_debt_repayment->insertPayment($input);

                if ($save['success']) {

                    $result = ['success' => TRUE, 'message' => 'Data pelunasan hutang berhasil disimpan', 'payment_debt_id' => $save['payment_debt_id']];

                } else {

                    $result = ['success' => FALSE, 'message' => 'Data pelunasan hutang gagal disimpan / Tidak ada data yang di Lunasi'];

                }

            } else {

                $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menambah pelunasan hutang'];

            }

        }

        $result['csrfHash'] = csrf_hash();

        resultJSON($result);

    }

    public function getPaymentFooter()
    {

        $getPaymentFooter = $this->M_debt_repayment->getPaymentFooter($this->userLogin['user_id'])->getResultArray();

        $find_result = [];

        foreach ($getPaymentFooter as $k => $v) {

            $find_result[$k] = esc($v);

        }

        $result['data'] = $find_result;

        $result['csrfHash'] = csrf_hash();

        $result['success'] = 'TRUE';

        resultJSON($result);
    }


}
