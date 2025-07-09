<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="fas fa-edit me-2"></i>Edit Rekanan</h2>
        <p class="text-muted mb-0">Edit data rekanan: <?= $rekanan['nama_rek'] ?></p>
    </div>
    <a href="<?= base_url('rekanan') ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-user me-2"></i>Form Edit Rekanan</h5>
    </div>
    <div class="card-body">
        <?= form_open('rekanan/update/' . $rekanan['id_rek']) ?>
            <div class="mb-3">
                <label for="nama_rek" class="form-label">Nama Rekanan *</label>
                <input type="text" class="form-control" id="nama_rek" name="nama_rek" 
                       value="<?= old('nama_rek', $rekanan['nama_rek']) ?>" required>
                <?php if (isset($validation) && $validation->hasError('nama_rek')): ?>
                    <div class="text-danger small mt-1">
                        <i class="fas fa-exclamation-circle me-1"></i>
                        <?= $validation->getError('nama_rek') ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat *</label>
                <input type="text" class="form-control" id="alamat" name="alamat" value="<?= old('alamat', $rekanan['alamat']) ?>" required>
                <?php if (isset($validation) && $validation->hasError('alamat')): ?>
                    <div class="text-danger small mt-1">
                        <i class="fas fa-exclamation-circle me-1"></i>
                        <?= $validation->getError('alamat') ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="npwp" class="form-label">NPWP</label>
                <input type="text" class="form-control" id="npwp" name="npwp" value="<?= old('npwp', $rekanan['npwp']) ?>" placeholder="00.000.000.0-000.000">
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Update</button>
        <?= form_close() ?>
    </div>
</div>
<?= $this->endSection() ?>
