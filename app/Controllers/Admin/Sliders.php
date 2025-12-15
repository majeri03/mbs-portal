<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseAdminController;
use App\Models\SliderModel;
use App\Models\SchoolModel;
class Sliders extends BaseAdminController
{
    protected $sliderModel;
    protected $schoolModel;
    public function __construct()
    {
        $this->sliderModel = new SliderModel();
        $this->schoolModel = new SchoolModel();
    }
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // PANGGIL SATPAM
        $this->restrictToAdmin();
    }
    // Halaman List Slider
    public function index()
    {
        $data['title'] = 'Kelola Hero Slider';
        
        // Ambil parameter filter
        $search = $this->request->getGet('search');
        $status = $this->request->getGet('status');
        $schoolId = $this->request->getGet('school_id');
        
        // Query builder dengan JOIN ke tabel schools
        $builder = $this->sliderModel
            ->select('sliders.*, schools.name as school_name')
            ->join('schools', 'schools.id = sliders.school_id', 'left');
        
        // Filter berdasarkan school (admin sekolah hanya lihat miliknya)
        if ($this->mySchoolId) {
            $builder->where('sliders.school_id', $this->mySchoolId);
        }
        
        // Filter Search (judul atau deskripsi)
        if ($search) {
            $builder->groupStart()
                ->like('sliders.title', $search)
                ->orLike('sliders.description', $search)
                ->groupEnd();
        }
        
        // Filter Status (aktif/nonaktif)
        if ($status !== null && $status !== '') {
            $builder->where('sliders.is_active', $status);
        }
        
        // Filter Sekolah (hanya untuk superadmin)
        if (!$this->mySchoolId && $schoolId !== null && $schoolId !== '') {
            if ($schoolId === 'pusat') {
                $builder->where('sliders.school_id', null);
            } else {
                $builder->where('sliders.school_id', $schoolId);
            }
        }
        
        $data['sliders'] = $builder->orderBy('sliders.order_position', 'ASC')->findAll();
        
        // Data untuk dropdown filter (hanya superadmin)
        if (!$this->mySchoolId) {
            $data['schools'] = $this->schoolModel->orderBy('name', 'ASC')->findAll();
        }
        
        // Pass current filters ke view
        $data['current_search'] = $search;
        $data['current_status'] = $status;
        $data['current_school_id'] = $schoolId;
        $data['mySchoolId'] = $this->mySchoolId;
        return view('admin/sliders/index', $data);
    }

    // Halaman Form Tambah
    public function create()
    {
        $data['title'] = 'Tambah Hero Slider';
        return view('admin/sliders/create', $data);
    }

    // Proses Simpan
    public function store()
    {

        $rules = [
            'title'      => 'required|min_length[5]',
            'image' => [
                'rules' => 'uploaded[image]|max_size[image,3072]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]',
                'errors' => [
                    'uploaded' => 'Pilih gambar slider terlebih dahulu.',
                    'max_size' => 'Ukuran terlalu besar (Maks 3MB).',
                    'is_image' => 'File bukan gambar.',
                    'mime_in'  => 'Hanya format JPG, PNG, atau WEBP.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Upload Image
        $image = $this->request->getFile('image');
        $imageName = $image->getRandomName();
        $image->move('uploads/sliders', $imageName);

        $this->sliderModel->save([
            'school_id'      => $this->mySchoolId,
            'badge_text'     => $this->request->getPost('badge_text'),
            'title'          => $this->request->getPost('title'),
            'description'    => $this->request->getPost('description'),
            'image_url'      => 'uploads/sliders/' . $imageName,
            'button_text'    => $this->request->getPost('button_text'),
            'button_link'    => $this->request->getPost('button_link'),
            'order_position' => $this->request->getPost('order_position') ?: 99,
            'is_active'      => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        return redirect()->to('admin/sliders')->with('success', 'Hero Slider berhasil ditambahkan!');
    }

    // Halaman Form Edit
    public function edit($id)
    {
        $data['title'] = 'Edit Hero Slider';
        $data['slider'] = $this->sliderModel->find($id);

        if (!$data['slider']) {
            return redirect()->to('admin/sliders')->with('error', 'Slider tidak ditemukan!');
        }

        return view('admin/sliders/edit', $data);
    }

    // Proses Update
    public function update($id)
    {
        $rules = [
            'title' => 'required|min_length[5]',
            'image' => [
                'rules' => 'permit_empty|max_size[image,3072]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]',
                'errors' => [
                    'max_size' => 'Ukuran terlalu besar (Maks 3MB).',
                    'is_image' => 'File bukan gambar.',
                    'mime_in'  => 'Hanya format JPG, PNG, atau WEBP.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $slider = $this->sliderModel->find($id);
        $imageUrl = $slider['image_url'];

        // Jika upload gambar baru
        $image = $this->request->getFile('image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            // Hapus gambar lama
            if (file_exists($slider['image_url'])) {
                unlink($slider['image_url']);
            }

            $imageName = $image->getRandomName();
            $image->move('uploads/sliders', $imageName);
            $imageUrl = 'uploads/sliders/' . $imageName;
        }

        $this->sliderModel->update($id, [
            'badge_text'     => $this->request->getPost('badge_text'),
            'title'          => $this->request->getPost('title'),
            'description'    => $this->request->getPost('description'),
            'image_url'      => $imageUrl,
            'button_text'    => $this->request->getPost('button_text'),
            'button_link'    => $this->request->getPost('button_link'),
            'order_position' => $this->request->getPost('order_position'),
            'is_active'      => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        return redirect()->to('admin/sliders')->with('success', 'Hero Slider berhasil diperbarui!');
    }

    // Hapus Slider
    public function delete($id)
    {
        $slider = $this->sliderModel->find($id);

        if (!$slider) {
            return redirect()->to('admin/sliders')->with('error', 'Slider tidak ditemukan!');
        }

        // Hapus file image
        if (file_exists($slider['image_url'])) {
            unlink($slider['image_url']);
        }

        $this->sliderModel->delete($id);

        return redirect()->to('admin/sliders')->with('success', 'Hero Slider berhasil dihapus!');
    }

    // Toggle Status Active/Inactive (AJAX)
    public function toggleStatus($id)
    {
        $slider = $this->sliderModel->find($id);
        $newStatus = $slider['is_active'] == 1 ? 0 : 1;

        $this->sliderModel->update($id, ['is_active' => $newStatus]);

        return $this->response->setJSON(['status' => 'success', 'new_status' => $newStatus]);
    }
}
