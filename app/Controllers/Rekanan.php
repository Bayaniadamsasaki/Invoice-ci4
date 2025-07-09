<?php

namespace App\Controllers;

use App\Models\RekananModel;

class Rekanan extends BaseController
{
    protected $rekananModel;

    public function __construct()
    {
        $this->rekananModel = new RekananModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Rekanan - Sistem Invoice PT Jaya Beton',
            'rekanan' => $this->rekananModel->findAll()
        ];

        return view('rekanan/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Rekanan - Sistem Invoice PT Jaya Beton',
            'validation' => \Config\Services::validation()
        ];

        return view('rekanan/create', $data);
    }

    public function store()
    {
        $rules = [
            'nama_rek' => 'required|min_length[3]',
            'alamat' => 'required|min_length[10]'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $data = [
            'nama_rek' => $this->request->getPost('nama_rek'),
            'alamat' => $this->request->getPost('alamat'),
            'npwp' => $this->request->getPost('npwp'),
        ];

        if ($this->rekananModel->insert($data)) {
            session()->setFlashdata('success', 'Data rekanan berhasil ditambahkan!');
            return redirect()->to('/rekanan');
        }

        session()->setFlashdata('error', 'Gagal menambahkan data rekanan!');
        return redirect()->back()->withInput();
    }

    public function show($id)
    {
        $rekanan = $this->rekananModel->find($id);
        
        if (!$rekanan) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Rekanan tidak ditemukan');
        }

        $data = [
            'title' => 'Detail Rekanan - Sistem Invoice PT Jaya Beton',
            'rekanan' => $rekanan
        ];

        return view('rekanan/show', $data);
    }

    public function edit($id)
    {
        $rekanan = $this->rekananModel->find($id);
        
        if (!$rekanan) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Rekanan tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Rekanan - Sistem Invoice PT Jaya Beton',
            'rekanan' => $rekanan,
            'validation' => \Config\Services::validation()
        ];

        return view('rekanan/edit', $data);
    }

    public function update($id)
    {
        $rekanan = $this->rekananModel->find($id);
        
        if (!$rekanan) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Rekanan tidak ditemukan');
        }

        $rules = [
            'nama_rek' => 'required|min_length[3]',
            'alamat' => 'required|min_length[10]'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $data = [
            'nama_rek' => $this->request->getPost('nama_rek'),
            'alamat' => $this->request->getPost('alamat'),
            'npwp' => $this->request->getPost('npwp'),
        ];

        if ($this->rekananModel->update($id, $data)) {
            session()->setFlashdata('success', 'Data rekanan berhasil diupdate!');
            return redirect()->to('/rekanan');
        }

        session()->setFlashdata('error', 'Gagal mengupdate data rekanan!');
        return redirect()->back()->withInput();
    }

    public function delete($id)
    {
        $rekanan = $this->rekananModel->find($id);
        
        if (!$rekanan) {
            session()->setFlashdata('error', 'Rekanan tidak ditemukan!');
            return redirect()->to('/rekanan');
        }

        if ($this->rekananModel->delete($id)) {
            session()->setFlashdata('success', 'Data rekanan berhasil dihapus!');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus data rekanan!');
        }

        return redirect()->to('/rekanan');
    }
}
