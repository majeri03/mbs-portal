<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4><i class="bi bi-pencil-square me-2"></i>Edit Berita</h4>
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
        <form action="<?= base_url('admin/posts/update/' . $post['id']) ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Berita <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="<?= old('title', $post['title']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Penulis</label>
                        <input type="text" name="author" class="form-control" value="<?= old('author', $post['author']) ?>" placeholder="Nama Penulis">
                        <small class="text-muted">Kosongkan jika ingin otomatis dari user login</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Konten Berita <span class="text-danger">*</span></label>
                        <textarea name="content" id="content" class="form-control" rows="15" required><?= old('content', $post['content']) ?></textarea>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Jenjang Sekolah</label>

                        <?php if (session('school_id')): ?>
                            <!-- Admin Sekolah: Readonly -->
                            <input type="text" class="form-control" value="<?= esc($schools[0]['name'] ?? 'Sekolah Anda') ?>" readonly>
                            <input type="hidden" name="school_id" value="<?= session('school_id') ?>">
                            <small class="text-muted">
                                <i class="bi bi-lock-fill"></i> Berita terkait sekolah Anda.
                            </small>
                        <?php else: ?>
                            <!-- Superadmin: Bisa pilih -->
                            <select name="school_id" class="form-select">
                                <option value="">Berita Umum (Portal Pusat)</option>
                                <?php foreach ($schools as $school) : ?>
                                    <option value="<?= $school['id'] ?>" <?= $post['school_id'] == $school['id'] ? 'selected' : '' ?>>
                                        <?= esc($school['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Thumbnail Saat Ini</label>
                        <?php if ($post['thumbnail']) : ?>
                            <div class="mb-2">
                                <img src="<?= base_url($post['thumbnail']) ?>" class="img-thumbnail" style="max-height: 150px;">
                            </div>
                        <?php else : ?>
                            <div class="alert alert-warning small">Belum ada thumbnail</div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Ganti Thumbnail</label>
                        <input type="file" name="thumbnail" class="form-control" accept="image/*">
                        <small class="text-muted">Kosongkan jika tidak ingin mengganti</small>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="bi bi-check-circle me-2"></i>Update Berita
                        </button>
                        <a href="<?= base_url('admin/posts') ?>" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-2"></i>Batal
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>