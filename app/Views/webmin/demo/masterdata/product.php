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
                        <!--
                        <button id="btnexchange" class="btn btn-default"><i class="fas fa-exchange-alt"></i> Penukaran Poin</button>
                        -->
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
                                        <option value="all">Semua</option>
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
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>
                                        <b>P000001</b><br>
                                        Toto Gantungan Double Robe Hook (TX04AES)
                                    </td>
                                    <td>Toto</td>
                                    <td>Gantungan</td>
                                    <td>
                                        <span class="badge badge-primary">PT IKAD INDONESIA</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-danger"><i class="fas fa-times-circle"></i></span>
                                    </td>
                                    <td>
                                        <span class="badge badge-success"><i class="fas fa-check-circle"></i></span>
                                    </td>
                                    <td>
                                        <span class="badge badge-success"><i class="fas fa-check-circle"></i></span>
                                    </td>


                                    <td>
                                        <a class="fancy_image" href="<?= base_url('assets/demo/00000565-TX704AES.jpg') ?>"><img src="<?= base_url('assets/demo/00000565-TX704AES.jpg') ?>" alt="" width="100px" height="120px" /></a>
                                    </td>
                                    <td>
                                        <a href="javascript:;" data-fancybox data-type="iframe" data-src="<?= base_url('webmin/product/detail') ?>" class="btn btn-sm btn-default mb-2" data-toggle="tooltip" data-placement="top" data-title="Detail"><i class="fas fa-eye"></i></a>
                                        <button class="btn btn-sm btn-default btnsetup mb-2" data-toggle="tooltip" data-placement="top" data-title="Pengaturan Produk"><i class="fas fa-cog"></i></button>&nbsp;
                                        <br />
                                        <button class="btn btn-sm btn-warning btnedit mb-2" data-toggle="tooltip" data-placement="top" data-title="Edit"><i class="fas fa-edit"></i></button>&nbsp;
                                        <button class="btn btn-sm btn-danger btndelete mb-2" data-toggle="tooltip" data-placement="top" data-title="Hapus"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>
                                        <b>P000002</b><br>
                                        Toto Floor Drain (TX1DA)
                                    </td>
                                    <td>Toto</td>
                                    <td>Floor Drain</td>
                                    <td>
                                        <span class="badge badge-primary">PT IKAD INDONESIA</span><br />
                                        <span class="badge badge-primary">PT NIPPON INDONESIA</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-danger"><i class="fas fa-times-circle"></i></span>
                                    </td>
                                    <td>
                                        <span class="badge badge-danger"><i class="fas fa-times-circle"></i></span>
                                    </td>
                                    <td>
                                        <span class="badge badge-danger"><i class="fas fa-times-circle"></i></span>
                                    </td>

                                    <td>
                                        <a class="fancy_image" href="<?= base_url('assets/demo/00000572-TX1DA.jpg') ?>"><img src="<?= base_url('assets/demo/00000572-TX1DA.jpg') ?>" alt="" width="100px" height="120px" /></a>
                                    </td>
                                    <td>
                                        <a href="javascript:;" data-fancybox data-type="iframe" data-src="<?= base_url('webmin/product/detail') ?>" class="btn btn-sm btn-default mb-2" data-toggle="tooltip" data-placement="top" data-title="Detail"><i class="fas fa-eye"></i></a>
                                        <button class="btn btn-sm btn-default btnsetup mb-2" data-toggle="tooltip" data-placement="top" data-title="Pengaturan Produk"><i class="fas fa-cog"></i></button>&nbsp;
                                        <br />
                                        <button class="btn btn-sm btn-warning btnedit mb-2" data-toggle="tooltip" data-placement="top" data-title="Edit"><i class="fas fa-edit"></i></button>&nbsp;
                                        <button class="btn btn-sm btn-danger btndelete mb-2" data-toggle="tooltip" data-placement="top" data-title="Hapus"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>
                                        <b>P000003</b><br>
                                        Paket Double Toto
                                    </td>
                                    <td>Paket</td>
                                    <td>Paket</td>
                                    <td>
                                        <span class="badge badge-primary">d'BIG</span><br />
                                    </td>
                                    <td>
                                        <span class="badge badge-success"><i class="fas fa-check-circle"></i></span>

                                    </td>
                                    <td>
                                        <span class="badge badge-danger"><i class="fas fa-times-circle"></i></span>
                                    </td>
                                    <td>
                                        <span class="badge badge-danger"><i class="fas fa-times-circle"></i></span>
                                    </td>
                                    <td>
                                        <a class="fancy_image" href="<?= base_url('assets/demo/00000572-TX1DA.jpg') ?>"><img src="<?= base_url('assets/demo/00000572-TX1DA.jpg') ?>" alt="" width="100px" height="120px" /></a>
                                    </td>
                                    <td>

                                        <a href="javascript:;" data-fancybox data-type="iframe" data-src="<?= base_url('webmin/product/parcel-detail') ?>" class="btn btn-sm btn-default mb-2" data-toggle="tooltip" data-placement="top" data-title="Detail"><i class="fas fa-eye"></i></a>
                                        <button class="btn btn-sm btn-default btnsetupparcel mb-2" data-toggle="tooltip" data-placement="top" data-title="Pengaturan Produk"><i class="fas fa-cog"></i></button>&nbsp;
                                        <br />
                                        <button class="btn btn-sm btn-warning btneditparcel mb-2" data-toggle="tooltip" data-placement="top" data-title="Edit"><i class="fas fa-edit"></i></button>&nbsp;
                                        <button class="btn btn-sm btn-danger btndelete mb-2" data-toggle="tooltip" data-placement="top" data-title="Hapus"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
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
                                <td width="84%" id="setup_product_code">P000001</td>
                            </tr>
                            <tr>
                                <th>Nama Produk</th>
                                <td>:</td>
                                <td id="setup_product_name">Toto Gantungan Double Robe Hook (TX04AES)</td>
                            </tr>
                            <tr>
                                <th>Satuan Dasar</th>
                                <td>:</td>
                                <td id="setup_base_unit">PCS</td>
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
                                        <th rowspan="2" class="text-center">Dijual</th>
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
                                            <button data-id="" data-json="" class="btn btn-sm btn-warning btnedit" data-toggle="tooltip" data-placement="top" data-title="Edit"><i class="fas fa-edit"></i></button>
                                        </td>
                                        <td>1234567890123</td>
                                        <td>PCS</td>
                                        <td class="text-right">1</td>
                                        <td class="text-right">25,000.00</td>
                                        <td class="text-right">2,750.00</td>
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
                                        <td class="text-center">
                                            <span class="badge badge-success"><i class="fas fa-check-circle"></i></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-warning btnedit" data-toggle="tooltip" data-placement="top" data-title="Edit"><i class="fas fa-edit"></i></button>
                                                <button type="button" class="btn btn-sm btn-danger btndelete" data-toggle="tooltip" data-placement="top" data-title="Hapus"><i class="fas fa-times"></i></button>
                                            </div>
                                        </td>
                                        <td>1234567899999</td>
                                        <td>DUS</td>
                                        <td class="text-right">50&nbsp;PCS</td>
                                        <td class="text-right">1,250,000.00</td>
                                        <td class="text-right">137,500.00</td>
                                        <td class="text-right">1,387,500.00</td>
                                        <td class="text-right">50.00%</td>
                                        <td class="text-right">2,081,300.00</td>
                                        <td class="text-right">40.00%</td>
                                        <td class="text-right">1,942,500.00</td>
                                        <td class="text-right">30.00%</td>
                                        <td class="text-right">1,803,800.00</td>
                                        <td class="text-right">20.00%</td>
                                        <td class="text-right">1,665,000.00</td>
                                        <td class="text-right">20.00%</td>
                                        <td class="text-right">1,665,000.00</td>
                                        <td class="text-right">50.00%</td>
                                        <td class="text-right">2,081,300.00</td>
                                        <td class="text-center">
                                            <span class="badge badge-danger"><i class="fas fa-times-circle"></i></span>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <td colspan="21">
                                        <a href="#" id="btnadd_item">
                                            <i class="fas fa-plus"></i> Tambahkan
                                        </a>
                                    </td>
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
                                    </div>
                                    <div class="col-md-6">

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
                    <form id="frmproduct" class="form-horizontal">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <img id="image_product" src="<?= base_url('assets/images/no-image.PNG') ?>" width="100%" height="200px">
                                    <button class="btn btn-primary btn-block mt-2"><i class="fas fa-cloud-upload-alt"></i> Unggah Gambar</button>
                                </div>
                                <div class="col-md-9">
                                    <input id="product_id" name="product_id" value="0" type="hidden">

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
                                            <label for="category_id" class="col-sm-12">Brand</label>
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
                                            <label for="product_tax" class="col-sm-12">Jenis Produk</label>
                                            <div class="col-sm-12">
                                                <select id="product_tax" name="product_tax" class="form-control">
                                                    <option value="Y" selected>Barang Kena Pajak (BKP)</option>
                                                    <option value="N">Barang Tidak Kena Pajak (NON BKP)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="base_unit_input" class="form-group">
                                        <label for="base_unit" class="col-sm-12">Satuan Dasar</label>
                                        <div class="col-sm-12 sel2">
                                            <select id="base_unit" name="base_unit" class="form-control" required></select>
                                        </div>
                                    </div>




                                    <div class="form-group">
                                        <label for="active" class="col-sm-12">Jenis Produk</label>
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


                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button id="btncancel" class="btn btn-danger close-modal"><i class="fas fa-times-circle"></i> Batal</button>
                            <button id="btnsave" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <div class="modal fade" id="modal-item">
            <div class="modal-dialog modal-lg">
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
                                <div class="col-md-6 border-right border-primary">
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

                                    <div class="form-check">
                                        <div class="col-sm-12">
                                            <input type="checkbox" class="form-check-input" id="is_sale">
                                            <label class="form-check-label" for="is_sale" checked>Dijual</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-center"><b>Margin Dan Harga Jual</b></p>

                                    <div class="form-group">
                                        <label for="promo_price" class="col-sm-12">G1 - UMUM</label>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <input id="margin_rate_G1" name="margin_rate_G1" type="text" class="form-control text-right" value="0" />
                                                </div>

                                                <div class="col-sm-8">
                                                    <input id="sales_price_G1" name="sales_price_G1" type="text" class="form-control text-right" data-parsley-vsalesprice value="0" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label for="promo_price" class="col-sm-12">G2 - SILVER</label>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <input id="margin_rate_G2" name="margin_rate_G2" type="text" class="form-control text-right" value="0" />
                                                </div>

                                                <div class="col-sm-8">
                                                    <input id="sales_price_G2" name="sales_price_G2" type="text" class="form-control text-right" data-parsley-vsalesprice value="0" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="promo_price" class="col-sm-12">G3 - GOLD</label>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <input id="margin_rate_G3" name="margin_rate_G3" type="text" class="form-control text-right" value="0" />
                                                </div>

                                                <div class="col-sm-8">
                                                    <input id="sales_price_G3" name="sales_price_G3" type="text" class="form-control text-right" data-parsley-vsalesprice value="0" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label for="promo_price" class="col-sm-12">G4 - PLATINUM</label>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <input id="margin_rate_G4" name="margin_rate_G4" type="text" class="form-control text-right" value="0" />
                                                </div>

                                                <div class="col-sm-8">
                                                    <input id="sales_price_G4" name="sales_price_G4" type="text" class="form-control text-right" data-parsley-vsalesprice value="0" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="promo_price" class="col-sm-12">G5 - PROYEK</label>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <input id="margin_rate_G5" name="margin_rate_G5" type="text" class="form-control text-right" value="0" />
                                                </div>

                                                <div class="col-sm-8">
                                                    <input id="sales_price_G5" name="sales_price_G5" type="text" class="form-control text-right" data-parsley-vsalesprice value="0" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="promo_price" class="col-sm-12">G6 - CUSTOM</label>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <input id="margin_rate_G6" name="margin_rate_G6" type="text" class="form-control text-right" value="0" />
                                                </div>

                                                <div class="col-sm-8">
                                                    <input id="sales_price_G6" name="sales_price_G6" type="text" class="form-control text-right" data-parsley-vsalesprice value="0" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button id="btncancel" class="btn btn-danger close-modal-item"><i class="fas fa-times-circle"></i> Batal</button>
                            <button id="btnsave_item" class="btn btn-success close-modal-item"><i class="fas fa-save"></i> Simpan</button>
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
        let formMode = '';
        $('#product_setup').hide();
        $('#parcel_setup').hide();

        $("a.fancy_image").fancybox();

        let min_stock = new AutoNumeric('#min_stock', configQty);

        let product_content = new AutoNumeric('#product_content', configQty);
        let purchase_price = new AutoNumeric('#purchase_price', configRp);
        let purchase_tax = new AutoNumeric('#purchase_tax', configRp);
        let purchase_price_with_tax = new AutoNumeric('#purchase_price_with_tax', configRp);

        let margin_rate_G1 = new AutoNumeric('#margin_rate_G1', configMargin);
        let sales_price_G1 = new AutoNumeric('#sales_price_G1', configRp);
        let margin_rate_G2 = new AutoNumeric('#margin_rate_G2', configMargin);
        let sales_price_G2 = new AutoNumeric('#sales_price_G2', configRp);
        let margin_rate_G3 = new AutoNumeric('#margin_rate_G3', configMargin);
        let sales_price_G3 = new AutoNumeric('#sales_price_G3', configRp);
        let margin_rate_G4 = new AutoNumeric('#margin_rate_G4', configMargin);
        let sales_price_G4 = new AutoNumeric('#sales_price_G4', configRp);
        let margin_rate_G5 = new AutoNumeric('#margin_rate_G5', configMargin);
        let sales_price_G5 = new AutoNumeric('#sales_price_G5', configRp);
        let margin_rate_G6 = new AutoNumeric('#margin_rate_G6', configMargin);
        let sales_price_G6 = new AutoNumeric('#sales_price_G6', configRp);

        let parcel_price = new AutoNumeric('#parcel_price', configRp);
        let parcel_tax = new AutoNumeric('#parcel_tax', configRp);
        let parcel_cost = new AutoNumeric('#parcel_cost', configRp);

        let parcel_margin_rate_G1 = new AutoNumeric('#parcel_margin_rate_G1', configMargin);
        let parcel_sales_price_G1 = new AutoNumeric('#parcel_sales_price_G1', configRp);
        let parcel_margin_rate_G2 = new AutoNumeric('#parcel_margin_rate_G2', configMargin);
        let parcel_sales_price_G2 = new AutoNumeric('#parcel_sales_price_G2', configRp);
        let parcel_margin_rate_G3 = new AutoNumeric('#parcel_margin_rate_G3', configMargin);
        let parcel_sales_price_G3 = new AutoNumeric('#parcel_sales_price_G3', configRp);
        let parcel_margin_rate_G4 = new AutoNumeric('#parcel_margin_rate_G4', configMargin);
        let parcel_sales_price_G4 = new AutoNumeric('#parcel_sales_price_G4', configRp);
        let parcel_margin_rate_G5 = new AutoNumeric('#parcel_margin_rate_G5', configMargin);
        let parcel_sales_price_G5 = new AutoNumeric('#parcel_sales_price_G5', configRp);
        let parcel_margin_rate_G6 = new AutoNumeric('#parcel_margin_rate_G6', configMargin);
        let parcel_sales_price_G6 = new AutoNumeric('#parcel_sales_price_G6', configRp);


        parcel_price.set(75000);
        parcel_tax.set(2750);
        parcel_cost.set(77750);
        parcel_margin_rate_G1.set(45);
        parcel_sales_price_G1.set(112800);
        parcel_margin_rate_G2.set(35);
        parcel_sales_price_G2.set(105000);
        parcel_margin_rate_G3.set(25);
        parcel_sales_price_G3.set(97200);
        parcel_margin_rate_G4.set(15);
        parcel_sales_price_G4.set(89500);
        parcel_margin_rate_G5.set(15);
        parcel_sales_price_G5.set(89500);
        parcel_margin_rate_G6.set(45);
        parcel_sales_price_G6.set(112800)


        $('#filter_category').select2({
            data: [{
                    id: '1',
                    text: 'Floor Drain'
                },
                {
                    id: '2',
                    text: 'Gantungan'
                },
            ]
        })

        $('#filter_brand').select2({
            data: [{
                    id: '1',
                    text: 'Toto'
                },
                {
                    id: '2',
                    text: 'Philips'
                },
            ]
        })

        $('#filter_supplier').select2({
            data: [{
                    id: '1',
                    text: 'PT IKAD INDONESIA'
                },
                {
                    id: '2',
                    text: 'PT NIPPON INDONESIA'
                },
            ]
        })

        $('#category_id').select2({
            data: [{
                    id: '1',
                    text: 'Floor Drain'
                },
                {
                    id: '2',
                    text: 'Gantungan'
                },
            ]
        })

        $('#brand_id').select2({
            data: [{
                    id: '1',
                    text: 'Toto'
                },
                {
                    id: '2',
                    text: 'Philips'
                },
            ]
        })

        $('#supplier_id').select2({

            data: [{
                    id: '1',
                    text: 'PT IKAD INDONESIA'
                },
                {
                    id: '2',
                    text: 'PT NIPPON INDONESIA'
                },
            ]
        })

        $('#base_unit').select2({
            data: [{
                    id: '1',
                    text: 'PCS'
                },
                {
                    id: '2',
                    text: 'LUSIN'
                },
                {
                    id: '3',
                    text: 'DUS'
                },
            ]
        })

        $('#unit_id').select2({
            data: [{
                    id: '1',
                    text: 'PCS'
                },
                {
                    id: '2',
                    text: 'LUSIN'
                },
                {
                    id: '3',
                    text: 'DUS'
                },
            ]
        })

        // datatables //
        let tblproduct = $("#tblproduct").DataTable({
            select: true,
            responsive: true,
            fixedColumns: true,
            order: [
                [1, 'desc']
            ],
            language: {
                url: lang_datatables,
            },

            drawCallback: function(settings) {
                _initTooltip();
            },
            columnDefs: [{
                    width: 100,
                    targets: 9
                },
                {
                    targets: [0, 9],
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

        $('#btnreload').click(function(e) {
            e.preventDefault();
        })

        function addMode() {
            let form = $('#frmproduct');
            $('#title-frmproduct').html('Tambah Produk');
            form[0].reset();
            form.parsley().reset();
            formMode = 'add';
            let imgSrc = base_url + '/assets/images/no-image.PNG'
            $('#image_product').attr('src', imgSrc);
            $('#product_id').val('0');
            $('#product_name').val('');
            $('#category_id').val('');
            $('#brand_id').val('');
            $('#supplier_id').val('');
            $('#base_unit').val('');
            $('#product_tax').val('N');
            $('#active').val('Y');
            $('#is_parcel').val('N').prop('disabled', false);
            $('#product_description').val('');
            $('#input_product').show();
            min_stock.set(0);
            $('#modal-product').modal(configModal);
        }

        function editMode(data) {
            let form = $('#frmproduct');
            $('#title-frmproduct').html('Ubah Produk');
            //form[0].reset();
            form.parsley().reset();
            formMode = 'add';
            let imgSrc = base_url + '/assets/demo/00000572-TX1DA.jpg';
            $('#image_product').attr('src', imgSrc);
            $('#product_id').val('0');
            $('#product_name').val('Toto Floor Drain (TX1DA)');
            setSelect2('#category_id', '2', 'Gantungan');
            setSelect2('#brand_id', '1', 'Toto');
            $('#input_product').show();
            let selectOption = [{
                    id: '1',
                    label: 'PT IKAD INDONESIA'
                },
                {
                    id: '2',
                    label: 'PT NIPPON INDONESIA'
                },
            ]
            setSelect2('#supplier_id', selectOption);
            setSelect2('#base_unit', '1', 'PCS');
            $('#product_tax').val('N');
            $('#active').val('N');
            $('#is_parcel').val('N').prop('disabled', true);
            $('#product_description').val('Gantungan Toto');
            min_stock.set(10);
            $('#modal-product').modal(configModal);
        }

        $('#is_parcel').change(function(e) {
            if ($(this).val() == 'Y') {
                $('#input_product').hide();
            } else {
                $('#input_product').show();
            }
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

        $('#btnsave').click(function(e) {
            e.preventDefault();
            $('#modal-product').modal('hide');
        })

        $("#tblproduct").on('click', '.btnedit', function(e) {
            e.preventDefault();
            editMode({
                a: 1
            });

        })

        $("#tblproduct").on('click', '.btneditparcel', function(e) {
            e.preventDefault();
            let form = $('#frmproduct');
            $('#title-frmproduct').html('Ubah Produk');
            //form[0].reset();
            form.parsley().reset();
            formMode = 'add';
            let imgSrc = base_url + '/assets/demo/00000572-TX1DA.jpg';
            $('#image_product').attr('src', imgSrc);
            $('#product_id').val('0');
            $('#product_name').val('Paket Double Toto');
            setSelect2('#category_id', '3', 'Paket');
            setSelect2('#brand_id', '3', 'Paket');
            $('#input_product').hide();
            let selectOption = [{
                id: '3',
                label: 'd\'BIG'
            }]
            setSelect2('#supplier_id', selectOption);
            setSelect2('#base_unit', '1', 'PCS');
            $('#product_tax').val('N');
            $('#active').val('Y');
            $('#is_parcel').val('N').prop('disabled', true);
            $('#product_description').val('Paket Toto');
            min_stock.set(10);
            $('#modal-product').modal(configModal);

        })

        $("#tblproduct").on('click', '.btndelete', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let customer_name = $(this).attr('data-name');
            let question = 'Yakin ingin menghapus produk <b>P000003 - Paket Double Toto</b>?';
            let actUrl = base_url + '/customer/delete/' + id;
            message.question(question).then(function(answer) {
                let yes = parseMessageResult(answer);
                if (yes) {
                    notification.success('Produk P000003 - Paket Double Toto telah dihapus');
                }
            })
        })

        $("#tblproduct").on('click', '.btnsetup', function(e) {
            e.preventDefault();
            $('#product_list').hide();
            $('#parcel_setup').hide();
            $('#product_setup').show();
        })

        $("#tblproduct").on('click', '.btnsetupparcel', function(e) {
            e.preventDefault();
            $('#product_list').hide();
            $('#product_setup').hide();
            $('#parcel_setup').show();
        })

        $('#tblproduct').on('click', '.btndetail', function(e) {
            e.preventDefault();
            message.success('Coming Soon');
        })


        $('#btnadd_item').click(function(e) {
            e.preventDefault;
            $('#title-frmitem').html('Tambah Item');
            $('#item_code').val('8888888888888');
            product_content.set(10);
            purchase_price.set(0);
            purchase_tax.set(0);
            purchase_price_with_tax.set(0);
            margin_rate_G1.set(0);
            sales_price_G1.set(0);
            margin_rate_G2.set(0);
            sales_price_G2.set(0);
            margin_rate_G3.set(0);
            sales_price_G3.set(0);
            margin_rate_G4.set(0);
            sales_price_G4.set(0);
            margin_rate_G5.set(0);
            sales_price_G5.set(0);
            margin_rate_G6.set(0);
            sales_price_G6.set(0);
            $('#is_sale').prop('checked', true);
            $('#modal-item').modal(configModal);
        })

        $('#tblitem').on('click', '.btnedit', function(e) {
            e.preventDefault;
            $('#title-frmitem').html('Ubah Item');
            $('#item_code').val('1234567899999');
            product_content.set(50);
            purchase_price.set(1250000);
            purchase_tax.set(137500);
            purchase_price_with_tax.set(1387500);
            margin_rate_G1.set(50);
            sales_price_G1.set(2081300);
            margin_rate_G2.set(40);
            sales_price_G2.set(1942500);
            margin_rate_G3.set(30);
            sales_price_G3.set(1803800);
            margin_rate_G4.set(20);
            sales_price_G4.set(1665000);
            margin_rate_G5.set(20);
            sales_price_G5.set(1665000);
            margin_rate_G6.set(50);
            sales_price_G6.set(2081300);
            $('#is_sale').prop('checked', false);
            $('#modal-item').modal(configModal);
        })

        $('.close-modal-item').click(function(e) {
            e.preventDefault();
            message.question('Yakin ingin menutup halaman ini?').then(function(answer) {
                let yes = parseMessageResult(answer);
                if (yes) {
                    $('#modal-item').modal('hide');
                }
            })
        })

        $('.close-setup-page').click(function(e) {
            e.preventDefault();
            message.question('Yakin ingin menutup halaman ini?').then(function(answer) {
                let yes = parseMessageResult(answer);
                if (yes) {
                    $('#product_list').show();
                    $('#product_setup').hide();
                    $('#parcel_setup').hide();
                }
            })
        })

        $('.close-setup-parcel').click(function(e) {
            e.preventDefault();
            message.question('Yakin ingin menutup halaman ini?').then(function(answer) {
                let yes = parseMessageResult(answer);
                if (yes) {
                    $('#product_list').show();
                    $('#product_setup').hide();
                    $('#parcel_setup').hide();
                }
            })
        })


    })
</script>
<?= $this->endSection() ?>