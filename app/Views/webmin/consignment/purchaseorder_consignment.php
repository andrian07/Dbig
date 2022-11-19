<?php
$themeUrl = base_url('assets/adminlte3');
$assetsUrl = base_url('assets');
?>

<?= $this->extend('webmin/template/admin_template') ?>

<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<div id="po_list">

    <section class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h1>Pruchase Order Konsinyasi</h1>

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

                            <table id="tblpurchaseordersconsignment" class="table table-bordered table-hover" width="100%">

                                <thead>

                                    <tr>

                                        <th data-priority="1">#</th>

                                        <th data-priority="2">No PO</th>

                                        <th data-priority="2">Tanggal PO</th>

                                        <th data-priority="6">Nama Supplier</th>

                                        <th data-priority="3">Status Pemesanan</th>

                                        <th data-priority="3">Aksi</th>

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



<div id="po_input">

    <section class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h1 id="title-frm-purchase-order-consignment">Tambah PO</h1>

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


                          <form id="frm-purchase-order-consignment" class="form-horizontal form-space">

                            <div class="form-group row">

                                <label for="noinvoice" class="col-sm-1 col-form-label text-right">No Invoice :</label>

                                <div class="col-sm-3">

                                    <input id="purchase_order_invoice" name="purchase_order_invoice" type="text" class="form-control" value="AUTO" readonly>

                                </div>

                                <div class="col-md-4"></div>

                                <label for="tanggal" class="col-sm-1 col-form-label text-right">Tanggal :</label>

                                <div class="col-sm-3">

                                    <input id="po_consignment_date" name="po_consignment_date" type="date" class="form-control" value="<?= date('Y-m-d') ?>" readonly>

                                </div>
                            </div>


                            <div class="form-group row">

                                <label for="suplier" class="col-sm-1 col-form-label text-right">Supplier :</label>

                                <div class="col-sm-3">

                                    <select id="supplier_id" name="supplier_id" class="form-control"></select>

                                </div>

                                

                                <div class="col-md-4"></div>

                                <label for="user" class="col-sm-1 col-form-label text-right">Gudang :</label>

                                <div class="col-sm-3">

                                    <select id="warehouse" type="text" class="form-control"></select>

                                </div>

                            </div>


                            <div class="form-group row">

                                <div class="col-md-8"></div>

                                <label for="user" class="col-sm-1 col-form-label text-right">User :</label>

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

                                <input id="product_tax" name="product_tax" type="hidden" value="">


                                <div class="col-sm-3">

                                    <!-- text input -->

                                    <div class="form-group">

                                        <label>Produk</label>

                                        <input id="temp_po_consignment_id" name="temp_po_consignment_id" type="hidden" value="">

                                        <input id="product_id" name="product_id" type="hidden" value="">

                                        <input id="product_name" name="product_name" type="text" class="form-control" placeholder="ketikkan nama produk" value="" data-parsley-vproductname required>

                                    </div>

                                </div>


                                <div class="col-sm-2">

                                    <!-- text input -->

                                    <div class="form-group">

                                        <label>Qty</label>

                                        <input id="temp_qty" name="temp_qty" type="text" class="form-control text-right" value="0" data-parsley-vqty required>

                                    </div>

                                </div>

                                <div class="col-sm-2">

                                    <!-- text input -->

                                    <div class="form-group">

                                        <label>Expire Date</label>

                                        <input id="temp_ed_date" name="temp_ed_date" type="date" class="form-control">

                                    </div>

                                </div>

                                <div class="col-sm-1">

                                    <!-- text input -->

                                    <label>&nbsp;</label>

                                    <div class="form-group">

                                        <div class="col-12">

                                            <button id="btnadd_temp" class="btn btn-md btn-primary rounded-circle" style="margin-left: 2px;"><i class="fas fa-plus"></i></button>
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

                                            <th data-priority="3" width="50%;">Produk</th>

                                            <th data-priority="4">Qty</th>

                                            <th data-priority="5">E.D</th>

                                            <th data-priority="6">Aksi</th>

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

                                     <td>{temp_ed_date}</td>

                                     <td>

                                         <button data-id="{temp_id}" data-json="{data_json}" class="btn btn-sm btn-warning btnedit rounded-circle" data-toggle="tooltip" data-placement="top" data-title="Edit">

                                             <i class="fas fa-edit"></i>

                                         </button>

                                         &nbsp;

                                         <button data-id="{temp_id}" class="btn btn-sm btn-danger btndelete rounded-circle" data-toggle="tooltip" data-placement="top" data-title="Hapus">

                                             <i class="fas fa-minus"></i>

                                         </button>

                                     </td>

                                 </tr>

                             </template>


                         </div>

                     </div>



                     <div class="row form-space">

                        <div class="col-lg-6">

                            <div class="form-group">

                                <div class="col-sm-12">

                                    <textarea id="po_consignment_remark" name="po_consignment_remark" class="form-control" placeholder="Catatan" maxlength="500" rows="3"></textarea>

                                </div>

                            </div>

                        </div>

                        <div class="col-lg-6 text-right">

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

     let temp_qty = new AutoNumeric('#temp_qty', configQty);

     function _initButton() {
       $('#btnadd').prop('disabled', !hasRole('purchase_order_consignment.add'));
       $('.btnedit').prop('disabled', !hasRole('purchase_order_consignment.edit'));
       $('.btndelete').prop('disabled', !hasRole('purchase_order_consignment.delete'));
   }

   let tblpurchaseordersconsignment = $("#tblpurchaseordersconsignment").DataTable({
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
        url: base_url + '/webmin/consignment/tblhdpoconsignment',
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


   $('#btnadd_temp').click(function(e) {

       e.preventDefault();

       let qty = parseFloat(temp_qty.getNumericString());

       let supplier_id = $('#supplier_id').val();

       let supplier_name = $( "#supplier_id option:selected" ).text();

       let btnSubmit = $('#btnadd_temp');

       let form = $('#frmaddtemp');

       form.parsley().validate();

       if (form.parsley().isValid()) {

           let actUrl = base_url + '/webmin/consignment/temp-add';

           let formValues = {

               temp_po_consignment_id: $('#temp_po_consignment_id').val(),

               product_id: $('#product_id').val(),

               temp_qty: qty,

               temp_supplier_id: supplier_id,

               temp_supplier_name: supplier_name,

               temp_ed_date: $('#temp_ed_date').val()

           };

           btnSubmit.prop('disabled', true);

           ajax_post(actUrl, formValues, {

               success: function(response) {

                   if (response.success) {

                       if (response.result.success) {

                           clearItemInput();

                           $('#product_name').focus();

                           setSelect2('#supplier_id', supplier_id, supplier_name);

                           $('#supplier_id').attr("disabled", true);

                           notification.success(response.result.message);

                       } else {

                           message.error(response.result.message);

                       }

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


   $("#tbltemp").on('click', '.btnedit', function(e) {

         e.preventDefault();

         let json_data = $(this).attr('data-json');

         let [json, is_json, error] = parseJSON(htmlEntities.decode(json_data));

         console.log(json);

         if (is_json) {

             $('#temp_po_consignment_id').val(json.temp_po_consignment_id );

             $('#product_name').val(json.product_name);

             $('#product_id').val(json.temp_po_consignment_product_id);

             temp_qty.set(json.temp_po_consignment_qty);

             $('#temp_qty').focus();

             $('#temp_ed_date').val(json.temp_po_consignment_expire_date);

         } else {

             getTemp();

             message.error('Terjadi kesalahan dalam memproses data, harap coba lagi');

         }

     })

   $("#tbltemp").on('click', '.btndelete', function(e) {

        e.preventDefault();

        let id = $(this).attr('data-id');

        let actUrl = base_url + '/webmin/consignment/temp-delete/' + id;

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

    function loadTempData(items) {

           let template = $('#template_row_temp').html();

           let tbody = '';

           let row = 1;

           let temp_total_order = 0;

           items.forEach((val, key) => {


               let item = template;

               let data_json = htmlEntities.encode(JSON.stringify(val));

               let temp_po_consignment_id = val.temp_po_consignment_id;

               let product_id = val.product_id;

               let product_name = val.product_name;

               let temp_po_consignment_qty = parseFloat(val.temp_po_consignment_qty);

               let temp_po_consignment_expire_date = val.temp_po_consignment_expire_date;


               item = item.replaceAll('{row}', row)

               .replaceAll('{product_code}', val.product_code)

               .replaceAll('{product_name}', product_name)

               .replaceAll('{temp_qty}', numberFormat(temp_po_consignment_qty, true))

               .replaceAll('{temp_ed_date}', temp_po_consignment_expire_date)

               .replaceAll('{temp_id}', temp_po_consignment_id)

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
        // select2 //


        

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

             targets: 4

         },
         {

             targets: [4],

             orderable: false,

             searchable: false,

         },
         {

             targets: [0, 3, 4],

             className: "text-right",

         },
         ]

     };

     let tbltemp = $('#tbltemp').DataTable(config_tbltemp);


     $('#btnsave').click(function(e) {

        e.preventDefault();

        let form = $('#frmaddtemp');

        let btnSubmit = $('#btnsave');

        let question = 'Yakin ingin menyimpan data PO Konsinyasi?';

        let actUrl = base_url + '/webmin/consignment/save/add';

        if (formMode == 'edit') {

            question = 'Yakin ingin memperbarui data PO Konsinyasi?';

            actUrl = base_url + '/webmin/consignment/save/edit';

        }

        message.question(question).then(function(answer) {

            let yes = parseMessageResult(answer);

            if (yes) {

                let formValues = {

                    supplier_id: $('#supplier_id').val(),

                    po_consignment_date: $('#po_consignment_date').val(),

                    warehouse : $('#warehouse').val(),

                    po_consignment_remark : $('#po_consignment_remark').val(),

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

                                //let invUrl = base_url + '/submission/invoice/' + invoice + '?print=Y';

                                //window.open(invUrl, '_blank');

                            } else {

                                message.error(response.result.message);

                            }

                        }

                        btnSubmit.prop('disabled', false);

                        window.location.href = base_url + '/webmin/consignment/purchase-order-consignment/';

                    },

                    error: function(response) {

                        btnSubmit.prop('disabled', false);

                        updateTable();

                    }

                });

            }

        })

    });


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

           $('#product_id').val(ui.item.product_id);

               //temp_price.set(parseFloat(ui.item.base_purchase_price));\

           },

       });


    function clearItemInput() {

             let form = $('#frmaddtemp');

             form.parsley().reset();

             $('#product_id').val('');

             $('#product_name').val('');

             $('#temp_ed_date').val('');

             temp_qty.set('0.00');
    }


     function showInputPage(x) {

        if (x) {

            $('#po_list').hide();

            $('#po_input').show();



        } else {

            $('#po_list').show();

            $('#po_input').hide();

        }

    }



    $('#btnadd').click(function(e) {

           e.preventDefault();

           let actUrl = base_url + '/webmin/consignment/get-consignment-temp';

           ajax_get(actUrl, null, {

               success: function(response) {

                if (response.result.success == 'TRUE') {

                   let form = $('#frm-purchase-order-consignment');

                   let items = response.result.data;

                   $('#title-frm-purchase-order-consignment').html('Pengajuan Pesanan Konsinyasi');

                   formMode = 'add';

                   loadTempData(items);

                   if(items.length != 0){
                        let supplier_ids = items[0].temp_po_consignment_suplier_id;
                        let supplier_names = items[0].temp_po_consignment_suplier_name;
                        setSelect2('#supplier_id', supplier_ids, supplier_names);
                        $('#supplier_id').attr("disabled", true);
                   }

                   clearItemInput();

                   showInputPage(true);

               } else {

                   message.error(response.result.message);

               }

           }

        })

    })



    _initButton();

    showInputPage(false);

})

</script>

<?= $this->endSection() ?>