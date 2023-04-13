<?= $this->extend('webmin/template/report_F4_template') ?>

<?= $this->section('css') ?>
<style>
    * {
        margin: 0px;
        padding: 0px;
        font-size: 10px;
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        font-family: Calibri, Candara, Segoe, Segoe UI, Optima, Arial, sans-serif;
    }

    .font-primary {
        font-family: Arial, Helvetica, sans-serif;
    }

    .font-secondary {
        font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    }


    .voucher {
        width: 15cm;
        height: 7cm;
        margin: auto;
        border: 1px solid #000;
        background-image: url("data:image/png;base64,<?= $cover_background ?>");
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
    }

    .voucher-code {
        padding: 0px 10px;
        font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        vertical-align: top;
        text-align: right;
        font-size: 25;
    }

    .voucher-exp-date {
        padding: 0px 10px;
        font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        vertical-align: bottom;
        text-align: left;
        font-size: 25;
    }
</style>
<?= $this->endSection() ?>


<?= $this->section('content') ?>


<!-- page 1/2 -->
<div style="page-break-after:always;margin:0px;padding:0px;">
    <table width="100%">
        <tr>
            <td>
                <table class="voucher">
                    <tr>
                        <td class="voucher-code" style="height:100px;">0476767676767</td>
                    </tr>
                    <tr>
                        <td style="height:100px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="voucher-exp-date" style="height:20px;">Exp Date : 31/01/2023</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</div>
<?= $this->endSection() ?>