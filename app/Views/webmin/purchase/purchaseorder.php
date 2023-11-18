<?php
$themeUrl = base_url('assets/adminlte3');
$assetsUrl = base_url('assets');
?>

<?= $this->extend('webmin/template/admin_template') ?>

<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<div id="po_list">

    <section class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h1>Pruchase Order</h1>

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

                <div class="col-md-12">

                    <div class="card">

                        <div class="card-header p-2">

                            <button id="btnadd" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah</button>

                            <button id="btnreload" class="btn btn-secondary"><i class="fas fa-sync"></i> Reload</button>

                        </div>

                        <div class="card-body">

                            <table id="tblpurchaseorders" class="table table-bordered table-hover" width="100%">

                                <thead>

                                    <tr>

                                        <th data-priority="1">#</th>

                                        <th data-priority="2">No PO</th>

                                        <th data-priority="3">Tanggal PO</th>

                                        <th data-priority="4">Golongan</th>

                                        <th data-priority="5">Nama Supplier</th>

                                        <th data-priority="6">Total Harga</th>

                                        <th data-priority="7">Status</th>

                                        <th data-priority="8">Status Barang</th>

                                        <th data-priority="9">Aksi</th>

                                    </tr>

                                </thead>

                            </table>



                            <!-- /.tab-content -->

                        </div><!-- /.card-body -->

                    </div>

                    <!-- /.card -->

                </div>

                <!-- /.col -->

            </div>

            <!-- /.row -->

        </div><!-- /.container-fluid -->

        <div class="modal fade" id="modal-updatestatus">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="title-frmupdatestatus"></h4>
                        <button type="button" class="close close-modal-updatestatus">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="frmupdatestatus" class="form-horizontal">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                 <div class="form-group">
                                     <label for="desc_status" class="col-sm-12">Keterangan Status Barang:</label>
                                     <div class="col-sm-12">
                                        <input type="hidden" id="purchase_order_id_status" name="purchase_order_id_status">
                                        <textarea id="desc_item_status" name="desc_item_status" type="text" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button class="btn btn-danger close-modal-updatestatus"><i class="fas fa-times-circle"></i> Batal</button>
                        <button id="btn_updatestatus" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

</section>

</div>



<div id="po_input">

    <section class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h1 id="title-frmpurchaseorder">Tambah PO</h1>

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

                <div class="col-md-12">

                    <div class="card">

                        <div class="card-body">


                          <form id="frmpurchaseorder" class="form-horizontal form-space">

                            <div class="form-group row">

                                <label for="noinvoice" class="col-sm-1 col-form-label text-right">No Invoice :</label>

                                <div class="col-sm-3">

                                    <input id="purchase_order_invoice" name="purchase_order_invoice" type="text" class="form-control" value="AUTO" readonly>
                                    <input id="purchase_order_id" name="purchase_order_id" type="hidden" class="form-control">

                                </div>

                                <div class="col-md-4"></div>
                                <label for="tanggal" class="col-sm-1 col-form-label text-right">Tanggal :</label>

                                <div class="col-sm-3">

                                    <input id="purchase_order_date" name="purchase_order_date" type="date" class="form-control" value="<?= date('Y-m-d') ?>" readonly>

                                </div>
                            </div>


                            <div class="form-group row">

                                <label for="supplier_id" class="col-sm-1 col-form-label text-right">Supplier :</label>

                                <div class="col-sm-3">

                                    <select id="supplier_id" name="supplier_id" class="form-control"></select>

                                </div>


                                <div class="col-md-4"></div>

                                <label for="user" class="col-sm-1 col-form-label text-right">Gudang :</label>

                                <div class="col-sm-3">

                                    <select id="warehouse" type="text" class="form-control"></select>

                                </div>

                            </div>


                            <div class="form-group row">

                                <label for="has_tax" class="col-sm-1 col-form-label text-right">Golongan :</label>

                                <div class="col-sm-3">
                                    <input id="has_tax" name="has_tax" type="text" class="form-control" readonly>
                                </div>

                                <div class="col-md-4"></div>

                                <label for="user" class="col-sm-1 col-form-label text-right">User :</label>

                                <div class="col-sm-3">

                                    <input id="display_user" type="text" class="form-control" value="<?= $user['user_realname'] ?>" readonly>

                                </div>

                            </div>


                        </form>




                    </div><!-- /.card-body -->

                </div>

                <!-- /.card -->

            </div>

            <!-- /.col -->

        </div>

        <!-- /.row -->

    </div><!-- /.container-fluid -->





    <div class="container-fluid">

        <div class="row">

            <!-- /.col -->

            <div class="col-md-12">

                <div class="card">

                    <div class="card-body">

                        <form id="frmaddtemp" class="mb-2">

                            <div class="row well well-sm">

                                <input id="temp_po_id" name="temp_po_id" type="hidden" value="">

                                <input id="item_id" name="item_id" type="hidden" value="">


                                <div class="col-md-3">

                                    <label>No Pengajuan:</label>

                                    <select id="nosubmission" name="nosubmission" class="form-control"></select>

                                    <input id="submission_id" type="hidden" name="submission_id">

                                    <input id="submission_inv" type="hidden" name="submission_inv">
                                </div>

                                <div class="col-sm-4">

                                    <!-- text input -->

                                    <div class="form-group">

                                        <label>Produk</label>

                                        <input id="product_name" name="product_name" type="text" class="form-control" placeholder="ketikkan nama produk" value="" data-parsley-vproductname required>

                                    </div>

                                </div>

                                <div class="col-sm-2">

                                    <!-- text input -->

                                    <div class="form-group">

                                        <label>Harga Beli Per Unit</label>

                                        <input id="temp_price" name="temp_price" class="form-control text-right" value="0" data-parsley-vprice required>
                                        <input id="temp_dpp" name="temp_dpp" type="hidden" class="form-control text-right" value="0" required>
                                        <input id="temp_tax" name="temp_tax" type="hidden" class="form-control text-right" value="0" readonly required>
                                    </div>

                                </div>


                                <div class="col-sm-2">

                                    <!-- text input -->

                                    <div class="form-group">

                                        <label>Qty</label>

                                        <input id="temp_qty" name="temp_qty" type="text" class="form-control text-right" value="0" data-parsley-vqty required>
                                        <input id="total_price" name="total_price" type="hidden" class="form-control text-right" value="0" required>

                                    </div>

                                </div>
                                <div class="col-md-5"></div>

                                <div class="col-sm-2">

                                    <!-- text input -->

                                    <div class="form-group">

                                        <label>Ongkir</label>

                                        <input id="temp_ongkir" name="temp_ongkir" type="text" class="form-control text-right" value="0">

                                    </div>

                                </div>

                                <div class="col-sm-2" style="display:none;">

                                    <!-- text input -->

                                    <div class="form-group">

                                        <label>Discount</label>

                                        <input id="temp_discount1" name="temp_discount1" type="hidden" class="form-control text-right" value="0" readonly>
                                        <input id="temp_discount2" name="temp_discount2" type="hidden" class="form-control text-right" value="0" readonly>
                                        <input id="temp_discount3" name="temp_discount3" type="hidden" class="form-control text-right" value="0" readonly>
                                        <input id="temp_discount_percentage1" name="temp_discount_percentage1" type="hidden" class="form-control text-right" value="0" readonly>
                                        <input id="temp_discount_percentage2" name="temp_discount_percentage2" type="hidden" class="form-control text-right" value="0" readonly>
                                        <input id="temp_discount_percentage3" name="temp_discount_percentage3" type="hidden" class="form-control text-right" value="0" readonly>
                                        <input id="total_temp_discount" name="total_temp_discount" type="text" class="form-control text-right" value="0"readonly>

                                    </div>

                                </div>


                                <div class="col-sm-2" style="display:none;">

                                    <!-- text input -->

                                    <div class="form-group">

                                        <label>Expire Date</label>

                                        <input id="temp_ed_date" name="temp_ed_date" type="date" class="form-control">

                                    </div>

                                </div>


                                <div class="col-sm-4">

                                    <!-- text input -->

                                    <div class="form-group">

                                        <label>Total</label>

                                        <input id="temp_total" name="temp_total" type="text" class="form-control text-right" value="0" readonly>

                                    </div>

                                </div>

                                <div class="col-sm-1" style="padding-right: 62px;">

                                    <!-- text input -->

                                    <label>&nbsp;</label>

                                    <div class="form-group">

                                        <button id="btnadd_temp" class="btn btn-md btn-primary rounded-circle float-right"><i class="fas fa-plus"></i></button>

                                    </div>

                                </div>

                            </div>

                        </form>



                        <div class="row mb-2">

                            <div class="col-12">

                                <table id="tbltemp" class="table table-bordered table-hover" width="100%">

                                    <thead>

                                        <tr>

                                            <th data-priority="1">#</th>

                                            <th data-priority="2">No Pengajuan</th>

                                            <th data-priority="3">Kode Item</th>

                                            <th data-priority="4" width="25%;">Produk</th>

                                            <th data-priority="5">Harga Satuan</th>

                                            <th data-priority="6">Qty</th>

                                            <th data-priority="7">Diskon</th>

                                            <th data-priority="8">Ongkir</th>

                                            <th data-priority="9">E.D</th>

                                            <th data-priority="10">Total</th>

                                            <th data-priority="11">Aksi</th>

                                        </tr>

                                    </thead>

                                    <tbody></tbody>

                                </table>

                                <template id="template_row_temp">

                                   <tr>

                                       <td>{row}</td>

                                       <td>{submission_invoice}</td>

                                       <td>{item_code}</td>

                                       <td>{product_name}</td>

                                       <td>{temp_price}</td>

                                       <td>{temp_qty}</td>

                                       <td>{temp_disc}</td>

                                       <td>{temp_ongkir}</td>

                                       <td>{temp_ed}</td>

                                       <td>{temp_total}</td>

                                       <td>

                                           <button data-id="{temp_id}" data-json="{data_json}" class="btn btn-sm btn-warning btnedit rounded-circle" data-toggle="tooltip" data-placement="top" data-title="Edit">

                                               <i class="fas fa-edit"></i>

                                           </button>

                                           &nbsp;

                                           <button data-id="{temp_id}" class="btn btn-sm btn-danger btndelete rounded-circle" data-toggle="tooltip" data-placement="top" data-title="Hapus">

                                               <i class="fas fa-minus"></i>

                                           </button>

                                       </td>

                                   </tr>

                               </template>

                           </div>

                       </div>



                       <div class="row form-space">

                        <div class="col-lg-6">

                            <div class="form-group">

                                <div class="col-sm-12">


                                    <div class="form-group">
                                        <div class="form-check">
                                            <div class="col-sm-12">
                                                <input type="checkbox" class="form-check-input" id="show_tax_desc">
                                                <label class="form-check-label" for="show_tax_desc">Tampilkan Faktur</label>
                                            </div>
                                        </div>
                                    </div>

                                    <textarea id="purchase_order_remark" name="purchase_order_remark" class="form-control" placeholder="Catatan" maxlength="500" rows="8">- UNTUK SETIAP MOTIF KERAMIK/ GRANIT HARAP DAPAT DIMUATKAN DENGAN NOMOR SERI YANG SAMA
