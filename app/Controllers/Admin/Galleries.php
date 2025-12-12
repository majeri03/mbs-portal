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

        // Ambil parameter filter dari URL
        $search = $this->request->getGet('search');
        $category = $this->request->getGet('category');
        $schoolId = $this->request->getGet('school_id');

        // Query builder
        $builder = $this->galleryModel
            ->select('galleries.*, schools.name as school_name')
            ->join('schools', 'schools.id = galleries.school_id', 'left');

        // Filter berdasarkan sekolah (jika admin sekolah)
        if ($this->mySchoolId) {
            $builder->where('galleries.school_id', $this->mySchoolId);
        }

        // Filter Search (Judul)
        if (!empty($search)) {
            $builder->like('galleries.title', $search);
        }

        // Filter Category
        if (!empty($category)) {
            $builder->where('galleries.category', $category);
        }

        // Filter School (hanya untuk superadmin)
        if (!empty($schoolId) && empty($this->mySchoolId)) {
            $builder->where('galleries.school_id', $schoolId);
        }

        $data['galleries'] = $builder->orderBy('galleries.created_at', 'DESC')->findAll();

        // Data untuk dropdown filter
        $data['schools'] = $this->schoolModel->findAll();
        $data['categories'] = $this->galleryModel
            ->select('category')
            ->distinct()
            ->where('category IS NOT NULL')
            ->where('category !=', '')
            ->orderBy('category', 'ASC')
            ->findColumn('category');

        // Kirim nilai filter ke view
        $data['currentSearch'] = $search;
        $data['currentCategory'] = $category;
        $data['currentSchoolFilter'] = $schoolId;

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
        // Validasi
        $rules = [
            'title'    => 'required|min_length[3]',
            'category' => 'required',
        ];

        // Cek apakah ada file yang diupload
        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $rules['image'] = [
                'rules' => 'max_size[image,2048]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]',
                'errors' => [
                    'max_size' => 'Ukuran foto terlalu besar (Maksimal 2 MB).',
                    'is_image' => 'File yang diupload bukan gambar valid.',
                    'mime_in'  => 'Hanya format JPG, PNG, atau WEBP yang diperbolehkan.'
                ]
            ];
        } else {
            return redirect()->back()->withInput()->with('error', 'Pilih foto galeri terlebih dahulu.');
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Upload & Resize dengan Helper
        $fileName = upload_and_resize_image($file, 'uploads/galleries/', 1200, 85);

        if (!$fileName) {
            log_message('error', 'Gallery upload failed for file: ' . $file->getName());
            return redirect()->back()->withInput()->with('error', 'Gagal upload gambar. Cek log untuk detail.');
        }

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
        if (!$gallery) {
            return redirect()->to('admin/galleries')->with('error', 'Akses ditolak!');
        }

        // Validasi
        $rules = [
            'title'    => 'required|min_length[3]',
            'category' => 'required',
        ];

        // Cek apakah ada file yang diupload
        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $rules['image'] = [
                'rules' => 'max_size[image,2048]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]',
                'errors' => [
                    'max_size' => 'Ukuran foto terlalu besar (Maksimal 2 MB).',
                    'is_image' => 'File yang diupload bukan gambar valid.',
                    'mime_in'  => 'Hanya format JPG, PNG, atau WEBP yang diperbolehkan.'
                ]
            ];
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $imageUrl = $gallery['image_url'];

        // Cek jika ada gambar baru
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Hapus gambar lama
            if (!empty($gallery['image_url']) && file_exists(FCPATH . $gallery['image_url'])) {
                @unlink(FCPATH . $gallery['image_url']);
            }

            // Upload & resize gambar baru dengan Helper
            $fileName = upload_and_resize_image($file, 'uploads/galleries/', 1200, 85);

            if ($fileName) {
                $imageUrl = 'uploads/galleries/' . $fileName;
            } else {
                log_message('error', 'Gallery update failed for ID: ' . $id);
            }
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
            if (!empty($gallery['image_url']) && file_exists(FCPATH . $gallery['image_url'])) {
                @unlink(FCPATH . $gallery['image_url']);
            }
            $this->galleryModel->delete($id);
            return redirect()->to('admin/galleries')->with('success', 'Foto berhasil dihapus!');
        }
        return redirect()->to('admin/galleries')->with('error', 'Gagal menghapus data.');
    }
}
