<?php
$themeUrl = base_url('assets/adminlte3');
$assetsUrl = base_url('assets');
?>

<?= $this->extend('webmin/template/admin_template') ?>

<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<div id="salesadmin_list">

    <section class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h1>Penjualan</h1>

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

                            <table id="tblsalesadmin" class="table table-bordered table-hover" width="100%">

                                <thead>

                                    <tr>

                                        <th data-priority="1">#</th>

                                        <th data-priority="2">No Invoice</th>

                                        <th data-priority="3">Tanggal</th>

                                        <th data-priority="4">Salesman</th>

                                        <th data-priority="5">Customer</th>

                                        <th data-priority="6">Total Harga</th>

                                        <th data-priority="7">Status Pembayaran</th>

                                        <th data-priority="8">Sisa Pembayaran</th>

                                        <th data-priority="9">Aksi</th>

                                    </tr>

                                </thead>

                                <tbody>

                                </tbody>

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



<div id="sales_input">

    <section class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h1 id="title-frmpurchaseorder">Tambah Penjualan</h1>

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

                            <form id="frmsalesadmin" class="form-horizontal form-space">

                                <div class="form-group row">

                                    <label for="noinvoice" class="col-sm-1 col-form-label text-right">No Invoice :</label>

                                    <div class="col-sm-3">

                                       <input id="sales_admin_id" name="sales_admin_id" type="hidden" class="form-control">

                                       <input id="sales_admin_invoice" name="sales_admin_invoice" type="text" class="form-control" value="AUTO" readonly>

                                   </div>

                                   <div class="col-md-1">

                                   </div>

                                   <label for="due_date" class="col-sm-1 col-form-label text-right">Tempo :</label>

                                   <div class="col-sm-3">
                                    <input id="due_date" name="due_date" type="date" class="form-control">

                                </div>

                                <label for="tanggal" class="col-sm-1 col-form-label text-right">Tanggal :</label>

                                <div class="col-sm-2">

                                    <input id="sales_date" name="sales_date" type="date" class="form-control" value="<?= date('Y-m-d') ?>" readonly>

                                </div>
                            </div>

                            <div class="form-group row">

                                <label for="customer_id" class="col-sm-1 col-form-label text-right">Customer :</label>

                                <div class="col-sm-3">

                                    <select id="customer_id" name="customer_id" class="form-control"></select>

                                </div>

                                <div class="col-sm-1">



                                </div>

                                <label for="Sales" class="col-sm-1 col-form-label text-right">Sales :</label>

                                <div class="col-md-3">

                                    <select id="salesman_id" name="salesman_id" class="form-control select-salesman fs-20"></select>

                                </div>               

                                <label for="cabang" class="col-sm-1 col-form-label text-right">Cabang :</label>

                                <div class="col-sm-2">

                                    <select id="store_id" name="store_id" class="form-control"></select>

                                </div>
                            </div>


                            <div class="form-group row">

                                <label for="suplier" class="col-sm-1 col-form-label text-right">Payment :</label>

                                <div class="col-sm-3">

                                    <select id="payment_type" name="payment_type" class="form-control"></select>

                                </div>

                                <div class="col-md-5">

                                </div>  


                                <label for="user" class="col-sm-1 col-form-label text-right">User :</label>

                                <div class="col-sm-2">

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

                               <input id="temp_sales_admin_id" name="temp_sales_admin_id" type="hidden" value="">

                               <div class="col-sm-3">

                                <!-- text input -->

                                <div class="form-group">

                                    <label>Produk</label>

                                    <input id="item_id" name="item_id" type="hidden" value="">

                                    <input id="product_name" name="product_name" type="text" class="form-control" placeholder="ketikkan nama produk" value="" data-parsley-vproductname required>

                                </div>

                            </div>

                            <div class="col-sm-2">

                                <!-- text input -->

                                <div class="form-group">

                                    <label>Harga Jual Per Unit</label>

                                    <input id="temp_purchase_price" name="temp_purchase_price" type="hidden" class="form-control text-right">

                                    <input id="temp_purchase_tax" name="temp_purchase_tax" type="hidden" class="form-control text-right">

                                    <input id="temp_purchase_cogs" name="temp_purchase_cogs" type="hidden" class="form-control text-right">

                                    <input id="temp_price" name="temp_price" type="text" class="form-control text-right" value="0" data-parsley-vprice required>

                                </div>

                            </div>

                            <div class="col-sm-2">

                                <!-- text input -->

                                <div class="form-group">

                                    <label>Qty</label>

                                    <input id="temp_qty" name="temp_qty" type="text" class="form-control text-right" value="0" data-parsley-vqty required>
                                    <input id="total_price" name="total_price" type="hidden" class="form-control text-right" value="0" data-parsley-vqty required>

                                </div>

                            </div>

                            <div class="col-sm-2">

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

                            <div class="col-sm-2">

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

                                        <button id="btnadd_temp" class="btn btn-md btn-primary rounded-circle float-right" style="margin-left: 2px;"><i class="fas fa-plus"></i></button>

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

                                        <th data-priority="3">Produk</th>

                                        <th data-priority="4">Qty</th>

                                        <th data-priority="5">Harga Satuan</th>

                                        <th data-priority="6">Discount</th>

                                        <th data-priority="7">Total</th>

                                        <th data-priority="8">Aksi</th>

                                    </tr>

                                </thead>

                                <tbody></tbody>

                            </table>


                            <template id="template_row_temp">

                             <tr>

                                 <td>{row}</td>

                                 <td>{item_code}</td>

                                 <td>{product_name}</td>

                                 <td>{temp_qty}</td>

                                 <td>{temp_sales_price}</td>

                                 <td>{discount}</td>

                                 <td>{total}</td>

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

                                <textarea id="sales_remark" name="sales_remark" class="form-control" placeholder="Catatan" maxlength="500" rows="3"></textarea>

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
                            <label for="footer_total_ppn" class="col-sm-7 col-form-label text-right:">PPN :</label>
                            <div class="col-sm-4">
                                <input id="footer_total_ppn" name="footer_total_ppn" type="text" class="form-control text-right" value="0" readonly>
                            </div>
                            <div class="col-sm-1">
                              <div class="icheck-primary d-inline">
                                <input type="checkbox" id="ppn_check" style="width:25px; height:25px;">
                                <label for="ppn_check">
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="footer_total_invoice" class="col-sm-7 col-form-label text-right:">Total :</label>
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
                        <label for="footer_credit" class="col-sm-7 col-form-label text-right:">Kredit :</label>
                        <div class="col-sm-5">
                            <input id="footer_credit" name="footer_credit" type="text" class="form-control text-right" value="0" readonly>
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

        let temp_purchase_price = new AutoNumeric('#temp_purchase_price', configRp);

        let temp_purchase_tax = new AutoNumeric('#temp_purchase_tax', configRp);

        let temp_purchase_cogs = new AutoNumeric('#temp_purchase_cogs', configRp);

        let temp_qty = new AutoNumeric('#temp_qty', configQty);

        let total_price = new AutoNumeric('#total_price', configRp);

        //popup Temp discount //

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

       //End popup Temp discount //

       let temp_total = new AutoNumeric('#temp_total', configRp);

       let footer_sub_total = new AutoNumeric('#footer_sub_total', configRp);

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

       //End popup footer discount //

       let footer_total_invoice = new AutoNumeric('#footer_total_invoice', configRp);

       let footer_total_ppn = new AutoNumeric('#footer_total_ppn', configRp);

       let footer_dp = new AutoNumeric('#footer_dp', configRp);

       let footer_credit = new AutoNumeric('#footer_credit', configRp);


       calculation_temp_total_footer();


        // init component //

        function _initButton() {

            $('#btnadd').prop('disabled', !hasRole('sales_admin.add'));
            $('.btnedit').prop('disabled', !hasRole('sales_admin.edit'));
            $('.btndelete').prop('disabled', !hasRole('sales_admin.delete'));
            $('.btnprint').prop('disabled', !hasRole('sales_admin.print'));
        }



        // select2 //


        $("#store_id").select2({
            placeholder: '-- Pilih Store --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/store",
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

        $("#salesman_id").select2({
            placeholder: '-- Pilih Salesman --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/salesman",
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


        $("#customer_id").select2({
            placeholder: '-- Pilih Customer --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/customer",
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

                   url: base_url + '/webmin/sales-admin/search-product',

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

            temp_price.set(parseFloat(ui.item.price));

            temp_purchase_price.set(parseFloat(ui.item.purchase_price));

            temp_purchase_tax.set(parseFloat(ui.item.tax));

            temp_purchase_cogs.set(parseFloat(ui.item.cogs));

        },

    });
        // Table //

        let tblsalesadmin = $("#tblsalesadmin").DataTable({
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
                url: base_url + '/webmin/sales-admin/tblsalesadmin',
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

             targets: [0,7],

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

        //End Table //

        function showInputPage(x) {

            if (x) {

                $('#salesadmin_list').hide();

                $('#sales_input').show();



            } else {

                $('#salesadmin_list').show();

                $('#sales_input').hide();

            }

        }


        $("#tblsalesadmin").on('click', '.btnedit', function(e) {

            e.preventDefault();

            let id = $(this).attr('data-id');

            let actUrl = base_url + '/webmin/sales-admin/edit-salesadmin/' + id;

            ajax_get(actUrl, null, {

                success: function(response) {

                    if (response.success) {

                        if (response.result.success) {

                            let form = $('#frmsalesadmin');

                            let items = response.result.data;

                            $('#title-frmsalesadmin').html('Ubah Penjualan Admin');

                            let header = response.result.header;

                            let customer_id = header.sales_customer_id;

                            let customer_name = header.customer_name;

                            let payment_id = header.sales_payment_type;

                            let payment_name  = header.payment_method_name+'-'+header.bank_account_name;

                            let sales_id = header.sales_salesman_id;

                            let sales_name = header.salesman_code+'-'+header.salesman_name;

                            let store_id = header.sales_store_id;

                            let store_name = header.store_code+'-'+header.store_name;


                            let sales_admin_invoice = String(header.purchase_order_submission_inv);

                            let footer_discount1_val  = header.sales_admin_discount1;

                            let footer_discount2_val  = header.sales_admin_discount2;

                            let footer_discount3_val  = header.sales_admin_discount3;

                            let footer_discount1_percentage_val  = header.sales_admin_discount1_percentage;

                            let footer_discount2_percentage_val  = header.sales_admin_discount2_percentage;

                            let footer_discount3_percentage_val  = header.sales_admin_discount3_percentage;

                            let footer_total_discount_val  = header.sales_admin_total_discount;

                            let footer_sub_total_val  = header.sales_admin_subtotal;

                            let footer_total_ppn_val  = header.sales_admin_ppn;

                            let footer_total_dp_val  = header.sales_admin_down_payment;

                            let footer_credit_cal = header.sales_admin_remaining_payment;

                            /*

                            let footer_total_ongkir_Val  = header.purchase_order_total_ongkir;

                            let footer_total_invoice_val  = header.purchase_order_total;*/

                            $('#title-frmsalesadmin').html('Ubah Penjualan Admin');

                            formMode = 'edit';

                            setSelect2('#customer_id', customer_id, customer_name);

                            setSelect2('#payment_type', payment_id, payment_name);

                            setSelect2('#salesman_id', salesman_id, sales_name);

                            setSelect2('#store_id', store_id, store_name);

                            $('#store_id').prop("disabled", true);

                            $('#sales_admin_invoice').val(header.sales_admin_invoice);

                            $('#sales_admin_id').val(header.sales_admin_id);

                            $('#due_date').val(header.sales_due_date);

                            footer_sub_total.set(footer_sub_total_val);

                            footer_discount1.set(footer_discount1_val);

                            footer_discount2.set(footer_discount2_val);

                            footer_discount3.set(footer_discount3_val);

                            footer_discount_percentage1.set(footer_discount1_percentage_val);

                            footer_discount_percentage2.set(footer_discount2_percentage_val);

                            footer_discount_percentage3.set(footer_discount3_percentage_val);

                            footer_total_discount.set(footer_total_discount_val);

                            footer_total_ppn.set(footer_total_ppn_val);

                            if(footer_total_ppn_val > 0){
                                $('#ppn_check').prop('checked', true);
                            }

                            footer_total_invoice.set(Number(footer_sub_total_val) - Number(footer_total_discount_val) + Number(footer_total_ppn_val));

                            footer_dp.set(footer_total_dp_val);

                            footer_credit.set(footer_credit_cal);

                            loadTempData(items);

                            showInputPage(true);

                        } else {

                            message.error(response.result.message);

                        }

                    }

                }

            })
})

$("#tblsalesadmin").on('click', '.btnprint', function(e) {
    e.preventDefault();


    let id = $(this).attr('data-id');
    Swal.fire({
        title: "Cetak",
        html: "Ingin cetak <b>Faktur Penjualan</b> atau <b>Surat Jalan</b>?",
        icon: "question",
        showCancelButton: true,
        allowOutsideClick: false,
        confirmButtonColor: "#007bff",
        cancelButtonColor: "#28a745",
        confirmButtonText: 'Faktur Penjualan',
        cancelButtonText: 'Surat Jalan',
    }).then(function(answer) {
        let yes = parseMessageResult(answer);
        if (yes) {
            let invUrl = base_url + '/webmin/sales-admin/print-invoice/'+id;
            window.open(invUrl, '_blank');
        } else {
            let invUrl = base_url + '/webmin/sales-admin/printdispatch/'+id;
            window.open(invUrl, '_blank');
        }
    })
})



function loadTempData(items) {

 let template = $('#template_row_temp').html();

 let tbody = '';

 let row = 1;

 let temp_total_order = 0;

 items.forEach((val, key) => {

     let item = template;

     let data_json = htmlEntities.encode(JSON.stringify(val));

     let temp_id = val.temp_sales_admin_id;

     let item_id = val.item_id;

     let item_code  = val.item_code;

     let temp_qty = parseFloat(val.temp_qty);

     let product_name = val.product_name+'('+val.unit_name+')';

     let temp_purchase_price = val.temp_purchase_price;

     let temp_purchase_tax  = val.temp_purchase_tax;

     let temp_purchase_cogs  = val.temp_purchase_cogs;

     let temp_product_price  = val.temp_product_price;

     let temp_disc1 = val.temp_disc1;

     let temp_price_disc1_percentage = val.temp_price_disc1_percentage;

     let temp_disc2 = val.temp_disc2;

     let temp_price_disc2_percentage = val.temp_price_disc2_percentage;

     let temp_disc3 = val.temp_disc3;

     let temp_price_disc3_percentage = val.temp_price_disc3_percentage;

     let temp_total_discount = val.temp_total_discount;

     let temp_sales_price = val.temp_sales_price;

     item = item.replaceAll('{row}', row)

     .replaceAll('{temp_id}', temp_id)

     .replaceAll('{item_code}', item_code)

     .replaceAll('{product_name}', product_name)

     .replaceAll('{temp_qty}', numberFormat(temp_qty, true))

     .replaceAll('{temp_sales_price}', numberFormat(temp_sales_price, true))

     .replaceAll('{discount}', numberFormat(temp_total_discount, true))

     .replaceAll('{total}', numberFormat(temp_sales_price, true))

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

 clearItemInput();

 if(formMode == 'add'){

     setfootervalue();

 }

 _initTooltip();

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


$('#btnaddfooterdiscount').click(function(e) {
    e.preventDefault();
    footerdiscountMode({
        temp_discount1: $('#temp_discount1').val(),
        temp_discount2: $('#temp_discount2').val(),
        temp_discount3: $('#temp_discount3').val(),
        temp_discount_percentage1: $('#temp_discount_percentage1').val(),
        temp_discount_percentage2: $('#temp_discount_percentage2').val(),
        temp_discount_percentage3: $('#temp_discount_percentage3').val(),
    });
})

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
    message.question('Yakin untuk penambahan discount?').then(function(answer) {
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
            footer_dp.set(0);
            footer_total_ppn.set(0);
            $('#ppn_check').prop('checked', false);
            calculation_temp_total_footer();
        }
    })
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

function footerdiscountMode(data) {
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
                //cleardiscount();
                $('#modal-tempdiscount').modal('hide');
            }
        })
})

$('.close-modal-footer').click(function(e) {
    e.preventDefault();
    message.question('Yakin ingin menutup halaman ini?').then(function(answer) {
        let yes = parseMessageResult(answer);
        if (yes) {
                //cleardiscount();
                $('#modal-footerdiscount').modal('hide');
            }
        })
})


$('#temp_qty').on('change', function() {
    calculation_temp_total();
    cleardiscount();
});

$('#footer_dp').on('input', function() {
    footer_credit.set(footer_total_invoice.get() - footer_dp.get());
});

$('#temp_price').on('change', function() {
    calculation_temp_total();
    cleardiscount();
});


$('#edit_temp_discount_percentage1').on('change', function() {
 if(temp_qty.get() < 1){
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Slahkan Isi Qty Terlebih Dahulu'
  })
    edit_temp_discount_percentage1.set('0.00%');
    edit_temp_discount1.set(0);
}
let edit_temp_discount1_cal = total_price.get() * (edit_temp_discount_percentage1.get()/100);
edit_temp_discount1.set(edit_temp_discount1_cal.toFixed(2));
});

$('#edit_temp_discount1').on('change', function() {
    if(temp_qty.get() < 1){
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Slahkan Isi Qty Terlebih Dahulu'
      })
        edit_temp_discount_percentage1.set('0.00%');
        edit_temp_discount1.set(0);
    }
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


$(document).on('input', '#ppn_check', function(e) {
    e.preventDefault();
    if ($('#ppn_check').is(":checked"))
    {
      let footer_sub_total_cal = parseFloat(footer_sub_total.getNumericString());
      let footer_total_discount_cal = parseFloat(footer_total_discount.getNumericString());
      let footer_total_ppn_cal = (footer_sub_total_cal - footer_total_discount_cal) * 0.11;
      footer_total_ppn.set(footer_total_ppn_cal);
      footer_total_invoice.set(footer_sub_total_cal - footer_total_discount_cal + footer_total_ppn_cal);
      footer_dp.set(0);
      footer_credit.set(footer_sub_total_cal - footer_total_discount_cal + footer_total_ppn_cal);
  }else{
      let footer_sub_total_cal = parseFloat(footer_sub_total.getNumericString());
      let footer_total_discount_cal = parseFloat(footer_total_discount.getNumericString());
      footer_total_ppn.set(0);
      footer_dp.set(0);
      footer_total_invoice.set(footer_sub_total_cal - footer_total_discount_cal);
      footer_credit.set(footer_sub_total_cal - footer_total_discount_cal);
  }
});

function calculation_temp_total(){
    var price_calculation = AutoNumeric.getAutoNumericElement('#temp_price').get();
    let qty_calculation = parseFloat(temp_qty.getNumericString());
    let subtotal_calculation = price_calculation * qty_calculation;
    total_price.set(subtotal_calculation);
    temp_total.set(total_price.get() - total_temp_discount.get());
}

function calculation_temp_total_footer(){
    footer_total_invoice.set(Number(footer_sub_total.get()) - Number(footer_total_discount.get()) - Number(footer_total_ppn.get()));
    footer_credit.set(Number(footer_sub_total.get()) - Number(footer_total_discount.get()));
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
}


$('#btnadd_temp').click(function(e) {

 e.preventDefault();

 let purchase_price = parseFloat(temp_purchase_price.getNumericString());

 let purchase_tax = parseFloat(temp_purchase_tax.getNumericString());

 let purchase_cogs = parseFloat(temp_purchase_cogs.getNumericString());

 let price = parseFloat(temp_price.getNumericString());

 let qty = parseFloat(temp_qty.getNumericString());

 let discount1 = parseFloat(temp_discount1.getNumericString());

 let discount2 = parseFloat(temp_discount2.getNumericString());

 let discount3 = parseFloat(temp_discount3.getNumericString());

 let discount_percentage1 = parseFloat(temp_discount_percentage1.getNumericString());

 let discount_percentage2 = parseFloat(temp_discount_percentage2.getNumericString());

 let discount_percentage3 = parseFloat(temp_discount_percentage3.getNumericString());

 let total_discount = parseFloat(total_temp_discount.getNumericString());

 let total = parseFloat(temp_total.getNumericString());

 let btnSubmit = $('#btnadd_temp');

 let form = $('#frmaddtemp');

 form.parsley().validate();

 if (form.parsley().isValid()) {

     let actUrl = base_url + '/webmin/sales-admin/temp-add';

     let formValues = {

         temp_sales_admin_id: $('#temp_sales_admin_id').val(),

         item_id: $('#item_id').val(),

         temp_purchase_price: purchase_price,

         temp_purchase_tax: purchase_tax,

         temp_purchase_cogs: purchase_cogs,

         temp_price: price,

         temp_qty: qty,

         temp_discount1: discount1,

         temp_discount2: discount2,

         temp_discount3: discount3,

         temp_discount_percentage1: discount_percentage1,

         temp_discount_percentage2: discount_percentage2,

         temp_discount_percentage3: discount_percentage3,

         total_temp_discount: total_discount,

         temp_total: total

     };

     btnSubmit.prop('disabled', true);

     ajax_post(actUrl, formValues, {

         success: function(response) {

             if (response.success) {

                 if (response.result.success) {

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

    vprice: 'Harga Jual wajib diatas Rp 0',

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



$("#tbltemp").on('click', '.btnedit', function(e) {

 e.preventDefault();

 let json_data = $(this).attr('data-json');

 let [json, is_json, error] = parseJSON(htmlEntities.decode(json_data));

 if (is_json) {

    $('#temp_sales_admin_id').val(json.temp_sales_admin_id);

    $('#item_id').val(json.item_id);

    $('#product_name').val(json.product_name);

    temp_purchase_price.set(json.temp_purchase_price);

    temp_purchase_tax.set(json.temp_purchase_tax);

    temp_price.set(json.temp_sales_price);

    temp_qty.set(json.temp_qty);

    temp_discount1.set(json.temp_disc1);

    temp_discount2.set(json.temp_disc2);

    temp_discount3.set(json.temp_disc3);

    temp_discount_percentage1.set(json.temp_price_disc1_percentage);

    temp_discount_percentage2.set(json.temp_price_disc2_percentage);

    temp_discount_percentage3.set(json.temp_price_disc3_percentage);

    total_temp_discount.set(json.temp_total_discount);

    temp_total.set(json.temp_sales_price);

    $('#temp_qty').focus();

} else {

        //getTemp();

        message.error('Terjadi kesalahan dalam memproses data, harap coba lagi');

    }

})  

$("#tbltemp").on('click', '.btndelete', function(e) {

    e.preventDefault();

    let id = $(this).attr('data-id');

    let actUrl = base_url + '/webmin/sales-admin/temp-delete/' + id;

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

$('#btnadd').click(function(e) {

 e.preventDefault();
 let actUrl = base_url + '/webmin/sales-admin/get-salesadmin-temp';
 ajax_get(actUrl, null, {
    success: function(response) {   
        if (response.result.success == 'TRUE') {
            let form = $('#frmsalesadmin');
            let items = response.result.data;
            $('#title-frmsalesadmin').html('Penjualan Admin');
            formMode = 'add';
            clearAll();
            clearItemInput();
            cleardiscountfooter();
            footer_total_discount.set(0);
            footer_total_ppn.set(0);
            $('#ppn_check').prop('checked', false);
            footer_dp.set(0);
            loadTempData(items);
            showInputPage(true);
        } else {
           message.error(response.result.message);
       }

   }
})
})




$("#btnexcellimport").click(function(e) {
    e.preventDefault();
    let datasend = $('#excell').files;
    $.ajax({
      url: base_url + '/webmin/sales-admin/import-excell',
      method:"POST",
      data:datasend,
      processData:false,
      contentType:false,
      cache:false,
      success:function(data){
        console.log(data);
    }
})
})

function clearItemInput() {

   let form = $('#frmaddtemp');

   form.parsley().reset();

   $('#item_id').val('');

   $('#product_name').val('');

   temp_purchase_price.set(0);

   temp_purchase_tax.set(0);

   temp_price.set(0);

   temp_qty.set(0);

   temp_total.set(0);

   cleardiscount();

}


function clearAll() {

   let form = $('#frmaddtemp');

   form.parsley().reset();

   setSelect2('#customer_id', '', '');

   setSelect2('#payment_type', '', '');

   setSelect2('#salesman_id', '', '');

   setSelect2('#store_id', '', '');

   $('#due_date').val('');

   clearItemInput()

   cleardiscount();

   cleardiscountfooter();

}


function setfootervalue(){

    let actUrl = base_url + '/webmin/sales-admin/get-salesadmin-footer';
    ajax_get(actUrl, null, {
        success: function(response) { 

            if (response.result.success == 'TRUE') {

                if(response.result.data.length > 0){
                    if(response.result.data[0].total_footer_price == 'null'){
                        //footer_sub_total.set(0);
                        //footer_total_ongkir.set(0);
                    }else{
                        footer_sub_total.set(response.result.data[0].total_footer_price);
                        footer_total_invoice.set(response.result.data[0].total_footer_price);
                        footer_credit.set(response.result.data[0].total_footer_price);
                    }
                }
            } else {
                message.error(response.result.message);
            }
        }
    });
}


$('#btnsave').click(function(e) {

    e.preventDefault();

    let form = $('#frmaddtemp');

    let btnSubmit = $('#btnsave');

    let sales_admin_remaining_payment = parseFloat(footer_credit.getNumericString());

    let sales_admin_down_payment = parseFloat(footer_dp.getNumericString());

    let sales_sub_total = parseFloat(footer_sub_total.getNumericString());

    let sales_discount1 = parseFloat(footer_discount1.getNumericString());

    let sales_discount2 = parseFloat(footer_discount2.getNumericString());

    let sales_discount3 = parseFloat(footer_discount3.getNumericString());

    let sales_discount_percentage1 = parseFloat(footer_discount_percentage1.getNumericString());

    let sales_discount_percentage2 = parseFloat(footer_discount_percentage2.getNumericString());

    let sales_discount_percentage3 = parseFloat(footer_discount_percentage3.getNumericString());

    let sales_total_discount = parseFloat(footer_total_discount.getNumericString());

    let sales_order_total = parseFloat(footer_total_invoice.getNumericString());

    let sales_ppn = parseFloat(footer_total_ppn.getNumericString());

    let customer_id = $('#customer_id').val();

    let payment_type = $('#payment_type').val();

    let due_date = $('#due_date').val();

    let salesman_id = $('#salesman_id').val();

    let sales_date = $('#salesman_id').val();

    let store_id = $('#store_id').val();

    let question = 'Yakin ingin menyimpan data Penjualan?';

    let actUrl = base_url + '/webmin/sales-admin/save/add';

    if (formMode == 'edit') {

        question = 'Yakin ingin mengubah data penjualan?';

        actUrl = base_url + '/webmin/sales-admin/save/edit';

    }

    if(customer_id == null){
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Silahkan Pilih Nama Customer Terlebih Dahulu !'
      })

    }else if(payment_type == null){
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Silahkan Pilih Jenis Pembayaran Terlebih Dahulu !'
      })

    }else if(salesman_id == null){
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Silahkan Pilih Nama Sales Terlebih Dahulu !'
      })

    }else if(store_id == null){
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Silahkan Pilih Cabang Penjualan Terlebih Dahulu !'
      })

    }else{

        message.question(question).then(function(answer) {

            let yes = parseMessageResult(answer);

            if (yes) {

                let formValues = {

                    sales_admin_id: $('#sales_admin_id').val(),

                    sales_customer_id : customer_id,

                    sales_salesman_id: salesman_id,

                    sales_payment_type: payment_type,

                    sales_due_date: due_date,

                    sales_date: $('#sales_date').val(),

                    sales_store_id: store_id,

                    sales_admin_remark: $('#sales_remark').val(),

                    sales_admin_sub_total: sales_sub_total,

                    sales_admin_discount1: sales_discount1,

                    sales_admin_discount2: sales_discount2,

                    sales_admin_discount3: sales_discount3,

                    sales_admin_discount1_percentage: sales_discount_percentage1,

                    sales_admin_discount2_percentage: sales_discount_percentage2,

                    sales_admin_discount3_percentage: sales_discount_percentage3,

                    sales_admin_total_discount: sales_total_discount,

                    sales_admin_ppn:sales_ppn,

                    sales_admin_total:sales_order_total,

                    sales_admin_down_payment:sales_admin_down_payment,

                    sales_admin_remaining_payment:sales_admin_remaining_payment,

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

                                clearAll();

                                let invoice = response.result.purchase_order_id;

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

                });

            }

        })

    }

});

function updateTable() {

 tblsalesadmin.ajax.reload(null, false);

}

_initButton();

showInputPage(false);

})

</script>

<?= $this->endSection() ?>