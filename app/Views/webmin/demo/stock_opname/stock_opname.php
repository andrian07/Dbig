<?php
$themeUrl = base_url('assets/adminlte3');
$assetsUrl = base_url('assets');
?>

<?= $this->extend('webmin/template/admin_template') ?>

<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<div id="opname_list">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Stok Opname</h1>
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
                            <table id="tblopname" class="table table-bordered table-hover" width="100%">
                                <thead>
                                    <tr>
                                        <th data-priority="1">#</th>
                                        <th data-priority="2">No Opname</th>
                                        <th data-priority="4">Tanggal Opname</th>
                                        <th data-priority="5">Gudang</th>
                                        <th data-priority="6">Selisih (Rp)</th>
                                        <th data-priority="7">User</th>
                                        <th data-priority="3">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>OP/UTM/22/09/000001</td>
                                        <td>01/09/2022</td>
                                        <td>UTM - PUSAT</td>
                                        <td>100,000.00</td>
                                        <td>Reza</td>
                                        <td>
                                            <a href="javascript:;" data-fancybox data-type="iframe" data-src="<?= base_url('webmin/stock-opname/detail') ?>" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" data-title="Detail"><i class="fas fa-eye"></i></a>&nbsp;
                                            <button class="btn btn-sm btn-default btnprint" data-toggle="tooltip" data-placement="top" data-title="Cetak"><i class="fas fa-print"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>OP/KBR/22/09/000001</td>
                                        <td>03/09/2022</td>
                                        <td>KBR - CABANG KOTA BARU</td>
                                        <td>-152,500.00</td>
                                        <td>Ani</td>
                                        <td>
                                            <a href="javascript:;" data-fancybox data-type="iframe" data-src="<?= base_url('webmin/stock-opname/detail') ?>" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" data-title="Detail"><i class="fas fa-eye"></i></a>&nbsp;
                                            <button class="btn btn-sm btn-default btnprint" data-toggle="tooltip" data-placement="top" data-title="Cetak"><i class="fas fa-print"></i></button>
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

