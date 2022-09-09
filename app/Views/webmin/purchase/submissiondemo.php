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

                                                <th data-priority="1">Kode Produk</th>

                                                <th data-priority="2">Produk</th>

                                                <th data-priority="3">Qty</th>

                                                <th data-priority="4">Status</th>

                                                <th data-priority="5">Keterangan</th>

                                                <th data-priority="6">Aksi</th>

                                            </tr>

                                        </thead>

                                        <tbody>
                                           <tr>

                                            <td>1</td>

                                            <td>00002050</td>

                                            <td>NIPPON PAINT CAT BASE NIPPON SATIN GLO - PASTEL BASE 2.35L </td>

                                            <td>10</td>

                                            <td>Urgent</td>

                                            <td>Customer sudah DP dan minta antar dalam 3 hari</td>

                                            <td>

                                                <button id="btnadd" class="btn btn-sm btn-success btnedit rounded-circle" data-toggle="tooltip" data-placement="top" data-title="Edit">

                                                   <i class="fas fa-check-circle"></i>

                                                </button>

                                                &nbsp;


                                            </td>

                                        </tr>


                                        <tr>

                                            <td>2</td>

                                            <td>00009200</td>

                                            <td>ARISTON WATER HEATER ANDRIS AN2 15 LUX 350 ID</td>

                                            <td>10</td>

                                            <td>Restock</td>

                                            <td>Sisa stock per 2/8 tinggal 5</td>

                                            <td>

                                                <button id="btnadd" class="btn btn-sm btn-success btnedit rounded-circle" data-toggle="tooltip" data-placement="top" data-title="Edit">

                                                   <i class="fas fa-check-circle"></i>

                                                </button>

                                                <div class="modal fade" id="modal-customer">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="title-frmcustomer"></h4>
                                                                <button type="button" class="close close-modal">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form id="frmcustomer" class="form-horizontal">
                                                                <div class="modal-body">
                                                                    <input id="customer_id" name="customer_id" value="0" type="hidden">
                                                                    <div class="form-group">
                                                                        <label for="approve_by" class="col-sm-12">Diapprove Oleh</label>
                                                                        <div class="col-sm-12">
                                                                            <input type="text" class="form-control" id="approve_by" name="approve_by" placeholder="
                                                                            Nama" value="" required readonly>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="progress" class="col-sm-12">Progress</label>
                                                                        <div class="col-sm-12">
                                                                            <select id="progress" name="progress" class="form-control">
                                                                                <option value="Disetujui">Disetujui</option>
                                                                                <option value="Ditolak">Ditolak</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="qty" class="col-sm-12">Qty Approve</label>
                                                                        <div class="col-sm-12">
                                                                            <input type="text" class="form-control" id="qty" name="qty" placeholder="qty" value="" data-parsley-maxlength="200" required>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="desc" class="col-sm-12">Keterangan</label>
                                                                        <div class="col-sm-12">
                                                                            <textarea id="desc" name="desc" class="form-control" placeholder="Keterangan" data-parsley-maxlength="500" rows="3" required></textarea>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div class="modal-footer justify-content-between">
                                                                    <button id="btncancel" class="btn btn-danger close-modal"><i class="fas fa-times-circle"></i> Batal</button>
                                                                    <button id="btnsave" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>
                                            </div>


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