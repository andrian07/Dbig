<?php

namespace App\Models;

use CodeIgniter\Model;

class M_receivable_repayment extends Model
{

    protected $table_hd_sales_admin = 'hd_sales_admin';
    protected $table_temp_payment_receivable = 'temp_payment_receivable';
    protected $table_hd_payment_receivable = 'hd_payment_receivable';
    protected $table_dt_payment_receivable = 'dt_payment_receivable';


    public function getSaleseData($customerid)
    {
        $builder = $this->db->table($this->table_hd_sales_admin);

        return $builder->select('*')

        ->where('sales_admin_remaining_payment >', '0')

        ->where('sales_customer_id', $customerid)

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

        ->orderBy('temp_payment_receivable.created_at', 'ASC')

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


    public function insertPayment($data)
    {

        $this->db->query('LOCK TABLES hd_sales_admin WRITE, hd_payment_receivable WRITE, dt_payment_receivable WRITE');

        $this->db->transBegin();

        $saveQueries = NULL;

        $maxCode = $this->db->table($this->table_hd_payment_receivable)->select('payment_receivable_id, payment_receivable_invoice')->orderBy('payment_receivable_id', 'desc')->limit(1)->get()->getRowArray();

        $invoice_date =  date_format(date_create($data['payment_receivable_date']),"y/m/d");

        if ($maxCode == NULL) {

            $data['payment_receivable_invoice'] = 'PP/'.$invoice_date.'/'.'0000000001';

        } else {

            $invoice = substr($maxCode['payment_receivable_invoice'], -10);

            $data['payment_receivable_invoice'] = 'PP/'.$invoice_date.'/'.substr('000000000' . strval(floatval($invoice) + 1), -10);

        }

        $count_invoice =  $this->count_invoice($data['user_id'])->getResultArray();

        $data['payment_receivable_total_invoice'] = $count_invoice[0]['total_invoice_pay'];

        $this->db->table($this->table_hd_payment_receivable)->insert($data);

        $payment_receivable_id   = $this->db->insertID();


        if ($this->db->affectedRows() > 0) {

            $saveQueries[] = [

                'query_text'    => $this->db->getLastQuery()->getQuery(),

                'ref_id'        => $payment_receivable_id  

            ];

        }


        $sqlDtOrder = "insert into dt_payment_receivable(payment_receivable_id,dt_payment_receivable_sales_id,dt_payment_receivable_discount,dt_payment_receivable_desc,dt_payment_receivable_nominal) VALUES ";

        $sqlDtValues = [];

        $getTemp =  $this->db->table($this->table_temp_payment_receivable)->where('temp_payment_receivable_user_id', $data['user_id'])->where('temp_payment_isedit', 'Y')->get();

        foreach ($getTemp->getResultArray() as $row) {

            $dt_payment_receivable_sales_id         = $row['temp_payment_receivable_sales_id'];
            $dt_payment_receivable_discount         = $row['temp_payment_receivable_discount'];
            $dt_payment_receivable_nominal          = $row['temp_payment_receivable_nominal'];
            $dt_payment_receivable_desc             = $row['temp_payment_receivable_desc'];
            $dt_new_remaining_receivable            = $row['temp_sales_nominal'] - $row['temp_payment_receivable_nominal'] - $row['temp_payment_receivable_discount'];

            $sqlDtValues[] = "('$payment_receivable_id','$dt_payment_receivable_sales_id','$dt_payment_receivable_discount','$dt_payment_receivable_desc','$dt_payment_receivable_nominal')";

            $update_remaining_debt =  $this->db->table($this->table_hd_sales_admin)->where('sales_admin_id', $dt_payment_receivable_sales_id)->update(['sales_admin_remaining_payment' => $dt_new_remaining_receivable]);
        }

        $sqlDtOrder .= implode(',', $sqlDtValues);

        $this->db->query($sqlDtOrder);

        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }

        if ($this->db->transStatus() === false) {

            $saveQueries = NULL;

            $this->db->transRollback();

            $save = ['success' => FALSE, 'payment_receivable_id' => 0];

        } else {

            $this->db->transCommit();

            $this->clearTemp($data['user_id']);

            $save = ['success' => TRUE, 'payment_receivable_id' => $payment_receivable_id ];

        }

        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'paymentreceivable', $payment_receivable_id);

        return $save;
    }


    public function count_invoice($userid)
    {
        $builder = $this->db->table($this->table_temp_payment_receivable);

        return $builder->select('count(*) as total_invoice_pay')

        ->where('temp_payment_receivable_user_id', $userid)

        ->where('temp_payment_isedit', 'Y')

        ->get();
    }

    public function getReceivableFooter($userid)
    {
        $builder = $this->db->table($this->table_temp_payment_receivable);

        return $builder->select('sum(temp_payment_receivable_nominal) as subTotal, count(*) as temp_payment_isedit')

        ->where('temp_payment_receivable_user_id', $userid)

        ->where('temp_payment_isedit', 'Y')

        ->get();
    }

    public function getHdReceivabledetail($payment_receivable_id)
    {
        $builder = $this->db->table($this->table_hd_payment_receivable);

        $builder->select('hd_payment_receivable.*,ms_customer.* ,user_account.user_realname,hd_payment_receivable.create_at as created_at');

        $builder->join('user_account', 'user_account.user_id = hd_payment_receivable.user_id');

        $builder->join('ms_customer', 'ms_customer.customer_id  = hd_payment_receivable.payment_receivable_customer_id');

        if ($payment_receivable_id  != '') {

            $builder->where(['hd_payment_receivable.payment_receivable_id' => $payment_receivable_id]);

        }

        return $builder->get();
    }

    public function getDtReceivabledetail($payment_receivable_id)
    {
        $builder = $this->db->table($this->table_dt_payment_receivable);

        $builder->select('*');

        $builder->join('hd_sales_admin', 'hd_sales_admin.sales_admin_id  = dt_payment_receivable.dt_payment_receivable_sales_id');

        if ($payment_receivable_id  != '') {

            $builder->where(['dt_payment_receivable.payment_receivable_id' => $payment_receivable_id]);
        }

        return $builder->get();
    }

    public function getReportData($start_date, $end_date, $customer_id, $store_id)
    {
        $builder = $this->db->table('hd_sales_admin')->select("sales_admin_invoice, sales_date, sales_due_date, sales_admin_grand_total, sales_admin_down_payment, sales_admin_remaining_payment, customer_name, customer_address, customer_phone, store_name, store_code");
        $builder->join('ms_customer', 'ms_customer.customer_id  = hd_sales_admin.sales_customer_id');
        $builder->join('ms_store', 'ms_store.store_id = hd_sales_admin.sales_store_id');
        if ($store_id != null) {
            $builder->where('store_id', $store_id);
        }
        if ($customer_id != null) {
            $builder->where('sales_customer_id', $customer_id);
        }
        $builder->where("(sales_due_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        $builder->where('sales_admin_remaining_payment > 0');
        return $builder->orderBy('hd_sales_admin.sales_customer_id', 'ASC')->get();
    }

}
