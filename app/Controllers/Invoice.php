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
        // Ambil semua id pemesanan yang sudah di-invoice
        $invoicedIds = $this->invoiceModel->select('pemesanan_id')->findAll();
        $invoicedIdList = array_column($invoicedIds, 'pemesanan_id');
        // Ambil pemesanan yang id_so belum ada di invoice
        if (!empty($invoicedIdList)) {
            $pemesananBelumInvoice = $this->pemesananModel
                ->whereNotIn('id_so', $invoicedIdList)
                ->findAll();
        } else {
            $pemesananBelumInvoice = $this->pemesananModel->findAll();
        }
        $data = [
            'invoice' => $this->invoiceModel->findAll(),
            'pemesanan_belum_invoice' => $pemesananBelumInvoice
        ];
        return view('invoice/index', $data);
    }

    public function create($pemesananId = null)
    {
        // Ambil nomor invoice berikutnya
        $lastInvoice = $this->invoiceModel->selectMax('no_invoice')->first();
        $next_no_invoice = isset($lastInvoice['no_invoice']) ? ((int)$lastInvoice['no_invoice'] + 1) : 1;
        if ($pemesananId) {
            $pemesanan = $this->pemesananModel
                ->select('tbl_mengelola_pemesanan.*, tbl_input_data_rekanan.nama_rek, tbl_input_data_rekanan.alamat, tbl_input_data_rekanan.npwp, tbl_input_data_produk.nama_jenis_produk, tbl_input_data_produk.nama_kategori_produk')
                ->join('tbl_input_data_rekanan', 'tbl_input_data_rekanan.nama_rek = tbl_mengelola_pemesanan.nama_rek')
                ->join('tbl_input_data_produk', 'tbl_input_data_produk.nama_jenis_produk = tbl_mengelola_pemesanan.nama_jenis_produk')
                ->find($pemesananId);
            $data = [
                'title' => 'Buat Invoice - Sistem Invoice PT Jaya Beton',
                'pemesanan' => $pemesanan,
                'list_pemesanan' => [],
                'selected_pemesanan_id' => $pemesananId,
                'validation' => \Config\Services::validation(),
                'next_no_invoice' => $next_no_invoice
            ];
        } else {
            // Ambil semua id pemesanan yang sudah di-invoice
            $invoicedIds = $this->invoiceModel->select('pemesanan_id')->findAll();
            $invoicedIdList = array_column($invoicedIds, 'pemesanan_id');
            // Ambil pemesanan yang id_so belum ada di invoice
            if (!empty($invoicedIdList)) {
                $list_pemesanan = $this->pemesananModel
                    ->whereNotIn('id_so', $invoicedIdList)
                    ->findAll();
            } else {
                $list_pemesanan = $this->pemesananModel->findAll();
            }
            $data = [
                'title' => 'Buat Invoice - Sistem Invoice PT Jaya Beton',
                'pemesanan' => null,
                'list_pemesanan' => $list_pemesanan,
                'selected_pemesanan_id' => null,
                'validation' => \Config\Services::validation(),
                'next_no_invoice' => $next_no_invoice
            ];
        }
        return view('invoice/create', $data);
    }

    public function store()
    {
        file_put_contents(WRITEPATH . 'debug.txt', 'MASUK STORE: ' . date('Y-m-d H:i:s') . PHP_EOL, FILE_APPEND);
        $rules = [
            'pemesanan_id' => 'required|integer',
            'npwp' => 'required',
            'ppn' => 'required|decimal|greater_than_equal_to[0]',
            'harga_satuan' => 'required|numeric|greater_than_equal_to[0]'
        ];

        if (!$this->validate($rules)) {
            file_put_contents(WRITEPATH . 'debug.txt', 'VALIDASI GAGAL: ' . json_encode($this->validator->getErrors()) . PHP_EOL, FILE_APPEND);
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $pemesananId = $this->request->getPost('pemesanan_id');
        $pemesanan = $this->pemesananModel
            ->select('tbl_mengelola_pemesanan.*, tbl_input_data_rekanan.alamat, tbl_input_data_rekanan.npwp, tbl_input_data_rekanan.nama_rek, tbl_input_data_produk.nama_jenis_produk')
            ->join('tbl_input_data_rekanan', 'tbl_input_data_rekanan.nama_rek = tbl_mengelola_pemesanan.nama_rek')
            ->join('tbl_input_data_produk', 'tbl_input_data_produk.nama_jenis_produk = tbl_mengelola_pemesanan.nama_jenis_produk')
            ->find($pemesananId);
        if (!$pemesanan || !isset($pemesanan['alamat'])) {
            file_put_contents(WRITEPATH . 'debug.txt', 'PEMESANAN TIDAK DITEMUKAN' . PHP_EOL, FILE_APPEND);
            return redirect()->back()->withInput()->with('validation', 'Data alamat tidak ditemukan pada pemesanan.');
        }

        $hargaSatuan = $this->request->getPost('harga_satuan');
        $qty = $pemesanan['order_btg'];
        $subtotal = $qty * $hargaSatuan;
        $ppn = $this->request->getPost('ppn');
        $nilaiPpn = $subtotal * ($ppn / 100);
        $totalHarga = $subtotal + $nilaiPpn;
        $data = [
            'tgl_so' => $pemesanan['tgl_so'],
            'nama_rek' => $pemesanan['nama_rek'],
            'alamat' => $pemesanan['alamat'],
            'npwp' => $this->request->getPost('npwp'),
            'nama_jenis_produk' => $pemesanan['nama_jenis_produk'],
            'order_btg' => $pemesanan['order_btg'],
            'ppn' => $ppn,
            'total_harga' => $totalHarga,
            'pemesanan_id' => $pemesananId,
        ];

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Insert invoice
            $invoiceId = $this->invoiceModel->insert($data);
            file_put_contents(WRITEPATH . 'debug.txt', 'INSERT: ' . json_encode($data) . ' | ID: ' . $invoiceId . PHP_EOL, FILE_APPEND);
            if (!$invoiceId) {
                file_put_contents(WRITEPATH . 'debug.txt', 'INSERT GAGAL: ' . json_encode($this->invoiceModel->errors()) . PHP_EOL, FILE_APPEND);
                var_dump($this->invoiceModel->errors());
                var_dump($data);
                exit;
            }
            // Dapatkan no_invoice terakhir (auto increment)
            $noInvoiceBaru = $this->invoiceModel->getInsertID();
            // Update status pemesanan (hapus baris ini karena tidak ada field status)
            $db->transComplete();

            if ($db->transStatus() === false) {
                file_put_contents(WRITEPATH . 'debug.txt', 'TRANSAKSI ROLLBACK' . PHP_EOL, FILE_APPEND);
                throw new \Exception('Transaction failed');
            }
            file_put_contents(WRITEPATH . 'debug.txt', 'TRANSAKSI SELESAI' . PHP_EOL, FILE_APPEND);
            session()->setFlashdata('success', 'Invoice berhasil dibuat!');
            return redirect()->to('/invoice');

        } catch (\Exception $e) {
            $db->transRollback();
            file_put_contents(WRITEPATH . 'debug.txt', 'EXCEPTION: ' . $e->getMessage() . PHP_EOL, FILE_APPEND);
            session()->setFlashdata('error', 'Gagal membuat invoice!');
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
