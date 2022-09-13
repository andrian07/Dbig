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

                                <tbody>
                                    <tr>

                                        <td data-priority="1">1</td>

                                        <td data-priority="1">PO-KBR-0001</td>

                                        <td data-priority="2">02/09/2022</td>

                                        <td data-priority="4">BKP</td>

                                        <td data-priority="6">PT NIPPON INDONESIA</td>

                                        <td data-priority="6">500.000</td>

                                        <td data-priority="6"><span class="badge badge-success">Diterima</span></td>

                                        <td data-priority="3">
                                            <a href="<?php base_url() ?>submission/submissiondetaildemo">
                                                <button class="btn btn-sm btn-default btndetail mb-2" data-toggle="tooltip" data-placement="top" data-title="Detail" data-original-title="" title=""><i class="fas fa-eye"></i></button>
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


                          <form id="frmpurchaseorder" class="form-horizontal">

                            <div class="form-group row">

                                <label for="noinvoice" class="col-sm-1 col-form-label">No Invoice</label>

                                <div class="col-sm-3">

                                    <input id="purchase_order_invoice" name="purchase_order_invoice" type="text" class="form-control" value="AUTO" readonly>

                                </div>

                                <div class="col-md-4"></div>

                                <label for="tanggal" class="col-sm-1 col-form-label">Tanggal</label>

                                <div class="col-sm-3">

                                    <input id="purchase_order_date" name="purchase_order_date" type="date" class="form-control" value="<?= date('Y-m-d') ?>" readonly>

                                </div>
                            </div>


                            <div class="form-group row">

                                <label for="suplier" class="col-sm-1 col-form-label">Supplier</label>

                                <div class="col-sm-3">

                                    <select id="supplier_id" name="supplier_id" class="form-control"></select>

                                </div>

                                <div class="col-sm-1">

                                    <button id="btnadd" class="btn btn-primary"><i class="fas fa-plus"></i></button>

                                </div>

                                <div class="col-md-3"></div>

                                <label for="user" class="col-sm-1 col-form-label">Gudang</label>

                                <div class="col-sm-3">

                                    <select id="warehouse" type="text" class="form-control"></select>

                                </div>

                            </div>


                            <div class="form-group row">

                                <div class="col-md-8"></div>

                                <label for="user" class="col-sm-1 col-form-label">User</label>

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

                                <input id="item_id" name="item_id" type="hidden" value="">

                                <input id="product_tax" name="product_tax" type="hidden" value="">


                                <div class="col-sm-3">

                                    <!-- text input -->

                                    <div class="form-group">

                                        <label>Produk</label>

                                        <select id="product_name" name="product_name" type="text" class="form-control" placeholder="ketikkan nama produk" onchange="setprice()" required> </select>

                                    </div>

                                </div>

                                <div class="col-sm-2">

                                    <!-- text input -->

                                    <div class="form-group">

                                        <label>Harga Beli</label>

                                        <input id="temp_price" name="temp_price" type="text" class="form-control text-right" value="0" data-parsley-vprice required>

                                    </div>

                                </div>

                                <div class="col-sm-2">

                                    <!-- text input -->

                                    <div class="form-group">

                                        <label>Qty</label>

                                        <input id="temp_qty" name="temp_qty" type="text" class="form-control text-right" value="0" data-parsley-vqty required>

                                    </div>

                                </div>

                                <div class="col-sm-2">

                                    <!-- text input -->

                                    <div class="form-group">

                                        <label>DPP</label>

                                        <input id="temp_dpp" name="temp_dpp" type="text" class="form-control text-right" value="0" readonly required>

                                    </div>

                                </div>

                                <div class="col-sm-2">

                                    <!-- text input -->

                                    <div class="form-group">

                                        <label>PPN <?= PPN_TEXT ?></label>

                                        <input id="temp_tax" name="temp_tax" type="text" class="form-control text-right" value="0" readonly required>

                                    </div>

                                </div>

                                <div class="col-md-3"></div>

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
                                        <input id="total_temp_discount" name="total_temp_discount" type="text" class="form-control text-right" value="0" readonly>

                                    </div>

                                </div>

                                <div class="col-sm-4">

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
                                            <button id="getlist" class="btn btn-md btn-warning rounded-circle float-right"><i class="far fa-list-alt"></i></button>


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

                                            <th data-priority="6">DPP</th>

                                            <th data-priority="7">PPN</th>

                                            <th data-priority="8">Total</th>

                                            <th data-priority="9">Aksi</th>

                                        </tr>

                                    </thead>

                                    <tbody>
                                       <tr>

                                        <td>1</td>

                                        <td>00002050</td>

                                        <td>NIPPON PAINT CAT BASE NIPPON SATIN GLO - PASTEL BASE 2.35L </td>

                                        <td>10</td>

                                        <td>Rp. 50,000</td>

                                        <td>Rp. 450,450</td>

                                        <td>Rp. 49,550</td>

                                        <td>Rp. 500,000</td>

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


                                    <tr>

                                        <td>2</td>

                                        <td>00011521</td>

                                        <td>IKAD KERAMIK DINDING DX 2277A FR 25X40 - I</td>

                                        <td>148</td>

                                        <td>Rp. 100,000</td>

                                        <td>Rp. 13,513,514</td>

                                        <td>Rp. 1,486,486</td>

                                        <td>Rp.  15,000,000</td>

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



                    <div class="row">

                        <div class="col-lg-6">

                            <div class="form-group">

                                <div class="col-sm-12">

                                    <textarea id="purchase_order_remark" name="purchase_order_remark" class="form-control" placeholder="Catatan" maxlength="500" rows="3"></textarea>

                                </div>

                            </div>

                        </div>

                        <div class="col-lg-6 text-right">

                            <div class="form-group row">
                                <label for="ongkir" class="col-sm-7 col-form-label text-right:">PPN <?= PPN_TEXT ?> :</label>
                                <div class="col-sm-5">
                                    <input id="display_total_ppn" name="display_total_ppn" type="text" class="form-control text-right" value="0" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="total" class="col-sm-7 col-form-label text-right:">Total :</label>
                                <div class="col-sm-5">
                                    <input type="hidden" id="purchase_order_total" name="purchase_order_total">
                                    <input id="display_total" name="display_total" type="text" class="form-control text-right" value="0" readonly>
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

