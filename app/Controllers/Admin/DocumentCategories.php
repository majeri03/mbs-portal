<?php

namespace App\Controllers\Admin;

use App\Models\DocumentCategoryModel;
use App\Models\SchoolModel;

class DocumentCategories extends BaseAdminController
{
    protected $categoryModel;
    protected $schoolModel;

    public function __construct()
    {
        $this->categoryModel = new DocumentCategoryModel();
        $this->schoolModel   = new SchoolModel();
    }
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // PANGGIL SATPAM
        $this->restrictToAdmin();
    }
    public function index()
    {
        $data['title'] = 'Kategori Dokumen';

        // Filter: Admin Sekolah hanya melihat kategori sekolahnya
        // Superadmin melihat semua (di-join dengan nama sekolah biar jelas)
        $query = $this->filterBySchool($this->categoryModel);

        $data['categories'] = $query->select('document_categories.*, schools.name as school_name')
            ->join('schools', 'schools.id = document_categories.school_id', 'left')
            ->findAll();

        $data['schools'] = $this->schoolModel->findAll(); // Untuk pilihan di modal tambah (bagi superadmin)
        $data['currentSchoolId'] = $this->mySchoolId;

        return view('admin/documents/categories', $data);
    }

    public function store()
    {
        if (!$this->validate(['name' => 'required|min_length[3]'])) {
            return redirect()->back()->with('error', 'Nama kategori wajib diisi minimal 3 karakter.');
        }

        // --- PERBAIKAN LOGIKA SCHOOL ID ---

        // 1. Ambil input dari form (Apapun isinya)
        $inputSchoolId = $this->request->getPost('school_id');

        // 2. Tentukan ID Sekolah final
        if (!empty($this->mySchoolId)) {
            // Jika yang login adalah Admin Sekolah (MTs/MA/SMK), PAKSA pakai ID mereka sendiri
            $schoolId = $this->mySchoolId;
        } else {
            // Jika Superadmin:
            // Cek apakah input ada isinya? Jika kosong string (''), jadikan NULL (Pusat).
            // Jika ada angka ('1', '2'), gunakan angka tersebut.
            $schoolId = ($inputSchoolId === '' || $inputSchoolId === null) ? null : $inputSchoolId;
        }

        $this->categoryModel->save([
            'school_id' => $schoolId,
            'name'      => $this->request->getPost('name'),
            'slug'      => url_title($this->request->getPost('name'), '-', true),
        ]);

        return redirect()->to('admin/document-categories')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function update($id)
    {
        // Pastikan data milik sekolah yang login
        $exists = $this->filterBySchool($this->categoryModel)->find($id);
        if (!$exists) return redirect()->back()->with('error', 'Akses ditolak!');

        $this->categoryModel->update($id, [
            'name' => $this->request->getPost('name'),
            'slug' => url_title($this->request->getPost('name'), '-', true),
        ]);

        return redirect()->to('admin/document-categories')->with('success', 'Kategori diperbarui.');
    }

    public function delete($id)
    {
        $exists = $this->filterBySchool($this->categoryModel)->find($id);
        if ($exists) {
            $this->categoryModel->delete($id);
            return redirect()->to('admin/document-categories')->with('success', 'Kategori dihapus.');
        }
        return redirect()->back()->with('error', 'Gagal menghapus.');
    }
}
