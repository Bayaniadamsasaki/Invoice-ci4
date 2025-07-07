<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="fas fa-users me-2"></i>Data Rekanan</h2>
        <p class="text-muted mb-0">Kelola data rekanan/partner bisnis</p>
    </div>
    <a href="<?= base_url('rekanan/create') ?>" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tambah Rekanan
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>Daftar Rekanan</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Rekanan</th>
                        <th>Nama Rekanan</th>
                        <th>Alamat</th>
                        <th>NPWP</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($rekanan)): ?>
                        <?php $no = 1; foreach ($rekanan as $item): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><span class="badge bg-info"><?= $item['id_rek'] ?></span></td>
                                <td><strong><?= $item['nama_rek'] ?></strong></td>
                                <td><small><?= $item['alamat'] ?></small></td>
                                <td><?= $item['npwp'] ?: '<span class="text-muted">-</span>' ?></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?= base_url('rekanan/show/' . $item['id_rek']) ?>" 
                                           class="btn btn-sm btn-info" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= base_url('rekanan/edit/' . $item['id_rek']) ?>" 
                                           class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" 
                                                onclick="confirmDelete('<?= base_url('rekanan/delete/' . $item['id_rek']) ?>', 'rekanan <?= $item['nama_rek'] ?>')"
                                                title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="fas fa-users fa-4x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum ada data rekanan</h5>
                                <p class="text-muted">Klik tombol "Tambah Rekanan" untuk menambah data</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
