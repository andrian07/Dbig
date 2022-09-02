<?php

namespace App\Controllers\Webmin;

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



    //--------------------------------------------------------------------

}
