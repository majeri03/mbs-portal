<?php

namespace App\Controllers;

use App\Models\GalleryModel;
use App\Models\SettingModel;

class GalleryController extends BaseController
{
    protected $galleryModel;
    protected $settingModel;

    public function __construct()
    {
        $this->galleryModel = new GalleryModel();
        $this->settingModel = new SettingModel();
    }

    public function index()
    {
        $data['site'] = $this->settingModel->getSiteSettings();
        $data['title'] = 'Galeri Kegiatan';
        
        // Ambil semua foto, urutkan terbaru
        $data['galleries'] = $this->galleryModel->orderBy('created_at', 'DESC')->findAll();

        return view('gallery/index', $data);
    }
}