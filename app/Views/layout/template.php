<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>

    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons (Bootstrap Icons) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>

<body>

    <!-- 1. TOP BAR (Info Kecil di Atas) -->
    <div class="top-bar">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="small">
                <i class="bi bi-envelope-fill me-2"></i> <?= esc($site['email'] ?? 'email@mbs.sch.id') ?>
                <span class="mx-2">|</span>
                <i class="bi bi-telephone-fill me-2"></i> <?= esc($site['phone'] ?? '08123456789') ?>
            </div>
            <div class="social-icons">
                <a href="<?= esc($site['facebook_url']) ?>" class="text-white me-2"><i class="bi bi-facebook"></i></a>
                <a href="<?= esc($site['instagram_url']) ?>" class="text-white me-2"><i class="bi bi-instagram"></i></a>
                <a href="<?= esc($site['youtube_url']) ?>" class="text-white me-2"><i class="bi bi-youtube"></i></a>
                <?php if (!empty($site['tiktok_url'])): ?>
                    <a href="<?= esc($site['tiktok_url']) ?>" class="text-white"><i class="bi bi-tiktok"></i></a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- 2. NAVBAR UTAMA (Sticky) -->
    <nav class="navbar navbar-expand-lg navbar-mbs sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="<?= base_url() ?>">
                <?php if (!empty($site['site_logo'])): ?>
                    <img src="<?= base_url($site['site_logo']) ?>" height="50" alt="Logo MBS">
                <?php else: ?>
                    <i class="bi bi-building-fill fs-2" style="color: var(--mbs-purple);"></i>
                <?php endif; ?>

                <div class="d-flex flex-column lh-1">
                    <span class="fw-bold" style="color: var(--mbs-purple);">
                        <?= esc($site['site_name'] ?? 'MBS Portal') ?>
                    </span>
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto gap-3 align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link fw-bold <?= uri_string() == '' ? 'active-custom' : '' ?>" href="<?= base_url() ?>">Beranda</a>
                    </li>

                    <?php
                    // Ambil Data Grouped PUSAT (NULL)
                    $pageModel = new \App\Models\PageModel();
                    $groupedPages = $pageModel->getPagesGrouped(null);

                    $navSchoolModel = new \App\Models\SchoolModel();
                    $navSchools = $navSchoolModel->orderBy('order_position', 'ASC')->findAll();

                    ?>

                    <?php if (!empty($groupedPages)) : ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link fw-medium dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Tentang MBS
                                <i class="bi bi-chevron-down ms-1" style="font-size: 0.75rem;"></i>
                            </a>

                            <ul class="dropdown-menu">
                                <?php foreach ($groupedPages as $menuName => $pages): ?>
                                    <li class="dropend">
                                        <a class="dropdown-item dropdown-toggle" href="#" role="button">
                                            <?= esc($menuName) ?>
                                            <i class="bi bi-chevron-right text-muted" style="font-size: 0.8em;"></i>
                                        </a>

                                        <ul class="dropdown-menu">
                                            <?php foreach ($pages as $p): ?>
                                                <li>
                                                    <a class="dropdown-item" href="<?= base_url('page/' . $p['slug']) ?>">
                                                        <i class="bi bi-dash text-muted"></i>
                                                        <?= esc($p['title']) ?>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if (!empty($navSchools)) : ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link fw-medium dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Jenjang
                                <i class="bi bi-chevron-down ms-1" style="font-size: 0.75rem;"></i>
                            </a>

                            <ul class="dropdown-menu border-top-purple mt-2">
                                <?php foreach ($navSchools as $ns): ?>
                                    <li>
                                        <a class="dropdown-item rounded py-2 px-3 fw-medium d-flex align-items-center justify-content-between"
                                            href="<?= base_url($ns['slug']) ?>">
                                            <span><?= esc($ns['name']) ?></span>
                                            <i class="bi bi-arrow-right-short text-muted"></i>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link fw-medium <?= strpos(uri_string(), 'news') !== false ? 'active-custom' : '' ?>" href="<?= base_url('news') ?>">Berita</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link fw-medium dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Dokumen
                            <i class="bi bi-chevron-down ms-1 toggle-icon" style="font-size: 0.75rem; transition: transform 0.3s;"></i>
                        </a>
                        <ul class="dropdown-menu border-0 animate slideIn mt-2 p-2" style="border-radius: 12px; min-width: 220px;">

                            <li><span class="dropdown-header text-uppercase x-small fw-bold text-muted">Arsip Yayasan</span></li>
                            <li>
                                <a class="dropdown-item rounded py-2 px-3 fw-medium text-purple" href="<?= base_url('dokumen') ?>">
                                    <i class="bi bi-folder-fill me-2"></i>Dokumen Pusat
                                </a>
                            </li>

                            <li>
                                <hr class="dropdown-divider my-2">
                            </li>

                            <li><span class="dropdown-header text-uppercase x-small fw-bold text-muted">Dokumen Unit</span></li>
                            <?php if (!empty($navSchools)) : ?>
                                <?php foreach ($navSchools as $ns): ?>
                                    <li>
                                        <a class="dropdown-item rounded py-2 px-3 d-flex align-items-center justify-content-between"
                                            href="<?= base_url($ns['slug'] . '/dokumen') ?>">
                                            <span><?= esc($ns['name']) ?></span>
                                            <i class="bi bi-box-arrow-up-right text-muted" style="font-size: 0.7rem;"></i>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium <?= strpos(uri_string(), 'gallery') !== false ? 'active-custom' : '' ?>" href="<?= base_url('gallery') ?>">Galeri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium <?= strpos(uri_string(), 'events') !== false ? 'active-custom' : '' ?>" href="<?= base_url('events') ?>">Agenda</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <!-- 3. CONTENT SECTION (Dinamis) -->
    <!-- Bagian ini akan diisi oleh konten landing page -->
    <?= $this->renderSection('content') ?>

    <!-- 4. FOOTER -->
    <footer class="bg-white pt-5 pb-4 border-top" style="border-top: 5px solid var(--mbs-purple) !important;">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5 class="fw-bold mb-3 text-purple">
                        <?= esc($site['site_name'] ?? 'MBS Boarding School') ?>
                    </h5>

                    <p class="text-secondary small mb-4">
                        <?= esc($site['site_desc'] ?? 'Membangun Generasi Qurani Berkemajuan dengan pendidikan terintegrasi.') ?>
                    </p>
                    <div class="d-flex align-items-center gap-3 mb-4">

                        <?php if (!empty($site['site_logo'])): ?>
                            <img src="<?= base_url($site['site_logo']) ?>" height="55" class="object-fit-contain" alt="Logo Utama">
                        <?php else: ?>
                            <i class="bi bi-building-fill fs-1 text-purple"></i>
                        <?php endif; ?>

                        <?php if (!empty($site['site_logo_2'])): ?>
                            <img src="<?= base_url($site['site_logo_2']) ?>" height="55" class="object-fit-contain" alt="Logo 2">
                        <?php endif; ?>

                        <?php if (!empty($site['site_logo_3'])): ?>
                            <img src="<?= base_url($site['site_logo_3']) ?>" height="55" class="object-fit-contain" alt="Logo 3">
                        <?php endif; ?>

                    </div>


                    <div class="small d-flex flex-column gap-2 mb-4 text-secondary">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-geo-alt-fill me-2 mt-1 text-purple"></i>
                            <span><?= esc($site['address'] ?? 'Alamat belum diatur') ?></span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-telephone-fill me-2 text-purple"></i>
                            <span><?= esc($site['phone'] ?? '-') ?></span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-envelope-fill me-2 text-purple"></i>
                            <span><?= esc($site['email'] ?? '-') ?></span>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <?php if (!empty($site['facebook_url'])): ?>
                            <a href="<?= esc($site['facebook_url']) ?>" class="btn btn-sm btn-outline-purple rounded-circle" target="_blank"><i class="bi bi-facebook"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($site['instagram_url'])): ?>
                            <a href="<?= esc($site['instagram_url']) ?>" class="btn btn-sm btn-outline-purple rounded-circle" target="_blank"><i class="bi bi-instagram"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($site['youtube_url'])): ?>
                            <a href="<?= esc($site['youtube_url']) ?>" class="btn btn-sm btn-outline-purple rounded-circle" target="_blank"><i class="bi bi-youtube"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($site['tiktok_url'])): ?>
                            <a href="<?= esc($site['tiktok_url']) ?>" class="btn btn-sm btn-outline-purple rounded-circle" target="_blank"><i class="bi bi-tiktok"></i></a>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-lg-2 col-6 mb-4">
                    <h5 class="fw-bold mb-3" style="color: var(--mbs-purple);">Tentang</h5>

                    <ul class="list-unstyled small footer-link">
                        <li class="mb-2">
                            <a href="<?= base_url('tentang') ?>" class="text-secondary text-decoration-none hover-purple d-flex align-items-center">
                                <i class="bi bi-info-circle me-2 text-purple"></i> Profil & Informasi
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-2 col-6 mb-4">
                    <h5 class="fw-bold mb-3" style="color: var(--mbs-purple);">Pendidikan</h5>

                    <?php
                    // Panggil Model Sekolah
                    $schoolModelFooter = new \App\Models\SchoolModel();
                    // Ambil semua sekolah, urutkan sesuai settingan admin
                    $footerSchools = $schoolModelFooter->orderBy('order_position', 'ASC')->findAll();
                    ?>

                    <ul class="list-unstyled small footer-link">
                        <?php if (!empty($footerSchools)) : ?>
                            <?php foreach ($footerSchools as $school): ?>
                                <li class="mb-2">
                                    <?php
                                    $linkUrl = !empty($school['website_url']) ? $school['website_url'] : base_url('#jenjang-sekolah');
                                    $target = !empty($school['website_url']) ? '_blank' : '_self';
                                    ?>

                                    <a href="<?= $linkUrl ?>" target="<?= $target ?>" class="text-secondary text-decoration-none hover-purple">
                                        <?= esc($school['name']) ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <li class="mb-2 text-muted fst-italic">Data sekolah belum diinput</li>
                        <?php endif; ?>
                    </ul>
                </div>

                <div class="col-lg-4 mb-4">
                    <h5 class="fw-bold mb-3" style="color: var(--mbs-purple);">Lokasi</h5>
                    <div class="ratio ratio-16x9 bg-light rounded overflow-hidden shadow-sm border">
                        <?php if (!empty($site['maps_embed_url'])) : ?>
                            <?= $site['maps_embed_url'] ?>
                        <?php else : ?>
                            <div class="d-flex align-items-center justify-content-center h-100 text-muted small">
                                Peta belum diatur
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="border-top mt-4 pt-4" style="border-color: #eee !important;">
            <div class="container text-center small text-muted">
                &copy; <?= date('Y') ?> <strong style="color: var(--mbs-purple);"><?= esc($site['site_name'] ?? 'MBS Boarding School') ?></strong>. All Rights Reserved.
                <span class="d-none d-md-inline">| Built with by <span class="text-purple fw-bold">KKP-PLUS ENREKANG TEKNIK UNISMUH MAKASSAR 2025</span></span>
            </div>
        </div>
    </footer>

    <style>
        /* --- 0. KONFIGURASI WARNA & DASAR --- */
        :root {
            --mbs-purple: #2f3f58;
            /* Warna Utama */
            --mbs-purple-light: #e8ecf1;
            /* Warna Hover (Ungu Muda) */
            --mbs-text-dark: #333333;
        }

        /* Override Warna Button Bootstrap Default */
        .btn-primary {
            background-color: var(--mbs-purple) !important;
            border-color: var(--mbs-purple) !important;
        }

        .btn-primary:hover,
        .btn-primary:active,
        .btn-primary:focus {
            background-color: var(--mbs-purple-dark) !important;
            border-color: var(--mbs-purple-dark) !important;
            color: var(--mbs-purple) !important;
        }

        .btn-outline-primary {
            color: var(--mbs-purple) !important;
            border-color: var(--mbs-purple) !important;
        }

        .btn-outline-primary:hover {
            background-color: var(--mbs-purple) !important;
            color: white !important;
        }

        /* Fix Pagination agar seragam */
        .page-item.active .page-link {
            background-color: var(--mbs-purple) !important;
            border-color: var(--mbs-purple) !important;
        }

        .page-link {
            color: var(--mbs-purple-light) !important;
            background-color: var(--mbs-purple-dark) !important;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            color: var(--mbs-text-dark);
            padding-top: 0;
            /* Reset padding agar tidak ada gap putih */
        }

        /* --- 1. PERBAIKAN MOBILE & RESPONSIVE --- */
        @media (max-width: 991px) {
            body {
                padding-top: 0 !important;
                /* Paksa 0 di mobile */
            }

            .navbar-collapse {
                background: white;
                padding: 15px;
                border-radius: 15px;
                margin-top: 10px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            }
        }

        /* --- 2. HAPUS PANAH BAWAAN BOOTSTRAP (Agar tidak double) --- */
        .dropdown-toggle::after {
            display: none !important;
            content: none !important;
        }

        /* --- 3. NAVBAR LINK STYLE (Garis Bawah Animasi) --- */
        .nav-link {
            color: #555;
            font-weight: 500;
            padding: 10px 18px !important;
            position: relative;
            transition: color 0.3s ease;
            border-radius: 50px;
            /* Opsional: memberi bentuk oval saat hover */
        }

        /* Garis Bawah */
        .navbar-nav .nav-link::before {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 5px;
            left: 0;
            background-color: var(--mbs-purple);
            transition: width 0.3s ease-in-out;
        }

        /* Hover State */
        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active,
        .navbar-nav .show>.nav-link {
            color: var(--mbs-purple) !important;
            background-color: rgba(47, 63, 88, 0.05);
            /* Background tipis */
        }

        .navbar-nav .nav-link:hover::before,
        .navbar-nav .show>.nav-link::before {
            width: 100%;
            /* Garis memanjang */
        }

        /* --- 4. DROPDOWN MENU UTAMA --- */
        .dropdown-menu {
            border: none;
            border-top: 3px solid var(--mbs-purple);
            /* Aksen Ungu di Atas */
            border-radius: 0 0 8px 8px;
            box-shadow: none !important;
            margin-top: 0;
            padding: 5px 0;
            min-width: 230px;
            /* Lebar minimum agar teks tidak terpotong */
            background-color: #fff;
        }

        /* --- 5. ITEM DROPDOWN (Isi Menu) --- */
        .dropdown-item {
            font-size: 0.95rem;
            color: #444;
            padding: 10px 20px;
            font-weight: 400;
            transition: all 0.2s ease;

            /* Flexbox untuk merapikan Icon dan Teks */
            display: flex;
            align-items: center;
            justify-content: flex-start;
            /* Default rata kiri */
            gap: 10px;
            /* Jarak antara Icon dan Teks (Solusi icon jauh) */
        }

        .dropdown-item:hover {
            background-color: var(--mbs-purple-light);
            color: var(--mbs-purple);
            padding-left: 25px;
            /* Efek geser kanan */
        }

        /* KHUSUS Tombol Submenu (Informasi > Sejarah) */
        /* Kita paksa agar panah submenu ada di ujung kanan */
        .dropend>.dropdown-toggle {
            justify-content: space-between !important;
        }

        /* --- 6. LOGIKA MENU BERCABANG (NESTED) & ANIMASI --- */

        /* Transisi Icon agar muter halus */
        .bi-chevron-down,
        .bi-chevron-right {
            transition: transform 0.3s ease !important;
        }

        /* A. TAMPILAN DESKTOP (Layar Besar) */
        @media (min-width: 992px) {

            /* Dropdown Utama muncul saat Hover */
            .nav-item.dropdown:hover>.dropdown-menu {
                display: block;
                animation: fadeInUp 0.3s ease;
            }

            /* Rotasi Icon Menu Utama saat Hover */
            .nav-item.dropdown:hover>.nav-link .bi-chevron-down {
                transform: rotate(180deg);
            }

            /* Submenu: Posisi Relative */
            .dropend {
                position: relative;
            }

            /* Submenu: Muncul di Kanan saat Hover */
            .dropend:hover>.dropdown-menu {
                display: block;
                position: absolute;
                top: 0;
                left: 100%;
                margin-left: 0.1rem;
                margin-top: -5px;
                border-radius: 8px;
                border-top: none;
                border-left: 3px solid var(--mbs-purple);
                animation: fadeInLeft 0.3s ease;
            }

            /* Submenu: Rotasi Panah Kanan saat Hover */
            .dropend:hover>.dropdown-item .bi-chevron-right {
                transform: rotate(90deg);
            }
        }

        /* B. TAMPILAN MOBILE (Layar Kecil) */
        @media (max-width: 991px) {

            /* Submenu muncul di bawah (indentasi) bukan di samping */
            .dropend .dropdown-menu {
                position: static;
                display: none;
                float: none;
                width: 100%;
                margin-top: 0;
                background-color: #f9f9f9;
                border: none;
                border-left: 2px solid #ddd;
                box-shadow: none;
                padding-left: 20px;
            }

            /* Tampilkan jika ada class 'show' (dari JS) */
            .dropend .dropdown-menu.show {
                display: block;
            }

            /* Rotasi Icon saat Menu Utama dibuka (Bootstrap logic) */
            .nav-link[aria-expanded="true"] .bi-chevron-down {
                transform: rotate(180deg);
            }

            /* Rotasi Icon saat Submenu dibuka (Custom JS logic) */
            .dropdown-item.show .bi-chevron-right {
                transform: rotate(90deg);
            }
        }

        /* --- 7. ANIMASI KEYFRAMES --- */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* --- 8. UTILITIES LAIN --- */
        .text-purple {
            color: var(--mbs-purple) !important;
        }

        .bg-purple {
            background-color: var(--mbs-purple) !important;
        }

        .btn-outline-purple {
            color: var(--mbs-purple);
            border-color: var(--mbs-purple);
        }

        .btn-outline-purple:hover {
            background-color: var(--mbs-purple);
            color: white;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const submenuToggles = document.querySelectorAll('.dropdown-menu .dropdown-toggle');

            submenuToggles.forEach(function(toggle) {
                toggle.addEventListener('click', function(e) {
                    // Hanya jalankan di Mobile (< 992px)
                    if (window.innerWidth < 992) {
                        e.preventDefault();
                        e.stopPropagation(); // Mencegah menu induk tertutup

                        const nextEl = this.nextElementSibling;
                        if (nextEl && nextEl.classList.contains('dropdown-menu')) {
                            // Tutup submenu lain yang terbuka (opsional, biar rapi)
                            const parentMenu = this.closest('.dropdown-menu');
                            if (parentMenu) {
                                parentMenu.querySelectorAll('.dropdown-menu.show').forEach(function(openMenu) {
                                    if (openMenu !== nextEl) {
                                        openMenu.classList.remove('show');
                                        // Reset icon submenu lain
                                        if (openMenu.previousElementSibling) {
                                            openMenu.previousElementSibling.classList.remove('show');
                                        }
                                    }
                                });
                            }

                            // Toggle menu ini
                            nextEl.classList.toggle('show');
                            // Toggle class di tombol (untuk rotasi icon)
                            this.classList.toggle('show');
                        }
                    }
                });
            });
        });
    </script>
    <?php if (!empty($portal_announcements)): ?>

        <style>
            body {
                padding-bottom: 50px;
            }
        </style>

        <div class="sticky-ticker-container" id="mbsTicker">

            <div class="ticker-label">
                <i class="bi bi-broadcast me-2 animate-pulse"></i> INFO PUSAT
            </div>

            <div class="ticker-content-wrapper">
                <div class="ticker-content">
                    <?php foreach ($portal_announcements as $anno): ?>
                        <?php
                        // Logika Warna Berdasarkan Kategori
                        $colorClass = match ($anno['category']) {
                            'urgent'    => '#ff4d4d', // Merah Terang
                            'important' => '#ffcc00', // Kuning
                            'normal'    => '#00d2ff', // Biru Cyan
                            default     => '#ffffff'
                        };
                        ?>

                        <span class="ticker-item">

                            <span class="ticker-strip" style="background-color: <?= $colorClass ?>;"></span>

                            <i class="bi <?= esc($anno['icon']) ?> me-2" style="color: <?= $colorClass ?>;"></i>

                            <strong style="color: <?= $colorClass ?>;"><?= esc($anno['title']) ?>:</strong>
                            <span class="text-white mx-1"><?= esc($anno['content']) ?></span>

                            <?php if (!empty($anno['link_url'])): ?>
                                <a href="<?= esc($anno['link_url']) ?>" target="_blank" class="ticker-link" style="border-color: <?= $colorClass ?>; color: <?= $colorClass ?>;">
                                    <i class="bi bi-link-45deg"></i> Buka
                                </a>
                            <?php endif; ?>

                        </span>
                    <?php endforeach; ?>
                </div>
            </div>

            <button class="ticker-close" onclick="document.getElementById('mbsTicker').style.display='none'; document.body.style.paddingBottom='0';">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <style>
            /* STICKY FOOTER CONTAINER */
            .sticky-ticker-container {
                position: fixed;
                bottom: 0;
                left: 0;
                width: 100%;
                height: 42px;
                /* Sedikit dikecilkan */
                background: #2c1e3f;
                /* Ungu gelap */
                color: white;
                z-index: 9999;
                display: flex;
                align-items: center;
                box-shadow: 0 -4px 15px rgba(0, 0, 0, 0.3);
                font-family: 'Inter', sans-serif;
                font-size: 0.85rem;
                /* Font dasar dikecilkan */
                border-top: 1px solid rgba(255, 255, 255, 0.1);
            }

            /* LABEL KIRI (INFO PUSAT) */
            .ticker-label {
                background: #2f3f58;
                color: white;
                height: 100%;
                padding: 0 15px;
                /* Padding dikurangi */
                display: flex;
                align-items: center;
                font-weight: 700;
                font-size: 0.8rem;
                /* Font label kecil */
                position: relative;
                z-index: 2;
                box-shadow: 3px 0 10px rgba(0, 0, 0, 0.2);
                white-space: nowrap;
                /* Agar tidak turun baris */
            }

            /* Icon Broadcast berdenyut */
            .animate-pulse {
                animation: pulse 2s infinite;
            }

            @keyframes pulse {
                0% {
                    opacity: 1;
                }

                50% {
                    opacity: 0.6;
                }

                100% {
                    opacity: 1;
                }
            }

            /* WRAPPER ANIMASI */
            .ticker-content-wrapper {
                flex-grow: 1;
                overflow: hidden;
                white-space: nowrap;
                height: 100%;
                display: flex;
                align-items: center;
                background: rgba(0, 0, 0, 0.2);
                mask-image: linear-gradient(to right, transparent, black 10px, black 95%, transparent);
                /* Efek fade di ujung */
                -webkit-mask-image: linear-gradient(to right, transparent, black 10px, black 95%, transparent);
            }

            /* ANIMASI BERJALAN */
            .ticker-content {
                display: inline-flex;
                /* Flex agar item sejajar */
                align-items: center;
                padding-left: 100%;
                animation: ticker-move 40s linear infinite;
                /* Kecepatan sedang */
            }

            /* Pause saat disentuh/hover */
            .sticky-ticker-container:hover .ticker-content {
                animation-play-state: paused;
            }

            @keyframes ticker-move {
                0% {
                    transform: translate3d(0, 0, 0);
                }

                100% {
                    transform: translate3d(-100%, 0, 0);
                }
            }

            /* ITEM BERITA */
            .ticker-item {
                display: inline-flex;
                align-items: center;
                margin-right: 40px;
                /* Jarak antar berita dikurangi */
                position: relative;
                padding-left: 12px;
                /* Ruang untuk strip */
                height: 100%;
                /* Agar strip posisinya pas */
            }

            /* STRIP GARIS WARNA DI KIRI */
            .ticker-strip {
                position: absolute;
                left: 0;
                top: 50%;
                transform: translateY(-50%);
                width: 3px;
                /* Garis lebih tipis */
                height: 60%;
                /* Tinggi garis disesuaikan */
                border-radius: 2px;
            }

            /* ICON BERITA */
            .ticker-item i.bi:not(.bi-link-45deg) {
                font-size: 1.1em;
                /* Ukuran icon sedikit lebih besar dari teks */
                margin-right: 6px !important;
                display: flex;
                align-items: center;
                /* Memastikan icon di tengah vertikal */
            }

            /* LINK TOMBOL */
            .ticker-link {
                text-decoration: none;
                margin-left: 8px;
                font-size: 0.75em;
                /* Link lebih kecil */
                border: 1px solid;
                padding: 1px 5px;
                border-radius: 4px;
                opacity: 0.9;
                transition: all 0.2s;
                display: inline-flex;
                align-items: center;
                background: rgba(0, 0, 0, 0.1);
            }

            .ticker-link:hover {
                opacity: 1;
                color: white !important;
                border-color: white !important;
                background: rgba(255, 255, 255, 0.1);
            }

            /* TOMBOL CLOSE (X) */
            .ticker-close {
                background: transparent;
                border: none;
                border-left: 1px solid rgba(255, 255, 255, 0.1);
                color: #aaa;
                width: 40px;
                /* Lebih ramping */
                height: 100%;
                cursor: pointer;
                z-index: 2;
                flex-shrink: 0;
                /* Agar tidak mengecil */
            }

            .ticker-close:hover {
                background: #dc3545;
                color: white;
            }

            /* =========================================
           RESPONSIF KHUSUS HP (Max Width 576px)
        ========================================= */
            @media (max-width: 576px) {
                .sticky-ticker-container {
                    height: 38px;
                    /* Bar lebih pendek di HP */
                    font-size: 0.75rem;
                    /* Font isi lebih kecil lagi */
                }

                .ticker-label {
                    padding: 0 10px;
                    font-size: 0.7rem;
                    /* Label lebih kecil */
                }

                /* Sembunyikan teks "INFO PUSAT", sisakan icon saja agar hemat tempat */
                .ticker-label span {
                    display: none;
                }

                .ticker-label i {
                    margin-right: 0 !important;
                    font-size: 1rem;
                }

                .ticker-item {
                    margin-right: 30px;
                    padding-left: 10px;
                }

                .ticker-strip {
                    width: 2px;
                    height: 50%;
                }

                /* Strip lebih kecil */
                .ticker-item i.bi:not(.bi-link-45deg) {
                    font-size: 1em;
                    margin-right: 4px !important;
                }

                /* Icon berita disesuaikan */

                /* Judul berita jangan bold di HP biar tidak terlalu penuh */
                .ticker-item strong {
                    font-weight: 600;
                }

                .ticker-link {
                    font-size: 0.7em;
                    /* Tombol link mini */
                    padding: 0 4px;
                    margin-left: 5px;
                }

                .ticker-link span {
                    display: none;
                }

                /* Hapus teks "Buka", sisakan icon link */
                .ticker-link i {
                    margin-right: 0 !important;
                }

                .ticker-close {
                    width: 35px;
                }
            }
        </style>
    <?php endif; ?>
</body>

</html>