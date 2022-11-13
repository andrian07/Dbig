<?php

namespace App\Controllers\Webmin\Mobileapps;

use App\Models\M_mobile;
use App\Controllers\Base\WebminController;


class Mobileapps extends WebminController
{

    protected $M_mobile;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->M_mobile = new M_mobile;
    }

    public function index(){

    }

    public function mobileappsBanner(){
        $data = [
            'title'         => 'Mobile Apps Banner'
        ];
        return $this->renderView('mobileapps/mobileapps_banner', $data);
    }

    public function mobileappsPromo(){
        $data = [
            'title'         => 'Mobile Apps Promo'
        ];
        return $this->renderView('mobileapps/mobileapps_promo', $data);
    }

    public function tablebanner()
    {
        $this->validationRequest(TRUE);
        if ($this->role->hasRole('mobilebanner.view')) {
        helper('datatable');
        $table = new \App\Libraries\Datatables('ms_mobile_banner');
        $table->db->select('mobile_banner_id ,mobile_banner_title,mobile_banner_image,active');
        $table->db->where('deleted', 'N');

        $table->renderColumn(function ($row, $i) {
            $column = [];

            $column[] = $i;
            $column[] = esc($row['mobile_banner_title']);
            $caption = esc($row['mobile_banner_title']);
            $imageUrl = base_url().'/contents/upload/banner/'. esc($row['mobile_banner_image']);
            $thumbUrl = base_url().'/contents/thumb/banner/'.  esc($row['mobile_banner_image']);
            $column[] = fancy_image($caption, $imageUrl, $thumbUrl, $imageClass = 'width="60px" height="80px"');
            if($row['active'] == 'N'){
                $column[] = '<span class="badge badge-danger"><i class="fas fa-times-circle"></i></span>';
            }else{
                $column[] = '<span class="badge badge-success"><i class="fas fa-check-circle"></i></span>';
            }
            $btns = [];
            $prop =  'data-id="' . $row['mobile_banner_id'] . '" data-name="' . esc($row['mobile_banner_title']) . '"';

            $btns[] = button_edit($prop);
            $btns[] = button_delete($prop);
            $column[] = implode('&nbsp;', $btns);

            return $column;
        });

        $table->orderColumn  = ['', 'mobile_banner_title', 'active', ''];
        $table->searchColumn = ['mobile_banner_id', 'active'];
        $table->generate();
        }
    }

    public function tablepromo()
    {
        $this->validationRequest(TRUE);
        if ($this->role->hasRole('mobilepromo.view')) {
        helper('datatable');
        $table = new \App\Libraries\Datatables('ms_mobile_promo');
        $table->db->select('mobile_promo_id,mobile_promo_title,mobile_promo_image,mobile_promo_desc,mobile_promo_start_date,mobile_promo_end_date,active');
        $table->db->where('deleted', 'N');

        $table->renderColumn(function ($row, $i) {
            $column = [];
            $column[] = $i;
            $column[] = esc($row['mobile_promo_title']);
            $caption = esc($row['mobile_promo_title']);
            $imageUrl = base_url().'/contents/upload/banner/'. esc($row['mobile_promo_image']);
            $thumbUrl = base_url().'/contents/thumb/banner/'.  esc($row['mobile_promo_image']);
            $column[] = fancy_image($caption, $imageUrl, $thumbUrl, $imageClass = 'width="60px" height="80px"');
            $column[] = esc($row['mobile_promo_desc']);
            $column[] = esc($row['mobile_promo_start_date']);
            $column[] = esc($row['mobile_promo_end_date']);
            if($row['active'] == 'N'){
                $column[] = '<span class="badge badge-danger"><i class="fas fa-times-circle"></i></span>';
            }else{
                $column[] = '<span class="badge badge-success"><i class="fas fa-check-circle"></i></span>';
            }
            $btns = [];
            $prop =  'data-id="' . $row['mobile_promo_id'] . '" data-name="' . esc($row['mobile_promo_title']) . '"';

            $btns[] = button_edit($prop);
            $btns[] = button_delete($prop);
            $column[] = implode('&nbsp;', $btns);

            return $column;
        });

        $table->orderColumn  = ['', 'mobile_promo_title', 'active', ''];
        $table->searchColumn = ['mobile_promo_id','mobile_promo_title','active'];
        $table->generate();
        }
    }

    public function getById($banner_id = ''){
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Data Banner tidak ditemukan'];
        if ($this->role->hasRole('mobilebanner.view')) {
            if ($banner_id != '') {
                $find = $this->M_mobile->getBanner($banner_id)->getRowArray();
                if ($find == NULL) {
                    $result = ['success' => TRUE, 'exist' => FALSE, 'message' => 'Data Banner tidak ditemukan'];
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

    public function savebanner($type){
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        $validation =  \Config\Services::validation();

        $input = [
            'mobile_banner_id'            => $this->request->getPost('banner_id'),
            'mobile_banner_title'         => $this->request->getPost('title_banner'),
            'active'                      => $this->request->getPost('active'),
            'upload_image'                => $this->request->getFile('upload_image')
        ];

        $old_product_image  = $this->request->getPost('old_product_image');
        $isUploadFile       = FALSE;

        $validation->setRules([
            'title_banner'            => ['rules' => 'required'],
            'active'                  => ['rules' => 'required'],
            'upload_image'            => ['rules' => 'required']
        ]);

        if ($input['upload_image'] != NULL) {
            $maxUploadSize = $this->maxUploadSize['kb'];
            $ext = implode(',', $this->myConfig->uploadFileType['image']);
            $validation->setRules([
                'upload_image' => ['label' => 'upload_image', 'rules' => 'max_size[upload_image,' . $maxUploadSize . ']|ext_in[upload_image,' . $ext . ']|is_image[upload_image]'],
            ]);
        }

        if ($validation->run($input) === FALSE) {
            $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        } else {
            if ($input['upload_image'] != NULL) {
                helper(['upload', 'text']);
                $renameTo       = random_string('alnum', 10)  . date('dmyHis');;
                $uploadImage    = upload_image('upload_image', $renameTo, 'banner');
                if ($uploadImage != '') {
                    $isUploadFile  = TRUE;
                    $input['mobile_banner_image'] = $uploadImage;
                }
            }
            unset($input['upload_image']);
            if ($type == 'add') {
                if ($this->role->hasRole('mobilebanner.add')) {
                    unset($input['upload_image']);
                    $save = $this->M_mobile->insertbanner($input);
                    if ($save) {
                        if ($isUploadFile) {
                            deleteImage($old_product_image, 'banner');
                        }
                        $result = ['success' => TRUE, 'message' => 'Data Banner berhasil disimpan'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data Banner gagal disimpan'];
                    }
                } else if ($type == 'edit') {
                    if ($this->role->hasRole('mobilebanner.edit')) {
                        $save = $this->M_mobile->updateBanner($input);
                        if ($save) {
                            $result = ['success' => TRUE, 'message' => 'Data Banner berhasil diperbarui'];
                        } else {
                            $result = ['success' => FALSE, 'message' => 'Data Banner gagal diperbarui'];
                        }
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk mengubah Banner'];
                    }
                }
                else {
                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menambah atau mengubah banner'];
                }
            } 
        }


        $result['csrfHash'] = csrf_hash();
        resultJSON($result);
    }


    public function savepromo($type){
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        $validation =  \Config\Services::validation();

        $input = [
            'mobile_promo_id'           => $this->request->getPost('mobile_promo_id'),
            'mobile_promo_title'        => $this->request->getPost('mobile_promo_title'),
            'mobile_promo_desc'         => $this->request->getPost('mobile_promo_desc'),
            'mobile_promo_start_date'   => $this->request->getPost('mobile_promo_start_date'),
            'mobile_promo_end_date'     => $this->request->getPost('mobile_promo_end_date'),
            'active'                    => $this->request->getPost('active'),
            'upload_image'              => $this->request->getFile('upload_image')
        ];

        $old_product_image  = $this->request->getPost('old_product_image');
        $isUploadFile       = FALSE;

        $validation->setRules([
            'mobile_promo_title'      => ['rules' => 'required'],
            'active'                  => ['rules' => 'required'],
            'mobile_promo_start_date' => ['rules' => 'required'],
            'mobile_promo_end_date'   => ['rules' => 'required'],
        ]);

        if ($input['upload_image'] != NULL) {
            $maxUploadSize = $this->maxUploadSize['kb'];
            $ext = implode(',', $this->myConfig->uploadFileType['image']);
            $validation->setRules([
                'upload_image' => ['label' => 'upload_image', 'rules' => 'max_size[upload_image,' . $maxUploadSize . ']|ext_in[upload_image,' . $ext . ']|is_image[upload_image]'],
            ]);
        }

        if ($validation->run($input) === FALSE) {
            $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        } else {
            if ($input['upload_image'] != NULL) {
                helper(['upload', 'text']);
                $renameTo       = random_string('alnum', 10)  . date('dmyHis');;
                $uploadImage    = upload_image('upload_image', $renameTo, 'banner');
                if ($uploadImage != '') {
                    $isUploadFile  = TRUE;
                    $input['mobile_promo_image'] = $uploadImage;
                }
            }
            unset($input['upload_image']);
            if ($type == 'add') {
                if ($this->role->hasRole('mobilepromo.add')) {
                    unset($input['upload_image']);
                    $save = $this->M_mobile->insertporomo($input);
                    if ($save) {
                        if ($isUploadFile) {
                            deleteImage($old_product_image, 'promo');
                        }
                        $result = ['success' => TRUE, 'message' => 'Data Promo berhasil disimpan'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data Promo gagal disimpan'];
                    }
                } else if ($type == 'edit') {
                    if ($this->role->hasRole('mobilepromo.edit')) {
                        $save = $this->M_mobile->updateBanner($input);
                        if ($save) {
                            $result = ['success' => TRUE, 'message' => 'Data Promo berhasil diperbarui'];
                        } else {
                            $result = ['success' => FALSE, 'message' => 'Data Promo gagal diperbarui'];
                        }
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk mengubah Promo'];
                    }
                }
                else {
                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menambah atau mengubah Promo'];
                }
            } 
        }


        $result['csrfHash'] = csrf_hash();
        resultJSON($result);
    }


    public function deletebanner($mobile_banner_id = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        if ($this->role->hasRole('mobilebanner.delete')) {
            if ($mobile_banner_id != '') {
                $delete = $this->M_mobile->deleteBanner($mobile_banner_id);
                if ($delete) {
                    $result = ['success' => TRUE, 'message' => 'Data Banner berhasil dihapus'];
                } else {
                    $result = ['success' => FALSE, 'message' => 'Data Banner gagal dihapus'];
                }
            }
        } else {
            $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menghapus promo banner'];
        }
        resultJSON($result);
    }

    public function deletepromo($mobile_promo_id  = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        if ($this->role->hasRole('mobilepromo.delete')) {
            if ($mobile_promo_id != '') {
                $delete = $this->M_mobile->deletepromo($mobile_promo_id );
                if ($delete) {
                    $result = ['success' => TRUE, 'message' => 'Data Promo berhasil dihapus'];
                } else {
                    $result = ['success' => FALSE, 'message' => 'Data Promo gagal dihapus'];
                }
            }
        } else {
            $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menghapus Promo banner'];
        }
        resultJSON($result);
    }

}
