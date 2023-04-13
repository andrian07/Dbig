<?php
$themeUrl = base_url('assets/adminlte3');
$assetsUrl = base_url('assets');
?>

<?= $this->extend('webmin/template/admin_template') ?>

<?= $this->section('content') ?>

<div id="list_sales">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Penjualan POS</h1>
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

                            <table id="tblsalespos" class="table table-bordered table-hover" width="100%">
                                <thead>
                                    <tr>
                                        <th data-priority="1">#</th>
                                        <th data-priority="2">No Invoice</th>
                                        <th data-priority="4">Tanggal</th>
                                        <th data-priority="5">Cabang</th>
                                        <th data-priority="6">Customer</th>
                                        <th data-priority="7">Golongan</th>
                                        <th data-priority="8">Total <small>Rp</small></th>
                                        <th data-priority="3">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
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


<div id="edit_sales">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 id="title">Ubah Penjualan Pos </h1>
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
                            <div class="row ">
                                <div class="col-sm-12 col-md-2">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>No Invoice</label>
                                        <input id="pos_sales_invoice" name="pos_sales_invoice" type="text" value="" class="form-control" readonly>
                                    </div>
                                </div>


                                <div class="col-sm-12 col-md-2">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Tgl.Penjualan</label>
                                        <input id="pos_sales_date" name="pos_sales_date" type="date" class="form-control" value="" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-2">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Customer</label>
                                        <input id="customer_name" name="customer_name" type="text" value="" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-2">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Cabang</label>
                                        <input id="store_name" name="store_name" type="text" value="" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-2">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Kasir</label>
                                        <input id="user_realname" name="user_realname" type="text" class="form-control" value="Ani" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-2">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Total Penjualan</label>
                                        <input id="pos_sales_total" name="pos_sales_total" type="text" class="form-control text-right" value="Rp0" readonly>
                                    </div>
                                </div>
                            </div>
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
                            <form id="frmaddopname" class="mb-2">
                                <div class="row well well-sm">
                                    <input type="hidden" id="detail_id" name="detail_id" value="">
                                    <div class="col-md-2">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Barcode</label>
                                            <input type="text" id="item_code" name="item_code" class="form-control" value="" readonly />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Nama Produk</label>
                                            <input type="text" id="product_name" name="product_name" class="form-control" value="" readonly />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Salesman</label>
                                            <select id="salesman_id" name="salesman_id" class="form-control" value=""></select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Harga</label>
                                            <input type="text" id="product_price" name="product_price" class="form-control" value="" readonly />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Disc</label>
                                            <input type="text" id="price_disc" name="price_disc" class="form-control" value="" readonly />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Qty</label>
                                            <input type="text" id="sales_qty" name="sales_qty" class="form-control" value="" readonly />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Satuan</label>
                                            <input type="text" id="unit_name" name="unit_name" class="form-control" value="" readonly />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Subtotal</label>
                                            <input type="text" id="subtotal" name="subtotal" class="form-control" value="" readonly />
                                        </div>
                                    </div>

                                    <div class="col-sm-1 col-md-1">
                                        <!-- text input -->
                                        <label>&nbsp;</label>
                                        <div class="form-group">
                                            <div class="col-12">
                                                <button id="btnupdatesalesman" class="btn btn-md btn-primary rounded-circle float-right"><i class="fas fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>



                            <div class="row mb-2">
                                <div class="col-12">
                                    <table id="tbldetailsales" class="table table-bordered table-hover" width="100%">
                                        <thead>
                                            <tr>
                                                <th data-priority="1">#</th>
                                                <th data-priority="2">Nama Produk</th>
                                                <th data-priority="5">Harga Jual <small>Rp</small></th>
                                                <th data-priority="6">Disc <small>Rp</small></th>
                                                <th data-priority="7">Qty</th>
                                                <th data-priority="4">Subtotal <small>Rp</small></th>
                                                <th data-priority="8">Salesman</th>
                                                <th data-priority="3">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="col-12">
                                        <button id="btncancel" class="btn btn-danger"><i class="fas fa-times-circle"></i> Batal</button>
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




