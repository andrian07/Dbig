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
                <h1>Supplier</h1>
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
                    </div>
                    <div class="card-body">
                        <table id="tblsupplier" class="table table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th data-priority="1">#</th>
                                    <th data-priority="2">Kode Supplier</th>
                                    <th data-priority="4">Nama Supplier</th>
                                    <th data-priority="5">Alamat</th>
                                    <th data-priority="6">No Telp</th>
                                    <th data-priority="3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>NPPI</td>
                                    <td>PT NIPPON INDONESIA</td>
                                    <td>
                                        Jl Sungai Raya Dalam Komplek ABC No.10
                                    </td>
                                    <td>0896-0899-0888</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning btnedit" data-toggle="tooltip" data-placement="top" data-title="Edit"><i class="fas fa-edit"></i></button>&nbsp;
                                        <button class="btn btn-sm btn-danger btndelete" data-toggle="tooltip" data-placement="top" data-title="Hapus"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>IKAD</td>
                                    <td>PT IKAD INDONESIA</td>
                                    <td>
                                        Jl Sungai Raya Dalam Komplek ABC No.10
                                    </td>
                                    <td>
                                        (600) 8999 0888
                                    </td>
                                    <td>
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

            <div class="modal fade" id="modal-supplier">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="title-frmsupplier"></h4>
                            <button type="button" class="close close-modal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="frmsupplier" class="form-horizontal">
                            <div class="modal-body">
                                <input id="supplier_id" name="supplier_id" value="0" type="hidden">
                                <div class="form-group">
                                    <label for="supplier_name" class="col-sm-12">Kode Supplier</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="supplier_code" name="supplier_code" placeholder="Kode Supplier" value="" data-parsley-maxlength="200" data-parsley-trigger-after-failure="focusout" data-parsley-vsuppliername required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="supplier_name" class="col-sm-12">Nama Supplier</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="supplier_name" name="supplier_name" placeholder="Nama Supplier" value="" data-parsley-maxlength="200" data-parsley-trigger-after-failure="focusout" data-parsley-vsuppliername required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="supplier_address" class="col-sm-12">Alamat</label>
                                    <div class="col-sm-12">
                                        <textarea id="supplier_address" name="supplier_address" class="form-control" placeholder="Alamat" data-parsley-maxlength="500" rows="3" required></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="supplier_phone" class="col-sm-12">No Telp</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="supplier_phone" name="supplier_phone" placeholder="No Telp" value="" data-parsley-pattern="^[0-9+ ]+$" data-parsley-minlength="8" data-parsley-maxlength="15" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="supplier_npwp" class="col-sm-12">NPWP</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="supplier_npwp" name="supplier_npwp" placeholder="NPWP Supplier" value="" data-parsley-maxlength="200" data-parsley-trigger-after-failure="focusout">
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

        // datatables //
        let tblsupplier = $("#tblsupplier").DataTable({
            select: true,
            responsive: true,
            fixedColumns: true,
            order: [
                [1, 'asc']
            ],
            language: {
                url: lang_datatables,
            },

            drawCallback: function(settings) {
                _initTooltip();
            },
            columnDefs: [{
                    width: 100,
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

        // crud  //


        function addMode() {
            let form = $('#frmsupplier');
            $('#title-frmsupplier').html('Tambah Supplier');
            form[0].reset();
            form.parsley().reset();
            formMode = 'add';
            $('#supplier_id').val('1');
            $('#supplier_code').val('');
            $('#supplier_name').val('');
            $('#supplier_address').val('');
            $('#supplier_phone').val('');
            $('#modal-supplier').modal(configModal);
        }

        function editMode(data) {
            let form = $('#frmsupplier');
            $('#title-frmsupplier').html('Ubah Supplier');
            form[0].reset();
            form.parsley().reset();
            formMode = 'add';
            $('#supplier_id').val('1');
            $('#supplier_code').val('IKAD');
            $('#supplier_name').val('PT IKAD INDONESIA');
            $('#supplier_address').val('Jl Sungai Raya Dalam Komplek ABC No.10');
            $('#supplier_phone').val('60089990888');
            $('#modal-supplier').modal(configModal);
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
                    $('#modal-supplier').modal('hide');
                }
            })
        })


        $('#btnsave').click(function(e) {
            e.preventDefault();
            $('#modal-supplier').modal('hide');
        })

        $("#tblsupplier").on('click', '.btnedit', function(e) {
            e.preventDefault();
            editMode({
                a: 1
            });

        })

        $("#tblsupplier").on('click', '.btndelete', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let question = 'Yakin ingin menghapus supplier <b>PT IKAD INDONESIA</b>?';

            message.question(question).then(function(answer) {
                let yes = parseMessageResult(answer);
                if (yes) {
                    notification.success('Supplier <b>PT IKAD INDONESIA</b> telah dihapus');
                }
            })
        })


    })
</script>
<?= $this->endSection() ?>