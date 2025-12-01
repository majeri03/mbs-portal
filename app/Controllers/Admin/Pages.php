<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseAdminController;
use App\Models\PageModel;
use App\Models\SchoolModel;

class Pages extends BaseAdminController
{
    protected $pageModel;
    protected $schoolModel;
    public function __construct()
    {
        $this->pageModel = new PageModel();
        $this->schoolModel = new SchoolModel();
    }
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // PANGGIL SATPAM
        $this->restrictToAdmin();
    }
    public function index()
    {
        $data['title'] = 'Kelola Halaman Statis';
        $query = $this->filterBySchool($this->pageModel);
        $data['pages'] = $query->select('pages.*, schools.name as school_name')
            ->join('schools', 'schools.id = pages.school_id', 'left')
            ->findAll();
        return view('admin/pages/index', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Halaman Baru';
        $data['schools'] = $this->schoolModel->findAll();
        $data['currentSchoolId'] = $this->mySchoolId;
        $data['existingMenus'] = $this->pageModel->getExistingMenus($this->mySchoolId);
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

        // 4. Logika School ID (Otomatis/Manual)
        $schoolId = $this->mySchoolId ? $this->mySchoolId : ($this->request->getPost('school_id') ?: null);

        $this->pageModel->save([
            'school_id'   => $schoolId,
            'menu_title'  => $this->request->getPost('menu_title'),
            'title'       => $title,
            'slug'        => $slug,
            'content'     => $this->request->getPost('content'),
            'is_active'   => 1,
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0
        ]);

        return redirect()->to('admin/pages')->with('success', 'Halaman berhasil dibuat!');
    }

    public function edit($id)
    {
        $data['page'] = $this->filterBySchool($this->pageModel)->find($id);
        if (!$data['page']) {
            return redirect()->to('admin/pages')->with('error', 'Halaman tidak ditemukan atau akses ditolak.');
        }
        $data['title'] = 'Edit Halaman';
        $data['schools'] = $this->schoolModel->findAll();
        $data['currentSchoolId'] = $this->mySchoolId;
        $data['existingMenus'] = $this->pageModel->getExistingMenus($data['page']['school_id']);
        return view('admin/pages/edit', $data);
    }

    public function update($id)
    {
        $page = $this->filterBySchool($this->pageModel)->find($id);
        if (!$page) return redirect()->to('admin/pages');
        if (!$this->validate([
            'title'   => 'required|min_length[3]',
            'content' => 'required'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $schoolId = $this->mySchoolId ? $this->mySchoolId : ($this->request->getPost('school_id') ?: null);
        $this->pageModel->update($id, [
            'school_id'   => $schoolId,
            'menu_title'  => $this->request->getPost('menu_title'),
            'title'   => $this->request->getPost('title'),
            'content' => $this->request->getPost('content'),
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0
        ]);

        return redirect()->to('admin/pages')->with('success', 'Halaman berhasil diperbarui!');
    }

    public function delete($id)
    {
        $page = $this->filterBySchool($this->pageModel)->find($id);
        if ($page) {
            $this->pageModel->delete($id);
            return redirect()->to('admin/pages')->with('success', 'Halaman dihapus!');
        }
        return redirect()->to('admin/pages')->with('success', 'Halaman dihapus!');
    }
}
