<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>Tambah Pimpinan Baru</h4>
            <a href="<?= base_url('admin/teachers') ?>" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="<?= base_url('admin/teachers/store') ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <?php if (!session('school_id')) : ?>
                        <div class="mb-3 p-3 bg-light border rounded">
                            <label class="form-label fw-bold text-primary">Tempat Tugas / Sekolah</label>
                            <select name="school_id" class="form-select">
                                <option value="">-- Pimpinan Pusat / Yayasan (Umum) --</option>
                                <?php foreach ($schools as $s) : ?>
                                    <option value="<?= $s['id'] ?>">
                                        <?= esc($s['name']) ?> (<?= esc($s['slug']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-muted">
                                <i class="bi bi-info-circle"></i>
                                Jika dipilih <strong>MTs, MA, SMK</strong>, data ini akan otomatis muncul di Admin masing-masing.
                                Jika <strong>Pusat</strong>, hanya muncul di sini dan Web Utama.
                            </small>
                        </div>
                    <?php endif; ?>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Lengkap & Gelar</label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: KH. Ahmad Dahlan, Lc." required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Jabatan</label>
                        <input type="text" name="position" class="form-control" placeholder="Contoh: Mudir / Direktur" required>
                    </div>

                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label fw-bold">Upload Foto (Opsional)</label>
                            <input type="file" name="photo" class="form-control" accept="image/*">
                            <small class="text-muted">Kosongkan untuk menggunakan avatar default (inisial nama).</small>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Urutan Tampil</label>
                            <input type="number" name="order_position" class="form-control" value="99">
                        </div>
                    </div>
                    <div class="mb-4 p-3 border rounded bg-light">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_leader" value="1" id="isLeaderSwitch">
                            <label class="form-check-label fw-bold text-purple" for="isLeaderSwitch">
                                Jadikan Kepala Sekolah / Pimpinan?
                            </label>
                        </div>

                        <div id="hiddenInputContainer"></div>

                        <small class="text-muted d-block mt-1" id="leaderHelpText">
                            Centang jika ini adalah Pimpinan (Direktur/Kepala Sekolah).
                        </small>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-save me-2"></i> Simpan Data
                    </button>

                </form>
            </div>
        </div>
    </div>
</div>

<?php if (!session('school_id')) : ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const schoolSelect = document.querySelector('select[name="school_id"]');
            const leaderSwitch = document.getElementById('isLeaderSwitch');
            const hiddenContainer = document.getElementById('hiddenInputContainer');
            const helpText = document.getElementById('leaderHelpText');

            function checkLogic() {
                if (schoolSelect.value === "") {
                    // === KASUS 1: PUSAT/UMUM ===
                    // 1. Paksa ON
                    leaderSwitch.checked = true;

                    // 2. KUNCI (Disable) agar tidak bisa di-klik user
                    leaderSwitch.disabled = true;

                    // 3. Buat Input Rahasia (Karena disabled tidak terkirim ke server)
                    // Kita paksa kirim nilai '1' lewat input hidden ini
                    hiddenContainer.innerHTML = '<input type="hidden" name="is_leader" value="1">';

                    // 4. Ubah pesan bantuan
                    helpText.innerHTML = '<span class="text-success fw-bold"><i class="bi bi-lock-fill"></i> Terkunci: Pimpinan Pusat wajib tampil di Web Utama.</span>';

                } else {
                    // === KASUS 2: SEKOLAH (MTs/MA/SMK) ===
                    // 1. Buka Kunci (Enable)
                    if (leaderSwitch.disabled) {
                        leaderSwitch.checked = false;
                    }
                    leaderSwitch.disabled = false;

                    // 2. Hapus Input Rahasia (Biar ikut nilai checkbox asli)
                    hiddenContainer.innerHTML = '';

                    // 3. Default-kan ke OFF (Guru Biasa) - Tapi user BISA ubah manual
                    // (Hanya reset ke false jika sebelumnya terkunci/disabled, biar ga ganggu edit manual user)

                    // 4. Kembalikan pesan normal
                    helpText.innerHTML = 'Centang manual jika ini adalah Kepala Sekolah. Biarkan mati untuk Guru Biasa.';
                }
            }

            // Jalankan saat dropdown berubah
            schoolSelect.addEventListener('change', checkLogic);

            // Jalankan saat pertama kali load
            checkLogic();
        });
    </script>
<?php endif; ?>
</form>
</div>
</div>
</div>
</div>
<?= $this->endSection() ?>