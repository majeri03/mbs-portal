<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1"><i class="bi bi-people-fill me-2 text-purple"></i>Kelola Pengguna</h4>
        <p class="text-muted mb-0">Manajemen akun Admin Sekolah & Guru</p>
    </div>
    <a href="<?= base_url('admin/users/create') ?>" class="btn btn-primary">
        <i class="bi bi-person-plus-fill me-2"></i>Tambah User Baru
    </a>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Lengkap</th>
                        <th>Username / Email</th>
                        <th>Role</th>
                        <th>Sekolah</th>
                        <th>Status</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)) : ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                <i class="bi bi-people fs-1 d-block mb-2 opacity-50"></i>
                                Belum ada data pengguna.
                            </td>
                        </tr>
                    <?php else : ?>
                        <?php $no = 1; foreach ($users as $user) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td class="fw-bold"><?= esc($user['full_name']) ?></td>
                                <td>
                                    <div><?= esc($user['username']) ?></div>
                                    <small class="text-muted"><?= esc($user['email']) ?></small>
                                </td>
                                <td>
                                    <?php
                                    $badge = match ($user['role']) {
                                        'superadmin' => 'bg-danger',
                                        'admin'      => 'bg-primary',
                                        'guru'       => 'bg-info text-dark',
                                        default      => 'bg-secondary'
                                    };
                                    ?>
                                    <span class="badge <?= $badge ?>"><?= strtoupper($user['role']) ?></span>
                                </td>
                                <td>
                                    <?php if (empty($user['school_id'])) : ?>
                                        <span class="badge bg-dark">PUSAT / YAYASAN</span>
                                    <?php else : ?>
                                        <span class="badge bg-success"><?= esc($user['school_name']) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($user['is_active']) : ?>
                                        <span class="badge bg-success bg-opacity-10 text-success"><i class="bi bi-check-circle me-1"></i>Aktif</span>
                                    <?php else : ?>
                                        <span class="badge bg-danger bg-opacity-10 text-danger"><i class="bi bi-x-circle me-1"></i>Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('admin/users/edit/' . $user['id']) ?>" class="btn btn-outline-warning" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        
                                        <?php if(session('user_id') != $user['id']): ?>
                                            <a href="<?= base_url('admin/users/delete/' . $user['id']) ?>" 
                                               class="btn btn-outline-danger" 
                                               onclick="return confirm('Yakin hapus user ini? Data tidak bisa dikembalikan.')"
                                               title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        <?php endif; ?>
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