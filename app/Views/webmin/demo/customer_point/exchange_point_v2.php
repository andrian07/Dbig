<?php
$themeUrl = base_url('assets/adminlte3');
$assetsUrl = base_url('assets');
?>

<?= $this->extend('webmin/template/admin_template') ?>

<?= $this->section('content') ?>


<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Penukaran Poin</h1>
            </div>
            <div class="col-sm-6"></div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">


            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="custom-content-above-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-content-above-exchange-tab" data-toggle="pill" href="#custom-content-above-exchange" role="tab" aria-controls="custom-content-above-exchange" aria-selected="true">Tukar Poin</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-content-above-history-tab" data-toggle="pill" href="#custom-content-above-history" role="tab" aria-controls="custom-content-above-history" aria-selected="false">Histori Poin</a>
                            </li>

                        </ul>
                        <div class="tab-custom-content border-bottom border-primary">
                            <form>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Customer &nbsp; <span class="badge badge-light">Member Silver</span></label>
                                            <select id="customer_id" name="customer_id" class="form-control pos-input">
                                                <option value="1" selected>Samsul (0896-7899-8899)</option>
                                                <option value="2">Udin (0896-7899-5555)</option>
                                                <option value="3">Ricky Acinda (0896-8888-5656)</option>
                                                <option value="4">PT Aneka Jaya (0896-7899-8899)</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Poin</label>
                                            <input type="text" id="" class="form-control text-right" value="100.00" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Alamat</label>
                                            <input type="text" id="" class="form-control" value="Jl.Sui raya km 8.5 no 25" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Exp.Date</label>
                                            <input type="text" id="" class="form-control" value="15/10/2022" readonly>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-content" id="custom-content-above-tabContent">
                            <div class="tab-pane fade show active" id="custom-content-above-exchange" role="tabpanel" aria-labelledby="custom-content-above-exchange-tab">
                                <!-- exchange -->

                                <form id="frmexchange" class="mb-2">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <!-- text input -->
                                            <div class="form-group">
                                                <label>Nama Item</label>
                                                <input id="exchange_item" name="exchange_item" type="text" class="form-control pos-input" placeholder="Ketikkan nama item" value="" maxlength="200" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <!-- text input -->
                                            <div class="form-group">
                                                <label>Poin</label>
                                                <input id="exchange_point" name="exchange_point" type="text" class="form-control text-right pos-input" value="0" data-parsley-vmaxpoint readonly required>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <!-- text input -->
                                            <label>&nbsp;</label>
                                            <div class="form-group">
                                                <div class="col-12">
                                                    <button id="btnexchange" class="btn btn-md btn-primary btn-block"><i class="fas fa-exchange-alt"></i> Tukar Poin</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <div class="border-top border-default">&nbsp;</div>
                                <div class="row mb-1">
                                    <div class="col-12">
                                        <table id="tblexchangepointlist" class="table table-bordered table-hover" width="100%">
                                            <thead>
                                                <tr>
                                                    <th data-priority="1">#</th>
                                                    <th data-priority="4">Tanggal Penukaran</th>
                                                    <th data-priority="2">Nama Item</th>
                                                    <th data-priority="5">Poin</th>
                                                    <th data-priority="6">User</th>
                                                    <th data-priority="7">Status</th>
                                                    <th data-priority="3">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>01/08/2022</td>
                                                    <td>Kopin Mangkok Vegetable Bowl 9″ Kukuruyuk (KPQ-9VB)</td>
                                                    <td>50</td>
                                                    <td>Reza</td>
                                                    <td>
                                                        <span class="badge badge-success">Selesai</span>
                                                    </td>
                                                    <td>
                                                        <a href="javascript:;" data-fancybox data-type="iframe" data-src="<?= base_url('webmin/exchange-point/detail') ?>" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" data-title="Detail"><i class="fas fa-eye"></i></a>&nbsp;
                                                        <button class="btn btn-sm btn-danger btncancel" data-toggle="tooltip" data-placement="top" data-title="Batal" disabled><i class="fas fa-times"></i></button>&nbsp;
                                                        <button class="btn btn-sm btn-success btncomplete" data-toggle="tooltip" data-placement="top" data-title="Selesai" disabled><i class="fas fa-check"></i></button>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>21/08/2022</td>
                                                    <td>Kopin Mangkok Vegetable Bowl 9″ Kukuruyuk (KPQ-9VB)</td>
                                                    <td>50</td>
                                                    <td>System</td>
                                                    <td>
                                                        <span class="badge badge-danger">Batal</span>
                                                    </td>
                                                    <td>
                                                        <a href="javascript:;" data-fancybox data-type="iframe" data-src="<?= base_url('webmin/exchange-point/detail') ?>" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" data-title="Detail"><i class="fas fa-eye"></i></a>&nbsp;

                                                        <button class="btn btn-sm btn-danger btncancel" data-toggle="tooltip" data-placement="top" data-title="Batal" disabled><i class="fas fa-times"></i></button>&nbsp;
                                                        <button class="btn btn-sm btn-success btncomplete" data-toggle="tooltip" data-placement="top" data-title="Selesai" disabled><i class="fas fa-check"></i></button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>30/08/2022</td>
                                                    <td>Kopin Mangkok Vegetable Bowl 9″ Kukuruyuk (KPQ-9VB)</td>
                                                    <td>50</td>
                                                    <td>System</td>
                                                    <td>
                                                        <span class="badge badge-primary">Proses</span>
                                                    </td>
                                                    <td>
                                                        <a href="javascript:;" data-fancybox data-type="iframe" data-src="<?= base_url('webmin/exchange-point/detail') ?>" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" data-title="Detail"><i class="fas fa-eye"></i></a>&nbsp;
                                                        <button class="btn btn-sm btn-danger btncancel" data-toggle="tooltip" data-placement="top" data-title="Batal"><i class="fas fa-times"></i></button>&nbsp;
                                                        <button class="btn btn-sm btn-success btncomplete" data-toggle="tooltip" data-placement="top" data-title="Selesai"><i class="fas fa-check"></i></button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>

                            </div>

                            <div class="tab-pane fade" id="custom-content-above-history" role="tabpanel" aria-labelledby="custom-content-above-history-tab">
                                <!-- history -->
                                <div class="row mb-1">
                                    <div class="col-12">
                                        <table id="tblhistorypoint" class="table table-bordered table-hover" width="100%">
                                            <thead>
                                                <tr>
                                                    <th data-priority="1">#</th>
                                                    <th data-priority="2">Tanggal</th>
                                                    <th data-priority="4">Keterangan</th>
                                                    <th data-priority="3">Poin</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>01/08/2022</td>
                                                    <td>Belanja Rp150,000.00</td>
                                                    <td><span class="text-success">+150<span></td>
                                                </tr>

                                                <tr>
                                                    <td>2</td>
                                                    <td>01/08/2022</td>
                                                    <td>Tukar Kopin Mangkok Vegetable Bowl 9″ Kukuruyuk (KPQ-9VB)</td>
                                                    <td><span class="text-danger">-50<span></td>
                                                </tr>

                                            </tbody>
                                        </table>
                                        <div class="clearfix"></div>
                                    </div>
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



