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
            <!-- /.col -->
            <div class="col-md-4 order-md-2">
                <div class="card">
                    <div class="card-body">
                        <div class="row"></div>
                        <form>
                            <div class="row">
                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Customer</label>
                                        <select id="customer_id" name="customer_id" class="form-control">
                                            <option value="1" selected>Samsul (0896-7899-8899)</option>
                                            <option value="2">Udin (0896-7899-5555)</option>
                                            <option value="3">Ricky Acinda (0896-8888-5656)</option>
                                            <option value="4">PT Aneka Jaya (0896-7899-8899)</option>
                                        </select>
                                    </div>
                                </div>
                                <table class="table" width="100%">
                                    <tr>
                                        <th width="30%">Nama</th>
                                        <td width="70%" class="text-right" id="customer_name">Samsul</td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Grup</th>
                                        <td width="70%" class="text-right" id="customer_group">
                                            <span class="badge badge-light">Member Silver</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Alamat</th>
                                        <td width="70%" class="text-right" id="customer_address">
                                            Jl.Sui raya km 8.5 no 25
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">No Telp</th>
                                        <td width="70%" class="text-right" id="customer_phone">
                                            0896-7899-8899
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Email</th>
                                        <td width="70%" class="text-right" id="customer_email">
                                            samsul.sanjaya22@gmail.com
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width=" 30%">Poin</th>
                                        <td width="70%" class="text-right">
                                            <b id="customer_point">
                                                100.00
                                            </b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Exp.Date</th>
                                        <td width="70%" class="text-right" id="customer_exp_date">
                                            15/10/2022
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </form>
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>

            <div class="col-md-8 order-md-1">
                <div class="card">
                    <div class="card-body">
                        <form id="frmexchange" class="mb-2">
                            <div class="row">
                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Nama Item</label>
                                        <input id="exchange_item" name="exchange_item" type="text" class="form-control pos-input" placeholder="Ketikkan nama item" value="" maxlength="200" required>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Poin</label>
                                        <input id="exchange_point" name="exchange_point" type="text" class="form-control text-right pos-input" value="0" data-parsley-vmaxpoint readonly required>
                                    </div>
                                </div>
                                <div class="col-sm-3">
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

                        <div class="border-top border-primary">&nbsp;</div>
                        <div class="row mb-1">
                            <div class="col-12">
                                <table id="tblexchangepointlist" class="table table-bordered table-hover" width="100%">
                                    <thead>
                                        <tr>
                                            <th data-priority="1">#</th>
                                            <th data-priority="3">Tanggal Penukaran</th>
                                            <th data-priority="2">Nama Item</th>
                                            <th data-priority="4">Poin</th>
                                            <th data-priority="5">User</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>01/08/2022</td>
                                            <td>Kopin Mangkok Vegetable Bowl 9″ Kukuruyuk (KPQ-9VB)</td>
                                            <td>50</td>
                                            <td>System</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>21/08/2022</td>
                                            <td>Kopin Mangkok Vegetable Bowl 9″ Kukuruyuk (KPQ-9VB)</td>
                                            <td>50</td>
                                            <td>Reza</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="clearfix"></div>
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
                    width: 100,
                    targets: [1, 4]
                },
                {
                    width: 50,
                    targets: 3
                },
                {
                    targets: [0, 2, 3],
                    orderable: false,
                    searchable: false,
                },
                {
                    targets: [0],
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
            let form = $('#frmexchange');
            let btnSubmit = $('#btnexchange');
            form.parsley().validate();
            if (form.parsley().isValid()) {
                let exPoint = parseFloat(exchange_point.getNumericString());
                let question = 'Yakin ingin menukarankan poin customer sebesar <b>' + numberFormat(exPoint, true) + '</b> poin?';
                let actUrl = base_url + '/customer/point-exchange';

                message.question(question).then(function(answer) {
                    let yes = parseMessageResult(answer);
                    if (yes) {
                        let formValues = {
                            customer_id: $('#customer_id').val(),
                            exchange_point: exPoint,
                            exchange_item: $('#exchange_item').val()
                        };
                        btnSubmit.prop('disabled', true);
                        ajax_post(actUrl, formValues, {
                            success: function(response) {
                                if (response.success) {
                                    if (response.result.success) {
                                        notification.success(response.result.message);
                                        let data = response.result.data;
                                        customer_point = parseFloat(data.customer_point);
                                        $('#customer_point').html(numberFormat(customer_point, true));
                                        clearForm();
                                    } else {
                                        message.error(response.result.message);
                                    }
                                }
                                btnSubmit.prop('disabled', false);
                                updateTable();
                            },
                            error: function(response) {
                                btnSubmit.prop('disabled', false);
                                updateTable();
                            }
                        });
                    }

                })

            }
        })

        clearForm();
    })
</script>
<?= $this->endSection() ?>