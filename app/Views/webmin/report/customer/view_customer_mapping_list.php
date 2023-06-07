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
                    <h1>Daftar Mapping Customer</h1>
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
                                    <div class="col-md-10">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Mapping Area :</label>
                                            <select id="mapping_id" name="mapping_id" class="form-control"></select>
                                        </div>
                                    </div>


                                    <div class="col-md-2">
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
                            <iframe id="preview" src="<?= base_url('webmin/report/customer-mapping-list') ?>" width="100%" height="1000px"></iframe>
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
        $("#mapping_id").select2({
            placeholder: '-- Semua --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/mapping-area",
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



        function getReportUrl(params = {}) {
            let mapping_id = '';
            let mapping_name = '';

            if (!($('#mapping_id').val() == '' || $('#mapping_id').val() == null)) {
                let select_mapping_id = $('#mapping_id').select2('data');
                mapping_id = select_mapping_id[0].id;
                mapping_name = select_mapping_id[0].text;
            }


            const rptUrl = new URL("<?= base_url('webmin/report/customer-mapping-list') ?>");
            rptUrl.searchParams.append("mapping_id", mapping_id);
            rptUrl.searchParams.append("mapping_name", mapping_name);

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