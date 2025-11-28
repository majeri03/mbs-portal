<?php

namespace App\Controllers;

use App\Models\PageModel;
use App\Models\SettingModel;

class PageController extends BaseController
{
    protected $pageModel;
    protected $settingModel;

    public function __construct()
    {
        $this->pageModel = new PageModel();
        $this->settingModel = new SettingModel();
    }
    public function index()
    {
        $data['site'] = $this->settingModel->getSiteSettings();
        
        // 1. Ambil Parameter Filter dari URL (misal: ?kategori=Fasilitas)
        $filterKategori = $this->request->getGet('kategori');
        
        // 2. Siapkan Query Builder (Halaman Pusat yang Aktif)
        $builder = $this->pageModel->where('school_id', null)
                                   ->where('is_active', 1);

        // 3. Jika ada filter, tambahkan kondisi WHERE
        if (!empty($filterKategori)) {
            $builder->where('menu_title', $filterKategori);
            $data['title'] = 'Informasi: ' . $filterKategori; // Update judul tab
        } else {
            $data['title'] = 'Semua Informasi MBS';
        }

        // Eksekusi Query Ambil Halaman
        $data['all_pages'] = $builder->orderBy('menu_title', 'ASC') // Urutkan per grup dulu
                                     ->orderBy('title', 'ASC')      // Lalu per judul
                                     ->findAll();

        // 4. Ambil Daftar Kategori/Menu yang Ada (Untuk isi Dropdown)
        // Kita gunakan method getExistingMenus yang sudah ada di Model
        $data['categories'] = $this->pageModel->getExistingMenus(null);
        
        // Kirim info filter yang sedang aktif ke view
        $data['active_filter'] = $filterKategori;

        return view('pages/list', $data);
    }
    public function show($slug)
    {
        $page = $this->pageModel->where('slug', $slug)->where('is_active', 1)->first();

        if (!$page) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data['site'] = $this->settingModel->getSiteSettings();
        // Ambil daftar halaman untuk menu dropdown (Global)
        $data['pages_menu'] = $this->pageModel->getActivePages();

        $data['title'] = $page['title'];
        $data['page'] = $page;

        return view('pages/detail', $data);
    }
}
