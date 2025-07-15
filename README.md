# 📋 Sistem Invoice PT Jaya Beton

Sistem manajemen invoice berbasis web menggunakan CodeIgniter 4 dengan role-based access control untuk PT Jaya Beton Plant Indonesia.

## 🚀 Fitur Utama

- **Role-Based Access Control** (Admin, Bagian Keuangan, Manager)
- **Master Data Management** (Produk, Rekanan)
- **Manajemen Pemesanan** dengan auto-generate invoice
- **Sistem Invoice Pelunasan** dengan perhitungan PPN otomatis
- **Print Invoice Professional** dengan logo perusahaan
- **Laporan & Dashboard** dengan visualisasi data
- **Galeri Produk** showcase 5 kategori produk beton PT Jaya Beton

## 🛠️ Tech Stack

- **Framework:** CodeIgniter 4.6.1
- **Database:** MySQL
- **Frontend:** Bootstrap 5.3.0, DataTables, Chart.js
- **Icons:** Font Awesome 6.4.0
- **Server:** Apache/Nginx + PHP 8.0+
- **Print:** CSS Print Media Queries untuk optimal printing

---

## 📦 Instalasi & Setup

### 1. Clone Repository

```bash
git clone https://github.com/username/invoice-ci4.git
cd invoice-ci4
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Environment Configuration

Copy file environment dan konfigurasi database:

```bash
cp env .env
```

Edit file `.env`:

```env
# Database Configuration
database.default.hostname = localhost
database.default.database = dbinvoice
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi

# Base URL
app.baseURL = 'http://localhost/invoice-ci4/'

# Environment
CI_ENVIRONMENT = development
```

### 4. Database Setup

#### Buat Database

```sql
CREATE DATABASE dbinvoice;
```

#### Jalankan Migrasi

```bash
php spark migrate
```

Ini akan membuat tabel-tabel berikut:
- `login` - User authentication & roles
- `tbl_input_data_produk` - Master data produk beton
- `tbl_input_data_rekanan` - Master data rekanan/client
- `tbl_mengelola_pemesanan` - Data pemesanan/sales order
- `tbl_mengelola_invoice` - Data invoice & faktur

#### Jalankan Seeder (Data Awal)

```bash
# Seeder login users
php spark db:seed LoginSeeder

# Seeder data produk
php spark db:seed ProdukSeeder

# Seeder data rekanan (opsional)
php spark db:seed RekananSeeder
```

### 5. Menjalankan Server

#### Menggunakan PHP Built-in Server:

```bash
php spark serve
```

Server akan berjalan di: `http://localhost:8080`

#### Menggunakan Laragon/XAMPP:

1. Copy folder project ke `htdocs` atau `www`
2. Akses via: `http://localhost/invoice-ci4`

---

## 👥 Default User Accounts

| Username | Password | Role | Akses |
|----------|----------|------|-------|
| `admin` | `admin123` | Administrator | Master Data (Produk, Rekanan, Pemesanan), Dashboard |
| `user` | `user123` | Bagian Keuangan | Invoice, Laporan Invoice, Dashboard |
| `manager` | `manager123` | Manager | Dashboard, Laporan Invoice (monitoring only) |

---

## 📊 Alur Kerja Sistem

### 1. Setup Master Data (Admin Only)

#### A. Input Data Produk
- Login sebagai **admin**
- Menu **Input Data Produk**
- Tambah produk beton (PC Spun Pile, dll)

**Contoh Data Produk:**
```
Jenis Produk: PC SPUN PILE
Kategori: PCA 600 - 6 UP
Kode Kategori: PCA
Berat: 244.800 kg
Satuan: Batang
```

#### B. Input Data Rekanan
- Menu **Input Data Rekanan**
- Tambah data client/rekanan

**Contoh Data Rekanan:**
```
Nama Rekanan: CV. Sumber Rejeki
Alamat: Jl. Industri No. 45, Medan
NPWP: 12.345.678.9-123.000
Telepon: 061-12345678
Email: contact@sumberrejeki.com
```

### 2. Proses Pemesanan (Admin Only)

#### A. Buat Pemesanan Baru
- Menu **Mengelola Pemesanan** (hanya Admin)
- Klik **Tambah Pemesanan**
- Isi form pemesanan

**Contoh Data Pemesanan:**
```
ID SO: SO-2025001
Nama Rekanan: PT Kodya Asri
Jenis Produk: PC SPUN PILE
Kategori Produk: PCA 600 - 100
Quantity: 100 batang
Tanggal SO: 2025-07-15
No. PO: PO-2025-004
```

#### B. Sistem Auto-Calculate
- Total harga otomatis dihitung
- Harga satuan dari database produk
- Subtotal dan PPN otomatis

### 3. Generate Invoice (Bagian Keuangan Only)

#### A. Buat Invoice dari Pemesanan
- Menu **Mengelola Invoice** (hanya Bagian Keuangan)
- Klik **Tambah Invoice**
- Pilih pemesanan yang belum di-invoice

#### B. Input Detail Invoice - Format Pelunasan
**Contoh Data Invoice:**
```
No. Invoice: 6 (auto-increment)
Pemesanan: PO-2025-004 (PT Kodya Asri)
Produk: PCA 600 - 100 Btg
Subtotal: Rp 15,000,000
PPN (11%): Rp 1,650,000
Total Pelunasan: Rp 16,650,000
Terbilang: Enam belas juta enam ratus lima puluh ribu rupiah
```

