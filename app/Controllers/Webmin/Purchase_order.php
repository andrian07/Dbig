<?php


namespace App\Controllers\Webmin;


use App\Controllers\Base\WebminController;


class Purchase_order extends WebminController
{


    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function index()
    {
        $data = [
            'title'         => 'Purchase Order' 
        ];
        return $this->renderView('purchase/purchaseorder', $data);
    }

    //--------------------------------------------------------------------

}