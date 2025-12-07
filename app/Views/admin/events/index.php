<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<!-- Alert Messages -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Header Section -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1"><i class="bi bi-calendar-event text-purple"></i> Manajemen Agenda</h4>
        <p class="text-muted mb-0">Kelola agenda dan kegiatan sekolah</p>
    </div>
    <a href="<?= base_url('admin/events/create') ?>" class="btn btn-purple">
        <i class="bi bi-plus-circle me-2"></i> Tambah Agenda
    </a>
</div>

<!-- Events Table Card -->
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="eventsTable">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="25%">Judul Agenda</th>
                        <th width="15%">Milik</th>
                        <th width="12%">Tanggal</th>
                        <th width="10%">Waktu</th>
                        <th width="20%" class="hide-mobile">Lokasi</th>
                        <th width="13%">Dibuat</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($events)): ?>
                        <?php foreach ($events as $index => $event): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td>
                                    <strong><?= esc($event['title']) ?></strong>
                                </td>
                                <td>
                                    <?php if (empty($event['school_id'])): ?>
                                        <span class="badge bg-dark">PUSAT</span>
                                    <?php else: ?>
                                        <span class="badge bg-primary"><?= esc($event['school_name'] ?? 'Sekolah') ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-purple-light">
                                        <i class="bi bi-calendar3"></i>
                                        <?= date('d M Y', strtotime($event['event_date'])) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($event['time_start']): ?>
                                        <small class="text-muted">
                                            <i class="bi bi-clock"></i>
                                            <?= date('H:i', strtotime($event['time_start'])) ?>
                                            <?php if ($event['time_end']): ?>
                                                - <?= date('H:i', strtotime($event['time_end'])) ?>
                                            <?php endif; ?>
                                        </small>
                                    <?php else: ?>
                                        <small class="text-muted">-</small>
                                    <?php endif; ?>
                                </td>
                                <td class="hide-mobile">
                                    <?php if ($event['location']): ?>
                                        <small><i class="bi bi-geo-alt"></i> <?= esc($event['location']) ?></small>
                                    <?php else: ?>
                                        <small class="text-muted">-</small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <?= date('d/m/Y H:i', strtotime($event['created_at'])) ?>
                                    </small>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="<?= base_url('admin/events/edit/' . $event['id']) ?>"
                                            class="btn btn-outline-primary"
                                            title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <button type="button"
                                            class="btn btn-outline-danger"
                                            onclick="deleteEvent(<?= $event['id'] ?>, '<?= esc($event['title']) ?>')"
                                            title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="bi bi-calendar-x fs-1 text-muted d-block mb-3"></i>
                                <p class="text-muted mb-0">Belum ada agenda yang ditambahkan</p>
                                <a href="<?= base_url('admin/events/create') ?>" class="btn btn-purple btn-sm mt-3">
                                    <i class="bi bi-plus-circle me-2"></i> Tambah Agenda Pertama
                                </a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .btn-purple {
        background: linear-gradient(135deg, #2f3f58 0%, #1a253a 100%);
        color: white;
        border: none;
        padding: 10px 25px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s;
    }

    .btn-purple:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(47, 63, 88, 0.3);
        color: white;
    }

    .bg-purple-light {
        background: linear-gradient(135deg, #2f3f58 0%, #4a5a73 100%);
        color: white;
        padding: 5px 12px;
        border-radius: 6px;
    }

    .text-purple {
        color: #2f3f58;
    }

    .card {
        border-radius: 15px;
    }

    .table thead th {
        background: linear-gradient(135deg, #2f3f58 0%, #1a253a 100%);
        color: white;
        font-weight: 600;
        border: none;
        padding: 15px;
    }

    .table tbody tr {
        transition: all 0.3s;
    }

    .table tbody tr:hover {
        background-color: #f8f5ff;
        transform: scale(1.01);
    }

    @media (max-width: 768px) {
        .btn-group-sm .btn {
            padding: 4px 8px;
            font-size: 0.75rem;
        }
    }
</style>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Initialize DataTable
    $(document).ready(function() {
        $('#eventsTable').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },
            order: [
                [2, 'desc']
            ], // Sort by date
            pageLength: 10
        });
    });

    // Delete Confirmation
    function deleteEvent(id, title) {
        if (confirm(`Apakah Anda yakin ingin menghapus agenda "${title}"?\n\nData yang dihapus tidak dapat dikembalikan!`)) {
            window.location.href = `<?= base_url('admin/events/delete/') ?>${id}`;
        }
    }

    // Auto hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
</script>
<?= $this->endSection() ?>