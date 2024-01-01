<?php

namespace App\Controllers;

use App\Controllers\Base\BaseController;

class CronJob extends BaseController
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        helper('global');
    }

    public function index()
    {
        echo "CronJob Controller";
    }

    public function daily01()
    {
        //update safety stock
        //$this->updateSafetyStockBalance();
        $this->migrate_suplier_and_customer_to_accounting();
    }

    public function daily02()
    {
        //update voucher
        $this->updateVoucher();
    }

    public function updateVoucher()
    {
        // set expired voucher //    
        $M_voucher = model('M_voucher');
        $today = date('Y-m-d');
        $update = $M_voucher->setExpiredVoucher($today);
        if ($update) {
            echo "Update Voucher : OK<br>";
        };
    }

    public function updatePOSafetyStock()
    {

        $isUserRequest          = $this->request->getGet('user_request') == null ? false : true;
        $today                  = date('Y-m-d');
        $M_cronjob              = model('M_cronjob');
        $M_admin_notification   = model('M_admin_notification');
        $M_product              = model('M_product');


        $getListAutoPO = $M_product->getReportListAutoPO();

        $orderData = [];
        foreach ($getListAutoPO as $row) {
            $product_id         = $row['product_id'];
            $stock_total        = floatval($row['stock_total']);
            $min_stock          = floatval($row['min_stock']);
            $percent_stock      = $min_stock == 0 ? 0 : (($stock_total / $min_stock) * 100);
            $order_stock        = $percent_stock >= 50 ? ceil($min_stock * 0.5) : $min_stock;
            $avg_sales          = floatval($row['avg_sales']);
            $orderData[] = [
                'product_id'    => $product_id,
                'min_stock'     => $min_stock,
                'stock'         => $stock_total,
                'order_stock'   => $order_stock,
                'avg_sales'     => $avg_sales,
                'update_date'   => $today,
                'status'        => 'Pending',
                'outstanding'   => 'N',
                'submission_no' => ''
            ];
        }

        $countProduct = count($orderData);

        $insertOrder = $M_cronjob->insertListPurchaseOrderV2($orderData);

        if ($insertOrder) {
            // set notification //
            $notifData = [
                'notification_date' =>  $today,
                'notification_text' => "Terdapat <b>$countProduct</b> produk dibawah safety stok",
                'notification_view_url' => base_url('webmin/purchase-order/auto-po'),
            ];
            $M_admin_notification->insertNotification($notifData);

            if ($isUserRequest) {
                return redirect()->to(base_url('webmin/dashboard'));
            } else {
                echo "Update Order : OK";
            }
        } else {
            if ($isUserRequest) {
                return redirect()->to(base_url('webmin/dashboard'));
            } else {
                echo "Update Order : GAGAL";
            }
        }
    }

    public function updateSafetyStockBalance()
    {
        $isUserRequest          = $this->request->getGet('user_request') == null ? false : true;
        $monthCount             = 3;
        $today                  = date('Y-m-d');

        $M_product              = model('M_product');
        $M_cronjob              = model('M_cronjob');
        $M_admin_notification   = model('M_admin_notification');
        $getProduct             = $M_product->getProduct()->getResultArray();

        $listUpdateSafetyStock = [];
        $sampleListUpdateSafetyStock = [
            [
                'product_id'        => 1,
                'old_min_stock'     => 10,
                'three_month_sales' => 25,
                'new_min_stock'     => 13,
                'update_date'       => ''
            ]
        ];

        $updateList         = [];
        $sampleUpdateList   = [
            'P1'    => [
                'product_id'        => 1,
                'min_stock'         => 10,
            ]
        ];

        foreach ($getProduct as $row) {
            if ($row['is_parcel'] == 'N') {
                $pid = 'P' . $row['product_id'];
                $updateList[$pid] = [
                    'product_id'    => $row['product_id'],
                    'new_min_stock' => floatval($row['new_min_stock'])
                ];
            }
        }


        // get sales three month sales //
        $start_date     = date("Y-m-d", strtotime("-3 months"));
        $getSalesStock  = $M_product->getSalesStockByProduct([], $start_date, $today);
        foreach ($getSalesStock as $row) {
            $pid = 'P' . $row['product_id'];
            $salesStock = floatval($row['sales_stock']);
            $new_min_stock = ceil($salesStock / $monthCount);
            if (isset($updateList[$pid])) {
                $old_min_stock = $updateList[$pid]['new_min_stock'];
                $updateList[$pid]['new_min_stock'] = $new_min_stock;

                $listUpdateSafetyStock[] = [
                    'product_id'        => $row['product_id'],
                    'old_min_stock'     => $old_min_stock,
                    'three_month_sales' => $salesStock,
                    'new_min_stock'     => $new_min_stock,
                    'update_date'       => $today
                ];
            }
        }

        $updateMinStock = $M_cronjob->updateMinStock($updateList);
        if ($updateMinStock) {
            // $M_cronjob->insertListUpdateSafetyStock($listUpdateSafetyStock, $today);
            // // set notification //
            // $notifData = [
            //     'notification_date'     => $today,
            //     'notification_text'     => "Info update safety stok <b>" . count($listUpdateSafetyStock) . "</b> produk",
            //     'notification_view_url' => base_url('webmin/product/info-update-safety?update_date=' . $today),
            // ];
            // $M_admin_notification->insertNotification($notifData);

            if ($isUserRequest) {
                return redirect()->to(base_url('webmin/dashboard'));
            } else {
                echo "Update Safety Stok : OK";
            }
        } else {
            if ($isUserRequest) {
                return redirect()->to(base_url('webmin/dashboard'));
            } else {
                echo "Update Safety Stok : GAGAL";
            }
        }
    }

    public function deleteLastMonthRecap()
    {
        $M_cronjob = model('M_cronjob');
        $max_date = date('Y-m') . '-01';
        $delete = $M_cronjob->deleteRecapData($max_date);
        if ($delete) {
            echo "Delete Recap Data : OK";
        } else {
            echo "Delete Recap Data : GAGAL";
        }
    }

    public function migrate_suplier_and_customer_to_accounting()
    {
        echo "migrate supplier and customer to accounting<br>";

        $db = \Config\Database::connect();
        $db_accounting = \Config\Database::connect('accounting');


        $getSupplier = $db->table('ms_supplier')->get()->getResultArray();
        $getCustomer = $db->table('ms_customer')->get()->getResultArray();

        $batch_import_supplier = array_chunk($getSupplier, 200);
        $batch_import_customer = array_chunk($getCustomer, 200);


        $supplier_base_query = "INSERT INTO ms_supplier(supplier_id,supplier_code,supplier_name,supplier_phone,supplier_address,mapping_id,supplier_npwp,supplier_remark) VALUES";
        $supplier_update_key = 'supplier_code,supplier_name,supplier_phone,supplier_address,mapping_id,supplier_npwp,supplier_remark';
        $supplier_update_list = explode(",", $supplier_update_key);
        $supplier_on_duplicate_update = [];
        foreach ($supplier_update_list as $li) {
            $supplier_on_duplicate_update[] = "$li=VALUES($li)";
        }


        $customer_base_query = "INSERT INTO ms_customer(customer_id,customer_code,customer_name,customer_phone,customer_email,customer_password,customer_address,customer_point,customer_group,customer_gender,customer_job,customer_birth_date,salesman_id,customer_remark,customer_delivery_address,customer_npwp,customer_nik,customer_tax_invoice_name,customer_tax_invoice_address,mapping_id,exp_date,referral_code,invite_by_referral_code,verification_email,last_login,active) VALUES";
        $customer_update_key = 'customer_code,customer_name,customer_phone,customer_email,customer_password,customer_address,customer_point,customer_group,customer_gender,customer_job,customer_birth_date,salesman_id,customer_remark,customer_delivery_address,customer_npwp,customer_nik,customer_tax_invoice_name,customer_tax_invoice_address,mapping_id,exp_date,referral_code,invite_by_referral_code,verification_email,last_login,active';
        $customer_update_list = explode(",", $customer_update_key);
        $customer_on_duplicate_update = [];
        foreach ($customer_update_list as $li) {
            $customer_on_duplicate_update[] = "$li=VALUES($li)";
        }



        foreach ($batch_import_customer as $queue) {
            $values = [];

            foreach ($queue as $row) {
                $customer_id = $row['customer_id'];
                $customer_code = $row['customer_code'];
                $customer_name = $row['customer_name'];
                $customer_phone = $row['customer_phone'];
                $customer_email = $row['customer_email'];
                $customer_address = $row['customer_address'];
                $customer_point = $row['customer_point'];
                $customer_group = $row['customer_group'];
                $customer_gender = $row['customer_gender'];
                $customer_job = $row['customer_job'];
                $customer_birth_date = $row['customer_birth_date'];
                $salesman_id = $row['salesman_id'];
                $customer_remark = $row['customer_remark'];
                $customer_delivery_address = $row['customer_delivery_address'];
                $customer_npwp = $row['customer_npwp'];
                $customer_nik = $row['customer_nik'];
                $customer_tax_invoice_name = $row['customer_tax_invoice_name'];
                $customer_tax_invoice_address = $row['customer_tax_invoice_address'];
                $mapping_id = $row['mapping_id'];
                $exp_date = $row['exp_date'];
                $referral_code = $row['referral_code'];
                $invite_by_referral_code = $row['invite_by_referral_code'];
                $verification_email = $row['verification_email'];
                $last_login = $row['last_login'];
                $active = $row['active'];


                $values[] = "('$customer_id','$customer_code','$customer_name','$customer_phone','$customer_email','@','$customer_address','$customer_point','$customer_group','$customer_gender','$customer_job','$customer_birth_date','$salesman_id','$customer_remark','$customer_delivery_address','$customer_npwp','$customer_nik','$customer_tax_invoice_name','$customer_tax_invoice_address','$mapping_id','$exp_date','$referral_code','$invite_by_referral_code','$verification_email','$last_login','$active')";
            }

            $query_import_customer = $customer_base_query . implode(",", $values) . " ON DUPLICATE KEY UPDATE " . implode(',', $customer_on_duplicate_update);
            $db_accounting->query($query_import_customer);
        }





        foreach ($batch_import_supplier as $queue) {
            $values = [];

            foreach ($queue as $row) {
                $supplier_id        = $row['supplier_id'];
                $supplier_code      = $row['supplier_code'];
                $supplier_name      = $row['supplier_name'];
                $supplier_phone     = $row['supplier_phone'];
                $supplier_address   = $row['supplier_address'];
                $mapping_id         = $row['mapping_id'];
                $supplier_npwp      = $row['supplier_npwp'];
                $supplier_remark    = $row['supplier_remark'];

                $values[] = "('$supplier_id','$supplier_code','$supplier_name','$supplier_phone','$supplier_address','$mapping_id','$supplier_npwp','$supplier_remark')";
            }

            $query_import_supplier = $supplier_base_query . implode(",", $values) . " ON DUPLICATE KEY UPDATE " . implode(',', $supplier_on_duplicate_update);
            $db_accounting->query($query_import_supplier);
        }
    }
}
