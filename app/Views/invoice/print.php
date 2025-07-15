<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice Print</title>
    <style>
        body {
            background: #fff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }
        
        /* Print specific styles */
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            .invoice-box {
                max-width: 100%;
                margin: 0;
                padding: 15px;
                border: none;
                box-shadow: none;
                font-size: 12px;
                line-height: 16px;
            }
            .print-btn-container {
                display: none;
            }
        }
        
        .invoice-box {
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #eee;
            background: #fff;
            font-size: 14px;
            line-height: 20px;
            color: #555;
            box-shadow: 0 0 10px rgba(0,0,0,0.08);
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
        .no-print {
            display: block;
            margin-bottom: 16px;
        }
        @media print {
            .no-print { display: none !important; }
            body { background: #fff; }
            .invoice-box {
                box-shadow: none !important;
                border: none !important;
                margin: 0 !important;
                width: 100% !important;
                padding: 0 !important;
            }
        }
        .pretty-print-btn {
            background: linear-gradient(90deg, #1976d2 0%, #42a5f5 100%);
            color: #fff;
            border: none;
            border-radius: 24px;
            padding: 10px 28px 10px 18px;
            font-size: 1.1em;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(25, 118, 210, 0.10);
            cursor: pointer;
            transition: background 0.2s, box-shadow 0.2s, transform 0.1s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .pretty-print-btn:hover {
            background: linear-gradient(90deg, #1565c0 0%, #1e88e5 100%);
            box-shadow: 0 4px 16px rgba(25, 118, 210, 0.18);
            transform: translateY(-2px) scale(1.03);
        }
        .pretty-print-btn svg {
            width: 20px;
            height: 20px;
            fill: #fff;
        }
    </style>
</head>
<body onload="window.print()">
    <div class="print-btn-container no-print" style="text-align:right; max-width:900px; margin:20px auto 0 auto;">
        <button onclick="window.print()" class="pretty-print-btn">
            <svg viewBox="0 0 24 24"><path d="M19 8H5c-1.1 0-2 .9-2 2v6c0 1.1.9 2 2 2h1v2c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2v-2h1c1.1 0 2-.9 2-2v-6c0-1.1-.9-2-2-2zm-3 10H8v-4h8v4zm3-6c-.55 0-1 .45-1 1s.45 1 1 1 1-.45 1-1-.45-1-1-1zm-2-8v4H6V4c0-1.1.9-2 2-2h6c1.1 0 2 .9 2 2z"/></svg>
            Print
        </button>
    </div>
    <div class="invoice-box">
        <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 20px;">
            <div style="flex: 0 0 auto;">
                <img src="<?= base_url('assets/images/logo-jaya-beton.png') ?>" alt="Logo Jaya Beton" style="height: 60px;">
            </div>
            <div style="flex: 1; text-align: center; margin-top: 40px; margin-bottom: 10px;">
                <span style="font-size: 2em; font-weight: 500; letter-spacing: 2px; color: #333;">INVOICE</span>
            </div>
            <div style="flex: 0 0 auto; width: 200px;"></div>
        </div>
        <table>
            <tr>
                <td style="width: 50%; vertical-align: top; padding-right: 20px;">
                    Medan, <?= $invoice['tgl_so'] ?? 'xx-xx-xxxx' ?><br>
                    <br>
                    No Invoice : <?= $invoice['no_invoice'] ?? 'Mdn-xx/xxxx' ?><br>
                    PO        : <?= $invoice['no_po'] ?? 'xxx' ?><br>
                    Tanggal   : <?= $invoice['tgl_so'] ?? 'xx/xx/xxxx' ?>
                </td>
                </td>
                <td style="width: 50%; vertical-align: top; padding-left: 20px;">
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
                <th style="width:30px;">No</th>
                <th>Uraian</th>
                <th style="width:80px;">Quantity<br>(Btg)</th>
                <th style="width:100px;">Harga<br>(Rp/Btg)</th>
                <th style="width:120px;">Total Harga</th>
            </tr>
        <?php 
        // Ambil data dari invoice untuk pelunasan
        $total_harga = $invoice['total_harga'] ?? 0;
        $ppn_percent = ($invoice['ppn'] ?? 11) / 100;
        
        // Hitung subtotal (sebelum PPN)
        $subtotal = $total_harga / (1 + $ppn_percent);
        
        // PPN dari subtotal
        $ppn_amount = $subtotal * $ppn_percent;
        
        // Total quantity dan harga satuan
        $quantity = $invoice['order_btg'] ?? 0;
        $harga_satuan = $quantity > 0 ? $subtotal / $quantity : 0;
        ?>
            <tr class="item">
                <td class="text-center">1</td>
                <td>
                    Pelunasan atas pengadaan <?= $invoice['nama_jenis_produk'] ?? 'PC SPUN PILE' ?><br>
                    Berdasarkan PO. <?= $invoice['no_po'] ?? 'xxxxx' ?>, Tanggal <?= date('d M Y', strtotime($invoice['tgl_so'] ?? '')) ?><br>
                    <br>
                    <?= $invoice['kode_kategori_produk_'] ?? 'PCA' ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $invoice['nama_kategori_produk'] ?? '600 - 12 UP' ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $invoice['order_btg'] ?? '12' ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Btg
                </td>
                <td class="text-center"><?= $invoice['order_btg'] ?? '-' ?></td>
                <td class="text-center"><?= number_format($harga_satuan, 0, ',', '.') ?></td>
                <td class="text-right"><?= number_format($subtotal, 0, ',', '.') ?></td>
            </tr>
            <tr>
                <td colspan="4" class="text-right text-bold">Jumlah</td>
                <td class="text-right text-bold"><?= number_format($subtotal, 0, ',', '.') ?></td>
            </tr>
            <tr class="item">
                <td class="text-center">2</td>
                <td>P P N<br><?= number_format($invoice['ppn'] ?? 11, 0) ?>% &nbsp;&nbsp;&nbsp; x &nbsp;&nbsp;&nbsp; <?= number_format($subtotal, 0, ',', '.') ?></td>
                <td class="text-center">-</td>
                <td class="text-center">-</td>
                <td class="text-right"><?= number_format($ppn_amount, 0, ',', '.') ?></td>
            </tr>
            <tr>
                <td colspan="4" class="text-right text-bold">Jumlah yang akan dibayar oleh <?= $invoice['nama_rek'] ?? 'PT. WASHITA - PERMATA KSO' ?></td>
                <td class="text-right text-bold"><?= number_format($total_harga, 0, ',', '.') ?></td>
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
                    Please make your cheque payable to :<br>
                    PT JAYA BETON INDONESIA<br>
                    or by wire transfer to :<br>
                    <br>
                    Transfer to :<br>
                    BCA Cab KIM<br>
                    Account No. 8195073003<br>
                    <br>
                    BCA Cab KIM II<br>
                    Account No. 0058936258
                </td>
                <td style="vertical-align:top; text-align:right;">
                    PT JAYA BETON INDONESIA<br><br><br>
                    Wahyudi<br>
                    Pj. General Manager
                </td>
            </tr>
        </table>
    </div>
    
</body>
</html> 