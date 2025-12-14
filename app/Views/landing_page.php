<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<!-- ============================================================== -->
<!-- SECTION 2: HERO SLIDER (DINAMIS DARI DATABASE) -->
<!-- ============================================================== -->
<section class="hero-slider-section position-relative" style="padding-bottom: 0;">

    <!-- Swiper Slider Container -->
    <div class="swiper heroSwiper">
        <div class="swiper-wrapper">
            <?php if (!empty($sliders)) : ?>
                <?php foreach ($sliders as $slider) : ?>
                   <div class="swiper-slide">
                    <!-- Background Image -->
                    <div class="hero-slide position-relative d-flex align-items-center text-white"
                        style="min-height: 85vh; padding-bottom: 120px;
                                background: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.7)), 
                                            url('<?= get_image_url($slider['image_url']) ?>') no-repeat center center/cover;">

                        <!-- Content -->
                        <div class="container position-relative z-index-1">
                            <div class="row">
                                <div class="col-lg-8">
                                    <span class="badge bg-white text-dark text-uppercase mb-3 px-3 py-2 fw-bold ls-2">
                                        <?= esc($slider['badge_text'] ?? $site['site_name'] ?? 'MBS Boarding School') ?>
                                    </span>
                                    <h1 class="display-3 fw-bold mb-3 animate__animated animate__fadeInUp slider-title">
                                        <?= esc($slider['title']) ?>
                                    </h1>
                                    <?php if (!empty($slider['description'])) : ?>
                                        <p class="lead mb-4 text-light opacity-90 animate__animated animate__fadeInUp animate__delay-1s slider-description">
                                            <?= esc($slider['description']) ?>
                                        </p>
                                    <?php endif; ?>

                                    <?php if (!empty($slider['button_text']) && !empty($slider['button_link'])) : ?>
                                        <?php
                                        $isExternal = (strpos($slider['button_link'], 'http://') === 0 || strpos($slider['button_link'], 'https://') === 0);
                                        $targetBlank = $isExternal ? 'target="_blank" rel="noopener noreferrer"' : '';
                                        ?>
                                        <div class="mt-3">
                                            <a href="<?= esc($slider['button_link']) ?>"
                                                <?= $targetBlank ?>
                                                class="btn btn-light btn-lg px-5 py-3 rounded-pill fw-bold animate__animated animate__fadeInUp animate__delay-2s">
                                                <?= esc($slider['button_text']) ?>
                                                <i class="bi bi-arrow-right ms-2"></i>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else : ?>
                <!-- Default Slide jika database kosong -->
                <div class="swiper-slide">
                    <div class="hero-slide position-relative d-flex align-items-center text-white"
                        style="min-height: 85vh; 
                                padding: 120px 0 80px;
                                background: linear-gradient(to bottom, rgba(47, 63, 88, 0.8), rgba(61, 31, 92, 0.9));">
                        <div class="container text-center">
                            <h1 class="display-3 fw-bold mb-4">Selamat Datang di MBS</h1>
                            <p class="lead">Belum ada hero slider. Silakan tambahkan di Admin Panel.</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pagination Dots -->
        <div class="swiper-pagination"></div>
    </div>
</section>

