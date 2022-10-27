<?php


namespace App\Controllers\Webmin;

use App\Models\M_mapping_area;
use App\Controllers\Base\WebminController;

class MappingArea extends WebminController
{
    protected $M_mapping_area;
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->M_mapping_area = new M_mapping_area;
    }

    public function index()
    {
        $data = [
            'title'         => 'Mapping Area'
        ];

        return $this->renderView('masterdata/mapping_area', $data, 'mapping_area.view');
    }

    public function table()
    {
        $this->validationRequest(TRUE);
        if ($this->role->hasRole('mapping_area.view')) {
            helper('datatable');
            $prov_id    = $this->request->getPost('prov_id') == NULL ? '' : $this->request->getPost('prov_id');
            $city_id    = $this->request->getPost('city_id') == NULL ? '' : $this->request->getPost('city_id');
            $dis_id     = $this->request->getPost('dis_id') == NULL ? '' : $this->request->getPost('dis_id');
            $subdis_id  = $this->request->getPost('subdis_id') == NULL ? '' : $this->request->getPost('subdis_id');


            $table = new \App\Libraries\Datatables('ms_mapping_area');
            $table->db->select('ms_mapping_area.*,pc_provinces.prov_name,pc_cities.city_name,pc_districts.dis_name,pc_subdistricts.subdis_name');
            $table->db->join('pc_provinces', 'pc_provinces.prov_id=ms_mapping_area.prov_id');
            $table->db->join('pc_cities', 'pc_cities.city_id=ms_mapping_area.city_id');
            $table->db->join('pc_districts', 'pc_districts.dis_id=ms_mapping_area.dis_id');
            $table->db->join('pc_subdistricts', 'pc_subdistricts.subdis_id=ms_mapping_area.subdis_id');
            $table->db->where('ms_mapping_area.deleted', 'N');

            // custom filter //
            if ($prov_id != '') {
                $table->db->where('ms_mapping_area.prov_id', $prov_id);
            }

            if ($city_id != '') {
                $table->db->where('ms_mapping_area.city_id', $city_id);
            }

            if ($dis_id != '') {
                $table->db->where('ms_mapping_area.dis_id', $dis_id);
            }

            if ($subdis_id != '') {
                $table->db->where('ms_mapping_area.subdis_id', $subdis_id);
            }

            $table->renderColumn(function ($row, $i) {
                $column = [];
                $column[] = $i;
                $column[] = esc($row['mapping_code']);
                $column[] = esc($row['prov_name']);
                $column[] = esc($row['city_name']);
                $column[] = esc($row['dis_name']);
                $column[] = esc($row['subdis_name']);
                $column[] = esc($row['postal_code']);
                $column[] = esc($row['mapping_address']);

                $btns = [];
                $prop =  'data-id="' . $row['mapping_id'] . '" data-name="' . esc($row['mapping_address']) . '" data-code="' . esc($row['mapping_code']) . '"';
                $btns[] = button_edit($prop);
                $btns[] = button_delete($prop);
                $column[] = implode('&nbsp;', $btns);
                return $column;
            });

            $table->orderColumn  = ['', 'ms_mapping_area.mapping_code', 'pc_provinces.prov_name', 'pc_cities.city_name', 'pc_districts.dis_name', 'pc_subdistricts.subdis_name', 'ms_mapping_area.postal_code', 'ms_mapping_area.mapping_address', ''];
            $table->searchColumn = ['ms_mapping_area.mapping_code', 'ms_mapping_area.postal_code', 'ms_mapping_area.mapping_address'];
            $table->generate();
        }
    }

    public function getById($mapping_id = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Data area tidak ditemukan'];
        if ($this->role->hasRole('mapping_area.view')) {
            if ($mapping_id != '') {
                $find = $this->M_mapping_area->getMap($mapping_id)->getRowArray();
                if ($find == NULL) {
                    $result = ['success' => TRUE, 'exist' => FALSE, 'message' => 'Data area tidak ditemukan'];
                } else {
                    $find_result = [];
                    foreach ($find as $k => $v) {
                        $find_result[$k] = esc($v);
                    }
                    $result = ['success' => TRUE, 'exist' => TRUE, 'data' => $find_result, 'message' => ''];
                }
            }
        }

        resultJSON($result);
    }

    public function getByAddress()
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Data area tidak ditemukan'];
        if ($this->role->hasRole('mapping_area.view')) {
            $mapping_address    = $this->request->getGet('mapping_address');
            $prov_id            = $this->request->getGet('prov_id');
            $city_id            = $this->request->getGet('city_id');
            $dis_id             = $this->request->getGet('dis_id');
            $subdis_id          = $this->request->getGet('subdis_id');

            if (!($mapping_address == '' || $mapping_address == NULL)) {
                $find = $this->M_mapping_area->getMapByAddress($mapping_address, $prov_id, $city_id, $dis_id, $subdis_id, TRUE)->getRowArray();
                if ($find == NULL) {
                    $result = ['success' => TRUE, 'exist' => FALSE, 'message' => 'Data Area tidak ditemukan'];
                } else {
                    $find_result = array();
                    foreach ($find as $k => $v) {
                        $find_result[$k] = esc($v);
                    }
                    $result = ['success' => TRUE, 'exist' => TRUE, 'data' => $find_result, 'message' => ''];
                }
            }
        }
        resultJSON($result);
    }

    public function save($type)
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        $validation =  \Config\Services::validation();
        $input = [
            'mapping_id'        => $this->request->getPost('mapping_id'),
            'mapping_code'      => $this->request->getPost('mapping_code'),
            'mapping_address'   => $this->request->getPost('mapping_address'),
            'prov_id'           => $this->request->getPost('prov_id'),
            'city_id'           => $this->request->getPost('city_id'),
            'dis_id'            => $this->request->getPost('dis_id'),
            'subdis_id'         => $this->request->getPost('subdis_id'),
            'postal_code'       => $this->request->getPost('postal_code'),
        ];

        $validation->setRules([
            'mapping_id'        => ['rules' => 'required'],
            'mapping_code'      => ['rules' => 'required'],
            'mapping_address'   => ['rules' => 'required|max_length[200]'],
            'prov_id'           => ['rules' => 'required'],
            'city_id'           => ['rules' => 'required'],
            'dis_id'            => ['rules' => 'required'],
            'subdis_id'         => ['rules' => 'required'],
            'postal_code'       => ['rules' => 'required|exact_length[5]'],
        ]);

        if ($validation->run($input) === FALSE) {
            $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        } else {
            if ($type == 'add') {
                if ($this->role->hasRole('mapping_area.add')) {
                    unset($input['mapping_id']);
                    $save = $this->M_mapping_area->insertMap($input);
                    if ($save) {
                        $result = ['success' => TRUE, 'message' => 'Data mapping area berhasil disimpan'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data mapping area gagal disimpan'];
                    }
                } else {
                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menambah data area'];
                }
            } else if ($type == 'edit') {
                if ($this->role->hasRole('mapping_area.edit')) {
                    $save = $this->M_mapping_area->updateMap($input);
                    if ($save) {
                        $result = ['success' => TRUE, 'message' => 'Data mapping area berhasil diperbarui'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data mapping area gagal diperbarui'];
                    }
                } else {
                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk mengubah data area'];
                }
            }
        }


        $result['csrfHash'] = csrf_hash();
        resultJSON($result);
    }

    public function delete($mapping_id = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        if ($this->role->hasRole('mapping_area.delete')) {
            if ($mapping_id != '') {
                $hasCustomer = $this->M_mapping_area->hasCustomer($mapping_id);
                if ($hasCustomer) {
                    $result = ['success' => FALSE, 'message' => 'Mapping area tidak dapat dihapus'];
                } else {
                    $delete = $this->M_mapping_area->deleteMap($mapping_id);
                    if ($delete) {
                        $result = ['success' => TRUE, 'message' => 'Data mapping area berhasil dihapus'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data mapping area gagal dihapus'];
                    }
                }
            }
        } else {
            $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menghapus data area'];
        }
        resultJSON($result);
    }
    //--------------------------------------------------------------------

}
