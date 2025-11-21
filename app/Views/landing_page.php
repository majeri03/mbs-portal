<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<!-- ============================================================== -->
<!-- SECTION 2: HERO IMAGE (BACKGROUND BESAR) -->
<!-- ============================================================== -->
<section class="hero-section position-relative d-flex align-items-center text-white" style="min-height: 85vh; padding-bottom: 150px;">
    
    <!-- 1. Background Image (Ganti URL ini dengan foto sekolah asli nanti) -->
    <div class="position-absolute top-0 start-0 w-100 h-100" 
         style="background: url('https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=1600&auto=format&fit=crop') no-repeat center center/cover; z-index: -2;">
    </div>
    
    <!-- 2. Overlay Gelap (Agar teks terbaca) -->
    <div class="position-absolute top-0 start-0 w-100 h-100" 
         style="background: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.7)); z-index: -1;">
    </div>

    <!-- 3. Konten Teks Hero -->
    <div class="container position-relative z-index-1 mt-n5">
        <div class="row">
            <div class="col-lg-8">
                <span class="badge bg-white text-dark text-uppercase mb-3 px-3 py-2 fw-bold ls-2">MBS Boarding School</span>
                <h1 class="display-3 fw-bold mb-4">Membangun Generasi<br>Qur'ani Berkemajuan</h1>
                <p class="lead mb-5 text-light opacity-90 w-75">
                    Lembaga pendidikan Islam modern yang mengintegrasikan kurikulum nasional, kepesantrenan, dan pengembangan karakter.
                </p>
            </div>
        </div>
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
                        <select class="form-select form-select-lg rounded-pill fs-6 border-secondary text-secondary">
                            <option selected>-- Pilih Kategori --</option>
                            <option value="1">Berita Sekolah</option>
                            <option value="2">Prestasi Santri</option>
                            <option value="3">Artikel Islami</option>
                        </select>
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

                    <a href="#" class="btn btn-outline-primary rounded-pill px-4 w-100 w-md-auto fw-bold btn-view-all">LIHAT SEMUA</a>
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
                                                <a href="#" class="text-decoration-none text-dark stretched-link hover-purple text-clamp-2">
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
                                            <div class="mt-auto pt-3 border-top border-light text-muted x-small">
                                                <i class="bi bi-calendar-event me-2"></i> 
                                                <?= date('d M Y', strtotime($news['created_at'])) ?>
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
<!-- SECTION 4: PENGUMUMAN (Running Text) -->
<!-- ============================================================== -->
<?php if (!empty($announcements)) : ?>
<div class="bg-light border-bottom border-top py-2 mt-5">
    <div class="container d-flex align-items-center">
        <span class="badge bg-danger me-3 rounded-0">INFO PENTING</span>
        <div class="flex-grow-1 overflow-hidden">
            <marquee class="mb-0 text-dark small fw-bold" scrollamount="8">
                <?php foreach ($announcements as $info) : ?>
                    <span class="me-5"><i class="bi bi-megaphone-fill text-secondary me-1"></i> <?= esc($info['content']) ?></span>
                <?php endforeach; ?>
            </marquee>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- ============================================================== -->
