<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4><i class="bi bi-images me-2 text-purple"></i>Kelola Galeri Foto</h4>
    <a href="<?= base_url('admin/galleries/create') ?>" class="btn btn-primary"><i class="bi bi-upload me-2"></i>Upload Foto</a>
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