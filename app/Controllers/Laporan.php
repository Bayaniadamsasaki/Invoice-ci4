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
    protected $laporanInvoiceModel;

    public function __construct()
    {
        helper(['auth']);
        $this->invoiceModel = new InvoiceModel();
        $this->laporanInvoiceModel = new \App\Models\LaporanInvoiceModel();
        $this->pemesananModel = new PemesananModel();
        $this->rekananModel = new RekananModel();
        $this->produkModel = new ProdukModel();
    }

    public function index()
    {

        if (!hasAnyRole(['admin', 'bagian_keuangan', 'manager'])) {
            session()->setFlashdata('alert', [
                'type' => 'error',
                'message' => 'Anda tidak memiliki akses ke halaman ini.'
            ]);
            return redirect()->to('/dashboard');
        }

        $laporan = $this->invoiceModel->orderBy('no_invoice', 'ASC')->findAll();
        return view('laporan/index', ['laporan' => $laporan]);
    }

    public function invoice()
    {

        if (!hasAnyRole(['admin', 'bagian_keuangan', 'manager'])) {
            session()->setFlashdata('alert', [
                'type' => 'error',
                'message' => 'Anda tidak memiliki akses ke halaman ini.'
            ]);
            return redirect()->to('/dashboard');
        }

        $tanggalDari = $this->request->getGet('tanggal_dari');
        $tanggalSampai = $this->request->getGet('tanggal_sampai');

        $builder = $this->invoiceModel
            ->select('tbl_mengelola_invoice.*, tbl_mengelola_pemesanan.no_po')
            ->join('tbl_mengelola_pemesanan', 'tbl_mengelola_pemesanan.id_so = tbl_mengelola_invoice.pemesanan_id');

        if ($tanggalDari && $tanggalSampai) {
            $builder->where('tbl_mengelola_invoice.tgl_so >=', $tanggalDari)
                ->where('tbl_mengelola_invoice.tgl_so <=', $tanggalSampai);
        }

        $invoices = $builder->orderBy('tbl_mengelola_invoice.tgl_so', 'DESC')->findAll();


        $totalSebelumPpn = array_sum(array_column($invoices, 'total_sebelum_ppn'));
        $totalPpn = array_sum(array_column($invoices, 'nilai_ppn'));
        $totalSetelahPpn = array_sum(array_column($invoices, 'total_harga'));
        $totalBayar = array_sum(array_column($invoices, 'jumlah_bayar'));


        $invoice = !empty($invoices) ? $invoices[0] : null;
        $terbilang = '';

        if ($invoice) {

            $total_harga = $invoice['total_harga'] ?? 0;
            $ppn_percent = ($invoice['ppn'] ?? 11) / 100;
            $subtotal = $total_harga / (1 + $ppn_percent);
            $uang_muka = $subtotal * 0.20;
            $ppn_uang_muka = $uang_muka * 0.11;
            $total_bayar_benar = $uang_muka + $ppn_uang_muka;


            $terbilang = $this->terbilang($total_bayar_benar);
        }

        $data = [
            'title' => 'Laporan Invoice - Sistem Invoice PT Jaya Beton',
            'invoices' => $invoices,
            'invoice' => $invoice,
            'terbilang' => $terbilang,
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

        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $tanggalDari = $this->request->getGet('tanggal_dari');
        $tanggalSampai = $this->request->getGet('tanggal_sampai');


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

        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $type = $this->request->getPost('type');
        $format = $this->request->getPost('format');




        $this->setAlert('info', 'Fitur export sedang dalam pengembangan');
        return redirect()->back();
    }


    private function terbilang($angka)
    {
        $angka = round(abs($angka));
        $baca = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
        $hasil = "";

        if ($angka < 12) {
            $hasil = $baca[$angka];
        } else if ($angka < 20) {
            $hasil = $this->terbilang($angka - 10) . " Belas";
        } else if ($angka < 100) {
            $hasil = $this->terbilang(intval($angka / 10)) . " Puluh";
            if ($angka % 10 != 0) {
                $hasil .= " " . $this->terbilang($angka % 10);
            }
        } else if ($angka < 200) {
            $hasil = "Seratus";
            if ($angka - 100 != 0) {
                $hasil .= " " . $this->terbilang($angka - 100);
            }
        } else if ($angka < 1000) {
            $hasil = $this->terbilang(intval($angka / 100)) . " Ratus";
            if ($angka % 100 != 0) {
                $hasil .= " " . $this->terbilang($angka % 100);
            }
        } else if ($angka < 2000) {
            $hasil = "Seribu";
            if ($angka - 1000 != 0) {
                $hasil .= " " . $this->terbilang($angka - 1000);
            }
        } else if ($angka < 1000000) {
            $hasil = $this->terbilang(intval($angka / 1000)) . " Ribu";
            if ($angka % 1000 != 0) {
                $hasil .= " " . $this->terbilang($angka % 1000);
            }
        } else if ($angka < 1000000000) {
            $hasil = $this->terbilang(intval($angka / 1000000)) . " Juta";
            if ($angka % 1000000 != 0) {
                $hasil .= " " . $this->terbilang($angka % 1000000);
            }
        } else if ($angka < 1000000000000) {
            $hasil = $this->terbilang(intval($angka / 1000000000)) . " Milyar";
            if ($angka % 1000000000 != 0) {
                $hasil .= " " . $this->terbilang($angka % 1000000000);
            }
        } else if ($angka < 1000000000000000) {
            $hasil = $this->terbilang(intval($angka / 1000000000000)) . " Triliun";
            if ($angka % 1000000000000 != 0) {
                $hasil .= " " . $this->terbilang($angka % 1000000000000);
            }
        }

        return trim($hasil);
    }
}
