<?php
$themeUrl = base_url('assets/adminlte3');
$assetsUrl = base_url('assets');
?>

<?= $this->extend('webmin/template/admin_template') ?>


<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<div id="repayment_list">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Pelunasan Piutang</h1>
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
                            <button id="btnreload" class="btn btn-secondary"><i class="fas fa-sync"></i> Reload</button>
                        </div>
                        <div class="card-body">

                            <ul class="nav nav-tabs" id="custom-content-above-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-content-above-exchange-tab" data-toggle="pill" href="#custom-content-above-exchange" role="tab" aria-controls="custom-content-above-exchange" aria-selected="true">Daftar Piutang</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-content-above-history-tab" data-toggle="pill" href="#custom-content-above-history" role="tab" aria-controls="custom-content-above-history" aria-selected="false">Histori Pelunasan Piutang</a>
                                </li>

                            </ul>
                            <div class="tab-content" id="custom-content-above-tabContent">
                                <div class="tab-pane fade show active" id="custom-content-above-exchange" role="tabpanel" aria-labelledby="custom-content-above-exchange-tab">
                                    <!-- exchange -->
                                    <div class="row mb-1 pt-2">
                                        <div class="col-12">
                                            <table id="tblreceivablerepayment" class="table table-bordered table-hover" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th data-priority="1">#</th>
                                                        <th data-priority="2">Kode Customer</th>
                                                        <th data-priority="3">Nama Customer</th>
                                                        <th data-priority="4">Alamat</th>
                                                        <th data-priority="5">No Telp</th>
                                                        <th data-priority="6">Jumlah Nota</th>
                                                        <th data-priority="7">Total Piutang</th>
                                                        <th data-priority="8">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>

                                <div class="tab-pane fade" id="custom-content-above-history" role="tabpanel" aria-labelledby="custom-content-above-history-tab">
                                    <!-- history -->
                                    <div class="row mb-1 pt-2">
                                        <div class="col-12">
                                            <table id="tblreceivablerepaymenthistory" class="table table-bordered table-hover" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th data-priority="1">#</th>
                                                        <th data-priority="2">No Transaksi</th>
                                                        <th data-priority="3">Nama Customer</th>
                                                        <th data-priority="4">Tanggal Pembayaran</th>
                                                        <th data-priority="5">Metode Pembayaran</th>
                                                        <th data-priority="6">Jumlah Nota</th>
                                                        <th data-priority="7">Total Pembayaran</th>
                                                        <th data-priority="8">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>




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
</div>

