<?php
namespace Modules\Mts\Controllers;
use App\Models\EventModel;

class Events extends BaseMtsController
{
    protected $eventModel;

    public function __construct()
    {
        $this->eventModel = new EventModel();
    }

    // Halaman Index (Daftar Agenda)
    public function index()
    {
        $this->data['title'] = "Agenda Kegiatan - " . $this->data['school']['name'];
        
        // Filter: Agenda MTs (ID=1) ATAU Agenda Umum (ID=NULL)
        // Tampilkan yang tanggalnya hari ini atau masa depan
        $this->data['events'] = $this->eventModel->groupStart()
                                            ->where('school_id', $this->schoolId)
                                            ->orWhere('school_id', null)
                                           ->groupEnd()
                                           ->where('event_date >=', date('Y-m-d'))
                                           ->orderBy('event_date', 'ASC')
                                           ->findAll();

        return view('Modules\Mts\Views\events_index', $this->data);
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

        return view('Modules\Mts\Views\event_detail', $this->data);
    }
}