- Kami meminta support dari Bapak/Ibu jika terdapat brosur & souvenir Sehingga bisa membantu memasarkan produk ke konsumen
- Kami juga mengharapakan jika untuk keramik bisa mensupport rak display dan sample keramik untuk display
                                    </textarea>

                                </div>

                            </div>

                            <div class="form-group">

                                <div class="col-sm-12">


                                    <div class="form-group">
                                        <div class="form-check">
                                            <div class="col-sm-12">
                                                <label class="form-check-label" for="show_tax_desc">Memo:</label>
                                            </div>
                                        </div>
                                    </div>

                                    <textarea id="purchase_order_remark2" name="purchase_order_remark2" class="form-control" placeholder="Catatan" maxlength="500" rows="5"></textarea>

                                </div>

                            </div>

                        </div>

                        <div class="col-lg-6 text-right">

                            <div class="form-group row">
                                <label for="footer_sub_total" class="col-sm-7 col-form-label text-right:">Sub Total:</label>
                                <div class="col-sm-5">
                                    <input id="footer_sub_total" name="footer_sub_total" type="text" class="form-control text-right" value="0" readonly>
                                </div>
                            </div>

                            <div class="form-group row" style="display:none;">
                                <label for="footer_total_discount" class="col-sm-7 col-form-label text-right:">Discount :</label>
                                <div class="col-sm-4">
                                    <input id="footer_discount1" name="footer_discount1" type="hidden" class="form-control text-right" value="0" readonly>
                                    <input id="footer_discount2" name="footer_discount2" type="hidden" class="form-control text-right" value="0" readonly>
                                    <input id="footer_discount3" name="footer_discount3" type="hidden" class="form-control text-right" value="0" readonly>
                                    <input id="footer_discount_percentage1" name="footer_discount_percentage1" type="hidden" class="form-control text-right" value="0" readonly>
                                    <input id="footer_discount_percentage2" name="footer_discount_percentage2" type="hidden" class="form-control text-right" value="0" readonly>
                                    <input id="footer_discount_percentage3" name="footer_discount_percentage3" type="hidden" class="form-control text-right" value="0" readonly>
                                    <input id="footer_total_discount" name="footer_total_discount" type="text" class="form-control text-right" value="0" readonly>
                                </div>
                                <div class="col-sm-1">
                                    <button id="btnaddfooterdiscount" class="btn btn-warning"><i class="fas fa-tags"></i></button>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="footer_dpp" class="col-sm-7 col-form-label text-right:">DPP :</label>
                                <div class="col-sm-5">
                                    <input id="footer_dpp" name="footer_dpp" type="text" class="form-control text-right" value="0" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="footer_total_ppn" class="col-sm-7 col-form-label text-right:">PPN <?= PPN_TEXT ?> :</label>
                                <div class="col-sm-5">
                                    <input id="footer_total_ppn" name="footer_total_ppn" type="text" class="form-control text-right" value="0" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="footer_total_ongkir" class="col-sm-7 col-form-label text-right:">Ongkir:</label>
                                <div class="col-sm-5">
                                    <input id="footer_total_ongkir" name="footer_total_ongkir" type="text" class="form-control text-right" value="0" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="footer_total_invoice" class="col-sm-7 col-form-label text-right:">Grand Total :</label>
                                <div class="col-sm-5">
                                    <input id="footer_total_invoice" name="footer_total_invoice" type="text" class="form-control text-right" value="0" readonly>
                                </div>
                            </div>


                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <button id="btncancel" class="btn btn-danger"><i class="fas fa-times-circle"></i> Batal</button>
                                    <button id="btnsave" class="btn btn-success button-header-custom-save"><i class="fas fa-save"></i> Simpan</button>
                                </div>
                            </div>

                        </div>


                    </div>

                </div>

            </div>

            <!-- /.card -->

        </div>

        <!-- /.col -->

    </div>

    <!-- /.row -->

</div><!-- /.container-fluid -->

<!-- Temp Modal Discount -->
<div class="modal fade" id="modal-tempdiscount">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="title-frmtempdiscount"></h4>
                <button type="button" class="close close-modal-temp">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="frmtempdiscount" class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <label for="edit_temp_discount1_lbl" class="col-sm-12">Discount 1</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="edit_temp_discount_percentage1" name="edit_temp_discount_percentage1" value="0">
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="edit_temp_discount1" name="edit_temp_discount1" value="0">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="edit_temp_discount2_lbl" class="col-sm-12">Discount 2</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="edit_temp_discount_percentage2" name="edit_temp_discount_percentage2" value="0">
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="edit_temp_discount2" name="edit_temp_discount2" value="0">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="edit_temp_discount2_lbl" class="col-sm-12">Discount 3</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="edit_temp_discount_percentage3" name="edit_temp_discount_percentage3" value="0">
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="edit_temp_discount3" name="edit_temp_discount3" value="0">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button id="btncancel" class="btn btn-danger close-modal-temp"><i class="fas fa-times-circle"></i> Batal</button>
                    <button id="btndisc" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- End Temp Modal Discount -->

