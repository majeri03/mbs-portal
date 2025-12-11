<?php

namespace Modules\Smk\Controllers;

use App\Models\GalleryModel;

class Gallery extends BaseSmkController
{
    protected $galleryModel;

    public function __construct()
    {
        $this->galleryModel = new GalleryModel();
    }

    public function index()
    {
        $this->data['title'] = "Galeri Kegiatan - " . $this->data['school']['name'];

        // Ambil parameter kategori dari URL (opsional, misal: ?kategori=prestasi)
        $category = $this->request->getGet('kategori');

        // Query Dasar: Ambil data milik sekolah ini (MTs)
        $query = $this->galleryModel->where('school_id', $this->schoolId);

        // Filter kategori jika ada
        if ($category && $category != 'semua') {
            $query->where('category', $category);
        }

        // Eksekusi dengan Pagination (12 foto per halaman)
        $this->data['galleries'] = $query->orderBy('created_at', 'DESC')
                                         ->paginate(12, 'gallery');
        
        $this->data['pager'] = $this->galleryModel->pager;
        $this->data['current_category'] = $category ?? 'semua';

        return view('Modules\Smk\Views\gallery_index', $this->data);
    }
}