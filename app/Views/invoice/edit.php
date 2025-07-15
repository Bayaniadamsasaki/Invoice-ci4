<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="fas fa-edit me-2"></i>Edit Invoice</h2>
        <p class="text-muted mb-0">Ubah data invoice</p>
    </div>
    <a href="<?= base_url('invoice') ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<!-- Detail Invoice -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Detail Invoice</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td>No Invoice</td>
                        <td>: <strong><?= $invoice['no_invoice'] ?></strong></td>
                    </tr>
                    <tr>
                        <td>Tanggal SO</td>
                        <td>: <?= date('d/m/Y', strtotime($invoice['tgl_so'])) ?></td>
                    </tr>
                    <tr>
                        <td>No PO</td>
                        <td>: <?= $invoice['no_po'] ?? '-' ?></td>
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
                        <td>: <strong><?= $invoice['nama_rek'] ?></strong></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>: <?= $invoice['alamat'] ?></td>
                    </tr>
                    <tr>
                        <td>NPWP</td>
                        <td>: <?= $invoice['npwp'] ?: '-' ?></td>
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
                        <th>Qty</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= $invoice['nama_jenis_produk'] ?></td>
                        <td><?= number_format($invoice['order_btg']) ?></td>
                        <td><strong>Rp <?= number_format($invoice['total_harga'], 0, ',', '.') ?></strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Form Edit Invoice -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-file-invoice me-2"></i>Form Edit Invoice</h5>
    </div>
    <div class="card-body">
        <?php if (session('validation')): ?>
            <div class="alert alert-danger">
                <?= session('validation')->listErrors() ?>
            </div>
        <?php endif; ?>
        <?= form_open('invoice/update/' . $invoice['no_invoice']) ?>
            <input type="hidden" name="no_invoice" value="<?= $invoice['no_invoice'] ?>">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="harga_satuan" class="form-label">Harga Satuan *</label>
                        <input type="number" class="form-control" id="harga_satuan" name="harga_satuan" value="<?= old('harga_satuan', $invoice['harga_satuan'] ?? '') ?>" required min="0">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="tanggal_invoice" class="form-label">Tanggal Invoice *</label>
                        <input type="date" class="form-control" id="tanggal_invoice" name="tanggal_invoice" value="<?= old('tanggal_invoice', $invoice['tanggal_invoice'] ?? date('Y-m-d')) ?>" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="ppn" class="form-label">PPN (%) *</label>
                        <input type="number" class="form-control" id="ppn" name="ppn" value="<?= old('ppn', $invoice['ppn'] ?? 11) ?>" step="0.01" required min="0">
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="npwp" class="form-label">NPWP *</label>
                <input type="text" class="form-control" id="npwp" name="npwp" value="<?= old('npwp', $invoice['npwp'] ?? '') ?>" required>
            </div>
            <div class="card bg-light mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6"><strong>Subtotal:</strong></div>
                        <div class="col-6 text-end" id="subtotal">Rp 0</div>
                    </div>
                    <div class="row">
                        <div class="col-6"><strong>PPN:</strong></div>
                        <div class="col-6 text-end" id="ppn_value">Rp 0</div>
                    </div>
                    <div class="row">
                        <div class="col-6"><strong>Total:</strong></div>
                        <div class="col-6 text-end" id="total">Rp 0</div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Update</button>
        <?= form_close() ?>
    </div>
</div>
<script>
function formatRupiah(angka) {
    return 'Rp ' + angka.toLocaleString('id-ID');
}

function hitungTotal() {
    var hargaSatuan = parseFloat(document.getElementById('harga_satuan').value) || 0;
    var qty = <?= (int)($invoice['order_btg'] ?? 0) ?>;
    var ppn = parseFloat(document.getElementById('ppn').value) || 0;

    var subtotal = hargaSatuan * qty;
    var nilaiPpn = subtotal * (ppn / 100);
    var total = subtotal + nilaiPpn;

    document.getElementById('subtotal').innerText = formatRupiah(subtotal);
    document.getElementById('ppn_value').innerText = formatRupiah(nilaiPpn);
    document.getElementById('total').innerText = formatRupiah(total);
}

document.getElementById('harga_satuan').addEventListener('input', hitungTotal);
document.getElementById('ppn').addEventListener('input', hitungTotal);

hitungTotal();
</script>
<?= $this->endSection() ?> 