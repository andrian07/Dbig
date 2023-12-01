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

                    <h1>Daftar Produk Di Bawah Safety Stock</h1>

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

                        </div>

                        <div class="card-body">

                            <table id="tblsafetystock" class="table table-bordered table-hover" width="100%">

                                <thead>

                                    <tr>

                                        <th data-priority="1">#</th>

                                        <th data-priority="2">Nama Produk</th>

                                        <th data-priority="3">Minimal Stok</th>

                                        <th data-priority="4">Stok Saat Ini</th>

                                        <th data-priority="5">Total Order</th>
                                        <th data-priority="6">Avg Sales 3Bln</th>

                                        <th data-priority="7">Outstanding</th>
                                        <th data-priority="8">No Pengajuan</th>

                                        <th data-priority="9">Status</th>

                                        <th data-priority="10">Aksi</th>

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

            <div class="modal fade" id="modal-edit">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="title">Edit</h4>
                            <button type="button" class="close close-modal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="frmedit" class="form-horizontal">
                            <div class="modal-body">
                                <input id="product_id" name="product_id" value="" type="hidden">
                                <div class="form-group">
                                    <label for="product_name" class="col-sm-12">Nama Produk</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Nama Produk" value="" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="outstanding" class="col-sm-12">Outstanding</label>
                                    <div class="col-sm-12">
                                        <select id="outstanding" name="outstanding" class="form-control">
                                            <option value="N">Tidak</option>
                                            <option value="Y">Ya</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button id="btncancel" class="btn btn-danger close-modal"><i class="fas fa-times-circle"></i> Batal</button>
                                <button id="btnsave" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.row -->

        </div><!-- /.container-fluid -->

    </section>

</div>

</div>

<!-- end Decline -->


<!-- /.content -->

<?= $this->endSection() ?>



<?= $this->section('js') ?>

<script>
    function _initButton() {
        $('#autosubmission').prop('disabled', !hasRole('submission.add'));
    }

    $(document).ready(function() {

        var url_string = window.location.href;
        var url = new URL(url_string);
        var id = url.searchParams.get("update_date");

        let tblsafetystock = $("#tblsafetystock").DataTable({
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
                url: base_url + '/webmin/purchase-order/list-auto-po',
                type: "POST",
                data: function(d) {
                    return $.extend({}, d, {
                        'id': id,
                    });
                },
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
                    targets: [9]
                },
                {
                    targets: [0, 9],
                    orderable: false,
                    searchable: false,
                },
                {
                    targets: [0],
                    className: "text-right",
                },
            ],
        });

        $("#tblsafetystock").on('click', '.btnorder', function(e) {

            e.preventDefault();

            let submission_item_id = $(this).attr('data-id');

            let submission_product_name = $(this).attr('data-name');

            let qty = $(this).attr('data-qty');

            let dates = $(this).attr('data-dates');

            let prod = $(this).attr('data-prod');

            let actUrl = base_url + '/webmin/submission/create-submission-system';

            let formValues = {

                product_id: prod,

                submission_warehouse_id: 1,

                submission_type: 'Pembelian',

                item_id: submission_item_id,

                product_name: submission_product_name,

                qty: qty,

                temp_status: 'Restock',

                submission_order_date: dates,

                desc: 'Order By System'

            };

            ajax_post(actUrl, formValues, {

                success: function(response) {

                    if (response.success) {

                        if (response.result.success) {

                            notification.success(response.result.message);

                        } else {

                            message.error(response.result.message);

                        }

                        tblsafetystock.ajax.reload(null, false);

                    }

                }

            })

        })

        $("#tblsafetystock").on('click', '.btnedit', function(e) {
            e.preventDefault();
            let product_id = $(this).attr('data-id');
            let product_name = $(this).attr('data-name');
            let outstanding = $(this).attr('data-outstanding');

            $('#product_id').val(product_id);
            $('#product_name').val(product_name);
            $('#outstanding').val(outstanding);
            $('#modal-edit').modal(configModal);
        })

        $('#btnsave').click(function(e) {
            e.preventDefault();
            let question = 'Yakin ingin memperbarui data po?';
            let actUrl = base_url + '/webmin/purchase-order/edit-auto-po';
            let btnSubmit = $('#btnsave')

            message.question(question).then(function(answer) {
                let yes = parseMessageResult(answer);
                if (yes) {
                    let formValues = {
                        product_id: $('#product_id').val(),
                        outstanding: $('#outstanding').val()
                    };

                    btnSubmit.prop('disabled', true);
                    ajax_post(actUrl, formValues, {
                        success: function(response) {
                            if (response.success) {
                                if (response.result.success) {
                                    notification.success(response.result.message);
                                    $('#modal-edit').modal('hide');
                                } else {
                                    message.error(response.result.message);
                                }
                            }
                            btnSubmit.prop('disabled', false);
                            tblsafetystock.ajax.reload(null, false);
                        },
                        error: function(response) {
                            btnSubmit.prop('disabled', false);
                            tblsafetystock.ajax.reload(null, false);
                        }
                    });
                }

            })
        })



        $('.close-modal').click(function(e) {
            e.preventDefault();
            $('#modal-edit').modal('hide');
        })


        _initButton();
    })
</script>

<?= $this->endSection() ?>