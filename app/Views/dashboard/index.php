<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="fas fa-tachometer-alt me-2"></i>Dashboard</h2>
        <p class="text-muted mb-0">Selamat datang di Sistem Invoice PT Jaya Beton Indonesia</p>
    </div>
    <div class="text-muted">
        <i class="fas fa-calendar me-1"></i><?= date('d F Y') ?>
    </div>
</div>

<!-- Company Info Banner -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card company-banner">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-9">
                        <div class="welcome-text mb-3">
                            <h4 class="fw-bold text-white mb-1">
                                <i class="fas fa-hand-wave me-2 text-warning"></i>
                                Selamat datang di Sistem Invoice PT Jaya Beton Indonesia
                            </h4>
                            <p class="text-white-50 small mb-0">Sistem manajemen invoice terintegrasi untuk efisiensi bisnis yang optimal</p>
                        </div>
                        <hr class="text-white-50 mb-3" style="opacity: 0.3;">
                        <h3 class="fw-bold text-white mb-2"><?= $companyInfo['name'] ?></h3>
                        <p class="fs-5 text-white-50 mb-3"><?= $companyInfo['tagline'] ?></p>
                        <p class="text-white-50 mb-4" style="line-height: 1.6;"><?= $companyInfo['description'] ?></p>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="info-item mb-2">
                                    <i class="fas fa-calendar-alt text-warning me-2"></i>
                                    <small class="text-white-50"><strong class="text-white">Didirikan:</strong> <?= $companyInfo['established'] ?></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-item mb-2">
                                    <i class="fas fa-user-tie text-warning me-2"></i>
                                    <small class="text-white-50"><strong class="text-white">Direktur Utama:</strong><br><?= $companyInfo['president_director'] ?></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-item mb-2">
                                    <i class="fas fa-building text-warning me-2"></i>
                                    <small class="text-white-50"><strong class="text-white">Grup:</strong><br><?= $companyInfo['group_affiliation'] ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="company-logo-section">
                            <div class="company-badge">
                                <i class="fas fa-industry fa-3x text-warning mb-3"></i>
                                <p class="text-white-50 small mb-3">Leading Precast<br>Concrete Manufacturer</p>
                            </div>
                            <button class="btn btn-gradient-warning btn-lg shadow-lg" data-bs-toggle="modal" data-bs-target="#companyModal">
                                <i class="fas fa-info-circle me-2"></i>Info Lengkap
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card stats-card" data-bs-toggle="modal" data-bs-target="#productModal" style="cursor: pointer;">
            <div class="card-body text-center">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-start">
                        <h3 class="mb-1"><?= number_format($totalProduk) ?></h3>
                        <p class="mb-0">Total Produk</p>
                        <small class="opacity-75">Produk Aktif</small>
                    </div>
                    <i class="fas fa-boxes stats-icon"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stats-card" data-bs-toggle="modal" data-bs-target="#rekananModal" style="cursor: pointer;">
            <div class="card-body text-center">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-start">
                        <h3 class="mb-1"><?= number_format($totalRekanan) ?></h3>
                        <p class="mb-0">Total Rekanan</p>
                        <small class="opacity-75">Partner Bisnis</small>
                    </div>
                    <i class="fas fa-users stats-icon"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stats-card">
            <div class="card-body text-center">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-start">
                        <h3 class="mb-1"><?= number_format($totalPemesanan) ?></h3>
                        <p class="mb-0">Total Pemesanan</p>
                        <small class="opacity-75">Sales Order</small>
                    </div>
                    <i class="fas fa-shopping-cart stats-icon"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stats-card">
            <div class="card-body text-center">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-start">
                        <h3 class="mb-1"><?= number_format($totalInvoice) ?></h3>
                        <p class="mb-0">Total Invoice</p>
                        <small class="opacity-75">Faktur Tagihan</small>
                    </div>
                    <i class="fas fa-file-invoice stats-icon"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Monthly Chart -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Grafik Penjualan Bulanan <?= date('Y') ?></h5>
            </div>
            <div class="card-body">
                <canvas id="monthlyChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Project Gallery -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-images me-2"></i>Galeri Produk PT Jaya Beton Indonesia</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php foreach ($projectGallery as $project): ?>
                        <div class="col-md-4 col-lg-3 mb-4">
                            <div class="card project-card h-100 shadow-sm">
                                <div class="project-image-container">
                                    <img src="<?= base_url('assets/' . $project['image']) ?>" 
                                         class="card-img-top project-image" 
                                         alt="<?= $project['title'] ?>"
                                         loading="lazy"
                                         onclick="openImagePreview('<?= base_url('assets/' . $project['image']) ?>', '<?= $project['title'] ?>', '<?= $project['description'] ?>')"
                                         style="cursor: pointer;">
                                    <div class="project-overlay">
                                        <span class="badge bg-primary project-category"><?= $project['category'] ?></span>
                                        <div class="view-actions">
                                            <i class="fas fa-search-plus view-icon" 
                                               onclick="openImagePreview('<?= base_url('assets/' . $project['image']) ?>', '<?= $project['title'] ?>', '<?= $project['description'] ?>')"
                                               title="Lihat Gambar Besar"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <h6 class="card-title fw-bold text-primary"><?= $project['title'] ?></h6>
                                    <p class="card-text text-muted small flex-grow-1"><?= $project['description'] ?></p>
                                    <div class="text-center mt-2">
                                        <button class="btn btn-outline-primary btn-sm" 
                                                onclick="openImagePreview('<?= base_url('assets/' . $project['image']) ?>', '<?= $project['title'] ?>', '<?= $project['description'] ?>')">
                                            <i class="fas fa-eye me-1"></i>Lihat Gambar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Invoices -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Invoice Terbaru</h5>
        
    </div>
    <div class="card-body">
        <?php if (!empty($recentInvoices)): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No Invoice</th>
                            <th>Rekanan</th>
                            <th>No SO</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentInvoices as $invoice): ?>
                            <tr>
                                <td>
                                    <a href="<?= base_url('invoice/show/' . $invoice['no_invoice']) ?>" 
                                       class="text-decoration-none fw-bold">
                                        <?= $invoice['no_invoice'] ?>
                                    </a>
                                </td>
                                <td><?= $invoice['nama_rekanan'] ?></td>
                                <td><?= $invoice['id_so'] ?></td>
                                <td><?= date('d/m/Y', strtotime($invoice['tgl_so'])) ?></td>
                                <td>Rp <?= number_format($invoice['total_harga'], 0, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-file-invoice fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada invoice yang dibuat</h5>
                <p class="text-muted">Mulai dengan membuat pemesanan terlebih dahulu</p>
                <a href="<?= base_url('pemesanan/create') ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Buat Pemesanan
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Company Info Modal -->
<div class="modal fade" id="companyModal" tabindex="-1" aria-labelledby="companyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="companyModalLabel">
                    <i class="fas fa-building me-2"></i>Informasi Lengkap PT Jaya Beton Indonesia
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body company-modal-content">
                <!-- Timeline Section -->
                <div class="timeline-section mb-5">
                    <div class="timeline-item">
                        <div class="timeline-icon">
                            <i class="fas fa-history"></i>
                        </div>
                        <div class="timeline-content">
                            <h6 class="fw-bold text-primary mb-2">
                                <i class="fas fa-calendar-alt me-2"></i>Sejarah Perusahaan
                            </h6>
                            <p class="text-muted timeline-text"><?= $companyInfo['history'] ?></p>
                        </div>
                    </div>
                </div>
                
                <!-- Vision & Mission Cards -->
                <div class="row mb-5">
                    <div class="col-md-6">
                        <div class="info-card vision-card">
                            <div class="card-icon">
                                <i class="fas fa-eye"></i>
                            </div>
                            <h6 class="fw-bold text-primary mb-3">Visi</h6>
                            <p class="card-text"><?= $companyInfo['vision'] ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-card mission-card">
                            <div class="card-icon">
                                <i class="fas fa-bullseye"></i>
                            </div>
                            <h6 class="fw-bold text-primary mb-3">Misi</h6>
                            <ul class="mission-list">
                                <?php foreach ($companyInfo['mission'] as $mission): ?>
                                    <li><?= $mission ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Leadership & Affiliation -->
                <div class="row mb-5">
                    <div class="col-md-6">
                        <div class="leadership-card">
                            <div class="leadership-icon">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <h6 class="fw-bold text-primary mb-2">Direktur Utama</h6>
                            <p class="leadership-name"><?= $companyInfo['president_director'] ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="affiliation-card">
                            <div class="affiliation-icon">
                                <i class="fas fa-building"></i>
                            </div>
                            <h6 class="fw-bold text-primary mb-2">Afiliasi Grup</h6>
                            <p class="affiliation-name"><?= $companyInfo['group_affiliation'] ?></p>
                        </div>
                    </div>
                </div>
                
                <!-- Man Power Section -->
                <div class="manpower-section mb-5">
                    <div class="section-header">
                        <h5 class="section-title">
                            <i class="fas fa-users me-2"></i><?= $companyInfo['manpower']['title'] ?>
                        </h5>
                    </div>
                    <div class="section-content">
                        <p class="section-description"><?= $companyInfo['manpower']['description'] ?></p>
                        <p class="section-philosophy"><?= $companyInfo['manpower']['philosophy'] ?></p>
                        
                        <div class="values-container">
                            <h6 class="values-title">Nilai-Nilai Pembangunan Jaya Group:</h6>
                            <div class="values-grid">
                                <?php foreach ($companyInfo['manpower']['group_values'] as $value): ?>
                                    <div class="value-item">
                                        <i class="fas fa-star"></i>
                                        <span><?= $value ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        
                        <div class="development-note">
                            <p><?= $companyInfo['manpower']['people_development'] ?></p>
                        </div>
                    </div>
                </div>
                
                <!-- Core Business Section -->
                <div class="corebusiness-section mb-4">
                    <div class="section-header">
                        <h5 class="section-title">
                            <i class="fas fa-cogs me-2"></i><?= $companyInfo['core_business']['title'] ?>
                        </h5>
                    </div>
                    <div class="section-content">
                        <p class="section-description"><?= $companyInfo['core_business']['overview'] ?></p>
                        
                        <div class="manufacturing-highlight">
                            <div class="manufacturing-header">
                                <h6 class="manufacturing-title">
                                    <i class="fas fa-industry me-2"></i><?= $companyInfo['core_business']['precast_manufacturing']['title'] ?>
                                </h6>
                            </div>
                            <p class="manufacturing-description"><?= $companyInfo['core_business']['precast_manufacturing']['description'] ?></p>
                            
                            <div class="capabilities-section">
                                <h6 class="capabilities-title">Kemampuan & Layanan:</h6>
                                <div class="capabilities-grid">
                                    <?php foreach ($companyInfo['core_business']['precast_manufacturing']['capabilities'] as $capability): ?>
                                        <div class="capability-item">
                                            <i class="fas fa-check-circle"></i>
                                            <span><?= $capability ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Footer -->
                <div class="modal-footer-custom">
                    <div class="source-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <small><em>Informasi resmi dari website PT Jaya Beton Indonesia</em></small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Product List Modal -->
<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel">
                    <i class="fas fa-boxes me-2"></i>Daftar Produk
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Berat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($products as $product): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $product['nama_jenis_produk'] ?></td>
                                    <td><?= $product['nama_kategori_produk'] ?></td>
                                    <td><?= $product['berat'] ?> Kg</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Rekanan Modal -->
<div class="modal fade" id="rekananModal" tabindex="-1" aria-labelledby="rekananModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rekananModalLabel">
                    <i class="fas fa-users me-2"></i>Data Rekanan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-users fa-4x text-primary mb-3"></i>
                <h4><?= number_format($totalRekanan) ?></h4>
                <p class="text-muted">Total Rekanan Terdaftar</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Image Preview Modal -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-labelledby="imagePreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content image-modal-content">
            <div class="modal-header image-modal-header">
                <h5 class="modal-title" id="imagePreviewModalLabel">
                    <i class="fas fa-image me-2"></i>Preview Produk PT Jaya Beton Indonesia
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body image-modal-body p-0">
                <div class="image-preview-container">
                    <div class="image-wrapper">
                        <img id="previewImage" src="" alt="" class="preview-image">
                        <div class="image-zoom-controls">
                            <button class="zoom-btn" onclick="zoomImage('in')" title="Zoom In">
                                <i class="fas fa-search-plus"></i>
                            </button>
                            <button class="zoom-btn" onclick="zoomImage('out')" title="Zoom Out">
                                <i class="fas fa-search-minus"></i>
                            </button>
                            <button class="zoom-btn" onclick="resetZoom()" title="Reset Zoom">
                                <i class="fas fa-expand-arrows-alt"></i>
                            </button>
                        </div>
                    </div>
                    <div class="image-info-panel">
                        <div class="info-content">
                            <div class="product-badge">
                                <i class="fas fa-building me-2"></i>PT Jaya Beton Indonesia
                            </div>
                            <h3 id="imageTitle" class="product-title"></h3>
                            <p id="imageDescription" class="product-description"></p>
                            <div class="product-features">
                                <div class="feature-item">
                                    <i class="fas fa-shield-alt"></i>
                                    <span>Kualitas Terjamin</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-truck"></i>
                                    <span>Pengiriman Cepat</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-tools"></i>
                                    <span>Instalasi Profesional</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer image-modal-footer">
                <div class="footer-info">
                    <small class="text-light">
                        <i class="fas fa-info-circle me-1"></i>
                        Gunakan scroll mouse atau tombol zoom untuk memperbesar gambar
                    </small>
                </div>
                <button type="button" class="btn btn-light btn-lg" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Tutup Preview
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Product Detail Modal -->
<div class="modal fade" id="productDetailModal" tabindex="-1" aria-labelledby="productDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productDetailModalLabel">
                    <i class="fas fa-info-circle me-2"></i>Detail Produk
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="productDetailContent">
                <!-- Content will be loaded dynamically -->
                <div class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<style>
/* Company Banner Styles */
.company-banner {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 20px;
    border: none;
    position: relative;
    overflow: hidden;
}

.company-banner::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 200px;
    height: 200px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    z-index: 1;
}

