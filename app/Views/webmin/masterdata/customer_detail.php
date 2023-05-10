<?php
$themeUrl = base_url('assets/adminlte3');
$assetsUrl = base_url('assets');
$product_status = 'Y' == 'Y' ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-danger">Tidak Aktif</span>';
$product_type   = 'N' == 'Y' ? 'Barang Kena Pajak (BKP)' : 'Barang Tidak Dikenakan Pajak (NON BKP)';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Customer</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= $themeUrl ?>/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= $themeUrl ?>/dist/css/adminlte.min.css">
</head>

<body>
    <div class="wrapper">
        <!-- Main content -->
        <section class="invoice">
            <!-- title row -->
            <div class="row">
                <div class="col-12">
                    <h2 class="page-header">
                        Detail Customer
                        <small class="float-right"></small>
                    </h2>
                </div>
                <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                    <address>
                        <strong><?= COMPANY_NAME ?></strong><br>
                        <?= COMPANY_ADDRESS ?><br>
                        <i class="fa fas-phone"></i> <?= COMPANY_PHONE ?><br>
                    </address>
                </div>
                <div class="col-sm-4 invoice-col">

                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    <b>#<?= $customer['customer_code'] ?></b><br>
                </div>
                <!-- /.col -->
            </div>
            <br>
            <!-- /.row -->

            <!-- Table row -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#profiles" data-toggle="tab">Data Diri</a></li>

                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="profiles">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <td width="150px" class="text-right"><b>Kode Customer&nbsp;:&nbsp;</b></td>
                                                        <td><?= esc($customer['customer_code']) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><b>Nama Customer&nbsp;:&nbsp;</b></td>
                                                        <td><?= esc($customer['customer_name']) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><b>Tgl.Lahir&nbsp;:&nbsp;</b></td>
                                                        <td><?= indo_date($customer['customer_birth_date']) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><b>Grup&nbsp;:&nbsp;</b></td>
                                                        <td><?= $member_group_label ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><b>Jenis Kelamin&nbsp;:&nbsp;</b></td>
                                                        <td><?= $customer['customer_gender'] == 'L' ? 'Laki-Laki' : 'Perempuan' ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><b>Pekerjaan&nbsp;:&nbsp;</b></td>
                                                        <td><?= esc($customer['customer_job']) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><b>Salesman&nbsp;:&nbsp;</b></td>
                                                        <td><?= $customer['salesman_id'] == '0' ? '-' : esc($customer['salesman_code'] . ' - ' . $customer['salesman_name']) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><b>Alamat&nbsp;:&nbsp;</b></td>
                                                        <td><?= nl2br(esc($customer['customer_address'])) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><b>Blok &nbsp;:&nbsp;</b></td>
                                                        <td><?= esc($customer['customer_address_block']) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><b>No Rumah &nbsp;:&nbsp;</b></td>
                                                        <td><?= esc($customer['customer_address_number']) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><b>RT/RW&nbsp;:&nbsp;</b></td>
                                                        <td><?= esc($customer['customer_address_rt']) ?>/<?= esc($customer['customer_address_rw']) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><b>No Telp&nbsp;:&nbsp;</b></td>
                                                        <td><?= esc($customer['customer_phone']) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><b>Email&nbsp;:&nbsp;</b></td>
                                                        <td><?= esc($customer['customer_email']) ?> <?= $customer['verification_email'] == 'Y' ? '<span class="badge badge-success"><i class="fas fa-check-circle"></i></span>' : '<span class="badge badge-danger"><i class="fas fa-times-circle"></i></span>' ?></td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-right"><b>Poin&nbsp;:&nbsp;</b></td>
                                                        <td><?= numberFormat($customer['customer_point'], TRUE) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><b>Status&nbsp;:&nbsp;</b></td>
                                                        <td><?= $customer['active'] == 'Y' ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-danger">Tidak Aktif</span>' ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><b>Tgl.Registrasi&nbsp;:&nbsp;</b></td>
                                                        <td><?= indo_short_date($customer['created_at'], TRUE) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><b>Tgl.Exp&nbsp;:&nbsp;</b></td>
                                                        <td><?= indo_short_date($customer['exp_date'], FALSE) ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">

                                                    <tr>
                                                        <td width="150px" class="text-right"><b>Alamat Delivery&nbsp;:&nbsp;</b></td>
                                                        <td><?= nl2br(esc($customer['customer_delivery_address'])) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" class="text-center"><b>Nama dan Alamat Faktur Pajak</b></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><b>Nama&nbsp;:&nbsp;</b></td>
                                                        <td><?= esc($customer['customer_tax_invoice_name']) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><b>Alamat&nbsp;:&nbsp;</b></td>
                                                        <td><?= nl2br(esc($customer['customer_tax_invoice_address'])) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><b>NPWP&nbsp;:&nbsp;</b></td>
                                                        <td><?= esc($customer['customer_npwp']) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><b>NIK&nbsp;:&nbsp;</b></td>
                                                        <td><?= esc($customer['customer_nik']) ?></td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="2" class="text-center"><b>Lain-Lain</b></td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-right"><b>Mapping Area&nbsp;:&nbsp;</b></td>
                                                        <td><?= $customer['mapping_id'] == '0' ? '-' : esc($customer['mapping_code'] . ' - ' . $customer['mapping_address']) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><b>Kode Referral&nbsp;:&nbsp;</b></td>
                                                        <td><?= esc($customer['referral_code']) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><b>Diundang Oleh&nbsp;:&nbsp;</b></td>
                                                        <td><?= $invite_by == NULL ? '-' : esc($invite_by['customer_code'] . ' - ' . $invite_by['customer_name']) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><b>Keterangan&nbsp;:&nbsp;</b></td>
                                                        <td><?= esc($customer['customer_remark']) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><b>Terakhir Login&nbsp;:&nbsp;</b></td>
                                                        <?php $last_login = indo_short_date($customer['last_login'], TRUE) ?>
                                                        <td><?= $last_login == '' ? '-' : $last_login ?></td>
                                                    </tr>


                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                </div>
            </div>


        </section>
        <!-- /.content -->
    </div>
    <!-- ./wrapper -->
    <!-- Page specific script -->
</body>

</html>