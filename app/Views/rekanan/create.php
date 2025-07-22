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
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?= form_open('rekanan/store', ['id' => 'rekananForm']) ?>
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="nama_rek" class="form-label">Nama Rekanan *</label>
                <input type="text" class="form-control <?= (isset($validation) && $validation->hasError('nama_rek')) ? 'is-invalid' : '' ?>" 
                       id="nama_rek" name="nama_rek" value="<?= old('nama_rek') ?>" 
                       required maxlength="255" placeholder="Masukkan nama rekanan/partner">
                <div class="invalid-feedback" style="display: none;">
                    <i class="fas fa-exclamation-circle me-1"></i>
                    <?= (isset($validation) && $validation->hasError('nama_rek')) ? $validation->getError('nama_rek') : 'Nama rekanan minimal 3 karakter' ?>
                </div>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat *</label>
                <textarea class="form-control <?= (isset($validation) && $validation->hasError('alamat')) ? 'is-invalid' : '' ?>" 
                          id="alamat" name="alamat" rows="3" required maxlength="500" 
                          placeholder="Masukkan alamat lengkap rekanan"><?= old('alamat') ?></textarea>
                <div class="invalid-feedback" style="display: none;">
                    <i class="fas fa-exclamation-circle me-1"></i>
                    <?= (isset($validation) && $validation->hasError('alamat')) ? $validation->getError('alamat') : 'Alamat minimal 5 karakter' ?>
                </div>
                <div class="form-text">Minimal 5 karakter</div>
            </div>
            <div class="mb-3">
                <label for="npwp" class="form-label">NPWP</label>
                <input type="text" class="form-control <?= (isset($validation) && $validation->hasError('npwp')) ? 'is-invalid' : '' ?>" 
                       id="npwp" name="npwp" value="<?= old('npwp') ?>" 
                       placeholder="00.000.000.0-000.000" maxlength="20">
                <div class="invalid-feedback" style="display: none;">
                    <i class="fas fa-exclamation-circle me-1"></i>
                    <?= (isset($validation) && $validation->hasError('npwp')) ? $validation->getError('npwp') : 'NPWP minimal 15 karakter jika diisi' ?>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" id="submitBtn">
                <i class="fas fa-save me-2"></i>Simpan
            </button>
        <?= form_close() ?>
        
        <script>
        // Form handling dan validasi
        document.getElementById('rekananForm').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            const namaRekField = document.getElementById('nama_rek');
            const alamatField = document.getElementById('alamat');
            const npwpField = document.getElementById('npwp');
            
            const namaRek = namaRekField.value.trim();
            const alamat = alamatField.value.trim();
            const npwp = npwpField.value.trim();
            
            // Reset semua error states
            namaRekField.classList.remove('is-invalid');
            alamatField.classList.remove('is-invalid');
            npwpField.classList.remove('is-invalid');
            
            // Hapus error messages yang ada
            document.querySelectorAll('.invalid-feedback').forEach(el => el.style.display = 'none');
            
            // Client-side validation
            let isValid = true;
            
            // Validasi nama rekanan
            if (namaRek.length < 3) {
                namaRekField.classList.add('is-invalid');
                let errorEl = namaRekField.nextElementSibling;
                if (errorEl && errorEl.classList.contains('invalid-feedback')) {
                    errorEl.innerHTML = '<i class="fas fa-exclamation-circle me-1"></i>Nama rekanan minimal 3 karakter';
                    errorEl.style.display = 'block';
                }
                isValid = false;
            }
            
            // Validasi alamat
            if (alamat.length < 5) {
                alamatField.classList.add('is-invalid');
                let errorEl = alamatField.nextElementSibling;
                if (errorEl && errorEl.classList.contains('invalid-feedback')) {
                    errorEl.innerHTML = '<i class="fas fa-exclamation-circle me-1"></i>Alamat minimal 5 karakter';
                    errorEl.style.display = 'block';
                }
                isValid = false;
            }
            
            // Validasi NPWP (jika diisi)
            if (npwp.length > 0 && npwp.length < 15) {
                npwpField.classList.add('is-invalid');
                let errorEl = npwpField.nextElementSibling;
                if (errorEl && errorEl.classList.contains('invalid-feedback')) {
                    errorEl.innerHTML = '<i class="fas fa-exclamation-circle me-1"></i>NPWP minimal 15 karakter jika diisi';
                    errorEl.style.display = 'block';
                }
                isValid = false;
            }
            
            // Jika tidak valid, jangan submit dan jangan show loading
            if (!isValid) {
                e.preventDefault();
                return false;
            }
            
            // Hanya show loading jika validasi berhasil
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
        });
        
        // Real-time validation saat user mengetik
        document.getElementById('nama_rek').addEventListener('input', function(e) {
            const field = e.target;
            const value = field.value.trim();
            const errorEl = field.nextElementSibling;
            
            if (value.length > 0 && value.length < 3) {
                field.classList.add('is-invalid');
                if (errorEl && errorEl.classList.contains('invalid-feedback')) {
                    errorEl.innerHTML = '<i class="fas fa-exclamation-circle me-1"></i>Nama rekanan minimal 3 karakter';
                    errorEl.style.display = 'block';
                }
            } else if (value.length >= 3) {
                field.classList.remove('is-invalid');
                if (errorEl && errorEl.classList.contains('invalid-feedback')) {
                    errorEl.style.display = 'none';
                }
            }
        });
        
        document.getElementById('alamat').addEventListener('input', function(e) {
            const field = e.target;
            const value = field.value.trim();
            const errorEl = field.nextElementSibling;
            
            if (value.length > 0 && value.length < 5) {
                field.classList.add('is-invalid');
                if (errorEl && errorEl.classList.contains('invalid-feedback')) {
                    errorEl.innerHTML = '<i class="fas fa-exclamation-circle me-1"></i>Alamat minimal 5 karakter';
                    errorEl.style.display = 'block';
                }
            } else if (value.length >= 5) {
                field.classList.remove('is-invalid');
                if (errorEl && errorEl.classList.contains('invalid-feedback')) {
                    errorEl.style.display = 'none';
                }
            }
        });
        
        // Auto-format NPWP dan real-time validation
        document.getElementById('npwp').addEventListener('input', function(e) {
            const field = e.target;
            let value = field.value.replace(/\D/g, ''); // Remove non-digits
            
            if (value.length > 0) {
                // Format: XX.XXX.XXX.X-XXX.XXX
                value = value.substring(0, 15); // Max 15 digits
                let formatted = '';
                if (value.length > 0) formatted += value.substring(0, 2);
                if (value.length > 2) formatted += '.' + value.substring(2, 5);
                if (value.length > 5) formatted += '.' + value.substring(5, 8);
                if (value.length > 8) formatted += '.' + value.substring(8, 9);
                if (value.length > 9) formatted += '-' + value.substring(9, 12);
                if (value.length > 12) formatted += '.' + value.substring(12, 15);
                field.value = formatted;
            }
            
            // Real-time validation untuk NPWP
            const npwpValue = field.value.trim();
            const errorEl = field.nextElementSibling;
            
            if (npwpValue.length > 0 && npwpValue.length < 15) {
                field.classList.add('is-invalid');
                if (errorEl && errorEl.classList.contains('invalid-feedback')) {
                    errorEl.innerHTML = '<i class="fas fa-exclamation-circle me-1"></i>NPWP minimal 15 karakter jika diisi';
                    errorEl.style.display = 'block';
                }
            } else {
                field.classList.remove('is-invalid');
                if (errorEl && errorEl.classList.contains('invalid-feedback')) {
                    errorEl.style.display = 'none';
                }
            }
        });
        </script>
    </div>
</div>
<?= $this->endSection() ?>
