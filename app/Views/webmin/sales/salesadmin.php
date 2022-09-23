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

                            <table id="tblpurchaseorders" class="table table-bordered table-hover" width="100%">

                                <thead>

                                    <tr>

                                        <th data-priority="1">#</th>

                                        <th data-priority="2">No Invoice</th>

                                        <th data-priority="3">Tanggal</th>

                                        <th data-priority="4">Customer</th>

                                        <th data-priority="5">Total Harga</th>

                                        <th data-priority="6">Status Pembayaran</th>

                                        <th data-priority="7">Aksi</th>

                                    </tr>

                                </thead>

                                <tbody>
                                    <tr>

                                        <td data-priority="1">1</td>

                                        <td data-priority="2">SI/UTM/22/08/00003</td>

                                        <td data-priority="3">02/09/2022</td>

                                        <td data-priority="4">Dedi</td>

                                        <td data-priority="5">65.000,000.00</td>

                                        <td data-priority="6"><span class="badge badge-success">Lunas</span></td>

                                        <td data-priority="7">
                                            <a href="<?php base_url() ?>submission/submissiondetaildemo">
                                                <button class="btn btn-sm btn-default btndetail mb-2" data-toggle="tooltip" data-placement="top" data-title="Detail" data-original-title="" title=""><i class="fas fa-eye"></i></button>
                                            </a>
                                            <a href="<?php base_url() ?>sales-admin/printinvoice">
                                            <button id="print_invoice" data-id="1" data-invoice="0000000001" class="btn btn-sm btn-default btndetail mb-2" data-toggle="tooltip" data-placement="top" data-title="Print" data-original-title="" title=""><i class="fas fa-print"></i></button>
                                            </a>
                                        </td>

                                    </tr>

                                    <tr>

                                        <td data-priority="1">1</td>

                                        <td data-priority="2">SI/UTM/22/08/00003</td>

                                        <td data-priority="3">02/09/2022</td>

                                        <td data-priority="4">Dedi</td>

                                        <td data-priority="5">65.000,000.00</td>

                                        <td data-priority="6"><span class="badge badge-danger">Hutang</span></td>

                                        <td data-priority="7">
                                            <a href="<?php base_url() ?>submission/submissiondetaildemo">
                                                <button class="btn btn-sm btn-default btndetail mb-2" data-toggle="tooltip" data-placement="top" data-title="Detail" data-original-title="" title=""><i class="fas fa-eye"></i></button>
                                            </a>
                                            <a href="<?php base_url() ?>sales-admin/printinvoice">
                                                <button id="print_invoice" data-id="1" data-invoice="0000000001" class="btn btn-sm btn-default btndetail mb-2" data-toggle="tooltip" data-placement="top" data-title="Print" data-original-title="" title=""><i class="fas fa-print"></i></button>
                                            </a>
                                        </td>

                                    </tr>
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

                            <form id="frmsalesadmin" class="form-horizontal form-header-input">

                                <div class="form-group row">

                                    <label for="noinvoice" class="col-sm-1 col-form-label">No Invoice</label>

                                    <div class="col-sm-3">

                                        <input id="purchase_order_invoice" name="purchase_order_invoice" type="text" class="form-control" value="AUTO" readonly>

                                    </div>

                                    <div class="col-md-1">

                                    </div>  

                                    <label for="tanggal" class="col-sm-1 col-form-label">No Faktur</label>

                                    <div class="col-sm-3">

                                        <input id="no_invoice_suplier" name="purchase_order_invoice" type="text" class="form-control">

                                    </div>

                                    <label for="tanggal" class="col-sm-1 col-form-label">Tanggal</label>

                                    <div class="col-sm-2">

                                        <input id="purchase_order_date" name="purchase_order_date" type="date" class="form-control" value="<?= date('Y-m-d') ?>" readonly>

                                    </div>
                                </div>

                                <div class="form-group row">

                                    <label for="customer_id" class="col-sm-1 col-form-label">Customer</label>

                                    <div class="col-sm-3">

                                        <select id="customer_id" name="customer_id" class="form-control"></select>

                                    </div>

                                    <div class="col-sm-1">

                                        <button id="btnadd" class="btn btn-primary"><i class="fas fa-plus"></i></button>

                                    </div>

                                    

                                    <label for="tanggal" class="col-sm-1 col-form-label">Tgl Faktur</label>

                                    <div class="col-sm-3">

                                        <input id="invoice_date" name="invoice_date" type="date" class="form-control">

                                    </div>

                                    <label for="cabang" class="col-sm-1 col-form-label">Cabang</label>

                                    <div class="col-sm-2">

                                        <input id="cabang" type="text" class="form-control" value="Kota Baru" readonly>

                                    </div>
                                </div>


                                <div class="form-group row">

                                    <label for="suplier" class="col-sm-1 col-form-label">Pembayaran</label>

                                    <div class="col-sm-3">

                                        <select id="payment_type" name="payment_type" class="form-control"></select>

                                    </div>

                                   <div class="col-md-1">

                                    </div>  

                                    <label for="Sales" class="col-sm-1 col-form-label">Sales</label>

                                    <div class="col-md-3">

                                        <select id="sales_id" name="sales_id" class="form-control"></select>

                                    </div>

                                    <label for="user" class="col-sm-1 col-form-label">User</label>

                                    <div class="col-sm-2">

                                        <input id="display_user" type="text" class="form-control" value="<?= $user['user_realname'] ?>" readonly>

                                    </div>


                                </div>


                                <div class="form-group row">


                                    <label for="suplier" class="col-sm-1 col-form-label">Tempo</label>

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

                                    <input id="item_id" name="item_id" type="hidden" value="">

                                    <input id="product_tax" name="product_tax" type="hidden" value="">


                                    <div class="col-sm-3">

                                        <!-- text input -->

                                        <div class="form-group">

                                            <label>Produk</label>

                                            <select id="product_name" name="product_name" type="text" class="form-control" placeholder="ketikkan nama produk" required> </select>

                                        </div>

                                    </div>

                                    <div class="col-sm-2">

                                        <!-- text input -->

                                        <div class="form-group">

                                            <label>Harga Jual Per Unit</label>

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
                                            <input id="total_temp_discount" name="total_temp_discount" type="text" class="form-control text-right" value="0" readonly>

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

                                                <th data-priority="7">Aksi</th>

                                            </tr>

                                        </thead>

                                        <tbody>
                                           <tr>

                                            <td>1</td>

                                            <td>00002050</td>

                                            <td>NIPPON PAINT CAT BASE NIPPON SATIN GLO - PASTEL BASE 2.35L </td>

                                            <td>10</td>

                                            <td>Rp. 50,000</td>

                                            <td>Rp. 45,000</td>

                                            <td>Rp. 465,000</td>

                                            <td>

                                                <button data-id="{item_id}" data-json="{data_json}" class="btn btn-sm btn-warning btnedit rounded-circle" data-toggle="tooltip" data-placement="top" data-title="Edit">

                                                    <i class="fas fa-edit"></i>

                                                </button>

                                                &nbsp;

                                                <button data-id="{item_id}" class="btn btn-sm btn-danger btndelete rounded-circle" data-toggle="tooltip" data-placement="top" data-title="Hapus">

                                                    <i class="fas fa-minus"></i>

                                                </button>

                                            </td>

                                        </tr>

                                    </tbody>

                                </table>


                            </div>

                        </div>



                        <div class="row footer-purchaseorder">

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
                                    <label for="footer_total_invoice" class="col-sm-7 col-form-label text-right:">Total :</label>
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

       //End popup Temp discount //

       let temp_discount1 = new AutoNumeric('#temp_discount1', configRp);

       let temp_discount2 = new AutoNumeric('#temp_discount2', configRp);

       let temp_discount3 = new AutoNumeric('#temp_discount3', configRp);

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

       let footer_discount2 = new AutoNumeric('#footer_discount2', configRp);

       let footer_discount3 = new AutoNumeric('#footer_discount3', configRp);

       let footer_total_invoice = new AutoNumeric('#footer_total_invoice', configRp);



       footer_sub_total.set(15500000);

       calculation_temp_total_footer();


        // init component //

        function _initButton() {


        }



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


        $("#customer_id").select2({

            data: [
            {
                id:'1',
                text: 'PT JAYA ABADI'
            },
            {
                id:'2',
                text: 'Samsul'
            }

            ]

        });

        $("#payment_type").select2({

            data: [
            {
                id:'1',
                text: 'Cash'
            },
            {
                id:'2',
                text: 'BCA - 1234567890'
            },
            {
                id:'3',
                text: 'Mandiri - 2323143556'
            }

            ]

        });

        $("#sales_id").select2({

            data: [
            {
                id:'1',
                text: 'Hendi'
            },
            {
                id:'2',
                text: 'Rendi'
            },
            {
                id:'3',
                text: 'Brama'
            }

            ]

        });


        $("#product_name").select2({

            data: [
            {
                id:'00002050',
                text: 'NIPPON PAINT CAT BASE NIPPON SATIN GLO - PASTEL BASE 2.35L / 00002050'
            },
            {
                id:'00009200',
                text: 'ARISTON WATER HEATER ANDRIS AN2 15 LUX 350 ID / 00009200'
            },
            {
                id:'00011521',
                text: 'KERAMIK LANTAI ACCURA (SERI WASHINGTON BROWN 40X40) KW I / 00011521',
            },
            {
                id:'00005001',
                text: 'IKAD KERAMIK DINDING DX 2277A FR 25X40 - I / 00005001',
            }
            
            ]

        });
        // Table //



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

        function footer_calculation() {
            // body...
        }

        $('#total_temp_discount').click(function(e) {
            e.preventDefault();
            discountMode({
                temp_discount1: $('#temp_discount1').val(),
                temp_discount2: $('#temp_discount2').val(),
                temp_discount3: $('#temp_discount3').val(),
            });
        })

        $('#print_invoice').click(function(e) {
            e.preventDefault();

            let id = 12;
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
                    let invUrl = base_url + '/webmin/sales-admin/printinvoice';
                    window.open(invUrl, '_blank');
                } else {
                    let invUrl = base_url + '/webmin/sales-admin/printdispatch';
                    window.open(invUrl, '_blank');
                }
            })
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
            let edit_footer_discount1_cal = footer_total_invoice.get() * (edit_footer_discount_percentage1.get()/100);
            edit_footer_discount1.set(edit_footer_discount1_cal.toFixed(2));
        });

        $('#edit_footer_discount1').on('change', function() {
            let edit_footer_discount1_cal = edit_footer_discount1.get() / footer_total_invoice.get() *  100;
            edit_footer_discount_percentage1.set(edit_footer_discount1_cal);
        });

        $('#edit_footer_discount_percentage2').on('change', function() {
            let edit_footer_discount2_cal = (footer_total_invoice.get() - edit_footer_discount1.get()) * (edit_footer_discount_percentage2.get()/100);
            edit_footer_discount2.set(edit_footer_discount2_cal.toFixed(2));
        });

        $('#edit_footer_discount2').on('change', function() {
            let edit_footer_discount2_cal = edit_footer_discount2.get() / (footer_total_invoice.get() - edit_footer_discount1.get()) *  100;
            edit_footer_discount_percentage2.set(edit_footer_discount2_cal.toFixed(2));
        });

        $('#edit_footer_discount_percentage3').on('change', function() {
            let edit_footer_discount3_cal = (footer_total_invoice.get() - edit_footer_discount2.get() - edit_footer_discount2.get()) * (edit_footer_discount_percentage3.get()/100);
            edit_footer_discount3.set(edit_footer_discount3_cal.toFixed(2));
        });

        $('#edit_footer_discount3').on('change', function() {
            let edit_footer_discount3_cal = edit_footer_discount3.get() / (footer_total_invoice.get() - edit_footer_discount1.get() - edit_footer_discount2.get()) *  100;
            edit_footer_discount_percentage3.set(edit_footer_discount3_cal.toFixed(2));
        });



        $('#temp_ongkir').on('change', function() {
            calculation_temp_total()
        });
        

        $('#product_name').on('change', function() {
           var id = document.getElementById("product_name").value;
           if(id == '00002050'){
            document.getElementById("temp_price").value = '40000';
        }
        
        if(id == '00009200'){
            document.getElementById("temp_price").value = '50000';
        }
        
        if(id == '00011521'){
            document.getElementById("temp_price").value = '59000';
        }
        
        if(id == '00005001'){
            document.getElementById("temp_price").value = '100000';
        }
        
        let temp_price = new AutoNumeric('#temp_price', configRp);
        calculation_temp_total();
    });


        function calculation_temp_total(){
            var price_calculation = AutoNumeric.getAutoNumericElement('#temp_price').get();
            let qty_calculation = parseFloat(temp_qty.getNumericString());
            let subtotal_calculation = price_calculation * qty_calculation;
            total_price.set(subtotal_calculation);
            temp_total.set(total_price.get() - total_temp_discount.get());
        }

        function calculation_temp_total_footer(){
            footer_total_invoice.set(Number(footer_sub_total.get()) - Number(footer_total_discount.get()));
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

        $('#btnadd').click(function(e) {

            e.preventDefault();

            let form = $('#frmsalesadmin');
                            //let items = response.result.data;
                            $('#title-frmsalesadmin').html('Penjualan Admin');

                            formMode = 'add';

                            showInputPage(true);

                        })



        _initButton();

        showInputPage(false);

    })

</script>

<?= $this->endSection() ?>