<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<!-- Header Section -->
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h4 class="mb-0">
            <i class="bi bi-lock-fill text-danger me-2"></i><?= esc($title) ?>
        </h4>
        <a href="<?= base_url('admin/events') ?>" class="btn btn-sm btn-light">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
    <p class="text-muted mb-0 small"><?= esc($subtitle) ?></p>
</div>

<!-- Stats Row -->
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center">
                <div class="icon-wrapper bg-danger bg-opacity-10 text-danger rounded-3 p-3 me-3">
                    <i class="bi bi-bell fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-1 small">7 Hari Ke Depan</p>
                    <h3 class="mb-0 fw-bold"><?= $upcoming_count ?></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center">
                <div class="icon-wrapper bg-secondary bg-opacity-10 text-secondary rounded-3 p-3 me-3">
                    <i class="bi bi-calendar-check fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-1 small">Total Internal</p>
                    <h3 class="mb-0 fw-bold"><?= $total_count ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upcoming Events Card -->
<?php if (!empty($upcoming_events)): ?>
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white border-bottom-0 py-3">
        <h6 class="mb-0 fw-semibold">
            <i class="bi bi-bell text-danger me-2"></i>Agenda Mendatang
        </h6>
    </div>
    <div class="card-body p-0">
        <?php foreach ($upcoming_events as $index => $event): ?>
            <?php 
            $isLast = ($index === count($upcoming_events) - 1);
            ?>
            <div class="p-3 <?= !$isLast ? 'border-bottom' : '' ?>">
                <div class="row align-items-center g-3">
                    <!-- Date -->
                    <div class="col-auto">
                        <div class="date-badge text-center">
                            <div class="date-day"><?= date('d', strtotime($event['event_date'])) ?></div>
                            <div class="date-month"><?= strtoupper(date('M', strtotime($event['event_date']))) ?></div>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="col">
                        <h6 class="mb-1 fw-semibold"><?= esc($event['title']) ?></h6>
                        <div class="text-muted small d-flex flex-wrap gap-3">
                            <span>
                                <i class="bi bi-calendar3 me-1"></i>
                                <?= date('l, d M Y', strtotime($event['event_date'])) ?>
                            </span>
                            <?php if ($event['time_start']): ?>
                                <span>
                                    <i class="bi bi-clock me-1"></i>
                                    <?= date('H:i', strtotime($event['time_start'])) ?>
                                    <?php if ($event['time_end']): ?>
                                        - <?= date('H:i', strtotime($event['time_end'])) ?>
                                    <?php endif; ?>
                                </span>
                            <?php endif; ?>
                            <?php if ($event['location']): ?>
                                <span>
                                    <i class="bi bi-geo-alt me-1"></i>
                                    <?= esc($event['location']) ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Action -->
                    <?php if (session()->get('role') !== 'guru'): ?>
                        <div class="col-auto">
                            <a href="<?= base_url('admin/events/edit/' . $event['id']) ?>" 
                               class="btn btn-sm btn-light">
                                <i class="bi bi-pencil"></i>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<!-- All Events Table -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom-0 py-3">
        <h6 class="mb-0 fw-semibold">
            <i class="bi bi-list-ul me-2"></i>Semua Agenda Internal
        </h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 simple-table">
                <thead>
                    <tr>
                        <th width="5%" class="ps-3">No</th>
                        <th>Agenda</th>
                        <th width="15%">Tanggal</th>
                        <th width="12%">Waktu</th>
                        <th width="18%">Lokasi</th>
                        <?php if (session()->get('role') !== 'guru'): ?>
                            <th width="8%" class="text-center pe-3">Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($all_internal_events)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-calendar-x fs-1 opacity-25"></i>
                                    <p class="mt-2 mb-0">Belum ada agenda internal</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php 
                        $no = 1; 
                        foreach ($all_internal_events as $event): 
                            $eventDate = strtotime($event['event_date']);
                            $today = strtotime(date('Y-m-d'));
                            $isToday = ($eventDate == $today);
                            $isTomorrow = ($eventDate == strtotime('+1 day', $today));
                        ?>
                            <tr>
                                <td class="ps-3"><?= $no++ ?></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <span><?= esc($event['title']) ?></span>
                                        <?php if ($isToday): ?>
                                            <span class="badge bg-danger badge-sm">Hari Ini</span>
                                        <?php elseif ($isTomorrow): ?>
                                            <span class="badge bg-warning text-dark badge-sm">Besok</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-muted small">
                                        <?= date('d M Y', strtotime($event['event_date'])) ?>
                                    </span>
                                </td>
                                <td class="text-muted small">
                                    <?php if ($event['time_start']): ?>
                                        <?= date('H:i', strtotime($event['time_start'])) ?>
                                        <?php if ($event['time_end']): ?>
                                            - <?= date('H:i', strtotime($event['time_end'])) ?>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td class="small">
                                    <span class="text-muted"><?= $event['location'] ? esc($event['location']) : '-' ?></span>
                                </td>
                                <?php if (session()->get('role') !== 'guru'): ?>
                                    <td class="text-center pe-3">
                                        <a href="<?= base_url('admin/events/edit/' . $event['id']) ?>" 
                                           class="btn btn-sm btn-light">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
/* Date Badge Styling */
.date-badge {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    color: white;
    border-radius: 10px;
    padding: 8px 12px;
    min-width: 60px;
    box-shadow: 0 2px 8px rgba(220, 53, 69, 0.2);
}

.date-day {
    font-size: 1.5rem;
    font-weight: 700;
    line-height: 1;
    margin-bottom: 2px;
}

.date-month {
    font-size: 0.65rem;
    font-weight: 600;
    letter-spacing: 0.5px;
}

/* Table Styling */
.simple-table thead th {
    background-color: #f8f9fa;
    border-bottom: 2px solid #e9ecef;
    font-weight: 600;
    font-size: 0.85rem;
    color: #495057;
    padding: 0.75rem;
}

.simple-table tbody td {
    padding: 1rem 0.75rem;
    vertical-align: middle;
    border-bottom: 1px solid #f1f3f5;
}

.simple-table tbody tr:last-child td {
    border-bottom: none;
}

.simple-table tbody tr:hover {
    background-color: #f8f9fa;
}

/* Badge Styling */
.badge-sm {
    font-size: 0.7rem;
    padding: 0.25rem 0.5rem;
    font-weight: 500;
}

/* Card Styling */
.card {
    border-radius: 12px;
    overflow: hidden;
}

.card-header {
    background-color: white;
}

/* Button Styling */
.btn-light {
    background-color: #f8f9fa;
    border: 1px solid #e9ecef;
    color: #495057;
}

.btn-light:hover {
    background-color: #e9ecef;
    border-color: #dee2e6;
    color: #212529;
}

/* Icon Wrapper */
.icon-wrapper {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Responsive */
@media (max-width: 768px) {
    .date-badge {
        min-width: 50px;
        padding: 6px 10px;
    }
    
    .date-day {
        font-size: 1.25rem;
    }
    
    .date-month {
        font-size: 0.6rem;
    }
}
</style>

<?= $this->endSection() ?>