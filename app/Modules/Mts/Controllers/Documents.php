<?php

namespace Modules\Mts\Controllers;

use App\Models\DocumentModel;
use App\Models\DocumentCategoryModel;

class Documents extends BaseMtsController
{
    protected $documentModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->documentModel = new DocumentModel();
        $this->categoryModel = new DocumentCategoryModel();
    }

    // Halaman Index (Daftar Dokumen)
    public function index()
    {
        $this->data['title'] = "Pusat Dokumen - " . $this->data['school']['name'];
        
        // Ambil parameter kategori dari URL
        $categorySlug = $this->request->getGet('kategori');
        $keyword = $this->request->getGet('cari');

        // Query Dasar: Dokumen Sekolah Ini ATAU Umum, DAN harus Publik
        $builder = $this->documentModel->select('documents.*, document_categories.name as category_name')
                                       ->join('document_categories', 'document_categories.id = documents.category_id', 'left')
                                       ->groupStart()
                                            ->where('documents.school_id', $this->schoolId)
                                            ->orWhere('documents.school_id', null)
                                       ->groupEnd()
                                       ->where('documents.is_public', 1);

        // Filter Kategori
        $activeCategoryName = 'Semua Dokumen';
        if ($categorySlug) {
            $category = $this->categoryModel->where('slug', $categorySlug)->first();
            if ($category) {
                $builder->where('documents.category_id', $category['id']);
                $activeCategoryName = $category['name'];
            }
        }

        // Filter Pencarian
        if ($keyword) {
            $builder->like('documents.title', $keyword);
        }

        $this->data['documents'] = $builder->orderBy('documents.created_at', 'DESC')->paginate(10, 'documents');
        $this->data['pager'] = $this->documentModel->pager;
        $this->data['active_category'] = $activeCategoryName;
        // --- LOGIKA BARU UNTUK LIVE SEARCH ---
        if ($this->request->isAJAX()) {
            // Jika request datang dari Javascript, kembalikan potongan tabel saja
            return view('Modules\Mts\Views\documents_data', $this->data);
        }
        return view('Modules\Mts\Views\documents_index', $this->data);
    }

}