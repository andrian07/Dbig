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
                <h1>Password Control Logs</h1>
            </div>
            <div class="col-sm-6">

            </div>
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
                        <button id="btnreload" class="btn btn-secondary"><i class="fas fa-sync"></i> Reload</button>

                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-sm-2">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Dari Tanggal:</label>
                                    <input id="date_from" name="date_from" type="date" class="form-control" value="<?= date('Y-m') ?>-01">
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Sampai Tanggal:</label>
                                    <input id="date_until" name="date_until" type="date" class="form-control" value="<?= date('Y-m-d') ?>">
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Permintaan Dari:</label>
                                    <select id="request_user_id" name="request_user_id" class="form-control select_user"></select>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Pemberi Izin:</label>
                                    <select id="user_id" name="user_id" class="form-control select_user"></select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Toko:</label>
                                    <select id="store_id" name="store_id" class="form-control">
                                        <option value="1">UTM - UTAMA</option>
                                        <option value="2">KBR - CABANG KOTA BARU</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <table id="tblpasswordcontrollogs" class="table table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th data-priority="1">#</th>
                                    <th data-priority="4">DateTime</th>
                                    <th data-priority="3">Log</th>
                                    <th data-priority="5">Permintaan Dari </th>
                                    <th data-priority="6">Pemberi Izin</th>
                                    <th data-priority="2">Toko</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>
                                        <?= indo_short_date('2022-08-01 08:00:00', true, '<br/>') ?>
                                    </td>
                                    <td>Tutup Kas</td>
                                    <td>Ani</td>
                                    <td>Budi</td>
                                    <td>PUSAT</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>
                                        <?= indo_short_date('2022-08-01 09:00:00', true, '<br/>') ?>
                                    </td>
                                    <td>Pemberian diskon "1234567899999 - Toto Gantungan Double Robe Hook (TX04AES)" senilai Rp208,130.00 (10.00%) dari harga produk Rp2,081,300.00 menjadi Rp1,873,200.00</td>
                                    <td>Ani</td>
                                    <td>Budi</td>
                                    <td>PUSAT</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>
                                        <?= indo_short_date('2022-08-09 09:00:00', true, '<br/>') ?>
                                    </td>
                                    <td>Ubah Harga Jual "1234567899999 - Toto Gantungan Double Robe Hook (TX04AES)" dari Rp2,081,300.00 menjadi Rp2,000,000.00</td>
                                    <td>Ani</td>
                                    <td>Budi</td>
                                    <td>PUSAT</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>
                                        <?= indo_short_date('2022-08-09 09:00:00', true, '<br/>') ?>
                                    </td>
                                    <td>Cancel penjualan SI/UTM/22/08/000001</td>
                                    <td>Ani</td>
                                    <td>Budi</td>
                                    <td>PUSAT</td>
                                </tr>

                                <tr>
                                    <td>5</td>
                                    <td>
                                        <?= indo_short_date('2022-08-09 09:00:00', true, '<br/>') ?>
                                    </td>
                                    <td>Cancel retur penjualan SR/UTM/22/08/000001</td>
                                    <td>Ani</td>
                                    <td>Budi</td>
                                    <td>PUSAT</td>
                                </tr>

                                <tr>
                                    <td>6</td>
                                    <td>
                                        <?= indo_short_date('2022-08-09 09:00:00', true, '<br/>') ?>
                                    </td>
                                    <td>Cetak Ulang Invoice SI/UTM/22/08/000010</td>
                                    <td>Ani</td>
                                    <td>Budi</td>
                                    <td>PUSAT</td>
                                </tr>

                                <tr>
                                    <td>7</td>
                                    <td>
                                        <?= indo_short_date('2022-08-15 09:00:00', true, '<br/>') ?>
                                    </td>
                                    <td>
                                        Mengubah golongan produk "P000002 - Toto Floor Drain (TX1DA)" dari BKP menjadi NON BKP
                                    </td>
                                    <td>Joko</td>
                                    <td>Reza</td>
                                    <td>CABANG KOTA BARU</td>
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
<!-- /.content -->
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    $(document).ready(function() {
        $('.select_user').select2({
            data: [{
                    id: '1',
                    text: 'Ani'
                },
                {
                    id: '2',
                    text: 'Joko'
                },
                {
                    id: '3',
                    text: 'Budi'
                },

            ]
        })

        // datatables //
        let tblpasswordcontrollogs = $("#tblpasswordcontrollogs").DataTable({
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
                    targets: [0, 2],
                    orderable: false,
                    searchable: false,
                },
                {
                    targets: [1],
                    width: "100"
                },
                {
                    targets: [2],
                    width: "500"
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

    })
</script>
<?= $this->endSection() ?>