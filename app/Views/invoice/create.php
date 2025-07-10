<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="fas fa-plus me-2"></i>Buat Invoice</h2>
        <p class="text-muted mb-0">Buat invoice dari pemesanan</p>
    </div>
    <a href="<?= base_url('invoice') ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<?php if (!$pemesanan): ?>
<div class="card mb-4">
    <div class="card-header">
        <h6 class="mb-0"><i class="fas fa-search me-2"></i>Pilih Data Pemesanan</h6>
    </div>
    <div class="card-body">
        <form method="get" action="<?= base_url('invoice/create') ?>">
            <div class="mb-3">
                <label for="pemesanan_id" class="form-label">Pilih Pemesanan</label>
                <select class="form-select" id="pemesanan_id" name="pemesanan_id" required onchange="if(this.value) window.location='<?= base_url('invoice/create') ?>/' + this.value;">
                    <option value="">-- Pilih Pemesanan --</option>
                    <?php foreach ($list_pemesanan as $p): ?>
                        <option value="<?= $p['id_so'] ?>" <?= $selected_pemesanan_id == $p['id_so'] ? 'selected' : '' ?>>
                            <?= $p['id_so'] ?> | <?= $p['tgl_so'] ?> | <?= $p['nama_rek'] ?> | <?= $p['nama_jenis_produk'] ?> | <?= $p['order_btg'] ?> Batang
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<?php if ($pemesanan): ?>
<!-- Detail Pemesanan -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Detail Pemesanan</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td>No SO</td>
                        <td>: <strong><?= $pemesanan['id_so'] ?></strong></td>
                    </tr>
                    <tr>
                        <td>Tanggal SO</td>
                        <td>: <?= date('d/m/Y', strtotime($pemesanan['tgl_so'])) ?></td>
                    </tr>
                    <tr>
                        <td>No PO</td>
                        <td>: <?= $pemesanan['no_po'] ?? '-' ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-building me-2"></i>Detail Rekanan</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td>Nama</td>
                        <td>: <strong><?= $pemesanan['nama_rek'] ?></strong></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>: <?= $pemesanan['alamat'] ?></td>
                    </tr>
                    <tr>
                        <td>NPWP</td>
                        <td>: <?= $pemesanan['npwp'] ?: '-' ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Detail Produk -->
<div class="card mb-4">
    <div class="card-header">
        <h6 class="mb-0"><i class="fas fa-box me-2"></i>Detail Produk</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Qty</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= $pemesanan['nama_jenis_produk'] ?></td>
                        <td><?= $pemesanan['nama_kategori_produk'] ?></td>
                        <td><?= number_format($pemesanan['order_btg']) ?></td>
                        <td><strong>Rp <?= number_format($pemesanan['total_harga'], 0, ',', '.') ?></strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Form Invoice -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-file-invoice me-2"></i>Form Buat Invoice</h5>
    </div>
    <div class="card-body">
        <?php if (session('validation')): ?>
            <div class="alert alert-danger">
                <?= session('validation')->listErrors() ?>
            </div>
        <?php endif; ?>
        <?= form_open('invoice/store') ?>
            <input type="hidden" name="pemesanan_id" value="<?= $pemesanan['id_so'] ?>">
            <input type="hidden" id="qty" value="<?= $pemesanan['order_btg'] ?>">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="no_invoice" class="form-label">No Invoice (Otomatis)</label>
                        <input type="text" class="form-control" id="no_invoice" name="no_invoice" value="<?= $next_no_invoice ?>" readonly>
                        <?php if (isset($validation) && $validation->hasError('no_invoice')): ?>
                            <div class="text-danger small mt-1">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                <?= $validation->getError('no_invoice') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="harga_satuan" class="form-label">Harga Satuan *</label>
                        <input type="number" class="form-control" id="harga_satuan" name="harga_satuan" value="<?= old('harga_satuan') ?>" required min="0">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="tanggal_invoice" class="form-label">Tanggal Invoice *</label>
                        <input type="date" class="form-control" id="tanggal_invoice" name="tanggal_invoice" 
                               value="<?= old('tanggal_invoice', date('Y-m-d')) ?>" required>
                        <?php if (isset($validation) && $validation->hasError('tanggal_invoice')): ?>
                            <div class="text-danger small mt-1">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                <?= $validation->getError('tanggal_invoice') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="ppn" class="form-label">PPN (%) *</label>
                        <input type="number" class="form-control" id="ppn" name="ppn" 
                               value="<?= old('ppn', 11) ?>" step="0.01" required min="0">
                        <?php if (isset($validation) && $validation->hasError('ppn')): ?>
                            <div class="text-danger small mt-1">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                <?= $validation->getError('ppn') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control" id="keterangan" name="keterangan" rows="3"><?= old('keterangan') ?></textarea>
            </div>
            <div class="mb-3">
                <label for="npwp" class="form-label">NPWP *</label>
                <input type="text" class="form-control" id="npwp" name="npwp"
                       value="<?= old('npwp', $pemesanan['npwp'] ?? '') ?>" required>
            </div>
            <!-- Kalkulasi -->
            <div class="card bg-light">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <strong>Subtotal:</strong>
                        </div>
                        <div class="col-6 text-end" id="subtotal">Rp 0</div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <strong>PPN:</strong>
                        </div>
                        <div class="col-6 text-end" id="ppn_value">Rp 0</div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-6">
                            <strong>Total:</strong>
                        </div>
                        <div class="col-6 text-end fw-bold text-primary" id="total_with_ppn">Rp 0</div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Buat Invoice
                </button>
            </div>
        <?= form_close() ?>
    </div>
</div>
<script>
function updateTotal() {
    var qty = parseFloat(document.getElementById('qty').value) || 0;
    var harga = parseFloat(document.getElementById('harga_satuan').value) || 0;
    var ppn = parseFloat(document.getElementById('ppn').value) || 0;
    var subtotal = qty * harga;
    var nilaiPpn = subtotal * (ppn / 100);
    var total = subtotal + nilaiPpn;
    document.getElementById('subtotal').innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
    document.getElementById('ppn_value').innerText = 'Rp ' + nilaiPpn.toLocaleString('id-ID');
    document.getElementById('total_with_ppn').innerText = 'Rp ' + total.toLocaleString('id-ID');
}
document.getElementById('harga_satuan').addEventListener('input', updateTotal);
document.getElementById('ppn').addEventListener('input', updateTotal);
window.addEventListener('DOMContentLoaded', updateTotal);
</script>
<?php endif; ?>
<?= $this->endSection() ?>
