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
                                            <label>Customer &nbsp; <span id="customer_group"></span></label>
                                            <select id="customer_id" name="customer_id" class="form-control pos-input"></select>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Poin</label>
                                            <input type="text" id="customer_point" name="customer_point" class="form-control text-right" value="0" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Alamat</label>
                                            <input type="text" id="customer_address" name="customer_address" class="form-control" value="" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Exp.Date</label>
                                            <input type="text" id="exp_date" name="exp_date" class="form-control" value="" readonly>
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
                                        <input type="hidden" id="reward_id" name="reward_id" value="">
                                        <input type="hidden" id="reward_stock" name="reward_stock" value="">
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
                                                <input id="reward_point" name="reward_point" type="text" class="form-control text-right pos-input" value="0" data-parsley-vmaxpoint readonly required>
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
                                        <table id="tblexchange" class="table table-bordered table-hover" width="100%">
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

                                            </tbody>
                                        </table>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>

                            </div>

                            <div class="tab-pane fade" id="custom-content-above-history" role="tabpanel" aria-labelledby="custom-content-above-history-tab">
                                <!-- history -->
                                <div class="row mb-1">
                                    <div class="col-12 mb-1">
                                        <button id="btnaddpoint" class="btn btn-md btn-primary"><i class="fas fa-plus"></i> Tambah Poin</button>
                                    </div>
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
                                            <tbody></tbody>
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

    <div class="modal fade" id="modal-addpoint">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="title-frmcustomer">Tambah Poin</h4>
                    <button type="button" class="close close-modal-addpoint">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="frmaddpoint" class="form-horizontal">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="addpoint_remark" class="col-sm-12">Keterangan</label>
                                    <div class="col-sm-12">
                                        <textarea id="addpoint_remark" name="addpoint_remark" class="form-control" placeholder="Keterangan" data-parsley-maxlength="500" rows="3" required></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="addpoint_value" class="col-sm-12">Jumlah Poin</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="addpoint_value" name="addpoint_value" data-parsley-vaddpoint placeholder="Jumlah Poin">
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer justify-content-between">
                        <button id="btncancel_addpoint" class="btn btn-danger close-modal-addpoint"><i class="fas fa-times-circle"></i> Batal</button>
                        <button id="btnsave_addpoint" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

</section>




