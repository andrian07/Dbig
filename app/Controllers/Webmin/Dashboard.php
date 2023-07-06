<?php


namespace App\Controllers\Webmin;

use App\Controllers\Base\WebminController;

class Dashboard extends WebminController
{

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function index()
    {
        $M_admin_notification = model('M_admin_notification');

        $getNotification = $M_admin_notification->getNotification()->getResultArray();
        $data = [
            'title'             => 'Dasbor',
            'notifications'     => $getNotification
        ];


        return $this->renderView('dashboard', $data);
    }


    public function deleteNotification($notification_id)
    {
        $view_url = $this->request->getGet('view_url') == null ? base_url('webmin/dashboard') : $this->request->getGet('view_url');
        $M_admin_notification = model('M_admin_notification');
        $M_admin_notification->deleteNotification($notification_id);
        return redirect()->to($view_url);
    }
    //--------------------------------------------------------------------

}
