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
                <h1>Mapping Area</h1>
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
                        <div class="row">
                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Provinsi</label>
                                    <select id="fiter_prov_id" name="filter_customer_group" class="form-control">
                                        <option value="1">KALIMANTAN BARAT</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Kota/Kabupaten</label>
                                    <select id="filter_city_id" name="filter_city_id" class="form-control">

                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Kecamatan</label>
                                    <select id="filter_dis_id" name="filter_dis_id" class="form-control">

                                    </select>
                                </div>
                            </div>


                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Kelurahan</label>
                                    <select id="filter_subdis_id" name="filter_subdis_id" class="form-control">

                                    </select>
                                </div>
                            </div>



                        </div>

                        <table id="tblmappingarea" class="table table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th data-priority="1">#</th>
                                    <th data-priority="3">Provinsi</th>
                                    <th data-priority="4">Kota/Kabubaten</th>
                                    <th data-priority="5">Kecamatan</th>
                                    <th data-priority="6">Kelurahan</th>
                                    <th data-priority="7">Kode Pos</th>
                                    <th data-priority="2">Nama Jalan</th>
                                    <th data-priority="3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>KALIMANTAN BARAT</td>
                                    <td>PONTIANAK</td>
                                    <td>PONTIANAK KOTA</td>
                                    <td>TENGAH</td>
                                    <td>78111</td>
                                    <td>JL GAJAH MADA</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning btnedit" data-toggle="tooltip" data-placement="top" data-title="Edit"><i class="fas fa-edit"></i></button>&nbsp;
                                        <button class="btn btn-sm btn-danger btndelete" data-toggle="tooltip" data-placement="top" data-title="Hapus"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>KALIMANTAN BARAT</td>
                                    <td>PONTIANAK</td>
                                    <td>PONTIANAK KOTA</td>
                                    <td>MARIANA</td>
                                    <td>78112</td>
                                    <td>JL ABC</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning btnedit" data-toggle="tooltip" data-placement="top" data-title="Edit"><i class="fas fa-edit"></i></button>&nbsp;
                                        <button class="btn btn-sm btn-danger btndelete" data-toggle="tooltip" data-placement="top" data-title="Hapus"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>KALIMANTAN BARAT</td>
                                    <td>PONTIANAK</td>
                                    <td>PONTIANAK KOTA</td>
                                    <td>MARIANA</td>
                                    <td>78112</td>
                                    <td>JL XYZ</td>
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

            <div class="modal fade" id="modal-mappingarea">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="title-frmmappingarea">Ubah Area</h4>
                            <button type="button" class="close close-modal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="frmmappingarea" class="form-horizontal">
                            <div class="modal-body">
                                <input id="mapping_id" name="customer_id" value="0" type="hidden">
                                <div class="form-group">
                                    <label for="prov_id" class="col-sm-12">Provinsi</label>
                                    <div class="col-sm-12 sel2">
                                        <select class="form-control" id="prov_id" name="prov_id" required>
                                            <option value="1" selected>KALIMANTAN BARAT</option>
                                            <option value="2">KALIMANTAN TENGAH</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="city_id" class="col-sm-12">Kota/Kabupaten</label>
                                    <div class="col-sm-12 sel2">
                                        <select class="form-control" id="city_id" name="city_id" required>
                                            <option value="1" selected>PONTIANAK</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="dis_id" class="col-sm-12">Kecamatan</label>
                                    <div class="col-sm-12 sel2">
                                        <select class="form-control" id="dis_id" name="dis_id" required>
                                            <option value="1" selected>PONTIANAK KOTA</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="dis_id" class="col-sm-12">Kelurahan</label>
                                    <div class="col-sm-12 sel2">
                                        <select class="form-control" id="subdis_id" name="subdis_id" required>
                                            <option value="1" selected>TENGAH</option>
                                            <option value="2">MARIANA</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="postal_code" class="col-sm-12">Kode Pos</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="postal_code" name="postal_code" placeholder="Kode Pos" data-parsley-pattern="^[0-9]+$" data-parsley-minlength="5" data-parsley-maxlength="5" value="78111" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="mapping_address" class="col-sm-12">Nama Jalan</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="mapping_address" name="mapping_address" placeholder="Nama Jalan" value="JL GAJAH MADA" data-parsley-maxlength="200" required>
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
        let tblmappingarea = $("#tblmappingarea").DataTable({
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
                    targets: 7
                },
                {
                    targets: [0, 7],
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

        $('#btnexchange').click(function(e) {
            e.preventDefault();
            let actUrl = base_url + '/customer/view-point-exchange';
            window.location.href = actUrl;
        })



        function addMode() {
            // let form = $('#frmcustomer');
            // $('#title-frmcustomer').html('Tambah Customer');
            // form[0].reset();
            // form.parsley().reset();
            // formMode = 'add';
            // $('#customer_id').val('0');
            // $('#customer_name').val('');
            // $('#customer_phone').val('');
            // $('#customer_address').val('');
            // $('#customer_email').val('');
            // $('#customer_group').val('G1');
            // $('#customer_exp_date').val('');
            $('#modal-mappingarea').modal(configModal);
        }

        function editMode(data) {
            //let form = $('#frmcustomer');
            //$('#title-frmcustomer').html('Ubah Customer');
            //form[0].reset();
            //form.parsley().reset();
            //formMode = 'edit';
            //$('#customer_id').val('1');
            //$('#customer_name').val('Ricky Acinda');
            //$('#customer_phone').val('089688885656');
            //$('#customer_address').val('Jl.Gajah Mada GG.XYZ No 10');
            //$('#customer_email').val('ricky@gmail.com');
            //$('#customer_group').val('G4');
            //$('#customer_exp_date').val('2022-12-31');
            $('#modal-mappingarea').modal(configModal);
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
                    $('#modal-mappingarea').modal('hide');
                }
            })
        })


        $('#btnsave').click(function(e) {
            e.preventDefault();
            $('#modal-customer').modal('hide');
        })

        $("#tblmappingarea").on('click', '.btnedit', function(e) {
            e.preventDefault();
            editMode({
                a: 1
            });

        })

        $("#tblmappingarea").on('click', '.btndelete', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let customer_name = $(this).attr('data-name');
            let question = 'Yakin ingin menghapus area <b>KALIMANTAN BARAT/PONTIANAK/PONTIANAK KOTA/TENGAH/JL GAJAH MADA</b>?';
            let actUrl = base_url + '/customer/delete/' + id;
            message.question(question).then(function(answer) {
                let yes = parseMessageResult(answer);
                if (yes) {
                    notification.success('Area KALIMANTAN BARAT/PONTIANAK/PONTIANAK KOTA/TENGAH/JL GAJAH MADA telah dihapus');
                }
            })
        })





        _initButton();

    })
</script>
<?= $this->endSection() ?>