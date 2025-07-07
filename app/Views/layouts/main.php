<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Sistem Invoice PT Jaya Beton' ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --sidebar-width: 280px;
        }
        
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .sidebar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 20px;
            min-height: 100vh;
        }
        
        .navbar-brand {
            color: white !important;
            font-weight: bold;
            font-size: 1.1rem;
        }
        
        .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            padding: 12px 20px !important;
            border-radius: 8px;
            margin: 2px 10px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }
        
        .nav-link:hover, .nav-link.active {
            background-color: rgba(255, 255, 255, 0.15);
            color: white !important;
            transform: translateX(5px);
        }
        
        .nav-link i {
            width: 20px;
            margin-right: 10px;
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.2s ease;
        }
        
        .card:hover {
            transform: translateY(-2px);
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            border: none;
            font-weight: 600;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
            border-radius: 8px;
            padding: 8px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .table th {
            background-color: #f8f9fa;
            border-top: none;
            font-weight: 600;
            color: #495057;
        }
        
        .stats-card {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            border-radius: 15px;
            transition: transform 0.2s ease;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
        }
        
        .stats-card .card-body {
            padding: 1.5rem;
        }
        
        .stats-icon {
            font-size: 2.5rem;
            opacity: 0.8;
        }
        
        .alert {
            border-radius: 10px;
            border: none;
        }
        
        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            padding: 10px 15px;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .badge {
            border-radius: 6px;
            font-weight: 500;
        }
        
        .btn-group .btn {
            border-radius: 6px;
            margin: 0 2px;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
        }
        
        .loading {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 9999;
        }
        
        .loading-spinner {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 2rem;
        }
    </style>
</head>
<body>
    <!-- Loading Overlay -->
    <div class="loading" id="loadingOverlay">
        <div class="loading-spinner">
            <i class="fas fa-spinner fa-spin"></i>
            <div class="mt-2">Loading...</div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="p-3">
            <a class="navbar-brand d-flex align-items-center" href="<?= base_url('dashboard') ?>">
                <i class="fas fa-building me-2"></i>
                <div>
                    <div>PT Jaya Beton</div>
                    <small style="font-size: 0.8rem; opacity: 0.8;">Invoice System</small>
                </div>
            </a>
        </div>
        
        <nav class="nav flex-column mt-3">
            <a class="nav-link <?= (uri_string() == 'dashboard') ? 'active' : '' ?>" href="<?= base_url('dashboard') ?>">
                <i class="fas fa-tachometer-alt"></i>Dashboard
            </a>
            <a class="nav-link <?= (strpos(uri_string(), 'produk') !== false) ? 'active' : '' ?>" href="<?= base_url('produk') ?>">
                <i class="fas fa-boxes"></i>Data Produk
            </a>
            <a class="nav-link <?= (strpos(uri_string(), 'rekanan') !== false) ? 'active' : '' ?>" href="<?= base_url('rekanan') ?>">
                <i class="fas fa-users"></i>Data Rekanan
            </a>
            <a class="nav-link <?= (strpos(uri_string(), 'pemesanan') !== false) ? 'active' : '' ?>" href="<?= base_url('pemesanan') ?>">
                <i class="fas fa-shopping-cart"></i>Pemesanan
            </a>
            <a class="nav-link <?= (strpos(uri_string(), 'invoice') !== false) ? 'active' : '' ?>" href="<?= base_url('invoice') ?>">
                <i class="fas fa-file-invoice"></i>Invoice
            </a>
            <a class="nav-link <?= (strpos(uri_string(), 'laporan') !== false) ? 'active' : '' ?>" href="<?= base_url('laporan') ?>">
                <i class="fas fa-chart-bar"></i>Laporan
            </a>
            
            <hr class="text-white-50 mx-3">
            
            <div class="px-3 py-2">
                <small class="text-white-50">
                    <i class="fas fa-user me-1"></i>
                    <?= session()->get('fullName') ?? 'User' ?>
                </small>
            </div>
            <a class="nav-link" href="<?= base_url('auth/logout') ?>" onclick="return confirm('Yakin ingin logout?')">
                <i class="fas fa-sign-out-alt"></i>Logout
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Mobile Menu Button -->
        <button class="btn btn-primary d-md-none mb-3" type="button" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Alert Messages -->
        <?php if (session()->getFlashdata('alert')): ?>
            <?php $alert = session()->getFlashdata('alert'); ?>
            <div class="alert alert-<?= $alert['type'] ?> alert-dismissible fade show" role="alert">
                <i class="fas fa-<?= $alert['type'] == 'success' ? 'check-circle' : ($alert['type'] == 'error' ? 'exclamation-circle' : 'info-circle') ?> me-2"></i>
                <?= $alert['message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Page Content -->
        <?= $this->renderSection('content') ?>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    
    <script>
        // Global JavaScript functions
        $(document).ready(function() {
            // Initialize DataTables
            $('.data-table').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
                },
                "pageLength": 10,
                "responsive": true,
                "order": [[0, "desc"]]
            });

            // Auto hide alerts
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);

            // Form validation
            $('form').on('submit', function() {
                showLoading();
            });

            // Calculate total on form
            $('input[name="order_btg"], input[name="harga_satuan"]').on('input', function() {
                calculateTotal();
            });

            // Calculate PPN on invoice form
            $('input[name="ppn"]').on('input', function() {
                calculatePPN();
            });
        });

        function showLoading() {
            $('#loadingOverlay').show();
        }

        function hideLoading() {
            $('#loadingOverlay').hide();
        }

        function toggleSidebar() {
            $('#sidebar').toggleClass('show');
        }

        function calculateTotal() {
            var qty = parseFloat($('input[name="order_btg"]').val()) || 0;
            var price = parseFloat($('input[name="harga_satuan"]').val()) || 0;
            var total = qty * price;
            $('#total_preview').text('Rp ' + formatNumber(total));
        }

        function calculatePPN() {
            var subtotal = parseFloat($('#subtotal').data('value')) || 0;
            var ppn_percent = parseFloat($('input[name="ppn"]').val()) || 0;
            var ppn_value = (subtotal * ppn_percent) / 100;
            var total = subtotal + ppn_value;
            
            $('#ppn_value').text('Rp ' + formatNumber(ppn_value));
            $('#total_with_ppn').text('Rp ' + formatNumber(total));
        }

        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function formatCurrency(input) {
            let value = input.value.replace(/[^\d]/g, '');
            input.value = formatNumber(value);
        }

        function confirmDelete(url, item) {
            if (confirm('Yakin ingin menghapus ' + item + '?')) {
                showLoading();
                window.location.href = url;
            }
        }

        function printInvoice(url) {
            window.open(url, '_blank', 'width=800,height=600');
        }

        // Product selection change handler
        function onProductChange(select) {
            var selectedOption = select.options[select.selectedIndex];
            var harga = selectedOption.getAttribute('data-harga');
            if (harga) {
                $('input[name="harga_satuan"]').val(harga);
                calculateTotal();
            }
        }

        // Close sidebar when clicking outside on mobile
        $(document).on('click', function(e) {
            if (window.innerWidth <= 768) {
                if (!$(e.target).closest('.sidebar, .btn').length) {
                    $('#sidebar').removeClass('show');
                }
            }
        });
    </script>

    <?= $this->renderSection('scripts') ?>
</body>
</html>
