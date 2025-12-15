<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<!-- Alert Notifications -->
<?php if (session()->getFlashdata('error')) : ?>
<div class="alert alert-danger alert-dismissible fade show">
    <i class="bi bi-exclamation-triangle-fill me-2"></i>
    <?= session()->getFlashdata('error') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<!-- Action Bar -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1"><i class="bi bi-images me-2"></i>Kelola Hero Slider</h4>
        <small class="text-muted">Gambar utama yang muncul di halaman beranda</small>
    </div>
    <a href="<?= base_url('admin/sliders/create') ?>" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Tambah Slider Baru
    </a>
</div>
<!-- Filter Card -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="<?= base_url('admin/sliders') ?>" class="row g-3">
            <!-- Search -->
            <div class="col-md-4">
                <label class="form-label fw-bold">Cari Slider</label>
                <input type="text" name="search" class="form-control" placeholder="Cari judul atau deskripsi..." value="<?= esc($current_search ?? '') ?>">
            </div>
            
            <!-- Filter Status -->
            <div class="col-md-3">
                <label class="form-label fw-bold">Status</label>
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="1" <?= ($current_status === '1') ? 'selected' : '' ?>>Aktif</option>
                    <option value="0" <?= ($current_status === '0') ? 'selected' : '' ?>>Nonaktif</option>
                </select>
            </div>
            
            <!-- Filter Sekolah (hanya untuk superadmin) -->
            <?php if (!$mySchoolId) : ?>
            <div class="col-md-3">
                <label class="form-label fw-bold">Milik Sekolah</label>
                <select name="school_id" class="form-select">
                    <option value="">Semua Sekolah</option>
                    <option value="pusat" <?= ($current_school_id === 'pusat') ? 'selected' : '' ?>>Portal Pusat</option>
                    <?php foreach ($schools as $school) : ?>
                        <option value="<?= $school['id'] ?>" <?= ($current_school_id == $school['id']) ? 'selected' : '' ?>>
                            <?= esc($school['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php endif; ?>
            
            <!-- Tombol Filter -->
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-funnel me-1"></i> Filter
                </button>
            </div>
        </form>
    </div>
</div>
<!-- Slider List -->
<div class="row g-4">
    <?php if (empty($sliders)) : ?>
        <div class="col-12">
            <div class="alert alert-warning">
                <i class="bi bi-info-circle me-2"></i>Belum ada slider. Tambahkan slider pertama Anda!
            </div>
        </div>
    <?php else : ?>
        <?php foreach ($sliders as $slider) : ?>
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100 <?= $slider['is_active'] ? '' : 'opacity-50' ?>">
                <!-- Image Preview -->
                <div class="position-relative" style="height: 200px; overflow: hidden;">
                    <img src="<?= base_url($slider['image_url']) ?>" class="w-100 h-100 object-fit-cover" alt="Slider">
                    
                    <!-- Badge Status -->
                    <div class="position-absolute top-0 end-0 m-2">
                        <?php if ($slider['is_active']) : ?>
                            <span class="badge bg-success">Aktif</span>
                        <?php else : ?>
                            <span class="badge bg-secondary">Nonaktif</span>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Badge Order -->
                    <div class="position-absolute top-0 start-0 m-2">
                        <span class="badge bg-dark">Urutan #<?= $slider['order_position'] ?></span>
                    </div>
                </div>
                
                <!-- Card Body -->
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-2"><?= esc($slider['title']) ?></h5>
                    <p class="card-text text-muted small mb-3">
                        <?= esc(substr($slider['description'], 0, 80)) ?>...
                    </p>
                    
                    <?php if ($slider['button_text']) : ?>
                        <div class="mb-3">
                            <span class="badge bg-info">
                                <i class="bi bi-hand-index-thumb me-1"></i><?= esc($slider['button_text']) ?>
                            </span>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Card Footer Actions -->
                <div class="card-footer bg-white border-top d-flex gap-2">
                    <a href="<?= base_url('admin/sliders/edit/' . $slider['id']) ?>" class="btn btn-sm btn-warning flex-fill">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>
                    <button class="btn btn-sm btn-<?= $slider['is_active'] ? 'secondary' : 'success' ?> flex-fill toggle-status" data-id="<?= $slider['id'] ?>">
                        <i class="bi bi-toggle-<?= $slider['is_active'] ? 'off' : 'on' ?>"></i> 
                        <?= $slider['is_active'] ? 'Nonaktifkan' : 'Aktifkan' ?>
                    </button>
                    <a href="<?= base_url('admin/sliders/delete/' . $slider['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus slider ini?')">
                        <i class="bi bi-trash-fill"></i>
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Toggle Status via AJAX
    $('.toggle-status').click(function() {
        const btn = $(this);
        const id = btn.data('id');
        
        $.ajax({
            url: '<?= base_url('admin/sliders/toggle-status') ?>/' + id,
            type: 'POST',
            data: {
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
            },
            success: function(response) {
                location.reload();
            },
            error: function(xhr) {
                alert('Error: ' + xhr.status);
            }
        });
    });
</script>
<?= $this->endSection() ?>