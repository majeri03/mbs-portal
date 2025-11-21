<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4><i class="bi bi-file-earmark-plus me-2"></i>Tambah Berita Baru</h4>
    <a href="<?= base_url('admin/posts') ?>" class="btn btn-secondary">
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
        <form action="<?= base_url('admin/posts/store') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Berita <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="<?= old('title') ?>" required>
                    </div>
                     <div class="mb-3">
                        <label class="form-label fw-bold">Penulis</label>
                        <input type="text" name="author" class="form-control" value="<?= old('author', session()->get('full_name')) ?>" placeholder="Nama Penulis">
                        <small class="text-muted">Default: <?= session()->get('full_name') ?></small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Konten Berita <span class="text-danger">*</span></label>
                        <textarea name="content" id="content" class="form-control" rows="15" required><?= old('content') ?></textarea>
                        <small class="text-muted">Minimal 50 karakter</small>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Jenjang Sekolah</label>
                        <select name="school_id" class="form-select">
                            <option value="">Berita Umum</option>
                            <?php foreach ($schools as $school) : ?>
                                <option value="<?= $school['id'] ?>"><?= esc($school['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Thumbnail <span class="text-danger">*</span></label>
                        <input type="file" name="thumbnail" class="form-control" accept="image/*" required>
                        <small class="text-muted">Maks 2MB (JPG, PNG)</small>
                    </div>
                    
                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-save me-2"></i>Simpan Berita
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>