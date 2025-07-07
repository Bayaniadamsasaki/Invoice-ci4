<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<style>
.invoice-box {
    max-width: 900px;
    margin: auto;
    padding: 30px;
    border: 1px solid #eee;
    background: #fff;
    font-size: 16px;
    line-height: 24px;
    color: #555;
}
.invoice-box table {
    width: 100%;
    line-height: inherit;
    text-align: left;
    border-collapse: collapse;
}
.invoice-box table td {
    padding: 5px;
    vertical-align: top;
}
.invoice-box table tr.heading th {
    background: #eee;
    border-bottom: 1px solid #ddd;
    font-weight: bold;
    text-align: center;
}
.invoice-box table tr.item td {
    border-bottom: 1px solid #eee;
}
.invoice-box .logo {
    width: 80px;
}
.invoice-box .text-right {
    text-align: right;
}
.invoice-box .text-center {
    text-align: center;
}
.invoice-box .text-bold {
    font-weight: bold;
}
.invoice-box .border-top {
    border-top: 1px solid #000;
}
</style>
<div class="invoice-box">
    <table>
        <tr>
            <td colspan="2">
                <img src="<?= base_url('path/to/logo.png') ?>" class="logo" alt="Logo">
                <span style="font-size: 1.5em; font-weight: bold; vertical-align: middle;">JAYA BETON</span>
            </td>
            <td colspan="3" class="text-center" style="font-size: 1.5em; font-weight: bold;">INVOICE</td>
        </tr>
        <tr>
            <td colspan="5" style="height: 10px;"></td>
        </tr>
        <tr>
            <td colspan="2">
                Medan, <?= $invoice['tgl_so'] ?? 'xx-xx-xxxx' ?><br>
                <br>
                No Invoice : <?= $invoice['no_invoice'] ?? 'Mdn-xx/xxxx' ?><br>
                PO        : <?= $invoice['no_po'] ?? 'xxx' ?><br>
                Tanggal   : <?= $invoice['tgl_so'] ?? 'xx/xx/xxxx' ?>
            </td>
            <td colspan="3">
                Kepada :<br>
                <?= $invoice['nama_rek'] ?? 'PT xxxx' ?><br>
                Alamat : <?= $invoice['alamat'] ?? 'xxxxx' ?><br>
                NPWP   : <?= $invoice['npwp'] ?? 'xxxxx' ?>
            </td>
        </tr>
    </table>
    <br>
    <table border="1">
        <tr class="heading">
            <th style="width:30px;">NO</th>
            <th>Uraian</th>
            <th style="width:80px;">Total Btg</th>
            <th style="width:80px;">Berat Ton</th>
            <th style="width:120px;">Total Harga</th>
        </tr>
        <tr class="item">
            <td class="text-center">1</td>
            <td>
                Uang muka 20% atas pengadaan <?= $invoice['nama_jenis_produk'] ?? 'PC PILE xxx' ?><br>
                Berdasarkan PO. <?= $invoice['no_po'] ?? 'xxxxx' ?>, Tanggal <?= $invoice['tgl_so'] ?? 'xx-xx-xxxx' ?><br>
                20% X <?= number_format($invoice['total_harga'] ?? 0, 0, ',', '.') ?>
            </td>
            <td class="text-center">-</td>
            <td class="text-center">-</td>
            <td class="text-right"><?= number_format($invoice['total_harga'] ?? 0, 0, ',', '.') ?></td>
        </tr>
        <tr>
            <td colspan="4" class="text-right text-bold">Jumlah</td>
            <td class="text-right text-bold"><?= number_format($invoice['total_harga'] ?? 0, 0, ',', '.') ?></td>
        </tr>
        <tr class="item">
            <td class="text-center">2</td>
            <td>PPN<br>11% X <?= number_format($invoice['total_harga'] ?? 0, 0, ',', '.') ?></td>
            <td class="text-center">-</td>
            <td class="text-center">-</td>
            <td class="text-right">
                <?php $ppn = round(($invoice['total_harga'] ?? 0) * 0.11); ?>
                <?= number_format($ppn, 0, ',', '.') ?>
            </td>
        </tr>
        <tr>
            <td colspan="4" class="text-right text-bold">Jumlah yang akan dibayar oleh PT. <?= $invoice['nama_rek'] ?? 'xxxxx' ?></td>
            <td class="text-right text-bold">
                <?php $total = ($invoice['total_harga'] ?? 0) + $ppn; ?>
                <?= number_format($total, 0, ',', '.') ?>
            </td>
        </tr>
    </table>
    <br>
    <b>Terbilang :</b><br>
    <div style="border:1px solid #000; padding:8px; margin-bottom:16px;">
        <?= $terbilang ?? '(terbilang otomatis di sini)' ?> Rupiah
    </div>
    <br>
    <table style="width:100%;">
        <tr>
            <td style="width:60%; vertical-align:top;">
                Transfer to :<br>
                BCA Cab KIM<br>
                Account No. 8195073003<br>
                <br>
                BCA Cab KIM II<br>
                Account No. 0058936258
            </td>
            <td style="vertical-align:top; text-align:right;">
                PT JAYA BETON PLANT INDONESIA<br><br><br>
                Wahyudi<br>
                Pj. General Manager
            </td>
        </tr>
    </table>
</div>
<?= $this->endSection() ?> 