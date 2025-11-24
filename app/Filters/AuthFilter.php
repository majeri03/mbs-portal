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
        // Cek: Jika session 'logged_in' TIDAK ADA
        if (!session()->get('logged_in')) {
            
            // Coba cek apakah ada Cookie 'mbs_remember'?
            helper('cookie');
            $rememberCookie = get_cookie('mbs_remember');

            if ($rememberCookie) {
                try {
                    // Dekripsi cookie menggunakan key dari .env
                    $encrypter = Services::encrypter();
                    $userId = $encrypter->decrypt(hex2bin($rememberCookie));

                    // Cek apakah ID hasil dekripsi ada di database
                    $userModel = new \App\Models\UserModel();
                    $user = $userModel->find($userId);

                    if ($user && $user['is_active'] == 1) {
                        // SUCCESS! Login-kan user secara otomatis (Restore Session)
                        session()->set([
                            'user_id'    => $user['id'],
                            'username'   => $user['username'],
                            'full_name'  => $user['full_name'],
                            'role'       => $user['role'],
                            'logged_in'  => true,
                        ]);
                        
                        // Biarkan user lanjut masuk (jangan di-redirect ke login)
                        return;
                    }
                } catch (\Exception $e) {
                    // Jika dekripsi gagal (cookie diubah-ubah/rusak), abaikan saja
                }
            }

            // Jika Session kosong DAN Cookie tidak valid/tidak ada -> Tendang ke Login
            return redirect()->to('/admin/login')->with('error', 'Silakan login terlebih dahulu.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada aksi setelah request
    }
}