<!-- /.content -->
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    $(document).ready(function() {
        let customer_point = 100;
        let exchange_point = new AutoNumeric('#exchange_point', configPoint);

        Parsley.addMessages('id', {
            vmaxpoint: 'Poin tidak cukup',
        });

        Parsley.setLocale('id');

        window.Parsley.addValidator("vmaxpoint", {
            validateString: function(value) {
                let ep = parseFloat(exchange_point.getNumericString());
                if (ep > customer_point) {
                    return false;
                } else {
                    return true;
                }
            },
        });


        $('#customer_id').select2();


        let tblexchangepointlist = $("#tblexchangepointlist").DataTable({
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
                    width: 30,
                    targets: 0
                },
                {
                    width: 120,
                    targets: 6
                },
                {
                    width: 100,
                    targets: [1, 4]
                },
                {
                    width: 50,
                    targets: 3
                },
                {
                    targets: [0, 2, 6],
                    orderable: false,
                    searchable: false,
                },
                {
                    targets: [0, 3],
                    className: "text-right",
                },
                {
                    targets: [5],
                    className: "text-center",
                },
            ],
        });


        let tblhistorypoint = $("#tblhistorypoint").DataTable({
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
                    width: 30,
                    targets: 0
                },
                {
                    width: 100,
                    targets: [1, 3]
                },
                {
                    targets: [0, 2, 3],
                    orderable: false,
                    searchable: false,
                },
                {
                    targets: [0, 3],
                    className: "text-right",
                },
            ],
        });




        function clearForm() {
            let form = $('#frmexchange');
            form.parsley().reset();
            exchange_point.set(1);
            $('#exchange_item').val('').focus();
        }

        $('#btnexchange').click(function(e) {
            e.preventDefault();
            message.info('Penukaran poin berhasil');
        })

        $("#tblexchangepointlist").on('click', '.btncancel', function(e) {
            e.preventDefault();
            let question = 'Yakin ingin membatalkan penukaran poin <b>30/08/2022 - Kopin Mangkok Vegetable Bowl 9″ Kukuruyuk (KPQ-9VB)</b>?';
            //let actUrl = base_url + '/customer/delete/' + id;
            message.question(question).then(function(answer) {
                let yes = parseMessageResult(answer);
                if (yes) {
                    notification.success('Penukaran poin 30/08/2022 - Kopin Mangkok Vegetable Bowl 9″ Kukuruyuk (KPQ-9VB) telah dibatalkan');
                }
            })
        })

        $("#tblexchangepointlist").on('click', '.btncomplete', function(e) {
            e.preventDefault();
            let question = 'Yakin ingin menyelesaikan penukaran poin <b>30/08/2022 - Kopin Mangkok Vegetable Bowl 9″ Kukuruyuk (KPQ-9VB)</b>?';
            //let actUrl = base_url + '/customer/delete/' + id;
            message.question(question).then(function(answer) {
                let yes = parseMessageResult(answer);
                if (yes) {
                    notification.success('Penukaran poin 30/08/2022 - Kopin Mangkok Vegetable Bowl 9″ Kukuruyuk (KPQ-9VB) telah diselesaikan');
                }
            })
        })

    })
</script>
<?= $this->endSection() ?>