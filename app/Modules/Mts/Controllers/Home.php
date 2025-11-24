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
        
        // 1. Ambil Pimpinan/Kepala Sekolah (Cari yang dicentang "is_leader" = 1)
        $kepalaSekolah = $teacherModel->where('school_id', $this->schoolId)
                                      ->where('is_leader', 1) 
                                      ->first();

        // 2. Ambil Guru Lainnya (Yang BUKAN leader / is_leader = 0)
        $guruLainnya = $teacherModel->where('school_id', $this->schoolId)
                                    ->where('is_leader', 0) 
                                    ->orderBy('order_position', 'ASC')
                                    ->findAll();

        // Kirim data yang sudah dipisah ke View
        $this->data['kepala_sekolah'] = $kepalaSekolah;
        $this->data['teachers']       = $guruLainnya;
        
        return view('Modules\Mts\Views\landing', $this->data);
    }
}