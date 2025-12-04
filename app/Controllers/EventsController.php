<?php

namespace App\Controllers;

use App\Models\EventModel;
use App\Models\SettingModel; // Tambahkan Model Setting
use CodeIgniter\Controller;

class EventsController extends Controller
{
    protected $eventModel;
    protected $settingModel; // Tambahkan properti ini

    public function __construct()
    {
        $this->eventModel = new EventModel();
        $this->settingModel = new SettingModel(); // Load Model Setting
        helper(['hijri', 'text', 'url']);
    }

    /**
     * Display calendar view
     */
    public function calendar()
    {
        // Ambil Settings agar layout tidak error
        $data['site'] = $this->settingModel->getSiteSettings();
        
        $data['title'] = 'Kalender Agenda';
        $data['upcoming_events'] = $this->eventModel
            ->where('event_date >=', date('Y-m-d'))
            ->orderBy('event_date', 'ASC')
            ->limit(5)
            ->findAll();

        return view('events/calendar', $data);
    }

    /**
     * Get events for FullCalendar (AJAX)
     */
    public function getEvents()
    {
        try {
            $start = $this->request->getGet('start');
            $end = $this->request->getGet('end');

            if (empty($start) || empty($end)) {
                return $this->response->setJSON([]);
            }

            $events = $this->eventModel
                ->where('event_date >=', $start)
                ->where('event_date <=', $end)
                ->orderBy('event_date', 'ASC')
                ->findAll();

            $calendarEvents = [];
            foreach ($events as $event) {
                $calendarEvents[] = [
                    'id' => $event['id'],
                    'title' => $event['title'],
                    'start' => $event['event_date'] . (!empty($event['time_start']) ? 'T' . $event['time_start'] : ''),
                    'end' => $event['event_date'] . (!empty($event['time_end']) ? 'T' . $event['time_end'] : ''),
                    'location' => $event['location'] ?? '',
                    'description' => $event['description'] ?? '',
                    'url' => base_url('events/' . $event['slug']),
                    'backgroundColor' => '#2f3f58',
                    'borderColor' => '#1a253a',
                    'textColor' => '#ffffff',
                    'extendedProps' => [
                        'location' => $event['location'] ?? '',
                        'description' => strip_tags($event['description'] ?? ''),
                        'time_start' => $event['time_start'] ?? '',
                        'time_end' => $event['time_end'] ?? ''
                    ]
                ];
            }

            return $this->response->setJSON($calendarEvents);
        } catch (\Exception $e) {
            return $this->response->setJSON([]);
        }
    }

    /**
     * Show single event detail
     */
    public function show($slug)
    {
        $event = $this->eventModel->where('slug', $slug)->first();

        if (!$event) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Ambil Settings agar layout tidak error saat buka detail
        $data['site'] = $this->settingModel->getSiteSettings();
        
        $data['title'] = $event['title'];
        $data['event'] = $event;

        return view('events/detail', $data);
    }
}