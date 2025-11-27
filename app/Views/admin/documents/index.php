<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold text-purple"><i class="bi bi-file-earmark-text-fill me-2"></i>Kelola Dokumen</h4>
        <p class="text-muted mb-0 small">Manajemen file download dan arsip digital.</p>
    </div>
    <a href="<?= base_url('admin/documents/create') ?>" class="btn btn-purple shadow-sm">
        <i class="bi bi-cloud-upload me-2"></i>Upload Dokumen
    </a>
</div>
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-3 bg-light rounded-3">
        <form action="" method="get" class="row g-2 align-items-center">
            
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" name="keyword" class="form-control border-start-0 ps-0" 
                           placeholder="Cari judul dokumen..." 
                           value="<?= esc(request()->getGet('keyword')) ?>">
                </div>
            </div>

            <div class="col-md-4">
                <select name="category_id" class="form-select">
                    <option value="">-- Semua Kategori --</option>
                    <?php foreach ($categories as $cat) : ?>
                        <option value="<?= $cat['id'] ?>" <?= (request()->getGet('category_id') == $cat['id']) ? 'selected' : '' ?>>
                            <?= esc($cat['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-fill">
                    Cari
                </button>
                
                <?php if(request()->getGet('keyword') || request()->getGet('category_id')): ?>
                    <a href="<?= base_url('admin/documents') ?>" class="btn btn-outline-secondary" title="Reset Filter">
                        <i class="bi bi-x-lg"></i>
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>
<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3 text-secondary" width="5%">No</th>
                        <th class="px-4 py-3 text-secondary">Judul Dokumen</th>
                        <th class="px-4 py-3 text-secondary">Kategori</th>
                        <th class="px-4 py-3 text-secondary">Milik Sekolah</th>
                        <th class="px-4 py-3 text-secondary text-center">Status</th>
                        <th class="px-4 py-3 text-secondary text-center" width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($documents)) : ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="bi bi-folder2-open fs-1 mb-2 opacity-50"></i>
                                    <p>Belum ada dokumen yang diupload.</p>
                                </div>
                            </td>
                        </tr>
                    <?php else : ?>
                        <?php $no = 1; foreach ($documents as $doc) : ?>
                            <?php 
                                // Icon Helper
                                $icon = match($doc['file_type']) {
                                    'pdf' => 'bi-file-pdf-fill text-danger',
                                    'word' => 'bi-file-word-fill text-primary',
                                    'excel' => 'bi-file-excel-fill text-success',
                                    'gdrive' => 'bi-google text-warning',
                                    default => 'bi-file-earmark-text-fill text-secondary'
                                };
                            ?>
                            <tr>
                                <td class="px-4"><?= $no++ ?></td>
                                <td class="px-4">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi <?= $icon ?> fs-5"></i>
                                        <div>
                                            <span class="fw-bold text-dark d-block"><?= esc($doc['title']) ?></span>
                                            <small class="text-muted">
                                                <i class="bi bi-calendar3 me-1"></i> <?= date('d M Y', strtotime($doc['created_at'])) ?>
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4">
                                    <span class="badge bg-light text-dark border"><?= esc($doc['category_name'] ?? '-') ?></span>
                                </td>
                                <td class="px-4">
                                    <?php if(empty($doc['school_id'])): ?>
                                        <span class="badge bg-secondary">Umum / Pusat</span>
                                    <?php else: ?>
                                        <span class="badge bg-info text-dark"><?= esc($doc['school_name']) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 text-center">
                                    <?php if($doc['is_public']): ?>
                                        <span class="badge bg-success bg-opacity-10 text-success px-2 py-1 rounded-pill">
                                            <i class="bi bi-check-circle-fill me-1"></i>Publik
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-warning bg-opacity-10 text-warning px-2 py-1 rounded-pill">
                                            <i class="bi bi-eye-slash-fill me-1"></i>Draft
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 text-center">
                                    <div class="btn-group">
                                        <a href="<?= esc($doc['external_url']) ?>" target="_blank" class="btn btn-sm btn-outline-secondary" title="Cek Link">
                                            <i class="bi bi-link-45deg"></i>
                                        </a>
                                        <a href="<?= base_url('admin/documents/edit/' . $doc['id']) ?>" class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="<?= base_url('admin/documents/delete/' . $doc['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin hapus dokumen ini?')" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .text-purple { color: var(--mbs-purple) !important; }
    .btn-purple { background-color: var(--mbs-purple); color: white; border: none; }
    .btn-purple:hover { background-color: #3D1F5C; color: white; }
</style>

<?= $this->endSection() ?>