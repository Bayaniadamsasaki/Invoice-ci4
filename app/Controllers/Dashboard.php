<?php

namespace App\Controllers;

use App\Models\ProdukModel;
use App\Models\RekananModel;
use App\Models\PemesananModel;
use App\Models\InvoiceModel;

class Dashboard extends BaseController
{
    protected $produkModel;
    protected $rekananModel;
    protected $pemesananModel;
    protected $invoiceModel;

    public function __construct()
    {
        $this->produkModel = new ProdukModel();
        $this->rekananModel = new RekananModel();
        $this->pemesananModel = new PemesananModel();
        $this->invoiceModel = new InvoiceModel();
    }

    public function index()
    {
        // Semua role bisa akses dashboard
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $data = [
            'title' => 'Dashboard - Sistem Invoice PT Jaya Beton Indonesia',
            'totalProduk' => $this->produkModel->countAllResults(),
            'totalRekanan' => $this->rekananModel->countAllResults(),
            'totalPemesanan' => $this->getActualPemesananCount(),
            'totalInvoice' => $this->invoiceModel->countAllResults(),
            'recentInvoices' => $this->getRecentInvoices(),
            'monthlyStats' => $this->getMonthlyStats(),
            'statusStats' => $this->getStatusStats(),
            'projectGallery' => $this->getProjectGallery(),
            'companyInfo' => $this->getCompanyInfo(),
            'products' => $this->getAllProducts(),
            'rekanans' => $this->getAllRekanans(),
            'pemesanans' => $this->getAllPemesanans(),
            'invoices' => $this->getAllInvoices()
        ];

        return view('dashboard/index', $data);
    }

    public function getStats()
    {
        // AJAX endpoint untuk real-time statistics
        if ($this->request->isAJAX()) {
            $stats = [
                'totalProduk' => $this->produkModel->countAllResults(),
                'totalRekanan' => $this->rekananModel->countAllResults(),
                'totalPemesanan' => $this->getActualPemesananCount(),
                'totalInvoice' => $this->invoiceModel->countAllResults(),
                'timestamp' => date('Y-m-d H:i:s'),
                'lastUpdate' => $this->getLastDataUpdate()
            ];
            
            return $this->response->setJSON($stats);
        }
        
        return $this->response->setStatusCode(404);
    }

    private function getLastDataUpdate()
    {
        // Ambil timestamp terakhir dari semua tabel untuk deteksi perubahan
        $db = \Config\Database::connect();
        
        // Cek last update dari setiap tabel
        $lastUpdates = [
            'produk' => $db->query("SELECT MAX(COALESCE(updated_at, created_at)) as last_update FROM produk")->getRow(),
            'rekanan' => $db->query("SELECT MAX(COALESCE(updated_at, created_at)) as last_update FROM tbl_input_data_rekanan")->getRow(),
            'pemesanan' => $db->query("SELECT MAX(COALESCE(updated_at, created_at)) as last_update FROM tbl_mengelola_pemesanan")->getRow(),
            'invoice' => $db->query("SELECT MAX(COALESCE(updated_at, created_at)) as last_update FROM tbl_mengelola_invoice")->getRow()
        ];

        // Ambil timestamp terbaru dari semua tabel
        $latestUpdate = null;
        foreach ($lastUpdates as $table => $update) {
            if ($update && $update->last_update) {
                if (!$latestUpdate || $update->last_update > $latestUpdate) {
                    $latestUpdate = $update->last_update;
                }
            }
        }

        return $latestUpdate ?: date('Y-m-d H:i:s');
    }

    private function getActualPemesananCount()
    {
        // Hitung semua pemesanan sesuai dengan yang ditampilkan di menu Data Pemesanan
        // Tidak menggunakan JOIN agar konsisten dengan controller Pemesanan
        return $this->pemesananModel->countAllResults();
    }

    private function getRecentInvoices()
    {
        $today = date('Y-m-d');
        return $this->invoiceModel
            ->select('tbl_mengelola_invoice.*, tbl_input_data_rekanan.nama_rek as nama_rekanan, tbl_mengelola_pemesanan.id_so')
            ->join('tbl_input_data_rekanan', 'tbl_input_data_rekanan.nama_rek = tbl_mengelola_invoice.nama_rek', 'left')
            ->join('tbl_mengelola_pemesanan', 'tbl_mengelola_pemesanan.id_so = tbl_mengelola_invoice.pemesanan_id', 'left')
            ->where('DATE(tbl_mengelola_invoice.tgl_so)', $today)
            ->orderBy('tbl_mengelola_invoice.no_invoice', 'DESC')
            ->find();
    }

