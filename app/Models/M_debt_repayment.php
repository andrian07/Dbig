<?php

namespace App\Models;

use CodeIgniter\Model;

class M_debt_repayment extends Model
{

    protected $table_hd_purchase = 'hd_purchase';
    protected $table_temp_payment_debt = 'temp_payment_debt';
    protected $hd_payment_debt = 'hd_payment_debt';
    protected $table_dt_payment_debt = 'dt_payment_debt';
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

        ->orderBy('temp_payment_debt.created_at', 'ASC')

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

         $invoice_date =  date_format(date_create($data['payment_debt_date']),"y/m/d");

         if ($maxCode == NULL) {

            $data['payment_debt_invoice'] = 'PH/'.$invoice_date.'/'.'0000000001';

        } else {

            $invoice = substr($maxCode['payment_debt_invoice'], -10);

            $data['payment_debt_invoice'] = 'PH/'.$invoice_date.'/'.substr('000000000' . strval(floatval($invoice) + 1), -10);

        }

        $count_invoice =  $this->count_invoice($data['user_id'])->getResultArray();

        $data['payment_debt_total_invoice'] = $count_invoice[0]['total_invoice_pay'];

        $this->db->table($this->hd_payment_debt)->insert($data);

        $payment_debt_id  = $this->db->insertID();


        if ($this->db->affectedRows() > 0) {

            $saveQueries[] = $this->db->getLastQuery()->getQuery();
        }


        $sqlDtOrder = "insert into dt_payment_debt(payment_debt_id,dt_payment_debt_purchase_id,dt_payment_debt_discount,dt_payment_debt_desc,dt_payment_debt_nominal) VALUES ";

        $sqlUpdatePurchase = "insert into hd_purchase (purchase_id, purchase_invoice, purchase_po_invoice, purchase_suplier_no, purchase_date, purchase_faktur_date, purchase_supplier_id, purchase_user_id, purchase_warehouse_id, purchase_remark, purchase_sub_total, purchase_discount1, purchase_discount1_percentage, purchase_discount2, purchase_discount2_percentage, purchase_discount3, purchase_discount3_percentage, purchase_total_discount, purchase_total_dpp, purchase_total_ppn, purchase_total_ongkir, purchase_total, purchase_due_date, purchase_payment_method_id, purchase_down_payment, purchase_remaining_debt, purchase_retur_nominal) VALUES ";

        $sqlDtValues = [];
        $sqlPurchaseValues = [];

        $getTemp =  $this->db->table($this->table_temp_payment_debt)->where('temp_payment_debt_user_id', $data['user_id'])->where('temp_payment_isedit', 'Y')->get();

