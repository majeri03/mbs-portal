<?= $this->extend('layout/template_sekolah') ?>

<?= $this->section('content') ?>

<style>
    /* --- CSS Tambahan Khusus Halaman Ini --- */

    /* 1. Menghilangkan Panah Navigasi Swiper */
    .swiper-button-next,
    .swiper-button-prev {
        display: none !important;
    }

    /* 2. Style untuk Efek Overlapping (Menimpa) */
    .section-overlap {
        position: relative;
        z-index: 10;
        /* Agar berada di atas slider */
        margin-top: -100px;
        /* KUNCI: Menarik konten ke atas */
    }

    /* Agar Card Program terlihat menonjol */
    .program-card {
        background: white;
        transition: all 0.3s ease;
        border: none;
    }

    .program-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 1rem 3rem rgba(88, 44, 131, 0.15) !important;
    }

    .icon-box-purple {
        width: 80px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: var(--mbs-purple);
        color: white;
        border-radius: 50%;
        margin-bottom: 1.5rem;
    }

    /* Warna Khusus MBS (Ungu) */
    :root {
        --mbs-purple: #582C83;
        --mbs-purple-light: #f3e5f5;
    }

    .text-purple {
        color: var(--mbs-purple) !important;
    }

    .bg-purple {
        background-color: var(--mbs-purple) !important;
    }

    /* Section Title Style */
    .section-title {
        position: relative;
        display: inline-block;
        padding-bottom: 10px;
        margin-bottom: 30px;
        font-weight: 800;
        color: var(--mbs-purple);
    }

    .section-title::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 50px;
        height: 4px;
        background-color: var(--mbs-purple);
    }

    .hover-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(88, 44, 131, 0.15) !important;
    }

    .hero-section {
        height: 85vh;
        min-height: 600px;
        position: relative;
    }

    .heroSwiper .swiper-slide {
        height: 85vh;
        min-height: 600px;
        position: relative;
        overflow: hidden;
    }

    /* Background Image & Zoom Effect */
    .hero-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        transition: transform 8s ease;
        /* Efek zoom lambat */
        transform: scale(1);
    }

    .swiper-slide-active .hero-bg {
        transform: scale(1.1);
    }

    /* Zoom saat aktif */

    /* Overlay Gradient (Ungu Transparan ke Gelap) */
    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(88, 44, 131, 0.85) 0%, rgba(61, 31, 92, 0.7) 100%);
        z-index: 1;
    }

    /* Typography */
    .hero-title {
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        letter-spacing: -1px;
    }

    .hero-desc {
        text-shadow: 0 1px 5px rgba(0, 0, 0, 0.3);
        font-weight: 300;
    }

    /* Button Hover */
    .btn-hero {
        transition: all 0.3s ease;
        border: 2px solid white;
    }

    .btn-hero:hover {
        background-color: transparent;
        color: white;
        transform: translateY(-3px);
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {

        .hero-section,
        .swiper-slide {
            height: auto;
            min-height: 500px;
            padding-bottom: 50px;
        }

        .hero-title {
            font-size: 2.5rem;
        }
    }

    /* --- LOGIKA OVERLAP / FLOAT --- */
    .floating-section {
        position: relative;
        z-index: 10;
        /* Pastikan layer-nya di atas slider */
        padding-bottom: 20px;
    }

    /* Hanya untuk Layar Desktop (Lebar > 992px) */
    @media (min-width: 992px) {
        .hero-content-wrapper {
            /* Jarak dari Navbar */
            padding-top: 180px;
            /* Ruang kosong di bawah untuk ditimpa kartu */
            padding-bottom: 180px;
            min-height: 90vh;
        }

        .floating-section {
            margin-top: -120px;
            /* Naik ke atas menimpa gambar */
            position: relative;
            z-index: 10;
        }

        .border-start-md {
            border-left: 1px solid #dee2e6;
        }
    }

    /* Untuk Layar HP (Lebar < 992px) */
    @media (max-width: 991px) {
        .hero-content-wrapper {
            padding-top: 40px;
            padding-bottom: 80px;
            min-height: 450px;

        }

        .hero-title {
            font-size: 2.5rem;
        }

        .row.h-100.align-items-start {
            padding-top: 8vh !important;
        }

        .floating-section {
            /* 3. EFEK MENIMPA: */
            /* Tarik kartu ke atas menutupi padding-bottom gambar tadi */
            margin-top: -100px !important;
            position: relative;
            z-index: 20;
            /* Layer paling atas */
            padding-left: 15px;
            padding-right: 15px;
        }
    }

    /* Efek Hover pada Icon */
    .group-hover:hover .icon-box {
        transform: scale(1.1);
        transition: transform 0.3s ease;
    }

    .group-hover:hover .text-purple {
        color: var(--mbs-purple-dark) !important;
    }

    .border-purple {
        border-color: #8a4fff !important;
    }

    /* --- CSS BERITA & AGENDA --- */

    /* Efek angkat sedikit saat hover di kartu berita */
    .hover-lift-sm {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .hover-lift-sm:hover {
        transform: translateY(-3px);
        box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .1) !important;
    }

    /* Tombol "Baca Selengkapnya" */
    .btn-purple {
        background-color: var(--mbs-purple);
        color: white;
        border: none;
        transition: all 0.3s;
    }

    .btn-purple:hover {
        background-color: var(--mbs-purple-dark);
        color: black;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(88, 44, 131, 0.3);
    }

    /* Tombol Outline Ungu */
    .btn-outline-purple {
        color: var(--mbs-purple);
        border: 1px solid var(--mbs-purple);
        transition: all 0.3s;
    }

    .btn-outline-purple:hover {
        background-color: var(--mbs-purple);
        color: white;
    }

    /* Link Hover Effect */
    .hover-purple:hover {
        color: var(--mbs-purple) !important;
        transition: color 0.2s;
    }

    /* Responsive Mobile: Ubah layout kartu berita jadi vertikal di HP */
    @media (max-width: 768px) {
        .card .row>.col-md-4 {
            height: 200px;
            /* Fix tinggi gambar di HP */
        }

        .card .row>.col-md-4 img {
            position: relative !important;
            /* Reset posisi absolute */
        }
    }

    /* --- CSS GURU & STAFF --- */

    /* Kartu Kepala Sekolah */
    .headmaster-card {
        transition: transform 0.3s ease;
        background: linear-gradient(to bottom, #ffffff 0%, #fafafa 100%);
    }

    .headmaster-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 3rem rgba(88, 44, 131, 0.15) !important;
    }

    /* Slider Guru */
    .teacherSwiper {
        padding-bottom: 50px !important;
        /* Tambah padding bawah agar bayangan/shadow tidak terpotong */
        padding-top: 20px;
    }

    .teacherSwiper .swiper-slide {
        height: auto !important;
        min-height: 0 !important;
        display: flex;
        align-items: flex-start;
        /* KUNCI: Agar tinggi card sesuai konten saja */
        justify-content: center;
        /* Agar card ada di tengah slide */
    }

    .teacherSwiper .swiper-pagination {
        bottom: 0 !important;
    }

    .teacherSwiper .swiper-pagination-bullet-active {
        background-color: var(--mbs-purple) !important;
    }

    #guru {
        background-color: #fff;
    }

    /* CSS KHUSUS GALERI */
    .gallery-card {
        border: 1px solid rgba(0, 0, 0, 0.05);
        background-color: #000;
        /* Fallback color */
    }

    /* Efek Zoom Gambar saat Hover */
    .gallery-card img.transition-transform {
        transition: transform 0.6s ease;
    }

    .gallery-card:hover img.transition-transform {
        transform: scale(1.1);
        opacity: 0.8;
    }

    /* Overlay Gradient */
    .gallery-overlay {
        background: linear-gradient(to top, rgba(88, 44, 131, 0.9) 0%, transparent 100%);
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.4s ease;
    }

    .gallery-card:hover .gallery-overlay {
        opacity: 1;
        transform: translateY(0);
    }

    /* Icon Zoom */
    .zoom-icon {
        transition: all 0.3s ease;
    }

    .gallery-card:hover .zoom-icon {
        opacity: 1 !important;
    }

    .text-shadow {
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .cursor-pointer {
        cursor: pointer;
    }
</style>

<section class="hero-section position-relative overflow-hidden pb-5">
    <?php if (!empty($sliders)): ?>
        <div class="swiper heroSwiper">
            <div class="swiper-wrapper">
                <?php foreach ($sliders as $slide): ?>
                    <div class="swiper-slide">
                        <div class="hero-bg" style="background-image: url('<?= base_url($slide['image_url']) ?>');"></div>

                        <div class="hero-overlay"></div>

                        <div class="container h-100 position-relative z-2">
                            <div class="row h-100 align-items-start justify-content-center text-center" style="padding-top: 20vh;">
                                <div class="col-lg-10">

                                    <span class="badge bg-white text-purple px-3 py-2 rounded-pill mb-3 fw-bold shadow-sm animate__animated animate__fadeInDown">
                                        <?= esc($school['name']) ?>
                                    </span>

                                    <h1 class="display-4 fw-bold text-white mb-4 hero-title animate__animated animate__fadeInUp">
                                        <?= esc($slide['title']) ?>
                                    </h1>

                                    <?php if (!empty($slide['description'])): ?>
                                        <p class="lead text-white opacity-90 mb-5 mx-auto hero-desc animate__animated animate__fadeInUp animate__delay-1s" style="max-width: 700px;">
                                            <?= esc($slide['description']) ?>
                                        </p>
                                    <?php endif; ?>

                                    <?php if (!empty($slide['button_text'])): ?>
                                        <div class="d-flex justify-content-center gap-3 animate__animated animate__fadeInUp animate__delay-2s">
                                            <a href="<?= esc($slide['button_link']) ?>" class="btn btn-light btn-lg rounded-pill px-5 fw-bold text-purple shadow-lg btn-hero">
                                                <?= esc($slide['button_text']) ?>
                                                <i class="bi bi-arrow-right ms-2"></i>
                                            </a>
                                        </div>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    <?php else: ?>
        <div class="d-flex align-items-center justify-content-center text-center text-white bg-purple py-5" style="min-height: 600px;">
            <div class="container">
                <h1 class="fw-bold display-5">Selamat Datang di <?= esc($school['name']) ?></h1>
                <p class="lead opacity-75">Menyiapkan Generasi Qur'ani Berkemajuan</p>
            </div>
        </div>
    <?php endif; ?>
</section>
<section class="floating-section">
    <div class="container">
        <div class="bg-white shadow-lg rounded-4 p-4 p-md-5 border-top border-5 border-purple">

            <div class="text-center mb-4">
                <h3 class="fw-bold text-purple">Program Pendidikan</h3>
                <div class="divider mx-auto bg-purple" style="width: 50px; height: 3px;"></div>
            </div>

            <div class="row g-4 justify-content-center">

                <?php if (!empty($programs)): ?>
                    <?php foreach ($programs as $index => $prog): ?>
                        <?php
                        // Logika Garis Pemisah (Border):
                        // Item pertama tidak pakai border kiri.
                        // Item kedua, ketiga, dst pakai border kiri (hanya di desktop).
                        $borderClass = ($index > 0) ? 'border-start-md' : '';
                        ?>

                        <div class="col-md-4 <?= $borderClass ?>">
                            <div class="text-center p-3 h-100 group-hover">
                                <div class="icon-box mb-3 text-purple">
                                    <i class="bi <?= esc($prog['icon']) ?> display-4"></i>
                                </div>
                                <h5 class="fw-bold"><?= esc($prog['title']) ?></h5>
                                <p class="text-muted small"><?= esc($prog['description']) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>

                <?php else: ?>
                    <div class="col-12 text-center py-4">
                        <p class="text-muted fst-italic">Belum ada program pendidikan yang ditambahkan.</p>
                    </div>
                <?php endif; ?>

            </div>

        </div>
    </div>
</section>
<?php if (!empty($announcements)): ?>
    <div class="bg-white border-bottom py-2">
        <div class="container d-flex align-items-center">
            <span class="badge bg-purple me-3 px-3 py-2 rounded-pill">
                <i class="bi bi-megaphone-fill me-1"></i> PENGUMUMAN
            </span>
            <div class="flex-grow-1 overflow-hidden">
                <marquee class="text-dark fw-medium" scrollamount="6">
                    <?php foreach ($announcements as $anno): ?>
                        <span class="me-5">
                            <i class="bi bi-dot text-purple"></i> <?= esc($anno['title']) ?>: <?= esc($anno['content']) ?>
                        </span>
                    <?php endforeach; ?>
                </marquee>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if (!empty($featured_pages)): ?>
    <?php foreach ($featured_pages as $page): ?>
        <section class="py-5 bg-light border-bottom">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="card border-0 shadow-sm rounded-4 p-4 p-lg-5">
                            <div class="text-center mb-4">
                                <h2 class="fw-bold text-purple"><?= esc($page['title']) ?></h2>
                                <div class="divider mx-auto bg-purple" style="width: 60px; height: 3px;"></div>
                            </div>
                            <div class="content-body text-secondary lh-lg">
                                <?= $page['content'] ?>
                            </div>
                            
                            <div class="text-center mt-4">
                                <a href="<?= site_url('mts/halaman/' . $page['slug']) ?>" class="btn btn-outline-purple rounded-pill px-4">
                                    Baca Selengkapnya
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endforeach; ?>
<?php endif; ?>

<section id="berita" class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">

            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-end mb-4">
                    <div>
                        <h3 class="fw-bold text-purple mb-1">Kabar Sekolah</h3>
                        <div class="divider bg-purple" style="width: 60px; height: 3px;"></div>
                    </div>
                    <a href="<?= site_url('mts/kabar') ?>" class="btn btn-sm btn-outline-purple rounded-pill px-3">
                        Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>

                <div class="d-flex flex-column gap-3">
                    <?php if (!empty($news)): ?>
                        <?php foreach ($news as $n): ?>
                            <div class="card border-0 shadow-sm overflow-hidden hover-lift-sm">
                                <div class="row g-0">
                                    <div class="col-md-4 position-relative">
                                        <div class="h-100" style="min-height: 200px;">
                                            <img src="<?= base_url($n['thumbnail']) ?>"
                                                class="w-100 h-100 object-fit-cover position-absolute top-0 start-0"
                                                alt="<?= esc($n['title']) ?>"
                                                onerror="this.src='https://placehold.co/600x400/eee/999?text=No+Image'">
                                        </div>
                                    </div>

                                    <div class="col-md-8">
                                        <div class="card-body p-4 h-100 d-flex flex-column">
                                            <div class="mb-2 text-muted small d-flex align-items-center gap-3">
                                                <span>
                                                    <i class="bi bi-calendar3 me-1 text-purple"></i>
                                                    <?= date('d M Y', strtotime($n['created_at'])) ?>
                                                </span>
                                                <span>
                                                    <i class="bi bi-person-circle me-1 text-purple"></i>
                                                    <?= esc($n['author'] ?? 'Admin') ?>
                                                </span>
                                            </div>

                                            <h5 class="card-title fw-bold mb-2">
                                                <a href="<?= site_url('mts/kabar/' . $n['slug']) ?>" class="text-decoration-none text-dark hover-purple">
                                                    <?= esc($n['title']) ?>
                                                </a>
                                            </h5>

                                            <p class="card-text text-secondary small mb-3 flex-grow-1">
                                                <?= substr(strip_tags($n['content']), 0, 120) ?>...
                                            </p>

                                            <div class="mt-auto">
                                                <a href="<?= site_url('mts/kabar/' . $n['slug']) ?>" class="btn btn-sm btn-purple rounded-pill px-4 shadow-sm">
                                                    Baca Selengkapnya
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="alert alert-light border text-center py-4">
                            <i class="bi bi-newspaper fs-1 text-muted opacity-50 mb-2"></i>
                            <p class="mb-0 text-muted">Belum ada berita terbaru.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="d-flex justify-content-between align-items-end mb-4">
                    <div>
                        <h3 class="fw-bold text-purple mb-1">Agenda</h3>
                        <div class="divider bg-purple" style="width: 40px; height: 3px;"></div>
                    </div>
                    <a href="<?= site_url('mts/agenda') ?>" class="text-decoration-none small fw-bold text-purple">
                        Kalender <i class="bi bi-calendar4-week"></i>
                    </a>
                </div>

                <div class="bg-white p-4 rounded-4 shadow-sm border-top border-4 border-purple">
                    <?php if (!empty($events)): ?>
                        <div class="d-flex flex-column gap-4">
                            <?php foreach ($events as $e): ?>
                                <div class="d-flex gap-3 align-items-start group-hover">
                                    <div class="text-center rounded-3 overflow-hidden flex-shrink-0 shadow-sm" style="width: 60px;">
                                        <div class="bg-purple text-white py-1 small fw-bold text-uppercase">
                                            <?= date('M', strtotime($e['event_date'])) ?>
                                        </div>
                                        <div class="bg-light text-dark py-2 fw-bold border border-top-0 h4 mb-0">
                                            <?= date('d', strtotime($e['event_date'])) ?>
                                        </div>
                                    </div>

                                    <div>
                                        <h6 class="fw-bold mb-1 text-dark hover-purple transition-color">
                                            <a href="<?= site_url('mts/agenda/' . $e['slug']) ?>" class="text-reset text-decoration-none">
                                                <?= esc($e['title']) ?>
                                            </a>
                                        </h6>
                                        <div class="text-muted small mb-1">
                                            <i class="bi bi-clock text-purple me-1"></i>
                                            <?= date('H:i', strtotime($e['time_start'])) ?> WITA
                                        </div>
                                        <div class="text-muted small">
                                            <i class="bi bi-geo-alt text-purple me-1"></i>
                                            <?= esc($e['location']) ?>
                                        </div>
                                    </div>
                                </div>

                                <?php if ($e !== end($events)): ?>
                                    <hr class="my-0 border-light">
                                <?php endif; ?>

                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <p class="text-muted small mb-0 fst-italic">Tidak ada agenda mendatang.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</section>

<section id="guru" class="py-5 bg-white">
    <div class="container">

        <div class="text-center mb-5">
            <h3 class="fw-bold text-purple">Dewan Guru & Staff</h3>
            <div class="divider mx-auto bg-purple" style="width: 50px; height: 3px;"></div>
        </div>

        <?php if (!empty($kepala_sekolah)): ?>
            <div class="row justify-content-center mb-5">
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden card-guru">
                        <div class="bg-purple" style="height: 100px;"></div>

                        <div class="card-body text-center p-0">
                            <div class="position-relative d-inline-block" style="margin-top: -60px;">
                                <?php
                                $fotoKS = $kepala_sekolah['photo'];
                                // Cek: Jika string mengandung 'http', berarti link luar. Jika tidak, pakai base_url()
                                $srcKS = (filter_var($fotoKS, FILTER_VALIDATE_URL)) ? $fotoKS : base_url($fotoKS);
                                ?>
                                <img src="<?= $srcKS ?>"
                                    class="rounded-circle border border-4 border-white shadow-sm object-fit-cover"
                                    width="120" height="120"
                                    alt="<?= esc($kepala_sekolah['name']) ?>"
                                    onerror="this.src='https://ui-avatars.com/api/?name=KS&background=random&size=128'">
                            </div>

                            <div class="p-4 pt-2">
                                <h5 class="fw-bold text-dark mb-1"><?= esc($kepala_sekolah['name']) ?></h5>
                                <span class="badge bg-purple bg-opacity-10 text-white rounded-pill mb-3 px-3">
                                    <?= esc($kepala_sekolah['position']) ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty($teachers)): ?>
            <div class="swiper teacherSwiper pb-5 px-2">
                <div class="swiper-wrapper">
                    <?php foreach ($teachers as $t): ?>
                        <div class="swiper-slide">

                            <div class="card border-0 shadow-sm rounded-4 overflow-hidden card-guru mx-auto" style="max-width: 350px;">

                                <div class="bg-purple" style="height: 70px;"></div>

                                <div class="card-body text-center position-relative pt-0 pb-4">
                                    <div class="position-relative d-inline-block" style="margin-top: -40px;">
                                        <?php
                                        $fotoGuru = $t['photo'];
                                        // Cek URL vs Lokal
                                        $srcGuru = (filter_var($fotoGuru, FILTER_VALIDATE_URL)) ? $fotoGuru : base_url($fotoGuru);
                                        ?>
                                        <img src="<?= $srcGuru ?>"
                                            class="rounded-circle border border-3 border-white shadow-sm object-fit-cover"
                                            width="80" height="80"
                                            alt="<?= esc($t['name']) ?>"
                                            onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($t['name']) ?>&background=random&size=128'">
                                    </div>

                                    <h6 class="fw-bold text-dark mb-1 mt-2" style="font-size: 0.95rem;"><?= esc($t['name']) ?></h6>
                                    <span class="d-block text-secondary small mb-2" style="font-size: 0.8rem;"><?= esc($t['position']) ?></span>
                                </div>
                            </div>

                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        <?php endif; ?>
