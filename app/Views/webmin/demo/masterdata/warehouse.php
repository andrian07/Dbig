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
                <h1>Gudang</h1>
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
                        <table id="tblwarehouse" class="table table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th data-priority="1">#</th>
                                    <th data-priority="2">Kode Gudang</th>
                                    <th data-priority="4">Toko</th>
                                    <th data-priority="5">Nama Gudang</th>
                                    <th data-priority="6">Alamat</th>
                                    <th data-priority="3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>UTM</td>
                                    <td>PUSAT</td>
                                    <td>PUSAT</td>
                                    <td>
                                        Jalan Sungai Raya Dalam 1. Ruko Ceria No. A2 - A4
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning btnedit" data-toggle="tooltip" data-placement="top" data-title="Edit"><i class="fas fa-edit"></i></button>&nbsp;
                                        <button class="btn btn-sm btn-danger btndelete" data-toggle="tooltip" data-placement="top" data-title="Hapus"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>KNY</td>
                                    <td>PUSAT</td>
                                    <td>KONSINYASI</td>
                                    <td>
                                        Jalan Sungai Raya Dalam 1. Ruko Ceria No. A2 - A4
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning btnedit" data-toggle="tooltip" data-placement="top" data-title="Edit"><i class="fas fa-edit"></i></button>&nbsp;
                                        <button class="btn btn-sm btn-danger btndelete" data-toggle="tooltip" data-placement="top" data-title="Hapus"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>KBR</td>
                                    <td>CABANG KOTA BARU</td>
                                    <td>KOTA BARU</td>
                                    <td>
                                        Jalan Prof. M. Yamin No 5, Perempatan Jalan Ampera
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

            <div class="modal fade" id="modal-warehouse">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="title-frmwarehouse"></h4>
                            <button type="button" class="close close-modal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="frmwarehouse" class="form-horizontal">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="warehouse_code" class="col-sm-12">Kode Gudang</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="warehouse_code" name="warehouse_code" placeholder="Kode Gudang" value="" data-parsley-maxlength="200" data-parsley-trigger-after-failure="focusout" data-parsley-vcategoryname required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="warehouse_name" class="col-sm-12">Nama Gudang</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="warehouse_name" name="warehouse_name" placeholder="Nama Gudang" value="" data-parsley-maxlength="200" data-parsley-trigger-after-failure="focusout" data-parsley-vcategoryname required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="warehouse_address" class="col-sm-12">Alamat</label>
                                    <div class="col-sm-12">
                                        <textarea id="warehouse_address" name="warehouse_address" class="form-control" placeholder="Alamat" data-parsley-maxlength="500" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="store_id" class="col-sm-12">Toko</label>
                                    <div class="col-sm-12">
                                        <select id="store_id" name="store_id" class="form-control">
                                            <option value="1">UTM - UTAMA</option>
                                            <option value="2">KBR - CABANG KOTA BARU</option>
                                        </select>
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
        let tblwarehouse = $("#tblwarehouse").DataTable({
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
            let form = $('#frmwarehouse');
            $('#title-frmwarehouse').html('Tambah Gudang');
            //form[0].reset();
            form.parsley().reset();
            formMode = 'add';
            $('#warehouse_code').val('');
            $('#warehouse_name').val('');
            $('#warehouse_address').val('');
            $('#store_id').val('1');
            $('#modal-warehouse').modal(configModal);
        }

        function editMode(data) {
            let form = $('#frmwarehouse');
            $('#title-frmwarehouse').html('Ubah Gudang');
            //form[0].reset();
            form.parsley().reset();
            formMode = 'edit';
            $('#warehouse_code').val('KBR');
            $('#warehouse_name').val('KOTA BARU');
            $('#warehouse_address').val('Jalan Prof. M. Yamin No 5, Perempatan Jalan Ampera');
            $('#store_id').val('2');
            $('#modal-warehouse').modal(configModal);
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
                    $('#modal-warehouse').modal('hide');
                }
            })
        })


        $('#btnsave').click(function(e) {
            e.preventDefault();
            $('#modal-category').modal('hide');
        })

        $("#tblwarehouse").on('click', '.btnedit', function(e) {
            e.preventDefault();
            editMode({
                a: 1
            });

        })

        $("#tblwarehouse").on('click', '.btndelete', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let question = 'Yakin ingin menghapus gudang <b>KBR - KOTA BARU</b>?';

            message.question(question).then(function(answer) {
                let yes = parseMessageResult(answer);
                if (yes) {
                    notification.success('Gudang <b>KBR - KOTA BARU</b> telah dihapus');
                }
            })
        })


    })
</script>
<?= $this->endSection() ?>