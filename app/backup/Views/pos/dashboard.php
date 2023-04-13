<?php
$themeUrl = base_url('assets/adminlte3');
$assetsUrl = base_url('assets');
?>

<?= $this->extend('pos/template/pos_template') ?>

<?= $this->section('content') ?>
<!-- Content Header (Page header) -->

<div class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-2">
                <button id="btnopenpos" class="btn btn-block btn-primary">
                    <i class="fas fa-cash-register"></i> Buka Kas
                </button>
                <button id="btnclosepos" class="btn btn-block btn-danger">
                    <i class="fas fa-cash-register"></i> Tutup Kas
                </button>
            </div>

            <div class="col-sm-2">
                <button id="btncashin" class="btn btn-block btn-success">
                    <i class="fas fa-dollar-sign"></i> Kas Masuk
                </button>
            </div>
            <div class="col-sm-2">
                <button id="btncashout" class="btn btn-block btn-danger">
                    <i class="fas fa-hand-holding-usd"></i> Kas Keluar
                </button>
            </div>
            <div class="col-sm-2">
                <button id="btnadd_sales" class="btn btn-block btn-primary">
                    <i class="fas fa-plus"></i> Tambah Penjualan
                </button>
            </div>
            <div class="col-sm-2">
                <button id="btnadd_salesreturn" class="btn btn-block btn-primary">
                    <i class="fas fa-plus"></i> Tambah Retur
                </button>
            </div>
            <div class="col-sm-2">
                <button id="btnsalesrecap" class="btn btn-block btn-primary">
                    <i class="fas fa-file"></i> Rekap Penjualan
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-cash-register"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Saldo Awal</span>
                        <span class="info-box-number">Rp 200,000.00</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-cash-register"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Saldo Kas</span>
                        <span class="info-box-number">Rp 203,400.00</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="clearfix hidden-md-up"></div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total Sales</span>
                        <span class="info-box-number">Rp 3,400.00</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total Retur</span>
                        <span class="info-box-number">Rp 0</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>
    </div>
</div>

<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <h3 class="text-center">Histori Kas</h3>
                        <div class="row mb-1">
                            <table id="tblcashflow" class="table table-bordered table-hover" width="100%">
                                <thead>
                                    <tr>
                                        <th width="20%">Tanggal</th>
                                        <th width="20%">Jenis Kas</th>
                                        <th width="35%">Keterangan</th>
                                        <th width="25%" class="text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <?= indo_short_date('2022-08-24 08:00:00', TRUE, '<br>') ?>
                                        </td>
                                        <td>
                                            Kas Awal
                                        </td>
                                        <td>
                                            -
                                        </td>
                                        <td class="text-right">
                                            200,000.00
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <?= indo_short_date('2022-08-24 09:00:00', TRUE, '<br>') ?>
                                        </td>
                                        <td>
                                            Kas Keluar
                                        </td>
                                        <td>
                                            Setor Ke Kabag
                                        </td>
                                        <td class="text-right">
                                            100,000.00
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <?= indo_short_date('2022-08-24 18:00:00', TRUE, '<br>') ?>
                                        </td>
                                        <td>
                                            Kas Masuk
                                        </td>
                                        <td>
                                            Tambah Uang Kas
                                        </td>
                                        <td class="text-right">
                                            50,000.00
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </div>
</div>

<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <h3 class="text-center">Histori Penjualan</h3>
                        <div class="row mb-1">
                            <div class="col-12">
                                <table id="tblsales" class="table table-bordered table-hover" width="100%">
                                    <thead>
                                        <tr>
                                            <th data-priority="1">No Invoice</th>
                                            <th data-priority="4">Tanggal</th>
                                            <th data-priority="5">Customer</th>
                                            <th data-priority="2">Total</th>
                                            <th data-priority="3">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                SI/UTM/22/08/00001
                                            </td>
                                            <td>
                                                24/08/2022
                                            </td>
                                            <td>
                                                BUDI
                                            </td>
                                            <td>
                                                51,500.00
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btnedit btn-sm btn-default"><i class="fas fa-print"></i></button>
                                                    <button type="button" class="btn btndelete btn-sm btn-danger"><i class="fas fa-times"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                SI/UTM/22/08/00002
                                            </td>
                                            <td>
                                                24/08/2022
                                            </td>
                                            <td>
                                                CASH
                                            </td>
                                            <td>
                                                100,000.00
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btnedit btn-sm btn-default"><i class="fas fa-print"></i></button>
                                                    <button type="button" class="btn btndelete btn-sm btn-danger"><i class="fas fa-times"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                SI/UTM/22/08/00003
                                            </td>
                                            <td>
                                                24/08/2022
                                            </td>
                                            <td>
                                                CASH
                                            </td>
                                            <td>
                                                50,000.00
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btnedit btn-sm btn-default"><i class="fas fa-print"></i></button>
                                                    <button type="button" class="btn btndelete btn-sm btn-danger"><i class="fas fa-times"></i></button>
                                                </div>
                                            </td>
                                        </tr>


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-danger card-outline">
                    <div class="card-body">
                        <h3 class="text-center">Histori Retur Penjualan</h3>
                        <div class="row mb-1">
                            <div class="col-12">
                                <table id="tblsalesreturn" class="table table-bordered table-hover" width="100%">
                                    <thead>
                                        <tr>
                                            <th data-priority="1">No Invoice</th>
                                            <th data-priority="4">Tanggal</th>
                                            <th data-priority="5">Customer</th>
                                            <th data-priority="2">Total</th>
                                            <th data-priority="3">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                SR/UTM/22/08/00001
                                            </td>
                                            <td>
                                                24/08/2022
                                            </td>
                                            <td>
                                                BUDI
                                            </td>
                                            <td>
                                                10,300.00
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btnedit btn-sm btn-default"><i class="fas fa-print"></i></button>
                                                    <button type="button" class="btn btndelete btn-sm btn-danger"><i class="fas fa-times"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>







                    </div>
                </div>
            </div>


        </div>

    </div>
