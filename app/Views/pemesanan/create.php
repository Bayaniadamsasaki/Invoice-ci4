<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="fas fa-plus me-2"></i>Tambah Pemesanan</h2>
        <p class="text-muted mb-0">Buat sales order baru</p>
    </div>
    <a href="<?= base_url('pemesanan') ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Form Tambah Pemesanan</h5>
    </div>
    <div class="card-body">
        <?= form_open('pemesanan/store') ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="no_so" class="form-label">No SO *</label>
                        <input type="text" class="form-control" id="no_so" name="no_so" 
                               value="<?= old('no_so', 'SO-' . date('Ymd') . '-' . sprintf('%03d', rand(1, 999))) ?>" required>
                        <?php if (isset($validation) && $validation->hasError('no_so')): ?>
                            <div class="text-danger small mt-1">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                <?= $validation->getError('no_so') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="tanggal_so" class="form-label">Tanggal SO *</label>
                        <input type="date" class="form-control" id="tanggal_so" name="tanggal_so" 
                               value="<?= old('tanggal_so', date('Y-m-d')) ?>" required>
                        <?php if (isset($validation) && $validation->hasError('tanggal_so')): ?>
                            <div class="text-danger small mt-1">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                <?= $validation->getError('tanggal_so') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="no_po" class="form-label">No PO</label>
                <input type="text" class="form-control" id="no_po" name="no_po" 
                       value="<?= old('no_po') ?>" placeholder="Nomor Purchase Order dari customer">
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="rekanan_id" class="form-label">Rekanan *</label>
                        <select class="form-select" id="rekanan_id" name="rekanan_id" required>
                            <option value="">Pilih Rekanan</option>
                            <?php foreach ($rekanan as $r): ?>
                                <option value="<?= $r['id'] ?>" <?= old('rekanan_id') == $r['id'] ? 'selected' : '' ?>>
                                    <?= $r['nama_rekanan'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($validation) && $validation->hasError('rekanan_id')): ?>
                            <div class="text-danger small mt-1">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                <?= $validation->getError('rekanan_id') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="produk_id" class="form-label">Produk *</label>
                        <select class="form-select" id="produk_id" name="produk_id" required onchange="onProductChange(this)">
                            <option value="">Pilih Produk</option>
                            <?php foreach ($produk as $p): ?>
                                <option value="<?= $p['id'] ?>" data-harga="<?= $p['harga_satuan'] ?>" <?= old('produk_id') == $p['id'] ? 'selected' : '' ?>>
                                    <?= $p['nama_jenis_produk'] ?> - <?= $p['nama_kategori_produk'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($validation) && $validation->hasError('produk_id')): ?>
                            <div class="text-danger small mt-1">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                <?= $validation->getError('produk_id') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="order_btg" class="form-label">Jumlah Order *</label>
                        <input type="number" class="form-control" id="order_btg" name="order_btg" 
                               value="<?= old('order_btg') ?>" required min="1">
                        <?php if (isset($validation) && $validation->hasError('order_btg')): ?>
                            <div class="text-danger small mt-1">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                <?= $validation->getError('order_btg') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="harga_satuan" class="form-label">Harga Satuan *</label>
                        <input type="number" class="form-control" id="harga_satuan" name="harga_satuan" 
                               value="<?= old('harga_satuan') ?>" step="0.01" required min="0">
                        <?php if (isset($validation) && $validation->hasError('harga_satuan')): ?>
                            <div class="text-danger small mt-1">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                <?= $validation->getError('harga_satuan') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Total Harga</label>
                        <div class="form-control-plaintext fw-bold text-success" id="total_preview">Rp 0</div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control" id="keterangan" name="keterangan" rows="3"><?= old('keterangan') ?></textarea>
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
