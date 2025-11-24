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
                        <small class="text-muted d-block mt-1">
                            Jika diaktifkan, foto akan tampil besar paling atas (terpisah dari slider guru).
                        </small>
                    </div>
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-save me-2"></i> Simpan Data</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>