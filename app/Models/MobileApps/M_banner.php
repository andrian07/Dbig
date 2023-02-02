<?php

namespace App\Models\MobileApps;

use CodeIgniter\Model;

class M_banner extends Model
{
    protected $table = 'ms_mobile_banner';

    public function getBanner($banner_id = '', $show_deleted = FALSE)
    {
        $builder = $this->db->table($this->table);
        if ($banner_id  != '') {
            $builder->where(['mobile_banner_id' => $banner_id]);
        }

        if ($show_deleted == FALSE) {
            $builder->where(['deleted' => 'N']);
        }

        return $builder->get();
    }

    public function insertBanner($data)
    {
        $this->db->query('LOCK TABLES ms_mobile_banner WRITE');

        $save = $this->db->table($this->table)->insert($data);
        $saveQueries = NULL;
        $id = 0;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
            $id = $this->db->insertID();
        }
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'mobilebanner', $id, 'add');
        return $save;
    }

    public function updateBanner($data)
    {
        $this->db->query('LOCK TABLES ms_mobile_banner WRITE');
        $save = $this->db->table($this->table)->update($data, ['mobile_banner_id' => $data['mobile_banner_id']]);

        $saveQueries = NULL;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'mobilebanner', $data['mobile_banner_id'], 'edit');
        return $save;
    }

    public function deleteBanner($mobile_banner_id)
    {
        $this->db->query('LOCK TABLES ms_mobile_banner WRITE');
        $data = ['deleted' => 'Y'];
        $save = $this->db->table($this->table)->update($data, ['mobile_banner_id' => $mobile_banner_id]);
        $saveQueries = NULL;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'mobilebanner', $mobile_banner_id, 'delete');
        return $save;
    }
}
