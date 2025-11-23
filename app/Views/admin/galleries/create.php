<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>
<div class="card border-0 shadow-sm col-lg-8 mx-auto">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0">Upload Foto Baru</h5>
    </div>
    <div class="card-body p-4">
        <form action="<?= base_url('admin/galleries/store') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label fw-bold">Judul Foto / Caption</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Kategori</label>
                    <select name="category" class="form-select">
                        <option value="kegiatan">Kegiatan Santri</option>
                        <option value="fasilitas">Fasilitas</option>
                        <option value="prestasi">Prestasi</option>
                        <option value="asrama">Asrama</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Milik Sekolah (Opsional)</label>
                    <select name="school_id" class="form-select">
                        <option value="">-- Semua / Umum --</option>
                        <?php foreach ($schools as $s) : ?>
                            <option value="<?= $s['id'] ?>"><?= $s['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label fw-bold">File Foto</label>
                <input type="file" name="image" class="form-control" accept="image/*" required>
            </div>
            <div class="d-flex justify-content-end gap-2">
                <a href="<?= base_url('admin/galleries') ?>" class="btn btn-secondary">Batal</a>
                <button type="button" class="btn btn-primary" onclick="this.form.submit()">Upload</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>