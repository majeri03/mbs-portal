<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseAdminController;
use App\Models\AnnouncementModel;
use App\Models\SchoolModel;
class Announcements extends BaseAdminController
{
    protected $announcementModel;
    protected $schoolModel;
    public function __construct()
    {
        $this->announcementModel = new AnnouncementModel();
        $this->schoolModel = new SchoolModel();
    }

    // List Pengumuman
    public function index()
    {
        $data['title'] = 'Kelola Pengumuman';
        $query = $this->filterBySchool($this->announcementModel);
        $data['announcements'] = $query->select('announcements.*, schools.name as school_name')
                                       ->join('schools', 'schools.id = announcements.school_id', 'left')
                                       ->orderBy('priority', 'ASC')
                                       ->findAll();
        
        return view('admin/announcements/index', $data);
    }

    // Form Tambah
    public function create()
    {
        $data['title'] = 'Tambah Pengumuman Baru';
        $data['schools'] = $this->schoolModel->findAll();
        $data['currentSchoolId'] = $this->mySchoolId;
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
        $schoolId = $this->mySchoolId ? $this->mySchoolId : ($this->request->getPost('school_id') ?: null);
        $this->announcementModel->save([
            'school_id'  => $schoolId,
            'title'      => $this->request->getPost('title'),
            'content'    => $this->request->getPost('content'),
            'category'   => $this->request->getPost('category'),
            'link_url' => $this->request->getPost('link_url'),
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
        $data['announcement'] = $this->filterBySchool($this->announcementModel)->find($id);
        if (!$data['announcement']) {
            return redirect()->to('admin/announcements')->with('error', 'Pengumuman tidak ditemukan!');
        }
        $data['title'] = 'Edit Pengumuman';
        $data['schools'] = $this->schoolModel->findAll();
        $data['currentSchoolId'] = $this->mySchoolId;

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
        $exists = $this->filterBySchool($this->announcementModel)->find($id);
        if (!$exists) return redirect()->to('admin/announcements');
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $schoolId = $this->mySchoolId ? $this->mySchoolId : ($this->request->getPost('school_id') ?: null);
        $this->announcementModel->update($id, [
            'school_id'  => $schoolId,
            'title'      => $this->request->getPost('title'),
            'content'    => $this->request->getPost('content'),
            'category'   => $this->request->getPost('category'),
            'link_url' => $this->request->getPost('link_url'),
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
        $data = $this->filterBySchool($this->announcementModel)->find($id);
        

        if ($data) {
            $this->announcementModel->delete($id);
            return redirect()->to('admin/announcements')->with('success', 'Pengumuman dihapus!');
        }

        return redirect()->to('admin/announcements')->with('success', 'Pengumuman berhasil dihapus!');
    }
    
    // Toggle Active/Inactive (AJAX)
    public function toggleActive($id)
    {
        $announcement = $this->filterBySchool($this->announcementModel)->find($id);
        
        if ($announcement) {
            // Balik statusnya (1 jadi 0, 0 jadi 1)
            $newStatus = $announcement['is_active'] == 1 ? 0 : 1;
            
            $this->announcementModel->update($id, ['is_active' => $newStatus]);
            
            return $this->response->setJSON([
                'success' => true,
                'newStatus' => $newStatus
            ]);
        }
        
        // Jika data tidak ditemukan atau milik sekolah lain
        return $this->response->setJSON(['success' => false, 'message' => 'Akses ditolak']);
    }
}