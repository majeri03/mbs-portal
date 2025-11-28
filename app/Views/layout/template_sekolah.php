<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'MBS Boarding School') ?></title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <style>
        :root {
            --mbs-purple: #582C83;
            --mbs-purple-light: #7A4E9F;
            --mbs-text-dark: #333333;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            color: var(--mbs-text-dark);
            padding-top: 0;
        }

        /* --- NAVBAR STYLING --- */
        .navbar-school {
            background-color: white;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            padding: 12px 0;
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--mbs-purple) !important;
            font-size: 1.25rem;
        }

        .nav-link {
            color: #555;
            font-weight: 500;
            padding: 10px 18px !important;
            transition: all 0.3s ease;
            border-radius: 50px;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--mbs-purple) !important;
            background-color: rgba(88, 44, 131, 0.05);
        }

        /* Tombol Kembali ke Pusat */
        .btn-back-portal {
            font-size: 0.85rem;
            color: #666;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: color 0.3s;
        }

        .btn-back-portal:hover {
            color: var(--mbs-purple);
        }

        /* FOOTER STYLING */
        footer {
            background-color: #ffffff;
            color: #555;
            font-size: 0.9rem;
        }

        .footer-title {
            color: var(--mbs-purple);
            font-weight: 700;
            margin-bottom: 1.5rem;
            position: relative;
            display: inline-block;
        }

        .footer-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -8px;
            width: 40px;
            height: 3px;
            background-color: var(--mbs-purple-light);
            border-radius: 2px;
        }

        .footer-link li {
            margin-bottom: 12px;
        }

        .footer-link a {
            color: #666;
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }

        .footer-link a:hover {
            color: var(--mbs-purple);
            transform: translateX(5px);
        }

        .social-btn {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #eee;
            color: var(--mbs-purple);
            transition: all 0.3s ease;
            background-color: #fff;
        }

        .social-btn:hover {
            background-color: var(--mbs-purple);
            color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(88, 44, 131, 0.2);
            border-color: var(--mbs-purple);
        }

        .map-container iframe {
            width: 100%;
            height: 100%;
            border: 0;
            filter: grayscale(0%);
            transition: filter 0.3s;
        }

        .map-container:hover iframe {
            filter: grayscale(0%);
        }

        /* --- UTILITIES --- */
        .text-purple {
            color: var(--mbs-purple) !important;
        }

        .bg-purple {
            background-color: var(--mbs-purple) !important;
        }

        /* --- CSS KHUSUS MULTI-LEVEL DROPDOWN (SOLUSI ANDA) --- */

        /* 1. Styling Dropdown Utama */
        .dropdown-menu {
            border: none;
            border-top: 3px solid var(--mbs-purple);
            border-radius: 0 0 8px 8px;
            box-shadow: none !important;
            padding: 5px 0;
            min-width: 230px;
        }

        .dropdown-item {
            padding: 10px 20px;
            font-size: 0.9rem;
            color: #555;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            /* Default: Rata kiri */
            gap: 10px;
            /* Jarak antara icon dan teks */
        }

        .dropdown-item:hover {
            background-color: rgba(88, 44, 131, 0.05);
            color: var(--mbs-purple);
            padding-left: 25px;
        }

        .dropend>.dropdown-toggle {
            justify-content: space-between !important;
            /* gap tidak dibutuhkan disini karena space-between sudah memisahkan */
        }

        /* 3. Helper untuk panah kecil di samping */
        .caret-right {
            font-size: 0.8em;
            color: #999;
        }

        /* 2. Styling Submenu (Bercabang) - Desktop Only */
        @media (min-width: 992px) {

            /* Agar dropdown induk muncul saat hover */
            .nav-item.dropdown:hover>.dropdown-menu {
                display: block;
                animation: fadeInUp 0.3s ease;
            }

            /* Logika Nested Dropdown (Dropend) */
            .dropend {
                position: relative;
            }

            /* Submenu muncul di kanan induknya saat hover */
            .dropend:hover>.dropdown-menu {
                display: block;
                position: absolute;
                top: 0;
                left: 100%;
                margin-left: 0.1rem;
                margin-top: -5px;
                /* Sedikit naik agar sejajar */
                border-radius: 8px;
                border-top: none;
                border-left: 3px solid var(--mbs-purple);
                /* Garis ungu di kiri untuk submenu */
                animation: fadeInLeft 0.3s ease;
            }
        }

        /* 3. Styling Submenu - Mobile Only (Agar tidak melebar ke samping) */
        @media (max-width: 991px) {
            body {
                padding-top: 0 !important;
                /* Diubah jadi 0 agar tidak ada gap */
            }

            .navbar-collapse {
                background: white;
                padding: 15px;
                border-radius: 15px;
                margin-top: 10px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            }

            body {
                padding-top: 60px;
            }

            /* Di HP, submenu turun ke bawah (indentasi) */
            .dropend .dropdown-menu {
                position: static;
                display: none;
                /* Tetap hidden sampai diklik */
                float: none;
                width: 100%;
                margin-top: 0;
                background-color: #f9f9f9;
                border: none;
                border-left: 2px solid #ddd;
                box-shadow: none;
                padding-left: 20px;
            }

            .dropend .dropdown-menu.show {
                display: block;
            }
        }

        .dropdown-toggle::after {
            display: none !important;
            content: none !important;
        }

        /* Animasi */
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

        /* --- TAMBAHAN: ANIMASI ROTASI ICON --- */

        /* 1. Agar transisi halus */
        .bi-chevron-down,
        .bi-chevron-right {
            display: inline-block !important;
            transition: transform 0.3s ease !important;
        }

        /* 2. Rotasi Icon Menu Utama (Informasi) */
        /* Desktop: Saat Hover */
        @media (min-width: 992px) {
            .nav-item.dropdown:hover>.nav-link .bi-chevron-down {
                transform: rotate(180deg);
            }
        }

        /* Mobile: Saat Class 'show' aktif (otomatis dari Bootstrap) */
        .nav-link[aria-expanded="true"] .bi-chevron-down {
            transform: rotate(180deg);
        }

        /* 3. Rotasi Icon Submenu (Sejarah, dll) */
        /* Desktop: Saat Hover */
        @media (min-width: 992px) {
            .dropend:hover>.dropdown-item .bi-chevron-right {
                transform: rotate(90deg);
                /* Putar ke bawah */
            }
        }

        /* Mobile: Saat Class 'show' aktif (kita tambah lewat JS nanti) */
        .dropdown-item.show .bi-chevron-right {
            transform: rotate(90deg);
        }

        /* CONTAINER UTAMA DI POJOK KANAN BAWAH */
        .floating-anno-container {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            align-items: end;
            gap: 15px;
        }

        /* TOMBOL PEMICU (BULAT) */
        .anno-trigger {
            border-radius: 30px;
            background: linear-gradient(135deg, var(--mbs-purple) 0%, #3D1F5C 100%);
            color: white;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            min-height: 50px;
        }

        .anno-trigger:hover {
            transform: scale(1.1) rotate(-10deg);
        }

        /* PANEL KONTEN (KOTAK CHAT) */
        .anno-panel {
            width: 320px;
            background: white;
            border-radius: 15px;
            overflow: hidden;

            /* Animasi Masuk (Hidden by default) */
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px) scale(0.9);
            /* Geser ke bawah sedikit */
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            transform-origin: bottom right;
            position: absolute;
            bottom: 80px;
            /* Di atas tombol */
            right: 0;
        }

        /* KELAS AKTIF (SAAT MUNCUL) */
        .anno-panel.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) scale(1);
            /* Swap Up ke posisi normal */
        }

        /* HEADER PANEL */
        .anno-header {
            background: var(--mbs-purple);
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* BODY PANEL (SCROLLABLE) */
        .anno-body {
            max-height: 400px;
            overflow-y: auto;
            padding: 15px;
            background-color: #f8f9fa;
        }

        /* ITEM PENGUMUMAN */
        .anno-item {
            font-size: 0.9rem;
            transition: transform 0.2s;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .anno-item:hover {
            transform: translateX(-3px);
        }

        .x-small {
            font-size: 0.75rem;
        }

        .bg-purple-light {
            background-color: rgba(88, 44, 131, 0.1);
        }

        /* ANIMASI BERDENYUT (PULSE) UNTUK BADGE ANGKA */
        @keyframes pulse-red {
            0% {
                box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(220, 53, 69, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
            }
        }

        .pulse-animation {
            animation: pulse-red 2s infinite;
        }

        /* RESPONSIVE MOBILE */
        @media (max-width: 576px) {
            .floating-anno-container {
                bottom: 20px;
                right: 20px;
            }

            .anno-panel {
                width: 280px;
                /* Lebih kecil di HP */
            }
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    <div class="py-2 text-white small" style="background-color: var(--mbs-purple-dark, #3D1F5C);">
        <div class="container d-flex justify-content-between align-items-center">
            <div>
                <i class="bi bi-envelope-fill me-2"></i> <?= esc($school_site['email'] ?? 'info@mbs.sch.id') ?>
                <span class="mx-3">|</span>
                <i class="bi bi-telephone-fill me-2"></i> <?= esc($school_site['phone'] ?? '+62 123 4567 890') ?>
            </div>
            <div class="d-none d-md-block">
                <?php if (!empty($school_site['facebook_url'])): ?>
                    <a href="<?= esc($school_site['facebook_url']) ?>" class="text-white me-3 text-decoration-none"><i class="bi bi-facebook"></i></a>
                <?php endif; ?>
                <?php if (!empty($school_site['instagram_url'])): ?>
                    <a href="<?= esc($school_site['instagram_url']) ?>" class="text-white me-3 text-decoration-none"><i class="bi bi-instagram"></i></a>
                <?php endif; ?>
                <?php if (!empty($school_site['youtube_url'])): ?>
                    <a href="<?= esc($school_site['youtube_url']) ?>" class="text-white me-3 text-decoration-none"><i class="bi bi-youtube"></i></a>
                <?php endif; ?>
                <?php if (!empty($school_site['tiktok_url'])): ?>
                    <a href="<?= esc($school_site['tiktok_url']) ?>" target="_blank" class="text-white text-decoration-none">
                        <i class="bi bi-tiktok"></i>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-school sticky-top bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="<?= site_url('mts') ?>">
                <?php
                // LOGIKA LOGO
                if (!empty($school_site['site_logo'])) {
                    $logoSrc = base_url($school_site['site_logo']);
                    echo '<img src="' . $logoSrc . '" height="50" alt="Logo Sekolah" class="object-fit-contain">';
                } elseif (!empty($school['logo'])) {
                    echo '<img src="' . base_url($school['logo']) . '" height="50" alt="Logo">';
                } else {
                    echo '<i class="bi bi-building-fill fs-2 text-purple"></i>';
                }
                ?>

                <div class="d-flex flex-column lh-1">
                    <span class="fw-bold text-purple"><?= esc($school_site['site_name'] ?? $school['name']) ?></span>
                    <span style="font-size: 0.75rem; color: #666;">
                        <?= esc($school_site['site_desc'] ?? 'MBS Boarding School') ?>
                    </span>
                </div>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto align-items-center gap-1">

                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('mts') ?>">Beranda</a>
                    </li>

                    <?php if (!empty($school_pages_grouped)) : ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Informasi <i class="bi bi-chevron-down small transition-icon" style="font-size: 0.7rem;"></i>
                            </a>

                            <ul class="dropdown-menu">
                                <?php foreach ($school_pages_grouped as $menuName => $pages): ?>
                                    <li class="dropend">
                                        <a class="dropdown-item dropdown-toggle" href="#" role="button">
                                            <?= esc($menuName) ?>
                                            <i class="bi bi-chevron-right text-muted" style="font-size: 0.8em;"></i>
                                        </a>

                                        <ul class="dropdown-menu">
                                            <?php foreach ($pages as $p): ?>
                                                <li>
                                                    <a class="dropdown-item" href="<?= site_url('mts/halaman/' . $p['slug']) ?>">
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

                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('mts/#guru') ?>">Asatidz</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('mts/kabar') ?>">Kabar</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Dokumen <i class="bi bi-chevron-down ms-1" style="font-size: 0.7em;"></i>
                        </a>
                        <ul class="dropdown-menu border-0 shadow-sm mt-2" style="border-top: 3px solid var(--mbs-purple);">
                            <li>
                                <a class="dropdown-item py-2 fw-bold text-purple" href="<?= site_url('mts/dokumen') ?>">
                                    <i class="bi bi-grid-fill"></i> Lihat Semua
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <?php if (!empty($nav_doc_categories)): ?>
                                <?php foreach ($nav_doc_categories as $cat): ?>
                                    <li>
                                        <a class="dropdown-item py-2" href="<?= site_url('mts/dokumen?kategori=' . $cat['slug']) ?>">
                                            <?= esc($cat['name']) ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li><span class="dropdown-item text-muted small">Belum ada kategori</span></li>
                            <?php endif; ?>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('mts/agenda') ?>">Agenda</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('mts/galeri') ?>">Galeri</a>
                    </li>
                </ul>

                <div class="vr mx-3 d-none d-lg-block" style="color: #ddd;"></div>
                <hr class="d-lg-none my-3 text-muted">

                <a href="<?= base_url() ?>" class="btn-back-portal py-2 py-lg-0 fw-medium" style="font-size: 0.9rem;">
                    <i class="bi bi-arrow-left-circle me-1"></i> Portal Pusat
                </a>
            </div>
        </div>
    </nav>

    <main class="flex-grow-1">
        <?= $this->renderSection('content') ?>
    </main>

    <footer class="pt-5 pb-4 border-top" style="border-top: 4px solid var(--mbs-purple) !important;">
        <div class="container">
            <div class="row g-4 justify-content-between">

                <div class="col-lg-4 col-md-6">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <?php if (!empty($school_site['site_logo'])): ?>
                            <img src="<?= base_url($school_site['site_logo']) ?>" height="50" class="object-fit-contain" alt="Logo Utama">
                        <?php elseif (!empty($school['logo'])): ?>
                            <img src="<?= base_url($school['logo']) ?>" height="50" class="object-fit-contain" alt="Logo Lama">
                        <?php else: ?>
                            <i class="bi bi-building-fill fs-1 text-purple"></i>
                        <?php endif; ?>

                        <?php if (!empty($school_site['site_logo_2'])): ?>
                            <img src="<?= base_url($school_site['site_logo_2']) ?>" height="50" class="object-fit-contain" alt="Logo 2">
                        <?php endif; ?>

                        <?php if (!empty($school_site['site_logo_3'])): ?>
                            <img src="<?= base_url($school_site['site_logo_3']) ?>" height="50" class="object-fit-contain" alt="Logo 3">
                        <?php endif; ?>
                    </div>

                    <div class="d-flex flex-column lh-1 mb-3">
                        <span class="fw-bold text-purple fs-5"><?= esc($school_site['site_name'] ?? $school['name']) ?></span>
                        <span class="small text-muted mt-1"><?= esc($school_site['site_desc'] ?? 'MBS Boarding School') ?></span>
                    </div>

                    <div class="d-flex gap-2">
                        <?php if (!empty($school_site['facebook_url'])): ?>
                            <a href="<?= esc($school_site['facebook_url']) ?>" class="social-btn" target="_blank"><i class="bi bi-facebook"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($school_site['instagram_url'])): ?>
                            <a href="<?= esc($school_site['instagram_url']) ?>" class="social-btn" target="_blank"><i class="bi bi-instagram"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($school_site['youtube_url'])): ?>
                            <a href="<?= esc($school_site['youtube_url']) ?>" class="social-btn" target="_blank"><i class="bi bi-youtube"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($school_site['tiktok_url'])): ?>
                            <a href="<?= esc($school_site['tiktok_url']) ?>" class="social-btn" target="_blank"><i class="bi bi-tiktok"></i></a>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6">
                    <h6 class="footer-title">Akses Cepat</h6>
                    <ul class="list-unstyled footer-link">
                        <li><a href="<?= site_url('mts') ?>"><i class="bi bi-chevron-right x-small me-2"></i> Beranda</a></li>
                        <li><a href="<?= site_url('mts/#guru') ?>"><i class="bi bi-chevron-right x-small me-2"></i> Asatidz</a></li>
                        <li><a href="<?= site_url('mts/kabar') ?>"><i class="bi bi-chevron-right x-small me-2"></i> Kabar Sekolah</a></li>
                        <li><a href="<?= site_url('mts/agenda') ?>"><i class="bi bi-chevron-right x-small me-2"></i> Agenda</a></li>
                        <li><a href="<?= site_url('mts/galeri') ?>"><i class="bi bi-chevron-right x-small me-2"></i> Galeri Foto</a></li>
                        <li><a href="<?= base_url() ?>" class="fw-bold text-purple"><i class="bi bi-arrow-left-circle me-2"></i> Portal Yayasan</a></li>
                        
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h6 class="footer-title">Hubungi Kami</h6>
                    <ul class="list-unstyled footer-link">
                        <li class="d-flex align-items-start">
                            <i class="bi bi-geo-alt-fill text-purple me-3 mt-1"></i>
                            <span><?= esc($school_site['address'] ?? 'Alamat belum diatur di Admin Panel.') ?></span>
                        </li>
                        <li class="d-flex align-items-center">
                            <i class="bi bi-telephone-fill text-purple me-3"></i>
                            <span><?= esc($school_site['phone'] ?? '(+62) -') ?></span>
                        </li>
                        <li class="d-flex align-items-center">
                            <i class="bi bi-envelope-fill text-purple me-3"></i>
                            <span><?= esc($school_site['email'] ?? 'info@mbs.sch.id') ?></span>
                        </li>
                        <li>
                            <a href="<?= site_url('mts/informasi') ?>">
                                <i class="bi bi-info-circle-fill text-purple me-3"></i> Informasi
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h6 class="footer-title">Lokasi</h6>
                    <div class="map-container rounded-4 overflow-hidden shadow-sm border" style="height: 180px;">
                        <?php
                        $mapUrl = $school_site['maps_embed_url'] ?? '';
                        if (empty($mapUrl)) {
                            $mapUrl = '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.088324882644!2d110.37394831477815!3d-7.780456994392587!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a59cba9256835%3A0xe035415685e27c7!2sMBS%20Yogyakarta!5e0!3m2!1sid!2sid!4v1629781234567!5m2!1sid!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>';
                        }
                        ?>
                        <?= $mapUrl ?>
                    </div>
                    <small class="text-muted mt-2 d-block fst-italic">
                        <i class="bi bi-pin-map-fill text-danger"></i>
                        <?= empty($school_site['maps_embed_url']) ? 'Lokasi Pusat (Default)' : 'Lokasi Sekolah' ?>
                    </small>
                </div>

            </div>
        </div>

        <div class="container mt-5">
            <div class="border-top pt-4 text-center">
                <p class="mb-0 text-secondary small">
                    © <?= date('Y') ?> <strong><?= esc($school_site['site_name'] ?? $school['name']) ?></strong>.
                    All Rights Reserved. <span class="mx-1">|</span>
                    Built with by <span class="text-purple fw-bold">KKP-PLUS ENREKANG TEKNIK UNISMUH MAKASSAR 2025</span>
                </p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const submenuToggles = document.querySelectorAll('.dropdown-menu .dropdown-toggle');

            submenuToggles.forEach(function(toggle) {
                toggle.addEventListener('click', function(e) {
                    if (window.innerWidth < 992) {
                        e.preventDefault();
                        e.stopPropagation();

                        const nextEl = this.nextElementSibling;
                        if (nextEl && nextEl.classList.contains('dropdown-menu')) {

                            // Logika menutup menu tetangga (opsional tapi rapi)
                            const parentMenu = this.closest('.dropdown-menu');
                            if (parentMenu) {
                                parentMenu.querySelectorAll('.dropdown-menu.show').forEach(function(openMenu) {
                                    if (openMenu !== nextEl) {
                                        openMenu.classList.remove('show');

                                        // [BARU] Reset ikon tetangga ke posisi semula
                                        const prevToggle = openMenu.previousElementSibling;
                                        if (prevToggle) prevToggle.classList.remove('show');
                                    }
                                });
                            }

                            // Buka/Tutup Menu Anak
                            nextEl.classList.toggle('show');

                            // [BARU] Tambahkan class 'show' ke TOMBOL itu sendiri
                            // Ini pemicu agar CSS .dropdown-item.show .bi-chevron-right bekerja (memutar ikon)
                            this.classList.toggle('show');
                        }
                    }
                });
            });
        });

        function toggleAnno() {
            var panel = document.getElementById("annoPanel");
            panel.classList.toggle("active");
        }
    </script>
    <?php if (!empty($global_announcements)): ?>
        <div class="floating-anno-container">

            <div class="anno-panel shadow-lg" id="annoPanel">
                <div class="anno-header">
                    <h6 class="mb-0 fw-bold text-white"><i class="bi bi-bell-fill me-2"></i>Info Terkini</h6>
                    <button type="button" class="btn-close btn-close-white btn-sm" onclick="toggleAnno()"></button>
                </div>

                <div class="anno-body">
                    <?php foreach ($global_announcements as $anno): ?>
                        <?php
                        $borderClass = ($anno['category'] == 'urgent') ? 'border-danger' : 'border-light';
                        $bgIcon = match ($anno['category']) {
                            'urgent' => 'bg-danger text-white',
                            'important' => 'bg-warning text-dark',
                            default => 'bg-purple-light text-purple'
                        };
                        ?>
                        <div class="anno-item p-3 mb-2 rounded border <?= $borderClass ?> bg-white position-relative">
                            <div class="d-flex gap-3">
                                <div class="flex-shrink-0">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center <?= $bgIcon ?>" style="width: 35px; height: 35px;">
                                        <i class="bi <?= esc($anno['icon']) ?>"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-bold small text-dark text-break"><?= esc($anno['title']) ?></h6>
                                    <p class="mb-0 text-secondary x-small lh-sm text-break"><?= esc($anno['content']) ?></p>
                                    <span class="text-muted x-small mt-1 d-block text-end fst-italic">
                                        <?= date('d M', strtotime($anno['start_date'])) ?>
                                    </span>

                                    <?php if (!empty($anno['link_url'])): ?>
                                        <a href="<?= esc($anno['link_url']) ?>" target="_blank" class="btn btn-sm btn-outline-purple w-100 mt-2" style="font-size: 0.75rem;">
                                            Buka Tautan <i class="bi bi-box-arrow-up-right ms-1"></i>
                                        </a>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <button class="anno-trigger shadow-lg ps-3 pe-4 py-2" onclick="toggleAnno()">
                <i class="bi bi-megaphone-fill fs-4"></i>

                <span class="ms-2 fw-bold text-uppercase ls-1 d-none d-sm-inline-block" style="font-size: 0.8rem; letter-spacing: 1px;">
                    Pengumuman
                </span>
                <span class="ms-2 fw-bold text-uppercase d-inline-block d-sm-none" style="font-size: 0.8rem;">
                    Info
                </span>

                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-white pulse-animation" style="margin-left: -10px; margin-top: 5px;">
                    <?= count($global_announcements) ?>
                    <span class="visually-hidden">unread messages</span>
                </span>
            </button>

        </div>
    <?php endif; ?>
</body>

</html>