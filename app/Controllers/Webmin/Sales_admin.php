<?php


namespace App\Controllers\Webmin;

use Dompdf\Dompdf;
use App\Controllers\Base\WebminController;


class Sales_admin extends WebminController
{


    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function index()
    {
        $data = [
            'title'         => 'Penjualan Admin'
        ];
        return $this->renderView('sales/salesadmin', $data);
    }

    public function tblsalesadmin()
    {
        $this->validationRequest(TRUE);
        if ($this->role->hasRole('sales_admin.view')) {
            helper('datatable');

            $table = new \App\Libraries\Datatables('hd_pos_sales');
            $table->db->select('pos_sales_invoice,pos_sales_date,pos_sales_type,customer_id,store_id,pos_sales_total');
            $table->db->join('ms_supplier', 'ms_supplier.supplier_id  = hd_purchase.purchase_supplier_id');
            $table->db->orderBy('hd_purchase.created_at', 'desc');
            $table->renderColumn(function ($row, $i) {
                $column = [];
                $column[] = $i;
                $column[] = esc($row['purchase_invoice']);
                $column[] = indo_short_date($row['purchase_date']);
                if($row['purchase_total_ppn'] > 0){
                    $column[] = '<span class="badge badge-warning">BKP</span>';
                }else{
                    $column[] = '<span class="badge badge-primary">Non BKP</span>';
                }
                if($row['purchase_remaining_debt'] > 0){
                    $column[] = '<span class="badge badge-danger">Belum Lunas</span>';
                }else{
                    $column[] = '<span class="badge badge-success">Lunas</span>';
                }
                $column[] = esc($row['supplier_name']);
                $column[] = esc($row['purchase_suplier_no']);
                $column[] = 'Rp. '.esc(number_format($row['purchase_total']));
                $btns = [];
                $prop =  'data-id="' . $row['purchase_id'] . '" data-name="' . esc($row['purchase_invoice']) . '"';
                $btns[] = '<a href="javascript:;" data-fancybox data-type="iframe" data-src="'.base_url().'/webmin/purchase/get-purchase-detail/'.$row['purchase_id'].'" class="margins btn btn-sm btn-default mb-2" data-toggle="tooltip" data-placement="top" data-title="Detail"><i class="fas fa-eye"></i></a>';
                $column[] = implode('&nbsp;', $btns);
                return $column;
            });

            $table->orderColumn  = ['', 'purchase_invoice', 'purchase_date','',''];
            $table->searchColumn = ['purchase_invoice', 'purchase_date'];
            $table->generate();
        }
    }

    public function printinvoice()
    {
        $export = $this->request->getGet('export');
        if ($export == 'pdf') {

            
            $htmlView   = $this->renderView('sales/salesadmin_invoice');
            $dompdf = new Dompdf();
            $dompdf->loadHtml($htmlView);
            $dompdf->setPaper('half-letter', 'landscape');
            $dompdf->render();
            $dompdf->stream('invoice.pdf', array("Attachment" => false));
            exit();
        } else {
            return $this->renderView('sales/salesadmin_invoice');
        }
    }

    public function printdispatch()
    {
        return $this->renderView('sales/salesadmin_dispatch');
    }
    //--------------------------------------------------------------------

}
