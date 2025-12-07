<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseAdminController;
use App\Models\GalleryModel;
use App\Models\SchoolModel;

class Galleries extends BaseAdminController
{
    protected $galleryModel;
    protected $schoolModel;

    public function __construct()
    {
        $this->galleryModel = new GalleryModel();
        $this->schoolModel = new SchoolModel();
    }

    public function index()
    {
        $data['title'] = 'Kelola Galeri Foto';
        $query = $this->filterBySchool($this->galleryModel);
        $data['galleries'] = $this->galleryModel
            ->select('galleries.*, schools.name as school_name')
            ->join('schools', 'schools.id = galleries.school_id', 'left')
            ->orderBy('galleries.created_at', 'DESC')
            ->findAll();

        return view('admin/galleries/index', $data);
    }

    public function create()
    {
        $data['title'] = 'Upload Foto Baru';
        $data['schools'] = $this->schoolModel->findAll();
        $data['currentSchoolId'] = $this->mySchoolId;
        return view('admin/galleries/create', $data);
    }

    public function store()
    {
        // 1. VALIDASI KETAT (1MB MAX)
        $rules = [
            'title'    => 'required|min_length[3]',
            'category' => 'required',
            'image'    => [
                // max_size: 1024 KB = 1 MB
                'rules' => 'uploaded[image]|max_size[image,1024]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]',
                'errors' => [
                    'uploaded' => 'Pilih foto galeri terlebih dahulu.',
                    'max_size' => 'Ukuran foto terlalu besar (Maksimal 1 MB).',
                    'is_image' => 'File yang diupload bukan gambar valid.',
                    'mime_in'  => 'Hanya format JPG, PNG, atau WEBP yang diperbolehkan.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Upload Image
        $file = $this->request->getFile('image');
        $fileName = $file->getRandomName();
        $file->move('uploads/galleries', $fileName);

        // KOMPRESI GAMBAR GALERI
        // Kita set max lebar 1200px agar tetap tajam di layar besar tapi file kecil
        $filePath = 'uploads/galleries/' . $fileName;
        \Config\Services::image()
            ->withFile($filePath)
            ->resize(1200, 1200, true, 'width')
            ->save($filePath, 85); // Kualitas 85% (sedikit lebih tinggi dari berita)
        $schoolId = $this->mySchoolId ? $this->mySchoolId : ($this->request->getPost('school_id') ?: null);
        $this->galleryModel->save([
            'school_id' => $schoolId,
            'title'     => $this->request->getPost('title'),
            'category'  => $this->request->getPost('category'),
            'image_url' => 'uploads/galleries/' . $fileName,
        ]);

        return redirect()->to('admin/galleries')->with('success', 'Foto berhasil diupload & dioptimalkan!');
    }

    public function edit($id)
    {
        $data['gallery'] = $this->filterBySchool($this->galleryModel)->find($id);
        if (!$data['gallery']) {
            return redirect()->to('admin/galleries')->with('error', 'Data tidak ditemukan');
        }

        $data['title'] = 'Edit Foto';
        $data['schools'] = $this->schoolModel->findAll();
        $data['currentSchoolId'] = $this->mySchoolId;
        return view('admin/galleries/edit', $data);
    }

    public function update($id)
    {
        $gallery = $this->filterBySchool($this->galleryModel)->find($id);
        if (!$gallery) return redirect()->to('admin/galleries')->with('error', 'Akses ditolak!');

        // 1. VALIDASI UPDATE (Image Optional/Permit Empty)
        $rules = [
            'title'    => 'required|min_length[3]',
            'category' => 'required',
            'image'    => [
                'rules' => 'permit_empty|max_size[image,1024]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]',
                'errors' => [
                    'max_size' => 'Ukuran foto terlalu besar (Maksimal 1 MB).',
                    'is_image' => 'File yang diupload bukan gambar valid.',
                    'mime_in'  => 'Hanya format JPG, PNG, atau WEBP yang diperbolehkan.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $imageUrl = $gallery['image_url'];
        $file = $this->request->getFile('image');

        // Cek jika ada gambar baru
        if ($file && $file->isValid() && !$file->hasMoved()) {
            if (file_exists($gallery['image_url'])) {
                unlink($gallery['image_url']);
            }
            $fileName = $file->getRandomName();
            $file->move('uploads/galleries', $fileName);

            // KOMPRESI GAMBAR BARU
            $filePath = 'uploads/galleries/' . $fileName;
            \Config\Services::image()
                ->withFile($filePath)
                ->resize(1200, 1200, true, 'width')
                ->save($filePath, 85);

            $imageUrl = 'uploads/galleries/' . $fileName;
        }
        $schoolId = $this->mySchoolId ? $this->mySchoolId : ($this->request->getPost('school_id') ?: null);
        $this->galleryModel->update($id, [
            'school_id' => $schoolId,
            'title'     => $this->request->getPost('title'),
            'category'  => $this->request->getPost('category'),
            'image_url' => $imageUrl,
        ]);

        return redirect()->to('admin/galleries')->with('success', 'Data galeri berhasil diperbarui!');
    }

    public function delete($id)
    {
        $gallery = $this->filterBySchool($this->galleryModel)->find($id);
        if ($gallery) {
            if (file_exists($gallery['image_url'])) {
                unlink($gallery['image_url']);
            }
            $this->galleryModel->delete($id);
            return redirect()->to('admin/galleries')->with('success', 'Foto berhasil dihapus!');
        }
        return redirect()->to('admin/galleries')->with('error', 'Gagal menghapus data.');
    }
}
