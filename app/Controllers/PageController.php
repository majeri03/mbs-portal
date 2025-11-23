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