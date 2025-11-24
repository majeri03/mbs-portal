<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use Config\Services;
class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper(['form', 'cookie']);
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
        $remember = $this->request->getPost('remember');
        $result = $this->userModel->verifyLogin($username, $password);

        // CEK: Apakah return berupa array error (akun terkunci atau password salah dengan info)
        if (is_array($result) && isset($result['error'])) {
            return redirect()->back()->withInput()->with('error', $result['error']);
        }

        // CEK: Apakah login berhasil (return berupa array user data)
        if ($result) {
            // Simpan data user ke session
            session()->set([
                'user_id'    => $result['id'],
                'username'   => $result['username'],
                'full_name'  => $result['full_name'],
                'role'       => $result['role'],
                'logged_in'  => true,
            ]);
            if ($remember) {
                // Ambil service encrypter (otomatis pakai key dari .env)
                $encrypter = Services::encrypter();
                
                // Enkripsi ID User
                $encryptedId = bin2hex($encrypter->encrypt($result['id']));
                
                // Simpan ke Cookie 'mbs_remember' selama 30 hari
                set_cookie('mbs_remember', $encryptedId, 30 * 24 * 60 * 60);
            }
            return redirect()->to('/admin/dashboard')->with('success', 'Selamat datang, ' . esc($result['full_name']) . '!');
        }

        // Default error (seharusnya tidak sampai sini)
        return redirect()->back()->withInput()->with('error', 'Username atau Password salah!');
    }

    // Logout
    public function logout()
    {
        delete_cookie('mbs_remember');
        session()->destroy();
        return redirect()->to('/admin/login')->with('success', 'Anda telah logout.');
    }
}