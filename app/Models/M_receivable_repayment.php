<?php

namespace App\Models;

use CodeIgniter\Model;

class M_receivable_repayment extends Model
{

    protected $table_hd_sales_admin = 'hd_sales_admin';
    protected $table_temp_payment_receivable = 'temp_payment_receivable';


    public function getSaleseData($customerid)
    {
        $builder = $this->db->table($this->table_hd_sales_admin);

        return $builder->select('*')

        ->where('sales_admin_remaining_payment >', '0')

        ->where('sales_salesman_id', $customerid)

        ->orderBy('created_at', 'ASC')

        ->get();
    }

    public function insertTemp($data)
    {

        $exist = $this->db->table($this->table_temp_payment_receivable)

        ->where('temp_payment_receivable_id', $data['temp_payment_receivable_id'])

        ->where('temp_payment_receivable_user_id', $data['temp_payment_receivable_user_id'])

        ->countAllResults();

        if ($exist > 0) {

            return $this->db->table($this->table_temp_payment_receivable)

            ->where('temp_payment_receivable_id', $data['temp_payment_receivable_id'])

            ->where('temp_payment_receivable_user_id', $data['temp_payment_receivable_user_id'])

            ->update($data);

        } else {

            return $this->db->table($this->table_temp_payment_receivable)->insert($data);

        }

    }


    public function getTemp($customerid)
    {

        $builder = $this->db->table($this->table_hd_sales_admin);

        return $builder->select('*')

        ->join('temp_payment_receivable', 'temp_payment_receivable.temp_payment_receivable_sales_id  = hd_sales_admin.sales_admin_id')

        ->where('sales_admin_remaining_payment >', '0')

        ->where('sales_customer_id', $customerid)

        ->orderBy('created_at', 'ASC')

        ->get();
    }

    public function clearTemp($user_id)
    {

        return $this->db->table($this->table_temp_payment_receivable)

        ->where('temp_payment_receivable_user_id', $user_id)

        ->delete();

    }

    public function copySalesTemp($customerid, $user_id)
    {

        $this->clearTemp($user_id);

        $sqlTemp = "insert into temp_payment_receivable(temp_sales_nominal, temp_payment_receivable_sales_id, temp_payment_receivable_discount, temp_payment_receivable_nominal, temp_payment_receivable_user_id) VALUES ";

        $sqlTempValues = [];

        $getData =  $this->db->table($this->table_hd_sales_admin)->where('sales_customer_id', $customerid)->where('sales_admin_remaining_payment >','0')->get();

        foreach ($getData->getResultArray() as $row) {
            $temp_sales_nominal                           = $row['sales_admin_remaining_payment'];
            $temp_payment_receivable_sales_id             = $row['sales_admin_id'];
            $temp_payment_receivable_discount             = 0;
            $temp_payment_receivable_nominal              = 0;
            $temp_payment_receivable_user_id              = $user_id;


            $sqlTempValues[] = " ('$temp_sales_nominal','$temp_payment_receivable_sales_id','$temp_payment_receivable_discount','$temp_payment_receivable_nominal','$temp_payment_receivable_user_id')";

        }

        $sqlTemp .= implode(',', $sqlTempValues);



        $this->db->query($sqlTemp);

        return $this->getTemp($customerid);
    }

}
