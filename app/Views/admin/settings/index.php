<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4><i class="bi bi-gear-fill me-2 text-purple"></i>Pengaturan Website</h4>
</div>

<form action="<?= base_url('admin/settings/update') ?>" method="POST" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="list-group shadow-sm">
                <a href="#general" class="list-group-item list-group-item-action active" data-bs-toggle="list">
                    <i class="bi bi-globe me-2"></i> Identitas Web
                </a>
                <a href="#profile" class="list-group-item list-group-item-action" data-bs-toggle="list">
                    <i class="bi bi-person-video2 me-2"></i> Profil & Sambutan
                </a>
                <a href="#contact" class="list-group-item list-group-item-action" data-bs-toggle="list">
                    <i class="bi bi-envelope-paper me-2"></i> Kontak & Sosmed
                </a>
                <a href="#branding" class="list-group-item list-group-item-action" data-bs-toggle="list">
                    <i class="bi bi-images me-2"></i> Logo & Branding
                </a>
            </div>
        </div>

        <div class="col-md-9">
            <div class="tab-content">

                <div class="tab-pane fade show active" id="general">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3">
                            <h6 class="mb-0 fw-bold">Identitas Website</h6>
                        </div>
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <label class="form-label">Nama Website / Sekolah</label>
                                <input type="text" name="site_name" class="form-control" value="<?= esc($settings['site_name'] ?? '') ?>" maxlength="25">
