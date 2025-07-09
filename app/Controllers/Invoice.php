<?php

namespace App\Controllers;

use App\Models\InvoiceModel;
use App\Models\PemesananModel;

class Invoice extends BaseController
{
    protected $invoiceModel;
    protected $pemesananModel;

    public function __construct()
    {
        $this->invoiceModel = new InvoiceModel();
        $this->pemesananModel = new PemesananModel();
    }

    public function index()
    {
        $invoices = $this->invoiceModel->findAll();
        $data = [
            'invoice' => $invoices
        ];
        return view('invoice/index', $data);
    }

    public function create($pemesananId)
    {
        $pemesanan = $this->pemesananModel
            ->select('tbl_mengelola_pemesanan.*, tbl_input_data_rekanan.nama_rek, tbl_input_data_rekanan.alamat, tbl_input_data_rekanan.npwp, tbl_input_data_rekanan.telepon, tbl_input_data_produk.nama_jenis_produk, produk.nama_kategori_produk, produk.satuan')
            ->join('rekanan', 'rekanan.id = tbl_mengelola_pemesanan.rekanan_id')
            ->join('tbl_input_data_rekanan', 'tbl_input_data_rekanan.nama_rek = tbl_mengelola_pemesanan.nama_rek')
            ->join('tbl_input_data_produk', 'tbl_input_data_produk.nama_jenis_produk = tbl_mengelola_pemesanan.nama_jenis_produk')
            ->join('produk', 'produk.id = tbl_mengelola_pemesanan.produk_id')
            ->find($pemesananId);

        $data = [
            'title' => 'Buat Invoice - Sistem Invoice PT Jaya Beton',
            'pemesanan' => $pemesanan,
            'validation' => $this->validation
        ];

        return view('invoice/create', $data);
    }

    public function store()
    {
        $rules = [
            'no_invoice' => 'required|is_unique[tbl_mengelola_invoice.no_invoice]',
            'pemesanan_id' => 'required|integer',
            'tgl_so' => 'required|valid_date',
            'ppn' => 'required|decimal|greater_than_equal_to[0]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $pemesananId = $this->request->getPost('pemesanan_id');
        $pemesanan = $this->pemesananModel->find($pemesananId);

        $totalSebelumPpn = $pemesanan['total_harga'];
        $ppnPersen = $this->request->getPost('ppn');
        $nilaiPpn = ($totalSebelumPpn * $ppnPersen) / 100;
        $totalSetelahPpn = $totalSebelumPpn + $nilaiPpn;

        $dueDate = $this->request->getPost('due_date');
        if (empty($dueDate)) {
            $dueDate = date('Y-m-d', strtotime('+30 days', strtotime($this->request->getPost('tgl_so'))));
        }

        $data = [
            'no_invoice' => $this->request->getPost('no_invoice'),
            'pemesanan_id' => $pemesananId,
            'tgl_so' => $this->request->getPost('tgl_so'),
            'due_date' => $dueDate,
            'ppn' => $ppnPersen,
            'total_sebelum_ppn' => $totalSebelumPpn,
            'nilai_ppn' => $nilaiPpn,
            'total_harga' => $totalSetelahPpn,
            'keterangan' => $this->request->getPost('keterangan'),
            'created_by' => $this->getUserId()
        ];

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Insert invoice
            $invoiceId = $this->invoiceModel->insert($data);
            
            // Update status pemesanan
            $this->pemesananModel->update($pemesananId, ['status' => 'invoiced']);
            
            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception('Transaction failed');
            }

            $this->setAlert('success', 'Invoice berhasil dibuat!');
            return redirect()->to('/invoice');

        } catch (\Exception $e) {
            $db->transRollback();
            $this->setAlert('error', 'Gagal membuat invoice!');
            return redirect()->back()->withInput();
        }
    }

    public function show($noInvoice)
    {
        $invoice = $this->invoiceModel
            ->select('tbl_mengelola_invoice.*, tbl_input_data_rekanan.nama_rek, tbl_input_data_rekanan.alamat, tbl_input_data_rekanan.npwp, tbl_input_data_rekanan.telepon, tbl_input_data_rekanan.email, tbl_mengelola_pemesanan.id_so, tbl_mengelola_pemesanan.no_po, tbl_mengelola_pemesanan.order_btg, tbl_input_data_produk.nama_jenis_produk, produk.nama_kategori_produk, produk.satuan, users.full_name as created_by_name')
            ->join('tbl_mengelola_pemesanan', 'tbl_mengelola_pemesanan.id_so = tbl_mengelola_invoice.pemesanan_id')
            ->join('tbl_input_data_rekanan', 'tbl_input_data_rekanan.nama_rek = tbl_mengelola_pemesanan.nama_rek')
            ->join('tbl_input_data_produk', 'tbl_input_data_produk.nama_jenis_produk = tbl_mengelola_pemesanan.nama_jenis_produk')
            ->join('produk', 'produk.id = tbl_mengelola_pemesanan.produk_id')
            ->join('users', 'users.id = tbl_mengelola_invoice.created_by', 'left')
            ->where('tbl_mengelola_invoice.no_invoice', $noInvoice)
            ->first();
        
        if (!$invoice) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Invoice tidak ditemukan');
        }

        $data = [
            'title' => 'Detail Invoice - Sistem Invoice PT Jaya Beton',
            'invoice' => $invoice
        ];

        return view('invoice/show', $data);
    }

    public function print($no_invoice)
    {
        $invoice = $this->invoiceModel->where('no_invoice', $no_invoice)->first();
        if (!$invoice) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Invoice tidak ditemukan');
        }
        $terbilang = $this->terbilang($invoice['total_harga'] + round($invoice['total_harga'] * 0.11));
        return view('invoice/print', [
            'invoice' => $invoice,
            'terbilang' => $terbilang
        ]);
    }

    // Fungsi terbilang sederhana (Indonesia)
    private function terbilang($angka)
    {
        $angka = abs($angka);
        $baca = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
        $hasil = "";
        if ($angka < 12) {
            $hasil = " " . $baca[$angka];
        } else if ($angka < 20) {
            $hasil = $this->terbilang($angka - 10) . " Belas";
        } else if ($angka < 100) {
            $hasil = $this->terbilang($angka / 10) . " Puluh" . $this->terbilang($angka % 10);
        } else if ($angka < 200) {
            $hasil = " Seratus" . $this->terbilang($angka - 100);
        } else if ($angka < 1000) {
            $hasil = $this->terbilang($angka / 100) . " Ratus" . $this->terbilang($angka % 100);
        } else if ($angka < 2000) {
            $hasil = " Seribu" . $this->terbilang($angka - 1000);
        } else if ($angka < 1000000) {
            $hasil = $this->terbilang($angka / 1000) . " Ribu" . $this->terbilang($angka % 1000);
        } else if ($angka < 1000000000) {
            $hasil = $this->terbilang($angka / 1000000) . " Juta" . $this->terbilang($angka % 1000000);
        } else if ($angka < 1000000000000) {
            $hasil = $this->terbilang($angka / 1000000000) . " Milyar" . $this->terbilang(fmod($angka, 1000000000));
        } else if ($angka < 1000000000000000) {
            $hasil = $this->terbilang($angka / 1000000000000) . " Triliun" . $this->terbilang(fmod($angka, 1000000000000));
        }
        return trim($hasil);
    }
}
