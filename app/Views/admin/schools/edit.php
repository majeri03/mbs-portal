<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4><i class="bi bi-pencil-square me-2"></i>Edit Jenjang Pendidikan</h4>
    <a href="<?= base_url('admin/schools') ?>" class="btn btn-secondary">
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
        <form action="<?= base_url('admin/schools/update/' . $school['id']) ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="row">
                <!-- Left Column -->
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            Nama Jenjang Sekolah <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                            name="name"
                            class="form-control form-control-lg"
                            value="<?= old('name', $school['name']) ?>"
                            maxlength="25"
                            required>
                        <small class="text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            Maksimal 25 karakter agar tampil rapi di navbar
                        </small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            Deskripsi Lengkap <span class="text-danger">*</span>
                        </label>
                        <textarea name="description"
                            class="form-control"
                            rows="5"
                            required><?= old('description', $school['description']) ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Kontak Person</label>
                            <input type="text"
                                name="contact_person"
                                class="form-control"
                                value="<?= old('contact_person', $school['contact_person']) ?>">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nomor Telepon</label>
                            <input type="text"
                                name="phone"
                                class="form-control"
                                value="<?= old('phone', $school['phone']) ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Website URL</label>
                        <input type="url"
                            name="website_url"
                            class="form-control"
                            value="<?= old('website_url', $school['website_url']) ?>">
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Foto/Logo Saat Ini</label>
                        <div class="border rounded p-2 mb-2 bg-light">
                            <?php if (!empty($school['image_url']) && file_exists($school['image_url'])) : ?>
                                <img src="<?= base_url($school['image_url']) ?>"
                                    class="img-fluid rounded"
                                    alt="Current Image"
                                    style="max-height: 250px;">
                            <?php else : ?>
                                <!-- Placeholder jika tidak ada gambar -->
                                <div class="text-center py-5 text-muted">
                                    <i class="bi bi-image" style="font-size: 3rem;"></i>
                                    <p class="mb-0 mt-2 small">Belum ada foto. Upload foto baru di bawah.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Ganti Foto (Opsional)</label>
                        <input type="file"
                            name="image"
                            class="form-control"
                            accept="image/*"
                            onchange="previewImage(event)">
                        <small class="text-muted">Kosongkan jika tidak ingin mengganti</small>
                    </div>

                    <!-- New Image Preview -->
                    <div id="imagePreview" class="mb-3"></div>

                    <div class="mb-3">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Status Akreditasi</label>
                            <select name="accreditation_status" id="accreditationSelect" class="form-select" onchange="toggleCustomAccreditation()">
                                <option value="A" <?= old('accreditation_status', $school['accreditation_status']) == 'A' ? 'selected' : '' ?>>
                                    ⭐ Terakreditasi A (Unggul)
                                </option>
                                <option value="B" <?= old('accreditation_status', $school['accreditation_status']) == 'B' ? 'selected' : '' ?>>
                                    ⭐ Terakreditasi B (Baik Sekali)
                                </option>
                                <option value="C" <?= old('accreditation_status', $school['accreditation_status']) == 'C' ? 'selected' : '' ?>>
                                    ⭐ Terakreditasi C (Baik)
                                </option>
                                <option value="Belum Terakreditasi" <?= old('accreditation_status', $school['accreditation_status']) == 'Belum Terakreditasi' ? 'selected' : '' ?>>
                                    ⏳ Belum Terakreditasi
                                </option>

                                <?php if (!empty($existing_accreditations)) : ?>
                                    <optgroup label="─── Status Lainnya ───">
                                        <?php foreach ($existing_accreditations as $acc) : ?>
                                            <?php if (!in_array($acc['accreditation_status'], ['A', 'B', 'C', 'Belum Terakreditasi'])) : ?>
                                                <option value="<?= esc($acc['accreditation_status']) ?>"
                                                    <?= old('accreditation_status', $school['accreditation_status']) == $acc['accreditation_status'] ? 'selected' : '' ?>>
                                                    <?= esc($acc['accreditation_status']) ?>
                                                </option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </optgroup>
                                <?php endif; ?>

                                <option value="custom">✏️ Tambah Status Baru (Ketik Manual)</option>
                            </select>
                        </div>

                        <!-- Input Custom Akreditasi -->
                        <div class="mb-3" id="customAccreditationWrapper" style="display: none;">
                            <label class="form-label fw-bold text-primary">
                                <i class="bi bi-pencil-square me-2"></i>Ketik Status Akreditasi Baru
                            </label>
                            <input type="text"
                                name="custom_accreditation"
                                id="customAccreditationInput"
                                class="form-control form-control-lg"
                                placeholder="Contoh: Akreditasi A+ atau Unggul">
                        </div>
                        <label class="form-label fw-bold">Urutan Tampil</label>
                        <input type="number"
                            name="order_position"
                            class="form-control"
                            value="<?= old('order_position', $school['order_position']) ?>"
                            min="1">
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="bi bi-check-circle me-2"></i>Update Data
                        </button>
                        <a href="<?= base_url('admin/schools') ?>" class="btn btn-secondary">
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

    function previewImage(event) {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            document.getElementById('imagePreview').innerHTML =
                '<img src="' + e.target.result + '" class="img-fluid rounded" style="max-height: 250px;">';
        }

        if (file) {
            reader.readAsDataURL(file);
        }
    }

    // Toggle Custom Accreditation Input
    function toggleCustomAccreditation() {
        const select = document.getElementById('accreditationSelect');
        const wrapper = document.getElementById('customAccreditationWrapper');
        const input = document.getElementById('customAccreditationInput');

        if (select.value === 'custom') {
            wrapper.style.display = 'block';
            input.required = true;
            input.focus();
        } else {
            wrapper.style.display = 'none';
            input.required = false;
            input.value = '';
        }
    }

    // Check on page load (jika ada old input)
    document.addEventListener('DOMContentLoaded', function() {
        toggleCustomAccreditation();
    });
</script>
<?= $this->endSection() ?>