<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="fas fa-users me-2"></i>Data Rekanan</h2>
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
                        <th>ID Rekanan</th>
                        <th>Nama Rekanan</th>
                        <th>Alamat</th>
                        <th>NPWP</th>
                        <th class="no-sort">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($rekanan)): ?>
                        <?php foreach ($rekanan as $item): ?>
                            <tr>
                                <td><span class="badge bg-info"><?= $item['id_rek'] ?></span></td>
                                <td><strong><?= $item['nama_rek'] ?></strong></td>
                                <td><small><?= $item['alamat'] ?></small></td>
                                <td><?= $item['npwp'] ?: '<span class="text-muted">-</span>' ?></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?= base_url('rekanan/edit/' . $item['id_rek']) ?>" 
                                           class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" 
                                                onclick="return confirmDelete('<?= base_url('rekanan/delete/' . $item['id_rek']) ?>', 'Rekanan <?= $item['nama_rek'] ?>')"
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
