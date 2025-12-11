<?php
namespace Modules\Smk\Controllers;
use App\Models\PageModel;

class Page extends BaseSmkController
{
    public function index()
    {
        $this->data['title'] = "Direktori Informasi - " . $this->data['school']['name'];
        $pageModel = new PageModel();

        // 1. Ambil Filter Kategori dari URL
        $filterKategori = $this->request->getGet('kategori');
        $this->data['active_filter'] = $filterKategori;

        // 2. Query Halaman (KHUSUS SEKOLAH INI)
        $builder = $pageModel->where('school_id', $this->schoolId) // <--- KUNCI: Filter ID Sekolah
                             ->where('is_active', 1);

        if (!empty($filterKategori)) {
            $builder->where('menu_title', $filterKategori);
        }

        $this->data['pages_list'] = $builder->orderBy('menu_title', 'ASC')
                                            ->orderBy('title', 'ASC')
                                            ->findAll();

        // 3. Ambil Kategori Menu yang ada di sekolah ini saja
        $this->data['categories'] = $pageModel->getExistingMenus($this->schoolId);

        return view('Modules\Smk\Views\pages_list', $this->data);
    }
    public function show($slug)
    {
        $pageModel = new PageModel();
        
        // Cari halaman berdasarkan slug DAN school_id (agar tidak bisa akses halaman SMK dari link MTs)
        $page = $pageModel->where('slug', $slug)
                          ->where('school_id', $this->schoolId)
                          ->first();

        if (!$page) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $this->data['title'] = $page['title'] . " - " . $this->data['school']['name'];
        $this->data['page'] = $page;

        // Kita pakai view generic atau buat khusus
        return view('Modules\Smk\Views\page_detail', $this->data);
    }
}