<!-- Footer Modal Discount -->
<div class="modal fade" id="modal-footerdiscount">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="title-frmfooterdiscount"></h4>
                <button type="button" class="close close-modal-footer">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="frmfooterdiscount" class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <label for="edit_footer_discount1_lbl" class="col-sm-12">Discount 1</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="edit_footer_discount_percentage1" name="edit_footer_discount_percentage1" value="0">
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="edit_footer_discount1" name="edit_footer_discount1" value="0">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="edit_footer_discount2_lbl" class="col-sm-12">Discount 2</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="edit_footer_discount_percentage2" name="edit_footer_discount_percentage2" value="0">
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="edit_footer_discount2" name="edit_footer_discount2" value="0">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="edit_footer_discount3_lbl" class="col-sm-12">Discount 3</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="edit_footer_discount_percentage3" name="edit_footer_discount_percentage3" value="0">
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="edit_footer_discount3" name="edit_footer_discount3" value="0">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button id="btncancel" class="btn btn-danger close-modal-footer"><i class="fas fa-times-circle"></i> Batal</button>
                    <button id="btndiscfooter" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- Footer Modal Discount -->


</section>



</div>



<!-- /.content -->

<?= $this->endSection() ?>



<?= $this->section('js') ?>

<script>

    $(document).ready(function() {

        let temp_price = new AutoNumeric('#temp_price', configRp);

        let temp_tax = new AutoNumeric('#temp_tax', configRp);

        let temp_dpp = new AutoNumeric('#temp_dpp', configRp); 

        let temp_qty = new AutoNumeric('#temp_qty', configQty);

        let temp_ongkir = new AutoNumeric('#temp_ongkir', configRp);

        let total_price = new AutoNumeric('#total_price', configRp);

        let footer_dpp = new AutoNumeric('#footer_dpp', configRp);

        //popup Temp discount //

        let total_temp_discount = new AutoNumeric('#total_temp_discount', configRp);

        let edit_temp_discount1 = new AutoNumeric('#edit_temp_discount1', configRp);

        let edit_temp_discount_percentage1 = new AutoNumeric('#edit_temp_discount_percentage1', configMargin);

        let edit_temp_discount2 = new AutoNumeric('#edit_temp_discount2', configRp);

        let edit_temp_discount_percentage2 = new AutoNumeric('#edit_temp_discount_percentage2', configMargin);

        let edit_temp_discount3 = new AutoNumeric('#edit_temp_discount3', configRp);

        let edit_temp_discount_percentage3 = new AutoNumeric('#edit_temp_discount_percentage3', configMargin);

        //End popup Temp discount //

        let temp_discount1 = new AutoNumeric('#temp_discount1', configRp);

        let temp_discount_percentage1 = new AutoNumeric('#temp_discount_percentage1', configMargin);

        let temp_discount2 = new AutoNumeric('#temp_discount2', configRp);

        let temp_discount_percentage2 = new AutoNumeric('#temp_discount_percentage2', configMargin);

        let temp_discount3 = new AutoNumeric('#temp_discount3', configRp);

        let temp_discount_percentage3 = new AutoNumeric('#temp_discount_percentage3', configMargin);

        let temp_total = new AutoNumeric('#temp_total', configRp);

        let footer_sub_total = new AutoNumeric('#footer_sub_total', configRp);

        

        let footer_total_ongkir = new AutoNumeric('#footer_total_ongkir', configRp);

        let footer_total_discount = new AutoNumeric('#footer_total_discount', configRp);

        //popup footer discount //
        
        let edit_footer_discount1 = new AutoNumeric('#edit_footer_discount1', configRp);

        let edit_footer_discount_percentage1 = new AutoNumeric('#edit_footer_discount_percentage1', configMargin);

        let edit_footer_discount2 = new AutoNumeric('#edit_footer_discount2', configRp);

        let edit_footer_discount_percentage2 = new AutoNumeric('#edit_footer_discount_percentage2', configMargin);

        let edit_footer_discount3 = new AutoNumeric('#edit_footer_discount3', configRp);

        let edit_footer_discount_percentage3 = new AutoNumeric('#edit_footer_discount_percentage3', configMargin);

        //End popup footer discount //

        let footer_discount1 = new AutoNumeric('#footer_discount1', configRp);

        let footer_discount_percentage1 = new AutoNumeric('#footer_discount_percentage1', configMargin);

        let footer_discount2 = new AutoNumeric('#footer_discount2', configRp);

        let footer_discount_percentage2 = new AutoNumeric('#footer_discount_percentage2', configMargin);

        let footer_discount3 = new AutoNumeric('#footer_discount3', configRp);

        let footer_discount_percentage3 = new AutoNumeric('#footer_discount_percentage3', configMargin);

        let footer_total_ppn = new AutoNumeric('#footer_total_ppn', configRp);

        let footer_total_invoice = new AutoNumeric('#footer_total_invoice', configRp);

        // init component //

        function _initButton() {
           $('#btnadd').prop('disabled', !hasRole('purchase_order.add'));
           $('.btnedit').prop('disabled', !hasRole('purchase_order.edit'));
           $('.btndelete').prop('disabled', !hasRole('purchase_order.delete'));
           $('.btnprint').prop('disabled', !hasRole('purchase_order.print'));
       }

       let tblpurchaseorders = $("#tblpurchaseorders").DataTable({
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
            url: base_url + '/webmin/purchase-order/tblpurchaseorders',
            type: "POST",
            error: function() {
                notification.danger('Gagal memuat table, harap coba lagi');
            },
        },
        drawCallback: function(settings) {
            _initTooltip();
            _initButton();
        },
        columnDefs: [{
            width: 180,
            targets: [7]
        },
        {
            targets: [0, 8],
            orderable: false,
            searchable: false,
        },
        {
            targets: [0],
            className: "text-right",
        },
        ],
    });

       $("#nosubmission").select2({
        placeholder: '-- Pilih No Pengajuan --',
        width: "100%",
        allowClear: true,
        ajax: {
            url: base_url + "/webmin/select/no-submission",
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


       $("#tblpurchaseorders").on('click', '.btnstatus', function(e) {
        e.preventDefault();
        let id = $(this).attr('data-id');
        let actUrl = base_url + '/webmin/purchase-order/getbyid/' + id;
        ajax_get(actUrl, null, {
            success: function(response) {
                if (response.success) {
                    if (response.result.exist){
                        if(response.result.data.purchase_order_status == 'Pending'){
                            updatestatus(response.result.data);
                        }else{
                            message.info('Pesanan yang sudah selesai atau dibatalkan tidak dapat di ubah lagi');
                        }
                    } else {
                        message.error(response.result.message);
                    }
                }
            }
        })

    })

       function updatestatus(data) {
        let form = $('#frmupdatestatus');
        $('#title-frmupdatestatus').html('Update Status Barang');
        $('#purchase_order_id_status').val(htmlEntities.decode(data.purchase_order_id));
        $('#desc_item_status').val(htmlEntities.decode(data.purchase_order_item_status))
        $('#modal-updatestatus').modal(configModal);
    }

    $('#btn_updatestatus').click(function(e) {

        e.preventDefault();

        let form = $('#frmupdatestatus');

        let btnSubmit = $('btn_updatestatus');

        let actUrl = base_url + '/webmin/purchase-order/update-status-item';

        let formValues = {

            purchase_order_id_status: $('#purchase_order_id_status').val(),

            purchase_order_item_status: $('#desc_item_status').val()

        };

        btnSubmit.prop('disabled', true);

        ajax_post(actUrl, formValues, {

            success: function(response) {

                if (response.success) {

                    if (response.result.success) {

                        notification.success(response.result.message);
                        updateTableHeader();
                        $('#modal-updatestatus').modal('hide');

                    } else {

                        message.error(response.result.message);

                    }

                }

                btnSubmit.prop('disabled', false);

                updateTableHeader();

            },

            error: function(response) {

                btnSubmit.prop('disabled', false);

                updateTable();

            }
        });
    })
    

    $("#nosubmission").change(function(e) {

        let id = $(this).val();

        if (id != null) {

            if ($("#supplier_id").val() == null) {

                Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Silahkan Pilih Suplier Terlebih Dahulu !'
              })

                setSelect2('#nosubmission','','');

            }else{

                let actUrl = base_url + '/webmin/purchase-order/get-submission-detail/' + id;

                ajax_get(actUrl, null, {

                    success: function(response) {

                        if (response.success) {

                            if (response.result.success) {

                                let header = response.result.header;

                                let items = response.result.data;

                                if (header.submission_status == 'Pending') {
                                    if(header.supplier_id != $('#supplier_id').val()){
                                        Swal.fire({
                                          icon: 'error',
                                          title: 'Oops...',
                                          text: 'Produk Dan Suplier Tidak Sesuai !'
                                      })
                                        setSelect2('#nosubmission','','');
                                        cleardiscount();
                                        clearItemInput();
                                    }else{
                                        $('#item_id').val(header.submission_item_id);
                                        $('#product_name').val(header.submission_product_name);
                                        temp_price.set(header.base_purchase_price * header.product_content);
                                        temp_qty.set(header.submission_qty);
                                        if(header.has_tax == 'Y'){
                                            let tax = header.base_purchase_price * header.product_content - (header.base_purchase_price * header.product_content - (header.base_purchase_price * header.product_content * 0.11));
                                            temp_tax.set(tax);
                                            temp_dpp.set(header.base_purchase_price * header.product_content);
                                        }else{
                                            let tax = 0;
                                            temp_tax.set(tax);
                                            temp_dpp.set(header.base_purchase_price * header.product_content); 
                                        }
                                        
                                        temp_total.set((header.base_purchase_price * header.product_content) * header.submission_qty);
                                        total_price.set((header.base_purchase_price * header.product_content) * header.submission_qty);
                                    }
                                } else {
                                    $('#supplier_id').prop('disabled', true);
                                }

                            } else {

                                message.error(response.result.message);

                                setSelect2("#purchase_order_id");

                                $('#supplier_id').prop('disabled', false);

                            }

                        }

                    }

                })
            }
        } else {

            $('#supplier_id').prop('disabled', false);

        }

    });


    $('#btnadd').click(function(e) {
        e.preventDefault();
        let actUrl = base_url + '/webmin/purchase-order/get-po-temp';
        ajax_get(actUrl, null, {
            success: function(response) {   
                if (response.result.success == 'TRUE') {
                 let form = $('#frmpurchaseorder');
                 let items = response.result.data;
                 $('#title-frmpurchaseorder').html('Pengajuan Pesanan');
                 formMode = 'add';
                 setSelect2('#supplier_id', "", "");
                 $('#supplier_id').prop("disabled", false);
                 loadTempData(items);
                 if(items.length != 0){
                    let supplier_ids = items[0].temp_po_supplier_id;
                    let supplier_names = items[0].temp_po_supplier_name;
                    setSelect2('#supplier_id', supplier_ids, supplier_names);
                    $('#supplier_id').attr("disabled", true);
                }
                clearItemInput();
                showInputPage(true);
            } else {
                message.error(response.result.message);
            }

        }
    })

    })

    function showInputPage(x) {

        if (x) {

            $('#po_list').hide();

            $('#po_input').show();

        } else {

            $('#po_list').show();

            $('#po_input').hide();

        }

    }

    $('#btnsave').click(function(e) {

        e.preventDefault();

        let form = $('#frmaddtemp');

        let btnSubmit = $('#btnsave');

        let purchase_order_sub_total = parseFloat(footer_sub_total.getNumericString());

        let purchase_order_discount1 = parseFloat(footer_discount1.getNumericString());

        let purchase_order_discount2 = parseFloat(footer_discount2.getNumericString());

        let purchase_order_discount3 = parseFloat(footer_discount3.getNumericString());

        let purchase_order_discount1_percentage = parseFloat(footer_discount_percentage1.getNumericString());

        let purchase_order_discount2_percentage = parseFloat(footer_discount_percentage2.getNumericString());

        let purchase_order_discount3_percentage = parseFloat(footer_discount_percentage3.getNumericString());

        let purchase_order_total_discount = parseFloat(footer_total_discount.getNumericString());

        let purchase_order_dpp = parseFloat(footer_dpp.getNumericString());

        let purchase_order_total_ppn = parseFloat(footer_total_ppn.getNumericString());

        let purchase_order_total_ongkir = parseFloat(footer_total_ongkir.getNumericString());

        let purchase_order_total = parseFloat(footer_total_invoice.getNumericString());

        let nosubmission = $('#nosubmission').val();

        let warehouse = $('#warehouse').val();

        let question = 'Yakin ingin menyimpan data PO?';

        let actUrl = base_url + '/webmin/purchase-order/save/add';

        if (formMode == 'edit') {

            question = 'Yakin ingin memperbarui data PO?';

            actUrl = base_url + '/webmin/purchase-order/save/edit';

        }

        if(warehouse == null){
           Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Silahkan Isi Gudang Terlebih Dahulu !'
          })

       }else{

        message.question(question).then(function(answer) {

            let yes = parseMessageResult(answer);

            if (yes) {

                let formValues = {

                    purchase_order_id: $('#purchase_order_id').val(),

                    purchase_order_date: $('#purchase_order_date').val(),

                    purchase_order_supplier_id: $('#supplier_id').val(),

                    purchase_order_warehouse_id: warehouse,

                    purchase_order_remark: $('#purchase_order_remark').val(),

                    purchase_order_remark2: $('#purchase_order_remark2').val(),

                    purchase_show_tax_desc: $('#show_tax_desc:checked').val(),

                    purchase_order_sub_total: purchase_order_sub_total,

                    purchase_order_discount1: purchase_order_discount1,

                    purchase_order_discount2: purchase_order_discount2,

                    purchase_order_discount3: purchase_order_discount3,

                    purchase_order_discount1_percentage: purchase_order_discount1_percentage,

                    purchase_order_discount2_percentage: purchase_order_discount2_percentage,

                    purchase_order_discount3_percentage: purchase_order_discount3_percentage,

                    purchase_order_total_discount: purchase_order_total_discount,

                    purchase_order_dpp: purchase_order_dpp,

                    purchase_order_total_ppn: purchase_order_total_ppn,

                    purchase_order_total_ongkir:purchase_order_total_ongkir,

                    purchase_order_total: purchase_order_total,

                };

                btnSubmit.prop('disabled', true);

                ajax_post(actUrl, formValues, {

                    success: function(response) {

                        if (response.success) {

                            if (response.result.success) {

                                form[0].reset();

                                notification.success(response.result.message);

                                form.parsley().reset();

                                showInputPage(false);

                                let invoice = response.result.purchase_order_id;

                                //let invUrl = base_url + '/webmin/purchase-order/invoice/' + invoice + '?print=Y';

                               //window.open(invUrl, '_blank');

                           } else {

                            message.error(response.result.message);

                        }

                    }

                    btnSubmit.prop('disabled', false);

                    updateTableHeader();

                },

                error: function(response) {

                    btnSubmit.prop('disabled', false);

                    updateTable();

                }

            });

            }

        })

    }

});


