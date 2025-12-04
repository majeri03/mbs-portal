<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="py-5 bg-light border-bottom">
    <div class="container text-center">
        <h1 class="fw-bold text-purple display-6">Tentang & Informasi</h1>
        <p class="text-muted mb-0">Profil Lengkap, Sejarah, dan Informasi Yayasan MBS</p>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold text-secondary mb-0">
                    <?php if($active_filter): ?>
                        Menampilkan: <span class="text-purple"><?= esc($active_filter) ?></span>
                    <?php else: ?>
                        Semua Informasi
                    <?php endif; ?>
                </h5>

                <form action="" method="get" class="d-flex gap-2">
                    <select name="kategori" class="form-select border-purple shadow-sm rounded-pill px-4" onchange="this.form.submit()" style="cursor: pointer;">
                        <option value="">-- Semua Kategori --</option>
                        <?php foreach($categories as $cat): ?>
                            <option value="<?= esc($cat['menu_title']) ?>" <?= ($active_filter == $cat['menu_title']) ? 'selected' : '' ?>>
                                <?= esc($cat['menu_title']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    
                    <?php if($active_filter): ?>
                        <a href="<?= base_url('tentang') ?>" class="btn btn-light rounded-circle shadow-sm" title="Reset Filter" style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-x-lg text-danger"></i>
                        </a>
                    <?php endif; ?>
                </form>
            </div>

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-purple text-white p-3">
                    <i class="bi bi-list-ul me-2"></i> Direktori Halaman
                </div>
                
                <div class="card-body p-0">
                    <?php if(!empty($all_pages)): ?>
                        <div class="list-group list-group-flush custom-list">
                            <?php foreach($all_pages as $p): ?>
                                <a href="<?= base_url('page/' . $p['slug']) ?>" class="list-group-item list-group-item-action d-flex align-items-center py-3 px-4">
                                    <div class="flex-grow-1">
                                        <span class="badge bg-light text-secondary border mb-1" style="font-size: 0.65rem;">
                                            <?= esc($p['menu_title']) ?>
                                        </span>
                                        <h6 class="fw-bold mb-0 text-dark"><?= esc($p['title']) ?></h6>
                                    </div>

                                    <i class="bi bi-arrow-right text-purple opacity-0 arrow-anim"></i>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center p-5">
                            <i class="bi bi-search text-muted fs-1 mb-3 d-block"></i>
                            <h6 class="text-muted fw-bold">Tidak ditemukan</h6>
                            <p class="text-muted small">Belum ada halaman untuk kategori ini.</p>
                            <a href="<?= base_url('tentang') ?>" class="btn btn-sm btn-outline-purple mt-2">Lihat Semua</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="<?= base_url() ?>" class="btn btn-outline-purple rounded-pill px-4">
                    <i class="bi bi-arrow-left me-2"></i> Kembali ke Beranda
                </a>
            </div>

        </div>
    </div>
</div>
<style>
    /* KONSEP JADUL MODERN (RETRO MODERN) */
    .bg-purple { background-color: var(--mbs-purple); }
    .text-purple { color: var(--mbs-purple); }
    .btn-outline-purple { color: var(--mbs-purple); border-color: var(--mbs-purple); }
    .btn-outline-purple:hover { background-color: var(--mbs-purple); color: white; }

    /* List Styling */
    .custom-list .list-group-item {
        border-color: #f0f0f0; /* Garis tipis halus */
        transition: all 0.3s ease;
        border-left: 4px solid transparent; /* Border kiri tersembunyi */
    }

    /* Hover Effect */
    .custom-list .list-group-item:hover {
        background-color: #fbf8ff; /* Ungu sangat muda */
        padding-left: 2rem !important; /* Geser konten ke kanan sedikit */
        border-left-color: var(--mbs-purple); /* Munculkan border ungu di kiri */
    }

    /* Bullet Icon Circle */
    .icon-bullet {
        width: 35px; height: 35px;
        background-color: #e8ecf1; /* Ungu pudar */
        color: var(--mbs-purple);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.8rem;
        transition: all 0.3s;
    }

    .custom-list .list-group-item:hover .icon-bullet {
        background-color: var(--mbs-purple);
        color: white;
    }

    /* Arrow Animation */
    .arrow-anim { transition: all 0.3s; transform: translateX(-10px); }
    .custom-list .list-group-item:hover .arrow-anim {
        opacity: 1;
        transform: translateX(0);
    }
    /* Style Dropdown Filter */
    .border-purple {
        border: 1px solid var(--mbs-purple);
        color: var(--mbs-purple);
        font-weight: 500;
    }
    .border-purple:focus {
        box-shadow: 0 0 0 0.25rem rgba(47, 63, 88, 0.25); /* Glow Ungu saat diklik */
        border-color: var(--mbs-purple);
    }
</style>

<?= $this->endSection() ?>