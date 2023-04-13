<?php
$themeUrl = base_url('assets/adminlte3');
$assetsUrl = base_url('assets');
?>

<?= $this->extend('webmin/template/admin_template') ?>

<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Password Control Logs</h1>
            </div>
            <div class="col-sm-6">

            </div>
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
                        <div class="row">

                            <div class="col-sm-2">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Dari Tanggal:</label>
                                    <input id="date_from" name="date_from" type="date" class="form-control" value="<?= date('Y-m') ?>-01">
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Sampai Tanggal:</label>
                                    <input id="date_until" name="date_until" type="date" class="form-control" value="<?= date('Y-m-d') ?>">
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Permintaan Dari:</label>
                                    <select id="request_user_id" name="request_user_id" class="form-control"></select>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Pemberi Izin:</label>
                                    <select id="user_id" name="user_id" class="form-control"></select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Toko:</label>
                                    <select id="store_id" name="store_id" class="form-control"></select>
                                </div>
                            </div>
                        </div>
                        <table id="tblpasswordcontrollogs" class="table table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th data-priority="1">#</th>
                                    <th data-priority="4">DateTime</th>
                                    <th data-priority="3">Log</th>
                                    <th data-priority="5">Permintaan Dari </th>
                                    <th data-priority="6">Pemberi Izin</th>
                                    <th data-priority="2">Toko</th>
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
<!-- /.content -->
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    $(document).ready(function() {
        const default_date = '<?= date('Y-m-d') ?>';
        // datatables //
        let tblpasswordcontrollogs = $("#tblpasswordcontrollogs").DataTable({
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
                url: base_url + '/webmin/password-control/table-logs',
                type: "POST",
                data: function(d) {
                    return $.extend({}, d, {
                        'date_from': $('#date_from').val(),
                        'date_until': $('#date_until').val(),
                        'store_id': $('#store_id').val(),
                        'request_user_id': $('#request_user_id').val(),
                        'user_id': $('#user_id').val(),
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
                    targets: [0, 2],
                    orderable: false,
                    searchable: false,
                },
                {
                    targets: [1],
                    width: "100"
                },
                {
                    targets: [2],
                    width: "500"
                },
                {
                    targets: [0],
                    className: "text-right",
                },
            ],
        });

        function updateTable() {
            tblpasswordcontrollogs.ajax.reload(null, false);
        }

        $('#btnreload').click(function(e) {
            e.preventDefault();
            updateTable();
        })

        $("#store_id").select2({
            placeholder: '-- Pilih Toko --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/store",
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

        $("#request_user_id").select2({
            placeholder: '-- Pilih User --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/user-account",
                dataType: "json",
                type: "GET",
                delay: select2Delay,
                data: function(params) {
                    let store_id = $('#store_id').val();
                    return {
                        store_id: store_id,
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

        $("#user_id").select2({
            placeholder: '-- Pilih User --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/user-account",
                dataType: "json",
                type: "GET",
                delay: select2Delay,
                data: function(params) {
                    let store_id = $('#store_id').val();
                    return {
                        store_id: store_id,
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

        $('#store_id').on('change', function() {
            setSelect2('#request_user_id');
            setSelect2('#user_id');
            updateTable();
        });

        $('#user_id').on('change', function() {
            updateTable();
        });

        $('#request_user_id').on('change', function() {
            updateTable();
        });

        $('#date_from').on('change', function() {
            if ($(this).val() == '' || $(this).val() == null) {
                $(this).val(default_date);
            }
            updateTable();
        });

        $('#date_until').on('change', function() {
            if ($(this).val() == '' || $(this).val() == null) {
                $(this).val(default_date);
            }
            updateTable();
        });


    })
</script>
<?= $this->endSection() ?>