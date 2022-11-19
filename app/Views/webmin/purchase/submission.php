<?php
$themeUrl = base_url('assets/adminlte3');
$assetsUrl = base_url('assets');
?>

<?= $this->extend('webmin/template/admin_template') ?>

<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<div id="submission_list">

    <section class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h1>Daftar Pengajuan</h1>

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

                            <table id="tblhdsubmission" class="table table-bordered table-hover" width="100%">

                                <thead>

                                    <tr>
                                        
                                        <th data-priority="1">#</th>

                                        <th data-priority="2">Tanggal Pengajuan</th>

                                        <th data-priority="3">Diajukan</th>

                                        <th data-priority="4">Keterangan</th>

                                        <th data-priority="4">Status</th>

                                        <th data-priority="5">Aksi</th>

                                    </tr>

                                </thead>


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

</div>



<div id="submission_input">

    <section class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h1 id="title-frmsubmisiion">Buat
                    Pengajuan</h1>

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

                            <form id="frmsubmission">

                                <div class="row">

                                    <div class="col-sm-2">

                                        <!-- text input -->

                                        <div class="form-group">

                                            <label>Tanggal Transaksi</label>

                                            <input id="submission_order_date" name="submission_order_date" type="date" class="form-control" value="<?= date('Y-m-d') ?>" readonly>

                                        </div>

                                    </div>

                                    <div class="col-sm-3">

                                        <!-- text input -->

                                        <div class="form-group">

                                            <label>No Referensi Pengajuan</label>

                                            <input type="hidden" id="purchase_order_id" name="purchase_order_id" value="0">

                                            <input id="purchase_order_invoice" name="purchase_order_invoice" type="text" class="form-control" value="AUTO" readonly>

                                        </div>

                                    </div>


                                    <div class="col-sm-3">

                                        <!-- text input -->

                                        <div class="form-group">

                                            <label>Diajukan Oleh:</label>

                                            <input id="display_user" type="text" class="form-control" value="<?= $user['user_realname'] ?>" readonly>

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

                            <form id="frmaddtemp" class="mb-2">

                                <div class="row well well-sm">

                                    <input id="item_id" name="item_id" type="hidden" value="">

                                    <input id="temp_id" name="temp_id" type="hidden" value="">

                                    <div class="col-sm-2">

                                        <!-- text input -->

                                        <div class="form-group">

                                            <label>Status</label>

                                            <select id="temp_status" name="temp_status" class="form-control text-right" value="0" readonly> </select>

                                        </div>

                                    </div>


                                    <div class="col-sm-3">

                                        <!-- text input -->

                                        <div class="form-group">
                                            <label>Produk</label>

                                            <input id="product_name" name="product_name" type="text" class="form-control" placeholder="ketikkan nama produk" value="" data-parsley-vproductname required>

                                        </div>
                                    </div>

                                    <div class="col-sm-2">

                                        <!-- text input -->

                                        <div class="form-group">

                                            <label>Qty</label>

                                            <input id="temp_qty" name="temp_qty"  class="form-control text-right" value="0" data-parsley-vqty required>

                                        </div>

                                    </div>

                                    

                                    <div class="col-sm-3">

                                        <!-- text input -->

                                        <div class="form-group">

                                            <label>Keterangan</label>

                                            <input id="temp_desc" name="temp_desc" type="text" class="form-control" > 

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

                                                <th data-priority="2">Kode Produk</th>

                                                <th data-priority="3">Produk</th>

                                                <th data-priority="4">Qty</th>

                                                <th data-priority="5">Status</th>

                                                <th data-priority="6">Keterangan</th>

                                                <th data-priority="7">Progress</th>

                                                <th data-priority="8">Aksi</th>

                                            </tr>

                                        </thead>

                                        <tbody>

                                        </tbody>

                                    </table>

                                    <template id="template_row_temp">

                                       <tr>

                                           <td>{row}</td>

                                           <td>{product_code}</td>

                                           <td>{product_name}</td>

                                           <td>{temp_qty}</td>

                                           <td>{temp_status}</td>

                                           <td>{temp_desc}</td>

                                           <td>{temp_approval}</td>

                                           <td>

                                               <button data-id="{temp_submission_id}" data-json="{data_json}" class="btn btn-sm btn-warning btnedit rounded-circle" data-toggle="tooltip" data-placement="top" data-title="Edit">

                                                   <i class="fas fa-edit"></i>

                                               </button>

                                               &nbsp;

                                               <button data-id="{temp_submission_id}" class="btn btn-sm btn-danger btndelete rounded-circle" data-toggle="tooltip" data-placement="top" data-title="Hapus">

                                                   <i class="fas fa-minus"></i>

                                               </button>

                                           </td>

                                       </tr>

                                   </template>

                               </div>

                           </div>



                           <div class="row">

                            <div class="col-lg-6 col-md-6 col-sm-12">

                                <div class="form-group">

                                    <label for="submisson_order_remark" class="col-sm-12">Catatan</label>

                                    <div class="col-sm-12">

                                        <textarea id="submisson_order_remark" name="submisson_order_remark" class="form-control" placeholder="Catatan" maxlength="500" rows="3"></textarea>

                                    </div>

                                </div>

                            </div>

                            <div class="col-12">

                                <div class="col-12">

                                    <button id="btncancel" class="btn btn-danger"><i class="fas fa-times-circle"></i> Batal</button>

                                    <button id="btnsave" class="btn btn-success float-right"><i class="fas fa-save"></i> Simpan</button>

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

       let temp_qty = new AutoNumeric('#temp_qty', configQty);
       $('#product_name2_form').hide();


       function showInputPage(x) {

        if (x) {

            $('#submission_list').hide();

            $('#submission_input').show();

        } else {

            $('#submission_list').show();

            $('#submission_input').hide();

        }

    }

       // init component //

       function _initButton() {
         $('#btnadd').prop('disabled', !hasRole('submission.add'));
         $('.btnedit').prop('disabled', !hasRole('submission.edit'));
         $('.btndelete').prop('disabled', !hasRole('submission.delete'));
     }

        // select2 //

        $("#temp_status").select2({

            data: [
            {
                id:'Urgent',
                text: 'Urgent'
            },
            {
                id:'Restock',
                text: 'Restock'
            },
            {
                id:'New',
                text: 'New',
            }

            ]

        });


        let tblhdsubmission = $("#tblhdsubmission").DataTable({
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
                url: base_url + '/webmin/submission/tblhdsubmission',
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
                targets: [0, 3, 5],
                orderable: false,
                searchable: false,
            },
            {
                targets: [0],
                className: "text-right",
            },
            ],
        });


        $('#btnadd').click(function(e) {

           e.preventDefault();

           let actUrl = base_url + '/webmin/submission/get-submission-temp';

           ajax_get(actUrl, null, {

               success: function(response) {

                if (response.result.success == 'TRUE') {

                   let form = $('#frmaddtemp');

                   let items = response.result.data;

                   $('#title-frmsubmisiion').html('Tambah Pengajuan Pesanan');

                   formMode = 'add';

                   loadTempData(items);

                   clearItemInput();

                   showInputPage(true);

               } else {

                   message.error(response.result.message);

               }

           }

        })

       })


        $("#tblhdsubmission").on('click', '.btnedit', function(e) {

             e.preventDefault();

             let id = $(this).attr('data-id');

             let actUrl = base_url + '/webmin/submission/get-submission-edit';

             ajax_get(actUrl, null, {

                 success: function(response) {

                     if (response.success) {

                         if (response.result.success) {

                             let form = $('#frmsubmission');

                             let items = response.result.data;

                             $('#title-frmsubmission').html('Ubah Pengajuan');

                             let header = response.result.header;

                             //if (header.purchase_order_status == 'pending') {

                                 $('#title-frmpurchaseorder').html('Ubah Pesanan');

                                 formMode = 'edit';

                                 $('#purchase_order_id').val(header.purchase_order_id);

                                 $('#purchase_order_invoice').val('PO-' + header.purchase_order_invoice);

                                 $('#purchase_order_date').val(header.purchase_order_date);

                                 $('#purchase_order_total').val(header.purchase_order_total);

                                 $('#purchase_order_remark').val(htmlEntities.decode(header.purchase_order_remark));

                                 $('#display_user').val(header.user_realname);

                                 setSelect2("#supplier_id", header.supplier_id, header.supplier_name);

                                 loadTempData(items);

                                 showInputPage(true);

                            // } else {

                             //    message.info('Pesanan yang sudah selesai atau dibatalkan tidak dapat di ubah lagi');

                              //   updateTable();

                            // }

                         } else {

                             message.error(response.result.message);

                         }

                     }

                 }

             })

         })


        $('#product_name').autocomplete({

           minLength: 2,

           source: function(req, add) {

               $.ajax({

                   url: base_url + '/webmin/submission/search-product',

                   dataType: 'json',

                   type: 'GET',

                   data: req,

                   success: function(res) {

                       if (res.success == true) {

                           add(res.data);

                       }

                   },

               });

           },

           select: function(event, ui) {

               $('#item_id').val(ui.item.item_id);

           },

       });




        $('#btnadd_temp').click(function(e) {

           e.preventDefault();

           let qty = parseFloat(temp_qty.getNumericString());

           let btnSubmit = $('#btnadd_temp');

           let form = $('#frmaddtemp');

           form.parsley().validate();

           if (form.parsley().isValid()) {

               let actUrl = base_url + '/webmin/submission/temp-add';

               let formValues = {
                   item_id: $('#item_id').val(),
                   temp_id: $('#temp_id').val(),
                   temp_status: $('#temp_status').val(),
                   product_name: $('#product_name').val(),
                   temp_qty: qty,
                   temp_desc:$('#temp_desc').val()
               };

               btnSubmit.prop('disabled', true);

               ajax_post(actUrl, formValues, {

                   success: function(response) {

                       if (response.success) {

                           if (response.result.success) {

                               clearItemInput();

                               $('#product_name').focus();

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


        function loadTempData(items) {

           let template = $('#template_row_temp').html();

           let tbody = '';

           let row = 1;

           let temp_total_order = 0;

           items.forEach((val, key) => {


               let item = template;

               let data_json = htmlEntities.encode(JSON.stringify(val));

               let temp_submission_id = val.temp_submission_id;

               let product_id = val.product_id;

               let product_code = val.product_code;

               let product_name = val.temp_submission_product_name;

               let temp_submission_order_qty = parseFloat(val.temp_submission_order_qty);

               let temp_submission_status = val.temp_submission_status;

               let temp_submission_desc = val.temp_submission_desc;

               let temp_submission_approval = val.temp_submission_approval;


               item = item.replaceAll('{row}', row)

               .replaceAll('{product_code}', val.product_code)

               .replaceAll('{product_name}', product_name)

               .replaceAll('{temp_qty}', numberFormat(temp_submission_order_qty, true))

               .replaceAll('{temp_status}', temp_submission_status)

               .replaceAll('{temp_desc}', temp_submission_desc)

               .replaceAll('{temp_approval}', temp_submission_approval)

               .replaceAll('{temp_submission_id}', temp_submission_id)

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

           clearItemInput();

           _initTooltip();

       }


       $("#tbltemp").on('click', '.btndelete', function(e) {

        e.preventDefault();

        let id = $(this).attr('data-id');

        let actUrl = base_url + '/webmin/submission/temp-delete/' + id;

        ajax_get(actUrl, null, {

            success: function(response) {

                if (response.success) {

                    if (response.result.success) {

                        notification.success(response.result.message);

                    } else {

                        message.error(response.result.message);

                    }

                    loadTempData(response.result.data);

                }

            },

            error: function(response) {

                getTemp();

            }

        })

    })

       $("#tbltemp").on('click', '.btnedit', function(e) {

         e.preventDefault();

         let json_data = $(this).attr('data-json');

         let [json, is_json, error] = parseJSON(htmlEntities.decode(json_data));

         console.log(json);

         if (is_json) {

             $('#item_id').val(json.product_id);

             $('#product_name').val(json.temp_submission_product_name);

             temp_qty.set(json.temp_submission_order_qty);

             $('#temp_desc').val(json.temp_submission_desc);

             $('#temp_id').val(json.temp_submission_id);

             $('#temp_qty').focus();

         } else {

             getTemp();

             message.error('Terjadi kesalahan dalam memproses data, harap coba lagi');

         }

     })  


       $('#btnsave').click(function(e) {

        e.preventDefault();

        let form = $('#frmaddtemp');

        let btnSubmit = $('#btnsave');

        let question = 'Yakin ingin menyimpan data Pengajuan?';

        let actUrl = base_url + '/webmin/submission/save/add';

        if (formMode == 'edit') {

            question = 'Yakin ingin memperbarui data Pengajuan?';

            actUrl = base_url + '/webmin/submission/save/edit';

        }

        message.question(question).then(function(answer) {

            let yes = parseMessageResult(answer);

            if (yes) {

                let formValues = {

                    submission_order_date: $('#submission_order_date').val(),

                    submission_desc: $('#submisson_order_remark').val()

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

                                let invUrl = base_url + '/submission/invoice/' + invoice + '?print=Y';

                                window.open(invUrl, '_blank');

                            } else {

                                message.error(response.result.message);

                            }

                        }

                        btnSubmit.prop('disabled', false);

                        window.location.href = base_url + '/webmin/submission/';

                    },

                    error: function(response) {

                        btnSubmit.prop('disabled', false);

                        updateTable();

                    }

                });

            }

        })

    });



       function updateTable() {

           tbltemp.ajax.reload(null, false);

       }

       function clearItemInput() {

           let form = $('#frmaddtemp');

           form.parsley().reset();

           $('#item_id').val('');

           $('#product_name').val('');

           temp_qty.set('0.00');

           $('#temp_desc').val('');

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

             width: 100,

             targets: 6

         },

         {

             targets: [6],

             orderable: false,

             searchable: false,

         },



         {

             targets: [0, 2, 3, 4, 5],

             className: "text-right",

         }

         ]

     };



     let tbltemp = $('#tbltemp').DataTable(config_tbltemp);





     _initButton();

     showInputPage(false);

 })

</script>

<?= $this->endSection() ?>