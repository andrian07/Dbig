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
                <h1>Customer</h1>
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
                        <div class="btn-group">
                            <button type="button" class="btn btn-success"><i class="fas fa-file-excel"></i> Import Excel</button>
                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                                <a class="dropdown-item" href="#">Template File Excel</a>
                            </div>
                        </div>
                        <!--
                        <button id="btnexchange" class="btn btn-default"><i class="fas fa-exchange-alt"></i> Penukaran Poin</button>
                        -->
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Grup Customer</label>
                                    <select id="fiter_customer_group" name="filter_customer_group" class="form-control">
                                        <option value="all">Semua</option>
                                        <option value="G1">G1 - UMUM</option>
                                        <option value="G2">G2 - SILVER</option>
                                        <option value="G3">G3 - GOLD</option>
                                        <option value="G4">G4 - PLATINUM</option>
                                        <option value="G5">G5 - PROYEK</option>
                                        <option value="G6">G6 - CUSTOM</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <!-- text input -->
                                <div class="form-group">

                                    <div class="col-12">
                                        <label>Poin</label>
                                        <div class="row">
                                            <div class="col-4">
                                                <select id="filter_point_by" name="filter_point_by" class="form-control">
                                                    <option value="none" selected>NONE</option>
                                                    <option value="greater_than"><?= esc('>=') ?></option>
                                                    <option value="lower_than"><?= esc('<=') ?></option>
                                                </select>
                                            </div>
                                            <div class="col-8">
                                                <input id="filter_point_value" name="filter_point_value" type="number" class="form-control text-right" value="0" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <table id="tblcustomer" class="table table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th data-priority="1">#</th>
                                    <th data-priority="4">Kode Customer</th>
                                    <th data-priority="2">Nama Customer</th>
                                    <th data-priority="5">Alamat</th>
                                    <th data-priority="5">No Telp</th>
                                    <th data-priority="5">Grup Customer</th>
                                    <th data-priority="7">Poin</th>
                                    <th data-priority="8">Exp. Date</th>
                                    <th data-priority="3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>0000000001</td>
                                    <td>Samsul</td>
                                    <td>Jl.Sui raya km 8.5 no 25</td>
                                    <td>0896-7899-8899</td>
                                    <td>
                                        <span class="badge badge-light">Member Silver</span>
                                    </td>
                                    <td>
                                        100
                                    </td>
                                    <td>
                                        15/10/2022
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-default btndetail mb-2" data-toggle="tooltip" data-placement="top" data-title="Detail"><i class="fas fa-eye"></i></button>&nbsp;
                                        <button class="btn btn-sm btn-default btnresetpassword mb-2" data-toggle="tooltip" data-placement="top" data-title="Reset Kata Sandi"><i class="fas fa-key"></i></button>
                                        <br>
                                        <button class="btn btn-sm btn-warning btnedit" data-toggle="tooltip" data-placement="top" data-title="Edit"><i class="fas fa-edit"></i></button>&nbsp;
                                        <button class="btn btn-sm btn-danger btndelete" data-toggle="tooltip" data-placement="top" data-title="Hapus"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>0000000002</td>
                                    <td>Udin</td>
                                    <td>
                                        Jl.Sui raya km 8.5 no 39<br>
                                        (Sebelah Smk Immanuel II)
                                    </td>
                                    <td>0896-7899-5555</td>
                                    <td>
                                        <span class="badge badge-warning">Member Gold</span>
                                    </td>
                                    <td>
                                        0
                                    </td>
                                    <td>
                                        31/10/2022
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-default btndetail mb-2" data-toggle="tooltip" data-placement="top" data-title="Detail"><i class="fas fa-eye"></i></button>&nbsp;
                                        <button class="btn btn-sm btn-default btnresetpassword mb-2" data-toggle="tooltip" data-placement="top" data-title="Reset Kata Sandi"><i class="fas fa-key"></i></button>
                                        <br>
                                        <button class="btn btn-sm btn-warning btnedit" data-toggle="tooltip" data-placement="top" data-title="Edit"><i class="fas fa-edit"></i></button>&nbsp;
                                        <button class="btn btn-sm btn-danger btndelete" data-toggle="tooltip" data-placement="top" data-title="Hapus"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>0000000003</td>
                                    <td>Ricky Acinda</td>
                                    <td>
                                        Jl.Gajah Mada GG.XYZ No 10
                                    </td>
                                    <td>0896-8888-5656</td>
                                    <td>
                                        <span class="badge badge-secondary">Member Platinum</span>
                                    </td>
                                    <td>
                                        0
                                    </td>
                                    <td>
                                        31/12/2022
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-default btndetail mb-2" data-toggle="tooltip" data-placement="top" data-title="Detail"><i class="fas fa-eye"></i></button>&nbsp;
                                        <button class="btn btn-sm btn-default btnresetpassword mb-2" data-toggle="tooltip" data-placement="top" data-title="Reset Kata Sandi"><i class="fas fa-key"></i></button>
                                        <br>
                                        <button class="btn btn-sm btn-warning btnedit" data-toggle="tooltip" data-placement="top" data-title="Edit"><i class="fas fa-edit"></i></button>&nbsp;
                                        <button class="btn btn-sm btn-danger btndelete" data-toggle="tooltip" data-placement="top" data-title="Hapus"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>0000000004</td>
                                    <td>PT Aneka Jaya</td>
                                    <td>
                                        Jl.Gajah Mada No.5
                                    </td>
                                    <td>0896-7899-8899</td>
                                    <td>
                                        <span class="badge badge-primary">Proyek</span>
                                    </td>
                                    <td>
                                        100
                                    </td>
                                    <td>
                                        31/12/2022
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-default btndetail mb-2" data-toggle="tooltip" data-placement="top" data-title="Detail"><i class="fas fa-eye"></i></button>&nbsp;
                                        <button class="btn btn-sm btn-default btnresetpassword mb-2" data-toggle="tooltip" data-placement="top" data-title="Reset Kata Sandi"><i class="fas fa-key"></i></button>
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
                                    <label for="customer_name" class="col-sm-12">Nama Customer</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Nama Customer" value="" data-parsley-maxlength="200" data-parsley-trigger-after-failure="focusout" data-parsley-vcustomername required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="customer_address" class="col-sm-12">Alamat</label>
                                    <div class="col-sm-12">
                                        <textarea id="customer_address" name="customer_address" class="form-control" placeholder="Alamat" data-parsley-maxlength="500" rows="3" required></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="customer_phone" class="col-sm-12">No Telp</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="customer_phone" name="customer_phone" placeholder="No Telp" value="" data-parsley-pattern="^[0-9+ ]+$" data-parsley-minlength="8" data-parsley-maxlength="15" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="customer_email" class="col-sm-12">Email</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="customer_email" name="customer_email" placeholder="Email" value="" data-parsley-maxlength="200" required>
                                    </div>
                                </div>





                                <div class="form-group">
                                    <label for="customer_group" class="col-sm-12">Grup</label>
                                    <div class="col-sm-12">
                                        <select id="customer_group" name="customer_group" class="form-control">
                                            <option value="G1">G1 - UMUM</option>
                                            <option value="G2">G2 - SILVER</option>
                                            <option value="G3">G3 - GOLD</option>
                                            <option value="G4">G4 - PLATINUM</option>
                                            <option value="G5">G5 - PROYEK</option>
                                            <option value="G6">G6 - CUSTOM</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="mapping_id" class="col-sm-12">Mapping Area</label>
                                    <div class="col-sm-12">
                                        <select id="mapping_id" name="mapping_id" class="form-control">
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="customer_exp_date" class="col-sm-12">Exp. Date</label>
                                    <div class="col-sm-12">
                                        <input type="date" class="form-control" id="customer_exp_date" name="customer_exp_date" placeholder="Exp. Date" value="" data-parsley-maxlength="200" required>
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

        // datatables //
        let tblcustomer = $("#tblcustomer").DataTable({
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
                    targets: 8
                },
                {
                    targets: [0, 8],
                    orderable: false,
                    searchable: false,
                },
                {
                    targets: [5],
                    className: "text-center",
                },
                {
                    targets: [0, 6],
                    className: "text-right",
                },
            ],
        });

        $('#btnreload').click(function(e) {
            e.preventDefault();
        })

        $('#btnexchange').click(function(e) {
            e.preventDefault();
            let actUrl = base_url + '/customer/view-point-exchange';
            window.location.href = actUrl;
        })

        const mapData = [{
                id: 1,
                text: "JL GAJAH MADA",
                address: "KALIMANTAN BARAT"
            },
            {
                id: 2,
                text: "JL ABC",
                address: "KALIMANTAN BARAT"
            },
            {
                id: 3,
                text: "JL XYZ",
                address: "KALIMANTAN BARAT"
            }
        ]

        $('#mapping_id').select2({
            data: mapData,
        });



        function addMode() {
            let form = $('#frmcustomer');
            $('#title-frmcustomer').html('Tambah Customer');
            form[0].reset();
            form.parsley().reset();
            formMode = 'add';
            $('#customer_id').val('0');
            $('#customer_name').val('');
            $('#customer_phone').val('');
            $('#customer_address').val('');
            $('#customer_email').val('');
            $('#customer_group').val('G1');
            $('#customer_exp_date').val('');
            $('#modal-customer').modal(configModal);
        }

        function editMode(data) {
            let form = $('#frmcustomer');
            $('#title-frmcustomer').html('Ubah Customer');
            form[0].reset();
            form.parsley().reset();
            formMode = 'edit';
            $('#customer_id').val('1');
            $('#customer_name').val('Ricky Acinda');
            $('#customer_phone').val('089688885656');
            $('#customer_address').val('Jl.Gajah Mada GG.XYZ No 10');
            $('#customer_email').val('ricky@gmail.com');
            $('#customer_group').val('G4');
            $('#customer_exp_date').val('2022-12-31');
            $('#modal-customer').modal(configModal);
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
                    $('#modal-customer').modal('hide');
                }
            })
        })


        $('#btnsave').click(function(e) {
            e.preventDefault();
            $('#modal-customer').modal('hide');
        })

        $("#tblcustomer").on('click', '.btnedit', function(e) {
            e.preventDefault();
            editMode({
                a: 1
            });

        })

        $("#tblcustomer").on('click', '.btndelete', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let customer_name = $(this).attr('data-name');
            let question = 'Yakin ingin menghapus customer <b>Ricky Acinda</b>?';
            let actUrl = base_url + '/customer/delete/' + id;
            message.question(question).then(function(answer) {
                let yes = parseMessageResult(answer);
                if (yes) {
                    notification.success('Customer Ricky Acinda telah dihapus');
                }
            })
        })


        $("#tblcustomer").on('click', '.btnresetpassword', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let customer_name = $(this).attr('data-name');
            let question = 'Yakin ingin melakukan reset password <b>Ricky Acinda</b>?';
            let actUrl = base_url + '/customer/delete/' + id;
            message.question(question).then(function(answer) {
                let yes = parseMessageResult(answer);
                if (yes) {
                    message.success('Password <b>Ricky Acinda</b> adalah <b>1AS4562SA</b>');
                }
            })
        })


        $('#tblcustomer').on('click', '.btndetail', function(e) {
            e.preventDefault();
            message.success('Coming Soon');
        })

        _initButton();

    })
</script>
<?= $this->endSection() ?>