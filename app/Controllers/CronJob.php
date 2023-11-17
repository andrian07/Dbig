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

        $getMinStockProduct = $M_product->getReportMinStockProduct()->getResultArray();



        $orderData = [];
        foreach ($getMinStockProduct as $row) {
            $product_id         = $row['product_id'];
            $stock_total        = floatval($row['stock_total']);
            $min_stock          = floatval($row['min_stock']);
            $percent_stock      = $min_stock == 0 ? 0 : (($stock_total / $min_stock) * 100);
            $order_stock        = $percent_stock >= 50 ? ceil($min_stock * 0.5) : $min_stock;

            $orderData[] = [
                'product_id'    => $product_id,
                'min_stock'     => $min_stock,
                'stock'         => $stock_total,
                'order_stock'   => $order_stock,
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
                'notification_view_url' => base_url('webmin/purchase-order/auto-po?update_date=' . $today),
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
                    'min_stock'     => floatval($row['min_stock'])
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
                $old_min_stock = $updateList[$pid]['min_stock'];
                $updateList[$pid]['min_stock'] = $new_min_stock;

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
            $M_cronjob->insertListUpdateSafetyStock($listUpdateSafetyStock, $today);
            // set notification //
            $notifData = [
                'notification_date'     => $today,
                'notification_text'     => "Info update safety stok <b>" . count($listUpdateSafetyStock) . "</b> produk",
                'notification_view_url' => base_url('webmin/product/info-update-safety?update_date=' . $today),
            ];
            $M_admin_notification->insertNotification($notifData);

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
}
