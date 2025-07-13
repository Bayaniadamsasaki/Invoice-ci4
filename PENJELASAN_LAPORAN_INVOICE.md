# 📋 PENJELASAN LAPORAN INVOICE
## Sistem Invoice PT Jaya Beton

---

## 🔍 **OVERVIEW**

Laporan Invoice adalah dokumen yang menampilkan perhitungan uang muka 20% dari kontrak pemesanan dengan perhitungan PPN yang benar (tanpa double taxation).

---

## 🧮 **PERHITUNGAN STEP BY STEP**

### **📊 Data Dasar**
- **Total Harga Kontrak**: Nilai kontrak yang sudah termasuk PPN 11%
- **Uang Muka**: 20% dari nilai kontrak (sebelum PPN)
- **PPN**: 11% dari nilai uang muka

### **🔢 Formula Perhitungan**

#### **STEP 1: Hitung Subtotal (Harga Sebelum PPN)**
```
Subtotal = Total Harga Kontrak ÷ (1 + PPN%)
Subtotal = Total Harga Kontrak ÷ 1.11
```

#### **STEP 2: Hitung Uang Muka 20%**
```
Uang Muka = 20% × Subtotal
```

#### **STEP 3: Hitung PPN dari Uang Muka**
```
PPN Uang Muka = 11% × Uang Muka
```

#### **STEP 4: Total yang Harus Dibayar**
```
Total Bayar = Uang Muka + PPN Uang Muka
```

---

## 📝 **CONTOH PERHITUNGAN**

### **Skenario: Invoice No. 3**
- **Kontrak Total**: Rp 12.000.000 (sudah + PPN 11%)
- **Produk**: Beton Instan
- **PO**: PO-003

### **Perhitungan Detail:**

| Step | Keterangan | Rumus | Hasil |
|------|------------|-------|-------|
| 1 | **Subtotal** | 12.000.000 ÷ 1.11 | **Rp 10.810.811** |
| 2 | **Uang Muka 20%** | 20% × 10.810.811 | **Rp 2.162.162** |
| 3 | **PPN 11%** | 11% × 2.162.162 | **Rp 237.838** |
| 4 | **Total Bayar** | 2.162.162 + 237.838 | **Rp 2.400.000** |

---

## 📋 **STRUKTUR LAPORAN INVOICE**

### **Header Invoice**
```
JAYA BETON                    INVOICE
Medan, [Tanggal]

No Invoice : [Nomor]
PO        : [Nomor PO]         Kepada : [Nama Customer]
Tanggal   : [Tanggal]          Alamat : [Alamat Customer]
                               NPWP   : [NPWP Customer]
```

### **Tabel Detail**

| NO | Uraian | Total Btg | Berat Ton | Total Harga |
|----|--------|-----------|-----------|-------------|
| 1 | **Uang muka 20%** atas pengadaan [Produk]<br>Berdasarkan PO. [No PO], Tanggal [Tanggal]<br>20% X [Subtotal] | - | - | [Uang Muka] |
| | **Jumlah** | | | [Uang Muka] |
| 2 | **PPN**<br>11% X [Uang Muka] | - | - | [PPN Amount] |
| | **Jumlah yang akan dibayar oleh PT. [Customer]** | | | **[Total Bayar]** |

### **Terbilang**
```
Terbilang: [Angka dalam Huruf] Rupiah
```

---

## ⚠️ **PENTING: PENCEGAHAN PPN GANDA**

### **❌ Perhitungan SALAH (PPN Ganda)**
```
❌ Uang Muka = 20% × Total Harga (yang sudah + PPN)
❌ PPN = 11% × Uang Muka 
❌ Hasil: Customer bayar PPN 2 kali!
```

### **✅ Perhitungan BENAR (PPN Sekali)**
```
✅ Subtotal = Total Harga ÷ 1.11
✅ Uang Muka = 20% × Subtotal (sebelum PPN)
✅ PPN = 11% × Uang Muka
✅ Hasil: Customer bayar PPN 1 kali saja!
```

---

## 🔧 **IMPLEMENTASI TEKNIS**

### **Controller: Laporan.php**
```php
// Hitung mundur subtotal dari total_harga yang sudah termasuk PPN
$total_harga = $invoice['total_harga'] ?? 0;
$ppn_percent = ($invoice['ppn'] ?? 11) / 100;
$subtotal = $total_harga / (1 + $ppn_percent);

// Uang muka 20% dari subtotal (sebelum PPN)
$uang_muka = $subtotal * 0.20;

// PPN 11% dari uang muka
$ppn_uang_muka = $uang_muka * 0.11;

// Total yang harus dibayar
$total_bayar = $uang_muka + $ppn_uang_muka;
```

### **View: laporan/invoice.php**
```php
<?php 
// Perhitungan yang sama di view
$subtotal = $total_harga / (1 + $ppn_percent);
$uang_muka = $subtotal * 0.20;
$ppn_uang_muka = $uang_muka * 0.11;
$total_bayar = $uang_muka + $ppn_uang_muka;
?>
```

---

## 📊 **BUSINESS LOGIC**

### **Alur Bisnis**
1. **Customer** memesan produk dengan harga total (sudah + PPN)
2. **PT Jaya Beton** mengirim invoice uang muka 20%
3. **Customer** bayar uang muka + PPN-nya saja
4. Sisa pembayaran dilakukan setelah produk selesai/dikirim

### **Keuntungan Sistem Ini**
- ✅ **Transparansi**: Customer tahu berapa PPN yang dibayar
- ✅ **Akurasi**: Tidak ada double taxation
- ✅ **Compliance**: Sesuai aturan perpajakan Indonesia
- ✅ **Cash Flow**: PT Jaya Beton dapat uang muka untuk operasional

---

## 📞 **SUPPORT**

Jika ada pertanyaan mengenai perhitungan invoice, silakan hubungi:
- **Finance**: PT Jaya Beton Plant Indonesia
- **Email**: [email perusahaan]
- **Phone**: [nomor telepon]

---

*Dokumen ini dibuat untuk memastikan pemahaman yang sama antara tim internal dan customer mengenai perhitungan invoice.*

**© 2025 PT Jaya Beton Plant Indonesia**
