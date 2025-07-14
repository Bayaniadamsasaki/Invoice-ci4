# 📋 Sistem Invoice PT Jaya Beton

Sistem manajemen invoice berbasis web menggunakan CodeIgniter 4 dengan role-based access control untuk PT Jaya Beton Plant Medan.

## 🚀 Fitur Utama

- **Role-Based Access Control** (Admin, Bagian Keuangan, Manager)
- **Master Data Management** (Produk, Rekanan)
- **Manajemen Pemesanan** dengan auto-generate invoice
- **Sistem Invoice** dengan perhitungan PPN otomatis
- **Laporan & Dashboard** dengan visualisasi data
- **Galeri Produk** showcase proyek-proyek PT Jaya Beton

## 🛠️ Tech Stack

- **Framework:** CodeIgniter 4.6.1
- **Database:** MySQL
- **Frontend:** Bootstrap 5.3.0, DataTables, Chart.js
- **Icons:** Font Awesome 6.4.0
- **Server:** Apache/Nginx + PHP 8.0+

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
| `admin` | `admin123` | Administrator | Full access semua fitur |
| `user` | `user123` | Bagian Keuangan | Pemesanan, Invoice, Dashboard, Laporan |
| `manager` | `manager123` | Manager | Dashboard, Laporan (monitoring) |

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

### 2. Proses Pemesanan (Admin + Bagian Keuangan)

#### A. Buat Pemesanan Baru
- Menu **Mengelola Pemesanan**
- Klik **Tambah Pemesanan**
- Isi form pemesanan

**Contoh Data Pemesanan:**
```
ID SO: SO-2025001
Nama Rekanan: CV. Sumber Rejeki
Jenis Produk: PC SPUN PILE
Kategori Produk: PCA 600 - 6 UP
Quantity: 100 batang
Tanggal SO: 2025-07-14
No. PO: PO/SRJ/2025/001
```

#### B. Sistem Auto-Calculate
- Total berat otomatis dihitung
- Harga satuan bisa diinput manual
- Subtotal dan PPN otomatis

### 3. Generate Invoice (Admin + Bagian Keuangan)

#### A. Buat Invoice dari Pemesanan
- Menu **Mengelola Invoice**
- Klik **Buat Invoice**
- Pilih pemesanan yang belum di-invoice

#### B. Input Detail Invoice
**Contoh Data Invoice:**
```
No. Invoice: 1 (auto-increment)
Harga Satuan: Rp 150,000
PPN: 11%
Subtotal: Rp 15,000,000
Nilai PPN: Rp 1,650,000
Total: Rp 16,650,000
Terbilang: Enam belas juta enam ratus lima puluh ribu rupiah
```

### 4. Laporan & Monitoring (Semua Role)

#### A. Dashboard
- Statistik total produk, rekanan, pemesanan, invoice
- Grafik penjualan bulanan
- Invoice terbaru
- Galeri produk PT Jaya Beton

#### B. Laporan Invoice
- Filter berdasarkan tanggal
- Export laporan
- Summary penjualan

---

## 🔧 Struktur Database

### Tabel Login
```sql
login (
  id INT PRIMARY KEY,
  username VARCHAR(50),
  password VARCHAR(255),
  role ENUM('admin', 'bagian_keuangan', 'manager'),
  created_at TIMESTAMP,
  updated_at TIMESTAMP
)
```

### Tabel Produk
```sql
tbl_input_data_produk (
  kode_jenis_produk INT PRIMARY KEY,
  nama_jenis_produk VARCHAR(100),
  kode_kategori_produk_ VARCHAR(20),
  nama_kategori_produk VARCHAR(100),
  berat DECIMAL(10,3),
  satuan VARCHAR(20)
)
```

### Tabel Rekanan
```sql
tbl_input_data_rekanan (
  nama_rek VARCHAR(100) PRIMARY KEY,
  alamat TEXT,
  npwp VARCHAR(20),
  telepon VARCHAR(20),
  email VARCHAR(100)
)
```

### Tabel Pemesanan
```sql
tbl_mengelola_pemesanan (
  id_so INT PRIMARY KEY,
  nama_rek VARCHAR(100),
  nama_jenis_produk VARCHAR(100),
  order_btg INT,
  total_berat DECIMAL(10,3),
  tgl_so DATE,
  no_po VARCHAR(50),
  produk_id INT
)
```

### Tabel Invoice
```sql
tbl_mengelola_invoice (
  no_invoice INT PRIMARY KEY,
  pemesanan_id INT,
  nama_rek VARCHAR(100),
  harga_satuan DECIMAL(15,2),
  subtotal DECIMAL(15,2),
  ppn DECIMAL(5,2),
  nilai_ppn DECIMAL(15,2),
  total_harga DECIMAL(15,2),
  terbilang TEXT,
  tgl_so DATE,
  created_by INT
)
```

---

## 🎯 Role & Permissions

### 🔴 Admin (Full Access)
- ✅ Master Data Produk (CRUD)
- ✅ Master Data Rekanan (CRUD)
- ✅ Mengelola Pemesanan (CRUD)
- ✅ Mengelola Invoice (CRUD)
- ✅ Hapus Invoice
- ✅ Dashboard & Laporan

### 🟡 Bagian Keuangan (Operational)
- ❌ Master Data Produk
- ❌ Master Data Rekanan  
- ✅ Mengelola Pemesanan (CRUD)
- ✅ Mengelola Invoice (Create, Read, Update)
- ❌ Hapus Invoice
- ✅ Dashboard & Laporan

### 🟢 Manager (Monitoring)
- ❌ Master Data Produk
- ❌ Master Data Rekanan
- ❌ Mengelola Pemesanan
- ❌ Mengelola Invoice
- ✅ Dashboard & Laporan

---

## 🎨 UI Features

### Dashboard
- **Statistics Cards** - Total data dengan icon
- **Monthly Chart** - Grafik penjualan dengan Chart.js
- **Recent Invoices** - Tabel invoice terbaru
- **Product Gallery** - Showcase 7 kategori produk beton

### DataTables (Indonesian)
- Pagination dalam bahasa Indonesia
- Search, sort, filter
- Responsive design
- Export functionality

### Responsive Design
- Mobile-friendly sidebar
- Bootstrap 5 components
- Modern gradient design
- Interactive hover effects

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

**PT Jaya Beton Plant Medan**
- 📧 Email: info@jayabeton.com
- 📠 Fax: 021-5902383  
- 📞 Telp: 021-5902385
- 🌐 Social Media: Facebook, Twitter, YouTube, Instagram

---

## 📄 License

Copyright © 2025 PT Jaya Beton. All rights reserved.

---

*Dokumentasi ini dibuat untuk memudahkan setup dan penggunaan Sistem Invoice PT Jaya Beton. Untuk pertanyaan lebih lanjut, silakan hubungi tim developer.*
