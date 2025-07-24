<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="fas fa-boxes me-2"></i>Data Produk</h2>
    </div>
    <a href="<?= base_url('produk/create') ?>" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tambah Produk
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>Daftar Produk</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover data-table">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Jenis Produk</th>
                        <th>Kategori</th>
                        <th>Berat</th>
                        <th class="no-sort">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($produk)): ?>
                        <?php foreach ($produk as $item): ?>
                            <tr>
                                <td>
                                    <span class="badge bg-secondary"><?= $item['kode_jenis_produk'] ?></span>
                                </td>
                                <td>
                                    <strong><?= $item['nama_jenis_produk'] ?></strong><br>
                                    <small class="text-muted"><?= $item['kode_kategori_produk_'] ?></small>
                                </td>
                                <td><?= $item['nama_kategori_produk'] ?></td>
                                <td><?= $item['berat'] ?></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?= base_url('produk/edit/' . $item['kode_jenis_produk']) ?>" 
                                           class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" 
                                                onclick="return confirmDelete('<?= base_url('produk/delete/' . $item['kode_jenis_produk']) ?>', 'Produk <?= $item['nama_jenis_produk'] ?>')"
                                                title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="fas fa-boxes fa-4x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum ada data produk</h5>
                                <p class="text-muted">Klik tombol "Tambah Produk" untuk menambah data</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