$('#btnadd_temp').click(function(e) {

   e.preventDefault();

   let price = parseFloat(temp_price.getNumericString());

   let dpp = parseFloat(temp_dpp.getNumericString());

   let tax = parseFloat(temp_tax.getNumericString());

   let qty = parseFloat(temp_qty.getNumericString());

   let ongkir = parseFloat(temp_ongkir.getNumericString());

   let discount1 = parseFloat(edit_temp_discount1.getNumericString());

   let discount2 = parseFloat(edit_temp_discount2.getNumericString());

   let discount3 = parseFloat(edit_temp_discount3.getNumericString());

   let discount_percentage1 = parseFloat(temp_discount_percentage1.getNumericString());

   let discount_percentage2 = parseFloat(temp_discount_percentage2.getNumericString());

   let discount_percentage3 = parseFloat(temp_discount_percentage3.getNumericString());

   let total_discount = parseFloat(total_temp_discount.getNumericString());

   let total = parseFloat(temp_total.getNumericString());

   let supplier_id = $('#supplier_id').val();

   let supplier_name = $("#supplier_id option:selected" ).text();

   let submission_id = $('#nosubmission').val();

   let submission_inv = $("#nosubmission option:selected" ).text();


   let btnSubmit = $('#btnadd_temp');

   let form = $('#frmaddtemp');

   form.parsley().validate();

   if (form.parsley().isValid()) {

       let actUrl = base_url + '/webmin/purchase-order/temp-add';

       let formValues = {

           temp_po_id: $('#temp_po_id').val(),

           temp_po_submission_id: submission_id,

           temp_po_submission_invoice: submission_inv,

           item_id: $('#item_id').val(),

           temp_price: price,

           temp_dpp: dpp,

           temp_tax: tax,

           temp_qty: qty,

           temp_ongkir: ongkir,

           temp_discount1: discount1,

           temp_discount_percentage1: discount_percentage1,

           temp_discount2: discount2,

           temp_discount_percentage2: discount_percentage2,

           temp_discount3: discount3,

           temp_discount_percentage3: discount_percentage3,

           temp_po_suplier_id:supplier_id,

           total_temp_discount:total_discount,

           temp_po_suplier_name:supplier_name,

           temp_ed_date: $('#temp_ed_date').val(),

           temp_total: total,

       };

       btnSubmit.prop('disabled', true);

       ajax_post(actUrl, formValues, {

           success: function(response) {

               if (response.success) {

                   if (response.result.success) {

                       $('#product_name').focus();

                       setSelect2('#supplier_id', supplier_id, supplier_name);

                       $('#supplier_id').attr("disabled", true);

                       notification.success(response.result.message);

                   } else {

                       message.error(response.result.message);

                   }

                   clearItemInput();
                   loadTempData(response.result.data);

               }

               btnSubmit.prop('disabled', false);

           },

           error: function(response) {

               btnSubmit.prop('disabled', false);

           }
       });
   }
})

