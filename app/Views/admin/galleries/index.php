<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4><i class="bi bi-images me-2 text-purple"></i>Kelola Galeri Foto</h4>
    <a href="<?= base_url('admin/galleries/create') ?>" class="btn btn-primary"><i class="bi bi-upload me-2"></i>Upload Foto</a>
</div>

<!-- Filter Card -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form action="<?= base_url('admin/galleries') ?>" method="GET" id="filterForm">
            <div class="row g-3">
                <!-- Search by Title -->
                <div class="col-md-4">
                    <label class="form-label fw-bold">
                        <i class="bi bi-search"></i> Cari Judul Foto
                    </label>
                    <input type="text" 
                           name="search" 
                           class="form-control" 
                           placeholder="Ketik judul foto..."
                           value="<?= esc($currentSearch ?? '') ?>">
                </div>

                <!-- Filter by Category -->
                <div class="col-md-3">
                    <label class="form-label fw-bold">
                        <i class="bi bi-tag"></i> Kategori
                    </label>
                    <select name="category" class="form-select">
                        <option value="">Semua Kategori</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= esc($cat) ?>" <?= ($currentCategory ?? '') == $cat ? 'selected' : '' ?>>
                                <?= esc($cat) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Filter by School (hanya untuk superadmin) -->
                <?php if (session()->get('role') == 'superadmin'): ?>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">
                            <i class="bi bi-building"></i> Sekolah
                        </label>
                        <select name="school_id" class="form-select">
                            <option value="">Semua Sekolah</option>
                            <?php foreach ($schools as $school): ?>
                                <option value="<?= $school['id'] ?>" <?= ($currentSchoolFilter ?? '') == $school['id'] ? 'selected' : '' ?>>
                                    <?= esc($school['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endif; ?>

                <!-- Action Buttons -->
                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary flex-fill">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                    <a href="<?= base_url('admin/galleries') ?>" class="btn btn-outline-secondary" title="Reset Filter">
                        <i class="bi bi-arrow-clockwise"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show"><?= session()->getFlashdata('success') ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
<?php endif; ?>

<div class="row g-3">
    <?php foreach ($galleries as $item) : ?>
    <div class="col-md-4 col-lg-3">
        <div class="card h-100 shadow-sm border-0">
            <div style="height: 180px; overflow: hidden;">
                <img src="<?= base_url($item['image_url']) ?>" class="w-100 h-100 object-fit-cover" alt="Foto">
            </div>
            <div class="card-body p-3">
                <h6 class="fw-bold mb-1 text-truncate"><?= esc($item['title']) ?></h6>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="badge bg-secondary text-uppercase" style="font-size: 0.7rem;"><?= esc($item['category']) ?></span>
                    <?php if($item['school_name']): ?>
                        <span class="badge bg-info text-dark" style="font-size: 0.7rem;"><?= esc($item['school_name']) ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-footer bg-white border-top-0 pt-0 d-flex justify-content-between">
                <a href="<?= base_url('admin/galleries/edit/'.$item['id']) ?>" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                <a href="<?= base_url('admin/galleries/delete/'.$item['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus foto ini?')"><i class="bi bi-trash"></i></a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?= $this->endSection() ?>