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
            'validation' => $this->validation
        ];

        return view('rekanan/create', $data);
    }

    public function store()
    {
        $rules = [
            'nama_rekanan' => 'required|min_length[3]',
            'alamat' => 'required|min_length[10]',
            'email' => 'permit_empty|valid_email',
            'telepon' => 'permit_empty|min_length[10]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $data = [
            'kode_rekanan' => $this->request->getPost('kode_rekanan'),
            'nama_rekanan' => $this->request->getPost('nama_rekanan'),
            'alamat' => $this->request->getPost('alamat'),
            'npwp' => $this->request->getPost('npwp'),
            'telepon' => $this->request->getPost('telepon'),
            'email' => $this->request->getPost('email'),
            'contact_person' => $this->request->getPost('contact_person')
        ];

        if ($this->rekananModel->insert($data)) {
            $this->setAlert('success', 'Data rekanan berhasil ditambahkan!');
            return redirect()->to('/rekanan');
        }

        $this->setAlert('error', 'Gagal menambahkan data rekanan!');
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
            'validation' => $this->validation
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
            'nama_rekanan' => 'required|min_length[3]',
            'alamat' => 'required|min_length[10]',
            'email' => 'permit_empty|valid_email',
            'telepon' => 'permit_empty|min_length[10]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $data = [
            'kode_rekanan' => $this->request->getPost('kode_rekanan'),
            'nama_rekanan' => $this->request->getPost('nama_rekanan'),
            'alamat' => $this->request->getPost('alamat'),
            'npwp' => $this->request->getPost('npwp'),
            'telepon' => $this->request->getPost('telepon'),
            'email' => $this->request->getPost('email'),
            'contact_person' => $this->request->getPost('contact_person')
        ];

        if ($this->rekananModel->update($id, $data)) {
            $this->setAlert('success', 'Data rekanan berhasil diupdate!');
            return redirect()->to('/rekanan');
        }

        $this->setAlert('error', 'Gagal mengupdate data rekanan!');
        return redirect()->back()->withInput();
    }

    public function delete($id)
    {
        $rekanan = $this->rekananModel->find($id);
        
        if (!$rekanan) {
            $this->setAlert('error', 'Rekanan tidak ditemukan!');
            return redirect()->to('/rekanan');
        }

        // Soft delete
        if ($this->rekananModel->update($id, ['is_active' => 0])) {
            $this->setAlert('success', 'Data rekanan berhasil dihapus!');
        } else {
            $this->setAlert('error', 'Gagal menghapus data rekanan!');
        }

        return redirect()->to('/rekanan');
    }
}
