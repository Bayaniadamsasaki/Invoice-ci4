<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;
    protected $validation;
    protected $session;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
    }

    protected function isLoggedIn(): bool
    {
        return session()->get('isLoggedIn') === true;
    }

    protected function setAlert(string $type, string $message): void
    {
        $this->session->setFlashdata('alert', [
            'type' => $type,
            'message' => $message
        ]);
    }

    public function index()
    {
        if ($this->isLoggedIn()) {
            return redirect()->to('/dashboard');
        }
        
        return $this->login();
    }

    public function login()
    {
        if ($this->isLoggedIn()) {
            return redirect()->to('/dashboard');
        }

        $data = [
            'title' => 'Login - Sistem Invoice PT Jaya Beton',
            'validation' => $this->validation
        ];

        return view('auth/login', $data);
    }

    public function attemptLogin()
    {
        $rules = [
            'username' => 'required|min_length[3]',
            'password' => 'required|min_length[6]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $this->userModel->where('username', $username)
                                ->first();

        if ($user && password_verify($password, $user['password'])) {
            $sessionData = [
                'userId' => $user['id'],
                'username' => $user['username'],
                'fullName' => $user['username'],
                'role' => $user['role'],
                'isLoggedIn' => true,
                'userData' => $user
            ];

            $this->session->set($sessionData);
            
            // Update last login
            $this->userModel->update($user['id'], ['updated_at' => date('Y-m-d H:i:s')]);

            $this->setAlert('success', 'Login berhasil! Selamat datang ' . $user['username']);
            return redirect()->to('/dashboard');
        }

        $this->setAlert('error', 'Username atau password salah!');
        return redirect()->back()->withInput();
    }

    public function register()
    {
        $data = [
            'title' => 'Register - Sistem Invoice PT Jaya Beton',
            'validation' => $this->validation
        ];

        return view('auth/register', $data);
    }

    public function attemptRegister()
    {
        $rules = [
            'username' => 'required|min_length[3]|is_unique[users.username]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'full_name' => 'required|min_length[3]',
            'password' => 'required|min_length[6]',
            'password_confirm' => 'required|matches[password]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'full_name' => $this->request->getPost('full_name'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => 'user'
        ];

        if ($this->userModel->insert($data)) {
            $this->setAlert('success', 'Registrasi berhasil! Silakan login.');
            return redirect()->to('/auth/login');
        }

        $this->setAlert('error', 'Registrasi gagal! Silakan coba lagi.');
        return redirect()->back()->withInput();
    }

    public function logout()
    {
        $this->session->destroy();
        $this->setAlert('success', 'Logout berhasil!');
        return redirect()->to('/auth/login');
    }
}
