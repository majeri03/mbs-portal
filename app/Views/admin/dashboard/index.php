<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<!-- Welcome Banner -->
<div class="alert alert-primary border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, <?= 'var(--mbs-purple)' ?>, <?= 'var(--mbs-purple-light)' ?>); color: white;">
    <div class="d-flex align-items-center">
        <i class="bi bi-emoji-smile fs-1 me-3"></i>
        <div>
            <h5 class="mb-1">Selamat Datang Kembali, <?= esc($user['full_name']) ?>! 👋</h5>
            <small class="opacity-75">Kelola konten website MBS Boarding School dengan mudah dari sini.</small>
        </div>
    </div>
</div>

<!-- Statistic Cards -->
<div class="row g-4 mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="stat-card purple">
            <div class="stat-icon">
                <i class="bi bi-newspaper"></i>
            </div>
            <h3><?= $stats['total_posts'] ?></h3>
            <p>Total Berita</p>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="stat-card blue">
            <div class="stat-icon">
                <i class="bi bi-building"></i>
            </div>
            <h3><?= $stats['total_schools'] ?></h3>
            <p>Jenjang Sekolah</p>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="stat-card green">
            <div class="stat-icon">
                <i class="bi bi-calendar-event"></i>
            </div>
            <h3><?= $stats['total_events'] ?></h3>
            <p>Agenda Mendatang</p>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="stat-card orange">
            <div class="stat-icon">
                <i class="bi bi-people-fill"></i>
            </div>
            <h3><?= $stats['total_users'] ?></h3>
            <p>Admin Aktif</p>
        </div>
    </div>
</div>

<!-- Recent Posts Table -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Berita Terbaru</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive table-responsive-wrapper">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Sekolah</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($latest_posts as $post) : ?>
                <tr>
                    <td><?= esc($post['title']) ?></td>
                    <td><span class="badge bg-secondary"><?= esc($post['school_name'] ?? 'Umum') ?></span></td>
                    <td><?= date('d M Y', strtotime($post['created_at'])) ?></td>
                    <td><span class="badge bg-success">Published</span></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>