<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TeacherModel;

class Teachers extends BaseController
{
    protected $teacherModel;

    public function __construct()
    {
        $this->teacherModel = new TeacherModel();
    }

    // List Pimpinan
    public function index()
    {
        $data['title'] = 'Kelola Pimpinan Pondok';
        $data['teachers'] = $this->teacherModel->orderBy('order_position', 'ASC')->findAll();
        
        return view('admin/teachers/index', $data);
    }

    // Form Tambah
    public function create()
    {
        $data['title'] = 'Tambah Pimpinan Baru';
        return view('admin/teachers/create', $data);
    }

    // Proses Simpan
    public function store()
    {
        // Validasi
        if (!$this->validate([
            'name'     => 'required|min_length[3]',
            'position' => 'required',
            'photo'    => 'permit_empty|uploaded[photo]|max_size[photo,2048]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png]',
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

        $this->teacherModel->save([
            'name'           => $this->request->getPost('name'),
            'position'       => $this->request->getPost('position'),
            'photo'          => $photoUrl,
            'is_leader'      => 1, // Default tampil di depan
            'order_position' => $this->request->getPost('order_position') ?: 99,
        ]);

        return redirect()->to('admin/teachers')->with('success', 'Data pimpinan berhasil ditambahkan!');
    }

    // Form Edit
    public function edit($id)
    {
        $data['teacher'] = $this->teacherModel->find($id);
        if (!$data['teacher']) {
            return redirect()->to('admin/teachers')->with('error', 'Data tidak ditemukan!');
        }
        
        $data['title'] = 'Edit Pimpinan';
        return view('admin/teachers/edit', $data);
    }

    // Proses Update
    public function update($id)
    {
        $teacher = $this->teacherModel->find($id);
        if (!$teacher) {
            return redirect()->to('admin/teachers')->with('error', 'Data tidak ditemukan!');
        }

        // Validasi
        if (!$this->validate([
            'name'     => 'required|min_length[3]',
            'position' => 'required',
            'photo'    => 'permit_empty|uploaded[photo]|max_size[photo,2048]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $photoUrl = $teacher['photo'];
        
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

        $this->teacherModel->update($id, [
            'name'           => $this->request->getPost('name'),
            'position'       => $this->request->getPost('position'),
            'photo'          => $photoUrl,
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