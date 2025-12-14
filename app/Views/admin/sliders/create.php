<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4><i class="bi bi-plus-square me-2"></i>Tambah Hero Slider Baru</h4>
    <a href="<?= base_url('admin/sliders') ?>" class="btn btn-secondary">
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
        <form action="<?= base_url('admin/sliders/store') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            
            <div class="row">
                <!-- Left Column -->
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Slider <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control form-control-lg" value="<?= old('title') ?>" placeholder="Contoh: Membangun Generasi Qur'ani" required>
                        <small class="text-muted">Judul utama yang tampil di hero slider</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            Teks Badge 
                            <span class="badge bg-secondary small ms-1">Opsional</span>
                        </label>
                        <input type="text" 
                               name="badge_text" 
                               class="form-control" 
                               value="<?= old('badge_text') ?>" 
                               placeholder="Contoh: PPDB 2025, PENGUMUMAN, PRESTASI">
                        <small class="text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            Kosongkan untuk menggunakan nama site otomatis
                        </small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="4" placeholder="Deskripsi singkat di bawah judul..."><?= old('description') ?></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">
                                Teks Tombol 
                                <span class="badge bg-secondary small ms-1">Opsional</span>
                            </label>
                            <input type="text" 
                                   name="button_text" 
                                   class="form-control" 
                                   value="<?= old('button_text') ?>" 
                                   placeholder="Contoh: Jelajahi Kami">
                            <small class="text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                Kosongkan jika tidak ingin menampilkan tombol
                            </small>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Link Tujuan Tombol</label>
                            <input type="text" 
                                   name="button_link" 
                                   class="form-control" 
                                   value="<?= old('button_link') ?>" 
                                   placeholder="Contoh: #jenjang-sekolah">
                            <small class="text-muted">
                                <i class="bi bi-lightbulb me-1"></i>
                                Contoh: <code>#jenjang-sekolah</code> atau <code>https://ppdb.mbs.sch.id</code>
                            </small>
                        </div>
                    </div>
                </div>
                
                <!-- Right Column -->
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Upload Gambar Hero <span class="text-danger">*</span></label>
                        <input type="file" name="image" class="form-control" accept="image/*" required onchange="previewImage(event)">
                        <small class="text-muted">Maks 3MB | Rekomendasi: 1920x800px</small>
                    </div>
                    
                    <!-- Image Preview -->
                    <div class="mb-3">
                        <div id="imagePreview" class="border rounded p-2 text-center bg-light" style="min-height: 150px; display: flex; align-items: center; justify-content: center;">
                            <span class="text-muted">Preview gambar akan muncul di sini</span>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Urutan Tampil</label>
                        <input type="number" name="order_position" class="form-control" value="<?= old('order_position', 1) ?>" min="1">
                        <small class="text-muted">Angka kecil = tampil lebih dulu</small>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked>
                            <label class="form-check-label fw-bold" for="is_active">
                                Aktifkan Slider Ini
                            </label>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-save me-2"></i>Simpan Slider
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Preview Image Before Upload
    function previewImage(event) {
        const file = event.target.files[0];
        const reader = new FileReader();
        
        reader.onload = function(e) {
            document.getElementById('imagePreview').innerHTML = 
                '<img src="' + e.target.result + '" class="img-fluid rounded" style="max-height: 200px;">';
        }
        
        if (file) {
            reader.readAsDataURL(file);
        }
    }
</script>
<?= $this->endSection() ?>