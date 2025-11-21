<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4><i class="bi bi-pencil-square me-2"></i>Edit Hero Slider</h4>
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
        <form action="<?= base_url('admin/sliders/update/' . $slider['id']) ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            
            <div class="row">
                <!-- Left Column -->
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Slider <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control form-control-lg" value="<?= old('title', $slider['title']) ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="4"><?= old('description', $slider['description']) ?></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Teks Tombol</label>
                            <input type="text" name="button_text" class="form-control" value="<?= old('button_text', $slider['button_text']) ?>">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Link Tombol</label>
                            <input type="text" name="button_link" class="form-control" value="<?= old('button_link', $slider['button_link']) ?>">
                        </div>
                    </div>
                </div>
                
                <!-- Right Column -->
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Gambar Saat Ini</label>
                        <div class="border rounded p-2 mb-2">
                            <img src="<?= base_url($slider['image_url']) ?>" class="img-fluid rounded" alt="Current Slider">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Ganti Gambar (Opsional)</label>
                        <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(event)">
                        <small class="text-muted">Kosongkan jika tidak ingin mengganti</small>
                    </div>
                    
                    <!-- New Image Preview -->
                    <div id="imagePreview" class="mb-3"></div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Urutan Tampil</label>
                        <input type="number" name="order_position" class="form-control" value="<?= old('order_position', $slider['order_position']) ?>" min="1">
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" <?= $slider['is_active'] ? 'checked' : '' ?>>
                            <label class="form-check-label fw-bold" for="is_active">
                                Aktifkan Slider Ini
                            </label>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="bi bi-check-circle me-2"></i>Update Slider
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
    function previewImage(event) {
        const file = event.target.files[0];
        const reader = new FileReader();
        
        reader.onload = function(e) {
            document.getElementById('imagePreview').innerHTML = 
                '<div class="border rounded p-2"><img src="' + e.target.result + '" class="img-fluid rounded"></div>';
        }
        
        if (file) {
            reader.readAsDataURL(file);
        }
    }
</script>
<?= $this->endSection() ?>