<!-- ============================================================== -->
<!-- SECTION 5: BERITA & STORIES (FLOATING / TIMBUL) -->
<!-- ============================================================== -->
<!-- Perhatikan class 'floating-section' di CSS bawah -->
<section class="floating-section position-relative z-index-10">
    <div class="container">
        <!-- Kartu Putih Besar yang Timbul -->
        <div class="bg-white shadow-lg rounded-4 p-4 p-md-5 border-top border-5 border-purple">

            <div class="row">
                <!-- KOLOM KIRI: Judul & Navigasi -->
                <div class="col-lg-4 mb-5 mb-lg-0 border-end-lg pe-lg-5 d-flex flex-column justify-content-center">
                    <span class="text-uppercase fw-bold text-secondary ls-2 mb-2 small">MBS Stories</span>
                    <h2 class="fw-bold display-6 mb-3 text-dark">Kabar Terbaru &<br>Informasi Pondok</h2>

                    <!-- Dropdown Filter -->
                    <div class="mb-4">
                        <form action="<?= base_url('news') ?>" method="get">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                                <input type="text" name="category" class="form-control form-control-lg border-start-0 ps-0"
                                    placeholder="Cari berita..." aria-label="Cari berita">
                                <button class="btn btn-primary " type="submit">Cari</button>
                            </div>
                        </form>
                    </div>

                    <!-- Navigasi Slider Bulat -->
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <button class="swiper-prev-btn btn btn-outline-dark rounded-circle p-0 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="bi bi-chevron-left fs-5"></i>
                        </button>
                        <button class="swiper-next-btn btn btn-outline-dark rounded-circle p-0 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="bi bi-chevron-right fs-5"></i>
                        </button>
                    </div>

                    <a href="<?= base_url('news') ?>" class="btn btn-outline-primary rounded-pill px-4 w-100 w-md-auto fw-bold btn-view-all">LIHAT SEMUA</a>
                </div>

                <!-- KOLOM KANAN: Slider Berita -->
                <div class="col-lg-8 ps-lg-5">
                    <div class="swiper newsSwiper overflow-hidden p-2">
                        <div class="swiper-wrapper">
                            <?php foreach ($latest_news as $news) : ?>
                                <div class="swiper-slide h-auto">
                                    <div class="card h-100 border-0 bg-transparent group-hover">
                                        <!-- Gambar -->
                                        <div class="position-relative rounded-3 overflow-hidden mb-3" style="height: 200px;">
                                            <img src="<?= esc($news['thumbnail']) ?>" class="w-100 h-100 object-fit-cover transition-transform" alt="News">
                                            <!-- Label -->
                                            <div class="position-absolute top-0 start-0 p-2">
                                                <span class="badge bg-white text-purple fw-bold shadow-sm">
                                                    <?= esc($news['school_name'] ?? 'UMUM') ?>
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Teks & Konten -->
                                        <div class="d-flex flex-column h-100 px-1">
                                            <!-- Judul -->
                                            <h5 class="fw-bold mb-2">
                                                <a href="<?= base_url('news/' . $news['slug']) ?>" class="text-decoration-none text-dark stretched-link hover-purple text-clamp-2">
                                                    <?= esc($news['title']) ?>
                                                </a>
                                            </h5>

                                            <!-- [BARU] Ringkasan Berita -->
                                            <p class="text-muted small mb-3 text-clamp-3 lh-sm">
                                                <?php
                                                // Ambil 100 karakter pertama, hilangkan tag HTML
                                                $excerpt = strip_tags($news['content']);
                                                if (strlen($excerpt) > 100) {
                                                    $excerpt = substr($excerpt, 0, 100) . "...";
                                                }
                                                echo esc($excerpt);
                                                ?>
                                            </p>

                                            <!-- Tanggal (Footer Kartu) -->
                                            <!-- Info Meta (Tanggal & Penulis) -->
                                            <div class="mt-auto pt-2 border-top">
                                                <div class="d-flex justify-content-between align-items-center text-muted small">
                                                    <span>
                                                        <i class="bi bi-calendar-event me-1"></i>
                                                        <?= date('d M Y', strtotime($news['created_at'])) ?>
                                                    </span>
                                                    <?php if (!empty($news['author'])) : ?>
                                                        <span>
                                                            <i class="bi bi-person-fill me-1"></i>
                                                            <?= esc($news['author']) ?>
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================== -->
<!-- SECTION: JENJANG PENDIDIKAN (DINAMIS DARI DATABASE) -->
<!-- ============================================================== -->
<section class="py-5 bg-light" id="jenjang-sekolah">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge bg-light text-purple text-uppercase mb-3 px-4 py-2 fw-bold">PENDIDIKAN</span>
            <h2 class="display-5 fw-bold text-purple mb-3">Jenjang Pendidikan</h2>
            <p class="lead text-muted mx-auto" style="max-width: 600px;">
                Tiga jenjang pendidikan berkualitas dengan sistem pesantren modern
            </p>
        </div>

        <div class="row g-4">
            <?php if (!empty($schools)) : ?>
                <?php foreach ($schools as $index => $school) : ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card border-0 shadow-sm h-100 hover-lift-school">
                            <!-- School Image -->
                            <div class="position-relative overflow-hidden" style="height: 250px;">
                                <?php if (!empty($school['image_url']) && file_exists($school['image_url'])) : ?>
                                    <img src="<?= base_url($school['image_url']) ?>"
                                        class="w-100 h-100 object-fit-cover"
                                        alt="<?= esc($school['name']) ?>">
                                <?php elseif (!empty($school['hero_image']) && file_exists($school['hero_image'])) : ?>
                                    <!-- Fallback ke hero_image jika ada -->
                                    <img src="<?= base_url($school['hero_image']) ?>"
                                        class="w-100 h-100 object-fit-cover"
                                        alt="<?= esc($school['name']) ?>">
                                <?php else : ?>
                                    <!-- Placeholder dengan gradient -->
                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center text-white"
                                        style="background: linear-gradient(135deg, 
                                            <?= $index == 0 ? '#2f3f58, #e8ecf1' : ($index == 1 ? '#3b82f6, #60a5fa' : '#10b981, #34d399') ?>);">
                                        <div class="text-center">
                                            <i class="bi bi-building" style="font-size: 4rem;"></i>
                                            <h4 class="mt-3 fw-bold"><?= esc($school['name']) ?></h4>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <!-- Badge Akreditasi (Dinamis dengan Auto Color) -->
                                <div class="position-absolute top-0 end-0 m-3">
                                    <?php
                                    $accreditation = $school['accreditation_status'] ?? 'A';

                                    // Format text badge (tambahkan "Akreditasi" jika hanya huruf A/B/C)
                                    $badgeText = $accreditation;
                                    if (in_array($accreditation, ['A', 'B', 'C'])) {
                                        $badgeText = 'Akreditasi ' . $accreditation;
                                    }

                                    // Auto detect warna badge berdasarkan status
                                    if (stripos($accreditation, 'A') !== false) {
                                        $badgeClass = 'bg-success';
                                        $icon = 'bi-star-fill';
                                    } elseif (stripos($accreditation, 'B') !== false) {
                                        $badgeClass = 'bg-primary';
                                        $icon = 'bi-star-fill';
                                    } elseif (stripos($accreditation, 'C') !== false) {
                                        $badgeClass = 'bg-info';
                                        $icon = 'bi-star';
                                    } elseif (stripos($accreditation, 'Belum') !== false || stripos($accreditation, 'Proses') !== false) {
                                        $badgeClass = 'bg-secondary';
                                        $icon = 'bi-hourglass-split';
                                    } else {
                                        $badgeClass = 'bg-dark';
                                        $icon = 'bi-award-fill';
                                    }
                                    ?>
                                    <span class="badge <?= $badgeClass ?> text-white px-3 py-2 shadow-sm">
                                        <i class="bi <?= $icon ?> me-1"></i>
                                        <?= esc($badgeText) ?>
                                    </span>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="card-body p-4">
                                <h4 class="card-title fw-bold text-purple mb-3">
                                    <i class="bi bi-mortarboard-fill me-2"></i>
                                    <?= esc($school['name']) ?>
                                </h4>
                                <p class="card-text text-muted mb-4" style="min-height: 80px;">
                                    <?= esc($school['description']) ?>
                                </p>

                                <!-- Info Kontak (Jika Ada) -->
                                <?php if (!empty($school['contact_person']) || !empty($school['phone'])) : ?>
                                    <div class="mb-3 small text-muted">
                                        <?php if (!empty($school['contact_person'])) : ?>
                                            <div class="mb-1">
                                                <i class="bi bi-person-badge me-2"></i>
                                                <?= esc($school['contact_person']) ?>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (!empty($school['phone'])) : ?>
                                            <div>
                                                <i class="bi bi-telephone me-2"></i>
                                                <a href="tel:<?= esc($school['phone']) ?>" class="text-muted">
                                                    <?= esc($school['phone']) ?>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>

                                <!-- Button -->
                                <?php if (!empty($school['website_url'])) : ?>
                                    <a href="<?= esc($school['website_url']) ?>"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="btn btn-outline-purple w-100">
                                        <i class="bi bi-box-arrow-up-right me-2"></i>
                                        Kunjungi Website
                                    </a>
                                <?php else : ?>
                                    <a href="#kontak" class="btn btn-outline-purple w-100">
                                        <i class="bi bi-info-circle me-2"></i>
                                        Info Lebih Lanjut
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <!-- Fallback jika belum ada data -->
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <i class="bi bi-info-circle me-2"></i>
                        Data jenjang pendidikan sedang diperbarui. Silakan hubungi admin untuk informasi lebih lanjut.
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ============================================================== -->
<!-- SECTION 9: PIMPINAN PONDOK (LEADERSHIP) -->
<!-- ============================================================== -->
<section class="py-5 bg-light">
    <div class="container py-4">
        <div class="text-center mb-5">
            <h6 class="text-uppercase fw-bold text-secondary ls-2">Manajemen</h6>
            <h2 class="fw-bold display-6 text-purple">Pimpinan Pondok</h2>
            <div class="divider mx-auto mt-3 bg-purple" style="width: 60px; height: 3px;"></div>
        </div>
        <div class="row g-4 justify-content-center">
            <?php foreach ($leaders as $leader) : ?>
                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm text-center h-100 hover-top bg-white">
                        <div class="card-body p-4">
                            <div class="mb-4 mx-auto position-relative" style="width: 120px; height: 120px;">
                                <div class="position-absolute top-0 start-0 w-100 h-100 rounded-circle border border-2 border-light shadow-sm" style="background: url('<?= esc($leader['photo']) ?>') center/cover;"></div>
                            </div>
                            <h5 class="fw-bold mb-1 text-dark small"><?= esc($leader['name']) ?></h5>
                            <p class="text-muted x-small text-uppercase ls-1 mb-0"><?= esc($leader['position']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<!-- SECTION 6: AGENDA (Horizontal Banner Style - Biar beda dengan berita) -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold" style="color: var(--mbs-purple);">Agenda Mendatang</h3>
            <a href="<?= base_url('events') ?>" class="text-decoration-none fw-bold" style="color: var(--mbs-purple);">Lihat Kalender <i class="bi bi-arrow-right"></i></a>
        </div>

        <div class="row g-3">
            <?php foreach ($upcoming_events as $event) : ?>
                <div class="col-md-6 col-lg-3">
                    <div class="border rounded p-3 d-flex align-items-center gap-3 shadow-sm h-100">
                        <div class="text-center rounded p-2 text-white flex-shrink-0" style="background: var(--mbs-purple); width: 60px;">
                            <span class="d-block h4 fw-bold mb-0"><?= date('d', strtotime($event['event_date'])) ?></span>
                            <span class="d-block small text-uppercase" style="font-size: 0.7rem;"><?= date('M', strtotime($event['event_date'])) ?></span>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1 small text-dark"><?= esc($event['title']) ?></h6>
                            <span class="text-muted x-small"><i class="bi bi-clock"></i> <?= date('H:i', strtotime($event['time_start'])) ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- SECTION 7: GALERI KEGIATAN (HIGHLIGHT) -->
<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="text-center mb-5">
            <h6 class="text-uppercase fw-bold text-secondary ls-2">Galeri Pondok</h6>
            <h2 class="fw-bold display-6" style="color: var(--mbs-purple);">Potret Aktivitas Santri</h2>
            <div class="divider mx-auto mt-3" style="width: 60px; height: 3px; background: var(--mbs-purple);"></div>
        </div>

        <!-- Grid Gallery Responsif -->
        <div class="row g-3">
            <?php foreach ($latest_photos as $index => $photo) : ?>
                <!-- Logika Layout: Foto pertama & kelima besar (col-md-6), sisanya kecil (col-md-3) -->
                <?php $colClass = ($index == 0 || $index == 4) ? 'col-md-6' : 'col-md-3 col-6'; ?>

                <div class="<?= $colClass ?>">
                    <div class="gallery-item position-relative overflow-hidden rounded shadow-sm h-100 group-hover">
                        <img src="<?= esc($photo['image_url']) ?>"
                            class="w-100 h-100 object-fit-cover transition-transform"
                            alt="<?= esc($photo['title']) ?>"
                            style="min-height: 250px;">

                        <!-- Overlay Hover Info -->
                        <div class="overlay-hover position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-3"
                            style="background: linear-gradient(to top, rgba(0,0,0,0.8), transparent); opacity: 0; transition: all 0.3s;">
                            <span class="badge bg-warning text-dark mb-2 w-auto align-self-start"><?= esc(ucfirst($photo['category'])) ?></span>
                            <h6 class="text-white fw-bold mb-0"><?= esc($photo['title']) ?></h6>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-5">
            <a href="<?= base_url('gallery') ?>" class="btn btn-outline-secondary rounded-pill px-4">Lihat Galeri Lengkap <i class="bi bi-arrow-right"></i></a>
        </div>
    </div>
</section>

<!-- SECTION 8: PROFIL SINGKAT & VIDEO (SAMBUTAN DIREKTUR) -->
<section class="py-5 position-relative text-white" style="background-color: var(--mbs-purple);">
    <div class="position-absolute top-0 end-0 p-5 opacity-10 d-none d-md-block">
        <i class="bi bi-quote" style="font-size: 15rem; color: white;"></i>
    </div>

    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0 z-index-2 position-relative">
                <span class="badge bg-warning text-dark mb-3 px-3 py-2">KENAL LEBIH DEKAT</span>

                <h2 class="display-5 fw-bold mb-4">
                    <?= esc($site['profile_title'] ?? 'Mendidik dengan Hati, Mengabdi untuk Negeri.') ?>
                </h2>

                <p class="lead opacity-75 mb-4">
                    "<?= esc($site['profile_description'] ?? 'Selamat datang di MBS Boarding School...') ?>"
                </p>

                <div class="d-flex align-items-center mt-4">
                    <?php
                    $directorPhoto = $site['director_photo'] ?? 'https://ui-avatars.com/api/?name=Direktur&background=random&size=128';
                    // Cek jika foto lokal atau URL luar
                    if (!filter_var($directorPhoto, FILTER_VALIDATE_URL)) {
                        $directorPhoto = base_url($directorPhoto);
                    }
                    ?>
                    <img src="<?= $directorPhoto ?>"
                        class="rounded-circle border border-3 border-white me-3 object-fit-cover"
                        width="60" height="60"
                        alt="Direktur">

                    <div>
                        <h5 class="fw-bold mb-0"><?= esc($site['director_name'] ?? 'Nama Direktur') ?></h5>
                        <small class="opacity-75"><?= esc($site['director_label'] ?? 'Pimpinan Pondok') ?></small>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 position-relative z-index-2">
                <div class="ratio ratio-16x9 rounded-4 shadow-lg border border-5 border-white overflow-hidden" style="transform: rotate(2deg);">
                    <?php
                    // Gunakan helper untuk convert link ke embed
                    $videoUrl = $site['profile_video_url'] ?? '';
                    $embedUrl = !empty($videoUrl) ? get_youtube_embed($videoUrl) : '';
                    ?>

                    <?php if (!empty($embedUrl)) : ?>
                        <iframe src="<?= $embedUrl ?>" title="Profil MBS" allowfullscreen></iframe>
                    <?php else : ?>
                        <div class="d-flex align-items-center justify-content-center bg-dark h-100">
                            <div class="text-center">
                                <i class="bi bi-play-circle fs-1 text-white opacity-50"></i>
                                <p class="text-white mt-2">Video Profil Belum Diatur</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="position-absolute top-0 start-0 w-100 h-100 bg-warning rounded-4" style="z-index: -1; transform: rotate(-3deg) scale(0.95);"></div>
            </div>
        </div>
    </div>
</section>
<!-- ============================================================== -->
<!-- STYLE & SCRIPT KHUSUS -->
<!-- ============================================================== -->
<style>
    /* VARIABLE WARNA */
    .text-purple {
        color: var(--mbs-purple);
    }

    .bg-purple {
        background-color: var(--mbs-purple);
    }

    .border-purple {
        border-color: var(--mbs-purple) !important;
    }

    .hover-purple:hover {
        color: var(--mbs-purple) !important;
    }

    /* HERO & FLOATING SECTION (KUNCI DESIGN) */
    .floating-section {
        position: relative;
        z-index: 100;
        /* Pastikan di atas hero */
    }

    /* Di layar besar, tarik section berita ke atas (-100px) */
    @media (min-width: 992px) {
        .floating-section {
            margin-top: -120px;
            /* INI KUNCINYA: Menarik ke atas */
        }

        .border-end-lg {
            border-right: 1px solid #dee2e6;
        }
    }

    /* Di layar HP, jangan ditarik (biar tidak numpuk berantakan) */
    @media (max-width: 991px) {
        .hero-section {
            min-height: 60vh !important;
            padding-bottom: 50px !important;
        }

        .floating-section {
            margin-top: -30px;
            padding-left: 15px;
            padding-right: 15px;
        }
    }

    /* BUTTON STYLES */
    .btn-view-all {
        color: var(--mbs-purple);
        border-color: var(--mbs-purple);
    }

    .btn-view-all:hover {
        background-color: var(--mbs-purple);
        color: white;
    }

    /* CARD HOVER EFFECTS */
    .group-hover:hover img {
        transform: scale(1.05);
    }

    .transition-transform {
        transition: transform 0.5s ease;
    }

    .hover-top {
        transition: transform 0.3s ease;
    }

    .hover-top:hover {
        transform: translateY(-5px);
    }

    /* UTILS */
    .ls-2 {
        letter-spacing: 2px;
    }

    .object-fit-cover {
        object-fit: cover;
    }

    .x-small {
        font-size: 0.75rem;
    }

    .text-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .text-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        /* Maksimal 3 baris deskripsi */
        line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .lh-sm {
        line-height: 1.4;
    }

    /* ========== HERO SLIDER CUSTOM STYLE ========== */
    .hero-slider-section {
        position: relative;
    }

    .heroSwiper {
        width: 100%;
        height: 100%;
    }

    .hero-slide {
        transition: all 0.5s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Batasi tinggi title agar tidak terlalu panjang */
    .slider-title {
        height: auto;
        overflow: visible;
        display: block;
        /* Hapus line-clamp agar semua teks muncul */
        line-height: 1.2;
    }

    /* Batasi tinggi description */
    .slider-description {
        height: auto;
        overflow: visible;
        display: block;
        line-height: 1.6;
    }

    /* Responsive Mobile */
    @media (max-width: 991px) {
        .hero-slide {
            /* Ubah min-height jadi auto atau kecil, biar ngikutin konten */
            min-height: auto !important; 
            padding: 150px 0 100px !important; /* Padding besar biar ga ketutup menu */
        }

        .slider-title {
            font-size: 2rem !important;
            height: auto; /* Biarkan bebas */
        }

        .slider-description {
            font-size: 1rem !important;
            height: auto; /* Biarkan bebas */
        }

        .hero-slide .btn {
            padding: 0.75rem 2rem !important;
            font-size: 0.9rem !important;
        }
    }

    /* Hilangkan panah navigasi (jika masih muncul) */
    .heroSwiper .swiper-button-next,
    .heroSwiper .swiper-button-prev {
        display: none !important;
    }

    /* Pagination Dots Custom (lebih cantik) */
    .heroSwiper .swiper-pagination {
        bottom: 30px !important;
    }

    .heroSwiper .swiper-pagination-bullet {
        width: 12px;
        height: 12px;
        background: white;
        opacity: 0.5;
        transition: all 0.3s;
    }

    .heroSwiper .swiper-pagination-bullet-active {
        opacity: 1;
        background: white;
        width: 35px;
        border-radius: 10px;
    }

    /* Responsive: Spacing di Mobile */
    @media (max-width: 991px) {
        .hero-slide .container {
            padding-top: 40px !important;
        }

        .hero-slide h1 {
            font-size: 2rem !important;
        }

        .hero-slide .lead {
            font-size: 1rem !important;
        }
    }

    /* ========== SECTION SCHOOLS (JENJANG PENDIDIKAN) ========== */
    .hover-lift-school {
        transition: all 0.3s ease;
    }

    .hover-lift-school:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(47, 63, 88, 0.2) !important;
    }

    .btn-outline-purple {
        border: 2px solid var(--mbs-purple);
        color: var(--mbs-purple);
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-outline-purple:hover {
        background: var(--mbs-purple);
        color: white;
        transform: scale(1.05);
    }

    .text-purple {
        color: var(--mbs-purple);
    }

    .object-fit-cover {
        object-fit: cover;
    }

    /* ========== ANNOUNCEMENT SECTION (SINGLE LINE SCROLL) ========== */
    .announcement-section {
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
    }

    /* Badge Info Penting */
    .announcement-section .badge {
        white-space: nowrap;
        flex-shrink: 0;
    }

    /* Container Scroll */
    .announcement-scroll-container {
        height: 35px;
        position: relative;
    }

    /* Content yang akan scroll */
    .announcement-scroll-content {
        display: inline-block;
        white-space: nowrap;
        color: white;
        font-size: 0.95rem;
        line-height: 35px;
        padding-left: 100%;
        animation: scroll-announcement 40s linear infinite;
    }

    /* Animasi Scrolling */
    @keyframes scroll-announcement {
        0% {
            transform: translateX(0);
        }

        100% {
            transform: translateX(-100%);
        }
    }

    /* HOVER = PAUSE */
    .announcement-scroll-container:hover .announcement-scroll-content {
        animation-play-state: paused;
    }

    /* Style untuk setiap item pengumuman */
    .announcement-item {
        display: inline-flex;
        align-items: center;
        margin-right: 3rem;
        /* Jarak agak longgar antar pengumuman */
    }

    /* Strip Vertikal Prioritas */
    .priority-strip {
        display: inline-block;
        width: 3px;
        height: 20px;
        margin-right: 10px;
        border-radius: 2px;
        vertical-align: middle;
    }

    /* Icon styling */
    .announcement-item i {
        font-size: 1.1rem;
        vertical-align: middle;
    }

    /* Bullet separator */
    .announcement-scroll-content>.mx-4 {
        color: rgba(255, 255, 255, 0.5);
        font-weight: bold;
    }

    /* Responsive - Mobile */
    @media (max-width: 768px) {
        .announcement-scroll-content {
            font-size: 0.85rem;
            animation: scroll-announcement 30s linear infinite;
        }

        .announcement-section .badge {
            font-size: 0.65rem !important;
            padding: 0.4rem 0.7rem !important;
        }

        .priority-strip {
            height: 16px;
            width: 2.5px;
        }

        .announcement-item {
            margin-right: 2rem;
        }
    }

    @media (max-width: 576px) {
        .announcement-scroll-content {
            font-size: 0.8rem;
            animation: scroll-announcement 25s linear infinite;
        }

        .announcement-scroll-container {
            height: 30px;
        }
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var swiper = new Swiper(".newsSwiper", {
            slidesPerView: 1.2,
            spaceBetween: 20,
            grabCursor: true,
            navigation: {
                nextEl: ".swiper-next-btn",
                prevEl: ".swiper-prev-btn",
            },
            breakpoints: {
                768: {
                    slidesPerView: 2.2,
                    spaceBetween: 25,
                },
                1024: {
                    slidesPerView: 2.5, // Tampilan Desktop
                    spaceBetween: 30,
                },
            },
        });
    });

    // ========== HERO SLIDER SWIPER ==========
    document.addEventListener("DOMContentLoaded", function() {
        var heroSwiper = new Swiper(".heroSwiper", {
            loop: true,
            autoplay: {
                delay: 5000, // Auto slide tiap 5 detik
                disableOnInteraction: false,
            },
            effect: 'fade', // Efek transisi fade
            fadeEffect: {
                crossFade: true
            },
            speed: 1000, // Durasi transisi (ms)
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
                dynamicBullets: true, // Dots lebih dinamis
            },
        });
    });
</script>

<?= $this->endSection() ?>