<?php
$themeUrl = base_url('assets/adminlte3');
$assetsUrl = base_url('assets');
?>

<?= $this->extend('webmin/template/admin_template') ?>

<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Produk</h1>
            </div>
            <div class="col-sm-6"></div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- /.col -->
            <div id="product_list" class="col-md-12">
                <div class="card">
                    <div class="card-header p-2">
                        <button id="btnadd" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah</button>
                        <button id="btnreload" class="btn btn-secondary"><i class="fas fa-sync"></i> Reload</button>
                        <div class="btn-group">
                            <button type="button" class="btn btn-success"><i class="fas fa-file-excel"></i> Import Excel</button>
                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                                <a class="dropdown-item" href="#">Template File Excel</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <select id="filter_category" name="filter_category" class="form-control">
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Brand</label>
                                    <select id="filter_brand" name="filter_brand" class="form-control">
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Supplier</label>
                                    <select id="filter_supplier" name="filter_supplier" class="form-control">
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Jenis Produk</label>
                                    <select id="filter_product_type" name="filter_product_type" class="form-control">
                                        <option value="">Semua</option>
                                        <option value="Y">Paket</option>
                                        <option value="N">Produk</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <table id="tblproduct" class="table table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th data-priority="1">#</th>
                                    <th data-priority="2">Nama Produk</th>
                                    <th data-priority="4">Brand</th>
                                    <th data-priority="5">Kategori</th>
                                    <th data-priority="6">Supplier</th>
                                    <th data-priority="7">Paket</th>
                                    <th data-priority="8">PPN</th>
                                    <th data-priority="9">Aktif</th>
                                    <th data-priority="10">Gambar Produk</th>
                                    <th data-priority="3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>


            <div id="product_setup" class="col-md-12">
                <div class="card">
                    <div class="card-header p-2">
                        <h4>Pengaturan Satuan & Harga</h4>
                    </div>
                    <div class="card-body">
                        <table width="100%" class="mb-3">
                            <tr>
                                <th width="15%">Kode Produk</th>
                                <td width="1%">:</td>
                                <td width="84%" id="setup_product_code"></td>
                            </tr>
                            <tr>
                                <th>Nama Produk</th>
                                <td>:</td>
                                <td id="setup_product_name"></td>
                            </tr>
                            <tr>
                                <th>Satuan Dasar</th>
                                <td>:</td>
                                <td id="setup_base_unit"></td>
                            </tr>
                        </table>

                        <div class="table-responsive">
                            <table id="tblitem" class="table table-bordered table-hover" width="100%">
                                <thead>
                                    <tr>
                                        <th rowspan="2">Aksi</th>
                                        <th rowspan="2">Barcode</th>
                                        <th rowspan="2" class="" width="120px">Satuan</th>
                                        <th rowspan="2" class="text-right">Isi</th>
                                        <th rowspan="2" class="text-right">DPP</th>
                                        <th rowspan="2" class="text-right">PPN</th>
                                        <th rowspan="2" class="text-right">Harga Beli</th>
                                        <th colspan="2" class="text-center">G1 - UMUM</th>
                                        <th colspan="2" class="text-center">G2 - SILVER</th>
                                        <th colspan="2" class="text-center">G3 - GOLD</th>
                                        <th colspan="2" class="text-center">G4 - PLATINUM</th>
                                        <th colspan="2" class="text-center">G5 - PROYEK</th>
                                        <th colspan="2" class="text-center">G6 - CUSTOM</th>


                                        <th colspan="9" class="text-center">Diskon Seasonal</th>

                                        <!-- Sisa Margin -->
                                        <th colspan="2" class="text-center">G1 - UMUM</th>
                                        <th colspan="2" class="text-center">G2 - SILVER</th>
                                        <th colspan="2" class="text-center">G3 - GOLD</th>
                                        <th colspan="2" class="text-center">G4 - PLATINUM</th>
                                        <th colspan="2" class="text-center">G5 - PROYEK</th>
                                        <th colspan="2" class="text-center">G6 - CUSTOM</th>

                                        <th colspan="7" class="text-center">Alokasi Margin</th>




                                        <th rowspan="2" class="text-center">Dijual</th>
                                        <th rowspan="2" class="text-center">Tampilkan&nbsp;Di<br>Mobile&nbsp;Apps</th>
                                        <th rowspan="2" class="text-center">Ijinkan<br>Ubah&nbsp;Harga</th>
                                    </tr>
                                    <tr>
                                        <!-- Margin-->
                                        <th class="text-right">Margin </th>
                                        <th class="text-right">Hrg.Jual</th>
                                        <th class="text-right">Margin </th>
                                        <th class="text-right">Hrg.Jual</th>
                                        <th class="text-right">Margin </th>
                                        <th class="text-right">Hrg.Jual</th>
                                        <th class="text-right">Margin </th>
                                        <th class="text-right">Hrg.Jual</th>
                                        <th class="text-right">Margin </th>
                                        <th class="text-right">Hrg.Jual</th>
                                        <th class="text-right">Margin </th>
                                        <th class="text-right">Hrg.Jual</th>

                                        <!-- Diskon Seasonal -->
                                        <th class="text-right">Diskon</th>

                                        <th class="text-right">G1&nbsp;-&nbsp;UMUM</th>
                                        <th class="text-right">G2&nbsp;-&nbsp;SILVER</th>
                                        <th class="text-right">G3&nbsp;-&nbsp;GOLD</th>
                                        <th class="text-right">G4&nbsp;-&nbsp;PLATINUM</th>
                                        <th class="text-right">G5&nbsp;-&nbsp;PROYEK</th>
                                        <th class="text-right">G6&nbsp;-&nbsp;CUSTOM</th>
                                        <th class="">Mulai&nbsp;Tanggal</th>
                                        <th class="">S.d&nbsp;Tanggal</th>

                                        <!-- Margin-->
                                        <th class="text-right">Sisa&nbsp;Margin </th>
                                        <th class="text-right">Margin</th>
                                        <th class="text-right">Sisa&nbsp;Margin </th>
                                        <th class="text-right">Margin</th>
                                        <th class="text-right">Sisa&nbsp;Margin </th>
                                        <th class="text-right">Margin</th>
                                        <th class="text-right">Sisa&nbsp;Margin </th>
                                        <th class="text-right">Margin</th>
                                        <th class="text-right">Sisa.&nbsp;Margin </th>
                                        <th class="text-right">Margin</th>
                                        <th class="text-right">Sisa.&nbsp;Margin </th>
                                        <th class="text-right">Margin</th>

                                        <!-- Alokasi Margin -->
                                        <th class="text-right">Alokasi</th>
                                        <th class="text-right">G1&nbsp;-&nbsp;UMUM</th>
                                        <th class="text-right">G2&nbsp;-&nbsp;SILVER</th>
                                        <th class="text-right">G3&nbsp;-&nbsp;GOLD</th>
                                        <th class="text-right">G4&nbsp;-&nbsp;PLATINUM</th>
                                        <th class="text-right">G5&nbsp;-&nbsp;PROYEK</th>
                                        <th class="text-right">G6&nbsp;-&nbsp;CUSTOM</th>




                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <td colspan="50">
                                        <a href="#" id="btnadd_item">
                                            <i class="fas fa-plus"></i> Tambahkan
                                        </a>
                                    </td>
                                    <template id="item_base_unit_template">
                                        <tr>
                                            <td>
                                                <div class="btn-group">
                                                    <button data-id="{item_id}" data-json="{data_json}" class="btn btn-sm btn-warning btnedit" data-toggle="tooltip" data-placement="top" data-title="Edit"><i class="fas fa-edit"></i></button>
                                                    <button data-id="{item_id}" data-json="{data_json}" type="button" class="btn btn-sm btn-default btnsetdisc" data-toggle="tooltip" data-placement="top" data-title="Atur Diskon"><i class="fas fa-percent"></i></button>
                                                </div>
                                            </td>
                                            <td>{item_code}</td>
                                            <td>{unit_name}</td>
                                            <td class="text-right">{product_content}</td>
                                            <td class="text-right">{product_price}</td>
                                            <td class="text-right">{product_tax}</td>
                                            <td class="text-right">{net_price}</td>

                                            <!-- margin -->
                                            <td class="text-right">{MR_G1}%</td>
                                            <td class="text-right">{SP_G1}</td>
                                            <td class="text-right">{MR_G2}%</td>
                                            <td class="text-right">{SP_G2}</td>
                                            <td class="text-right">{MR_G3}%</td>
                                            <td class="text-right">{SP_G3}</td>
                                            <td class="text-right">{MR_G4}%</td>
                                            <td class="text-right">{SP_G4}</td>
                                            <td class="text-right">{MR_G5}%</td>
                                            <td class="text-right">{SP_G5}</td>
                                            <td class="text-right">{MR_G6}%</td>
                                            <td class="text-right">{SP_G6}</td>

                                            <!-- disc seasonal -->
                                            <td class="text-right">{disc_seasonal}%</td>
                                            <td class="text-right">{disc_G1}</td>
                                            <td class="text-right">{disc_G2}</td>
                                            <td class="text-right">{disc_G3}</td>
                                            <td class="text-right">{disc_G4}</td>
                                            <td class="text-right">{disc_G5}</td>
                                            <td class="text-right">{disc_G6}</td>
                                            <td>{disc_start_date}</td>
                                            <td>{disc_end_date}</td>

                                            <!-- Sisa Margin -->
                                            <td class="text-right">{remain_margin_G1}%</td>
                                            <td class="text-right">{margin_G1}</td>
                                            <td class="text-right">{remain_margin_G2}%</td>
                                            <td class="text-right">{margin_G2}</td>
                                            <td class="text-right">{remain_margin_G3}%</td>
                                            <td class="text-right">{margin_G3}</td>
                                            <td class="text-right">{remain_margin_G4}%</td>
                                            <td class="text-right">{margin_G4}</td>
                                            <td class="text-right">{remain_margin_G5}%</td>
                                            <td class="text-right">{margin_G5}</td>
                                            <td class="text-right">{remain_margin_G6}%</td>
                                            <td class="text-right">{margin_G6}</td>


                                            <!-- alokasi -->
                                            <td class="text-right">{margin_allocation}%</td>
                                            <td class="text-right">{margin_allocation_G1}</td>
                                            <td class="text-right">{margin_allocation_G2}</td>
                                            <td class="text-right">{margin_allocation_G3}</td>
                                            <td class="text-right">{margin_allocation_G4}</td>
                                            <td class="text-right">{margin_allocation_G5}</td>
                                            <td class="text-right">{margin_allocation_G6}</td>

                                            <td class="text-center">{is_sale}</td>
                                            <td class="text-center">{show_in_mobile_apps}</td>
                                            <td class="text-center">{allow_change_price}</td>
                                        </tr>
                                    </template>
                                    <template id="item_unit_template">
                                        <tr>
                                            <td>
                                                <div class="btn-group">
                                                    <button data-id="{item_id}" data-json="{data_json}" type="button" class="btn btn-sm btn-warning btnedit" data-toggle="tooltip" data-placement="top" data-title="Edit"><i class="fas fa-edit"></i></button>
                                                    <button data-id="{item_id}" data-json="{data_json}" type="button" class="btn btn-sm btn-default btnsetdisc" data-toggle="tooltip" data-placement="top" data-title="Atur Diskon"><i class="fas fa-percent"></i></button>
                                                    <button data-id="{item_id}" type="button" class="btn btn-sm btn-danger btndelete" data-toggle="tooltip" data-placement="top" data-title="Hapus"><i class="fas fa-times"></i></button>
                                                </div>
                                            </td>
                                            <td>{item_code}</td>
                                            <td>{unit_name}</td>
                                            <td class="text-right">{product_content}</td>
                                            <td class="text-right">{product_price}</td>
                                            <td class="text-right">{product_tax}</td>
                                            <td class="text-right">{net_price}</td>

                                            <!-- margin -->
                                            <td class="text-right">{MR_G1}%</td>
                                            <td class="text-right">{SP_G1}</td>
                                            <td class="text-right">{MR_G2}%</td>
                                            <td class="text-right">{SP_G2}</td>
                                            <td class="text-right">{MR_G3}%</td>
                                            <td class="text-right">{SP_G3}</td>
                                            <td class="text-right">{MR_G4}%</td>
                                            <td class="text-right">{SP_G4}</td>
                                            <td class="text-right">{MR_G5}%</td>
                                            <td class="text-right">{SP_G5}</td>
                                            <td class="text-right">{MR_G6}%</td>
                                            <td class="text-right">{SP_G6}</td>

                                            <!-- disc seasonal -->
                                            <td class="text-right">{disc_seasonal}%</td>
                                            <td class="text-right">{disc_G1}</td>
                                            <td class="text-right">{disc_G2}</td>
                                            <td class="text-right">{disc_G3}</td>
                                            <td class="text-right">{disc_G4}</td>
                                            <td class="text-right">{disc_G5}</td>
                                            <td class="text-right">{disc_G6}</td>
                                            <td>{disc_start_date}</td>
                                            <td>{disc_end_date}</td>

                                            <!-- Sisa Margin -->
                                            <td class="text-right">{remain_margin_G1}%</td>
                                            <td class="text-right">{margin_G1}</td>
                                            <td class="text-right">{remain_margin_G2}%</td>
                                            <td class="text-right">{margin_G2}</td>
                                            <td class="text-right">{remain_margin_G3}%</td>
                                            <td class="text-right">{margin_G3}</td>
                                            <td class="text-right">{remain_margin_G4}%</td>
                                            <td class="text-right">{margin_G4}</td>
                                            <td class="text-right">{remain_margin_G5}%</td>
                                            <td class="text-right">{margin_G5}</td>
                                            <td class="text-right">{remain_margin_G6}%</td>
                                            <td class="text-right">{margin_G6}</td>


                                            <!-- alokasi -->
                                            <td class="text-right">{margin_allocation}%</td>
                                            <td class="text-right">{margin_allocation_G1}</td>
                                            <td class="text-right">{margin_allocation_G2}</td>
                                            <td class="text-right">{margin_allocation_G3}</td>
                                            <td class="text-right">{margin_allocation_G4}</td>
                                            <td class="text-right">{margin_allocation_G5}</td>
                                            <td class="text-right">{margin_allocation_G6}</td>

                                            <td class="text-center">{is_sale}</td>
                                            <td class="text-center">{show_in_mobile_apps}</td>
                                            <td class="text-center">{allow_change_price}</td>
                                        </tr>
                                    </template>
                                </tfoot>
                            </table>
                        </div>
                        <div class="justify-content-between mt-2">
                            <button class="btn btn-danger close-setup-page"><i class="fas fa-arrow-circle-left"></i> Kembali</button>
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>


            <div id="parcel_setup" class="col-md-12">
                <div class="card">
                    <div class="card-header p-2">
                        <h4>Pengaturan Satuan & Harga Paket</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="custom-content-above-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-content-above-list-tab" data-toggle="pill" href="#custom-content-above-list" role="tab" aria-controls="custom-content-above-home" aria-selected="true">List Produk Paket</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-content-above-price-tab" data-toggle="pill" href="#custom-content-above-price" role="tab" aria-controls="custom-content-above-profile" aria-selected="false">Harga Jual Paket</a>
                            </li>

                        </ul>
                        <div class="tab-custom-content">
                            <table width="100%" class="mb-3">
                                <tr>
                                    <th width="15%">Kode Produk</th>
                                    <td width="1%">:</td>
                                    <td width="84%" id="setup_product_code">P000003</td>
                                </tr>
                                <tr>
                                    <th>Nama Produk</th>
                                    <td>:</td>
                                    <td id="setup_product_name">Paket Double Toto</td>
                                </tr>
                                <tr>
                                    <th>Satuan Dasar</th>
                                    <td>:</td>
                                    <td id="setup_base_unit">PCS</td>
                                </tr>
                            </table>
                        </div>
                        <div class="tab-content" id="custom-content-above-tabContent">
                            <div class="tab-pane fade show active" id="custom-content-above-list" role="tabpanel" aria-labelledby="custom-content-above-home-tab">
                                <form class="mb-2">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <!-- text input -->
                                            <div class="form-group">
                                                <label>Produk</label>
                                                <input id="parcel_item" name="product_item" type="text" class="form-control" placeholder="ketikkan nama produk atau barcode" value="" data-parsley-vproductname required>
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <!-- text input -->
                                            <div class="form-group">
                                                <label>Qty</label>
                                                <input id="parcel_qty" name="parcel_qty" type="text" class="form-control text-right" value="0" data-parsley-vprice required>
                                            </div>
                                        </div>

                                        <div class="col-sm-1">
                                            <!-- text input -->
                                            <label>&nbsp;</label>
                                            <div class="form-group">
                                                <div class="col-12">
                                                    <button id="btnadd_temp" class="btn btn-md btn-primary rounded-circle float-right"><i class="fas fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>


                                <div class="table-responsive">
                                    <table id="tblitem" class="table table-bordered table-hover" width="100%">
                                        <thead>
                                            <tr>
                                                <th rowspan="2">Aksi</th>
                                                <th rowspan="2" class="">Item</th>
                                                <th rowspan="2" class="text-right">Qty</th>
                                                <th rowspan="2">Satuan</th>
                                                <th rowspan="2" class="text-right">Harga Beli</th>
                                                <th colspan="2" class="text-center">G1 - UMUM</th>
                                                <th colspan="2" class="text-center">G2 - SILVER</th>
                                                <th colspan="2" class="text-center">G3 - GOLD</th>
                                                <th colspan="2" class="text-center">G4 - PLATINUM</th>
                                                <th colspan="2" class="text-center">G5 - PROYEK</th>
                                                <th colspan="2" class="text-center">G6 - CUSTOM</th>

                                            </tr>
                                            <tr>
                                                <th class="text-right">Margin </th>
                                                <th class="text-right">Hrg.Jual</th>
                                                <th class="text-right">Margin </th>
                                                <th class="text-right">Hrg.Jual</th>
                                                <th class="text-right">Margin </th>
                                                <th class="text-right">Hrg.Jual</th>
                                                <th class="text-right">Margin </th>
                                                <th class="text-right">Hrg.Jual</th>
                                                <th class="text-right">Margin </th>
                                                <th class="text-right">Hrg.Jual</th>
                                                <th class="text-right">Margin </th>
                                                <th class="text-right">Hrg.Jual</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-sm btn-warning btnedit" data-toggle="tooltip" data-placement="top" data-title="Edit"><i class="fas fa-edit"></i></button>
                                                        <button type="button" class="btn btn-sm btn-danger btndelete" data-toggle="tooltip" data-placement="top" data-title="Hapus"><i class="fas fa-times"></i></button>
                                                    </div>
                                                </td>
                                                <td>
                                                    <b>1234567890123</b><br>
                                                    Toto Gantungan Double Robe Hook (TX04AES)
                                                </td>
                                                <td class="text-right">1.00</td>
                                                <td class="text-right">PCS</td>
                                                <td class="text-right">27,750.00</td>
                                                <td class="text-right">50.00%</td>
                                                <td class="text-right">41,700.00</td>
                                                <td class="text-right">40.00%</td>
                                                <td class="text-right">38,900.00</td>
                                                <td class="text-right">30.00%</td>
                                                <td class="text-right">36,100.00</td>
                                                <td class="text-right">20.00%</td>
                                                <td class="text-right">33,300.00</td>
                                                <td class="text-right">20.00%</td>
                                                <td class="text-right">33,300.00</td>
                                                <td class="text-right">50.00%</td>
                                                <td class="text-right">41,700.00</td>

                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-sm btn-warning btnedit" data-toggle="tooltip" data-placement="top" data-title="Edit"><i class="fas fa-edit"></i></button>
                                                        <button type="button" class="btn btn-sm btn-danger btndelete" data-toggle="tooltip" data-placement="top" data-title="Hapus"><i class="fas fa-times"></i></button>
                                                    </div>
                                                </td>
                                                <td>
                                                    <b>1234567877777</b><br>
                                                    Toto Floor Drain (TX1DA)
                                                </td>
                                                <td class="text-right">2.00</td>
                                                <td>PCS</td>
                                                <td class="text-right">50,000.00</td>
                                                <td class="text-right">50.00%</td>
                                                <td class="text-right">75,000.00</td>
                                                <td class="text-right">40.00%</td>
                                                <td class="text-right">70,000.00</td>
                                                <td class="text-right">30.00%</td>
                                                <td class="text-right">65,000.00</td>
                                                <td class="text-right">20.00%</td>
                                                <td class="text-right">60,000.00</td>
                                                <td class="text-right">20.00%</td>
                                                <td class="text-right">60,000.00</td>
                                                <td class="text-right">50.00%</td>
                                                <td class="text-right">75,000.00</td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="4" class="text-right">TOTAL</th>
                                                <th class="text-right">77,750.00</th>
                                                <th colspan="2" class="text-right">116,700.00</th>
                                                <th colspan="2" class="text-right">108,900.00</th>
                                                <th colspan="2" class="text-right">101,100.00</th>
                                                <th colspan="2" class="text-right">93,300.00</th>
                                                <th colspan="2" class="text-right">93,300.00</th>
                                                <th colspan="2" class="text-right">116,700.00</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="custom-content-above-price" role="tabpanel" aria-labelledby="custom-content-above-profile-tab">
                                <div class="row">
                                    <div class="col-md-6 border-right border-primary">
                                        <input id="item_id" name="item_id" value="" type="hidden">

                                        <div class="form-group">
                                            <label for="item_code" class="col-sm-12">Kode Item / Barcode</label>
                                            <div class="col-sm-12">
                                                <input id="item_code" name="item_code" type="text" class="form-control" maxlength="55" data-parsley-trigger-after-failure="focusout" data-parsley-vitemcode value="9999999888777" required />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="unit_id" class="col-sm-12">Satuan</label>
                                            <div class="col-sm-12 sel2">
                                                <select id="unit_id" name="unit_id" class="form-control" required></select>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="purchase_price" class="col-sm-12">TOTAL DPP</label>
                                            <div class="col-sm-12">
                                                <input id="parcel_price" name="parcel_price" type="text" class="form-control text-right" data-parsley-vpurchaseprice value="0" readonly />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="purchase_tax" class="col-sm-12">TOTAL PPN</label>
                                            <div class="col-sm-12">
                                                <input id="parcel_tax" name="parcel_tax" type="text" class="form-control text-right" data-parsley-vpurchaseprice value="0" readonly />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="purchase_price_with_tax" class="col-sm-12">Modal Paket</label>
                                            <div class="col-sm-12">
                                                <input id="parcel_cost" name="parcel_cost" type="text" class="form-control text-right" value="0" readonly />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="parcel_margin_allocation" class="col-sm-12">Alokasi Margin</label>
                                            <div class="col-sm-12">
                                                <input id="parcel_margin_allocation" name="parcel_margin_allocation" type="text" class="form-control text-right" value="0" />
                                            </div>
                                        </div>

                                        <div class="form-check">
                                            <div class="col-sm-12">
                                                <input type="checkbox" class="form-check-input" id="parcel_mobile_app">
                                                <label class="form-check-label" for="parcel_mobile_app" checked>Tampilkan di Mobile Apps</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <label for="promo_price" class="col-sm-12">G1 - UMUM</label>
                                            <div class="col-sm-12">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <input id="parcel_margin_rate_G1" name="parcel_margin_rate_G1" type="text" class="form-control text-right" value="0" />
                                                    </div>

                                                    <div class="col-sm-8">
                                                        <input id="parcel_sales_price_G1" name="parcel_sales_price_G1" type="text" class="form-control text-right" data-parsley-vsalesprice value="0" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="promo_price" class="col-sm-12">G2 - SILVER</label>
                                            <div class="col-sm-12">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <input id="parcel_margin_rate_G2" name="parcel_margin_rate_G2" type="text" class="form-control text-right" value="0" />
                                                    </div>

                                                    <div class="col-sm-8">
                                                        <input id="parcel_sales_price_G2" name="parcel_sales_price_G2" type="text" class="form-control text-right" data-parsley-vsalesprice value="0" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="promo_price" class="col-sm-12">G3 - GOLD</label>
                                            <div class="col-sm-12">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <input id="parcel_margin_rate_G3" name="parcel_margin_rate_G3" type="text" class="form-control text-right" value="0" />
                                                    </div>

                                                    <div class="col-sm-8">
                                                        <input id="parcel_sales_price_G3" name="parcel_sales_price_G3" type="text" class="form-control text-right" data-parsley-vsalesprice value="0" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="promo_price" class="col-sm-12">G4 - PLATINUM</label>
                                            <div class="col-sm-12">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <input id="parcel_margin_rate_G4" name="parcel_margin_rate_G4" type="text" class="form-control text-right" value="0" />
                                                    </div>

                                                    <div class="col-sm-8">
                                                        <input id="parcel_sales_price_G4" name="parcel_sales_price_G4" type="text" class="form-control text-right" data-parsley-vsalesprice value="0" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="promo_price" class="col-sm-12">G5 - PROYEK</label>
                                            <div class="col-sm-12">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <input id="parcel_margin_rate_G5" name="parcel_margin_rate_G5" type="text" class="form-control text-right" value="0" />
                                                    </div>

                                                    <div class="col-sm-8">
                                                        <input id="parcel_sales_price_G5" name="parcel_sales_price_G5" type="text" class="form-control text-right" data-parsley-vsalesprice value="0" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="promo_price" class="col-sm-12">G6 - CUSTOM</label>
                                            <div class="col-sm-12">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <input id="parcel_margin_rate_G6" name="parcel_margin_rate_G6" type="text" class="form-control text-right" value="0" />
                                                    </div>

                                                    <div class="col-sm-8">
                                                        <input id="parcel_sales_price_G6" name="parcel_sales_price_G6" type="text" class="form-control text-right" data-parsley-vsalesprice value="0" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="parcel_disc_seasonal" class="col-sm-12">Disc Seasonal</label>
                                            <div class="col-sm-12">
                                                <input id="parcel_disc_seasonal" name="parcel_disc_seasonal" type="text" class="form-control text-right" value="0" />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="parcel_disc_start_date" class="col-sm-12">Mulai Tanggal</label>
                                            <div class="col-sm-12">
                                                <input id="parcel_disc_start_date" name="parcel_disc_start_date" type="date" class="form-control" value="" />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="parcel_disc_end_date" class="col-sm-12">Sampai Tanggal</label>
                                            <div class="col-sm-12">
                                                <input id="parcel_disc_end_date" name="parcel_disc_end_date" type="date" class="form-control" value="" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mt-3">


                                        <p class="text-center"><b>Detail Disc & Margin</b></p>
                                        <table class="table table-striped table-hover table-bordered">
                                            <thead>
                                                <tr>
                                                    <td>Grup</td>
                                                    <td>Harga Jual<small>(Rp)</small></td>
                                                    <td>Margin <small>(Rp)</small></td>
                                                    <td>Sisa Margin</td>
                                                    <td>Alokasi Margin <small>(Rp)</small></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>G1&nbsp;-&nbsp;UMUM</td>
                                                    <td class="text-right">107,200</td>
                                                    <td class="text-right">29,400.00</td>
                                                    <td class="text-right">38.00%</td>
                                                    <td class="text-right">14,675.00</td>
                                                </tr>
                                                <tr>
                                                    <td>G2&nbsp;-&nbsp;SILVER</td>
                                                    <td class="text-right">99,800.00</td>
                                                    <td class="text-right">22,000.00</td>
                                                    <td class="text-right">28.00%</td>
                                                    <td class="text-right">11,000.00</td>
                                                </tr>
                                                <tr>
                                                    <td>G3&nbsp;-&nbsp;GOLD</td>
                                                    <td class="text-right">92,400.00</td>
                                                    <td class="text-right">14,600.00</td>
                                                    <td class="text-right">20.00%</td>
                                                    <td class="text-right">7,300.00</td>
                                                </tr>
                                                <tr>
                                                    <td>G4&nbsp;-&nbsp;PLATINUM</td>
                                                    <td class="text-right">85,000.00</td>
                                                    <td class="text-right">7,200.00</td>
                                                    <td class="text-right">9.00%</td>
                                                    <td class="text-right">3,600.00</td>
                                                </tr>
                                                <tr>
                                                    <td>G5&nbsp;-&nbsp;PROYEK</td>
                                                    <td class="text-right">107,200</td>
                                                    <td class="text-right">29,400.00</td>
                                                    <td class="text-right">38.00%</td>
                                                    <td class="text-right">14,675.00</td>
                                                </tr>
                                                <tr>
                                                    <td>G6&nbsp;-&nbsp;CUSTOM</td>
                                                    <td class="text-right">107,200</td>
                                                    <td class="text-right">29,400.00</td>
                                                    <td class="text-right">38.00%</td>
                                                    <td class="text-right">14,675.00</td>
                                                </tr>
                                            </tbody>
                                        </table>



                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="justify-content-between mt-2">
                            <button class="btn btn-danger close-setup-parcel"><i class="fas fa-arrow-circle-left"></i> Kembali</button>
                            <button id="btnsave_parcel" class="btn btn-success close-setup-parcel float-right"><i class="fas fa-save"></i> Simpan</button>

                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="modal fade" id="modal-product">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="title-frmproduct"></h4>
                        <button type="button" class="close close-modal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-3">
                                <img id="product_image" src="" width="100%" height="200px">
                                <?php
                                $allow_ext = [];
                                foreach ($upload_file_type['image'] as $ext) {
                                    $allow_ext[] = '.' . $ext;
                                }
                                ?>
                                <input type="file" name="upload_image" id="upload_image" accept="<?= implode(',', $allow_ext) ?>" hidden>
                                <button id="btnupload" class="btn btn-primary btn-block mt-2"><i class="fas fa-cloud-upload-alt"></i> Unggah Gambar</button>
                            </div>
                            <div class="col-md-9">
                                <form id="frmproduct" class="form-horizontal">
                                    <input id="product_id" name="product_id" value="0" type="hidden">
                                    <input id="old_product_image" name="old_product_image" value="0" type="hidden">

                                    <div class="form-group">
                                        <label for="product_name" class="col-sm-12">Nama Produk</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Nama Produk" value="" data-parsley-maxlength="200" data-parsley-trigger-after-failure="focusout" data-parsley-vproductname required>
                                        </div>
                                    </div>

                                    <div id="input_product">
                                        <div class="form-group">
                                            <label for="category_id" class="col-sm-12">Kategori</label>
                                            <div class="col-sm-12 sel2">
                                                <select id="category_id" name="category_id" class="form-control" required></select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="brand_id" class="col-sm-12">Brand</label>
                                            <div class="col-sm-12 sel2">
                                                <select id="brand_id" name="brand_id" class="form-control" required></select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="supplier_id" class="col-sm-12">Supplier</label>
                                            <div class="col-sm-12 sel2">
                                                <select id="supplier_id" name="supplier_id[]" class="form-control" multiple="multiple" required></select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="has_tax" class="col-sm-12">Golongan Produk</label>
                                            <div class="col-sm-12">
                                                <select id="has_tax" name="has_tax" class="form-control">
                                                    <option value="Y">Barang Kena Pajak (BKP)</option>
                                                    <option value="N">Barang Tidak Kena Pajak (NON BKP)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="base_unit_input" class="form-group">
                                        <label for="base_unit" class="col-sm-12">Satuan Dasar</label>
                                        <div class="col-sm-12 sel2">
                                            <select id="base_unit" name="base_unit" class="form-control"></select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="is_parcel" class="col-sm-12">Jenis Produk</label>
                                        <div class="col-sm-12">
                                            <select id="is_parcel" name="is_parcel" class="form-control">
                                                <option value="N">Produk</option>
                                                <option value="Y">Paket</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="min_stock" class="col-sm-12">Min.Stok</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="min_stock" name="min_stock" placeholder="min.stok" value="" required>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="active" class="col-sm-12">Status</label>
                                        <div class="col-sm-12">
                                            <select id="active" name="active" class="form-control">
                                                <option value="Y" selected>Aktif</option>
                                                <option value="N">Tidak Aktif</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="product_description" class="col-sm-12">Deskripsi</label>
                                        <div class="col-sm-12">
                                            <textarea id="product_description" name="product_description" class="form-control" rows="10"></textarea>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button id="btncancel" class="btn btn-danger close-modal"><i class="fas fa-times-circle"></i> Batal</button>
                        <button id="btnsave" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
                    </div>

                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <div class="modal fade" id="modal-item">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="title-frmitem"></h4>
                        <button type="button" class="close close-modal-item">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="frmitem" class="form-horizontal">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-3 border-right border-primary">
                                    <p class="text-center"><b>Detail Item</b></p>
                                    <input id="item_id" name="item_id" value="" type="hidden">

                                    <div class="form-group">
                                        <label for="item_code" class="col-sm-12">Kode Item / Barcode</label>
                                        <div class="col-sm-12">
                                            <input id="item_code" name="item_code" type="text" class="form-control" maxlength="55" data-parsley-trigger-after-failure="focusout" data-parsley-vitemcode value="" required />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="unit_id" class="col-sm-12">Satuan</label>
                                        <div class="col-sm-12 sel2">
                                            <select id="unit_id" name="unit_id" class="form-control" required></select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="product_content" class="col-sm-12">Isi</label>
                                        <div class="col-sm-12">
                                            <input id="product_content" name="product_content" type="text" class="form-control text-right" min="1" value="0" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="purchase_price" class="col-sm-12">DPP</label>
                                        <div class="col-sm-12">
                                            <input id="purchase_price" name="purchase_price" type="text" class="form-control text-right" data-parsley-vpurchaseprice value="0" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="purchase_tax" class="col-sm-12">PPN <?= PPN_TEXT ?></label>
                                        <div class="col-sm-12">
                                            <input id="purchase_tax" name="purchase_tax" type="text" class="form-control text-right" data-parsley-vpurchaseprice value="0" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="purchase_price_with_tax" class="col-sm-12">Harga Beli</label>
                                        <div class="col-sm-12">
                                            <input id="purchase_price_with_tax" name="purchase_price_with_tax" type="text" class="form-control text-right" value="0" readonly />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="margin_allocation" class="col-sm-12">Alokasi Margin</label>
                                        <div class="col-sm-12">
                                            <input id="margin_allocation" name="margin_allocation" type="text" class="form-control text-right" value="0" />
                                        </div>
                                    </div>

                                    <div class="form-check">
                                        <div class="col-sm-12">
                                            <input type="checkbox" class="form-check-input" id="is_sale" name="is_sale">
                                            <label class="form-check-label" for="is_sale">Dijual</label>
                                        </div>
                                    </div>
                                    <div class="form-check">
                                        <div class="col-sm-12">
                                            <input type="checkbox" class="form-check-input" id="show_mobile_app" name="show_mobile_app">
                                            <label class="form-check-label" for="show_mobile_app">Tampilkan di Mobile Apps</label>
                                        </div>
                                    </div>
                                    <div class="form-check">
                                        <div class="col-sm-12">
                                            <input type="checkbox" class="form-check-input" id="allow_change_price" name="allow_change_price">
                                            <label class="form-check-label" for="allow_change_price">Ijinkan Ubah Harga di POS</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 border-right border-primary">
                                    <p class="text-center"><b>Margin Dan Harga Jual</b></p>

                                    <div class="form-group">
                                        <label for="promo_price" class="col-sm-12">G1 - <?= isset($customer_group['G1']) ? $customer_group['G1'] : 'NO CONFIG' ?></label>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <input id="margin_rate_G1" name="margin_rate_G1" type="text" class="form-control text-right" value="0" />
                                                </div>

                                                <div class="col-sm-8">
                                                    <input id="sales_price_G1" name="sales_price_G1" type="text" class="form-control text-right" data-parsley-vsalespriceG1 value="0" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="promo_price" class="col-sm-12">G2 - <?= isset($customer_group['G2']) ? $customer_group['G2'] : 'NO CONFIG' ?></label>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <input id="margin_rate_G2" name="margin_rate_G2" type="text" class="form-control text-right" value="0" />
                                                </div>

                                                <div class="col-sm-8">
                                                    <input id="sales_price_G2" name="sales_price_G2" type="text" class="form-control text-right" data-parsley-vsalespriceG2 value="0" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="promo_price" class="col-sm-12">G3 - <?= isset($customer_group['G3']) ? $customer_group['G3'] : 'NO CONFIG' ?></label>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <input id="margin_rate_G3" name="margin_rate_G3" type="text" class="form-control text-right" value="0" />
                                                </div>

                                                <div class="col-sm-8">
                                                    <input id="sales_price_G3" name="sales_price_G3" type="text" class="form-control text-right" data-parsley-vsalespriceG3 value="0" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="promo_price" class="col-sm-12">G4 - <?= isset($customer_group['G4']) ? $customer_group['G4'] : 'NO CONFIG' ?></label>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <input id="margin_rate_G4" name="margin_rate_G4" type="text" class="form-control text-right" value="0" />
                                                </div>

                                                <div class="col-sm-8">
                                                    <input id="sales_price_G4" name="sales_price_G4" type="text" class="form-control text-right" data-parsley-vsalespriceG4 value="0" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="promo_price" class="col-sm-12">G5 - <?= isset($customer_group['G5']) ? $customer_group['G5'] : 'NO CONFIG' ?></label>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <input id="margin_rate_G5" name="margin_rate_G5" type="text" class="form-control text-right" value="0" />
                                                </div>

                                                <div class="col-sm-8">
                                                    <input id="sales_price_G5" name="sales_price_G5" type="text" class="form-control text-right" data-parsley-vsalespriceG5 value="0" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="promo_price" class="col-sm-12">G6 - <?= isset($customer_group['G6']) ? $customer_group['G6'] : 'NO CONFIG' ?></label>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <input id="margin_rate_G6" name="margin_rate_G6" type="text" class="form-control text-right" value="0" />
                                                </div>

                                                <div class="col-sm-8">
                                                    <input id="sales_price_G6" name="sales_price_G6" type="text" class="form-control text-right" data-parsley-vsalespriceG6 value="0" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <p class="text-center"><b>Disc Seasonal</b></p>
                                    <div class="form-group">
                                        <label for="disc_seasonal" class="col-sm-12">Disc Seasonal</label>
                                        <div class="col-sm-12">
                                            <input id="disc_seasonal" name="disc_seasonal" type="text" class="form-control text-right" value="0" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="disc_start_date" class="col-sm-12">Mulai Tanggal</label>
                                        <div class="col-sm-12">
                                            <input id="disc_start_date" name="disc_start_date" type="date" class="form-control" value="" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="disc_end_date" class="col-sm-12">Sampai Tanggal</label>
                                        <div class="col-sm-12">
                                            <input id="disc_end_date" name="disc_end_date" type="date" class="form-control" value="" />
                                        </div>
                                    </div>

                                    <p class="text-center"><b>Detail Disc & Margin</b></p>
                                    <table class="table table-striped table-hover table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Grup</th>
                                                <th>Harga Diskon <small>(Rp)</small></th>
                                                <th>Margin <small>(Rp)</small></th>
                                                <th>Sisa Margin</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>G1&nbsp;-&nbsp;<?= isset($customer_group['G1']) ? $customer_group['G1'] : 'NO CONFIG' ?></td>
                                                <td class="text-right" id="view_disc_G1">0.00</td>
                                                <td class="text-right" id="view_margin_G1">0.00</td>
                                                <td class="text-right" id="view_remain_margin_G1">0.00</td>
                                            </tr>
                                            <tr>
                                                <td>G2&nbsp;-&nbsp;<?= isset($customer_group['G2']) ? $customer_group['G2'] : 'NO CONFIG' ?></td>
                                                <td class="text-right" id="view_disc_G2">0.00</td>
                                                <td class="text-right" id="view_margin_G2">0.00</td>
                                                <td class="text-right" id="view_remain_margin_G2">0.00</td>
                                            </tr>
                                            <tr>
                                                <td>G3&nbsp;-&nbsp;<?= isset($customer_group['G3']) ? $customer_group['G3'] : 'NO CONFIG' ?></td>
                                                <td class="text-right" id="view_disc_G3">0.00</td>
                                                <td class="text-right" id="view_margin_G3">0.00</td>
                                                <td class="text-right" id="view_remain_margin_G3">0.00</td>
                                            </tr>
                                            <tr>
                                                <td>G4&nbsp;-&nbsp;<?= isset($customer_group['G4']) ? $customer_group['G4'] : 'NO CONFIG' ?></td>
                                                <td class="text-right" id="view_disc_G4">0.00</td>
                                                <td class="text-right" id="view_margin_G4">0.00</td>
                                                <td class="text-right" id="view_remain_margin_G4">0.00</td>
                                            </tr>
                                            <tr>
                                                <td>G5&nbsp;-&nbsp;<?= isset($customer_group['G5']) ? $customer_group['G5'] : 'NO CONFIG' ?></td>
                                                <td class="text-right" id="view_disc_G5">0.00</td>
                                                <td class="text-right" id="view_margin_G5">0.00</td>
                                                <td class="text-right" id="view_remain_margin_G5">0.00</td>
                                            </tr>
                                            <tr>
                                                <td>G6&nbsp;-&nbsp;<?= isset($customer_group['G6']) ? $customer_group['G6'] : 'NO CONFIG' ?></td>
                                                <td class="text-right" id="view_disc_G6">0.00</td>
                                                <td class="text-right" id="view_margin_G6">0.00</td>
                                                <td class="text-right" id="view_remain_margin_G6">0.00</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button class="btn btn-danger close-modal-item"><i class="fas fa-times-circle"></i> Batal</button>
                            <button id="btnsave_item" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

    </div><!-- /.container-fluid -->
