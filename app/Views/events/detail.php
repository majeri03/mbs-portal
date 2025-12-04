<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('events') ?>">Agenda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail Kegiatan</li>
                    </ol>
                </nav>

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header text-white p-4" style="background: var(--mbs-purple);">
                        <h2 class="fw-bold mb-0 fs-3"><?= esc($event['title']) ?></h2>
                    </div>
                    
                    <div class="card-body p-4 p-lg-5">
                        <div class="d-flex flex-column flex-md-row align-items-start gap-4 mb-4">
                            <div class="bg-light rounded-3 p-3 text-center border shadow-sm" style="min-width: 120px;">
                                <span class="d-block display-4 fw-bold text-purple" style="line-height: 1;">
                                    <?= date('d', strtotime($event['event_date'])) ?>
                                </span>
                                <span class="d-block text-uppercase fw-bold text-muted">
                                    <?php 
                                        // Format Bulan Indonesia Manual
                                        $bulan = [
                                            'Jan' => 'Januari', 'Feb' => 'Februari', 'Mar' => 'Maret', 
                                            'Apr' => 'April', 'May' => 'Mei', 'Jun' => 'Juni', 
                                            'Jul' => 'Juli', 'Aug' => 'Agustus', 'Sep' => 'September', 
                                            'Oct' => 'Oktober', 'Nov' => 'November', 'Dec' => 'Desember'
                                        ];
                                        echo $bulan[date('M', strtotime($event['event_date']))] ?? date('M', strtotime($event['event_date']));
                                    ?>
                                    <?= date('Y', strtotime($event['event_date'])) ?>
                                </span>
                            </div>

                            <div class="flex-grow-1 pt-2">
                                <ul class="list-unstyled mb-0 d-grid gap-3">
                                    <li class="d-flex align-items-center text-muted">
                                        <div class="icon-square bg-purple-light rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: rgba(47, 63, 88, 0.1);">
                                            <i class="bi bi-clock-fill text-purple"></i>
                                        </div>
                                        <div>
                                            <strong class="d-block text-dark">Waktu Pelaksanaan</strong>
                                            <span>
                                                <?= $event['time_start'] ? date('H:i', strtotime($event['time_start'])) : '08:00' ?> 
                                                <?= $event['time_end'] ? ' s/d ' . date('H:i', strtotime($event['time_end'])) : ' Selesai' ?>
                                                WITA
                                            </span>
                                        </div>
                                    </li>
                                    <li class="d-flex align-items-center text-muted">
                                        <div class="icon-square bg-purple-light rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: rgba(47, 63, 88, 0.1);">
                                            <i class="bi bi-geo-alt-fill text-purple"></i>
                                        </div>
                                        <div>
                                            <strong class="d-block text-dark">Lokasi</strong>
                                            <span><?= esc($event['location'] ?? 'Kampus MBS') ?></span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <hr class="my-4 border-light">

                        <h5 class="fw-bold text-purple mb-3">Deskripsi Kegiatan</h5>
                        <div class="text-secondary lh-lg">
                            <?= nl2br(esc($event['description'] ?? 'Tidak ada deskripsi tambahan untuk kegiatan ini.')) ?>
                        </div>

                        <div class="mt-5 pt-3 border-top">
                            <a href="<?= base_url('events') ?>" class="btn btn-outline-secondary rounded-pill px-4 fw-semibold">
                                <i class="bi bi-arrow-left me-2"></i> Kembali ke Kalender
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .text-purple { color: var(--mbs-purple); }
    .bg-purple-light { background-color: rgba(47, 63, 88, 0.1); }
</style>
<?= $this->endSection() ?>