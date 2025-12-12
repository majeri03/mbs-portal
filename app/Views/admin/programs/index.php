<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold text-purple"><i class="bi bi-trophy-fill me-2"></i>Program Unggulan</h4>
        <p class="text-muted mb-0 small">Kelola kartu program pendidikan yang tampil di halaman depan.</p>
    </div>
    <?php if (session('school_id')) : ?>
        <a href="<?= base_url('admin/programs/create') ?>" class="btn btn-purple shadow-sm">
            <i class="bi bi-plus-lg me-2"></i>Tambah Program
        </a>
    <?php else : ?>
        <button class="btn btn-secondary opacity-50" disabled title="Login sebagai Admin Sekolah untuk menambah">
            <i class="bi bi-lock-fill me-2"></i>Tambah Terkunci
        </button>
    <?php endif; ?>
</div>
<?php if (!session('school_id')) : ?>
    <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center mb-4" role="alert">
        <i class="bi bi-info-circle-fill fs-4 me-3"></i>
        <div>
            <strong>Mode Superadmin:</strong> Anda hanya dapat melihat, mengedit, atau menghapus program yang telah dibuat oleh Admin Sekolah masing-masing. Anda tidak dapat membuat program baru dari sini.
        </div>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3 text-secondary" width="5%">No</th>
                        <th class="px-4 py-3 text-secondary" width="10%">Icon</th>
                        <th class="px-4 py-3 text-secondary" width="25%">Nama Program</th>
                        <th class="px-4 py-3 text-secondary">Deskripsi Singkat</th>
                        <th class="px-4 py-3 text-secondary text-center" width="10%">Urutan</th>
                        <th class="px-4 py-3 text-secondary text-center" width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($programs)) : ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="bi bi-folder-x fs-1 mb-2 opacity-50"></i>
                                    <p>Belum ada program pendidikan.</p>
                                </div>
                            </td>
                        </tr>
                    <?php else : ?>
                        <?php $no = 1; foreach ($programs as $p) : ?>
                        <tr>
                            <td class="px-4"><?= $no++ ?></td>
                            <td class="px-4">
                                <div class="icon-preview-sm bg-purple-light text-purple rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi <?= esc($p['icon']) ?>"></i>
                                </div>
                            </td>
                            <td class="px-4 fw-bold text-dark"><?= esc($p['title']) ?></td>
                            <td class="px-4 text-muted small text-truncate" style="max-width: 250px;">
                                <?= esc($p['description']) ?>
                            </td>
                            <td class="px-4 text-center">
                                <span class="badge bg-light text-dark border">#<?= esc($p['order_position']) ?></span>
                            </td>
                            <td class="px-4 text-center">
                                <div class="btn-group">
                                    <a href="<?= base_url('admin/programs/edit/' . $p['id']) ?>" class="btn btn-sm btn-outline-purple" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="<?= base_url('admin/programs/delete/' . $p['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin hapus program ini?')" title="Hapus">
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
    .text-purple { color: #2f3f58 !important; }
    
    .btn-purple {
        background-color: #2f3f58;
        color: white;
        border: none;
        transition: all 0.3s;
    }
    .btn-purple:hover {
        background-color: #1a253a;
        color: white;
        transform: translateY(-2px);
    }

    .btn-outline-purple {
        color: #2f3f58;
        border-color: #2f3f58;
    }
    .btn-outline-purple:hover {
        background-color: #2f3f58;
        color: white;
    }

    .bg-purple-light {
        background-color: #e8ecf1;
        width: 40px;
        height: 40px;
        font-size: 1.2rem;
    }
</style>

<?= $this->endSection() ?>