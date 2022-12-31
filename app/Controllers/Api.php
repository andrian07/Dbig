<?php

namespace App\Controllers;

use App\Controllers\Base\BaseController;

class Api extends BaseController
{
    public function index()
    {
        echo "Api Dbig Ver 1.0";
    }


    public function checkOuth($headers, $input)
    {
        if($headers['token'] == 'asdk12m3121m23k1'){
            $result = ['err_code' => '00', 'message' => 'Data Tidak Ditemukan Silahkan Login Kembali'];
            echo json_encode($result);
        }else{
            $result = ['err_code' => '01', 'message' => 'Data Sesuai'];
            echo json_encode($result);
        }
    }

    public function login()
    {
        $headers = apache_request_headers();
        $input = [
            'customer_phone'                      => $this->request->getPost('customer_phone'),
            'customer_password'                   => $this->request->getPost('customer_password'),
        ];
        $checkOuth = $this->checkOuth($headers, $input);
    }

}
