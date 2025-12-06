<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-6">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold" style="color: var(--mbs-purple);"><i class="bi bi-shield-lock-fill me-2"></i>Ganti Password</h4>
            <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-secondary shadow-sm">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>
        <?php if (session()->getFlashdata('errors')) : ?>
            <div class="alert alert-danger border-0 shadow-sm mb-4">
                <div class="d-flex align-items-start">
                    <i class="bi bi-exclamation-circle-fill me-2 mt-1"></i>
                    <div>
                        <strong>Periksa input Anda:</strong>
                        <ul class="mb-0 ps-3">
                            <?php foreach (session()->getFlashdata('errors') as $err) : ?>
                                <li><?= esc($err) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-header text-white p-4" style="background: linear-gradient(135deg, var(--mbs-purple) 0%, var(--mbs-purple-dark) 100%);">
                <h6 class="mb-0 fw-bold"><i class="bi bi-key-fill me-2"></i>Formulir Keamanan</h6>
                <small class="opacity-75">Amankan akun Anda dengan password yang kuat.</small>
            </div>

            <div class="card-body p-4 bg-white">
                <form action="<?= base_url('admin/change-password') ?>" method="POST">
                    <?= csrf_field() ?>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-secondary">Password Lama</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-unlock"></i></span>
                            <input type="password" name="current_password" class="form-control border-start-0 bg-light" required placeholder="Masukkan password saat ini">
                        </div>
                        <div class="text-end mt-1">
                            <small>
                                <a href="<?= base_url('admin/logout') ?>" onclick="alert('Silakan logout lalu klik Lupa Password di halaman login.');" class="text-decoration-none text-muted" style="font-size: 0.8rem;">
                                    Lupa password lama?
                                </a>
                            </small>
                        </div>
                    </div>

                    <hr class="border-light my-4">

                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary">Password Baru</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" name="new_password" class="form-control border-start-0 bg-light" required minlength="8" placeholder="Minimal 8 karakter">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-secondary">Ulangi Password Baru</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-check-circle"></i></span>
                            <input type="password" name="confirm_password" class="form-control border-start-0 bg-light" required placeholder="Ketik ulang password baru">
                        </div>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary btn-lg shadow rounded-pill fw-bold">
                            <i class="bi bi-save me-2"></i> Simpan Password Baru
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus {
        border-color: var(--mbs-purple);
        box-shadow: 0 0 0 0.25rem rgba(47, 63, 88, 0.25);
    }
</style>

<?= $this->endSection() ?>