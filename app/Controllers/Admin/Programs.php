<?php

namespace App\Controllers\Admin;

use App\Models\ProgramModel;

class Programs extends BaseAdminController
{
    protected $programModel;

    public function __construct()
    {
        $this->programModel = new ProgramModel();
    }
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // PANGGIL SATPAM
        $this->restrictToAdmin();
    }
    public function index()
    {
        $data['title'] = 'Kelola Program Unggulan';

        // GUNAKAN filterBySchool DARI BaseAdminController
        // Agar admin MTs cuma liat program MTs
        $data['programs'] = $this->filterBySchool($this->programModel)
            ->orderBy('order_position', 'ASC')
            ->findAll();

        return view('admin/programs/index', $data);
    }

    public function create()
    {
        if (empty($this->mySchoolId)) {
            return redirect()->to('admin/programs')->with('error', 'Fitur Tambah Program tidak tersedia untuk Superadmin. Silakan login sebagai Admin Sekolah (MTs/MA/SMK) untuk menambahkan program.');
        }
        $data['title'] = 'Tambah Program Baru';
        return view('admin/programs/create', $data);
    }

    public function store()
    {
        if (empty($this->mySchoolId)) {
            return redirect()->to('admin/programs')->with('error', 'Akses ditolak. Superadmin tidak dapat membuat program.');
        }
        if (!$this->validate($this->programModel->getValidationRules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->programModel->save([
            'school_id'      => $this->mySchoolId, // Otomatis ID Sekolah User Login
            'title'          => $this->request->getPost('title'),
            'description'    => $this->request->getPost('description'),
            'icon'           => $this->request->getPost('icon'),
            'order_position' => $this->request->getPost('order_position') ?: 0,
        ]);

        return redirect()->to('admin/programs')->with('success', 'Program berhasil ditambahkan!');
    }

    public function edit($id)
    {
        // Filter: Pastikan hanya bisa edit milik sekolah sendiri
        $program = $this->filterBySchool($this->programModel)->find($id);

        if (!$program) {
            return redirect()->to('admin/programs')->with('error', 'Program tidak ditemukan atau bukan milik Anda.');
        }

        $data['title'] = 'Edit Program';
        $data['program'] = $program;

        return view('admin/programs/edit', $data);
    }

    public function update($id)
    {
        // Validasi kepemilikan data sebelum update
        $exists = $this->filterBySchool($this->programModel)->find($id);
        if (!$exists) {
            return redirect()->to('admin/programs');
        }

        if (!$this->validate($this->programModel->getValidationRules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->programModel->update($id, [
            'title'          => $this->request->getPost('title'),
            'description'    => $this->request->getPost('description'),
            'icon'           => $this->request->getPost('icon'),
            'order_position' => $this->request->getPost('order_position'),
        ]);

        return redirect()->to('admin/programs')->with('success', 'Program berhasil diperbarui!');
    }

    public function delete($id)
    {
        $program = $this->filterBySchool($this->programModel)->find($id);

        if (!$program) {
            return redirect()->to('admin/programs')->with('error', 'Data tidak ditemukan.');
        }

        $this->programModel->delete($id);
        return redirect()->to('admin/programs')->with('success', 'Program berhasil dihapus!');
    }
}
