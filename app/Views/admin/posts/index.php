<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<!-- Alert Notifications -->
<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Action Bar -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1"><i class="bi bi-newspaper me-2"></i>Kelola Berita</h4>
        <small class="text-muted">Manajemen konten berita dan artikel</small>
    </div>
    <a href="<?= base_url('admin/posts/create') ?>" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Tambah Berita Baru
    </a>
</div>

<!-- Data Table -->
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive-wrapper">
            <table id="postsTable" class="table table-hover">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="8%">Thumbnail</th>
                        <th width="30%">Judul</th>
                        <th width="12%">Penulis</th>
                        <th width="12%">Sekolah</th>
                        <th width="12%">Tanggal</th>
                        <th width="8%">Views</th>
                        <th width="18%">Link Berita</th>
                        <th width="13%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <<?php
                        $no = 1;
                        foreach ($posts as $post) :
                            // ✅ Generate URL Berita Dinamis
                            if ($post['school_id']) {
                                // Berita Sekolah
                                $schoolSlug = '';
                                if ($post['school_id'] == 1) $schoolSlug = 'mts';
                                elseif ($post['school_id'] == 2) $schoolSlug = 'ma';
                                elseif ($post['school_id'] == 3) $schoolSlug = 'smk';

                                $postUrl = base_url($schoolSlug . '/kabar/' . $post['slug']);
                            } else {
                                // Berita Umum
                                $postUrl = base_url('news/' . $post['slug']);
                            }
                        ?>
                        <tr>
                        <td><?= $no++ ?></td>
                        <td>
                            <?php if ($post['thumbnail']) : ?>
                                <img src="<?= base_url($post['thumbnail']) ?>" class="img-thumbnail" style="height: 50px; width: 70px; object-fit: cover;">
                            <?php else : ?>
                                <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 50px; width: 70px; font-size: 0.7rem;">
                                    No Image
                                </div>
                            <?php endif; ?>
                        </td>
                        <td><?= esc($post['title']) ?></td>
                        <td>
                            <?php if (!empty($post['author'])) : ?>
                                <span class="badge bg-info"><?= esc($post['author']) ?></span>
                            <?php else : ?>
                                <span class="text-muted small">-</span>
                            <?php endif; ?>
                        </td>
                        <td><span class="badge bg-secondary"><?= esc($post['school_name'] ?? 'Umum') ?></span></td>
                        <td><?= date('d M Y', strtotime($post['created_at'])) ?></td>
                        <td><i class="bi bi-eye-fill text-muted me-1"></i><?= $post['views'] ?></td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="<?= $postUrl ?>" target="_blank" class="btn btn-outline-primary" title="Buka berita di tab baru">
                                    <i class="bi bi-box-arrow-up-right"></i> Lihat
                                </a>
                                <button type="button" class="btn btn-outline-secondary copy-link-btn" data-url="<?= $postUrl ?>" title="Copy link berita">
                                    <i class="bi bi-clipboard"></i>
                                </button>
                            </div>
                        </td>
                        <td class="text-center">
                            <a href="<?= base_url('admin/posts/edit/' . $post['id']) ?>" class="btn btn-sm btn-warning" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a href="<?= base_url('admin/posts/delete/' . $post['id']) ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus berita ini?')">
                                <i class="bi bi-trash-fill"></i>
                            </a>
                        </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?= $this->endSection() ?>

    <?= $this->section('scripts') ?>
    <script>
    $(document).ready(function() {
        // DataTable Initialization
        $('#postsTable').DataTable({
            "responsive": true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
            },
            "pageLength": 10,
            "order": [[5, "desc"]], // Sort by date
            "columnDefs": [
                { "orderable": false, "targets": [0, 1, 7, 8] }, // No, Thumbnail, Link, Aksi tidak bisa di-sort
                { "className": "text-center", "targets": [0, 8] }
            ],
            "autoWidth": false,
            "scrollX": false// Enable horizontal scroll untuk mobile
        });

        // ✅ COPY LINK FUNCTIONALITY
        $('.copy-link-btn').on('click', function() {
            const url = $(this).data('url');
            const btn = $(this);
            const originalIcon = btn.html();
            
            // Copy to clipboard
            navigator.clipboard.writeText(url).then(function() {
                // Success feedback
                btn.html('<i class="bi bi-check-lg"></i>');
                btn.removeClass('btn-outline-secondary').addClass('btn-success');
                
                // Reset button after 2 seconds
                setTimeout(function() {
                    btn.html(originalIcon);
                    btn.removeClass('btn-success').addClass('btn-outline-secondary');
                }, 2000);
            }).catch(function(err) {
                console.error('Copy failed:', err);
                alert('Gagal menyalin link!');
            });
        });
    });
</script>
    <?= $this->endSection() ?>