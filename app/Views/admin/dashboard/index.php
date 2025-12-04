<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<style>
    /* Custom Style untuk Dashboard */
    .welcome-banner {
        background: linear-gradient(135deg, var(--mbs-purple) 0%, #1a253a 100%);
        border-radius: 15px;
        position: relative;
        overflow: hidden;
    }
    .welcome-banner::before {
        content: ''; position: absolute; top: -50%; left: -10%; width: 300px; height: 300px;
        background: rgba(255,255,255,0.1); border-radius: 50%;
    }
    .welcome-banner::after {
        content: ''; position: absolute; bottom: -50%; right: -10%; width: 200px; height: 200px;
        background: rgba(255,255,255,0.05); border-radius: 50%;
    }
    
    .stat-card-modern {
        background: white; border: none; border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden; height: 100%;
    }
    .stat-card-modern:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    }
    .icon-box {
        width: 50px; height: 50px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem; margin-bottom: 15px;
    }
    
    /* Warna Background Icon Soft */
    .bg-soft-primary { background-color: rgba(13, 110, 253, 0.1); color: #0d6efd; }
    .bg-soft-success { background-color: rgba(25, 135, 84, 0.1); color: #198754; }
    .bg-soft-warning { background-color: rgba(255, 193, 7, 0.1); color: #ffc107; }
    .bg-soft-info    { background-color: rgba(13, 202, 240, 0.1); color: #0dcaf0; }

    .shortcut-btn {
        background: white; border: 1px solid #eee; border-radius: 12px;
        padding: 15px; text-align: center; color: #555;
        transition: all 0.2s; text-decoration: none; display: block;
    }
    .shortcut-btn:hover {
        background: #f8f9fa; border-color: var(--mbs-purple); color: var(--mbs-purple);
    }
    .shortcut-btn i { font-size: 1.5rem; display: block; margin-bottom: 5px; color: var(--mbs-purple); }
</style>

<div class="welcome-banner p-4 p-md-5 mb-4 text-white shadow-sm">
    <div class="position-relative z-1">
        <h2 class="fw-bold mb-1">
            <?php 
                $hour = date('H');
                $salam = ($hour < 11) ? "Selamat Pagi" : (($hour < 15) ? "Selamat Siang" : (($hour < 18) ? "Selamat Sore" : "Selamat Malam"));
            ?>
            <?= $salam ?>, <?= esc($user['full_name']) ?>!
        </h2>
        <p class="mb-0 opacity-75">
            Anda login sebagai <strong><?= strtoupper($user['role']) ?></strong> di panel <strong><?= esc($user['school_name']) ?></strong>.
        </p>
    </div>
</div>

<div class="row g-4 mb-5">
    <?php foreach ($stats as $key => $stat): ?>
        <div class="col-6 col-md-3">
            <div class="stat-card-modern p-4 d-flex flex-column justify-content-between">
                <div>
                    <div class="icon-box bg-soft-<?= $stat['color'] ?>">
                        <i class="bi <?= $stat['icon'] ?>"></i>
                    </div>
                    <h6 class="text-muted text-uppercase small fw-bold ls-1 mb-1"><?= $stat['label'] ?></h6>
                    <h2 class="fw-bold mb-0 text-dark"><?= number_format($stat['value']) ?></h2>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="row">
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white py-3 border-0">
                <h6 class="mb-0 fw-bold"><i class="bi bi-lightning-charge-fill text-warning me-2"></i>Akses Cepat</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <?php if ($user['role'] !== 'guru'): ?>
                        <div class="col-6">
                            <a href="<?= base_url('admin/users/create') ?>" class="shortcut-btn">
                                <i class="bi bi-person-plus"></i> <span class="small fw-bold">Add User</span>
                            </a>
                        </div>
                    <?php endif; ?>
                    
                    <div class="col-6">
                        <a href="<?= base_url('admin/posts/create') ?>" class="shortcut-btn">
                            <i class="bi bi-pencil-square"></i> <span class="small fw-bold">Tulis Berita</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="<?= base_url('admin/events/create') ?>" class="shortcut-btn">
                            <i class="bi bi-calendar-plus"></i> <span class="small fw-bold">Buat Agenda</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="<?= base_url('admin/documents/create') ?>" class="shortcut-btn">
                            <i class="bi bi-cloud-upload"></i> <span class="small fw-bold">Upload File</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white py-3 border-bottom-0 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold"><i class="bi bi-clock-history me-2 text-primary"></i>Berita Terbaru</h6>
                <a href="<?= base_url('admin/posts') ?>" class="btn btn-sm btn-light rounded-pill px-3">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Judul</th>
                                <th>Kategori</th>
                                <th>Tanggal</th>
                                <th class="text-end pe-4">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($latest_posts)): ?>
                                <?php foreach ($latest_posts as $post) : ?>
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark text-truncate" style="max-width: 200px;">
                                            <?= esc($post['title']) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if(empty($post['school_id'])): ?>
                                            <span class="badge bg-secondary text-white" style="font-size: 0.7rem;">UMUM</span>
                                        <?php else: ?>
                                            <span class="badge bg-purple text-white" style="font-size: 0.7rem; background-color: var(--mbs-purple);">SEKOLAH</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-muted small">
                                        <?= date('d M Y', strtotime($post['created_at'])) ?>
                                    </td>
                                    <td class="text-end pe-4">
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill">
                                            Published
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Belum ada berita.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>