<?php

namespace App\Controllers;

use App\Models\SettingModel;
use App\Models\SchoolModel;
use App\Models\AnnouncementModel;
use App\Models\PostModel;
use App\Models\EventModel;
use App\Models\GalleryModel;
use App\Models\TeacherModel;
use App\Models\SliderModel;
class Home extends BaseController
{
    protected $settingModel;
    protected $schoolModel;
    protected $announcementModel;
    protected $postModel;
    protected $eventModel;
    protected $galleryModel;
    protected $teacherModel;
    protected $sliderModel;
    public function __construct()
    {
        // Load Model di constructor agar bisa dipakai di semua fungsi
        $this->settingModel = new SettingModel();
        $this->schoolModel = new SchoolModel();
        $this->announcementModel = new AnnouncementModel();
        $this->postModel = new PostModel();
        $this->eventModel = new EventModel();
        $this->galleryModel = new GalleryModel();
        $this->teacherModel = new \App\Models\TeacherModel();
        $this->sliderModel = new SliderModel();
        helper(['youtube']);
    }

     public function index()
    {
        // 1. Settings (Footer/Header)
        $data['site'] = $this->settingModel->getSiteSettings();
        $data['title'] = "Beranda - " . ($data['site']['site_name'] ?? 'MBS Portal');
        $data['sliders'] = $this->sliderModel->where('school_id', null)->where('is_active', 1)->orderBy('order_position', 'ASC')->findAll();
        // 2. Data Sekolah (Untuk 3 Kartu Utama)
        $data['schools'] = $this->schoolModel->findAll();
        
        // 3. Pengumuman Aktif (Untuk Running Text)
        $data['announcements'] = $this->announcementModel->where('school_id', null)->where('is_active', 1)->findAll();

        $data['latest_news'] = $this->postModel->select('posts.*, schools.name as school_name')
                    ->join('schools', 'schools.id = posts.school_id', 'left')
                    ->where('posts.school_id', null) // <--- FILTER: HANYA YANG ID SEKOLAHNYA KOSONG
                    ->where('is_published', 1)
                    ->orderBy('posts.created_at', 'DESC')
                    ->findAll(3);
        $data['upcoming_events'] = $this->eventModel
                    ->where('school_id', null) // <--- FILTER
                    ->where('event_date >=', date('Y-m-d'))
                    ->orderBy('event_date', 'ASC')
                    ->limit(4)
                    ->findAll();
        $data['latest_photos'] = $this->galleryModel->where('school_id', null)->orderBy('created_at', 'DESC')->findAll(8);
        $data['leaders'] = $this->teacherModel->getLeaders();
        return view('landing_page', $data);
    }
}