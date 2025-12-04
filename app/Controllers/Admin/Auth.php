<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\SettingModel;
use Config\Services;
class Auth extends BaseController
{
    protected $userModel;
    protected $settingModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->settingModel = new SettingModel();
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
                'school_id'  => $result['school_id'],
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
    // 1. Tampilkan Form Input Email
    public function forgotPassword()
    {
        return view('admin/auth/forgot_password');
    }

    // 2. Proses Kirim Email Token (UPDATE)
    public function attemptForgot()
    {
        $email = $this->request->getPost('email');
        $user = $this->userModel->where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->with('success', 'Permintaan reset diproses. Cek email Anda.');
        }

        // Generate Token
        $token = bin2hex(random_bytes(32));
        $expire = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $this->userModel->update($user['id'], [
            'reset_token' => $token,
            'reset_expire' => $expire
        ]);

        // --- MULAI BAGIAN EMAIL KEREN ---

        // 1. Ambil Data Setting (Logo & Nama Web)
        $settings = $this->settingModel->getSettings(null); // Ambil setting Pusat
        
        // Cek logo, kalau kosong pakai placeholder text/image
        $logoUrl = !empty($settings['site_logo']) ? base_url($settings['site_logo']) : 'https://placehold.co/150x50?text=MBS+Logo';
        $siteName = $settings['site_name'] ?? 'MBS Portal';
        
        // Link Reset
        $link = base_url("admin/reset-password/$token");

        // 2. Template HTML Email (Inline CSS agar kompatibel dengan Gmail)
        $message = "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; background-color: #f9f9f9; padding: 20px;'>
            <div style='background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1);'>
                
                <div style='background-color: #2f3f58; padding: 20px; text-align: center;'>
                    <img src='$logoUrl' alt='$siteName' style='max-height: 60px; object-fit: contain; background: #fff; padding: 5px; border-radius: 5px;'>
                </div>

                <div style='padding: 30px; color: #333333;'>
                    <h2 style='color: #2f3f58; margin-top: 0;'>Atur Ulang Kata Sandi</h2>
                    <p>Halo, <strong>" . esc($user['full_name']) . "</strong>.</p>
                    <p>Kami menerima permintaan untuk mereset password akun Admin Panel Anda di <strong>$siteName</strong>.</p>
                    <p>Silakan klik tombol di bawah ini untuk membuat password baru:</p>
                    
                    <div style='text-align: center; margin: 30px 0;'>
                        <a href='$link' style='background-color: #2f3f58; color: #ffffff; padding: 12px 25px; text-decoration: none; border-radius: 50px; font-weight: bold; font-size: 16px; display: inline-block;'>
                            Reset Password Sekarang
                        </a>
                    </div>

                    <p style='font-size: 13px; color: #666;'>
                        Atau salin link ini ke browser Anda:<br>
                        <a href='$link' style='color: #2f3f58;'>$link</a>
                    </p>
                    
                    <hr style='border: 0; border-top: 1px solid #eee; margin: 20px 0;'>
                    
                    <p style='font-size: 12px; color: #999;'>
                        Link ini akan kadaluarsa dalam 1 jam.<br>
                        Jika Anda tidak merasa meminta reset password, abaikan email ini. Akun Anda tetap aman.
                    </p>
                </div>
                
                <div style='background-color: #f1f1f1; padding: 15px; text-align: center; font-size: 12px; color: #888;'>
                    &copy; " . date('Y') . " $siteName. All Rights Reserved.
                </div>
            </div>
        </div>
        ";

        // Kirim
        $emailService = \Config\Services::email();
        $emailService->setTo($email);
        $emailService->setSubject('Reset Password - ' . $siteName);
        $emailService->setMessage($message);

        if ($emailService->send()) {
            return redirect()->to('/admin/login')->with('success', 'Email reset password telah dikirim. Cek Inbox/Spam.');
        } else {
            return redirect()->back()->with('error', 'Gagal mengirim email. Pastikan konfigurasi SMTP benar.');
        }
    }

    // 3. Tampilkan Form Password Baru (Validasi Token)
    public function resetPassword($token)
    {
        // Cek Token Valid & Belum Expired
        $user = $this->userModel->where('reset_token', $token)
                                ->where('reset_expire >=', date('Y-m-d H:i:s'))
                                ->first();

        if (!$user) {
            return redirect()->to('/admin/login')->with('error', 'Link reset tidak valid atau sudah kadaluarsa.');
        }

        return view('admin/auth/reset_password', ['token' => $token]);
    }

    // 4. Proses Simpan Password Baru
    public function attemptReset()
    {
        $token = $this->request->getPost('token');
        $password = $this->request->getPost('password');
        $confPassword = $this->request->getPost('pass_confirm');

        if ($password !== $confPassword) {
            // [PERBAIKAN] Jangan back(), tapi redirect spesifik ke URL token ini
            return redirect()->to('admin/reset-password/' . $token)
                             ->with('error', 'Konfirmasi password tidak cocok. Silakan ulangi.');
        }

        // Cek Token Lagi (Double Check)
        $user = $this->userModel->where('reset_token', $token)->first();

        if ($user) {
            $this->userModel->update($user['id'], [
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'reset_token' => null, // Hapus token agar tidak bisa dipakai lagi
                'reset_expire' => null,
                'locked_until' => null, // Buka kunci akun jika sebelumnya terkunci
                'login_attempts' => 0
            ]);

            return redirect()->to('/admin/login')->with('success', 'Password berhasil diubah! Silakan login.');
        }

        return redirect()->to('/admin/login')->with('error', 'Terjadi kesalahan. Ulangi proses.');
    }

    // --- FITUR GANTI PASSWORD (LOGGED IN) ---

    // 1. Tampilkan Form Ganti Password
    public function changePassword()
    {
        if (!session()->get('logged_in')) return redirect()->to('admin/login');

        $data['title'] = 'Ganti Password';
        // Kirim data user untuk view (jika perlu)
        $data['user'] = $this->userModel->find(session()->get('user_id'));
        
        return view('admin/auth/change_password', $data);
    }

    // 2. Proses Ganti Password
    public function attemptChangePassword()
    {
        if (!session()->get('logged_in')) return redirect()->to('admin/login');

        $userId = session()->get('user_id');
        $currentPass = $this->request->getPost('current_password');
        $newPass     = $this->request->getPost('new_password');
        $confirmPass = $this->request->getPost('confirm_password');

        // Validasi Input Dasar
        if (!$this->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min_length[6]',
            'confirm_password' => 'required|matches[new_password]'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Ambil Data User dari DB
        $user = $this->userModel->find($userId);

        // Cek 1: Apakah Password Lama Benar?
        if (!password_verify($currentPass, $user['password'])) {
            return redirect()->back()->with('error', 'Password lama yang Anda masukkan salah!');
        }

        // Cek 2: Password Baru tidak boleh sama dengan Password Lama (Opsional, good practice)
        if ($currentPass === $newPass) {
            return redirect()->back()->with('error', 'Password baru tidak boleh sama dengan password lama.');
        }

        // Simpan Password Baru
        $this->userModel->update($userId, [
            'password' => password_hash($newPass, PASSWORD_DEFAULT)
        ]);

        return redirect()->back()->with('success', 'Password berhasil diubah!');
    }
}