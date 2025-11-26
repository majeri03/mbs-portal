<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>Edit Data Pimpinan</h4>
            <a href="<?= base_url('admin/teachers') ?>" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="<?= base_url('admin/teachers/update/' . $teacher['id']) ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <?php if (!session('school_id')) : ?>
                        <div class="mb-3 p-3 bg-light border rounded">
                            <label class="form-label fw-bold text-primary">Tempat Tugas / Sekolah</label>
                            <select name="school_id" class="form-select">
                                <option value="" <?= empty($teacher['school_id']) ? 'selected' : '' ?>>
                                    -- Pimpinan Pusat / Yayasan (Umum) --
                                </option>
                                <?php foreach ($schools as $s) : ?>
                                    <option value="<?= $s['id'] ?>" <?= ($teacher['school_id'] == $s['id']) ? 'selected' : '' ?>>
                                        <?= esc($s['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Lengkap & Gelar</label>
                        <input type="text" name="name" class="form-control" value="<?= esc($teacher['name']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Jabatan</label>
                        <input type="text" name="position" class="form-control" value="<?= esc($teacher['position']) ?>" required>
                    </div>

                    <div class="row align-items-center mb-3">
                        <div class="col-md-3 text-center">
                            <?php 
                                $imgSrc = filter_var($teacher['photo'], FILTER_VALIDATE_URL) ? $teacher['photo'] : base_url($teacher['photo']);
                            ?>
                            <img src="<?= $imgSrc ?>" class="img-thumbnail rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                            <small class="d-block text-muted mt-1">Foto Saat Ini</small>
                        </div>
                        <div class="col-md-9">
                            <label class="form-label fw-bold">Ganti Foto</label>
                            <input type="file" name="photo" class="form-control" accept="image/*">
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengganti foto.</small>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Urutan Tampil</label>
                        <input type="number" name="order_position" class="form-control" value="<?= esc($teacher['order_position']) ?>">
                    </div>
                    <div class="mb-4 p-3 border rounded bg-light">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_leader" value="1" id="isLeaderSwitch" 
                                <?= ($teacher['is_leader'] == 1) ? 'checked' : '' ?>>
                            <label class="form-check-label fw-bold text-purple" for="isLeaderSwitch">
                                Jadikan Kepala Sekolah / Pimpinan?
                            </label>
                        </div>
                        <small class="text-muted d-block mt-1">
                            Jika diaktifkan, foto akan tampil besar paling atas (terpisah dari slider guru).
                        </small>
                    </div>
                    <button type="submit" class="btn btn-success w-100"><i class="bi bi-check-circle me-2"></i> Update Data</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>