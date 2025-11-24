<?php
namespace Modules\Mts\Controllers;
use App\Models\PageModel;

class Page extends BaseMtsController
{
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
        return view('Modules\Mts\Views\page_detail', $this->data);
    }
}