<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Admin Panel') ?> - MBS</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Google Font: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- DataTables (untuk tabel berita nanti) -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <style>
        :root {
            --mbs-purple: #2f3f58;
            --mbs-purple-light: #e8ecf1;
            --mbs-purple-dark: #1a253a;
            --sidebar-width: 260px;
            --topbar-height: 65px;
        }

        /* Paksa Ubah Warna Tombol Primary Bootstrap */
        .btn-primary {
            background-color: var(--mbs-purple) !important;
            border-color: var(--mbs-purple) !important;
        }

        .btn-primary:hover {
            background-color: var(--mbs-purple-dark) !important;
            border-color: var(--mbs-purple-dark) !important;
        }

        .bg-primary {
            background-color: var(--mbs-purple) !important;
        }

        .text-primary {
            color: var(--mbs-purple) !important;
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

        /* 1. Mengubah Warna List Group (Menu Settings) yang Aktif */
        .list-group-item.active {
            background-color: var(--mbs-purple) !important;
            border-color: var(--mbs-purple) !important;
            color: white !important;
        }

        /* 2. (Opsional) Mengubah Warna Checkbox & Radio Button saat dicentang */
        .form-check-input:checked {
            background-color: var(--mbs-purple) !important;
            border-color: var(--mbs-purple) !important;
        }

        /* 3. (Opsional) Mengubah Warna Outline Input saat diklik (Fokus) */
        .form-control:focus,
        .form-select:focus {
            border-color: var(--mbs-purple) !important;
            box-shadow: 0 0 0 0.25rem rgba(47, 63, 88, 0.25) !important;
            /* Versi transparan dari Navy */
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f6fa;
            overflow-x: hidden;
        }

        /* ========== SIDEBAR ========== */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, var(--mbs-purple) 0%, var(--mbs-purple-dark) 100%);
            color: white;
            z-index: 1000;
            transition: all 0.3s;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);

            overflow-y: auto;
            scrollbar-width: none;
        }

        .sidebar::-webkit-scrollbar {
            display: none;
        }

        .sidebar-logo {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-logo h4 {
            font-weight: 700;
            margin: 0;
            font-size: 1.3rem;
        }

        .sidebar-logo small {
            opacity: 0.8;
            font-size: 0.75rem;
        }

        .sidebar-menu {
            padding: 20px 0;
            list-style: none;
        }

        .sidebar-menu li {
            margin-bottom: 5px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 12px 25px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s;
            font-size: 0.95rem;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border-left: 4px solid #fff;
        }

        .sidebar-menu a i {
            margin-right: 15px;
            font-size: 1.2rem;
            width: 25px;
            text-align: center;
        }

        /* ========== TOPBAR ========== */
        .topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--topbar-height);
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            z-index: 999;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
        }

        .topbar-title h5 {
            margin: 0;
            font-weight: 600;
            color: var(--mbs-purple);
        }

        .topbar-title small {
            color: #888;
            font-size: 0.85rem;
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .topbar-user .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--mbs-purple);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .topbar-user .user-info {
            display: flex;
            flex-direction: column;
        }

        .topbar-user .user-name {
            font-weight: 600;
            font-size: 0.9rem;
            color: #333;
        }

        .topbar-user .user-role {
            font-size: 0.75rem;
            color: #888;
            text-transform: uppercase;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        /* ========== MAIN CONTENT ========== */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--topbar-height);
            padding: 30px;
            min-height: calc(100vh - var(--topbar-height));
        }

        /* ========== STAT CARDS ========== */
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
            border-left: 4px solid var(--mbs-purple);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .stat-card .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 15px;
        }

        .stat-card.purple .stat-icon {
            background: rgba(47, 63, 88, 0.1);
            color: var(--mbs-purple);
        }

        .stat-card.blue .stat-icon {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }

        .stat-card.green .stat-icon {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }

        .stat-card.orange .stat-icon {
            background: rgba(251, 146, 60, 0.1);
            color: #fb923c;
        }

        .stat-card h3 {
            font-size: 2rem;
            font-weight: 700;
            margin: 10px 0;
        }

        .stat-card p {
            color: #888;
            margin: 0;
            font-size: 0.9rem;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 992px) {
            .sidebar {
                left: -260px;
            }

            .sidebar.active {
                left: 0;
            }

            .topbar,
            .main-content {
                left: 0;
                margin-left: 0;
            }
        }

        /* ========== MOBILE HAMBURGER BUTTON ========== */
        .mobile-menu-toggle {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1001;
            background: var(--mbs-purple);
            color: white;
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 8px;
            font-size: 1.3rem;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: all 0.3s;
        }

        .mobile-menu-toggle:hover {
            background: var(--mbs-purple-dark);
            transform: scale(1.05);
        }

        /* Overlay Background saat sidebar terbuka di mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .sidebar-overlay.active {
            display: block;
            opacity: 1;
        }

        /* ========== RESPONSIVE: TABLET & MOBILE ========== */
        @media (max-width: 992px) {

            /* Tampilkan hamburger button */
            .mobile-menu-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            /* Sidebar hidden by default di mobile */
            .sidebar {
                left: -260px;
                transition: left 0.3s ease;
            }

            .sidebar.active {
                left: 0;
                box-shadow: 5px 0 15px rgba(0, 0, 0, 0.3);
            }

            /* Topbar & Main Content full width */
            .topbar,
            .main-content {
                left: 0 !important;
                margin-left: 0 !important;
            }

            /* Topbar padding untuk hamburger button */
            .topbar {
                padding-left: 70px;
            }

            /* Hide user info text di mobile */
            .topbar-user .user-info {
                display: none !important;
            }

            /* Card columns di mobile */
            .stat-card {
                margin-bottom: 15px;
            }
        }

        @media (max-width: 576px) {
            .topbar-title h5 {
                font-size: 1rem;
            }

            .topbar-title small {
                display: none;
            }

            .main-content {
                padding: 20px 15px;
            }
        }

        /* ========== RESPONSIVE TABLE ========== */
        .table-responsive-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-bottom: 1rem;
        }

        @media (max-width: 768px) {
            .table-responsive-wrapper {
                border-radius: 8px;
                box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.1);
            }

            /* Perkecil font table di mobile */
            .table {
                font-size: 0.85rem;
            }

            .table th,
            .table td {
                padding: 10px 8px !important;
                white-space: nowrap;
            }

            /* Hide kolom yang tidak penting di mobile */
            .table th.hide-mobile,
            .table td.hide-mobile {
                display: none;
            }

            /* Button action lebih kecil */
            .table .btn-sm {
                padding: 4px 8px;
                font-size: 0.75rem;
            }

            /* Badge lebih kecil */
            .table .badge {
                font-size: 0.7rem;
                padding: 3px 6px;
            }
        }

        /* Scroll indicator untuk tabel di mobile */
        @media (max-width: 768px) {
            .table-responsive-wrapper::after {
                content: '← Geser untuk melihat lebih banyak →';
                display: block;
                text-align: center;
                font-size: 0.75rem;
                color: #999;
                padding: 8px;
                background: linear-gradient(to right, transparent, #f5f6fa 20%, #f5f6fa 80%, transparent);
            }

            .table-responsive-wrapper::-webkit-scrollbar {
                height: 6px;
            }

            .table-responsive-wrapper::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 10px;
            }

            .table-responsive-wrapper::-webkit-scrollbar-thumb {
                background: var(--mbs-purple);
                border-radius: 10px;
            }
        }

        /* --- CSS TAMBAHAN UNTUK SIDEBAR DROPDOWN --- */
        .sidebar-submenu {
            list-style: none;
            padding-left: 0;
            background: rgba(0, 0, 0, 0.15);
            /* Warna lebih gelap untuk submenu */
            transition: all 0.3s;
        }

        .sidebar-submenu li a {
            padding-left: 55px !important;
            /* Indentasi lebih dalam */
            font-size: 0.9rem;
            border-left: none !important;
        }

        .sidebar-submenu li a:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        /* Icon Panah Berputar saat diklik */
        .sidebar-menu a[data-bs-toggle="collapse"] .arrow-icon {
            transition: transform 0.3s;
        }

        .sidebar-menu a[data-bs-toggle="collapse"][aria-expanded="true"] .arrow-icon {
            transform: rotate(180deg);
        }

        /* --- FIX DATALIST ARROW (SOLUSI FINAL) --- */

        /* 1. Pastikan panah native muncul di Chrome/Edge/Opera */
        input[list]::-webkit-calendar-picker-indicator {
            display: block !important;
            opacity: 1 !important;
            background: transparent;
            /* Transparan agar menyatu */
            bottom: 0;
            color: transparent;
            cursor: pointer;
            height: auto;
            left: auto;
            position: absolute;
            right: 12px;
            /* Posisi dari kanan */
            top: 0;
            width: 24px;
            /* Lebar area klik */
            z-index: 99;
            /* Ganti ikon bawaan browser yang jelek dengan ikon Bootstrap (Opsional) */
            /* Kalau mau pakai ikon native segitiga hitam, hapus baris background-image di bawah */
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gray" class="bi bi-chevron-down" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/></svg>');
            background-repeat: no-repeat;
            background-position: center;
            background-size: 12px;
        }

        /* 2. Firefox biasanya otomatis muncul saat double click, tapi kita beri hint hover */
        input[list]:hover {
            background-color: #e9ecef;
            /* Sedikit gelap saat dihover menandakan bisa diklik */
        }
    </style>
