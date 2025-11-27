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
            /* Kompensasi untuk navbar fixed */
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

        /* Garis kecil di bawah judul footer */
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
            /* Efek geser kanan saat hover */
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
            /* Bisa diubah 100% jika mau peta hitam putih */
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

        /* Mobile Responsive Tweaks */
        @media (max-width: 991px) {
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
                    // 1. Cek Logo di Settings (Uploadan Baru)
                    if (!empty($school_site['site_logo'])) {
                        $logoSrc = base_url($school_site['site_logo']);
                        echo '<img src="' . $logoSrc . '" height="50" alt="Logo Sekolah" class="object-fit-contain">';
                    } 
                    // 2. Fallback: Cek Logo di Tabel Schools (Data Lama)
                    elseif (!empty($school['logo'])) {
                        echo '<img src="' . base_url($school['logo']) . '" height="50" alt="Logo">';
                    }
                    // 3. Fallback Terakhir: Icon Default
                    else {
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
                        <?php foreach ($school_pages_grouped as $menuName => $pages): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <?= esc($menuName) ?>
                                </a>
                                <ul class="dropdown-menu border-0 shadow-sm mt-2" style="border-top: 3px solid var(--mbs-purple);">
                                    <?php foreach ($pages as $p): ?>
                                        <li>
                                            <a class="dropdown-item py-2" href="<?= site_url('mts/halaman/' . $p['slug']) ?>">
                                                <?= esc($p['title']) ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('mts/#guru') ?>">Asatidz</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('mts/kabar') ?>">Kabar</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Dokumen
                        </a>
                        <ul class="dropdown-menu border-0 shadow-sm mt-2" style="border-top: 3px solid var(--mbs-purple);">
                            <li>
                                <a class="dropdown-item py-2 fw-bold text-purple" href="<?= site_url('mts/dokumen') ?>">
                                    <i class="bi bi-grid-fill me-2"></i>Lihat Semua
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            
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
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h6 class="footer-title">Lokasi</h6>
                    <div class="map-container rounded-4 overflow-hidden shadow-sm border" style="height: 180px;">
                        <?php
                        // LOGIKA PETA:
                        // 1. Cek apakah Admin Sekolah sudah isi peta?
                        // 2. Jika BELUM, gunakan Peta MBS Pusat (Default)

                        $mapUrl = $school_site['maps_embed_url'] ?? '';

                        if (empty($mapUrl)) {
                            // PETA DEFAULT (MBS PUSAT / CONTOH) - Silakan ganti src ini dengan Embed Map MBS yang asli
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
                    &copy; <?= date('Y') ?> <strong><?= esc($school_site['site_name'] ?? $school['name']) ?></strong>.
                    All Rights Reserved. <span class="mx-1">|</span>
                    Built with by  <span class="text-purple fw-bold">KKP-PLUS ENREKANG TEKNIK UNISMUH MAKASSAR 2025</span>
                </p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</body>

</html>