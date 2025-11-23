<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-purple"><i class="bi bi-file-earmark-plus me-2"></i>Buat Halaman Baru</h4>
            <a href="<?= base_url('admin/pages') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>

        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-header bg-purple text-white p-4" style="background: linear-gradient(135deg, var(--mbs-purple) 0%, var(--mbs-purple-dark) 100%);">
                <h6 class="mb-0"><i class="bi bi-pencil-fill me-2"></i>Editor Konten</h6>
            </div>
            <div class="card-body p-4 bg-white">
                <form action="<?= base_url('admin/pages/store') ?>" method="POST">
                    <?= csrf_field() ?>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark">Judul Halaman <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="title" 
                               class="form-control form-control-lg bg-light border-0" 
                               placeholder="Contoh: Sejarah Berdiri, Fasilitas Asrama" 
                               required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark">Isi Konten <span class="text-danger">*</span></label>
                        <div class="alert alert-info small border-0 bg-info-subtle text-info-emphasis">
                            <i class="bi bi-info-circle me-1"></i> 
                            Anda bisa menempelkan (paste) teks dan gambar langsung di kotak di bawah ini.
                        </div>
                        <textarea id="summernote" name="content" required></textarea>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-5">
                        <button type="submit" class="btn btn-primary btn-lg px-5 rounded-pill shadow-sm" style="background-color: var(--mbs-purple); border-color: var(--mbs-purple);">
                            <i class="bi bi-save me-2"></i>Simpan Halaman
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: 'Tulis konten halaman di sini... Silakan tempel gambar atau teks.',
            tabsize: 2,
            height: 500,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            callbacks: {
                // FITUR CANGGIH: Kompresi Gambar Otomatis saat Upload/Drag
                onImageUpload: function(files) {
                    for (let i = 0; i < files.length; i++) {
                        compressImage(files[i], function(compressedBase64) {
                            // Masukkan gambar yang SUDAH dikompres ke editor
                            $('#summernote').summernote('insertImage', compressedBase64);
                        });
                    }
                }
            }
        });
        
        // Style Fix
        $('.note-editable').css('background-color', '#fff').css('color', '#333');
        $('.note-toolbar').css('background-color', '#f8f9fa');
    });

    /**
     * Fungsi untuk Mengompres Gambar di Browser
     * @param {File} file - File gambar asli
     * @param {Function} callback - Fungsi yang dijalankan setelah kompresi selesai
     */
    function compressImage(file, callback) {
        const reader = new FileReader();
        reader.readAsDataURL(file);
        
        reader.onload = function(event) {
            const img = new Image();
            img.src = event.target.result;
            
            img.onload = function() {
                // Tentukan ukuran maksimal (misal: lebar 800px)
                const maxWidth = 800;
                let width = img.width;
                let height = img.height;

                // Hitung rasio aspek baru jika gambar terlalu besar
                if (width > maxWidth) {
                    height = Math.round((height * maxWidth) / width);
                    width = maxWidth;
                }

                // Buat Canvas untuk menggambar ulang (Resize)
                const canvas = document.createElement('canvas');
                canvas.width = width;
                canvas.height = height;
                
                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0, width, height);

                // Konversi ke Base64 dengan Kualitas JPEG 70% (Kompresi)
                // 'image/jpeg' membuat ukuran jauh lebih kecil daripada 'image/png'
                const compressedDataUrl = canvas.toDataURL('image/jpeg', 0.7);
                
                callback(compressedDataUrl);
            }
        }
    }
</script>
<?= $this->endSection() ?>