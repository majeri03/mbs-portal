<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PageModel;

class Pages extends BaseController
{
    protected $pageModel;

    public function __construct()
    {
        $this->pageModel = new PageModel();
    }

    public function index()
    {
        $data['title'] = 'Kelola Halaman Statis';
        $data['pages'] = $this->pageModel->findAll();
        return view('admin/pages/index', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Halaman Baru';
        return view('admin/pages/create', $data);
    }

    public function store()
    {
        if (!$this->validate([
            'title'   => 'required|min_length[3]',
            'content' => 'required'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $title = $this->request->getPost('title');
        $slug = url_title($title, '-', true);

        $this->pageModel->save([
            'title'     => $title,
            'slug'      => $slug,
            'content'   => $this->request->getPost('content'),
            'is_active' => 1
        ]);

        return redirect()->to('admin/pages')->with('success', 'Halaman berhasil dibuat!');
    }

    public function edit($id)
    {
        $data['page'] = $this->pageModel->find($id);
        $data['title'] = 'Edit Halaman';
        return view('admin/pages/edit', $data);
    }

    public function update($id)
    {
        if (!$this->validate([
            'title'   => 'required|min_length[3]',
            'content' => 'required'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->pageModel->update($id, [
            'title'   => $this->request->getPost('title'),
            'content' => $this->request->getPost('content'),
        ]);

        return redirect()->to('admin/pages')->with('success', 'Halaman berhasil diperbarui!');
    }

    public function delete($id)
    {
        $this->pageModel->delete($id);
        return redirect()->to('admin/pages')->with('success', 'Halaman dihapus!');
    }
}