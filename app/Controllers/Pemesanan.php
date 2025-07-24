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
    protected $validation;

    public function __construct()
    {
        $this->pemesananModel = new PemesananModel();
        $this->rekananModel = new RekananModel();
        $this->produkModel = new ProdukModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        // Hanya admin yang bisa akses
        if (!hasAnyRole(['admin'])) {
            session()->setFlashdata('alert', [
                'type' => 'error',
                'message' => 'Anda tidak memiliki akses ke halaman ini.'
            ]);
            return redirect()->to('/dashboard');
        }

        $pemesanan = $this->pemesananModel->orderBy('id_so', 'DESC')->findAll();

        $data = [
            'title' => 'Data Pemesanan - Sistem Invoice PT Jaya Beton Indonesia',
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
            'validation' => \Config\Services::validation()
        ];

        return view('pemesanan/create', $data);
    }

    public function store()
    {
        $rules = [
            'tgl_so' => 'required|valid_date',
            'no_po' => 'permit_empty',
            'nama_rek' => 'required',
            'nama_jenis_produk' => 'required',
            'order_btg' => 'required|integer|greater_than[0]'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $data = [
            'tgl_so' => $this->request->getPost('tgl_so'),
            'no_po' => $this->request->getPost('no_po'),
            'nama_rek' => $this->request->getPost('nama_rek'),
            'nama_jenis_produk' => $this->request->getPost('nama_jenis_produk'),
            'order_btg' => $this->request->getPost('order_btg'),
        ];

        if ($this->pemesananModel->insert($data)) {
            session()->setFlashdata('success', 'Data pemesanan berhasil ditambahkan!');
            session()->setFlashdata('trigger_dashboard_update', true);
            return redirect()->to('/pemesanan');
        }

        session()->setFlashdata('error', 'Gagal menambahkan data pemesanan!');
        return redirect()->back()->withInput();
    }

    public function show($id)
    {
        $pemesanan = $this->pemesananModel
            ->select('tbl_mengelola_pemesanan.*, tbl_input_data_rekanan.nama_rek, tbl_input_data_rekanan.alamat, tbl_input_data_rekanan.npwp, tbl_input_data_rekanan.telepon, tbl_input_data_rekanan.email, users.full_name as created_by_name')
            ->join('tbl_input_data_rekanan', 'tbl_input_data_rekanan.nama_rek = tbl_mengelola_pemesanan.nama_rek')
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
            'tgl_so' => 'required|valid_date',
            'no_po' => 'permit_empty',
            'nama_rek' => 'required',
            'nama_jenis_produk' => 'required',
            'order_btg' => 'required|integer|greater_than[0]'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $data = [
            'tgl_so' => $this->request->getPost('tgl_so'),
            'no_po' => $this->request->getPost('no_po'),
            'nama_rek' => $this->request->getPost('nama_rek'),
            'nama_jenis_produk' => $this->request->getPost('nama_jenis_produk'),
            'order_btg' => $this->request->getPost('order_btg'),
        ];

        if ($this->pemesananModel->update($id, $data)) {
            session()->setFlashdata('success', 'Data pemesanan berhasil diupdate!');
            return redirect()->to('/pemesanan');
        }

        session()->setFlashdata('error', 'Gagal mengupdate data pemesanan!');
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
            session()->setFlashdata('success', 'Data pemesanan berhasil dihapus!');
            session()->setFlashdata('trigger_dashboard_update', true);
        } else {
            session()->setFlashdata('error', 'Gagal menghapus data pemesanan!');
        }

        return redirect()->to('/pemesanan');
    }
}
