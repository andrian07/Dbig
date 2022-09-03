<?php


namespace App\Controllers\Webmin;

use App\Models\M_category;
use App\Controllers\Base\WebminController;


class Submission extends WebminController
{
    protected $M_category;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function index()
    {
        $data = [
            'title'         => 'Pengajuan' 
        ];
        return $this->renderView('purchase/submission', $data);
    }

    public function submissiondetaildemo()
    {

        $data = [
            'title'         => 'Pengajuan' 
        ];
        return $this->renderView('purchase/submissiondemo', $data);
    }

    //--------------------------------------------------------------------

}
