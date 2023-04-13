<?php

namespace App\Controllers\Pos;

use App\Controllers\Base\PosController;

class Sales_return extends PosController
{

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function index()
    {
        $data = [
            'title'     => 'Sales Return',
        ];
        return $this->renderView('transaction/sales_return', $data);
    }








    //--------------------------------------------------------------------

}
