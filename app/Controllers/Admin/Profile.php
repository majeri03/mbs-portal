<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseAdminController;
use App\Models\UserModel;

class Profile extends BaseAdminController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper(['form', 'url']);
    }

    /**
     * Tampilkan halaman edit profil
     */
    public function index()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->to('/admin/dashboard')->with('error', 'User tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit Profil',
            'user' => $user,
            'validation' => \Config\Services::validation()
        ];

        return view('admin/profile/edit', $data);
    }

    /**
     * Update profil user
     */
    public function update()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->to('/admin/dashboard')->with('error', 'User tidak ditemukan.');
        }

        // Validasi Input
        $rules = [
            'full_name' => 'required|min_length[3]|max_length[100]',
            'email' => "required|valid_email|is_unique[users.email,id,{$userId}]",
            'username' => "required|min_length[4]|max_length[50]|is_unique[users.username,id,{$userId}]"
        ];

        // Jika user mengisi password baru, tambahkan validasi password
        if ($this->request->getPost('new_password')) {
            $rules['current_password'] = 'required';
            $rules['new_password'] = 'required|min_length[6]';
            $rules['confirm_password'] = 'required|matches[new_password]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Data yang akan diupdate
        $data = [
            'full_name' => $this->request->getPost('full_name'),
            'email' => $this->request->getPost('email'),
            'username' => $this->request->getPost('username')
        ];

        // Jika user mengisi password baru
        if ($this->request->getPost('new_password')) {
            // Verifikasi password lama
            if (!password_verify($this->request->getPost('current_password'), $user['password'])) {
                return redirect()->back()->withInput()->with('error', 'Password lama tidak sesuai!');
            }

            // Hash password baru
            $data['password'] = password_hash($this->request->getPost('new_password'), PASSWORD_BCRYPT);
        }

        // Update ke database
        try {
            if ($this->userModel->update($userId, $data)) {
                // Update session jika nama berubah
                session()->set('full_name', $data['full_name']);
                session()->set('email', $data['email']);
                session()->set('username', $data['username']);

                return redirect()->to('/admin/profile')->with('success', 'Profil berhasil diupdate!');
            }

            return redirect()->back()->withInput()->with('error', 'Gagal update profil.');
        } catch (\Exception $e) {
            log_message('error', 'Error updating profile: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}