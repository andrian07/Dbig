<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class DevmanAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $getSession = session()->get('devman_login');
        if ($getSession == NULL) {
            return redirect()->to(base_url('devman/auth'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