<!-- SECTION 3: NAVIGASI JENJANG (3 KARTU UTAMA) -->
<!-- ============================================================== -->
<section id="jenjang-sekolah" class="py-5 bg-white">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h6 class="text-uppercase fw-bold text-secondary ls-2">Pendidikan</h6>
            <h2 class="fw-bold display-6 text-purple">Jenjang Pendidikan</h2>
            <div class="divider mx-auto mt-3 bg-purple" style="width: 60px; height: 3px;"></div>
        </div>

        <div class="row g-4">
            <?php foreach ($schools as $school) : ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm h-100 overflow-hidden group-hover">
                        <div class="position-relative overflow-hidden" style="height: 250px;">
                            <img src="https://source.unsplash.com/600x400/?student,<?= $school['slug'] ?>" class="img-fluid w-100 h-100 object-fit-cover transition-transform" alt="<?= esc($school['name']) ?>">
                            <div class="overlay-hover position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" style="background: rgba(88, 44, 131, 0.85); opacity: 0; transition: all 0.3s;">
                                <a href="<?= base_url('sekolah/' . esc($school['slug'])) ?>" class="btn btn-outline-light rounded-0 text-uppercase fw-bold px-4 py-2">Lihat Profil</a>
                            </div>
                        </div>
                        <div class="card-body text-center p-4 bg-white">
                            <h3 class="card-title h4 fw-bold mb-2"><?= esc($school['name']) ?></h3>
                            <p class="text-muted small"><?= esc($school['description']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
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
             <a href="#" class="text-decoration-none fw-bold" style="color: var(--mbs-purple);">Lihat Kalender <i class="bi bi-arrow-right"></i></a>
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
            <a href="#" class="btn btn-outline-secondary rounded-pill px-4">Lihat Galeri Lengkap <i class="bi bi-arrow-right"></i></a>
        </div>
    </div>
</section>

<!-- SECTION 8: PROFIL SINGKAT & VIDEO (SAMBUTAN DIREKTUR) -->
<section class="py-5 position-relative text-white" style="background-color: var(--mbs-purple);">
    <!-- Background Pattern/Decoration -->
    <div class="position-absolute top-0 end-0 p-5 opacity-10 d-none d-md-block">
        <i class="bi bi-quote" style="font-size: 15rem; color: white;"></i>
    </div>

    <div class="container py-5">
        <div class="row align-items-center">
            <!-- Kolom Kiri: Text Sambutan -->
            <div class="col-lg-6 mb-5 mb-lg-0 z-index-2 position-relative">
                <span class="badge bg-warning text-dark mb-3 px-3 py-2">KENAL LEBIH DEKAT</span>
                <h2 class="display-5 fw-bold mb-4">Mendidik dengan Hati, <br>Mengabdi untuk Negeri.</h2>
                <p class="lead opacity-75 mb-4">
                    "MBS berkomitmen mencetak kader ulama yang intelek dan intelektual yang ulama. Kami memadukan kedalaman ilmu agama dengan wawasan sains modern."
                </p>
                
                <div class="d-flex align-items-center mt-4">
                    <!-- Foto Direktur (Placeholder) -->
                    <img src="https://ui-avatars.com/api/?name=Direktur+MBS&background=random&size=128" class="rounded-circle border border-3 border-white me-3" width="60" alt="Direktur">
                    <div>
                        <h5 class="fw-bold mb-0">Ustadz Fulan, Lc., M.Ag.</h5>
                        <small class="opacity-75">Direktur Pesantren MBS</small>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Video Embed -->
            <div class="col-lg-6 position-relative z-index-2">
                <div class="ratio ratio-16x9 rounded-4 shadow-lg border border-5 border-white overflow-hidden" style="transform: rotate(2deg);">
                    <!-- Ambil link youtube dari database settings jika ada, atau default -->
                    <?php 
                        // Logic sederhana ubah link watch jadi embed
                        $yt_url = $site['youtube_url'] ?? 'https://www.youtube.com/watch?v=dQw4w9WgXcQ';
                        // (Note: Di real project nanti kita buat helper function untuk parsing ID youtube yang benar)
                        // Untuk dummy, kita hardcode iframe dulu agar tampil rapi
                    ?>
                    <iframe src="https://www.youtube.com/embed/EngW7tLk6R8?si=dummy" title="Profil MBS" allowfullscreen></iframe>
                </div>
                <!-- Dekorasi kotak di belakang video -->
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
    .text-purple { color: var(--mbs-purple); }
    .bg-purple { background-color: var(--mbs-purple); }
    .border-purple { border-color: var(--mbs-purple) !important; }
    .hover-purple:hover { color: var(--mbs-purple) !important; }

    /* HERO & FLOATING SECTION (KUNCI DESIGN) */
    /* Di layar besar, tarik section berita ke atas (-100px) */
    @media (min-width: 992px) {
        .floating-section {
            margin-top: -120px; /* INI KUNCINYA: Menarik ke atas */
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
    .group-hover:hover img { transform: scale(1.05); }
    .transition-transform { transition: transform 0.5s ease; }
    .hover-top { transition: transform 0.3s ease; }
    .hover-top:hover { transform: translateY(-5px); }

    /* UTILS */
    .ls-2 { letter-spacing: 2px; }
    .object-fit-cover { object-fit: cover; }
    .x-small { font-size: 0.75rem; }

    .text-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .text-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3; /* Maksimal 3 baris deskripsi */
        line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .lh-sm { line-height: 1.4; } 
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
</script>

<?= $this->endSection() ?>