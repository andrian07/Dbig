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
                <h1>Satuan</h1>
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
                        <table id="tblcategory" class="table table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th data-priority="1">#</th>
                                    <th data-priority="2">Nama Satuan</th>
                                    <th data-priority="4">Deskripsi</th>
                                    <th data-priority="3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>DUS</td>
                                    <td></td>
                                    <td>
                                        <button class="btn btn-sm btn-warning btnedit" data-toggle="tooltip" data-placement="top" data-title="Edit"><i class="fas fa-edit"></i></button>&nbsp;
                                        <button class="btn btn-sm btn-danger btndelete" data-toggle="tooltip" data-placement="top" data-title="Hapus"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>LUSIN</td>
                                    <td>12 PCS</td>
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

            <div class="modal fade" id="modal-category">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="title-frmcategory"></h4>
                            <button type="button" class="close close-modal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="frmcategory" class="form-horizontal">
                            <div class="modal-body">
                                <input id="category_id" name="category_id" value="" type="hidden">
                                <div class="form-group">
                                    <label for="category_name" class="col-sm-12">Nama Satuan</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="category_name" name="category_name" placeholder="Nama Satuan" value="" data-parsley-maxlength="200" data-parsley-trigger-after-failure="focusout" data-parsley-vcategoryname required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="category_description" class="col-sm-12">Deskripsi</label>
                                    <div class="col-sm-12">
                                        <textarea id="category_description" name="category_description" class="form-control" placeholder="Deskripsi" data-parsley-maxlength="500" rows="3"></textarea>
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
        let tblcategory = $("#tblcategory").DataTable({
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
                _initButton();
            },
            columnDefs: [{
                    width: 100,
                    targets: 3
                },
                {
                    targets: [0, 3],
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
            let form = $('#frmcategory');
            $('#title-frmcategory').html('Tambah Satuan');
            form[0].reset();
            form.parsley().reset();
            formMode = 'add';
            $('#category_id').val('0');
            $('#category_name').val('');
            $('#category_description').val('');
            $('#modal-category').modal(configModal);
        }

        function editMode(data) {
            let form = $('#frmcategory');
            $('#title-frmcategory').html('Ubah Satuan');
            form[0].reset();
            form.parsley().reset();
            formMode = 'edit';
            $('#category_id').val('1');
            $('#category_name').val('LUSIN');
            $('#category_description').val('12 PCS');
            $('#modal-category').modal(configModal);
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
                    $('#modal-category').modal('hide');
                }
            })
        })


        $('#btnsave').click(function(e) {
            e.preventDefault();
            $('#modal-category').modal('hide');
        })

        $("#tblcategory").on('click', '.btnedit', function(e) {
            e.preventDefault();
            editMode({
                a: 1
            });

        })

        $("#tblcategory").on('click', '.btndelete', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let category_name = $(this).attr('data-name');
            let question = 'Yakin ingin menghapus satuan <b>LUSIN</b>?';

            message.question(question).then(function(answer) {
                let yes = parseMessageResult(answer);
                if (yes) {
                    notification.success('Satuan telah dihapus');
                }
            })
        })

        _initButton();

    })
</script>
<?= $this->endSection() ?>