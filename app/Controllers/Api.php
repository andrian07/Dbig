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
        $data = json_decode(file_get_contents('php://input'), true);
        $customer_phone = $data['customer_phone'];
        $customer_password = $data['customer_password'];
        $checkOuth = $this->checkOuth($headers);
        if($checkOuth['err_code'] == '00'){
            $getCustomerLogin = $this->M_api->getCustomerLogin($customer_phone)->getRowArray();
            if ($getCustomerLogin != NULL) {
                if ($getCustomerLogin['active'] == 'N') {
                    $result = ['err_code' => '01', 'message' => 'Akun anda berstatus tidak aktif harap hubungi administrator'];
                    echo json_encode($result);die();
                }
                if($getCustomerLogin['verification_email'] == 'N'){
                    $result = ['err_code' => '01', 'message' => 'Silahkan Cek Email Untuk Verifikasi Email'];
                    echo json_encode($result);die();
                }
                if (password_verify($customer_password, $getCustomerLogin['customer_password'])) {

                    $result = ['err_code' => '00', 'message' => $getCustomerLogin];
                    echo json_encode($result);die();
                }else{
                    $result = ['err_code' => '01', 'message' => 'Username atau password anda salah'];
                    echo json_encode($result);die();
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




    public function registerCustomer($type)
    {
         helper('text');
        $headers = apache_request_headers();
        $data = json_decode(file_get_contents('php://input'), true);
        $checkOuth = $this->checkOuth($headers);
        if($checkOuth['err_code'] == '00'){
            if($type == 'add'){
                $input = [
                    'customer_code'                 => $data['customer_code'],
                    'customer_name'                 => $data['customer_name'],
                    'customer_address'              => $data['customer_address'],
                    'customer_phone'                => $data['customer_phone'],
                    'customer_email'                => $data['customer_email'],
                    'customer_nik'                  => '',
                    'customer_group'                => $data['customer_group'],
                    'customer_gender'               => $data['customer_gender'],
                    'customer_job'                  => $data['customer_job'],
                    'customer_birth_date'           => $data['customer_birth_date'],
                    'customer_password'             => $data['customer_password'],
                    'invite_by_referral_code'       => $data['invite_by_referral_code'],
                ];

                if($input['customer_group'] == 'G3' || $input['customer_group'] == 'G4'){
                    $input['active']           = 'N';
                }else{
                    $input['active']           = 'Y';
                }

                $input['customer_remark']           = $data['customer_remark'].'By APPS';

            }else{
                $input = [
                    'customer_id'                   => $data['customer_id'],
                    'customer_name'                 => $data['customer_name'],
                    'customer_address'              => $data['customer_address'],
                    'customer_phone'                => $data['customer_phone'],
                ];  
            }

            $input['mapping_id']                          = 0;
            $input['salesman_id']                         = 0;
            $input['customer_delivery_address']           = $input['customer_address'];

            $M_customer = model('M_customer');

            if ($type == 'add') {
                helper('text');
                unset($input['customer_id']);

                $check_email = $this->M_api->check_email($input['customer_email'])->getRowArray();
                
                if($check_email != null){
                    $result = ['err_code' => '01', 'message' => 'Email Sudah Terdaftar'];
                    echo json_encode($result);die();
                }

                $check_phone = $this->M_api->check_phone($input['customer_phone'])->getRowArray();

                if($check_phone != null){
                    $result = ['err_code' => '01', 'message' => 'No Telepon Sudah Terdaftar'];
                    echo json_encode($result);die();
                }

                if($input['invite_by_referral_code'] != null){
                  $check_referalcode = $this->M_api->check_referalcode($input['invite_by_referral_code'])->getRowArray();

                  if($check_referalcode == null){
                      $result = ['err_code' => '01', 'message' => 'Referal Code Tidak Di Temukan'];
                      echo json_encode($result);die();
                  }
                }

                $customer_password = $input['customer_password'];
                $input['customer_password'] = password_hash($customer_password, PASSWORD_BCRYPT);
                
                $isFound        = FALSE;
                $referral_code  = '';
                while ($isFound == FALSE) {
                    $referral_code = strtoupper(random_string('alnum', 6));
                    $check = $M_customer->getCustomerByReferralCode($referral_code, TRUE)->getRowArray();
                    if ($check == NULL) {
                        $isFound = TRUE;
                    }
                }

                $input['referral_code'] = $referral_code;

                

                $save = $this->M_api->insertCustomer($input);

                if ($save['result'] == 1) {
                    helper('encrypter');
                    $customer_id    = $save['customer_id'];
                    $customer_name  = $data['customer_name'];
                    $customer_email = $data['customer_email'];
                    $get_customer_code = $this->M_api->get_customer_code($customer_id)->getRowArray();
                    $params = [
                        'customer_id'       => $customer_id,
                        'customer_code'     => $get_customer_code['customer_code'],
                        'exp_time'          => time() + (60 * 60 * 24)
                    ];
                    $toJson = json_encode($params);
                    $strEncode = strEncode($toJson);
                    $verificationUrl = base_url('verification/' . $strEncode) . '?cid=' . $customer_id;
                    $subject = 'Verifikasi Email';
                    $data = [
                        'customer_name'    => $customer_name,
                        'verification_url' => $verificationUrl,
                    ];
                    $message = view('email/verification', $data);
                    /* end sample verification email */

                    $mail = new \App\Libraries\Mail();
                    $mail->setTo($customer_email);
                    $mail->setSubject($subject);
                    $mail->setMessage($message);

                    if ($mail->send()) {
                         $result = ['err_code' => '00', 'message' => 'Data customer berhasil disimpan silahkan cek email anda'];
                    } else {
                        $result = ['err_code' => '00', 'message' => 'Data customer berhasil disimpan silahkan cek email anda'];
                    }          
                } else {
                    $result = ['err_code' => '01', 'message' => 'Data customer gagal disimpan'];
                }

            } else if ($type == 'edit') {

                $check_pass = $this->M_api->check_pass($input['customer_id'])->getRowArray();
                $input['customer_id'] = $data['customer_id'];
                $save = $this->M_api->updateCustomer($input);
                if ($save) {
                    $result = ['err_code' => '00', 'message' => 'Data customer berhasil diperbarui'];
                } else {
                    $result = ['err_code' => '01', 'message' => 'Data customer gagal diperbarui'];
                }
                
            }
        }else{
            $result = ['err_code' => '01', 'message' => 'Token Tidak Sesuai'];
        }
        echo json_encode($result);die();
    }

    public function changePass()
    {
        $headers = apache_request_headers();
        $checkOuth = $this->checkOuth($headers);
        $data = json_decode(file_get_contents('php://input'), true);
        $customer_id = $data['customer_id'];
        $old_pass = $data['old_pass'];
        $new_pass = password_hash($data['new_pass'], PASSWORD_BCRYPT);
        if($checkOuth['err_code'] == '00'){
            $getCustomerLogin = $this->M_api->getCustomerResetPass($customer_id)->getRowArray();
            if (password_verify($old_pass, $getCustomerLogin['customer_password'])) {
                $input = [
                    'customer_password'  => $new_pass,
                ];  
                $save = $this->M_api->updatePass($customer_id, $input);
                if ($save) {
                    $result = ['err_code' => '00', 'message' => 'Reset Password Berhasil'];
                    echo json_encode($result);die();
                } else {
                    $result = ['err_code' => '01', 'message' => 'Gagal Reset Password'];
                    echo json_encode($result);die();
                }
            }else{
                $result = ['err_code' => '01', 'message' => 'Password Lama Tidak Sesuai'];
                echo json_encode($result);die();
            }
        }else{
            $result = ['err_code' => '01', 'message' => 'Token Tidak Sesuai'];
            echo json_encode($result);die();
        }
    }

    public function resetPass()
    {
         helper('text');
        $headers = apache_request_headers();
        $checkOuth = $this->checkOuth($headers);
        $data = json_decode(file_get_contents('php://input'), true);
        $customer_email = $data['customer_email'];
        $customer_password_rand = strtoupper(random_string('alnum', 8));
        $customer_password = password_hash($customer_password_rand, PASSWORD_BCRYPT);
        $input = [
            'customer_password'  => $customer_password,
        ];
        $getCustomerIdByEmail = $this->M_api->getCustomerIdByEmail($customer_email)->getRowArray();
        if($getCustomerIdByEmail != null){
            $customer_id = $getCustomerIdByEmail['customer_id'];
            $save = $this->M_api->updatePass($customer_id, $input);
            helper('encrypter');
            $customer_name  = $getCustomerIdByEmail['customer_name'];
            $get_customer_code = $this->M_api->get_customer_code($customer_id)->getRowArray();
            $params = [
                'customer_id'       => $customer_id,
                'customer_code'     => $get_customer_code['customer_code'],
                'exp_time'          => time() + (60 * 60 * 24)
            ];
            $toJson = json_encode($params);
            $strEncode = strEncode($toJson);
            $verificationUrl = base_url('verification/' . $strEncode) . '?cid=' . $customer_id;
            $subject = 'Lupa Password';
            $data = [
                'customer_name'     => $customer_name,
                'customer_password' => $customer_password_rand,
            ];
            $message = view('email/forgetpass', $data);
            /* end sample verification email */

            $mail = new \App\Libraries\Mail();
            $mail->setTo($customer_email);
            $mail->setSubject($subject);
            $mail->setMessage($message);

            if ($mail->send()) {
                $result = ['err_code' => '00', 'message' => 'Cek Email Untuk Password Anda'];die();
            } else {
                $result = ['err_code' => '01', 'message' => 'Email Tidak Terdaftar'];die();
            }
        }else{
            $result = ['err_code' => '01', 'message' => 'Email Tidak Terdaftar'];
            echo json_encode($result);die();
        }
        
    }

    public function getdataCustomer()
    {
        $headers = apache_request_headers();
        $checkOuth = $this->checkOuth($headers);
        $data = json_decode(file_get_contents('php://input'), true);
        $customer_phone = $data['customer_phone'];
        if($checkOuth['err_code'] == '00'){
            $result['result'] = $this->M_api->getCustomerByPhone($customer_phone)->getResultArray();
            $total_rows['total_rows'] = $this->M_api->getCustomerByPhone($customer_phone)->getNumRows();
            $err_code['err_code'] = '00';
            $data = array_merge($result, $total_rows, $err_code);
            if ($result['result'] != NULL) {
                $result = ['err_code' => '00', 'message' => $result];
                echo json_encode($result);die();
            } else {
                $result = ['err_code' => '01', 'message' => 'Data User Tidak Di Temukan'];
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
            $total_rows['total_rows'] = $this->M_api->getBanner($perpage = 0, $start = 0)->getNumRows();
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
            $total_rows['total_rows'] = $this->M_api->getPromo($perpage = 0, $start = 0)->getNumRows();
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
            $total_rows['total_rows'] = $this->M_api->getProduct($customer_group, $perpage = 0, $start = 0, $brand_id, $category_id, $sort)->getNumRows();
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
            $total_rows['total_rows'] = $this->M_api->getCategory($perpage = 0, $start = 0)->getNumRows();
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
            $total_rows['total_rows'] = $this->M_api->getBrand($perpage = 0, $start = 0)->getNumRows();
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


    public function getitempoint()
    {
        $headers = apache_request_headers();
        $checkOuth = $this->checkOuth($headers);
        $data = json_decode(file_get_contents('php://input'), true);
        $perpage = $data['perpage'];
        $start = $data['start'];
        if($checkOuth['err_code'] == '00'){
            $result['result'] = $this->M_api->getitempoint($perpage, $start)->getResultArray();
            $total_rows['total_rows'] = $this->M_api->getitempoint($perpage = 0, $start = 0)->getNumRows();
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

    public function historyPoint()
    {
        $headers = apache_request_headers();
        $checkOuth = $this->checkOuth($headers);
        $data = json_decode(file_get_contents('php://input'), true);
        $perpage = $data['perpage'];
        $start = $data['start'];
        $customer_id = $data['customer_id'];
        if($checkOuth['err_code'] == '00'){
            $result['result'] = $this->M_api->getHistoryPoint($perpage, $start, $customer_id)->getResultArray();
            $total_rows['total_rows'] = $this->M_api->getHistoryPoint($perpage = 0, $start = 0, $customer_id)->getNumRows();
            $err_code['err_code'] = '00';
            $data = array_merge($result, $total_rows, $err_code);
            if ($result['result'] != NULL) {
                echo json_encode($data);die();
            } else {
                $result = ['err_code' => '01', 'message' => 'Data History Point Tidak Di Temukan'];
                echo json_encode($result);die();
            }
        }else{
            $result = ['err_code' => '01', 'message' => 'Token Tidak Sesuai'];
            echo json_encode($result);die();
        }
    }


    public function exchangePoint()
    {
        $headers = apache_request_headers();
        $checkOuth = $this->checkOuth($headers);
        $data = json_decode(file_get_contents('php://input'), true);
        $perpage = $data['perpage'];
        $start = $data['start'];
        $customer_id = $data['customer_id'];
        if($checkOuth['err_code'] == '00'){
            $result['result'] = $this->M_api->getHistoryPoint($perpage, $start, $customer_id)->getResultArray();
            $total_rows['total_rows'] = $this->M_api->getHistoryPoint($perpage = 0, $start = 0, $customer_id)->getNumRows();
            $err_code['err_code'] = '00';
            $data = array_merge($result, $total_rows, $err_code);
            if ($result['result'] != NULL) {
                echo json_encode($data);die();
            } else {
                $result = ['err_code' => '01', 'message' => 'Data  Point Tidak Di Temukan'];
                echo json_encode($result);die();
            }
        }else{
            $result = ['err_code' => '01', 'message' => 'Token Tidak Sesuai'];
            echo json_encode($result);die();
        }
    }


    public function exchangePointProcess()
    {
        $headers = apache_request_headers();
        $checkOuth = $this->checkOuth($headers);
        $data = json_decode(file_get_contents('php://input'), true);
        $customer_phone = $data['customer_phone'];
        $input = [
            'customer_id'           => $data['customer_id'],
            'reward_id'             => $data['reward_id'],
            'reward_point'          => $data['reward_point'],
            'exchange_date'         => date('Y-m-d'),
            'exchange_status'       => 'pending',
            'store_id'              => 0,
            'user_id'               => 0,
        ];

        $M_point_exchange = model('M_point_exchange');
        $result['result'] = $M_point_exchange->exchangeReward($input);
        $resultdata = $this->M_api->getCustomerByPhone($customer_phone)->getResultArray();
        $point_remaining['point_remaining'] = $resultdata[0]['customer_point'];
        $data = array_merge($result, $point_remaining);
        echo json_encode($data);die();
    }
}

