<?php

namespace App\Controllers;

use App\Controllers\Base\BaseController;

class ApiPos extends BaseController
{
    private $db;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        helper('global');
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        echo "DBIG API POS VER 1.0";
    }

    public function getUpdateTime()
    {
        $data = [
            'datetime' => date('Y-m-d H:i:s')
        ];
        resultJSON($data);
    }

    // download data //
    public function saveUpdateTime($store_key)
    {
        $getStore = $this->db->table('ms_store')->where('store_api_key', $store_key)->get()->getRowArray();
        if ($getStore == null) {
            $result = ['success' => false, 'message' => 'Token tidak valid'];
        } else {
            $store_id       = $getStore['store_id'];
            $store_code     = $getStore['store_code'];
            $update_to      = $this->request->getPost('update_to');

            if ($update_to == null) {
                $result = ['success' => false, 'message' => 'Input Invalid'];
            } else {
                $M_config   = model('M_config');
                $updateData = [
                    'config_group'      => $store_code,
                    'config_subgroup'   => 'pos',
                    'config_name'       => 'last_update',
                    'config_value'      => $update_to
                ];

                $save = $M_config->updateConfig($updateData);
                if ($save) {
                    $result = ['success' => true, 'message' => '', 'store_code' => $store_code, 'data' => $updateData];
                } else {
                    $result = ['success' => false, 'message' => 'Gagal menyimpan data', 'store_code' => $store_code];
                }
            }
        }
        resultJSON($result);
    }

    public function downloadData($store_key)
    {
        $list_section = ['store_config', 'user_account', 'support_data', 'mapping_area', 'salesman', 'supplier', 'customer', 'product', 'stock', 'voucher'];
        $getStore = $this->db->table('ms_store')->where('store_api_key', $store_key)->get()->getRowArray();
        if ($getStore == null) {
            $result = ['success' => false, 'message' => 'Token tidak valid'];
        } else {
            $store_id       = $getStore['store_id'];
            $store_code     = $getStore['store_code'];
            $section        = $this->request->getGet('section') == null ? 'product' : $this->request->getGet('section');
            $update_to      = $this->request->getPost('update_to');
            $last_update    = $this->appConfig->get($store_code, 'pos', 'last_update');
            if ($update_to == null) {
                $result = ['success' => false, 'message' => 'Input Invalid'];
            } else {
                $updateData = [];
                if ($section == 'store_config') {
                    $updateData = $this->_get_update_store($update_to, $last_update);
                }

                if ($section == 'user_account') {
                    $updateData = $this->_get_update_user($update_to, $last_update);
                }

                if ($section == 'support_data') {
                    $updateData = $this->_get_update_support($update_to, $last_update);
                }

                if ($section == 'mapping_area') {
                    $updateData = $this->_get_update_mapping($update_to, $last_update);
                }

                if ($section == 'salesman') {
                    $updateData = $this->_get_update_salesman($update_to, $last_update);
                }

                if ($section == 'supplier') {
                    $updateData = $this->_get_update_supplier($update_to, $last_update);
                }

                if ($section == 'customer') {
                    $updateData = $this->_get_update_customer($update_to, $last_update);
                }

                if ($section == 'product') {
                    $updateData = $this->_get_update_product($update_to, $last_update);
                }

                if ($section == 'stock') {
                    $updateData = $this->_get_update_stock($update_to, $last_update);
                }

                if ($section == 'voucher') {
                    $updateData = $this->_get_update_voucher($update_to, $last_update);
                }

                $message = "`$store_code` update `$section` to `$update_to`";
                $result = ['success' => true, 'message' => $message, 'store_code' => $store_code, 'data' => $updateData];
            }
        }
        resultJSON($result);
    }


    private function _get_update_store($update_to, $last_update = null)
    {
        $updateData = [];
        $getUpdateMsStore = $this->db->table('ms_store');
        if ($last_update != null) {
            $getUpdateMsStore->where('updated_at>CAST("' . $last_update . '" AS DATETIME)');
        }
        $getUpdateMsStore->where('updated_at<=CAST("' . $update_to . '" AS DATETIME)');
        $updateData['ms_store'] = $getUpdateMsStore->get()->getResultArray();


        $getUpdateMsPayment = $this->db->table('ms_payment_method');
        if ($last_update != null) {
            $getUpdateMsPayment->where('updated_at>CAST("' . $last_update . '" AS DATETIME)');
        }
        $getUpdateMsPayment->where('updated_at<=CAST("' . $update_to . '" AS DATETIME)');
        $updateData['ms_payment_method'] = $getUpdateMsPayment->get()->getResultArray();


        $getUpdateConfig = $this->db->table('ms_config');
        if ($last_update != null) {
            $getUpdateConfig->where('updated_at>CAST("' . $last_update . '" AS DATETIME)');
        }
        $getUpdateConfig->where('updated_at<=CAST("' . $update_to . '" AS DATETIME)');
        $updateData['ms_config'] = $getUpdateConfig->get()->getResultArray();


        $getUpdateWarehouse = $this->db->table('ms_warehouse');
        if ($last_update != null) {
            $getUpdateWarehouse->where('updated_at>CAST("' . $last_update . '" AS DATETIME)');
        }
        $getUpdateWarehouse->where('updated_at<=CAST("' . $update_to . '" AS DATETIME)');
        $updateData['ms_warehouse'] = $getUpdateWarehouse->get()->getResultArray();


        return $updateData;
    }

    private function _get_update_user($update_to, $last_update = null)
    {
        $updateData = [];
        $getUpdateUserGroup = $this->db->table('user_group');
        if ($last_update != null) {
            $getUpdateUserGroup->where('updated_at>CAST("' . $last_update . '" AS DATETIME)');
        }
        $getUpdateUserGroup->where('updated_at<=CAST("' . $update_to . '" AS DATETIME)');
        $updateData['user_group'] = $getUpdateUserGroup->get()->getResultArray();


        $getUpdateUserRole = $this->db->table('user_role');
        if ($last_update != null) {
            $getUpdateUserRole->where('updated_at>CAST("' . $last_update . '" AS DATETIME)');
        }
        $getUpdateUserRole->where('updated_at<=CAST("' . $update_to . '" AS DATETIME)');
        $updateData['user_role'] = $getUpdateUserRole->get()->getResultArray();

        $getUpdateUser = $this->db->table('user_account');
        if ($last_update != null) {
            $getUpdateUser->where('updated_at>CAST("' . $last_update . '" AS DATETIME)');
        }
        $getUpdateUser->where('updated_at<=CAST("' . $update_to . '" AS DATETIME)');
        $updateData['user_account'] = $getUpdateUser->get()->getResultArray();

        $getUpdatePasswordControl = $this->db->table('password_control');
        if ($last_update != null) {
            $getUpdatePasswordControl->where('updated_at>CAST("' . $last_update . '" AS DATETIME)');
        }
        $getUpdatePasswordControl->where('updated_at<=CAST("' . $update_to . '" AS DATETIME)');
        $updateData['password_control'] = $getUpdatePasswordControl->get()->getResultArray();

        return $updateData;
    }

    private function _get_update_support($update_to, $last_update = null)
    {
        $updateData = [];
        $getUpdateData = $this->db->table('ms_unit');
        if ($last_update != null) {
            $getUpdateData->where('updated_at>CAST("' . $last_update . '" AS DATETIME)');
        }
        $getUpdateData->where('updated_at<=CAST("' . $update_to . '" AS DATETIME)');
        $updateData['ms_unit'] = $getUpdateData->get()->getResultArray();


        $getUpdateBrand = $this->db->table('ms_brand');
        if ($last_update != null) {
            $getUpdateBrand->where('updated_at>CAST("' . $last_update . '" AS DATETIME)');
        }
        $getUpdateBrand->where('updated_at<=CAST("' . $update_to . '" AS DATETIME)');
        $updateData['ms_brand'] = $getUpdateBrand->get()->getResultArray();


        $getUpdateCategory = $this->db->table('ms_category');
        if ($last_update != null) {
            $getUpdateCategory->where('updated_at>CAST("' . $last_update . '" AS DATETIME)');
        }
        $getUpdateCategory->where('updated_at<=CAST("' . $update_to . '" AS DATETIME)');
        $updateData['ms_category'] = $getUpdateCategory->get()->getResultArray();

        return $updateData;
    }

    private function _get_update_mapping($update_to, $last_update = null)
    {
        $updateData = [];
        $getUpdateData = $this->db->table('ms_mapping_area');
        if ($last_update != null) {
            $getUpdateData->where('updated_at>CAST("' . $last_update . '" AS DATETIME)');
        }
        $getUpdateData->where('updated_at<=CAST("' . $update_to . '" AS DATETIME)');
        $updateData['ms_mapping_area'] = $getUpdateData->get()->getResultArray();

        return $updateData;
    }

    private function _get_update_salesman($update_to, $last_update = null)
    {
        $updateData = [];
        $getUpdateData = $this->db->table('ms_salesman');
        if ($last_update != null) {
            $getUpdateData->where('updated_at>CAST("' . $last_update . '" AS DATETIME)');
        }
        $getUpdateData->where('updated_at<=CAST("' . $update_to . '" AS DATETIME)');
        $updateData['ms_salesman'] = $getUpdateData->get()->getResultArray();

        return $updateData;
    }

    private function _get_update_supplier($update_to, $last_update = null)
    {
        $updateData = [];
        $getUpdateData = $this->db->table('ms_supplier');
        if ($last_update != null) {
            $getUpdateData->where('updated_at>CAST("' . $last_update . '" AS DATETIME)');
        }
        $getUpdateData->where('updated_at<=CAST("' . $update_to . '" AS DATETIME)');
        $updateData['ms_supplier'] = $getUpdateData->get()->getResultArray();

        return $updateData;
    }

    private function _get_update_customer($update_to, $last_update = null)
    {
        $updateData = [];
        $getUpdateData = $this->db->table('ms_customer');
        if ($last_update != null) {
            $getUpdateData->where('updated_at>CAST("' . $last_update . '" AS DATETIME)');
        }
        $getUpdateData->where('updated_at<=CAST("' . $update_to . '" AS DATETIME)');
        $updateData['ms_customer'] = $getUpdateData->get()->getResultArray();

        return $updateData;
    }

    private function _get_update_product($update_to, $last_update = null)
    {
        $updateData = [];
        $getUpdateData = $this->db->table('ms_product');
        if ($last_update != null) {
            $getUpdateData->where('updated_at>CAST("' . $last_update . '" AS DATETIME)');
        }
        $getUpdateData->where('updated_at<=CAST("' . $update_to . '" AS DATETIME)');
        $updateData['ms_product'] = $getUpdateData->get()->getResultArray();


        $getProductUnit = $this->db->table('ms_product_unit');
        if ($last_update != null) {
            $getProductUnit->where('updated_at>CAST("' . $last_update . '" AS DATETIME)');
        }
        $getProductUnit->where('updated_at<=CAST("' . $update_to . '" AS DATETIME)');
        $updateData['ms_product_unit'] = $getProductUnit->get()->getResultArray();


        $getProductSupplier = $this->db->table('ms_product_supplier');
        $updateData['ms_product_supplier'] = $getProductSupplier->get()->getResultArray();


        $getProductParcel = $this->db->table('ms_product_parcel');
        if ($last_update != null) {
            $getProductParcel->where('updated_at>CAST("' . $last_update . '" AS DATETIME)');
        }
        $getProductParcel->where('updated_at<=CAST("' . $update_to . '" AS DATETIME)');
        $updateData['ms_product_parcel'] = $getProductParcel->get()->getResultArray();

        return $updateData;
    }

    private function _get_update_stock($update_to, $last_update = null)
    {
        $updateData = [];
        $getStockData = $this->db->table('ms_product_stock');
        if ($last_update != null) {
            $getStockData->where('updated_at>CAST("' . $last_update . '" AS DATETIME)');
        }
        $getStockData->where('updated_at<=CAST("' . $update_to . '" AS DATETIME)');
        $updateData['ms_product_stock'] = $getStockData->get()->getResultArray();

        return $updateData;
    }

    private function _get_update_voucher($update_to, $last_update = null)
    {
        $updateData = [];

        $getVoucherGroupData = $this->db->table('ms_voucher_group');
        if ($last_update != null) {
            $getVoucherGroupData->where('updated_at>CAST("' . $last_update . '" AS DATETIME)');
        }
        $getVoucherGroupData->where('updated_at<=CAST("' . $update_to . '" AS DATETIME)');
        $updateData['ms_voucher_group'] = $getVoucherGroupData->get()->getResultArray();

        $getBrandResData = $this->db->table('ms_voucher_brand_restriction');
        $updateData['ms_voucher_brand_restriction'] = $getBrandResData->get()->getResultArray();

        $getCategoryResData = $this->db->table('ms_voucher_category_restriction');
        $updateData['ms_voucher_category_restriction'] = $getCategoryResData->get()->getResultArray();


        $getVoucherData = $this->db->table('ms_voucher');
        if ($last_update != null) {
            $getVoucherData->where('updated_at>CAST("' . $last_update . '" AS DATETIME)');
        }
        $getVoucherData->where('updated_at<=CAST("' . $update_to . '" AS DATETIME)');
        $updateData['ms_voucher'] = $getVoucherData->get()->getResultArray();

        return $updateData;
    }

    // end download data //


    public function uploadData($store_key)
    {
        $getStore = $this->db->table('ms_store')->where('store_api_key', $store_key)->get()->getRowArray();
        if ($getStore == null) {
            $result = ['success' => false, 'message' => 'Token tidak valid'];
        } else {
            $store_id       = $getStore['store_id'];
            $store_code     = $getStore['store_code'];

            //get update data//
            $updateData['hd_pos_session']               = $this->request->getPost('hd_pos_session') == null ? [] : $this->request->getPost('hd_pos_session');
            $updateData['dt_pos_session_cash']          = $this->request->getPost('dt_pos_session_cash') == null ? [] : $this->request->getPost('dt_pos_session_cash');
            $updateData['dt_pos_session_transaction']   = $this->request->getPost('dt_pos_session_transaction') == null ? [] : $this->request->getPost('dt_pos_session_transaction');

            $updateData['hd_pos_sales']                 = $this->request->getPost('hd_pos_sales') == null ? [] : $this->request->getPost('hd_pos_sales');
            $updateData['dt_pos_sales']                 = $this->request->getPost('dt_pos_sales') == null ? [] : $this->request->getPost('dt_pos_sales');
            $updateData['dt_pos_sales_payment']         = $this->request->getPost('dt_pos_sales_payment') == null ? [] : $this->request->getPost('dt_pos_sales_payment');


            $updateData['hd_pos_sales_return']          = $this->request->getPost('hd_pos_sales_return') == null ? [] : $this->request->getPost('hd_pos_sales_return');
            $updateData['dt_pos_sales_return']          = $this->request->getPost('dt_pos_sales_return') == null ? [] : $this->request->getPost('dt_pos_sales_return');

            $updateData['log_password_control']         = $this->request->getPost('log_password_control') == null ? [] : $this->request->getPost('log_password_control');
            $updateData['last_record_number']           = $this->request->getPost('last_record_number') == null ? [] : $this->request->getPost('last_record_number');

            //$result = ['success' => true, 'message' => 'berhasil'];
            $result = $updateData;
        }
        echo var_dump($result);
        //resultJSON($result);
    }
}
