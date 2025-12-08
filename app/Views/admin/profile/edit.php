<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-lg-8 mx-auto">
        <!-- Back Button -->
        <div class="mb-3">
            <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-2"></i> Kembali ke Dashboard
            </a>
        </div>

        <!-- Profile Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-purple text-white">
                <h5 class="mb-0">
                    <i class="bi bi-person-circle me-2"></i> Edit Profil Saya
                </h5>
            </div>
            <div class="card-body p-4">
                <!-- Success/Error Messages -->
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <strong><i class="bi bi-exclamation-triangle me-2"></i> Error!</strong>
                        <ul class="mb-0 mt-2">
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('admin/profile/update') ?>" method="POST">
                    <?= csrf_field() ?>

                    <!-- User Info Badge -->
                    <div class="alert alert-info border-0 mb-4">
                        <div class="d-flex align-items-center">
                            <div class="user-avatar-large me-3">
                                <?= strtoupper(substr($user['full_name'], 0, 1)) ?>
                            </div>
                            <div>
                                <h6 class="mb-0"><?= esc($user['full_name']) ?></h6>
                                <small class="text-muted">
                                    <i class="bi bi-shield-check"></i> <?= strtoupper(esc($user['role'])) ?>
                                    <?php if (!empty($user['school_id'])): ?>
                                        | <i class="bi bi-building"></i> Admin Sekolah
                                    <?php endif; ?>
                                </small>
                            </div>
                        </div>
                    </div>

                    <h6 class="mb-3 text-muted">
                        <i class="bi bi-info-circle me-2"></i> Informasi Dasar
                    </h6>

                    <!-- Full Name -->
                    <div class="mb-3">
                        <label for="full_name" class="form-label fw-bold">
                            Nama Lengkap <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                            class="form-control"
                            id="full_name"
                            name="full_name"
                            value="<?= old('full_name', $user['full_name']) ?>"
                            required>
                    </div>

                    <!-- Username -->
                    <div class="mb-3">
                        <label for="username" class="form-label fw-bold">
                            Username <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                            class="form-control"
                            id="username"
                            name="username"
                            value="<?= old('username', $user['username']) ?>"
                            required>
                        <small class="text-muted">Username digunakan untuk login</small>
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="form-label fw-bold">
                            Email <span class="text-danger">*</span>
                        </label>
                        <input type="email"
                            class="form-control"
                            id="email"
                            name="email"
                            value="<?= old('email', $user['email']) ?>"
                            required>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-light">
                            <i class="bi bi-x-circle me-2"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-purple">
                            <i class="bi bi-check-circle me-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Last Login Info -->
        <div class="card border-0 shadow-sm mt-3">
            <div class="card-body">
                <h6 class="mb-3">
                    <i class="bi bi-clock-history me-2"></i> Informasi Login Terakhir
                </h6>
                <div class="row text-center">
                    <div class="col-md-6">
                        <p class="text-muted mb-1">Login Terakhir</p>
                        <h6><?= $user['last_login'] ? date('d M Y, H:i', strtotime($user['last_login'])) : 'Belum pernah login' ?></h6>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1">IP Address</p>
                        <h6><?= esc($user['last_ip'] ?? '-') ?></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-purple {
        background: linear-gradient(135deg, #2f3f58 0%, #1a253a 100%);
    }

    .btn-purple {
        background: linear-gradient(135deg, #2f3f58 0%, #1a253a 100%);
        color: white;
        border: none;
        padding: 10px 25px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s;
    }

    .btn-purple:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(47, 63, 88, 0.3);
        color: white;
    }

    .user-avatar-large {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2f3f58 0%, #1a253a 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.5rem;
    }

    .card {
        border-radius: 15px;
        overflow: hidden;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #2f3f58;
        box-shadow: 0 0 0 0.2rem rgba(47, 63, 88, 0.25);
    }
</style>

<?= $this->endSection() ?>