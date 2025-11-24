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
            padding-top: 70px;
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

        /* --- FOOTER STYLING --- */
        footer {
            background-color: white;
            border-top: 1px solid #eaeaea;
            margin-top: auto;
            /* Footer selalu di bawah */
        }

        .footer-title {
            color: var(--mbs-purple);
            font-weight: 700;
            margin-bottom: 1.2rem;
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

    <nav class="navbar navbar-expand-lg navbar-school fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="#">
                <?php if (!empty($school['logo'])): ?>
                    <img src="<?= base_url($school['logo']) ?>" height="40" alt="Logo" class="d-inline-block align-text-top">
                <?php else: ?>
                    <i class="bi bi-building-fill fs-3"></i>
                <?php endif; ?>

                <div class="d-flex flex-column lh-1">
                    <span><?= esc($school['name'] ?? 'MBS School') ?></span>
                    <span style="font-size: 0.75rem; font-weight: 400; color: #888;">MBS Boarding School</span>
                </div>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('mts') ?>">Beranda</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Informasi
                        </a>
                        <ul class="dropdown-menu border-0 shadow-sm mt-2" style="border-top: 3px solid var(--mbs-purple);">
                            <?php if (!empty($school_pages)): ?>
                                <?php foreach ($school_pages as $sp): ?>
                                    <li>
                                        <a class="dropdown-item py-2" href="<?= site_url('mts/halaman/' . $sp['slug']) ?>">
                                            <?= esc($sp['title']) ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li><span class="dropdown-item text-muted small">Belum ada info</span></li>
                            <?php endif; ?>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#guru">Asatidz</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#kurikulum">Kurikulum</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('mts/kabar') ?>">Kabar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('mts/agenda') ?>">Agenda</a>
                    </li>
                </ul>

                <div class="vr mx-3 d-none d-lg-block" style="color: #ddd;"></div>
                <hr class="d-lg-none my-3 text-muted">
                <a href="<?= base_url() ?>" class="btn-back-portal py-2 py-lg-0">
                    <i class="bi bi-arrow-left-circle me-2 fs-5"></i> Portal Pusat
                </a>
            </div>
        </div>
    </nav>

    <main class="flex-grow-1">
        <?= $this->renderSection('content') ?>
    </main>

    <footer class="py-5">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-5 col-md-6">
                    <h5 class="footer-title"><?= esc($school['name'] ?? 'MBS School') ?></h5>
                    <p class="text-muted small mb-4 pe-lg-5">
                        <?= esc($school['description'] ?? 'Membangun generasi Qurani yang cerdas, berakhlak mulia, dan berkemajuan.') ?>
                    </p>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-secondary fs-5 hover-purple"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-secondary fs-5 hover-purple"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-secondary fs-5 hover-purple"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <h6 class="fw-bold text-dark mb-3">Hubungi Kami</h6>
                    <ul class="list-unstyled text-secondary small d-flex flex-column gap-2">
                        <li class="d-flex align-items-start">
                            <i class="bi bi-geo-alt me-2 text-purple"></i>
                            <span><?= esc($school['address'] ?? 'Alamat Pesantren') ?></span>
                        </li>
                        <li class="d-flex align-items-center">
                            <i class="bi bi-telephone me-2 text-purple"></i>
                            <span><?= esc($school['phone'] ?? '-') ?></span>
                        </li>
                        <li class="d-flex align-items-center">
                            <i class="bi bi-envelope me-2 text-purple"></i>
                            <span><?= esc($school['email'] ?? 'info@mbs.sch.id') ?></span>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-12">
                    <h6 class="fw-bold text-dark mb-3">Akses Cepat</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="<?= base_url() ?>" class="text-decoration-none text-secondary hover-purple">Portal Yayasan</a></li>
                        <li class="mb-2"><a href="#profil" class="text-decoration-none text-secondary hover-purple">Profil Sekolah</a></li>
                        <li class="mb-2"><a href="#berita" class="text-decoration-none text-secondary hover-purple">Berita Terbaru</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-top mt-5 pt-4 text-center">
                <small class="text-muted">
                    &copy; <?= date('Y') ?> <strong><?= esc($school['name'] ?? 'MBS') ?></strong>. All Rights Reserved.
                </small>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</body>

</html>