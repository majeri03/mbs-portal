<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-purple"><i class="bi bi-pencil-square me-2"></i>Edit Halaman</h4>
            <a href="<?= base_url('admin/pages') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>

        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-header bg-warning text-dark p-4">
                <h6 class="mb-0 fw-bold"><i class="bi bi-pencil-fill me-2"></i>Mode Edit: <?= esc($page['title']) ?></h6>
            </div>
            <div class="card-body p-4 bg-white">
                <form action="<?= base_url('admin/pages/update/' . $page['id']) ?>" method="POST">
                    <?= csrf_field() ?>
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark">
                            Kelompok Menu (Navbar)
                            <span class="badge bg-info ms-2">
                                <i class="bi bi-info-circle"></i> Halaman dengan nama menu sama akan dikelompokkan
                            </span>
                        </label>

                        <div class="input-group">
                            <span class="input-group-text bg-white text-purple">
                                <i class="bi bi-menu-button-wide"></i>
                            </span>

                            <input type="text"
                                name="menu_title"
                                id="menuTitleInputEdit"
                                class="form-control"
                                value="<?= old('menu_title', $page['menu_title']) ?>"
                                placeholder="Ketik atau pilih dari dropdown..."
                                required>

                            <button class="btn btn-outline-primary dropdown-toggle"
                                type="button"
                                data-bs-toggle="dropdown">
                                <i class="bi bi-list-ul"></i> Pilih Menu
                            </button>

                            <ul class="dropdown-menu dropdown-menu-end shadow" style="max-height: 300px; overflow-y: auto; min-width: 250px;">
                                <li>
                                    <h6 class="dropdown-header text-purple"><i class="bi bi-folder2-open me-2"></i>Pindah ke Menu Lain:</h6>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>

                                <?php if (!empty($existingMenus)): ?>
                                    <?php foreach ($existingMenus as $menu): ?>
                                        <li>
                                            <button type="button"
                                                class="dropdown-item"
                                                onclick="selectMenu('<?= esc($menu['menu_title'], 'js') ?>')">
                                                <i class="bi bi-arrow-return-right me-2"></i>
                                                <?= esc($menu['menu_title']) ?>

                                                <?php if ($menu['school_id']): ?>
                                                    <span class="badge bg-secondary ms-2" style="font-size: 0.7rem;">
                                                        <?= esc($menu['school_name']) ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-primary ms-2" style="font-size: 0.7rem;">
                                                        Portal Pusat
                                                    </span>
                                                <?php endif; ?>
                                            </button>
                                        </li>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <li><button type="button" class="dropdown-item" onclick="selectMenuEdit('Profil Sekolah')">Profil Sekolah</button></li>
                                    <li><button type="button" class="dropdown-item" onclick="selectMenuEdit('Kesiswaan')">Kesiswaan</button></li>
                                    <li><button type="button" class="dropdown-item" onclick="selectMenuEdit('Akademik')">Akademik</button></li>
                                <?php endif; ?>

                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li class="px-3 py-2 bg-light">
                                    <small class="text-muted">
                                        <i class="bi bi-lightbulb"></i> Atau ketik manual untuk membuat menu baru
                                    </small>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <script>
                        function selectMenuEdit(value) {
                            document.getElementById('menuTitleInputEdit').value = value;
                        }
                    </script>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark">Judul Halaman</label>
                        <input type="text" name="title" class="form-control form-control-lg bg-light" value="<?= esc($page['title']) ?>" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark">Isi Konten</label>
                        <textarea id="summernote" name="content" required><?= esc($page['content']) ?></textarea>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark">Milik Sekolah</label>
                            <?php if (empty($currentSchoolId)) : ?>
                                <select name="school_id" id="schoolSelectEdit" class="form-select" onchange="toggleFeaturedOptionEdit()">
                                    <option value="">-- Web Utama / Yayasan --</option>
                                    <?php foreach ($schools as $s) : ?>
                                        <option value="<?= $s['id'] ?>" <?= ($page['school_id'] == $s['id']) ? 'selected' : '' ?>>
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
                                <input type="hidden" name="school_id" id="schoolSelectEdit" value="<?= $currentSchoolId ?>">
                                <small class="text-success fw-bold"><i class="bi bi-check-circle-fill"></i> Milik <?= esc($schoolName) ?></small>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-6">
                            <!-- Opsi Tampilan - Dinamis berdasarkan dropdown -->
                            <div id="featuredOptionDivEdit">
                                <label class="form-label fw-bold text-dark">Opsi Tampilan</label>
                                <div class="p-3 border rounded bg-light d-flex align-items-start">
                                    <div class="form-check form-switch me-3">
                                        <input class="form-check-input" type="checkbox" style="width: 3em; height: 1.5em; cursor: pointer;" name="is_featured" value="1" id="isFeatured" <?= (isset($page) && $page['is_featured'] == 1) ? 'checked' : '' ?>>
                                    </div>

                                    <div>
                                        <label class="form-check-label fw-bold text-purple cursor-pointer mb-1" for="isFeatured" style="font-size: 1rem;">
                                            Tampilkan di Landing Page?
                                        </label>
                                        <small class="d-block text-muted lh-sm">
                                            Aktifkan ini untuk menjadikan halaman ini sebagai <strong>Konten Utama (Profil/Tentang Kami)</strong> di halaman depan sekolah.
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <!-- Info untuk Web Utama -->
                            <div id="mainWebInfoDivEdit" style="display: none;">
                                <div class="alert alert-info mb-0">
                                    <i class="bi bi-info-circle me-2"></i>
                                    <strong>Info:</strong> Halaman web utama/yayasan tidak ditampilkan di landing page. Akses melalui menu navigasi.
                                </div>
                                <input type="hidden" name="is_featured" value="0">
                            </div>
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-5">
                        <button type="submit" class="btn btn-success btn-lg px-5 rounded-pill shadow-sm">
                            <i class="bi bi-check-circle me-2"></i>Update Halaman
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
    // Toggle Featured Option berdasarkan dropdown sekolah
    function toggleFeaturedOptionEdit() {
        const schoolSelect = document.getElementById('schoolSelectEdit');
        const featuredDiv = document.getElementById('featuredOptionDivEdit');
        const mainWebInfoDiv = document.getElementById('mainWebInfoDivEdit');

        if (schoolSelect.value === '') {
            // Web Utama dipilih - hide checkbox, show info
            featuredDiv.style.display = 'none';
            mainWebInfoDiv.style.display = 'block';
        } else {
            // Sekolah dipilih - show checkbox, hide info
            featuredDiv.style.display = 'block';
            mainWebInfoDiv.style.display = 'none';
        }
    }

    // Jalankan saat halaman load
    document.addEventListener('DOMContentLoaded', function() {
        toggleFeaturedOptionEdit();
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