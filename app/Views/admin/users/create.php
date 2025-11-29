<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4><i class="bi bi-person-plus-fill me-2"></i>Tambah User Baru</h4>
            <a href="<?= base_url('admin/users') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>

        <?php if (session()->getFlashdata('errors')) : ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="<?= base_url('admin/users/store') ?>" method="POST">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Penempatan Sekolah</label>
                        
                        <?php if (empty($mySchoolId)) : ?>
                            <select name="school_id" class="form-select" id="schoolSelector" onchange="adjustRoleOptions()">
                                <option value="">-- Pusat / Yayasan (Superadmin) --</option>
                                <?php foreach ($schools as $s) : ?>
                                    <option value="<?= $s['id'] ?>"><?= esc($s['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-muted">Pilih "Pusat" untuk membuat Superadmin baru.</small>
                        
                        <?php else : ?>
                            <input type="text" class="form-control bg-light" value="Sekolah Anda (Terkunci)" readonly disabled>
                            <input type="hidden" name="school_id" value="<?= $mySchoolId ?>">
                            <small class="text-success fw-bold"><i class="bi bi-lock-fill"></i> User otomatis didaftarkan di sekolah Anda.</small>
                        <?php endif; ?>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" class="form-control" value="<?= old('username') ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" value="<?= old('email') ?>" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" required minlength="6">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="full_name" class="form-control" value="<?= old('full_name') ?>" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Role / Hak Akses</label>
                        
                        <?php if (empty($mySchoolId)) : ?>
                            <select name="role" class="form-select" id="roleSelector">
                                <option value="guru">Guru / Staff</option>
                                <option value="admin">Admin Sekolah</option>
                                <option value="superadmin">Superadmin (Pusat)</option>
                            </select>
                        <?php else : ?>
                            <select name="role" class="form-select bg-light" readonly>
                                <option value="guru" selected>Guru / Staff</option>
                            </select>
                            <small class="text-muted">Admin sekolah hanya dapat menambahkan akun Guru.</small>
                        <?php endif; ?>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-save me-2"></i>Simpan User
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

        if (schoolSelect && roleSelect) {
            // Jalankan saat pertama load
            adjustRoleOptions();

            // Jalankan saat user mengganti sekolah
            schoolSelect.addEventListener('change', adjustRoleOptions);
        }

        function adjustRoleOptions() {
            const selectedSchool = schoolSelect.value;
            const options = roleSelect.options;

            // Cari opsi Superadmin (value="superadmin")
            let superAdminOption = null;
            for (let i = 0; i < options.length; i++) {
                if (options[i].value === 'superadmin') {
                    superAdminOption = options[i];
                    break;
                }
            }

            if (selectedSchool === "") {
                // === KASUS: PUSAT / YAYASAN DIPILIH ===
                
                // 1. Munculkan opsi Superadmin
                if(superAdminOption) superAdminOption.style.display = 'block';
                
                // 2. Default pilih Superadmin
                roleSelect.value = "superadmin";
                
            } else {
                // === KASUS: SEKOLAH TERTENTU DIPILIH (MTs/MA/SMK) ===
                
                // 1. Sembunyikan opsi Superadmin (Biar gak salah pilih)
                if(superAdminOption) superAdminOption.style.display = 'none';
                
                // 2. Jika saat ini terpilih Superadmin, paksa ganti ke Admin Sekolah
                if (roleSelect.value === 'superadmin') {
                    roleSelect.value = "admin";
                }
            }
        }
    });
</script>

<?= $this->endSection() ?>