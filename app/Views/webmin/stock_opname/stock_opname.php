<?php
$themeUrl = base_url('assets/adminlte3');
$assetsUrl = base_url('assets');
?>

<?= $this->extend('webmin/template/admin_template') ?>

<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<div id="opname_list">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Stok Opname</h1>
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
                            <table id="tblopname" class="table table-bordered table-hover" width="100%">
                                <thead>
                                    <tr>
                                        <th data-priority="1">#</th>
                                        <th data-priority="2">No Opname</th>
                                        <th data-priority="4">Tanggal Opname</th>
                                        <th data-priority="5">Gudang</th>
                                        <th data-priority="6">Selisih (Rp)</th>
                                        <th data-priority="7">User</th>
                                        <th data-priority="3">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>OP/UTM/22/09/000001</td>
                                        <td>01/09/2022</td>
                                        <td>UTM - PUSAT</td>
                                        <td>100,000.00</td>
                                        <td>Reza</td>
                                        <td>
                                            <a href="javascript:;" data-fancybox data-type="iframe" data-src="<?= base_url('webmin/stock-opname/detail') ?>" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" data-title="Detail"><i class="fas fa-eye"></i></a>&nbsp;
                                            <button class="btn btn-sm btn-default btnprint" data-toggle="tooltip" data-placement="top" data-title="Cetak"><i class="fas fa-print"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>OP/KBR/22/09/000001</td>
                                        <td>03/09/2022</td>
                                        <td>KBR - CABANG KOTA BARU</td>
                                        <td>-152,500.00</td>
                                        <td>Ani</td>
                                        <td>
                                            <a href="javascript:;" data-fancybox data-type="iframe" data-src="<?= base_url('webmin/stock-opname/detail') ?>" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" data-title="Detail"><i class="fas fa-eye"></i></a>&nbsp;
                                            <button class="btn btn-sm btn-default btnprint" data-toggle="tooltip" data-placement="top" data-title="Cetak"><i class="fas fa-print"></i></button>
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
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
</div>

<div id="opname_input">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 id="title">Tambah Opname</h1>
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
                                <div class="row ">
                                    <div class="col-sm-12 col-md-2">
                                        <input type="hidden" id="supplier_id" name="supplier_id" value="">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>No Opname</label>
                                            <input id="opname_code" name="opname_code" type="text" value="AUTO" class="form-control" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Tanggal Opname</label>
                                            <input id="opname_date" name="opname_date" type="date" class="form-control" value="2022-09-03" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-4">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Gudang</label>
                                            <select id="warehouse_id" name="warehouse_id" class="form-control"></select>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>User</label>
                                            <input id="display_user" type="text" class="form-control" value="Ani" readonly>
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
                            <form id="frmaddopname" class="mb-2">
                                <div class="row well well-sm">
                                    <div class="col-sm-10 col-md-10">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Pilih Produk</label>
                                            <select id="select_product" name="select_product" class="form-control" multiple></select>
                                        </div>
                                    </div>
                                    <div class="col-sm-1 col-md-1">
                                        <!-- text input -->
                                        <label>&nbsp;</label>
                                        <div class="form-group">
                                            <div class="col-12">
                                                <button id="btnaddopname" class="btn btn-md btn-primary rounded-circle float-right"><i class="fas fa-plus"></i></button>
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
                                                <th data-priority="2">Nama Produk</th>
                                                <th data-priority="4">Satuan</th>
                                                <th data-priority="5">HPP</th>
                                                <th data-priority="6">Stok Fisik</th>
                                                <th data-priority="7">Stok Sistem</th>
                                                <th data-priority="8">Selisih HPP</th>
                                                <th data-priority="3">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6"></div>
                                <div class="col-6">
                                    <form class="form-horizontal">
                                        <div class="form-group row">
                                            <label for="total_difference_cogs" class="col-7 col-form-label text-right">Total Selisih:</label>
                                            <div class="col-5">
                                                <input id="total_difference_cogs" name="total_difference_cogs" type="text" class="form-control text-right" value="0" readonly>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-12 mt-3">
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

