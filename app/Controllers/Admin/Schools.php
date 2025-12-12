<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseAdminController;
use App\Models\SchoolModel;

class Schools extends BaseAdminController
{
    protected $schoolModel;

    public function __construct()
    {
        $this->schoolModel = new SchoolModel();
    }
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // PANGGIL SATPAM
        $this->restrictToAdmin();
    }
    // List Sekolah
    public function index()
    {
        $data['title'] = 'Kelola Jenjang Pendidikan';

        if ($this->mySchoolId) {
            // [KUNCI 1] Admin Sekolah: Hanya lihat sekolahnya sendiri
            $data['schools'] = $this->schoolModel->where('id', $this->mySchoolId)->findAll();
        } else {
            // Superadmin: Lihat semua
            $data['schools'] = $this->schoolModel->orderBy('order_position', 'ASC')->findAll();
        }

        return view('admin/schools/index', $data);
    }

    // Form Tambah
    public function create()
    {
        if ($this->mySchoolId) {
            return redirect()->to('admin/schools')->with('error', 'Akses ditolak! Hanya Superadmin yang boleh menambah jenjang.');
        }
        $data['title'] = 'Tambah Jenjang Sekolah';

        // Ambil list akreditasi unik dari data yang sudah ada (untuk auto-suggest)
        $data['existing_accreditations'] = $this->schoolModel
            ->select('accreditation_status')
            ->where('accreditation_status IS NOT NULL')
            ->where('accreditation_status !=', '')
            ->groupBy('accreditation_status')
            ->orderBy('accreditation_status', 'ASC')
            ->findAll();

        return view('admin/schools/create', $data);
    }

    // Proses Simpan
    public function store()
    {
        if ($this->mySchoolId) {
            return redirect()->to('admin/schools')->with('error', 'Akses ditolak!');
        }
        $rules = [
            'name'        => 'required|min_length[3]',
            'description' => 'required|min_length[10]',
            'image'       => [
                'rules' => 'uploaded[image]|max_size[image,2048]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]',
                'errors' => [
                    'uploaded' => 'Logo/Foto sekolah wajib diupload.',
                    'mime_in'  => 'Format harus JPG, PNG, atau WEBP.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Upload Image
        $image = $this->request->getFile('image');
        $imageName = $image->getRandomName();
        $image->move('uploads/schools', $imageName);

        // Handle custom accreditation
        $accreditationStatus = $this->request->getPost('accreditation_status');
        if ($accreditationStatus === 'custom') {
            $accreditationStatus = $this->request->getPost('custom_accreditation') ?: 'A';
        }

        $this->schoolModel->save([
            'name'                  => $this->request->getPost('name'),
            'description'           => $this->request->getPost('description'),
            'image_url'             => 'uploads/schools/' . $imageName,
            'website_url'           => $this->request->getPost('website_url'),
            'contact_person'        => $this->request->getPost('contact_person'),
            'phone'                 => $this->request->getPost('phone'),
            'order_position'        => $this->request->getPost('order_position') ?: 99,
            'accreditation_status'  => $accreditationStatus,
        ]);

        return redirect()->to('admin/schools')->with('success', 'Jenjang sekolah berhasil ditambahkan!');
    }

    // Form Edit
    public function edit($id)
    {
        if ($this->mySchoolId && $this->mySchoolId != $id) {
            return redirect()->to('admin/schools')->with('error', 'Anda hanya boleh mengedit profil sekolah Anda sendiri.');
        }
        $data['title'] = 'Edit Jenjang Sekolah';
        $data['school'] = $this->schoolModel->find($id);

        if (!$data['school']) {
            return redirect()->to('admin/schools')->with('error', 'Sekolah tidak ditemukan!');
        }

        // Pastikan field tidak null (set default value)
        $data['school']['image_url'] = $data['school']['image_url'] ?? '';
        $data['school']['website_url'] = $data['school']['website_url'] ?? '';
        $data['school']['contact_person'] = $data['school']['contact_person'] ?? '';
        $data['school']['phone'] = $data['school']['phone'] ?? '';
        $data['school']['order_position'] = $data['school']['order_position'] ?? 1;
        $data['school']['accreditation_status'] = $data['school']['accreditation_status'] ?? 'A';

        // Ambil list akreditasi unik
        $data['existing_accreditations'] = $this->schoolModel
            ->select('accreditation_status')
            ->where('accreditation_status IS NOT NULL')
            ->where('accreditation_status !=', '')
            ->groupBy('accreditation_status')
            ->orderBy('accreditation_status', 'ASC')
            ->findAll();

        return view('admin/schools/edit', $data);
    }

    // Proses Update
    public function update($id)
    {
        if ($this->mySchoolId && $this->mySchoolId != $id) {
            return redirect()->to('admin/schools')->with('error', 'Akses ditolak!');
        }

        $rules = [
            'name'        => 'required|min_length[3]',
            'description' => 'required|min_length[10]',
        ];

        // HANYA validasi gambar jika ada upload
        $image = $this->request->getFile('image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $rules['image'] = [
                'rules' => 'max_size[image,2048]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]',
                'errors' => [
                    'max_size' => 'Ukuran gambar maksimal 2MB.',
                    'is_image' => 'File harus berupa gambar.',
                    'mime_in'  => 'Format harus JPG, PNG, atau WEBP.'
                ]
            ];
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $school = $this->schoolModel->find($id);

        if (!$school) {
            return redirect()->to('admin/schools')->with('error', 'Sekolah tidak ditemukan!');
        }

        $imageUrl = $school['image_url'] ?? '';

        // Jika upload gambar baru
        if ($image && $image->isValid() && !$image->hasMoved()) {
            // Hapus gambar lama jika ada
            if (!empty($school['image_url']) && file_exists(FCPATH . $school['image_url'])) {
                @unlink(FCPATH . $school['image_url']);
            }

            $imageName = $image->getRandomName();
            $image->move(FCPATH . 'uploads/schools', $imageName);
            $imageUrl = 'uploads/schools/' . $imageName;
        }

        // Handle custom accreditation
        $accreditationStatus = $this->request->getPost('accreditation_status');
        if ($accreditationStatus === 'custom') {
            $accreditationStatus = $this->request->getPost('custom_accreditation') ?: 'A';
        }

        $this->schoolModel->update($id, [
            'name'                  => $this->request->getPost('name'),
            'description'           => $this->request->getPost('description'),
            'image_url'             => $imageUrl,
            'website_url'           => $this->request->getPost('website_url') ?? '',
            'contact_person'        => $this->request->getPost('contact_person') ?? '',
            'phone'                 => $this->request->getPost('phone') ?? '',
            'order_position'        => $this->request->getPost('order_position') ?? 1,
            'accreditation_status'  => $accreditationStatus,
        ]);

        return redirect()->to('admin/schools')->with('success', 'Data sekolah berhasil diperbarui!');
    }
    // Hapus
    public function delete($id)
    {
        if ($this->mySchoolId) {
            return redirect()->to('admin/schools')->with('error', 'Akses ditolak! Anda tidak boleh menghapus sekolah.');
        }
        $school = $this->schoolModel->find($id);

        if (!$school) {
            return redirect()->to('admin/schools')->with('error', 'Sekolah tidak ditemukan!');
        }

        // Hapus file image
        if (!empty($school['image_url']) && file_exists(FCPATH . $school['image_url'])) {
            @unlink(FCPATH . $school['image_url']);
        }

        $this->schoolModel->delete($id);

        return redirect()->to('admin/schools')->with('success', 'Jenjang sekolah berhasil dihapus!');
    }
}