<div id="repayment_input">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 id="title">Pelunasan Piutang</h1>
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
                        <div class="card-body">
                            <form id="frmpurchase">
                                <div class="row">
                                    <div class="col-sm-12 col-md-3">
                                        <input type="hidden" id="customer_id" name="customer_id" value="">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Nama Customer</label>
                                            <input id="customer_name" name="customer_name" type="text" class="form-control" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-2">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Tanggal Pembayaran</label>
                                            <input id="repayment_date" name="repayment_date" type="date" class="form-control" value="<?= date('Y-m-d') ?>">
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Metode Pembayaran</label>
                                            <select id="payment_method_id" name="payment_method_id" class="form-control"></select>
                                        </div>
                                    </div>


                                    <div class="col-sm-12 col-md-2">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>User</label>
                                            <input id="display_user" type="text" class="form-control" value="<?= $user['user_realname'] ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-2">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Total Piutang</label>
                                            <input id="customer_total_debt" name="customer_total_debt" type="text" class="form-control text-right" value="0" readonly>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->


        <div class="container-fluid">
            <div class="row">
                <!-- /.col -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form id="frmrepayment" class="mb-2">
                                <div class="row">
                                    <input id="temp_key" name="temp_key" type="hidden" value="">
                                    <input id="sales_admin_id" name="sales_admin_id" type="hidden" value="">

                                    <div class="col-sm-12 col-md-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>No Invoice</label>
                                            <input id="sales_admin_invoice" name="sales_admin_invoice" type="text" class="form-control" placeholder="No Invoice" value="" readonly>
                                        </div>
                                    </div>


                                    <div class="col-sm-12 col-md-2">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Tanggal Invoice</label>
                                            <input id="sales_admin_date" name="sales_admin_date" type="date" class="form-control" placeholder="Tanggal Invoice" value="" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-2">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Jatuh Tempo</label>
                                            <input id="due_date" name="due_date" type="date" class="form-control" placeholder="Tanggal Jatuh Tempo" value="" readonly>
                                        </div>
                                    </div>



                                    <div class="col-sm-12 col-md-5">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Keterangan</label>
                                            <input id="repayment_remark" name="repayment_remark" type="text" class="form-control" value="" max-length="500">
                                        </div>
                                    </div>



                                    <div class="col-sm-12 col-md-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Saldo Piutang</label>
                                            <input id="remaining_receivable" name="remaining_receivable" type="text" class="form-control text-right" value="0" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-2">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Pembayaran</label>
                                            <input id="repayment_total" name="repayment_total" type="text" class="form-control text-right" value="0" data-parsley-vrepaymenttotal required>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-2">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Pembulatan/Disc</label>
                                            <input id="repayment_disc" name="repayment_disc" type="text" class="form-control text-right" value="0" required>
                                        </div>
                                    </div>

                                    

                                    <div class="col-sm-12 col-md-4">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Sisa Piutang</label>
                                            <input id="new_remaining_receivable" name="new_remaining_receivable" type="text" class="form-control text-right" data-parsley-vnewdebt value="0" readonly>
                                        </div>
                                    </div>


                                    <div class="col-sm-1">
                                        <!-- text input -->
                                        <label>&nbsp;</label>
                                        <div class="form-group">
                                            <div class="col-12">
                                                <button id="btnadd_temp" class="btn btn-md btn-primary rounded-circle float-right"><i class="fas fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="row mb-2">
                                <div class="col-12">
                                    <table id="tbltemp" class="table table-bordered table-hover" width="100%">
                                        <thead>
                                            <tr>
                                                <th data-priority="1">#</th>
                                                <th data-priority="2">No Invoice</th>
                                                <th data-priority="3">Tanggal Invoice</th>
                                                <th data-priority="4">Jatuh Tempo</th>
                                                <th data-priority="5">Saldo Piutang</th>
                                                <th data-priority="6">Pembulatan/Disc</th>
                                                <th data-priority="7">Pembayaran</th>
                                                <th data-priority="8">Sisa Piutang</th>
                                                <th data-priority="9">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>

                                    <template id="template_row_temp">

                                        <tr>

                                           <td>{row}</td>

                                           <td>{sales_admin_invoice}</td>

                                           <td>{sales_date}</td>

                                           <td>{due_date}</td>

                                           <td>{sales_admin_remaining_payment}</td>

                                           <td>{temp_payment_receivable_discount}</td>

                                           <td>{temp_payment_receivable_nominal}</td>

                                           <td>{temp_payment_remaining}</td>

                                           <td>

                                               <button data-id="{temp_id}" data-json="{data_json}" class="btn btn-sm btn-warning btnedit rounded-circle" data-toggle="tooltip" data-placement="top" data-title="Edit">

                                                   <i class="fas fa-money-bill-wave"></i>

                                               </button>

                                           </td>

                                       </tr>

                                   </template>

                               </div>
                           </div>

                           <div class="row form-space">

                            <div class="col-lg-6">

                            </div>

                            <div class="col-lg-6 text-right">

                                <div class="form-group row">
                                    <label for="footer_invoice_total" class="col-sm-7 col-form-label text-right:">Total Pembayaran:</label>
                                    <div class="col-sm-5">
                                        <input id="footer_invoice_total" name="footer_invoice_total" type="text" class="form-control text-right" value="0" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="footer_total_pay" class="col-sm-7 col-form-label text-right:">Jumlah Nota:</label>
                                    <div class="col-sm-5">
                                        <input id="footer_total_pay" name="footer_total_pay" type="text" class="form-control text-right" value="0" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <button id="btncancel" class="btn btn-danger"><i class="fas fa-times-circle"></i> Batal</button>
                                        <button id="btnsave" class="btn btn-success button-header-custom-save"><i class="fas fa-save"></i> Simpan</button>
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
</div>