<div class="modal fade" id="modal-opname">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="title-frmopname">OPNAME PRODUK</h4>
                <button type="button" class="close close-modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <table width="100%">
                            <tr>
                                <td width="100px"><b>Kode Produk</b></td>
                                <td width="10px">:</td>
                                <td id="opname_product_code"></td>
                            </tr>
                            <tr>
                                <td><b>Nama Produk</b></td>
                                <td>:</td>
                                <td id="opname_product_name"></td>
                            </tr>
                            <tr>
                                <td><b>Satuan Dasar</b></td>
                                <td>:</td>
                                <td id="opname_unit_name"></td>
                            </tr>

                            <tr>
                                <td><b>HPP</b></td>
                                <td>:</td>
                                <td id="opname_base_cogs"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-12">
                        <form id="frmtemp" class="mb-2">
                            <div class="row well well-sm">
                                <div class="col-12 mb-2">
                                    <h3 id="title-frmtemp" class="text-center border-bottom ">Tambah Stok</h3>
                                </div>
                                <input type="hidden" id="product_key" name="product_key" value="0">
                                <div class="col-sm-2 col-md-2">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Tgl.Exp</label>
                                        <input id="exp_date" name="exp_date" type="date" class="form-control" placeholder="Tgl.Exp" value="">
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-2">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Stok Sistem</label>
                                        <input id="system_stock" name="system_stock" type="text" class="form-control text-right" placeholder="Stok Sistem" value="" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-2">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Stok Fisik</label>
                                        <input id="warehouse_stock" name="warehouse_stock" type="text" class="form-control text-right" placeholder="Stok Fisik" value="">
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-2">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Selisih Stok</label>
                                        <input id="product_difference_stock" name="product_difference_stock" type="text" class="form-control  text-right" placeholder="Selisih Stok" value="" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Selisih HPP</label>
                                        <input id="product_difference_cogs" name="product_difference_cogs" type="text" class="form-control  text-right" placeholder="Selisih Stok" value="" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-11 col-md-10">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Keterangan</label>
                                        <input id="opname_remark" name="opname_remark" type="text" class="form-control" placeholder="Catatan" value="">
                                    </div>
                                </div>

                                <div class="col-sm-1">
                                    <!-- text input -->
                                    <label>&nbsp;</label>
                                    <div class="form-group">
                                        <div class="col-12">
                                            <button id="btnreset-temp" class="btn btn-md btn-default rounded-circle float-right"><i class="fas fa-sync"></i></button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-1">
                                    <!-- text input -->
                                    <label>&nbsp;</label>
                                    <div class="form-group">
                                        <div class="col-12">
                                            <button id="btnadd-temp" class="btn btn-md btn-primary rounded-circle float-right"><i class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                    <div class="col-12">
                        <table id="tbltempopname" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Exp Date</th>
                                    <th>Stok Sistem</th>
                                    <th>Stok Fisik</th>
                                    <th>Selisih</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button id="btncancel" class="btn btn-danger close-modal"><i class="fas fa-times-circle"></i> Batal</button>
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
        let opname_base_cogs = 0;
        let opname_product_id = 0;
        let warehouse_stock = new AutoNumeric('#warehouse_stock', configQty);
        let system_stock = new AutoNumeric('#system_stock', configQty);
        let product_difference_stock = new AutoNumeric('#product_difference_stock', configQty);
        let product_difference_cogs = new AutoNumeric('#product_difference_cogs', configRp);

        let total_difference_cogs = new AutoNumeric('#total_difference_cogs', configRp);

        // select 2 //
        $("#warehouse_id").select2({
            placeholder: '-- Pilih Area --',
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

        $("#select_product").select2({
            placeholder: '-- Pilih Produk --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/product",
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
        let tblopname = $("#tblopname").DataTable({
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
                url: base_url + '/webmin/stock-opname/table',
                type: "POST",
                error: function() {
                    notification.danger('Gagal memuat table, harap coba lagi');
                },
            },
            drawCallback: function(settings) {
                _initTooltip();


            },
            columnDefs: [{
                    width: 80,
                    targets: 6
                },
                {
                    width: 30,
                    targets: [0]
                },
                {
                    width: 100,
                    targets: [1, 2, 5]
                },
                {
                    targets: [6],
                    orderable: false,
                    searchable: false,
                },
                {
                    targets: [0, 4],
                    className: "text-right",
                },
            ],
        });

        function updateTable() {
            tblopname.ajax.reload(null, false);
        }

        $('#btnreload').click(function(e) {
            e.preventDefault();
            updateTable();
        })

        $("#tblopname").on('click', '.btnprint', function(e) {
            e.preventDefault();
            let _opname_id = $(this).attr('data-id');
            let actUrl = base_url + '/webmin/stock-opname/report/' + _opname_id;
            window.open(actUrl, '_blank');
            console.log('open :' + actUrl);
        })

        // CRUD //
        const configTempTable = {
            paging: true,
            pageLength: 10,
            autoWidth: false,
            select: true,
            responsive: true,
            fixedColumns: true,
            order: [
                [0, 'asc']
            ],
            "language": {
                "url": lang_datatables,
            },
            data: [],
            columns: [{
                    data: "index"
                },
                {
                    data: "product_name"
                },
                {
                    data: "unit_name"
                },
                {
                    data: "temp_base_cogs"
                },
                {
                    data: "temp_warehouse_stock"
                },
                {
                    data: "temp_system_stock"
                },
                {
                    data: "temp_total"
                },
                {
                    data: "action"
                }
            ],
            "columnDefs": [{
                    width: 20,
                    targets: 0
                },
                {
                    width: 100,
                    targets: [3, 4, 5, 6]
                },
                {
                    width: 80,
                    targets: [7]
                },
                {
                    targets: [7],
                    orderable: false,
                    searchable: false,
                },
                {
                    targets: [0, 3, 4, 5, 6],
                    className: "text-right",
                }
            ]
        };

        let temp = {
            countItem: 0,
            totalOpname: 0,
            dataSource: [],
            table: $('#tbltemp').DataTable(configTempTable),
            loadItem: function(listData) {
                this.dataSource = listData;
                let tableRows = [];
                let num_row = 1;
                let total_opname = 0;

                listData.forEach(function(row) {
                    let product_name = `<b>${row.product_code}</b><br>${row.product_name}`;
                    let unit_name = row.unit_name;
                    let temp_base_cogs = parseFloat(row.temp_base_cogs);
                    let temp_warehouse_stock = parseFloat(row.temp_warehouse_stock); //13
                    let temp_system_stock = parseFloat(row.temp_system_stock); //10 = 13-10 = 3, 13-14=-1
                    let temp_total = (temp_warehouse_stock - temp_system_stock) * temp_base_cogs;

                    total_opname = total_opname + temp_total;
                    let jso = htmlEntities.encode(JSON.stringify(row));
                    let btns = `<button data-json="${jso}" class="btn btn-sm btn-warning btnedit rounded-circle"  data-toggle="tooltip" data-placement="top" data-title="Edit"><i class="fas fa-edit"></i></button><button data-json="${jso}" class="btn btn-sm btn-danger btndelete rounded-circle" data-toggle="tooltip" data-placement="top" data-title="Hapus"><i class="fas fa-trash"></i></button>`;

                    let formater = {
                        'index': num_row,
                        'product_name': product_name,
                        'unit_name': unit_name,
                        'temp_base_cogs': numberFormat(temp_base_cogs, true),
                        'temp_warehouse_stock': numberFormat(temp_warehouse_stock, true),
                        'temp_system_stock': numberFormat(temp_system_stock, true),
                        'temp_total': numberFormat(temp_total, true),
                        'action': btns,
                    }

                    tableRows.push(formater);
                    num_row++;
                });

                this.table.clear();
                this.table.rows.add(tableRows);
                this.table.draw(false);
                _initTooltip();
                this.totalOpname = total_opname;
                this.countItem = num_row - 1;

                if (this.countItem > 0) {
                    $('#warehouse_id').prop('disabled', true);
                } else {
                    $('#warehouse_id').prop('disabled', false);
                }

                total_difference_cogs.set(this.totalOpname);
            },
            reload: function(listData = null) {
                if (listData == null) {
                    let warehouse_id = $('#warehouse_id').val();
                    let actUrl = base_url + '/webmin/stock-opname/temp/' + warehouse_id;
                    ajax_get(actUrl, {}, {
                        success: function(response) {
                            if (response.success) {
                                temp.loadItem(response.result.data);
                            }
                        }
                    })
                } else {
                    this.loadItem(listData);
                }
            },
            reset: function() {
                let warehouse_id = '1';
                let actUrl = base_url + '/webmin/stock-opname/temp/' + warehouse_id;
                ajax_get(actUrl, {
                    clear: 'Y',
                }, {
                    success: function(response) {
                        if (response.success) {
                            temp.loadItem(response.result.data);
                        }
                    }
                })
            }
        }

        const configTempOpnameTable = {
            paging: true,
            pageLength: 10,
            autoWidth: false,
            select: true,
            responsive: true,
            fixedColumns: true,
            order: [
                [0, 'asc']
            ],
            "language": {
                "url": lang_datatables,
            },
            data: [],
            columns: [{
                    data: "index"
                },
                {
                    data: "temp_exp_date"
                },
                {
                    data: "temp_system_stock"
                },
                {
                    data: "temp_warehouse_stock"
                },
                {
                    data: "temp_total"
                },
                {
                    data: "temp_detail_remark"
                },
                {
                    data: "action"
                }
            ],
            "columnDefs": [{
                    width: 20,
                    targets: 0
                },
                {
                    width: 100,
                    targets: [1, 2, 3]
                },
                {
                    width: 120,
                    targets: [4]
                },
                {
                    width: 80,
                    targets: [6]
                },
                {
                    targets: [6],
                    orderable: false,
                    searchable: false,
                },
                {
                    targets: [0, 2, 3, 4],
                    className: "text-right",
                }
            ]
        };

        let tempOpname = {
            countItem: 0,
            totalOpname: 0,
            dataSource: [],
            table: $('#tbltempopname').DataTable(configTempOpnameTable),
            loadItem: function(listData) {
                this.dataSource = listData;
                let tableRows = [];
                let num_row = 1;
                let total_opname = 0;

                listData.forEach(function(row) {
                    let exp_date = 'N/A';
                    if (row.indo_exp_date != '') {
                        exp_date = row.indo_exp_date;
                    }
                    let temp_warehouse_stock = parseFloat(row.temp_warehouse_stock); //13
                    let temp_system_stock = parseFloat(row.temp_system_stock); //10 = 13-10 = 3, 13-14=-1
                    let temp_total = (temp_warehouse_stock - temp_system_stock) * opname_base_cogs;

                    let disableDelete = '';
                    if (row.temp_add == 'N') {
                        disableDelete = 'disabled';
                    }

                    total_opname = total_opname + temp_total;
                    let jso = htmlEntities.encode(JSON.stringify(row));

                    let btns = `<button data-json="${jso}" class="btn btn-sm btn-warning btnedit rounded-circle"  data-toggle="tooltip" data-placement="top" data-title="Edit"><i class="fas fa-edit"></i></button><button data-json="${jso}" class="btn btn-sm btn-danger btndelete rounded-circle" data-toggle="tooltip" data-placement="top" data-title="Hapus" ${disableDelete}><i class="fas fa-trash"></i></button>`;

                    let formater = {
                        'index': num_row,
                        'temp_exp_date': exp_date,
                        'temp_system_stock': numberFormat(temp_system_stock, true),
                        'temp_warehouse_stock': numberFormat(temp_warehouse_stock, true),
                        'temp_total': numberFormat(temp_total, true),
                        'temp_detail_remark': row.temp_detail_remark,
                        'action': btns,
                    }

                    tableRows.push(formater);
                    num_row++;
                });

                this.table.clear();
                this.table.rows.add(tableRows);
                this.table.draw(false);
                _initTooltip();
                this.totalOpname = total_opname;
                this.countItem = num_row - 1;
            },
            reload: function(listData = null) {
                if (listData == null) {
                    let warehouse_id = $('#warehouse_id').val();
                    let actUrl = base_url + '/webmin/stock-opname/temp-opname/' + warehouse_id + '/' + opname_product_id;
                    ajax_get(actUrl, {}, {
                        success: function(response) {
                            if (response.success) {
                                tempOpname.loadItem(response.result.data);
                            }
                        }
                    })
                } else {
                    this.loadItem(listData);
                }
            }
        }


        function showInputPage(x) {
            if (x) {
                $('#opname_list').hide();
                $('#opname_input').show();
            } else {
                $('#opname_input').hide();
                $('#opname_list').show();
            }
        }

        function clearItemInput() {
            $('#title-frmtemp').html('Tambah Stok');
            $('#product_key').val('');
            $('#exp_date').val('').prop('readonly', false);
            $('#opname_remark').val('');
            warehouse_stock.set(0);
            system_stock.set(0);
            product_difference_stock.set(0);
            product_difference_cogs.set(0);
        }


        $('#btnaddopname').click(function(e) {
            e.preventDefault();
            let product_ids = $('#select_product').val();
            let warehouse_id = $('#warehouse_id').val();
            if (warehouse_id == null || warehouse_id == '') {
                message.info('Harap pilih gudang terlebih dahulu');
            } else if (product_ids.length == 0) {
                message.info('Harap pilih produk terlebih dahulu');
            } else {
                let actUrl = base_url + '/webmin/stock-opname/opname-product';
                let formValues = {
                    product_id: product_ids,
                    warehouse_id: warehouse_id
                };
                let btnSubmit = $('#btnaddopname');
                btnSubmit.prop('disabled', true);
                ajax_post(actUrl, formValues, {
                    success: function(response) {
                        if (response.success) {
                            if (response.result.success) {
                                notification.success(response.result.message);
                                setSelect2('#select_product');
                                temp.reload(response.result.data);
                            } else {
                                message.error(response.result.message);
                            }
                        }
                        btnSubmit.prop('disabled', false);
                    },
                    error: function(response) {
                        btnSubmit.prop('disabled', false);
                    }
                });
            }
        })

        $('#tbltemp').on('click', '.btnedit', function(e) {
            e.preventDefault();
            let json_data = $(this).attr('data-json');
            let [json, is_json, error] = parseJSON(htmlEntities.decode(json_data));
            if (is_json) {
                opname_product_id = json.product_id;
                $('#opname_product_code').html(htmlEntities.encode(json.product_code));
                $('#opname_product_name').html(htmlEntities.encode(json.product_name));
                $('#opname_unit_name').html(htmlEntities.encode(json.unit_name));
                opname_base_cogs = parseFloat(json.temp_base_cogs);
                $('#opname_base_cogs').html(numberFormat(opname_base_cogs));
                tempOpname.reload();
                $('#modal-opname').modal(configModal);
            } else {
                message.error('Terjadi kesalahan dalam memproses data, harap coba lagi');
            }
        })

        $('#tbltemp').on('click', '.btndelete', function(e) {
            e.preventDefault();
            let json_data = $(this).attr('data-json');
            let [json, is_json, error] = parseJSON(htmlEntities.decode(json_data));
            if (is_json) {
                let product_id = json.product_id;
                let warehouse_id = $('#warehouse_id').val();
                let actUrl = base_url + '/webmin/stock-opname/temp-delete/' + warehouse_id;
                ajax_get(actUrl, {
                    product_id: product_id
                }, {
                    success: function(response) {
                        if (response.success) {
                            temp.loadItem(response.result.data);
                            notification.success(response.result.message);
                        } else {
                            message.error(response.result.message);
                        }
                    }
                })

            } else {
                message.error('Terjadi kesalahan dalam memproses data, harap coba lagi');
            }
        })

        $('#tbltempopname').on('click', '.btnedit', function(e) {
            e.preventDefault();
            let json_data = $(this).attr('data-json');
            let [json, is_json, error] = parseJSON(htmlEntities.decode(json_data));
            if (is_json) {
                let temp_warehouse_stock = parseFloat(json.temp_warehouse_stock);
                let temp_system_stock = parseFloat(json.temp_system_stock);
                let diff_stock = temp_warehouse_stock - temp_system_stock;
                let diff_cogs = diff_stock * opname_base_cogs;

                $('#title-frmtemp').html('Edit Stok');
                $('#product_key').val(json.product_key);
                $('#exp_date').val(json.temp_exp_date)
                if (json.temp_add == 'N') {
                    $('#exp_date').prop('readonly', true);
                } else {
                    $('#exp_date').prop('readonly', false);
                }

                $('#opname_remark').val(json.temp_detail_remark);
                warehouse_stock.set(temp_warehouse_stock);
                system_stock.set(temp_system_stock);
                product_difference_stock.set(diff_stock);
                product_difference_cogs.set(diff_cogs);
                $('#warehouse_stock').trigger('focus');
            } else {
                message.error('Terjadi kesalahan dalam memproses data, harap coba lagi');
            }
        })

        $('#tbltempopname').on('click', '.btndelete', function(e) {
            e.preventDefault();
            let json_data = $(this).attr('data-json');
            let [json, is_json, error] = parseJSON(htmlEntities.decode(json_data));
            if (is_json) {
                let product_key = json.product_key;
                let warehouse_id = $('#warehouse_id').val();
                let actUrl = base_url + '/webmin/stock-opname/temp-delete/' + warehouse_id;
                ajax_get(actUrl, {
                    product_id: opname_product_id,
                    product_key: product_key
                }, {
                    success: function(response) {
                        if (response.success) {
                            tempOpname.loadItem(response.result.data);
                            notification.success(response.result.message);
                        } else {
                            message.error(response.result.message);
                        }
                    }
                })
            } else {
                message.error('Terjadi kesalahan dalam memproses data, harap coba lagi');
            }
        })



        $('#btnreset-temp').click(function(e) {
            e.preventDefault();
            clearItemInput();
        })

        $('#btnadd-temp').click(function(e) {
            e.preventDefault();
            let warehouse_id = $('#warehouse_id').val();
            let actUrl = base_url + '/webmin/stock-opname/temp-update/' + warehouse_id;
            let formValues = {
                product_key: $('#product_key').val(),
                product_id: opname_product_id,
                temp_warehouse_stock: parseFloat(warehouse_stock.getNumericString()),
                temp_system_stock: parseFloat(system_stock.getNumericString()),
                temp_base_cogs: opname_base_cogs,
                temp_stock_difference: parseFloat(product_difference_cogs.getNumericString()),
                temp_exp_date: $('#exp_date').val(),
                temp_detail_remark: $('#opname_remark').val()
            };
            ajax_post(actUrl, formValues, {
                success: function(response) {
                    if (response.success) {
                        if (response.result.success) {
                            notification.success(response.result.message);
                            tempOpname.reload(response.result.data);
                            clearItemInput();
                        } else {
                            message.error(response.result.message);
                        }
                    }

                },
            });
        })

        $('.close-modal').click(function(e) {
            e.preventDefault();
            temp.reload();
            $('#modal-opname').modal('hide');
        })

        $('#btnadd').click(function(e) {
            e.preventDefault();
            let warehouse_id = '1';
            let actUrl = base_url + '/webmin/stock-opname/temp/' + warehouse_id + '?clear=Y';
            ajax_get(actUrl, null, {
                success: function(response) {
                    if (response.success) {
                        if (response.result.success) {
                            temp.reload(response.result.data);
                            showInputPage(true);
                            clearItemInput();
                        } else {
                            message.error(response.result.message);
                        }
                    }
                }
            })
        })

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
            if (temp.countItem > 0) {
                let btnSubmit = $('#btnsave');
                let question = 'Yakin ingin menyimpan data stok opname?';
                let actUrl = base_url + '/webmin/stock-opname/save';
                message.question(question).then(function(answer) {
                    let yes = parseMessageResult(answer);
                    if (yes) {
                        let formValues = {
                            opname_date: $('#opname_date').val(),
                            warehouse_id: $('#warehouse_id').val(),
                            opname_total: parseFloat(total_difference_cogs.getNumericString())
                        };
                        btnSubmit.prop('disabled', true);
                        ajax_post(actUrl, formValues, {
                            success: function(response) {
                                if (response.success) {
                                    if (response.result.success) {
                                        notification.success(response.result.message);
                                        showInputPage(false);
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
            } else {
                message.info('Harap input produk yang akan diopname terlebih dahulu');
            }
        })

        function calcDifference() {
            let ws = 0;
            let ss = parseFloat(system_stock.getNumericString())
            if (warehouse_stock.getNumericString() == '' || warehouse_stock.getNumericString() == null) {
                warehouse_stock.set(0);
            } else {
                ws = parseFloat(warehouse_stock.getNumericString());
            }
            let ds = ws - ss;
            let dc = ds * opname_base_cogs;
            product_difference_stock.set(ds);
            product_difference_cogs.set(dc);
        }

        $('#warehouse_stock').on('change blur', function(e) {
            calcDifference();
        })

        $('#opname_date').on('change blur', function() {
            if ($('#opname_date').val() == '') {
                $('#opname_date').val('<?= date('Y-m-d') ?>');
            }
        })

        $('#btnadd-temp').click(function(e) {
            e.preventDefault();
            clearItemInput();
        })




        _initTooltip();

        showInputPage(false);
        clearItemInput();
    })
</script>
<?= $this->endSection() ?>