</section>

<!-- /.content -->
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    $(document).ready(function() {
        const noImage = '<?= base_url('assets/images/no-image.PNG') ?>';
        const badgeStatus = {
            active: '<span class="badge badge-success"><i class="fas fa-check-circle"></i></span>',
            notActive: '<span class="badge badge-danger"><i class="fas fa-times-circle"></i></span>'
        };

        let formMode = '';

        function showPage(id_page) {
            $('#product_list').hide();
            $('#product_setup').hide();
            $('#parcel_setup').hide();
            $(id_page).show();
        }

        // datatables //
        let tblproduct = $("#tblproduct").DataTable({
            processing: true,
            select: true,
            serverSide: true,
            responsive: true,
            fixedColumns: true,
            order: [
                [1, 'asc']
            ],
            language: {
                url: lang_datatables,
            },
            ajax: {
                url: base_url + '/webmin/product/table',
                type: "POST",
                data: function(d) {
                    return $.extend({}, d, {
                        'filter_category': $('#filter_category').val(),
                        'filter_brand': $('#filter_brand').val(),
                        'filter_supplier': $('#filter_supplier').val(),
                        'filter_product_type': $('#filter_product_type').val(),
                    });
                },
                error: function() {
                    notification.danger('Gagal memuat table, harap coba lagi');
                },
            },
            drawCallback: function(settings) {
                _initTooltip();
                //_initButton();
            },
            columnDefs: [{
                    width: 100,
                    targets: 9
                },
                {
                    targets: [0, 4, 8, 9],
                    orderable: false,
                    searchable: false,
                },
                {
                    targets: [5, 6, 7, 8],
                    className: "text-center",
                },
                {
                    targets: [0],
                    className: "text-right",
                },
            ],
        });

        function updateTable() {
            tblproduct.ajax.reload(null, false);
        }

        $('#btnreload').click(function(e) {
            e.preventDefault();
            updateTable();
        })

        // select2 //
        $("#filter_category").select2({
            placeholder: '-- Pilih Kategori --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/category",
                dataType: "json",
                type: "GET",
                delay: select2Delay,
                data: function(params) {
                    return {
                        search: params.term,
                    };
                },
                processResults: function(data, page) {
                    return {
                        results: data,
                    };
                },
            },
        });

        $("#filter_brand").select2({
            placeholder: '-- Pilih Brand --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/brand",
                dataType: "json",
                type: "GET",
                delay: select2Delay,
                data: function(params) {
                    return {
                        search: params.term,
                    };
                },
                processResults: function(data, page) {
                    return {
                        results: data,
                    };
                },
            },
        });

        $("#filter_supplier").select2({
            placeholder: '-- Pilih Supplier --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/supplier",
                dataType: "json",
                type: "GET",
                delay: select2Delay,
                data: function(params) {
                    return {
                        search: params.term,
                    };
                },
                processResults: function(data, page) {
                    return {
                        results: data,
                    };
                },
            },
        });

        $('#filter_category').on('change', function(e) {
            updateTable();
        })
        $('#filter_brand').on('change', function(e) {
            updateTable();
        })
        $('#filter_supplier').on('change', function(e) {
            updateTable();
        })
        $('#filter_product_type').on('change', function(e) {
            updateTable();
        })


        /* Master Product  */
        let min_stock = new AutoNumeric('#min_stock', configQty);

        $("#category_id").select2({
            placeholder: '-- Pilih Kategori --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/category",
                dataType: "json",
                type: "GET",
                delay: select2Delay,
                data: function(params) {
                    return {
                        search: params.term,
                    };
                },
                processResults: function(data, page) {
                    return {
                        results: data,
                    };
                },
            },
        });

        $("#brand_id").select2({
            placeholder: '-- Pilih Brand --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/brand",
                dataType: "json",
                type: "GET",
                delay: select2Delay,
                data: function(params) {
                    return {
                        search: params.term,
                    };
                },
                processResults: function(data, page) {
                    return {
                        results: data,
                    };
                },
            },
        });

        $("#supplier_id").select2({
            placeholder: '-- Pilih Supplier --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/supplier",
                dataType: "json",
                type: "GET",
                delay: select2Delay,
                data: function(params) {
                    return {
                        search: params.term,
                    };
                },
                processResults: function(data, page) {
                    return {
                        results: data,
                    };
                },
            },
        });

        $("#base_unit").select2({
            placeholder: '-- Pilih Satuan --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/unit",
                dataType: "json",
                type: "GET",
                delay: select2Delay,
                data: function(params) {
                    return {
                        search: params.term,
                    };
                },
                processResults: function(data, page) {
                    return {
                        results: data,
                    };
                },
            },
        });

        function checkName(product_name) {
            let actUrl = base_url + '/webmin/product/getbyname';
            useLoader = false;
            let getData = ajax_get(actUrl, {
                product_name: product_name
            }, {}, false);
            useLoader = true;

            if (getData.success) {
                let result = getData.result;
                if (result.exist) {
                    let uID = result.data.product_id;
                    if (uID.toUpperCase() == $("#product_id").val().toUpperCase()) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return true;
                }
            } else {
                return false;
            }
        }

        Parsley.addMessages('id', {
            vproductname: 'Nama produk sudah terdaftar',
        });

        Parsley.setLocale('id');

        window.Parsley.addValidator("vproductname", {
            validateString: function(value) {
                return checkName(value)
            },
        });

        function clearUploadImage() {
            let file = $("#upload_image");
            file.wrap("<form>").closest("form").get(0).reset();
            file.unwrap();
            $('#product_image').attr('src', noImage);
        }

        function readUploadImage(file) {
            if (file.files && file.files[0]) {
                let img_name = file.files[0].name;
                let img_ext = img_name.split(".").pop().toLowerCase();
                let ext = upload_file_type.image;

                if (jQuery.inArray(img_ext, ext) == -1) {
                    let message_text = 'File wajib berekstensi ' + ext.join(", ");
                    message.info(message_text);
                    file.value = "";
                } else {
                    let img_size = file.files[0].size;
                    let size = max_upload_size.kb;
                    if (img_size > size) {
                        let message_text = 'Ukuran file maksimum ' + max_upload_size.mb + ' MB'
                        message.info(message_text);
                        file.value = "";
                    } else {
                        let reader = new FileReader();
                        reader.onload = function(e) {
                            $("#product_image").attr("src", e.target.result);
                        };
                        reader.readAsDataURL(file.files[0]);
                    }
                }
            }
        }

        $("#upload_image").change(function() {
            readUploadImage(this);
        });


        function addMode() {
            formMode = 'add';
            let form = $('#frmproduct');
            form.parsley().reset();
            $('#title-frmproduct').html('Tambah Produk');
            $('#product_id').val(0);
            $('#product_name').val('');
            setSelect2('#category_id');
            setSelect2('#brand_id');
            setSelect2('#supplier_id');
            $('#base_unit_input').show();
            setSelect2('#base_unit');
            $('#base_unit').prop('required', true);
            $('#has_tax').val('Y');
            $('#is_parcel').val('N').prop('readonly', false);
            $('#active').val('Y');
            $('#product_description').val('');
            $('#old_product_image').val('');
            clearUploadImage();
            min_stock.set(10);
            $('#modal-product').modal(configModal);
        }

        function editMode(res) {
            let data = res.data;
            let productSupplier = res.product_supplier;

            formMode = 'edit';
            let form = $('#frmproduct');
            form.parsley().reset();
            $('#title-frmproduct').html('Ubah Produk');
            $('#product_id').val(data.product_id);
            $('#product_name').val(htmlEntities.decode(data.product_name));
            setSelect2('#category_id', data.category_id, htmlEntities.decode(data.category_name));
            setSelect2('#brand_id', data.brand_id, htmlEntities.decode(data.brand_name));

            if (productSupplier.length > 0) {
                let selectSupplierId = Array();
                productSupplier.forEach(function(val, i) {
                    selectSupplierId.push({
                        'id': val.supplier_id,
                        'label': val.supplier_name
                    });
                })
                setSelect2('#supplier_id', selectSupplierId);
            } else {
                setSelect2('#supplier_id');
            }


            $('#base_unit_input').hide();
            setSelect2('#base_unit');
            $('#base_unit').prop('required', false);
            $('#has_tax').val(data.has_tax);
            $('#is_parcel').val(data.is_parcel).prop('readonly', true);
            $('#active').val(data.active);
            $('#product_description').val(htmlEntities.decode(data.product_description));
            $('#old_product_image').val(data.product_image);
            clearUploadImage();
            $('#product_image').attr('src', data.image_url);
            min_stock.set(parseFloat(data.min_stock));
            $('#modal-product').modal(configModal);
        }

        $('#btnupload').click(function(e) {
            e.preventDefault();
            $('#upload_image').click();
        })

        $('#btnsave').click(function(e) {
            e.preventDefault();
            let form = $('#frmproduct');
            let btnSubmit = $('#btnsave')
            form.parsley().validate();
            if (form.parsley().isValid()) {
                let question = 'Yakin ingin menyimpan data produk?';
                let actUrl = base_url + '/webmin/product/save/add';
                if (formMode == 'edit') {
                    question = 'Yakin ingin memperbarui data produk?';
                    actUrl = base_url + '/webmin/product/save/edit';
                }

                message.question(question).then(function(answer) {
                    let yes = parseMessageResult(answer);
                    if (yes) {
                        let formValues = new FormData();
                        let file = $('#upload_image');
                        formValues.append('product_id', $('#product_id').val());
                        formValues.append('product_name', $('#product_name').val());
                        formValues.append('category_id', $('#category_id').val());
                        formValues.append('brand_id', $('#brand_id').val());
                        formValues.append('supplier_id', $('#supplier_id').val());
                        formValues.append('base_unit', $('#base_unit').val());
                        formValues.append('has_tax', $('#has_tax').val());
                        formValues.append('is_parcel', $('#is_parcel').val());
                        formValues.append('min_stock', parseFloat(min_stock.getNumericString()));
                        formValues.append('active', $('#active').val());
                        formValues.append('product_description', $('#product_description').val());

                        if (file[0].files[0] != undefined) {
                            formValues.append('upload_image', file[0].files[0]);
                        }
                        formValues.append('old_product_image', $('#old_product_image').val());


                        btnSubmit.prop('disabled', true);
                        ajax_post(actUrl, formValues, {
                            success: function(response) {
                                if (response.success) {
                                    if (response.result.success) {
                                        notification.success(response.result.message);
                                        $('#modal-product').modal('hide');
                                    } else {
                                        message.error(response.result.message);
                                    }
                                }
                                btnSubmit.prop('disabled', false);
                                updateTable();
                            },
                            error: function(response) {
                                btnSubmit.prop('disabled', false);
                                updateTable();
                            }
                        }, true, true);
                    }
                })

            }
        })

        $("#tblproduct").on('click', '.btnedit', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let actUrl = base_url + '/webmin/product/getbyid/' + id;
            ajax_get(actUrl, null, {
                success: function(response) {
                    if (response.success) {
                        if (response.result.exist) {
                            editMode(response.result);
                        } else {
                            message.error(response.result.message);
                        }
                    }
                }
            })

        })

        $("#tblproduct").on('click', '.btndelete', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let product_name = $(this).attr('data-name');
            let question = 'Yakin ingin menghapus produk <b>' + product_name + '</b>?';
            let actUrl = base_url + '/webmin/product/delete/' + id;
            message.question(question).then(function(answer) {
                let yes = parseMessageResult(answer);
                if (yes) {
                    ajax_get(actUrl, null, {
                        success: function(response) {
                            if (response.success) {
                                if (response.result.success) {
                                    notification.success(response.result.message);
                                } else {
                                    message.error(response.result.message);
                                }
                            }
                            updateTable();
                        },
                        error: function(response) {
                            updateTable();
                        }
                    })
                }
            })
        })

        $('#btnadd').click(function(e) {
            e.preventDefault();
            addMode();
        })

        $('.close-modal').click(function(e) {
            e.preventDefault();
            message.question('Yakin ingin menutup halaman ini?').then(function(answer) {
                let yes = parseMessageResult(answer);
                if (yes) {
                    $('#modal-product').modal('hide');
                }
            })
        })

        /* End Master Product  */

        /* Product Unit */
        let formModeItem;
        let setup_product_id = 0;
        let base_purchase_price = 0;
        let base_purchase_tax = 0;
        let item_has_tax = '';

        let item_product_content = new AutoNumeric('#product_content', configQty);
        let item_purchase_price = new AutoNumeric('#purchase_price', configRp);
        let item_purchase_tax = new AutoNumeric('#purchase_tax', configRp);
        let item_purchase_price_with_tax = new AutoNumeric('#purchase_price_with_tax', configRp);

        let item_margin_rate_G1 = new AutoNumeric('#margin_rate_G1', configMargin);
        let item_sales_price_G1 = new AutoNumeric('#sales_price_G1', configRp);

        let item_margin_rate_G2 = new AutoNumeric('#margin_rate_G2', configMargin);
        let item_sales_price_G2 = new AutoNumeric('#sales_price_G2', configRp);

        let item_margin_rate_G3 = new AutoNumeric('#margin_rate_G3', configMargin);
        let item_sales_price_G3 = new AutoNumeric('#sales_price_G3', configRp);

        let item_margin_rate_G4 = new AutoNumeric('#margin_rate_G4', configMargin);
        let item_sales_price_G4 = new AutoNumeric('#sales_price_G4', configRp);

        let item_margin_rate_G5 = new AutoNumeric('#margin_rate_G5', configMargin);
        let item_sales_price_G5 = new AutoNumeric('#sales_price_G5', configRp);

        let item_margin_rate_G6 = new AutoNumeric('#margin_rate_G6', configMargin);
        let item_sales_price_G6 = new AutoNumeric('#sales_price_G6', configRp);

        let item_disc_seasonal = new AutoNumeric('#disc_seasonal', configDisc);

        let item_disc_price_G1 = 0;
        let item_promo_price_G1 = 0;
        let item_disc_price_G2 = 0;
        let item_promo_price_G2 = 0;
        let item_disc_price_G3 = 0;
        let item_promo_price_G3 = 0;
        let item_disc_price_G4 = 0;
        let item_promo_price_G4 = 0;
        let item_disc_price_G5 = 0;
        let item_promo_price_G5 = 0;
        let item_disc_price_G6 = 0;
        let item_promo_price_G6 = 0;


        let item_margin_allocation = new AutoNumeric('#margin_allocation', configMargin);
        let item_margin_alocation_G1 = 0;
        let item_margin_alocation_G2 = 0;
        let item_margin_alocation_G3 = 0;
        let item_margin_alocation_G4 = 0;
        let item_margin_alocation_G5 = 0;
        let item_margin_alocation_G6 = 0;

        let item_remain_margin_G1 = 0;
        let item_remain_margin_G2 = 0;
        let item_remain_margin_G3 = 0;
        let item_remain_margin_G4 = 0;
        let item_remain_margin_G5 = 0;
        let item_remain_margin_G6 = 0;

        $("#unit_id").select2({
            placeholder: '-- Pilih Satuan --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/unit",
                dataType: "json",
                type: "GET",
                delay: select2Delay,
                data: function(params) {
                    return {
                        search: params.term,
                    };
                },
                processResults: function(data, page) {
                    return {
                        results: data,
                    };
                },
            },
        });

        function reCalcMarginRate() {
            let spG1 = 0;
            let spG2 = 0;
            let spG3 = 0;
            let spG4 = 0;
            let spG5 = 0;
            let spG6 = 0;

            let ppt = parseFloat(item_purchase_price_with_tax.getNumericString());

            if (item_sales_price_G1.getNumericString() == '' || item_sales_price_G1.getNumericString() == null) {
                item_sales_price_G1.set(0);
            } else {
                spG1 = parseFloat(item_sales_price_G1.getNumericString());
            }

            if (item_sales_price_G2.getNumericString() == '' || item_sales_price_G2.getNumericString() == null) {
                item_sales_price_G2.set(0);
            } else {
                spG2 = parseFloat(item_sales_price_G2.getNumericString());
            }


            if (item_sales_price_G3.getNumericString() == '' || item_sales_price_G3.getNumericString() == null) {
                item_sales_price_G3.set(0);
            } else {
                spG3 = parseFloat(item_sales_price_G3.getNumericString());
            }

            if (item_sales_price_G4.getNumericString() == '' || item_sales_price_G4.getNumericString() == null) {
                item_sales_price_G4.set(0);
            } else {
                spG4 = parseFloat(item_sales_price_G4.getNumericString());
            }

            if (item_sales_price_G5.getNumericString() == '' || item_sales_price_G5.getNumericString() == null) {
                item_sales_price_G5.set(0);
            } else {
                spG5 = parseFloat(item_sales_price_G5.getNumericString());
            }

            if (item_sales_price_G6.getNumericString() == '' || item_sales_price_G6.getNumericString() == null) {
                item_sales_price_G6.set(0);
            } else {
                spG6 = parseFloat(item_sales_price_G6.getNumericString());
            }

            let mrG1 = calcPercentRate(ppt, spG1);
            let mrG2 = calcPercentRate(ppt, spG2);
            let mrG3 = calcPercentRate(ppt, spG3);
            let mrG4 = calcPercentRate(ppt, spG4);
            let mrG5 = calcPercentRate(ppt, spG5);
            let mrG6 = calcPercentRate(ppt, spG6);

            item_margin_rate_G1.set(mrG1);
            item_margin_rate_G2.set(mrG2);
            item_margin_rate_G3.set(mrG3);
            item_margin_rate_G4.set(mrG4);
            item_margin_rate_G5.set(mrG5);
            item_margin_rate_G6.set(mrG6);
        }

        $('#product_content').on('change blur', function(e) {
            let pc = 1;
            if (!(item_product_content.getNumericString() == '' || item_product_content.getNumericString() == null)) {
                pc = parseFloat(item_product_content.getNumericString());
            } else {
                item_product_content.set(1);
            }

            let pp = pc * base_purchase_price;
            let pt = 0;
            if (item_has_tax == 'Y') {
                pt = pp * PPN;
            }
            let ppt = pp + pt;

            item_purchase_price.set(pp);
            item_purchase_tax.set(pt);
            item_purchase_price_with_tax.set(ppt);
            reCalcMarginRate();
        })

        $('#purchase_price').on('change blur', function(e) {
            if (item_purchase_price.getNumericString() == '' || item_purchase_price.getNumericString() == null) {
                item_purchase_price.set(0);
            }
            let pp = parseFloat(item_purchase_price.getNumericString());
            let pt = 0;
            if (item_has_tax == 'Y') {
                pt = pp * PPN;
            }
            let ppt = pp + pt;
            item_purchase_tax.set(pt);
            item_purchase_price_with_tax.set(ppt);
            reCalcMarginRate();
        })

        $('#margin_rate_G1').on('change blur', function(e) {
            let ppt = parseFloat(item_purchase_price_with_tax.getNumericString());
            let mr = 0;
            let ds = parseFloat(item_disc_seasonal.getNumericString());
            let ma = parseFloat(item_margin_allocation.getNumericString());

            if (item_margin_rate_G1.getNumericString() == '' || item_margin_rate_G1.getNumericString() == null) {
                item_margin_rate_G1.set(0);
            } else {
                mr = parseFloat(item_margin_rate_G1.getNumericString());
            }

            let sp = ppt + (ppt * (mr / 100));
            sp = threeDigitRound(sp);

            item_margin_alocation_G1 = 0;
            item_remain_margin_G1 = 0;
            item_disc_price_G1 = 0;
            item_promo_price_G1 = sp;

            if (ds > 0) {
                item_disc_price_G1 = (ds / 100) * sp;
                item_promo_price_G1 = sp - item_disc_price_G1;
                item_promo_price_G1 = threeDigitRound(item_promo_price_G1);
            }

            item_remain_margin_G1 = item_promo_price_G1 - ppt;
            if (ma > 0) {
                item_margin_alocation_G1 = (ma / 100) * item_remain_margin_G1;
            }

            item_sales_price_G1.set(sp);
            $('#view_disc_G1').html(numberFormat(item_promo_price_G1, true));
            $('#view_margin_G1').html(numberFormat(item_remain_margin_G1, true));

            let remain_margin_rate = calcPercentRate(ppt, item_promo_price_G1);
            $('#view_remain_margin_G1').html(numberFormat(remain_margin_rate, true) + '%');
        })

        $('#margin_rate_G2').on('change blur', function(e) {
            let ppt = parseFloat(item_purchase_price_with_tax.getNumericString());
            let mr = 0;
            let ds = parseFloat(item_disc_seasonal.getNumericString());
            let ma = parseFloat(item_margin_allocation.getNumericString());

            if (item_margin_rate_G2.getNumericString() == '' || item_margin_rate_G2.getNumericString() == null) {
                item_margin_rate_G2.set(0);
            } else {
                mr = parseFloat(item_margin_rate_G2.getNumericString());
            }

            let sp = ppt + (ppt * (mr / 100));
            sp = threeDigitRound(sp);

            item_margin_alocation_G2 = 0;
            item_remain_margin_G2 = 0;
            item_disc_price_G2 = 0;
            item_promo_price_G2 = sp;

            if (ds > 0) {
                item_disc_price_G2 = (ds / 100) * sp;
                item_promo_price_G2 = sp - item_disc_price_G2;
                item_promo_price_G2 = threeDigitRound(item_promo_price_G2);
            }

            item_remain_margin_G2 = item_promo_price_G2 - ppt;
            if (ma > 0) {
                item_margin_alocation_G2 = (ma / 100) * item_remain_margin_G2;
            }

            item_sales_price_G2.set(sp);
            $('#view_disc_G2').html(numberFormat(item_promo_price_G2, true));
            $('#view_margin_G2').html(numberFormat(item_remain_margin_G2, true));

            let remain_margin_rate = calcPercentRate(ppt, item_promo_price_G2);
            $('#view_remain_margin_G2').html(numberFormat(remain_margin_rate, true) + '%');
        })

        $('#margin_rate_G3').on('change blur', function(e) {
            let ppt = parseFloat(item_purchase_price_with_tax.getNumericString());
            let mr = 0;
            let ds = parseFloat(item_disc_seasonal.getNumericString());
            let ma = parseFloat(item_margin_allocation.getNumericString());

            if (item_margin_rate_G3.getNumericString() == '' || item_margin_rate_G3.getNumericString() == null) {
                item_margin_rate_G3.set(0);
            } else {
                mr = parseFloat(item_margin_rate_G3.getNumericString());
            }

            let sp = ppt + (ppt * (mr / 100));
            sp = threeDigitRound(sp);

            item_margin_alocation_G3 = 0;
            item_remain_margin_G3 = 0;
            item_disc_price_G3 = 0;
            item_promo_price_G3 = sp;

            if (ds > 0) {
                item_disc_price_G3 = (ds / 100) * sp;
                item_promo_price_G3 = sp - item_disc_price_G3;
                item_promo_price_G3 = threeDigitRound(item_promo_price_G3);
            }

            item_remain_margin_G3 = item_promo_price_G3 - ppt;
            if (ma > 0) {
                item_margin_alocation_G3 = (ma / 100) * item_remain_margin_G3;
            }

            item_sales_price_G3.set(sp);
            $('#view_disc_G3').html(numberFormat(item_promo_price_G3, true));
            $('#view_margin_G3').html(numberFormat(item_remain_margin_G3, true));

            let remain_margin_rate = calcPercentRate(ppt, item_promo_price_G3);
            $('#view_remain_margin_G3').html(numberFormat(remain_margin_rate, true) + '%');
        })

        $('#margin_rate_G4').on('change blur', function(e) {
            let ppt = parseFloat(item_purchase_price_with_tax.getNumericString());
            let mr = 0;
            let ds = parseFloat(item_disc_seasonal.getNumericString());
            let ma = parseFloat(item_margin_allocation.getNumericString());

            if (item_margin_rate_G4.getNumericString() == '' || item_margin_rate_G4.getNumericString() == null) {
                item_margin_rate_G4.set(0);
            } else {
                mr = parseFloat(item_margin_rate_G4.getNumericString());
            }

            let sp = ppt + (ppt * (mr / 100));
            sp = threeDigitRound(sp);

            item_margin_alocation_G4 = 0;
            item_remain_margin_G4 = 0;
            item_disc_price_G4 = 0;
            item_promo_price_G4 = sp;

            if (ds > 0) {
                item_disc_price_G4 = (ds / 100) * sp;
                item_promo_price_G4 = sp - item_disc_price_G4;
                item_promo_price_G4 = threeDigitRound(item_promo_price_G4);
            }

            item_remain_margin_G4 = item_promo_price_G4 - ppt;
            if (ma > 0) {
                item_margin_alocation_G4 = (ma / 100) * item_remain_margin_G4;
            }

            item_sales_price_G4.set(sp);
            $('#view_disc_G4').html(numberFormat(item_promo_price_G4, true));
            $('#view_margin_G4').html(numberFormat(item_remain_margin_G4, true));

            let remain_margin_rate = calcPercentRate(ppt, item_promo_price_G4);
            $('#view_remain_margin_G4').html(numberFormat(remain_margin_rate, true) + '%');
        })

        $('#margin_rate_G5').on('change blur', function(e) {
            let ppt = parseFloat(item_purchase_price_with_tax.getNumericString());
            let mr = 0;
            let ds = parseFloat(item_disc_seasonal.getNumericString());
            let ma = parseFloat(item_margin_allocation.getNumericString());

            if (item_margin_rate_G5.getNumericString() == '' || item_margin_rate_G5.getNumericString() == null) {
                item_margin_rate_G5.set(0);
            } else {
                mr = parseFloat(item_margin_rate_G5.getNumericString());
            }

            let sp = ppt + (ppt * (mr / 100));
            sp = threeDigitRound(sp);

            item_margin_alocation_G5 = 0;
            item_remain_margin_G5 = 0;
            item_disc_price_G5 = 0;
            item_promo_price_G5 = sp;

            if (ds > 0) {
                item_disc_price_G5 = (ds / 100) * sp;
                item_promo_price_G5 = sp - item_disc_price_G5;
                item_promo_price_G5 = threeDigitRound(item_promo_price_G5);
            }

            item_remain_margin_G5 = item_promo_price_G5 - ppt;
            if (ma > 0) {
                item_margin_alocation_G5 = (ma / 100) * item_remain_margin_G5;
            }

            item_sales_price_G5.set(sp);
            $('#view_disc_G5').html(numberFormat(item_promo_price_G5, true));
            $('#view_margin_G5').html(numberFormat(item_remain_margin_G5, true));

            let remain_margin_rate = calcPercentRate(ppt, item_promo_price_G5);
            $('#view_remain_margin_G5').html(numberFormat(remain_margin_rate, true) + '%');
        })

        $('#margin_rate_G6').on('change blur', function(e) {
            let ppt = parseFloat(item_purchase_price_with_tax.getNumericString());
            let mr = 0;
            let ds = parseFloat(item_disc_seasonal.getNumericString());
            let ma = parseFloat(item_margin_allocation.getNumericString());

            if (item_margin_rate_G6.getNumericString() == '' || item_margin_rate_G6.getNumericString() == null) {
                item_margin_rate_G6.set(0);
            } else {
                mr = parseFloat(item_margin_rate_G6.getNumericString());
            }

            let sp = ppt + (ppt * (mr / 100));
            sp = threeDigitRound(sp);

            item_margin_alocation_G6 = 0;
            item_remain_margin_G6 = 0;
            item_disc_price_G6 = 0;
            item_promo_price_G6 = sp;

            if (ds > 0) {
                item_disc_price_G6 = (ds / 100) * sp;
                item_promo_price_G6 = sp - item_disc_price_G6;
                item_promo_price_G6 = threeDigitRound(item_promo_price_G6);
            }

            item_remain_margin_G6 = item_promo_price_G6 - ppt;
            if (ma > 0) {
                item_margin_alocation_G6 = (ma / 100) * item_remain_margin_G6;
            }

            item_sales_price_G6.set(sp);
            $('#view_disc_G6').html(numberFormat(item_promo_price_G6, true));
            $('#view_margin_G6').html(numberFormat(item_remain_margin_G6, true));

            let remain_margin_rate = calcPercentRate(ppt, item_promo_price_G6);
            $('#view_remain_margin_G6').html(numberFormat(remain_margin_rate, true) + '%');
        })

        $('#disc_seasonal').on('change blur', function(e) {
            let ds = 0;
            let ppt = parseFloat(item_purchase_price_with_tax.getNumericString());
            let ma = parseFloat(item_margin_allocation.getNumericString());


            if (item_disc_seasonal.getNumericString() == '' || item_disc_seasonal.getNumericString() == null) {
                item_disc_seasonal.set(0);
            } else {
                ds = parseFloat(item_disc_seasonal.getNumericString());
            }

            let spG1 = parseFloat(item_sales_price_G1.getNumericString());
            let spG2 = parseFloat(item_sales_price_G2.getNumericString());
            let spG3 = parseFloat(item_sales_price_G3.getNumericString());
            let spG4 = parseFloat(item_sales_price_G4.getNumericString());
            let spG5 = parseFloat(item_sales_price_G5.getNumericString());
            let spG6 = parseFloat(item_sales_price_G6.getNumericString());

            if (ds == 0) {
                item_disc_price_G1 = 0;
                item_promo_price_G1 = spG1;
                item_disc_price_G2 = 0;
                item_promo_price_G2 = spG2;
                item_disc_price_G3 = 0;
                item_promo_price_G3 = spG3;
                item_disc_price_G4 = 0;
                item_promo_price_G4 = spG4;
                item_disc_price_G5 = 0;
                item_promo_price_G5 = spG5;
                item_disc_price_G6 = 0;
                item_promo_price_G6 = spG6;
            } else {
                ds = ds / 100;
                item_disc_price_G1 = spG1 * ds;
                item_promo_price_G1 = spG1 - item_disc_price_G1;
                item_promo_price_G1 = threeDigitRound(item_promo_price_G1);

                item_disc_price_G2 = spG2 * ds;
                item_promo_price_G2 = spG2 - item_disc_price_G2;
                item_promo_price_G2 = threeDigitRound(item_promo_price_G2);

                item_disc_price_G3 = spG3 * ds;
                item_promo_price_G3 = spG3 - item_disc_price_G3;
                item_promo_price_G3 = threeDigitRound(item_promo_price_G3);

                item_disc_price_G4 = spG4 * ds;
                item_promo_price_G4 = spG4 - item_disc_price_G4;
                item_promo_price_G4 = threeDigitRound(item_promo_price_G4);

                item_disc_price_G5 = spG5 * ds;
                item_promo_price_G5 = spG5 - item_disc_price_G5;
                item_promo_price_G5 = threeDigitRound(item_promo_price_G5);

                item_disc_price_G6 = spG6 * ds;
                item_promo_price_G6 = spG6 - item_disc_price_G6;
                item_promo_price_G6 = threeDigitRound(item_promo_price_G6);
            }

            item_remain_margin_G1 = item_promo_price_G1 - ppt;
            item_remain_margin_G2 = item_promo_price_G2 - ppt;
            item_remain_margin_G3 = item_promo_price_G3 - ppt;
            item_remain_margin_G4 = item_promo_price_G4 - ppt;
            item_remain_margin_G5 = item_promo_price_G5 - ppt;
            item_remain_margin_G6 = item_promo_price_G6 - ppt;



            if (ma > 0) {
                ma = ma / 100;
                item_margin_alocation_G1 = ma * item_remain_margin_G1;
                item_margin_alocation_G2 = ma * item_remain_margin_G2;
                item_margin_alocation_G3 = ma * item_remain_margin_G3;
                item_margin_alocation_G4 = ma * item_remain_margin_G4;
                item_margin_alocation_G5 = ma * item_remain_margin_G5;
                item_margin_alocation_G6 = ma * item_remain_margin_G6;
            } else {
                item_margin_alocation_G1 = 0;
                item_margin_alocation_G2 = 0;
                item_margin_alocation_G3 = 0;
                item_margin_alocation_G4 = 0;
                item_margin_alocation_G5 = 0;
                item_margin_alocation_G6 = 0;
            }


            let rmrG1 = calcPercentRate(ppt, item_promo_price_G1);
            let rmrG2 = calcPercentRate(ppt, item_promo_price_G2);
            let rmrG3 = calcPercentRate(ppt, item_promo_price_G3);
            let rmrG4 = calcPercentRate(ppt, item_promo_price_G4);
            let rmrG5 = calcPercentRate(ppt, item_promo_price_G5);
            let rmrG6 = calcPercentRate(ppt, item_promo_price_G6);

            $('#view_disc_G1').html(numberFormat(item_promo_price_G1, true));
            $('#view_margin_G1').html(numberFormat(item_remain_margin_G1, true));
            $('#view_remain_margin_G1').html(numberFormat(rmrG1, true) + '%');

            $('#view_disc_G2').html(numberFormat(item_promo_price_G2, true));
            $('#view_margin_G2').html(numberFormat(item_remain_margin_G2, true));
            $('#view_remain_margin_G2').html(numberFormat(rmrG2, true) + '%');

            $('#view_disc_G3').html(numberFormat(item_promo_price_G3, true));
            $('#view_margin_G3').html(numberFormat(item_remain_margin_G3, true));
            $('#view_remain_margin_G3').html(numberFormat(rmrG3, true) + '%');

            $('#view_disc_G4').html(numberFormat(item_promo_price_G4, true));
            $('#view_margin_G4').html(numberFormat(item_remain_margin_G4, true));
            $('#view_remain_margin_G4').html(numberFormat(rmrG4, true) + '%');

            $('#view_disc_G5').html(numberFormat(item_promo_price_G5, true));
            $('#view_margin_G5').html(numberFormat(item_remain_margin_G5, true));
            $('#view_remain_margin_G5').html(numberFormat(rmrG5, true) + '%');

            $('#view_disc_G6').html(numberFormat(item_promo_price_G6, true));
            $('#view_margin_G6').html(numberFormat(item_remain_margin_G6, true));
            $('#view_remain_margin_G6').html(numberFormat(rmrG6, true) + '%');



        })

        $('#margin_allocation').on('change blur', function(e) {
            let ma = 0;

            if (item_margin_allocation.getNumericString() == '' || item_margin_allocation.getNumericString() == null) {
                item_margin_allocation.set(0);
            } else {
                ma = parseFloat(item_margin_allocation.getNumericString());
            }


            if (ma > 0) {
                ma = ma / 100;
                item_margin_alocation_G1 = ma * item_remain_margin_G1;
                item_margin_alocation_G2 = ma * item_remain_margin_G2;
                item_margin_alocation_G3 = ma * item_remain_margin_G3;
                item_margin_alocation_G4 = ma * item_remain_margin_G4;
                item_margin_alocation_G5 = ma * item_remain_margin_G5;
                item_margin_alocation_G6 = ma * item_remain_margin_G6;
            } else {
                item_margin_alocation_G1 = 0;
                item_margin_alocation_G2 = 0;
                item_margin_alocation_G3 = 0;
                item_margin_alocation_G4 = 0;
                item_margin_alocation_G5 = 0;
                item_margin_alocation_G6 = 0;
            }





        })







        function addItem() {
            let form = $('#frmitem');
            formModeItem = 'add';
            form.parsley().reset();
            $('#title-frmitem').html('Tambah Satuan');
            $('#item_id').val(0);
            $('#item_code').val('');
            setSelect2('#unit_id');

            item_product_content.set(1);
            item_purchase_price.set(base_purchase_price);
            item_purchase_tax.set(base_purchase_tax);

            let ppwt = base_purchase_price + base_purchase_tax;
            item_purchase_price_with_tax.set(ppwt);

            item_margin_rate_G1.set(0);
            item_sales_price_G1.set(0);
            item_margin_rate_G2.set(0);
            item_sales_price_G2.set(0);
            item_margin_rate_G3.set(0);
            item_sales_price_G3.set(0);
            item_margin_rate_G4.set(0);
            item_sales_price_G4.set(0);
            item_margin_rate_G5.set(0);
            item_sales_price_G5.set(0);
            item_margin_rate_G6.set(0);
            item_sales_price_G6.set(0);

            $('#disc_start_date').val('');
            $('#disc_end_date').val('');
            item_disc_seasonal.set(0);
            item_disc_price_G1 = 0;
            item_promo_price_G1 = 0;
            item_disc_price_G2 = 0;
            item_promo_price_G2 = 0;
            item_disc_price_G3 = 0;
            item_promo_price_G3 = 0;
            item_disc_price_G4 = 0;
            item_promo_price_G4 = 0;
            item_disc_price_G5 = 0;
            item_promo_price_G5 = 0;
            item_disc_price_G6 = 0;
            item_promo_price_G6 = 0;



            item_margin_allocation.set(0);
            item_margin_alocation_G1 = 0;
            item_margin_alocation_G2 = 0;
            item_margin_alocation_G3 = 0;
            item_margin_alocation_G4 = 0;
            item_margin_alocation_G5 = 0;
            item_margin_alocation_G6 = 0;


            $('#view_disc_G1').html('0.00');
            $('#view_margin_G1').html('0.00');
            $('#view_remain_margin_G1').html('0.00');

            $('#view_disc_G2').html('0.00');
            $('#view_margin_G2').html('0.00');
            $('#view_remain_margin_G2').html('0.00');

            $('#view_disc_G3').html('0.00');
            $('#view_margin_G3').html('0.00');
            $('#view_remain_margin_G3').html('0.00');

            $('#view_disc_G4').html('0.00');
            $('#view_margin_G4').html('0.00');
            $('#view_remain_margin_G4').html('0.00');

            $('#view_disc_G5').html('0.00');
            $('#view_margin_G5').html('0.00');
            $('#view_remain_margin_G5').html('0.00');

            $('#view_disc_G6').html('0.00');
            $('#view_margin_G6').html('0.00');
            $('#view_remain_margin_G6').html('0.00');
            $('#modal-item').modal(configModal);
        }

        function loadProductUnit(list_product_unit) {
            let base_unit = '';
            let template = '';
            let tableData = '';

            list_product_unit.forEach(item => {
                if (item.base_unit == 'Y') {
                    template = $('#item_base_unit_template').html();
                    base_unit = item.unit_name;
                } else {
                    template = $('#item_unit_template').html();
                }

                let data_json = htmlEntities.encode(JSON.stringify(item));

                let pp = parseFloat(item.product_price);
                let pt = parseFloat(item.product_tax);
                let net_price = pp + pt;

                if (item.base_unit == 'Y') {
                    base_purchase_price = pp;
                    base_purchase_tax = pt;
                }

                let sp_G1 = parseFloat(item.G1_sales_price);
                let mr_G1 = calcPercentRate(net_price, sp_G1);

                let sp_G2 = parseFloat(item.G2_sales_price);
                let mr_G2 = calcPercentRate(net_price, sp_G2);

                let sp_G3 = parseFloat(item.G3_sales_price);
                let mr_G3 = calcPercentRate(net_price, sp_G3);

                let sp_G4 = parseFloat(item.G4_sales_price);
                let mr_G4 = calcPercentRate(net_price, sp_G4);

                let sp_G5 = parseFloat(item.G5_sales_price);
                let mr_G5 = calcPercentRate(net_price, sp_G5);

                let sp_G6 = parseFloat(item.G6_sales_price);
                let mr_G6 = calcPercentRate(net_price, sp_G6);


                let disc_seasonal = parseFloat(item.disc_seasonal);
                let G1_disc_price = parseFloat(item.G1_disc_price);
                let G1_promo_price = parseFloat(item.G1_promo_price);

                let G2_disc_price = parseFloat(item.G2_disc_price);
                let G2_promo_price = parseFloat(item.G2_promo_price);

                let G3_disc_price = parseFloat(item.G3_disc_price);
                let G3_promo_price = parseFloat(item.G3_promo_price);

                let G4_disc_price = parseFloat(item.G4_disc_price);
                let G4_promo_price = parseFloat(item.G4_promo_price);

                let G5_disc_price = parseFloat(item.G5_disc_price);
                let G5_promo_price = parseFloat(item.G5_promo_price);

                let G6_disc_price = parseFloat(item.G6_disc_price);
                let G6_promo_price = parseFloat(item.G6_promo_price);


                let margin_allocation = parseFloat(item.margin_allocation);
                let G1_margin_allocation = parseFloat(item.G1_margin_allocation);
                let G2_margin_allocation = parseFloat(item.G2_margin_allocation);
                let G3_margin_allocation = parseFloat(item.G3_margin_allocation);
                let G4_margin_allocation = parseFloat(item.G4_margin_allocation);
                let G5_margin_allocation = parseFloat(item.G5_margin_allocation);
                let G6_margin_allocation = parseFloat(item.G6_margin_allocation);

                let margin_G1 = (sp_G1 - G1_disc_price) - net_price;
                let remain_margin_G1 = calcPercentRate(net_price, (sp_G1 - G1_disc_price));

                let margin_G2 = (sp_G2 - G2_disc_price) - net_price;
                let remain_margin_G2 = calcPercentRate(net_price, (sp_G2 - G2_disc_price));

                let margin_G3 = (sp_G3 - G3_disc_price) - net_price;
                let remain_margin_G3 = calcPercentRate(net_price, (sp_G3 - G3_disc_price));

                let margin_G4 = (sp_G4 - G4_disc_price) - net_price;
                let remain_margin_G4 = calcPercentRate(net_price, (sp_G4 - G4_disc_price));

                let margin_G5 = (sp_G5 - G5_disc_price) - net_price;
                let remain_margin_G5 = calcPercentRate(net_price, (sp_G5 - G5_disc_price));

                let margin_G6 = (sp_G6 - G6_disc_price) - net_price;
                let remain_margin_G6 = calcPercentRate(net_price, (sp_G6 - G6_disc_price));

                let is_sale = badgeStatus.active;
                let show_in_mobile_apps = badgeStatus.active;
                let allow_change_price = badgeStatus.active;

                if (item.is_sale == 'N') {
                    is_sale = badgeStatus.notActive;
                }

                if (item.show_on_mobile_apps == 'N') {
                    show_on_mobile_apps = badgeStatus.notActive;
                }

                if (item.allow_change_price == 'N') {
                    allow_change_price = badgeStatus.notActive;
                }

                template = template.replaceAll('{item_id}', item.item_id)
                    .replaceAll('{item_code}', item.item_code)
                    .replaceAll('{unit_name}', item.unit_name)
                    .replaceAll('{product_content}', numberFormat(item.product_content))
                    .replaceAll('{product_price}', numberFormat(pp, true))
                    .replaceAll('{product_tax}', numberFormat(pt, true))
                    .replaceAll('{net_price}', numberFormat(net_price, true))

                    .replaceAll('{MR_G1}', numberFormat(mr_G1, true))
                    .replaceAll('{SP_G1}', numberFormat(sp_G1, true))
                    .replaceAll('{MR_G2}', numberFormat(mr_G2, true))
                    .replaceAll('{SP_G2}', numberFormat(sp_G2, true))
                    .replaceAll('{MR_G3}', numberFormat(mr_G3, true))
                    .replaceAll('{SP_G3}', numberFormat(sp_G3, true))
                    .replaceAll('{MR_G4}', numberFormat(mr_G4, true))
                    .replaceAll('{SP_G4}', numberFormat(sp_G4, true))
                    .replaceAll('{MR_G5}', numberFormat(mr_G5, true))
                    .replaceAll('{SP_G5}', numberFormat(sp_G5, true))
                    .replaceAll('{MR_G6}', numberFormat(mr_G6, true))
                    .replaceAll('{SP_G6}', numberFormat(sp_G6, true))

                    .replaceAll('{disc_seasonal}', numberFormat(disc_seasonal, true))
                    .replaceAll('{disc_G1}', numberFormat(G1_promo_price, true))
                    .replaceAll('{disc_G2}', numberFormat(G2_promo_price, true))
                    .replaceAll('{disc_G3}', numberFormat(G3_promo_price, true))
                    .replaceAll('{disc_G4}', numberFormat(G4_promo_price, true))
                    .replaceAll('{disc_G5}', numberFormat(G5_promo_price, true))
                    .replaceAll('{disc_G6}', numberFormat(G6_promo_price, true))
                    .replaceAll('{disc_start_date}', item.indo_disc_start_date)
                    .replaceAll('{disc_end_date}', item.indo_disc_end_date)

                    .replaceAll('{remain_margin_G1}', numberFormat(remain_margin_G1, true))
                    .replaceAll('{margin_G1}', numberFormat(margin_G1, true))
                    .replaceAll('{remain_margin_G2}', numberFormat(remain_margin_G2, true))
                    .replaceAll('{margin_G2}', numberFormat(margin_G2, true))
                    .replaceAll('{remain_margin_G3}', numberFormat(remain_margin_G3, true))
                    .replaceAll('{margin_G3}', numberFormat(margin_G3, true))
                    .replaceAll('{remain_margin_G4}', numberFormat(remain_margin_G4, true))
                    .replaceAll('{margin_G4}', numberFormat(margin_G4, true))
                    .replaceAll('{remain_margin_G5}', numberFormat(remain_margin_G5, true))
                    .replaceAll('{margin_G5}', numberFormat(margin_G5, true))
                    .replaceAll('{remain_margin_G6}', numberFormat(remain_margin_G6, true))
                    .replaceAll('{margin_G6}', numberFormat(margin_G6, true))

                    .replaceAll('{margin_allocation}', numberFormat(margin_allocation, true))
                    .replaceAll('{margin_allocation_G1}', numberFormat(G1_margin_allocation, true))
                    .replaceAll('{margin_allocation_G2}', numberFormat(G2_margin_allocation, true))
                    .replaceAll('{margin_allocation_G3}', numberFormat(G3_margin_allocation, true))
                    .replaceAll('{margin_allocation_G4}', numberFormat(G4_margin_allocation, true))
                    .replaceAll('{margin_allocation_G5}', numberFormat(G5_margin_allocation, true))
                    .replaceAll('{margin_allocation_G6}', numberFormat(G6_margin_allocation, true))

                    .replaceAll('{is_sale}', is_sale)
                    .replaceAll('{show_in_mobile_apps}', show_in_mobile_apps)
                    .replaceAll('{allow_change_price}', allow_change_price)

                    .replaceAll('{data_json}', data_json);


                tableData += template;
                //console.log('jso:' + data_json);
            });

            $('#setup_base_unit').html(base_unit);
            $('#tblitem tbody').html(tableData);
            _initTooltip();
        }

        function setupProductUnit(res) {
            let data = res.data;
            $('#setup_product_code').html(data.product_code);
            $('#setup_product_name').html(data.product_name);
            item_has_tax = data.has_tax;
            loadProductUnit(res.product_unit);
            showPage('#product_setup');
        }

        $('#btnadd_item').click(function(e) {
            e.preventDefault();
            addItem();
        })

        /* End Product Unit */

        /* Parcel Setup */
        $("#tblproduct").on('click', '.btnsetup', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let is_parcel = $(this).attr('data-parcel');

            if (is_parcel == 'N') {
                let actUrl = base_url + '/webmin/product/get-product-unit/' + id;
                ajax_get(actUrl, null, {
                    success: function(response) {
                        if (response.success) {
                            if (response.result.exist) {
                                setupProductUnit(response.result);
                            } else {
                                message.error(response.result.message);
                            }
                        }
                    }
                })
            } else {
                console.log('Parcel!')
            }
        })
        /* End Parcel Setup */



        showPage('#product_list');
    })
</script>
<?= $this->endSection() ?>