    private function getMonthlyStats()
    {
        $currentYear = date('Y');
        $monthlyData = [];

        for ($month = 1; $month <= 12; $month++) {
            $totalInvoice = $this->invoiceModel
                ->where('YEAR(tgl_so)', $currentYear)
                ->where('MONTH(tgl_so)', $month)
                ->selectSum('total_harga', 'total')
                ->first();

            $monthlyData[] = [
                'month' => $month,
                'month_name' => date('F', mktime(0, 0, 0, $month, 1)),
                'total' => $totalInvoice['total'] ?? 0
            ];
        }

        return $monthlyData;
    }

    private function getStatusStats()
    {
        return [
        ];
    }

    private function getProjectGallery()
    {
        // Daftar project dengan gambar dan deskripsi
        $projects = [
            // [
            //     'title' => 'Building',
            //     'description' => 'Konstruksi gedung komersial dan proyek bangunan bertingkat',
            //     'image' => 'building.jpg',
            //     'category' => 'Konstruksi'
            // ],
            // [
            //     'title' => 'Roads & Bridges',
            //     'description' => 'Pembangunan jalan raya dan pengembangan infrastruktur transportasi',
            //     'image' => 'roads.jpg',
            //     'category' => 'Infrastruktur'
            // ],
            [
                'title' => 'PC. SPUN PILES',
                'description' => 'Konstruksi pondasi bangunan dan sistem pondasi struktural',
                'image' => 'foundation.png',
                'category' => 'Pondasi'
            ],
            [
                'title' => 'PC. SHEET PILES (CORRUGATED TYPE)',
                'description' => 'Konstruksi dinding penahan dan struktur penahan tanah',
                'image' => 'retainingwall.jpg',
                'category' => 'Struktur'
            ],
            // [
            //     'title' => 'Water Management',
            //     'description' => 'Sistem drainase dan solusi manajemen air infrastruktur',
            //     'image' => 'watermanagement.jpg',
            //     'category' => 'Utilities'
            // ],
            [
                'title' => 'PC. SPUN POLES',
                'description' => 'Instalasi sistem kelistrikan untuk bangunan dan infrastruktur',
                'image' => 'electricity.jpg',
                'category' => 'Utilities'
            ],
            // [
            //     'title' => 'Custom Projects',
            //     'description' => 'Proyek khusus yang disesuaikan dengan spesifikasi dan kebutuhan klien',
            //     'image' => 'costum.jpg',
            //     'category' => 'Custom'
            // ],
            [
                'title' => 'PC. SHEET PILES (FLAT TYPE)',
                'description' => 'Sistem dinding penahan tanah dan struktur sheet pile beton pracetak',
                'image' => 'PC SHEET PILES.png',
                'category' => 'Struktur'
            ],
            [
                'title' => 'PRESTRESSED CONCRETE SQUARE PILE',
                'description' => 'Tiang pancang beton prategang persegi untuk pondasi bangunan',
                'image' => 'PRESTERESSED CONCRETE SQUARE FILE.png',
                'category' => 'Pondasi'
            ]
        ];

        return $projects;
    }

