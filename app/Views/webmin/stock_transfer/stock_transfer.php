<?php
$themeUrl = base_url('assets/adminlte3');
$assetsUrl = base_url('assets');
?>

<?= $this->extend('webmin/template/admin_template') ?>

<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<div id="transfer_stock_list">

    <section class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h1>Transfer Stock</h1>

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

                            <table id="tblstocktransfer" class="table table-bordered table-hover" width="100%">

                                <thead>

                                    <tr>

                                        <th data-priority="1">#</th>

                                        <th data-priority="2">No Transfer</th>

                                        <th data-priority="3">Tanggal</th>

                                        <th data-priority="4">Dari</th>

                                        <th data-priority="5">Tujuan</th>

                                        <th data-priority="6">Aksi</th>

                                    </tr>

                                </thead>

                                <tbody>



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

        <div class="modal fade" id="modal-updatestatus">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="title-frmupdatestatus"></h4>
                        <button type="button" class="close close-modal-updatestatus">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="frmupdatestatus" class="form-horizontal">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                   <div class="form-group">
                                       <label for="desc_status" class="col-sm-12">Keterangan Status Barang:</label>
                                       <div class="col-sm-12">
                                        <input type="hidden" id="purchase_order_id_status" name="purchase_order_id_status">
                                        <textarea id="desc_item_status" name="desc_item_status" type="text" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button class="btn btn-danger close-modal-updatestatus"><i class="fas fa-times-circle"></i> Batal</button>
                        <button id="btn_updatestatus" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

</section>

</div>



