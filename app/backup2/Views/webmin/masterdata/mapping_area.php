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
                <h1>Mapping Area</h1>
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
                        <div class="row">
                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Provinsi</label>
                                    <select id="filter_prov_id" name="filter_prov_id" class="form-control"></select>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Kota/Kabupaten</label>
                                    <select id="filter_city_id" name="filter_city_id" class="form-control"></select>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Kecamatan</label>
                                    <select id="filter_dis_id" name="filter_dis_id" class="form-control"></select>
                                </div>
                            </div>


                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Kelurahan</label>
                                    <select id="filter_subdis_id" name="filter_subdis_id" class="form-control"></select>
                                </div>
                            </div>
                        </div>

                        <table id="tblmappingarea" class="table table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th data-priority="1">#</th>
                                    <th data-priority="2">Kode Mapping</th>
                                    <th data-priority="9">Provinsi</th>
                                    <th data-priority="5">Kota/Kabubaten</th>
                                    <th data-priority="6">Kecamatan</th>
                                    <th data-priority="7">Kelurahan</th>
                                    <th data-priority="8">Kode Pos</th>
                                    <th data-priority="4">Nama Jalan</th>
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

            <div class="modal fade" id="modal-mappingarea">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="title-frmmappingarea">Ubah Area</h4>
                            <button type="button" class="close close-modal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="frmmappingarea" class="form-horizontal">
                            <div class="modal-body">
                                <input id="mapping_id" name="mapping_id" value="0" type="hidden">

                                <div class="form-group">
                                    <label for="mapping_code" class="col-sm-12">Kode Mapping</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="mapping_code" name="mapping_code" placeholder="Kode Mapping" value="" readonly>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="mapping_address" class="col-sm-12">Nama Jalan</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="mapping_address" name="mapping_address" placeholder="Nama Jalan" value="" data-parsley-maxlength="200" data-parsley-trigger-after-failure="focusout" data-parsley-vaddress required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="prov_id" class="col-sm-12">Provinsi</label>
                                    <div class="col-sm-12 sel2">
                                        <select class="form-control" id="prov_id" name="prov_id" required></select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="city_id" class="col-sm-12">Kota/Kabupaten</label>
                                    <div class="col-sm-12 sel2">
                                        <select class="form-control" id="city_id" name="city_id" required> </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="dis_id" class="col-sm-12">Kecamatan</label>
                                    <div class="col-sm-12 sel2">
                                        <select class="form-control" id="dis_id" name="dis_id" required></select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="dis_id" class="col-sm-12">Kelurahan</label>
                                    <div class="col-sm-12 sel2">
                                        <select class="form-control" id="subdis_id" name="subdis_id" required></select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="postal_code" class="col-sm-12">Kode Pos</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="postal_code" name="postal_code" placeholder="Kode Pos" data-parsley-pattern="^[0-9]+$" data-parsley-minlength="5" data-parsley-maxlength="5" value="78111" required>
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
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    $(document).ready(function() {
        let formMode = '';

        function _initButton() {
            $('#btnadd').prop('disabled', !hasRole('mapping_area.add'));
            $('.btnedit').prop('disabled', !hasRole('mapping_area.edit'));
            $('.btndelete').prop('disabled', !hasRole('mapping_area.delete'));
        }

        // datatables //
        let tblmappingarea = $("#tblmappingarea").DataTable({
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
                url: base_url + '/webmin/mapping-area/table',
                type: "POST",
                data: function(d) {
                    return $.extend({}, d, {
                        'prov_id': $('#filter_prov_id').val(),
                        'city_id': $('#filter_city_id').val(),
                        'dis_id': $('#filter_dis_id').val(),
                        'subdis_id': $('#filter_subdis_id').val(),
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
                    targets: 8
                },
                {
                    targets: [0, 8],
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
            tblmappingarea.ajax.reload(null, false);
        }


        // select 2 //
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
            updateTable();
        });

        $('#filter_city_id').on('change', function() {
            setSelect2('#filter_dis_id');
            setSelect2('#filter_subdis_id');
            updateTable();
        });

        $('#filter_dis_id').on('change', function() {
            setSelect2('#filter_subdis_id');
            updateTable();
        });

        $('#filter_subdis_id').on('change', function() {
            updateTable();
        });


        $("#prov_id").select2({
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

        $("#city_id").select2({
            placeholder: '-- Pilih Kota/Kabupaten --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/pc/cities",
                dataType: "json",
                type: "GET",
                delay: select2Delay,
                data: function(params) {
                    let prov_id = $('#prov_id').val();
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

        $("#dis_id").select2({
            placeholder: '-- Pilih Kecamatan --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/pc/districts",
                dataType: "json",
                type: "GET",
                delay: select2Delay,
                data: function(params) {
                    let city_id = $('#city_id').val();
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

        $("#subdis_id").select2({
            placeholder: '-- Pilih Kelurahan --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/pc/subdistricts",
                dataType: "json",
                type: "GET",
                delay: select2Delay,
                data: function(params) {
                    let dis_id = $('#dis_id').val();
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


        $('#prov_id').on('change', function() {
            setSelect2('#city_id');
            setSelect2('#dis_id');
            setSelect2('#subdis_id');
        });

        $('#city_id').on('change', function() {
            setSelect2('#dis_id');
            setSelect2('#subdis_id');
        });

        $('#dis_id').on('change', function() {
            setSelect2('#subdis_id');
        });

        $('#subdis_id').on('select2:select', function(e) {
            let data = e.params.data;
            $('#postal_code').val(data.postal_code);
        });

        // Validation //
        function checkAddress(mapping_address) {
            let actUrl = base_url + '/webmin/mapping-area/getbyaddress';
            useLoader = false;
            let getMap = ajax_get(actUrl, {
                mapping_address: mapping_address,
                prov_id: $('#prov_id').val(),
                city_id: $('#city_id').val(),
                dis_id: $('#dis_id').val(),
                subdis_id: $('#subdis_id').val(),
            }, {}, false);
            useLoader = true;

            if (getMap.success) {
                let result = getMap.result;
                if (result.exist) {
                    let mId = result.data.mapping_id;
                    if (mId.toUpperCase() == $("#mapping_id").val().toUpperCase()) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return true;
                }
            } else {
                return false;
            }
        }

        Parsley.addMessages('id', {
            vaddress: 'Nama jalan sudah terdaftar'
        });

        Parsley.setLocale('id');

        window.Parsley.addValidator("vaddress", {
            validateString: function(value) {
                return checkAddress(value)
            },
        });





        $('#btnreload').click(function(e) {
            e.preventDefault();
            updateTable();
        })

        function addMode() {
            let form = $('#frmmappingarea');
            $('#title-frmmappingarea').html('Tambah Area');
            form.parsley().reset();
            formMode = 'add';
            $('#mapping_id').val('0');
            $('#mapping_code').val('AUTO');
            setSelect2('#prov_id');
            setSelect2('#city_id');
            setSelect2('#dis_id');
            setSelect2('#subdis_id');
            $('#postal_code').val('');
            $('#mapping_address').val('');
            $('#modal-mappingarea').modal(configModal);
        }

        function editMode(data) {
            let form = $('#frmmappingarea');
            $('#title-frmmappingarea').html('Ubah Area');
            form.parsley().reset();
            formMode = 'edit';
            $('#mapping_id').val(htmlEntities.decode(data.mapping_id));
            $('#mapping_code').val(htmlEntities.decode(data.mapping_code));
            setSelect2('#prov_id', data.prov_id, data.prov_name);
            setSelect2('#city_id', data.city_id, data.city_name);
            setSelect2('#dis_id', data.dis_id, data.dis_name);
            setSelect2('#subdis_id', data.subdis_id, data.subdis_name);
            $('#postal_code').val(htmlEntities.decode(data.postal_code));
            $('#mapping_address').val(htmlEntities.decode(data.mapping_address));
            $('#modal-mappingarea').modal(configModal);
        }

        $('#btnadd').click(function(e) {
            e.preventDefault();
            addMode();
        })

        $('.close-modal').click(function(e) {
            e.preventDefault();
            message.question('Yakin ingin menutup halaman ini?').then(function(answer) {
                let yes = parseMessageResult(answer);
                if (yes) {
                    $('#modal-mappingarea').modal('hide');
                }
            })
        })

        $('#btnsave').click(function(e) {
            e.preventDefault();
            let form = $('#frmmappingarea');
            let btnSubmit = $('#btnsave')
            form.parsley().validate();
            if (form.parsley().isValid()) {
                let question = 'Yakin ingin menyimpan data mapping?';
                let actUrl = base_url + '/webmin/mapping-area/save/add';
                if (formMode == 'edit') {
                    question = 'Yakin ingin memperbarui data mapping?';
                    actUrl = base_url + '/webmin/mapping-area/save/edit';
                }

                message.question(question).then(function(answer) {
                    let yes = parseMessageResult(answer);
                    if (yes) {
                        let formValues = form.serialize();
                        btnSubmit.prop('disabled', true);
                        ajax_post(actUrl, formValues, {
                            success: function(response) {
                                if (response.success) {
                                    if (response.result.success) {
                                        form[0].reset();
                                        notification.success(response.result.message);
                                        form.parsley().reset();
                                        $('#modal-mappingarea').modal('hide');
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

            }
        })


        $("#tblmappingarea").on('click', '.btnedit', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let actUrl = base_url + '/webmin/mapping-area/getbyid/' + id;
            ajax_get(actUrl, null, {
                success: function(response) {
                    if (response.success) {
                        if (response.result.exist) {
                            editMode(response.result.data);
                        } else {
                            message.error(response.result.message);
                        }
                    }
                }
            })

        })


        $("#tblmappingarea").on('click', '.btndelete', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let mCode = $(this).attr('data-code');
            let mName = $(this).attr('data-name');
            let question = 'Yakin ingin menghapus area <b>' + mCode + ' - ' + mName + '</b>?';
            let actUrl = base_url + '/webmin/mapping-area/delete/' + id;
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
                            updateTable();
                        },
                        error: function(response) {
                            updateTable();
                        }
                    })
                }
            })
        })





        _initButton();

    })
</script>
<?= $this->endSection() ?>