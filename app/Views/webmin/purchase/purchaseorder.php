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

                                        <th data-priority="2">Tanggal PO</th>

                                        <th data-priority="4">Golongan</th>

                                        <th data-priority="6">Nama Supplier</th>

                                        <th data-priority="3">Total Harga</th>

                                        <th data-priority="3">Status Barang</th>

                                        <th data-priority="3">Aksi</th>

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

                                <div class="col-md-8"></div>

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

                                <input id="product_id" name="product_id" type="hidden" value="">

                                <input id="product_tax" name="product_tax" type="hidden" value="">


                                <div class="col-sm-3">

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
                                        <input id="total_price" name="total_price" type="hidden" class="form-control text-right" value="0" data-parsley-vqty required>

                                    </div>

                                </div>

                                <div class="col-sm-2">

                                    <!-- text input -->

                                    <div class="form-group">

                                        <label>Ongkir</label>

                                        <input id="temp_ongkir" name="temp_ongkir" type="text" class="form-control text-right" value="0">

                                    </div>

                                </div>

                                <div class="col-sm-2">

                                    <!-- text input -->

                                    <div class="form-group">

                                        <label>Discount</label>

                                        <input id="temp_discount1" name="temp_discount1" type="hidden" class="form-control text-right" value="0" readonly>
                                        <input id="temp_discount2" name="temp_discount2" type="hidden" class="form-control text-right" value="0" readonly>
                                        <input id="temp_discount3" name="temp_discount3" type="hidden" class="form-control text-right" value="0" readonly>
                                        <input id="total_temp_discount" name="total_temp_discount" type="text" class="form-control text-right" value="0"readonly>

                                    </div>

                                </div>

                                <div class="col-md-5"></div>
                                <div class="col-sm-2">

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

                                            <th data-priority="2">Kode Produk</th>

                                            <th data-priority="3" width="25%;">Produk</th>

                                            <th data-priority="4">Harga Satuan</th>

                                            <th data-priority="5">Qty</th>

                                            <th data-priority="6">Diskon</th>

                                            <th data-priority="7">Ongkir</th>

                                            <th data-priority="8">E.D</th>

                                            <th data-priority="9">Total</th>

                                            <th data-priority="10">Aksi</th>

                                        </tr>

                                    </thead>

                                    <tbody></tbody>

                                </table>

                                <template id="template_row_temp">

                                 <tr>

                                     <td>{row}</td>

                                     <td>{product_code}</td>

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

                                    <textarea id="purchase_order_remark" name="purchase_order_remark" class="form-control" placeholder="Catatan" maxlength="500" rows="3"></textarea>

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
                <button type="button" class="close close-modal">
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
                    <button id="btncancel" class="btn btn-danger close-modal"><i class="fas fa-times-circle"></i> Batal</button>
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
                <button type="button" class="close close-modal">
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
                    <button id="btncancel" class="btn btn-danger close-modal"><i class="fas fa-times-circle"></i> Batal</button>
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

        let temp_discount2 = new AutoNumeric('#temp_discount2', configRp);

        let temp_discount3 = new AutoNumeric('#temp_discount3', configRp);

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

        let footer_discount2 = new AutoNumeric('#footer_discount2', configRp);

        let footer_discount3 = new AutoNumeric('#footer_discount3', configRp);

        let footer_total_ppn = new AutoNumeric('#footer_total_ppn', configRp);

        let footer_total_invoice = new AutoNumeric('#footer_total_invoice', configRp);

        // init component //

        function _initButton() {
         $('#btnadd').prop('disabled', !hasRole('purchase_order.add'));
         $('.btnedit').prop('disabled', !hasRole('purchase_order.edit'));
         $('.btndelete').prop('disabled', !hasRole('purchase_order.delete'));
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
                 loadTempData(items);
                 if(items.length != 0){
                    let supplier_ids = items[0].temp_po_suplier_id;
                    let supplier_names = items[0].temp_po_suplier_name;
                    setSelect2('#supplier_id', supplier_ids, supplier_names);
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

        let purchase_order_discount1 = parseFloat(edit_footer_discount1.getNumericString());

        let purchase_order_discount2 = parseFloat(edit_footer_discount2.getNumericString());

        let purchase_order_discount3 = parseFloat(edit_footer_discount3.getNumericString());

        let purchase_order_total_discount = parseFloat(footer_total_discount.getNumericString());

        let purchase_order_total_ppn = parseFloat(footer_total_ppn.getNumericString());

        //let purchase_order_total = parseFloat(footer_total_invoice.getNumericString());

        let question = 'Yakin ingin menyimpan data PO?';

        let actUrl = base_url + '/webmin/purchase-order/save/add';

        if (formMode == 'edit') {

            question = 'Yakin ingin memperbarui data PO?';

            actUrl = base_url + '/webmin/purchase-order/save/edit';

        }

        message.question(question).then(function(answer) {

            let yes = parseMessageResult(answer);

            if (yes) {

                let formValues = {

                    purchase_order_date: $('#purchase_order_date').val(),

                    purchase_order_supplier_id: $('#supplier_id').val(),

                    purchase_order_store_id: $('#warehouse').val(),

                    purchase_order_remark: $('#purchase_order_remark').val(),

                    purchase_order_sub_total: $('#footer_total_discount').val(),

                    purchase_order_discount1: $('#edit_footer_discount1').val(),

                    purchase_order_discount2: $('#edit_footer_discount2').val(),

                    purchase_order_discount3: $('#edit_footer_discount3').val(),

                    purchase_order_total_discount: $('#footer_total_discount').val(),

                    purchase_order_total_ppn: $('#footer_total_ppn').val(),

                    purchase_order_total: $('#footer_total_invoice').val(),

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

                                let invUrl = base_url + '/webmin/purchase-order/invoice/' + invoice + '?print=Y';

                                window.open(invUrl, '_blank');

                            } else {

                                message.error(response.result.message);

                            }

                        }

                        btnSubmit.prop('disabled', false);

                        window.location.href = base_url + '/webmin/purchase-order/';

                    },

                    error: function(response) {

                        btnSubmit.prop('disabled', false);

                        updateTable();

                    }

                });

            }

        })

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

     let edit_temp_discount_percentage1 = parseFloat(edit_temp_discount_percentage1.getNumericString());

     let edit_temp_discount_percentage2 = parseFloat(edit_temp_discount_percentage2.getNumericString());

     let edit_temp_discount_percentage3 = parseFloat(edit_temp_discount_percentage3.getNumericString());

     let total_temp_discount = parseFloat(total_temp_discount.getNumericString());
     
     let total = parseFloat(temp_total.getNumericString());

     let supplier_id = $('#supplier_id').val();

     let supplier_name = $( "#supplier_id option:selected" ).text();


     let btnSubmit = $('#btnadd_temp');

     let form = $('#frmaddtemp');

     form.parsley().validate();

     if (form.parsley().isValid()) {

         let actUrl = base_url + '/webmin/purchase-order/temp-add';

         let formValues = {

             temp_po_id: $('#temp_po_id').val(),

             product_id: $('#product_id').val(),

             temp_price: price,

             temp_dpp: dpp,

             temp_tax: tax,

             temp_qty: qty,

             temp_ongkir: ongkir,

             temp_discount1: discount1,

             edit_temp_discount_percentage1: edit_temp_discount_percentage1,

             temp_discount2: discount2,

             edit_temp_discount_percentage2: edit_temp_discount_percentage2,

             temp_discount3: discount3,

             edit_temp_discount_percentage3: edit_temp_discount_percentage3,

             temp_po_suplier_id:supplier_id,

             total_temp_discount:total_temp_discount,

             temp_po_suplier_name:supplier_name,

             temp_ed_date: $('#temp_ed_date').val(),

             temp_total: total,

         };

         btnSubmit.prop('disabled', true);

         ajax_post(actUrl, formValues, {

             success: function(response) {

                 if (response.success) {

                     if (response.result.success) {

                         clearItemInput();

                         $('#product_name').focus();

                         setSelect2('#supplier_id', supplier_id, supplier_name);

                         $('#supplier_id').attr("disabled", true);

                         notification.success(response.result.message);

                     } else {

                         message.error(response.result.message);

                     }

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

                    loadTempData(response.result.data);

                }

            },

            error: function(response) {

                getTemp();

            }

        })

    })



    $("#tbltemp").on('click', '.btnedit', function(e) {

       e.preventDefault();

       let json_data = $(this).attr('data-json');

       let [json, is_json, error] = parseJSON(htmlEntities.decode(json_data));

       console.log(json);

       if (is_json) {

           $('#product_id').val(json.temp_po_product_id);

           $('#product_name').val(json.product_name);

           temp_price.set(json.temp_po_price);

           temp_qty.set(json.temp_po_qty);

           temp_ongkir.set(json.temp_po_ongkir);

           edit_temp_discount1.set(json.temp_po_discount1);
           
           edit_temp_discount_percentage1.set((json.temp_po_discount1 / json.temp_po_price *  10).toFixed(2));

           edit_temp_discount2.set(json.temp_po_discount2);
 
           edit_temp_discount_percentage2.set((json.temp_po_discount2 / (json.temp_po_price - json.temp_po_discount1)*  10).toFixed(2));

           edit_temp_discount3.set(json.temp_po_discount3);

           edit_temp_discount_percentage3.set((json.temp_po_discount3 / (json.temp_po_price - json.temp_po_discount1 - json.temp_po_discount2)*  10).toFixed(2));

           total_temp_discount.set(json.temp_po_discount3);

           $('#temp_ed_date').val(json.temp_po_expire_date);

           $('#temp_po_id').val(json.temp_po_id );

           $('#product_tax').val(json.temp_po_ppn);

           temp_total.set(json.temp_po_total);

           temp_dpp.set(json.temp_po_dpp);

           temp_tax.set(json.temp_po_ppn);

           $('#temp_qty').focus();

       } else {

           getTemp();

           message.error('Terjadi kesalahan dalam memproses data, harap coba lagi');

       }

   })  


    function loadTempData(items) {

       let template = $('#template_row_temp').html();

       let tbody = '';

       let row = 1;

       let temp_total_order = 0;

       items.forEach((val, key) => {

           let item = template;

           let data_json = htmlEntities.encode(JSON.stringify(val));

           let temp_po_id  = val.temp_po_id;

           let temp_po_product_id = val.temp_po_product_id;

           let product_code = val.product_code;

           let product_name  = val.product_name;

           let temp_po_price  = val.base_purchase_price;

           let temp_po_qty = parseFloat(val.temp_po_qty);

           let temp_po_total_disc = val.temp_total_discount;

           let temp_po_ongkir = val.temp_po_ongkir;

           let temp_po_expire_date = val.temp_po_expire_date;

           let temp_po_total = val.temp_po_total;


           item = item.replaceAll('{row}', row)

           .replaceAll('{product_code}', val.product_code)

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



// select2 //
$("#warehouse").select2({

    data: [
    {
        id:'1',
        text: 'UTM-PUSAT'
    },
    {
        id:'3',
        text: 'KBR-KOTA BARU'
    },
    {
        id:'2',
        text: 'KNY-KONSINYASI'
    }

    ]

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

       $('#product_id').val(ui.item.product_id);

       temp_price.set(parseFloat(ui.item.base_purchase_price));

       //temp_tax.set(0);

       //temp_qty.set(1);

   },

});



calculation_temp_total_footer();

$('#total_temp_discount').click(function(e) {
    e.preventDefault();
    discountMode({
        temp_discount1: $('#temp_discount1').val(),
        temp_discount2: $('#temp_discount2').val(),
        temp_discount3: $('#temp_discount3').val(),
    });
})

function discountMode(data) {
    let form = $('#frmtempdiscount');
    $('#title-frmtempdiscount').html('Tambah Discount');
    $('#edit_temp_discount1').val(data.temp_discount1);
    $('#edit_temp_discount2').val(data.temp_discount2);
    $('#edit_temp_discount3').val(data.temp_discount3);
    $('#modal-tempdiscount').modal(configModal);
}

$('#btnaddfooterdiscount').click(function(e) {
    e.preventDefault();
    discountFooterMode({
        footer_discount1: $('#footer_discount1').val(),
        footer_discount2: $('#footer_discount2').val(),
        footer_discount3: $('#footer_discount3').val(),
    });
})

function discountFooterMode(data) {
    let form = $('#frmfooterdiscount');
    $('#title-frmfooterdiscount').html('Tambah Discount Nota');
    $('#edit_footer_discount1').val(data.footer_discount1);
    $('#edit_footer_discount2').val(data.footer_discount2);
    $('#edit_footer_discount3').val(data.footer_discount3);
    $('#modal-footerdiscount').modal(configModal);
}


$('.close-modal').click(function(e) {
    e.preventDefault();
    message.question('Yakin ingin menutup halaman ini?').then(function(answer) {
        let yes = parseMessageResult(answer);
        if (yes) {
            $('#modal-tempdiscount').modal('hide');
            $('#modal-footerdiscount').modal('hide');
        }
    })
})

$('#temp_qty').on('change', function() {
    calculation_temp_total();
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
    let edit_temp_discount2_cal = (total_price.get() - edit_temp_discount1.get()) * (edit_temp_discount_percentage2.get()/100);
    edit_temp_discount2.set(edit_temp_discount2_cal.toFixed(2));
});

$('#edit_temp_discount2').on('change', function() {
    let edit_temp_discount2_cal = edit_temp_discount2.get() / (total_price.get() - edit_temp_discount1.get()) *  100;
    edit_temp_discount_percentage2.set(edit_temp_discount2_cal.toFixed(2));
});

$('#edit_temp_discount_percentage3').on('change', function() {
    let edit_temp_discount3_cal = (total_price.get() - edit_temp_discount2.get() - edit_temp_discount2.get()) * (edit_temp_discount_percentage3.get()/100);
    edit_temp_discount3.set(edit_temp_discount3_cal.toFixed(2));
});

$('#edit_temp_discount3').on('change', function() {
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
    let edit_footer_discount2_cal = (footer_sub_total.get() - edit_footer_discount1.get()) * (edit_footer_discount_percentage2.get()/100);
    edit_footer_discount2.set(edit_footer_discount2_cal.toFixed(2));
});

$('#edit_footer_discount2').on('change', function() {
    let edit_footer_discount2_cal = edit_footer_discount2.get() / (footer_sub_total.get() - edit_footer_discount1.get()) *  100;
    edit_footer_discount_percentage2.set(edit_footer_discount2_cal.toFixed(2));
});

$('#edit_footer_discount_percentage3').on('change', function() {
    let edit_footer_discount3_cal = (footer_sub_total.get() - edit_footer_discount2.get() - edit_footer_discount2.get()) * (edit_footer_discount_percentage3.get()/100);
    edit_footer_discount3.set(edit_footer_discount3_cal.toFixed(2));
});

$('#edit_footer_discount3').on('change', function() {
    let edit_footer_discount3_cal = edit_footer_discount3.get() / (footer_sub_total.get() - edit_footer_discount1.get() - edit_footer_discount2.get()) *  100;
    edit_footer_discount_percentage3.set(edit_footer_discount3_cal.toFixed(2));
});

$('#temp_ongkir').on('change', function() {
    calculation_temp_total()
});

function calculation_temp_total(){
    var price_calculation = AutoNumeric.getAutoNumericElement('#temp_price').get();
    let ppn = price_calculation - (price_calculation * 11/100);
    let dpp = price_calculation - ppn;
    let qty_calculation = parseFloat(temp_qty.getNumericString());
    let subtotal_calculation = price_calculation * qty_calculation;
    total_price.set(subtotal_calculation);
    temp_dpp.set(parseFloat(dpp.toFixed(2)));
    temp_tax.set(parseFloat(ppn.toFixed(2)));
    temp_total.set(total_price.get() - total_temp_discount.get());
}

function calculation_temp_total_footer(){
    footer_dpp.set(Number(footer_sub_total.get()) - Number(footer_total_discount.get()));
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

            footer_total_discount.set(Number(edit_footer_discount1) + Number(edit_footer_discount2) + Number(edit_footer_discount3));
            calculation_temp_total_footer();
        }
    })
})


function clearItemInput() {

   let form = $('#frmaddtemp');

   form.parsley().reset();

   $('#product_id').val('');

   $('#product_name').val('');

   $('#temp_ed_date').val('');

   temp_qty.set('0.00');

   temp_ongkir.set(0);

   temp_price.set(0);

   temp_total.set(0);

   edit_temp_discount_percentage1.set('0.00%');

   edit_temp_discount_percentage2.set('0.00%');

   edit_temp_discount_percentage3.set('0.00%');

   edit_temp_discount1.set(0);

   edit_temp_discount2.set(0);

   edit_temp_discount3.set(0);

   total_temp_discount.set(0);

   $('#temp_desc').val('');

}

function setfootervalue(){
    let actUrl = base_url + '/webmin/purchase-order/get-po-footer';
    ajax_get(actUrl, null, {
        success: function(response) {   
            if (response.result.success == 'TRUE') {
                if(response.result.data.length > 0){
                    //console.log(response.result.data[]);
                    footer_sub_total.set(response.result.data[0].subTotal);
                    footer_total_ppn.set(response.result.data[0].totalPpn);
                    footer_total_ongkir.set(response.result.data[0].totalOngkir);
                    calculation_temp_total_footer();
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