    private function getCompanyInfo()
    {
        return [
            'name' => 'PT Jaya Beton Indonesia',
            'tagline' => 'Indonesian Leading Precast Concrete Manufacturer',
            'description' => 'Didirikan sejak 11 Maret 1978, PT Jaya Beton Indonesia telah berperan penting sebagai pelopor dalam industri beton pracetak di Indonesia.',
            'address' => 'Jl. P. Danau Siombak, Paya Pasir, Kec. Medan Marelan, Kota Medan, Sumatera Utara 20254',
            'vision' => 'Menjadi perusahaan terdepan dalam industri beton pracetak di Indonesia.',
            'mission' => [
                'Menyediakan produk beton pracetak berkualitas tinggi',
                'Memberikan solusi terbaik untuk kebutuhan konstruksi',
                'Mengembangkan teknologi dalam industri beton pracetak',
                'Membangun kemitraan jangka panjang dengan pelanggan'
            ],
            'history' => 'Didirikan sejak 11 Maret 1978, PT Jaya Beton Indonesia telah menjadi pelopor industri beton pracetak di Indonesia.',
            'established' => '11 Maret 1978',
            'president_director' => 'Ir. Hardjanto Agus Priambodo, M.M',
            'group_affiliation' => 'Pembangunan Jaya Group',
            'manpower' => [
                'title' => 'Man Power - Demonstrating Expertise, Delivering a Great Experience',
                'description' => 'Manufaktur berkualitas tinggi lebih dari sekadar peralatan dan material. PT Jaya Beton Indonesia berdedikasi untuk merekrut orang-orang terbaik dengan keterampilan terbaik dan berkomitmen pada atmosfer perbaikan melalui kerja tim dan profesional yang terlatih dengan baik.',
                'philosophy' => 'Sebagai perusahaan yang bereputasi, kami menyadari bahwa kompetensi dan keterampilan bukanlah upaya satu kali, melainkan upaya yang berkelanjutan. Kami percaya pada pengembangan sumber daya manusia yang berkelanjutan sejak perekrutan hingga sepanjang masa kerja mereka.',
                'group_values' => [
                    'Integrity (Integritas)',
                    'Fairness (Keadilan)', 
                    'Commitment (Komitmen)',
                    'Discipline (Disiplin)',
                    'Motivation (Motivasi)'
                ],
                'people_development' => 'Sebagai bagian dari Pembangunan Jaya Group, kami mengembangkan sumber daya manusia untuk mempertahankan nilai-nilai Integritas, Keadilan, Komitmen, Disiplin, dan Motivasi. Bersama dengan pengetahuan dan keterampilan teknis, kami percaya nilai-nilai tersebut akan memberdayakan sumber daya manusia untuk menghasilkan produk dan layanan berkualitas tinggi serta mempertahankan hubungan baik dengan pelanggan dan mitra perusahaan.'
            ],
            'core_business' => [
                'title' => 'Core Business - Area of Expertise',
                'overview' => 'Semakin banyak teknologi inovatif dalam industri beton pracetak telah dikembangkan untuk memenuhi kebutuhan masa depan. Ketika permintaan akan kualitas material dan layanan terus berubah, perusahaan kami merangkul perubahan dan cenderung melihat kemajuan teknologi dalam produk melalui bisnis inti kami.',
                'precast_manufacturing' => [
                    'title' => 'PRECAST CONCRETE MANUFACTURING',
                    'description' => 'Banyak kemajuan telah dibuat di semua bidang teknologi beton. Dikenal karena keunggulan dan reputasi yang didambakan untuk kualitas produk, PT Jaya Beton Indonesia berusaha menggabungkan teknologi dan metode terbaru ke dalam produk beton pracetak.',
                    'capabilities' => [
                        'Lini produk beton prategang berkinerja tinggi yang luas',
                        'Diproduksi menggunakan teknik rekayasa canggih',
                        'Layanan teknis yang luar biasa',
                        'Pengadaan pesanan yang cepat dan pemenuhan kebutuhan',
                        'Layanan pengiriman terjamin',
                        'Instalasi dan pemasangan produk',
                        'Solusi layanan satu atap untuk pelanggan'
                    ]
                ]
            ]
        ];
    }

    private function getAllProducts()
    {
        return $this->produkModel
            ->select('kode_jenis_produk, nama_jenis_produk, nama_kategori_produk, berat')
            ->findAll();
    }

    private function getAllRekanans()
    {
        return $this->rekananModel
            ->select('id_rek, nama_rek, alamat, npwp')
            ->findAll();
    }

    private function getAllPemesanans()
    {
        // Gunakan query yang sama seperti di controller Pemesanan untuk konsistensi
        return $this->pemesananModel->orderBy('id_so', 'ASC')->findAll();
    }

    private function getAllInvoices()
    {
        // Gunakan query yang sama seperti di controller Invoice untuk konsistensi
        return $this->invoiceModel->orderBy('no_invoice', 'ASC')->findAll();
    }

