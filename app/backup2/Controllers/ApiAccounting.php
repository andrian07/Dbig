<?php

namespace App\Controllers;

use App\Controllers\Base\BaseController;
use App\Models\M_api_accounting;

class ApiAccounting extends BaseController
{
    protected $M_api_accounting;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->M_api_accounting = new M_api_accounting();
    }

    public function index()
    {
        echo "Api Dbig Ver 1.0";
    }


    public function post_accounting_purchase()
    {

        $data = json_decode(file_get_contents('php://input'), true);

        $api_last_record_id = $data['api_last_record_id'] + 1;

        $data = $this->M_api_accounting->getPurchaseApi($api_last_record_id)->getResultArray();

        echo json_encode($data, true);
    }

    public function post_accounting_debt_repayment()
    {

        $data = json_decode(file_get_contents('php://input'), true);

        $api_last_record_id = $data['api_last_record_id'] + 1;

        $data = $this->M_api_accounting->getDebtRepaymentApi($api_last_record_id)->getResultArray();

        ///return $data;
        echo json_encode($data, true);
    }

    public function post_accounting_retur_purchase()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $api_last_record_id = $data['api_last_record_id'] + 1;

        $data = $this->M_api_accounting->getReturPurchaseApi($api_last_record_id)->getResultArray();

        ///return $data;
        echo json_encode($data, true);
    }

    public function post_accounting_sales_admin()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $api_last_record_id = $data['api_last_record_id'] + 1;

        $data = $this->M_api_accounting->getSalesAdmin($api_last_record_id)->getResultArray();

        ///return $data;
        echo json_encode($data, true);
    }


    public function post_accounting_receivable_repayment()
    {

        $data = json_decode(file_get_contents('php://input'), true);

        $api_last_record_id = $data['api_last_record_id'] + 1;

        $data = $this->M_api_accounting->getReceivableRepaymentApi($api_last_record_id)->getResultArray();

        ///return $data;
        echo json_encode($data, true);
    }


}

