<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4><i class="bi bi-plus-square me-2"></i>Tambah Pengumuman Baru</h4>
    <a href="<?= base_url('admin/announcements') ?>" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Kembali
    </a>
</div>

<?php if (session()->getFlashdata('errors')) : ?>
    <div class="alert alert-danger">
        <strong>Error:</strong>
        <ul class="mb-0">
            <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="<?= base_url('admin/announcements/store') ?>" method="POST">
            <?= csrf_field() ?>

            <div class="row">
                <!-- Left Column -->
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Target Sekolah</label>
                        <?php if (empty($currentSchoolId)) : ?>
                            <select name="school_id" class="form-select">
                                <option value="">-- Semua / Umum (Yayasan) --</option>
                                <?php foreach ($schools as $s) : ?>
                                    <option value="<?= $s['id'] ?>"><?= esc($s['name']) ?></option>
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
                            <small class="text-success"><i class="bi bi-lock-fill"></i> Pengumuman ini khusus untuk <?= esc($schoolName) ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            Judul Pengumuman <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                            name="title"
                            class="form-control form-control-lg"
                            value="<?= old('title') ?>"
                            placeholder="Contoh: Penerimaan Santri Baru Gelombang 1"
                            required>
                        <small class="text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            Judul akan ditampilkan di ticker berjalan
                        </small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            Isi Pengumuman Lengkap <span class="text-danger">*</span>
                        </label>
                        <textarea name="content"
                            class="form-control"
                            rows="5"
                            placeholder="Tulis isi pengumuman secara lengkap..."
                            required><?= old('content') ?></textarea>
                        <small class="text-muted">Minimal 10 karakter</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Link / Tautan (Opsional)</label>
                        <input type="url" name="link_url" class="form-control" placeholder="https://..." value="<?= old('link_url', $announcement['link_url'] ?? '') ?>">
                        <small class="text-muted">Isi jika pengumuman ini mengarah ke file/halaman tertentu.</small>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">
                                Tanggal Mulai Tampil <span class="text-danger">*</span>
                            </label>
                            <input type="date"
                                name="start_date"
                                class="form-control"
                                value="<?= old('start_date', date('Y-m-d')) ?>"
                                required>
                            <small class="text-muted">Pengumuman mulai tampil dari tanggal ini</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">
                                Tanggal Selesai <span class="text-danger">*</span>
                            </label>
                            <input type="date"
                                name="end_date"
                                class="form-control"
                                value="<?= old('end_date') ?>"
                                required>
                            <small class="text-muted">Otomatis hilang setelah tanggal ini</small>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Kategori Pengumuman</label>
                        <select name="category" class="form-select form-select-lg" required>
                            <option value="urgent" <?= old('category') == 'urgent' ? 'selected' : '' ?>>
                                Mendesak
                            </option>
                            <option value="important" <?= old('category') == 'important' ? 'selected' : '' ?>>
                                Penting
                            </option>
                            <option value="normal" <?= old('category', 'normal') == 'normal' ? 'selected' : '' ?>>
                                Biasa
                            </option>
                        </select>
                        <small class="text-muted">Kategori menentukan warna badge</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Icon Bootstrap</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi <?= old('icon', 'bi-megaphone-fill') ?>" id="iconPreview"></i>
                            </span>
                            <input type="text"
                                name="icon"
                                class="form-control"
                                value="<?= old('icon', 'bi-megaphone-fill') ?>"
                                id="iconInput"
                                placeholder="bi-megaphone-fill">
                        </div>
                        <small class="text-muted d-block mt-1">
                            <a href="https://icons.getbootstrap.com/" target="_blank" class="text-primary">
                                <i class="bi bi-box-arrow-up-right me-1"></i>
                                Lihat daftar icon
                            </a>
                        </small>

                        <!-- Icon Quick Select -->
                        <div class="mt-2">
                            <small class="text-muted d-block mb-2">Icon populer:</small>
                            <div class="btn-group-sm d-flex flex-wrap gap-1">
                                <button type="button" class="btn btn-outline-secondary icon-select-btn" data-icon="bi-megaphone-fill">
                                    <i class="bi bi-megaphone-fill"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary icon-select-btn" data-icon="bi-bell-fill">
                                    <i class="bi bi-bell-fill"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary icon-select-btn" data-icon="bi-exclamation-triangle-fill">
                                    <i class="bi bi-exclamation-triangle-fill"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary icon-select-btn" data-icon="bi-info-circle-fill">
                                    <i class="bi bi-info-circle-fill"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary icon-select-btn" data-icon="bi-calendar-event-fill">
                                    <i class="bi bi-calendar-event-fill"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Prioritas Urutan</label>
                        <input type="number"
                            name="priority"
                            class="form-control"
                            value="<?= old('priority', 0) ?>"
                            min="0"
                            placeholder="0">
                        <small class="text-muted">
                            Angka kecil = prioritas tinggi (tampil duluan)
                        </small>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input"
                                type="checkbox"
                                name="is_active"
                                id="isActive"
                                value="1"
                                <?= old('is_active', '1') == '1' ? 'checked' : '' ?>>
                            <label class="form-check-label fw-bold" for="isActive">
                                Aktifkan Pengumuman
                            </label>
                        </div>
                        <small class="text-muted d-block mt-1">
                            Jika nonaktif, tidak akan tampil di landing page
                        </small>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-save me-2"></i>Simpan Pengumuman
                        </button>
                        <a href="<?= base_url('admin/announcements') ?>" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-2"></i>Batal
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Icon Preview
    document.getElementById('iconInput').addEventListener('input', function() {
        document.getElementById('iconPreview').className = 'bi ' + this.value;
    });

    // Icon Quick Select
    document.querySelectorAll('.icon-select-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const icon = this.dataset.icon;
            document.getElementById('iconInput').value = icon;
            document.getElementById('iconPreview').className = 'bi ' + icon;
        });
    });
</script>
<?= $this->endSection() ?>