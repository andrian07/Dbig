<?php

namespace App\Controllers;

use App\Controllers\Base\BaseController;

class ApiPos extends BaseController
{
    private $db;
    private $storageSessionID = [];
    private $storageSalesID = [];
    private $storageSalesReturnID = [];
    private $logs = [];
    private $logQueries = null;

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

    private function addLog($sss)
    {
    }

    private function table(array $tbody, array $thead = [])
    {
        // All the rows in the table will be here until the end
        $tableRows = [];

        // We need only indexes and not keys
        if (!empty($thead)) {
            $tableRows[] = array_values($thead);
        }

        foreach ($tbody as $tr) {
            $tableRows[] = array_values($tr);
        }

        // Yes, it really is necessary to know this count
        $totalRows = count($tableRows);

        // Store all columns lengths
        // $all_cols_lengths[row][column] = length
        $allColsLengths = [];

        // Store maximum lengths by column
        // $max_cols_lengths[column] = length
        $maxColsLengths = [];

        // Read row by row and define the longest columns
        for ($row = 0; $row < $totalRows; $row++) {
            $column = 0; // Current column index

            foreach ($tableRows[$row] as $col) {
                // Sets the size of this column in the current row
                $allColsLengths[$row][$column] = mb_strwidth($col);

                // If the current column does not have a value among the larger ones
                // or the value of this is greater than the existing one
                // then, now, this assumes the maximum length
                if (!isset($maxColsLengths[$column]) || $allColsLengths[$row][$column] > $maxColsLengths[$column]) {
                    $maxColsLengths[$column] = $allColsLengths[$row][$column];
                }

                // We can go check the size of the next column...
                $column++;
            }
        }

        // Read row by row and add spaces at the end of the columns
        // to match the exact column length
        for ($row = 0; $row < $totalRows; $row++) {
            $column = 0;

            foreach ($tableRows[$row] as $col) {
                $diff = $maxColsLengths[$column] - mb_strwidth($col);

                if ($diff) {
                    $tableRows[$row][$column] = $tableRows[$row][$column] . str_repeat(' ', $diff);
                }

                $column++;
            }
        }

        $table = '';

        // Joins columns and append the well formatted rows to the table
        for ($row = 0; $row < $totalRows; $row++) {
            // Set the table border-top
            if ($row === 0) {
                $cols = '+';

                foreach ($tableRows[$row] as $col) {
                    $cols .= str_repeat('-', mb_strwidth($col) + 2) . '+';
                }
                $table .= $cols . PHP_EOL;
            }

            // Set the columns borders
            $table .= '| ' . implode(' | ', $tableRows[$row]) . ' |' . PHP_EOL;

            // Set the thead and table borders-bottom
            if (isset($cols) && (($row === 0 && !empty($thead)) || ($row + 1 === $totalRows))) {
                $table .= $cols . PHP_EOL;
            }
        }

        $this->logs[] = $table;
    }


    private function create_upsert_query($table = '', $fieldData = [])
    {
        $fields = [];
        $values = [];
        $onDuplicateKeyUpdate = [];

        foreach ($fieldData as $rows) {
            $fields                 = [];
            $rowValues              = [];
            $onDuplicateKeyUpdate   = [];

            foreach ($rows as $field_name => $field_value) {
                $fields[]               = $field_name;
                $onDuplicateKeyUpdate[] = "$field_name=VALUES($field_name)";
                if ($field_value == null) {
                    $rowValues[]            = "''";
                } else {
                    $rowValues[]            = "'" . $this->db->escapeString($field_value) . "'";
                }
            }

            $values[] = "(" . implode(',', $rowValues) . ")";
        }

        return "INSERT INTO " . $table . "(" . implode(',', $fields) . ") VALUES" . implode(',', $values) . " ON DUPLICATE KEY UPDATE " . implode(',', $onDuplicateKeyUpdate);
    }

    public function getUpdateTime($store_key)
    {
        $last_update = null;
        $getStore = $this->db->table('ms_store')->where('store_api_key', $store_key)->get()->getRowArray();
        if ($getStore == null) {
            $result = ['success' => false, 'message' => 'Token tidak valid'];
        } else {
            $store_id       = $getStore['store_id'];
            $store_code     = $getStore['store_code'];
            $M_config       = model('M_config');
            $getLastUpdate  = $M_config->getConfig($store_code,  'pos', 'last_update')->getRowArray();
            $last_update    = $getLastUpdate == null ? null : $getLastUpdate['config_value'];
            $result = [
                'success'           => true,
                'last_update'       => $last_update,
                'current_datetime'  => date('Y-m-d H:i:s')
            ];
        }
        resultJSON($result);
    }

