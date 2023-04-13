<?php

namespace App\Controllers\Pos;

use App\Controllers\Base\BaseController;

class Utility extends BaseController
{

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function index()
    {
        echo "Utility";
    }


    public function customerDisplay()
    {
        $data = [
            'title'     => 'Customer Display',
        ];
        return view('pos/customer_display', $data);
    }


    public function priceChecker()
    {
        $data = [
            'title'     => 'Cek Harga',
        ];
        return view('pos/price_checker', $data);
    }

    //--------------------------------------------------------------------

}
