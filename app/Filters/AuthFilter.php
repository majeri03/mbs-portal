<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Services;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $userModel = new \App\Models\UserModel();

        // ============================================================
        // BAGIAN 1: CEK KEAMANAN UNTUK USER YANG SUDAH LOGIN (ACTIVE SESSION)
        // ============================================================
        if ($session->get('logged_in')) {
            $userId = $session->get('user_id');
            $user = $userModel->find($userId);

            // Cek A: Apakah user dihapus atau dibanned?
            if (!$user || $user['is_active'] != 1) {
                $this->forceLogout('Akun tidak ditemukan atau dinonaktifkan.');
                return redirect()->to('/admin/login');
            }

            // Cek B: Apakah Password Berubah? (Force Logout jika ganti password)
            if ($session->get('auth_password') !== $user['password']) {
                $this->forceLogout('Password telah diubah. Silakan login ulang.');
                return redirect()->to('/admin/login');
            }

            // Cek C: Apakah Token Remember Me Valid? (Force Logout jika token dihapus/reset)
            $sessionToken = $session->get('auth_token');
            if (!empty($sessionToken)) {
                // Jika session punya token, tapi di DB tokennya beda/hilang -> Logout
                if (!hash_equals((string)$user['remember_token'], (string)$sessionToken)) {
                    $this->forceLogout('Sesi login tidak valid (Token kadaluarsa).');
                    return redirect()->to('/admin/login');
                }
            }

            return; // Lanjut, user aman
        }

        // ============================================================
        // BAGIAN 2: LOGIN OTOMATIS VIA COOKIE (REMEMBER ME)
        // ============================================================
        helper('cookie');
        $rememberCookie = get_cookie('mbs_remember');

        if ($rememberCookie) {
            try {
                $encrypter = Services::encrypter();
                $decryptedString = $encrypter->decrypt(hex2bin($rememberCookie));
                $parts = explode(':', $decryptedString, 2);

                if (count($parts) === 2) {
                    $userId = $parts[0];
                    $token  = $parts[1];

                    $user = $userModel->find($userId);

                    // Cek Token DB vs Cookie
                    if ($user && $user['is_active'] == 1 && hash_equals((string)$user['remember_token'], (string)$token)) {

                        // RESTORE SESSION (Lengkap dengan data keamanan)
                        session()->set([
                            'user_id'       => $user['id'],
                            'username'      => $user['username'],
                            'full_name'     => $user['full_name'],
                            'role'          => $user['role'],
                            'school_id'     => $user['school_id'],
                            'logged_in'     => true,
                            'auth_password' => $user['password'], // Simpan password hash
                            'auth_token'    => $token             // Simpan token
                        ]);

                        return; // Login sukses
                    }
                }
            } catch (\Exception $e) {
                // Abaikan jika cookie rusak/palsu
            }
        }

        // Jika tidak ada session & tidak ada cookie valid -> Tendang ke Login
        return redirect()->to('/admin/login')->with('error', 'Silakan login terlebih dahulu.');
    }

    // Helper Logout Bersih (Tambahkan fungsi ini di dalam class AuthFilter)
    private function forceLogout($msg)
    {
        session()->destroy();
        helper('cookie');
        delete_cookie('mbs_remember');
        session()->start(); // Start session baru untuk flashdata
        session()->setFlashdata('error', $msg);
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada aksi setelah request
    }
}
