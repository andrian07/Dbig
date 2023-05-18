<?php


namespace App\Controllers\Webmin;

use Dompdf\Dompdf;
use App\Models\M_voucher;
use App\Controllers\Base\WebminController;

class Voucher extends WebminController
{
    protected $M_voucher;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->M_voucher = new M_voucher;
    }

    public function index()
    {
        $data = [
            'title'         => 'Voucher'
        ];
        return $this->renderView('masterdata/voucher', $data, 'voucher.view');
    }

    public function table()
    {
        $this->validationRequest(TRUE);
        if ($this->role->hasRole('voucher.view')) {
            helper('datatable');
            $table = new \App\Libraries\Datatables('ms_voucher_group');
            $table->db->select('ms_voucher_group.*,(SELECT count(ms_voucher.voucher_id) FROM ms_voucher WHERE ms_voucher.voucher_group_id=ms_voucher_group.voucher_group_id AND ms_voucher.deleted=\'N\') as count_voucher');
            $table->db->where('ms_voucher_group.deleted', 'N');

            $table->renderColumn(function ($row, $i) {
                $column = [];

                $column[] = $i;
                $column[] = esc($row['voucher_name']);
                $column[] = esc($row['voucher_remark']);
                $column[] = numberFormat($row['voucher_value'], TRUE);
                $count_voucher = floatval($row['count_voucher']);
                $column[] = numberFormat($count_voucher, TRUE);
                $column[] = indo_short_date($row['exp_date'], FALSE);

                $btns = [];
                $prop =  'data-id="' . $row['voucher_group_id'] . '" data-name="' . esc($row['voucher_name']) . '"';
                $btns[] = '<button ' . $prop . ' class="btn btn-sm btn-default btndownload mb-2" data-toggle="tooltip" data-placement="top" data-title="Download"><i class="fas fa-download"></i></button>';
                $btns[] = "&nbsp;";
                $btns[] = '<button ' . $prop . ' class="btn btn-sm btn-default btnmanagevoucher mb-2" data-toggle="tooltip" data-placement="top" data-title="Pengaturan Voucher"><i class="fas fa-ticket-alt"></i></button>';
                $btns[] = "<br>";

                $disabled_edit = $count_voucher > 0 ? ' disabled' : ' ';
                $btns[] = button_edit($prop . $disabled_edit);
                $btns[] = "&nbsp;";
                $btns[] = button_delete($prop);
                $column[] = implode('', $btns);

                return $column;
            });

            $table->orderColumn  = ['ms_voucher_group.voucher_group_id', 'ms_voucher_group.voucher_name', 'ms_voucher_group.voucher_remark', 'ms_voucher_group.voucher_value', '', 'ms_voucher_group.exp_date', ''];
            $table->searchColumn = ['ms_voucher_group.voucher_name', 'ms_voucher_group.voucher_remark'];
            $table->generate();
        }
    }

    public function getById($voucher_group_id = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Data voucher tidak ditemukan'];
        if ($this->role->hasRole('voucher.view')) {
            if ($voucher_group_id != '') {
                $find = $this->M_voucher->getVoucherGroup($voucher_group_id)->getRowArray();
                if ($find == NULL) {
                    $result = ['success' => TRUE, 'exist' => FALSE, 'message' => 'Data satuan tidak ditemukan'];
                } else {
                    $noImage  = base_url('assets/images/no-image.PNG');

                    $find_result = [];
                    foreach ($find as $k => $v) {
                        $find_result[$k] = esc($v);
                        if ($k == 'exp_date') {
                            $find_result['indo_exp_date'] = indo_short_date($v);
                        }

                        if ($k == 'voucher_image_cover') {
                            $imageUrl = getImage($v, 'voucher', FALSE, $noImage);
                            $find_result['voucher_image_cover_url'] = $imageUrl;
                        }

                        if ($k == 'voucher_image_backcover') {
                            $imageUrl = getImage($v, 'voucher', FALSE, $noImage);
                            $find_result['voucher_image_backcover_url'] = $imageUrl;
                        }
                    }

                    $category_restriction   = $this->M_voucher->getVoucherCategoryRestriction($voucher_group_id)->getResultArray();
                    $brand_restriction      = $this->M_voucher->getVoucherBrandRestriction($voucher_group_id)->getResultArray();
                    $result = [
                        'success' => TRUE,
                        'exist' => TRUE,
                        'data' => $find_result,
                        'category_restriction'  => $category_restriction,
                        'brand_restriction'     => $brand_restriction,
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
            'voucher_group_id'              => $this->request->getPost('voucher_group_id'),
            'voucher_name'                  => $this->request->getPost('voucher_name'),
            'voucher_remark'                => $this->request->getPost('voucher_remark'),
            'voucher_value'                 => $this->request->getPost('voucher_value'),
            'exp_date'                      => $this->request->getPost('exp_date'),
            'category_restriction'          => $this->request->getPost('category_restriction[]'),
            'brand_restriction'             => $this->request->getPost('brand_restriction[]'),
            'min_sales'                     => $this->request->getPost('min_sales'),
            'upload_image_cover'            => $this->request->getFile('upload_image_cover'),
            'upload_image_backcover'        => $this->request->getFile('upload_image_backcover'),
            'old_cover_image'               => $this->request->getPost('old_cover_image'),
            'old_backcover_image'           => $this->request->getPost('old_backcover_image'),
        ];

        $validation->setRules([
            'voucher_group_id'              => ['rules' => 'required'],
            'voucher_name'                  => ['rules' => 'required|max_length[200]'],
            'voucher_remark'                => ['rules' => 'max_length[500]'],
            'voucher_value'                 => ['rules' => 'required'],
            'exp_date'                      => ['rules' => 'required'],
            'min_sales'                     => ['rules' => 'required'],
        ]);

        $maxUploadSize = $this->maxUploadSize['kb'];
        $ext = implode(',', $this->myConfig->uploadFileType['image']);

        if ($input['upload_image_cover'] != NULL) {
            $validation->setRules([
                'upload_image_cover' => ['rules' => 'max_size[upload_image_cover,' . $maxUploadSize . ']|ext_in[upload_image_cover,' . $ext . ']|is_image[upload_image_cover]'],
            ]);
        }

        if ($input['upload_image_backcover'] != NULL) {
            $validation->setRules([
                'upload_image_backcover' => ['rules' => 'max_size[upload_image_backcover,' . $maxUploadSize . ']|ext_in[upload_image_backcover,' . $ext . ']|is_image[upload_image_backcover]'],
            ]);
        }

        if ($input['category_restriction'] == NULL) {
            $input['category_restriction'] = [];
        }

        if ($input['brand_restriction'] == NULL) {
            $input['brand_restriction'] = [];
        }

        if ($validation->run($input) === FALSE) {
            $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        } else {
            $isUploadCover          = FALSE;
            $isUploadBackCover      = FALSE;
            $old_cover_image        = $input['old_cover_image'];
            $old_backcover_image    = $input['old_backcover_image'];

            helper(['upload', 'text']);
            $base_upload_name = random_string('alnum', 10)  . date('dmyHis');

            if ($input['upload_image_cover'] != NULL) {
                $renameTo       = 'cover_' . $base_upload_name;
                $uploadCover    = upload_image('upload_image_cover', $renameTo, 'voucher');
                if ($uploadCover != '') {
                    $isUploadCover                      = TRUE;
                    $input['voucher_image_cover']       = $uploadCover;
                }
            }

            if ($input['upload_image_backcover'] != NULL) {
                $renameTo           = 'backcover_' . $base_upload_name;
                $uploadBackCover    = upload_image('upload_image_backcover', $renameTo, 'voucher');
                if ($uploadBackCover != '') {
                    $isUploadBackCover                  = TRUE;
                    $input['voucher_image_backcover']   = $uploadBackCover;
                }
            }


            unset($input['upload_image_cover']);
            unset($input['upload_image_backcover']);
            unset($input['old_cover_image']);
            unset($input['old_backcover_image']);

            if ($type == 'add') {
                if ($this->role->hasRole('voucher.add')) {
                    unset($input['voucher_group_id']);
                    $save = $this->M_voucher->insertVoucherGroup($input);
                    if ($save) {
                        if ($isUploadCover) {
                            deleteImage($old_cover_image, 'voucher');
                        }

                        if ($isUploadBackCover) {
                            deleteImage($old_backcover_image, 'voucher');
                        }
                        $result = ['success' => TRUE, 'message' => 'Data voucher berhasil disimpan'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data voucher gagal disimpan'];
                    }
                } else {
                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menambah data voucher'];
                }
            } else if ($type == 'edit') {
                if ($this->role->hasRole('voucher.edit')) {
                    $save = $this->M_voucher->updateVoucherGroup($input);
                    if ($save) {
                        if ($isUploadCover) {
                            deleteImage($old_cover_image, 'voucher');
                        }

                        if ($isUploadBackCover) {
                            deleteImage($old_backcover_image, 'voucher');
                        }
                        $result = ['success' => TRUE, 'message' => 'Data voucher berhasil diperbarui'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data voucher gagal diperbarui'];
                    }
                } else {
                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk mengubah data voucher'];
                }
            }
        }


        $result['csrfHash'] = csrf_hash();
        resultJSON($result);
    }

    public function delete($voucher_group_id = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        if ($this->role->hasRole('voucher.delete')) {
            if ($voucher_group_id != '') {
                $hasVoucher = $this->M_voucher->groupHasVoucher($voucher_group_id);
                if ($hasVoucher) {
                    $result = ['success' => FALSE, 'message' => 'Voucher tidak dapat dihapus'];
                } else {
                    $delete = $this->M_voucher->deleteVoucherGroup($voucher_group_id);
                    if ($delete) {
                        $result = ['success' => TRUE, 'message' => 'Data voucher berhasil dihapus'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data voucher gagal dihapus'];
                    }
                }
            }
        } else {
            $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menghapus voucher'];
        }
        resultJSON($result);
    }

    public function tableVoucher()
    {
        $this->validationRequest(TRUE);
        if ($this->role->hasRole('voucher.view')) {
            helper('datatable');
            $voucher_group_id = $this->request->getPost('voucher_group_id') == NULL ? 0 : $this->request->getPost('voucher_group_id');

            $table = new \App\Libraries\Datatables('ms_voucher');
            $table->db->select('ms_voucher.*,ms_customer.customer_name');
            $table->db->join('ms_customer', 'ms_customer.customer_id=ms_voucher.used_by', 'left');
            $table->db->where('ms_voucher.voucher_group_id', $voucher_group_id);
            $table->db->where('ms_voucher.deleted', 'N');
            $table->renderColumn(function ($row, $i) {
                $column = [];

                $column[] = $i;
                $column[] = esc($row['voucher_code']);

                switch ($row['voucher_status']) {
                    case 'not used':
                        $column[] = badge('Belum Digunakan', 'primary');
                        break;
                    case 'used':
                        $column[] = badge('Sudah Digunakan', 'success');
                        break;
                    case 'expired':
                        $column[] = badge('Expired', 'danger');
                        break;
                    default:
                        $column[] = '';
                }

                $column[] = indo_short_date($row['used_at'], FALSE);
                $column[] = esc($row['customer_name']);

                $disabled = $row['voucher_status'] == 'not used' ? '' : 'disabled';
                $prop =  'data-id="' . $row['voucher_id'] . '" data-code="' . esc($row['voucher_code']) . '" ' . $disabled;
                $column[] = button_delete($prop);

                return $column;
            });

            $table->orderColumn  = ['ms_voucher.voucher_id', 'ms_voucher.voucher_status', 'ms_voucher.used_at', 'ms_voucher.used_by', ''];
            $table->searchColumn = ['ms_voucher.voucher_code'];
            $table->generate();
        }
    }

    public function generateVoucher($voucher_group_id, $count_voucher = 1)
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        if ($this->role->hasRole('voucher.generate_voucher')) {
            if ($voucher_group_id != '') {
                $user_id    = $this->userLogin['user_id'];
                $generate   = $this->M_voucher->generateVoucher($voucher_group_id, $count_voucher, $user_id);

                if ($generate['success']) {
                    $message =  'Berhasil mengenerate ' . numberFormat($count_voucher, FALSE) . ' voucher';
                } else {
                    $message = isset($generate['message']) ? $generate['message'] : 'Gagal mengenerate voucher';
                }

                $result = ['success' => $generate['success'], 'message' => $message];
            }
        } else {
            $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk mengenerate voucher'];
        }
        resultJSON($result);
    }

    public function deleteVoucher($voucher_id = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        if ($this->role->hasRole('voucher.delete')) {
            if ($voucher_id != '') {
                $voucher_code   = $this->request->getGet('voucher_code') == NULL ? '' : $this->request->getGet('voucher_code');
                $delete         = $this->M_voucher->deleteVoucher($voucher_id);
                if ($delete) {
                    $result = ['success' => TRUE, 'message' => 'Voucher <b>' . $voucher_code . '</b> berhasil dihapus'];
                } else {
                    $result = ['success' => FALSE, 'message' => 'Voucher gagal dihapus'];
                }
            }
        } else {
            $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menghapus voucher'];
        }
        resultJSON($result);
    }

    public function exportVoucher($voucher_group_id = '')
    {
        if ($this->role->hasRole('voucher.view')) {
            if ($voucher_group_id != '') {
                $find = $this->M_voucher->getVoucherGroup($voucher_group_id)->getRowArray();
                if ($find == NULL) {
                    throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
                } else {

                    $category_restriction   = $this->M_voucher->getVoucherCategoryRestriction($voucher_group_id)->getResultArray();
                    $brand_restriction      = $this->M_voucher->getVoucherBrandRestriction($voucher_group_id)->getResultArray();
                    $voucher_list           = $this->M_voucher->getVoucher($voucher_group_id)->getResultArray();

                    $list_category = [];
                    foreach ($category_restriction as $row) {
                        $list_category[] = $row['category_name'];
                    }

                    $list_brand = [];
                    foreach ($brand_restriction as $row) {
                        $list_brand[] = $row['brand_name'];
                    }

                    $filter_category    = count($list_category) > 0 ? implode(', ', $list_category) : '-';
                    $filter_brand       = count($list_brand) > 0 ? implode(', ', $list_brand) : '-';

                    $template = WRITEPATH . '/template/template_export_voucher.xlsx';
                    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($template);

                    $sheet2 = $spreadsheet->setActiveSheetIndex(1);
                    $iRow = 2;
                    foreach ($voucher_list as $row) {
                        $voucher_code   = $row['voucher_code'];
                        $voucher_status = '';
                        switch ($row['voucher_status']) {
                            case 'not used':
                                $voucher_status = 'Belum Digunakan';
                                break;
                            case 'used':
                                $voucher_status = 'Sudah Digunakan';
                                break;
                            case 'expired':
                                $voucher_status = 'Expired';
                                break;
                            default:
                                $voucher_status = '';
                        }

                        $used_at    = indo_short_date($row['used_at']);
                        $used_by    = $row['customer_name'];
                        $created_at = indo_short_date($row['created_at']);
                        $created_by = $row['user_realname'];


                        $sheet2->getCell('A' . $iRow)->setValue($voucher_code);
                        $sheet2->getCell('B' . $iRow)->setValue($voucher_status);
                        $sheet2->getCell('C' . $iRow)->setValue($used_at);
                        $sheet2->getCell('D' . $iRow)->setValue($used_by);
                        $sheet2->getCell('E' . $iRow)->setValue($created_at);
                        $sheet2->getCell('F' . $iRow)->setValue($created_by);
                        $iRow++;
                    }

                    $sheet1 = $spreadsheet->setActiveSheetIndex(0);
                    $export_date = indo_short_date(date('Y-m-d H:i:s'));
                    $sheet1->getCell('C1')->setValue($find['voucher_name']);
                    $sheet1->getCell('C2')->setValue($find['voucher_remark']);
                    $sheet1->getCell('C3')->setValue(floatval($find['voucher_value']));
                    $sheet1->getCell('C4')->setValue(indo_short_date($find['exp_date']));
                    $sheet1->getCell('C5')->setValue($filter_category);
                    $sheet1->getCell('C6')->setValue($filter_brand);
                    $sheet1->getCell('C7')->setValue($export_date);

                    $filename = 'voucher_' . url_title($find['voucher_name'], '_', true);
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
                    header('Cache-Control: max-age=0');
                    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
                    $writer->save('php://output');
                    exit();
                }
            } else {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }
        }
    }

    public function printVoucher($voucher_group_id = '')
    {
        $find = $this->M_voucher->getVoucherGroup($voucher_group_id)->getRowArray();
        if ($find == NULL) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        } else {
            $uploadDir                  = isset($this->myConfig->uploadImage['voucher']['upload_dir']) ? $this->myConfig->uploadImage['voucher']['upload_dir'] : '';
            $noImage                    = 'assets/images/no-image.PNG';
            $cover_path                 = $find['voucher_image_cover'] != '' ? $uploadDir . $find['voucher_image_cover'] : $noImage;
            $backcover_path             = $find['voucher_image_backcover'] != '' ? $uploadDir . $find['voucher_image_backcover'] : $noImage;

            $getCover                   = file_get_contents($cover_path);
            $cover_base64               = base64_encode($getCover);
            $getBackCover               = file_get_contents($backcover_path);
            $backcover_base64           = base64_encode($getBackCover);

            $getVoucherList   = $this->M_voucher->getVoucher($voucher_group_id)->getResultArray();
            $voucher_list     = array_chunk($getVoucherList, 6);

            $agent = $this->request->getUserAgent();
            $isDownload = $this->request->getGet('download') == 'Y' ? TRUE : FALSE; // param export
            $fileType   = $this->request->getGet('file'); // jenis file pdf|xlsx 

            if (!in_array($fileType, ['pdf'])) {
                $fileType = 'pdf';
            }



            $data = [
                'title'             => 'Voucher',
                'voucher_group'     => $find,
                'voucher_list'      => $voucher_list,
                'voucher_cover'     => $cover_base64,
                'voucher_backcover' => $backcover_base64
            ];
            $htmlView   = $this->renderView('masterdata/voucher_print', $data);

            if ($agent->isMobile() && !$isDownload) {
                return $htmlView;
            } else {
                if ($fileType == 'pdf') {
                    $dompdf = new Dompdf();
                    $dompdf->loadHtml($htmlView);
                    $dompdf->setPaper('f4', 'landscape');
                    $dompdf->render();
                    $dompdf->stream('voucher.pdf', array("Attachment" => $isDownload));
                    exit();
                }
            }
        }
    }
    //--------------------------------------------------------------------

}
