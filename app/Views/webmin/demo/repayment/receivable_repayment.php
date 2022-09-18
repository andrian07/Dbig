<?php
$themeUrl = base_url('assets/adminlte3');
$assetsUrl = base_url('assets');
?>

<?= $this->extend('webmin/template/admin_template') ?>

<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<div id="repayment_list">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Pelunasan Piutang</h1>
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
                            <button id="btnreload" class="btn btn-secondary"><i class="fas fa-sync"></i> Reload</button>
                        </div>
                        <div class="card-body">

                            <ul class="nav nav-tabs" id="custom-content-above-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-content-above-exchange-tab" data-toggle="pill" href="#custom-content-above-exchange" role="tab" aria-controls="custom-content-above-exchange" aria-selected="true">Daftar Piutang</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-content-above-history-tab" data-toggle="pill" href="#custom-content-above-history" role="tab" aria-controls="custom-content-above-history" aria-selected="false">Histori Pelunasan Piutang</a>
                                </li>

                            </ul>
                            <div class="tab-content" id="custom-content-above-tabContent">
                                <div class="tab-pane fade show active" id="custom-content-above-exchange" role="tabpanel" aria-labelledby="custom-content-above-exchange-tab">
                                    <!-- exchange -->
                                    <div class="row mb-1 pt-2">
                                        <div class="col-12">
                                            <table id="tblpurchaserepayment" class="table table-bordered table-hover" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th data-priority="1">#</th>
                                                        <th data-priority="2">Kode Customer</th>
                                                        <th data-priority="2">Nama Customer</th>
                                                        <th data-priority="5">Alamat</th>
                                                        <th data-priority="6">No Telp</th>
                                                        <th data-priority="5">Jumlah Nota</th>
                                                        <th data-priority="4">Total Piutang</th>
                                                        <th data-priority="3">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>0000000004</td>
                                                        <td>PT Aneka Jaya</td>
                                                        <td>Jl.Gajah Mada No.5</td>
                                                        <td>0896-7899-8899</td>
                                                        <td>2</td>
                                                        <td>8,000,000.00</td>
                                                        <td>
                                                            <button class="btn btn-sm btn-success btnrepayment" data-toggle="tooltip" data-placement="top" data-title="Pelunasan"><i class="fas fa-money-bill-wave"></i></button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>

                                <div class="tab-pane fade" id="custom-content-above-history" role="tabpanel" aria-labelledby="custom-content-above-history-tab">
                                    <!-- history -->
                                    <div class="row mb-1 pt-2">
                                        <div class="col-12">
                                            <table id="tbldebtrepayment" class="table table-bordered table-hover" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th data-priority="1">#</th>
                                                        <th data-priority="2">No Transaksi</th>
                                                        <th data-priority="2">Nama Supplier</th>
                                                        <th data-priority="5">Tanggal Pembayaran</th>
                                                        <th data-priority="6">Metode Pembayaran</th>
                                                        <th data-priority="5">Jumlah Nota</th>
                                                        <th data-priority="4">Total Pembayaran</th>
                                                        <th data-priority="3">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>PH/UTM/22/08/00001</td>
                                                        <td>PT NIPPON INDONESIA</td>
                                                        <td>24/08/2022</td>
                                                        <td>BCA</td>
                                                        <td>2</td>
                                                        <td>4,200,000.00</td>
                                                        <td>
                                                            <a href="javascript:;" data-fancybox data-type="iframe" data-src="<?= base_url('webmin/debt-repayment/detail') ?>" class="btn btn-sm btn-default mb-2" data-toggle="tooltip" data-placement="top" data-title="Detail"><i class="fas fa-eye"></i></a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>




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

