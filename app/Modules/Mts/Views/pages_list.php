<?= $this->extend('layout/template_sekolah') ?>

<?= $this->section('content') ?>

<div class="bg-purple text-white py-5 mb-4 text-center">
    <div class="container">
        <h1 class="fw-bold display-6">Informasi Sekolah</h1>
        <p class="lead opacity-75 mb-0">Profil, Sejarah, dan Kesiswaan <?= esc($school['name']) ?></p>
    </div>
</div>

<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="fw-bold text-secondary mb-0">
                    <?php if($active_filter): ?>
                        Filter: <span class="text-purple"><?= esc($active_filter) ?></span>
                    <?php else: ?>
                        Semua Halaman
                    <?php endif; ?>
                </h6>

                <form action="" method="get" class="d-flex gap-2">
                    <select name="kategori" class="form-select form-select-sm border-purple shadow-sm rounded-pill px-3" onchange="this.form.submit()" style="cursor: pointer;">
                        <option value="">-- Semua Kategori --</option>
                        <?php foreach($categories as $cat): ?>
                            <option value="<?= esc($cat['menu_title']) ?>" <?= ($active_filter == $cat['menu_title']) ? 'selected' : '' ?>>
                                <?= esc($cat['menu_title']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    
                    <?php if($active_filter): ?>
                        <a href="<?= site_url('mts/informasi') ?>" class="btn btn-sm btn-light rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 31px; height: 31px;">
                            <i class="bi bi-x-lg text-danger small"></i>
                        </a>
                    <?php endif; ?>
                </form>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-0">
                    <?php if(!empty($pages_list)): ?>
                        <div class="list-group list-group-flush custom-list">
                            <?php foreach($pages_list as $p): ?>
                                <a href="<?= site_url('mts/page/' . $p['slug']) ?>" class="list-group-item list-group-item-action d-flex align-items-center py-3 px-4">
                                    
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
                            <i class="bi bi-journals text-muted fs-1 mb-3 d-block"></i>
                            <p class="text-muted small">Belum ada informasi tersedia.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="<?= site_url('mts') ?>" class="btn btn-outline-purple rounded-pill px-4">
                    <i class="bi bi-arrow-left me-2"></i> Kembali ke Beranda
                </a>
            </div>

        </div>
    </div>
</div>

<style>
    /* Styling Konsisten */
    .text-purple { color: var(--mbs-purple) !important; }
    .bg-purple { background-color: var(--mbs-purple) !important; }
    .btn-outline-purple { color: var(--mbs-purple); border-color: var(--mbs-purple); }
    .btn-outline-purple:hover { background-color: var(--mbs-purple); color: white; }
    
    .border-purple { border-color: var(--mbs-purple) !important; color: var(--mbs-purple); }

    /* List Hover Effect */
    .custom-list .list-group-item {
        border-color: #f0f0f0; transition: all 0.3s ease; border-left: 4px solid transparent;
    }
    .custom-list .list-group-item:hover {
        background-color: #fbf8ff; padding-left: 1.8rem !important; border-left-color: var(--mbs-purple);
    }
    
    /* Arrow Animation */
    .arrow-anim { transition: all 0.3s; transform: translateX(-10px); }
    .custom-list .list-group-item:hover .arrow-anim { opacity: 1; transform: translateX(0); }
</style>

<?= $this->endSection() ?>