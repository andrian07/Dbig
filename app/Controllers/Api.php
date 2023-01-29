<?php

namespace App\Controllers;

use App\Controllers\Base\BaseController;
use App\Models\M_api;

class Api extends BaseController
{
    protected $M_api;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->M_api = new M_api();
    }

    public function index()
    {
        echo "Api Dbig Ver 1.0";
    }


    public function checkOuth($headers)
    {   
        if(isset($headers['token']) == null){
            $result = ['err_code' => '01', 'message' => 'Token Tidak Ditemukan'];
            echo json_encode($result);die();
        }
        if($headers['token'] == 'asdk12m3121m23k1'){
            $result = ['err_code' => '00', 'message' => 'success'];
            return($result);
        }else{
            $result = ['err_code' => '01', 'message' => 'Token Tidak Sesuai'];
            echo json_encode($result);die();
        }
    }

    public function login()
    {
        $headers = apache_request_headers();
        $input = [
            'customer_phone'                      => $this->request->getPost('customer_phone'),
            'customer_password'                   => $this->request->getPost('customer_password'),
        ];
        $checkOuth = $this->checkOuth($headers);
        if($checkOuth['err_code'] == '00'){
            $getCustomerLogin = $this->M_api->getCustomerLogin($input['customer_phone'])->getRowArray();
            if ($getCustomerLogin != NULL) {
                if ($getCustomerLogin['active'] == 'N') {
                    $result = ['err_code' => '01', 'message' => 'Akun anda berstatus tidak aktif harap hubungi administrator'];
                    echo json_encode($result);die();
                }
                if($getCustomerLogin['verification_email'] == 'N'){
                    $result = ['err_code' => '01', 'message' => 'Silahkan Cek Email Untuk Verifikasi Email'];
                    echo json_encode($result);die();
                }
                if (password_verify($input['customer_password'], $getCustomerLogin['customer_password'])) {
                    echo json_encode($getCustomerLogin);die();
                }
            } else {
                $result = ['err_code' => '01', 'message' => 'Username atau password anda salah'];
                echo json_encode($result);die();
            }
        }else{
            $result = ['err_code' => '01', 'message' => 'Token Tidak Sesuai'];
            echo json_encode($result);die();
        }

    }


    public function getbanner()
    {
        $headers = apache_request_headers();
        $data = json_decode(file_get_contents('php://input'), true);
        $perpage = $data['perpage'];
        $start = $data['start'];
        $checkOuth = $this->checkOuth($headers);
        if($checkOuth['err_code'] == '00'){
            $result['result'] = $this->M_api->getBanner($perpage, $start)->getResultArray();
            $total_rows['total_rows'] = $this->M_api->getBanner($perpage, $start)->getNumRows();
            $err_code['err_code'] = '00';
            $data = array_merge($result, $total_rows, $err_code);
            if ($result['result'] != NULL) {
                echo json_encode($data);die();
            } else {
                $result = ['err_code' => '01', 'message' => 'Data Banner Tidak Di Temukan'];
                echo json_encode($result);die();
            }
        }else{
            $result = ['err_code' => '01', 'message' => 'Token Tidak Sesuai'];
            echo json_encode($result);die();
        }

    }

    public function getbannerbyid()
    {
        $headers = apache_request_headers();
        $checkOuth = $this->checkOuth($headers);
        $data = json_decode(file_get_contents('php://input'), true);
        $mobile_banner_id = $data['mobile_banner_id'];
        if($checkOuth['err_code'] == '00'){
            $result['result'] = $this->M_api->getBannerById($mobile_banner_id)->getResultArray();
            $total_rows['total_rows'] = $this->M_api->getBannerById($mobile_banner_id)->getNumRows();
            $err_code['err_code'] = '00';
            $data = array_merge($result, $total_rows, $err_code);
            if ($result['result'] != NULL) {
                echo json_encode($data);die();
            } else {
                $result = ['err_code' => '01', 'message' => 'Data Banner Tidak Di Temukan'];
                echo json_encode($result);die();
            }
        }else{
            $result = ['err_code' => '01', 'message' => 'Token Tidak Sesuai'];
            echo json_encode($result);die();
        }
    }


    public function getpromo()
    {
        $headers = apache_request_headers();
        $data = json_decode(file_get_contents('php://input'), true);
        $perpage = $data['perpage'];
        $start = $data['start'];
        $checkOuth = $this->checkOuth($headers);
        if($checkOuth['err_code'] == '00'){
            $result['result'] = $this->M_api->getPromo($perpage, $start)->getResultArray();
            $total_rows['total_rows'] = $this->M_api->getPromo($perpage, $start)->getNumRows();
            $err_code['err_code'] = '00';
            $data = array_merge($result, $total_rows, $err_code);
            if ($result['result'] != NULL) {
                echo json_encode($data);die();
            } else {
                $result = ['err_code' => '01', 'message' => 'Data Banner Tidak Di Temukan'];
                echo json_encode($result);die();
            }
        }else{
            $result = ['err_code' => '01', 'message' => 'Token Tidak Sesuai'];
            echo json_encode($result);die();
        }

    }


    public function getpromobyid()
    {
        $headers = apache_request_headers();
        $checkOuth = $this->checkOuth($headers);
        $data = json_decode(file_get_contents('php://input'), true);
        $mobile_promo_id = $data['mobile_promo_id'];
        if($checkOuth['err_code'] == '00'){
            $result['result'] = $this->M_api->getPromoById($mobile_promo_id)->getResultArray();
            $total_rows['total_rows'] = $this->M_api->getPromoById($mobile_promo_id)->getNumRows();
            $err_code['err_code'] = '00';
            $data = array_merge($result, $total_rows, $err_code);
            if ($result['result'] != NULL) {
                echo json_encode($data);die();
            } else {
                $result = ['err_code' => '01', 'message' => 'Data Promo Tidak Di Temukan'];
                echo json_encode($result);die();
            }
        }else{
            $result = ['err_code' => '01', 'message' => 'Token Tidak Sesuai'];
            echo json_encode($result);die();
        }
    }


    public function getProduct()
    {
        $headers = apache_request_headers();
        $data = json_decode(file_get_contents('php://input'), true);
        $checkOuth = $this->checkOuth($headers);
        $customer_group = $data['customer_group'];
        $brand_id = $data['brand_id'];
        $category_id = $data['category_id'];
        $sort = $data['sort'];
        $perpage = $data['perpage'];
        $start = $data['start'];

        if($sort == null){
            $result = ['err_code' => '01', 'message' => 'Silahkan Isi Jenis Sorting'];
            echo json_encode($result);die();
        }

        if($checkOuth['err_code'] == '00'){
            $result['result'] = $this->M_api->getProduct($customer_group, $perpage, $start, $brand_id, $category_id, $sort)->getResultArray();
            $total_rows['total_rows'] = $this->M_api->getProduct($customer_group, $perpage, $start, $brand_id, $category_id, $sort)->getNumRows();
            $err_code['err_code'] = '00';
            $data = array_merge($result, $total_rows, $err_code);
            if ($result['result'] != NULL) {
                echo json_encode($data);die();
            } else {
                $result = ['err_code' => '01', 'message' => 'Data Produk Tidak Di Temukan'];
                echo json_encode($result);die();
            }
        }else{
            $result = ['err_code' => '01', 'message' => 'Token Tidak Sesuai'];
            echo json_encode($result);die();
        }

    }

    public function getproductbyid()
    {
        $headers = apache_request_headers();
        $checkOuth = $this->checkOuth($headers);
        $data = json_decode(file_get_contents('php://input'), true);
        $customer_group = $data['customer_group'];
        $item_id = $data['item_id'];
        if($checkOuth['err_code'] == '00'){

            $result['result'] = $this->M_api->getProductById($customer_group, $item_id)->getResultArray();
            $total_rows['total_rows'] = $this->M_api->getProductById($customer_group, $item_id)->getNumRows();
            $err_code['err_code'] = '00';
            $data = array_merge($result, $total_rows, $err_code);
            if ($result['result'] != NULL) {
                echo json_encode($data);die();
            } else {
                $result = ['err_code' => '01', 'message' => 'Data Produk Tidak Di Temukan'];
                echo json_encode($result);die();
            }
        }else{
            $result = ['err_code' => '01', 'message' => 'Token Tidak Sesuai'];
            echo json_encode($result);die();
        }

    }

    public function getproductbyname()
    {
        $headers = apache_request_headers();
        $checkOuth = $this->checkOuth($headers);
        $data = json_decode(file_get_contents('php://input'), true);
        $customer_group = $data['customer_group'];
        $search = $data['search'];
        if($checkOuth['err_code'] == '00'){

            $result['result'] = $this->M_api->getproductbyname($search, $customer_group)->getResultArray();
            $total_rows['total_rows'] = $this->M_api->getproductbyname($search, $customer_group)->getNumRows();
            $err_code['err_code'] = '00';
            $data = array_merge($result, $total_rows, $err_code);
            if ($result['result'] != NULL) {
                echo json_encode($data);die();
            } else {
                $result = ['err_code' => '01', 'message' => 'Data Produk Tidak Di Temukan'];
                echo json_encode($result);die();
            }
        }else{
            $result = ['err_code' => '01', 'message' => 'Token Tidak Sesuai'];
            echo json_encode($result);die();
        }

    }

    public function getcategory()
    {
        $headers = apache_request_headers();
        $checkOuth = $this->checkOuth($headers);
        $data = json_decode(file_get_contents('php://input'), true);
        $perpage = $data['perpage'];
        $start = $data['start'];
        if($checkOuth['err_code'] == '00'){
            $result['result'] = $this->M_api->getCategory($perpage, $start)->getResultArray();
            $total_rows['total_rows'] = $this->M_api->getCategory($perpage, $start)->getNumRows();
            $err_code['err_code'] = '00';
            $data = array_merge($result, $total_rows, $err_code);
            if ($result['result'] != NULL) {
                echo json_encode($data);die();
            } else {
                $result = ['err_code' => '01', 'message' => 'Data Banner Tidak Di Temukan'];
                echo json_encode($result);die();
            }
        }else{
            $result = ['err_code' => '01', 'message' => 'Token Tidak Sesuai'];
            echo json_encode($result);die();
        }
    }

    public function getbrand()
    {
        $headers = apache_request_headers();
        $checkOuth = $this->checkOuth($headers);
        $data = json_decode(file_get_contents('php://input'), true);
        $perpage = $data['perpage'];
        $start = $data['start'];
        if($checkOuth['err_code'] == '00'){
            $result['result'] = $this->M_api->getBrand($perpage, $start)->getResultArray();
            $total_rows['total_rows'] = $this->M_api->getBrand($perpage, $start)->getNumRows();
            $err_code['err_code'] = '00';
            $data = array_merge($result, $total_rows, $err_code);
            if ($result['result'] != NULL) {
                echo json_encode($data);die();
            } else {
                $result = ['err_code' => '01', 'message' => 'Data Banner Tidak Di Temukan'];
                echo json_encode($result);die();
            }
        }else{
            $result = ['err_code' => '01', 'message' => 'Token Tidak Sesuai'];
            echo json_encode($result);die();
        }
    }


    /*public function getitempoint()
    {
        $headers = apache_request_headers();
        $checkOuth = $this->checkOuth($headers);
        $search = $this->request->getPost('search');
        if($checkOuth['err_code'] == '00'){

            $result['result'] = $this->M_api->getitempoint($search)->getResultArray();
            $total_rows['total_rows'] = $this->M_api->getitempoint($search)->getNumRows();
            $err_code['err_code'] = '00';
            $data = array_merge($result, $total_rows, $err_code);
            if ($result['result'] != NULL) {
                echo json_encode($data);die();
            } else {
                $result = ['err_code' => '01', 'message' => 'Data Produk Tidak Di Temukan'];
                echo json_encode($result);die();
            }
        }else{
            $result = ['err_code' => '01', 'message' => 'Token Tidak Sesuai'];
            echo json_encode($result);die();
        }

    }*/



}

