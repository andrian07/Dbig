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
                <h1>Hadiah Poin</h1>
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
            <div id="product_list" class="col-md-12">
                <div class="card">
                    <div class="card-header p-2">
                        <button id="btnadd" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah</button>
                        <button id="btnreload" class="btn btn-secondary"><i class="fas fa-sync"></i> Reload</button>
                        <!--
                        <button id="btnexchange" class="btn btn-default"><i class="fas fa-exchange-alt"></i> Penukaran Poin</button>
                        -->
                    </div>
                    <div class="card-body">
                        <table id="tblpointreward" class="table table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th data-priority="1">#</th>
                                    <th data-priority="2">Kode Item</th>
                                    <th data-priority="4">Nama Item</th>
                                    <th data-priority="5">Point</th>
                                    <th data-priority="7">Dari Tgl</th>
                                    <th data-priority="8">Sampai Tgl</th>
                                    <th data-priority="6">Stok</th>
                                    <th data-priority="9">Aktif</th>
                                    <th data-priority="10">Gambar Produk</th>
                                    <th data-priority="3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>
                                        R2208001
                                    </td>
                                    <td>Kopin Gelas Coffee Mug Kukuruyuk (KPM-03CM)</td>
                                    <td>50.00</td>
                                    <td>01/09/2022</td>
                                    <td>30/09/2022</td>
                                    <td>15.00</td>
                                    <td>
                                        <span class="badge badge-success"><i class="fas fa-check-circle"></i></span>
                                    </td>

                                    <td>
                                        <a class="fancy_image" href="<?= base_url('assets/demo/00002732.jpg') ?>"><img src="<?= base_url('assets/demo/00002732.jpg') ?>" alt="" width="100px" height="120px" /></a>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning btnedit" data-toggle="tooltip" data-placement="top" data-title="Edit"><i class="fas fa-edit"></i></button>&nbsp;
                                        <button class="btn btn-sm btn-danger btndelete" data-toggle="tooltip" data-placement="top" data-title="Hapus"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>
                                        R2208002
                                    </td>
                                    <td>Kopin Mangkok Vegetable Bowl 9″ Kukuruyuk (KPQ-9VB)</td>
                                    <td>50.00</td>
                                    <td>01/09/2022</td>
                                    <td>10/09/2022</td>
                                    <td>10.00</td>
                                    <td>
                                        <span class="badge badge-danger"><i class="fas fa-times-circle"></i></span>
                                    </td>

                                    <td>
                                        <a class="fancy_image" href="<?= base_url('assets/demo/00002738.jpg') ?>"><img src="<?= base_url('assets/demo/00002738.jpg') ?>" alt="" width="100px" height="120px" /></a>
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
        </div>
        <!-- /.row -->

        <div class="modal fade" id="modal-reward">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="title-frmreward"></h4>
                        <button type="button" class="close close-modal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="frmreward" class="form-horizontal">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <img id="image_reward" src="<?= base_url('assets/images/no-image.PNG') ?>" width="100%" height="200px">
                                    <button class="btn btn-primary btn-block mt-2"><i class="fas fa-cloud-upload-alt"></i> Unggah Gambar</button>
                                </div>
                                <div class="col-md-9">
                                    <input id="reward_id" name="reward_id" value="0" type="hidden">

                                    <div class="form-group">
                                        <label for="reward_name" class="col-sm-12">Nama Item</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="reward_name" name="reward_name" placeholder="Nama Item" value="" data-parsley-maxlength="200" data-parsley-trigger-after-failure="focusout" data-parsley-vproductname required>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label for="reward_point" class="col-sm-12">Poin</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="reward_point" name="reward_point" placeholder="Poin" value="" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="start_date" class="col-sm-12">Dari Tgl</label>
                                        <div class="col-sm-12">
                                            <input type="date" class="form-control" id="start_date" name="start_date" placeholder="Dari Tgl" value="" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="end_date" class="col-sm-12">Sampai Tgl</label>
                                        <div class="col-sm-12">
                                            <input type="date" class="form-control" id="end_date" name="end_date" placeholder="Sampai Tgl" value="" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="reward_stock" class="col-sm-12">Stok</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="reward_stock" name="reward_stock" placeholder="Stok" value="" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="active" class="col-sm-12">Status</label>
                                        <div class="col-sm-12">
                                            <select id="active" name="active" class="form-control">
                                                <option value="Y" selected>Aktif</option>
                                                <option value="N">Tidak Aktif</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="reward_description" class="col-sm-12">Deskripsi</label>
                                        <div class="col-sm-12">
                                            <textarea id="reward_description" name="reward_description" class="form-control" rows="10"></textarea>
                                        </div>
                                    </div>


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

    </div><!-- /.container-fluid -->
