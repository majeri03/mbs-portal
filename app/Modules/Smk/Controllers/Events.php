<?php

namespace Modules\Smk\Controllers;

use App\Models\EventModel;

class Events extends BaseSmkController
{
    protected $eventModel;

    public function __construct()
    {
        $this->eventModel = new EventModel();
    }

    // Halaman Index (Daftar Agenda)
   // Modules/Smk/Controllers/Events.php

    public function index()
    {
        $this->data['title'] = "Agenda Kegiatan - " . $this->data['school']['name'];
        
        // 1. Cek Hak Akses
        $isLoggedIn   = session()->get('logged_in');
        $userSchoolId = session()->get('school_id');
        $userRole     = session()->get('role');
        
        // User Internal = Superadmin ATAU Guru Sekolah Ini
        $isInternal = ($isLoggedIn && ($userRole == 'superadmin' || $userSchoolId == $this->schoolId));

        // 2. Mulai Query Builder
        // Gunakan $builder variabel baru, jangan langsung masukkan ke $this->data dulu
        $builder = $this->eventModel->groupStart()
                                    ->where('school_id', $this->schoolId) // HANYA SEKOLAH INI
                                    ->groupEnd()
                                    ->where('event_date >=', date('Y-m-d')); // Hanya masa depan

        // 3. Filter Scope (Satpam Privasi)
        // KITA TARUH DI SINI SEBELUM data diambil (findAll)
        if (!$isInternal) {
            $builder->where('scope', 'public');
        }

        // 4. Eksekusi Pengambilan Data
        $this->data['events'] = $builder->orderBy('event_date', 'ASC')->findAll();
        
        // 5. Tampilkan View (INI WAJIB DI AKHIR)
        return view('Modules\Smk\Views\events_index', $this->data);
    }
    // Halaman Detail (Single Agenda)
    public function show($slug)
    {
        // Cari event berdasarkan slug
        $event = $this->eventModel->where('slug', $slug)->first();

        // Validasi: Pastikan event ada DAN (milik MTs ATAU Umum)
        // Agar tidak bisa intip agenda khusus SMK
        if (!$event || ($event['school_id'] != $this->schoolId && $event['school_id'] != null)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $this->data['title'] = $event['title'];
        $this->data['event'] = $event;

        return view('Modules\Smk\Views\event_detail', $this->data);
    }
}
