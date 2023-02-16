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
                <h1>Customer</h1>
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
                        <div class="btn-group">
                            <button type="button" class="btn btn-success"><i class="fas fa-file-excel"></i> Import Excel</button>
                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                                <a class="dropdown-item" href="#">Template File Excel</a>
                            </div>
                        </div>
                        <!--
                        <button id="btnexchange" class="btn btn-default"><i class="fas fa-exchange-alt"></i> Penukaran Poin</button>
                        -->
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Grup Customer</label>
                                    <select id="filter_customer_group" name="filter_customer_group" class="form-control">
                                        <option value="">Semua</option>
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

                            <div class="col-sm-4">
                                <!-- text input -->
                                <div class="form-group">
                                    <div class="col-12">
                                        <label>Poin</label>
                                        <div class="row">
                                            <div class="col-4">
                                                <select id="filter_point_by" name="filter_point_by" class="form-control">
                                                    <option value="">NONE</option>
                                                    <option value="greater_than"><?= esc('>') ?></option>
                                                    <option value="greater_than_equal"><?= esc('>=') ?></option>

                                                    <option value="lower_than"><?= esc('<') ?></option>
                                                    <option value="lower_than_equal"><?= esc('<=') ?></option>
                                                </select>
                                            </div>
                                            <div class="col-8">
                                                <input id="filter_point_value" name="filter_point_value" type="text" class="form-control" value="0" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <table id="tblcustomer" class="table table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th data-priority="1">#</th>
                                    <th data-priority="4">Kode Customer</th>
                                    <th data-priority="2">Nama Customer</th>
                                    <th data-priority="5">Alamat</th>
                                    <th data-priority="5">No Telp</th>
                                    <th data-priority="5">Grup Customer</th>
                                    <th data-priority="7">Poin</th>
                                    <th data-priority="8">Exp. Date</th>
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

            <div class="modal fade" id="modal-customer">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="title-frmcustomer"></h4>
                            <button type="button" class="close close-modal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="frmcustomer" class="form-horizontal">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6 col-xs-12 border-right border-dark">
                                        <input id="customer_id" name="customer_id" value="0" type="hidden">
                                        <div class="form-group">
                                            <label for="customer_code" class="col-sm-12">Kode Customer</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="customer_code" name="customer_code" placeholder="Kode Customer" value="" data-parsley-maxlength="10" data-parsley-trigger-after-failure="focusout" data-parsley-vcustomercode required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="customer_name" class="col-sm-12">Nama Customer</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Nama Customer" value="" data-parsley-maxlength="200" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="customer_birth_date" class="col-sm-12">Tgl. Lahir</label>
                                            <div class="col-sm-12">
                                                <input type="date" class="form-control" id="customer_birth_date" name="customer_birth_date" placeholder="Tgl. Lahir" value="">
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="customer_gender" class="col-sm-12">Jenis Kelamin</label>
                                            <div class="col-sm-12">
                                                <select id="customer_gender" name="customer_gender" class="form-control">
                                                    <option value="P">Perempuan</option>
                                                    <option value="L">Laki-Laki</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="customer_job" class="col-sm-12">Pekerjaan</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="customer_job" name="customer_job" placeholder="Pekerjaan" value="" data-parsley-maxlength="200">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="salesman_id" class="col-sm-12">Salesman</label>
                                            <div class="col-sm-12">
                                                <select id="salesman_id" name="salesman_id" class="form-control"></select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="customer_address" class="col-sm-12">Alamat</label>
                                            <div class="col-sm-12">
                                                <textarea id="customer_address" name="customer_address" class="form-control" placeholder="Alamat" data-parsley-maxlength="500" rows="3" required></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="customer_phone" class="col-sm-12">No Telp</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="customer_phone" name="customer_phone" placeholder="No Telp" value="" data-parsley-pattern="^[0-9+ ]+$" data-parsley-minlength="8" data-parsley-maxlength="15" data-parsley-trigger-after-failure="focusout" data-parsley-vcustomerphone required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="customer_email" class="col-sm-12">Email</label>
                                            <div class="col-sm-12">
                                                <input type="email" class="form-control" id="customer_email" name="customer_email" placeholder="Email" value="" data-parsley-maxlength="200" data-parsley-trigger-after-failure="focusout" data-parsley-vcustomeremail required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="mapping_id" class="col-sm-12">Mapping Area</label>
                                            <div class="col-sm-12">
                                                <select id="mapping_id" name="mapping_id" class="form-control"></select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="active" class="col-sm-12">Status</label>
                                            <div class="col-sm-12">
                                                <select id="active" name="active" class="form-control">
                                                    <option value="Y">Aktif</option>
                                                    <option value="N">Tidak Aktif</option>
                                                </select>
                                            </div>
                                        </div>



                                    </div>
                                    <div class="col-md-6 col-xs-12">

                                        <div class="form-group">
                                            <label for="customer_delivery_address" class="col-sm-12">Alamat Delivery</label>
                                            <div class="col-sm-12">
                                                <textarea id="customer_delivery_address" name="customer_delivery_address" class="form-control" placeholder="Alamat Delivery" data-parsley-maxlength="500" rows="3"></textarea>
                                            </div>
                                        </div>

                                        <h6 class="text-center">Nama dan Alamat Faktur Pajak</h6>
                                        <div class="form-group">
                                            <label for="customer_tax_invoice_name" class="col-sm-12">Nama</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="customer_tax_invoice_name" name="customer_tax_invoice_name" placeholder="Nama" value="" data-parsley-maxlength="200">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="customer_tax_invoice_address" class="col-sm-12">Alamat</label>
                                            <div class="col-sm-12">
                                                <textarea id="customer_tax_invoice_address" name="customer_tax_invoice_address" class="form-control" placeholder="Alamat" data-parsley-maxlength="500" rows="3"></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="customer_npwp" class="col-sm-12">NPWP</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="customer_npwp" name="customer_npwp" placeholder="NPWP" value="" data-parsley-maxlength="50">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="customer_nik" class="col-sm-12">NIK</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="customer_nik" name="customer_nik" placeholder="Nama" value="" data-parsley-maxlength="50">
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="customer_remark" class="col-sm-12">Keterangan</label>
                                            <div class="col-sm-12">
                                                <textarea id="customer_remark" name="customer_remark" class="form-control" placeholder="Keterangan" data-parsley-maxlength="500" rows="3"></textarea>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="customer_group" class="col-sm-12">Grup</label>
                                            <div class="col-sm-12">
                                                <select id="customer_group" name="customer_group" class="form-control">
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



                                        <div class="form-group">
                                            <label for="exp_date" class="col-sm-12">Exp. Date</label>
                                            <div class="col-sm-12">
                                                <input type="date" class="form-control" id="exp_date" name="exp_date" placeholder="Exp. Date" value="" required>
                                            </div>
                                        </div>


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
        let filter_point_value = new AutoNumeric('#filter_point_value', configQty);

        function _initButton() {
            $('#btnadd').prop('disabled', !hasRole('customer.add'));
            if (!hasRole('customer.edit')) {
                $('.btnedit').prop('disabled', false);
            }

            if (!hasRole('customer.delete')) {
                $('.btndelete').prop('disabled', false);
            }
        }

        const randomString = (length = 8) => {
            // Declare all characters
            let chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

            // Pick characers randomly
            let str = '';
            for (let i = 0; i < length; i++) {
                str += chars.charAt(Math.floor(Math.random() * chars.length));
            }

            return str;
        };

        // datatables //
        let tblcustomer = $("#tblcustomer").DataTable({
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
                url: base_url + '/webmin/customer/table',
                type: "POST",
                data: function(d) {
                    return $.extend({}, d, {
                        'filter_customer_group': $('#filter_customer_group').val(),
                        'filter_point_by': $('#filter_point_by').val(),
                        'filter_point_value': $('#filter_point_value').val(),
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
                    targets: [8],
                    orderable: false,
                    searchable: false,
                },
                {
                    targets: [5],
                    className: "text-center",
                },
                {
                    targets: [0, 6],
                    className: "text-right",
                },
            ],
        });

        function updateTable() {
            tblcustomer.ajax.reload(null, false);
        }

        $('#btnreload').click(function(e) {
            e.preventDefault();
            updateTable();
        })


        $('#filter_customer_group').change(function(e) {
            updateTable();
        })

        $('#filter_point_by').change(function(e) {
            updateTable();
        })

        $('#filter_point_value').on('change blur', function(e) {
            let fp = filter_point_value.getNumericString();
            if (fp == null || fp == '') {
                filter_point_value.set(0);
            } else {
                if (parseFloat(fp) < 0) {
                    filter_point_value.set(0);
                }
            }
            updateTable();
        })



        // select2 //
        $("#mapping_id").select2({
            placeholder: '-- Pilih Area --',
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

        $("#salesman_id").select2({
            placeholder: '-- Pilih Area --',
            width: "100%",
            allowClear: true,
            ajax: {
                url: base_url + "/webmin/select/salesman",
                dataType: "json",
                type: "GET",
                delay: select2Delay,
                data: function(params) {
                    return {
                        store_id: 1,
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

        // validation //
        function checkCode(customer_code) {
            if (customer_code.toUpperCase() == 'AUTO') {
                return true;
            } else {
                let actUrl = base_url + '/webmin/customer/getbycode';
                useLoader = false;
                let getData = ajax_get(actUrl, {
                    customer_code: customer_code
                }, {}, false);
                useLoader = true;

                if (getData.success) {
                    let result = getData.result;
                    if (result.exist) {
                        let uID = result.data.customer_id;
                        if (uID.toUpperCase() == $("#customer_id").val().toUpperCase()) {
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
        }

        function checkEmail(customer_email) {
            let actUrl = base_url + '/webmin/customer/getbyemail';
            useLoader = false;
            let getData = ajax_get(actUrl, {
                customer_email: customer_email
            }, {}, false);
            useLoader = true;

            if (getData.success) {
                let result = getData.result;
                if (result.exist) {
                    let uID = result.data.customer_id;
                    if (uID.toUpperCase() == $("#customer_id").val().toUpperCase()) {
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

        function checkPhone(customer_phone) {
            let actUrl = base_url + '/webmin/customer/getbyphone';
            useLoader = false;
            let getData = ajax_get(actUrl, {
                customer_phone: customer_phone
            }, {}, false);
            useLoader = true;

            if (getData.success) {
                let result = getData.result;
                if (result.exist) {
                    let uID = result.data.customer_id;
                    if (uID.toUpperCase() == $("#customer_id").val().toUpperCase()) {
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
            vcustomercode: 'Kode customer sudah terdaftar',
            vcustomeremail: 'Email customer sudah terdaftar',
            vcustomerphone: 'No Telp customer sudah terdaftar'
        });

        Parsley.setLocale('id');

        window.Parsley.addValidator("vcustomercode", {
            validateString: function(value) {
                return checkCode(value)
            },
        });

        window.Parsley.addValidator("vcustomeremail", {
            validateString: function(value) {
                return checkEmail(value)
            },
        });

        window.Parsley.addValidator("vcustomerphone", {
            validateString: function(value) {
                return checkPhone(value)
            },
        });

        function addMode() {
            let form = $('#frmcustomer');
            $('#title-frmcustomer').html('Tambah Customer');
            form.parsley().reset();
            formMode = 'add';
            $('#customer_id').val('0');
            $('#customer_code').val('AUTO').prop('readonly', false);
            $('#customer_name').val('');
            $('#customer_phone').val('');
            $('#customer_address').val('');
            let dummy_email = 'u' + randomString(10).toLowerCase() + '@dbig.com';
            $('#customer_email').val(dummy_email);
            $('#customer_group').val('G1');
            setSelect2('#mapping_id');
            $('#exp_date').val('2050-01-01');
            $('#active').val('Y');


            $('#customer_birth_date').val('');
            $('#customer_gender').val('L');
            $('#customer_job').val('');
            setSelect2('#salesman_id');
            $('#customer_remark').val('');
            $('#customer_delivery_address').val('');
            $('#customer_npwp').val('');
            $('#customer_nik').val('');
            $('#customer_tax_invoice_name ').val('');
            $('#customer_tax_invoice_address').val('');

            $('#modal-customer').modal(configModal);
        }

        function editMode(data) {
            let form = $('#frmcustomer');
            $('#title-frmcustomer').html('Ubah Customer');
            form.parsley().reset();
            formMode = 'edit';
            $('#customer_id').val(data.customer_id);
            $('#customer_code').val(htmlEntities.decode(data.customer_code)).prop('readonly', true);
            $('#customer_name').val(htmlEntities.decode(data.customer_name));
            $('#customer_phone').val(htmlEntities.decode(data.customer_phone));
            $('#customer_address').val(htmlEntities.decode(data.customer_address));
            $('#customer_email').val(htmlEntities.decode(data.customer_email));
            $('#customer_group').val(data.customer_group);
            let mapping_id = parseFloat(data.mapping_id);
            if (mapping_id == 0) {
                setSelect2('#mapping_id');
            } else {
                let mapping_text = htmlEntities.decode(data.mapping_code + ' - ' + data.mapping_address);
                setSelect2('#mapping_id', mapping_id, mapping_text);
            }

            $('#exp_date').val(data.exp_date);
            $('#active').val(data.active);

            $('#customer_birth_date').val(data.customer_birth_date);
            $('#customer_gender').val(data.customer_gender);
            $('#customer_job').val(htmlEntities.decode(data.customer_job));

            let salesman_id = parseFloat(data.salesman_id);
            if (salesman_id == 0) {
                setSelect2('#salesman_id');
            } else {
                let salesman_text = htmlEntities.decode(data.salesman_code + ' - ' + data.salesman_name);
                setSelect2('#salesman_id', salesman_id, salesman_text);
            }

            $('#customer_remark').val(htmlEntities.decode(data.customer_remark));
            $('#customer_delivery_address').val(htmlEntities.decode(data.customer_delivery_address));
            $('#customer_npwp').val(htmlEntities.decode(data.customer_npwp));
            $('#customer_nik').val(htmlEntities.decode(data.customer_nik));
            $('#customer_tax_invoice_name').val(htmlEntities.decode(data.customer_tax_invoice_name));
            $('#customer_tax_invoice_address').val(htmlEntities.decode(data.customer_tax_invoice_address));

            $('#modal-customer').modal(configModal);
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
                    $('#modal-customer').modal('hide');
                }
            })
        })

        $('#btnsave').click(function(e) {
            e.preventDefault();
            let form = $('#frmcustomer');
            let btnSubmit = $('#btnsave')
            form.parsley().validate();
            if (form.parsley().isValid()) {
                let question = 'Yakin ingin menyimpan data customer?';
                let actUrl = base_url + '/webmin/customer/save/add';
                if (formMode == 'edit') {
                    question = 'Yakin ingin memperbarui data customer?';
                    actUrl = base_url + '/webmin/customer/save/edit';
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
                                        notification.success(response.result.message);
                                        form.parsley().reset();
                                        $('#modal-customer').modal('hide');
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

        $("#tblcustomer").on('click', '.btnedit', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let actUrl = base_url + '/webmin/customer/getbyid/' + id;
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

        $("#tblcustomer").on('click', '.btndelete', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let customer_name = $(this).attr('data-name');
            let question = 'Yakin ingin menghapus customer <b>' + customer_name + '</b>?';
            let actUrl = base_url + '/webmin/customer/delete/' + id;
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

        $("#tblcustomer").on('click', '.btnresetpassword', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let customer_name = $(this).attr('data-name');
            let question = 'Yakin ingin mereset password customer <b>' + customer_name + '</b>?';
            let actUrl = base_url + '/webmin/customer/reset-password/' + id;
            message.question(question).then(function(answer) {
                let yes = parseMessageResult(answer);
                if (yes) {
                    ajax_get(actUrl, null, {
                        success: function(response) {
                            if (response.success) {
                                if (response.result.success) {
                                    let info_text = 'Password customer <b>' + customer_name + '</b> berhasil direset menjadi <b>' + response.result.new_password + '</b>';
                                    message.info(info_text);
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



        filter_point_value.set(0);
        _initButton();
    })
</script>
<?= $this->endSection() ?>