</section>

<section id="galeri" class="py-5 bg-white position-relative">
    <div class="position-absolute top-0 start-0 w-100 h-100 opacity-10"
        style="background-image: radial-gradient(#582C83 1px, transparent 1px); background-size: 20px 20px;"></div>

    <div class="container position-relative z-1">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <div>
                <h6 class="text-uppercase fw-bold text-secondary ls-2 mb-2">Dokumentasi</h6>
                <h2 class="fw-bold display-6 text-purple">Galeri Kegiatan</h2>
                <div class="divider bg-purple mt-3" style="width: 60px; height: 4px; border-radius: 2px;"></div>
            </div>
            <a href="<?= site_url('mts/galeri') ?>" class="btn btn-outline-purple rounded-pill px-4 fw-bold d-none d-md-inline-block hover-lift-sm">
                Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-3">
            <?php if (!empty($galleries)): ?>
                <?php foreach ($galleries as $index => $g): ?>
                    <?php
                    $colClass = ($index === 0 || $index === 4) ? 'col-md-6' : 'col-md-3 col-6';
                    $heightClass = ($index === 0 || $index === 4) ? '280px' : '280px';
                    ?>

                    <div class="<?= $colClass ?>">
                        <div class="gallery-card position-relative overflow-hidden rounded-4 shadow-sm h-100 cursor-pointer"
                            onclick="openGalleryModal('<?= base_url($g['image_url']) ?>', '<?= esc($g['title']) ?>', '<?= esc(ucfirst($g['category'])) ?>')">

                            <img src="<?= base_url($g['image_url']) ?>"
                                class="w-100 h-100 object-fit-cover transition-transform"
                                style="min-height: <?= $heightClass ?>;"
                                alt="<?= esc($g['title']) ?>"
                                loading="lazy">

                            <div class="gallery-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-4">
                                <span class="badge bg-warning text-dark align-self-start mb-2 shadow-sm">
                                    <?= esc(ucfirst($g['category'])) ?>
                                </span>
                                <h6 class="text-white fw-bold mb-0 text-shadow"><?= esc($g['title']) ?></h6>
                            </div>

                            <div class="zoom-icon position-absolute top-50 start-50 translate-middle opacity-0 transition-opacity">
                                <div class="bg-white text-purple rounded-circle p-3 shadow-lg">
                                    <i class="bi bi-zoom-in fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5 bg-light rounded-4 border border-dashed">
                    <i class="bi bi-images fs-1 text-muted opacity-50 mb-3"></i>
                    <p class="text-muted mb-0">Belum ada dokumentasi kegiatan yang diupload.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<div class="modal fade" id="galleryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-header border-0 p-0 mb-2">
                <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0 text-center position-relative">
                <img src="" id="modalImageSrc" class="img-fluid rounded-4 shadow-lg" style="max-height: 85vh;">
                <div class="position-absolute bottom-0 start-0 w-100 p-3" style="background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);">
                    <h5 class="modal-title text-white fw-bold" id="modalImageTitle"></h5>
                    <span class="badge bg-purple" id="modalImageCat"></span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Tunggu dokumen selesai dimuat baru jalankan Swiper
    document.addEventListener("DOMContentLoaded", function() {

        // Inisialisasi Swiper Guru
        var teacherSwiper = new Swiper(".teacherSwiper", {
            slidesPerView: 1, // Tampilan HP: 1 kartu dulu biar rapi
            spaceBetween: 20,
            loop: false, // Jangan di-loop kalau datanya sedikit (kurang dari slidesPerView)
            grabCursor: true, // Biar kursor berubah jadi tangan saat hover
            pagination: {
                el: ".teacherSwiper .swiper-pagination", // Spesifik ke class ini
                clickable: true
            },
            breakpoints: {
                640: {
                    slidesPerView: 2, // Tablet kecil: 2 kartu
                    spaceBetween: 20
                },
                768: {
                    slidesPerView: 3, // Tablet/Laptop: 3 kartu
                    spaceBetween: 30
                },
                1024: {
                    slidesPerView: 4, // Desktop lebar: 4 kartu
                    spaceBetween: 40
                },
            },
        });

        // Inisialisasi Hero Swiper (Slider Atas)
        var heroSwiper = new Swiper(".heroSwiper", {
            loop: true,
            effect: "fade",
            fadeEffect: {
                crossFade: true
            },
            autoplay: {
                delay: 6000,
                disableOnInteraction: false
            },
            pagination: {
                el: ".heroSwiper .swiper-pagination",
                clickable: true,
                dynamicBullets: true
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev"
            },
        });
    });
    // Script untuk Modal Popup Galeri
    function openGalleryModal(src, title, category) {
        var modalImg = document.getElementById('modalImageSrc');
        var modalTitle = document.getElementById('modalImageTitle');
        var modalCat = document.getElementById('modalImageCat');

        modalImg.src = src;
        modalTitle.innerText = title;
        modalCat.innerText = category;

        var myModal = new bootstrap.Modal(document.getElementById('galleryModal'));
        myModal.show();
    }
</script>

<?= $this->endSection() ?>