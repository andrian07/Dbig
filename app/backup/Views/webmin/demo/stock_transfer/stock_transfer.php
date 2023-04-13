<?php
$themeUrl = base_url('assets/adminlte3');
$assetsUrl = base_url('assets');
?>

<?= $this->extend('webmin/template/admin_template') ?>

<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<div id="transfer_list">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Transfer Stok</h1>
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
                            <table id="tblstocktransfer" class="table table-bordered table-hover" width="100%">
                                <thead>
                                    <tr>
                                        <th data-priority="1">#</th>
                                        <th data-priority="2">No Transfer</th>
                                        <th data-priority="4">Tanggal Transfer</th>
                                        <th data-priority="5">Dari Gudang</th>
                                        <th data-priority="6">Ke Gudang</th>
                                        <th data-priority="6"> Total Stok <small>(Unit)</small> </th>
                                        <th data-priority="7">User</th>
                                        <th data-priority="3">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>ST/UTM/22/09/000001</td>
                                        <td>01/09/2022</td>
                                        <td>UTM - PUSAT</td>
                                        <td>KBR - CABANG KOTA BARU</td>
                                        <td>50.00</td>
                                        <td>Reza</td>
                                        <td>
                                            <a href="javascript:;" data-fancybox data-type="iframe" data-src="<?= base_url('webmin/stock-transfer/detail') ?>" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" data-title="Detail"><i class="fas fa-eye"></i></a>&nbsp;
                                            <button class="btn btn-sm btn-default btnprint" data-toggle="tooltip" data-placement="top" data-title="Cetak"><i class="fas fa-print"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>ST/UTM/22/09/000002</td>
                                        <td>01/09/2022</td>
                                        <td>KNY - KONSINYASI</td>
                                        <td>UTM - PUSAT</td>
                                        <td>60.00</td>
                                        <td>Reza</td>
                                        <td>
                                            <a href="javascript:;" data-fancybox data-type="iframe" data-src="<?= base_url('webmin/stock-transfer/detail') ?>" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" data-title="Detail"><i class="fas fa-eye"></i></a>&nbsp;
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

<div id="transfer_input">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 id="title">Tranfer Stok</h1>
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
                            <form id="frmtransfer">
                                <div class="row ">
                                    <div class="col-sm-12 col-md-2">
                                        <input type="hidden" id="supplier_id" name="supplier_id" value="">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>No Transfer</label>
                                            <input id="transfer_code" name="transfer_code" type="text" value="AUTO" class="form-control" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-2">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Tanggal Transfer</label>
                                            <input id="transfer_date" name="transfer_date" type="date" class="form-control" value="2022-09-03" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Dari Gudang</label>
                                            <select id="from_warehouse_id" name="from_warehouse_id" class="form-control">
                                                <option value="1">KBR - KOTA BARU</option>
                                                <option value="2" selected>KNY - KONSINYASI</option>
                                                <option value="3">UTM - PUSAT</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Ke Gudang</label>
                                            <select id="dest_warehouse_id" name="dest_warehouse_id" class="form-control">
                                                <option value="1">KBR - KOTA BARU</option>
                                                <option value="2">KNY - KONSINYASI</option>
                                                <option value="3" selected>UTM - PUSAT</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-2">
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
                                    <div class="col-sm-12 col-md-5">
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
                                            <label>Qty</label>
                                            <input id="qty" name="qty" type="text" class="form-control text-right" placeholder="Qty" value="">
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-2">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Total Stok</label>
                                            <input id="product_stock" name="product_stock" type="text" class="form-control text-right" placeholder="HPP" value="" readonly>
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
                                                <th data-priority="2">Barcode</th>
                                                <th data-priority="4">Nama Produk</th>
                                                <th data-priority="5">Qty</th>
                                                <th data-priority="6">Satuan</th>
                                                <th data-priority="3">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>1234567899999</td>
                                                <td>
                                                    Toto Gantungan Double Robe Hook (TX04AES)
                                                </td>
                                                <td>10.00</td>
                                                <td>
                                                    DUS
                                                </td>
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
                                                <td>12089898398</td>
                                                <td>
                                                    Toto Floor Drain (TX1DA)
                                                </td>
                                                <td>50.00</td>
                                                <td>PCS</td>
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
                                    <textarea id="stock_transfer_remark" name="stock_transfer_remark" class="form-control" placeholder="Catatan" maxlength="500" rows="3"></textarea>
                                </div>
                                <div class="col-6">
                                    <form class="form-horizontal">
                                        <div class="form-group row">
                                            <label for="total_stock_transfer" class="col-7 col-form-label text-right">Total Stok Transfer:</label>
                                            <div class="col-5">
                                                <input id="total_stock_transfer" name="total_stock_transfer" type="text" class="form-control text-right" value="0" readonly>
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
        let qty = new AutoNumeric('#qty', configQty);
        let product_stock = new AutoNumeric('#product_stock', configQty);
        let total_stock_transfer = new AutoNumeric('#total_stock_transfer', configQty);

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
                    targets: [1, 3, 4]
                },
                {
                    width: 80,
                    targets: [5]
                },
                {
                    targets: [5],
                    orderable: false,
                    searchable: false,
                },
                {
                    targets: [0, 3],
                    className: "text-right",
                }
            ]
        };

        // datatables //
        let tblstocktransfer = $("#tblstocktransfer").DataTable({
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
                    width: 20,
                    targets: 0
                },
                {
                    width: 100,
                    targets: [2, 5, 6]
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
                    targets: [0, 5],
                    className: "text-right",
                }
            ],
        });


        $('#tblstocktransfer').on('click', '.btnprint', function(e) {
            e.preventDefault();
            window.open(base_url + '/webmin/stock-transfer/report?print=Y', '_blank')
        })

        $('#btnreload').click(function(e) {
            e.preventDefault();
        })

        function showInputPage(x) {
            if (x) {
                $('#transfer_list').hide();
                $('#transfer_input').show();
            } else {
                $('#transfer_input').hide();
                $('#transfer_list').show();
            }
        }

        function clearItemInput() {
            let form = $('#frmtemp');
            form.parsley().reset();
            $('#product_name').val('');
            $('#unit_name').val('');
            product_stock.set(0);
            qty.set(0);
        }

        $('#btnadd').click(function(e) {
            e.preventDefault();
            $('#stock_transfer_remark').val('');
            total_stock_transfer.set(60);
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



        $('#tbltemp').on('click', '.btnedit', function(e) {
            e.preventDefault();
            $('#product_name').val('1234567899999 - Toto Gantungan Double Robe Hook (TX04AES)');
            $('#unit_name').val('PCS');
            qty.set(10);
            product_stock.set(50);
        })

        $('#btnadd-temp').click(function(e) {
            e.preventDefault();
            clearItemInput();
        })



        _initTooltip();

        showInputPage(false);
        clearItemInput();
    })
</script>
<?= $this->endSection() ?>