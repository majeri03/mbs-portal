<?= $this->extend('layout/template_sekolah') ?>

<?= $this->section('content') ?>

<div class="bg-purple text-white py-5 mb-5 text-center">
    <div class="container">
        <h1 class="fw-bold display-5">Agenda Kegiatan</h1>
        <p class="lead opacity-75 mb-0">Jadwal Aktivitas & Acara MTs MBS</p>
    </div>
</div>

<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <?php if(!empty($events)): ?>
                <div class="d-flex flex-column gap-4">
                    <?php foreach($events as $e): ?>
                        <div class="card border-0 shadow-sm hover-card overflow-hidden rounded-4">
                            <div class="card-body p-0">
                                <div class="row g-0">
                                    <div class="col-md-2 bg-light d-flex flex-column align-items-center justify-content-center p-3 text-center border-end">
                                        <span class="display-5 fw-bold text-purple mb-0 lh-1">
                                            <?= date('d', strtotime($e['event_date'])) ?>
                                        </span>
                                        <span class="text-uppercase small fw-bold text-muted">
                                            <?= date('M Y', strtotime($e['event_date'])) ?>
                                        </span>
                                    </div>
                                    
                                    <div class="col-md-10 p-4 d-flex flex-column justify-content-center">
                                        <h4 class="fw-bold mb-2">
                                            <a href="<?= site_url('mts/agenda/'.$e['slug']) ?>" class="text-decoration-none text-dark hover-purple">
                                                <?= esc($e['title']) ?>
                                            </a>
                                        </h4>
                                        
                                        <div class="d-flex flex-wrap gap-3 text-secondary small mb-3">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-clock-fill text-purple me-2"></i>
                                                <?= $e['time_start'] ? date('H:i', strtotime($e['time_start'])) : '08:00' ?> 
                                                <?= $e['time_end'] ? ' - ' . date('H:i', strtotime($e['time_end'])) : ' - Selesai' ?> 
                                                WITA
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-geo-alt-fill text-purple me-2"></i>
                                                <?= esc($e['location'] ?? 'Lingkungan Sekolah') ?>
                                            </div>
                                        </div>
                                        
                                        <p class="text-muted mb-0 text-truncate">
                                            <?= substr(strip_tags($e['description']), 0, 150) ?>...
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <div class="bg-light rounded-circle d-inline-flex p-4 mb-3">
                        <i class="bi bi-calendar-x text-secondary fs-1"></i>
                    </div>
                    <h4 class="fw-bold text-secondary">Belum ada agenda</h4>
                    <p class="text-muted">Jadwal kegiatan akan segera diupdate oleh admin.</p>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<style>
    /* Custom Styles agar sesuai konsep */
    .hover-card { transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .hover-card:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(88, 44, 131, 0.1) !important; }
    .hover-purple:hover { color: var(--mbs-purple) !important; }
    .text-purple { color: var(--mbs-purple) !important; }
    .bg-purple { background-color: var(--mbs-purple) !important; }
</style>

<?= $this->endSection() ?>