<div id="opname_input">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 id="title">Tambah Opname</h1>
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
                                <div class="row ">
                                    <div class="col-sm-12 col-md-2">
                                        <input type="hidden" id="supplier_id" name="supplier_id" value="">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>No Opname</label>
                                            <input id="opname_code" name="opname_code" type="text" value="AUTO" class="form-control" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Tanggal Opname</label>
                                            <input id="opname_date" name="opname_date" type="date" class="form-control" value="2022-09-03" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-4">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Gudang</label>
                                            <select id="warehouse_id" name="warehouse_id" class="form-control">
                                                <option value="1" selected>KBR - KOTA BARU</option>
                                                <option value="2">KNY - KONSINYASI</option>
                                                <option value="3">UTM - PUSAT</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>User</label>
                                            <input id="display_user" type="text" class="form-control" value="Ani" readonly>
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
                            <form id="frmtemp" class="mb-2">
                                <div class="row well well-sm">
                                    <div class="col-sm-12 col-md-4">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Produk</label>
                                            <input id="product_name" name="product_name" type="text" class="form-control" placeholder="Nama Produk" value="">
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-2">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Satuan</label>
                                            <input id="unit_name" name="unit_name" type="text" class="form-control" placeholder="Satuan" value="" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-2">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Isi</label>
                                            <input id="product_content" name="product_content" type="text" class="form-control text-right" placeholder="Isi" value="" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>HPP</label>
                                            <input id="product_cogs" name="product_cogs" type="text" class="form-control text-right" placeholder="HPP" value="" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Stok Sistem</label>
                                            <input id="system_stock" name="system_stock" type="text" class="form-control text-right" placeholder="Stok Sistem" value="" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Stok Fisik</label>
                                            <input id="real_stock" name="real_stock" type="text" class="form-control text-right" placeholder="Stok Fisik" value="">
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-2">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Selisih Stok</label>
                                            <input id="product_difference_stock" name="product_difference_stock" type="text" class="form-control  text-right" placeholder="Selisih Stok" value="" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Selisih HPP</label>
                                            <input id="product_difference_cogs" name="product_difference_cogs" type="text" class="form-control  text-right" placeholder="Selisih Stok" value="" readonly>
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

                                    <table id="tbltemp" class="table table-bordered table-hover" width="100%">
                                        <thead>
                                            <tr>
                                                <th data-priority="1">#</th>
                                                <th data-priority="2">Nama Produk</th>
                                                <th data-priority="4">Satuan</th>
                                                <th data-priority="5">HPP</th>
                                                <th data-priority="6">Stok Fisik</th>
                                                <th data-priority="7">Stok Sistem</th>
                                                <th data-priority="8">Selisih HPP</th>
                                                <th data-priority="3">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>
                                                    <b>P000001</b><br>
                                                    Toto Gantungan Double Robe Hook (TX04AES)
                                                </td>
                                                <td>
                                                    PCS
                                                </td>
                                                <td>27,750.00</td>
                                                <td>240.00</td>
                                                <td>250.00</td>
                                                <td>-277,500.00</td>
                                                <td>
                                                    <button class="btn btn-sm btn-warning btnedit rounded-circle" data-toggle="tooltip" data-placement="top" data-title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger btndelete rounded-circle" data-toggle="tooltip" data-placement="top" data-title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>
                                                    <b>P000002</b><br>
                                                    Toto Floor Drain (TX1DA)
                                                </td>
                                                <td>PCS</td>
                                                <td>25,000.00</td>
                                                <td>100</td>
                                                <td>105</td>
                                                <td>125,000.00</td>
                                                <td>
                                                    <button class="btn btn-sm btn-warning btnedit rounded-circle" data-toggle="tooltip" data-placement="top" data-title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger btndelete rounded-circle" data-toggle="tooltip" data-placement="top" data-title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <textarea id="opname_remark" name="opname_remark" class="form-control" placeholder="Catatan" maxlength="500" rows="3"></textarea>
                                </div>
                                <div class="col-6">
                                    <form class="form-horizontal">
                                        <div class="form-group row">
                                            <label for="total_difference_cogs" class="col-7 col-form-label text-right">Total Selisih:</label>
                                            <div class="col-5">
                                                <input id="total_difference_cogs" name="total_difference_cogs" type="text" class="form-control text-right" value="0" readonly>
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
        let product_content = new AutoNumeric('#product_content', configQty);
        let real_stock = new AutoNumeric('#real_stock', configQty);
        let system_stock = new AutoNumeric('#system_stock', configQty);
        let product_difference_stock = new AutoNumeric('#product_difference_stock', configQty);
        let product_cogs = new AutoNumeric('#product_cogs', configRp);
        let product_difference_cogs = new AutoNumeric('#product_difference_cogs', configRp);
        let total_difference_cogs = new AutoNumeric('#total_difference_cogs', configRp);

        const config_tbltemp = {
            scrollY: "240px",
            scrollCollapse: true,
            paging: false,
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
                    width: 80,
                    targets: [7]
                },
                {
                    targets: [7],
                    orderable: false,
                    searchable: false,
                },
                {
                    targets: [0, 3, 4, 5, 6],
                    className: "text-right",
                }
            ]
        };

        // datatables //
        let tblopname = $("#tblopname").DataTable({
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
                    width: 30,
                    targets: [0]
                },
                {
                    width: 100,
                    targets: [1, 2, 5]
                },
                {
                    targets: [0, 6],
                    orderable: false,
                    searchable: false,
                },
                {
                    targets: [0, 4],
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

        $('#tblopname').on('click', '.btnprint', function(e) {
            e.preventDefault();
            window.open(base_url + '/webmin/stock-opname/report?print=Y', '_blank')
        })

        $('#btnreload').click(function(e) {
            e.preventDefault();
        })

        function showInputPage(x) {
            if (x) {
                $('#opname_list').hide();
                $('#opname_input').show();
            } else {
                $('#opname_input').hide();
                $('#opname_list').show();
            }
        }

        function clearItemInput() {
            let form = $('#frmtemp');
            form.parsley().reset();
            $('#product_name').val('');
            $('#unit_name').val('');
            product_content.set(0);
            product_cogs.set(0);
            system_stock.set(0);
            real_stock.set(0);
            product_difference_stock.set(0);
            product_difference_cogs.set(0);
        }

        $('#btnadd').click(function(e) {
            e.preventDefault();
            $('#opname_remark').val('');
            total_difference_cogs.set(-152500);
            showInputPage(true);
            clearItemInput();
            $('#tbltemp').DataTable(config_tbltemp);
        })

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

        function autoNumericValue(autoNumeric) {
            if (autoNumeric.getNumericString() == '' || autoNumeric.getNumericString() == null) {
                return 0;
            } else {
                return parseFloat(autoNumeric.getNumericString());
            }
        }


        function calcDifference() {
            let ss = autoNumericValue(system_stock);
            let rs = autoNumericValue(real_stock);
            let ds = rs - ss;
            let cogs = autoNumericValue(product_cogs);
            let dcogs = cogs * ds;
            real_stock.set(rs);
            product_difference_stock.set(ds);
            product_difference_cogs.set(dcogs);
        }

        $('#real_stock').on('change blur', function() {
            calcDifference();
        })

        $('#opname_date').on('change blur', function() {
            if ($('#opname_date').val() == '') {
                $('#opname_date').val('<?= date('Y-m-d') ?>');
            }
        })



        $('#tbltemp').on('click', '.btnedit', function(e) {
            e.preventDefault();
            $('#product_name').val('P000001 - Toto Gantungan Double Robe Hook (TX04AES)');
            $('#unit_name').val('PCS');
            product_content.set(1);
            product_cogs.set(27750);
            system_stock.set(250);
            real_stock.set(240);
            calcDifference();
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


        _initTooltip();

        showInputPage(false);
        clearItemInput();
    })
</script>
<?= $this->endSection() ?>