</section>





<!-- /.content -->
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    $(document).ready(function() {
        let formMode = '';
        $("a.fancy_image").fancybox();

        let reward_point = new AutoNumeric('#reward_point', configQty);
        let reward_stock = new AutoNumeric('#reward_stock', configQty);

        // datatables //
        let tblpointreward = $("#tblpointreward").DataTable({
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
                    targets: 9
                },
                {
                    targets: [0, 9],
                    orderable: false,
                    searchable: false,
                },
                {
                    targets: [7, 8],
                    className: "text-center",
                },
                {
                    targets: [0, 6, 3],
                    className: "text-right",
                },
            ],
        });

        $('#btnreload').click(function(e) {
            e.preventDefault();
        })

        function addMode() {
            let form = $('#frmreward');
            $('#title-frmreward').html('Tambah Hadiah');
            form.parsley().reset();
            formMode = 'add';
            let imgSrc = base_url + '/assets/images/no-image.PNG'
            $('#image_reward').attr('src', imgSrc);
            $('#reward_id').val('0');
            $('#reward_name').val('');
            $('#active').val('Y');
            $('#start_date').val('');
            $('#end_date').val('');
            $('#reward_description').val('');
            reward_point.set(0);
            reward_stock.set(0);
            $('#modal-reward').modal(configModal);
        }

        function editMode(data) {
            let form = $('#frmreward');
            $('#title-frmreward').html('Ubah Hadiah');
            form.parsley().reset();
            formMode = 'add';
            let imgSrc = base_url + '/assets/demo/00002738.jpg'
            $('#image_reward').attr('src', imgSrc);
            $('#reward_id').val('0');
            $('#reward_name').val('Kopin Mangkok Vegetable Bowl 9″ Kukuruyuk (KPQ-9VB)');
            $('#active').val('N');
            $('#start_date').val('2022-09-01');
            $('#end_date').val('2022-09-10');
            $('#reward_description').val('');
            reward_point.set(50);
            reward_stock.set(10);
            $('#modal-reward').modal(configModal);
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
                    $('#modal-reward').modal('hide');
                }
            })
        })

        $('#btnsave').click(function(e) {
            e.preventDefault();
            $('#modal-reward').modal('hide');
        })

        $("#tblpointreward").on('click', '.btnedit', function(e) {
            e.preventDefault();
            editMode({
                a: 1
            });

        })

        $("#tblpointreward").on('click', '.btndelete', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let customer_name = $(this).attr('data-name');
            let question = 'Yakin ingin menghapus hadiah <b>R2208002 - Kopin Mangkok Vegetable Bowl 9″ Kukuruyuk (KPQ-9VB)</b>?';
            let actUrl = base_url + '/customer/delete/' + id;
            message.question(question).then(function(answer) {
                let yes = parseMessageResult(answer);
                if (yes) {
                    notification.success('Hadiah R2208002 - Kopin Mangkok Vegetable Bowl 9″ Kukuruyuk (KPQ-9VB) telah dihapus');
                }
            })
        })
    })
</script>
<?= $this->endSection() ?>