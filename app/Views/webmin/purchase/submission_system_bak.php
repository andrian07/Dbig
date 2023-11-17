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
        var id   = url.searchParams.get("update_date");

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

        _initButton();
   })

</script>

<?= $this->endSection() ?>