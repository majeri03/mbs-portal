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
                        
                        <?php if (!session('school_id')): ?>
                            <th>Sekolah</th>
                        <?php endif; ?>

                        <th width="10%">Foto</th>
                        <th>Nama Lengkap</th>
                        <th>Jabatan</th>
                        <th width="10%">Urutan</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($teachers)): ?>
                        <tr><td colspan="7" class="text-center text-muted py-4">Belum ada data.</td></tr>
                    <?php else: ?>
                        <?php $no=1; foreach ($teachers as $t) : ?>
                        <tr>
                            <td><?= $no++ ?></td>

                            <?php if (!session('school_id')): ?>
                                <td>
                                    <?php if(empty($t['school_id'])): ?>
                                        <span class="badge bg-dark">Pusat/Umum</span>
                                    <?php elseif($t['school_id'] == 1): ?>
                                        <span class="badge bg-success">MTs</span>
                                    <?php elseif($t['school_id'] == 2): ?>
                                        <span class="badge bg-warning text-dark">MA</span>
                                    <?php elseif($t['school_id'] == 3): ?>
                                        <span class="badge bg-danger">SMK</span>
                                    <?php endif; ?>
                                </td>
                            <?php endif; ?>

                            <td>
                                <?php 
                                    $imgSrc = filter_var($t['photo'], FILTER_VALIDATE_URL) ? $t['photo'] : base_url($t['photo']);
                                ?>
                                <img src="<?= $imgSrc ?>" class="rounded-circle object-fit-cover border shadow-sm" width="50" height="50" alt="Foto">
                            </td>
                            <td class="fw-bold">
                                <?= esc($t['name']) ?>
                                <?php if($t['is_leader']): ?>
                                    <i class="bi bi-star-fill text-warning ms-1" title="Pimpinan/Kepala Sekolah"></i>
                                <?php endif; ?>
                            </td>
                            <td><span class="badge bg-info text-dark bg-opacity-25 border border-info"><?= esc($t['position']) ?></span></td>
                            <td>#<?= esc($t['order_position']) ?></td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="<?= base_url('admin/teachers/edit/' . $t['id']) ?>" class="btn btn-outline-warning"><i class="bi bi-pencil-square"></i></a>
                                    <a href="<?= base_url('admin/teachers/delete/' . $t['id']) ?>" class="btn btn-outline-danger" onclick="return confirm('Yakin hapus data ini?')"><i class="bi bi-trash"></i></a>
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
<?= $this->endSection() ?>