</div>


<div class="modal fade" id="modal-openpos">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Buka Kas</h4>
                <button type="button" class="close close-modal-openpos">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="frmopenpos" class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="open_balance" class="col-sm-12">Saldo Awal</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="open_balance" name="open_balance" placeholder="Saldo Awal" value="0.00" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button class="btn btn-danger close-modal-openpos"><i class="fas fa-times-circle"></i> Batal</button>
                    <button id="btnsave_openpos" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-closepos">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tutup Kas</h4>
                <button type="button" class="close close-modal-closepos">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="frmclosepos" class="form-horizontal">
                <div class="modal-body">
                    <div id="view_close_balance" class="form-group">
                        <label for="close_balance" class="col-sm-12">Saldo Akhir</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="close_balance" name="close_balance" placeholder="Saldo Akhir" value="351,500.00" readonly required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="session_remark" class="col-sm-12">Catatan</label>
                        <div class="col-sm-12">
                            <textarea id="session_remark" name="session_remark" class="form-control" placeholder="Catatan" data-parsley-maxlength="500" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button class="btn btn-danger close-modal-closepos"><i class="fas fa-times-circle"></i> Batal</button>
                    <button id="btnsave_closepos" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade" id="modal-cash">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">KAS KELUAR/MASUK</h4>
                <button type="button" class="close close-modal-cash">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="frmclosepos" class="form-horizontal">
                <div class="modal-body">
                    <div id="view_close_balance" class="form-group">
                        <label for="close_balance" class="col-sm-12">Jenis</label>
                        <div class="col-sm-12">
                            <select id="cash_type" class="form-control">
                                <option value="IN">Kas Masuk</option>
                                <option value="OUT" selected>Kas Keluar</option>
                            </select>
                        </div>
                    </div>

                    <div id="view_close_balance" class="form-group">
                        <label for="close_balance" class="col-sm-12">Saldo</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="cash_balance" name="cash_balance" placeholder="Saldo Akhir" value="100,000.00" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="session_remark" class="col-sm-12">Catatan</label>
                        <div class="col-sm-12">
                            <textarea id="session_remark" name="session_remark" class="form-control" placeholder="Catatan" data-parsley-maxlength="500" rows="3">Setor ke Kabag</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button class="btn btn-danger close-modal-cash"><i class="fas fa-times-circle"></i> Batal</button>
                    <button id="btnsave_cash" class="btn btn-success close-modal-cash"><i class="fas fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<!-- /.content -->
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    $(document).ready(function() {
        const config_tblsales = {
            paging: true,
            pageLength: 10,
            autoWidth: true,
            select: true,
            responsive: true,
            order: [
                [0, 'desc']
            ],
            "language": {
                "url": lang_datatables,
            },
            "columnDefs": [{
                    width: 70,
                    targets: 4
                },
                {
                    targets: [4],
                    orderable: false,
                    searchable: false,
                },

                {
                    targets: [3],
                    className: "text-right",
                }
            ]
        };

        let open_balance = new AutoNumeric('#open_balance', configRp);
        let close_balance = new AutoNumeric('#close_balance', configRp);

        let tblsales = $('#tblsales').DataTable(config_tblsales);
        let tblsalesreturn = $('#tblsalesreturn').DataTable(config_tblsales);

        $('#btnadd_sales').click(function(e) {
            e.preventDefault();
            window.location.href = '<?= base_url('pos/sales') ?>';
        })

        $('#btnadd_salesreturn').click(function(e) {
            e.preventDefault();
            window.location.href = '<?= base_url('pos/sales-return') ?>';
        })

        $('#btnsalesrecap').click(function(e) {
            e.preventDefault();
            window.location.href = '<?= base_url('pos/view-sales-recap') ?>';
        })

        $('#btnopenpos').click(function(e) {
            e.preventDefault();
            open_balance.set(0);
            $('#modal-openpos').modal('show');
        })

        $('#btnsave_openpos').click(function(e) {
            e.preventDefault();
            $('#modal-openpos').modal('hide');
            $('#btnopenpos').hide();
            $('#btnclosepos').show();
            $('#btncashin').prop('disabled', false);
            $('#btncashout').prop('disabled', false);
        })

        $('#btnclosepos').click(function(e) {
            e.preventDefault();
            close_balance.set(203400);
            $('#modal-closepos').modal('show');
        })

        $('#btnsave_closepos').click(function(e) {
            e.preventDefault();
            $('#modal-closepos').modal('hide');
            $('#btnopenpos').show();
            $('#btnclosepos').hide();
            $('#btncashin').prop('disabled', true);
            $('#btncashout').prop('disabled', true);
        })

        $('#btncashin, #btncashout').click(function(e) {
            e.preventDefault();
            $('#modal-cash').modal('show');
        })

        $('.close-modal-cash').click(function(e) {
            e.preventDefault();
            $('#modal-cash').modal('hide');
        })

        $('.close-modal-closepos').click(function(e) {
            e.preventDefault();
            $('#modal-closepos').modal('hide');
        })

        $('.close-modal-openpos').click(function(e) {
            e.preventDefault();
            $('#modal-openpos').modal('hide');
        })

        $('#btnopenpos').show();
        $('#btnclosepos').hide();

        $('#btncashin').prop('disabled', true);
        $('#btncashout').prop('disabled', true);
    })
</script>
<?= $this->endSection() ?>