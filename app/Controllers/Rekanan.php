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

        if (!isAdmin()) {
            session()->setFlashdata('alert', [
                'type' => 'error',
                'message' => 'Anda tidak memiliki akses ke halaman ini.'
            ]);
            return redirect()->to('/dashboard');
        }

        $data = [
            'title' => 'Data Rekanan - Sistem Invoice PT Jaya Beton',
            'rekanan' => $this->rekananModel->orderBy('id_rek', 'ASC')->findAll()
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

        log_message('debug', 'Rekanan Store - Data POST: ' . json_encode($this->request->getPost()));


        $db = \Config\Database::connect();
        if (!$db->tableExists('tbl_input_data_rekanan')) {
            log_message('error', 'Rekanan Store - Tabel tbl_input_data_rekanan tidak ditemukan!');
            session()->setFlashdata('error', 'Tabel database tidak ditemukan!');
            return redirect()->back()->withInput();
        }

        $rules = [
            'nama_rek' => 'required|min_length[3]|max_length[255]',
            'alamat' => 'required|min_length[5]|max_length[500]',
            'npwp' => 'permit_empty|min_length[15]|max_length[20]'
        ];

        $messages = [
            'nama_rek' => [
                'required' => 'Nama rekanan harus diisi',
                'min_length' => 'Nama rekanan minimal 3 karakter',
                'max_length' => 'Nama rekanan maksimal 255 karakter'
            ],
            'alamat' => [
                'required' => 'Alamat harus diisi',
                'min_length' => 'Alamat minimal 5 karakter',
                'max_length' => 'Alamat maksimal 500 karakter'
            ],
            'npwp' => [
                'min_length' => 'Format NPWP tidak valid (minimal 15 karakter)',
                'max_length' => 'Format NPWP tidak valid (maksimal 20 karakter)'
            ]
        ];

        if (! $this->validate($rules, $messages)) {
            log_message('debug', 'Rekanan Store - Validasi gagal: ' . json_encode($this->validator->getErrors()));
            session()->setFlashdata('error', 'Data tidak valid, silakan periksa kembali form Anda.');
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $data = [
            'nama_rek' => $this->request->getPost('nama_rek'),
            'alamat' => $this->request->getPost('alamat'),
            'npwp' => $this->request->getPost('npwp') ?: null,
        ];

        log_message('debug', 'Rekanan Store - Data yang akan disimpan: ' . json_encode($data));

        try {
            log_message('debug', 'Rekanan Store - Mencoba insert data ke database...');

            $result = $this->rekananModel->insert($data);

            if ($result) {
                $insertId = $this->rekananModel->getInsertID();
                log_message('debug', 'Rekanan Store - Berhasil insert data dengan ID: ' . $insertId);
                session()->setFlashdata('success', 'Data rekanan berhasil ditambahkan!');
                session()->setFlashdata('trigger_dashboard_update', true);


                log_message('debug', 'Rekanan Store - Melakukan redirect ke /rekanan');
                return redirect()->to('/rekanan')->with('success', 'Data rekanan berhasil ditambahkan!');
            } else {
                $errors = $this->rekananModel->errors();
                log_message('error', 'Rekanan Store - Insert gagal. Errors dari model: ' . json_encode($errors));

                if (empty($errors)) {
                    $errors = ['Terjadi kesalahan saat menyimpan data ke database'];
                }

                session()->setFlashdata('error', 'Gagal menambahkan data rekanan: ' . implode(', ', $errors));
                return redirect()->back()->withInput();
            }
        } catch (\Exception $e) {
            log_message('error', 'Rekanan Store - Exception caught: ' . $e->getMessage());
            log_message('error', 'Rekanan Store - Exception trace: ' . $e->getTraceAsString());

            session()->setFlashdata('error', 'Error sistem: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
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
            session()->setFlashdata('trigger_dashboard_update', true);
        } else {
            session()->setFlashdata('error', 'Gagal menghapus data rekanan!');
        }

        return redirect()->to('/rekanan');
    }
}