<!-- /.content -->
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    $(document).ready(function() {

        function _initButton() {
            $('#btnadd').prop('disabled', !hasRole('receivable_repayment.add'));
            $('.btnedit').prop('disabled', !hasRole('receivable_repayment.edit'));
            $('.btndelete').prop('disabled', !hasRole('receivable_repayment.delete'));
        }

        let default_date = '<?= date('Y-m-d') ?>';
        let customer_id = 0;
        let remaining_receivable = new AutoNumeric('#remaining_receivable', configRp);
        let repayment_total = new AutoNumeric('#repayment_total', configRp);
        let repayment_disc = new AutoNumeric('#repayment_disc', configRp);
        let new_remaining_receivable = new AutoNumeric('#new_remaining_receivable', configRp);
        let customer_total_debt = new AutoNumeric('#customer_total_debt', configRp);
        let footer_invoice_total = new AutoNumeric('#footer_invoice_total', configRp);
        let footer_total_pay = new AutoNumeric('#footer_total_pay', configQty);


        $("#payment_method_id").select2({
            placeholder: '-- Pilih Jenis Pembayaran --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/payment-method",
                dataType: "json",
                type: "GET",
                delay: select2Delay,
                data: function(params) {
                    return {
                        search: params.term,
                    };
                },
                processResults: function(data, page) {
                    return {
                        results: data,
                    };
                },
            },
        });
        

        // datatables //

        let tblreceivablerepaymenthistory = $("#tblreceivablerepaymenthistory").DataTable({
            processing: true,
            select: true,
            serverSide: true,
            responsive: true,
            fixedColumns: true,
            order: [
            [1, 'asc']
            ],
            language: {
                url: lang_datatables,
            },
            ajax: {
                url: base_url + '/webmin/payment/tblreceivablehistory',
                type: "POST",
                error: function() {
                    notification.danger('Gagal memuat table, harap coba lagi');
                },
            },
            drawCallback: function(settings) {
                _initTooltip();
                _initButton();
            },
            columnDefs: [{
                width: 100
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

        let tblreceivablerepayment = $("#tblreceivablerepayment").DataTable({
            processing: true,
            select: true,
            serverSide: true,
            responsive: true,
            fixedColumns: true,
            order: [
            [1, 'asc']
            ],
            language: {
                url: lang_datatables,
            },
            ajax: {
                url: base_url + '/webmin/payment/tblreceivablerepayment',
                type: "POST",
                error: function() {
                    notification.danger('Gagal memuat table, harap coba lagi');
                },
            },
            drawCallback: function(settings) {
                _initTooltip();
                _initButton();
            },
            columnDefs: [{
                width: 100
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


        $('#btnadd_temp').click(function(e) {

         e.preventDefault();

         let temp_key = $("#temp_key").val();

         let sales_admin_id = $("#sales_admin_id").val();

         let customer_id = $("#customer_id").val();

         let sales_admin_invoice = $("#sales_admin_invoice").val();

         let sales_admin_date = $("#sales_admin_date").val();

         let due_date = $("#due_date").val();

         let repayment_remark = $("#repayment_remark").val();

         let repayment_total_input = parseFloat(repayment_total.getNumericString());

         let repayment_disc_input = parseFloat(repayment_disc.getNumericString());

         let new_remaining_receivable_input = parseFloat(new_remaining_receivable.getNumericString());

         let btnSubmit = $('#btnadd_temp');

         let form = $('#frmrepayment');

         form.parsley().validate();

         if (form.parsley().isValid()) {

             let actUrl = base_url + '/webmin/payment/temp-receivable-add';

             let formValues = {

                 temp_payment_receivable_id : temp_key,

                 temp_payment_receivable_sales_id : sales_admin_id,

                 temp_payment_receivable_discount: repayment_disc_input,

                 temp_payment_receivable_nominal: repayment_total_input,

                 temp_payment_receivable_desc: repayment_remark,

                 customer_id:customer_id,

             };

             btnSubmit.prop('disabled', true);

             ajax_post(actUrl, formValues, {

                 success: function(response) {

                     if (response.success) {

                         if (response.result.success) {

                             notification.success(response.result.message);

                         } else {

                             message.error(response.result.message);

                         }

                         clearItemInput();
                         loadTempData(response.result.data);

                     }

                     btnSubmit.prop('disabled', false);

                 },

                 error: function(response) {

                     btnSubmit.prop('disabled', false);

                 }
             });
         }
     })

        Parsley.addMessages('id', {

            vnewdebt: 'Sisa hutang tidak boleh minus',

            vrepaymenttotal: 'Pembayaran wajib diatas Rp 0',

        });



        Parsley.setLocale('id');


        window.Parsley.addValidator("vrepaymenttotal", {

            validateString: function(value) {

                let vrepaymenttotal = parseFloat(repayment_total.getNumericString());

                if (vrepaymenttotal <= 0) {

                    return false;

                } else {

                    return true;

                }
            },

        });


        window.Parsley.addValidator("vnewdebt", {

            validateString: function(value) {

                let vnewdebt = parseFloat(new_remaining_receivable.getNumericString());

                if (vnewdebt < 0) {

                    return false;

                } else {

                    return true;

                }

            },

        });


        $('#btnreload').click(function(e) {
            e.preventDefault();
        })

        function showInputPage(x) {
            if (x) {
                $('#repayment_list').hide();
                $('#repayment_input').show();
            } else {
                $('#repayment_input').hide();
                $('#repayment_list').show();
            }
        }

        function clearItemInput() {
            let form = $('#frmrepayment');
            form.parsley().reset();
            $('#temp_key').val('');
            $('#purchase_id').val('');
            $('#sales_admin_invoice').val('');
            $('#due_date').val('');
            $('#sales_admin_date').val('');
            $('#payment_method_id').val('');
            remaining_receivable.set(0);
            repayment_disc.set(0);
            repayment_total.set(0);
            new_remaining_receivable.set(0);
            $('#repayment_remark').val('');
        }



        $('#btncancel').click(function(e) {
            e.preventDefault();
            message.question('Yakin ingin menutup halaman ini?').then(function(answer) {
                let yes = parseMessageResult(answer);
                if (yes) {
                    showInputPage(false);
                }
            })
        })

        $('#btnsave').click(function(e) {
            e.preventDefault();

            let form = $('#frmrepayment');

            let btnSubmit = $('#btnsave');

            let payment_receivable_customer_id = $('#customer_id').val();

            let payment_receivable_method_id = $('#payment_method_id').val();

            let payment_receivable_method_name = $("#payment_method_id option:selected" ).text();

            let payment_receivable_date = $('#repayment_date').val();

            let invoice_total = parseFloat(footer_invoice_total.getNumericString());


            let question = 'Yakin ingin menyimpan data Pelunasan Piutang?';

            let actUrl = base_url + '/webmin/payment/save-receivable/add';


            if($('#payment_method_id').val() == null){
             Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Silahkan Pilih Metode Pembayaran Terlebih Dahulu !'
          })

         }else if(invoice_total <= 0){
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Total Pembayaran Tidak Boleh Kosong !'
          })

        }else{

            message.question(question).then(function(answer) {

                let yes = parseMessageResult(answer);

                if (yes) {

                    let formValues = {

                        payment_receivable_customer_id: payment_receivable_customer_id,

                        payment_receivable_total_pay: invoice_total,

                        payment_receivable_method_id: payment_receivable_method_id,

                        payment_receivable_method_name: payment_receivable_method_name,

                        payment_receivable_date:payment_receivable_date,

                    };

                    btnSubmit.prop('disabled', true);

                    ajax_post(actUrl, formValues, {

                        success: function(response) {

                            if (response.success) {

                                if (response.result.success) {

                                    form[0].reset();

                                    notification.success(response.result.message);

                                    form.parsley().reset();

                                    showInputPage(false);

                                    let invoice = response.result.purchase_order_id;



                                //let invUrl = base_url + '/webmin/purchase-order/invoice/' + invoice + '?print=Y';

                               //window.open(invUrl, '_blank');

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
    });

        function calcRepayment() {
            let rdebt = parseFloat(remaining_receivable.getNumericString());

            let rpdisc = 0;
            if (repayment_disc.getNumericString() == '') {
                repayment_disc.set(0);
            } else {
                rpdisc = parseFloat(repayment_disc.getNumericString());
            }


            let rptotal = 0;
            if (repayment_total.getNumericString() == '') {
                repayment_total.set(0);
            } else {
                rptotal = parseFloat(repayment_total.getNumericString());
            }

            let nrdebt = rdebt - (rpdisc + rptotal);
            new_remaining_receivable.set(nrdebt);
        }

        $('#repayment_disc,#repayment_total').on('keydown keypress change blur', function() {
            calcRepayment();
        })

        $('#repayment_date').on('change blur', function() {
            if ($('#repayment_date').val() == '') {
                $('#repayment_date').val(default_date);
            }
        })



        $('#tbltemp').on('click', '.btnedit', function(e) {
            e.preventDefault();
            clearItemInput();

            let json_data = $(this).attr('data-json');

            let [json, is_json, error] = parseJSON(htmlEntities.decode(json_data));

            if (is_json) {

                $('#temp_key').val(json.temp_payment_receivable_id);

                $('#sales_admin_id').val(json.temp_payment_receivable_sales_id);

                $('#sales_admin_invoice').val(json.sales_admin_invoice);

                $('#sales_admin_date').val(json.sales_date);

                $('#due_date').val(json.sales_due_date);

                repayment_total.set(json.temp_payment_debt_nominal);

                remaining_receivable.set(json.sales_admin_remaining_payment);

                //new_remaining_receivable.set(json.purchase_remaining_receivable - json.temp_payment_debt_nominal);

                $('#repayment_total').focus();

            } else {

               getTemp();

               message.error('Terjadi kesalahan dalam memproses data, harap coba lagi');

           }
       })



        function loadTempData(items) {

           let template = $('#template_row_temp').html();

           let tbody = '';

           let row = 1;

           let temp_total_order = 0;

           items.forEach((val, key) => {

               let item = template;

               let data_json = htmlEntities.encode(JSON.stringify(val));

               let temp_id  = val.temp_payment_receivable_id;

               let sales_admin_invoice = val.sales_admin_invoice ;

               let sales_date = val.sales_date;

               let due_date = val.sales_due_date;

               let sales_admin_remaining_payment = val.sales_admin_remaining_payment;

               let temp_payment_receivable_nominal  = val.temp_payment_receivable_nominal;

               let temp_payment_receivable_discount = val.temp_payment_receivable_discount;

               let temp_payment_remaining  = val.sales_admin_remaining_payment - val.temp_payment_receivable_nominal;


               item = item.replaceAll('{row}', row)

               .replaceAll('{temp_id}', temp_id)

               .replaceAll('{sales_admin_invoice}', sales_admin_invoice)

               .replaceAll('{sales_date}', sales_date)

               .replaceAll('{due_date}', due_date)

               .replaceAll('{sales_admin_remaining_payment}', numberFormat(sales_admin_remaining_payment, true))

               .replaceAll('{temp_payment_receivable_discount}', numberFormat(temp_payment_receivable_discount, true))

               .replaceAll('{temp_payment_receivable_nominal}', numberFormat(temp_payment_receivable_nominal, true))

               .replaceAll('{temp_payment_remaining}', numberFormat(temp_payment_remaining, true))

               .replaceAll('{data_json}', data_json);

               tbody += item;

               row++;

           });


           if ($.fn.DataTable.isDataTable('#tbltemp')) {

               $('#tbltemp').DataTable().destroy();

           }



           $('#tbltemp tbody').html('');

           $('#tbltemp tbody').html(tbody);

           tbltemp = $('#tbltemp').DataTable(config_tbltemp);

            setfootervalue();

            //clearItemInput();

            _initTooltip();

        }

        const config_tbltemp = {

         pageLength: 10,

         autoWidth: false,

         select: true,

         responsive: true,

         fixedColumns: true,

         order: [

         [0, 'desc']

         ],

         "language": {

             "url": lang_datatables,

         },
         "columnDefs": [{

             width: 100

         },
         {

             targets: [0],

             orderable: false,

             searchable: false,

         },
         {

             targets: [0],

             className: "text-right",

         }

         ]

     };

     $('#tblreceivablerepayment').on('click', '.btnrepayment', function(e) {
        e.preventDefault();
        $('#customer_id').val($(this).attr('data-customerid'));
        $('#customer_name').val($(this).attr('data-customername'));
        customer_total_debt.set($(this).attr('data-totalremainingdebt'));
        let actUrl = base_url + '/webmin/payment/copy_data_temp_repayment';
        let formValues = {
            customerid : $(this).attr('data-customerid'),
        };
        ajax_post(actUrl, formValues, {
            success: function(response) {
                if (response.success) {
                    if (response.result.success) {
                     let items = response.result.data;
                     loadTempData(items);
                 } else {
                    message.error(response.result.message);
                }
            }
            showInputPage(true);
        },
        error: function(response) {
            showInputPage(true);
        }
    });
    })

     function setfootervalue(){
        let actUrl = base_url + '/webmin/payment/get-receivable-footer';
        ajax_get(actUrl, null, {
            success: function(response) { 
                if (response.result.success == 'TRUE') {
                    footer_invoice_total.set(response.result.data[0].subTotal);
                    footer_total_pay.set(response.result.data[0].temp_payment_isedit);
                } else {
                    message.error(response.result.message);
                }
            }
        });
    }

    function updateTable() {

       tblreceivablerepayment.ajax.reload(null, false);

       tblreceivablerepaymenthistory.ajax.reload(null, false);

   }

   $('#tbltemp').DataTable(config_tbltemp);
   _initTooltip();

   showInputPage(false);
})
</script>
<?= $this->endSection() ?>