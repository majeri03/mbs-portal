<?php
namespace Modules\Ma\Controllers;
use App\Models\PostModel;

class News extends BaseMaController
{
    protected $postModel;

    public function __construct() {
        $this->postModel = new PostModel();
    }

    // Halaman Index (Lihat Semua Berita MTs)
    public function index()
    {
        $this->data['title'] = "Kabar Sekolah - " . $this->data['school']['name'];
        
        // Filter hanya berita MTs
        $this->data['news_list'] = $this->postModel->where('school_id', $this->schoolId)
                                                   ->where('is_published', 1)
                                                   ->orderBy('created_at', 'DESC')
                                                   ->paginate(6, 'news'); // 6 per halaman
        $this->data['pager'] = $this->postModel->pager;

        return view('Modules\Ma\Views\news_index', $this->data);
    }

    // Halaman Detail Berita
    public function show($slug)
    {
        $post = $this->postModel->where('slug', $slug)
                                ->where('school_id', $this->schoolId) // Security Check
                                ->first();

        if (!$post) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $this->postModel->update($post['id'], ['views' => $post['views'] + 1]);
        $this->data['title'] = $post['title'];
        $this->data['post'] = $post;
        
        // Berita terkait (Hanya dari MTs juga)
        $this->data['related'] = $this->postModel->where('school_id', $this->schoolId)
                                                 ->where('id !=', $post['id'])
                                                 ->orderBy('created_at', 'DESC')
                                                 ->findAll(3);

        return view('Modules\Ma\Views\news_detail', $this->data);
    }
}