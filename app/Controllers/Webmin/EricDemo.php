<?php

namespace App\Controllers\Webmin;

use Dompdf\Dompdf;

use App\Controllers\Base\WebminController;


class EricDemo extends WebminController
{

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function index()
    {
        echo "Demo";
    }

    public function unit()
    {
        $data = [
            'title'         => 'Satuan'
        ];
        return $this->renderView('demo/masterdata/unit', $data);
    }

    public function brand()
    {
        $data = [
            'title'         => 'Brand'
        ];
        return $this->renderView('demo/masterdata/brand', $data);
    }

    public function warehouse()
    {
        $data = [
            'title'         => 'Warehouse'
        ];
        return $this->renderView('demo/masterdata/warehouse', $data);
    }


    public function supplier()
    {
        $data = [
            'title'         => 'Supplier'
        ];
        return $this->renderView('demo/masterdata/supplier', $data);
    }


    public function customer()
    {
        $data = [
            'title'         => 'Customer'
        ];
        return $this->renderView('demo/masterdata/customer', $data);
    }

    public function product()
    {
        $data = [
            'title'         => 'Produk'
        ];
        return $this->renderView('demo/masterdata/product', $data);
    }

    public function productDetail()
    {
        $data = [
            'title'         => 'Produk Detail'
        ];
        return $this->renderView('demo/masterdata/product_detail', $data);
    }

    public function parcelDetail()
    {
        $data = [
            'title'         => 'Paket Detail'
        ];
        return $this->renderView('demo/masterdata/parcel_detail', $data);
    }


    public function pointReward()
    {
        $data = [
            'title'         => 'Hadiah Poin'
        ];
        return $this->renderView('demo/customer_point/point_reward', $data);
    }

    public function exchangePoint()
    {
        $data = [
            'title'         => 'Penukaran Poin'
        ];
        return $this->renderView('demo/customer_point/exchange_point', $data);
    }

    public function exchangePointV2()
    {
        $data = [
            'title'         => 'Penukaran Poin'
        ];
        return $this->renderView('demo/customer_point/exchange_point_v2', $data);
    }

    public function exchangePointDetail()
    {
        $data = [
            'title'         => 'Detail Penukaran Poin'
        ];
        return $this->renderView('demo/customer_point/exchange_point_detail', $data);
    }

    public function userAccount()
    {
        $data = [
            'title'         => 'Akun Pengguna'
        ];
        return $this->renderView('demo/auth/user_account', $data);
    }

    public function voucher()
    {
        $data = [
            'title'         => 'Voucher'
        ];
        return $this->renderView('demo/voucher/voucher', $data);
    }

    public function passwordControl()
    {
        $data = [
            'title'         => 'Password Control'
        ];
        return $this->renderView('demo/password_control/password_control', $data);
    }


    public function passwordControlLogs()
    {
        $data = [
            'title'         => 'Password Control Log'
        ];
        return $this->renderView('demo/password_control/password_control_logs', $data);
    }


    public function debtRepayment()
    {
        $data = [
            'title'         => 'Pelunasan Hutang'
        ];
        return $this->renderView('demo/repayment/debt_repayment', $data);
    }

    public function debtRepaymentDetail()
    {
        $data = [
            'title'         => 'Detail Pelunasan Hutang'
        ];
        return $this->renderView('demo/repayment/debt_repayment_detail', $data);
    }


    public function receivableRepayment()
    {
        $data = [
            'title'         => 'Pelunasan Piutang'
        ];
        return $this->renderView('demo/repayment/receivable_repayment', $data);
    }


    public function receivableRepaymentDetail()
    {
        $data = [
            'title'         => 'Detail Pelunasan Piutang'
        ];
        return $this->renderView('demo/repayment/receivable_repayment_detail', $data);
    }


    public function stockOpname()
    {
        $data = [
            'title'         => 'Stok Opname'
        ];
        return $this->renderView('demo/stock_opname/stock_opname', $data);
    }

    public function stockOpnameDetail()
    {
        $data = [
            'title'         => 'Stok Opname Detail'
        ];
        return $this->renderView('demo/stock_opname/stock_opname_detail', $data);
    }

    public function stockOpnameReport()
    {
        $data = [
            'title'         => 'Stok Opname Report',
            'userLogin'     => $this->userLogin
        ];
        return $this->renderView('demo/stock_opname/stock_opname_report', $data);
    }

    public function stockTransfer()
    {
        $data = [
            'title'         => 'Stok Transfer'
        ];
        return $this->renderView('demo/stock_transfer/stock_transfer', $data);
    }

    public function stockTransferDetail()
    {
        $data = [
            'title'         => 'Stok Transfer Detail'
        ];
        return $this->renderView('demo/stock_transfer/stock_transfer_detail', $data);
    }

    public function stockTransferReport()
    {
        $data = [
            'title'         => 'Stok Transfer Report',
            'userLogin'     => $this->userLogin
        ];
        return $this->renderView('demo/stock_transfer/stock_transfer_report', $data);
    }

    public function reportSalesProductRecap()
    {
        $data = [
            'title'         => 'Rekap Penjualan Produk',
            'userLogin'     => $this->userLogin
        ];

        $htmlView   = $this->renderView('demo/report/product_sales_recap', $data);
        $agent = $this->request->getUserAgent();

        if ($agent->isMobile()) {
            return $htmlView;
        } else {
            $dompdf = new Dompdf();
            $dompdf->loadHtml($htmlView);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            $dompdf->stream('contoh_file_pdf.pdf', array("Attachment" => false));
            exit();
        }
    }

    public function viewReportSalesProductRecap()
    {
        $data = [
            'title'         => 'Rekap Penjualan Produk',
            'userLogin'     => $this->userLogin
        ];


        return $this->renderView('demo/report/view_product_sales_recap', $data);
    }






    //--------------------------------------------------------------------

}
