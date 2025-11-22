<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AnnouncementModel;

class Announcements extends BaseController
{
    protected $announcementModel;

    public function __construct()
    {
        $this->announcementModel = new AnnouncementModel();
    }

    // List Pengumuman
    public function index()
    {
        $data['title'] = 'Kelola Pengumuman';
        $data['announcements'] = $this->announcementModel->orderBy('priority', 'ASC')->findAll();
        
        return view('admin/announcements/index', $data);
    }

    // Form Tambah
    public function create()
    {
        $data['title'] = 'Tambah Pengumuman Baru';
        return view('admin/announcements/create', $data);
    }

    // Proses Simpan
    public function store()
    {
        $rules = [
            'title'      => 'required|min_length[5]',
            'content'    => 'required|min_length[10]',
            'start_date' => 'required|valid_date',
            'end_date'   => 'required|valid_date',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->announcementModel->save([
            'title'      => $this->request->getPost('title'),
            'content'    => $this->request->getPost('content'),
            'category'   => $this->request->getPost('category'),
            'start_date' => $this->request->getPost('start_date'),
            'end_date'   => $this->request->getPost('end_date'),
            'is_active'  => $this->request->getPost('is_active') ? 1 : 0,
            'priority'   => $this->request->getPost('priority') ?: 0,
            'icon'       => $this->request->getPost('icon') ?: 'bi-megaphone-fill',
            'created_by' => session()->get('user_id'),
        ]);

        return redirect()->to('admin/announcements')->with('success', 'Pengumuman berhasil ditambahkan!');
    }

    // Form Edit
    public function edit($id)
    {
        $data['title'] = 'Edit Pengumuman';
        $data['announcement'] = $this->announcementModel->find($id);

        if (!$data['announcement']) {
            return redirect()->to('admin/announcements')->with('error', 'Pengumuman tidak ditemukan!');
        }

        return view('admin/announcements/edit', $data);
    }

    // Proses Update
    public function update($id)
    {
        $rules = [
            'title'      => 'required|min_length[5]',
            'content'    => 'required|min_length[10]',
            'start_date' => 'required|valid_date',
            'end_date'   => 'required|valid_date',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->announcementModel->update($id, [
            'title'      => $this->request->getPost('title'),
            'content'    => $this->request->getPost('content'),
            'category'   => $this->request->getPost('category'),
            'start_date' => $this->request->getPost('start_date'),
            'end_date'   => $this->request->getPost('end_date'),
            'is_active'  => $this->request->getPost('is_active') ? 1 : 0,
            'priority'   => $this->request->getPost('priority'),
            'icon'       => $this->request->getPost('icon'),
        ]);

        return redirect()->to('admin/announcements')->with('success', 'Pengumuman berhasil diperbarui!');
    }

    // Hapus
    public function delete($id)
    {
        $announcement = $this->announcementModel->find($id);

        if (!$announcement) {
            return redirect()->to('admin/announcements')->with('error', 'Pengumuman tidak ditemukan!');
        }

        $this->announcementModel->delete($id);

        return redirect()->to('admin/announcements')->with('success', 'Pengumuman berhasil dihapus!');
    }
    
    // Toggle Active/Inactive (AJAX)
    public function toggleActive($id)
    {
        $announcement = $this->announcementModel->find($id);
        
        if ($announcement) {
            $newStatus = $announcement['is_active'] == 1 ? 0 : 1;
            $this->announcementModel->update($id, ['is_active' => $newStatus]);
            
            return $this->response->setJSON([
                'success' => true,
                'newStatus' => $newStatus
            ]);
        }
        
        return $this->response->setJSON(['success' => false]);
    }
}