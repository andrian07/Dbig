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

                                        <th data-priority="2">No Invoice Pengajuan</th>

                                        <th data-priority="3">Tanggal Pengajuan</th>

                                        <th data-priority="4">Diajukan</th>

                                        <th data-priority="5">Keterangan</th>

                                        <th data-priority="6">Status</th>

                                        <th data-priority="7">Aksi</th>

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

                    <h1 id="title-frmsubmission">Buat Pengajuan</h1>

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

                            <form id="frmsubmission" class="form-horizontal form-space">

                                <div class="form-group row">

                                    <label for="tanggal" class="col-sm-1 col-form-label text-right">No Invoice:</label>

                                    <div class="col-sm-3">

                                        <input type="hidden" id="submission_id" name="submission_id" value="0">

                                        <input id="submission_order_invoice" name="submission_order_invoice" type="text" class="form-control" value="AUTO" readonly>

                                    </div>

                                    <div class="col-sm-4">
                    
                                    </div>

                                    <label for="noinvoice" class="col-sm-1 col-form-label text-right">Tanggal:</label>

                                    <div class="col-sm-3">

                                        <input id="submission_order_date" name="submission_order_date" type="date" class="form-control" value="<?= date('Y-m-d') ?>" readonly>

                                    </div>
                                    
                                </div>




                                <div class="form-group row">

                                    <label for="tanggal" class="col-sm-1 col-form-label text-right">Supplier:</label>

                                    <div class="col-sm-3">

                                        <select id="supplier_id" name="supplier_id" class="form-control"></select>

                                    </div>

                                    <div class="col-sm-4">
                    
                                    </div>

                                    <label for="warehouse" class="col-sm-1 col-form-label text-right">Gudang:</label>

                                    <div class="col-sm-3">

                                        <select id="warehouse" type="text" class="form-control"></select>

                                    </div>
                                    
                                </div>


                                <div class="form-group row">

                                    <div class="col-sm-8"></div>

                                    <label for="noinvoice" class="col-sm-1 col-form-label text-right">User:</label>

                                    <div class="col-sm-3">

                                        <input id="display_user" type="text" class="form-control" value="<?= $user['user_realname'] ?>" readonly>

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

                                            <select id="temp_status" name="temp_status" class="form-control" data-parsley-vtempstatus required> 
                                                <option></option>
                                                <option value="Urgent">Urgent</option>
                                                <option value="New">New</option>
                                                <option value="Restock">Restock</option>
                                            </select>

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

                                                <th data-priority="7">Aksi</th>

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
                targets: [0, 6],
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

                 setSelect2('#supplier_id', "", "");
                 setSelect2('#warehouse', "", "");

                 $('#supplier_id').prop("disabled", false);

                 formMode = 'add';

                 loadTempData(items);
                 console.log(items);
                 if(items.length > 0){
                    let supplier_ids = items[0].temp_submission_supplier_id;
                    let supplier_names = items[0].temp_submission_supplier_name;
                    setSelect2('#supplier_id', supplier_ids, supplier_names);
                    $('#supplier_id').prop("disabled", true);
                }

                clearItemInput();

                showInputPage(true);

            } else {

             message.error(response.result.message);

         }

     }

 })

     })




        $('#product_name').autocomplete({   

         minLength: 2,

         source: function(req, add) {

             $.ajax({

                 url: base_url + '/webmin/purchase-order/search-product-bysuplier?sup='+$('#supplier_id').val(),

                 dataType: 'json',

                 type: 'GET',

                 data: req,

                 success: function(res) {

                     if (res.success == true) {

                        add(res.data);

                    }else{

                       message.error(res.message);

                       $('#product_name').val('');

                   }

               },

           });

         },

         select: function(event, ui) {

            $('#item_id').val(ui.item.item_id);

        },

    });



        $('#btncancel').click(function(e) {

            e.preventDefault();

            message.question('Yakin ingin menutup halaman ini?').then(function(answer) {

                let yes = parseMessageResult(answer);

                if (yes) {

                    showInputPage(false);

                }

            })

        })
        

        $("#tblhdsubmission").on('click', '.btnedit', function(e) {

            e.preventDefault();

            let id = $(this).attr('data-id');

            let actUrl = base_url + '/webmin/submission/edit-order/' + id;

            ajax_get(actUrl, null, {

                success: function(response) {

                    if (response.success) {

                        if (response.result.success) {

                            let form = $('#frmsubmission');

                            let items = response.result.data;

                            $('#title-frmsubmission').html('Ubah Pengajuan Pesanan');

                            let header = response.result.header;


                            if (header.submission_status == 'Pending') {

                                $('#title-frmsubmission').html('Ubah Pengajuan Pesanan');

                                formMode = 'edit';

                                $('#submission_id ').val(header.submission_id );

                                setSelect2("#supplier_id", header.submission_supplier_id, header.supplier_name);

                                $('#supplier_id').prop('disabled', true);

                                let warehouse_name = header.warehouse_name;

                                setSelect2("#warehouse", header.submission_store_id, warehouse_name);

                                $('#warehouse').prop('disabled', true);

                                //$('#submission_order_invoice').val('PJ-' + header.submission_inv);

                                $('#submission_order_invoice').val(header.submission_inv);

                                $('#submission_order_date').val(header.submission_date);

                                $('#submisson_order_remark').val(htmlEntities.decode(header.submission_desc));

                                $('#display_user').val(header.user_realname);

                                loadTempData(items);

                                showInputPage(true);

                            } else {

                                message.info('Pesanan yang sudah selesai atau dibatalkan tidak dapat di ubah lagi');

                                //updateTable();

                            }

                        } else {

                            message.error(response.result.message);

                        }

                    }

                }

            })
        })


        $("#tblhdsubmission").on('click', '.btndelete', function(e) {

            e.preventDefault();

            let id = $(this).attr('data-id');

            message.question('Yakin ingin membatalkan pengajuan ini?').then(function(answer) {

                let yes = parseMessageResult(answer);

                if (yes) {

                    let actUrl = base_url + '/webmin/submission/cancel-order/' + id;

                    ajax_get(actUrl, null, {

                        success: function(response) {

                            if (response.success) {

                                if (response.result.success) {

                                    notification.success(response.result.message);



                                } else {

                                    message.error(response.result.message);

                                }

                                updateTableHeader();

                            }

                        }

                    })

                }

            })

        })


        $("#warehouse").select2({
            placeholder: '-- Pilih Gudang --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/warehouse",
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

        $("#supplier_id").select2({
            placeholder: '-- Pilih Supplier --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/supplier",
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


        $('#btnadd_temp').click(function(e) {

         e.preventDefault();

         let qty = parseFloat(temp_qty.getNumericString());

         let btnSubmit = $('#btnadd_temp');

         let form = $('#frmaddtemp');

         let supplier_name = $( "#supplier_id option:selected" ).text();

         form.parsley().validate();

         if (form.parsley().isValid()) {

             let actUrl = base_url + '/webmin/submission/temp-add';

             let formValues = {
                 item_id: $('#item_id').val(),
                 temp_id: $('#temp_id').val(),
                 temp_status: $('#temp_status').val(),
                 product_name: $('#product_name').val(),
                 temp_qty: qty,
                 temp_desc:$('#temp_desc').val(),
                 supplier_id:$('#supplier_id').val(),
                 supplier_name:supplier_name,
             };


             btnSubmit.prop('disabled', true);

             ajax_post(actUrl, formValues, {

                 success: function(response) {

                     if (response.success) {

                         if (response.result.success) {

                             $('#product_name').focus();

                             let supplier_id_selected = response.result.data[0].temp_submission_supplier_id;

                             setSelect2('#supplier_id', supplier_id_selected, supplier_name);

                             $('#supplier_id').attr("disabled", true);

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

            vproductname: 'Harap pilih produk terlebih dahulu',

            vprice: 'Harga beli wajib diatas Rp 0',

            vqty: 'Qty wajib diatas Rp 0',

            vtempstatus: 'Status wajib di pilih ',

        });



        Parsley.setLocale('id');



        window.Parsley.addValidator("vproductname", {

            validateString: function(value) {

                if ($('#product_name').val() == '') {

                    return false;

                } else {

                    return true;

                }
            },

        });

        window.Parsley.addValidator("vtempstatus", {

            validateString: function(value) {

                if ($('#temp_status').val() == '') {

                    return false;

                } else {

                    return true;

                }
            },

        });

        window.Parsley.addValidator("vprice", {

            validateString: function(value) {

                let vprice = parseFloat(temp_price.getNumericString());

                if (vprice <= 0) {

                    return false;

                } else {

                    return true;

                }

            },

        });



        window.Parsley.addValidator("vqty", {

            validateString: function(value) {

                let vqty = parseFloat(temp_qty.getNumericString());

                if (vqty <= 0) {

                    return false;

                } else {

                    return true;

                }
            },

        });




        function loadTempData(items) {

         let template = $('#template_row_temp').html();

         let tbody = '';

         let row = 1;

         let temp_total_order = 0;

         items.forEach((val, key) => {

             let item = template;

             let data_json = htmlEntities.encode(JSON.stringify(val));

             let temp_submission_id = val.temp_submission_id;

             let item_id = val.item_id;

             let product_code = val.item_code;

             let product_name = val.temp_submission_product_name;

             let temp_submission_order_qty = parseFloat(val.temp_submission_order_qty);

             let temp_submission_status = val.temp_submission_status;

             let temp_submission_desc = val.temp_submission_desc;

             let temp_submission_approval = val.temp_submission_approval;

             item = item.replaceAll('{row}', row)

             .replaceAll('{product_code}', product_code)

             .replaceAll('{product_name}', product_name)

             .replaceAll('{temp_qty}', numberFormat(temp_submission_order_qty, true))

             .replaceAll('{temp_status}', temp_submission_status)

             .replaceAll('{temp_desc}', temp_submission_desc)

             .replaceAll('{temp_approval}', temp_submission_approval)

             .replaceAll('{item_id}', item_id)

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

       if (is_json) {

            console.log(json);
            
           $('#item_id').val(json.item_id);

           $('#product_name').val(json.temp_submission_product_name);

           temp_qty.set(json.temp_submission_order_qty);

           $('#temp_desc').val(json.temp_submission_desc);

           $('#temp_id').val(json.temp_submission_id);

           let temp_submission_status = json.temp_submission_status;

           document.getElementById("temp_status").value = temp_submission_status;

            //setSelect2('#temp_status', temp_submission_status, temp_submission_status);

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

        let warehouse = $('#warehouse').val();

        if(warehouse == null){
              Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Silahkan Isi Gudang Terlebih Dahulu !'
              })

        }else{

        message.question(question).then(function(answer) {


            let yes = parseMessageResult(answer);

            if (yes) {

                let formValues = {

                    submission_order_date: $('#submission_order_date').val(),

                    submission_desc: $('#submisson_order_remark').val(),

                    submission_supplier_id: $('#supplier_id').val(),

                    submission_id: $('#submission_id').val(),

                    submission_inv: $('#submission_order_invoice').val(),

                    submission_store_id: warehouse,

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

                            } else {

                                message.error(response.result.message);

                            }

                        }

                        btnSubmit.prop('disabled', false);

                        updateTableHeader();

                        //window.location.href = base_url + '/webmin/submission/';

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



     function updateTable() {

         tbltemp.ajax.reload(null, false);

     }

     function updateTableHeader() {

         tblhdsubmission.ajax.reload(null, false);

     }

     function clearItemInput() {

         let form = $('#frmaddtemp');

         form.parsley().reset();

         $('#item_id').val('');

         $('#product_name').val('');

         $('#temp_status').val('');

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