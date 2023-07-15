<?php
$themeUrl = base_url('assets/adminlte3');
$assetsUrl = base_url('assets');
?>



<?= $this->extend('webmin/template/admin_template') ?>

<?= $this->section('css') ?>
<style>
    td.nowrap {
        min-width: 129px;
    }

    .dtHorizontalExampleWrapper {
        max-width: 600px;
        margin: 0 auto;
    }

    #tblsearchproduct th,
    td {
        white-space: nowrap;
    }

    table.dataTable thead .sorting:after,
    table.dataTable thead .sorting:before,
    table.dataTable thead .sorting_asc:after,
    table.dataTable thead .sorting_asc:before,
    table.dataTable thead .sorting_asc_disabled:after,
    table.dataTable thead .sorting_asc_disabled:before,
    table.dataTable thead .sorting_desc:after,
    table.dataTable thead .sorting_desc:before,
    table.dataTable thead .sorting_desc_disabled:after,
    table.dataTable thead .sorting_desc_disabled:before {
        bottom: .5em;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Informasi Produk</h1>
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

                        <div class="row">
                            <div id="info" class="col-12">

                            </div>
                            <div class="col-sm-2">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Pencarian</label>
                                    <select id="filter_search" name="filter_search" class="form-control">
                                        <option value="product_code">Kode Produk</option>
                                        <option value="product_name">Nama Produk</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-8">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Kata Kunci</label>
                                    <input id="search" name="search" type="text" class="form-control" placeholder="Kata Kunci Pencarian">
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button id="btnsearch" class="btn btn-default btn-md form-control"><i class="fas fa-search"></i> Cari</button>
                                </div>
                            </div>
                        </div>
                        <div class="search_data">
                            <table id="tblsearchproduct" class="table table-striped table-bordered table-hover table-sm" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Kode Produk</th>
                                        <th>Barcode</th>
                                        <th>Nama Produk</th>
                                        <th>Brand</th>
                                        <th>Kategori</th>
                                        <th>Jumlah.Stok</th>
                                        <th>Detail.Stok</th>
                                        <th>Hrg.Jual [G1]</th>
                                        <th>Hrg.Jual [G2]</th>
                                        <th>Hrg.Jual [G3]</th>
                                        <th>Hrg.Jual [G4]</th>
                                        <th>Hrg.Jual [G5]</th>
                                        <th>Hrg.Jual [G6]</th>
                                        <th>Diskon</th>
                                        <th>Periode Diskon</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!--
                                    <tr>
                                        <td><b>[0] 99999999</b></td>
                                        <td><b>[1] 99999999</b></td>
                                        <td>[2] Indomie Kaldu Ayam</td>
                                        <td>[3] Indomie</td>
                                        <td>[4] Mie Instant</td>
                                        <td>
                                            120 [5]
                                        </td>
                                        <td>
                                            UTM - 10 [6]<br>
                                            KBR - 100<br>
                                            KNY - 10
                                        </td>
                                        <td>
                                            <del>12,000 [7]</del><br>
                                            10,000
                                        </td>
                                        <td>
                                            <del>12,000 [8]</del><br>
                                            10,000
                                        </td>
                                        <td>
                                            <del>12,000 [9]</del><br>
                                            10,000
                                        </td>
                                        <td>
                                            <del>12,000 [10]</del><br>
                                            10,000
                                        </td>
                                        <td>
                                            <del>12,000 [11]</del><br>
                                            10,000
                                        </td>
                                        <td>

                                            12,000 [12]
                                        </td>
                                        <td>
                                            10% [13]
                                        </td>
                                        <td>
                                            01/01/2023 s.d 12/12/2023 [14]
                                        </td>
                                    </tr>
                                    -->
                                </tbody>
                            </table>
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
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
        function showInfo(msgText, msgType = 'info') {
            $('#info').html(`<div class="alert alert-${msgType}">${msgText}<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></div>`)
        }


        let tblsearchproduct = $('#tblsearchproduct').DataTable({
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            bFilter: false,
            pageLength: 10,
            autoWidth: false,
            select: true,
            responsive: false,
            fixedColumns: true,
            data: [],
            columns: [{
                    data: "product_code"
                },
                {
                    data: "item_code"
                },
                {
                    data: "product_name"
                },
                {
                    data: "brand_name"
                },
                {
                    data: "category_name"
                },
                {
                    data: "product_stock"
                },
                {
                    data: "stock_detail"
                },
                {
                    data: "G1_sales_price"
                },
                {
                    data: "G2_sales_price"
                },
                {
                    data: "G3_sales_price"
                },
                {
                    data: "G4_sales_price"
                },
                {
                    data: "G5_sales_price"
                },
                {
                    data: "G6_sales_price"
                },
                {
                    data: "disc_seasonal"
                },
                {
                    data: "disc_period"
                }
            ],
            order: [
                [2, 'asc']
            ],
            "language": {
                "url": lang_datatables,
            },
            columnDefs: [{
                    width: 100,
                    targets: [0, 1, 5, 13]
                },
                {
                    width: 800,
                    targets: [2]
                },
                {
                    width: 350,
                    targets: [3, 4, 6]
                },
                {
                    width: 150,
                    targets: [7, 8, 9, 10, 11, 12, 14]
                },
                {
                    targets: [7, 8, 9, 10, 11, 12, 13],
                    className: "text-right",
                },
            ],
        });

        $('.dataTables_length').addClass('bs-select');

        $('#search').keydown(function(e) {
            if (e.keyCode == 13) {
                $('#btnsearch').trigger('click');
            }
        })

        $('#btnsearch').click(function(e) {
            e.preventDefault();
            let actUrl = base_url + '/webmin/product/info-product'
            let search = $('#search').val();
            let filter_search = $('#filter_search').val();
            if (search == '') {
                showInfo('Harap isi kata kunci pencarian terlebih dahulu');
                $('#search').focus();
            } else {
                let param = {
                    search: search,
                    filter_search: filter_search
                }

                ajax_post(actUrl, param, {
                    success: function(response) {
                        if (response.success) {


                            tblsearchproduct.clear();
                            tblsearchproduct.rows.add(response.result.data);
                            tblsearchproduct.draw(false);
                        }

                    },
                })
            }

        })

    })
</script>
<?= $this->endSection() ?>