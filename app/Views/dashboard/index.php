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
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Grafik Penjualan Bulanan <?= date('Y') ?></h5>
            </div>
            <div class="card-body">
                <canvas id="monthlyChart" height="100"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-calculator me-2"></i>Ringkasan Keuangan</h5>
            </div>
            <div class="card-body">
                <?php 
                $totalPenjualan = array_sum(array_column($monthlyStats, 'total'));
                $rataRata = $totalPenjualan / 12;
                ?>
                <div class="mb-3">
                    <small class="text-muted">Total Penjualan <?= date('Y') ?></small>
                    <h4 class="text-primary">Rp <?= number_format($totalPenjualan, 0, ',', '.') ?></h4>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Rata-rata per Bulan</small>
                    <h5 class="text-info">Rp <?= number_format($rataRata, 0, ',', '.') ?></h5>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Bulan Tertinggi</small>
                    <?php 
                    $maxMonth = array_reduce($monthlyStats, function($carry, $item) {
                        return ($carry === null || $item['total'] > $carry['total']) ? $item : $carry;
                    });
                    ?>
                    <h6 class="text-success"><?= $maxMonth['month_name'] ?><br>
                    <small>Rp <?= number_format($maxMonth['total'], 0, ',', '.') ?></small></h6>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Invoices -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Invoice Terbaru</h5>
        <a href="<?= base_url('invoice') ?>" class="btn btn-sm btn-outline-primary">
            Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
        </a>
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
                            <th>Status</th>
                            <th>Aksi</th>
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
                                <td><?= $invoice['no_so'] ?></td>
                                <td><?= date('d/m/Y', strtotime($invoice['tgl_so'])) ?></td>
                                <td>Rp <?= number_format($invoice['total_harga'], 0, ',', '.') ?></td>
                                <td>
                                    <span class="badge bg-<?= $invoice['status_pembayaran'] == 'paid' ? 'success' : ($invoice['status_pembayaran'] == 'partial' ? 'warning' : 'danger') ?>">
                                        <?= ucfirst($invoice['status_pembayaran']) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?= base_url('invoice/show/' . $invoice['no_invoice']) ?>" 
                                           class="btn btn-sm btn-outline-info" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= base_url('invoice/print/' . $invoice['no_invoice']) ?>" 
                                           class="btn btn-sm btn-outline-success" title="Print" target="_blank">
                                            <i class="fas fa-print"></i>
                                        </a>
                                    </div>
                                </td>
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
