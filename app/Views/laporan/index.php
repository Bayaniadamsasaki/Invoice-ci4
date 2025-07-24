<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="fas fa-chart-bar me-2"></i>Laporan Invoice</h2>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>Laporan Invoice</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover data-table">
                <thead>
                    <tr>
                        <th>No Invoice</th>
                        <th>Tanggal</th>
                        <th>Nama Rekanan</th>
                        <th>Produk</th>
                        <th>Total Harga</th>
                        <th class="no-sort">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($laporan)): ?>
                        <?php foreach ($laporan as $item): ?>
                            <tr>
                                <td><?= $item['no_invoice'] ?? '-' ?></td>
                                <td><?= isset($item['tgl_so']) ? date('d/m/Y', strtotime($item['tgl_so'])) : '-' ?></td>
                                <td><?= $item['nama_rek'] ?? '-' ?></td>
                                <td><?= $item['nama_jenis_produk'] ?? '-' ?></td>
                                <td>Rp <?= isset($item['total_harga']) ? number_format($item['total_harga'], 0, ',', '.') : '-' ?></td>
                                <td>
                                    <?php if (!empty($item['no_invoice'])): ?>
                                        <a href="<?= base_url('invoice/print/' . $item['no_invoice']) ?>" target="_blank" class="btn btn-sm btn-primary">
                                            <i class="fas fa-print"></i> Print
                                        </a>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="fas fa-chart-bar fa-4x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum ada data laporan invoice</h5>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
