<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\SettingModel;

class NewsController extends BaseController
{
    protected $postModel;
    protected $settingModel;

    public function __construct()
    {
        $this->postModel = new PostModel();
        $this->settingModel = new SettingModel();
        helper(['text']);
    }

    // Halaman "Lihat Semua" / Arsip Berita
    public function index()
    {
        $data['site'] = $this->settingModel->getSiteSettings();
        $data['title'] = 'Berita & Informasi';
        
        // Ambil kategori dari URL (misal: ?category=prestasi)
        $category = $this->request->getGet('category');

        // Query Dasar
        $builder = $this->postModel->select('posts.*, schools.name as school_name')
                                   ->join('schools', 'schools.id = posts.school_id', 'left')
                                   ->where('is_published', 1);

        // Jika ada filter kategori (kita anggap kategori = slug sekolah atau logic lain)
        // Untuk saat ini kita filter berdasarkan pencarian judul saja atau tampilkan semua
        if ($category) {
            // Logika filter sederhana
            $builder->like('title', $category);
        }

        $data['news_list'] = $builder->orderBy('posts.created_at', 'DESC')->paginate(9);
        $data['pager'] = $this->postModel->pager;

        return view('news/index', $data);
    }

    // Halaman Baca Berita (Detail)
   // Halaman Baca Berita (Detail)
    public function show($slug)
    {
        $post = $this->postModel->select('posts.*, schools.name as school_name, users.full_name as author_name')
                                ->join('schools', 'schools.id = posts.school_id', 'left')
                                ->join('users', 'users.username = posts.author', 'left')
                                ->where('posts.slug', $slug) // <--- PERBAIKAN DISINI (Tambahkan 'posts.')
                                ->first();

        if (!$post) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Tambah View Counter
        $this->postModel->update($post['id'], ['views' => $post['views'] + 1]);

        $data['site'] = $this->settingModel->getSiteSettings();
        $data['title'] = $post['title'];
        $data['post'] = $post;
        
        // Berita terkait (Sidebar)
        $data['related_news'] = $this->postModel->where('id !=', $post['id'])
                                                ->orderBy('created_at', 'DESC')
                                                ->findAll(4);

        return view('news/detail', $data);
    }
}