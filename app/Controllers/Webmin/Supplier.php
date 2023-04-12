<?php


namespace App\Controllers\Webmin;

use App\Models\M_supplier;
use App\Controllers\Base\WebminController;

class Supplier extends WebminController
{
    protected $M_supplier;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->M_supplier = new M_supplier;
    }

    public function index()
    {
        $data = [
            'title'         => 'Supplier'
        ];

        return $this->renderView('masterdata/supplier', $data, 'supplier.view');
    }

    public function table()
    {
        $this->validationRequest(TRUE);
        if ($this->role->hasRole('supplier.view')) {
            helper('datatable');
            $table = new \App\Libraries\Datatables('ms_supplier');
            $table->db->select('ms_supplier.*');
            $table->db->where('ms_supplier.deleted', 'N');

            $table->renderColumn(function ($row, $i) {
                $column = [];
                $column[] = $i;
                $column[] = esc($row['supplier_code']);
                $column[] = esc($row['supplier_name']);
                $column[] = esc($row['supplier_address']);
                $column[] = esc($row['supplier_phone']);
                $btns = [];
                $prop =  'data-id="' . $row['supplier_id'] . '" data-name="' . esc($row['supplier_name']) . '" data-code="' . esc($row['supplier_code']) . '"';
                $btns[] = button_edit($prop);
                $btns[] = button_delete($prop);
                $column[] = implode('&nbsp;', $btns);
                return $column;
            });

            $table->orderColumn  = ['ms_supplier.supplier_id', 'ms_supplier.supplier_code', 'ms_supplier.supplier_name', 'ms_supplier.supplier_address', 'ms_supplier.supplier_phone', ''];
            $table->searchColumn = ['ms_supplier.supplier_code', 'ms_supplier.supplier_name'];
            $table->generate();
        }
    }

    public function getById($supplier_id = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Data supplier tidak ditemukan'];
        if ($this->role->hasRole('supplier.view')) {
            if ($supplier_id != '') {
                $find = $this->M_supplier->getSupplier($supplier_id)->getRowArray();
                if ($find == NULL) {
                    $result = ['success' => TRUE, 'exist' => FALSE, 'message' => 'Data supplier tidak ditemukan'];
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

    public function getByCode()
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Data supplier tidak ditemukan'];
        if ($this->role->hasRole('supplier.view')) {
            $supplier_code = $this->request->getGet('supplier_code');
            if (!($supplier_code == '' || $supplier_code == NULL)) {
                $find = $this->M_supplier->getSupplierByCode($supplier_code, TRUE)->getRowArray();
                if ($find == NULL) {
                    $result = ['success' => TRUE, 'exist' => FALSE, 'message' => 'Data supplier tidak ditemukan'];
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

    public function getByName()
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Data supplier tidak ditemukan'];
        if ($this->role->hasRole('supplier.view')) {
            $supplier_name = $this->request->getGet('supplier_name');
            if (!($supplier_name == '' || $supplier_name == NULL)) {
                $find = $this->M_supplier->getSupplierByName($supplier_name, TRUE)->getRowArray();
                if ($find == NULL) {
                    $result = ['success' => TRUE, 'exist' => FALSE, 'message' => 'Data supplier tidak ditemukan'];
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
            'supplier_id'           => $this->request->getPost('supplier_id'),
            'supplier_code'         => $this->request->getPost('supplier_code'),
            'supplier_name'         => $this->request->getPost('supplier_name'),
            'supplier_address'      => $this->request->getPost('supplier_address'),
            'supplier_phone'        => $this->request->getPost('supplier_phone'),
            'mapping_id'            => $this->request->getPost('mapping_id'),
            'supplier_npwp'         => $this->request->getPost('supplier_npwp'),
            'supplier_remark'       => $this->request->getPost('supplier_remark'),
        ];

        $validation->setRules([
            'supplier_id'           => ['rules' => 'required'],
            'supplier_code'         => ['rules' => 'required|max_length[10]'],
            'supplier_name'         => ['rules' => 'required|max_length[200]'],
            'supplier_address'      => ['rules' => 'max_length[500]'],
            'supplier_phone'        => ['rules' => 'required|min_length[8]|max_length[15]'],
            'mapping_id'            => ['rules' => 'required'],
            'supplier_npwp'         => ['rules' => 'max_length[200]'],
            'supplier_remark'       => ['rules' => 'max_length[500]'],
        ]);

        if ($validation->run($input) === FALSE) {
            $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        } else {
            if ($type == 'add') {
                if ($this->role->hasRole('supplier.add')) {
                    unset($input['supplier_id']);
                    $save = $this->M_supplier->insertSupplier($input);
                    if ($save) {
                        $result = ['success' => TRUE, 'message' => 'Data supplier berhasil disimpan'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data supplier gagal disimpan'];
                    }
                } else {
                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menambah supplier'];
                }
            } else if ($type == 'edit') {
                if ($this->role->hasRole('supplier.edit')) {
                    $save = $this->M_supplier->updateSupplier($input);
                    if ($save) {
                        $result = ['success' => TRUE, 'message' => 'Data supplier berhasil diperbarui'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data supplier gagal diperbarui'];
                    }
                } else {
                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk mengubah supplier'];
                }
            }
        }


        $result['csrfHash'] = csrf_hash();
        resultJSON($result);
    }

    public function delete($supplier_id = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        if ($this->role->hasRole('supplier.delete')) {
            if ($supplier_id != '') {
                $hasTransaction = $this->M_supplier->hasTransaction($supplier_id);
                if ($hasTransaction) {
                    $result = ['success' => FALSE, 'message' => 'Supplier tidak dapat dihapus'];
                } else {
                    $delete = $this->M_supplier->deleteSupplier($supplier_id);
                    if ($delete) {
                        $result = ['success' => TRUE, 'message' => 'Data supplier berhasil dihapus'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data supplier gagal dihapus'];
                    }
                }
            }
        } else {
            $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menghapus supplier'];
        }
        resultJSON($result);
    }


    public function downloadImportExcel()
    {
        $M_mapping_area = model('M_mapping_area');
        $getMap =  $M_mapping_area->getMap()->getResultArray();

        $template = WRITEPATH . '/template/template_import_supplier.xlsx';
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($template);

        $sheet  = $spreadsheet->setActiveSheetIndex(1);
        $iRow   = 2;
        foreach ($getMap as $row) {
            $sheet->getCell('A' . $iRow)->setValue($row['mapping_id']);
            $sheet->getCell('B' . $iRow)->setValue($row['mapping_code']);
            $sheet->getCell('C' . $iRow)->setValue($row['mapping_address']);
            $sheet->getCell('D' . $iRow)->setValue($row['prov_name']);
            $sheet->getCell('E' . $iRow)->setValue($row['city_name']);
            $sheet->getCell('F' . $iRow)->setValue($row['dis_name']);
            $sheet->getCell('G' . $iRow)->setValue($row['subdis_name']);
            $sheet->getCell('H' . $iRow)->setValue($row['postal_code']);
            $iRow++;
        }

        $filename = 'import_data_supplier';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit();
    }

    public function uploadExcel()
    {

        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        $validation =  \Config\Services::validation();

        $input = [
            'file_import'         => $this->request->getFile('file_import')
        ];

        $maxUploadSize = $this->maxUploadSize['kb'];
        $ext = 'xlsx';
        $validation->setRules([
            'file_import' => ['rules' => 'max_size[file_import,' . $maxUploadSize . ']|ext_in[file_import,' . $ext . ']'],
        ]);


        if ($validation->run($input) === FALSE) {
            $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        } else {
            $path = $input['file_import']->store();
            if (!$path) {
                $result = ['success' => FALSE, 'message' => 'Upload file excel gagal, Harap coba lagi'];
            } else {
                $file_path = WRITEPATH . "/uploads/$path";

                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($file_path);
                $reader->setReadDataOnly(TRUE);

                $spreadsheet = $reader->load($file_path);
                $sheet1 = $spreadsheet->getSheet(0)->toArray();
                $sheet2 = $spreadsheet->getSheet(1)->toArray();

                $mappingData    = [];
                $importData     = [];
                // read mapping area //
                // delete header //
                unset($sheet2[0]);
                foreach ($sheet2 as $row) {
                    $mapping_id                 = $row[0];
                    $mapping_code               = $row[1];
                    $mappingData[$mapping_code] = $mapping_id;
                }

                // read supplier data //
                // delete header //
                unset($sheet1[0]);
                foreach ($sheet1 as $row) {
                    $mapping_code   = $row[4];
                    $mapping_id     = isset($mappingData[$mapping_code]) ? $mappingData[$mapping_code] : 0;

                    $npwp           = $row[5] == null ? '' : $row[5];
                    $remark         = $row[6] == null ? '' : $row[6];

                    $importData[] = [
                        'supplier_code'     => $row[0],
                        'supplier_name'     => $row[1],
                        'supplier_phone'    => $row[2],
                        'supplier_address'  => $row[3],
                        'mapping_id'        => $mapping_id,
                        'supplier_npwp'     => $npwp,
                        'supplier_remark'   => $remark,
                    ];
                }


                $cData = count($importData);
                if ($cData > 0) {
                    $result = $this->M_supplier->importSupplier($importData);
                } else {
                    $result = ['success' => FALSE, 'message' => 'Harap isi data excel terlebih dahulu'];
                }

                if (file_exists($file_path)) {
                    unlink($file_path);
                };
            }
        }

        $result['title']    = 'Import Data Supplier';
        $result['back_url'] = base_url('webmin/supplier');
        return $this->renderView('import_result', $result);
    }
    //--------------------------------------------------------------------

}
