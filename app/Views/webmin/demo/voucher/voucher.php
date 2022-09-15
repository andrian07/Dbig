<?php
$themeUrl = base_url('assets/adminlte3');
$assetsUrl = base_url('assets');
?>

<?= $this->extend('webmin/template/admin_template') ?>

<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Voucher</h1>
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
            <div id="list_voucher" class="col-md-12">
                <div class="card">
                    <div class="card-header p-2">
                        <button id="btnadd" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah</button>
                        <button id="btnreload" class="btn btn-secondary"><i class="fas fa-sync"></i> Reload</button>
                        <!--
                        <button id="btnexchange" class="btn btn-default"><i class="fas fa-exchange-alt"></i> Penukaran Poin</button>
                        -->
                    </div>
                    <div class="card-body">

                        <table id="tblvoucher" class="table table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th data-priority="1">#</th>
                                    <th data-priority="2">Nama Voucher</th>
                                    <th data-priority="4">Keterangan</th>
                                    <th data-priority="5">Nominal Voucher</th>
                                    <th data-priority="6">Jlh. Voucher</th>
                                    <th data-priority="7">Exp. Date</th>
                                    <th data-priority="3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Diskon 20RB</td>
                                    <td>Promo Diskon 20,000 untuk Pembelian merk.Toto</td>
                                    <td>Rp 20,000.00</td>
                                    <td>3</td>
                                    <td>20/09/2022</td>
                                    <td>
                                        <button class="btn btn-sm btn-success btnexportexcel mb-2" data-toggle="tooltip" data-placement="top" data-title="Ekspor ke Excel"><i class="fas fa-file-excel"></i></button>&nbsp;
                                        <button class="btn btn-sm btn-default btnmanagevoucher mb-2" data-toggle="tooltip" data-placement="top" data-title="Pengaturan Voucher"><i class="fas fa-ticket-alt"></i></button>
                                        <br>
                                        <button class="btn btn-sm btn-warning btnedit" data-toggle="tooltip" data-placement="top" data-title="Edit"><i class="fas fa-edit"></i></button>&nbsp;
                                        <button class="btn btn-sm btn-danger btndelete" data-toggle="tooltip" data-placement="top" data-title="Hapus"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Diskon 10RB</td>
                                    <td>Promo Diskon 10,000</td>
                                    <td>Rp 10,000.00</td>
                                    <td>0</td>
                                    <td>10/09/2022</td>
                                    <td>
                                        <button class="btn btn-sm btn-success btnexportexcel mb-2" data-toggle="tooltip" data-placement="top" data-title="Ekspor ke Excel"><i class="fas fa-file-excel"></i></button>&nbsp;
                                        <button class="btn btn-sm btn-default btnmanagevoucher mb-2" data-toggle="tooltip" data-placement="top" data-title="Pengaturan Voucher"><i class="fas fa-ticket-alt"></i></button>
                                        <br>
                                        <button class="btn btn-sm btn-warning btnedit" data-toggle="tooltip" data-placement="top" data-title="Edit"><i class="fas fa-edit"></i></button>&nbsp;
                                        <button class="btn btn-sm btn-danger btndelete" data-toggle="tooltip" data-placement="top" data-title="Hapus"><i class="fas fa-trash"></i></button>
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

            <div id="input_voucher" class="col-md-12">
                <div class="card">
                    <div class="card-header p-2">
                        <h4>Pengaturan Voucher</h4>
                    </div>
                    <div class="card-body">
                        <table width="100%" class="border-primary border-bottom mb-3">
                            <tr>
                                <th width="15%">Nama Voucher</th>
                                <td width="1%">:</td>
                                <td width="84%">Diskon 20RB</td>
                            </tr>
                            <tr>
                                <th>Nominal Voucher</th>
                                <td>:</td>
                                <td>Rp 20,000.00</td>
                            </tr>
                            <tr>
                                <th>Keterangan Voucher</th>
                                <td>:</td>
                                <td>Promo Diskon 20,000 untuk Pembelian merk.Toto</td>
                            </tr>
                            <tr>
                                <th>Exp.Date</th>
                                <td>:</td>
                                <td>20/09/2022</td>
                            </tr>
                        </table>

                        <form id="frmgenerate" class="mb-2">
                            <div class="row">
                                <div class="col-md-2">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Jumlah Voucher</label>
                                        <input id="voucher_count" name="voucher_count" type="text" class="form-control text-right" value="0" required>
                                    </div>
                                </div>
                                <div class="col-md-3 ">
                                    <!-- text input -->
                                    <label>&nbsp;</label>
                                    <div class="form-group">
                                        <div class="col-12">
                                            <button id="btngenerate" class="btn btn-md btn-primary"><i class="fas fa-plus"></i> Generate Voucher</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <table id="tblmanagevoucher" class="table table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th data-priority="1">#</th>
                                    <th data-priority="2">Kode Voucher</th>
                                    <th data-priority="4">Status</th>
                                    <th data-priority="5">Digunakan Pada</th>
                                    <th data-priority="6">Oleh Customer</th>
                                    <th data-priority="3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>0000100001</td>
                                    <td>
                                        <span class="badge badge-primary">Belum Digunakan</span>
                                    </td>
                                    <td>
                                        -
                                    </td>
                                    <td>-</td>
                                    <td>
                                        <button class="btn btn-sm btn-danger btndelete" data-toggle="tooltip" data-placement="top" data-title="Hapus"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>0000100002</td>
                                    <td>
                                        <span class="badge badge-success">Sudah Digunakan</span>
                                    </td>
                                    <td>
                                        01/09/2022 10:00:00
                                    </td>
                                    <td>Ricky Acinda</td>
                                    <td>
                                        <button class="btn btn-sm btn-danger btndelete" data-toggle="tooltip" data-placement="top" data-title="Hapus"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>0000100003</td>
                                    <td>
                                        <span class="badge badge-danger">Exp</span>
                                    </td>
                                    <td>
                                        -
                                    </td>
                                    <td>
                                        -
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-danger btndelete" data-toggle="tooltip" data-placement="top" data-title="Hapus"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- /.tab-content -->


                        <div class="justify-content-between mt-2">
                            <button class="btn btn-danger close-manage-voucher"><i class="fas fa-arrow-circle-left"></i> Kembali</button>
                            <button class="btn btn-success close-manage-voucher float-right"><i class="fas fa-save"></i> Simpan</button>

                        </div>
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>

            <div class="modal fade" id="modal-voucher">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="title-frmvoucher"></h4>
                            <button type="button" class="close close-modal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="frmvoucher" class="form-horizontal">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="voucher_name" class="col-sm-12">Nama Voucher</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="voucher_name" name="voucher_name" placeholder="Nama Voucher" value="" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="voucher_value" class="col-sm-12">Nilai Voucher</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="voucher_value" name="voucher_value" placeholder="Nilai Voucher" value="" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="voucher_remark" class="col-sm-12">Keterangan</label>
                                    <div class="col-sm-12">
                                        <textarea id="voucher_remark" name="voucher_remark" class="form-control" placeholder="Keterangan" data-parsley-maxlength="500" rows="3" required></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="category_id" class="col-sm-12">Filter Kategori</label>
                                    <div class="col-sm-12 sel2">
                                        <select id="category_id" name="category_id[]" class="form-control" multiple="multiple" required></select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="brand_id" class="col-sm-12">Filter Brand</label>
                                    <div class="col-sm-12 sel2">
                                        <select id="brand_id" name="brand_id[]" class="form-control" multiple="multiple" required></select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="voucher_exp_date" class="col-sm-12">Exp. Date</label>
                                    <div class="col-sm-12">
                                        <input type="date" class="form-control" id="voucher_exp_date" name="voucher_exp_date" placeholder="Exp. Date" value="" required>
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
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    $(document).ready(function() {
        let formMode = '';
        let voucher_value = new AutoNumeric('#voucher_value', configRp);
        let voucher_count = new AutoNumeric('#voucher_count', configQty);


        function showInput(x) {
            if (x) {
                $('#list_voucher').hide();
                $('#input_voucher').show();
            } else {
                $('#list_voucher').show();
                $('#input_voucher').hide();
            }
        }

        // datatables //
        let tblvoucher = $("#tblvoucher").DataTable({
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
                    width: 100,
                    targets: 6
                },
                {
                    targets: [0, 6],
                    orderable: false,
                    searchable: false,
                },
                {
                    targets: [0, 3, 4],
                    className: "text-right",
                },
            ],
        });

        let tblmanagevoucher = $("#tblmanagevoucher").DataTable({
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
                    targets: 5
                },
                {
                    targets: [0, 5],
                    orderable: false,
                    searchable: false,
                },
                {
                    targets: [0],
                    className: "text-right",
                },
            ],
        });

        $('#btnreload').click(function(e) {
            e.preventDefault();
        })

        $('#category_id').select2({
            data: [{
                    id: '1',
                    text: 'Floor Drain'
                },
                {
                    id: '2',
                    text: 'Gantungan'
                },
            ]
        })

        $('#brand_id').select2({
            data: [{
                    id: '1',
                    text: 'Toto'
                },
                {
                    id: '2',
                    text: 'Philips'
                },
            ]
        })

        function addMode() {
            let form = $('#frmvoucher');
            $('#title-frmvoucher').html('Tambah Voucher');
            //form[0].reset();
            form.parsley().reset();
            formMode = 'add';

            $('#voucher_name').val('');
            voucher_value.set(0);
            $('#voucher_remark').val('');
            $('#voucher_exp_date').val('');
            $('#modal-voucher').modal(configModal);
        }

        function editMode(data) {
            let form = $('#frmvoucher');
            $('#title-frmvoucher').html('Ubah Voucher');
            //form[0].reset();
            form.parsley().reset();
            formMode = 'add';

            $('#voucher_name').val('Diskon 20RB');
            voucher_value.set(20000);
            $('#voucher_remark').val('Promo Diskon 20,000 untuk Pembelian merk.Toto');
            let selectOption = [{
                id: '1',
                label: 'Toto'
            }]
            setSelect2('#brand_id', selectOption);
            setSelect2('#category_id');
            $('#voucher_exp_date').val('2022-09-20');
            $('#modal-voucher').modal(configModal);
        }

        $('#btnadd').click(function(e) {
            e.preventDefault();
            addMode();
        })

        $('.close-modal').click(function(e) {
            e.preventDefault();
            message.question('Yakin ingin menutup halaman ini?').then(function(answer) {
                let yes = parseMessageResult(answer);
                if (yes) {
                    $('#modal-voucher').modal('hide');
                }
            })
        })


        $('#btnsave').click(function(e) {
            e.preventDefault();
            $('#modal-voucher').modal('hide');
        })

        $("#tblvoucher").on('click', '.btnedit', function(e) {
            e.preventDefault();
            editMode({
                a: 1
            });

        })

        $("#tblvoucher").on('click', '.btndelete', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let customer_name = $(this).attr('data-name');
            let question = 'Yakin ingin menghapus voucher <b>Diskon 20RB</b>?';
            let actUrl = base_url + '/customer/delete/' + id;
            message.question(question).then(function(answer) {
                let yes = parseMessageResult(answer);
                if (yes) {
                    notification.success('Voucher <b>Diskon 20RB</b> telah dihapus');
                }
            })
        })

        $("#tblvoucher").on('click', '.btnmanagevoucher', function(e) {
            e.preventDefault();
            showInput(true);
        })

        $("#tblvoucher").on('click', '.btnexportexcel', function(e) {
            e.preventDefault();
            let uri = base_url + '/demo/sample_export_voucher.xlsx';
            window.open(uri, '_blank');
        })

        $('.close-manage-voucher').click(function(e) {
            e.preventDefault();
            showInput(false);
        })

        voucher_count.set(1);

        $('#btngenerate').click(function(e) {
            e.preventDefault();
            notification.success('10 Voucher telah digenerate');
        })

        $("#tblmanagevoucher").on('click', '.btndelete', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let customer_name = $(this).attr('data-name');
            let question = 'Yakin ingin menghapus voucher dengan kode <b>0000100001</b>?';
            let actUrl = base_url + '/customer/delete/' + id;
            message.question(question).then(function(answer) {
                let yes = parseMessageResult(answer);
                if (yes) {
                    notification.success('Voucher <b>0000100001</b> telah dihapus');
                }
            })
        })

        showInput(false);
    })
</script>
<?= $this->endSection() ?>