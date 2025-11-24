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
            --mbs-purple: #582C83;
            --mbs-purple-light: #7A4E9F;
            --mbs-purple-dark: #3D1F5C;
            --sidebar-width: 260px;
            --topbar-height: 65px;
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
            background: rgba(88, 44, 131, 0.1);
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

        <ul class="sidebar-menu">
            <li><a href="<?= base_url('admin/dashboard') ?>" class="<?= ($current_segment == 'dashboard') ? 'active' : '' ?>">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a></li>

            <li><a href="<?= base_url('admin/posts') ?>" class="<?= ($current_segment == 'posts') ? 'active' : '' ?>">
                    <i class="bi bi-newspaper"></i> Kelola Berita
                </a></li>
            <li><a href="<?= base_url('admin/pages') ?>" class="<?= ($current_segment == 'pages') ? 'active' : '' ?>">
                    <i class="bi bi-file-earmark-text"></i> Halaman Statis
                </a></li>
            <li>
                <a href="<?= base_url('admin/programs') ?>" class="<?= (service('uri')->getSegment(2) == 'programs') ? 'active' : '' ?>">
                    <i class="bi bi-trophy-fill"></i> Program Unggulan
                </a>
            </li>
            <li><a href="<?= base_url('admin/announcements') ?>" class="<?= str_contains(uri_string(), 'admin/announcements') ? 'active' : '' ?>">
                    <i class="bi bi-megaphone-fill"></i> Kelola Pengumuman
                </a></li>
            <li><a href="<?= base_url('admin/schools') ?>" class="<?= ($current_segment == 'schools') ? 'active' : '' ?>">
                    <i class="bi bi-building"></i> Kelola Sekolah
                </a></li>
            <li>
                <a href="<?= base_url('admin/teachers') ?>" class="<?= ($current_segment == 'teachers') ? 'active' : '' ?>">
                    <i class="bi bi-people-fill"></i>

                    <?php if (session('school_id')): ?>
                        Guru & Staff
                    <?php else: ?>
                        Pimpinan Pondok
                    <?php endif; ?>

                </a>
            </li>
            <li><a href="<?= base_url('admin/events') ?>" class="<?= ($current_segment == 'events') ? 'active' : '' ?>">
                    <i class="bi bi-calendar-event"></i> Kelola Agenda
                </a></li>

            <li><a href="<?= base_url('admin/galleries') ?>" class="<?= ($current_segment == 'galleries') ? 'active' : '' ?>">
                    <i class="bi bi-images"></i> Galeri Foto
                </a></li>

            <li><a href="<?= base_url('admin/sliders') ?>" class="<?= ($current_segment == 'sliders') ? 'active' : '' ?>">
                    <i class="bi bi-image"></i> Hero Slider
                </a></li>

            <li><a href="<?= base_url('admin/settings') ?>" class="<?= ($current_segment == 'settings') ? 'active' : '' ?>">
                    <i class="bi bi-gear-fill"></i> Pengaturan
                </a></li>
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

            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i> Profil</a></li>
                <li><a class="dropdown-item" href="#"><i class="bi bi-key me-2"></i> Ganti Password</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item text-danger" href="<?= base_url('admin/logout') ?>"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
            </ul>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">
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