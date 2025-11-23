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
                <a href="<?= esc($site['youtube_url']) ?>" class="text-white"><i class="bi bi-youtube"></i></a>
                <?php if (!empty($site['tiktok_url'])): ?>
                    <a href="<?= esc($site['tiktok_url']) ?>" class="text-white"><i class="bi bi-tiktok"></i></a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- 2. NAVBAR UTAMA (Sticky) -->
    <nav class="navbar navbar-expand-lg navbar-mbs sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?= base_url() ?>" style="color: var(--mbs-purple);">
                <!-- Ganti src dengan logo asli nanti -->
                <i class="bi bi-building-fill"></i> <?= esc($site['site_name']) ?>
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
                    // Ambil data halaman aktif untuk menu
                    $pageModel = new \App\Models\PageModel();
                    $menuPages = $pageModel->getActivePages();
                    ?>

                    <?php if (!empty($menuPages)) : ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link fw-medium dropdown-toggle <?= strpos(uri_string(), 'page') !== false ? 'active-custom' : '' ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Tentang Kami
                            </a>
                            <ul class="dropdown-menu shadow-lg border-0 animate slideIn mt-2 p-2" style="border-radius: 12px;">
                                <?php foreach ($menuPages as $mp): ?>
                                    <li>
                                        <a class="dropdown-item rounded py-2 px-3 fw-medium" href="<?= base_url('page/' . $mp['slug']) ?>">
                                            <?= esc($mp['title']) ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="<?= base_url('/#jenjang-sekolah') ?>">Pendidikan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium <?= strpos(uri_string(), 'news') !== false ? 'active-custom' : '' ?>" href="<?= base_url('news') ?>">Berita</a>
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
                    <h5 class="fw-bold mb-3" style="color: var(--mbs-purple);">
                        <i class="bi bi-building-fill me-2"></i><?= esc($site['site_name'] ?? 'MBS Boarding School') ?>
                    </h5>
                    <p class="text-secondary small mb-4">
                        <?= esc($site['site_desc'] ?? 'Membangun Generasi Qurani Berkemajuan dengan pendidikan terintegrasi.') ?>
                    </p>

                    <div class="small d-flex flex-column gap-2 mb-4 text-secondary">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-geo-alt-fill me-2 mt-1" style="color: var(--mbs-purple);"></i>
                            <span><?= esc($site['address'] ?? 'Alamat belum diatur') ?></span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-telephone-fill me-2" style="color: var(--mbs-purple);"></i>
                            <span><?= esc($site['phone'] ?? '-') ?></span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-envelope-fill me-2" style="color: var(--mbs-purple);"></i>
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
                <span class="d-none d-md-inline">| Built with by KKP-PLUS TEKNIK UNISMUH MAKASSAR</span>
            </div>
        </div>
    </footer>

    <style>
        /* --- 0. KONFIGURASI WARNA (Agar konsisten) --- */
        :root {
            /* Gunakan variabel ungu yang sama dengan tema kamu */
            --mbs-purple: #6610f2;
            /* Default bootstrap purple, akan ikut settingan globalmu jika ada */
            --mbs-purple-light: #f3f0ff;
            /* Warna ungu sangat muda untuk hover */
        }

        /* --- 1. PERBAIKAN UTAMA: HAPUS PANAH/GARIS PENGGANGGU --- */
        /* Ini yang membuat garis/kotak aneh di sebelah 'Tentang Kami' hilang total */
        .dropdown-toggle::after {
            display: none !important;
            content: none !important;
        }

        /* --- 2. NAVBAR MENU UTAMA (FORMAL & MODERN) --- */
        .navbar-nav .nav-link {
            font-weight: 500;
            /* Ketebalan font sedang (formal) */
            color: #555;
            /* Warna abu tua (tidak hitam pekat agar elegan) */
            padding: 10px 15px !important;
            /* Spasi antar menu */
            position: relative;
            /* Wajib ada untuk garis bawah */
            transition: color 0.3s ease;
        }

        /* Membuat Garis Bawah (Underline) Animasi */
        .navbar-nav .nav-link::before {
            content: '';
            position: absolute;
            width: 0;
            /* Awalnya lebar 0 (tidak terlihat) */
            height: 2px;
            /* Ketebalan garis */
            bottom: 5px;
            /* Jarak dari bawah teks */
            left: 0;
            background-color: var(--mbs-purple);
            transition: width 0.3s ease-in-out;
            /* Animasi memanjang */
        }

        /* Efek saat Hover, Aktif, atau Dropdown Terbuka */
        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active-custom,
        .navbar-nav .show>.nav-link {
            color: var(--mbs-purple) !important;
        }

        /* Munculkan garis memanjang saat hover/aktif */
        .navbar-nav .nav-link:hover::before,
        .navbar-nav .nav-link.active-custom::before,
        .navbar-nav .show>.nav-link::before {
            width: 100%;
            /* Garis memanjang penuh */
        }

        /* --- 3. DROPDOWN MENU (CLEAN STYLE) --- */
        .dropdown-menu {
            border: none;
            border-top: 3px solid var(--mbs-purple);
            /* Aksen ungu di atas kotak */
            border-radius: 0 0 8px 8px;
            /* Lengkungan hanya di bawah */
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            /* Bayangan sangat halus */
            margin-top: 0;
            padding: 10px 0;
            background-color: #fff;
        }

        .dropdown-item {
            font-size: 0.95rem;
            color: #444;
            padding: 10px 25px;
            /* Spasi dalam lega */
            font-weight: 400;
            transition: all 0.2s ease;
        }

        /* Efek Hover pada Item Dropdown */
        .dropdown-item:hover {
            background-color: var(--mbs-purple-light);
            /* Background ungu muda */
            color: var(--mbs-purple);
            padding-left: 30px;
            /* Efek geser kanan sedikit (modern) */
        }

        /* Animasi Muncul Dropdown (Fade In Halus) */
        .dropdown-menu.show {
            animation: fadeUp 0.3s ease forwards;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* --- 4. STYLE TOMBOL & FOOTER (BAWAAN SEBELUMNYA) --- */
        .btn-outline-purple {
            color: var(--mbs-purple);
            border-color: var(--mbs-purple);
        }

        .btn-outline-purple:hover {
            background-color: var(--mbs-purple);
            color: white;
        }

        .hover-purple:hover {
            color: var(--mbs-purple) !important;
            padding-left: 5px;
            transition: all 0.3s ease;
            font-weight: 500;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>