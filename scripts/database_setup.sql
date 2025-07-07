-- Database Setup untuk Sistem Invoice PT Jaya Beton Plant Medan (CodeIgniter 4)
CREATE DATABASE IF NOT EXISTS db_invoice_ci4;
USE db_invoice_ci4;

-- Tabel Users (untuk authentication)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel Produk
CREATE TABLE produk (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_jenis_produk VARCHAR(50) NOT NULL,
    nama_jenis_produk VARCHAR(100) NOT NULL,
    kode_kategori_produk VARCHAR(100) NOT NULL,
    nama_kategori_produk VARCHAR(100) NOT NULL,
    diameter_lebar VARCHAR(15),
    tinggi VARCHAR(15),
    tebal VARCHAR(15),
    panjang VARCHAR(15),
    berat VARCHAR(15) NOT NULL,
    satuan VARCHAR(10) DEFAULT 'BTG',
    harga_satuan DECIMAL(15,2) DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel Rekanan
CREATE TABLE rekanan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_rekanan VARCHAR(10),
    nama_rekanan VARCHAR(100) NOT NULL,
    alamat TEXT NOT NULL,
    npwp VARCHAR(20),
    telepon VARCHAR(20),
    email VARCHAR(100),
    contact_person VARCHAR(100),
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel Pemesanan (Sales Order)
CREATE TABLE pemesanan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    no_so VARCHAR(50) NOT NULL UNIQUE,
    tanggal_so DATE NOT NULL,
    no_po VARCHAR(100),
    rekanan_id INT NOT NULL,
    produk_id INT NOT NULL,
    order_btg INT NOT NULL,
    harga_satuan DECIMAL(15,2) NOT NULL,
    total_harga DECIMAL(15,2) NOT NULL,
    status ENUM('pending', 'approved', 'invoiced', 'cancelled') DEFAULT 'pending',
    keterangan TEXT,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (rekanan_id) REFERENCES rekanan(id) ON DELETE RESTRICT,
    FOREIGN KEY (produk_id) REFERENCES produk(id) ON DELETE RESTRICT,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
);

-- Tabel Invoice
CREATE TABLE invoice (
    id INT AUTO_INCREMENT PRIMARY KEY,
    no_invoice VARCHAR(50) NOT NULL UNIQUE,
    pemesanan_id INT NOT NULL,
    tanggal_invoice DATE NOT NULL,
    due_date DATE,
    ppn DECIMAL(5,2) DEFAULT 11.00,
    total_sebelum_ppn DECIMAL(15,2) NOT NULL,
    nilai_ppn DECIMAL(15,2) NOT NULL,
    total_setelah_ppn DECIMAL(15,2) NOT NULL,
    status_pembayaran ENUM('unpaid', 'partial', 'paid') DEFAULT 'unpaid',
    tanggal_bayar DATE NULL,
    jumlah_bayar DECIMAL(15,2) DEFAULT 0,
    keterangan TEXT,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (pemesanan_id) REFERENCES pemesanan(id) ON DELETE RESTRICT,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
);

-- Tabel Pembayaran
CREATE TABLE pembayaran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    invoice_id INT NOT NULL,
    tanggal_bayar DATE NOT NULL,
    jumlah_bayar DECIMAL(15,2) NOT NULL,
    metode_bayar ENUM('cash', 'transfer', 'check', 'other') DEFAULT 'transfer',
    no_referensi VARCHAR(100),
    keterangan TEXT,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (invoice_id) REFERENCES invoice(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
);

-- Insert default admin user (password: admin123)
INSERT INTO users (username, email, password, full_name, role) VALUES 
('admin', 'admin@jayabeton.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin');

-- Insert sample data produk berdasarkan laporan
INSERT INTO produk (kode_jenis_produk, nama_jenis_produk, kode_kategori_produk, nama_kategori_produk, diameter_lebar, tinggi, tebal, panjang, berat, harga_satuan) VALUES
('PCA-600-6-UP', 'PC SPUN PILE', 'PCA', 'PCA 600 - 6 UP', '600', '0', '100', '6', '244.800', 226194672.00),
('PCA-300-7-BP', 'PC SPUN PILE', 'PCA', 'PCA 300 - 7 BP', '300', '60', '60', '7', '0.821', 726084.89),
('PCA-300-7-UP', 'PC SPUN PILE', 'PCA', 'PCA 300 - 7 UP', '300', '60', '60', '7', '0.821', 760014.10),
('PCA-300-8-BP', 'PC SPUN PILE', 'PCA', 'PCA 300 - 8 BP', '300', '60', '60', '8', '0.940', 834658.34),
('PCA-300-8-UP', 'PC SPUN PILE', 'PCA', 'PCA 300 - 8 UP', '300', '60', '60', '8', '0.940', 868587.53),
('BOX-PS21', 'PC BOX GIRDER', 'BOX', 'BOX GIRDER PS-21', '9000', '2500', '2500', '2.50', '0.000', 0.00),
('UD-500X750', 'U-DITCH', 'UD', 'U-DITCH 500X750X60 - 1.2m', '500', '750', '60', '1.02', '0.171', 157920.00),
('PCA-400-11-UP', 'PC SPUN PILE', 'PCA', 'PCA 400 - 11 UP', '400', '0', '75', '11', '2.190', 202161487.00);

-- Insert sample data rekanan
INSERT INTO rekanan (kode_rekanan, nama_rekanan, alamat, npwp, telepon, email) VALUES
('045781', 'Adhi - Jaya Konstruksi - Waskita KSO', 'Jalan Raya Pasar Minggu Km. 18 Jakarta Selatan 12510', '', '021-12345678', 'contact@adhijaya.com'),
('046132', 'Adhi - Waskita - Jaya Konstruksi KSO', 'Proyek Pembangunan Jalan Tol Banyu Lencir - Tempino Seksi 1', '00.000.000.0-000.000', '021-87654321', 'info@adhiwaskita.com'),
('044869', 'DAELIM - WIKA - WASKITA, KSO', 'DKI JAKARTA', '', '021-11111111', 'contact@daelimwika.com'),
('030031', 'Konsortium ZUG, PT - WASKITA KARYA, PT', 'Jl. Rawa Melati Blok A-1/5 Kalideres Jakarta Barat', '', '021-22222222', 'info@zugwaskita.com'),
('175963', 'WASKITA - AGUNG, KSO', 'Jl.Truntum Krapyak Lor Pekalongan Utara 51149', '', '0285-123456', 'contact@waskitaagung.com'),
('045702', 'WASKITA - BRP KSO', 'Jl. Raya Tambaksari No. 123 Tambak Dahan, Kab. Subang, Jawa Barat 41253', '65.533.545.3-002.000', '0260-123456', 'info@waskitabrp.com');

-- Create indexes for better performance
CREATE INDEX idx_pemesanan_no_so ON pemesanan(no_so);
CREATE INDEX idx_pemesanan_status ON pemesanan(status);
CREATE INDEX idx_invoice_no_invoice ON invoice(no_invoice);
CREATE INDEX idx_invoice_status ON invoice(status_pembayaran);
CREATE INDEX idx_invoice_tanggal ON invoice(tanggal_invoice);
