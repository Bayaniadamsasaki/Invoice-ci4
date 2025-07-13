<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="fas fa-shopping-cart me-2"></i>Data Pemesanan</h2>
    </div>
    <a href="<?= base_url('pemesanan/create') ?>" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tambah Pemesanan
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>Daftar Pemesanan</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No SO</th>
                        <th>Tanggal</th>
                        <th>No PO</th>
                        <th>Rekanan</th>
                        <th>Produk</th>
                        <th>Qty</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pemesanan)): ?>
                        <?php $no = 1; foreach ($pemesanan as $item): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><strong><?= $item['id_so'] ?? '-' ?></strong></td>
                                <td><?= isset($item['tgl_so']) ? date('d/m/Y', strtotime($item['tgl_so'])) : '-' ?></td>
                                <td><?= !empty($item['no_po']) ? $item['no_po'] : '<span class="text-muted">-</span>' ?></td>
                                <td><strong><?= $item['nama_rek'] ?? '-' ?></strong></td>
                                <td><strong><?= $item['nama_jenis_produk'] ?? '-' ?></strong></td>
                                <td><strong><?= isset($item['order_btg']) ? number_format($item['order_btg']) : '-' ?></strong></td>
                                <td>
                                    <a href="<?= base_url('pemesanan/edit/' . $item['id_so']) ?>" class="btn btn-sm btn-warning me-1" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirmDelete('<?= base_url('pemesanan/delete/' . $item['id_so']) ?>', 'Pemesanan ID <?= $item['id_so'] ?>');">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum ada data pemesanan</h5>
                                <p class="text-muted">Klik tombol "Tambah Pemesanan" untuk menambah data</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
