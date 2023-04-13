<?php

namespace App\Models\MobileApps;

use CodeIgniter\Model;

class M_promo extends Model
{
    protected $table = 'ms_mobile_promo';

    public function getPromo($mobile_promo_id = '', $show_deleted = FALSE)
    {
        $builder = $this->db->table($this->table);
        if ($mobile_promo_id  != '') {
            $builder->where(['mobile_promo_id' => $mobile_promo_id]);
        }

        if ($show_deleted == FALSE) {
            $builder->where(['deleted' => 'N']);
        }

        return $builder->get();
    }

    public function insertPromo($data)
    {
        $this->db->query('LOCK TABLES ms_mobile_promo WRITE');

        $save = $this->db->table($this->table)->insert($data);
        $saveQueries = NULL;
        $id = 0;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
            $id = $this->db->insertID();
        }
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'mobilepromo', $id, 'add');
        return $save;
    }

    public function updatePromo($data)
    {
        $this->db->query('LOCK TABLES ms_mobile_promo WRITE');
        $save = $this->db->table($this->table)->update($data, ['mobile_promo_id' => $data['mobile_promo_id']]);

        $saveQueries = NULL;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'mobilepromo', $data['mobile_promo_id'], 'edit');
        return $save;
    }

    public function deletePromo($mobile_promo_id)
    {
        $this->db->query('LOCK TABLES ms_mobile_promo WRITE');
        $data = ['deleted' => 'Y'];
        $save = $this->db->table($this->table)->update($data, ['mobile_promo_id' => $mobile_promo_id]);
        $saveQueries = NULL;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'mobilepromo', $mobile_promo_id, 'delete');
        return $save;
    }
}
