<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SchoolModel;

class Schools extends BaseController
{
    protected $schoolModel;

    public function __construct()
    {
        $this->schoolModel = new SchoolModel();
    }

    // List Sekolah
    public function index()
    {
        $data['title'] = 'Kelola Jenjang Pendidikan';
        $data['schools'] = $this->schoolModel->orderBy('order_position', 'ASC')->findAll();
        
        return view('admin/schools/index', $data);
    }

    // Form Tambah
        public function create()
    {
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
        $rules = [
            'name'        => 'required|min_length[3]',
            'description' => 'required|min_length[10]',
            'image'       => 'uploaded[image]|max_size[image,2048]|is_image[image]',
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
        $rules = [
            'name'        => 'required|min_length[3]',
            'description' => 'required|min_length[10]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $school = $this->schoolModel->find($id);
        
        if (!$school) {
            return redirect()->to('admin/schools')->with('error', 'Sekolah tidak ditemukan!');
        }
        
        $imageUrl = $school['image_url'] ?? '';

        // Jika upload gambar baru
        $image = $this->request->getFile('image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            // Hapus gambar lama jika ada
            if (!empty($school['image_url']) && file_exists($school['image_url'])) {
                unlink($school['image_url']);
            }

            $imageName = $image->getRandomName();
            $image->move('uploads/schools', $imageName);
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
        $school = $this->schoolModel->find($id);

        if (!$school) {
            return redirect()->to('admin/schools')->with('error', 'Sekolah tidak ditemukan!');
        }

        // Hapus file image
        if (file_exists($school['image_url'])) {
            unlink($school['image_url']);
        }

        $this->schoolModel->delete($id);

        return redirect()->to('admin/schools')->with('success', 'Jenjang sekolah berhasil dihapus!');
    }
}