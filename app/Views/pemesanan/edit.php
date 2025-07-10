<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="fas fa-edit me-2"></i>Edit Pemesanan</h2>
        <p class="text-muted mb-0">Ubah data sales order</p>
    </div>
    <a href="<?= base_url('pemesanan') ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Form Edit Pemesanan</h5>
    </div>
    <div class="card-body">
        <?= form_open('pemesanan/update/' . $pemesanan['id_so']) ?>
            <input type="hidden" name="id_so" value="<?= $pemesanan['id_so'] ?>">
            <div class="mb-3">
                <label for="tgl_so" class="form-label">Tanggal SO *</label>
                <input type="date" class="form-control" id="tgl_so" name="tgl_so" value="<?= old('tgl_so', $pemesanan['tgl_so']) ?>" required>
                <?php if (isset($validation) && $validation->hasError('tgl_so')): ?>
                    <div class="text-danger small mt-1">
                        <i class="fas fa-exclamation-circle me-1"></i>
                        <?= $validation->getError('tgl_so') ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="no_po" class="form-label">No PO</label>
                <input type="text" class="form-control" id="no_po" name="no_po" value="<?= old('no_po', $pemesanan['no_po']) ?>">
            </div>
            <div class="mb-3">
                <label for="nama_rek" class="form-label">Rekanan *</label>
                <select class="form-select" id="nama_rek" name="nama_rek" required>
                    <option value="">Pilih Rekanan</option>
                    <?php foreach ($rekanan as $r): ?>
                        <option value="<?= $r['nama_rek'] ?>" <?= old('nama_rek', $pemesanan['nama_rek']) == $r['nama_rek'] ? 'selected' : '' ?>>
                            <?= $r['nama_rek'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if (isset($validation) && $validation->hasError('nama_rek')): ?>
                    <div class="text-danger small mt-1">
                        <i class="fas fa-exclamation-circle me-1"></i>
                        <?= $validation->getError('nama_rek') ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="nama_jenis_produk" class="form-label">Produk *</label>
                <select class="form-select" id="nama_jenis_produk" name="nama_jenis_produk" required>
                    <option value="">Pilih Produk</option>
                    <?php foreach ($produk as $p): ?>
                        <option value="<?= $p['nama_jenis_produk'] ?>" <?= old('nama_jenis_produk', $pemesanan['nama_jenis_produk']) == $p['nama_jenis_produk'] ? 'selected' : '' ?>>
                            <?= $p['nama_jenis_produk'] ?> - <?= $p['nama_kategori_produk'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if (isset($validation) && $validation->hasError('nama_jenis_produk')): ?>
                    <div class="text-danger small mt-1">
                        <i class="fas fa-exclamation-circle me-1"></i>
                        <?= $validation->getError('nama_jenis_produk') ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="order_btg" class="form-label">Jumlah Order *</label>
                <input type="number" class="form-control" id="order_btg" name="order_btg" value="<?= old('order_btg', $pemesanan['order_btg']) ?>" required min="1">
                <?php if (isset($validation) && $validation->hasError('order_btg')): ?>
                    <div class="text-danger small mt-1">
                        <i class="fas fa-exclamation-circle me-1"></i>
                        <?= $validation->getError('order_btg') ?>
                    </div>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Update</button>
        <?= form_close() ?>
    </div>
</div>
<?= $this->endSection() ?> 