<small class="text-muted"><i class="bi bi-info-circle"></i> Maksimal 25 karakter agar rapi di navbar</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Deskripsi Singkat (Footer)</label>
                                <textarea name="site_desc" class="form-control" rows="3"><?= esc($settings['site_desc'] ?? '') ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="profile">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3">
                            <h6 class="mb-0 fw-bold">Sambutan & Video Profil</h6>
                        </div>
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Judul Bagian (Headline)</label>
                                <input type="text" name="profile_title" class="form-control"
                                    value="<?= esc($settings['profile_title'] ?? 'Mendidik dengan Hati, Mengabdi untuk Negeri.') ?>">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Isi Sambutan / Quotes</label>
                                <textarea name="profile_description" class="form-control" rows="4"><?= esc($settings['profile_description'] ?? '') ?></textarea>
                                <small class="text-muted">Kata-kata mutiara atau sambutan singkat.</small>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Nama Pimpinan/Direktur</label>
                                    <input type="text" name="director_name" class="form-control"
                                        value="<?= esc($settings['director_name'] ?? 'Ustadz Fulan, Lc.') ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Jabatan</label>
                                    <input type="text" name="director_label" class="form-control"
                                        value="<?= esc($settings['director_label'] ?? 'Direktur Pesantren') ?>">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Foto Direktur</label>
                                <div class="d-flex align-items-center gap-3">
                                    <?php if (!empty($settings['director_photo'])): ?>
                                        <img src="<?= base_url($settings['director_photo']) ?>" class="rounded-circle" width="60" height="60" style="object-fit:cover;">
                                    <?php endif; ?>
                                    <input type="file" name="director_photo" class="form-control" accept="image/*">
                                </div>
                            </div>

                            <hr>

                            <div class="mb-3">
                                <label class="form-label fw-bold text-danger"><i class="bi bi-youtube me-2"></i>Link Video Profil (YouTube)</label>
                                <input type="text" name="profile_video_url" class="form-control"
                                    value="<?= esc($settings['profile_video_url'] ?? '') ?>"
                                    placeholder="Contoh: https://www.youtube.com/watch?v=AbCdEfGh">
                                <small class="text-muted">Masukkan link lengkap YouTube.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="contact">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3">
                            <h6 class="mb-0 fw-bold">Kontak, Sosmed & Lokasi</h6>
                        </div>
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Email Resmi</label>
                                    <input type="email" name="email" class="form-control" value="<?= esc($settings['email'] ?? '') ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">No. Telepon / WhatsApp</label>
                                    <input type="text" name="phone" class="form-control" value="<?= esc($settings['phone'] ?? '') ?>">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Alamat Lengkap</label>
                                <textarea name="address" class="form-control" rows="2"><?= esc($settings['address'] ?? '') ?></textarea>
                            </div>

                            <hr>

                            <div class="mb-3">
                                <label class="form-label fw-bold"><i class="bi bi-map text-primary me-2"></i>Link Google Maps Embed</label>
                                <textarea name="maps_embed_url" class="form-control" rows="3" placeholder='<iframe src="https://www.google.com/maps/embed?..."></iframe>'><?= esc($settings['maps_embed_url'] ?? '') ?></textarea>
                                <small class="text-muted">
                                    Cara ambil: Buka Google Maps -> Cari Lokasi -> Klik "Bagikan" -> Pilih "Sematkan Peta" -> Copy HTML.
                                </small>
                            </div>

                            <hr>

                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-facebook text-primary"></i> Facebook URL</label>
                                <input type="text" name="facebook_url" class="form-control" value="<?= esc($settings['facebook_url'] ?? '') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-instagram text-danger"></i> Instagram URL</label>
                                <input type="text" name="instagram_url" class="form-control" value="<?= esc($settings['instagram_url'] ?? '') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-youtube text-danger"></i> Youtube Channel URL</label>
                                <input type="text" name="youtube_url" class="form-control" value="<?= esc($settings['youtube_url'] ?? '') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-tiktok text-dark"></i> TikTok URL</label>
                                <input type="text" name="tiktok_url" class="form-control" value="<?= esc($settings['tiktok_url'] ?? '') ?>" placeholder="https://www.tiktok.com/@mbs.official">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="branding">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3">
                            <h6 class="mb-0 fw-bold">Pengaturan Logo</h6>
                        </div>
                        <div class="card-body p-4">

                            <div class="mb-4 border-bottom pb-4">
                                <label class="form-label fw-bold text-purple">1. Logo Utama (Navbar)</label>
                                <div class="d-flex align-items-center gap-4">
                                    <div class="border p-2 rounded bg-light text-center" style="width: 100px; height: 100px;">
                                        <?php if (!empty($settings['site_logo'])): ?>
                                            <img src="<?= base_url($settings['site_logo']) ?>" class="w-100 h-100 object-fit-contain">
                                        <?php else: ?>
                                            <span class="text-muted small d-block mt-4">No Logo</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex-grow-1">
                                        <input type="file" name="site_logo" class="form-control mb-1" accept="image/*">
                                        <small class="text-muted">Format: PNG (Transparan) / JPG. Rekomendasi Tinggi: 50px.</small>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4 border-bottom pb-4">
                                <label class="form-label fw-bold">2. Logo Pendukung 1 (Footer)</label>
                                <div class="d-flex align-items-center gap-4">
                                    <div class="border p-2 rounded bg-light text-center" style="width: 80px; height: 80px;">
                                        <?php if (!empty($settings['site_logo_2'])): ?>
                                            <img src="<?= base_url($settings['site_logo_2']) ?>" class="w-100 h-100 object-fit-contain">
                                        <?php else: ?>
                                            <span class="text-muted small d-block mt-3">Kosong</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex-grow-1">
                                        <input type="file" name="site_logo_2" class="form-control" accept="image/*">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-2">
                                <label class="form-label fw-bold">3. Logo Pendukung 2 (Footer)</label>
                                <div class="d-flex align-items-center gap-4">
                                    <div class="border p-2 rounded bg-light text-center" style="width: 80px; height: 80px;">
                                        <?php if (!empty($settings['site_logo_3'])): ?>
                                            <img src="<?= base_url($settings['site_logo_3']) ?>" class="w-100 h-100 object-fit-contain">
                                        <?php else: ?>
                                            <span class="text-muted small d-block mt-3">Kosong</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex-grow-1">
                                        <input type="file" name="site_logo_3" class="form-control" accept="image/*">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 d-grid">
                <button type="submit" class="btn btn-primary btn-lg shadow">
                    <i class="bi bi-save me-2"></i>Simpan Semua Pengaturan
                </button>
            </div>
        </div>
    </div>
</form>

<?= $this->endSection() ?>