Parsley.addMessages('id', {

    vproductname: 'Harap pilih produk terlebih dahulu',

    vprice: 'Harga beli wajib diatas Rp 0',

    vqty: 'Qty wajib diatas Rp 0',

});



Parsley.setLocale('id');



window.Parsley.addValidator("vproductname", {

    validateString: function(value) {

        if ($('#item_id').val() == '' || $('#item_id').val() == '0') {

            return false;

        } else {

            return true;

        }

    },

});


window.Parsley.addValidator("vprice", {

    validateString: function(value) {

        let vprice = parseFloat(temp_price.getNumericString());

        if (vprice <= 0) {

            return false;

        } else {

            return true;

        }
    },

});


window.Parsley.addValidator("vqty", {

    validateString: function(value) {

        let vqty = parseFloat(temp_qty.getNumericString());

        if (vqty <= 0) {

            return false;

        } else {

            return true;

        }

    },

});


$("#tblpurchaseorders").on('click', '.btnedit', function(e) {

    e.preventDefault();

    let id = $(this).attr('data-id');

    let actUrl = base_url + '/webmin/purchase-order/edit-order/' + id;

    ajax_get(actUrl, null, {

        success: function(response) {

            if (response.success) {

                if (response.result.success) {

                    let form = $('#frmpurchaseorder');

                    let items = response.result.data;

                    $('#title-frmpurchaseorder').html('Ubah PO');

                    let header = response.result.header;

                    let supplier_id = header.purchase_order_supplier_id;

                    let supplier_name = header.supplier_name;

                    let warehouse_id = header.purchase_order_warehouse_id;

                    let warehouse_name  = header.warehouse_name;

                    let submission_id = header.purchase_order_submission_id;

                    let submission_inv  = String(header.purchase_order_submission_inv);

                    let footer_sub_total_val  = header.purchase_order_sub_total;

                    let footer_discount1_val  = header.purchase_order_discount1;

                    let footer_discount2_val  = header.purchase_order_discount2;

                    let footer_discount3_val  = header.purchase_order_discount3;

                    let footer_discount1_percentage_val  = header.purchase_order_discount1_percentage;

                    let footer_discount2_percentage_val  = header.purchase_order_discount2_percentage;

                    let footer_discount3_percentage_val  = header.purchase_order_discount3_percentage;

                    let footer_total_discount_val  = header.purchase_order_total_discount;

                    let footer_dpp_val  = header.purchase_order_total_dpp;

                    let footer_total_ppn_val  = header.purchase_order_total_ppn;
                    
                    let footer_total_ongkir_Val  = header.purchase_order_total_ongkir;

                    let footer_total_invoice_val  = header.purchase_order_total;

                    let purchase_show_tax_desc = header.purchase_show_tax_desc;

                    let purchase_order_remark2 = header.purchase_order_remark2.replace("<br />", '\n');

                    if (header.purchase_order_status == 'Pending') {

                        $('#title-frmpurchaseorder').html('Ubah Pengajuan Pesanan');

                        formMode = 'edit';

                        setSelect2('#supplier_id', supplier_id, supplier_name);

                        $('#supplier_id').prop("disabled", true);

                        setSelect2('#warehouse', warehouse_id, warehouse_name);

                        $('#warehouse').prop("disabled", true);

                        $('#purchase_order_invoice').val(header.purchase_order_invoice);

                        $('#purchase_order_id').val(header.purchase_order_id);

                        $('#purchase_order_remark').val(header.purchase_order_remark);

                        $('#purchase_order_remark2').val(purchase_order_remark2);

                        if(purchase_show_tax_desc == 'Y'){
                            $('#show_tax_desc').prop('checked', true);
                        }else{
                            $('#show_tax_desc').prop('checked', false);
                        }

                        $('#display_user').val(header.user_realname);

                        footer_sub_total.set(footer_sub_total_val);

                        footer_discount1.set(footer_discount1_val);

                        footer_discount2.set(footer_discount2_val);

                        footer_discount3.set(footer_discount3_val);

                        footer_discount_percentage1.set(footer_discount1_percentage_val);

                        footer_discount_percentage2.set(footer_discount2_percentage_val);

                        footer_discount_percentage3.set(footer_discount3_percentage_val);

                        footer_total_discount.set(footer_total_discount_val);

                        footer_dpp.set(footer_dpp_val);

                        footer_total_ppn.set(footer_total_ppn_val);

                        footer_total_ongkir.set(footer_total_ongkir_Val);

                        footer_total_invoice.set(footer_total_invoice_val);

                        

                        loadTempData(items);

                        showInputPage(true);

                    } else {

                        message.info('Pesanan yang sudah selesai atau dibatalkan tidak dapat di ubah lagi');

                    }

                } else {

                    message.error(response.result.message);

                }

            }

        }

    })
})

$("#tbltemp").on('click', '.btndelete', function(e) {

    e.preventDefault();

    let id = $(this).attr('data-id');

    let actUrl = base_url + '/webmin/purchase-order/temp-delete/' + id;

    ajax_get(actUrl, null, {

        success: function(response) {

            if (response.success) {

                if (response.result.success) {

                    notification.success(response.result.message);

                } else {

                    message.error(response.result.message);

                }

                setfootervalue();

                loadTempData(response.result.data);

            }

        },

        error: function(response) {

            getTemp();

        }

    })

})  

$('#btncancel').click(function(e) {

    e.preventDefault();

    message.question('Yakin ingin menutup halaman ini?').then(function(answer) {

        let yes = parseMessageResult(answer);

        if (yes) {

            showInputPage(false);

            clearTemp();

            clearItemInput();

        }

    })

})

