<?php
$themeUrl = base_url('assets/adminlte3');
$assetsUrl = base_url('assets');
?>

<?= $this->extend('webmin/template/admin_template') ?>

<?= $this->section('content') ?>
<!-- Content Header (Page header) -->




<div id="po_input">

    <section class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h1 id="title-frmpurchaseorder">Proses Approve</h1>

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

                            <form id="frmsubmission">

                                <div class="row">

                                    <div class="col-sm-2">

                                        <!-- text input -->

                                        <div class="form-group">

                                            <label>Tanggal Transaksi</label>

                                            <input id="purchase_order_date" name="purchase_order_date" type="date" class="form-control" value="<?= date('Y-m-d') ?>" readonly>

                                        </div>

                                    </div>

                                    <div class="col-sm-3">

                                        <!-- text input -->

                                        <div class="form-group">

                                            <label>No Referensi Pengajuan</label>

                                            <input type="hidden" id="purchase_order_id" name="purchase_order_id" value="0">



                                            <input id="purchase_order_invoice" name="purchase_order_invoice" type="text" class="form-control" value="AUTO" readonly>

                                        </div>

                                    </div>



                                    <div class="col-sm-3">

                                        <!-- text input -->

                                        <div class="form-group">

                                            <label>Diajukan Oleh:</label>

                                            <input id="display_user" type="text" class="form-control" value="Marketing 01" readonly>

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

                            <div class="row mb-2">

                                <div class="col-12">

                                    <table id="tbltemp" class="table table-bordered table-hover" width="100%">

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

    $(document).ready(function() {

     // let temp_qty = new AutoNumeric('#temp_qty', configQty);

        // init component //

        function _initButton() {


        }





        // select2 //

        $("#temp_status").select2({

            data: [
            {
                id:'1',
                text: 'Urgent'
            },
            {
                id:'2',
                text: 'Restock'
            },
            {
                id:'3',
                text: 'Baru',
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


        $('#btnadd').click(function(e) {
            e.preventDefault();
            addMode();
        })

        function addMode() {
            let form = $('#frmcustomer');
            $('#title-frmcustomer').html('Approve Pengajuan');
            form[0].reset();
            form.parsley().reset();
            formMode = 'add';
            $('#approve_by').val('KBGPMB - KABAG PEMBELIAN');
            $('#modal-customer').modal(configModal);
        }

        $('.close-modal').click(function(e) {
            e.preventDefault();
            message.question('Yakin ingin menutup halaman ini?').then(function(answer) {
                let yes = parseMessageResult(answer);
                if (yes) {
                    $('#modal-customer').modal('hide');
                }
            })
        })


        // Table //




    })

</script>

<?= $this->endSection() ?>