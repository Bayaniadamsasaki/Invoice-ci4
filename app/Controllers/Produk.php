<?php

namespace App\Controllers;

use App\Models\ProdukModel;

class Produk extends BaseController
{
    protected $produkModel;

    public function __construct()
    {
        $this->produkModel = new ProdukModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Produk - Sistem Invoice PT Jaya Beton',
            'produk' => $this->produkModel->findAll()
        ];

        return view('produk/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Produk - Sistem Invoice PT Jaya Beton',
            'validation' => $this->validation
        ];

        return view('produk/create', $data);
    }

    public function store()
    {
        $rules = [
            'kode_jenis_produk' => 'required|is_unique[produk.kode_jenis_produk]',
            'nama_jenis_produk' => 'required|min_length[3]',
            'kode_kategori_produk' => 'required',
            'nama_kategori_produk' => 'required',
            'berat' => 'required',
            'harga_satuan' => 'required|decimal'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $data = [
            'kode_jenis_produk' => $this->request->getPost('kode_jenis_produk'),
            'nama_jenis_produk' => $this->request->getPost('nama_jenis_produk'),
            'kode_kategori_produk' => $this->request->getPost('kode_kategori_produk'),
            'nama_kategori_produk' => $this->request->getPost('nama_kategori_produk'),
            'diameter_lebar' => $this->request->getPost('diameter_lebar'),
            'tinggi' => $this->request->getPost('tinggi'),
            'tebal' => $this->request->getPost('tebal'),
            'panjang' => $this->request->getPost('panjang'),
            'berat' => $this->request->getPost('berat'),
            'satuan' => $this->request->getPost('satuan'),
            'harga_satuan' => $this->request->getPost('harga_satuan')
        ];

        if ($this->produkModel->insert($data)) {
            $this->setAlert('success', 'Data produk berhasil ditambahkan!');
            return redirect()->to('/produk');
        }

        $this->setAlert('error', 'Gagal menambahkan data produk!');
        return redirect()->back()->withInput();
    }

    public function show($id)
    {
        $produk = $this->produkModel->find($id);
        
        if (!$produk) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Produk tidak ditemukan');
        }

        $data = [
            'title' => 'Detail Produk - Sistem Invoice PT Jaya Beton',
            'produk' => $produk
        ];

        return view('produk/show', $data);
    }

    public function edit($id)
    {
        $produk = $this->produkModel->find($id);
        
        if (!$produk) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Produk tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Produk - Sistem Invoice PT Jaya Beton',
            'produk' => $produk,
            'validation' => $this->validation
        ];

        return view('produk/edit', $data);
    }

    public function update($id)
    {
        $produk = $this->produkModel->find($id);
        
        if (!$produk) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Produk tidak ditemukan');
        }

        $rules = [
            'kode_jenis_produk' => "required|is_unique[produk.kode_jenis_produk,id,{$id}]",
            'nama_jenis_produk' => 'required|min_length[3]',
            'kode_kategori_produk' => 'required',
            'nama_kategori_produk' => 'required',
            'berat' => 'required',
            'harga_satuan' => 'required|decimal'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $data = [
            'kode_jenis_produk' => $this->request->getPost('kode_jenis_produk'),
            'nama_jenis_produk' => $this->request->getPost('nama_jenis_produk'),
            'kode_kategori_produk' => $this->request->getPost('kode_kategori_produk'),
            'nama_kategori_produk' => $this->request->getPost('nama_kategori_produk'),
            'diameter_lebar' => $this->request->getPost('diameter_lebar'),
            'tinggi' => $this->request->getPost('tinggi'),
            'tebal' => $this->request->getPost('tebal'),
            'panjang' => $this->request->getPost('panjang'),
            'berat' => $this->request->getPost('berat'),
            'satuan' => $this->request->getPost('satuan'),
            'harga_satuan' => $this->request->getPost('harga_satuan')
        ];

        if ($this->produkModel->update($id, $data)) {
            $this->setAlert('success', 'Data produk berhasil diupdate!');
            return redirect()->to('/produk');
        }

        $this->setAlert('error', 'Gagal mengupdate data produk!');
        return redirect()->back()->withInput();
    }

    public function delete($id)
    {
        $produk = $this->produkModel->find($id);
        
        if (!$produk) {
            $this->setAlert('error', 'Produk tidak ditemukan!');
            return redirect()->to('/produk');
        }

        // Soft delete
        if ($this->produkModel->update($id, ['is_active' => 0])) {
            $this->setAlert('success', 'Data produk berhasil dihapus!');
        } else {
            $this->setAlert('error', 'Gagal menghapus data produk!');
        }

        return redirect()->to('/produk');
    }
}
