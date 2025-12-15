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

        // ✅ AMBIL PARAMETER FILTER
        $search = $this->request->getGet('search');
        $menu = $this->request->getGet('menu');
        $schoolId = $this->request->getGet('school_id');

        // Query dasar
        $query = $this->filterBySchool($this->pageModel);

        // Filter Search (Judul)
        if (!empty($search)) {
            $query = $query->like('pages.title', $search);
        }

        // Filter Menu
        if (!empty($menu)) {
            $query = $query->where('pages.menu_title', $menu);
        }

        // Filter School (khusus superadmin)
        if (isset($schoolId) && $schoolId !== '' && empty($this->mySchoolId)) {
            if ($schoolId == '0') {
                // Filter PUSAT
                $query = $query->where('pages.school_id', null);
            } else {
                // Filter sekolah tertentu
                $query = $query->where('pages.school_id', $schoolId);
            }
        }

        // Eksekusi query dengan JOIN
        $data['pages'] = $query->select('pages.*, schools.name as school_name')
            ->join('schools', 'schools.id = pages.school_id', 'left')
            ->orderBy('pages.menu_title', 'ASC')
            ->orderBy('pages.title', 'ASC')
            ->findAll();

        // ✅ DATA UNTUK DROPDOWN FILTER
        // Ambil semua menu yang ada
        $allMenusQuery = $this->pageModel->select('menu_title')
            ->distinct()
            ->where('menu_title IS NOT NULL')
            ->where('menu_title !=', '')
            ->orderBy('menu_title', 'ASC');

        if ($this->mySchoolId) {
            $allMenusQuery->where('school_id', $this->mySchoolId);
        }

        $data['allMenus'] = array_column($allMenusQuery->findAll(), 'menu_title');

        // Ambil daftar sekolah (untuk superadmin)
        $data['schools'] = $this->schoolModel->findAll();

        // Kirim nilai filter ke view
        $data['currentSearch'] = $search;
        $data['currentMenu'] = $menu;
        $data['currentSchoolFilter'] = $schoolId;

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
            return redirect()->to('admin/pages')->with('success', 'Halaman "' . esc($page['title']) . '" berhasil dihapus!');
        }
        return redirect()->to('admin/pages')->with('error', 'Halaman tidak ditemukan atau akses ditolak.');
    }
    // Rename menu
    public function renameMenu()
    {
        $oldName = $this->request->getPost('old_menu_name');
        $newName = $this->request->getPost('new_menu_name');

        if (empty($newName) || strlen($newName) < 3) {
            return redirect()->back()->with('error', 'Nama menu minimal 3 karakter.');
        }

        $builder = $this->filterBySchool($this->pageModel)->where('menu_title', $oldName);
        $builder->set(['menu_title' => $newName])->update();

        return redirect()->to('admin/pages')->with('success', "Menu \"$oldName\" berhasil diubah menjadi \"$newName\"!");
    }

    // Delete menu
    public function deleteMenu()
    {
        $menuName = $this->request->getPost('menu_name');
        $action = $this->request->getPost('action');
        $targetMenu = $this->request->getPost('target_menu');

        $builder = $this->filterBySchool($this->pageModel)->where('menu_title', $menuName);
        $pages = $builder->findAll();

        if ($action === 'move' && !empty($targetMenu)) {
            foreach ($pages as $p) {
                $this->pageModel->update($p['id'], ['menu_title' => $targetMenu]);
            }
            return redirect()->to('admin/pages')->with('success', "Menu \"$menuName\" dihapus. Halaman dipindahkan ke \"$targetMenu\".");
        } else {
            foreach ($pages as $p) {
                $this->pageModel->delete($p['id']);
            }
            return redirect()->to('admin/pages')->with('success', "Menu \"$menuName\" dan semua halamannya berhasil dihapus!");
        }
    }
}
