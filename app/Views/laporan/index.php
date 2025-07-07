<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="fas fa-chart-bar me-2"></i>Laporan Invoice</h2>
        <p class="text-muted mb-0">Daftar laporan invoice</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>Daftar Laporan Invoice</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>Data Invoice</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($laporan)): ?>
                        <?php $no = 1; foreach ($laporan as $item): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $item['id'] ?? '-' ?></td>
                                <td><?= $item['data_invoice'] ?? '-' ?></td>
                                <td>
                                    <?php if (!empty($item['id'])): ?>
                                        <a href="<?= base_url('invoice/print/' . $item['id']) ?>" target="_blank" class="btn btn-sm btn-primary">
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
                            <td colspan="3" class="text-center py-5">
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
