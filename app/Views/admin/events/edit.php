<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-lg-8 mx-auto">
        <!-- Back Button -->
        <div class="mb-3">
            <a href="<?= base_url('admin/events') ?>" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-2"></i> Kembali ke Daftar Agenda
            </a>
        </div>

        <!-- Form Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-purple text-white">
                <h5 class="mb-0">
                    <i class="bi bi-pencil-square me-2"></i> Edit Agenda
                </h5>
            </div>
            <div class="card-body p-4">
                <!-- Error Messages -->
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

                <form action="<?= base_url('admin/events/update/' . $event['id']) ?>" method="POST">
                    <?= csrf_field() ?>

                    <!-- Title -->
                    <div class="mb-4">
                        <label for="title" class="form-label fw-bold">
                            Judul Agenda <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                            class="form-control form-control-lg"
                            id="title"
                            name="title"
                            placeholder="Contoh: Ujian Tengah Semester MA"
                            value="<?= old('title', $event['title']) ?>"
                            required>
                    </div>

                    <div class="row">
                        <!-- Event Date -->
                        <div class="col-md-6 mb-4">
                            <label for="event_date" class="form-label fw-bold">
                                Tanggal Kegiatan <span class="text-danger">*</span>
                            </label>
                            <input type="date"
                                class="form-control"
                                id="event_date"
                                name="event_date"
                                value="<?= old('event_date', $event['event_date']) ?>"
                                required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Sifat Agenda</label>
                            <div class="d-flex gap-3">
                                <div class="form-check border rounded p-3 flex-fill">
                                    <input class="form-check-input" type="radio" name="scope" id="scopePublic" value="public"
                                        <?= ($event['scope'] ?? 'public') == 'public' ? 'checked' : '' ?>>
                                    <label class="form-check-label w-100" for="scopePublic">
                                        <i class="bi bi-globe text-success me-2"></i><strong>Publik</strong>
                                    </label>
                                </div>
                                <div class="form-check border rounded p-3 flex-fill bg-light">
                                    <input class="form-check-input" type="radio" name="scope" id="scopeInternal" value="internal"
                                        <?= ($event['scope'] ?? 'public') == 'internal' ? 'checked' : '' ?>>
                                    <label class="form-check-label w-100" for="scopeInternal">
                                        <i class="bi bi-lock-fill text-danger me-2"></i><strong>Internal</strong>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <!-- School ID (Optional) -->
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold">Milik</label>
                            <input type="text" class="form-control bg-light"
                                value="<?= empty($event['school_id']) ? 'UMUM / PUSAT' : 'Sekolah' ?>"
                                readonly disabled>
                            <small class="text-muted"><i class="bi bi-lock-fill"></i> Kepemilikan agenda tidak dapat diubah.</small>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Time Start -->
                        <div class="col-md-6 mb-4">
                            <label for="time_start" class="form-label fw-bold">
                                Waktu Mulai (Opsional)
                            </label>
                            <input type="time"
                                class="form-control"
                                id="time_start"
                                name="time_start"
                                value="<?= old('time_start', $event['time_start']) ?>">
                        </div>

                        <!-- Time End -->
                        <div class="col-md-6 mb-4">
                            <label for="time_end" class="form-label fw-bold">
                                Waktu Selesai (Opsional)
                            </label>
                            <input type="time"
                                class="form-control"
                                id="time_end"
                                name="time_end"
                                value="<?= old('time_end', $event['time_end']) ?>">
                        </div>
                    </div>

                    <!-- Location -->
                    <div class="mb-4">
                        <label for="location" class="form-label fw-bold">
                            Lokasi (Opsional)
                        </label>
                        <input type="text"
                            class="form-control"
                            id="location"
                            name="location"
                            placeholder="Contoh: Aula Utama MBS"
                            value="<?= old('location', $event['location']) ?>">
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label for="description" class="form-label fw-bold">
                            Deskripsi (Opsional)
                        </label>
                        <textarea class="form-control"
                            id="description"
                            name="description"
                            rows="5"
                            placeholder="Tambahkan detail tentang agenda ini..."><?= old('description', $event['description']) ?></textarea>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="<?= base_url('admin/events') ?>" class="btn btn-light">
                            <i class="bi bi-x-circle me-2"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-purple">
                            <i class="bi bi-check-circle me-2"></i> Update Agenda
                        </button>
                    </div>
                </form>
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