.company-banner .card-body {
    padding: 3rem 2.5rem;
    position: relative;
    z-index: 2;
}

.welcome-text {
    animation: fadeInDown 0.8s ease-out;
}

.welcome-text h4 {
    text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
    font-size: 1.5rem;
    line-height: 1.3;
}

.welcome-text .fas.fa-hand-wave {
    animation: wave 1s ease-in-out infinite alternate;
}

@keyframes wave {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(20deg); }
}

@keyframes fadeInDown {
    0% {
        opacity: 0;
        transform: translateY(-20px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

.company-banner h3 {
    font-size: 2.2rem;
    font-weight: 700;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.company-banner .fs-5 {
    font-size: 1.1rem !important;
    font-weight: 300;
    letter-spacing: 0.5px;
}

.info-item {
    padding: 8px 0;
}

.info-item i {
    width: 20px;
    text-align: center;
}

.company-logo-section {
    padding: 20px;
}

.company-badge {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 15px;
    padding: 20px;
    margin-bottom: 20px;
    backdrop-filter: blur(10px);
}

/* Custom Gradient Button */
.btn-gradient-warning {
    background: linear-gradient(45deg, #ffd700, #ffb347);
    border: none;
    color: #333;
    font-weight: 600;
    padding: 12px 25px;
    border-radius: 50px;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-size: 0.9rem;
}

.btn-gradient-warning:hover {
    background: linear-gradient(45deg, #ffb347, #ffd700);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255, 183, 71, 0.4) !important;
    color: #333;
}

.btn-gradient-warning:focus,
.btn-gradient-warning:active {
    background: linear-gradient(45deg, #ffb347, #ffd700);
    box-shadow: 0 8px 25px rgba(255, 183, 71, 0.4) !important;
    color: #333;
}

/* Text Colors */
.text-white-50 {
    color: rgba(255, 255, 255, 0.75) !important;
}

/* Responsive */
@media (max-width: 768px) {
    .company-banner h3 {
        font-size: 1.8rem;
    }
    
    .company-banner .card-body {
        padding: 2rem 1.5rem;
    }
    
    .company-logo-section {
        margin-top: 20px;
        padding: 15px;
    }
    
    .info-item {
        margin-bottom: 15px;
    }
}

/* Stats Cards Hover Effect */
.stats-card {
    transition: all 0.3s ease;
    border: none;
    border-radius: 15px;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
}

/* Project Gallery Styles */
.project-card {
    transition: all 0.3s ease;
    border: none;
    overflow: hidden;
    border-radius: 15px;
}

.project-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.2) !important;
}

.project-image-container {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.project-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.project-card:hover .project-image {
    transform: scale(1.15);
}

.project-overlay {
    position: absolute;
    top: 10px;
    right: 10px;
    left: 10px;
    z-index: 2;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.view-actions {
    display: flex;
    gap: 8px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.project-card:hover .view-actions {
    opacity: 1;
}

.view-icon {
    background: rgba(255,255,255,0.95);
    color: #667eea;
    padding: 8px;
    border-radius: 50%;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
}

.view-icon:hover {
    background: #667eea;
    color: white;
    transform: scale(1.1);
}

/* Image Preview Modal Styles */
.image-modal-content {
    background: linear-gradient(135deg, #0f0f23 0%, #1a1a2e 50%, #16213e 100%);
    border: none;
    border-radius: 0;
    overflow: hidden;
    height: 100vh;
}

.image-modal-header {
    background: linear-gradient(135deg, rgba(15, 15, 35, 0.95), rgba(26, 26, 46, 0.95));
    color: white;
    border-bottom: 2px solid rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    padding: 15px 25px;
}

.image-modal-header .modal-title {
    font-size: 20px;
    font-weight: 600;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.image-modal-body {
    background: transparent;
    position: relative;
    height: calc(100vh - 140px);
    overflow: hidden;
    padding: 0;
}

.image-preview-container {
    display: flex;
    height: 100%;
    position: relative;
}

.image-wrapper {
    flex: 2;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    background: radial-gradient(circle at center, rgba(255, 255, 255, 0.05) 0%, transparent 70%);
    overflow: hidden;
    padding: 20px;
}

.preview-image {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    border-radius: 15px;
    box-shadow: 
        0 25px 50px rgba(0, 0, 0, 0.5),
        0 0 0 1px rgba(255, 255, 255, 0.1);
    transition: transform 0.3s ease, filter 0.3s ease;
    cursor: zoom-in;
    transform-origin: center;
}

.preview-image:hover {
    filter: brightness(1.1);
}

.image-zoom-controls {
    position: absolute;
    top: 20px;
    right: 20px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    z-index: 10;
}

.zoom-btn {
    background: rgba(255, 255, 255, 0.9);
    border: none;
    width: 45px;
    height: 45px;
    border-radius: 50%;
    color: #333;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    backdrop-filter: blur(10px);
}

.zoom-btn:hover {
    background: white;
    transform: scale(1.1);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
}

.image-info-panel {
    flex: 1;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(248, 249, 250, 0.95));
    backdrop-filter: blur(20px);
    border-left: 2px solid rgba(255, 255, 255, 0.2);
    padding: 30px;
    overflow-y: auto;
    position: relative;
}

.image-info-panel::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #667eea, #764ba2);
}

.info-content {
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.product-badge {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    padding: 8px 16px;
    border-radius: 25px;
    font-size: 12px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    margin-bottom: 20px;
    width: fit-content;
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
}

.product-title {
    font-size: 28px;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 15px;
    line-height: 1.3;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.product-description {
    font-size: 16px;
    color: #6c757d;
    line-height: 1.6;
    margin-bottom: 30px;
    text-align: justify;
}

.product-features {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-left: 4px solid #667eea;
}

.feature-item:hover {
    transform: translateX(5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.feature-item i {
    font-size: 20px;
    color: #667eea;
    width: 25px;
    text-align: center;
}

.feature-item span {
    font-weight: 500;
    color: #495057;
    font-size: 14px;
}

.image-modal-footer {
    background: linear-gradient(135deg, rgba(15, 15, 35, 0.95), rgba(26, 26, 46, 0.95));
    border-top: 2px solid rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    padding: 15px 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.footer-info {
    flex: 1;
}

.footer-info small {
    color: rgba(255, 255, 255, 0.8);
    font-style: italic;
}

.image-modal-footer .btn-light {
    background: linear-gradient(135deg, #ffffff, #f8f9fa);
    border: none;
    border-radius: 25px;
    padding: 10px 25px;
    font-weight: 600;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease;
}

.image-modal-footer .btn-light:hover {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
}

/* Responsive Design for Image Preview */
@media (max-width: 992px) {
    .image-preview-container {
        flex-direction: column;
    }
    
    .image-wrapper {
        flex: 1;
        min-height: 60%;
    }
    
    .image-info-panel {
        flex: 0 0 auto;
        min-height: 40%;
        border-left: none;
        border-top: 2px solid rgba(255, 255, 255, 0.2);
    }
    
    .image-zoom-controls {
        top: 10px;
        right: 10px;
        flex-direction: row;
    }
    
    .zoom-btn {
        width: 40px;
        height: 40px;
        font-size: 14px;
    }
    
    .product-title {
        font-size: 24px;
    }
    
    .info-content {
        justify-content: flex-start;
    }
}

@media (max-width: 768px) {
    .image-wrapper {
        padding: 10px;
    }
    
    .image-info-panel {
        padding: 20px;
    }
    
    .product-title {
        font-size: 20px;
    }
    
    .product-description {
        font-size: 14px;
    }
}

/* Project Gallery Enhanced Styles */

.project-category {
    font-size: 0.7rem;
    padding: 4px 8px;
}

/* Company Modal Styling */
.company-modal-content {
    max-height: 80vh;
    overflow-y: auto;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Timeline Section */
.timeline-section {
    position: relative;
    padding: 20px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 15px;
    border-left: 5px solid #007bff;
}

.timeline-item {
    display: flex;
    align-items: flex-start;
    gap: 15px;
}

.timeline-icon {
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: white;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
}

.timeline-content h6 {
    color: #007bff;
    font-weight: 600;
}

.timeline-text {
    font-size: 14px;
    line-height: 1.6;
    margin-bottom: 0;
}

/* Info Cards */
.info-card {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    border: none;
    border-radius: 15px;
    padding: 25px;
    height: 100%;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    position: relative;
    overflow: hidden;
}

.info-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #007bff, #0056b3);
}

.info-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
}

.card-icon {
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: white;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 15px;
    box-shadow: 0 6px 20px rgba(0, 123, 255, 0.3);
}

.card-icon i {
    font-size: 20px;
}

.card-text {
    font-size: 14px;
    line-height: 1.6;
    color: #6c757d;
}

.mission-list {
    list-style: none;
    padding: 0;
}

.mission-list li {
    position: relative;
    padding-left: 25px;
    margin-bottom: 12px;
    font-size: 14px;
    line-height: 1.6;
    color: #6c757d;
}

.mission-list li::before {
    content: '✓';
    position: absolute;
    left: 0;
    top: 0;
    color: #28a745;
    font-weight: bold;
    font-size: 16px;
}

/* Leadership & Affiliation Cards */
.leadership-card, .affiliation-card {
    background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
    transition: transform 0.3s ease;
}

.leadership-card:hover, .affiliation-card:hover {
    transform: translateY(-3px);
}

.leadership-icon, .affiliation-icon {
    background: linear-gradient(135deg, #673ab7, #9c27b0);
    color: white;
    width: 45px;
    height: 45px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 15px;
    box-shadow: 0 4px 15px rgba(103, 58, 183, 0.3);
}

.leadership-name, .affiliation-name {
    font-weight: 600;
    color: #495057;
    margin-bottom: 0;
}

/* Section Styling */
.manpower-section, .corebusiness-section {
    background: linear-gradient(135deg, #fff3e0 0%, #fce4ec 100%);
    border-radius: 15px;
    padding: 25px;
    border-left: 5px solid #ff9800;
}

.section-header {
    margin-bottom: 20px;
}

.section-title {
    color: #ff9800;
    font-weight: 700;
    font-size: 18px;
    margin-bottom: 0;
}

.section-description, .section-philosophy {
    font-size: 14px;
    line-height: 1.7;
    color: #6c757d;
    margin-bottom: 15px;
}

/* Values Grid */
.values-container {
    background: white;
    border-radius: 12px;
    padding: 20px;
    margin: 20px 0;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
}

.values-title {
    color: #495057;
    font-weight: 600;
    margin-bottom: 15px;
}

.values-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 10px;
}

.value-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 12px;
    background: linear-gradient(135deg, #e8f5e8, #f0f8ff);
    border-radius: 8px;
    transition: background 0.3s ease;
}

.value-item:hover {
    background: linear-gradient(135deg, #d4edda, #e3f2fd);
}

.value-item i {
    color: #ffc107;
    font-size: 12px;
}

.value-item span {
    font-size: 13px;
    color: #495057;
    font-weight: 500;
}

.development-note {
    background: rgba(255, 255, 255, 0.7);
    border-radius: 10px;
    padding: 15px;
    margin-top: 15px;
    border-left: 4px solid #17a2b8;
}

.development-note p {
    font-size: 13px;
    line-height: 1.6;
    color: #6c757d;
    margin-bottom: 0;
}

/* Manufacturing Highlight */
.manufacturing-highlight {
    background: white;
    border-radius: 12px;
    padding: 20px;
    margin-top: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    border: 2px solid #e9ecef;
}

.manufacturing-header {
    margin-bottom: 15px;
}

.manufacturing-title {
    color: #28a745;
    font-weight: 600;
    font-size: 16px;
}

.manufacturing-description {
    font-size: 14px;
    line-height: 1.6;
    color: #6c757d;
    margin-bottom: 20px;
}

.capabilities-section {
    margin-top: 20px;
}

.capabilities-title {
    color: #495057;
    font-weight: 600;
    margin-bottom: 15px;
    font-size: 15px;
}

.capabilities-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 12px;
}

.capability-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 15px;
    background: linear-gradient(135deg, #d4edda 0%, #d1ecf1 100%);
    border-radius: 8px;
    border-left: 3px solid #28a745;
    transition: all 0.3s ease;
}

.capability-item:hover {
    background: linear-gradient(135deg, #c3e6cb 0%, #bee5eb 100%);
    transform: translateX(5px);
}

.capability-item i {
    color: #28a745;
    font-size: 14px;
    flex-shrink: 0;
}

.capability-item span {
    font-size: 13px;
    color: #495057;
    line-height: 1.5;
}

/* Modal Footer */
.modal-footer-custom {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 0 0 15px 15px;
    padding: 15px 25px;
    border-top: 1px solid #dee2e6;
}

.source-info {
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
    font-style: italic;
}

.source-info i {
    color: #17a2b8;
}

/* Modal Dialog Enhancement */
.modal-dialog {
    max-width: 900px;
}

.modal-content {
    border: none;
    border-radius: 20px;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
    overflow: hidden;
}

.modal-header {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    color: white;
    border-bottom: none;
    padding: 20px 25px;
}

.modal-header .modal-title {
    font-weight: 600;
    font-size: 18px;
}

.modal-header .btn-close {
    background-color: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    padding: 8px;
    opacity: 0.8;
}

.modal-header .btn-close:hover {
    opacity: 1;
    background-color: rgba(255, 255, 255, 0.3);
}

/* Responsive Design for Modal */
@media (max-width: 768px) {
    .values-grid {
        grid-template-columns: 1fr;
    }
    
    .capabilities-grid {
        grid-template-columns: 1fr;
    }
    
    .info-card {
        margin-bottom: 20px;
    }
    
    .modal-dialog {
        margin: 10px;
        max-width: none;
    }
}

.project-card .card-body {
    padding: 1rem;
}

.project-card .card-title {
    font-size: 0.95rem;
    margin-bottom: 0.5rem;
}

.project-card .card-text {
    font-size: 0.8rem;
    line-height: 1.4;
}

/* Modal Styles */
.modal-content {
    border-radius: 15px;
    border: none;
}

.modal-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-top-left-radius: 15px;
    border-top-right-radius: 15px;
}

.modal-header .btn-close {
    filter: invert(1);
}

/* Modal Content Sections */
.modal-body .card.bg-light {
    border: none;
    border-left: 4px solid #28a745;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.modal-body .badge.bg-primary {
    background-color: #667eea !important;
}

.modal-body .badge.bg-success {
    background-color: #28a745 !important;
}

.modal-body .text-success {
    color: #28a745 !important;
}

.modal-body .text-secondary {
    color: #6c757d !important;
}

/* Section dividers */
.modal-body hr {
    border-top: 2px solid #e9ecef;
    margin: 2rem 0;
}

/* Responsive text sizes */
@media (max-width: 768px) {
    .modal-body h6 {
        font-size: 0.9rem;
    }
    
    .modal-body p,
    .modal-body small {
        font-size: 0.8rem;
    }
}

/* Product Detail Styles */
.spec-item {
    background: #f8f9fa;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 8px;
}

.feature-badge {
    background: #e3f2fd;
    color: #1976d2;
    padding: 5px 10px;
    border-radius: 15px;
    font-size: 0.8rem;
    margin: 2px;
    display: inline-block;
}

.application-item {
    background: #f1f8e9;
    color: #388e3c;
    padding: 8px 12px;
    border-radius: 8px;
    margin-bottom: 5px;
    border-left: 4px solid #4caf50;
}
</style>

<script>
// Product Detail Function
function showProductDetail(productName) {
    $('#productDetailModal').modal('show');
    
    // Show loading
    $('#productDetailContent').html(`
        <div class="text-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-3">Memuat detail produk...</p>
        </div>
    `);
    
    // Update modal title
    $('#productDetailModalLabel').html('<i class="fas fa-info-circle me-2"></i>Detail Produk: ' + productName);
    
    // Fetch product details
    $.ajax({
        url: '<?= base_url('dashboard/getProductDetail') ?>',
        method: 'POST',
        data: {
            product_name: productName
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                let product = response.product;
                let content = `
                    <div class="row">
                        <div class="col-md-4">
                            <h6 class="fw-bold text-primary mb-3">
                                <i class="fas fa-tag me-2"></i>Informasi Dasar
                            </h6>
                            <div class="mb-3">
                                <strong>Nama Produk:</strong><br>
                                <span class="text-muted">${product.name}</span>
                            </div>
                            <div class="mb-3">
                                <strong>Kategori:</strong><br>
                                <span class="text-info">${product.category}</span>
                            </div>
                            <div class="mb-3">
                                <strong>Berat:</strong><br>
                                <span class="text-muted">${product.weight} Kg</span>
                            </div>
                            <div class="mb-3">
                                <strong>Harga Estimasi:</strong><br>
                                <span class="text-success fs-5">Rp ${Number(product.price).toLocaleString('id-ID')}</span>
                            </div>
                            <div class="mb-3">
                                <strong>Satuan:</strong><br>
                                <span class="text-muted">${product.unit}</span>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="fw-bold text-primary mb-3">
                                        <i class="fas fa-cogs me-2"></i>Spesifikasi
                                    </h6>
                `;
                
                Object.entries(product.specifications).forEach(([key, value]) => {
                    content += `
                        <div class="spec-item">
                            <strong>${key}:</strong> ${value}
                        </div>
                    `;
                });
                
                content += `
                                </div>
                                <div class="col-md-6">
                                    <h6 class="fw-bold text-primary mb-3">
                                        <i class="fas fa-star me-2"></i>Keunggulan
                                    </h6>
                `;
                
                product.features.forEach(feature => {
                    content += `<span class="feature-badge">${feature}</span>`;
                });
                
                content += `
                                </div>
                            </div>
                            <div class="mt-4">
                                <h6 class="fw-bold text-primary mb-3">
                                    <i class="fas fa-hammer me-2"></i>Aplikasi & Penggunaan
                                </h6>
                `;
                
                product.applications.forEach(application => {
                    content += `<div class="application-item">${application}</div>`;
                });
                
                content += `
                            </div>
                        </div>
                    </div>
                `;
                
                $('#productDetailContent').html(content);
            } else {
                $('#productDetailContent').html(`
                    <div class="text-center text-danger">
                        <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                        <h5>Error</h5>
                        <p>${response.message}</p>
                    </div>
                `);
            }
        },
        error: function() {
            $('#productDetailContent').html(`
                <div class="text-center text-danger">
                    <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                    <h5>Error</h5>
                    <p>Gagal memuat detail produk. Silakan coba lagi.</p>
                </div>
            `);
        }
    });
}

// Image Preview Functions
let currentZoom = 1;
const zoomStep = 0.2;
const maxZoom = 3;
const minZoom = 0.5;

function openImagePreview(imageSrc, title, description) {
    const modal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
    
    // Reset zoom
    currentZoom = 1;
    
    // Set image source and info
    const previewImage = document.getElementById('previewImage');
    previewImage.src = imageSrc;
    previewImage.alt = title;
    previewImage.style.transform = `scale(${currentZoom})`;
    
    document.getElementById('imageTitle').textContent = title;
    document.getElementById('imageDescription').textContent = description;
    
    // Show modal
    modal.show();
    
    // Add event listener for image load error
    previewImage.onerror = function() {
        this.src = '<?= base_url('assets/images/placeholder.jpg') ?>';
        this.alt = 'Gambar tidak tersedia';
    };
    
    // Add wheel zoom functionality
    previewImage.onwheel = function(e) {
        e.preventDefault();
        if (e.deltaY < 0) {
            zoomImage('in');
        } else {
            zoomImage('out');
        }
    };
}

function zoomImage(direction) {
    const previewImage = document.getElementById('previewImage');
    
    if (direction === 'in' && currentZoom < maxZoom) {
        currentZoom += zoomStep;
    } else if (direction === 'out' && currentZoom > minZoom) {
        currentZoom -= zoomStep;
    }
    
    currentZoom = Math.round(currentZoom * 10) / 10; // Round to 1 decimal
    previewImage.style.transform = `scale(${currentZoom})`;
    
    // Update cursor based on zoom level
    if (currentZoom >= maxZoom) {
        previewImage.style.cursor = 'zoom-out';
    } else {
        previewImage.style.cursor = 'zoom-in';
    }
}

function resetZoom() {
    currentZoom = 1;
    const previewImage = document.getElementById('previewImage');
    previewImage.style.transform = `scale(${currentZoom})`;
    previewImage.style.cursor = 'zoom-in';
}

// Monthly Sales Chart
const ctx = document.getElementById('monthlyChart').getContext('2d');
const monthlyChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode(array_column($monthlyStats, 'month_name')) ?>,
        datasets: [{
            label: 'Penjualan (Rp)',
            data: <?= json_encode(array_column($monthlyStats, 'total')) ?>,
            borderColor: '#667eea',
            backgroundColor: 'rgba(102, 126, 234, 0.1)',
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#667eea',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 6,
            pointHoverRadius: 8
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + value.toLocaleString('id-ID');
                    }
                },
                grid: {
                    color: 'rgba(0,0,0,0.1)'
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        },
        elements: {
            point: {
                hoverBackgroundColor: '#667eea'
            }
        }
    }
});

// Auto refresh dashboard stats every 5 minutes
setInterval(function() {
    fetch('<?= base_url('api/dashboard/stats') ?>')
        .then(response => response.json())
        .then(data => {
            // Update stats if needed
            console.log('Dashboard stats updated');
        })
        .catch(error => console.log('Error updating stats:', error));
}, 300000); // 5 minutes
</script>
<?= $this->endSection() ?>
