<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">

<style>
    :root {
        --mbs-purple: #2f3f58;
        --mbs-purple-dark: #e8ecf1;
        --mbs-purple-light: #4a5a73;
        --mbs-purple-lighter: #e8ecf1;
    }

    /* ========== CALENDAR CONTAINER ========== */
    .calendar-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        border: 1px solid #f3f4f6;
    }

    .calendar-header h3 {
        color: var(--mbs-purple);
        font-weight: 700;
        font-size: 1.5rem;
        margin-bottom: 20px;
    }

    /* ========== FULLCALENDAR CUSTOM STYLE ========== */
    #fullCalendar {
        border-radius: 15px;
        overflow: hidden;
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
        box-shadow: 0 5px 15px rgba(47, 63, 88, 0.3);
    }

    .fc .fc-button-primary:not(:disabled).fc-button-active,
    .fc .fc-button-primary:not(:disabled):active {
        background: var(--mbs-purple-dark);
    }

    .fc-daygrid-day.fc-day-today {
        background: rgba(47, 63, 88, 0.1) !important;
    }

    .fc-event {
        border-radius: 6px;
        padding: 3px 6px;
        font-weight: 500;
        cursor: pointer;
        border: none;
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
        box-shadow: 0 5px 20px rgba(47, 63, 88, 0.15);
    }

    .event-date-box {
        background: linear-gradient(135deg, var(--mbs-purple) 0%, var(--mbs-purple-dark) 100%);
        color: white;
        border-radius: 12px;
        padding: 15px;
        text-align: center;
        min-width: 80px;
        box-shadow: 0 4px 15px rgba(47, 63, 88, 0.3);
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

    .event-details { flex: 1; }

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

    .event-meta-item i { color: var(--mbs-purple); }

    /* ========== RESPONSIVE ========== */
    @media (max-width: 768px) {
        .calendar-card, .upcoming-events-card { padding: 20px; border-radius: 15px; }
        .event-item { flex-direction: column; gap: 15px; }
        .event-date-box { width: 100%; display: flex; align-items: center; justify-content: center; gap: 15px; padding: 15px 20px; }
        .event-date-box .day { font-size: 1.8rem; }
        .fc .fc-toolbar { flex-direction: column; gap: 10px; }
        .fc .fc-toolbar-title { font-size: 1.2rem; }
    }
</style>

<div class="bg-purple text-white py-5 mb-5" style="background: linear-gradient(135deg, var(--mbs-purple) 0%, var(--mbs-purple-dark) 100%);">
    <div class="container text-center">
        <h1 class="fw-bold display-5">Kalender Agenda</h1>
        <p class="lead opacity-75 mb-0">Pondok Pesantren Muhammadiyah Boarding School</p>
    </div>
</div>

<div class="container pb-5">
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="calendar-card">
                <div class="calendar-header">
                    <h3><i class="bi bi-calendar3 me-2"></i>Jadwal Kegiatan</h3>
                </div>
                <div id="fullCalendar"></div>
            </div>
        </div>

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
                                    <div class="month">
                                        <?php
                                            // Format Bulan Indonesia
                                            $bulanIndo = [
                                                'Jan' => 'Jan', 'Feb' => 'Feb', 'Mar' => 'Mar', 'Apr' => 'Apr', 
                                                'May' => 'Mei', 'Jun' => 'Jun', 'Jul' => 'Jul', 'Aug' => 'Agu', 
                                                'Sep' => 'Sep', 'Oct' => 'Okt', 'Nov' => 'Nov', 'Dec' => 'Des'
                                            ];
                                            echo $bulanIndo[date('M', strtotime($event['event_date']))];
                                        ?>
                                    </div>
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

<div class="modal fade" id="eventModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 overflow-hidden shadow-lg">
            <div class="modal-header text-white" style="background: var(--mbs-purple);">
                <h5 class="modal-title fw-bold" id="eventModalTitle">
                    <i class="bi bi-calendar-check me-2"></i>
                    <span id="modalEventTitle"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            
            <div class="modal-body p-4">
                <div class="d-flex gap-3 mb-3">
                    <div class="text-center" style="width: 40px;">
                        <i class="bi bi-calendar3 fs-4" style="color: var(--mbs-purple);"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1 text-dark">Waktu Pelaksanaan</h6>
                        <p class="mb-0 text-muted" id="modalEventDate"></p>
                        <p class="mb-0 text-muted" id="modalEventTime"></p>
                    </div>
                </div>
                
                <div class="d-flex gap-3 mb-3" id="modalLocationWrapper">
                    <div class="text-center" style="width: 40px;">
                        <i class="bi bi-geo-alt fs-4" style="color: var(--mbs-purple);"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1 text-dark">Lokasi</h6>
                        <p class="mb-0 text-muted" id="modalEventLocation"></p>
                    </div>
                </div>

                <div class="d-flex gap-3" id="modalDescriptionWrapper">
                    <div class="text-center" style="width: 40px;">
                        <i class="bi bi-card-text fs-4" style="color: var(--mbs-purple);"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1 text-dark">Deskripsi</h6>
                        <p class="mb-0 text-muted" id="modalEventDescription" style="white-space: pre-line;"></p>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer bg-light border-0">
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        initFullCalendar();

        function initFullCalendar() {
            const calendarEl = document.getElementById('fullCalendar');

            const calendar = new FullCalendar.Calendar(calendarEl, {
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
                            successCallback(data);
                        })
                        .catch(error => {
                            console.error('Error loading events:', error);
                            failureCallback(error);
                        });
                },
                eventClick: function(info) {
                    info.jsEvent.preventDefault(); // Cegah redirect
                    showEventModal(info.event);    // Tampilkan modal
                },
                eventDidMount: function(info) {
                    info.el.style.cursor = 'pointer';
                    info.el.title = info.event.title;
                }
            });

            calendar.render();
        }

        function showEventModal(event) {
            document.getElementById('modalEventTitle').textContent = event.title;
            
            // Format Tanggal Indonesia
            const eventDate = new Date(event.start);
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            document.getElementById('modalEventDate').textContent = 
                eventDate.toLocaleDateString('id-ID', options);

            // Format Waktu
            const timeStart = event.extendedProps.time_start;
            const timeEnd = event.extendedProps.time_end;
            let timeText = 'Sepanjang hari';
            if (timeStart) {
                timeText = timeStart.substring(0, 5);
                if (timeEnd) {
                    timeText += ' - ' + timeEnd.substring(0, 5);
                }
                timeText += ' WITA';
            }
            document.getElementById('modalEventTime').textContent = timeText;

            // Lokasi
            const location = event.extendedProps.location;
            if (location) {
                document.getElementById('modalEventLocation').textContent = location;
                document.getElementById('modalLocationWrapper').classList.remove('d-none');
                document.getElementById('modalLocationWrapper').classList.add('d-flex');
            } else {
                document.getElementById('modalLocationWrapper').classList.remove('d-flex');
                document.getElementById('modalLocationWrapper').classList.add('d-none');
            }

            // Deskripsi
            const description = event.extendedProps.description;
            if (description) {
                document.getElementById('modalEventDescription').textContent = description;
                document.getElementById('modalDescriptionWrapper').classList.remove('d-none');
                document.getElementById('modalDescriptionWrapper').classList.add('d-flex');
            } else {
                document.getElementById('modalDescriptionWrapper').classList.remove('d-flex');
                document.getElementById('modalDescriptionWrapper').classList.add('d-none');
            }

            // Tampilkan Modal
            const modal = new bootstrap.Modal(document.getElementById('eventModal'));
            modal.show();
        }
    });
</script>

<?= $this->endSection() ?>