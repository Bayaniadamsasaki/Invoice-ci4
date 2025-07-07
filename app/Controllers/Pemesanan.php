<?php

namespace App\Controllers;

use App\Models\PemesananModel;
use App\Models\RekananModel;
use App\Models\ProdukModel;

class Pemesanan extends BaseController
{
    protected $pemesananModel;
    protected $rekananModel;
    protected $produkModel;

    public function __construct()
    {
        $this->pemesananModel = new PemesananModel();
        $this->rekananModel = new RekananModel();
        $this->produkModel = new ProdukModel();
    }

    public function index()
    {
        $pemesanan = $this->pemesananModel
            ->select('tbl_mengelola_pemesanan.*, rekanan.nama_rekanan, produk.nama_jenis_produk, produk.nama_kategori_produk')
            ->join('rekanan', 'rekanan.id = tbl_mengelola_pemesanan.rekanan_id')
            ->join('produk', 'produk.id = tbl_mengelola_pemesanan.produk_id')
            ->orderBy('tbl_mengelola_pemesanan.created_at', 'DESC')
            ->findAll();

        $data = [
            'title' => 'Data Pemesanan - Sistem Invoice PT Jaya Beton',
            'pemesanan' => $pemesanan
        ];

        return view('pemesanan/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Pemesanan - Sistem Invoice PT Jaya Beton',
            'rekanan' => $this->rekananModel->findAll(),
            'produk' => $this->produkModel->findAll(),
            'validation' => $this->validation
        ];

        return view('pemesanan/create', $data);
    }

    public function store()
    {
        $rules = [
            'no_so' => 'required|is_unique[tbl_mengelola_pemesanan.no_so]',
            'tanggal_so' => 'required|valid_date',
            'rekanan_id' => 'required|integer',
            'produk_id' => 'required|integer',
            'order_btg' => 'required|integer|greater_than[0]',
            'harga_satuan' => 'required|decimal|greater_than[0]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $orderBtg = $this->request->getPost('order_btg');
        $hargaSatuan = $this->request->getPost('harga_satuan');
        $totalHarga = $orderBtg * $hargaSatuan;

        $data = [
            'no_so' => $this->request->getPost('no_so'),
            'tanggal_so' => $this->request->getPost('tanggal_so'),
            'no_po' => $this->request->getPost('no_po'),
            'rekanan_id' => $this->request->getPost('rekanan_id'),
            'produk_id' => $this->request->getPost('produk_id'),
            'order_btg' => $orderBtg,
            'harga_satuan' => $hargaSatuan,
            'total_harga' => $totalHarga,
            'keterangan' => $this->request->getPost('keterangan'),
            'created_by' => $this->getUserId()
        ];

        if ($this->pemesananModel->insert($data)) {
            $this->setAlert('success', 'Data pemesanan berhasil ditambahkan!');
            return redirect()->to('/pemesanan');
        }

        $this->setAlert('error', 'Gagal menambahkan data pemesanan!');
        return redirect()->back()->withInput();
    }

    public function show($id)
    {
        $pemesanan = $this->pemesananModel
            ->select('tbl_mengelola_pemesanan.*, rekanan.nama_rekanan, rekanan.alamat, rekanan.npwp, rekanan.telepon, rekanan.email, produk.nama_jenis_produk, produk.nama_kategori_produk, produk.satuan, users.full_name as created_by_name')
            ->join('rekanan', 'rekanan.id = tbl_mengelola_pemesanan.rekanan_id')
            ->join('produk', 'produk.id = tbl_mengelola_pemesanan.produk_id')
            ->join('users', 'users.id = tbl_mengelola_pemesanan.created_by', 'left')
            ->find($id);
        
        if (!$pemesanan) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pemesanan tidak ditemukan');
        }

        $data = [
            'title' => 'Detail Pemesanan - Sistem Invoice PT Jaya Beton',
            'pemesanan' => $pemesanan
        ];

        return view('pemesanan/show', $data);
    }

    public function edit($id)
    {
        $pemesanan = $this->pemesananModel->find($id);
        
        $data = [
            'title' => 'Edit Pemesanan - Sistem Invoice PT Jaya Beton',
            'pemesanan' => $pemesanan,
            'rekanan' => $this->rekananModel->findAll(),
            'produk' => $this->produkModel->findAll(),
            'validation' => $this->validation
        ];

        return view('pemesanan/edit', $data);
    }

    public function update($id)
    {
        $pemesanan = $this->pemesananModel->find($id);
        
        $rules = [
            'no_so' => "required|is_unique[tbl_mengelola_pemesanan.no_so,id,{$id}]",
            'tanggal_so' => 'required|valid_date',
            'rekanan_id' => 'required|integer',
            'produk_id' => 'required|integer',
            'order_btg' => 'required|integer|greater_than[0]',
            'harga_satuan' => 'required|decimal|greater_than[0]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $orderBtg = $this->request->getPost('order_btg');
        $hargaSatuan = $this->request->getPost('harga_satuan');
        $totalHarga = $orderBtg * $hargaSatuan;

        $data = [
            'no_so' => $this->request->getPost('no_so'),
            'tanggal_so' => $this->request->getPost('tanggal_so'),
            'no_po' => $this->request->getPost('no_po'),
            'rekanan_id' => $this->request->getPost('rekanan_id'),
            'produk_id' => $this->request->getPost('produk_id'),
            'order_btg' => $orderBtg,
            'harga_satuan' => $hargaSatuan,
            'total_harga' => $totalHarga,
            'keterangan' => $this->request->getPost('keterangan')
        ];

        if ($this->pemesananModel->update($id, $data)) {
            $this->setAlert('success', 'Data pemesanan berhasil diupdate!');
            return redirect()->to('/pemesanan');
        }

        $this->setAlert('error', 'Gagal mengupdate data pemesanan!');
        return redirect()->back()->withInput();
    }

    public function approve($id)
    {
        $pemesanan = $this->pemesananModel->find($id);
        
        if ($this->pemesananModel->update($id, ['status' => 'approved'])) {
            $this->setAlert('success', 'Pemesanan berhasil disetujui!');
        } else {
            $this->setAlert('error', 'Gagal menyetujui pemesanan!');
        }

        return redirect()->to('/pemesanan');
    }

    public function delete($id)
    {
        $pemesanan = $this->pemesananModel->find($id);
        
        if ($this->pemesananModel->delete($id)) {
            $this->setAlert('success', 'Data pemesanan berhasil dihapus!');
        } else {
            $this->setAlert('error', 'Gagal menghapus data pemesanan!');
        }

        return redirect()->to('/pemesanan');
    }
}