<div class="modal fade" id="modal-category">
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


</section>

</div>



<!-- /.content -->

<?= $this->endSection() ?>



<?= $this->section('js') ?>

<script>

 function setprice() {
    var id = document.getElementById("product_name").value;
    if(id == '00002050'){
        document.getElementById("temp_price").value = '50000';
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
}



$(document).ready(function() {

 let temp_price = new AutoNumeric('#temp_price', configRp);

 let temp_tax = new AutoNumeric('#temp_tax', configRp);

 let temp_dpp = new AutoNumeric('#temp_dpp', configRp); 

 let temp_qty = new AutoNumeric('#temp_qty', configQty);

 let temp_ongkir = new AutoNumeric('#temp_ongkir', configRp);

 let total_temp_discount = new AutoNumeric('#total_temp_discount', configRp);

 let edit_temp_discount1 = new AutoNumeric('#edit_temp_discount1', configRp);

 let edit_temp_discount_percentage1 = new AutoNumeric('#edit_temp_discount_percentage1', configMargin);

 let edit_temp_discount2 = new AutoNumeric('#edit_temp_discount2', configRp);

 let edit_temp_discount_percentage2 = new AutoNumeric('#edit_temp_discount_percentage2', configMargin);

 let edit_temp_discount3 = new AutoNumeric('#edit_temp_discount3', configRp);

 let edit_temp_discount_percentage3 = new AutoNumeric('#edit_temp_discount_percentage3', configMargin);

 let temp_discount1 = new AutoNumeric('#temp_discount1', configRp);

 let temp_discount2 = new AutoNumeric('#temp_discount2', configRp);

 let temp_discount3 = new AutoNumeric('#temp_discount3', configRp);

 let temp_total = new AutoNumeric('#temp_total', configRp);


 let display_total_ppn = new AutoNumeric('#display_total_ppn', configRp);

 let display_total = new AutoNumeric('#display_total', configRp);


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


        $("#supplier_id").select2({

            data: [
            {
                id:'1',
                text: 'PT IKAD INDONESIA'
            },
            {
                id:'2',
                text: 'PT NIPPON INDONESIA'
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
                id:'000092009',
                text: 'KERAMIK LANTAI ACCURA (SERI WASHINGTON BROWN 40X40) KW I / 000092009',
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

                $('#po_list').hide();

                $('#po_input').show();

         

            } else {

                $('#po_list').show();

                $('#po_input').hide();

            }

        }

        function discountMode(data) {
            let form = $('#frmtempdiscount');
            $('#title-frmtempdiscount').html('Tambah Discount');
            formMode = 'edit';
            $('#edit_temp_discount1').val(data.temp_discount1);
            $('#edit_temp_discount2').val(data.temp_discount2);
            $('#edit_temp_discount3').val(data.temp_discount3);
            $('#modal-category').modal(configModal);
        }

        $('#total_temp_discount').click(function(e) {
            e.preventDefault();
            discountMode({
                temp_discount1: $('#temp_discount1').val(),
                temp_discount2: $('#temp_discount2').val(),
                temp_discount3: $('#temp_discount3').val(),
            });
        })

        $('.close-modal').click(function(e) {
            e.preventDefault();
            message.question('Yakin ingin menutup halaman ini?').then(function(answer) {
                let yes = parseMessageResult(answer);
                if (yes) {
                    $('#modal-category').modal('hide');
                }
            })
        })

        document.getElementById('temp_qty').addEventListener('change', function() {
            var price_calculation = AutoNumeric.getAutoNumericElement('#temp_price').get();
            let qty_calculation = parseFloat(temp_qty.getNumericString());
            let subtotal_calculation = price_calculation * qty_calculation;
            let ppn = subtotal_calculation - (subtotal_calculation / 1.11);
            let dpp = subtotal_calculation - ppn;
            $('#temp_tax').val(parseFloat(ppn.toFixed(2)));
            $('#temp_dpp').val(parseFloat(dpp.toFixed(2)));
            let temp_tax = new AutoNumeric('#temp_tax', configRp);
            let temp_dpp = new AutoNumeric('#temp_dpp', configRp);
            calculation_temp_total();
        });

        document.getElementById('edit_temp_discount_percentage1').addEventListener('change', function() {
            var price_calculation = AutoNumeric.getAutoNumericElement('#temp_price').get();
            let qty_calculation = parseFloat(temp_qty.getNumericString());
            let edit_temp_discount_percentage1 = AutoNumeric.getAutoNumericElement('#edit_temp_discount_percentage1').get();
            let edit_temp_discount1 = (price_calculation * qty_calculation) * (edit_temp_discount_percentage1/100);
            $('#edit_temp_discount1').val(parseFloat(edit_temp_discount1.toFixed(2)));
            let edit_temp_discount1s = new AutoNumeric('#edit_temp_discount1', configRp);
            let edit_temp_discount2s = new AutoNumeric('#edit_temp_discount2', configRp);
            let edit_temp_discount3s = new AutoNumeric('#edit_temp_discount3', configRp);
        });

        function calculation_temp_total(){
            var price_calculation = AutoNumeric.getAutoNumericElement('#temp_price').get();
            let qty_calculation = parseFloat(temp_qty.getNumericString());
            let subtotal_calculation = price_calculation * qty_calculation; 
            $('#temp_total').val(subtotal_calculation);
            let temp_total = new AutoNumeric('#temp_total', configRp);
        }

        $('#btndisc').click(function(e) {
            e.preventDefault();
            message.question('Yakin untuk penambahan discount?').then(function(answer) {
                let yes = parseMessageResult(answer);
                if (yes) {
                    $('#modal-category').modal('hide');

                    let edit_temp_discount1 =  $('#edit_temp_discount1').val();
                    $('#temp_discount1').val(edit_temp_discount1);

                    let edit_temp_discount2 =  $('#edit_temp_discount2').val();
                    $('#temp_discount2').val(edit_temp_discount2);

                    let edit_temp_discount3 =  $('#edit_temp_discount3').val();
                    $('#temp_discount3').val(edit_temp_discount3);

                    let temp_discount1 = new AutoNumeric('#temp_discount1', configRp);

                    let temp_discount2 = new AutoNumeric('#temp_discount2', configRp);

                    let temp_discount3 = new AutoNumeric('#temp_discount3', configRp);
                }
            })
        })

        $('#btnadd').click(function(e) {

            e.preventDefault();

            let form = $('#frmpurchaseorder');
                            //let items = response.result.data;
                            $('#title-frmpurchaseorder').html('Pengajuan Pesanan');

                            formMode = 'add';

                            showInputPage(true);

                        })



        _initButton();

        showInputPage(false);

    })

</script>

<?= $this->endSection() ?>