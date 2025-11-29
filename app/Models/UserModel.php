<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'school_id',
        'username',
        'email',
        'password',
        'full_name',
        'role',
        'is_active',
        'last_login',
        'last_ip',
        'login_attempts',
        'locked_until'
    ];

    // Fungsi untuk cek login
        public function verifyLogin($username, $password)
    {
        // 1. Cari user berdasarkan username atau email
        $builder = $this->builder();
        $user = $builder->groupStart()
                            ->where('username', $username)
                            ->orWhere('email', $username)
                        ->groupEnd()
                        ->where('is_active', 1)
                        ->get()
                        ->getRowArray();

        // User tidak ditemukan
        if (!$user) {
            return false;
        }

        // 2. Cek apakah akun sedang terkunci
        if (!empty($user['locked_until'])) {
            $lockTime = strtotime($user['locked_until']);
            $currentTime = time();
            
            // Masih dalam masa lock
            if ($lockTime > $currentTime) {
                $remainingMinutes = ceil(($lockTime - $currentTime) / 60);
                return [
                    'error' => "Akun terkunci selama {$remainingMinutes} menit karena terlalu banyak percobaan login gagal."
                ];
            }
            
            // Masa lock sudah habis, reset counter
            $this->db->table($this->table)
                     ->where('id', $user['id'])
                     ->update([
                         'login_attempts' => 0,
                         'locked_until' => null
                     ]);
            
            $user['login_attempts'] = 0;
        }

        // 3. Verifikasi password
        if (password_verify($password, $user['password'])) {
            // ✅ PASSWORD BENAR - Update last login dan reset counter
            $this->db->table($this->table)
                     ->where('id', $user['id'])
                     ->update([
                         'last_login' => date('Y-m-d H:i:s'),
                         'last_ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
                         'login_attempts' => 0,
                         'locked_until' => null
                     ]);
            
            return $user; // Return user data untuk session
        }

        // 4. ❌ PASSWORD SALAH - Tambah login attempts
        $attempts = (int)($user['login_attempts'] ?? 0) + 1;
        
        $updateData = [
            'login_attempts' => $attempts
        ];

        // Jika sudah 5 kali salah, lock akun selama 15 menit
        if ($attempts >= 5) {
            $updateData['locked_until'] = date('Y-m-d H:i:s', strtotime('+15 minutes'));
            
            $this->db->table($this->table)
                     ->where('id', $user['id'])
                     ->update($updateData);
            
            return [
                'error' => 'Akun dikunci selama 15 menit karena 5x percobaan login gagal. Silakan coba lagi nanti.'
            ];
        }
        
        // Update counter (belum sampai 5x)
        $this->db->table($this->table)
                 ->where('id', $user['id'])
                 ->update($updateData);
        
        $remaining = 5 - $attempts;
        return [
            'error' => "Username atau Password salah! Sisa percobaan: {$remaining}x"
        ];
    }
}