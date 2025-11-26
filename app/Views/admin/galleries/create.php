<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>
<div class="card border-0 shadow-sm col-lg-8 mx-auto">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0">Upload Foto Baru</h5>
    </div>
    <div class="card-body p-4">
        <form action="<?= base_url('admin/galleries/store') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label fw-bold">Judul Foto / Caption</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Kategori</label>
                    <select name="category" class="form-select">
                        <option value="kegiatan">Kegiatan Santri</option>
                        <option value="fasilitas">Fasilitas</option>
                        <option value="prestasi">Prestasi</option>
                        <option value="asrama">Asrama</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Milik Sekolah</label>

                    <?php if (empty($currentSchoolId)) : ?>
                        <select name="school_id" class="form-select">
                            <option value="">-- Semua / Umum --</option>
                            <?php foreach ($schools as $s) : ?>
                                <option value="<?= $s['id'] ?>"><?= esc($s['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <small class="text-muted">Pilih sekolah tujuan atau biarkan kosong untuk Umum.</small>

                    <?php else : ?>
                        <?php
                        // Cari nama sekolah berdasarkan ID user yang login
                        $schoolName = 'Sekolah Anda';
                        foreach ($schools as $s) {
                            if ($s['id'] == $currentSchoolId) {
                                $schoolName = $s['name'];
                                break;
                            }
                        }
                        ?>
                        <input type="text" class="form-control bg-light" value="<?= esc($schoolName) ?>" readonly disabled>

                        <input type="hidden" name="school_id" value="<?= $currentSchoolId ?>">

                        <small class="text-success fw-bold">
                            <i class="bi bi-lock-fill"></i> Terkunci otomatis ke akun sekolah Anda.
                        </small>
                    <?php endif; ?>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label fw-bold">File Foto</label>
                <input type="file" name="image" class="form-control" accept="image/*" required>
            </div>
            <div class="d-flex justify-content-end gap-2">
                <a href="<?= base_url('admin/galleries') ?>" class="btn btn-secondary">Batal</a>
                <button type="button" class="btn btn-primary" onclick="this.form.submit()">Upload</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>