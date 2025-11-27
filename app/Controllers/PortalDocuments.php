<?php

namespace App\Controllers;

use App\Models\DocumentModel;
use App\Models\DocumentCategoryModel;
use App\Models\SettingModel;

class PortalDocuments extends BaseController
{
    protected $documentModel;
    protected $categoryModel;
    protected $settingModel;

    public function __construct()
    {
        $this->documentModel = new DocumentModel();
        $this->categoryModel = new DocumentCategoryModel();
        $this->settingModel  = new SettingModel();
    }

    public function index()
    {
        // 1. Ambil Settingan Site (Agar Header/Footer aman)
        $data['site'] = $this->settingModel->getSettings(null);
        $data['title'] = "Arsip Dokumen Yayasan - " . ($data['site']['site_name'] ?? 'MBS Portal');

        // 2. Ambil Filter
        $keyword = $this->request->getGet('cari');
        $categorySlug = $this->request->getGet('kategori');

        // 3. Query: HANYA DOKUMEN PUSAT (school_id = NULL)
        $builder = $this->documentModel->select('documents.*, document_categories.name as category_name')
                                       ->join('document_categories', 'document_categories.id = documents.category_id', 'left')
                                       ->where('documents.school_id', null) // KUNCI: HANYA PUSAT
                                       ->where('documents.is_public', 1);

        // Filter Kategori
        $activeCategoryName = 'Semua Arsip';
        if ($categorySlug) {
            $category = $this->categoryModel->where('slug', $categorySlug)->first();
            if ($category) {
                $builder->where('documents.category_id', $category['id']);
                $activeCategoryName = $category['name'];
            }
        }

        // Filter Cari
        if ($keyword) {
            $builder->like('documents.title', $keyword);
        }

        $data['documents'] = $builder->orderBy('documents.created_at', 'DESC')->paginate(15, 'documents');
        $data['pager'] = $this->documentModel->pager;
        $data['active_category'] = $activeCategoryName;

        // 4. Ambil Daftar Kategori Pusat (Untuk Sidebar)
        $data['categories'] = $this->categoryModel->where('school_id', null)->findAll();

        return view('portal/documents_index', $data);
    }
}