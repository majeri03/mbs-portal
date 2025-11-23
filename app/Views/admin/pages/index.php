<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4><i class="bi bi-file-text me-2 text-purple"></i>Kelola Halaman Statis</h4>
    <a href="<?= base_url('admin/pages/create') ?>" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Halaman Baru</a>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show"><?= session()->getFlashdata('success') ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
<?php endif; ?>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr><th>Judul Halaman</th><th>Link Slug</th><th>Last Update</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                <?php foreach($pages as $p): ?>
                <tr>
                    <td><?= esc($p['title']) ?></td>
                    <td><a href="<?= base_url('page/'.$p['slug']) ?>" target="_blank" class="text-decoration-none">/page/<?= esc($p['slug']) ?> <i class="bi bi-box-arrow-up-right small"></i></a></td>
                    <td><?= date('d M Y', strtotime($p['updated_at'])) ?></td>
                    <td>
                        <a href="<?= base_url('admin/pages/edit/'.$p['id']) ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                        <a href="<?= base_url('admin/pages/delete/'.$p['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus halaman ini?')"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>