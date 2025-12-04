<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold" style="color: var(--mbs-purple);"><i class="bi bi-person-circle me-2"></i>Profil Saya</h4>
            <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-secondary shadow-sm">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>

        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0">
                <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('errors')) : ?>
            <div class="alert alert-danger border-0 shadow-sm">
                <ul class="mb-0">
                    <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-header text-white p-4" style="background: linear-gradient(135deg, var(--mbs-purple) 0%, var(--mbs-purple-dark) 100%);">
                <div class="d-flex align-items-center">
                    <div class="bg-white text-purple rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px; color: var(--mbs-purple);">
                        <span class="fs-2 fw-bold"><?= strtoupper(substr($user['full_name'], 0, 1)) ?></span>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold"><?= esc($user['full_name']) ?></h5>
                        <small class="opacity-75 text-uppercase ls-1"><?= esc($user['role']) ?></small>
                    </div>
                </div>
            </div>

            <div class="card-body p-4 bg-white">
                <form action="<?= base_url('admin/profile/update') ?>" method="POST">
                    <?= csrf_field() ?>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-secondary">Username</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-person"></i></span>
                                <input type="text" name="username" class="form-control border-start-0 bg-light" value="<?= esc($user['username']) ?>" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-secondary">Email (Untuk Reset Password)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" class="form-control border-start-0 bg-light" value="<?= esc($user['email']) ?>" required>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold text-secondary">Nama Lengkap</label>
                            <input type="text" name="full_name" class="form-control form-control-lg" value="<?= esc($user['full_name']) ?>" required>
                        </div>

                        <div class="col-12">
                            <div class="p-3 rounded bg-info bg-opacity-10 border border-info d-flex align-items-start">
                                <i class="bi bi-info-circle-fill text-info me-3 mt-1"></i>
                                <div>
                                    <strong>Info Akun:</strong><br>
                                    <span class="small text-muted">
                                        Role: <strong><?= strtoupper($user['role']) ?></strong> <br>
                                        Terdaftar: <?= date('d M Y', strtotime($user['created_at'])) ?> <br>
                                        Login Terakhir: <?= $user['last_login'] ? date('d M Y H:i', strtotime($user['last_login'])) : '-' ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid mt-5">
                        <button type="submit" class="btn btn-primary btn-lg shadow rounded-pill fw-bold">
                            <i class="bi bi-save me-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="card-footer bg-light p-3 text-center">
                <small class="text-muted">Ingin mengganti password? <a href="<?= base_url('admin/change-password-request') ?>" class="fw-bold text-decoration-none" style="color: var(--mbs-purple);" onclick="return confirm('Kirim link reset password ke email?');">Klik di sini</a></small>
            </div>
        </div>
    </div>
</div>

<style>
    /* Pastikan warna input focus sesuai tema */
    .form-control:focus {
        border-color: var(--mbs-purple);
        box-shadow: 0 0 0 0.25rem rgba(47, 63, 88, 0.25);
    }
</style>

<?= $this->endSection() ?>