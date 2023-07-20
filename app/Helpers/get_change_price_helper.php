<?php
if (!function_exists('get_change_price')) {
    function get_change_price($product_id, $item_id, $new_data = [], $old_data = [], $update_date = null, $user_id = null)
    {
        $listUpdate = [];

        if ($update_date == null) {
            $update_date = date('Y-m-d');
        }

        if ($user_id == null) {
            $userLogin  = session()->get('user_login');
            $user_id    = $userLogin['user_id'];
        }

        // sales price //
        $old_G1_sales_price = isset($old_data['G1_sales_price']) ? floatval($old_data['G1_sales_price']) : 0;
        $old_G2_sales_price = isset($old_data['G2_sales_price']) ? floatval($old_data['G2_sales_price']) : 0;
        $old_G3_sales_price = isset($old_data['G3_sales_price']) ? floatval($old_data['G3_sales_price']) : 0;
        $old_G4_sales_price = isset($old_data['G4_sales_price']) ? floatval($old_data['G4_sales_price']) : 0;
        $old_G5_sales_price = isset($old_data['G5_sales_price']) ? floatval($old_data['G5_sales_price']) : 0;
        $old_G6_sales_price = isset($old_data['G6_sales_price']) ? floatval($old_data['G6_sales_price']) : 0;

        $new_G1_sales_price = isset($new_data['G1_sales_price']) ? floatval($new_data['G1_sales_price']) : 0;
        $new_G2_sales_price = isset($new_data['G2_sales_price']) ? floatval($new_data['G2_sales_price']) : 0;
        $new_G3_sales_price = isset($new_data['G3_sales_price']) ? floatval($new_data['G3_sales_price']) : 0;
        $new_G4_sales_price = isset($new_data['G4_sales_price']) ? floatval($new_data['G4_sales_price']) : 0;
        $new_G5_sales_price = isset($new_data['G5_sales_price']) ? floatval($new_data['G5_sales_price']) : 0;
        $new_G6_sales_price = isset($new_data['G6_sales_price']) ? floatval($new_data['G6_sales_price']) : 0;


        // promo price //
        $old_G1_promo_price = isset($old_data['G1_promo_price']) ? floatval($old_data['G1_promo_price']) : 0;
        $old_G2_promo_price = isset($old_data['G2_promo_price']) ? floatval($old_data['G2_promo_price']) : 0;
        $old_G3_promo_price = isset($old_data['G3_promo_price']) ? floatval($old_data['G3_promo_price']) : 0;
        $old_G4_promo_price = isset($old_data['G4_promo_price']) ? floatval($old_data['G4_promo_price']) : 0;
        $old_G5_promo_price = isset($old_data['G5_promo_price']) ? floatval($old_data['G5_promo_price']) : 0;
        $old_G6_promo_price = isset($old_data['G6_promo_price']) ? floatval($old_data['G6_promo_price']) : 0;

        $new_G1_promo_price = isset($new_data['G1_promo_price']) ? floatval($new_data['G1_promo_price']) : 0;
        $new_G2_promo_price = isset($new_data['G2_promo_price']) ? floatval($new_data['G2_promo_price']) : 0;
        $new_G3_promo_price = isset($new_data['G3_promo_price']) ? floatval($new_data['G3_promo_price']) : 0;
        $new_G4_promo_price = isset($new_data['G4_promo_price']) ? floatval($new_data['G4_promo_price']) : 0;
        $new_G5_promo_price = isset($new_data['G5_promo_price']) ? floatval($new_data['G5_promo_price']) : 0;
        $new_G6_promo_price = isset($new_data['G6_promo_price']) ? floatval($new_data['G6_promo_price']) : 0;


        if ($old_G1_sales_price != $new_G1_sales_price) {
            $listUpdate[] = [
                'product_id'        => $product_id,
                'item_id'           => $item_id,
                'product_id'        => $product_id,
                'old_sales_price'   => $old_G1_sales_price,
                'new_sales_price'   => $new_G1_sales_price,
                'customer_group'    => 'G1',
                'update_date'       => $update_date,
                'user_id'           => $user_id,
                'update_remark'     => 'Harga Jual',

            ];
        }

        if ($old_G2_sales_price != $new_G2_sales_price) {
            $listUpdate[] = [
                'product_id'        => $product_id,
                'item_id'           => $item_id,
                'product_id'        => $product_id,
                'old_sales_price'   => $old_G2_sales_price,
                'new_sales_price'   => $new_G2_sales_price,
                'customer_group'    => 'G2',
                'update_date'       => $update_date,
                'user_id'           => $user_id,
                'update_remark'     => 'Harga Jual',

            ];
        }


        if ($old_G3_sales_price != $new_G3_sales_price) {
            $listUpdate[] = [
                'product_id'        => $product_id,
                'item_id'           => $item_id,
                'product_id'        => $product_id,
                'old_sales_price'   => $old_G3_sales_price,
                'new_sales_price'   => $new_G3_sales_price,
                'customer_group'    => 'G3',
                'update_date'       => $update_date,
                'user_id'           => $user_id,
                'update_remark'     => 'Harga Jual',

            ];
        }

        if ($old_G4_sales_price != $new_G4_sales_price) {
            $listUpdate[] = [
                'product_id'        => $product_id,
                'item_id'           => $item_id,
                'product_id'        => $product_id,
                'old_sales_price'   => $old_G4_sales_price,
                'new_sales_price'   => $new_G4_sales_price,
                'customer_group'    => 'G4',
                'update_date'       => $update_date,
                'user_id'           => $user_id,
                'update_remark'     => 'Harga Jual',
            ];
        }


        if ($old_G5_sales_price != $new_G5_sales_price) {
            $listUpdate[] = [
                'product_id'        => $product_id,
                'item_id'           => $item_id,
                'product_id'        => $product_id,
                'old_sales_price'   => $old_G5_sales_price,
                'new_sales_price'   => $new_G5_sales_price,
                'customer_group'    => 'G5',
                'update_date'       => $update_date,
                'user_id'           => $user_id,
                'update_remark'     => 'Harga Jual',

            ];
        }


        if ($old_G6_sales_price != $new_G6_sales_price) {
            $listUpdate[] = [
                'product_id'        => $product_id,
                'item_id'           => $item_id,
                'product_id'        => $product_id,
                'old_sales_price'   => $old_G6_sales_price,
                'new_sales_price'   => $new_G6_sales_price,
                'customer_group'    => 'G6',
                'update_date'       => $update_date,
                'user_id'           => $user_id,
                'update_remark'     => 'Harga Jual',

            ];
        }


        if ($old_G1_promo_price != $new_G1_promo_price) {
            $listUpdate[] = [
                'product_id'        => $product_id,
                'item_id'           => $item_id,
                'product_id'        => $product_id,
                'old_sales_price'   => $old_G1_promo_price,
                'new_sales_price'   => $new_G1_promo_price,
                'customer_group'    => 'G1',
                'update_date'       => $update_date,
                'user_id'           => $user_id,
                'update_remark'     => 'Harga Diskon',

            ];
        }


        if ($old_G2_promo_price != $new_G2_promo_price) {
            $listUpdate[] = [
                'product_id'        => $product_id,
                'item_id'           => $item_id,
                'product_id'        => $product_id,
                'old_sales_price'   => $old_G2_promo_price,
                'new_sales_price'   => $new_G2_promo_price,
                'customer_group'    => 'G2',
                'update_date'       => $update_date,
                'user_id'           => $user_id,
                'update_remark'     => 'Harga Diskon',

            ];
        }

        if ($old_G3_promo_price != $new_G3_promo_price) {
            $listUpdate[] = [
                'product_id'        => $product_id,
                'item_id'           => $item_id,
                'product_id'        => $product_id,
                'old_sales_price'   => $old_G3_promo_price,
                'new_sales_price'   => $new_G3_promo_price,
                'customer_group'    => 'G3',
                'update_date'       => $update_date,
                'user_id'           => $user_id,
                'update_remark'     => 'Harga Diskon',

            ];
        }

        if ($old_G4_promo_price != $new_G4_promo_price) {
            $listUpdate[] = [
                'product_id'        => $product_id,
                'item_id'           => $item_id,
                'product_id'        => $product_id,
                'old_sales_price'   => $old_G4_promo_price,
                'new_sales_price'   => $new_G4_promo_price,
                'customer_group'    => 'G4',
                'update_date'       => $update_date,
                'user_id'           => $user_id,
                'update_remark'     => 'Harga Diskon',

            ];
        }

        if ($old_G5_promo_price != $new_G5_promo_price) {
            $listUpdate[] = [
                'product_id'        => $product_id,
                'item_id'           => $item_id,
                'product_id'        => $product_id,
                'old_sales_price'   => $old_G5_promo_price,
                'new_sales_price'   => $new_G5_promo_price,
                'customer_group'    => 'G5',
                'update_date'       => $update_date,
                'user_id'           => $user_id,
                'update_remark'     => 'Harga Diskon',

            ];
        }

        if ($old_G6_promo_price != $new_G6_promo_price) {
            $listUpdate[] = [
                'product_id'        => $product_id,
                'item_id'           => $item_id,
                'product_id'        => $product_id,
                'old_sales_price'   => $old_G6_promo_price,
                'new_sales_price'   => $new_G6_promo_price,
                'customer_group'    => 'G6',
                'update_date'       => $update_date,
                'user_id'           => $user_id,
                'update_remark'     => 'Harga Diskon',

            ];
        }

        return $listUpdate;
    }
}
