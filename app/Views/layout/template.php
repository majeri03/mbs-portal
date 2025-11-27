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

                            <ul class="dropdown-menu shadow-lg">
                                <?php foreach ($groupedPages as $menuName => $pages): ?>
                                    <li class="dropend">
                                        <a class="dropdown-item dropdown-toggle" href="#" role="button">
                                            <?= esc($menuName) ?>
                                            <i class="bi bi-chevron-right text-muted" style="font-size: 0.8em;"></i>
                                        </a>

                                        <ul class="dropdown-menu shadow-lg">
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

                            <ul class="dropdown-menu shadow-lg border-top-purple mt-2">
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
                        <ul class="dropdown-menu shadow-lg border-0 animate slideIn mt-2 p-2" style="border-radius: 12px; min-width: 220px;">

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

                    <?php
                    // Cek apakah variabel $menuPages sudah ada (dari navbar). 
                    // Jika belum, kita panggil lagi modelnya.
                    if (!isset($menuPages)) {
                        $pageModel = new \App\Models\PageModel();
                        try {
                            $menuPages = $pageModel->getActivePages();
                        } catch (\Exception $e) {
                            $menuPages = [];
                        }
                    }
                    ?>

                    <ul class="list-unstyled small footer-link">
                        <?php if (!empty($menuPages)) : ?>
                            <?php foreach ($menuPages as $mp): ?>
                                <li class="mb-2">
                                    <a href="<?= base_url('page/' . $mp['slug']) ?>" class="text-secondary text-decoration-none hover-purple">
                                        <?= esc($mp['title']) ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <li class="mb-2 text-muted fst-italic">Belum ada informasi</li>
                        <?php endif; ?>
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
            --mbs-purple: #582C83;
            /* Warna Utama */
            --mbs-purple-light: #F3E5F5;
            /* Warna Hover (Ungu Muda) */
            --mbs-text-dark: #333333;
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
            background-color: rgba(88, 44, 131, 0.05);
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
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
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
</body>

</html>