#### C. Print Invoice Professional
- **Logo PT Jaya Beton** di header kiri
- **Text "INVOICE"** di tengah dengan font optimal
- **Format Pelunasan** (bukan uang muka 20%)
- **Informasi Transfer Bank**: BCA Cab KIM & BCA Cab KIM II
- **CSS Print Optimized** untuk satu halaman A4
- **Terbilang otomatis** sesuai total pelunasan

### 4. Laporan & Monitoring

#### A. Dashboard (Semua Role)
- Statistik total produk, rekanan, pemesanan, invoice
- Grafik penjualan bulanan (Chart.js)
- Invoice terbaru hari ini
- **Galeri Produk Terbaru**: 5 kategori produk beton
  - PC. SPUN PILES (Pondasi)
  - PC. SHEET PILES CORRUGATED TYPE (Struktur)
  - PC. SPUN POLES (Utilities)
  - PC. SHEET PILES FLAT TYPE (Struktur)
  - PRESTRESSED CONCRETE SQUARE PILE (Pondasi)

#### B. Laporan Invoice (Bagian Keuangan + Manager)
- Filter berdasarkan tanggal
- Export laporan
- Summary penjualan
- **Manager**: Akses read-only untuk monitoring

---

## 🎯 Role & Permissions

### 🔴 Admin (Master Data Management)
- ✅ Master Data Produk (CRUD)
- ✅ Master Data Rekanan (CRUD)
- ✅ Mengelola Pemesanan (CRUD)
- ❌ Mengelola Invoice
- ❌ Laporan Invoice
- ✅ Dashboard

### 🟡 Bagian Keuangan (Financial Operations)
- ❌ Master Data Produk
- ❌ Master Data Rekanan  
- ❌ Mengelola Pemesanan
- ✅ Mengelola Invoice (CRUD)
- ✅ Print Invoice Professional
- ✅ Laporan Invoice
- ✅ Dashboard

### 🟢 Manager (Monitoring & Reporting)
- ❌ Master Data (Produk, Rekanan)
- ❌ Mengelola Pemesanan
- ❌ Mengelola Invoice
- ✅ Dashboard
- ✅ Laporan Invoice (Read-Only)

---

## 🎨 UI Features

### Dashboard
- **Statistics Cards** - Total data dengan icon FontAwesome
- **Monthly Chart** - Grafik penjualan dengan Chart.js
- **Recent Invoices** - Tabel invoice hari ini
- **Product Gallery** - Showcase 5 kategori produk beton:
  - PC. SPUN PILES (foundation.png)
  - PC. SHEET PILES CORRUGATED TYPE (retainingwall.jpg)
  - PC. SPUN POLES (electricity.jpg)  
  - PC. SHEET PILES FLAT TYPE (PC SHEET PILES.png)
  - PRESTRESSED CONCRETE SQUARE PILE (PRESTERESSED CONCRETE SQUARE FILE.png)

### Print Invoice Professional
- **Header Layout**: Logo PT Jaya Beton (kiri) + "INVOICE" (tengah)
- **Format Pelunasan**: Bukan uang muka 20%, full payment
- **Bank Transfer Info**: 
  - "Please make your cheque payable to: PT JAYA BETON INDONESIA"
  - "or by wire transfer to:"
  - BCA Cab KIM (Account: 8195073003)
  - BCA Cab KIM II (Account: 0058936258)
- **CSS Print Optimized**: 
  - Font size 12px untuk print
  - Margin minimal untuk A4
  - Single page layout
  - Print button hidden saat print

### DataTables (Indonesian)
- Pagination dalam bahasa Indonesia
- Search, sort, filter
- Responsive design
- Export functionality

### Responsive Design
- Mobile-friendly sidebar dengan hamburger menu
- Bootstrap 5 components
- Modern gradient design PT Jaya Beton
- Interactive hover effects
- Logo branding PT Jaya Beton di navbar

---

## 🔍 Troubleshooting

### Error Database Connection
```bash
# Cek konfigurasi .env
# Pastikan database sudah dibuat
# Jalankan migrasi ulang
php spark migrate:refresh
```

### Error 404 Routes
```bash
# Pastikan .htaccess ada di root
# Cek base URL di .env
# Restart server
```

### Error Permissions
```bash
# Set permission writable folder
chmod -R 777 writable/
```

### Reset Data
```bash
# Reset semua data dan struktur
php spark migrate:refresh --seed
```

---

## 📞 Support & Contact

**PT Jaya Beton Plant Indonesia**

**Head Office:**
- � Plaza Slipi Jaya, Lantai 5
- 📍 Jl. Let. Jend. S. Parman, Kav 17-18, Kemanggisan, Palmerah, Jakarta Barat
- � P (021) 530 4023 - F. (021) 530 4048
- 📧 E-Mail: jbipusa@jayabeton.com

**Plant Locations:**
1. **Tangerang**: Jl. Jend. Gatot Subroto KM. 8,5, Kadujaya, Curug - Tangerang 15810
2. **Medan**: Jl. Pasar Nippon, Paya Pasir, Medan Marelan - Sumatera Utara 20255  
3. **Surabaya**: Jl. Raya Surabaya - Krikilan KM. 27, Driyorejo, Gresik - Jawa Timur 61177
4. **Purwakarta**: Jl. Raya Sadang - Subang, Cikumpay, Campaka - Purwakarta

- 🌐 Website: http://www.jayabeton.com

---

## 📄 License

Copyright © 2025 PT Jaya Beton Plant Indonesia. All rights reserved.

---

*Dokumentasi ini dibuat untuk memudahkan setup dan penggunaan Sistem Invoice PT Jaya Beton Plant Indonesia. Untuk pertanyaan lebih lanjut, silakan hubungi tim developer.*
