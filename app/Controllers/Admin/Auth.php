<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper('form'); // Helper untuk form validation
    }

    // Halaman Login
    public function login()
    {
        // Jika sudah login, langsung ke dashboard
        if (session()->get('logged_in')) {
            return redirect()->to('/admin/dashboard');
        }

        return view('admin/auth/login');
    }

    // Proses Login
        public function attemptLogin()
    {
        $rules = [
            'username' => 'required',
            'password' => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $this->userModel->verifyLogin($username, $password);

        // === BAGIAN YANG DITAMBAHKAN (CEK ERROR AKUN TERKUNCI) ===
        if (is_array($user) && isset($user['error'])) {
            // Jika ada pesan error dari Model (misal: akun terkunci)
            return redirect()->back()->withInput()->with('error', $user['error']);
        }
        // === AKHIR PENAMBAHAN ===

        if ($user) {
            // Simpan data user ke session
            session()->set([
                'user_id'    => $user['id'],
                'username'   => $user['username'],
                'full_name'  => $user['full_name'],
                'role'       => $user['role'],
                'logged_in'  => true,
            ]);

            return redirect()->to('/admin/dashboard')->with('success', 'Selamat datang, ' . esc($user['full_name']) . '!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Username atau Password salah!');
        }
    }

    // Logout
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/admin/login')->with('success', 'Anda telah logout.');
    }
}