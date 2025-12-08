<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseAdminController;
use App\Models\TeacherModel;
use App\Models\SchoolModel;

class Teachers extends BaseAdminController
{
    protected $teacherModel;
    protected $schoolModel;
    public function __construct()
    {
        $this->teacherModel = new TeacherModel();
        $this->schoolModel  = new SchoolModel();
    }

    // List Pimpinan
    public function index()
    {
        // Title dinamis berdasarkan role & sekolah
        if ($this->mySchoolId) {
            // Admin Sekolah - Tampilkan nama sekolah
            $school = $this->schoolModel->find($this->mySchoolId);
            $schoolName = $school ? $school['name'] : 'Sekolah';
            $data['title'] = 'Kelola Pimpinan & Guru ' . $schoolName;
            $data['subtitle'] = 'Manajemen struktur organisasi ' . $schoolName;
        } else {
            // Superadmin - Semua sekolah
            $data['title'] = 'Kelola Pimpinan & Guru';
            $data['subtitle'] = 'Manajemen struktur organisasi dan pimpinan semua jenjang';
        }

        // Ambil parameter filter dari URL
        $search = $this->request->getGet('search');
        $position = $this->request->getGet('position');
        $schoolId = $this->request->getGet('school_id');
        $isLeader = $this->request->getGet('is_leader');

        // Query builder
        $query = $this->teacherModel;

        // Filter berdasarkan sekolah (jika admin sekolah)
        if ($this->mySchoolId) {
            $query = $query->where('school_id', $this->mySchoolId);
        }

        // Filter Search (Nama)
        if (!empty($search)) {
            $query = $query->like('name', $search);
        }

        // Filter Jabatan
        if (!empty($position)) {
            $query = $query->like('position', $position);
        }

        // Filter School (hanya untuk superadmin)
        if (!empty($schoolId) && empty($this->mySchoolId)) {
            $query = $query->where('school_id', $schoolId);
        }

        // Filter Status Pimpinan
        if ($isLeader !== null && $isLeader !== '') {
            $query = $query->where('is_leader', $isLeader);
        }

        $data['teachers'] = $query->orderBy('is_leader', 'DESC')
            ->orderBy('order_position', 'ASC')
            ->findAll();

        // Data untuk dropdown filter
        $data['schools'] = $this->schoolModel->findAll();

        // Ambil daftar jabatan unik dari database
        $data['positions'] = $this->teacherModel
            ->select('position')
            ->distinct()
            ->where('position IS NOT NULL')
            ->where('position !=', '')
            ->orderBy('position', 'ASC')
            ->findColumn('position');

        // Kirim nilai filter ke view
        $data['currentSearch'] = $search;
        $data['currentPosition'] = $position;
        $data['currentSchoolFilter'] = $schoolId;
        $data['currentIsLeader'] = $isLeader;

        return view('admin/teachers/index', $data);
    }

    // Form Tambah
    public function create()
    {
        $data['title'] = 'Tambah Pimpinan Baru';
        $data['schools'] = $this->schoolModel->findAll();
        return view('admin/teachers/create', $data);
    }

