<?php

namespace App\Controllers\Webmin\MobileApps;

use App\Models\MobileApps\M_promo;
use App\Controllers\Base\WebminController;


class Promo extends WebminController
{

    protected $M_promo;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->M_promo = new M_promo;
    }

    public function index()
    {
        $data = [
            'title'         => 'Mobile Apps Promo'
        ];
        return $this->renderView('mobileapps/promo', $data, 'mobilepromo.view');
    }

    public function table()
    {
        $this->validationRequest(TRUE);
        if ($this->role->hasRole('mobilepromo.view')) {
            helper('datatable');
            $table = new \App\Libraries\Datatables('ms_mobile_promo');
            $table->db->select('mobile_promo_id,mobile_promo_title,mobile_promo_image,mobile_promo_desc,mobile_promo_start_date,mobile_promo_end_date,active');
            $table->db->where('deleted', 'N');

            $noImage  = base_url('assets/images/no-image.PNG');
            $table->renderColumn(function ($row, $i) use ($noImage) {
                $column = [];
                $column[] = $i;
                $column[] = esc($row['mobile_promo_title']);
                $column[] = indo_short_date($row['mobile_promo_start_date']);
                $column[] = indo_short_date($row['mobile_promo_end_date']);
                if ($row['active'] == 'N') {
                    $column[] = '<span class="badge badge-danger"><i class="fas fa-times-circle"></i></span>';
                } else {
                    $column[] = '<span class="badge badge-success"><i class="fas fa-check-circle"></i></span>';
                }

                $caption = esc($row['mobile_promo_title']);
                $thumbUrl = getImage($row['mobile_promo_image'], 'promo', TRUE, $noImage);
                $imageUrl = getImage($row['mobile_promo_image'], 'promo', FALSE, $noImage);
                $column[] = fancy_image($caption, $imageUrl, $thumbUrl, 'width="60px" height="80px"');

                $btns = [];
                $prop =  'data-id="' . $row['mobile_promo_id'] . '" data-name="' . esc($row['mobile_promo_title']) . '"';

                $btns[] = button_edit($prop);
                $btns[] = button_delete($prop);
                $column[] = implode('&nbsp;', $btns);

                return $column;
            });

            $table->orderColumn  = ['mobile_promo_id', 'mobile_promo_title', 'mobile_promo_start_date', 'mobile_promo_end_date', 'active', '', ''];
            $table->searchColumn = ['mobile_promo_title'];
            $table->generate();
        }
    }


    public function getById($mobile_promo_id = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Data promo tidak ditemukan'];
        if ($this->role->hasRole('mobilepromo.view')) {
            if ($mobile_promo_id != '') {
                $find = $this->M_promo->getPromo($mobile_promo_id)->getRowArray();
                if ($find == NULL) {
                    $result = ['success' => TRUE, 'exist' => FALSE, 'message' => 'Data promo tidak ditemukan'];
                } else {
                    $find_result = [];
                    foreach ($find as $k => $v) {
                        $find_result[$k] = esc($v);
                        if ($k == 'mobile_promo_image') {
                            $noImage  = base_url('assets/images/no-image.PNG');
                            $imageUrl = getImage($v, 'promo', FALSE, $noImage);
                            $find_result['image_url'] = $imageUrl;
                        }
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
            'mobile_promo_id'               => $this->request->getPost('mobile_promo_id'),
            'mobile_promo_title'            => $this->request->getPost('mobile_promo_title'),
            'mobile_promo_desc'             => $this->request->getPost('mobile_promo_desc'),
            'mobile_promo_start_date'       => $this->request->getPost('mobile_promo_start_date'),
            'mobile_promo_end_date'         => $this->request->getPost('mobile_promo_end_date'),
            'active'                        => $this->request->getPost('active'),
            'upload_image'                  => $this->request->getFile('upload_image')
        ];

        $old_promo_image    = $this->request->getPost('old_promo_image');
        $isUploadFile       = FALSE;

        $validation->setRules([
            'mobile_promo_id'           => ['rules' => 'required'],
            'mobile_promo_title'        => ['rules' => 'required'],
            'mobile_promo_desc'         => ['rules' => 'required'],
            'mobile_promo_start_date'   => ['rules' => 'required'],
            'mobile_promo_end_date'     => ['rules' => 'required'],
            'active'                    => ['rules' => 'required'],
        ]);

        if ($input['upload_image'] != NULL) {
            $maxUploadSize = $this->maxUploadSize['kb'];
            $ext = implode(',', $this->myConfig->uploadFileType['image']);
            $validation->setRules([
                'upload_image' => ['label' => 'upload_image', 'rules' => 'max_size[upload_image,' . $maxUploadSize . ']|is_image[upload_image]'],
            ]);
        }

        if ($validation->run($input) === FALSE) {
            $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        } else {
            if ($input['upload_image'] != NULL) {
                helper(['upload', 'text']);
                $renameTo       = random_string('alnum', 10)  . date('dmyHis');
                $uploadImage    = upload_image('upload_image', $renameTo, 'promo');
                if ($uploadImage != '') {
                    $isUploadFile  = TRUE;
                    $input['mobile_promo_image'] = $uploadImage;
                }
            }
            unset($input['upload_image']);
            if ($type == 'add') {
                if ($this->role->hasRole('mobilepromo.add')) {
                    unset($input['mobile_promo_id']);
                    $save = $this->M_promo->insertPromo($input);
                    if ($save) {
                        $result = ['success' => TRUE, 'message' => 'Data promo berhasil disimpan'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data promo gagal disimpan'];
                    }
                } else {
                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menambah promo'];
                }
            } else if ($type == 'edit') {
                if ($this->role->hasRole('mobilepromo.edit')) {
                    $save = $this->M_promo->updatePromo($input);
                    if ($save) {
                        if ($isUploadFile) {
                            deleteImage($old_promo_image, 'promo');
                        }
                        $result = ['success' => TRUE, 'message' => 'Data promo berhasil diperbarui'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data promo gagal diperbarui'];
                    }
                } else {
                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk mengubah promo'];
                }
            }
        }


        $result['csrfHash'] = csrf_hash();
        resultJSON($result);
    }


    public function delete($mobile_promo_id = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        if ($this->role->hasRole('mobilepromo.delete')) {
            if ($mobile_promo_id != '') {
                $delete = $this->M_promo->deletePromo($mobile_promo_id);
                if ($delete) {
                    $result = ['success' => TRUE, 'message' => 'Data promo berhasil dihapus'];
                } else {
                    $result = ['success' => FALSE, 'message' => 'Data promo gagal dihapus'];
                }
            }
        } else {
            $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menghapus promo banner'];
        }
        resultJSON($result);
    }
}
