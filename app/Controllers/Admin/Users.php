<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseAdminController;
use App\Models\UserModel;
use App\Models\SchoolModel;

class Users extends BaseAdminController
{
    protected $userModel;
    protected $schoolModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->schoolModel = new SchoolModel();
    }

    public function index()
    {
        $data['title'] = 'Kelola Pengguna';

        // 1. Filter Data Sesuai Hak Akses
        // Fungsi filterBySchool() dari BaseAdminController otomatis membatasi Admin Sekolah
        // agar hanya melihat user di sekolahnya sendiri.
        $query = $this->filterBySchool($this->userModel);

        // 2. Ambil data + Nama Sekolah (Join)
        $data['users'] = $query->select('users.*, schools.name as school_name')
            ->join('schools', 'schools.id = users.school_id', 'left')
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('admin/users/index', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah User Baru';
        $data['schools'] = $this->schoolModel->findAll();

        // Kirim ID sekolah saya (jika saya admin sekolah) ke View
        // Agar View tahu harus menyembunyikan dropdown sekolah atau tidak
        $data['mySchoolId'] = $this->mySchoolId;

        return view('admin/users/create', $data);
    }

    public function store()
    {
        // 1. Validasi Input
        if (!$this->validate([
            'username' => 'required|min_length[4]|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'full_name' => 'required|min_length[3]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 2. LOGIKA PENENTUAN SEKOLAH & ROLE
        $schoolId = null;
        $role = $this->request->getPost('role');

        if ($this->mySchoolId) {
            // === JIKA SAYA ADMIN SEKOLAH ===
            // A. Sekolah otomatis dikunci ke sekolah saya
            $schoolId = $this->mySchoolId;

            // B. Role dipaksa jadi 'guru' (Demi keamanan, Admin tidak boleh bikin Admin lain)
            $role = 'guru';
        } else {
            // === JIKA SAYA SUPERADMIN ===
            // A. Ambil sekolah dari input (bisa NULL untuk user Pusat)
            $inputSchool = $this->request->getPost('school_id');
            $schoolId = !empty($inputSchool) ? $inputSchool : null;

            // B. Role bebas sesuai input
            $role = $this->request->getPost('role');
            if ($schoolId !== null && $role === 'superadmin') {
                // Paksa turunkan jadi Admin biasa jika user memaksa
                $role = 'admin';
            }
        }

        // 3. Simpan ke Database
        $this->userModel->save([
            'username'  => $this->request->getPost('username'),
            'email'     => $this->request->getPost('email'),
            'password'  => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'full_name' => $this->request->getPost('full_name'),
            'role'      => $role,
            'school_id' => $schoolId,
            'is_active' => 1
        ]);

        return redirect()->to('admin/users')->with('success', 'User berhasil ditambahkan!');
    }

    public function edit($id)
    {
        // Pastikan hanya bisa edit user milik sekolah sendiri
        $user = $this->filterBySchool($this->userModel)->find($id);

        if (!$user) {
            return redirect()->to('admin/users')->with('error', 'User tidak ditemukan atau akses ditolak.');
        }

        $data['title'] = 'Edit User';
        $data['user']  = $user;
        $data['schools'] = $this->schoolModel->findAll();
        $data['mySchoolId'] = $this->mySchoolId;

        return view('admin/users/edit', $data);
    }

    public function update($id)
    {
        // Cek Exist & Akses
        $user = $this->filterBySchool($this->userModel)->find($id);
        if (!$user) return redirect()->to('admin/users');

        // Validasi (Username & Email unique kecuali punya sendiri)
        if (!$this->validate([
            'username' => "required|min_length[4]|is_unique[users.username,id,{$id}]",
            'email'    => "required|valid_email|is_unique[users.email,id,{$id}]",
            'full_name' => 'required|min_length[3]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Siapkan Data Update
        $updateData = [
            'username'  => $this->request->getPost('username'),
            'email'     => $this->request->getPost('email'),
            'full_name' => $this->request->getPost('full_name'),
            'is_active' => $this->request->getPost('is_active')
        ];

        // Cek Password (Hanya update jika diisi)
        $newPass = $this->request->getPost('password');
        if (!empty($newPass)) {
            $updateData['password'] = password_hash($newPass, PASSWORD_DEFAULT);
        }

        // LOGIKA UPDATE ROLE & SEKOLAH
        // Hanya Superadmin yang boleh ganti Role & Sekolah user
        if (empty($this->mySchoolId)) {

            // 1. Ambil Input Sekolah
            $inputSchool = $this->request->getPost('school_id');
            // Jika kosong string (''), jadikan NULL (Pusat)
            $schoolId = ($inputSchool === '' || $inputSchool === null) ? null : $inputSchool;

            // 2. Ambil Input Role
            $role = $this->request->getPost('role');

            // 3. VALIDASI KEAMANAN:
            // Jika Sekolah dipilih (bukan Pusat), DILARANG pilih Superadmin
            if ($schoolId !== null && $role === 'superadmin') {
                // Kita paksa turunkan jadi Admin biasa
                $role = 'admin';
            }

            // Masukkan ke array update
            $updateData['school_id'] = $schoolId;
            $updateData['role'] = $role;
        }

        $this->userModel->update($id, $updateData);

        return redirect()->to('admin/users')->with('success', 'Data user diperbarui!');
    }

    public function delete($id)
    {
        $user = $this->filterBySchool($this->userModel)->find($id);

        if ($user) {
            // Cegah hapus diri sendiri
            if ($user['id'] == session('user_id')) {
                return redirect()->to('admin/users')->with('error', 'Tidak bisa menghapus akun sendiri!');
            }

            $this->userModel->delete($id);
            return redirect()->to('admin/users')->with('success', 'User dihapus.');
        }

        return redirect()->to('admin/users')->with('error', 'Gagal menghapus.');
    }
}
