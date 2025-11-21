<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<!-- Alert Notifications -->
<?php if (session()->getFlashdata('success')) : ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle-fill me-2"></i>
    <?= session()->getFlashdata('success') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-triangle-fill me-2"></i>
    <?= session()->getFlashdata('error') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<!-- Action Bar -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1"><i class="bi bi-building me-2"></i>Kelola Jenjang Pendidikan</h4>
        <small class="text-muted">Manajemen data sekolah MTs, MA, dan SMK</small>
    </div>
    <a href="<?= base_url('admin/schools/create') ?>" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Tambah Jenjang Baru
    </a>
</div>

<!-- Schools Grid -->
<div class="row g-4">
    <?php if (empty($schools)) : ?>
        <div class="col-12">
            <div class="alert alert-warning">
                <i class="bi bi-info-circle me-2"></i>Belum ada data jenjang sekolah. Tambahkan jenjang pertama Anda!
            </div>
        </div>
    <?php else : ?>
        <?php foreach ($schools as $school) : ?>
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100 hover-lift">
                <!-- Image -->
                <div class="position-relative overflow-hidden" style="height: 200px;">
                    <?php if (!empty($school['image_url']) && file_exists($school['image_url'])) : ?>
                        <img src="<?= base_url($school['image_url']) ?>" 
                             class="w-100 h-100 object-fit-cover" 
                             alt="<?= esc($school['name']) ?>">
                    <?php else : ?>
                        <!-- Placeholder jika tidak ada gambar -->
                        <div class="w-100 h-100 bg-secondary d-flex align-items-center justify-content-center text-white">
                            <div class="text-center">
                                <i class="bi bi-building" style="font-size: 3rem;"></i>
                                <p class="mb-0 mt-2 small">Belum ada foto</p>
                            </div>
                        </div>
                    <?php endif; ?>
                                        <!-- Badges -->
                    <div class="position-absolute top-0 start-0 m-2">
                        <span class="badge bg-dark mb-1">Urutan #<?= $school['order_position'] ?></span>
                    </div>
                    <div class="position-absolute top-0 end-0 m-2">
                        <?php
                            $accreditation = $school['accreditation_status'] ?? 'A';
                            $badgeClass = match($accreditation) {
                                'A' => 'bg-success',
                                'B' => 'bg-primary',
                                'C' => 'bg-warning',
                                default => 'bg-secondary'
                            };
                        ?>
                        <span class="badge <?= $badgeClass ?> text-white">
                            <i class="bi bi-star-fill me-1"></i>
                            <?= $accreditation == 'Belum Terakreditasi' ? 'Belum Terakreditasi' : 'Akreditasi ' . esc($accreditation) ?>
                        </span>
                    </div>
                </div>
                
                <!-- Card Body -->
                <div class="card-body">
                    <h5 class="card-title fw-bold text-purple mb-2">
                        <i class="bi bi-mortarboard-fill me-2"></i>
                        <?= esc($school['name']) ?>
                    </h5>
                    <p class="card-text text-muted small mb-3">
                        <?= esc(substr($school['description'], 0, 100)) ?>...
                    </p>
                    
                    <!-- Additional Info -->
                    <?php if ($school['contact_person']) : ?>
                        <div class="mb-2">
                            <small class="text-muted">
                                <i class="bi bi-person-badge me-1"></i>
                                <?= esc($school['contact_person']) ?>
                            </small>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($school['phone']) : ?>
                        <div class="mb-2">
                            <small class="text-muted">
                                <i class="bi bi-telephone me-1"></i>
                                <?= esc($school['phone']) ?>
                            </small>
                        </div>
                    <?php endif; ?>
                    
                                        <?php if (!empty($school['website_url'])) : ?>
                        <div class="mb-3">
                            <a href="<?= esc($school['website_url']) ?>" 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               class="text-primary small">
                                <i class="bi bi-globe me-1"></i>
                                Website
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Card Footer -->
                <div class="card-footer bg-white border-top d-flex gap-2">
                    <a href="<?= base_url('admin/schools/edit/' . $school['id']) ?>" 
                       class="btn btn-sm btn-warning flex-fill">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>
                    <a href="<?= base_url('admin/schools/delete/' . $school['id']) ?>" 
                       class="btn btn-sm btn-danger flex-fill" 
                       onclick="return confirm('Yakin ingin menghapus jenjang <?= esc($school['name']) ?>?')">
                        <i class="bi bi-trash-fill"></i> Hapus
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<style>
    .text-purple {
        color: var(--mbs-purple);
    }
    
    .hover-lift {
        transition: all 0.3s;
    }
    
    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important;
    }
    
    .object-fit-cover {
        object-fit: cover;
    }
</style>
<?= $this->endSection() ?>