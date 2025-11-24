<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseAdminController;
use App\Models\PostModel;
use App\Models\SchoolModel;

class Posts extends BaseAdminController
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
        $query = $this->filterBySchool($this->postModel);
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
            // 1. Pindahkan file original dulu
            $thumbnail->move('uploads/posts', $thumbnailName);
            
            // 2. KOMPRESI & RESIZE GAMBAR
            // Path file yang baru diupload
            $filePath = 'uploads/posts/' . $thumbnailName;
            
            // Panggil Service Image
            $image = \Config\Services::image();
            
            $image->withFile($filePath)
                  ->resize(1024, 1024, true, 'width') // Resize proporsional max lebar 1024px
                  ->save($filePath, 80); // Simpan dengan kualitas 80% (Kompresi)
        }

        $slug = url_title($this->request->getPost('title'), '-', true);
        $schoolId = $this->mySchoolId ? $this->mySchoolId : ($this->request->getPost('school_id') ?: null);
        $this->postModel->save([
            'school_id'    => $schoolId,
            'title'        => $this->request->getPost('title'),
            'slug'         => $slug,
            'author'       => $this->request->getPost('author') ?: session()->get('full_name'),
            'content'      => $this->request->getPost('content'),
            'thumbnail'    => $thumbnailName ? 'uploads/posts/' . $thumbnailName : null,
            'is_published' => 1,
        ]);

        return redirect()->to('admin/posts')->with('success', 'Berita berhasil ditambahkan & gambar dikompres!');
    }

    // Halaman Form Edit Berita
    public function edit($id)
    {
        $data['title'] = 'Edit Berita';
        $data['post'] = $this->filterBySchool($this->postModel)->find($id);
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

            $newName = $thumbnail->getRandomName();
            $thumbnail->move('uploads/posts', $newName);
            
            // KOMPRESI GAMBAR BARU
            $filePath = 'uploads/posts/' . $newName;
            \Config\Services::image()
                ->withFile($filePath)
                ->resize(1024, 1024, true, 'width') // Max lebar 1024px
                ->save($filePath, 80); // Kualitas 80%

            $thumbnailName = 'uploads/posts/' . $newName;
        }

        $slug = url_title($this->request->getPost('title'), '-', true);

        $this->postModel->update($id, [
            'school_id' => $this->request->getPost('school_id') ?: null,
            'title'     => $this->request->getPost('title'),
            'slug'      => $slug,
            'author'    => $this->request->getPost('author'),
            'content'   => $this->request->getPost('content'),
            'thumbnail' => $thumbnailName,
        ]);

        return redirect()->to('admin/posts')->with('success', 'Berita berhasil diperbarui!');
    }

    // Hapus Berita
    public function delete($id)
    {
        $post = $this->filterBySchool($this->postModel)->find($id);

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