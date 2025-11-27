<?php

namespace App\Controllers\Admin;

use App\Models\DocumentModel;
use App\Models\DocumentCategoryModel;
use App\Models\SchoolModel;

class Documents extends BaseAdminController
{
    protected $documentModel;
    protected $categoryModel;
    protected $schoolModel;

    public function __construct()
    {
        $this->documentModel = new DocumentModel();
        $this->categoryModel = new DocumentCategoryModel();
        $this->schoolModel   = new SchoolModel();
    }

    // List Semua Dokumen
    // List Semua Dokumen
    public function index()
    {
        $data['title'] = 'Kelola Dokumen & Unduhan';
        
        // 1. Ambil Input Filter dari URL (GET request)
        $keyword = $this->request->getGet('keyword');
        $categoryId = $this->request->getGet('category_id');

        // 2. Query Dasar (Join Kategori & Sekolah)
        $builder = $this->documentModel->select('documents.*, document_categories.name as category_name, schools.name as school_name')
                                       ->join('document_categories', 'document_categories.id = documents.category_id', 'left')
                                       ->join('schools', 'schools.id = documents.school_id', 'left');

        // Filter Sekolah (Wajib: Sesuai Login)
        if ($this->mySchoolId) {
            $builder->where('documents.school_id', $this->mySchoolId);
        }

        // Filter Pencarian Judul
        if ($keyword) {
            $builder->like('documents.title', $keyword);
        }

        // Filter Dropdown Kategori
        if ($categoryId) {
            $builder->where('documents.category_id', $categoryId);
        }

        // Eksekusi Query
        $data['documents'] = $builder->orderBy('documents.created_at', 'DESC')->findAll();

        // 3. Ambil Daftar Kategori (Untuk Dropdown Filter)
        // Gunakan filterBySchool agar admin MTs cuma liat kategori MTs
        $data['categories'] = $this->filterBySchool($this->categoryModel)->findAll();

        return view('admin/documents/index', $data);
    }

    // Form Tambah
    public function create()
    {
        $data['title'] = 'Upload Dokumen Baru';
        
        // Ambil kategori yang sesuai dengan sekolah user
        // Admin MTs cuma liat kategori MTs + Kategori Umum (jika perlu)
        $data['categories'] = $this->filterBySchool($this->categoryModel)->findAll();
        
        $data['schools'] = $this->schoolModel->findAll();
        $data['currentSchoolId'] = $this->mySchoolId;

        return view('admin/documents/create', $data);
    }

    // Proses Simpan
    public function store()
    {
        // Validasi
        if (!$this->validate([
            'title'        => 'required|min_length[3]',
            'category_id'  => 'required',
            'external_url' => 'required|valid_url', // Wajib URL valid
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $schoolId = $this->mySchoolId ? $this->mySchoolId : ($this->request->getPost('school_id') ?: null);
        
        // Auto Detect File Type dari URL (Sederhana)
        $url = $this->request->getPost('external_url');
        $type = 'link'; // Default
        if (strpos($url, 'drive.google.com') !== false) $type = 'gdrive';
        elseif (strpos($url, '.pdf') !== false) $type = 'pdf';
        elseif (strpos($url, '.doc') !== false) $type = 'word';
        elseif (strpos($url, '.xls') !== false) $type = 'excel';

        $this->documentModel->save([
            'school_id'    => $schoolId,
            'category_id'  => $this->request->getPost('category_id'),
            'title'        => $this->request->getPost('title'),
            'slug'         => url_title($this->request->getPost('title'), '-', true) . '-' . time(),
            'description'  => $this->request->getPost('description'),
            'external_url' => $url,
            'file_type'    => $type,
            'is_public'    => $this->request->getPost('is_public') ? 1 : 0,
            'created_by'   => session('user_id')
        ]);

        return redirect()->to('admin/documents')->with('success', 'Dokumen berhasil dipublikasikan!');
    }

    // Form Edit
    public function edit($id)
    {
        $doc = $this->documentModel->find($id);
        
        // Cek kepemilikan data
        if (!$doc || ($this->mySchoolId && $doc['school_id'] != $this->mySchoolId)) {
            return redirect()->to('admin/documents')->with('error', 'Dokumen tidak ditemukan atau akses ditolak.');
        }

        $data['document'] = $doc;
        $data['categories'] = $this->categoryModel->where('school_id', $doc['school_id'])->orWhere('school_id', null)->findAll();
        $data['schools'] = $this->schoolModel->findAll();
        $data['currentSchoolId'] = $this->mySchoolId;
        $data['title'] = 'Edit Dokumen';

        return view('admin/documents/edit', $data);
    }

    // Proses Update
    public function update($id)
    {
        $doc = $this->documentModel->find($id);
        if (!$doc || ($this->mySchoolId && $doc['school_id'] != $this->mySchoolId)) {
            return redirect()->to('admin/documents');
        }

        if (!$this->validate([
            'title' => 'required',
            'external_url' => 'required|valid_url'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Update Logic
        $this->documentModel->update($id, [
            'category_id'  => $this->request->getPost('category_id'),
            'title'        => $this->request->getPost('title'),
            'description'  => $this->request->getPost('description'),
            'external_url' => $this->request->getPost('external_url'),
            'is_public'    => $this->request->getPost('is_public') ? 1 : 0,
        ]);

        return redirect()->to('admin/documents')->with('success', 'Dokumen diperbarui.');
    }

    // Hapus
    public function delete($id)
    {
        $doc = $this->documentModel->find($id);
        if ($doc && (!$this->mySchoolId || $doc['school_id'] == $this->mySchoolId)) {
            $this->documentModel->delete($id);
            return redirect()->to('admin/documents')->with('success', 'Dokumen dihapus.');
        }
        return redirect()->to('admin/documents')->with('error', 'Gagal menghapus.');
    }
}