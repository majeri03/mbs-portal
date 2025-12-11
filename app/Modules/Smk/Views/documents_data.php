<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3 text-secondary border-0" width="5%">#</th>
                        <th class="px-4 py-3 text-secondary border-0" width="55%">Nama Dokumen</th>
                        <th class="px-4 py-3 text-secondary border-0" width="20%">Kategori & Tanggal</th>
                        <th class="px-4 py-3 text-secondary border-0 text-end" width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($documents)): ?>
                        <?php foreach($documents as $index => $doc): ?>
                            <?php 
                                $iconInfo = match($doc['file_type']) {
                                    'pdf' => ['color' => 'text-danger', 'icon' => 'bi-file-pdf-fill'],
                                    'word' => ['color' => 'text-primary', 'icon' => 'bi-file-word-fill'],
                                    'excel' => ['color' => 'text-success', 'icon' => 'bi-file-excel-fill'],
                                    'gdrive' => ['color' => 'text-warning', 'icon' => 'bi-google'],
                                    default => ['color' => 'text-secondary', 'icon' => 'bi-file-earmark-text-fill']
                                };
                            ?>
                            <tr>
                                <td class="px-4 py-3 text-center">
                                    <i class="bi <?= $iconInfo['icon'] ?> fs-3 <?= $iconInfo['color'] ?>"></i>
                                </td>
                                <td class="px-4 py-3">
                                    <h6 class="fw-bold mb-1">
                                        <a href="<?= esc($doc['external_url']) ?>" target="_blank" class="text-decoration-none text-dark hover-purple">
                                            <?= esc($doc['title']) ?>
                                        </a>
                                    </h6>
                                    <?php if(!empty($doc['description'])): ?>
                                        <small class="text-muted d-block text-truncate" style="max-width: 400px;">
                                            <?= strip_tags($doc['description']) ?>
                                        </small>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="badge bg-light text-secondary border mb-1"><?= esc($doc['category_name']) ?></span>
                                    <br>
                                    <small class="text-muted" style="font-size: 0.75rem;">
                                        <?= date('d/m/Y', strtotime($doc['created_at'])) ?>
                                    </small>
                                </td>
                                <td class="px-4 py-3 text-end">
                                    <a href="<?= esc($doc['external_url']) ?>" target="_blank" class="btn btn-sm btn-outline-purple rounded-pill px-3 fw-bold">
                                        <i class="bi bi-download me-1"></i> Buka / Unduh
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 opacity-25 d-block mb-2"></i>
                                Tidak ada dokumen ditemukan.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4">
    <?= $pager->links('documents', 'default_full') ?>
</div>