</head>

<body>
    <!-- Mobile Hamburger Button -->
    <button class="mobile-menu-toggle" id="mobileMenuToggle">
        <i class="bi bi-list"></i>
    </button>

    <!-- Sidebar Overlay (untuk nutup sidebar di mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <!-- SIDEBAR -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <i class="bi bi-mortarboard-fill fs-2 mb-2"></i>
            <h4>MBS ADMIN</h4>
            <small>Management System</small>
        </div>
        <?php
        // Deteksi halaman aktif berdasarkan URL segment ke-2
        $current_segment = service('uri')->getSegment(2) ?? 'dashboard';
        ?>
        <?php $userRole = session('role'); ?>

        <ul class="sidebar-menu">
            <li>
                <a href="<?= base_url('admin/dashboard') ?>" class="<?= (service('uri')->getSegment(2) == 'dashboard') ? 'active' : '' ?>">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            <!-- ✅ MENU BARU: LIHAT WEBSITE -->
            <?php
            $schoolId = session('school_id');
            $schoolSlug = '';

            // Tentukan slug berdasarkan school_id
            if ($schoolId == 1) {
                $schoolSlug = 'mts';
            } elseif ($schoolId == 2) {
                $schoolSlug = 'ma';
            } elseif ($schoolId == 3) {
                $schoolSlug = 'smk';
            }

            // Jika superadmin (school_id = null), tampilkan dropdown
            if (empty($schoolId)) {
            ?>
                <li>
                    <a href="#submenuWebsite" data-bs-toggle="collapse" aria-expanded="false"
                        class="d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-globe2"></i> Lihat Website</span>
                        <i class="bi bi-chevron-down arrow-icon" style="font-size: 0.8rem;"></i>
                    </a>
                    <ul class="collapse sidebar-submenu" id="submenuWebsite" data-bs-parent="#sidebar">
                        <li><a href="<?= base_url('/') ?>" target="_blank"><i class="bi bi-house-door me-2"></i>Portal Pusat</a></li>
                        <li><a href="<?= base_url('mts') ?>" target="_blank"><i class="bi bi-mortarboard me-2"></i>Website MTs</a></li>
                        <li><a href="<?= base_url('ma') ?>" target="_blank"><i class="bi bi-book me-2"></i>Website MA</a></li>
                        <li><a href="<?= base_url('smk') ?>" target="_blank"><i class="bi bi-gear me-2"></i>Website SMK</a></li>
                    </ul>
                </li>
            <?php
            } else {
                // Admin sekolah, langsung ke website sekolahnya
            ?>
                <li>
                    <a href="<?= base_url($schoolSlug) ?>" target="_blank" class="text-success">
                        <i class="bi bi-box-arrow-up-right"></i> Lihat Website
                    </a>
                </li>
            <?php
            }
            ?>
            <?php $isDocActive = str_contains(uri_string(), 'document'); ?>
            <li>
                <a href="#submenuDokumen" data-bs-toggle="collapse" aria-expanded="<?= $isDocActive ? 'true' : 'false' ?>"
                    class="d-flex justify-content-between align-items-center <?= $isDocActive ? 'active' : '' ?>">
                    <span><i class="bi bi-folder-fill"></i> E-Dokumen</span>
                    <i class="bi bi-chevron-down arrow-icon" style="font-size: 0.8rem;"></i>
                </a>

                <ul class="collapse sidebar-submenu <?= $isDocActive ? 'show' : '' ?>" id="submenuDokumen" data-bs-parent="#sidebar">
                    <li>
                        <a href="<?= base_url('admin/documents') ?>" class="<?= (uri_string() == 'admin/documents') ? 'text-warning' : '' ?>">
                            Data Dokumen
                        </a>
                    </li>

                    <?php if ($userRole !== 'guru') : ?>
                        <li>
                            <a href="<?= base_url('admin/document-categories') ?>" class="<?= str_contains(uri_string(), 'categories') ? 'text-warning' : '' ?>">
                                Kategori Dokumen
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </li>

            <?php
            $uri = uri_string();
            $isContentActive = (str_contains($uri, 'posts') || str_contains($uri, 'pages') || str_contains($uri, 'sliders') || str_contains($uri, 'galleries') || str_contains($uri, 'announcements'));
            ?>
            <li>
                <a href="#submenuKonten" data-bs-toggle="collapse" aria-expanded="<?= $isContentActive ? 'true' : 'false' ?>"
                    class="d-flex justify-content-between align-items-center <?= $isContentActive ? 'active' : '' ?>">
                    <span><i class="bi bi-globe"></i> Konten Web</span>
                    <i class="bi bi-chevron-down arrow-icon" style="font-size: 0.8rem;"></i>
                </a>

                <ul class="collapse sidebar-submenu <?= $isContentActive ? 'show' : '' ?>" id="submenuKonten" data-bs-parent="#sidebar">
                    <li><a href="<?= base_url('admin/posts') ?>">Berita / Artikel</a></li>

                    <li><a href="<?= base_url('admin/galleries') ?>">Galeri Foto</a></li>

                    <?php if ($userRole !== 'guru') : ?>
                        <li><a href="<?= base_url('admin/pages') ?>">Halaman Statis</a></li>
                        <li><a href="<?= base_url('admin/announcements') ?>">Pengumuman</a></li>
                        <li><a href="<?= base_url('admin/sliders') ?>">Hero Slider</a></li>
                    <?php endif; ?>
                </ul>
            </li>

            <?php if ($userRole !== 'guru') : ?>
                <?php
                $isMasterActive = (str_contains($uri, 'schools') || str_contains($uri, 'teachers') || str_contains($uri, 'programs'));
                ?>
                <li>
                    <a href="#submenuMaster" data-bs-toggle="collapse" aria-expanded="<?= $isMasterActive ? 'true' : 'false' ?>"
                        class="d-flex justify-content-between align-items-center <?= $isMasterActive ? 'active' : '' ?>">
                        <span><i class="bi bi-database-fill"></i> Data Master</span>
                        <i class="bi bi-chevron-down arrow-icon" style="font-size: 0.8rem;"></i>
                    </a>

                    <ul class="collapse sidebar-submenu <?= $isMasterActive ? 'show' : '' ?>" id="submenuMaster" data-bs-parent="#sidebar">
                        <li><a href="<?= base_url('admin/schools') ?>">Jenjang Sekolah</a></li>
                        <li><a href="<?= base_url('admin/programs') ?>">Program Unggulan</a></li>
                        <li><a href="<?= base_url('admin/teachers') ?>">Pimpinan & Guru</a></li>
                    </ul>
                </li>
            <?php endif; ?>

            <!-- Agenda Kegiatan -->
            <?php
            $isEventsActive = str_contains($uri, 'events');
            ?>
            <li>
                <?php if ($userRole === 'guru'): ?>
                    <!-- Guru: Langsung ke Agenda Internal (Read Only) -->
                    <a href="<?= base_url('admin/events/internal') ?>" class="<?= $isEventsActive ? 'active' : '' ?>">
                        <i class="bi bi-lock-fill text-danger"></i> Agenda Internal
                    </a>
                <?php else: ?>
                    <!-- Admin & Superadmin: Ada submenu -->
                    <a href="#submenuEvents" data-bs-toggle="collapse" aria-expanded="<?= $isEventsActive ? 'true' : 'false' ?>"
                        class="d-flex justify-content-between align-items-center <?= $isEventsActive ? 'active' : '' ?>">
                        <span><i class="bi bi-calendar-event"></i> Agenda Kegiatan</span>
                        <i class="bi bi-chevron-down arrow-icon" style="font-size: 0.8rem;"></i>
                    </a>

                    <ul class="collapse sidebar-submenu <?= $isEventsActive ? 'show' : '' ?>" id="submenuEvents" data-bs-parent="#sidebar">
                        <li><a href="<?= base_url('admin/events') ?>">Kelola Agenda</a></li>
                        <li><a href="<?= base_url('admin/events/internal') ?>">
                                <i class="bi bi-lock-fill text-danger me-2"></i>Agenda Internal
                            </a></li>
                    </ul>
                <?php endif; ?>
            </li>

            <?php if ($userRole !== 'guru') : ?>
                <li>
                    <a href="<?= base_url('admin/users') ?>" class="<?= str_contains($uri, 'users') ? 'active' : '' ?>">
                        <i class="bi bi-people-fill"></i> Manajemen User
                    </a>
                </li>
            <?php endif; ?>

            <?php if ($userRole !== 'guru') : ?>
                <li>
                    <a href="<?= base_url('admin/settings') ?>" class="<?= str_contains($uri, 'settings') ? 'active' : '' ?>">
                        <i class="bi bi-gear-fill"></i> Pengaturan
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>

    <!-- TOPBAR -->
    <div class="topbar">
        <div class="topbar-title">
            <h5><?= esc($title ?? 'Dashboard') ?></h5>
            <small><i class="bi bi-calendar3"></i> <?= date('l, d F Y') ?></small>
        </div>

        <div class="topbar-user dropdown">
            <a href="#" class="d-flex align-items-center gap-2 text-decoration-none" data-bs-toggle="dropdown">
                <div class="user-avatar">
                    <?= strtoupper(substr(session()->get('full_name'), 0, 1)) ?>
                </div>
                <div class="user-info d-none d-md-block">
                    <div class="user-name"><?= esc(session()->get('full_name')) ?></div>
                    <div class="user-role"><?= esc(session()->get('role')) ?></div>
                </div>
                <i class="bi bi-chevron-down"></i>
            </a>

            <ul class="dropdown-menu dropdown-menu-end border-0 shadow animate slideIn">
                <li>
                    <h6 class="dropdown-header">Halo, <?= esc(substr(session('full_name'), 0, 15)) ?>...</h6>
                </li>

                <li>
                    <a class="dropdown-item py-2" href="<?= base_url('admin/profile') ?>">
                        <i class="bi bi-person-circle me-2 text-primary"></i> Edit Profil
                    </a>
                </li>

                <li>
                    <a class="dropdown-item py-2" href="<?= base_url('admin/change-password') ?>">
                        <i class="bi bi-shield-lock me-2 text-warning"></i> Ganti Password
                    </a>
                </li>

                <li>
                    <hr class="dropdown-divider">
                </li>

                <li>
                    <a class="dropdown-item py-2 text-danger fw-bold" href="<?= base_url('admin/logout') ?>">
                        <i class="bi bi-box-arrow-right me-2"></i> Keluar
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill fs-4 me-3"></i>
                    <div>
                        <strong>Berhasil!</strong> <?= session()->getFlashdata('success') ?>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
                    <div>
                        <strong>Gagal!</strong> <?= session()->getFlashdata('error') ?>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?= $this->renderSection('content') ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery (untuk DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <!-- DataTables (untuk tabel berita nanti) -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <!-- DataTables Responsive Extension -->
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
    <?= $this->renderSection('scripts') ?>

    <script>
        // ========== MOBILE SIDEBAR TOGGLE ==========
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const mobileMenuToggle = document.getElementById('mobileMenuToggle');

            // Cek apakah elemen ada (untuk prevent error)
            if (!mobileMenuToggle || !sidebar || !sidebarOverlay) {
                console.error('Mobile menu elements not found!');
                return;
            }

            // Toggle sidebar saat klik hamburger
            mobileMenuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('active');
                sidebarOverlay.classList.toggle('active');

                // Ganti icon hamburger jadi X saat terbuka
                const icon = this.querySelector('i');
                if (sidebar.classList.contains('active')) {
                    icon.classList.replace('bi-list', 'bi-x');
                } else {
                    icon.classList.replace('bi-x', 'bi-list');
                }
            });

            // Tutup sidebar saat klik overlay
            sidebarOverlay.addEventListener('click', function() {
                sidebar.classList.remove('active');
                sidebarOverlay.classList.remove('active');
                const icon = mobileMenuToggle.querySelector('i');
                if (icon.classList.contains('bi-x')) {
                    icon.classList.replace('bi-x', 'bi-list');
                }
            });

            // Tutup sidebar saat klik menu link di mobile
            if (window.innerWidth <= 992) {
                document.querySelectorAll('.sidebar-menu a').forEach(link => {
                    link.addEventListener('click', function() {
                        sidebar.classList.remove('active');
                        sidebarOverlay.classList.remove('active');
                        const icon = mobileMenuToggle.querySelector('i');
                        if (icon.classList.contains('bi-x')) {
                            icon.classList.replace('bi-x', 'bi-list');
                        }
                    });
                });
            }
        });
    </script>
</body>

</html>