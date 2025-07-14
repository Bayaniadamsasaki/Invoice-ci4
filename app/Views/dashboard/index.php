<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="fas fa-tachometer-alt me-2"></i>Dashboard</h2>
        <p class="text-muted mb-0">Selamat datang di Sistem Invoice PT Jaya Beton Plant Medan</p>
    </div>
    <div class="text-muted">
        <i class="fas fa-calendar me-1"></i><?= date('d F Y') ?>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card stats-card">
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
        <div class="card stats-card">
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
                <h5 class="mb-0"><i class="fas fa-images me-2"></i>Galeri Produk PT Jaya Beton</h5>
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
                                         loading="lazy">
                                    <div class="project-overlay">
                                        <span class="badge bg-primary project-category"><?= $project['category'] ?></span>
                                    </div>
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <h6 class="card-title fw-bold text-primary"><?= $project['title'] ?></h6>
                                    <p class="card-text text-muted small flex-grow-1"><?= $project['description'] ?></p>
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
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<style>
/* Project Gallery Styles */
.project-card {
    transition: all 0.3s ease;
    border: none;
    overflow: hidden;
}

.project-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
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
    transform: scale(1.1);
}

.project-overlay {
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 2;
}

.project-category {
    font-size: 0.7rem;
    padding: 4px 8px;
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
</style>

<script>
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
