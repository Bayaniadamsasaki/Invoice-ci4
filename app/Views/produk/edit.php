<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="fas fa-edit me-2"></i>Edit Produk</h2>
        <p class="text-muted mb-0">Edit data produk: <?= $produk['nama_jenis_produk'] ?></p>
    </div>
    <a href="<?= base_url('produk') ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-box me-2"></i>Form Edit Produk</h5>
    </div>
    <div class="card-body">
        <?= form_open('produk/update/' . $produk['id']) ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="kode_jenis_produk" class="form-label">Kode Jenis Produk *</label>
                        <input type="text" class="form-control" id="kode_jenis_produk" name="kode_jenis_produk" 
                               value="<?= old('kode_jenis_produk', $produk['kode_jenis_produk']) ?>" required>
                        <?php if (isset($validation) && $validation->hasError('kode_jenis_produk')): ?>
                            <div class="text-danger small mt-1">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                <?= $validation->getError('kode_jenis_produk') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="kode_kategori_produk" class="form-label">Kode Kategori *</label>
                        <input type="text" class="form-control" id="kode_kategori_produk" name="kode_kategori_produk" 
                               value="<?= old('kode_kategori_produk', $produk['kode_kategori_produk']) ?>" required>
                        <?php if (isset($validation) && $validation->hasError('kode_kategori_produk')): ?>
                            <div class="text-danger small mt-1">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                <?= $validation->getError('kode_kategori_produk') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nama_jenis_produk" class="form-label">Nama Jenis Produk *</label>
                        <input type="text" class="form-control" id="nama_jenis_produk" name="nama_jenis_produk" 
                               value="<?= old('nama_jenis_produk', $produk['nama_jenis_produk']) ?>" required>
                        <?php if (isset($validation) && $validation->hasError('nama_jenis_produk')): ?>
                            <div class="text-danger small mt-1">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                <?= $validation->getError('nama_jenis_produk') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nama_kategori_produk" class="form-label">Nama Kategori Produk *</label>
                        <input type="text" class="form-control" id="nama_kategori_produk" name="nama_kategori_produk" 
                               value="<?= old('nama_kategori_produk', $produk['nama_kategori_produk']) ?>" required>
                        <?php if (isset($validation) && $validation->hasError('nama_kategori_produk')): ?>
                            <div class="text-danger small mt-1">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                <?= $validation->getError('nama_kategori_produk') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="diameter_lebar" class="form-label">Diameter/Lebar (mm)</label>
                        <input type="text" class="form-control" id="diameter_lebar" name="diameter_lebar" 
                               value="<?= old('diameter_lebar', $produk['diameter_lebar']) ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="tinggi" class="form-label">Tinggi (mm)</label>
                        <input type="text" class="form-control" id="tinggi" name="tinggi" 
                               value="<?= old('tinggi', $produk['tinggi']) ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="tebal" class="form-label">Tebal (mm)</label>
                        <input type="text" class="form-control" id="tebal" name="tebal" 
                               value="<?= old('tebal', $produk['tebal']) ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="panjang" class="form-label">Panjang (m)</label>
                        <input type="text" class="form-control" id="panjang" name="panjang" 
                               value="<?= old('panjang', $produk['panjang']) ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="berat" class="form-label">Berat *</label>
                        <input type="text" class="form-control" id="berat" name="berat" 
                               value="<?= old('berat', $produk['berat']) ?>" required>
                        <?php if (isset($validation) && $validation->hasError('berat')): ?>
                            <div class="text-danger small mt-1">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                <?= $validation->getError('berat') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="satuan" class="form-label">Satuan</label>
                        <select class="form-select" id="satuan" name="satuan">
                            <option value="BTG" <?= old('satuan', $produk['satuan']) == 'BTG' ? 'selected' : '' ?>>BTG</option>
                            <option value="TON" <?= old('satuan', $produk['satuan']) == 'TON' ? 'selected' : '' ?>>TON</option>
                            <option value="M3" <?= old('satuan', $produk['satuan']) == 'M3' ? 'selected' : '' ?>>M3</option>
                            <option value="PCS" <?= old('satuan', $produk['satuan']) == 'PCS' ? 'selected' : '' ?>>PCS</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="harga_satuan" class="form-label">Harga Satuan *</label>
                        <input type="number" class="form-control" id="harga_satuan" name="harga_satuan" 
                               value="<?= old('harga_satuan', $produk['harga_satuan']) ?>" step="0.01" required>
                        <?php if (isset($validation) && $validation->hasError('harga_satuan')): ?>
                            <div class="text-danger small mt-1">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                <?= $validation->getError('harga_satuan') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Update
                </button>
            </div>
        <?= form_close() ?>
    </div>
</div>
<?= $this->endSection() ?>
