<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="py-5 mb-5" style="background: linear-gradient(135deg, var(--mbs-purple) 0%, #3D1F5C 100%); margin-top: -1px;">
    <div class="container text-center">
        <h1 class="fw-bold display-6 text-white">Arsip Dokumen Yayasan</h1>
        <p class="lead text-white-50 mb-0">Pusat Unduhan & Berkas Resmi MBS Boarding School</p>
    </div>
</div>

<div class="container pb-5">
    <div class="row">
        
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h6 class="fw-bold mb-0 text-purple"><i class="bi bi-tags me-2"></i>Kategori Arsip</h6>
                </div>
                <div class="list-group list-group-flush p-2">
                    <a href="<?= base_url('dokumen') ?>" class="list-group-item list-group-item-action rounded-3 border-0 mb-1 <?= !request()->getGet('kategori') ? 'active-cat' : '' ?>">
                        Semua Dokumen
                    </a>
                    <?php foreach($categories as $cat): ?>
                        <a href="<?= base_url('dokumen?kategori='.$cat['slug']) ?>" class="list-group-item list-group-item-action rounded-3 border-0 mb-1 <?= request()->getGet('kategori') == $cat['slug'] ? 'active-cat' : '' ?>">
                            <?= esc($cat['name']) ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
                <h4 class="fw-bold mb-0 text-dark"><?= esc($active_category) ?></h4>
                
                <form action="" method="get" class="d-flex w-100 w-md-auto" style="max-width: 300px;">
                    <?php if(request()->getGet('kategori')): ?>
                        <input type="hidden" name="kategori" value="<?= esc(request()->getGet('kategori')) ?>">
                    <?php endif; ?>
                    <div class="input-group shadow-sm rounded-pill overflow-hidden">
                        <input type="text" name="cari" class="form-control border-0 bg-white px-3" placeholder="Cari arsip..." value="<?= esc(request()->getGet('cari')) ?>">
                        <button class="btn btn-purple px-3" type="submit"><i class="bi bi-search"></i></button>
                    </div>
                </form>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-4 py-3 text-secondary border-0 text-center" width="5%">Tipe</th>
                                <th class="px-4 py-3 text-secondary border-0">Judul Dokumen</th>
                                <th class="px-4 py-3 text-secondary border-0" width="20%">Tanggal</th>
                                <th class="px-4 py-3 text-secondary border-0 text-end" width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($documents)): ?>
                                <?php foreach($documents as $doc): ?>
                                    <?php 
                                        $icon = match($doc['file_type']) {
                                            'pdf' => 'bi-file-pdf-fill text-danger',
                                            'word' => 'bi-file-word-fill text-primary',
                                            'excel' => 'bi-file-excel-fill text-success',
                                            'gdrive' => 'bi-google text-warning',
                                            default => 'bi-file-earmark-text-fill text-secondary'
                                        };
                                    ?>
                                    <tr>
                                        <td class="px-4 py-3 text-center">
                                            <i class="bi <?= $icon ?> fs-4"></i>
                                        </td>
                                        <td class="px-4 py-3">
                                            <a href="<?= esc($doc['external_url']) ?>" target="_blank" class="text-decoration-none fw-bold text-dark hover-purple d-block">
                                                <?= esc($doc['title']) ?>
                                            </a>
                                            <small class="text-muted text-truncate d-block" style="max-width: 400px;">
                                                <?= strip_tags($doc['description'] ?? '') ?>
                                            </small>
                                        </td>
                                        <td class="px-4 py-3 text-muted small">
                                            <?= date('d M Y', strtotime($doc['created_at'])) ?>
                                        </td>
                                        <td class="px-4 py-3 text-end">
                                            <a href="<?= esc($doc['external_url']) ?>" target="_blank" class="btn btn-sm btn-outline-purple rounded-pill px-3">
                                                <i class="bi bi-download"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i class="bi bi-folder2-open fs-1 opacity-25 d-block mb-2"></i>
                                        Tidak ada dokumen di kategori ini.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                <?= $pager->links('documents', 'default_full') ?>
            </div>
        </div>
    </div>
</div>

<style>
    .text-purple { color: var(--mbs-purple) !important; }
    .bg-purple { background-color: var(--mbs-purple) !important; }
    .btn-purple { background-color: var(--mbs-purple); color: white; }
    .btn-purple:hover { background-color: #3D1F5C; color: white; }
    
    .btn-outline-purple { color: var(--mbs-purple); border-color: var(--mbs-purple); }
    .btn-outline-purple:hover { background-color: var(--mbs-purple); color: white; }
    
    .hover-purple:hover { color: var(--mbs-purple) !important; }
    
    .active-cat {
        background-color: rgba(88, 44, 131, 0.1) !important;
        color: var(--mbs-purple) !important;
        font-weight: 600;
    }
    
    @media (max-width: 768px) {
        .table th, .table td { white-space: nowrap; }
    }
</style>

<?= $this->endSection() ?>