        foreach ($getTemp->getResultArray() as $row) {

            $dt_payment_debt_purchase_id      = $row['temp_payment_debt_purchase_id'];
            $dt_payment_debt_discount         = $row['temp_payment_debt_discount'];
            $dt_payment_debt_nominal          = $row['temp_payment_debt_nominal'];
            $dt_payment_debt_desc             = $row['temp_payment_debt_desc'];
            $purchase_retur_nominal           = $row['temp_payment_debt_retur'];
            $dt_new_remaining_debt            = $row['temp_purchase_nominal'] - $row['temp_payment_debt_nominal'] - $row['temp_payment_debt_discount'];

            $getPurchase =  $this->db->table($this->table_hd_purchase)->where('purchase_id', $dt_payment_debt_purchase_id)->get()->getRowArray();

            $purchase_id_hd = $getPurchase['purchase_id'];
            $purchase_invoice_hd = $getPurchase['purchase_invoice'];
            $purchase_po_invoice_hd = $getPurchase['purchase_po_invoice'];
            $purchase_suplier_no_hd = $getPurchase['purchase_suplier_no'];
            $purchase_date_hd = $getPurchase['purchase_date'];
            $purchase_faktur_date_hd = $getPurchase['purchase_faktur_date'];
            $purchase_supplier_id_hd = $getPurchase['purchase_supplier_id'];
            $purchase_user_id_hd = $getPurchase['purchase_user_id'];
            $purchase_warehouse_id_hd = $getPurchase['purchase_warehouse_id'];
            $purchase_remark_hd = $getPurchase['purchase_remark'];
            $purchase_sub_total_hd = $getPurchase['purchase_sub_total'];
            $purchase_discount1_hd = $getPurchase['purchase_discount1'];
            $purchase_discount1_percentage_hd = $getPurchase['purchase_discount1_percentage'];
            $purchase_discount2_hd = $getPurchase['purchase_discount2'];
            $purchase_discount2_percentage_hd = $getPurchase['purchase_discount2_percentage'];
            $purchase_discount3_hd = $getPurchase['purchase_discount3'];
            $purchase_discount3_percentage_hd = $getPurchase['purchase_discount3_percentage'];
            $purchase_total_discount_hd = $getPurchase['purchase_total_discount'];
            $purchase_total_dpp_hd = $getPurchase['purchase_total_dpp'];
            $purchase_total_ppn_hd = $getPurchase['purchase_total_ppn'];
            $purchase_total_ongkir_hd = $getPurchase['purchase_total_ongkir'];
            $purchase_total_hd = $getPurchase['purchase_total'];
            $purchase_due_date_hd = $getPurchase['purchase_due_date'];
            $purchase_payment_method_id_hd = $getPurchase['purchase_payment_method_id'];
            $purchase_down_payment_hd = $getPurchase['purchase_down_payment'];
            $purchase_remaining_debt_hd = $dt_new_remaining_debt;
            $purchase_retur_nominal_hd = $purchase_retur_nominal;


            $sqlDtValues[] = "('$payment_debt_id','$dt_payment_debt_purchase_id','$dt_payment_debt_discount','$dt_payment_debt_desc','$dt_payment_debt_nominal')";

            $sqlPurchaseValues[] = "('$purchase_id_hd','$purchase_invoice_hd','$purchase_po_invoice_hd','$purchase_suplier_no_hd','$purchase_date_hd','$purchase_faktur_date_hd','$purchase_supplier_id_hd','$purchase_user_id_hd','$purchase_warehouse_id_hd','$purchase_remark_hd','$purchase_sub_total_hd','$purchase_discount1_hd','$purchase_discount1_percentage_hd','$purchase_discount2_hd','$purchase_discount2_percentage_hd','$purchase_discount3_hd','$purchase_discount3_percentage_hd','$purchase_total_discount_hd','$purchase_total_dpp_hd','$purchase_total_ppn_hd','$purchase_total_ongkir_hd','$purchase_total_hd','$purchase_due_date_hd','$purchase_payment_method_id_hd','$purchase_down_payment_hd', '$purchase_remaining_debt_hd','$purchase_retur_nominal_hd')";

            $update_remaining_debt =  $this->db->table($this->table_hd_purchase)->where('purchase_id', $dt_payment_debt_purchase_id)->update(['purchase_remaining_debt' => $dt_new_remaining_debt]);

        }

        $sqlDtOrder .= implode(',', $sqlDtValues);

        $sqlUpdatePurchase .= implode(',', $sqlPurchaseValues). " ON DUPLICATE KEY UPDATE purchase_retur_nominal=purchase_retur_nominal-VALUES(purchase_retur_nominal)";

       

        $this->db->query($sqlDtOrder);

        if ($this->db->affectedRows() > 0) {
            $saveQueries[] = $this->db->getLastQuery()->getQuery();
        }

        $this->db->query($sqlUpdatePurchase);

