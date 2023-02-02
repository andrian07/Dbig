<?php

namespace App\Controllers\Webmin\MobileApps;

use App\Models\MobileApps\M_banner;
use App\Controllers\Base\WebminController;


class Banner extends WebminController
{

    protected $M_banner;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->M_banner = new M_banner;
    }

    public function index()
    {
        $data = [
            'title'         => 'Mobile Apps Banner'
        ];
        return $this->renderView('mobileapps/banner', $data, 'mobilebanner.view');
    }

    public function table()
    {
        $this->validationRequest(TRUE);
        if ($this->role->hasRole('mobilebanner.view')) {
            helper('datatable');
            $table = new \App\Libraries\Datatables('ms_mobile_banner');
            $table->db->select('mobile_banner_id ,mobile_banner_title,mobile_banner_image,active');
            $table->db->where('deleted', 'N');
            $noImage  = base_url('assets/images/no-image.PNG');

            $table->renderColumn(function ($row, $i) use ($noImage) {
                $column = [];

                $column[] = $i;
                $column[] = esc($row['mobile_banner_title']);
                $caption = esc($row['mobile_banner_title']);

                $thumbUrl = getImage($row['mobile_banner_image'], 'banner', TRUE, $noImage);
                $imageUrl = getImage($row['mobile_banner_image'], 'banner', FALSE, $noImage);

                $column[] = fancy_image($caption, $imageUrl, $thumbUrl, 'width="60px" height="80px"');
                if ($row['active'] == 'N') {
                    $column[] = '<span class="badge badge-danger"><i class="fas fa-times-circle"></i></span>';
                } else {
                    $column[] = '<span class="badge badge-success"><i class="fas fa-check-circle"></i></span>';
                }
                $btns = [];
                $prop =  'data-id="' . $row['mobile_banner_id'] . '" data-name="' . esc($row['mobile_banner_title']) . '"';

                $btns[] = button_edit($prop);
                $btns[] = button_delete($prop);
                $column[] = implode('&nbsp;', $btns);

                return $column;
            });

            $table->orderColumn  = ['mobile_banner_id', 'mobile_banner_title', 'active', ''];
            $table->searchColumn = ['mobile_banner_title'];
            $table->generate();
        }
    }

    public function getById($banner_id = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Data Banner tidak ditemukan'];
        if ($this->role->hasRole('mobilebanner.view')) {
            if ($banner_id != '') {
                $find = $this->M_banner->getBanner($banner_id)->getRowArray();
                if ($find == NULL) {
                    $result = ['success' => TRUE, 'exist' => FALSE, 'message' => 'Data Banner tidak ditemukan'];
                } else {
                    $find_result = [];
                    foreach ($find as $k => $v) {
                        $find_result[$k] = esc($v);
                        if ($k == 'mobile_banner_image') {
                            $noImage  = base_url('assets/images/no-image.PNG');
                            $imageUrl = getImage($v, 'banner', FALSE, $noImage);
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
            'mobile_banner_id'            => $this->request->getPost('banner_id'),
            'mobile_banner_title'         => $this->request->getPost('title_banner'),
            'active'                      => $this->request->getPost('active'),
            'upload_image'                => $this->request->getFile('upload_image')
        ];

        $old_banner_image   = $this->request->getPost('old_banner_image');
        $isUploadFile       = FALSE;

        $validation->setRules([
            'mobile_banner_id'        => ['rules' => 'required'],
            'mobile_banner_title'     => ['rules' => 'required'],
            'active'                  => ['rules' => 'required'],
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
                    unset($input['mobile_banner_id']);
                    $save = $this->M_banner->insertBanner($input);
                    if ($save) {
                        $result = ['success' => TRUE, 'message' => 'Data Banner berhasil disimpan'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data Banner gagal disimpan'];
                    }
                } else {
                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menambah Banner'];
                }
            } else if ($type == 'edit') {
                if ($this->role->hasRole('mobilebanner.edit')) {
                    $save = $this->M_banner->updateBanner($input);
                    if ($save) {
                        if ($isUploadFile) {
                            deleteImage($old_banner_image, 'banner');
                        }
                        $result = ['success' => TRUE, 'message' => 'Data Banner berhasil diperbarui'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data Banner gagal diperbarui'];
                    }
                } else {
                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk mengubah Banner'];
                }
            }
        }


        $result['csrfHash'] = csrf_hash();
        resultJSON($result);
    }


    public function delete($mobile_banner_id = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        if ($this->role->hasRole('mobilebanner.delete')) {
            if ($mobile_banner_id != '') {
                $delete = $this->M_banner->deleteBanner($mobile_banner_id);
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
}
