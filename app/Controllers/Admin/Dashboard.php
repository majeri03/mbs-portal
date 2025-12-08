<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseAdminController; // Pastikan extend BaseAdmin
use App\Models\PostModel;
use App\Models\SchoolModel;
use App\Models\EventModel;
use App\Models\UserModel;
use App\Models\DocumentModel;
use App\Models\TeacherModel;
use App\Models\AnnouncementModel;

class Dashboard extends BaseAdminController
{
    protected $postModel;
    protected $schoolModel;
    protected $eventModel;
    protected $userModel;
    protected $docModel;
    protected $teacherModel;
    protected $announcementModel;
    public function __construct()
    {
        $this->postModel = new PostModel();
        $this->schoolModel = new SchoolModel();
        $this->eventModel = new EventModel();
        $this->userModel = new UserModel();
        $this->docModel = new DocumentModel();
        $this->teacherModel = new TeacherModel();
        $this->announcementModel = new AnnouncementModel();
    }

    public function index()
    {
        $role = session('role');
        $schoolId = session('school_id');
        $username = session('username');

        $data['title'] = 'Dashboard Admin';
        $data['user'] = [
            'username'  => $username,
            'full_name' => session('full_name'),
            'role'      => $role,
            'school_name' => $this->getSchoolName($schoolId)
        ];

        // --- LOGIKA STATISTIK BERDASARKAN ROLE ---
        $stats = [];

        if ($role === 'superadmin') {
            // SUPERADMIN: Lihat Semuanya
            $stats['card1'] = ['label' => 'Total Sekolah', 'value' => $this->schoolModel->countAll(), 'icon' => 'bi-building', 'color' => 'primary'];
            $stats['card2'] = ['label' => 'Total Pengguna', 'value' => $this->userModel->countAll(), 'icon' => 'bi-people-fill', 'color' => 'success'];
            $stats['card3'] = ['label' => 'Total Berita', 'value' => $this->postModel->countAll(), 'icon' => 'bi-newspaper', 'color' => 'warning'];
            $stats['card4'] = ['label' => 'Total Dokumen', 'value' => $this->docModel->countAll(), 'icon' => 'bi-file-earmark-text', 'color' => 'info'];

            // Berita Terbaru (Global)
            $data['latest_posts'] = $this->postModel->select('posts.*, schools.name as school_name')
                ->join('schools', 'schools.id = posts.school_id', 'left')
                ->orderBy('created_at', 'DESC')
                ->findAll(5);
        } elseif ($role === 'admin') {
            // ADMIN SEKOLAH: Lihat Data Sekolahnya Saja
            $stats['card1'] = ['label' => 'Guru & Staff', 'value' => $this->teacherModel->where('school_id', $schoolId)->countAllResults(), 'icon' => 'bi-person-badge', 'color' => 'primary'];
            $stats['card2'] = ['label' => 'Berita Sekolah', 'value' => $this->postModel->where('school_id', $schoolId)->countAllResults(), 'icon' => 'bi-newspaper', 'color' => 'success'];
            $stats['card3'] = ['label' => 'Agenda', 'value' => $this->eventModel->where('school_id', $schoolId)->countAllResults(), 'icon' => 'bi-calendar-event', 'color' => 'warning'];
            $stats['card4'] = ['label' => 'Dokumen', 'value' => $this->docModel->where('school_id', $schoolId)->countAllResults(), 'icon' => 'bi-folder', 'color' => 'info'];

            // Berita Terbaru (Sekolah Ini)
            $data['latest_posts'] = $this->postModel->where('school_id', $schoolId)
                ->orderBy('created_at', 'DESC')
                ->findAll(5);
        } else {
            // GURU: Lihat Kontribusi Sendiri & Info Sekolah
            // Hitung berita yang ditulis oleh user ini
            $myPosts = $this->postModel->where('author', session('full_name'))->countAllResults(); // Asumsi author menyimpan nama lengkap/username

            $stats['card1'] = ['label' => 'Tulisan Saya', 'value' => $myPosts, 'icon' => 'bi-pen', 'color' => 'primary'];
            $stats['card2'] = ['label' => 'Agenda Sekolah', 'value' => $this->eventModel->where('school_id', $schoolId)->where('event_date >=', date('Y-m-d'))->countAllResults(), 'icon' => 'bi-calendar-check', 'color' => 'success'];
            $stats['card3'] = ['label' => 'Dokumen Publik', 'value' => $this->docModel->where('school_id', $schoolId)->where('is_public', 1)->countAllResults(), 'icon' => 'bi-file-earmark', 'color' => 'warning'];

            // Card 4: Total Views tulisan dia (Opsional/Bonus)
            $myViews = $this->postModel->selectSum('views')->where('author', session('full_name'))->first();
            $stats['card4'] = ['label' => 'Total Pembaca', 'value' => $myViews['views'] ?? 0, 'icon' => 'bi-eye', 'color' => 'info'];

            // Berita Terbaru (Sekolah Ini - untuk referensi guru)
            $data['latest_posts'] = $this->postModel->where('school_id', $schoolId)
                ->orderBy('created_at', 'DESC')
                ->findAll(5);
        }

        $data['stats'] = $stats;
        // ============================================
        // FASE 2: WIDGET AGENDA INTERNAL & ANNOUNCEMENT
        // ============================================

        // Widget Agenda Internal (Hari Ini & Besok)
        $today = date('Y-m-d');
        $tomorrow = date('Y-m-d', strtotime('+1 day'));

        $agendaQuery = $this->eventModel
            ->where('scope', 'internal')
            ->groupStart()
            ->where('event_date', $today)
            ->orWhere('event_date', $tomorrow)
            ->groupEnd();

        // Filter berdasarkan sekolah
        if ($schoolId) {
            $agendaQuery->where('school_id', $schoolId);
        }

        $data['urgent_agenda'] = $agendaQuery
            ->orderBy('event_date', 'ASC')
            ->orderBy('time_start', 'ASC')
            ->findAll();

        // Widget Announcement Internal (3 terbaru)
        $today = date('Y-m-d');

        $announcementQuery = $this->announcementModel
            ->where('is_active', 1)
            ->where('start_date <=', $today)
            ->where('end_date >=', $today)
            ->where('priority <=', 3);

        // Filter berdasarkan sekolah
        if ($schoolId) {
            $announcementQuery->where('school_id', $schoolId);
        }

        $data['important_announcements'] = $announcementQuery
            ->orderBy('priority', 'ASC')
            ->orderBy('created_at', 'DESC')
            ->limit(3)
            ->findAll();
        return view('admin/dashboard/index', $data);
    }

    private function getSchoolName($id)
    {
        if (!$id) return "Yayasan Pusat";
        $school = $this->schoolModel->find($id);
        return $school ? $school['name'] : 'Unknown';
    }
}
