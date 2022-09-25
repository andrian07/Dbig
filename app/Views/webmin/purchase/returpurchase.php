<?php
$themeUrl = base_url('assets/adminlte3');
$assetsUrl = base_url('assets');
?>

<?= $this->extend('webmin/template/admin_template') ?>

<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<div id="returpurchase_list">

    <section class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h1>Retur Pembelian</h1>

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

                            <table id="tblreturpurcase" class="table table-bordered table-hover" width="100%">

                                <thead>

                                    <tr>

                                        <th data-priority="1">#</th>

                                        <th data-priority="2">No Invoice</th>

                                        <th data-priority="2">Tanggal</th>

                                        <th data-priority="4">Nama Suplier</th>

                                        <th data-priority="6">Status Pembayaran</th>

                                        <th data-priority="3">Total Transaksi</th>

                                        <th data-priority="3">Aksi</th>

                                    </tr>

                                </thead>

                                <tbody>
                                    <tr>

                                        <td data-priority="1">1</td>

                                        <td data-priority="1">RTR-KBR-0001</td>

                                        <td data-priority="2">02/09/2022</td>

                                        <td data-priority="6">PT NIPPON INDONESIA</td>

                                        <td data-priority="6"><span class="badge badge-success">Lunas</span></td>

                                        <td data-priority="6">5.000.000</td>

                                        <td data-priority="3">
                                            <a href="<?php base_url() ?>submission/submissiondetaildemo">
                                                <button class="btn btn-sm btn-default btndetail mb-2" data-toggle="tooltip" data-placement="top" data-title="Detail" data-original-title="" title=""><i class="fas fa-eye"></i></button>
                                            </a>
                                             <a href="<?php base_url() ?>purchase-order/printinvoice">
                                            <button data-id="1" data-invoice="0000000001" class="btn btn-sm btn-default btndetail mb-2" data-toggle="tooltip" data-placement="top" data-title="Print" data-original-title="" title=""><i class="fas fa-print"></i></button>
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



