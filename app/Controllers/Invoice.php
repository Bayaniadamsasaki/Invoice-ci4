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

        if (!hasAnyRole(['bagian_keuangan'])) {
            session()->setFlashdata('alert', [
                'type' => 'error',
                'message' => 'Anda tidak memiliki akses ke halaman ini.'
            ]);
            return redirect()->to('/dashboard');
        }


        $invoicedIds = $this->invoiceModel->select('pemesanan_id')->findAll();
        $invoicedIdList = array_column($invoicedIds, 'pemesanan_id');

        if (!empty($invoicedIdList)) {
            $pemesananBelumInvoice = $this->pemesananModel
                ->whereNotIn('id_so', $invoicedIdList)
                ->findAll();
        } else {
            $pemesananBelumInvoice = $this->pemesananModel->findAll();
        }
        $data = [
            'invoice' => $this->invoiceModel->orderBy('no_invoice', 'ASC')->findAll(),
            'pemesanan_belum_invoice' => $pemesananBelumInvoice
        ];
        return view('invoice/index', $data);
    }

    public function create($pemesananId = null)
    {

        if (!hasAnyRole(['bagian_keuangan'])) {
            session()->setFlashdata('alert', [
                'type' => 'error',
                'message' => 'Anda tidak memiliki akses ke halaman ini.'
            ]);
            return redirect()->to('/dashboard');
        }


        $lastInvoice = $this->invoiceModel->selectMax('no_invoice')->first();
        $next_no_invoice = isset($lastInvoice['no_invoice']) ? ((int)$lastInvoice['no_invoice'] + 1) : 1;
        if ($pemesananId) {
            $pemesanan = $this->pemesananModel
                ->select('tbl_mengelola_pemesanan.*, tbl_input_data_rekanan.nama_rek, tbl_input_data_rekanan.alamat, tbl_input_data_rekanan.npwp, tbl_input_data_produk.nama_jenis_produk, tbl_input_data_produk.nama_kategori_produk')
                ->join('tbl_input_data_rekanan', 'tbl_input_data_rekanan.nama_rek = tbl_mengelola_pemesanan.nama_rek')
                ->join('tbl_input_data_produk', 'tbl_input_data_produk.nama_jenis_produk = tbl_mengelola_pemesanan.nama_jenis_produk')
                ->where('tbl_mengelola_pemesanan.id_so', $pemesananId)
                ->first();
            $data = [
                'title' => 'Buat Invoice - Sistem Invoice PT Jaya Beton',
                'pemesanan' => $pemesanan,
                'list_pemesanan' => [],
                'selected_pemesanan_id' => $pemesananId,
                'validation' => \Config\Services::validation(),
                'next_no_invoice' => $next_no_invoice
            ];
        } else {

            $invoicedIds = $this->invoiceModel->select('pemesanan_id')->findAll();
            $invoicedIdList = array_column($invoicedIds, 'pemesanan_id');

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

        if (!hasAnyRole(['bagian_keuangan'])) {
            session()->setFlashdata('alert', [
                'type' => 'error',
                'message' => 'Anda tidak memiliki akses ke halaman ini.'
            ]);
            return redirect()->to('/dashboard');
        }

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
            ->where('tbl_mengelola_pemesanan.id_so', $pemesananId)
            ->first();
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

            $invoiceId = $this->invoiceModel->insert($data);
            file_put_contents(WRITEPATH . 'debug.txt', 'INSERT: ' . json_encode($data) . ' | ID: ' . $invoiceId . PHP_EOL, FILE_APPEND);
            if (!$invoiceId) {
                file_put_contents(WRITEPATH . 'debug.txt', 'INSERT GAGAL: ' . json_encode($this->invoiceModel->errors()) . PHP_EOL, FILE_APPEND);
                var_dump($this->invoiceModel->errors());
                var_dump($data);
                exit;
            }

            $noInvoiceBaru = $this->invoiceModel->getInsertID();

            $db->transComplete();

            if ($db->transStatus() === false) {
                file_put_contents(WRITEPATH . 'debug.txt', 'TRANSAKSI ROLLBACK' . PHP_EOL, FILE_APPEND);
                throw new \Exception('Transaction failed');
            }
            file_put_contents(WRITEPATH . 'debug.txt', 'TRANSAKSI SELESAI' . PHP_EOL, FILE_APPEND);
            session()->setFlashdata('success', 'Invoice berhasil dibuat!');


            if ($this->request->getPost('redirect_to_dashboard')) {
                session()->setFlashdata('trigger_dashboard_update', true);
            }

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

        if (!hasAnyRole(['bagian_keuangan'])) {
            session()->setFlashdata('alert', [
                'type' => 'error',
                'message' => 'Anda tidak memiliki akses ke halaman ini.'
            ]);
            return redirect()->to('/dashboard');
        }

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

    public function edit($no_invoice)
    {

        if (!hasAnyRole(['bagian_keuangan'])) {
            session()->setFlashdata('alert', [
                'type' => 'error',
                'message' => 'Anda tidak memiliki akses ke halaman ini.'
            ]);
            return redirect()->to('/dashboard');
        }

        $invoice = $this->invoiceModel->find($no_invoice);

        if (!$invoice) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Invoice tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Invoice',
            'invoice' => $invoice
        ];

        return view('invoice/edit', $data);
    }

    public function update($no_invoice)
    {

        if (!hasAnyRole(['bagian_keuangan'])) {
            session()->setFlashdata('alert', [
                'type' => 'error',
                'message' => 'Anda tidak memiliki akses ke halaman ini.'
            ]);
            return redirect()->to('/dashboard');
        }

        $invoice = $this->invoiceModel->find($no_invoice);
        if (!$invoice) {
            session()->setFlashdata('error', 'Invoice tidak ditemukan!');
            return redirect()->back();
        }

        $hargaSatuan = $this->request->getPost('harga_satuan');
        $ppn = $this->request->getPost('ppn');
        $orderBtg = $invoice['order_btg'];

        $subtotal = $orderBtg * $hargaSatuan;
        $nilaiPpn = $subtotal * ($ppn / 100);
        $totalHarga = $subtotal + $nilaiPpn;

        $data = [
            'harga_satuan'      => $hargaSatuan,
            'tanggal_invoice'   => $this->request->getPost('tanggal_invoice'),
            'ppn'               => $ppn,
            'keterangan'        => $this->request->getPost('keterangan'),
            'npwp'              => $this->request->getPost('npwp'),
            'total_harga'       => $totalHarga
        ];

        if (!$this->invoiceModel->update($no_invoice, $data)) {
            session()->setFlashdata('error', 'Gagal mengupdate invoice!');
            return redirect()->back()->withInput();
        }

        session()->setFlashdata('success', 'Invoice berhasil diupdate!');
        return redirect()->to('/invoice');
    }

    public function print($no_invoice)
    {
        $invoice = $this->invoiceModel
            ->select('tbl_mengelola_invoice.*, tbl_mengelola_pemesanan.no_po, tbl_input_data_produk.nama_kategori_produk, tbl_input_data_produk.kode_kategori_produk_')
            ->join('tbl_mengelola_pemesanan', 'tbl_mengelola_pemesanan.id_so = tbl_mengelola_invoice.pemesanan_id', 'left')
            ->join('tbl_input_data_produk', 'tbl_input_data_produk.nama_jenis_produk = tbl_mengelola_invoice.nama_jenis_produk', 'left')
            ->where('tbl_mengelola_invoice.no_invoice', $no_invoice)
            ->first();

        if (!$invoice) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Invoice tidak ditemukan');
        }


        $total_harga = $invoice['total_harga'] ?? 0;
        $terbilang = $this->terbilang($total_harga);

        return view('invoice/print', [
            'invoice' => $invoice,
            'terbilang' => $terbilang
        ]);
    }

    public function delete($no_invoice)
    {

        if (!hasAnyRole(['admin', 'bagian_keuangan'])) {
            session()->setFlashdata('alert', [
                'type' => 'error',
                'message' => 'Anda tidak memiliki akses untuk menghapus invoice.'
            ]);
            return redirect()->to('/invoice');
        }

        if ($this->invoiceModel->delete($no_invoice)) {
            session()->setFlashdata('success', 'Invoice berhasil dihapus!');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus invoice!');
        }
        return redirect()->to('/invoice');
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
