<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PostModel;
use App\Models\SchoolModel;

class Posts extends BaseController
{
    protected $postModel;
    protected $schoolModel;

    public function __construct()
    {
        $this->postModel = new PostModel();
        $this->schoolModel = new SchoolModel();
    }

    // Halaman List Berita
    public function index()
    {
        $data['title'] = 'Kelola Berita';
        $data['posts'] = $this->postModel->select('posts.*, schools.name as school_name')
                                         ->join('schools', 'schools.id = posts.school_id', 'left')
                                         ->orderBy('posts.created_at', 'DESC')
                                         ->findAll();
        
        return view('admin/posts/index', $data);
    }

    // Halaman Form Tambah Berita
    public function create()
    {
        $data['title'] = 'Tambah Berita Baru';
        $data['schools'] = $this->schoolModel->findAll();
        
        return view('admin/posts/create', $data);
    }

    // Proses Simpan Berita Baru
    public function store()
    {
        $rules = [
            'title'     => 'required|min_length[10]|max_length[255]',
            'content'   => 'required|min_length[50]',
            'thumbnail' => 'uploaded[thumbnail]|max_size[thumbnail,2048]|is_image[thumbnail]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Handle Upload Thumbnail
        $thumbnail = $this->request->getFile('thumbnail');
        $thumbnailName = null;

        if ($thumbnail->isValid() && !$thumbnail->hasMoved()) {
            $thumbnailName = $thumbnail->getRandomName();
            $thumbnail->move('uploads/posts', $thumbnailName);
        }

        // Generate Slug dari Judul
        $slug = url_title($this->request->getPost('title'), '-', true);

        // Simpan ke Database
        $this->postModel->save([
            'school_id'    => $this->request->getPost('school_id') ?: null,
            'title'        => $this->request->getPost('title'),
            'slug'         => $slug,
            'author'       => $this->request->getPost('author') ?: session()->get('full_name'), // AUTO-FILL dari user login
            'content'      => $this->request->getPost('content'),
            'thumbnail'    => $thumbnailName ? 'uploads/posts/' . $thumbnailName : null,
            'is_published' => 1,
        ]);

        return redirect()->to('admin/posts')->with('success', 'Berita berhasil ditambahkan!');
    }

    // Halaman Form Edit Berita
    public function edit($id)
    {
        $data['title'] = 'Edit Berita';
        $data['post'] = $this->postModel->find($id);
        $data['schools'] = $this->schoolModel->findAll();

        if (!$data['post']) {
            return redirect()->to('admin/posts')->with('error', 'Berita tidak ditemukan!');
        }

        return view('admin/posts/edit', $data);
    }

    // Proses Update Berita
    public function update($id)
    {
        $rules = [
            'title'   => 'required|min_length[10]|max_length[255]',
            'content' => 'required|min_length[50]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $post = $this->postModel->find($id);
        $thumbnailName = $post['thumbnail'];

        // Jika ada upload thumbnail baru
        $thumbnail = $this->request->getFile('thumbnail');
        if ($thumbnail && $thumbnail->isValid() && !$thumbnail->hasMoved()) {
            // Hapus thumbnail lama
            if ($post['thumbnail'] && file_exists($post['thumbnail'])) {
                unlink($post['thumbnail']);
            }

            $thumbnailName = $thumbnail->getRandomName();
            $thumbnail->move('uploads/posts', $thumbnailName);
            $thumbnailName = 'uploads/posts/' . $thumbnailName;
        }

        $slug = url_title($this->request->getPost('title'), '-', true);

            $this->postModel->update($id, [
            'school_id' => $this->request->getPost('school_id') ?: null,
            'title'     => $this->request->getPost('title'),
            'slug'      => $slug,
            'author'    => $this->request->getPost('author'), // Bisa diedit manual
            'content'   => $this->request->getPost('content'),
            'thumbnail' => $thumbnailName,
        ]);

        return redirect()->to('admin/posts')->with('success', 'Berita berhasil diperbarui!');
    }

    // Hapus Berita
    public function delete($id)
    {
        $post = $this->postModel->find($id);

        if (!$post) {
            return redirect()->to('admin/posts')->with('error', 'Berita tidak ditemukan!');
        }

        // Hapus file thumbnail
        if ($post['thumbnail'] && file_exists($post['thumbnail'])) {
            unlink($post['thumbnail']);
        }

        $this->postModel->delete($id);

        return redirect()->to('admin/posts')->with('success', 'Berita berhasil dihapus!');
    }
}