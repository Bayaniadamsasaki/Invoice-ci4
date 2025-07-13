<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="fas fa-file-invoice me-2"></i>Data Invoice</h2>
    </div>
    <a href="<?= base_url('invoice/create') ?>" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tambah Invoice
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>Daftar Invoice</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No Invoice</th>
                        <th>Pemesanan ID</th>
                        <th>Tanggal SO</th>
                        <th>Rekanan</th>
                        <th>Alamat</th>
                        <th>NPWP</th>
                        <th>Produk</th>
                        <th>Qty</th>
                        <th>PPN</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($invoice)): ?>
                        <?php $no = 1; foreach ($invoice as $item): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><strong><?= $item['no_invoice'] ?? '-' ?></strong></td>
                                <td><?= $item['pemesanan_id'] ?? '-' ?></td>
                                <td><?= isset($item['tgl_so']) ? date('d/m/Y', strtotime($item['tgl_so'])) : '-' ?></td>
                                <td><strong><?= $item['nama_rek'] ?? '-' ?></strong></td>
                                <td><?= $item['alamat'] ?? '-' ?></td>
                                <td><?= $item['npwp'] ?? '-' ?></td>
                                <td><?= $item['nama_jenis_produk'] ?? '-' ?></td>
                                <td><?= isset($item['order_btg']) ? number_format($item['order_btg']) : '-' ?></td>
                                <td><?= $item['ppn'] ?? '-' ?></td>
                                <td><strong class="text-success">Rp <?= isset($item['total_harga']) ? number_format($item['total_harga'], 0, ',', '.') : '-' ?></strong></td>
                                <td>
                                    <a href="<?= base_url('invoice/edit/' . $item['no_invoice']) ?>" class="btn btn-sm btn-warning me-1" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirmDelete('<?= base_url('invoice/delete/' . $item['no_invoice']) ?>', 'Invoice No. <?= $item['no_invoice'] ?>');">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10" class="text-center py-5">
                                <i class="fas fa-file-invoice fa-4x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum ada data invoice</h5>
                                <p class="text-muted">Klik tombol "Tambah Invoice" untuk menambah data</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
