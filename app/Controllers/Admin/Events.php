<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseAdminController;
use App\Models\EventModel;

class Events extends BaseAdminController
{
    protected $eventModel;
    protected $session;

    public function __construct()
    {
        $this->eventModel = new EventModel();
        $this->session = \Config\Services::session();
        helper(['form', 'url', 'text']);
    }

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        // Panggil Satpam (Cek Role)
        $this->restrictToAdmin();
    }
    /**
     * Display list of events
     */
    public function index()
    {
        $builder = $this->eventModel->select('events.*, schools.name as school_name')
            ->join('schools', 'schools.id = events.school_id', 'left');

        if ($this->mySchoolId) {
            // Filter Khusus Admin Sekolah
            $builder->where('events.school_id', $this->mySchoolId);
        }
        $data = [
            'title' => 'Manajemen Agenda',
            'events' => $this->eventModel->orderBy('event_date', 'DESC')->findAll(),
            'currentSchoolName' => $this->mySchoolId ? 'Sekolah (Unit)' : 'Pusat / Umum'
        ];

        return view('admin/events/index', $data);
    }
    /**
     * Show create event form
     */
    public function create()
    {
        $data = [
            'title' => 'Tambah Agenda Baru',
            'validation' => \Config\Services::validation()
        ];

        return view('admin/events/create', $data);
    }

    /**
     * Store new event
     */
    public function store()
    {
        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'event_date' => 'required|valid_date',
            'time_start' => 'permit_empty|regex_match[/^([0-1]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$/]',
            'time_end' => 'permit_empty|regex_match[/^([0-1]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$/]',
            'location' => 'permit_empty|max_length[255]',
            'description' => 'permit_empty'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $title = $this->request->getPost('title');
        $slug = url_title($title, '-', true) . '-' . time();
        $schoolId = $this->mySchoolId;
        // PENTING: Hanya kirim field yang ada di allowedFields
        $data = [
            'school_id' => $schoolId,
            'title' => $title,
            'slug' => $slug,
            'event_date' => $this->request->getPost('event_date'),
            'time_start' => $this->request->getPost('time_start') ?: null,
            'time_end' => $this->request->getPost('time_end') ?: null,
            'location' => $this->request->getPost('location') ?: null,
            'description' => $this->request->getPost('description') ?: null,
            'scope' => $this->request->getPost('scope') ?: 'public'
        ];

        // Tambahkan school_id jika ada
        $schoolId = $this->request->getPost('school_id');
        if (!empty($schoolId)) {
            $data['school_id'] = $schoolId;
        }

        try {
            if ($this->eventModel->skipValidation(true)->insert($data)) {
                return redirect()->to('/admin/events')->with('success', 'Agenda berhasil ditambahkan!');
            }

            // Tampilkan error dari model
            return redirect()->back()->withInput()->with('errors', $this->eventModel->errors());
        } catch (\Exception $e) {
            log_message('error', 'Error inserting event: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan agenda: ' . $e->getMessage());
        }
    }

    /**
     * Show edit event form
     */
    public function edit($id)
    {
        $builder = $this->eventModel;
        if ($this->mySchoolId) {
            $builder->where('school_id', $this->mySchoolId);
        }
        $event = $builder->find($id);

        if (!$event) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Edit Agenda',
            'event' => $event,
            'validation' => \Config\Services::validation()
        ];

        return view('admin/events/edit', $data);
    }

    /**
     * Update event
     */
    public function update($id)
    {
        // 1. Cek Data Lama
        $check = $this->eventModel->find($id);
        if (!$check) {
             return redirect()->to('/admin/events')->with('error', 'Agenda tidak ditemukan.');
        }

        // Cek Kepemilikan (Kecuali Superadmin)
        if ($this->mySchoolId && $check['school_id'] != $this->mySchoolId) {
             return redirect()->to('/admin/events')->with('error', 'Akses Ditolak.');
        }

        // 2. DEFINISI RULES (ATURAN) - Perbaikan Error Disini
        // Jangan masukkan $this->request->getPost(...) disini!
        $rules = [
            'title'      => 'required|min_length[3]',
            'event_date' => 'required|valid_date' 
        ];

        // 3. JALANKAN VALIDASI
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $title = $this->request->getPost('title');

        // Hanya generate slug baru jika title berubah
        if ($title !== $check['title']) {
            $slug = url_title($title, '-', true) . '-' . time();
        } else {
            $slug = $check['slug'];
        }

        $data = [
            'title' => $title,
            'slug' => $slug,
            'event_date' => $this->request->getPost('event_date'),
            'time_start' => $this->request->getPost('time_start') ?: null,
            'time_end' => $this->request->getPost('time_end') ?: null,
            'location' => $this->request->getPost('location') ?: null,
            'description' => $this->request->getPost('description') ?: null,
            'scope' => $this->request->getPost('scope') ?: 'public'
        ];

        $this->eventModel->update($id, $data);
        return redirect()->to('/admin/events')->with('success', 'Agenda berhasil diupdate!');
    }

    /**
     * Delete event
     */
    public function delete($id)
    {
        $event = $this->eventModel->find($id);
        if (!$event || ($this->mySchoolId && $event['school_id'] != $this->mySchoolId)) {
            return redirect()->to('/admin/events')->with('error', 'Gagal menghapus.');
        }
        if (!$event) {
            return redirect()->to('/admin/events')->with('error', 'Agenda tidak ditemukan.');
        }

        if ($this->eventModel->delete($id)) {
            return redirect()->to('/admin/events')->with('success', 'Agenda berhasil dihapus!');
        }

        return redirect()->to('/admin/events')->with('error', 'Gagal menghapus agenda.');
    }

    /**
     * Get events as JSON for FullCalendar
     */
    public function getEvents()
    {
        try {
            $start = $this->request->getGet('start');
            $end = $this->request->getGet('end');

            if (empty($start) || empty($end)) {
                return $this->response->setJSON([]);
            }

            $builder = $this->eventModel->builder();
            $events = $builder
                ->where('event_date >=', $start)
                ->where('event_date <=', $end)
                ->orderBy('event_date', 'ASC')
                ->get()
                ->getResultArray();

            $calendarEvents = [];
            foreach ($events as $event) {
                $calendarEvents[] = [
                    'id' => $event['id'],
                    'title' => $event['title'],
                    'start' => $event['event_date'] . (!empty($event['time_start']) ? 'T' . $event['time_start'] : ''),
                    'end' => $event['event_date'] . (!empty($event['time_end']) ? 'T' . $event['time_end'] : ''),
                    'location' => $event['location'] ?? '',
                    'description' => $event['description'] ?? '',
                    'url' => base_url('admin/events/edit/' . $event['id']),
                    'backgroundColor' => '#2f3f58',
                    'borderColor' => '#1a253a',
                    'textColor' => '#ffffff'
                ];
            }

            return $this->response->setJSON($calendarEvents);
        } catch (\Exception $e) {
            log_message('error', 'Error in Admin getEvents: ' . $e->getMessage());
            return $this->response->setJSON([]);
        }
    }
}
