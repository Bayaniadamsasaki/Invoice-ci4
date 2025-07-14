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
            'title' => 'Dashboard - Sistem Invoice PT Jaya Beton',
            'totalProduk' => $this->produkModel->countAllResults(),
            'totalRekanan' => $this->rekananModel->countAllResults(),
            'totalPemesanan' => $this->pemesananModel->countAllResults(),
            'totalInvoice' => $this->invoiceModel->countAllResults(),
            'recentInvoices' => $this->getRecentInvoices(),
            'monthlyStats' => $this->getMonthlyStats(),
            'statusStats' => $this->getStatusStats(),
            'projectGallery' => $this->getProjectGallery()
        ];

        return view('dashboard/index', $data);
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
            [
                'title' => 'Building',
                'description' => 'Konstruksi gedung komersial dan proyek bangunan bertingkat',
                'image' => 'building.jpg',
                'category' => 'Konstruksi'
            ],
            [
                'title' => 'Roads & Bridges',
                'description' => 'Pembangunan jalan raya dan pengembangan infrastruktur transportasi',
                'image' => 'roads.jpg',
                'category' => 'Infrastruktur'
            ],
            [
                'title' => 'Foundation',
                'description' => 'Konstruksi pondasi bangunan dan sistem pondasi struktural',
                'image' => 'foundation.png',
                'category' => 'Pondasi'
            ],
            [
                'title' => 'Retaining Wall',
                'description' => 'Konstruksi dinding penahan dan struktur penahan tanah',
                'image' => 'retainingwall.jpg',
                'category' => 'Struktur'
            ],
            [
                'title' => 'Water Management',
                'description' => 'Sistem drainase dan solusi manajemen air infrastruktur',
                'image' => 'watermanagement.jpg',
                'category' => 'Utilities'
            ],
            [
                'title' => 'Electricity',
                'description' => 'Instalasi sistem kelistrikan untuk bangunan dan infrastruktur',
                'image' => 'electricity.jpg',
                'category' => 'Utilities'
            ],
            [
                'title' => 'Custom Projects',
                'description' => 'Proyek khusus yang disesuaikan dengan spesifikasi dan kebutuhan klien',
                'image' => 'costum.jpg',
                'category' => 'Custom'
            ]
        ];

        return $projects;
    }
}