<div class="modal fade" id="modal-voucher">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="title-frmvoucher"></h4>
                <button type="button" class="close close-modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <form id="frmvoucher" class="form-horizontal">
                            <input type="hidden" id="voucher_group_id" name="voucher_group_id" value="0">
                            <input type="hidden" id="old_cover_image" name="old_cover_image" value="">
                            <input type="hidden" id="old_backcover_image" name="old_backcover_image" value="">
                            <div class="form-group">
                                <label for="voucher_name" class="col-sm-12">Nama Voucher</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="voucher_name" name="voucher_name" placeholder="Nama Voucher" value="" data-parsley-maxlength="200" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="voucher_value" class="col-sm-12">Nilai Voucher</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="voucher_value" name="voucher_value" placeholder="Nilai Voucher" value="" data-parsley-vvouchervalue required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="voucher_remark" class="col-sm-12">Keterangan</label>
                                <div class="col-sm-12">
                                    <textarea id="voucher_remark" name="voucher_remark" class="form-control" placeholder="Keterangan" data-parsley-maxlength="500" rows="3" required></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="category_restriction" class="col-sm-12">Filter Kategori</label>
                                <div class="col-sm-12 sel2">
                                    <select id="category_restriction" name="category_restriction[]" class="form-control" multiple="multiple"></select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="brand_restriction" class="col-sm-12">Filter Brand</label>
                                <div class="col-sm-12 sel2">
                                    <select id="brand_restriction" name="brand_restriction[]" class="form-control" multiple="multiple"></select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="exp_date" class="col-sm-12">Exp. Date</label>
                                <div class="col-sm-12">
                                    <input type="date" class="form-control" id="exp_date" name="exp_date" placeholder="Exp. Date" value="" required>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <?php
                        $defaultImage = base_url('assets/images/no-image.PNG');
                        $allow_ext = [];
                        foreach ($upload_file_type['image'] as $ext) {
                            $allow_ext[] = '.' . $ext;
                        }
                        ?>
                        <div class="mb-3 border">
                            <p class="text-center"><b>Cover Voucher</b></p>
                            <img id="preview_image_cover" src="<?= $defaultImage ?>" width="100%" height="200px">

                            <input type="file" name="upload_image_cover" id="upload_image_cover" accept="<?= implode(',', $allow_ext) ?>" hidden>
                            <button id="btnuploadcover" class="btn btn-primary btn-block mt-0"><i class="fas fa-cloud-upload-alt"></i> Unggah Gambar</button>
                        </div>

                        <div class="mb-3 border">
                            <p class="text-center"><b>Back Cover Voucher</b></p>
                            <img id="preview_image_backcover" src="<?= $defaultImage ?>" width="100%" height="200px">
                            <input type="file" name="upload_image_backcover" id="upload_image_backcover" accept="<?= implode(',', $allow_ext) ?>" hidden>
                            <button id="btnuploadbackcover" class="btn btn-primary btn-block mt-0"><i class="fas fa-cloud-upload-alt"></i> Unggah Gambar</button>

                        </div>



                    </div>
                </div>

            </div>
            <div class="modal-footer justify-content-between">
                <button id="btncancel" class="btn btn-danger close-modal"><i class="fas fa-times-circle"></i> Batal</button>
                <button id="btnsave" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.content -->
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    $(document).ready(function() {
        let formMode = '';
        let pos_sales_total = new AutoNumeric('#pos_sales_total', configRp);
        let edit_pos_sales_id = 0;
        let edit_store_id = '';


        let product_price = new AutoNumeric('#product_price', configRp);
        let price_disc = new AutoNumeric('#price_disc', configRp);
        let sales_qty = new AutoNumeric('#sales_qty', configQty);
        let subtotal = new AutoNumeric('#subtotal', configRp);

        function _initButton() {
            $('.btnedit').prop('disabled', !hasRole('sales_pos.edit'));
        }

        function showInput(x) {
            if (x) {
                $('#list_sales').hide();
                $('#edit_sales').show();
            } else {
                $('#list_sales').show();
                $('#edit_sales').hide();
            }
        }

        $("#salesman_id").select2({
            placeholder: '-- Pilih Salesman --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/salesman",
                dataType: "json",
                type: "GET",
                delay: select2Delay,
                data: function(params) {
                    return {
                        store_id: edit_store_id,
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
        let tblsalespos = $("#tblsalespos").DataTable({
            processing: true,
            select: true,
            serverSide: true,
            responsive: true,
            fixedColumns: true,
            order: [
                [0, 'desc']
            ],
            language: {
                url: lang_datatables,
            },
            ajax: {
                url: base_url + '/webmin/sales-pos/table',
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
                    targets: 7
                },
                {
                    targets: [7],
                    orderable: false,
                    searchable: false,
                },
                {
                    targets: [0, 6],
                    className: "text-right",
                },
            ],
        });

        function updateTable() {
            tblsalespos.ajax.reload(null, false);
        }

        $('#btnreload').click(function(e) {
            e.preventDefault();
            updateTable();
        })





        let tbldetailsales = $("#tbldetailsales").DataTable({
            processing: true,
            select: true,
            serverSide: true,
            responsive: true,
            fixedColumns: true,
            order: [
                [0, 'desc']
            ],
            language: {
                url: lang_datatables,
            },
            ajax: {
                url: base_url + '/webmin/sales-pos/table-detail-sales',
                type: "POST",
                data: function(d) {
                    return $.extend({}, d, {
                        'pos_sales_id': edit_pos_sales_id,
                    });
                },
                error: function() {
                    notification.danger('Gagal memuat table, harap coba lagi');
                },
            },
            drawCallback: function(settings) {
                _initTooltip();
                //_initButton();
            },
            columnDefs: [{
                    width: 40,
                    targets: [0, 4]
                },
                {
                    width: 100,
                    targets: [2, 3, 5]
                },
                {
                    width: 130,
                    targets: [6]
                },
                {
                    width: 50,
                    targets: 7
                },
                {
                    targets: [2, 3, 4, 5, 7],
                    orderable: false,
                    searchable: false,
                },
                {
                    targets: [2, 3, 4, 5],
                    className: "text-right",
                },
            ],
        });

        function updateTableDetail() {
            tbldetailsales.ajax.reload(null, false);
        }

        function clearInput() {
            $('#detail_id').val('0');
            $('#item_code').val('');
            $('#product_name').val('');
            $('#unit_name').val('');
            product_price.set(0);
            price_disc.set(0);
            sales_qty.set(0);
            subtotal.set(0);
            setSelect2('#salesman_id');
        }

        $("#tblsalespos").on('click', '.btnedit', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let actUrl = base_url + '/webmin/sales-pos/getbyid/' + id;
            ajax_get(actUrl, null, {
                success: function(response) {
                    if (response.success) {
                        if (response.result.exist) {
                            let data = response.result.data;
                            $('#pos_sales_invoice').val(data.pos_sales_invoice);
                            $('#pos_sales_date').val(data.pos_sales_date);
                            $('#customer_name').val(htmlEntities.decode(data.customer_name));
                            $('#store_name').val(htmlEntities.decode(data.store_name));
                            $('#user_realname').val(htmlEntities.decode(data.user_realname));
                            pos_sales_total.set(parseFloat(data.pos_sales_total));
                            edit_pos_sales_id = id;
                            edit_store_id = data.store_id;
                            clearInput();
                            showInput(true);
                            updateTableDetail();
                        } else {
                            message.error(response.result.message);
                        }
                    }
                }
            })

        })

        $("#tbldetailsales").on('click', '.btnedit', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let actUrl = base_url + '/webmin/sales-pos/getdetailbyid/' + id;
            ajax_get(actUrl, null, {
                success: function(response) {
                    if (response.success) {
                        if (response.result.exist) {
                            let data = response.result.data;
                            $('#detail_id').val(data.detail_id);
                            $('#item_code').val(htmlEntities.decode(data.item_code));
                            $('#product_name').val(htmlEntities.decode(data.product_name));
                            $('#unit_name').val(htmlEntities.decode(data.unit_name));
                            product_price.set(parseFloat(data.product_price));
                            price_disc.set(parseFloat(data.price_disc));

                            let qty = parseFloat(data.sales_qty);
                            let price = parseFloat(data.sales_price);
                            let stotal = qty * price;
                            sales_qty.set(qty);
                            subtotal.set(stotal);
                            let salesman_id = data.salesman_id;
                            if (salesman_id == '0') {
                                setSelect2('#salesman_id');
                            } else {
                                let salesman_text = htmlEntities.decode(data.salesman_code + ' - ' + data.salesman_name)
                                setSelect2('#salesman_id', salesman_id, salesman_text);
                            }


                        } else {
                            message.error(response.result.message);
                        }
                    }
                }
            })

        })

        $('#btnupdatesalesman').click(function(e) {
            e.preventDefault();
            let btnSubmit = $('#btnupdatesalesman')
            let question = 'Yakin ingin menyimpan perubahan salesman?';
            let detail_id = $('#detail_id').val();
            if (detail_id == '0') {
                message.info('Harap pilih item yang akan di ubah');
            } else {
                let salesman_id = 0;
                if (!($('#salesman_id').val() == '' || $('#salesman_id').val() == null)) {
                    salesman_id = $('#salesman_id').val();
                }
                let actUrl = base_url + '/webmin/sales-pos/change-salesman/' + detail_id + '/' + salesman_id;

                message.question(question).then(function(answer) {
                    let yes = parseMessageResult(answer);
                    if (yes) {
                        btnSubmit.prop('disabled', true);
                        let formValues = {
                            'fp': '999'
                        };
                        ajax_post(actUrl, formValues, {
                            success: function(response) {
                                if (response.success) {
                                    if (response.result.success) {
                                        clearInput();
                                        notification.success(response.result.message);
                                    } else {
                                        message.error(response.result.message);
                                    }
                                }
                                btnSubmit.prop('disabled', false);
                                updateTableDetail();
                            },
                            error: function(response) {
                                btnSubmit.prop('disabled', false);
                                updateTableDetail();
                            }
                        }, true);
                    }

                })
            }

        })

        $('#btncancel').click(function(e) {
            e.preventDefault();
            message.question('Yakin ingin menutup halaman ini?').then(function(answer) {
                let yes = parseMessageResult(answer);
                if (yes) {
                    showInput(false);
                    edit_pos_sales_id = 0;
                    edit_store_id = '';
                }
            })
        })



        _initButton();

        showInput(false);
        clearInput();
    })
</script>
<?= $this->endSection() ?>