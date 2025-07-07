<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="fas fa-plus me-2"></i>Tambah Rekanan</h2>
        <p class="text-muted mb-0">Tambah data rekanan/partner bisnis baru</p>
    </div>
    <a href="<?= base_url('rekanan') ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-user me-2"></i>Form Tambah Rekanan</h5>
    </div>
    <div class="card-body">
        <?= form_open('rekanan/store') ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="kode_rekanan" class="form-label">Kode Rekanan</label>
                        <input type="text" class="form-control" id="kode_rekanan" name="kode_rekanan" 
                               value="<?= old('kode_rekanan') ?>">
                        <small class="text-muted">Opsional - akan diisi otomatis jika kosong</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="npwp" class="form-label">NPWP</label>
                        <input type="text" class="form-control" id="npwp" name="npwp" 
                               value="<?= old('npwp') ?>" placeholder="00.000.000.0-000.000">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="nama_rekanan" class="form-label">Nama Rekanan *</label>
                <input type="text" class="form-control" id="nama_rekanan" name="nama_rekanan" 
                       value="<?= old('nama_rekanan') ?>" required>
                <?php if (isset($validation) && $validation->hasError('nama_rekanan')): ?>
                    <div class="text-danger small mt-1">
                        <i class="fas fa-exclamation-circle me-1"></i>
                        <?= $validation->getError('nama_rekanan') ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat *</label>
                <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?= old('alamat') ?></textarea>
                <?php if (isset($validation) && $validation->hasError('alamat')): ?>
                    <div class="text-danger small mt-1">
                        <i class="fas fa-exclamation-circle me-1"></i>
                        <?= $validation->getError('alamat') ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="telepon" class="form-label">Telepon</label>
                        <input type="text" class="form-control" id="telepon" name="telepon" 
                               value="<?= old('telepon') ?>">
                        <?php if (isset($validation) && $validation->hasError('telepon')): ?>
                            <div class="text-danger small mt-1">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                <?= $validation->getError('telepon') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="<?= old('email') ?>">
                        <?php if (isset($validation) && $validation->hasError('email')): ?>
                            <div class="text-danger small mt-1">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                <?= $validation->getError('email') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="contact_person" class="form-label">Contact Person</label>
                <input type="text" class="form-control" id="contact_person" name="contact_person" 
                       value="<?= old('contact_person') ?>">
            </div>

            <div class="d-flex justify-content-end">
                <button type="reset" class="btn btn-secondary me-2">Reset</button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Simpan
                </button>
            </div>
        <?= form_close() ?>
    </div>
</div>
<?= $this->endSection() ?>
