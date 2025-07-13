<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="fas fa-file-invoice me-2"></i>Detail Invoice</h2>
        <p class="text-muted mb-0">Invoice: <?= $invoice['no_invoice'] ?></p>
    </div>
    <div>
        <a href="<?= base_url('invoice/print/' . $invoice['no_invoice']) ?>" 
           class="btn btn-success me-2" target="_blank">
            <i class="fas fa-print me-2"></i>Print
        </a>
        <a href="<?= base_url('invoice') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<!-- Invoice Header -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Invoice</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td>No Invoice</td>
                        <td>: <strong><?= $invoice['no_invoice'] ?></strong></td>
                    </tr>
                    <tr>
                        <td>Tanggal Invoice</td>
                        <td>: <?= date('d/m/Y', strtotime($invoice['tanggal_invoice'])) ?></td>
                    </tr>
                    <tr>
                        <td>Jatuh Tempo</td>
                        <td>: <?= $invoice['due_date'] ? date('d/m/Y', strtotime($invoice['due_date'])) : '-' ?></td>
                    </tr>
                    <tr>
                        <td>No SO</td>
                        <td>: <?= $invoice['pemesanan_id'] ?? '-' ?></td>
                    </tr>
                    <tr>
                        <td>No PO</td>
                        <td>: <?= $invoice['no_po'] ?: '-' ?></td>
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
                    <tr>
                        <td>Telepon</td>
                        <td>: <?= $invoice['telepon'] ?: '-' ?></td>
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
                        <th>Harga Satuan</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= $invoice['nama_jenis_produk'] ?></td>
                        <td><?= $invoice['nama_kategori_produk'] ?></td>
                        <td><?= number_format($invoice['order_btg']) ?> <?= $invoice['satuan'] ?></td>
                        <td>Rp <?= number_format($invoice['total_sebelum_ppn'] / $invoice['order_btg'], 0, ',', '.') ?></td>
                        <td><strong>Rp <?= number_format($invoice['total_sebelum_ppn'], 0, ',', '.') ?></strong></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-end"><strong>Subtotal:</strong></td>
                        <td><strong>Rp <?= number_format($invoice['total_sebelum_ppn'], 0, ',', '.') ?></strong></td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-end"><strong>PPN (<?= $invoice['ppn'] ?>%):</strong></td>
                        <td><strong>Rp <?= number_format($invoice['nilai_ppn'], 0, ',', '.') ?></strong></td>
                    </tr>
                    <tr class="table-primary">
                        <td colspan="4" class="text-end"><strong>TOTAL:</strong></td>
                        <td><strong>Rp <?= number_format($invoice['total_setelah_ppn'], 0, ',', '.') ?></strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- Status Pembayaran -->
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="fas fa-money-bill-wave me-2"></i>Status Pembayaran</h6>
                <span class="badge bg-<?= $invoice['status_pembayaran'] == 'paid' ? 'success' : ($invoice['status_pembayaran'] == 'partial' ? 'warning' : 'danger') ?>">
                    <?= ucfirst($invoice['status_pembayaran']) ?>
                </span>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td>Total Invoice</td>
                        <td>: <strong>Rp <?= number_format($invoice['total_setelah_ppn'], 0, ',', '.') ?></strong></td>
                    </tr>
                    <tr>
                        <td>Sudah Dibayar</td>
                        <td>: <strong class="text-success">Rp <?= number_format($invoice['jumlah_bayar'], 0, ',', '.') ?></strong></td>
                    </tr>
                    <tr>
                        <td>Sisa Tagihan</td>
                        <td>: <strong class="text-danger">Rp <?= number_format($invoice['total_setelah_ppn'] - $invoice['jumlah_bayar'], 0, ',', '.') ?></strong></td>
                    </tr>
                </table>
                
                <?php if ($invoice['status_pembayaran'] != 'paid'): ?>
                    <button type="button" class="btn btn-warning btn-sm w-100" 
                            data-bs-toggle="modal" data-bs-target="#paymentModal">
                        <i class="fas fa-money-bill me-2"></i>Catat Pembayaran
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-history me-2"></i>Riwayat Pembayaran</h6>
            </div>
            <div class="card-body">
                <?php if (!empty($payments)): ?>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jumlah</th>
                                    <th>Metode</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($payments as $payment): ?>
                                    <tr>
                                        <td><?= date('d/m/Y', strtotime($payment['tanggal_bayar'])) ?></td>
                                        <td>Rp <?= number_format($payment['jumlah_bayar'], 0, ',', '.') ?></td>
                                        <td>
                                            <span class="badge bg-info"><?= ucfirst($payment['metode_bayar']) ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center">Belum ada pembayaran</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<?php if ($invoice['status_pembayaran'] != 'paid'): ?>
    <div class="modal fade" id="paymentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Catat Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <?= form_open('invoice/payment/' . $invoice['id']) ?>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Sisa Tagihan</label>
                            <input type="text" class="form-control" 
                                   value="Rp <?= number_format($invoice['total_setelah_ppn'] - $invoice['jumlah_bayar'], 0, ',', '.') ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_bayar" class="form-label">Tanggal Bayar *</label>
                            <input type="date" class="form-control" id="tanggal_bayar" name="tanggal_bayar" 
                                   value="<?= date('Y-m-d') ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="jumlah_bayar" class="form-label">Jumlah Bayar *</label>
                            <input type="number" class="form-control" id="jumlah_bayar" name="jumlah_bayar" 
                                   step="0.01" required min="1" max="<?= $invoice['total_setelah_ppn'] - $invoice['jumlah_bayar'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="metode_bayar" class="form-label">Metode Bayar *</label>
                            <select class="form-select" id="metode_bayar" name="metode_bayar" required>
                                <option value="transfer">Transfer Bank</option>
                                <option value="cash">Cash</option>
                                <option value="check">Cek</option>
                                <option value="other">Lainnya</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="no_referensi" class="form-label">No Referensi</label>
                            <input type="text" class="form-control" id="no_referensi" name="no_referensi" 
                                   placeholder="No transfer, no cek, dll">
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Pembayaran
                        </button>
                    </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<?= $this->endSection() ?>
