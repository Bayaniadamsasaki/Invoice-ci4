<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="fas fa-plus me-2"></i>Tambah Produk</h2>
        <p class="text-muted mb-0">Tambah data produk baru</p>
    </div>
    <a href="<?= base_url('produk') ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-box me-2"></i>Form Tambah Produk</h5>
    </div>
    <div class="card-body">
        <?= form_open('produk/store') ?>
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="kode_jenis_produk" class="form-label">Kode Jenis Produk *</label>
                        <input type="text" class="form-control" id="kode_jenis_produk" name="kode_jenis_produk" value="<?= old('kode_jenis_produk') ?>" required>
                        <?php if (isset($validation) && $validation->hasError('kode_jenis_produk')): ?>
                            <div class="text-danger small mt-1">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                <?= $validation->getError('kode_jenis_produk') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="nama_jenis_produk" class="form-label">Nama Jenis Produk *</label>
                        <input type="text" class="form-control" id="nama_jenis_produk" name="nama_jenis_produk" value="<?= old('nama_jenis_produk') ?>" required>
                        <?php if (isset($validation) && $validation->hasError('nama_jenis_produk')): ?>
                            <div class="text-danger small mt-1">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                <?= $validation->getError('nama_jenis_produk') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="kode_kategori_produk_" class="form-label">Kode Kategori Produk *</label>
                        <input type="text" class="form-control" id="kode_kategori_produk_" name="kode_kategori_produk_" value="<?= old('kode_kategori_produk_') ?>" required>
                        <?php if (isset($validation) && $validation->hasError('kode_kategori_produk_')): ?>
                            <div class="text-danger small mt-1">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                <?= $validation->getError('kode_kategori_produk_') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nama_kategori_produk" class="form-label">Nama Kategori Produk *</label>
                        <input type="text" class="form-control" id="nama_kategori_produk" name="nama_kategori_produk" value="<?= old('nama_kategori_produk') ?>" required>
                        <?php if (isset($validation) && $validation->hasError('nama_kategori_produk')): ?>
                            <div class="text-danger small mt-1">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                <?= $validation->getError('nama_kategori_produk') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="berat" class="form-label">Berat *</label>
                        <input type="number" class="form-control" id="berat" name="berat" value="<?= old('berat') ?>" required>
                        <?php if (isset($validation) && $validation->hasError('berat')): ?>
                            <div class="text-danger small mt-1">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                <?= $validation->getError('berat') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
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
