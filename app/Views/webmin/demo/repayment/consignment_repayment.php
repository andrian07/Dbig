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
                    <h1>Pelunasan Konsinyasi</h1>
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
                                    <a class="nav-link active" id="custom-content-above-exchange-tab" data-toggle="pill" href="#custom-content-above-exchange" role="tab" aria-controls="custom-content-above-exchange" aria-selected="true">Daftar Hutang</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-content-above-history-tab" data-toggle="pill" href="#custom-content-above-history" role="tab" aria-controls="custom-content-above-history" aria-selected="false">Histori Pelunasan Hutang</a>
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
                                                        <th data-priority="2">Kode Supplier</th>
                                                        <th data-priority="5">Nama Supplier</th>
                                                        <th data-priority="6">Alamat</th>
                                                        <th data-priority="7">No Telp</th>
                                                        <th data-priority="4">Total Hutang</th>
                                                        <th data-priority="3">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>NPPI</td>
                                                        <td>PT NIPPON INDONESIA</td>
                                                        <td>Jl Sungai Raya Dalam Komplek ABC No.10</td>
                                                        <td>0896-0899-0888</td>
                                                        <td>2,442,500.00</td>
                                                        <td>
                                                            <button class="btn btn-sm btn-default btnprint" data-toggle="tooltip" data-placement="top" data-title="Cetak"><i class="fas fa-print"></i></button>
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
                                                        <th data-priority="5">Nama Supplier</th>
                                                        <th data-priority="6">Tanggal Pembayaran</th>
                                                        <th data-priority="7">Metode Pembayaran</th>
                                                        <th data-priority="4">Total Pembayaran</th>
                                                        <th data-priority="3">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>PK/UTM/22/08/00001</td>
                                                        <td>PT NIPPON INDONESIA</td>
                                                        <td>24/08/2022</td>
                                                        <td>BCA</td>
                                                        <td>2,442,500.00</td>
                                                        <td>
                                                            <a href="javascript:;" data-fancybox data-type="iframe" data-src="<?= base_url('webmin/consignment-repayment/detail') ?>" class="btn btn-sm btn-default mb-2" data-toggle="tooltip" data-placement="top" data-title="Detail"><i class="fas fa-eye"></i></a>
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
                    <h1 id="title">Pelunasan Konsinyasi</h1>
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
                                            <label>Nama Supplier</label>
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
                                    <table id="tbltemprepayment" class="table table-bordered table-hover" width="100%">
                                        <thead>
                                            <tr>
                                                <th data-priority="1">#</th>
                                                <th data-priority="2">No Pembelian <br> <span class="border-top border-dark">No Transfer</span></th>
                                                <th data-priority="6">Barcode</th>
                                                <th data-priority="7">Nama Produk</th>
                                                <th data-priority="8">DPP</th>
                                                <th data-priority="8">PPN</th>
                                                <th data-priority="9">Qty</th>
                                                <th data-priority="3">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>PI/UTM/22/09/000001<br>ST/UTM/22/09/000002</td>

                                                <td>1234567899999</td>
                                                <td>Toto Gantungan Double Robe Hook (TX04AES)</td>
                                                <td>100,000.00</td>
                                                <td>10,000.00</td>
                                                <td>5.00</td>
                                                <td>550,000.00</td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>PI/UTM/22/09/000002<br>ST/UTM/22/09/000002</td>

                                                <td>1234567899999</td>
                                                <td>Toto Gantungan Double Robe Hook (TX04AES)</td>
                                                <td>100,000.00</td>
                                                <td>11,000.00</td>
                                                <td>5.00</td>
                                                <td>555,000.00</td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>PI/UTM/22/09/000002<br>ST/UTM/22/09/000002</td>

                                                <td>12089898398</td>
                                                <td>Toto Floor Drain (TX1DA)</td>
                                                <td>25,000.00</td>
                                                <td>2,750.00</td>
                                                <td>50.00</td>
                                                <td>1,387,500.00</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <textarea id="consignment_repayment_remark" name="consignment_repayment_remark" class="form-control" placeholder="Catatan" maxlength="500" rows="3"></textarea>
                                </div>
                                <div class="col-6">
                                    <form class="form-horizontal">
                                        <div class="form-group row">
                                            <label for="consignment_debt_total" class="col-7 col-form-label text-right">Total Hutang:</label>
                                            <div class="col-5">
                                                <input id="consignment_debt_total" name="consignment_debt_total" type="text" class="form-control text-right" value="0" readonly>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="consignment_repayment_total" class="col-7 col-form-label text-right">Total Pembayaran:</label>
                                            <div class="col-5">
                                                <input id="consignment_repayment_total" name="consignment_repayment_total" type="text" class="form-control text-right" value="0">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="consignment_repayment_disc" class="col-7 col-form-label text-right">Pembulatan / Disc:</label>
                                            <div class="col-5">
                                                <input id="consignment_repayment_disc" name="consignment_repayment_disc" type="text" class="form-control text-right" value="0">
                                            </div>
                                        </div>


                                    </form>
                                </div>
                                <div class="col-12 mt-3">
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

        let consignment_debt_total = new AutoNumeric('#consignment_debt_total', configRp);
        let consignment_repayment_total = new AutoNumeric('#consignment_repayment_total', configRp);
        let consignment_repayment_disc = new AutoNumeric('#consignment_repayment_disc', configRp);

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
                    targets: [2, 3, 5, 6, 7]
                },
                {
                    targets: [0, 5, 6, 7],
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
                    width: 80,
                    targets: 6
                },
                {
                    width: 100,
                    targets: [1, 3, 5]
                },
                {
                    width: 200,
                    targets: 2
                },
                {
                    targets: [0, 5, 6],
                    orderable: false,
                    searchable: false,
                },
                {
                    targets: [0, 5],
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
                    width: 80,
                    targets: 6
                },
                {
                    width: 120,
                    targets: [4, 5]
                },
                {
                    targets: [0, 5, 6],
                    orderable: false,
                    searchable: false,
                },
                {
                    targets: [0, 5],
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
            return true;
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
            consignment_debt_total.set(2442500);
            consignment_repayment_disc.set(0);
            consignment_repayment_total.set(0);
            clearItemInput();
        })
        $('#tblpurchaserepayment').on('click', '.btnprint', function(e) {
            e.preventDefault();
            window.open(base_url + '/webmin/consignment-repayment/invoice', '_blank');
        })

        $('#tbltemprepayment').DataTable(config_tbltemprepayment);
        _initTooltip();

        showInputPage(false);
    })
</script>
<?= $this->endSection() ?>