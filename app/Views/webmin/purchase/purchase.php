<?php
$themeUrl = base_url('assets/adminlte3');
$assetsUrl = base_url('assets');
?>

<?= $this->extend('webmin/template/admin_template') ?>

<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<div id="purchase_list">

    <section class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h1>Pembelian</h1>

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

                            <table id="tblhdpurchase" class="table table-bordered table-hover" width="100%">

                                <thead>

                                    <tr>

                                        <th data-priority="1">#</th>

                                        <th data-priority="2">No Invoice</th>

                                        <th data-priority="3">Tanggal Pembelian</th>

                                        <th data-priority="4">Golongan</th>

                                        <th data-priority="5">Payment Status</th>

                                        <th data-priority="6">Nama Supplier</th>

                                        <th data-priority="7">No Faktur Suplier</th>

                                        <th data-priority="8">Total</th>

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

    </section>

</div>



<div id="purchase_input">

    <section class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h1 id="title-frmpurchase"></h1>

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


                          <form id="frmpurchase" class="form-horizontal form-space">

                            <div class="form-group row">

                                <label for="purchase_invoice_no" class="col-sm-1 col-form-label text-right">No Invoice :</label>

                                <div class="col-sm-3">

                                    <input id="purchase_invoice_no" name="purchase_invoice_no" type="text" class="form-control" value="AUTO" readonly>

                                </div>

                                <div class="col-md-1">


                                </div>  

                                <label for="no_invoice_suplier" class="col-sm-1 col-form-label text-right">No Faktur :</label>

                                <div class="col-sm-3">

                                    <input id="no_invoice_suplier" name="no_invoice_suplier" type="text" class="form-control">

                                </div>



                                <label for="purchase_order_date" class="col-sm-1 col-form-label text-right">Tanggal :</label>

                                <div class="col-sm-2">

                                    <input id="purchase_order_date" name="purchase_order_date" type="date" class="form-control" value="<?= date('Y-m-d') ?>" readonly>

                                </div>
                            </div>

                            <div class="form-group row">

                                <label for="no_po_purchase" class="col-sm-1 col-form-label text-right">No Po :</label>

                                <div class="col-sm-3">

                                    <select id="no_po_purchase" name="no_po_purchase" class="form-control"></select>

                                </div>

                                <div class="col-md-1"></div>

                                <label for="faktur_date" class="col-sm-1 col-form-label text-right">Tgl Faktur :</label>

                                <div class="col-sm-3">

                                    <input id="faktur_date" name="faktur_date" type="date" class="form-control">

                                </div>



                                <label for="store_id" class="col-sm-1 col-form-label text-right">Cabang :</label>

                                <div class="col-sm-2">

                                   <select id="warehouse" type="text" class="form-control"></select>

                               </div>
                           </div>


                           <div class="form-group row">

                            <label for="supplier_id" class="col-sm-1 col-form-label text-right">Supplier :</label>

                            <div class="col-sm-3">

                                <select id="supplier_id" name="supplier_id" class="form-control"></select>

                            </div>

                            <div class="col-md-1">

                            </div>

                            <label for="has_tax" class="col-sm-1 col-form-label text-right">Golongan :</label>

                            <div class="col-sm-3">
                                <input id="has_tax" name="has_tax" type="text" class="form-control" readonly>
                            </div>


                            <label for="display_user" class="col-sm-1 col-form-label text-right">User :</label>

                            <div class="col-sm-2">

                                <input id="display_user" type="text" class="form-control" value="<?= $user['user_realname'] ?>" readonly>

                            </div>


                        </div>


                        <div class="form-group row">

                            <label for="payment_type" class="col-sm-1 col-form-label text-right">Payment :</label>

                            <div class="col-sm-3">

                                <select id="payment_type" name="payment_type" class="form-control"></select>

                            </div>

                        </div>

                        <div class="form-group row">


                            <label for="due_date" class="col-sm-1 col-form-label text-right">Tempo :</label>

                            <div class="col-sm-3">
                                <input id="due_date" name="due_date" type="date" class="form-control">

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

                        <input id="temp_purchase_id" name="temp_purchase_id" type="hidden" value="">

                        <input id="item_id" name="item_id" type="hidden" value="">


                        <div class="col-sm-3">

                            <!-- text input -->

                            <div class="form-group">

                                <label>Produk</label>

                                <input id="product_name" name="product_name" type="text" class="form-control" placeholder="ketikkan nama produk" value="" data-parsley-vproductname required>

                            </div>

                        </div>

                        <?php if($_SESSION['user_login']['group_name'] != "Gudang"){?>
                            <div class="col-sm-2">
                        <?php }else{ ?>
                            <div class="col-sm-2" style="display:none;">
                        <?php } ?>

                            <!-- text input -->

                            <div class="form-group">

                                <label>Harga Beli Per Unit</label>

                                <input id="temp_price" name="temp_price" type="text" class="form-control text-right" value="0" data-parsley-vprice required>
                                <input id="temp_dpp" name="temp_dpp" type="hidden" class="form-control text-right" value="0">
                                <input id="temp_has_tax" name="temp_has_tax" type="hidden" class="form-control text-right" value="0">
                                <input id="temp_tax" name="temp_tax" type="hidden" class="form-control text-right" value="0">
                            </div>

                        </div>


                        <div class="col-sm-2">

                            <!-- text input -->

                            <div class="form-group">

                                <label>Qty Terima</label>

                                <input id="temp_qty" name="temp_qty" type="text" class="form-control text-right" value="0" data-parsley-vqty required>
                                <input id="total_price" name="total_price" type="hidden" class="form-control text-right" value="0" required>

                            </div>

                        </div>
                        
                        <?php if($_SESSION['user_login']['group_name'] != "Gudang"){?>
                            <div class="col-sm-2">
                        <?php }else{ ?>
                            <div class="col-sm-2" style="display:none;">
                        <?php } ?>

                            <!-- text input -->

                            <div class="form-group">

                                <label>Ongkir</label>

                                <input id="temp_ongkir" name="temp_ongkir" type="text" class="form-control text-right" value="0">

                            </div>

                        </div>

                        <?php if($_SESSION['user_login']['group_name'] != "Gudang"){?>
                            <div class="col-sm-2">
                        <?php }else{ ?>
                            <div class="col-sm-2" style="display:none;">
                        <?php } ?>

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

                        <?php if($_SESSION['user_login']['group_name'] != "Gudang"){?>
                            <div class="col-sm-5"></div>
                        <?php }else{ ?>
                            <div class="col-sm-5" style="display:none;"></div>
                        <?php } ?>

                        <div class="col-sm-2">

                            <!-- text input -->

                            <div class="form-group">

                                <label>Expire Date</label>

                                <input id="temp_ed_date" name="temp_ed_date" type="date" class="form-control" value="0">

                            </div>

                        </div>


                        <?php if($_SESSION['user_login']['group_name'] != "Gudang"){?>
                            <div class="col-sm-4">
                        <?php }else{ ?>
                            <div class="col-sm-4" style="display:none;">
                        <?php } ?>

                            <!-- text input -->

                            <div class="form-group">

                                <label>Total</label>

                                <input id="temp_total" name="temp_total" type="text" class="form-control text-right" value="0" readonly>

                            </div>

                        </div>

                        <div class="col-sm-1">

                            <!-- text input -->

                            <label>&nbsp;</label>

                            <div class="form-group">

                                <div class="col-12">

                                    <button id="btnadd_temp" class="btn btn-md btn-primary rounded-circle" style="margin-left: 2px;"><i class="fas fa-plus"></i></button>

                                </div>

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

                                    <th data-priority="2">Kode Produk</th>

                                    <th data-priority="3" width="25%;">Produk</th>

                                    <?php if($_SESSION['user_login']['group_name'] != "Gudang"){?>
                                    <th data-priority="4">Harga</th>
                                    <?php } ?>

                                    <th data-priority="5">Qty Terima</th>
                                    
                                    <?php if($_SESSION['user_login']['group_name'] != "Gudang"){?>
                                    <th data-priority="6">Discount</th>

                                    <th data-priority="7">Ongkir</th>
                                    <?php } ?>

                                    <th data-priority="8">E.D</th>
                                    
                                    <?php if($_SESSION['user_login']['group_name'] != "Gudang"){?>
                                    <th data-priority="9">Total</th>
                                    <?php } ?>

                                    <th data-priority="10">Aksi</th>

                                </tr>

                            </thead>

                        </table>

                        <template id="template_row_temp">

                           <tr>

                               <td>{row}</td>

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

                            <textarea id="purchase_remark" name="purchase_remark" class="form-control" placeholder="Catatan" maxlength="500" rows="3"></textarea>

                        </div>

                    </div>

                </div>

                <div class="col-lg-6 text-right">
                
                <?php if($_SESSION['user_login']['group_name'] != "Gudang"){?>
                    <div>
                <?php }else{ ?>
                    <div style="display:none;">
                <?php } ?>
                    <div class="form-group row">
                        <label for="footer_sub_total" class="col-sm-7 col-form-label text-right:">Sub Total:</label>
                        <div class="col-sm-5">
                            <input id="footer_sub_total" name="footer_sub_total" type="text" class="form-control text-right" value="0" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
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
                        <label for="footer_dp" class="col-sm-7 col-form-label text-right:">Tunai/DP :</label>
                        <div class="col-sm-5">
                            <input id="footer_dp" name="footer_dp" type="text" class="form-control text-right" value="0">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="total_credit" class="col-sm-7 col-form-label text-right:">Kredit :</label>
                        <div class="col-sm-5">
                            <input id="footer_total_credit" name="footer_total_credit" type="text" class="form-control text-right" value="0" readonly>
                        </div>
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
                    <button class="btn btn-danger close-modal-temp"><i class="fas fa-times-circle"></i> Batal</button>
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
                    <button class="btn btn-danger close-modal-footer"><i class="fas fa-times-circle"></i> Batal</button>
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

        let total_temp_discount = new AutoNumeric('#total_temp_discount', configRp);

        let edit_temp_discount1 = new AutoNumeric('#edit_temp_discount1', configRp);

        let edit_temp_discount_percentage1 = new AutoNumeric('#edit_temp_discount_percentage1', configMargin);

        let edit_temp_discount2 = new AutoNumeric('#edit_temp_discount2', configRp);

        let edit_temp_discount_percentage2 = new AutoNumeric('#edit_temp_discount_percentage2', configMargin);

        let edit_temp_discount3 = new AutoNumeric('#edit_temp_discount3', configRp);

        let edit_temp_discount_percentage3 = new AutoNumeric('#edit_temp_discount_percentage3', configMargin);

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

        let footer_dp = new AutoNumeric('#footer_dp', configRp);

        let footer_total_credit = new AutoNumeric('#footer_total_credit', configRp);


        function _initButton() {
            $('#btnadd').prop('disabled', !hasRole('purchase.add'));
        }


        calculation_temp_total_footer();


        $('#btnadd').click(function(e) {
            e.preventDefault();
            let actUrl = base_url + '/webmin/purchase/get-purchase-temp';
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
                            let supplier_ids = items[0].temp_purchase_supplier_id;
                            let supplier_names = items[0].temp_purchase_supplier_name;
                            setSelect2('#supplier_id', supplier_ids, supplier_names);
                            $('#supplier_id').attr("disabled", true);
                            let po_ids = items[0].temp_purchase_po_id;
                            let po_invs = items[0].temp_purchase_po_invoice;
                            console.log(items);
                            setSelect2('#no_po_purchase', po_ids, po_invs);
                        }else{
                            clearHeader();
                            cleardiscountfooter();
                        }
                        clearItemInput();
                        showInputPage(true);
                    } else {
                        message.error(response.result.message);
                    }

                }
            })

        })

        let tblhdpurchase = $("#tblhdpurchase").DataTable({
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
                url: base_url + '/webmin/purchase/tblpurchase',
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
                width: 100
            },
            {
                targets: [0, 3, 5],
                orderable: false,
                searchable: false,
            },
            {
                targets: [0],
                className: "text-right",
            },
            ],
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

            let po_id = $('#no_po_purchase').val();

            let po_inv = $("#no_po_purchase option:selected" ).text();

            let btnSubmit = $('#btnadd_temp');

            let form = $('#frmaddtemp');

            form.parsley().validate();

            if (form.parsley().isValid()) {

                let actUrl = base_url + '/webmin/purchase/temp-add';

                let formValues = {

                    temp_purchase_id: $('#temp_purchase_id').val(),

                    temp_purchase_po_id: po_id,

                    temp_purchase_po_inv: po_inv,

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

                    temp_purchase_suplier_id:supplier_id,

                    total_temp_discount:total_discount,

                    temp_purchase_suplier_name:supplier_name,

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


        $("#tbltemp").on('click', '.btnedit', function(e) {

         e.preventDefault();

         let json_data = $(this).attr('data-json');

         let [json, is_json, error] = parseJSON(htmlEntities.decode(json_data));

         if (is_json) {

             $('#temp_purchase_id').val(json.temp_purchase_id);

             $('#item_id').val(json.temp_purchase_item_id);

             $('#product_name').val(json.product_name);

             temp_price.set(json.temp_purchase_price);

             temp_qty.set(json.temp_purchase_qty);

             temp_ongkir.set(json.temp_purchase_ongkir);

             temp_discount1.set(json.temp_purchase_discount1);

             temp_discount2.set(json.temp_purchase_discount2);

             temp_discount3.set(json.temp_purchase_discount3);

             temp_discount_percentage1.set(json.temp_purchase_discount1_percentage);

             temp_discount_percentage2.set(json.temp_purchase_discount2_percentage);

             temp_discount_percentage3.set(json.temp_purchase_discount3_percentage);

             total_price.set(json.temp_purchase_qty * json.temp_purchase_price);

             total_temp_discount.set(json.temp_purchase_discount_total);

             $('#temp_ed_date').val(json.temp_purchase_expire_date);

             $('#temp_po_id').val(json.temp_purchase_id );

             $('#temp_tax').val(json.temp_purchase_ppn);

             temp_total.set(json.temp_purchase_total);

             temp_dpp.set(json.temp_purchase_dpp);

             temp_tax.set(json.temp_purchase_ppn);

             $('#temp_qty').focus();

             $('#supplier_id').attr("disabled", true);

         } else {

             getTemp();

             message.error('Terjadi kesalahan dalam memproses data, harap coba lagi');

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

        function loadTempData(items) {

            let template = $('#template_row_temp').html();

            let tbody = '';

            let row = 1;

            let temp_total_order = 0;

            items.forEach((val, key) => {

                let item = template;

                let data_json = htmlEntities.encode(JSON.stringify(val));

                let temp_purchase_id  = val.temp_purchase_id;

                let temp_purchase_item_id = val.temp_purchase_item_id;

                let item_code = val.item_code;

                let product_name  = val.product_name+'('+val.unit_name+')';

                let temp_purchase_price  = val.temp_purchase_price;

                let temp_purchase_qty = parseFloat(val.temp_purchase_qty);

                let temp_purchase_total_disc = val.temp_total_discount;

                let temp_purchase_ongkir = val.temp_purchase_ongkir;

                let temp_purchase_expire_date = val.temp_purchase_expire_date;

                let temp_purchase_total = val.temp_purchase_total;

                let has_tax = val.has_tax;



                item = item.replaceAll('{row}', row)

                .replaceAll('{item_code}', val.item_code)

                .replaceAll('{product_name}', product_name)

                .replaceAll('{temp_price}', numberFormat(temp_purchase_price, true))

                .replaceAll('{temp_qty}', numberFormat(temp_purchase_qty, true))

                .replaceAll('{temp_disc}', numberFormat(temp_purchase_total_disc, true))

                .replaceAll('{temp_ongkir}', numberFormat(temp_purchase_ongkir, true))

                .replaceAll('{temp_ed}', temp_purchase_expire_date)

                .replaceAll('{temp_total}', numberFormat(temp_purchase_total, true))

                .replaceAll('{temp_id}', temp_purchase_id)

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

        $("#tbltemp").on('click', '.btndelete', function(e) {

            e.preventDefault();

            let id = $(this).attr('data-id');

            let actUrl = base_url + '/webmin/purchase/temp-delete/' + id;

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


        function clearTemp() {

            let actUrl = base_url + '/webmin/purchase/clear-temp';

            ajax_get(actUrl, null, {

                success: function(response) {

                    console.log(response);

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

            temp_tax.set(0);

            cleardiscount();

            $('#temp_desc').val('');

        }

        function clearHeader()
        {
         setSelect2("#no_po_purchase", '','');

         setSelect2("#supplier_id", '','');

         setSelect2("#payment_type", '','');

         setSelect2("#warehouse", '', '');

         $("#due_date").val("");

         $("#faktur_date").val("");

         $("#no_invoice_suplier").val("");
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

    function setfootervalue(){
        let actUrl = base_url + '/webmin/purchase/get-purchase-footer';
        ajax_get(actUrl, null, {
            success: function(response) {   
                if (response.result.success == 'TRUE') {
                    if(response.result.data.length > 0){
                        if(response.result.data[0].subTotal == null){
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
        let actUrl = base_url + '/webmin/purchase/get-purchase-tax';
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

    function calculation_temp_total_footer(){
        footer_dpp.set(Number(footer_sub_total.get()) - Number(footer_total_discount.get()));

        if($('#has_tax').val() == 'Pajak'){
            footer_total_ppn.set(Number(footer_dpp.get() * 0.11));
        }else{
            footer_total_ppn.set(0);   
        }
        footer_total_invoice.set(Number(footer_dpp.get()) + Number(footer_total_ppn.get()) + Number(footer_total_ongkir.get()));
        footer_total_credit.set(Number(footer_dpp.get()) + Number(footer_total_ppn.get()) + Number(footer_total_ongkir.get()));


    }

    $('#btncancel').click(function(e) {

        e.preventDefault();

        message.question('Yakin ingin menutup halaman ini dan menghapus data input ?').then(function(answer) {

            let yes = parseMessageResult(answer);

            if (yes) {

                clearItemInput();

                clearTemp();

                showInputPage(false);

            }

        })

    })

    $('#btnsave').click(function(e) {

        e.preventDefault();

        let form = $('#frmaddtemp');

        let btnSubmit = $('#btnsave');

        let purchase_sub_total = parseFloat(footer_sub_total.getNumericString());

        let purchase_discount1 = parseFloat(footer_discount1.getNumericString());

        let purchase_discount1_percentage = parseFloat(footer_discount_percentage1.getNumericString());

        let purchase_discount2 = parseFloat(footer_discount2.getNumericString());

        let purchase_discount2_percentage = parseFloat(footer_discount_percentage2.getNumericString());

        let purchase_discount3 = parseFloat(footer_discount3.getNumericString());

        let purchase_discount3_percentage = parseFloat(footer_discount_percentage3.getNumericString());

        let purchase_total_discount = parseFloat(footer_total_discount.getNumericString());

        let purchase_dpp = parseFloat(footer_dpp.getNumericString());

        let purchase_total_ppn = parseFloat(footer_total_ppn.getNumericString());

        let purchase_total_ongkir = parseFloat(footer_total_ongkir.getNumericString());

        let purchase_total = parseFloat(footer_total_invoice.getNumericString());

        let purchase_dp = parseFloat(footer_dp.getNumericString());

        let purchase_credit = parseFloat(footer_total_credit.getNumericString());

        let purchase_down_payment = parseFloat(footer_dp.getNumericString());

        let purchase_remaining_debt = parseFloat(footer_total_credit.getNumericString());

        let no_po_purchase = $('#no_po_purchase').val();

        let warehouse = $('#warehouse').val();

        let payment_type = $('#payment_type').val();

        let faktur_date = $('#faktur_date').val();

        let question = 'Yakin ingin menyimpan data Pembelian?';

        let actUrl = base_url + '/webmin/purchase/save/add';

        if(warehouse == null){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Silahkan Isi Gudang Terlebih Dahulu !'
            })

        }else if(payment_type == null){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Silahkan Isi Metode Pembayaran !'
            })

        }else if(faktur_date == 0){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Silahkan Isi Tanggal Faktur !'
            })

        }else{

            message.question(question).then(function(answer) {

                let yes = parseMessageResult(answer);

                if (yes) {

                    let formValues = {

                        purchase_po_invoice: $("#no_po_purchase option:selected").text(),

                        purchase_date: $('#purchase_order_date').val(),

                        purchase_faktur_date: $('#faktur_date').val(),

                        purchase_supplier_id: $('#supplier_id').val(),

                        purchase_due_date: $('#due_date').val(),

                        purchase_warehouse_id: $('#warehouse').val(),

                        purchase_remark: $('#purchase_remark').val(),

                        purchase_suplier_no: $('#no_invoice_suplier').val(),

                        purchase_sub_total: purchase_sub_total,

                        purchase_discount1: purchase_discount1,

                        purchase_discount1_percentage: purchase_discount1_percentage,

                        purchase_discount2: purchase_discount2,

                        purchase_discount2_percentage: purchase_discount2_percentage,

                        purchase_discount3: purchase_discount3,

                        purchase_discount3_percentage: purchase_discount3_percentage,

                        purchase_total_discount : purchase_total_discount,

                        purchase_total_dpp: purchase_dpp,

                        purchase_total_ppn: purchase_total_ppn,

                        purchase_total_ongkir:purchase_total_ongkir,

                        purchase_total: purchase_total,

                        purchase_payment_method_id : $('#payment_type').val(),

                        purchase_down_payment: purchase_down_payment,

                        purchase_remaining_debt : purchase_remaining_debt,

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

                               // let invoice = response.result.purchase_order_id;

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

                    updateTableHeader();

                }

            });

                }

            })

        }

    });


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

        $("#payment_type").select2({
            placeholder: '-- Pilih Jenis Pembayaran --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/payment-method",
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


        $("#no_po_purchase").select2({
            placeholder: '-- Pilih No PO --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/no-po",
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
                select: function(event, ui) {
                    console.log("asdas");
                },
            },
        });

        $("#no_po_purchase").change(function(e) {

            let id = $(this).val();

            if (id != null) {

                let actUrl = base_url + '/webmin/purchase/copy-purchase-order/' + id;

                ajax_get(actUrl, null, {

                    success: function(response) {

                        if (response.success) {

                            if (response.result.success) {

                                let header = response.result.header;

                                let items = response.result.data;

                                if (header.purchase_order_status == 'Pending') {

                                    setSelect2("#supplier_id", header.purchase_order_supplier_id, header.supplier_name);

                                    $('#supplier_id').prop('disabled', true);

                                    setSelect2("#warehouse", header.purchase_order_warehouse_id, header.warehouse_name);

                                    footer_discount_percentage1.set(header.purchase_order_discount1_percentage);

                                    footer_discount_percentage2.set(header.purchase_order_discount2_percentage);

                                    footer_discount_percentage3.set(header.purchase_order_discount3_percentage);

                                    footer_total_discount.set(header.purchase_order_total_discount);

                                    footer_discount1.set(header.purchase_order_discount1);

                                    footer_discount2.set(header.purchase_order_discount2);

                                    footer_discount3.set(header.purchase_order_discount3);

                                } else {

                                    $('#supplier_id').prop('disabled', true);

                                    cleardiscountfooter();

                                }

                                supplier_tax = header.supplier_tax;

                                loadTempData(items);

                                clearItemInput();

                                

                            } else {

                                message.error(response.result.message);

                                setSelect2("#purchase_id");

                                $('#supplier_id').prop('disabled', false);

                            }

                        }

                    }

                })

            } else {

                $('#supplier_id').prop('disabled', false);

            }



        })

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

                $('#temp_has_tax').val(ui.item.has_tax);
            },

        });
        // Table //



        //End Table //

        function showInputPage(x) {

            if (x) {

                $('#purchase_list').hide();

                $('#purchase_input').show();

            } else {

                $('#purchase_list').show();

                $('#purchase_input').hide();

            }

        }

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
                footer_discount_percentage3: $('#footer_discount_percentage3').val()
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

        $('#temp_qty').on('change', function() {
            cleardiscount();
            cleardiscountfooter();
            calculation_temp_total();
            
        });

        $('#temp_price').on('change', function() {
            cleardiscount();
            cleardiscountfooter();
            calculation_temp_total();
            
        });

        

        $('#footer_dp').on('change', function() {
            if(footer_total_invoice.get() > 0){
                let footer_total_credit_cal = footer_total_invoice.get() - footer_dp.get();
                footer_total_credit.set(footer_total_credit_cal.toFixed(2));
            }else{
                Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Grand Total Masih 0 !'
              })
            }
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

                    total_temp_discount.set(Number(edit_temp_discount1) + Number(edit_temp_discount2) + Number(edit_temp_discount3));
                    calculation_temp_total();
                }
            })
        })

        function calculation_temp_total(){
            var price_calculation = AutoNumeric.getAutoNumericElement('#temp_price').get();
            let ppn = price_calculation - (price_calculation - (price_calculation * 0.11));
            let dpp = price_calculation - ppn;
            let qty_calculation = parseFloat(temp_qty.getNumericString());
            let subtotal_calculation = price_calculation * qty_calculation;
            var has_tax_temp_val = $('#temp_has_tax').val();
            total_price.set(subtotal_calculation);
            temp_dpp.set(parseFloat(dpp.toFixed(2)));
            if(has_tax_temp_val == 'N'){
                temp_tax.set(0); 
            }else{
                temp_tax.set(parseFloat(ppn.toFixed(2))); 
            }
            temp_total.set(total_price.get() - total_temp_discount.get());
            
        }

        function updateTableHeader() {
            tblhdpurchase.ajax.reload(null, false);
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

             width: 100,

             targets: 6

         },
         {

             targets: [8],

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

     _initButton();

     showInputPage(false);

 })

</script>

<?= $this->endSection() ?>