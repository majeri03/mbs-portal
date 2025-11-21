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
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="<?= base_url() ?>">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Profil</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Pendidikan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Asrama</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Berita</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- 3. CONTENT SECTION (Dinamis) -->
    <!-- Bagian ini akan diisi oleh konten landing page -->
    <?= $this->renderSection('content') ?>

    <!-- 4. FOOTER -->
    <footer>
        <div class="container">
            <div class="row">
                <!-- Kolom 1: Identitas -->
                <div class="col-lg-4 mb-4">
                    <h5 class="footer-title"><?= esc($site['site_name']) ?></h5>
                    <p class="text-muted small"><?= esc($site['site_desc']) ?></p>
                    <p class="small">
                        <i class="bi bi-geo-alt-fill text-primary"></i> <?= esc($site['address']) ?>
                    </p>
                </div>

                <!-- Kolom 2: Link Cepat -->
                <div class="col-lg-2 col-6 mb-4">
                    <h5 class="footer-title">Tentang</h5>
                    <div class="footer-link">
                        <a href="#">Sejarah</a>
                        <a href="#">Visi Misi</a>
                        <a href="#">Struktur Organisasi</a>
                    </div>
                </div>

                <!-- Kolom 3: Jenjang -->
                <div class="col-lg-2 col-6 mb-4">
                    <h5 class="footer-title">Pendidikan</h5>
                    <div class="footer-link">
                        <a href="#">MTs MBS</a>
                        <a href="#">MA MBS</a>
                        <a href="#">SMK MBS</a>
                    </div>
                </div>

                <!-- Kolom 4: Maps (Embed) -->
                <div class="col-lg-4 mb-4">
                    <h5 class="footer-title">Lokasi</h5>
                    <div class="ratio ratio-16x9 bg-light rounded overflow-hidden">
                        <!-- Maps Dummy, nanti diganti data dari DB -->
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.098178349644!2d110.37356631477652!3d-7.779419994393561!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a584a6e1c23d1%3A0x4e4e8d8f8f8f8f8f!2sYogyakarta!5e0!3m2!1sen!2sid!4v1620000000000!5m2!1sen!2sid" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>

        <div class="copyright text-center">
            <div class="container">
                <small>&copy; <?= date('Y') ?> <?= esc($site['site_name']) ?>. All Rights Reserved. Built with Professional Standards.</small>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>