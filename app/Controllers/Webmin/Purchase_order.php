<?php


namespace App\Controllers\Webmin;

use App\Models\M_category;
use App\Controllers\Base\WebminController;


class Purchase_order extends WebminController
{
    protected $M_category;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->M_category = new M_category;
    }

    public function index()
    {
        $data = [
            'title'         => 'Purchase Order' 
        ];
        return $this->renderView('masterdata/category', $data, 'category.view');
    }

    //--------------------------------------------------------------------

}
