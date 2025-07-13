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
            'statusStats' => $this->getStatusStats()
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
}