function clearTemp() {

let actUrl = base_url + '/webmin/purchase-order/clear-temp';

ajax_get(actUrl, null, {

    success: function(response) {

        if (response.success) {

            if (response.result.success) {

                clearItemInput();

                location.reload();

            } else {

                message.error(response.result.message);

            }

        }

    },

    error: function(response) {

        getTemp();

    }

})
}


$("#tbltemp").on('click', '.btnedit', function(e) {

 e.preventDefault();

 let json_data = $(this).attr('data-json');

 let [json, is_json, error] = parseJSON(htmlEntities.decode(json_data));

 if (is_json) {

    setSelect2('#nosubmission',json.temp_po_submission_id,json.temp_po_submission_invoice);

    $('#submission_id').val(json.temp_po_submission_id);

    $('#submission_inv').val(json.temp_po_submission_invoice);

    $('#nosubmission').prop("disabled", true);

    $('#item_id').val(json.temp_po_item_id);

    $('#product_name').val(json.product_name);

    temp_price.set(json.temp_po_price);

    temp_qty.set(json.temp_po_qty);

    temp_ongkir.set(json.temp_po_ongkir);

    temp_discount1.set(json.temp_po_discount1);

    temp_discount2.set(json.temp_po_discount2);

    temp_discount3.set(json.temp_po_discount3);

    temp_discount_percentage1.set(json.temp_po_discount1_percentage);

    temp_discount_percentage2.set(json.temp_po_discount2_percentage);

    temp_discount_percentage3.set(json.temp_po_discount3_percentage);

    total_price.set(json.temp_po_qty * json.temp_po_price);

    total_temp_discount.set(json.temp_po_discount_total);

    $('#temp_ed_date').val(json.temp_po_expire_date);

    $('#temp_po_id').val(json.temp_po_id );

    $('#temp_tax').val(json.temp_po_ppn);

    temp_total.set(json.temp_po_total);

    temp_dpp.set(json.temp_po_dpp);

    temp_tax.set(json.temp_po_ppn);

    $('#temp_qty').focus();

    $('#supplier_id').attr("disabled", true);

} else {

 getTemp();

 message.error('Terjadi kesalahan dalam memproses data, harap coba lagi');

}

})  


function loadTempData(items) {

    if(items['length'] < 1){

                 setSelect2('#supplier_id', "", "");
                 $('#supplier_id').prop('disabled', false);
    }
 let template = $('#template_row_temp').html();

 let tbody = '';

 let row = 1;

 let temp_total_order = 0;

 items.forEach((val, key) => {

     let item = template;

     let data_json = htmlEntities.encode(JSON.stringify(val));

     let temp_po_id  = val.temp_po_id;

     let temp_po_submission_invoice  = val.temp_po_submission_invoice;

     let temp_po_item_id = val.temp_po_item_id;

     let item_code = val.item_code;

     let product_name  = val.product_name+'('+val.unit_name+')';

     let temp_po_price  = val.temp_po_price;

     let temp_po_qty = parseFloat(val.temp_po_qty);

     let temp_po_total_disc = val.temp_total_discount;

     let temp_po_ongkir = val.temp_po_ongkir;

     let temp_po_expire_date = val.temp_po_expire_date;

     let temp_po_total = val.temp_po_total;

     let has_tax = val.has_tax;
    


     item = item.replaceAll('{row}', row)

     .replaceAll('{submission_invoice}', temp_po_submission_invoice)

     .replaceAll('{item_code}', item_code)

     .replaceAll('{product_name}', product_name)

     .replaceAll('{temp_price}', numberFormat(temp_po_price, true))

     .replaceAll('{temp_qty}', numberFormat(temp_po_qty, true))

     .replaceAll('{temp_disc}', numberFormat(temp_po_total_disc, true))

     .replaceAll('{temp_ongkir}', numberFormat(temp_po_ongkir, true))

     .replaceAll('{temp_ed}', temp_po_expire_date)

     .replaceAll('{temp_total}', numberFormat(temp_po_total, true))

     .replaceAll('{temp_id}', temp_po_id)

     .replaceAll('{data_json}', data_json);

     tbody += item;

     row++;


   

 });


 if ($.fn.DataTable.isDataTable('#tbltemp')) {

     $('#tbltemp').DataTable().destroy();

 }



 $('#tbltemp tbody').html('');

 $('#tbltemp tbody').html(tbody);

 tbltemp = $('#tbltemp').DataTable(config_tbltemp);

 setTax();

 setfootervalue();

 clearItemInput();

 _initTooltip();

}

const config_tbltemp = {

   pageLength: 10,

   autoWidth: false,

   select: true,

   responsive: true,

   fixedColumns: true,

   order: [

   [0, 'desc']

   ],

   "language": {

       "url": lang_datatables,

   },
   "columnDefs": [{

       width: 100

   },
   {

       targets: [0,9],

       orderable: false,

       searchable: false,

   },
   {

       targets: [0, 2, 3, 4, 5, 6],

       className: "text-right",

   }

   ]

};



let tbltemp = $('#tbltemp').DataTable(config_tbltemp);



