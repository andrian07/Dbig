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

                                        <th data-priority="2">Tanggal PO</th>

                                        <th data-priority="4">Golongan</th>

                                        <th data-priority="6">Nama Supplier</th>

                                        <th data-priority="6">No Faktur Suplier</th>

                                        <th data-priority="3">Total Harga</th>

                                        <th data-priority="3">Status Barang</th>

                                        <th data-priority="3">Aksi</th>

                                    </tr>

                                </thead>

                                <tbody>
                                        <tr>

                                        <td data-priority="1">1</td>

                                        <td data-priority="2">02/09/2022</td>

                                        <td data-priority="4">BKP</td>

                                        <td data-priority="6">PT NIPPON INDONESIA</td>

                                        <td data-priority="6">SJ-20220821168</td>

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

                              <form id="frmpurchaseorder">

                                <div class="row">

                                    <div class="col-sm-4">

                                        <!-- text input -->

                                        <div class="form-group">

                                            <label>No Invoice</label>

                                            <input type="hidden" id="purchase_order_id" name="purchase_order_id" value="0">



                                            <input id="purchase_order_invoice" name="purchase_order_invoice" type="text" class="form-control" value="AUTO" readonly>

                                        </div>

                                    </div>

                                    <div class="col-sm-4">

                                        <!-- text input -->

                                        <div class="form-group">

                                            <label>Supplier</label>

                                            <select id="supplier_id" name="supplier_id" class="form-control"></select>

                                        </div>

                                    </div>



                                    <div class="col-sm-4">

                                        <!-- text input -->

                                        <div class="form-group">

                                            <label>Tanggal Transaksi</label>

                                            <input id="purchase_order_date" name="purchase_order_date" type="date" class="form-control" value="<?= date('Y-m-d') ?>" readonly>

                                        </div>

                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-sm-3">

                                        <!-- text input -->

                                        <div class="form-group">

                                            <label>User</label>

                                            <input id="display_user" type="text" class="form-control" value="<?= $user['user_realname'] ?>" readonly>

                                        </div>

                                    </div>

                                     <div class="col-sm-2">

                                        <!-- text input -->

                                        <div class="form-group">

                                            <label>Biaya Ongkir</label>

                                            <input id="ongkir" name="ongkir" type="text" class="form-control text-right" value="0">

                                        </div>

                                    </div>

                                    <div class="col-sm-7">

                                        <!-- text input -->

                                        <div class="form-group">

                                            <label>Total</label>

                                            <input type="hidden" id="purchase_order_total" name="purchase_order_total">

                                            <input id="display_total" name="display_total" type="text" class="form-control text-right" value="0" readonly>

                                        </div>

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

                                            <label>PPN <?= PPN_TEXT ?></label>

                                            <input id="temp_tax" name="temp_tax" type="text" class="form-control text-right" value="0" readonly required>

                                        </div>

                                    </div>

                                    <div class="col-sm-2">

                                        <!-- text input -->

                                        <div class="form-group">

                                            <label>Qty</label>

                                            <input id="temp_qty" name="temp_qty" type="text" class="form-control text-right" onchange="setppn()" value="0" data-parsley-vqty required>

                                        </div>

                                    </div>

                                    <div class="col-sm-2">

                                        <!-- text input -->

                                        <div class="form-group">

                                            <label>Total</label>

                                            <input id="subtotal" name="subtotal" type="text" class="form-control text-right" value="0" readonly>

                                        </div>

                                    </div>

                                    <div class="col-sm-1">

                                        <!-- text input -->

                                        <label>&nbsp;</label>

                                        <div class="form-group">

                                            <div class="col-12">

                                                <button id="btnadd_temp" class="btn btn-md btn-primary rounded-circle float-right"><i class="fas fa-plus"></i></button>
                                                <button id="getlist" class="btn btn-md btn-warning rounded-circle float-right"><i class="fas fa-cog"></i></button>


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

                                                <th data-priority="1">Kode Produk</th>

                                                <th data-priority="2">Produk</th>

                                                <th data-priority="3">Qty</th>

                                                <th data-priority="4">Harga Satuan</th>

                                                <th data-priority="5">PPN</th>

                                                <th data-priority="5">Total</th>

                                                <th data-priority="6">Aksi</th>

                                            </tr>

                                        </thead>

                                        <tbody>
                                             <tr>

                                            <td>1</td>

                                            <td>00002050</td>

                                            <td>NIPPON PAINT CAT BASE NIPPON SATIN GLO - PASTEL BASE 2.35L </td>

                                            <td>10</td>

                                            <td>Rp. 50,000</td>

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

                                            <td>00009200</td>

                                            <td>ARISTON WATER HEATER ANDRIS AN2 15 LUX 350 ID</td>

                                            <td>10</td>

                                            <td>Rp. 50,000</td>

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
                                        </tbody>

                                    </table>


                                </div>

                            </div>



                            <div class="row">

                                <div class="col-lg-6 col-md-6 col-sm-12">

                                    <div class="form-group">

                                        <label for="purchase_order_remark" class="col-sm-12">Catatan</label>

                                        <div class="col-sm-12">

                                            <textarea id="purchase_order_remark" name="purchase_order_remark" class="form-control" placeholder="Catatan" maxlength="500" rows="3"></textarea>

                                        </div>

                                    </div>

                                </div>

                                <div class="col-12">

                                    <div class="col-12">

                                        <button id="btncancel" class="btn btn-danger"><i class="fas fa-times-circle"></i> Batal</button>

                                        <button id="btnsave" class="btn btn-success float-right"><i class="fas fa-save"></i> Simpan</button>

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

        function setppn() {
            let qty = document.getElementById("temp_qty").value;
            let price = document.getElementById("temp_price").value;
            var id = document.getElementById("product_name").value;
            let totalharga = parseInt(price) * parseInt(qty);
            let ppn = parseInt(totalharga) - parseInt(price) * parseInt(qty) / 1.11;
            document.getElementById("temp_tax").value = ppn.toLocaleString('en-US');
            document.getElementById("subtotal").value = totalharga.toLocaleString('en-US');
        }

    $(document).ready(function() {

     // let temp_qty = new AutoNumeric('#temp_qty', configQty);
        let temp_price = new AutoNumeric('#temp_price', configRp);

        let temp_tax = new AutoNumeric('#temp_tax', configRp);

        let temp_qty = new AutoNumeric('#temp_qty', configQty);

        let subtotal = new AutoNumeric('#subtotal', configRp);

        let ongkir = new AutoNumeric('#ongkir', configRp);

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