<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Kalender Agenda') ?> - MBS Portal</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">

    <style>
        :root {
            --mbs-purple: #7c3aed;
            --mbs-purple-dark: #6d28d9;
            --mbs-purple-light: #a78bfa;
            --mbs-purple-lighter: #ddd6fe;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f3ff 0%, #ffffff 100%);
            color: #333;
        }

        /* ========== HEADER ========== */
        .header {
            background: linear-gradient(135deg, var(--mbs-purple) 0%, var(--mbs-purple-dark) 100%);
            color: white;
            padding: 30px 0;
            margin-bottom: 40px;
            box-shadow: 0 4px 20px rgba(124, 58, 237, 0.3);
        }

        .header h1 {
            font-weight: 800;
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .header p {
            opacity: 0.9;
            font-size: 1.1rem;
        }

        /* ========== CALENDAR CONTAINER ========== */
        .calendar-section {
            margin-bottom: 40px;
        }

        .calendar-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            border: 1px solid #f3f4f6;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .calendar-header h3 {
            color: var(--mbs-purple);
            font-weight: 700;
            font-size: 1.5rem;
            margin: 0;
        }

        .calendar-tabs {
            display: flex;
            gap: 10px;
        }

        .calendar-tab {
            padding: 10px 20px;
            border: 2px solid var(--mbs-purple-lighter);
            background: white;
            color: var(--mbs-purple);
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .calendar-tab:hover {
            background: var(--mbs-purple-lighter);
        }

        .calendar-tab.active {
            background: linear-gradient(135deg, var(--mbs-purple) 0%, var(--mbs-purple-dark) 100%);
            color: white;
            border-color: var(--mbs-purple);
        }

        /* ========== FULLCALENDAR CUSTOM STYLE ========== */
        #fullCalendar {
            border-radius: 15px;
            overflow: hidden;
        }

        .fc {
            font-family: 'Inter', sans-serif;
        }

        .fc .fc-toolbar-title {
            color: var(--mbs-purple);
            font-weight: 700;
            font-size: 1.5rem;
        }

        .fc .fc-button-primary {
            background: linear-gradient(135deg, var(--mbs-purple) 0%, var(--mbs-purple-dark) 100%);
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .fc .fc-button-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(124, 58, 237, 0.3);
        }

        .fc .fc-button-primary:not(:disabled).fc-button-active,
        .fc .fc-button-primary:not(:disabled):active {
            background: var(--mbs-purple-dark);
        }

        .fc-daygrid-day.fc-day-today {
            background: rgba(124, 58, 237, 0.1) !important;
        }

        .fc-event {
            border-radius: 6px;
            padding: 3px 6px;
            font-weight: 500;
            cursor: pointer;
        }

        /* ========== HIJRI CALENDAR ========== */
        .hijri-calendar {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            border: 1px solid #f3f4f6;
        }

        .hijri-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .hijri-header h4 {
            color: var(--mbs-purple);
            font-weight: 700;
            margin-bottom: 10px;
        }

        .hijri-month-year {
            font-size: 1.3rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .hijri-date-today {
            color: #666;
            font-size: 0.9rem;
        }

        .hijri-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 8px;
        }

        .hijri-day-name {
            text-align: center;
            font-weight: 700;
            color: var(--mbs-purple);
            padding: 10px 5px;
            font-size: 0.85rem;
        }

        .hijri-day {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s;
            cursor: pointer;
            position: relative;
            font-size: 0.9rem;
        }

        .hijri-day:hover {
            background: var(--mbs-purple-lighter);
            transform: scale(1.05);
        }

        .hijri-day.today {
            background: linear-gradient(135deg, var(--mbs-purple) 0%, var(--mbs-purple-dark) 100%);
            color: white;
            font-weight: 700;
        }

        .hijri-day.has-event::after {
            content: '';
            position: absolute;
            bottom: 5px;
            left: 50%;
            transform: translateX(-50%);
            width: 6px;
            height: 6px;
            background: var(--mbs-purple);
            border-radius: 50%;
        }

        .hijri-day.today.has-event::after {
            background: white;
        }

        .hijri-day.other-month {
            color: #ccc;
        }

        /* ========== UPCOMING EVENTS LIST ========== */
        .upcoming-events-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            border: 1px solid #f3f4f6;
        }

        .upcoming-events-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 25px;
        }

        .upcoming-events-header h4 {
            color: var(--mbs-purple);
            font-weight: 700;
            margin: 0;
        }

        .event-item {
            display: flex;
            gap: 20px;
            padding: 20px;
            border-radius: 15px;
            background: linear-gradient(135deg, #faf8ff 0%, #f5f3ff 100%);
            margin-bottom: 15px;
            transition: all 0.3s;
            border: 2px solid transparent;
        }

        .event-item:hover {
            transform: translateX(5px);
            border-color: var(--mbs-purple-light);
            box-shadow: 0 5px 20px rgba(124, 58, 237, 0.15);
        }

        .event-date-box {
            background: linear-gradient(135deg, var(--mbs-purple) 0%, var(--mbs-purple-dark) 100%);
            color: white;
            border-radius: 12px;
            padding: 15px;
            text-align: center;
            min-width: 80px;
            box-shadow: 0 4px 15px rgba(124, 58, 237, 0.3);
        }

        .event-date-box .day {
            font-size: 2rem;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 5px;
        }

        .event-date-box .month {
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            opacity: 0.9;
        }

        .event-details {
            flex: 1;
        }

        .event-title {
            font-weight: 700;
            font-size: 1.1rem;
            color: #333;
            margin-bottom: 8px;
        }

        .event-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            font-size: 0.9rem;
            color: #666;
        }

        .event-meta-item {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .event-meta-item i {
            color: var(--mbs-purple);
        }

        /* ========== EVENT MODAL ========== */
        .modal-content {
            border-radius: 20px;
            border: none;
            overflow: hidden;
        }

        .modal-header {
            background: linear-gradient(135deg, var(--mbs-purple) 0%, var(--mbs-purple-dark) 100%);
            color: white;
            border: none;
            padding: 25px 30px;
        }

        .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }

        .modal-body {
            padding: 30px;
        }

        .event-detail-item {
            display: flex;
            align-items: start;
            gap: 15px;
            padding: 15px;
            background: #f9fafb;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .event-detail-item i {
            color: var(--mbs-purple);
            font-size: 1.2rem;
            margin-top: 2px;
        }

        .event-detail-content h6 {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .event-detail-content p {
            margin: 0;
            color: #666;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 992px) {
            .header h1 {
                font-size: 2rem;
            }

            .calendar-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .calendar-tabs {
                width: 100%;
                justify-content: center;
            }

            .calendar-tab {
                flex: 1;
                text-align: center;
                padding: 10px 15px;
                font-size: 0.85rem;
            }
        }

        @media (max-width: 768px) {
            .header {
                padding: 20px 0;
            }

            .header h1 {
                font-size: 1.5rem;
            }

            .header p {
                font-size: 0.9rem;
            }

            .calendar-card,
            .hijri-calendar,
            .upcoming-events-card {
                padding: 20px;
                border-radius: 15px;
            }

            .calendar-header h3 {
                font-size: 1.2rem;
            }

            .event-item {
                flex-direction: column;
                gap: 15px;
            }

            .event-date-box {
                width: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 15px;
                padding: 15px 20px;
            }

            .event-date-box .day {
                font-size: 1.8rem;
            }

            .hijri-day {
                font-size: 0.8rem;
            }

            .hijri-day-name {
                font-size: 0.75rem;
                padding: 8px 3px;
            }

            .fc .fc-toolbar {
                flex-direction: column;
                gap: 10px;
            }

            .fc .fc-toolbar-title {
                font-size: 1.2rem;
            }
        }

        @media (max-width: 576px) {
            .calendar-tab {
                padding: 8px 12px;
                font-size: 0.8rem;
            }

            .hijri-grid {
                gap: 5px;
            }

            .hijri-day {
                font-size: 0.75rem;
            }

            .event-meta {
                flex-direction: column;
                gap: 8px;
            }
        }

        /* ========== LOADING ANIMATION ========== */
        .loading-spinner {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 50px;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 4px solid var(--mbs-purple-lighter);
            border-top-color: var(--mbs-purple);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <div class="container">
            <div class="text-center">
                <h1><i class="bi bi-calendar-event me-3"></i>Kalender Agenda</h1>
                <p>Pondok Pesantren Muhammadiyah Boarding School Enrekang</p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <div class="row">
            <!-- Left Column: Calendar -->
            <div class="col-lg-8 mb-4">
                <!-- Calendar Tabs -->
                <div class="calendar-section">
                    <div class="calendar-card">
                        <div class="calendar-header">
                            <h3><i class="bi bi-calendar3 me-2"></i>Kalender</h3>
                            <div class="calendar-tabs">
                                <button class="calendar-tab active" data-calendar="gregorian">
                                    <i class="bi bi-calendar-week me-2"></i>Masehi
                                </button>
                                <button class="calendar-tab" data-calendar="hijri">
                                    <i class="bi bi-moon-stars me-2"></i>Hijriah
                                </button>
                            </div>
                        </div>

                        <!-- Gregorian Calendar (FullCalendar) -->
                        <div id="gregorianCalendar" class="calendar-view">
                            <div id="fullCalendar"></div>
                        </div>

                        <!-- Hijri Calendar -->
                        <div id="hijriCalendar" class="calendar-view" style="display: none;">
                            <div class="hijri-calendar">
                                <div class="hijri-header">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <button class="btn btn-sm btn-outline-purple" id="prevHijriMonth">
                                            <i class="bi bi-chevron-left"></i>
                                        </button>
                                        <div>
                                            <div class="hijri-month-year" id="hijriMonthYear"></div>
                                            <div class="hijri-date-today" id="hijriToday"></div>
                                        </div>
                                        <button class="btn btn-sm btn-outline-purple" id="nextHijriMonth">
                                            <i class="bi bi-chevron-right"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="hijri-grid" id="hijriGrid">
                                    <!-- Day names -->
                                    <div class="hijri-day-name">Ahad</div>
                                    <div class="hijri-day-name">Senin</div>
                                    <div class="hijri-day-name">Selasa</div>
                                    <div class="hijri-day-name">Rabu</div>
                                    <div class="hijri-day-name">Kamis</div>
                                    <div class="hijri-day-name">Jumat</div>
                                    <div class="hijri-day-name">Sabtu</div>
                                    <!-- Days will be generated by JS -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Upcoming Events -->
            <div class="col-lg-4">
                <div class="upcoming-events-card">
                    <div class="upcoming-events-header">
                        <i class="bi bi-clock-history fs-4 text-purple"></i>
                        <h4>Agenda Mendatang</h4>
                    </div>

                    <div id="upcomingEventsList">
                        <?php if (!empty($upcoming_events)): ?>
                            <?php foreach ($upcoming_events as $event): ?>
                                <div class="event-item">
                                    <div class="event-date-box">
                                        <div class="day"><?= date('d', strtotime($event['event_date'])) ?></div>
                                        <div class="month"><?= strftime('%b', strtotime($event['event_date'])) ?></div>
                                    </div>
                                    <div class="event-details">
                                        <div class="event-title"><?= esc($event['title']) ?></div>
                                        <div class="event-meta">
                                            <?php if ($event['time_start']): ?>
                                                <div class="event-meta-item">
                                                    <i class="bi bi-clock"></i>
                                                    <span><?= date('H:i', strtotime($event['time_start'])) ?></span>
                                                </div>
                                            <?php endif; ?>
                                            <?php if ($event['location']): ?>
                                                <div class="event-meta-item">
                                                    <i class="bi bi-geo-alt"></i>
                                                    <span><?= esc($event['location']) ?></span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <i class="bi bi-calendar-x fs-1 text-muted d-block mb-3"></i>
                                <p class="text-muted mb-0">Tidak ada agenda mendatang</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Event Detail Modal -->
    <div class="modal fade" id="eventModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalTitle">
                        <i class="bi bi-calendar-check me-2"></i>
                        <span id="modalEventTitle"></span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="event-detail-item">
                        <i class="bi bi-calendar3"></i>
                        <div class="event-detail-content">
                            <h6>Tanggal</h6>
                            <p id="modalEventDate"></p>
                        </div>
                    </div>
                    <div class="event-detail-item">
                        <i class="bi bi-clock"></i>
                        <div class="event-detail-content">
                            <h6>Waktu</h6>
                            <p id="modalEventTime"></p>
                        </div>
                    </div>
                    <div class="event-detail-item" id="modalLocationWrapper" style="display: none;">
                        <i class="bi bi-geo-alt"></i>
                        <div class="event-detail-content">
                            <h6>Lokasi</h6>
                            <p id="modalEventLocation"></p>
                        </div>
                    </div>
                    <div class="event-detail-item" id="modalDescriptionWrapper" style="display: none;">
                        <i class="bi bi-card-text"></i>
                        <div class="event-detail-content">
                            <h6>Deskripsi</h6>
                            <p id="modalEventDescription"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

    <!-- Main Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let calendar;
            let currentHijriMonth = new Date().getMonth() + 1;
            let currentHijriYear = new Date().getFullYear();
            let allEvents = [];

            // Initialize FullCalendar (Gregorian)
            initFullCalendar();

            // Initialize Hijri Calendar
            initHijriCalendar();

            // Calendar Tab Switching
            document.querySelectorAll('.calendar-tab').forEach(tab => {
                tab.addEventListener('click', function() {
                    const calendarType = this.dataset.calendar;

                    // Update active tab
                    document.querySelectorAll('.calendar-tab').forEach(t => t.classList.remove('active'));
                    this.classList.add('active');

                    // Show/hide calendars
                    if (calendarType === 'gregorian') {
                        document.getElementById('gregorianCalendar').style.display = 'block';
                        document.getElementById('hijriCalendar').style.display = 'none';
                    } else {
                        document.getElementById('gregorianCalendar').style.display = 'none';
                        document.getElementById('hijriCalendar').style.display = 'block';
                    }
                });
            });

            // Initialize FullCalendar
            function initFullCalendar() {
                const calendarEl = document.getElementById('fullCalendar');

                calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,dayGridWeek'
                    },
                    locale: 'id',
                    buttonText: {
                        today: 'Hari Ini',
                        month: 'Bulan',
                        week: 'Minggu'
                    },
                    events: function(info, successCallback, failureCallback) {
                        fetch(`<?= base_url('events/getEvents') ?>?start=${info.startStr}&end=${info.endStr}`)
                            .then(response => response.json())
                            .then(data => {
                                allEvents = data;
                                successCallback(data);
                            })
                            .catch(error => {
                                console.error('Error loading events:', error);
                                failureCallback(error);
                            });
                    },
                    eventClick: function(info) {
                        showEventModal(info.event);
                    },
                    eventDidMount: function(info) {
                        info.el.style.cursor = 'pointer';
                    }
                });

                calendar.render();
            }

            // Initialize Hijri Calendar
            function initHijriCalendar() {
                const today = new Date();
                const hijriDate = gregorianToHijri(today);
                currentHijriMonth = hijriDate.month;
                currentHijriYear = hijriDate.year;

                renderHijriCalendar();

                // Navigation buttons
                document.getElementById('prevHijriMonth').addEventListener('click', () => {
                    currentHijriMonth--;
                    if (currentHijriMonth < 1) {
                        currentHijriMonth = 12;
                        currentHijriYear--;
                    }
                    renderHijriCalendar();
                });

                document.getElementById('nextHijriMonth').addEventListener('click', () => {
                    currentHijriMonth++;
                    if (currentHijriMonth > 12) {
                        currentHijriMonth = 1;
                        currentHijriYear++;
                    }
                    renderHijriCalendar();
                });
            }

            // Render Hijri Calendar
            function renderHijriCalendar() {
                const hijriMonths = [
                    'Muharram', 'Safar', 'Rabiul Awal', 'Rabiul Akhir',
                    'Jumadil Awal', 'Jumadil Akhir', 'Rajab', "Sya'ban",
                    'Ramadan', 'Syawal', 'Dzulqaidah', 'Dzulhijjah'
                ];

                // Update header
                document.getElementById('hijriMonthYear').textContent = 
                    `${hijriMonths[currentHijriMonth - 1]} ${currentHijriYear} H`;

                const today = new Date();
                const todayHijri = gregorianToHijri(today);
                document.getElementById('hijriToday').textContent = 
                    `${todayHijri.day} ${hijriMonths[todayHijri.month - 1]} ${todayHijri.year} H`;

                // Generate calendar days
                const grid = document.getElementById('hijriGrid');
                
                // Clear existing days (keep day names)
                while (grid.children.length > 7) {
                    grid.removeChild(grid.lastChild);
                }

                // Get first day of month in Gregorian
                const firstDayGregorian = hijriToGregorian(currentHijriYear, currentHijriMonth, 1);
                const firstDayOfWeek = firstDayGregorian.getDay();

                // Days in Hijri month (approximate)
                const daysInMonth = 29; // Simplified, should use actual Hijri calculation

                // Add empty cells for days before month starts
                for (let i = 0; i < firstDayOfWeek; i++) {
                    const emptyDay = document.createElement('div');
                    emptyDay.className = 'hijri-day other-month';
                    grid.appendChild(emptyDay);
                }

                // Add days of month
                for (let day = 1; day <= daysInMonth; day++) {
                    const dayEl = document.createElement('div');
                    dayEl.className = 'hijri-day';
                    dayEl.textContent = day;

                    // Check if today
                    if (day === todayHijri.day && 
                        currentHijriMonth === todayHijri.month && 
                        currentHijriYear === todayHijri.year) {
                        dayEl.classList.add('today');
                    }

                    // Check if has event (simplified)
                    const gregorianDate = hijriToGregorian(currentHijriYear, currentHijriMonth, day);
                    if (hasEventOnDate(gregorianDate)) {
                        dayEl.classList.add('has-event');
                    }

                    grid.appendChild(dayEl);
                }
            }

            // Show Event Modal
            function showEventModal(event) {
                document.getElementById('modalEventTitle').textContent = event.title;
                
                // Format date
                const eventDate = new Date(event.start);
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                document.getElementById('modalEventDate').textContent = 
                    eventDate.toLocaleDateString('id-ID', options);

                // Format time
                const timeStart = event.extendedProps.time_start;
                const timeEnd = event.extendedProps.time_end;
                let timeText = 'Sepanjang hari';
                if (timeStart) {
                    timeText = timeStart.substring(0, 5);
                    if (timeEnd) {
                        timeText += ' - ' + timeEnd.substring(0, 5);
                    }
                }
                document.getElementById('modalEventTime').textContent = timeText;

                // Location
                const location = event.extendedProps.location;
                if (location) {
                    document.getElementById('modalEventLocation').textContent = location;
                    document.getElementById('modalLocationWrapper').style.display = 'flex';
                } else {
                    document.getElementById('modalLocationWrapper').style.display = 'none';
                }

                // Description
                const description = event.extendedProps.description;
                if (description) {
                    document.getElementById('modalEventDescription').textContent = description;
                    document.getElementById('modalDescriptionWrapper').style.display = 'flex';
                } else {
                    document.getElementById('modalDescriptionWrapper').style.display = 'none';
                }

                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('eventModal'));
                modal.show();
            }

            // Helper: Check if date has event
            function hasEventOnDate(date) {
                const dateStr = date.toISOString().split('T')[0];
                return allEvents.some(event => event.start.includes(dateStr));
            }

            // Helper: Gregorian to Hijri conversion (simplified algorithm)
            function gregorianToHijri(date) {
                const day = date.getDate();
                const month = date.getMonth() + 1;
                const year = date.getFullYear();

                // Simplified conversion (use proper library for production)
                const jd = Math.floor((1461 * (year + 4800 + Math.floor((month - 14) / 12))) / 4) +
                           Math.floor((367 * (month - 2 - 12 * (Math.floor((month - 14) / 12)))) / 12) -
                           Math.floor((3 * (Math.floor((year + 4900 + Math.floor((month - 14) / 12)) / 100))) / 4) +
                           day - 32075;

                const l = jd - 1948440 + 10632;
                const n = Math.floor((l - 1) / 10631);
                const l2 = l - 10631 * n + 354;
                const j = (Math.floor((10985 - l2) / 5316)) * (Math.floor((50 * l2) / 17719)) +
                         (Math.floor(l2 / 5670)) * (Math.floor((43 * l2) / 15238));
                const l3 = l2 - (Math.floor((30 - j) / 15)) * (Math.floor((17719 * j) / 50)) -
                          (Math.floor(j / 16)) * (Math.floor((15238 * j) / 43)) + 29;
                const m = Math.floor((24 * l3) / 709);
                const d = l3 - Math.floor((709 * m) / 24);
                const y = 30 * n + j - 30;

                return { day: d, month: m, year: y };
            }

            // Helper: Hijri to Gregorian conversion (simplified)
            function hijriToGregorian(year, month, day) {
                // Simplified conversion - use proper library for production
                const jd = Math.floor((11 * year + 3) / 30) + 354 * year + 30 * month -
                          Math.floor((month - 1) / 2) + day + 1948440 - 385;

                const l = jd + 68569;
                const n = Math.floor((4 * l) / 146097);
                const l2 = l - Math.floor((146097 * n + 3) / 4);
                const i = Math.floor((4000 * (l2 + 1)) / 1461001);
                const l3 = l2 - Math.floor((1461 * i) / 4) + 31;
                const j = Math.floor((80 * l3) / 2447);
                const d = l3 - Math.floor((2447 * j) / 80);
                const l4 = Math.floor(j / 11);
                const m = j + 2 - 12 * l4;
                const y = 100 * (n - 49) + i + l4;

                return new Date(y, m - 1, d);
            }
        });

        // Additional CSS for purple outline button
        const style = document.createElement('style');
        style.textContent = `
            .btn-outline-purple {
                border: 2px solid var(--mbs-purple);
                color: var(--mbs-purple);
                background: transparent;
                border-radius: 8px;
                transition: all 0.3s;
            }
            .btn-outline-purple:hover {
                background: var(--mbs-purple);
                color: white;
            }
            .text-purple {
                color: var(--mbs-purple);
            }
        `;
        document.head.appendChild(style);
    </script>
</body>

</html>