// select2 //
$("#warehouse").select2({
    placeholder: '-- Pilih Gudang --',
    width: "100%",
    allowClear: true,
    ajax: {
        url: base_url + "/webmin/select/warehouse",
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

///end Select 2//

$('#product_name').autocomplete({   

 minLength: 2,

 source: function(req, add) {

     $.ajax({

         url: base_url + '/webmin/purchase-order/search-product-bysuplier?sup='+$('#supplier_id').val(),

         dataType: 'json',

         type: 'GET',

         data: req,

         success: function(res) {

             if (res.success == true) {

                add(res.data);

            }else{

               message.error(res.message);

               $('#product_name').val('');

           }

       },

   });

 },

 select: function(event, ui) {

     $('#item_id').val(ui.item.item_id);

     temp_price.set(parseFloat(ui.item.purchase_price));

     temp_dpp.set(parseFloat(ui.item.purchase_price));

     temp_tax.set(parseFloat(ui.item.base_purchase_tax));

           //temp_tax.set(0);

           //temp_qty.set(1);

       },

   });


$('#total_temp_discount').click(function(e) {
    e.preventDefault();
    discountMode({
        temp_discount1: $('#temp_discount1').val(),
        temp_discount2: $('#temp_discount2').val(),
        temp_discount3: $('#temp_discount3').val(),
        temp_discount_percentage1: $('#temp_discount_percentage1').val(),
        temp_discount_percentage2: $('#temp_discount_percentage2').val(),
        temp_discount_percentage3: $('#temp_discount_percentage3').val(),
    });
})

function discountMode(data) {
    let form = $('#frmtempdiscount');
    $('#title-frmtempdiscount').html('Tambah Discount');
    edit_temp_discount1.set(data.temp_discount1);
    edit_temp_discount2.set(data.temp_discount2);
    edit_temp_discount3.set(data.temp_discount3);
    edit_temp_discount_percentage1.set(data.temp_discount_percentage1);
    edit_temp_discount_percentage2.set(data.temp_discount_percentage2);
    edit_temp_discount_percentage3.set(data.temp_discount_percentage3);
    $('#modal-tempdiscount').modal(configModal);
}

$('#btnaddfooterdiscount').click(function(e) {
    e.preventDefault();
    discountFooterMode({
        footer_discount1: $('#footer_discount1').val(),
        footer_discount2: $('#footer_discount2').val(),
        footer_discount3: $('#footer_discount3').val(),
        footer_discount_percentage1: $('#footer_discount_percentage1').val(),
        footer_discount_percentage2: $('#footer_discount_percentage2').val(),
        footer_discount_percentage3: $('#footer_discount_percentage3').val(),
    });
})

function discountFooterMode(data) {
    let form = $('#frmfooterdiscount');
    $('#title-frmfooterdiscount').html('Tambah Discount Nota');
    edit_footer_discount1.set(data.footer_discount1);
    edit_footer_discount2.set(data.footer_discount2);
    edit_footer_discount3.set(data.footer_discount3);
    edit_footer_discount_percentage1.set(data.footer_discount_percentage1);
    edit_footer_discount_percentage2.set(data.footer_discount_percentage2);
    edit_footer_discount_percentage3.set(data.footer_discount_percentage3);
    $('#modal-footerdiscount').modal(configModal);
}


$('.close-modal-temp').click(function(e) {
    e.preventDefault();
    message.question('Yakin ingin menutup halaman ini?').then(function(answer) {
        let yes = parseMessageResult(answer);
        if (yes) {
            /*edit_temp_discount_percentage1.set('0.00%');
            edit_temp_discount_percentage2.set('0.00%');
            edit_temp_discount_percentage3.set('0.00%');
            edit_temp_discount1.set(0);
            edit_temp_discount2.set(0);
            edit_temp_discount3.set(0);
            total_temp_discount.set(0);*/
            $('#modal-tempdiscount').modal('hide');
        }
    })
})

$('.close-modal-footer').click(function(e) {
    e.preventDefault();
    message.question('Yakin ingin menutup halaman ini?').then(function(answer) {
        let yes = parseMessageResult(answer);
        if (yes) {
            /*edit_footer_discount_percentage1.set('0.00%');
            edit_footer_discount_percentage2.set('0.00%');
            edit_footer_discount_percentage3.set('0.00%');
            edit_footer_discount1.set(0);
            edit_footer_discount2.set(0);
            edit_footer_discount3.set(0);
            footer_total_discount.set(0);*/
            $('#modal-footerdiscount').modal('hide');
        }
    })
})

$('.close-modal-updatestatus').click(function(e) {
    e.preventDefault();
    message.question('Yakin ingin menutup halaman ini?').then(function(answer) {
        let yes = parseMessageResult(answer);
        if (yes) {
            $('#modal-updatestatus').modal('hide');
        }
    })
})

$('#temp_qty').on('change', function() {
    calculation_temp_total();
    cleardiscount();
});

$('#temp_price').on('change', function() {
    calculation_temp_total();
    cleardiscount();
});



$('#edit_temp_discount_percentage1').on('change', function() {
    let edit_temp_discount1_cal = total_price.get() * (edit_temp_discount_percentage1.get()/100);
    edit_temp_discount1.set(edit_temp_discount1_cal.toFixed(2));
});

$('#edit_temp_discount1').on('change', function() {
    let edit_temp_discount1_cal = edit_temp_discount1.get() / total_price.get() *  100;
    edit_temp_discount_percentage1.set(edit_temp_discount1_cal);
});

$('#edit_temp_discount_percentage2').on('change', function() {
    if(edit_temp_discount1.get() < 1){
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Discount 1 Tidak Boleh Kosong!'
      })
        edit_temp_discount_percentage2.set('0.00%');
        edit_temp_discount2.set(0);
    }
    let edit_temp_discount2_cal = (total_price.get() - edit_temp_discount1.get()) * (edit_temp_discount_percentage2.get()/100);
    edit_temp_discount2.set(edit_temp_discount2_cal.toFixed(2));
});

$('#edit_temp_discount2').on('change', function() {
    if(edit_temp_discount1.get() < 1){
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Discount 1 Tidak Boleh Kosong!'
      })
        edit_temp_discount_percentage2.set('0.00%');
        edit_temp_discount2.set(0);
    }
    let edit_temp_discount2_cal = edit_temp_discount2.get() / (total_price.get() - edit_temp_discount1.get()) *  100;
    edit_temp_discount_percentage2.set(edit_temp_discount2_cal.toFixed(2));
});

$('#edit_temp_discount_percentage3').on('change', function() {
    if(edit_temp_discount2.get() < 1){
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Discount 2 Tidak Boleh Kosong!'
      })
        edit_temp_discount_percentage3.set('0.00%');
        edit_temp_discount3.set(0);
    }
    let edit_temp_discount3_cal = (total_price.get() - edit_temp_discount1.get() - edit_temp_discount2.get()) * (edit_temp_discount_percentage3.get()/100);
    edit_temp_discount3.set(edit_temp_discount3_cal.toFixed(2));
});

$('#edit_temp_discount3').on('change', function() {
   if(edit_temp_discount2.get() < 1){
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Discount 2 Tidak Boleh Kosong!'
  })
    edit_temp_discount_percentage3.set('0.00%');
    edit_temp_discount3.set(0);
}
let edit_temp_discount3_cal = edit_temp_discount3.get() / (total_price.get() - edit_temp_discount1.get() - edit_temp_discount2.get()) *  100;
edit_temp_discount_percentage3.set(edit_temp_discount3_cal.toFixed(2));
});


$('#edit_footer_discount_percentage1').on('change', function() {
    let edit_footer_discount1_cal = footer_sub_total.get() * (edit_footer_discount_percentage1.get()/100);
    edit_footer_discount1.set(edit_footer_discount1_cal.toFixed(2));
});

$('#edit_footer_discount1').on('change', function() {
    let edit_footer_discount1_cal = edit_footer_discount1.get() / footer_sub_total.get() *  100;
    edit_footer_discount_percentage1.set(edit_footer_discount1_cal);
});

$('#edit_footer_discount_percentage2').on('change', function() {
    if(edit_footer_discount1.get() < 1){
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Discount 1 Tidak Boleh Kosong!'
      })
        edit_footer_discount_percentage2.set('0.00%');
        edit_footer_discount2.set(0);
    }
    let edit_footer_discount2_cal = (footer_sub_total.get() - edit_footer_discount1.get()) * (edit_footer_discount_percentage2.get()/100);
    edit_footer_discount2.set(edit_footer_discount2_cal.toFixed(2));
});

$('#edit_footer_discount2').on('change', function() {
    if(edit_footer_discount1.get() < 1){
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Discount 1 Tidak Boleh Kosong!'
      })
        edit_footer_discount_percentage2.set('0.00%');
        edit_footer_discount2.set(0);
    }
    let edit_footer_discount2_cal = edit_footer_discount2.get() / (footer_sub_total.get() - edit_footer_discount1.get()) *  100;
    edit_footer_discount_percentage2.set(edit_footer_discount2_cal.toFixed(2));
});

$('#edit_footer_discount_percentage3').on('change', function() {
    if(edit_footer_discount2.get() < 1){
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Discount 2 Tidak Boleh Kosong!'
      })
        edit_footer_discount_percentage3.set('0.00%');
        edit_footer_discount3.set(0);
    }
    let edit_footer_discount3_cal = (footer_sub_total.get() - edit_footer_discount1.get() - edit_footer_discount2.get()) * (edit_footer_discount_percentage3.get()/100);
    edit_footer_discount3.set(edit_footer_discount3_cal.toFixed(2));
});

$('#edit_footer_discount3').on('change', function() {
    if(edit_footer_discount2.get() < 1){
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Discount 2 Tidak Boleh Kosong!'
      })
        edit_footer_discount_percentage3.set('0.00%');
        edit_footer_discount3.set(0);
    }
    let edit_footer_discount3_cal = edit_footer_discount3.get() / (footer_sub_total.get() - edit_footer_discount1.get() - edit_footer_discount2.get()) *  100;
    edit_footer_discount_percentage3.set(edit_footer_discount3_cal.toFixed(2));
});

$('#temp_ongkir').on('change', function() {
    calculation_temp_total()
});

function calculation_temp_total(){
    var price_calculation = AutoNumeric.getAutoNumericElement('#temp_price').get();
    let dpp = price_calculation;
    let ppn = price_calculation - dpp;
    let qty_calculation = parseFloat(temp_qty.getNumericString());
    let subtotal_calculation = price_calculation * qty_calculation;
    total_price.set(subtotal_calculation);
    //temp_dpp.set(parseFloat(dpp.toFixed(2)));
    //temp_tax.set(parseFloat(ppn.toFixed(2)));
    temp_total.set(total_price.get() - total_temp_discount.get());
}

