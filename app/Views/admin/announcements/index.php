<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<!-- Alert Notifications -->
<?php if (session()->getFlashdata('success')) : ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle-fill me-2"></i>
    <?= session()->getFlashdata('success') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

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
        <h4 class="mb-1"><i class="bi bi-megaphone-fill me-2 text-primary"></i>Kelola Pengumuman</h4>
        <small class="text-muted">Manajemen info penting untuk landing page (ticker berjalan)</small>
    </div>
    <a href="<?= base_url('admin/announcements/create') ?>" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Tambah Pengumuman Baru
    </a>
</div>

<!-- Info Box -->
<div class="alert alert-info border-start border-primary border-4 mb-4">
    <div class="d-flex">
        <i class="bi bi-info-circle-fill fs-4 me-3"></i>
        <div>
            <strong>Cara Kerja Auto-Rotate:</strong>
            <p class="mb-0 mt-1">Pengumuman aktif akan ditampilkan <strong>bergantian setiap 5 detik</strong> di landing page dengan animasi ticker berjalan. Pengumuman yang sudah melewati <strong>tanggal selesai</strong> akan otomatis tidak tampil.</p>
        </div>
    </div>
</div>

<!-- Data Table -->
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive-wrapper">
            <table id="announcementsTable" class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="3%">No</th>
                        <th width="5%">Status</th>
                        <th width="30%">Judul Pengumuman</th>
                        <th width="10%">Kategori</th>
                        <th width="10%">Mulai</th>
                        <th width="10%">Selesai</th>
                        <th width="7%">Prioritas</th>
                        <th width="10%" class="hide-mobile">Icon</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($announcements)) : ?>
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                                Belum ada pengumuman. Klik tombol "Tambah Pengumuman Baru" untuk membuat yang pertama!
                            </td>
                        </tr>
                    <?php else : ?>
                        <?php $no = 1; foreach ($announcements as $announcement) : ?>
                        <?php
                            // Cek status expired
                            $today = date('Y-m-d');
                            $isExpired = $announcement['end_date'] < $today;
                            $isActive = $announcement['is_active'] == 1;
                            
                            // Badge color by category
                            $categoryBadge = match($announcement['category']) {
                                'urgent'    => 'bg-danger',
                                'important' => 'bg-warning text-dark',
                                'normal'    => 'bg-info',
                                default     => 'bg-secondary'
                            };
                            
                            $categoryLabel = match($announcement['category']) {
                                'urgent'    => 'Mendesak',
                                'important' => 'Penting',
                                'normal'    => 'Biasa',
                                default     => 'Lainnya'
                            };
                        ?>
                        <tr class="<?= $isExpired ? 'table-secondary opacity-50' : '' ?>">
                            <td><?= $no++ ?></td>
                            <td>
                                <?php if ($isExpired) : ?>
                                    <span class="badge bg-secondary" title="Sudah melewati tanggal selesai">
                                        <i class="bi bi-clock-history"></i> Expired
                                    </span>
                                <?php elseif ($isActive) : ?>
                                    <span class="badge bg-success" title="Sedang ditampilkan di landing page">
                                        <i class="bi bi-check-circle-fill"></i> Aktif
                                    </span>
                                <?php else : ?>
                                    <span class="badge bg-danger" title="Tidak ditampilkan di landing page">
                                        <i class="bi bi-x-circle-fill"></i> Nonaktif
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="fw-semibold text-truncate" style="max-width: 300px;" title="<?= esc($announcement['title']) ?>">
                                    <?= esc($announcement['title']) ?>
                                </div>
                                <small class="text-muted d-block mt-1">
                                    <?= esc(substr($announcement['content'], 0, 80)) ?>...
                                </small>
                            </td>
                            <td>
                                <span class="badge <?= $categoryBadge ?>">
                                    <?= $categoryLabel ?>
                                </span>
                            </td>
                            <td>
                                <small class="text-muted">
                                    <i class="bi bi-calendar-check me-1"></i>
                                    <?= date('d M Y', strtotime($announcement['start_date'])) ?>
                                </small>
                            </td>
                            <td>
                                <small class="text-muted">
                                    <i class="bi bi-calendar-x me-1"></i>
                                    <?= date('d M Y', strtotime($announcement['end_date'])) ?>
                                </small>
                                <?php if ($isExpired) : ?>
                                    <span class="badge bg-secondary ms-1">Lewat</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-dark">#<?= $announcement['priority'] ?></span>
                            </td>
                            <td class="text-center hide-mobile">
                                <i class="bi <?= esc($announcement['icon']) ?> fs-4 text-primary"></i>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <!-- Toggle Active Button -->
                                    <button type="button" 
                                            class="btn <?= $isActive ? 'btn-success' : 'btn-secondary' ?> toggle-active-btn"
                                            data-id="<?= $announcement['id'] ?>"
                                            title="<?= $isActive ? 'Klik untuk nonaktifkan' : 'Klik untuk aktifkan' ?>">
                                        <i class="bi <?= $isActive ? 'bi-eye-fill' : 'bi-eye-slash-fill' ?>"></i>
                                    </button>
                                    
                                    <!-- Edit Button -->
                                    <a href="<?= base_url('admin/announcements/edit/' . $announcement['id']) ?>" 
                                       class="btn btn-warning" 
                                       title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    
                                    <!-- Delete Button -->
                                    <a href="<?= base_url('admin/announcements/delete/' . $announcement['id']) ?>" 
                                       class="btn btn-danger" 
                                       title="Hapus"
                                       onclick="return confirm('Yakin ingin menghapus pengumuman: <?= esc($announcement['title']) ?>?')">
                                        <i class="bi bi-trash-fill"></i>
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

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        // Initialize DataTables
        $('#announcementsTable').DataTable({
            "responsive": true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
            },
            "pageLength": 10,
            "order": [[6, "asc"], [4, "desc"]], // Sort by priority, then start_date
            "columnDefs": [
                { "orderable": false, "targets": [0, 8] }, // No, Aksi
                { "className": "text-center", "targets": [0, 1, 6, 7, 8] }
            ]
        });
        
        // Toggle Active/Inactive via AJAX
        $('.toggle-active-btn').on('click', function() {
            const btn = $(this);
            const announcementId = btn.data('id');
            
            if (confirm('Yakin ingin mengubah status pengumuman ini?')) {
                $.ajax({
                    url: '<?= base_url('admin/announcements/toggle-active/') ?>' + announcementId,
                    type: 'POST',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Update button appearance
                            if (response.newStatus == 1) {
                                btn.removeClass('btn-secondary').addClass('btn-success');
                                btn.find('i').removeClass('bi-eye-slash-fill').addClass('bi-eye-fill');
                                btn.attr('title', 'Klik untuk nonaktifkan');
                            } else {
                                btn.removeClass('btn-success').addClass('btn-secondary');
                                btn.find('i').removeClass('bi-eye-fill').addClass('bi-eye-slash-fill');
                                btn.attr('title', 'Klik untuk aktifkan');
                            }
                            
                            // Reload page to update status badge
                            location.reload();
                        } else {
                            alert('Gagal mengubah status!');
                        }
                    },
                    error: function() {
                        alert('Terjadi kesalahan!');
                    }
                });
            }
        });
    });
</script>

<style>
    .text-truncate {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .table-secondary.opacity-50 {
        opacity: 0.6;
    }
</style>
<?= $this->endSection() ?>