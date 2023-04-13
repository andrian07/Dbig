<?php
$themeUrl = base_url('assets/adminlte3');
$assetsUrl = base_url('assets');
?>

<?= $this->extend('devman/template/admin_template') ?>

<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Log Queries</h1>
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
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Module:</label>
                                    <select id="module" name="module" class="form-control"></select>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label>Ref ID:</label>
                                    <input type="number" id="ref_id" name="ref_id" class="form-control" value="0">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>User ID:</label>
                                    <select id="user_id" name="user_id" class="form-control"></select>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label>Mulai Tgl:</label>
                                    <input type="date" id="start_date" name="start_date" class="form-control" value="">
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label>Sampai Tgl:</label>
                                    <input type="date" id="end_date" name="end_date" class="form-control" value="">
                                </div>
                            </div>

                        </div>
                        <table id="tbllogqueries" class="table table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th data-priority="1">#</th>
                                    <th data-priority="2">DateTime</th>
                                    <th data-priority="4">Module</th>
                                    <th data-priority="5">Ref ID</th>
                                    <th data-priority="6">User ID</th>
                                    <th data-priority="7">Log Remark</th>
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

            <div class="modal fade" id="modal-detail">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Detail</h4>
                            <button type="button" class="close close-modal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <pre><code id="logs" class="language-sql"></code></pre>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button id="btncancel" class="btn btn-danger close-modal"><i class="fas fa-times-circle"></i> Batal</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    $(document).ready(function() {

        //datatables //
        let tbllogqueries = $("#tbllogqueries").DataTable({
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
                url: base_url + '/devman/log-queries-table',
                type: "POST",
                error: function() {
                    notification.danger('Gagal memuat table, harap coba lagi');
                },
            },
            drawCallback: function(settings) {
                _initTooltip();
            },
            columnDefs: [{
                    width: 50,
                    targets: 6
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

        function updateTable() {
            tbllogqueries.ajax.reload(null, false);
        }

        $('#btnreload').click(function(e) {
            e.preventDefault();
            updateTable();
        })


        $('#tbllogqueries').on('click', '.btndetail', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let actUrl = base_url + '/devman/log-queries-detail/' + id;
            ajax_get(actUrl, null, {
                success: function(response) {
                    if (response.success) {
                        let logs_text = '';
                        $.each(response.result.log_detail, function(key, val) {
                            logs_text += '-- Query : ' + (key + 1) + '\r\n' + htmlEntities.decode(val.query_text) + '\r\n\r\n';
                        })
                        $('#logs').html(logs_text);
                        hljs.highlightAll();
                        $('#modal-detail').modal(configModal);
                    }
                }
            })



        })

        $('.close-modal').click(function(e) {
            e.preventDefault();
            $('#modal-detail').modal('hide');
        })





    })
</script>
<?= $this->endSection() ?>