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
        <?php 
        // Hitung mundur subtotal dari total_harga yang sudah termasuk PPN
        $total_harga = $invoice['total_harga'] ?? 0;
        $ppn_percent = ($invoice['ppn'] ?? 11) / 100;
        
        // total_harga = subtotal + (subtotal * ppn_percent)
        // total_harga = subtotal * (1 + ppn_percent)
        // subtotal = total_harga / (1 + ppn_percent)
        $subtotal = $total_harga / (1 + $ppn_percent);
        
        // Uang muka 20% dari subtotal (sebelum PPN)
        $uang_muka = $subtotal * 0.20;
        
        // PPN 11% dari uang muka
        $ppn_uang_muka = $uang_muka * 0.11;
        
        // Total yang harus dibayar
        $total_bayar = $uang_muka + $ppn_uang_muka;
        ?>
        <tr class="item">
            <td class="text-center">1</td>
            <td>
                Uang muka 20% atas pengadaan <?= $invoice['nama_jenis_produk'] ?? 'PC PILE xxx' ?><br>
                Berdasarkan PO. <?= $invoice['no_po'] ?? 'xxxxx' ?>, Tanggal <?= $invoice['tgl_so'] ?? 'xx-xx-xxxx' ?><br>
                20% X <?= number_format($subtotal, 0, ',', '.') ?>
            </td>
            <td class="text-center">-</td>
            <td class="text-center">-</td>
            <td class="text-right"><?= number_format($uang_muka, 0, ',', '.') ?></td>
        </tr>
        <tr>
            <td colspan="4" class="text-right text-bold">Jumlah</td>
            <td class="text-right text-bold"><?= number_format($uang_muka, 0, ',', '.') ?></td>
        </tr>
        <tr class="item">
            <td class="text-center">2</td>
            <td>PPN<br>11% X <?= number_format($uang_muka, 0, ',', '.') ?></td>
            <td class="text-center">-</td>
            <td class="text-center">-</td>
            <td class="text-right"><?= number_format($ppn_uang_muka, 0, ',', '.') ?></td>
        </tr>
        <tr>
            <td colspan="4" class="text-right text-bold">Jumlah yang akan dibayar oleh PT. <?= $invoice['nama_rek'] ?? 'xxxxx' ?></td>
            <td class="text-right text-bold"><?= number_format($total_bayar, 0, ',', '.') ?></td>
        </tr>
    </table>
    <br>
    <b>Terbilang :</b><br>
    <div style="border:1px solid #000; padding:8px; margin-bottom:16px;">
        <?php 
        // Fungsi terbilang sederhana untuk view
        function terbilang($angka)
        {
            $angka = round(abs($angka)); // Pastikan angka bulat
            $baca = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
            $hasil = "";
            
            if ($angka < 12) {
                $hasil = $baca[$angka];
            } else if ($angka < 20) {
                $hasil = terbilang($angka - 10) . " Belas";
            } else if ($angka < 100) {
                $hasil = terbilang(intval($angka / 10)) . " Puluh";
                if ($angka % 10 != 0) {
                    $hasil .= " " . terbilang($angka % 10);
                }
            } else if ($angka < 200) {
                $hasil = "Seratus";
                if ($angka - 100 != 0) {
                    $hasil .= " " . terbilang($angka - 100);
                }
            } else if ($angka < 1000) {
                $hasil = terbilang(intval($angka / 100)) . " Ratus";
                if ($angka % 100 != 0) {
                    $hasil .= " " . terbilang($angka % 100);
                }
            } else if ($angka < 2000) {
                $hasil = "Seribu";
                if ($angka - 1000 != 0) {
                    $hasil .= " " . terbilang($angka - 1000);
                }
            } else if ($angka < 1000000) {
                $hasil = terbilang(intval($angka / 1000)) . " Ribu";
                if ($angka % 1000 != 0) {
                    $hasil .= " " . terbilang($angka % 1000);
                }
            } else if ($angka < 1000000000) {
                $hasil = terbilang(intval($angka / 1000000)) . " Juta";
                if ($angka % 1000000 != 0) {
                    $hasil .= " " . terbilang($angka % 1000000);
                }
            } else if ($angka < 1000000000000) {
                $hasil = terbilang(intval($angka / 1000000000)) . " Milyar";
                if ($angka % 1000000000 != 0) {
                    $hasil .= " " . terbilang($angka % 1000000000);
                }
            } else if ($angka < 1000000000000000) {
                $hasil = terbilang(intval($angka / 1000000000000)) . " Triliun";
                if ($angka % 1000000000000 != 0) {
                    $hasil .= " " . terbilang($angka % 1000000000000);
                }
            }
            
            return trim($hasil);
        }
        
        // Gunakan total_bayar yang sudah dihitung dengan benar
        $total_final = round($total_bayar);
        echo terbilang($total_final);
        ?> Rupiah
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