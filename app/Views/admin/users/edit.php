<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4><i class="bi bi-pencil-square me-2"></i>Edit User</h4>
            <a href="<?= base_url('admin/users') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="<?= base_url('admin/users/update/' . $user['id']) ?>" method="POST">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Penempatan Sekolah</label>
                        
                        <?php if (empty($mySchoolId)) : ?>
                            <select name="school_id" class="form-select" id="schoolSelector">
                                <option value="" <?= empty($user['school_id']) ? 'selected' : '' ?>>-- Pusat / Yayasan --</option>
                                <?php foreach ($schools as $s) : ?>
                                    <option value="<?= $s['id'] ?>" <?= ($user['school_id'] == $s['id']) ? 'selected' : '' ?>>
                                        <?= esc($s['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        <?php else : ?>
                            <input type="text" class="form-control bg-light" value="Sekolah Terkunci" readonly disabled>
                        <?php endif; ?>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Username</label>
                            <input type="text" name="username" class="form-control" value="<?= old('username', $user['username']) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" value="<?= old('email', $user['email']) ?>" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Ganti Password</label>
                            <input type="password" name="password" class="form-control" placeholder="(Biarkan kosong jika tidak diganti)">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" name="full_name" class="form-control" value="<?= old('full_name', $user['full_name']) ?>" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Role</label>
                            
                            <?php if (empty($mySchoolId)) : ?>
                                <select name="role" class="form-select" id="schoolSelector">
                                    <option value="guru" <?= $user['role'] == 'guru' ? 'selected' : '' ?>>Guru / Staff</option>
                                    <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin Sekolah</option>
                                    <option value="superadmin" <?= $user['role'] == 'superadmin' ? 'selected' : '' ?>>Superadmin</option>
                                </select>
                            <?php else : ?>
                                <input type="text" class="form-control bg-light" value="<?= strtoupper($user['role']) ?>" readonly disabled>
                                <small class="text-muted">Anda tidak dapat mengubah role user ini.</small>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Status Akun</label>
                            <select name="is_active" class="form-select">
                                <option value="1" <?= $user['is_active'] == 1 ? 'selected' : '' ?>>Aktif</option>
                                <option value="0" <?= $user['is_active'] == 0 ? 'selected' : '' ?>>Nonaktif (Banned)</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-grid mt-3">
                        <button type="submit" class="btn btn-warning btn-lg">
                            <i class="bi bi-check-circle me-2"></i>Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const schoolSelect = document.getElementById('schoolSelector');
        const roleSelect = document.getElementById('roleSelector');

        // Pastikan elemen ada (hanya untuk Superadmin)
        if (schoolSelect && roleSelect) {
            
            // 1. Jalankan saat halaman pertama kali dibuka (untuk set kondisi awal)
            adjustRoleOptions();

            // 2. Jalankan setiap kali user mengubah pilihan sekolah
            schoolSelect.addEventListener('change', adjustRoleOptions);
        }

        function adjustRoleOptions() {
            const selectedSchool = schoolSelect.value;
            const options = roleSelect.options;
            
            // Cari opsi Superadmin
            let superAdminOption = null;
            for (let i = 0; i < options.length; i++) {
                if (options[i].value === 'superadmin') {
                    superAdminOption = options[i];
                    break;
                }
            }

            if (selectedSchool === "") {
                // === JIKA PUSAT (VALUE KOSONG) ===
                // Munculkan opsi Superadmin
                if(superAdminOption) superAdminOption.style.display = 'block';
                
            } else {
                // === JIKA SEKOLAH TERTENTU (MTs/MA/dll) ===
                // Sembunyikan opsi Superadmin
                if(superAdminOption) superAdminOption.style.display = 'none';
                
                // Jika saat ini rolenya Superadmin, paksa ubah jadi Admin Sekolah
                if (roleSelect.value === 'superadmin') {
                    roleSelect.value = "admin";
                }
            }
        }
    });
</script>
<?= $this->endSection() ?>