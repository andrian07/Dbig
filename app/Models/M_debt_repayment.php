<?php

namespace App\Models;

use CodeIgniter\Model;

class M_debt_repayment extends Model
{

    protected $table_hd_purchase = 'hd_purchase';
    protected $table_temp_payment_debt = 'temp_payment_debt';
    protected $hd_payment_debt = 'hd_payment_debt';
    protected $table_warehouse       = 'ms_warehouse';


    public function insertTemp($data)
    {

        $exist = $this->db->table($this->table_temp_payment_debt)

        ->where('temp_payment_debt_id', $data['temp_payment_debt_id'])

        ->where('temp_payment_debt_user_id', $data['temp_payment_debt_user_id'])

        ->countAllResults();

        if ($exist > 0) {

            return $this->db->table($this->table_temp_payment_debt)

            ->where('temp_payment_debt_id', $data['temp_payment_debt_id'])

            ->where('temp_payment_debt_user_id', $data['temp_payment_debt_user_id'])

            ->update($data);

        } else {

            return $this->db->table($this->table_temp_payment_debt)->insert($data);

        }

    }

    public function getPurchaseData($supplierid)
    {
        $builder = $this->db->table($this->table_hd_purchase);

        return $builder->select('*')

        ->where('purchase_remaining_debt >', '0')

        ->where('purchase_supplier_id', $supplierid)

        ->orderBy('created_at', 'ASC')

        ->get();
    }

    public function getPaymentFooter($user_id){

        $builder = $this->db->table($this->table_temp_payment_debt);

        return $builder->select('sum(temp_payment_debt_nominal) as subTotal, count(*) as temp_payment_isedit')

        ->where('temp_payment_debt_user_id', $user_id)

        ->where('temp_payment_isedit', 'Y')

        ->get();

    }

    public function getTemp($supplierid)
    {
        
        $builder = $this->db->table($this->table_hd_purchase);

        return $builder->select('*')

        ->join('temp_payment_debt', 'temp_payment_debt.temp_payment_debt_purchase_id = hd_purchase.purchase_id')

        ->where('purchase_remaining_debt >', '0')

        ->where('purchase_supplier_id', $supplierid)

        ->orderBy('created_at', 'ASC')

        ->get();
    }

    public function count_invoice($userid)
    {
        $builder = $this->db->table($this->table_temp_payment_debt);

        return $builder->select('count(*) as total_invoice_pay')

        ->where('temp_payment_debt_user_id', $userid)

        ->where('temp_payment_isedit', 'Y')

        ->get();
    }

    public function copyPurchaseTemp($supplierid, $user_id)
    {

        $this->clearTemp($user_id);

        $sqlTemp = "insert into temp_payment_debt(temp_purchase_nominal, temp_payment_debt_purchase_id, temp_payment_debt_discount, temp_payment_debt_nominal, temp_payment_debt_user_id) VALUES ";

        $sqlTempValues = [];

        $getData =  $this->db->table($this->table_hd_purchase)->where('purchase_supplier_id', $supplierid)->where('purchase_remaining_debt >','0')->get();

        foreach ($getData->getResultArray() as $row) {
            $temp_purchase_nominal                  = $row['purchase_remaining_debt'];
            $temp_payment_debt_purchase_id          = $row['purchase_id'];
            $temp_payment_debt_discount             = 0;
            $temp_payment_debt_nominal              = 0;
            $temp_payment_debt_user_id              = $user_id;


            $sqlTempValues[] = " ('$temp_purchase_nominal','$temp_payment_debt_purchase_id','$temp_payment_debt_discount','$temp_payment_debt_nominal','$temp_payment_debt_user_id')";

        }

        $sqlTemp .= implode(',', $sqlTempValues);



        $this->db->query($sqlTemp);

        return $this->getTemp($supplierid);
    }


    public function clearTemp($user_id)
    {

        return $this->db->table($this->table_temp_payment_debt)

        ->where('temp_payment_debt_user_id', $user_id)

        ->delete();

    }

    public function insertPayment($data)
    {

       $this->db->query('LOCK TABLES hd_purchase WRITE, hd_payment_debt WRITE, dt_payment_debt WRITE');

       $this->db->transBegin();

       $saveQueries = NULL;

       $maxCode = $this->db->table($this->hd_payment_debt)->select('payment_debt_id, payment_debt_invoice')->orderBy('payment_debt_id', 'desc')->limit(1)->get()->getRowArray();

       $invoice_date =  date_format(date_create($data['repayment_date']),"y/m/d");

       if ($maxCode == NULL) {

        $data['payment_debt_invoice'] = 'PH/'.$invoice_date.'/'.'0000000001';

    } else {

        $invoice = substr($maxCode['payment_debt_invoice'], -10);

        $data['payment_debt_invoice'] = 'PH/'.$invoice_date.'/'.substr('000000000' . strval(floatval($invoice) + 1), -10);

    }

    $count_invoice =  $this->count_invoice($data['user_id'])->getResultArray();

    $data['payment_debt_total_invoice'] = $count_invoice[0]['total_invoice_pay'];

     unset($data['repayment_date']);

    $this->db->table($this->hd_payment_debt)->insert($data);

    $payment_debt_id  = $this->db->insertID();


    if ($this->db->affectedRows() > 0) {

        $saveQueries[] = [

            'query_text'    => $this->db->getLastQuery()->getQuery(),

            'ref_id'        => $payment_debt_id 

        ];

    }


    $sqlDtOrder = "insert into dt_payment_debt(payment_debt_id,dt_payment_debt_purchase_id,dt_payment_debt_discount,dt_payment_debt_desc,dt_payment_debt_nominal) VALUES ";

    $sqlDtValues = [];

    $getTemp =  $this->db->table($this->table_temp_payment_debt)->where('temp_payment_debt_user_id', $data['user_id'])->where('temp_payment_isedit', 'Y')->get();

    foreach ($getTemp->getResultArray() as $row) {

        $dt_payment_debt_purchase_id      = $row['temp_payment_debt_purchase_id'];
        $dt_payment_debt_discount         = $row['temp_payment_debt_discount'];
        $dt_payment_debt_nominal          = $row['temp_payment_debt_nominal'];
        $dt_payment_debt_desc             = $row['temp_payment_debt_desc'];
        $dt_new_remaining_debt            = $row['temp_purchase_nominal'] - $row['temp_payment_debt_nominal'] - $row['temp_payment_debt_discount'];

        $sqlDtValues[] = "('$payment_debt_id','$dt_payment_debt_purchase_id','$dt_payment_debt_discount','$dt_payment_debt_desc','$dt_payment_debt_nominal')";

        $update_remaining_debt =  $this->db->table($this->table_hd_purchase)->where('purchase_id', $dt_payment_debt_purchase_id)->update(['purchase_remaining_debt' => $dt_new_remaining_debt]);



    }

    $sqlDtOrder .= implode(',', $sqlDtValues);

    $this->db->query($sqlDtOrder);

    if ($this->db->affectedRows() > 0) {
        $saveQueries = $this->db->getLastQuery()->getQuery();
    }

    if ($this->db->transStatus() === false) {

        $saveQueries = NULL;

        $this->db->transRollback();

        $save = ['success' => FALSE, 'payment_debt_id' => 0];

    } else {

        $this->db->transCommit();

        $this->clearTemp($data['user_id']);

        $save = ['success' => TRUE, 'payment_debt_id' => $payment_debt_id ];

    }

    $this->db->query('UNLOCK TABLES');

    saveQueries($saveQueries, 'paymentdebt', $payment_debt_id);
    
    return $save;
}

}