<div id="returpurchase_input">

    <section class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h1 id="title-frmreturpurchase"></h1>

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


                          <form id="frmreturpurchase" class="form-horizontal form-space">

                            <div class="form-group row">

                                <label for="noinvoice" class="col-sm-1 col-form-label text-right">No Invoice :</label>

                                <div class="col-sm-3">

                                    <input id="retur_invoice_no" name="retur_invoice_no" type="text" class="form-control" value="AUTO" readonly>

                                </div>

                                <div class="col-md-1"></div>

                                <label for="noinvoice" class="col-sm-2 col-form-label text-right">No Faktur Pajak :</label>

                                <div class="col-sm-2">

                                    <input id="invoice_tax_number" name="invoice_tax_number" type="text" class="form-control" >

                                </div>

                                <label for="tanggal" class="col-sm-1 col-form-label text-right">Tanggal :</label>

                                <div class="col-sm-2">

                                    <input id="retur_date" name="retur_date" type="date" class="form-control" value="<?= date('Y-m-d') ?>" readonly>

                                </div>
                            </div>


                            <div class="form-group row">

                                <label for="suplier" class="col-sm-1 col-form-label text-right">Supplier :</label>

                                <div class="col-sm-3">

                                    <select id="supplier_id" name="supplier_id" class="form-control"></select>

                                </div>

                                <div class="col-sm-1">

                                    <button id="btnadd" class="btn btn-primary"><i class="fas fa-plus"></i></button>

                                </div>

                                <label for="noinvoice" class="col-sm-2 col-form-label text-right">Tanggal Faktur Pajak :</label>

                                <div class="col-sm-2">

                                    <input id="invoice_tax_date" name="invoice_tax_date" type="date" class="form-control" >

                                </div>

                                <label for="user" class="col-sm-1 col-form-label text-right">Gudang :</label>

                                <div class="col-sm-2">

                                    <select id="warehouse" type="text" class="form-control"></select>

                                </div>

                            </div>


                            <div class="form-group row">

                                <div class="col-md-9"></div>

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

                                        <label>Harga Beli Per Unit</label>

                                        <input id="temp_price" name="temp_price" type="text" class="form-control text-right" value="0" data-parsley-vprice required>

                                    </div>

                                </div>

                                

                                <div class="col-sm-2">

                                    <!-- text input -->

                                    <div class="form-group">

                                        <label>DPP</label>

                                        <input id="temp_dpp" name="temp_dpp" type="text" class="form-control text-right" value="0" required>

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

                                        <input id="temp_qty" name="temp_qty" type="text" class="form-control text-right" value="0" data-parsley-vqty required>
                                        <input id="total_price" name="total_price" type="hidden" class="form-control text-right" value="0" data-parsley-vqty required>

                                    </div>

                                </div>

                                <div class="col-md-1"></div>
                                <div class="col-md-5"></div>

                                <div class="col-sm-2">

                                    <!-- text input -->

                                    <div class="form-group">

                                        <label>Ongkir</label>

                                        <input id="temp_ongkir" name="temp_ongkir" type="text" class="form-control text-right" value="0">

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

                                            <button id="btnadd_temp" class="btn btn-md btn-primary rounded-circle" ><i class="fas fa-plus"></i></button>
                                         
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

                                            <th data-priority="4">Qty</th>

                                            <th data-priority="5">Harga Satuan</th>

                                            <th data-priority="6">DPP</th>

                                            <th data-priority="7">PPN</th>

                                            <th data-priority="10">Total</th>

                                            <th data-priority="11">Aksi</th>

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
                                <label for="footer_total_invoice" class="col-sm-4 col-form-label text-right:">Total :</label>
                                <div class="col-sm-8">
                                    <input id="footer_total_invoice" name="footer_total_invoice" type="text" class="form-control text-right" value="0" readonly>
                                </div>
                            </div>

                            <div class="form-group row" style="margin-top: 30px;">
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

    $(document).ready(function() {

       let temp_price = new AutoNumeric('#temp_price', configRp);

       let temp_tax = new AutoNumeric('#temp_tax', configRp);

       let temp_dpp = new AutoNumeric('#temp_dpp', configRp); 

       let temp_qty = new AutoNumeric('#temp_qty', configQty);

       let temp_total = new AutoNumeric('#temp_total', configRp);

       let temp_ongkir = new AutoNumeric('#temp_ongkir', configRp);

       let total_price = new AutoNumeric('#total_price', configRp);

       let footer_total_invoice = new AutoNumeric('#footer_total_invoice', configRp);



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

                $('#returpurchase_list').hide();

                $('#returpurchase_input').show();



            } else {

                $('#returpurchase_list').show();

                $('#returpurchase_input').hide();

            }

        }

        function footer_calculation() {
            // body...
        }


        $('#temp_qty').on('change', function() {
            calculation_temp_total();
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
            let ppn = price_calculation - (price_calculation / 1.11);
            let dpp = price_calculation - ppn;
            let qty_calculation = parseFloat(temp_qty.getNumericString());
            let subtotal_calculation = price_calculation * qty_calculation;
            total_price.set(subtotal_calculation);
            temp_dpp.set(parseFloat(dpp.toFixed(2)));
            temp_tax.set(parseFloat(ppn.toFixed(2)));
            temp_total.set(Number(total_price.get()) + Number(temp_ongkir.get()));
        }


        $('#btnadd').click(function(e) {

            e.preventDefault();

            let form = $('#frmreturpurchase');
                            //let items = response.result.data;
                            $('#title-frmreturpurchase').html('Tambah Retur Pembelian');

                            formMode = 'add';

                            showInputPage(true);

                        })



        _initButton();

        showInputPage(false);

    })

</script>

<?= $this->endSection() ?>