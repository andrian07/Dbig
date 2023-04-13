<?php
$themeUrl = base_url('assets/adminlte3');
$assetsUrl = base_url('assets');
?>

<?= $this->extend('webmin/template/admin_template') ?>

<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Daftar Customer</h1>
                </div>
                <div class="col-sm-6"></div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- /.col -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Provinsi:</label>
                                            <select id="filter_prov_id" name="filter_prov_id" class="form-control"></select>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Kabupaten/Kota:</label>
                                            <select id="filter_city_id" name="filter_city_id" class="form-control"></select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Kecamatan:</label>
                                            <select id="filter_dis_id" name="filter_dis_id" class="form-control"></select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Kelurahan:</label>
                                            <select id="filter_subdis_id" name="filter_subdis_id" class="form-control"></select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">

                                        <div class="form-group">
                                            <label>Grup:</label>
                                            <select id="filter_customer_group" name="filter_customer_group" class="form-control">
                                                <option value="">Semua Customer</option>
                                                <?php
                                                foreach ($customerGroup as $key => $val) {
                                                ?>
                                                    <option value="<?= $key ?>"><?= $key ?> - <?= $val ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Masa Berlaku:</label>
                                            <select id="filter_exp_date" name="filter_exp_date" class="form-control">
                                                <option value="">Semua Customer</option>
                                                <option value="1">Masih Berlaku</option>
                                                <option value="2">Sisa Masa Berlaku 10 Hari</option>
                                                <option value="3">Sisa Masa Berlaku 30 Hari</option>
                                                <option value="4">Habis Masa Berlaku</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <div class="form-group">
                                                <div class="btn-group">
                                                    <button id="btnsearch" type="button" class="btn btn-default"><i class="fas fa-search"></i> Cari</button>
                                                    <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <div class="dropdown-menu" role="menu">
                                                        <a id="btnexportpdf" class="dropdown-item" href="#">Export PDF</a>
                                                        <a id="btnexportexcel" class="dropdown-item" href="#">Export Excel</a>
                                                    </div>
                                                </div>
                                            </div>
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
                <div class="col-md-12 ">
                    <div class="card">
                        <div class="card-body">
                            <h5>Preview</h5>
                            <iframe id="preview" src="<?= base_url('webmin/report/customer-list') ?>" width="100%" height="1000px"></iframe>
                        </div>
                    </div>
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
        $("#filter_prov_id").select2({
            placeholder: '-- Pilih Provinsi --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/pc/provinces",
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

        $("#filter_city_id").select2({
            placeholder: '-- Pilih Kota/Kabupaten --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/pc/cities",
                dataType: "json",
                type: "GET",
                delay: select2Delay,
                data: function(params) {
                    let prov_id = $('#filter_prov_id').val();
                    return {
                        prov_id: prov_id,
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

        $("#filter_dis_id").select2({
            placeholder: '-- Pilih Kecamatan --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/pc/districts",
                dataType: "json",
                type: "GET",
                delay: select2Delay,
                data: function(params) {
                    let city_id = $('#filter_city_id').val();
                    return {
                        city_id: city_id,
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

        $("#filter_subdis_id").select2({
            placeholder: '-- Pilih Kelurahan --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/pc/subdistricts",
                dataType: "json",
                type: "GET",
                delay: select2Delay,
                data: function(params) {
                    let dis_id = $('#filter_dis_id').val();
                    return {
                        dis_id: dis_id,
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


        $('#filter_prov_id').on('change', function() {
            setSelect2('#filter_city_id');
            setSelect2('#filter_dis_id');
            setSelect2('#filter_subdis_id');
        });

        $('#filter_city_id').on('change', function() {
            setSelect2('#filter_dis_id');
            setSelect2('#filter_subdis_id');
        });

        $('#filter_dis_id').on('change', function() {
            setSelect2('#filter_subdis_id');
        });


        function getReportUrl(params = {}) {
            let prov_id = '';
            let prov_name = '';
            let city_id = '';
            let city_name = '';
            let dis_id = '';
            let dis_name = '';
            let subdis_id = '';
            let subdis_name = '';
            let customer_group = $('#filter_customer_group').val();
            let customer_group_text = $("#filter_customer_group option:selected").text();
            let exp_date = $('#filter_exp_date').val();
            let exp_date_text = $("#filter_exp_date option:selected").text();


            if (!($('#filter_prov_id').val() == '' || $('#filter_prov_id').val() == null)) {
                let filter_prov_id = $('#filter_prov_id').select2('data');
                prov_id = filter_prov_id[0].id;
                prov_name = filter_prov_id[0].text;
            }

            if (!($('#filter_city_id').val() == '' || $('#filter_city_id').val() == null)) {
                let filter_city_id = $('#filter_city_id').select2('data');
                city_id = filter_city_id[0].id;
                city_name = filter_city_id[0].text;
            }


            if (!($('#filter_dis_id').val() == '' || $('#filter_dis_id').val() == null)) {
                let filter_dis_id = $('#filter_dis_id').select2('data');
                dis_id = filter_dis_id[0].id;
                dis_name = filter_dis_id[0].text;
            }

            if (!($('#filter_subdis_id').val() == '' || $('#filter_subdis_id').val() == null)) {
                let filter_subdis_id = $('#filter_subdis_id').select2('data');
                subdis_id = filter_subdis_id[0].id;
                subdis_name = filter_subdis_id[0].text;
            }

            if (customer_group == '') {
                customer_group_text = '-';
            }

            if (exp_date == '') {
                exp_date_text = '-';
            }


            const rptUrl = new URL("<?= base_url('webmin/report/customer-list') ?>");
            rptUrl.searchParams.append("prov_id", prov_id);
            rptUrl.searchParams.append("prov_name", prov_name);

            rptUrl.searchParams.append("city_id", city_id);
            rptUrl.searchParams.append("city_name", city_name);

            rptUrl.searchParams.append("dis_id", dis_id);
            rptUrl.searchParams.append("dis_name", dis_name);

            rptUrl.searchParams.append("subdis_id", subdis_id);
            rptUrl.searchParams.append("subdis_name", subdis_name);

            rptUrl.searchParams.append("customer_group", customer_group);
            rptUrl.searchParams.append("customer_group_text", customer_group_text);

            rptUrl.searchParams.append("exp_date", exp_date);
            rptUrl.searchParams.append("exp_date_text", exp_date_text);


            for (let key in params) {
                let val = params[key];
                rptUrl.searchParams.append(key, val);
            }

            return rptUrl.href;
        }

        $('#btnsearch').click(function(e) {
            e.preventDefault();
            let reportUrl = getReportUrl();
            $('#preview').prop('src', reportUrl);
        })


        $('#btnexportpdf').click(function(e) {
            e.preventDefault();
            let reportUrl = getReportUrl({
                'file': 'pdf',
                'download': 'Y',
            });

            window.open(reportUrl, '_blank');
        })

        $('#btnexportexcel').click(function(e) {
            e.preventDefault();
            let reportUrl = getReportUrl({
                'file': 'xls',
                'download': 'Y',
            });

            window.open(reportUrl, '_blank');
        })

    })
</script>
<?= $this->endSection() ?>