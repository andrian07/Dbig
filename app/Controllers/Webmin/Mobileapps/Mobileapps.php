<?php

namespace App\Controllers\Webmin\Mobileapps;

use Dompdf\Dompdf;
use App\Controllers\Base\WebminController;


class Mobileapps extends WebminController
{


    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function index(){
        
    }

    public function mobileappsBanner(){
        $data = [
            'title'         => 'Purchase Order Konsinyasi'
        ];
        return $this->renderView('mobileapps/mobileapps_banner', $data);
    }

    public function table()
    {
        $this->validationRequest(TRUE);
        //if ($this->role->hasRole('category.view')) {
            helper('datatable');
            $table = new \App\Libraries\Datatables('ms_mobile_banner');
            $table->db->select('mobile_banner_id ,mobile_banner_title,mobile_banner_image,active');
            $table->db->where('deleted', 'N');

            $table->renderColumn(function ($row, $i) {
                $column = [];

                $column[] = $i;
                $column[] = esc($row['mobile_banner_title']);
                $column[] = esc($row['mobile_banner_image']);
                $column[] = esc($row['active']);

                $btns = [];
                $prop =  'data-id="' . $row['mobile_banner_id'] . '" data-name="' . esc($row['mobile_banner_title']) . '"';
                $btns[] = button_edit($prop);
                $btns[] = button_delete($prop);
                $column[] = implode('&nbsp;', $btns);

                return $column;
            });

            $table->orderColumn  = ['', 'mobile_banner_title', 'active', ''];
            $table->searchColumn = ['mobile_banner_id', 'active'];
            $table->generate();
        //}
    }

}