<!-- /.content -->
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    $(document).ready(function() {
        let customer_point = new AutoNumeric('#customer_point', configPoint);
        let reward_point = new AutoNumeric('#reward_point', configPoint);
        let addpoint_value = new AutoNumeric('#addpoint_value', configPoint);

        let tblexchange = $("#tblexchange").DataTable({
            processing: true,
            select: true,
            serverSide: true,
            responsive: true,
            fixedColumns: true,
            order: [
                [1, 'desc']
            ],
            language: {
                url: lang_datatables,
            },
            ajax: {
                url: base_url + '/webmin/point-exchange/table-exchange',
                type: "POST",
                data: function(d) {
                    let customer_id = $('#customer_id').val();
                    if (customer_id == '' || customer_id == null) {
                        customer_id = 0;
                    }
                    return $.extend({}, d, {
                        'customer_id': customer_id,
                    });
                },
                error: function() {
                    notification.danger('Gagal memuat table, harap coba lagi');
                },
            },
            drawCallback: function(settings) {
                _initTooltip();
            },
            columnDefs: [{
                    width: 30,
                    targets: 0
                },
                {
                    width: 150,
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
            processing: true,
            select: true,
            serverSide: true,
            responsive: true,
            fixedColumns: true,
            order: [
                [1, 'desc']
            ],
            language: {
                url: lang_datatables,
            },
            ajax: {
                url: base_url + '/webmin/point-exchange/table-history',
                type: "POST",
                data: function(d) {
                    let customer_id = $('#customer_id').val();
                    if (customer_id == '' || customer_id == null) {
                        customer_id = 0;
                    }
                    return $.extend({}, d, {
                        'customer_id': customer_id,
                    });
                },
                error: function() {
                    notification.danger('Gagal memuat table, harap coba lagi');
                },
            },
            drawCallback: function(settings) {
                _initTooltip();
            },
            columnDefs: [{
                    width: 30,
                    targets: 0
                },
                {
                    width: 80,
                    targets: 1
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

        function updateTableExchange() {
            tblexchange.ajax.reload(null, false);
        }

        function updateTableHistory() {
            tblhistorypoint.ajax.reload(null, false);
        }

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



        $("#customer_id").select2({
            placeholder: '-- Pilih Customer --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/customer",
                dataType: "json",
                type: "GET",
                delay: select2Delay,
                data: function(params) {
                    return {
                        customer_group: 'G2,G3,G4',
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

        $('#exchange_item').autocomplete({
            minLength: 2,
            source: function(req, add) {
                $.ajax({
                    url: base_url + '/webmin/point-exchange/search-reward',
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
                $('#reward_stock').val(ui.item.reward_stock);
                $('#reward_id').val(ui.item.reward_id);
                reward_point.set(parseFloat(ui.item.reward_point));
            },
        });



        function clearCustomerData() {
            setSelect2('#customer_id');
            customer_point.set(0);
            $('#customer_group').html('');
            $('#customer_address').val('');
            $('#exp_date').val('');
        }

        $('#customer_id').on('change', function() {
            if ($(this).val() == '' || $(this).val() == null) {
                clearCustomerData();
                clearForm();
            }
            updateTableExchange();
            updateTableHistory()
        });

        $('#customer_id').on('select2:select', function(e) {
            let data = e.params.data;
            if (data.exp_status == 'Y') {
                message.info(`Masa berlaku customer <b>${data.customer_name}</b> sudah hangus.\r\nBerlaku sampai ${data.exp_date}`);
            }
            customer_point.set(parseFloat(data.customer_point));
            $('#customer_address').val(data.customer_address);
            $('#exp_date').val(data.exp_date);
            $('#customer_group').html(data.customer_group_label);
        });

        function clearForm() {
            let form = $('#frmexchange');
            form.parsley().reset();
            $('#reward_stock').val(0);
            $('#reward_id').val(0);
            reward_point.set(0);
            $('#exchange_item').val('').focus();
        }

        $('#btnexchange').click(function(e) {
            e.preventDefault();
            let cp = parseFloat(customer_point.getNumericString());
            let rp = parseFloat(reward_point.getNumericString());
            let stock = parseFloat($('#reward_stock').val());
            let customer_id = $('#customer_id').val();
            let reward_id = $('#reward_id').val();
            if (customer_id == '' || customer_id == null) {
                message.info("Pilih customer terlebih dahulu");
            } else if (reward_id == '' || reward_id == '0') {
                message.info("Pilih hadiah terlebih dahulu");
            } else if (cp < rp) {
                message.info("Poin tidak mencukupi");
            } else if (stock <= 0) {
                message.info("Stok sudah habis");
            } else {
                let btnSubmit = $('#btnexchange');
                let actUrl = base_url + '/webmin/point-exchange/exchange';
                let formValues = {
                    customer_id: customer_id,
                    reward_id: reward_id,
                    reward_point: parseFloat(reward_point.getNumericString())
                };

                btnSubmit.prop('disabled', true);
                ajax_post(actUrl, formValues, {
                    success: function(response) {
                        if (response.success) {
                            if (response.result.success) {
                                notification.success(response.result.message);
                                clearForm();
                            } else {
                                message.error(response.result.message);
                            }
                        }
                        btnSubmit.prop('disabled', false);
                        updateTableExchange();
                        updateTableHistory();
                    },
                    error: function(response) {
                        btnSubmit.prop('disabled', false);
                        updateTableExchange();
                        updateTableHistory();
                    }
                });
            }
        })

        $("#tblexchange").on('click', '.btncancel', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let reward_name = $(this).attr('data-name');
            let question = 'Yakin ingin membatalkan penukaran <b>' + reward_name + '</b>?';
            let actUrl = base_url + '/webmin/point-exchange/cancel-exchange/' + id;
            message.question(question).then(function(answer) {
                let yes = parseMessageResult(answer);
                if (yes) {
                    ajax_get(actUrl, null, {
                        success: function(response) {
                            if (response.success) {
                                if (response.result.success) {
                                    notification.success(response.result.message);
                                } else {
                                    message.error(response.result.message);
                                }
                            }
                            updateTableExchange();
                            updateTableHistory();
                        },
                        error: function(response) {
                            updateTableExchange();
                            updateTableHistory();
                        }
                    })
                }
            })
        })

        $("#tblexchange").on('click', '.btncomplete', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let reward_name = $(this).attr('data-name');
            let question = 'Yakin ingin menyelesaikan penukaran <b>' + reward_name + '</b>?';
            let actUrl = base_url + '/webmin/point-exchange/success-exchange/' + id;
            message.question(question).then(function(answer) {
                let yes = parseMessageResult(answer);
                if (yes) {
                    ajax_get(actUrl, null, {
                        success: function(response) {
                            if (response.success) {
                                if (response.result.success) {
                                    notification.success(response.result.message);
                                } else {
                                    message.error(response.result.message);
                                }
                            }
                            updateTableExchange();
                            updateTableHistory();
                        },
                        error: function(response) {
                            updateTableExchange();
                            updateTableHistory();
                        }
                    })
                }
            })
        })


        $('#btnaddpoint').click(function(e) {
            e.preventDefault();
            let customer_id = $('#customer_id').val();
            if (customer_id == '' || customer_id == null) {
                message.info("Pilih customer terlebih dahulu");
            } else {
                $('#addpoint_remark').val('');
                addpoint_value.set(0);
                $('#modal-addpoint').modal(configModal);
            }

        })

        $('.close-modal-addpoint').click(function(e) {
            e.preventDefault();
            $('#modal-addpoint').modal('hide');
        })

        $('#btnsave_addpoint').click(function(e) {
            e.preventDefault();
            let customer_id = $('#customer_id').val();
            let remark = $('#addpoint_remark').val();
            let value = parseFloat(addpoint_value.getNumericString());

            if (customer_id == '' || customer_id == null) {
                message.info("Pilih customer terlebih dahulu");
            } else if (remark == '') {
                message.info("Isi keterangan poin terlebih dahulu");
            } else if (value == 0) {
                message.info("Isi jumlah poin terlebih dahulu");
            } else {
                let question = `Yakin ingin menambahkan poin sejumlah <b>${value}</b> poin ke customer?`;
                let actUrl = base_url + '/webmin/point-exchange/add-point';
                let btnSubmit = $('#btnsave_addpoint');
                message.question(question).then(function(answer) {
                    let yes = parseMessageResult(answer);
                    if (yes) {
                        let formValues = {
                            customer_id: customer_id,
                            point_remark: remark,
                            point_value: value
                        };
                        btnSubmit.prop('disabled', true);
                        ajax_post(actUrl, formValues, {
                            success: function(response) {
                                if (response.success) {
                                    if (response.result.success) {
                                        notification.success(response.result.message);
                                        $('#modal-addpoint').modal('hide');
                                    } else {
                                        message.error(response.result.message);
                                    }
                                }
                                btnSubmit.prop('disabled', false);
                                updateTableHistory()
                            },
                            error: function(response) {
                                btnSubmit.prop('disabled', false);
                                updateTableHistory()
                            }
                        });
                    }

                })
            }


        })

        $('#addpoint_value').on('change', function(e) {
            if (addpoint_value.getNumericString() == null || addpoint_value.getNumericString() == '') {
                addpoint_value.set(0);
            }
        })

        clearForm();
        clearCustomerData();

    })
</script>
<?= $this->endSection() ?>