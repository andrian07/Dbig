<?php

namespace App\Models;

use CodeIgniter\Model;

class M_mobile extends Model
{
    protected $table_banner = 'ms_mobile_banner';
    protected $table_promo = 'ms_mobile_promo';

    public function insertbanner($data)
    {

        $this->db->query('LOCK TABLES ms_mobile_banner WRITE');

        $save = $this->db->table($this->table_banner)->insert($data);
        $saveQueries = NULL;
        $id = 0;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
            $id = $this->db->insertID();
        }
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'mobilebanner', $id);
        return $save;
    }

    public function insertporomo($data)
    {
        $this->db->query('LOCK TABLES ms_mobile_promo WRITE');

        $save = $this->db->table($this->table_promo)->insert($data);
        $saveQueries = NULL;
        $id = 0;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
            $id = $this->db->insertID();
        }
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'mobilepromo', $id);
        return $save;
    }


    public function getBanner($banner_id = '', $show_deleted = FALSE)
    {
        $builder = $this->db->table($this->table_banner);
        if ($banner_id  != '') {
            $builder->where(['mobile_banner_id ' => $banner_id]);
        }

        if ($show_deleted == FALSE) {
            $builder->where(['deleted' => 'N']);
        }

        return $builder->get();
    }

    public function updateBanner($data)
    {
         $this->db->query('LOCK TABLES ms_mobile_banner WRITE');
        $save = $this->db->table($this->table_banner)->update($data, ['mobile_banner_id ' => $data['mobile_banner_id ']]);

        $saveQueries = NULL;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'mobilebanner', $data['mobile_banner_id ']);
        return $save;
    }

    public function deleteBanner($mobile_banner_id)
    {
        $this->db->query('LOCK TABLES ms_mobile_banner WRITE');
        $data = ['deleted' => 'Y'];
        $save = $this->db->table($this->table_banner)->update($data, ['mobile_banner_id' => $mobile_banner_id]);
        $saveQueries = NULL;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'mobilebanner', $mobile_banner_id);
        return $save;
    }

    public function deletepromo($mobile_promo_id ){
        $this->db->query('LOCK TABLES ms_mobile_promo WRITE');
        $data = ['deleted' => 'Y'];
        $save = $this->db->table($this->table_promo)->update($data, ['mobile_promo_id' => $mobile_promo_id]);
        $saveQueries = NULL;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'mobilepromo', $mobile_promo_id);
        return $save;
    }
}
