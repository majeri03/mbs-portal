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

        // Cek apakah user sudah login dan role/schoolnya
        $isLoggedIn = session()->get('logged_in');
        $userRole = session()->get('role');
        $isInternal = ($isLoggedIn && $userRole === 'superadmin');
        // Query upcoming events dengan filter scope
        $eventBuilder = $this->eventModel
            ->where('school_id', null) // Hanya agenda pusat
            ->where('event_date >=', date('Y-m-d'));

        // Jika BELUM LOGIN atau BUKAN SUPERADMIN, hanya tampilkan PUBLIC
        if (!$isInternal) {
            $eventBuilder->where('scope', 'public');
        }
        $data['upcoming_events'] = $eventBuilder
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
        // if (!$this->request->isAJAX()) {
        //     return $this->response->setStatusCode(403)->setBody("Forbidden Access");
        // }
        $isLoggedIn = session()->get('logged_in');
        $userSchoolId = session()->get('school_id');
        $userRole     = session()->get('role');
        try {
            $start = $this->request->getGet('start');
            $end = $this->request->getGet('end');
            $schoolId = $this->request->getGet('school_id');

            $builder = $this->eventModel->where('event_date >=', $start)
                ->where('event_date <=', $end);

            if (!empty($schoolId) && is_numeric($schoolId)) {
                // KASUS A: Web Sekolah
                // HANYA ambil agenda milik sekolah ini. Hapus 'orWhere' pusat.
                $builder->where('school_id', $schoolId);

                // Cek Hak Akses Internal Khusus Sekolah Ini
                $canSeeInternal = ($isLoggedIn && ($userRole == 'superadmin' || $userSchoolId == $schoolId));
            } else {
                // KASUS B: Web Pusat
                // Tampilkan Agenda Pusat + Agenda PUBLIK Sekolah Lain
                $builder->groupStart()
                    ->where('school_id', null) // Agenda Pusat
                    ->orGroupStart()
                    ->where('school_id !=', null)
                    ->where('scope', 'public') // Sekolah lain cuma boleh nunjukin yang public
                    ->groupEnd()
                    ->groupEnd();

                // Di pusat, internal hanya untuk superadmin
                $canSeeInternal = ($isLoggedIn && $userRole == 'superadmin');
            }
            // --- 2. FILTER PRIVASI (SCOPE) ---
            if (!$canSeeInternal) {
                // Jika bukan orang dalam, paksa hanya Public
                $builder->where('scope', 'public');
            }
            $events = $builder->orderBy('event_date', 'ASC')->findAll();
            $calendarEvents = [];
            foreach ($events as $event) {
                // Logika Warna:
                if ($event['scope'] == 'internal') {
                    $color = '#dc3545'; // MERAH untuk Internal (Penting)
                    $titlePrefix = '🔒'; // Kasih ikon gembok biar jelas
                } elseif ($event['school_id'] == null) {
                    $color = '#2f3f58'; // UNGU untuk Pusat
                    $titlePrefix = '';
                } else {
                    $color = '#1e016dff'; // HIJAU untuk Sekolah
                    $titlePrefix = '';
                }
                $calendarEvents[] = [
                    'id' => $event['id'],
                    'title' => $titlePrefix . $event['title'],
                    'start' => $event['event_date'] . (!empty($event['time_start']) ? 'T' . $event['time_start'] : ''),
                    'end' => $event['event_date'] . (!empty($event['time_end']) ? 'T' . $event['time_end'] : ''),
                    'location' => $event['location'] ?? '',
                    'description' => $event['description'] ?? '',
                    'url' => base_url('events/' . $event['slug']),
                    'backgroundColor' => $color,
                    'borderColor' => $color,
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
