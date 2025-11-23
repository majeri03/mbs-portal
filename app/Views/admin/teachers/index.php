<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1"><i class="bi bi-people-fill me-2 text-purple"></i>Kelola Pimpinan Pondok</h4>
        <p class="text-muted mb-0">Manajemen struktur organisasi dan pimpinan</p>
    </div>
    <a href="<?= base_url('admin/teachers/create') ?>" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Tambah Pimpinan
    </a>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="10%">Foto</th>
                        <th>Nama Lengkap</th>
                        <th>Jabatan</th>
                        <th width="10%">Urutan</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($teachers)): ?>
                        <tr><td colspan="6" class="text-center text-muted py-4">Belum ada data pimpinan.</td></tr>
                    <?php else: ?>
                        <?php $no=1; foreach ($teachers as $t) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <?php 
                                    $imgSrc = filter_var($t['photo'], FILTER_VALIDATE_URL) ? $t['photo'] : base_url($t['photo']);
                                ?>
                                <img src="<?= $imgSrc ?>" class="rounded-circle object-fit-cover" width="50" height="50" alt="Foto">
                            </td>
                            <td class="fw-bold"><?= esc($t['name']) ?></td>
                            <td><span class="badge bg-info text-dark"><?= esc($t['position']) ?></span></td>
                            <td>#<?= esc($t['order_position']) ?></td>
                            <td class="text-center">
                                <a href="<?= base_url('admin/teachers/edit/' . $t['id']) ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
                                <a href="<?= base_url('admin/teachers/delete/' . $t['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data ini?')"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>