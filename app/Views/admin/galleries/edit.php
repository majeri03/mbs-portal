<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4><i class="bi bi-pencil-square me-2"></i>Edit Galeri Foto</h4>
            <a href="<?= base_url('admin/galleries') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <!-- Alert Error -->
                <?php if (session()->getFlashdata('error')) : ?>
                    <div class="alert alert-danger alert-dismissible fade show mb-3">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>Gagal!</strong> <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('errors')) : ?>
                    <div class="alert alert-danger alert-dismissible fade show mb-3">
                        <strong>Periksa input Anda:</strong>
                        <ul class="mb-0 mt-2">
                            <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                <form action="<?= base_url('admin/galleries/update/' . $gallery['id']) ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Foto / Caption <span class="text-danger">*</span></label>
                        <input type="text"
                            name="title"
                            class="form-control"
                            value="<?= old('title', $gallery['title']) ?>"
                            placeholder="Contoh: Kegiatan Upacara Bendera"
                            required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Kategori</label>
                            <select name="category" class="form-select" required>
                                <option value="kegiatan" <?= old('category', $gallery['category']) == 'kegiatan' ? 'selected' : '' ?>>Kegiatan Santri</option>
                                <option value="fasilitas" <?= old('category', $gallery['category']) == 'fasilitas' ? 'selected' : '' ?>>Fasilitas</option>
                                <option value="prestasi" <?= old('category', $gallery['category']) == 'prestasi' ? 'selected' : '' ?>>Prestasi</option>
                                <option value="asrama" <?= old('category', $gallery['category']) == 'asrama' ? 'selected' : '' ?>>Asrama</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Milik Sekolah</label>

                            <?php if (empty($currentSchoolId)) : ?>
                                <select name="school_id" class="form-select">
                                    <option value="">-- Semua / Umum --</option>
                                    <?php foreach ($schools as $s) : ?>
                                        <option value="<?= $s['id'] ?>" <?= ($gallery['school_id'] == $s['id']) ? 'selected' : '' ?>>
                                            <?= esc($s['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            <?php else : ?>
                                <?php
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
                                <small class="text-success"><i class="bi bi-check-circle-fill"></i> Data ini milik <?= esc($schoolName) ?></small>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Foto Saat Ini</label>
                        <div class="border rounded p-2 bg-light text-center">
                            <?php if (!empty($gallery['image_url']) && file_exists($gallery['image_url'])) : ?>
                                <img src="<?= base_url($gallery['image_url']) ?>" class="img-fluid rounded shadow-sm" style="max-height: 200px;" alt="Foto Lama">
                            <?php else : ?>
                                <p class="text-muted mb-0 py-3">File foto tidak ditemukan</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Ganti Foto (Opsional)</label>
                        <input type="file"
                            name="image"
                            class="form-control"
                            accept="image/*"
                            onchange="previewImage(event)">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengganti foto.</small>

                        <div id="newImagePreview" class="mt-3 text-center" style="display: none;">
                            <p class="small fw-bold text-success mb-1">Preview Foto Baru:</p>
                            <img id="preview" src="" class="img-fluid rounded shadow-sm" style="max-height: 200px;">
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-save me-2"></i> Simpan Perubahan
                        </button>
                        <a href="<?= base_url('admin/galleries') ?>" class="btn btn-light">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function previewImage(event) {
        const input = event.target;
        const previewBox = document.getElementById('newImagePreview');
        const previewImg = document.getElementById('preview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewBox.style.display = 'block';
            }

            reader.readAsDataURL(input.files[0]);
        } else {
            previewBox.style.display = 'none';
        }
    }
</script>
<?= $this->endSection() ?>