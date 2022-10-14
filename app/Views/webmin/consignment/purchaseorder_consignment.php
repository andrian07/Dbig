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

                    <h1>Pruchase Order Konsinyasi</h1>

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

                                        <td data-priority="6">PT NIPPON INDONESIA</td>

                                        <td data-priority="6">500.000</td>

                                        <td data-priority="6"><span class="badge badge-success">Diterima</span></td>

                                        <td data-priority="3">
                                            <a href="<?php base_url() ?>submission/submissiondetaildemo">
                                                <button class="btn btn-sm btn-default btndetail mb-2" data-toggle="tooltip" data-placement="top" data-title="Detail" data-original-title="" title=""><i class="fas fa-eye"></i></button>
                                            </a>
                                             <a href="<?php base_url() ?>purchase-order-consignment/printinvoice">
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



<div id="po_input">

    <section class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h1 id="title-frm-purchase-order-consignment">Tambah PO</h1>

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


                          <form id="frm-purchase-order-consignment" class="form-horizontal form-space">

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

                                <label for="suplier" class="col-sm-1 col-form-label text-right">Supplier :</label>

                                <div class="col-sm-3">

                                    <select id="supplier_id" name="supplier_id" class="form-control"></select>

                                </div>

                                <div class="col-sm-1">

                                    <button id="btnadd" class="btn btn-primary"><i class="fas fa-plus"></i></button>

                                </div>

                                <div class="col-md-3"></div>

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

                                        <label>Qty</label>

                                        <input id="temp_qty" name="temp_qty" type="text" class="form-control text-right" value="0" data-parsley-vqty required>
                                        <input id="total_price" name="total_price" type="hidden" class="form-control text-right" value="0" data-parsley-vqty required>

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

                                            <th data-priority="3" width="50%;">Produk</th>

                                            <th data-priority="4">Qty</th>

                                            <th data-priority="5">Aksi</th>

                                        </tr>

                                    </thead>

                                    <tbody>
                                     <tr>

                                        <td>1</td>

                                        <td>651</td>

                                        <td>EUROPE FLOOR DRAIN (D02)</td>

                                        <td>10</td>


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

                                        <td>638</td>

                                        <td>EUROPE FLOOR DRAIN (D03)</td>

                                        <td>10</td>


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

                                        <td>3</td>

                                        <td>706</td>

                                        <td>EUROPE GANTUNGAN ROBE HOOK (E1108)</td>

                                        <td>10</td>


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

       let temp_qty = new AutoNumeric('#temp_qty', configQty);


        // init component //

        function _initButton() {


        }



        // select2 //


        $("#warehouse").select2({

            data: [
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

                $('#po_list').hide();

                $('#po_input').show();



            } else {

                $('#po_list').show();

                $('#po_input').hide();

            }

        }

        $('#btnadd').click(function(e) {

            e.preventDefault();

            let form = $('#frm-purchase-order-consignment');
                            //let items = response.result.data;
                            $('#title-frm-purchase-order-consignment').html('Pengajuan Pesanan Konsinyasi');

                            formMode = 'add';

                            showInputPage(true);

                        })



        _initButton();

        showInputPage(false);

    })

</script>

<?= $this->endSection() ?>