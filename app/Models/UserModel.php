<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['username', 'email', 'password', 'full_name', 'role', 'is_active', 'last_login'];
    protected $useTimestamps    = true;

    // Fungsi untuk cek login
        public function verifyLogin($username, $password)
    {
        $user = $this->where('username', $username)
                     ->orWhere('email', $username)
                     ->where('is_active', 1)
                     ->first();

        if (!$user) {
            return false;
        }

        // CEK: Apakah akun terkunci?
        if ($user['locked_until'] && strtotime($user['locked_until']) > time()) {
            return ['error' => 'Akun terkunci sampai ' . date('H:i', strtotime($user['locked_until']))];
        }

        // Verifikasi Password
        if (password_verify($password, $user['password'])) {
            // Reset login attempts & update last login + IP
            $this->update($user['id'], [
                'last_login' => date('Y-m-d H:i:s'),
                'last_ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
                'login_attempts' => 0, // Reset counter
                'locked_until' => null
            ]);
            return $user;
        }

        // Password Salah: Tambah counter
        $attempts = $user['login_attempts'] + 1;
        $updateData = ['login_attempts' => $attempts];

        // Jika 5x salah, lock 15 menit
        if ($attempts >= 5) {
            $updateData['locked_until'] = date('Y-m-d H:i:s', strtotime('+15 minutes'));
        }

        $this->update($user['id'], $updateData);
        return false;
    }
}