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

                            <table id="tblpurchaseorders" class="table table-bordered table-hover" width="100%">

                                <thead>

                                    <tr>

                                        <th data-priority="1">#</th>

                                        <th data-priority="2">No Invoice</th>

                                        <th data-priority="2">Tanggal Pembelian</th>

                                        <th data-priority="4">Golongan</th>

                                        <th data-priority="6">Nama Supplier</th>

                                        <th data-priority="6">No Faktur Suplier</th>

                                        <th data-priority="3">Total Ongkir</th>

                                        <th data-priority="3">Total Harga</th>

                                        <th data-priority="3">Status Barang</th>

                                        <th data-priority="3">Aksi</th>

                                    </tr>

                                </thead>

                                <tbody>
                                    <tr>

                                        <td data-priority="1">1</td>

                                        <td data-priority="2">P-KBR-001</td>

                                        <td data-priority="2">02/09/2022</td>

                                        <td data-priority="4">BKP</td>

                                        <td data-priority="6">PT NIPPON INDONESIA</td>

                                        <td data-priority="6">SJ-20220821168</td>

                                        <td data-priority="6">Rp. 20,000</td>

                                        <td data-priority="6">Rp. 500,000</td>

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


                          <form id="frmpurchase" class="form-horizontal">

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

                                <label for="noinvoice" class="col-sm-1 col-form-label">No Po</label>

                                <div class="col-sm-3">

                                    <select id="no_po_purchase" name="no_po_purchase" class="form-control"></select>

                                </div>

                                <div class="col-md-1"></div>

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

                                <label for="suplier" class="col-sm-1 col-form-label">Supplier</label>

                                <div class="col-sm-3">

                                    <select id="supplier_id" name="supplier_id" class="form-control"></select>

                                </div>


                                <div class="col-sm-1">

                                    <button id="btnadd" class="btn btn-primary"><i class="fas fa-plus"></i></button>

                                </div>


                                <div class="col-md-4"></div>


                                
                                <label for="user" class="col-sm-1 col-form-label">User</label>

                                <div class="col-sm-2">

                                    <input id="display_user" type="text" class="form-control" value="<?= $user['user_realname'] ?>" readonly>

                                </div>


                            </div>


                            <div class="form-group row">

                                <label for="suplier" class="col-sm-1 col-form-label">Pembayaran</label>

                                <div class="col-sm-3">

                                    <select id="payment_type" name="payment_type" class="form-control" onchange="setpayment_type()"></select>

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

                                <div class="col-sm-11">

                                    <!-- text input -->

                                    <div class="form-group">

                                        <label>Produk</label>

                                        <select id="product_name" name="product_name" type="text" class="form-control" placeholder="ketikkan nama produk" required> </select>

                                    </div>

                                </div>

                                <div class="col-sm-1">

                                    <!-- text input -->

                                    <label>&nbsp;</label>

                                    <div class="form-group">

                                        <div class="col-12">

                                            <button id="btnadd_temp" class="btn btn-md btn-primary rounded-circle"><i class="fas fa-plus"></i></button>

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

                                        <td>42</td>

                                        <td>Rp. 450,450</td>

                                        <td>Rp. 450,450</td>

                                        <td>Rp. 49,550</td>

                                        <td>Rp. 500,000</td>

                                        <td>

                                            <button onclick="editrow(1)" class="btn btn-sm btn-warning btnedit rounded-circle" data-toggle="tooltip" data-placement="top" data-title="Edit">

                                                <i class="fas fa-edit"></i>

                                            </button>

                                            &nbsp;

                                            <button class="btn btn-sm btn-danger btndelete rounded-circle" data-toggle="tooltip" data-placement="top" data-title="Hapus">

                                                <i class="fas fa-minus"></i>

                                            </button>

                                        </td>

                                    </tr>


                                    <tr>

                                        <td>2</td>

                                        <td>00011521</td>

                                        <td>IKAD KERAMIK DINDING DX 2277A FR 25X40 - I</td>

                                        <td>142 </td>

                                        <td>Rp. 100,000</td>

                                        <td>Rp. 13,513,514</td>

                                        <td>Rp. 1,486,486</td>

                                        <td>Rp.  15,000,000</td>

                                        <td>

                                            <button onclick="editrow(2)" data-json="{data_json}" class="btn btn-sm btn-warning btnedit rounded-circle" data-toggle="tooltip" data-placement="top" data-title="Edit">

                                                <i class="fas fa-edit"></i>

                                            </button>

                                            &nbsp;

                                            <button  class="btn btn-sm btn-danger btndelete rounded-circle" data-toggle="tooltip" data-placement="top" data-title="Hapus">

                                                <i class="fas fa-minus"></i>

                                            </button>

                                        </td>

                                    </tr>
                                </tbody>

                            </table>


                        </div>

                    </div>



                    <div class="row footer-purchase">

                        <div class="col-lg-6">

                            <div class="form-group">

                                <div class="col-sm-12">

                                    <textarea id="purchase_order_remark" name="purchase_order_remark" class="form-control" placeholder="Catatan" maxlength="500" rows="3"></textarea>

                                </div>

                            </div>

                        </div>

                        <div class="col-lg-6 text-right">

                            <div class="form-group row">
                                <label for="ongkir" class="col-sm-7 col-form-label text-right:">Discount :</label>
                                <div class="col-sm-4">
                                    <input id="discount_header" name="discount_header" type="text" class="form-control text-right" value="0" readonly>
                                </div>
                                <div class="col-sm-1">
                                    <button id="btnadd" class="btn btn-warning"><i class="fas fa-tags"></i></button>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="ongkir" class="col-sm-7 col-form-label text-right:">PPN <?= PPN_TEXT ?> :</label>
                                <div class="col-sm-5">
                                    <input id="display_total_ppn" name="display_total_ppn" type="text" class="form-control text-right" value="0" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="ongkir" class="col-sm-7 col-form-label text-right:">Ongkir :</label>
                                <div class="col-sm-5">
                                    <input id="display_ongkir" name="display_ongkir" type="text" class="form-control text-right" value="0" readonly>
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