    // post to acccounting //
    public function postToAccounting()
    {
        $result = ['success' => true, 'message' => 'Posting Berhasil!'];
        $getHdPosSession = $this->db->table('hd_pos_session')
            ->select('hd_pos_session.*,user_account.user_realname,ms_store.store_code')
            ->join('user_account', 'user_account.user_id=hd_pos_session.user_id')
            ->join('ms_store', 'ms_store.store_id=hd_pos_session.store_id')
            ->where('hd_pos_session.closed', 'Y')
            ->where('hd_pos_session.posted', 'N')
            ->get()
            ->getResultArray();
        if (count($getHdPosSession) > 0) {
            $list_post_session_key = [];
            $postData = [];
            $samplePostData = [
                'session_key' => [
                    'user_id'       => 1,
                    'user_realname' => 'Eric',
                    'post_date'     => '2023-03-10',
                    'store_id'      => 1,
                    'store_code'    => 'UTM',
                    'sales' => [
                        'sales_total'       => 10000,
                        'sales_no_tax'      => 2000,
                        'sales_has_tax'     => 7000,
                        'tax_out'           => 1000,
                        'sales_cogs'        => 6000,
                        'margin_allocation' => 3000,
                        'payments'          => [
                            'CASH'  => ['payment_method_id' => 1, 'payment_balance' => 8000],
                            'BCA'   => ['payment_method_id' => 2, 'payment_balance' => 2000]
                        ]
                    ],
                    'sales_return' => [
                        'sales_return_total'        => 4000,
                        'sales_return_no_tax'       => 0,
                        'sales_return_has_tax'      => 3500,
                        'sales_return_tax_out'      => 500,
                        'sales_return_cogs'         => 1800,
                    ],
                ]
            ];

            foreach ($getHdPosSession as $hdSession) {
                $session_id     = intval($hdSession['session_id']);
                $session_key    = $hdSession['session_key'];
                $user_id        = $hdSession['user_id'];
                $user_realname  = $hdSession['user_realname'];
                $store_id       = intval($hdSession['store_id']);
                $store_code     = $hdSession['store_code'];
                $post_date      = date('Y-m-d');
                $list_post_session_key[] = $session_key;


                $getItemSales = $this->db->table('dt_pos_session_transaction')
                    ->select('dt_pos_sales.*,ms_product.product_name,ms_product.has_tax')
                    ->join('dt_pos_sales', 'dt_pos_sales.pos_sales_id=dt_pos_session_transaction.transaction_id')
                    ->join('ms_product_unit', 'ms_product_unit.item_id=dt_pos_sales.item_id')
                    ->join('ms_product', 'ms_product.product_id=ms_product_unit.product_id')

                    ->where('dt_pos_session_transaction.transaction_type', 'SI')
                    ->where('dt_pos_session_transaction.session_id', $session_id)
                    ->get()
                    ->getResultArray();

                $sales_cogs                 = 0;
                $sales_no_tax               = 0;
                $sales_has_tax              = 0;
                $sales_margin_allocation    = 0;
                $tax_out                    = 0;

                foreach ($getItemSales as $item) {
                    $product_cogs       = floatval($item['product_cogs']);
                    $sales_qty          = floatval($item['sales_qty']);
                    $sales_price        = floatval($item['sales_price']);
                    $margin_allocation  = floatval($item['margin_allocation']);

                    $sales_cogs += $sales_qty * $product_cogs;
                    $sales_margin_allocation += $sales_qty * $margin_allocation;
                    if ($item['has_tax'] == 'Y') {
                        $sales_has_tax += $sales_qty * $sales_price;
                    } else {
                        $sales_no_tax += $sales_qty * $sales_price;
                    }
                }

                if ($sales_has_tax > 0) {
                    $extract_no_tax = $sales_has_tax / 1.11;
                    $tax_out = $sales_has_tax - $extract_no_tax;
                    $sales_has_tax = $extract_no_tax;
                }

                $payments = [];
                $getPayment = $this->db->table('dt_pos_session_transaction')
                    ->select('dt_pos_sales_payment.payment_method_id,ms_payment_method.payment_method_name,SUM(dt_pos_sales_payment.payment_balance) AS payment_balance')
                    ->join('dt_pos_sales_payment', 'dt_pos_sales_payment.pos_sales_id=dt_pos_session_transaction.transaction_id')
                    ->join('ms_payment_method', 'ms_payment_method.payment_method_id=dt_pos_sales_payment.payment_method_id')

                    ->where('dt_pos_session_transaction.transaction_type', 'SI')
                    ->where('dt_pos_session_transaction.session_id', $session_id)
                    ->groupBy('dt_pos_sales_payment.payment_method_id')
                    ->get()
                    ->getResultArray();
                foreach ($getPayment as $pay) {
                    $_pay_name = $pay['payment_method_name'];
                    $payments[$_pay_name] = [
                        'payment_method_id' => intval($pay['payment_method_id']),
                        'payment_balance'   => floatval($pay['payment_balance'])
                    ];
                }


                $total_change = 0;
                $getSales = $this->db->table('dt_pos_session_transaction')
                    ->select('hd_pos_sales.*,(hd_pos_sales.pos_total_payment-hd_pos_sales.pos_sales_total) as payment_change')
                    ->join('hd_pos_sales', 'hd_pos_sales.pos_sales_id=dt_pos_session_transaction.transaction_id')
                    ->where('dt_pos_session_transaction.transaction_type', 'SI')
                    ->where('dt_pos_session_transaction.session_id', $session_id)
                    ->get()
                    ->getResultArray();

                foreach ($getSales as $sales) {
                    $payment_change = floatval($sales['payment_change']);
                    if ($payment_change > 0) {
                        $total_change += $payment_change;
                    }
                }

                if ($total_change > 0) {
                    $cash_balance                           = $payments['CASH']['payment_balance'];
                    $payments['CASH']['payment_balance']    = $cash_balance - $total_change;
                }

                $sales_total = $sales_no_tax + $sales_has_tax + $tax_out;
                $salesData = [
                    'sales_total'       => $sales_total,
                    'sales_no_tax'      => $sales_no_tax,
                    'sales_has_tax'     => $sales_has_tax,
                    'tax_out'           => $tax_out,
                    'sales_cogs'        => $sales_cogs,
                    'margin_allocation' => $sales_margin_allocation,
                    'payments'          => $payments
                ];

                $sales_return_cogs          = 0;
                $sales_return_no_tax        = 0;
                $sales_return_has_tax       = 0;
                $sales_return_tax_out       = 0;

                $getItemSalesReturn = $this->db->table('dt_pos_session_transaction')
                    ->select('dt_pos_sales_return.*,ms_product.product_name,ms_product.has_tax')
                    ->join('dt_pos_sales_return', 'dt_pos_sales_return.pos_sales_return_id=dt_pos_session_transaction.transaction_id')
                    ->join('ms_product_unit', 'ms_product_unit.item_id=dt_pos_sales_return.item_id')
                    ->join('ms_product', 'ms_product.product_id=ms_product_unit.product_id')

                    ->where('dt_pos_session_transaction.transaction_type', 'SR')
                    ->where('dt_pos_session_transaction.session_id', $session_id)
                    ->get()
                    ->getResultArray();

                foreach ($getItemSalesReturn as $item) {
                    $product_cogs       = floatval($item['product_cogs']);
                    $sales_return_qty   = floatval($item['sales_return_qty']);
                    $sales_return_price = floatval($item['sales_return_price']);

                    $sales_return_cogs += $sales_return_qty * $product_cogs;
                    if ($item['has_tax'] == 'Y') {
                        $sales_return_has_tax += $sales_return_qty * $sales_return_price;
                    } else {
                        $sales_return_no_tax += $sales_return_qty * $sales_return_price;
                    }
                }

                if ($sales_return_has_tax > 0) {
                    $extract_no_tax         = $sales_return_has_tax / 1.11;
                    $sales_return_tax_out   = $sales_return_has_tax - $extract_no_tax;
                    $sales_return_has_tax   = $extract_no_tax;
                }

                $sales_return_total = $sales_return_no_tax + $sales_return_has_tax + $sales_return_tax_out;
                $salesReturnData = [
                    'sales_return_total'        => $sales_return_total,
                    'sales_return_no_tax'       => $sales_return_no_tax,
                    'sales_return_has_tax'      => $sales_return_has_tax,
                    'sales_return_tax_out'      => $sales_return_tax_out,
                    'sales_return_cogs'         => $sales_return_cogs,
                ];



                $postData[$session_key] = [
                    'user_id'       => $user_id,
                    'user_realname' => $user_realname,
                    'post_date'     => $post_date,
                    'store_id'      => $store_id,
                    'store_code'    => $store_code,
                    'sales'         => $salesData,
                    'sales_return'  => $salesReturnData
                ];
            }

            $urlOffline = 'http://localhost:8989/';
            $urlOnline = 'https://dbigaccounting.borneoeternityswiftlet.co.id/';
            $client = \Config\Services::curlrequest([
                'baseURI' => $urlOnline,
            ]);

            $accountingApiUri = 'api-accounting/api-pos-sales';
            $postUpdate = $client->request('POST', $accountingApiUri, [
                'form_params' => [
                    'pos_data' => json_encode($postData)
                ],
            ]);

            $status_code    = $postUpdate->getStatusCode();
            $status_reason  = $postUpdate->getReason();
            if ($status_code == 200) {
                $contents = json_decode($postUpdate->getBody(), true);
                if ($contents['success']) {
                    $this->db->table('hd_pos_session')
                        ->set('posted', 'Y')
                        ->whereIn('session_key', $list_post_session_key)
                        ->update();
                }

                $result = ['success' => true, 'message' => 'Posting Berhasil'];
            } else {
                $result = ['success' => false, 'message' => 'Gagal terhubung ke server'];
            }
        }
        resultJSON($result);
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
        $getProduct  = $getUpdateData->get()->getResultArray();
        $listProduct = [];

        foreach ($getProduct as $productData) {
            $noImage  = base_url('assets/images/no-image.PNG');
            $productData['thumb_url'] = getImage($productData['product_image'], 'product', TRUE, $noImage);
            $productData['image_url'] = getImage($productData['product_image'], 'product', FALSE, $noImage);
            $listProduct[] = $productData;
        }

        $updateData['ms_product'] = $listProduct;


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
            $dsHdPosSession                 = $this->request->getPost('hd_pos_session') == null ? [] : json_decode($this->request->getPost('hd_pos_session'), true);
            $dsDtPosSessionCash             = $this->request->getPost('dt_pos_session_cash') == null ? [] : json_decode($this->request->getPost('dt_pos_session_cash'), true);
            $dsDtPosSessionTransaction      = $this->request->getPost('dt_pos_session_transaction') == null ? [] : json_decode($this->request->getPost('dt_pos_session_transaction'), true);

            $dsHdPosSales                   = $this->request->getPost('hd_pos_sales') == null ? [] : json_decode($this->request->getPost('hd_pos_sales'), true);
            $dsDtPosSales                   = $this->request->getPost('dt_pos_sales') == null ? [] : json_decode($this->request->getPost('dt_pos_sales'), true);
            $dsDtPosSalesPayment            = $this->request->getPost('dt_pos_sales_payment') == null ? [] : json_decode($this->request->getPost('dt_pos_sales_payment'), true);

            $dsHdPosSalesReturn             = $this->request->getPost('hd_pos_sales_return') == null ? [] : json_decode($this->request->getPost('hd_pos_sales_return'), true);
            $dsDtPosSalesReturn             = $this->request->getPost('dt_pos_sales_return') == null ? [] : json_decode($this->request->getPost('dt_pos_sales_return'), true);

            $dsLogPasswordControl           = $this->request->getPost('log_password_control') == null ? [] : json_decode($this->request->getPost('log_password_control'), true);
            $dsLastRecordNumber             = $this->request->getPost('last_record_number') == null ? [] : json_decode($this->request->getPost('last_record_number'), true);

            // for devonly //
            $postData = [
                'hd_pos_session'                => $dsHdPosSession,
                'dt_pos_session_cash'           => $dsDtPosSessionCash,
                'dt_pos_session_transaction'    => $dsDtPosSessionTransaction,
                'hd_pos_sales'                  => $dsHdPosSales,
                'dt_pos_sales'                  => $dsDtPosSales,
                'dt_pos_sales_payment'          => $dsDtPosSalesPayment,
                'hd_pos_sales_return'           => $dsHdPosSalesReturn,
                'dt_pos_sales_return'           => $dsDtPosSalesReturn,
                'log_password_control'          => $dsLogPasswordControl,
                'last_record_number'            => $dsLastRecordNumber
            ];

            $this->db->transBegin();
            $this->_update_data($dsLogPasswordControl, $dsLastRecordNumber);
            $this->_update_pos_sales($dsHdPosSales, $dsDtPosSales, $dsDtPosSalesPayment);
            $this->_update_pos_sales_return($dsHdPosSalesReturn, $dsDtPosSalesReturn);
            $this->_update_pos_session($dsHdPosSession, $dsDtPosSessionCash, $dsDtPosSessionTransaction);

            if ($this->db->transStatus() === false) {
                $this->db->transRollback();
                $result = ['success' => false, 'message' => 'Upload data gagal'];
            } else {
                $this->db->transCommit();

                $file_path = WRITEPATH . 'api_logs/' . date('Y-m-d_His') . '_upload_data.txt';
                $logger = new \App\Libraries\Logger($file_path);

                $logger->AddRow('Post Data:');
                $logger->AddRow(json_encode($postData));
                $logQueries = json_encode($this->logQueries);
                $logger->AddRow('Run Query:');
                $logger->AddRow($logQueries);


                $logger->Commit();

                $result = ['success' => true, 'message' => 'Upload data berhasil'];
            }
        }
        resultJSON($result);
    }

    private function _get_session_id($session_key)
    {
        $session_id = 0;
        if (isset($this->storageSessionID[$session_key])) {
            $session_id = $this->storageSessionID[$session_key];
        } else {
            $getSessionID = $this->db->table('hd_pos_session')->select('session_id')->where('session_key', $session_key)->get()->getRowArray();
            if ($getSessionID != null) {
                $session_id                             = intval($getSessionID['session_id']);
                $this->storageSessionID[$session_key]   = $session_id;
            }
        }

        return $session_id;
    }

    private function _get_sales_id($pos_sales_invoice)
    {

        $sales_id = 0;
        if (isset($this->storageSalesID[$pos_sales_invoice])) {
            $sales_id = $this->storageSalesID[$pos_sales_invoice];
        } else {
            $getSalesID = $this->db->table('hd_pos_sales')->select('pos_sales_id')->where('pos_sales_invoice', $pos_sales_invoice)->get()->getRowArray();
            if ($getSalesID != null) {
                $sales_id                                   = intval($getSalesID['pos_sales_id']);
                $this->storageSalesID[$pos_sales_invoice]   = $sales_id;
            }
        }

        return $sales_id;
    }

    private function _get_sales_return_id($pos_sales_return_invoice)
    {
        $sales_return_id = 0;
        if (isset($this->storageSalesReturnID[$pos_sales_return_invoice])) {
            $sales_return_id = $this->storageSalesReturnID[$pos_sales_return_invoice];
        } else {
            $getSalesReturnID = $this->db->table('hd_pos_sales_return')->select('pos_sales_return_id')->where('pos_sales_return_invoice', $pos_sales_return_invoice)->get()->getRowArray();
            if ($getSalesReturnID != null) {
                $sales_return_id                                            = intval($getSalesReturnID['pos_sales_return_id']);
                $this->storageSalesReturnID[$pos_sales_return_invoice]      = $sales_return_id;
            }
        }

        return $sales_return_id;
    }

    private function _update_pos_session($dsHdPosSession, $dsDtPosSessionCash, $dsDtPosSessionTransaction)
    {
        // hd_pos_session
        if (count($dsHdPosSession) > 0) {
            $hdPosSessionData = [];
            foreach ($dsHdPosSession as $row) {
                $sessionData = [
                    'session_key'       => $row['session_key'],
                    'store_id'          => $row['store_id'],
                    'open_balance'      => $row['open_balance'],
                    'close_balance'     => $row['close_balance'],
                    'close_at'          => $row['close_at'],
                    'closed'            => $row['closed'],
                    'session_remark'    => $row['session_remark'],
                    'user_id'           => $row['user_id'],
                    'created_at'        => $row['created_at'],
                    'updated_at'        => $row['updated_at'],
                ];
                $hdPosSessionData[] = $sessionData;
            }
            $qUpdateHdPosSession = $this->create_upsert_query('hd_pos_session', $hdPosSessionData);
            $this->db->query($qUpdateHdPosSession);
            if ($this->db->affectedRows() > 0) {
                $this->logQueries[] = $this->db->getLastQuery()->getQuery();
            }
        }

        // dt_pos_session_cash
        if (count($dsDtPosSessionCash) > 0) {
            $dtCashSessionData = [];
            foreach ($dsDtPosSessionCash as $row) {
                $session_key    = $row['session_key'];
                $session_id     = $this->_get_session_id($session_key);

                $dtCashSessionData[] = [
                    'session_id'    => $session_id,
                    'cash_balance'  => $row['cash_balance'],
                    'cash_type'     => $row['cash_type'],
                    'cash_remark'   => $row['cash_remark'],
                    'created_at'    => $row['created_at'],
                ];
            }
            $qUpdateDtPosSessionCash = $this->create_upsert_query('dt_pos_session_cash', $dtCashSessionData);
            $this->db->query($qUpdateDtPosSessionCash);
            if ($this->db->affectedRows() > 0) {
                $this->logQueries[] = $this->db->getLastQuery()->getQuery();
            }
        }


        // dt_pos_session_transaction
        if (count($dsDtPosSessionTransaction) > 0) {
            $dtTransSessionData = [];
            foreach ($dsDtPosSessionTransaction as $row) {
                $session_key        = $row['session_key'];
                $session_id         = $this->_get_session_id($session_key);

                $transaction_code   = $row['transaction_code'];
                $transaction_id     = $row['transaction_type'] == 'SI' ? $this->_get_sales_id($transaction_code) : $this->_get_sales_return_id($transaction_code);

                $dtTransSessionData[] = [
                    'session_id'        => $session_id,
                    'transaction_id'    => $transaction_id,
                    'transaction_type'  => $row['transaction_type'],
                    'created_at'        => $row['created_at']
                ];
            }
            $qUpdateDtPosSessionTrans = $this->create_upsert_query('dt_pos_session_transaction', $dtTransSessionData);
            $this->db->query($qUpdateDtPosSessionTrans);
            if ($this->db->affectedRows() > 0) {
                $this->logQueries[] = $this->db->getLastQuery()->getQuery();
            }
        }
    }

    private function _update_pos_sales($dsHdPosSales, $dsDtPosSales, $dsDtPosSalesPayment)
    {
        $warehouse_id       = 0;
        $voucher_payment_id = 2;


        foreach ($dsHdPosSales as $row) {
            $pos_sales_invoice = $row['pos_sales_invoice'];
            $hdSalesData = [
                'pos_sales_invoice'             => $row['pos_sales_invoice'],
                'pos_sales_date'                => $row['pos_sales_date'],
                'pos_sales_type'                => $row['pos_sales_type'],
                'customer_id'                   => $row['customer_id'],
                'customer_group'                => $row['customer_group'],
                'store_id'                      => $row['store_id'],
                'warehouse_id'                  => $row['warehouse_id'],
                'pos_sales_remark'              => $row['pos_sales_remark'],
                'pos_sales_total'               => $row['pos_sales_total'],
                'pos_total_payment'             => $row['pos_total_payment'],
                'pos_total_margin_allocation'   => $row['pos_total_margin_allocation'],
                'customer_initial_point'        => $row['customer_initial_point'],
                'customer_add_point'            => $row['customer_add_point'],
                'payment_list'                  => $row['payment_list'],
                'payment_remark'                => $row['payment_remark'],
                'user_id'                       => $row['user_id'],
                'has_sales_return'              => $row['has_sales_return'],
                'pos_sales_cancel'              => $row['pos_sales_cancel'],
                'created_at'                    => $row['created_at'],
                'updated_at'                    => $row['updated_at'],
            ];

            $warehouse_id = intval($row['warehouse_id']);

            $getSales =  $this->db->table('hd_pos_sales')->where('pos_sales_invoice', $pos_sales_invoice)->get()->getRowArray();
            if ($getSales == null) {
                // insert to sales and update point //
                $this->db->table('hd_pos_sales')->insert($hdSalesData);
                if ($this->db->affectedRows() > 0) {
                    $this->logQueries[] = $this->db->getLastQuery()->getQuery();
                }
                $pos_sales_id       = $this->db->insertID();
                $this->storageSalesID[$pos_sales_invoice]   = $pos_sales_id;

                $customer_add_point = floatval($row['customer_add_point']);
                if ($customer_add_point > 0) {
                    $this->db->table('ms_customer')->set('customer_point', 'customer_point+' . $customer_add_point, false)->where('customer_id', $row['customer_id'])->update();
                    if ($this->db->affectedRows() > 0) {
                        $this->logQueries[] = $this->db->getLastQuery()->getQuery();
                    }

                    $history_point = [
                        'customer_id'       => $row['customer_id'],
                        'log_point_remark'  => 'Belanja Rp ' . numberFormat($row['pos_sales_total']),
                        'customer_point'    => $customer_add_point

                    ];
                    $this->db->table('customer_history_point')->insert($history_point);
                    if ($this->db->affectedRows() > 0) {
                        $this->logQueries[] = $this->db->getLastQuery()->getQuery();
                    }
                }
            } else {
                $pos_sales_id                               = intval($getSales['pos_sales_id']);
                $this->storageSalesID[$pos_sales_invoice]   = $pos_sales_id;

                $this->db->table('hd_pos_sales')->where('pos_sales_id', $pos_sales_id)->update($hdSalesData);
                if ($this->db->affectedRows() > 0) {
                    $this->logQueries[] = $this->db->getLastQuery()->getQuery();
                }
            }
        }

        $reduceStock = [];
        // $reduceStock = [
        //     'P0001' => ['product_id' => 1 ,'stock'=>10],
        //     'P0002' => ['product_id' => 2 ,'stock'=>100]
        // ];

        foreach ($dsDtPosSales as $row) {
            $pos_sales_id       = $this->_get_sales_id($row['pos_sales_invoice']);
            $item_id            = $row['item_id'];
            $sales_qty          = floatval($row['sales_qty']);
            $product_cogs       = floatval($row['product_cogs']);
            $purchase_price     = floatval($row['purchase_price']);
            $product_price      = floatval($row['product_price']);
            $disc               = floatval($row['disc']);
            $price_disc         = floatval($row['price_disc']);
            $sales_price        = floatval($row['sales_price']);
            $sales_dpp          = floatval($row['sales_dpp']);
            $sales_ppn          = floatval($row['sales_ppn']);
            $margin_allocation  = floatval($row['margin_allocation']);
            $salesman_id        = $row['salesman_id'];

            $getDetail      = $this->db->table('dt_pos_sales')
                ->select('detail_id')
                ->where('pos_sales_id', $pos_sales_id)
                ->where('item_id', $item_id)
                ->get()
                ->getRowArray();

            if ($getDetail == null) {
                $getProduct = $this->db->table('ms_product_unit')
                    ->select('ms_product.product_code,ms_product_unit.product_id,ms_product_unit.product_content,ms_product.is_parcel')
                    ->join('ms_product', 'ms_product.product_id=ms_product_unit.product_id')
                    ->where('ms_product_unit.item_id', $item_id)
                    ->get()
                    ->getRowArray();

                $product_code       = $getProduct['product_code'];
                $product_id         = $getProduct['product_id'];
                $product_content    = floatval($getProduct['product_content']);
                if ($getProduct['is_parcel'] == 'N') {
                    $stock = $sales_qty * $product_content;
                    if (isset($reduceStock[$product_code])) {
                        $reduceStock[$product_code]['stock'] += $stock;
                    } else {
                        $reduceStock[$product_code] = [
                            'product_id'    => $product_id,
                            'stock'         => $stock,
                        ];
                    }
                } else {
                    $getParcelItem = $this->db->table('ms_product_parcel')
                        ->select('ms_product_parcel.product_id as parcel_id,ms_product.product_code,ms_product_unit.product_id,ms_product_unit.product_content,ms_product_parcel.item_qty')
                        ->join('ms_product_unit', 'ms_product_unit.item_id=ms_product_parcel.item_id')
                        ->join('ms_product', 'ms_product.product_id=ms_product_unit.product_id')
                        ->where('ms_product_parcel.product_id', $product_id)
                        ->get()
                        ->getResultArray();
                    foreach ($getParcelItem as $parcelItem) {
                        $item_product_id        = $parcelItem['product_id'];
                        $item_product_code      = $parcelItem['product_code'];
                        $item_product_content   = floatval($parcelItem['product_content']);
                        $item_qty               = $parcelItem['item_qty'];
                        $stock                  = $sales_qty * ($item_product_content * $item_qty);
                        if (isset($reduceStock[$item_product_code])) {
                            $reduceStock[$item_product_code]['stock'] += $stock;
                        } else {
                            $reduceStock[$item_product_code] = [
                                'product_id'    => $item_product_id,
                                'stock'         => $stock,
                            ];
                        }
                    }
                }

                $detailData = [
                    'pos_sales_id'      => $pos_sales_id,
                    'item_id'           => $item_id,
                    'sales_qty'         => $sales_qty,
                    'product_cogs'      => $product_cogs,
                    'purchase_price'    => $purchase_price,
                    'product_price'     => $product_price,
                    'disc'              => $disc,
                    'price_disc'        => $price_disc,
                    'sales_price'       => $sales_price,
                    'sales_dpp'         => $sales_dpp,
                    'sales_ppn'         => $sales_ppn,
                    'margin_allocation' => $margin_allocation,
                    'salesman_id'       => $salesman_id
                ];

                $this->db->table('dt_pos_sales')->insert($detailData);
                if ($this->db->affectedRows() > 0) {
                    $this->logQueries[] = $this->db->getLastQuery()->getQuery();
                }
            }
        }

        if (count($reduceStock) > 0) {
            // update ms_product_stock //
            $qUpdateStock       = "INSERT INTO ms_product_stock(product_id,warehouse_id,stock) VALUES";
            $vUpdateStock       = [];
            $warehouseStockData = [];

            foreach ($reduceStock as $row) {
                $product_id     = $row['product_id'];
                $stock          = $row['stock'];
                $reduce_stock   = (-1 * $row['stock']);
                $vUpdateStock[] = "('$product_id','$warehouse_id',$reduce_stock)";

                // update warehouse_stock //
                $getWarehouseStock = $this->db->table('ms_warehouse_stock')
                    ->select('stock_id,stock')
                    ->where('product_id', $product_id)
                    ->where('warehouse_id', $warehouse_id)
                    ->orderBy('stock_id', 'asc')
                    ->get()
                    ->getResultArray();
                foreach ($getWarehouseStock as $ws) {
                    if ($stock > 0) {
                        $ws_stock_id    = $ws['stock_id'];
                        $ws_stock       = floatval($ws['stock']);
                        $ws_new_stock   = 0;
                        // ws_stock = 12 <= 10 
                        if ($ws_stock <= $stock) {
                            $ws_new_stock = 0;
                            $stock =  $stock - $ws_stock;
                        } else {
                            $ws_new_stock = $ws_stock - $stock;
                            $stock = 0;
                        }
                        $warehouseStockData[] = [
                            'stock_id'  => $ws_stock_id,
                            'product_id' => $product_id,
                            'stock'     => $ws_new_stock
                        ];
                    }
                }
            }

            $qUpdateStock .= implode(',', $vUpdateStock) . " ON DUPLICATE KEY UPDATE stock=stock+VALUES(stock)";

            $this->db->query($qUpdateStock);
            if ($this->db->affectedRows() > 0) {
                $this->logQueries[] = $this->db->getLastQuery()->getQuery();
            }

            if (count($warehouseStockData) > 0) {
                $qUpdateWarehouseStock = $this->create_upsert_query('ms_warehouse_stock', $warehouseStockData);

                $this->db->query($qUpdateWarehouseStock);
                if ($this->db->affectedRows() > 0) {
                    $this->logQueries[] = $this->db->getLastQuery()->getQuery();
                }
            }
        }
        foreach ($dsDtPosSalesPayment as $row) {
            $pos_sales_id       = $this->_get_sales_id($row['pos_sales_invoice']);
            $payment_method_id  = intval($row['payment_method_id']);
            $dataPayment = [
                'pos_sales_id'          => $pos_sales_id,
                'payment_method_id'     => $payment_method_id,
                'payment_card_number'   => $row['payment_card_number'],
                'payment_appr_code'     => $row['payment_appr_code'],
                'payment_balance'       => $row['payment_balance'],
                'payment_remark'        => $row['payment_remark'],
            ];

            $checkPayment = $this->db->table('dt_pos_sales_payment')
                ->where('pos_sales_id', $pos_sales_id)
                ->where('payment_method_id', $payment_method_id)
                ->where('payment_card_number', $row['payment_card_number'])
                ->get()
                ->getRowArray();

            if ($checkPayment == null) {
                $this->db->table('dt_pos_sales_payment')->insert($dataPayment);
                if ($this->db->affectedRows() > 0) {
                    $this->logQueries[] = $this->db->getLastQuery()->getQuery();
                }
            }

            if ($payment_method_id == $voucher_payment_id) {
                $customer_id            = $row['customer_id'];
                $voucher_code           = $row['payment_card_number'];
                $update_voucher_data    = [
                    'voucher_status'    => 'used',
                    'used_by'           => $customer_id,
                    'used_at'           => $row['created_at']
                ];
                $this->db->table('ms_voucher')->set($update_voucher_data)->where('voucher_code', $voucher_code)->update();
                if ($this->db->affectedRows() > 0) {
                    $this->logQueries[] = $this->db->getLastQuery()->getQuery();
                }
            }
        }
    }

    private function _update_pos_sales_return($dsHdPosSalesReturn, $dsDtPosSalesReturn)
    {
        $warehouse_id = 0;

        foreach ($dsHdPosSalesReturn as $row) {
            $pos_sales_return_invoice           = $row['pos_sales_return_invoice'];
            $pos_sales_invoice                  = $row['pos_sales_invoice'];
            $pos_sales_id                       = $this->_get_sales_id($pos_sales_invoice);
            $hdSalesReturnData = [
                'pos_sales_return_invoice'      => $row['pos_sales_return_invoice'],
                'pos_sales_return_date'         => $row['pos_sales_return_date'],
                'pos_sales_id'                  => $pos_sales_id,
                'customer_id'                   => $row['customer_id'],
                'store_id'                      => $row['store_id'],
                'warehouse_id'                  => $row['warehouse_id'],
                'pos_sales_return_remark'       => $row['pos_sales_return_remark'],
                'pos_sales_return_total'        => $row['pos_sales_return_total'],
                'customer_initial_point'        => $row['customer_initial_point'],
                'customer_reduce_point'         => $row['customer_reduce_point'],
                'payment_list'                  => $row['payment_list'],
                'payment_remark'                => $row['payment_remark'],
                'user_id'                       => $row['user_id'],
                'pos_sales_return_cancel'       => $row['pos_sales_return_cancel'],
                'created_at'                    => $row['created_at'],
                'updated_at'                    => $row['updated_at'],
            ];

            $warehouse_id = intval($row['warehouse_id']);

            $getSalesReturn =  $this->db->table('hd_pos_sales_return')->where('pos_sales_return_invoice', $pos_sales_return_invoice)->get()->getRowArray();
            if ($getSalesReturn == null) {
                // insert to sales and update point //
                $this->db->table('hd_pos_sales_return')->insert($hdSalesReturnData);
                if ($this->db->affectedRows() > 0) {
                    $this->logQueries[] = $this->db->getLastQuery()->getQuery();
                }
                $pos_sales_return_id       = $this->db->insertID();
                $this->storageSalesReturnID[$pos_sales_return_invoice] = $pos_sales_return_id;


                $customer_reduce_point = floatval($row['customer_reduce_point']);
                if ($customer_reduce_point > 0) {
                    $this->db->table('ms_customer')->set('customer_point', 'customer_point-' . $customer_reduce_point, false)->where('customer_id', $row['customer_id'])->update();
                    if ($this->db->affectedRows() > 0) {
                        $this->logQueries[] = $this->db->getLastQuery()->getQuery();
                    }

                    $history_point = [
                        'customer_id'       => $row['customer_id'],
                        'log_point_remark'  => 'Retur belanja Rp ' . numberFormat($row['pos_sales_return_total']),
                        'customer_point'    => ($customer_reduce_point * -1)

                    ];
                    $this->db->table('customer_history_point')->insert($history_point);
                    if ($this->db->affectedRows() > 0) {
                        $this->logQueries[] = $this->db->getLastQuery()->getQuery();
                    }
                }
            } else {
                $pos_sales_return_id    = intval($getSalesReturn['pos_sales_return_id']);
                $this->storageSalesReturnID[$pos_sales_return_invoice]   = $pos_sales_return_id;

                $this->db->table('hd_pos_sales_return')->where('pos_sales_return_id', $pos_sales_return_id)->update($hdSalesReturnData);

                if ($this->db->affectedRows() > 0) {
                    $this->logQueries[] = $this->db->getLastQuery()->getQuery();
                }
            }
        }

        $addStock = [];
        // $addStock = [
        //     'P0001' => ['product_id' => 1 ,'stock'=>10],
        //     'P0002' => ['product_id' => 2 ,'stock'=>100]
        // ];

        foreach ($dsDtPosSalesReturn as $row) {
            $pos_sales_return_id = $this->_get_sales_return_id($row['pos_sales_return_invoice']);
            $item_id            = $row['item_id'];
            $sales_return_qty   = floatval($row['sales_return_qty']);
            $product_cogs       = floatval($row['product_cogs']);
            $purchase_price     = floatval($row['purchase_price']);
            $product_price      = floatval($row['product_price']);
            $disc               = floatval($row['disc']);
            $price_disc         = floatval($row['price_disc']);
            $sales_return_price = floatval($row['sales_return_price']);
            $sales_return_dpp   = floatval($row['sales_return_dpp']);
            $sales_return_ppn   = floatval($row['sales_return_ppn']);
            $margin_allocation  = floatval($row['margin_allocation']);


            $getDetail      = $this->db->table('dt_pos_sales_return')
                ->select('detail_id')
                ->where('pos_sales_return_id', $pos_sales_return_id)
                ->where('item_id', $item_id)
                ->get()
                ->getRowArray();

            if ($getDetail == null) {
                $getProduct = $this->db->table('ms_product_unit')
                    ->select('ms_product.product_code,ms_product_unit.product_id,ms_product_unit.product_content,ms_product.is_parcel')
                    ->join('ms_product', 'ms_product.product_id=ms_product_unit.product_id')
                    ->where('ms_product_unit.item_id', $item_id)
                    ->get()
                    ->getRowArray();

                $product_code       = $getProduct['product_code'];
                $product_id         = $getProduct['product_id'];
                $product_content    = floatval($getProduct['product_content']);
                if ($getProduct['is_parcel'] == 'N') {
                    $stock = $sales_return_qty * $product_content;
                    if (isset($addStock[$product_code])) {
                        $addStock[$product_code]['stock'] += $stock;
                    } else {
                        $addStock[$product_code] = [
                            'product_id'    => $product_id,
                            'stock'         => $stock,
                        ];
                    }
                } else {
                    $getParcelItem = $this->db->table('ms_product_parcel')
                        ->select('ms_product_parcel.product_id as parcel_id,ms_product.product_code,ms_product_unit.product_id,ms_product_unit.product_content,ms_product_parcel.item_qty')
                        ->join('ms_product_unit', 'ms_product_unit.item_id=ms_product_parcel.item_id')
                        ->join('ms_product', 'ms_product.product_id=ms_product_unit.product_id')
                        ->where('ms_product_parcel.product_id', $product_id)
                        ->get()
                        ->getResultArray();
                    foreach ($getParcelItem as $parcelItem) {
                        $item_product_id        = $parcelItem['product_id'];
                        $item_product_code      = $parcelItem['product_code'];
                        $item_product_content   = floatval($parcelItem['product_content']);
                        $item_qty               = $parcelItem['item_qty'];
                        $stock                  = $sales_return_qty * ($item_product_content * $item_qty);
                        if (isset($addStock[$item_product_code])) {
                            $addStock[$item_product_code]['stock'] += $stock;
                        } else {
                            $addStock[$item_product_code] = [
                                'product_id'    => $item_product_id,
                                'stock'         => $stock,
                            ];
                        }
                    }
                }

                $detailData = [
                    'pos_sales_return_id' => $pos_sales_return_id,
                    'item_id'           => $item_id,
                    'sales_return_qty'  => $sales_return_qty,
                    'product_cogs'      => $product_cogs,
                    'purchase_price'    => $purchase_price,
                    'product_price'     => $product_price,
                    'disc'              => $disc,
                    'price_disc'        => $price_disc,
                    'sales_return_price' => $sales_return_price,
                    'sales_return_dpp'  => $sales_return_dpp,
                    'sales_return_ppn'  => $sales_return_ppn,
                    'margin_allocation' => $margin_allocation,
                    'salesman_id'       => $row['salesman_id']
                ];

                $this->db->table('dt_pos_sales_return')->insert($detailData);
                if ($this->db->affectedRows() > 0) {
                    $this->logQueries[] = $this->db->getLastQuery()->getQuery();
                }
            }
        }

        if (count($addStock) > 0) {
            // update ms_product_stock //
            $qUpdateStock       = "INSERT INTO ms_product_stock(product_id,warehouse_id,stock) VALUES";
            $vUpdateStock       = [];
            $warehouseStockData = [];

            foreach ($addStock as $row) {
                $product_id     = $row['product_id'];
                $stock          = $row['stock'];
                $add_stock      = $row['stock'];
                $vUpdateStock[] = "('$product_id','$warehouse_id',$add_stock)";

                // update warehouse_stock //
                $warehouseStockData[] = [
                    'product_id'    => $product_id,
                    'warehouse_id'  => $warehouse_id,
                    'purchase_id'   => 0,
                    'stock'         => $add_stock
                ];
            }


            $qUpdateStock .= implode(',', $vUpdateStock) . " ON DUPLICATE KEY UPDATE stock=stock+VALUES(stock)";

            $this->db->query($qUpdateStock);
            if ($this->db->affectedRows() > 0) {
                $this->logQueries[] = $this->db->getLastQuery()->getQuery();
            }

            $this->db->table('ms_warehouse_stock')->insertBatch($warehouseStockData);
            if ($this->db->affectedRows() > 0) {
                $this->logQueries[] = $this->db->getLastQuery()->getQuery();
            }
        }
    }

    private function _update_data($dsLogPasswordControl, $dsLastRecordNumber)
    {
        foreach ($dsLogPasswordControl as $passwordControl) {
            $pcData = [
                'password_control_id'   => $passwordControl['password_control_id'],
                'request_user_id'       => $passwordControl['request_user_id'],
                'log_remark'            => $passwordControl['log_remark'],
                'log_at'                => $passwordControl['log_at']
            ];
            $this->db->table('log_password_control')->insert($pcData);
            if ($this->db->affectedRows() > 0) {
                $this->logQueries[] = $this->db->getLastQuery()->getQuery();
            }
        }

        $recordData = [];
        foreach ($dsLastRecordNumber as $row) {
            $recordData[] = [
                'record_module'     => $row['record_module'],
                'store_id'          => $row['store_id'],
                'record_period'     => $row['record_period'],
                'last_number'       => $row['last_number']
            ];
        }
        if (count($recordData) > 0) {
            $qUpdateLastNumber = $this->create_upsert_query('last_record_number', $recordData);
            $this->db->query($qUpdateLastNumber);
            if ($this->db->affectedRows() > 0) {
                $this->logQueries[] = $this->db->getLastQuery()->getQuery();
            }
        }
    }
}