    // Proses Simpan
    public function store()
    {

        // Validasi
        if (!$this->validate([
            'name'     => 'required|min_length[3]',
            'position' => 'required',
            'photo'    => 'permit_empty|max_size[photo,2048]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png,image/webp]'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Upload Foto
        $photoUrl = 'https://ui-avatars.com/api/?name=' . urlencode($this->request->getPost('name')) . '&background=random&size=512'; // Default Avatar

        $filePhoto = $this->request->getFile('photo');
        if ($filePhoto && $filePhoto->isValid() && !$filePhoto->hasMoved()) {
            $newName = $filePhoto->getRandomName();
            $filePhoto->move('uploads/teachers', $newName);
            $photoUrl = 'uploads/teachers/' . $newName;
        }

        $schoolIdInput = $this->mySchoolId; // Default: Ambil dari sesi login (untuk Admin Sekolah)

        // TAPI, jika yang login Superadmin (mySchoolId kosong), ambil dari input form
        if (empty($schoolIdInput)) {
            $inputPost = $this->request->getPost('school_id');
            // Jika input kosong/pilih "Pusat", set NULL. Jika pilih sekolah, set ID-nya.
            $schoolIdInput = !empty($inputPost) ? $inputPost : null;
        }
        $this->teacherModel->save([
            'school_id'      => $schoolIdInput,
            'name'           => $this->request->getPost('name'),
            'position'       => $this->request->getPost('position'),
            'photo'          => $photoUrl,
            'is_leader'      => $this->request->getPost('is_leader') ? 1 : 0,
            'order_position' => $this->request->getPost('order_position') ?: 99,
        ]);

        return redirect()->to('admin/teachers')->with('success', 'Data pimpinan berhasil ditambahkan!');
    }

    // Form Edit
    public function edit($id)
    {
        $teacher = $this->filterBySchool($this->teacherModel)->find($id);
        $data['teacher'] = $teacher;
        if (!$data['teacher']) {
            return redirect()->to('admin/teachers')->with('error', 'Data tidak ditemukan!');
        }

        $data['title'] = 'Edit Data';
        $data['schools'] = $this->schoolModel->findAll();
        return view('admin/teachers/edit', $data);
    }

    // Proses Update
    public function update($id)
    {
        $exists = $this->filterBySchool($this->teacherModel)->find($id);;
        if (!$exists) {
            return redirect()->to('admin/teachers')->with('error', 'Akses ditolak!');
        }

        // Validasi
        if (!$this->validate([
            'name'     => 'required|min_length[3]',
            'position' => 'required',
            'photo'    => 'permit_empty|uploaded[photo]|max_size[photo,2048]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $photoUrl = $exists['photo'];

        // Cek jika ada upload foto baru
        $filePhoto = $this->request->getFile('photo');
        if ($filePhoto && $filePhoto->isValid() && !$filePhoto->hasMoved()) {
            // Hapus foto lama jika bukan URL eksternal (avatar default)
            if (file_exists($photoUrl) && !str_contains($photoUrl, 'http')) {
                unlink($photoUrl);
            }

            $newName = $filePhoto->getRandomName();
            $filePhoto->move('uploads/teachers', $newName);
            $photoUrl = 'uploads/teachers/' . $newName;
        }

        $schoolIdInput = $this->mySchoolId; // Default: Ambil dari sesi login (untuk Admin Sekolah)

        // TAPI, jika yang login Superadmin (mySchoolId kosong), ambil dari input form
        if (empty($schoolIdInput)) {
            $inputPost = $this->request->getPost('school_id');
            // Jika input kosong/pilih "Pusat", set NULL. Jika pilih sekolah, set ID-nya.
            $schoolIdInput = !empty($inputPost) ? $inputPost : null;
        }
        $this->teacherModel->update($id, [
            'school_id'      => $schoolIdInput,
            'name'           => $this->request->getPost('name'),
            'position'       => $this->request->getPost('position'),
            'photo'          => $photoUrl,
            'is_leader'      => $this->request->getPost('is_leader') ? 1 : 0,
            'order_position' => $this->request->getPost('order_position'),
        ]);

        return redirect()->to('admin/teachers')->with('success', 'Data pimpinan berhasil diperbarui!');
    }

    // Hapus
    public function delete($id)
    {
        $teacher = $this->teacherModel->find($id);
        if (!$teacher) {
            return redirect()->to('admin/teachers')->with('error', 'Data tidak ditemukan!');
        }

        // Hapus file foto jika ada
        if (file_exists($teacher['photo']) && !str_contains($teacher['photo'], 'http')) {
            unlink($teacher['photo']);
        }

        $this->teacherModel->delete($id);
        return redirect()->to('admin/teachers')->with('success', 'Data berhasil dihapus!');
    }
}
