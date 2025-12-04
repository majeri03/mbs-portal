<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold text-purple"><i class="bi bi-tags-fill me-2"></i>Kategori Dokumen</h4>
        <p class="text-muted mb-0 small">Kelola pengelompokan jenis dokumen.</p>
    </div>
    <button type="button" class="btn btn-purple shadow-sm" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
        <i class="bi bi-plus-lg me-2"></i>Tambah Kategori
    </button>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= session()->getFlashdata('error') ?>
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
                        <th class="px-4 py-3 text-secondary">Nama Kategori</th>
                        <th class="px-4 py-3 text-secondary">Slug</th>
                        <th class="px-4 py-3 text-secondary">Milik Sekolah</th>
                        <th class="px-4 py-3 text-secondary text-center" width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($categories)) : ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="bi bi-folder-x fs-1 mb-2 opacity-50"></i>
                                    <p>Belum ada kategori dokumen.</p>
                                </div>
                            </td>
                        </tr>
                    <?php else : ?>
                        <?php $no = 1; foreach ($categories as $cat) : ?>
                        <tr>
                            <td class="px-4"><?= $no++ ?></td>
                            <td class="px-4 fw-bold text-dark"><?= esc($cat['name']) ?></td>
                            <td class="px-4 text-muted small"><code><?= esc($cat['slug']) ?></code></td>
                            <td class="px-4">
                                <?php if(empty($cat['school_id'])): ?>
                                    <span class="badge bg-secondary">Umum / Pusat</span>
                                <?php else: ?>
                                    <span class="badge bg-info text-dark"><?= esc($cat['school_name']) ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-warning" 
                                            onclick="editCategory('<?= $cat['id'] ?>', '<?= esc($cat['name']) ?>')">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <a href="<?= base_url('admin/document-categories/delete/' . $cat['id']) ?>" 
                                       class="btn btn-sm btn-outline-danger" 
                                       onclick="return confirm('Hapus kategori ini? Semua dokumen di dalamnya mungkin akan kehilangan kategori.')">
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

<div class="modal fade" id="addCategoryModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-purple text-white">
                <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle me-2"></i>Tambah Kategori</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('admin/document-categories/store') ?>" method="POST">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Kategori</label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: Akademik, Keuangan" required>
                    </div>
                    
                    <?php if(empty($currentSchoolId)): ?>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Milik Sekolah</label>
                            <select name="school_id" class="form-select">
                                <option value="">-- Umum / Pusat --</option>
                                <?php foreach($schools as $s): ?>
                                    <option value="<?= $s['id'] ?>"><?= esc($s['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-purple">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editCategoryModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i>Edit Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm" method="POST">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Kategori</label>
                        <input type="text" name="name" id="editName" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function editCategory(id, name) {
        document.getElementById('editName').value = name;
        document.getElementById('editForm').action = '<?= base_url('admin/document-categories/update/') ?>' + id;
        new bootstrap.Modal(document.getElementById('editCategoryModal')).show();
    }
</script>

<style>
    .bg-purple { background-color: var(--mbs-purple) !important; }
    .text-purple { color: var(--mbs-purple) !important; }
    .btn-purple { background-color: var(--mbs-purple); color: white; border: none; }
    .btn-purple:hover { background-color: #1a253a; color: white; }
</style>

<?= $this->endSection() ?>