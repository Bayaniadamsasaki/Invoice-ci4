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
        
        if (!isAdmin()) {
            session()->setFlashdata('alert', [
                'type' => 'error',
                'message' => 'Anda tidak memiliki akses ke halaman ini.'
            ]);
            return redirect()->to('/dashboard');
        }

        $data = [
            'title' => 'Data Produk - Sistem Invoice PT Jaya Beton',
            'produk' => $this->produkModel->orderBy('kode_jenis_produk', 'ASC')->findAll()
        ];

        return view('produk/index', $data);
    }

    public function create()
    {
        
        if (!isAdmin()) {
            session()->setFlashdata('alert', [
                'type' => 'error',
                'message' => 'Anda tidak memiliki akses ke halaman ini.'
            ]);
            return redirect()->to('/dashboard');
        }

        $data = [
            'title' => 'Tambah Produk - Sistem Invoice PT Jaya Beton',
            'validation' => \Config\Services::validation()
        ];

        return view('produk/create', $data);
    }

    public function store()
    {
        $rules = [
            'kode_jenis_produk' => 'required',
            'nama_jenis_produk' => 'required|min_length[3]',
            'kode_kategori_produk_' => 'required',
            'nama_kategori_produk' => 'required',
            'berat' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $data = [
            'kode_jenis_produk' => $this->request->getPost('kode_jenis_produk'),
            'nama_jenis_produk' => $this->request->getPost('nama_jenis_produk'),
            'kode_kategori_produk_' => $this->request->getPost('kode_kategori_produk_'),
            'nama_kategori_produk' => $this->request->getPost('nama_kategori_produk'),
            'berat' => $this->request->getPost('berat')
        ];

        if ($this->produkModel->insert($data)) {
            session()->setFlashdata('success', 'Data produk berhasil ditambahkan!');
            session()->setFlashdata('trigger_dashboard_update', true);
            return redirect()->to('/produk');
        }

        session()->setFlashdata('error', 'Gagal menambahkan data produk!');
        return redirect()->back()->withInput();
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
            'validation' => \Config\Services::validation()
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
            
            'nama_jenis_produk' => 'required|min_length[3]',
            'kode_kategori_produk_' => 'required',
            'nama_kategori_produk' => 'required',
            'berat' => 'required|numeric'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $data = [
            'kode_jenis_produk' => $this->request->getPost('kode_jenis_produk'),
            'nama_jenis_produk' => $this->request->getPost('nama_jenis_produk'),
            'kode_kategori_produk_' => $this->request->getPost('kode_kategori_produk_'),
            'nama_kategori_produk' => $this->request->getPost('nama_kategori_produk'),
            'berat' => $this->request->getPost('berat')
        ];

        if ($this->produkModel->update($id, $data)) {
            session()->setFlashdata('success', 'Data produk berhasil diupdate!');
            return redirect()->to('/produk');
        }

        session()->setFlashdata('error', 'Gagal mengupdate data produk!');
        return redirect()->back()->withInput();
    }

    public function delete($id)
    {
        $produk = $this->produkModel->find($id);
        
        if (!$produk) {
            session()->setFlashdata('error', 'Produk tidak ditemukan!');
            return redirect()->to('/produk');
        }

        if ($this->produkModel->delete($id)) {
            session()->setFlashdata('success', 'Data produk berhasil dihapus!');
            session()->setFlashdata('trigger_dashboard_update', true);
        } else {
            session()->setFlashdata('error', 'Gagal menghapus data produk!');
        }

        return redirect()->to('/produk');
    }
}
