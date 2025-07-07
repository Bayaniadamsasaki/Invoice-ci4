<?php

namespace App\Controllers;

use App\Models\InvoiceModel;
use App\Models\PemesananModel;
use App\Models\RekananModel;
use App\Models\ProdukModel;

class Laporan extends BaseController
{
    protected $invoiceModel;
    protected $pemesananModel;
    protected $rekananModel;
    protected $produkModel;

    public function __construct()
    {
        $this->invoiceModel = new InvoiceModel();
        $this->pemesananModel = new PemesananModel();
        $this->rekananModel = new RekananModel();
        $this->produkModel = new ProdukModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Laporan - Sistem Invoice PT Jaya Beton'
        ];

        return view('laporan/index', $data);
    }

    public function invoice()
    {
        $tanggalDari = $this->request->getGet('tanggal_dari');
        $tanggalSampai = $this->request->getGet('tanggal_sampai');

        $builder = $this->invoiceModel
            ->select('invoice.*, tbl_input_data_rekanan.nama_rek, pemesanan.no_so, produk.nama_jenis_produk')
            ->join('pemesanan', 'pemesanan.id = invoice.pemesanan_id')
            ->join('tbl_input_data_rekanan', 'tbl_input_data_rekanan.id_rek = pemesanan.id_rek')
            ->join('produk', 'produk.id = pemesanan.produk_id');

        if ($tanggalDari && $tanggalSampai) {
            $builder->where('invoice.tgl_so >=', $tanggalDari)
                   ->where('invoice.tgl_so <=', $tanggalSampai);
        }

        $invoices = $builder->orderBy('invoice.tgl_so', 'DESC')->findAll();

        // Calculate totals
        $totalSebelumPpn = array_sum(array_column($invoices, 'total_sebelum_ppn'));
        $totalPpn = array_sum(array_column($invoices, 'nilai_ppn'));
        $totalSetelahPpn = array_sum(array_column($invoices, 'total_harga'));
        $totalBayar = array_sum(array_column($invoices, 'jumlah_bayar'));

        $data = [
            'title' => 'Laporan Invoice - Sistem Invoice PT Jaya Beton',
            'invoices' => $invoices,
            'tanggal_dari' => $tanggalDari,
            'tanggal_sampai' => $tanggalSampai,
            'totals' => [
                'sebelum_ppn' => $totalSebelumPpn,
                'ppn' => $totalPpn,
                'setelah_ppn' => $totalSetelahPpn,
                'bayar' => $totalBayar,
                'sisa' => $totalSetelahPpn - $totalBayar
            ]
        ];

        return view('laporan/invoice', $data);
    }

    public function pemesanan()
    {
        $tanggalDari = $this->request->getGet('tanggal_dari');
        $tanggalSampai = $this->request->getGet('tanggal_sampai');
        // Hapus semua where('pemesanan.status', ...), filter status pada pemesanan, dan variabel status terkait pemesanan

        $builder = $this->pemesananModel
            ->select('pemesanan.*, tbl_input_data_rekanan.nama_rek, produk.nama_jenis_produk, produk.nama_kategori_produk')
            ->join('tbl_input_data_rekanan', 'tbl_input_data_rekanan.id_rek = pemesanan.id_rek')
            ->join('produk', 'produk.id = pemesanan.produk_id');

        if ($tanggalDari && $tanggalSampai) {
            $builder->where('pemesanan.tanggal_so >=', $tanggalDari)
                   ->where('pemesanan.tanggal_so <=', $tanggalSampai);
        }

        $pemesanan = $builder->orderBy('pemesanan.tanggal_so', 'DESC')->findAll();

        $data = [
            'title' => 'Laporan Pemesanan - Sistem Invoice PT Jaya Beton',
            'pemesanan' => $pemesanan,
            'tanggal_dari' => $tanggalDari,
            'tanggal_sampai' => $tanggalSampai,
            'total_nilai' => array_sum(array_column($pemesanan, 'total_harga'))
        ];

        return view('laporan/pemesanan', $data);
    }

    public function export()
    {
        $type = $this->request->getPost('type');
        $format = $this->request->getPost('format');

        // Implementation for export functionality
        // This would typically use libraries like PhpSpreadsheet for Excel export
        
        $this->setAlert('info', 'Fitur export sedang dalam pengembangan');
        return redirect()->back();
    }
}
