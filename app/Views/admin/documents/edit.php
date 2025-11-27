<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-purple"><i class="bi bi-pencil-square me-2"></i>Edit Dokumen</h4>
            <a href="<?= base_url('admin/documents') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>

        <?php if (session()->getFlashdata('errors')) : ?>
            <div class="alert alert-danger border-0 shadow-sm">
                <ul class="mb-0">
                    <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="card border-0 shadow-lg rounded-4">
            <div class="card-body p-4 p-md-5">
                <form action="<?= base_url('admin/documents/update/' . $document['id']) ?>" method="POST">
                    <?= csrf_field() ?>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Judul Dokumen <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control form-control-lg" 
                               value="<?= old('title', $document['title']) ?>" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Link File (Google Drive / Dropbox) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-link-45deg"></i></span>
                            <input type="url" name="external_url" class="form-control" 
                                   value="<?= old('external_url', $document['external_url']) ?>" 
                                   placeholder="https://drive.google.com/..." required>
                        </div>
                        <small class="text-muted">
                            <i class="bi bi-check-circle-fill text-success me-1"></i> Link saat ini tersimpan. Ubah jika ingin mengganti file tujuan.
                        </small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold">Kategori <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select" required>
                                <option value="">-- Pilih Kategori --</option>
                                <?php foreach($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>" <?= ($document['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                                        <?= esc($cat['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold">Milik Sekolah</label>
                            <?php if(empty($currentSchoolId)): ?>
                                <select name="school_id" class="form-select">
                                    <option value="">-- Umum / Pusat --</option>
                                    <?php foreach($schools as $s): ?>
                                        <option value="<?= $s['id'] ?>" <?= ($document['school_id'] == $s['id']) ? 'selected' : '' ?>>
                                            <?= esc($s['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            <?php else: ?>
                                <input type="text" class="form-control bg-light" value="Sekolah Anda" readonly disabled>
                                <?php endif; ?>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Deskripsi & Keterangan</label>
                        <textarea id="summernote" name="description"><?= old('description', $document['description']) ?></textarea>
                    </div>

                    <div class="mb-4 p-3 border rounded bg-light d-flex align-items-center">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_public" value="1" id="isPublic" 
                                   <?= ($document['is_public'] == 1) ? 'checked' : '' ?> 
                                   style="width: 3em; height: 1.5em; cursor: pointer;">
                        </div>
                        <div class="ms-3">
                            <label class="form-check-label fw-bold cursor-pointer" for="isPublic">Publikasikan?</label>
                            <small class="d-block text-muted">Jika dimatikan, dokumen akan kembali menjadi draft (tersembunyi).</small>
                        </div>
                    </div>

                    <div class="d-grid mt-5 gap-2">
                        <button type="submit" class="btn btn-warning btn-lg shadow rounded-pill text-white fw-bold">
                            <i class="bi bi-pencil-square me-2"></i> Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .text-purple { color: var(--mbs-purple) !important; }
    .cursor-pointer { cursor: pointer; }
</style>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: 'Deskripsi dokumen...',
            tabsize: 2,
            height: 200,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link']],
                ['view', ['codeview']]
            ]
        });
    });
</script>

<?= $this->endSection() ?>