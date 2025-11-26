<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4><i class="bi bi-pencil-square me-2"></i>Edit Pengumuman</h4>
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
        <form action="<?= base_url('admin/announcements/update/' . $announcement['id']) ?>" method="POST">
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
                                    <option value="<?= $s['id'] ?>" <?= ($announcement['school_id'] == $s['id']) ? 'selected' : '' ?>>
                                        <?= esc($s['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-muted">Superadmin dapat memindahkan target sekolah.</small>

                        <?php else : ?>
                            <?php
                            // Cari nama sekolah user yang login
                            $schoolName = 'Sekolah Anda';
                            foreach ($schools as $s) {
                                if ($s['id'] == $currentSchoolId) {
                                    $schoolName = $s['name'];
                                    break;
                                }
                            }
                            ?>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-success border-end-0">
                                    <i class="bi bi-lock-fill"></i>
                                </span>
                                <input type="text" class="form-control bg-light border-start-0" value="<?= esc($schoolName) ?>" readonly disabled>
                            </div>

                            <input type="hidden" name="school_id" value="<?= $currentSchoolId ?>">

                            <small class="text-success fw-bold">
                                Pengumuman ini terkunci untuk <?= esc($schoolName) ?>
                            </small>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            Judul Pengumuman <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                            name="title"
                            class="form-control form-control-lg"
                            value="<?= old('title', $announcement['title']) ?>"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            Isi Pengumuman Lengkap <span class="text-danger">*</span>
                        </label>
                        <textarea name="content"
                            class="form-control"
                            rows="5"
                            required><?= old('content', $announcement['content']) ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">
                                Tanggal Mulai Tampil <span class="text-danger">*</span>
                            </label>
                            <input type="date"
                                name="start_date"
                                class="form-control"
                                value="<?= old('start_date', $announcement['start_date']) ?>"
                                required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">
                                Tanggal Selesai <span class="text-danger">*</span>
                            </label>
                            <input type="date"
                                name="end_date"
                                class="form-control"
                                value="<?= old('end_date', $announcement['end_date']) ?>"
                                required>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Kategori Pengumuman</label>
                        <select name="category" class="form-select form-select-lg" required>
                            <option value="urgent" <?= old('category', $announcement['category']) == 'urgent' ? 'selected' : '' ?>>
                                Mendesak
                            </option>
                            <option value="important" <?= old('category', $announcement['category']) == 'important' ? 'selected' : '' ?>>
                                Penting
                            </option>
                            <option value="normal" <?= old('category', $announcement['category']) == 'normal' ? 'selected' : '' ?>>
                                Biasa
                            </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Icon Bootstrap</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi <?= old('icon', $announcement['icon']) ?>" id="iconPreview"></i>
                            </span>
                            <input type="text"
                                name="icon"
                                class="form-control"
                                value="<?= old('icon', $announcement['icon']) ?>"
                                id="iconInput">
                        </div>

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
                            value="<?= old('priority', $announcement['priority']) ?>"
                            min="0">
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input"
                                type="checkbox"
                                name="is_active"
                                id="isActive"
                                value="1"
                                <?= old('is_active', $announcement['is_active']) == '1' ? 'checked' : '' ?>>
                            <label class="form-check-label fw-bold" for="isActive">
                                Aktifkan Pengumuman
                            </label>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="bi bi-check-circle me-2"></i>Update Pengumuman
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