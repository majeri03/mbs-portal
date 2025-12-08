<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseAdminController;
use App\Models\EventModel;
use App\Models\SchoolModel;

class Events extends BaseAdminController
{
    protected $eventModel;
    protected $schoolModel;
    protected $session;

    public function __construct()
    {
        $this->eventModel = new EventModel();
        $this->schoolModel = new SchoolModel();
        $this->session = \Config\Services::session();
        helper(['form', 'url', 'text']);
    }

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // Cek role dan URI segment untuk method yang diakses
        if (session('role') === 'guru') {
            // Ambil segment terakhir dari URI untuk deteksi method
            $uri = service('uri');
            $segment = $uri->getSegment(3); // Segment ke-3 setelah /admin/events/

            // Guru hanya boleh akses 'internal' atau tanpa segment (untuk getEvents API)
            $allowedSegments = ['internal', null, '']; // null = /admin/events (untuk redirect ke internal)

            if (!in_array($segment, $allowedSegments)) {
                // Method lain (create, edit, dll) → 404
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }
        }
    }

    /**
     * Display list of events
     */
    public function index()
    {
        $builder = $this->eventModel->select('events.*, schools.name as school_name')
            ->join('schools', 'schools.id = events.school_id', 'left');

        if ($this->mySchoolId) {
            $builder->where('events.school_id', $this->mySchoolId);
        }

        $data = [
            'title' => 'Manajemen Agenda',
            'events' => $builder->orderBy('event_date', 'DESC')->findAll(),
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

        // Ambil scope dari form, default 'public' jika tidak ada
        $scope = $this->request->getPost('scope');
        if (empty($scope) || !in_array($scope, ['public', 'internal'])) {
            $scope = 'public';
        }

        $data = [
            'school_id' => $schoolId,
            'title' => $title,
            'slug' => $slug,
            'event_date' => $this->request->getPost('event_date'),
            'time_start' => $this->request->getPost('time_start') ?: null,
            'time_end' => $this->request->getPost('time_end') ?: null,
            'location' => $this->request->getPost('location') ?: null,
            'description' => $this->request->getPost('description') ?: null,
            'scope' => $scope
        ];

        try {
            if ($this->eventModel->skipValidation(true)->insert($data)) {
                return redirect()->to('/admin/events')->with('success', 'Agenda berhasil ditambahkan!');
            }

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
        // Cek Data Lama
        $check = $this->eventModel->find($id);
        if (!$check) {
            return redirect()->to('/admin/events')->with('error', 'Agenda tidak ditemukan.');
        }

        // Cek Kepemilikan (Kecuali Superadmin)
        if ($this->mySchoolId && $check['school_id'] != $this->mySchoolId) {
            return redirect()->to('/admin/events')->with('error', 'Akses Ditolak.');
        }

        // Validasi
        $rules = [
            'title' => 'required|min_length[3]',
            'event_date' => 'required|valid_date'
        ];

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

        // ✅ Ambil scope dengan benar - JANGAN PAKAI OPERATOR ?:
        $scopePost = $this->request->getPost('scope');

        // Debug: Log POST data
        log_message('debug', 'POST scope value: ' . var_export($scopePost, true));
        log_message('debug', 'All POST data: ' . json_encode($this->request->getPost()));

        // Validasi scope
        if (in_array($scopePost, ['public', 'internal'], true)) {
            $scope = $scopePost;
        } else {
            $scope = 'public'; // Default fallback
            log_message('warning', 'Invalid scope value received: ' . var_export($scopePost, true));
        }

        $data = [
            'title' => $title,
            'slug' => $slug,
            'event_date' => $this->request->getPost('event_date'),
            'time_start' => $this->request->getPost('time_start') ?: null,
            'time_end' => $this->request->getPost('time_end') ?: null,
            'location' => $this->request->getPost('location') ?: null,
            'description' => $this->request->getPost('description') ?: null,
            'scope' => $scope
        ];

        log_message('info', 'Updating Event #' . $id);
        log_message('info', 'Data to update: ' . json_encode($data));

        try {
            // ✅ PENTING: Skip validation untuk update
            $result = $this->eventModel->skipValidation(true)->update($id, $data);

            log_message('info', 'Update result: ' . var_export($result, true));

            if ($result) {
                return redirect()->to('/admin/events')->with('success', 'Agenda berhasil diupdate!');
            }

            // Jika gagal, cek error dari model
            $errors = $this->eventModel->errors();
            log_message('error', 'Update failed. Model errors: ' . json_encode($errors));

            return redirect()->back()->withInput()->with('error', 'Gagal update agenda. ' . json_encode($errors));
        } catch (\Exception $e) {
            log_message('error', 'Exception during update: ' . $e->getMessage());
            log_message('error', 'Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()->withInput()->with('error', 'Gagal mengupdate agenda: ' . $e->getMessage());
        }
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

            // Filter berdasarkan sekolah jika admin sekolah
            if ($this->mySchoolId) {
                $builder->where('school_id', $this->mySchoolId);
            }

            $events = $builder
                ->where('event_date >=', $start)
                ->where('event_date <=', $end)
                ->orderBy('event_date', 'ASC')
                ->get()
                ->getResultArray();

            $calendarEvents = [];
            foreach ($events as $event) {
                // Warna berdasarkan scope
                $color = ($event['scope'] == 'internal') ? '#dc3545' : '#7c3aed';

                $calendarEvents[] = [
                    'id' => $event['id'],
                    'title' => ($event['scope'] == 'internal' ? '🔒 ' : '') . $event['title'],
                    'start' => $event['event_date'] . (!empty($event['time_start']) ? 'T' . $event['time_start'] : ''),
                    'end' => $event['event_date'] . (!empty($event['time_end']) ? 'T' . $event['time_end'] : ''),
                    'location' => $event['location'] ?? '',
                    'description' => $event['description'] ?? '',
                    'url' => base_url('admin/events/edit/' . $event['id']),
                    'backgroundColor' => $color,
                    'borderColor' => $color,
                    'textColor' => '#ffffff'
                ];
            }

            return $this->response->setJSON($calendarEvents);
        } catch (\Exception $e) {
            log_message('error', 'Error in Admin getEvents: ' . $e->getMessage());
            return $this->response->setJSON([]);
        }
    }

    /**
     * Halaman Agenda Internal - Khusus yang login (Admin & Guru)
     */
    public function internal()
    {
        // Title dinamis
        if ($this->mySchoolId) {
            $school = $this->schoolModel->find($this->mySchoolId);
            $schoolName = $school ? $school['name'] : 'Sekolah';
            $data['title'] = 'Agenda Internal ' . $schoolName;
            $data['subtitle'] = 'Agenda khusus internal ' . $schoolName;
        } else {
            $data['title'] = 'Agenda Internal';
            $data['subtitle'] = 'Agenda khusus internal semua jenjang';
        }

        // Base query - filter scope internal
        $baseQuery = $this->eventModel->where('scope', 'internal');

        // Filter by school
        if ($this->mySchoolId) {
            // Admin Sekolah: hanya lihat agenda sekolahnya
            $baseQuery = $baseQuery->where('school_id', $this->mySchoolId);
        }
        // Superadmin: lihat semua agenda internal (tidak perlu filter tambahan)

        // Upcoming events (7 hari ke depan)
        $upcomingBuilder = clone $this->eventModel;
        $data['upcoming_events'] = $upcomingBuilder
            ->where('scope', 'internal')
            ->where('event_date >=', date('Y-m-d'))
            ->where('event_date <=', date('Y-m-d', strtotime('+7 days')))
            ->when($this->mySchoolId, function ($query) {
                return $query->where('school_id', $this->mySchoolId);
            })
            ->orderBy('event_date', 'ASC')
            ->orderBy('time_start', 'ASC')
            ->findAll();

        // All internal events
        $allBuilder = clone $this->eventModel;
        $data['all_internal_events'] = $allBuilder
            ->where('scope', 'internal')
            ->when($this->mySchoolId, function ($query) {
                return $query->where('school_id', $this->mySchoolId);
            })
            ->orderBy('event_date', 'DESC')
            ->findAll();

        // Count untuk info
        $data['upcoming_count'] = count($data['upcoming_events']);
        $data['total_count'] = count($data['all_internal_events']);

        return view('admin/events/internal', $data);
    }
}
