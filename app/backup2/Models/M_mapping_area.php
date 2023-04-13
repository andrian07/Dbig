<?php

namespace App\Models;

use CodeIgniter\Model;

class M_mapping_area extends Model
{
    protected $table = 'ms_mapping_area';

    public function getMap($mapping_id = '', $show_deleted = FALSE)
    {
        $builder = $this->db->table($this->table);

        $builder->select('ms_mapping_area.*,pc_provinces.prov_name,pc_cities.city_name,pc_districts.dis_name,pc_subdistricts.subdis_name');
        $builder->join('pc_provinces', 'pc_provinces.prov_id=ms_mapping_area.prov_id');
        $builder->join('pc_cities', 'pc_cities.city_id=ms_mapping_area.city_id');
        $builder->join('pc_districts', 'pc_districts.dis_id=ms_mapping_area.dis_id');
        $builder->join('pc_subdistricts', 'pc_subdistricts.subdis_id=ms_mapping_area.subdis_id');

        if ($mapping_id  != '') {
            $builder->where(['ms_mapping_area.mapping_id' => $mapping_id]);
        }

        if ($show_deleted == FALSE) {
            $builder->where(['ms_mapping_area.deleted' => 'N']);
        }

        return $builder->get();
    }

    public function getMapByAddress($mapping_address, $prov_id = 0, $city_id = 0, $dis_id = 0, $subdis_id = 0, $show_deleted = FALSE)
    {
        $builder = $this->db->table($this->table);
        $builder->where(['mapping_address' => $mapping_address]);

        if (!($prov_id == '' || $prov_id == NULL)) {
            $builder->where('prov_id', $prov_id);
        }

        if (!($city_id == '' || $city_id == NULL)) {
            $builder->where('city_id', $city_id);
        }

        if (!($dis_id == '' || $dis_id == NULL)) {
            $builder->where('dis_id', $dis_id);
        }

        if (!($subdis_id == '' || $subdis_id == NULL)) {
            $builder->where('subdis_id', $subdis_id);
        }

        if ($show_deleted == FALSE) {
            $builder->where(['deleted' => 'N']);
        }
        return $builder->get();
    }

    public function hasCustomer($mapping_id)
    {
        return 0;
        // $getData = $this->db->table('ms_product_unit')
        //     ->select('item_code')
        //     ->where('unit_id', $unit_id)
        //     ->limit(1)->get()->getRowArray();

        // if ($getData == NULL) {
        //     return 0;
        // } else {
        //     return 1;
        // }
    }

    public function insertMap($data)
    {
        $this->db->query('LOCK TABLES ms_mapping_area WRITE');

        $maxCode = $this->db->table($this->table)->select('mapping_code')->limit(1)->orderBy('mapping_id', 'desc')->get()->getRowArray();
        if ($maxCode == NULL) {
            $data['mapping_code'] = "A0001";
        } else {
            $data['mapping_code'] = "A" . substr('0000' . strval(floatval(substr($maxCode['mapping_code'], -4)) + 1), -4);
        }

        $save = $this->db->table($this->table)->insert($data);
        $saveQueries = NULL;
        $id = 0;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
            $id = $this->db->insertID();
        }
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'mapping_area', $id);
        return $save;
    }

    public function updateMap($data)
    {
        $this->db->query('LOCK TABLES ms_mapping_area WRITE');
        $save = $this->db->table($this->table)->update($data, ['mapping_id' => $data['mapping_id']]);

        $saveQueries = NULL;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'mapping_area', $data['mapping_id']);
        return $save;
    }

    public function deleteMap($mapping_id)
    {
        $this->db->query('LOCK TABLES ms_mapping_area WRITE');
        $data = ['deleted' => 'Y'];
        $save = $this->db->table($this->table)->update($data, ['mapping_id' => $mapping_id]);
        $saveQueries = NULL;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'mapping_area', $mapping_id);
        return $save;
    }
}