</section>

</div>



<!-- /.content -->

<?= $this->endSection() ?>



<?= $this->section('js') ?>

<script>

   function setprice() {
    var id = document.getElementById("product_name").value;
    if(id == '00002050'){
        document.getElementById("temp_price").value = '50000'.toLocaleString('en-US');
    }
    if(id == '00009200'){
        document.getElementById("temp_price").value = '60000'.toLocaleString('en-US');
    }
    if(id == '00011521'){
        document.getElementById("temp_price").value = '59000'.toLocaleString('en-US');
    }
    if(id == '00005001'){
        document.getElementById("temp_price").value = '100000'.toLocaleString('en-US');
    }
}

/*
function setppn() {
    let qty = document.getElementById("temp_qty").value;
    let price = document.getElementById("temp_price").value;
    var id = document.getElementById("product_name").value;
    let totalharga = parseInt(price) * parseInt(qty);
    let ppn = parseInt(totalharga) - parseInt(price) * parseInt(qty) / 1.11;
    document.getElementById("temp_tax").value = ppn.toLocaleString('en-US');
    document.getElementById("subtotal").value = totalharga.toLocaleString('en-US');
}*/


$(document).ready(function() {

     //let temp_qty = new AutoNumeric('#temp_qty', configQty);

     //let temp_price = new AutoNumeric('#temp_price', configRp);

     //let temp_tax = new AutoNumeric('#temp_tax', configRp);

     //let subtotal = new AutoNumeric('#subtotal', configRp);

     let display_total_ppn = new AutoNumeric('#display_total_ppn', configRp);

     let display_total = new AutoNumeric('#display_total', configRp);

        // init component //

        function _initButton() {


        }



        // select2 //

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

        $("#no_po_purchase").select2({

            data: [
            {
                id:'1',
                text: 'PO-KBR-0001'
            },
            {
                id:'2',
                text: 'PO-PST-0002'
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
                text: 'Kredit'
            },
            {
                id:'2',
                text: 'Transfer'
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



        $('#btnadd').click(function(e) {

            e.preventDefault();

            let form = $('#frmpurchase');
                            //let items = response.result.data;
                            $('#title-frmpurchase').html('Tambah Pembelian');

                            formMode = 'add';

                            showInputPage(true);

                        })



        _initButton();

        showInputPage(false);

    })

</script>

<?= $this->endSection() ?>