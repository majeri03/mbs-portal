<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\EventModel;

class Events extends BaseController
{
    protected $eventModel;
    protected $session;

    public function __construct()
    {
        $this->eventModel = new EventModel();
        $this->session = \Config\Services::session();
        helper(['form', 'url', 'text']);
    }

    /**
     * Display list of events
     */
    public function index()
    {
        $data = [
            'title' => 'Manajemen Agenda',
            'events' => $this->eventModel->orderBy('event_date', 'DESC')->findAll()
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

        // PENTING: Hanya kirim field yang ada di allowedFields
        $data = [
            'title' => $title,
            'slug' => $slug,
            'event_date' => $this->request->getPost('event_date'),
            'time_start' => $this->request->getPost('time_start') ?: null,
            'time_end' => $this->request->getPost('time_end') ?: null,
            'location' => $this->request->getPost('location') ?: null,
            'description' => $this->request->getPost('description') ?: null
        ];

        // Tambahkan school_id jika ada
        $schoolId = $this->request->getPost('school_id');
        if (!empty($schoolId)) {
            $data['school_id'] = $schoolId;
        }

        try {
            if ($this->eventModel->skipValidation(true)->insert($data)){
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
        $event = $this->eventModel->find($id);

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
        $event = $this->eventModel->find($id);

        if (!$event) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

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
        
        // Hanya generate slug baru jika title berubah
        if ($title !== $event['title']) {
            $slug = url_title($title, '-', true) . '-' . time();
        } else {
            $slug = $event['slug'];
        }

        $data = [
            'title' => $title,
            'slug' => $slug,
            'event_date' => $this->request->getPost('event_date'),
            'time_start' => $this->request->getPost('time_start') ?: null,
            'time_end' => $this->request->getPost('time_end') ?: null,
            'location' => $this->request->getPost('location') ?: null,
            'description' => $this->request->getPost('description') ?: null
        ];

        // Tambahkan school_id jika ada
        $schoolId = $this->request->getPost('school_id');
        if (!empty($schoolId)) {
            $data['school_id'] = $schoolId;
        }

        try {
            if ($this->eventModel->skipValidation(true)->update($id, $data)) {
                return redirect()->to('/admin/events')->with('success', 'Agenda berhasil diupdate!');
            }

            return redirect()->back()->withInput()->with('errors', $this->eventModel->errors());
        } catch (\Exception $e) {
            log_message('error', 'Error updating event: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Gagal mengupdate agenda: ' . $e->getMessage());
        }
    }

    /**
     * Delete event
     */
    public function delete($id)
    {
        $event = $this->eventModel->find($id);

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
                    'backgroundColor' => '#7c3aed',
                    'borderColor' => '#6d28d9',
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