<div id="repayment_input">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 id="title">Pelunasan Hutang</h1>
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
                            <form id="frmpurchase">
                                <div class="row">
                                    <div class="col-sm-12 col-md-3">
                                        <input type="hidden" id="supplier_id" name="supplier_id" value="">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Nama Customer</label>
                                            <input id="supplier_name" name="supplier_name" type="text" class="form-control" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-2">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Tanggal Pembayaran</label>
                                            <input id="repayment_date" name="repayment_date" type="date" class="form-control" value="<?= date('Y-m-d') ?>">
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Metode Pembayaran</label>
                                            <select id="payment_method_id" name="payment_method_id" class="form-control">
                                                <option value="1">CASH</option>
                                                <option value="2">BCA a/n DBIG (0123456789012)</option>
                                                <option value="3">BNI a/n DBIG2 (0123456789012)</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-sm-12 col-md-2">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>User</label>
                                            <input id="display_user" type="text" class="form-control" value="<?= $user['user_realname'] ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-2">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Total Piutang</label>
                                            <input id="supplier_total_debt" name="supplier_total_debt" type="text" class="form-control text-right" value="0" readonly>
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
                            <form id="frmrepayment" class="mb-2">
                                <div class="row">
                                    <input id="temp_key" name="temp_key" type="hidden" value="">
                                    <input id="purchase_id" name="purchase_id" type="hidden" value="">

                                    <div class="col-sm-12 col-md-2">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>No Invoice</label>
                                            <input id="purchase_invoice" name="purchase_invoice" type="text" class="form-control" placeholder="No Invoice" value="" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-2">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>No Faktur</label>
                                            <input id="invoice_number" name="invoice_number" type="text" class="form-control" placeholder="No Faktur" value="" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-2">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Tanggal Invoice</label>
                                            <input id="purchase_date" name="purchase_date" type="date" class="form-control" placeholder="Tanggal Invoice" value="" readonly>
                                        </div>
                                    </div>



                                    <div class="col-sm-12 col-md-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Keterangan</label>
                                            <input id="repayment_remark" name="repayment_remark" type="text" class="form-control" value="" max-length="500">
                                        </div>
                                    </div>



                                    <div class="col-sm-12 col-md-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Saldo Hutang</label>
                                            <input id="remaining_debt" name="remaining_debt" type="text" class="form-control text-right" value="0" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-2">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Pembulatan/Disc</label>
                                            <input id="repayment_disc" name="repayment_disc" type="text" class="form-control text-right" value="0" required>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Pembayaran</label>
                                            <input id="repayment_total" name="repayment_total" type="text" class="form-control text-right" value="0" required>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Sisa Hutang</label>
                                            <input id="new_remaining_debt" name="new_remaining_debt" type="text" class="form-control text-right" value="0" readonly>
                                        </div>
                                    </div>


                                    <div class="col-sm-1">
                                        <!-- text input -->
                                        <label>&nbsp;</label>
                                        <div class="form-group">
                                            <div class="col-12">
                                                <button id="btnadd-temp" class="btn btn-md btn-primary rounded-circle float-right"><i class="fas fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="row mb-2">
                                <div class="col-12">
                                    <table id="tbltemprepayment" class="table table-bordered table-hover" width="100%">
                                        <thead>
                                            <tr>
                                                <th data-priority="1">#</th>
                                                <th data-priority="2">No Invoice</th>
                                                <th data-priority="4">No Faktur</th>
                                                <th data-priority="5">Tanggal Invoice</th>
                                                <th data-priority="6">Saldo Hutang</th>
                                                <th data-priority="7">Pembulatan/Disc</th>
                                                <th data-priority="8">Pembayaran</th>
                                                <th data-priority="9">Sisa Hutang</th>
                                                <th data-priority="3">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>SI/UTM/22/09/00001</td>
                                                <td>FK00001</td>
                                                <td>20/08/22</td>
                                                <td>2,000,000.00</td>
                                                <td>0.00</td>
                                                <td>1,000,000.00</td>
                                                <td>1,000,000.00</td>
                                                <td>
                                                    <button class="btn btn-sm btn-warning btnedit rounded-circle" data-toggle="tooltip" data-placement="top" data-title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>SI/UTM/22/09/00002</td>
                                                <td>FK00002</td>
                                                <td>25/08/22</td>
                                                <td>3,200,000.00</td>
                                                <td>200,000.00</td>
                                                <td>3,000,000.00</td>
                                                <td>0.00</td>
                                                <td>
                                                    <button class="btn btn-sm btn-warning btnedit rounded-circle" data-toggle="tooltip" data-placement="top" data-title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>SI/UTM/22/09/00003</td>
                                                <td>FK00009</td>
                                                <td>10/09/22</td>
                                                <td>4,800,000.00</td>
                                                <td>0.00</td>
                                                <td>0.00</td>
                                                <td>4,800,000.00</td>
                                                <td>
                                                    <button class="btn btn-sm btn-warning btnedit rounded-circle" data-toggle="tooltip" data-placement="top" data-title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>

                            <div class="row">

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
        let default_date = '<?= date('Y-m-d') ?>';
        let supplier_id = 0;
        let remaining_debt = new AutoNumeric('#remaining_debt', configRp);
        let repayment_total = new AutoNumeric('#repayment_total', configRp);
        let repayment_disc = new AutoNumeric('#repayment_disc', configRp);
        let new_remaining_debt = new AutoNumeric('#new_remaining_debt', configRp);
        let supplier_total_debt = new AutoNumeric('#supplier_total_debt', configRp);

        let total_repayment_debt = 0;

        const config_tbltemprepayment = {
            pageLength: 10,
            autoWidth: false,
            select: true,
            responsive: true,
            fixedColumns: true,
            order: [
                [0, 'asc']
            ],
            "language": {
                "url": lang_datatables,
            },
            "columnDefs": [{
                    width: 20,
                    targets: 0
                },
                {
                    width: 100,
                    targets: [3, 4, 5, 6]
                },
                {
                    width: 50,
                    targets: [8]
                },
                {
                    targets: [8],
                    orderable: false,
                    searchable: false,
                },
                {
                    targets: [0, 4, 5, 6, 7],
                    className: "text-right",
                }
            ]
        };


        // datatables //

        let tbldebtrepayment = $("#tbldebtrepayment").DataTable({
            select: true,
            responsive: true,
            fixedColumns: true,
            order: [
                [1, 'desc']
            ],
            language: {
                url: lang_datatables,
            },
            drawCallback: function(settings) {
                _initTooltip();
            },
            columnDefs: [{
                    width: 50,
                    targets: 7
                },
                {
                    width: 80,
                    targets: 5
                },
                {
                    width: 120,
                    targets: [4, 6]
                },
                {
                    targets: [0, 5, 6, 7],
                    orderable: false,
                    searchable: false,
                },
                {
                    targets: [0, 5, 6],
                    className: "text-right",
                },
            ],
        });

        let tblpurchaserepayment = $("#tblpurchaserepayment").DataTable({
            select: true,
            responsive: true,
            fixedColumns: true,
            order: [
                [1, 'desc']
            ],
            language: {
                url: lang_datatables,
            },
            drawCallback: function(settings) {
                _initTooltip();
            },
            columnDefs: [{
                    width: 50,
                    targets: 7
                },
                {
                    width: 80,
                    targets: 5
                },
                {
                    width: 120,
                    targets: [4, 6]
                },
                {
                    targets: [0, 5, 6, 7],
                    orderable: false,
                    searchable: false,
                },
                {
                    targets: [0, 5, 6],
                    className: "text-right",
                },
            ],
        });


        $('#btnreload').click(function(e) {
            e.preventDefault();
        })

        function showInputPage(x) {
            if (x) {
                $('#repayment_list').hide();
                $('#repayment_input').show();
            } else {
                $('#repayment_input').hide();
                $('#repayment_list').show();
            }
        }

        function clearItemInput() {
            let form = $('#frmrepayment');
            form.parsley().reset();
            $('#temp_key').val('');
            $('#purchase_id').val('');
            $('#purchase_invoice').val('');
            $('#invoice_number').val('');
            $('#purchase_date').val('');
            $('#payment_method_id').val(1);
            remaining_debt.set(0);
            repayment_disc.set(0);
            repayment_total.set(0);
            new_remaining_debt.set(0);
            $('#repayment_remark').val('');
        }



        $('#btncancel').click(function(e) {
            e.preventDefault();
            message.question('Yakin ingin menutup halaman ini?').then(function(answer) {
                let yes = parseMessageResult(answer);
                if (yes) {
                    showInputPage(false);
                }
            })
        })

        $('#btnsave').click(function(e) {
            e.preventDefault();
            showInputPage(false);
        });

        function calcRepayment() {
            let rdebt = parseFloat(remaining_debt.getNumericString());

            let rpdisc = 0;
            if (repayment_disc.getNumericString() == '') {
                repayment_disc.set(0);
            } else {
                rpdisc = parseFloat(repayment_disc.getNumericString());
            }


            let rptotal = 0;
            if (repayment_total.getNumericString() == '') {
                repayment_total.set(0);
            } else {
                rptotal = parseFloat(repayment_total.getNumericString());
            }

            let nrdebt = rdebt - (rpdisc + rptotal);
            new_remaining_debt.set(nrdebt);
        }

        $('#repayment_disc,#repayment_total').on('keydown keypress change blur', function() {
            calcRepayment();
        })

        $('#repayment_date').on('change blur', function() {
            if ($('#repayment_date').val() == '') {
                $('#repayment_date').val(default_date);
            }
        })



        $('#tbltemprepayment').on('click', '.btnedit', function(e) {
            e.preventDefault();
            $('#purchase_id').val(2);
            $('#purchase_invoice').val('SI/UTM/22/09/00002');
            $('#invoice_number').val('FK00002');
            $('#purchase_date').val('2022-08-25');
            remaining_debt.set(3200000);
            repayment_disc.set(200000);
            repayment_total.set(3000000);
            new_remaining_debt.set(0);
            $('#repayment_remark').val('Potongan 200rb');
        })

        $('#btnadd-temp').click(function(e) {
            e.preventDefault();
            clearItemInput();
        })

        $('#tblpurchaserepayment').on('click', '.btnrepayment', function(e) {
            e.preventDefault();
            showInputPage(true);
            $('#supplier_name').val('PT NIPPON INDONESIA');
            supplier_total_debt.set(10000000);
            clearItemInput();
        })

        $('#tbltemprepayment').DataTable(config_tbltemprepayment);
        _initTooltip();

        showInputPage(false);
    })
</script>
<?= $this->endSection() ?>