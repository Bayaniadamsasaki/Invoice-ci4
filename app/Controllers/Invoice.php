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
        $invoices = $this->invoiceModel
            ->select('invoice.*, rekanan.nama_rekanan, tbl_mengelola_pemesanan.no_so, produk.nama_jenis_produk')
            ->join('tbl_mengelola_pemesanan', 'tbl_mengelola_pemesanan.id = invoice.pemesanan_id')
            ->join('rekanan', 'rekanan.id = tbl_mengelola_pemesanan.rekanan_id')
            ->join('produk', 'produk.id = tbl_mengelola_pemesanan.produk_id')
            ->orderBy('invoice.created_at', 'DESC')
            ->findAll();

        $data = [
            'title' => 'Data Invoice - Sistem Invoice PT Jaya Beton',
            'invoices' => $invoices
        ];

        return view('invoice/index', $data);
    }

    public function create($pemesananId)
    {
        $pemesanan = $this->pemesananModel
            ->select('tbl_mengelola_pemesanan.*, rekanan.nama_rekanan, rekanan.alamat, rekanan.npwp, rekanan.telepon, produk.nama_jenis_produk, produk.nama_kategori_produk, produk.satuan')
            ->join('rekanan', 'rekanan.id = tbl_mengelola_pemesanan.rekanan_id')
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
            'no_invoice' => 'required|is_unique[invoice.no_invoice]',
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
            ->select('invoice.*, rekanan.nama_rekanan, rekanan.alamat, rekanan.npwp, rekanan.telepon, rekanan.email, tbl_mengelola_pemesanan.no_so, tbl_mengelola_pemesanan.no_po, tbl_mengelola_pemesanan.order_btg, produk.nama_jenis_produk, produk.nama_kategori_produk, produk.satuan, users.full_name as created_by_name')
            ->join('tbl_mengelola_pemesanan', 'tbl_mengelola_pemesanan.id = invoice.pemesanan_id')
            ->join('rekanan', 'rekanan.id = tbl_mengelola_pemesanan.rekanan_id')
            ->join('produk', 'produk.id = tbl_mengelola_pemesanan.produk_id')
            ->join('users', 'users.id = invoice.created_by', 'left')
            ->where('invoice.no_invoice', $noInvoice)
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

    public function print($noInvoice)
    {
        $invoice = $this->invoiceModel
            ->select('invoice.*, rekanan.nama_rekanan, rekanan.alamat, rekanan.npwp, rekanan.telepon, tbl_mengelola_pemesanan.no_so, tbl_mengelola_pemesanan.no_po, tbl_mengelola_pemesanan.order_btg, produk.nama_jenis_produk, produk.nama_kategori_produk, produk.satuan')
            ->join('tbl_mengelola_pemesanan', 'tbl_mengelola_pemesanan.id = invoice.pemesanan_id')
            ->join('rekanan', 'rekanan.id = tbl_mengelola_pemesanan.rekanan_id')
            ->join('produk', 'produk.id = tbl_mengelola_pemesanan.produk_id')
            ->where('invoice.no_invoice', $noInvoice)
            ->first();
        
        if (!$invoice) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Invoice tidak ditemukan');
        }

        $data = [
            'invoice' => $invoice
        ];

        return view('invoice/print', $data);
    }
}
