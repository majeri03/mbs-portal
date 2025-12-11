<?= $this->extend('layout/template_sekolah') ?>

<?= $this->section('content') ?>

<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= site_url('smk') ?>" class="text-decoration-none">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="<?= site_url('smk/agenda') ?>" class="text-decoration-none">Agenda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail</li>
                    </ol>
                </nav>

                <div class="card border-0 shadow rounded-4 overflow-hidden">
                    <div class="card-header text-white p-4 p-lg-5 text-center" style="background: var(--mbs-purple);">
                        <h1 class="fw-bold h2 mb-0"><?= esc($event['title']) ?></h1>
                    </div>
                    
                    <div class="card-body p-4 p-lg-5">
                        <div class="row g-4 mb-5">
                            <div class="col-md-4">
                                <div class="bg-light p-3 rounded-3 text-center border h-100 d-flex flex-column justify-content-center">
                                    <span class="text-muted small text-uppercase fw-bold">Tanggal</span>
                                    <span class="fs-4 fw-bold text-purple"><?= date('d F Y', strtotime($event['event_date'])) ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="bg-light p-3 rounded-3 text-center border h-100 d-flex flex-column justify-content-center">
                                    <span class="text-muted small text-uppercase fw-bold">Waktu</span>
                                    <span class="fs-4 fw-bold text-purple">
                                        <?= date('H:i', strtotime($event['time_start'])) ?> 
                                        <?= $event['time_end'] ? '- ' . date('H:i', strtotime($event['time_end'])) : '' ?>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="bg-light p-3 rounded-3 text-center border h-100 d-flex flex-column justify-content-center">
                                    <span class="text-muted small text-uppercase fw-bold">Lokasi</span>
                                    <span class="fs-5 fw-bold text-purple"><?= esc($event['location']) ?></span>
                                </div>
                            </div>
                        </div>

                        <h5 class="fw-bold text-purple border-bottom pb-2 mb-3">Deskripsi Kegiatan</h5>
                        <div class="lh-lg text-secondary">
                            <?= nl2br(esc($event['description'])) ?>
                        </div>

                        <div class="mt-5 text-center">
                            <a href="<?= site_url('smk/agenda') ?>" class="btn btn-outline-secondary rounded-pill px-4">
                                <i class="bi bi-arrow-left me-2"></i> Kembali ke Daftar Agenda
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>