function cleardiscount() {
    temp_discount1.set(0);
    temp_discount2.set(0);
    temp_discount3.set(0);
    temp_discount_percentage1.set('0.00%');
    temp_discount_percentage2.set('0.00%');
    temp_discount_percentage3.set('0.00%');
    edit_temp_discount_percentage1.set('0.00%');
    edit_temp_discount_percentage2.set('0.00%');
    edit_temp_discount_percentage3.set('0.00%');
    edit_temp_discount1.set(0);
    edit_temp_discount2.set(0);
    edit_temp_discount3.set(0);
    total_temp_discount.set(0);
}

function cleardiscountfooter() {
    footer_discount1.set(0);
    footer_discount2.set(0);
    footer_discount3.set(0);
    edit_footer_discount_percentage1.set('0.00%');
    edit_footer_discount_percentage2.set('0.00%');
    edit_footer_discount_percentage3.set('0.00%');
    edit_footer_discount1.set(0);
    edit_footer_discount2.set(0);
    edit_footer_discount3.set(0);
    footer_total_discount.set(0);
}

function calculation_temp_total_footer(){
    footer_dpp.set(Number(footer_sub_total.get()) - Number(footer_total_discount.get()));

    if($('#has_tax').val() == 'Pajak'){
        footer_total_ppn.set(Number(footer_dpp.get() * 0.11));
    }else{
        footer_total_ppn.set(0);   
    }
    footer_total_invoice.set(Number(footer_dpp.get()) + Number(footer_total_ppn.get()) + Number(footer_total_ongkir.get()));
}

$('#btndisc').click(function(e) {
    e.preventDefault();
    message.question('Yakin untuk penambahan discount?').then(function(answer) {
        let yes = parseMessageResult(answer);
        if (yes) {
            $('#modal-tempdiscount').modal('hide');

            let edit_temp_discount1 =  AutoNumeric.getAutoNumericElement('#edit_temp_discount1').get();
            temp_discount1.set(edit_temp_discount1);

            let edit_temp_discount2 =  AutoNumeric.getAutoNumericElement('#edit_temp_discount2').get();
            temp_discount2.set(edit_temp_discount2);

            let edit_temp_discount3 =  AutoNumeric.getAutoNumericElement('#edit_temp_discount3').get();
            temp_discount3.set(edit_temp_discount3);

            let edit_temp_discount_percentage1 =  AutoNumeric.getAutoNumericElement('#edit_temp_discount_percentage1').get();
            temp_discount_percentage1.set(edit_temp_discount_percentage1);

            let edit_temp_discount_percentage2 =  AutoNumeric.getAutoNumericElement('#edit_temp_discount_percentage2').get();
            temp_discount_percentage2.set(edit_temp_discount_percentage2);

            let edit_temp_discount_percentage3 =  AutoNumeric.getAutoNumericElement('#edit_temp_discount_percentage3').get();
            temp_discount_percentage3.set(edit_temp_discount_percentage3);

            total_temp_discount.set(Number(edit_temp_discount1) + Number(edit_temp_discount2) + Number(edit_temp_discount3));
            calculation_temp_total();
        }
    })
})

$('#btndiscfooter').click(function(e) {
    e.preventDefault();
    message.question('Yakin untuk penambahan discount Nota?').then(function(answer) {
        let yes = parseMessageResult(answer);
        if (yes) {
            $('#modal-footerdiscount').modal('hide');

            let edit_footer_discount1 =  AutoNumeric.getAutoNumericElement('#edit_footer_discount1').get();
            footer_discount1.set(edit_footer_discount1);

            let edit_footer_discount2 =  AutoNumeric.getAutoNumericElement('#edit_footer_discount2').get();
            footer_discount2.set(edit_footer_discount2);

            let edit_footer_discount3 =  AutoNumeric.getAutoNumericElement('#edit_footer_discount3').get();
            footer_discount3.set(edit_footer_discount3);

            let edit_footer_discount_percentage1 =  AutoNumeric.getAutoNumericElement('#edit_footer_discount_percentage1').get();
            footer_discount_percentage1.set(edit_footer_discount_percentage1);

            let edit_footer_discount_percentage2 =  AutoNumeric.getAutoNumericElement('#edit_footer_discount_percentage2').get();
            footer_discount_percentage2.set(edit_footer_discount_percentage2);

            let edit_footer_discount_percentage3 =  AutoNumeric.getAutoNumericElement('#edit_footer_discount_percentage3').get();
            footer_discount_percentage3.set(edit_footer_discount_percentage3);

            footer_total_discount.set(Number(edit_footer_discount1) + Number(edit_footer_discount2) + Number(edit_footer_discount3));
            setfootervalue();
        }
    })
})


function updateTableHeader() {

 tblpurchaseorders.ajax.reload(null, false);

}


function clearItemInput() {

 let form = $('#frmaddtemp');

 form.parsley().reset();

 $('#item_id').val('');

 $('#product_name').val('');

 $('#temp_ed_date').val('');

 temp_qty.set('0.00');

 temp_ongkir.set(0);

 temp_price.set(0);

 temp_total.set(0);

 temp_dpp.set(0);

 temp_tax.set(0);

 edit_temp_discount_percentage1.set('0.00%');

 edit_temp_discount_percentage2.set('0.00%');

 edit_temp_discount_percentage3.set('0.00%');

 edit_temp_discount1.set(0);

 edit_temp_discount2.set(0);

 edit_temp_discount3.set(0);

 total_temp_discount.set(0);

 $('#temp_desc').val('');

 setSelect2('#nosubmission','','');

}

$("#tblpurchaseorders").on('click', '.btndelete', function(e) {

    e.preventDefault();

    let id = $(this).attr('data-id');

    message.question('Yakin ingin membatalkan PO ini?').then(function(answer) {

        let yes = parseMessageResult(answer);

        if (yes) {

            let actUrl = base_url + '/webmin/purchase-order/cancel-order/' + id;

            ajax_get(actUrl, null, {

                success: function(response) {

                    if (response.success) {

                        if (response.result.success) {

                            notification.success(response.result.message);

                        } else {

                            message.error(response.result.message);

                        }

                        updateTableHeader();

                    }

                }

            })

        }

    })

})

$("#tblpurchaseorders").on('click', '.btnprint', function(e) {

    e.preventDefault();

    let id = $(this).attr('data-id');

    let actUrl = base_url + '/webmin/purchase-order/printinvoice/' + id;

    window.open(actUrl, '_blank').focus();

})

$("#tblpurchaseorders").on('click', '.btnprint-memo', function(e) {

    e.preventDefault();

    let id = $(this).attr('data-id');

    let actUrl = base_url + '/webmin/purchase-order/printmemo/' + id;

    window.open(actUrl, '_blank').focus();

})


function setfootervalue(){
    let actUrl = base_url + '/webmin/purchase-order/get-po-footer';
    ajax_get(actUrl, null, {
        success: function(response) { 
            if (response.result.success == 'TRUE') {
                if(response.result.data.length > 0){
                    if(response.result.data[0].subTotal == 'null'){
                        footer_sub_total.set(0);
                        footer_total_ongkir.set(0);
                    }else{
                        footer_sub_total.set(response.result.data[0].subTotal);
                        footer_total_ongkir.set(response.result.data[0].totalOngkir);
                    }
                    calculation_temp_total_footer();
                }
            } else {
                message.error(response.result.message);
            }
        }
    });
}

function setTax(){
    let actUrl = base_url + '/webmin/purchase-order/get-po-tax';
    ajax_get(actUrl, null, {
        success: function(response) {   
            if (response.result.success == 'TRUE') {
                if(response.result.data.length > 0){
                   $('#has_tax').val('Pajak');
               }else{
                   $('#has_tax').val('Non Pajak');
               }
           } else {
            message.error(response.result.message);
        }
    }
});
}

_initButton();

showInputPage(false);

})




</script>

<?= $this->endSection() ?>