<?php


namespace App\Controllers\Webmin;

use App\Models\M_point_reward;
use App\Controllers\Base\WebminController;

class PointReward extends WebminController
{
    protected $M_point_reward;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->M_point_reward = new M_point_reward;
    }

    public function index()
    {
        $data = [
            'title'             => 'Hadiah Poin',
        ];
        return $this->renderView('customer_point/point_reward', $data, 'point_reward.view');
    }


    public function table()
    {
        $this->validationRequest(TRUE);
        if ($this->role->hasRole('point_reward.view')) {
            helper('datatable');
            $table = new \App\Libraries\Datatables('ms_point_reward');
            $table->db->select('ms_point_reward.*');
            $table->db->where('ms_point_reward.deleted', 'N');

            $table->renderColumn(function ($row, $i) {
                $column = [];
                $column[] = $i;
                $column[] = esc($row['reward_code']);
                $column[] = esc($row['reward_name']);
                $column[] = numberFormat($row['reward_point'], true);
                $column[] = indo_short_date($row['start_date']);
                $column[] = indo_short_date($row['end_date']);
                $column[] = numberFormat($row['reward_stock'], true);
                $column[] = $row['active'] == 'Y' ? activeSymbol(TRUE) : activeSymbol(FALSE);

                $noImage  = base_url('assets/images/no-image.PNG');
                $thumbUrl = getImage($row['reward_image'], 'reward_point', TRUE, $noImage);
                $imageUrl = getImage($row['reward_image'], 'reward_point', FALSE, $noImage);
                $column[] = fancy_image(esc($row['reward_name']), $imageUrl, $thumbUrl, 'img-thumbnail');


                $btns = [];
                $prop =  'data-id="' . $row['reward_id'] . '" data-name="' . esc($row['reward_name']) . '" data-code="' . esc($row['reward_code']) . '"';
                $btns[] = button_edit($prop);
                $btns[] = '&nbsp;';
                $btns[] = button_delete($prop);
                $column[] = implode('', $btns);

                return $column;
            });

            $table->orderColumn  = ['', 'ms_point_reward.reward_code', 'ms_point_reward.reward_name', 'ms_point_reward.reward_point', 'ms_point_reward.start_date', 'ms_point_reward.end_date', 'ms_point_reward.reward_stock', 'ms_point_reward.active', '', ''];
            $table->searchColumn = ['ms_point_reward.reward_code', 'ms_point_reward.reward_name'];
            $table->generate();
        }
    }

    public function getById($reward_id = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Data hadiah tidak ditemukan'];
        if ($this->role->hasRole('point_reward.view')) {
            if ($reward_id != '') {
                $find = $this->M_point_reward->getReward($reward_id)->getRowArray();
                if ($find == NULL) {
                    $result = ['success' => TRUE, 'exist' => FALSE, 'message' => 'Data hadiah tidak ditemukan'];
                } else {
                    $find_result = [];
                    foreach ($find as $k => $v) {
                        $find_result[$k] = esc($v);
                        if ($k == 'reward_image') {
                            $noImage  = base_url('assets/images/no-image.PNG');
                            $imageUrl = getImage($v, 'reward_point', FALSE, $noImage);
                            $find_result['image_url'] = $imageUrl;
                        }
                    }

                    $result = [
                        'success' => TRUE,
                        'exist' => TRUE,
                        'data' => $find_result,
                        'message' => ''
                    ];
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
            'reward_id'             => $this->request->getPost('reward_id'),
            'reward_code'           => $this->request->getPost('reward_code'),
            'reward_name'           => $this->request->getPost('reward_name'),
            'reward_point'          => $this->request->getPost('reward_point'),
            'reward_description'    => $this->request->getPost('reward_description'),
            'reward_stock'          => $this->request->getPost('reward_stock'),
            'start_date'            => $this->request->getPost('start_date'),
            'end_date'              => $this->request->getPost('end_date'),
            'active'                => $this->request->getPost('active'),
            'upload_image'          => $this->request->getFile('upload_image')
        ];

        $old_reward_image  = $this->request->getPost('old_reward_image');
        $isUploadFile       = FALSE;

        $validation->setRules([
            'reward_id'            => ['rules' => 'required'],
            'reward_code'          => ['rules' => 'required|max_length[8]'],
            'reward_name'          => ['rules' => 'required|max_length[200]'],
            'reward_point'         => ['rules' => 'required'],
            'reward_stock'         => ['rules' => 'required'],
            'start_date'           => ['rules' => 'required'],
            'end_date'             => ['rules' => 'required'],
            'end_date'             => ['rules' => 'required'],
            'active'               => ['rules' => 'required|in_list[Y,N]'],
        ]);

        if ($input['upload_image'] != NULL) {
            $maxUploadSize = $this->maxUploadSize['kb'];
            $ext = implode(',', $this->myConfig->uploadFileType['image']);
            $validation->setRules([
                'upload_image' => ['rules' => 'max_size[upload_image,' . $maxUploadSize . ']|ext_in[upload_image,' . $ext . ']|is_image[upload_image]'],
            ]);
        }

        if ($validation->run($input) === FALSE) {
            $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        } else {
            if ($input['upload_image'] != NULL) {
                helper(['upload', 'text']);
                $renameTo       = random_string('alnum', 10)  . date('dmyHis');;
                $uploadImage    = upload_image('upload_image', $renameTo, 'reward_point');
                if ($uploadImage != '') {
                    $isUploadFile  = TRUE;
                    $input['reward_image'] = $uploadImage;
                }
            }
            unset($input['upload_image']);

            if ($type == 'add') {
                if ($this->role->hasRole('point_reward.add')) {
                    unset($input['reward_id']);
                    $save = $this->M_point_reward->insertReward($input);
                    if ($save) {
                        if ($isUploadFile) {
                            deleteImage($old_reward_image, 'reward_point');
                        }
                        $result = ['success' => TRUE, 'message' => 'Data hadiah berhasil disimpan'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data hadiah gagal disimpan'];
                    }
                } else {
                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menambah hadiah'];
                }
            } else if ($type == 'edit') {
                if ($this->role->hasRole('point_reward.edit')) {
                    $save = $this->M_point_reward->updateReward($input);
                    if ($save) {
                        if ($isUploadFile) {
                            deleteImage($old_reward_image, 'reward_point');
                        }
                        $result = ['success' => TRUE, 'message' => 'Data hadiah berhasil diperbarui'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data hadiah gagal diperbarui'];
                    }
                } else {
                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk mengubah hadiah'];
                }
            }
        }


        $result['csrfHash'] = csrf_hash();
        resultJSON($result);
    }

    public function delete($reward_id = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        if ($this->role->hasRole('reward_point.delete')) {
            $hasExchange = 0;
            if ($hasExchange) {
                $result = ['success' => FALSE, 'message' => 'Hadiah tidak dapat dihapus'];
            } else {
                if ($reward_id != '') {
                    $delete = $this->M_point_reward->deleteReward($reward_id);
                    if ($delete) {
                        $result = ['success' => TRUE, 'message' => 'Data hadiah berhasil dihapus'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data hadiah gagal dihapus'];
                    }
                }
            }
        } else {
            $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menghapus hadiah'];
        }
        resultJSON($result);
    }
    //--------------------------------------------------------------------

}