    public function getProductDetail()
    {
        $productName = $this->request->getPost('product_name');
        
        // Cari produk berdasarkan nama
        $product = $this->produkModel
            ->where('nama_jenis_produk', $productName)
            ->first();

        if (!$product) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Produk tidak ditemukan'
            ]);
        }

        // Data detail produk
        $productDetails = [
            'PC. SPUN PILES' => [
                'price' => 1250000,
                'unit' => 'Btg',
                'specifications' => [
                    'Diameter' => '300mm - 600mm',
                    'Panjang' => '8m - 12m',
                    'Kuat Tekan' => 'K-500',
                    'Berat' => '1.2 - 3.5 ton/pcs'
                ],
                'features' => [
                    'Tahan terhadap korosi',
                    'Instalasi cepat dan mudah',
                    'Kualitas beton high strength',
                    'Presisi dimensi tinggi'
                ],
                'applications' => [
                    'Pondasi gedung tinggi',
                    'Pondasi jembatan',
                    'Pondasi dermaga',
                    'Konstruksi berat lainnya'
                ]
            ],
            'PC. SHEET PILES (CORRUGATED TYPE)' => [
                'price' => 850000,
                'unit' => 'M2',
                'specifications' => [
                    'Tinggi' => '250mm - 400mm',
                    'Panjang' => '6m - 12m',
                    'Kuat Tekan' => 'K-400',
                    'Tebal' => '100mm - 150mm'
                ],
                'features' => [
                    'Desain corrugated untuk kekuatan optimal',
                    'Mudah dalam pemasangan',
                    'Tahan terhadap beban lateral',
                    'Finishing permukaan halus'
                ],
                'applications' => [
                    'Dinding penahan tanah',
                    'Struktur basement',
                    'Turap dermaga',
                    'Perkuatan lereng'
                ]
            ],
            'PC. SPUN POLES' => [
                'price' => 2750000,
                'unit' => 'Btg',
                'specifications' => [
                    'Tinggi' => '9m - 14m',
                    'Diameter Top' => '190mm - 220mm',
                    'Diameter Base' => '350mm - 400mm',
                    'Kuat Tekan' => 'K-500'
                ],
                'features' => [
                    'Desain tirus untuk stabilitas',
                    'Lubang untuk kabel pra-dibuat',
                    'Permukaan halus dan presisi',
                    'Tahan cuaca ekstrem'
                ],
                'applications' => [
                    'Tiang listrik PLN',
                    'Tiang telekomunikasi',
                    'Tiang penerangan jalan',
                    'Infrastruktur utilitas'
                ]
            ],
            'PC. SHEET PILES (FLAT TYPE)' => [
                'price' => 780000,
                'unit' => 'M2',
                'specifications' => [
                    'Tinggi' => '250mm - 400mm',
                    'Panjang' => '6m - 12m',
                    'Kuat Tekan' => 'K-400',
                    'Tebal' => '100mm - 120mm'
                ],
                'features' => [
                    'Permukaan datar untuk finishing',
                    'Joint system yang rapat',
                    'Dimensi presisi tinggi',
                    'Mudah dalam handling'
                ],
                'applications' => [
                    'Dinding penahan air',
                    'Struktur bawah tanah',
                    'Basement gedung',
                    'Infrastruktur air'
                ]
            ],
            'PRESTRESSED CONCRETE SQUARE PILE' => [
                'price' => 1850000,
                'unit' => 'Btg',
                'specifications' => [
                    'Dimensi' => '250x250mm - 400x400mm',
                    'Panjang' => '8m - 16m',
                    'Kuat Tekan' => 'K-600',
                    'Prestressing' => 'High Tensile Steel'
                ],
                'features' => [
                    'Teknologi prestressed concrete',
                    'Daya dukung beban tinggi',
                    'Bentuk persegi untuk stabilitas',
                    'Kualitas beton premium'
                ],
                'applications' => [
                    'Pondasi bangunan super high rise',
                    'Pondasi infrastruktur berat',
                    'Konstruksi pelabuhan',
                    'Proyek skala besar'
                ]
            ]
        ];

        $detail = $productDetails[$productName] ?? [
            'price' => 0,
            'unit' => 'Unit',
            'specifications' => ['Informasi spesifikasi akan segera tersedia'],
            'features' => ['Informasi fitur akan segera tersedia'],
            'applications' => ['Informasi aplikasi akan segera tersedia']
        ];

        return $this->response->setJSON([
            'success' => true,
            'product' => [
                'name' => $product['nama_jenis_produk'],
                'category' => $product['nama_kategori_produk'],
                'weight' => $product['berat'],
                'price' => $detail['price'],
                'unit' => $detail['unit'],
                'specifications' => $detail['specifications'],
                'features' => $detail['features'],
                'applications' => $detail['applications']
            ]
        ]);
    }
}