<div id="transfer_stock_input">

    <section class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h1 id="title-frmtransferstock">Transfer Stock</h1>

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


                          <form id="frmtransferstock" class="form-horizontal form-space">

                            <div class="form-group row">

                                <label for="noinvoice" class="col-sm-1 col-form-label text-right">No Transfer :</label>

                                <div class="col-sm-3">

                                    <input id="hd_transfer_stock_id" name="hd_transfer_stock_id" type="hidden" class="form-control">

                                    <input id="hd_transfer_stock_no" name="hd_transfer_stock_no" type="text" class="form-control" value="AUTO" readonly>

                                </div>

                                <div class="col-md-4"></div>
                                <label for="tanggal" class="col-sm-1 col-form-label text-right">Tanggal :</label>

                                <div class="col-sm-3">

                                    <input id="transfer_date" name="transfer_date" type="date" class="form-control" value="<?= date('Y-m-d') ?>" >

                                </div>
                            </div>


                            <div class="form-group row">

                                <label for="warehouse_from" class="col-sm-1 col-form-label text-right">Dari :</label>

                                <div class="col-sm-3">

                                    <select id="warehouse_from" name="warehouse_from" class="form-control warehouse"></select>

                                </div>


                                <div class="col-md-4"></div>

                                <label for="user" class="col-sm-1 col-form-label text-right">User :</label>

                                <div class="col-sm-3">

                                    <input id="display_user" type="text" class="form-control" value="<?= $user['user_realname'] ?>" readonly>

                                </div>

                            </div>


                            <div class="form-group row">

                                <label for="warehouse_to" class="col-sm-1 col-form-label text-right">Ke :</label>

                                <div class="col-sm-3">

                                    <select id="warehouse_to" name="warehouse_to" class="form-control warehouse"></select>

                                </div>

                                <div class="col-sm-3">

                                </div>

                                <label for="is_consignment" class="col-sm-2 col-form-label text-right">Stock Konsinyasi :</label>

                                <div class="col-md-3">

                                    <select id="is_consignment" name="is_consignment" class="form-control">
                                        <option></option>
                                        <option value="Y">Ya</option>
                                        <option value="N">Tidak</option>
                                    </select>

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

                                <input id="temp_po_id" name="temp_po_id" type="hidden" value="">

                                <input id="item_id" name="item_id" type="hidden" value="">

                                <div class="col-sm-5">

                                    <!-- text input -->

                                    <div class="form-group">

                                        <label>Produk</label>

                                        <input id="product_name" name="product_name" type="text" class="form-control" placeholder="ketikkan nama produk" value="" data-parsley-vproductname required>

                                    </div>

                                </div>


                                <div class="col-sm-2">

                                    <!-- text input -->

                                    <div class="form-group">

                                        <label>Qty Transfer</label>

                                        <input id="temp_qty" name="temp_qty" type="text" class="form-control text-right" value="0" data-parsley-vqty required>

                                    </div>

                                </div>

                                <div class="col-sm-2">

                                    <!-- text input -->

                                    <div class="form-group">

                                        <label>Stock Gudang</label>

                                        <input id="temp_warehouse_stock" name="temp_warehouse_stock" type="text" class="form-control text-right pos-input" value="0" readonly="" required="">

                                    </div>

                                </div>

                                

                                <div class="col-sm-1" style="padding-right: 62px;">

                                    <!-- text input -->

                                    <label>&nbsp;</label>

                                    <div class="form-group">

                                        <button id="btnadd_temp" class="btn btn-md btn-primary rounded-circle float-right"><i class="fas fa-plus"></i></button>

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

                                            <th data-priority="2">Kode Item</th>

                                            <th data-priority="3" width="25%;">Produk</th>

                                            <th data-priority="4">Qty</th>

                                            <th data-priority="5">Aksi</th>

                                        </tr>

                                    </thead>

                                    <tbody></tbody>

                                </table>

                                <template id="template_row_temp">

                                 <tr>

                                     <td>{row}</td>

                                     <td>{item_code}</td>

                                     <td>{product_name}</td>

                                     <td>{temp_qty}</td>

                                     <td>

                                         <button  data-id="{item_id}" data-json="{data_json}" class="btn btn-sm btn-warning btnedit rounded-circle" data-toggle="tooltip" data-placement="top" data-title="Edit">

                                             <i class="fas fa-edit"></i>

                                         </button>

                                         <button  data-id="{item_id}" class="btn btn-sm btn-danger btndelete rounded-circle" data-toggle="tooltip" data-placement="top" data-title="Hapus">

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

                                    <textarea id="transfer_remark" name="transfer_remark" class="form-control" placeholder="Catatan" maxlength="500" rows="3"></textarea>

                                </div>

                            </div>

                        </div>

                        <div class="col-lg-6 text-right" style="margin-top: 80px;">
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

     let temp_warehouse_stock = new AutoNumeric('#temp_warehouse_stock', configQty);

     function _initButton() {
         $('#btnadd').prop('disabled', !hasRole('purchase_order.add'));
         $('.btnedit').prop('disabled', !hasRole('purchase_order.edit'));
         $('.btndelete').prop('disabled', !hasRole('purchase_order.delete'));
         $('.btnprint').prop('disabled', !hasRole('purchase_order.print'));
     }

     function showInputPage(x) {

        if (x) {

            $('#transfer_stock_list').hide();

            $('#transfer_stock_input').show();

        } else {

            $('#transfer_stock_list').show();

            $('#transfer_stock_input').hide();

        }

    }


    $('#btnadd').click(function(e) {
        e.preventDefault();
        let actUrl = base_url + '/webmin/stock-transfer/get-transfer-temp';
        ajax_get(actUrl, null, {
            success: function(response) {   
                if (response.result.success == 'TRUE') {
                 let form = $('#frmtransferstock');
                 let items = response.result.data;
                 $('#title-frmtransferstock').html('Transfer Stock');
                 formMode = 'add';
                 loadTempData(items);
                    if(items.length != 0){
                        let item_warehouse_from_ids = items[0].item_warehouse_from_id;
                        let item_warehouse_from_texts = items[0].item_warehouse_from_text;
                        setSelect2('#warehouse_from', item_warehouse_from_ids, item_warehouse_from_texts);
                        let item_warehouse_destination_ids = items[0].item_warehouse_destination_id;
                        let item_warehouse_destination_texts = items[0].item_warehouse_destination_text;
                        setSelect2('#warehouse_to', item_warehouse_destination_ids, item_warehouse_destination_texts);
                    }else{
                    setSelect2('#warehouse_from', '', '');
                    setSelect2('#warehouse_to', '', '');
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

                url: base_url + '/webmin/stock-transfer/search-product-transfer?warehouse='+$('#warehouse_from').val(),

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

            temp_warehouse_stock.set(ui.item.warehouse_stock);
        },

    });


    $('#btnadd_temp').click(function(e) {

     e.preventDefault();

     let qty = parseFloat(temp_qty.getNumericString());

     let last_stock_val = parseFloat(temp_warehouse_stock.getNumericString());

     let btnSubmit = $('#btnadd_temp');

     let form = $('#frmaddtemp');

     form.parsley().validate();

     if (form.parsley().isValid()) {

         let actUrl = base_url + '/webmin/stock-transfer/temp-add';

         let formValues = {

             item_id: $('#item_id').val(),

             temp_qty: qty,

             last_stock: last_stock_val,

             warehouse_from: $('#warehouse_from').val(),

             warehouse_from_text: $("#warehouse_from option:selected").text(),

             warehouse_to: $('#warehouse_to').val(),

             warehouse_to_text: $("#warehouse_to option:selected").text(),
         };

         btnSubmit.prop('disabled', true);

         ajax_post(actUrl, formValues, {

             success: function(response) {

                 if (response.success) {


                     if (response.result.success) {

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


    Parsley.addMessages('id', {

        vproductname: 'Harap pilih produk terlebih dahulu',

        vqty: 'Qty wajib diatas Rp 0',

    });



    Parsley.setLocale('id');


    window.Parsley.addValidator("vproductname", {

        validateString: function(value) {

            if ($('#item_id').val() == '' || $('#item_id').val() == '0') {

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

    $("#tbltemp").on('click', '.btnedit', function(e) {

        e.preventDefault();

        let json_data = $(this).attr('data-json');

        let [json, is_json, error] = parseJSON(htmlEntities.decode(json_data));

        if (is_json) {

            $('#item_id').val(json.item_id);

            $('#product_name').val(json.product_name +'('+json.unit_name+')');

            temp_qty.set(json.item_qty);

            temp_warehouse_stock.set(json.item_last_stock);

            $('#temp_qty').focus();

        } else {

            //getTemp();

            message.error('Terjadi kesalahan dalam memproses data, harap coba lagi');

        }

    })  

    $("#tbltemp").on('click', '.btndelete', function(e) {

        e.preventDefault();

        let id = $(this).attr('data-id');

        let actUrl = base_url + '/webmin/stock-transfer/temp-delete/' + id;

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


    $('#btnsave').click(function(e) {

        e.preventDefault();

        let form = $('#frmtransferstock');

        let btnSubmit = $('#btnsave');

        let warehouse_to = $('#warehouse_to').val();

        let warehouse_from = $('#warehouse_from').val();

        let transfer_date = $('#transfer_date').val();

        let transfer_remark = $('#transfer_remark').val();

        let is_consignment = $('#is_consignment').val();

        let question = 'Yakin ingin menyimpan data Transfer Stock?';

        let actUrl = base_url + '/webmin/stock-transfer/save/add';

        if (formMode == 'edit') {

            question = 'Yakin ingin memperbarui data Transfer Stock?';

            actUrl = base_url + '/webmin/stock-transfer/save/edit';

        }

        if(warehouse_to == null || warehouse_from == null){
         Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Silahkan Isi Gudang Terlebih Dahulu !'
        })
     }else if(is_consignment == ''){
       Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Silahkan Isi Jenis Stock !'
    })
   }else{

    message.question(question).then(function(answer) {

        let yes = parseMessageResult(answer);

        if (yes) {

            let formValues = {

                hd_transfer_stock_id: $('#hd_transfer_stock_id').val(),

                hd_transfer_stock_warehose_from: warehouse_from,

                hd_transfer_stock_warehose_to: warehouse_to,

                hd_transfer_stock_date:transfer_date,

                is_consignment :is_consignment,

                hd_transfer_stock_remark: transfer_remark

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

                        } else {

                            message.error(response.result.message);

                        }

                    }

                    btnSubmit.prop('disabled', false);

                    updateTableHeader();

                },

                error: function(response) {

                    btnSubmit.prop('disabled', false);

                    updateTableHeader();

                }

            });

        }

    })

}

});


    let tblstocktransfer = $("#tblstocktransfer").DataTable({
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
            url: base_url + '/webmin/stock-transfer/tblstocktransfer',
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
            width: 100,
        },
        {
            targets: [0, 5],
            orderable: false,
            searchable: false,
        },
        {
            targets: [0],
            className: "text-right",
        },
        ],
    });

    function updateTableHeader() {

     tblstocktransfer.ajax.reload(null, false);

 }

 function loadTempData(items) {

   let template = $('#template_row_temp').html();

   let tbody = '';

   let row = 1;

   let temp_total_order = 0;

   items.forEach((val, key) => {

       let item = template;

       let data_json = htmlEntities.encode(JSON.stringify(val));

       let item_code = val.item_code;

       let item_id = val.item_id;

       let product_name  = val.product_name+'('+val.unit_name+')';

       let temp_qty = parseFloat(val.item_qty);

       item = item.replaceAll('{row}', row)

       .replaceAll('{item_id}', item_id)

       .replaceAll('{item_code}', item_code)

       .replaceAll('{product_name}', product_name)

       .replaceAll('{temp_qty}', numberFormat(temp_qty, true))

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

         targets: [0, 4],

         orderable: false,

         searchable: false,

     },
     {

         targets: [0],

         className: "text-right",

     }

     ]

 };

 let tbltemp = $('#tbltemp').DataTable(config_tbltemp);

 $(".warehouse").select2({
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


 function clearItemInput() {

     let form = $('#frmaddtemp');

     form.parsley().reset();

     $('#product_name').val('');

     temp_qty.set('0.00');

     temp_warehouse_stock.set('0.00');
 }



 _initButton();

 showInputPage(false);

})




</script>

<?= $this->endSection() ?>