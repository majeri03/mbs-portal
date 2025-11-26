<?php
namespace Modules\Mts\Controllers;

use App\Models\{PostModel, EventModel, AnnouncementModel, SliderModel, TeacherModel, GalleryModel, CurriculumModel, ProgramModel};

// PENTING: Extend ke BaseMtsController, bukan BaseController biasa
class Home extends BaseMtsController 
{
    public function index()
    {
        // Load Model Data Konten
        $postModel   = new PostModel();
        $eventModel  = new EventModel();
        $annoModel   = new AnnouncementModel();
        $sliderModel = new SliderModel();
        $teacherModel= new TeacherModel();
        $galleryModel= new GalleryModel();
        $curricModel = new CurriculumModel();
        $pageModel   = new \App\Models\PageModel();
        $programModel = new ProgramModel();

        // Masukkan data ke variabel $this->data (warisan dari BaseMtsController)
        $this->data['title'] = "Beranda - " . $this->data['school']['name'];
        
        $this->data['sliders'] = $sliderModel->where('school_id', $this->schoolId)->where('is_active', 1)->orderBy('order_position', 'ASC')->findAll();
        $this->data['announcements'] = $annoModel->where('school_id', $this->schoolId)->where('is_active', 1)->findAll();
        
        // Berita & Agenda (Limit 3 untuk Landing Page)
        $this->data['news'] = $postModel->where('school_id', $this->schoolId)->orderBy('created_at', 'DESC')->findAll(3);
        $this->data['events'] = $eventModel->where('school_id', $this->schoolId)->where('event_date >=', date('Y-m-d'))->orderBy('event_date', 'ASC')->findAll(3);
        
        $this->data['teachers'] = $teacherModel->where('school_id', $this->schoolId)->findAll();
        $this->data['galleries'] = $galleryModel->where('school_id', $this->schoolId)->orderBy('created_at', 'DESC')->findAll(8);
        $this->data['curriculums'] = $curricModel->where('school_id', $this->schoolId)->findAll();
        
        // Halaman Statis (Featured)
        $this->data['featured_page'] = $pageModel->where('school_id', $this->schoolId)->where('is_featured', 1)->first();
        $this->data['programs']      = $programModel->where('school_id', $this->schoolId)->orderBy('order_position', 'ASC')->findAll();
        
        // 1. AMBIL KEPALA SEKOLAH (Hanya 1 Orang)
        // Syarat: Milik MTs (id=1) DAN dicentang sebagai Leader
        $kepalaSekolah = $teacherModel->where('school_id', $this->schoolId)
                                      ->where('is_leader', 1)
                                      ->orderBy('order_position', 'ASC') // Ambil urutan terkecil
                                      ->first();

        // 2. AMBIL GURU & STAFF LAINNYA
        // Logika Baru: Ambil semua guru MTs, KECUALI Kepala Sekolah yang sudah tampil di atas.
        // Jadi jika ada Wakil Direktur yang dicentang Leader, dia akan tetap muncul di slider (bergeser), tidak hilang.
        
        $teacherBuilder = $teacherModel->where('school_id', $this->schoolId);
        
        if ($kepalaSekolah) {
            // Jika kepala sekolah ada, jangan ambil dia lagi di slider
            $teacherBuilder->where('id !=', $kepalaSekolah['id']);
        }

        $guruLainnya = $teacherBuilder->orderBy('order_position', 'ASC')->findAll();

        // Kirim ke View
        $this->data['kepala_sekolah'] = $kepalaSekolah;
        $this->data['teachers']       = $guruLainnya;
        
        return view('Modules\Mts\Views\landing', $this->data);
    }
}