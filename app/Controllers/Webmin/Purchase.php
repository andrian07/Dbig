<?php


namespace App\Controllers\Webmin;

use App\Controllers\Base\WebminController;


class Purchase extends WebminController
{

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function index()
    {
        $data = [
            'title'         => 'Purchase' 
        ];
        return $this->renderView('purchase/purchase', $data);
    }

    public function returpurchase()
    {
        return $this->renderView('purchase/returpurchase');
    }

    //--------------------------------------------------------------------

}