        if ($this->db->affectedRows() > 0) {
            $saveQueries[] = $this->db->getLastQuery()->getQuery();
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

    public function getHdDebtdetail($payment_debt_id)
    {
         $builder = $this->db->table($this->hd_payment_debt);

         $builder->select('hd_payment_debt.*,ms_supplier.* ,user_account.user_realname,hd_payment_debt.created_at as created_at');

         $builder->join('user_account', 'user_account.user_id = hd_payment_debt.user_id');

         $builder->join('ms_supplier', 'ms_supplier.supplier_id  = hd_payment_debt.payment_debt_supplier_id');

         if ($payment_debt_id  != '') {

            $builder->where(['hd_payment_debt.payment_debt_id' => $payment_debt_id]);

            }

        return $builder->get();
    }

    public function getDtDebtdetail($payment_debt_id)
    {
         $builder = $this->db->table($this->table_dt_payment_debt);

         $builder->select('*');

         $builder->join('hd_purchase', 'hd_purchase.purchase_id  = dt_payment_debt.dt_payment_debt_purchase_id');

         if ($payment_debt_id  != '') {

            $builder->where(['dt_payment_debt.payment_debt_id' => $payment_debt_id]);
            }

        return $builder->get();
    }

    public function getReportData($start_date, $end_date, $supplier_id)
    {
        $builder = $this->db->table('hd_payment_debt')->select("payment_debt_date as date_inv, payment_debt_invoice as invoice, CONCAT('Pembayaran ', purchase_invoice) AS ket, dt_payment_debt_nominal as debit,'0' as credit, sp1.supplier_name as supplier_name, sp1.supplier_code as supplier_code");
        $builder->join('dt_payment_debt', 'dt_payment_debt.payment_debt_id = hd_payment_debt.payment_debt_id');
        $builder->join('hd_purchase', 'hd_purchase.purchase_id = dt_payment_debt.dt_payment_debt_purchase_id');
        $builder->join('ms_supplier sp1', 'sp1.supplier_id = hd_payment_debt.payment_debt_supplier_id');
        $builder->where("(payment_debt_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        if ($supplier_id != null) {
            $builder->where('purchase_supplier_id', $supplier_id);
        }

        $union   = $this->db->table('hd_purchase')->select("purchase_date as date_inv, purchase_invoice as invoice, CONCAT('PEMBELIAN ', purchase_invoice) AS ket, '0' as debit, purchase_total as credit, sp2.supplier_name as supplier_name, sp2.supplier_code as supplier_code");
        $union->join('ms_supplier sp2', 'sp2.supplier_id = hd_purchase.purchase_supplier_id');
        $union->where("(purchase_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        if ($supplier_id != null) {
            $union->where('purchase_supplier_id', $supplier_id);
        }

        $builder->union($union);

        return $this->db->newQuery()->fromSubquery($builder, 'q')->orderBy('date_inv', 'ASC')->get();
    }

    public function getDebt($purchase_invoice, $start_date, $end_date, $supplier_id)
    {
        $builder = $this->db->table('hd_payment_debt')->select("purchase_invoice, payment_debt_invoice, payment_debt_date, supplier_name, purchase_total, dt_payment_debt_discount, dt_payment_debt_nominal,supplier_code");
        $builder->join('dt_payment_debt', 'dt_payment_debt.payment_debt_id = hd_payment_debt.payment_debt_id');
        $builder->join('hd_purchase', 'hd_purchase.purchase_id = dt_payment_debt.dt_payment_debt_purchase_id');
        $builder->join('ms_supplier sp1', 'sp1.supplier_id = hd_payment_debt.payment_debt_supplier_id');
        $builder->where("(payment_debt_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        if ($supplier_id != null) {
            $builder->where('purchase_supplier_id', $supplier_id);
        }
        if ($purchase_invoice != null) {
            $builder->where('dt_payment_debt_purchase_id', $purchase_invoice);
        }

        return $builder->get();
    }

    public function getDebtRepaymentAccounting($payment_debt_id)
    {
        $builder = $this->db->table($this->hd_payment_debt);
        $builder->select('*');
        $builder->join('ms_supplier', 'ms_supplier.supplier_id=hd_payment_debt.payment_debt_supplier_id');
        $builder->where('payment_debt_id', $payment_debt_id);
        return $builder->get();
    }

}
