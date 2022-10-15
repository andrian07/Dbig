<?php


namespace App\Controllers\Webmin;

use App\Controllers\Base\WebminController;


class Select extends WebminController
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function index()
    {
        die('Select2 Controllers');
    }

    public function pcProvinces()
    {
        $this->validationRequest(TRUE);
        $select2 = new \App\Libraries\Select2('pc_provinces');
        $select2->db->select('prov_id,prov_name');

        $prov_id = $this->request->getGet('prov_id');
        if ($prov_id != NULL) {
            $list_prov_id = explode(',', $prov_id);
            $select2->db->whereIn('prov_id', $list_prov_id);
        }

        $select2->searchFields  = ['prov_name'];
        $select2->orderBy       = 'prov_name';
        $select2->orderDir      = 'ASC';

        $select2->renderResult(function ($row, $i) {
            $result = [];
            $result['id']   = esc($row['prov_id']);
            $result['text'] = esc($row['prov_name']);
            return $result;
        });

        $select2->generate();
    }

    public function pcCities()
    {
        $this->validationRequest(TRUE);
        $select2 = new \App\Libraries\Select2('pc_cities');
        $select2->db->select('pc_cities.city_id,pc_cities.city_name,pc_cities.prov_id,pc_provinces.prov_name');
        $select2->db->join('pc_provinces', 'pc_provinces.prov_id=pc_cities.prov_id');

        $prov_id = $this->request->getGet('prov_id');
        if ($prov_id != NULL) {
            $list_prov_id = explode(',', $prov_id);
            $select2->db->whereIn('pc_cities.prov_id', $list_prov_id);
        }

        $select2->searchFields  = ['pc_cities.city_name'];
        $select2->orderBy       = 'pc_cities.city_name';
        $select2->orderDir      = 'ASC';


        $select2->renderResult(function ($row, $i) {
            $result = [];
            $result['id']           = esc($row['city_id']);
            $result['text']         = esc($row['city_name']);
            $result['prov_id']      = esc($row['city_id']);
            $result['prov_name']    = esc($row['prov_name']);
            return $result;
        });

        $select2->generate();
    }

    public function pcDistricts()
    {
        $this->validationRequest(TRUE);
        $select2 = new \App\Libraries\Select2('pc_districts');
        $select2->db->select('pc_districts.dis_id,pc_districts.dis_name,pc_cities.city_id,pc_cities.city_name,pc_cities.prov_id,pc_provinces.prov_name');
        $select2->db->join('pc_cities', 'pc_cities.city_id=pc_districts.city_id');
        $select2->db->join('pc_provinces', 'pc_provinces.prov_id=pc_cities.prov_id');

        $city_id = $this->request->getGet('city_id');
        if ($city_id != NULL) {
            $list_city_id = explode(',', $city_id);
            $select2->db->whereIn('pc_cities.city_id', $list_city_id);
        }

        $select2->searchFields  = ['pc_districts.dis_name'];
        $select2->orderBy       = 'pc_districts.dis_name';
        $select2->orderDir      = 'ASC';


        $select2->renderResult(function ($row, $i) {
            $result = [];
            $result['id']           = esc($row['dis_id']);
            $result['text']         = esc($row['dis_name']);
            $result['city_id']      = esc($row['city_id']);
            $result['city_name']    = esc($row['city_name']);
            $result['prov_id']      = esc($row['city_id']);
            $result['prov_name']    = esc($row['prov_name']);
            return $result;
        });

        $select2->generate();
    }

    public function pcSubDistricts()
    {
        $this->validationRequest(TRUE);
        $select2 = new \App\Libraries\Select2('pc_postalcode');
        $select2->db->select('pc_postalcode.subdis_id,pc_subdistricts.subdis_name,pc_postalcode.dis_id,pc_districts.dis_name,pc_postalcode.city_id,pc_cities.city_name,pc_postalcode.prov_id,pc_provinces.prov_name,pc_postalcode.postal_code');
        $select2->db->join('pc_subdistricts', 'pc_subdistricts.subdis_id=pc_postalcode.subdis_id');
        $select2->db->join('pc_districts', 'pc_districts.dis_id=pc_postalcode.dis_id');
        $select2->db->join('pc_cities', 'pc_cities.city_id=pc_postalcode.city_id');
        $select2->db->join('pc_provinces', 'pc_provinces.prov_id=pc_postalcode.prov_id');

        $dis_id = $this->request->getGet('dis_id');
        if ($dis_id != NULL) {
            $list_dis_id = explode(',', $dis_id);
            $select2->db->whereIn('pc_postalcode.dis_id', $list_dis_id);
        }

        $select2->searchFields  = ['pc_subdistricts.subdis_name'];
        $select2->orderBy       = 'pc_subdistricts.subdis_name';
        $select2->orderDir      = 'ASC';


        $select2->renderResult(function ($row, $i) {
            $result = [];
            $result['id']           = esc($row['subdis_id']);
            $result['text']         = esc($row['subdis_name']);
            $result['dis_id']       = esc($row['dis_id']);
            $result['dis_name']     = esc($row['dis_name']);
            $result['city_id']      = esc($row['city_id']);
            $result['city_name']    = esc($row['city_name']);
            $result['prov_id']      = esc($row['city_id']);
            $result['prov_name']    = esc($row['prov_name']);
            $result['postal_code']  = esc($row['postal_code']);
            return $result;
        });

        $select2->generate();
    }

    public function unit()
    {
        $this->validationRequest(TRUE);
        $select2 = new \App\Libraries\Select2('ms_unit');

        $select2->db->select('unit_id,unit_name');
        $select2->db->where('deleted', 'N');

        $select2->searchFields  = ['unit_name'];
        $select2->orderBy       = 'unit_name';
        $select2->orderDir      = 'ASC';


        $select2->renderResult(function ($row, $i) {
            $result = [];
            $result['id']   = esc($row['unit_id']);
            $result['text'] = esc($row['unit_name']);
            return $result;
        });

        $select2->generate();
    }






    //--------------------------------------------------------------------

}
