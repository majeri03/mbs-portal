<?= $this->extend('layout/template_sekolah') ?>

<?= $this->section('content') ?>

<div class="bg-purple text-white py-5 mb-4 text-center position-relative overflow-hidden">

         
    <div class="container position-relative z-1">
        <h1 class="fw-bold display-5">Galeri Kegiatan</h1>
        <p class="lead opacity-75 mb-0">Dokumentasi aktivitas santri & fasilitas <?= esc($school['name']) ?></p>
    </div>
</div>

<div class="container pb-5">
    
    <div class="d-flex justify-content-center flex-wrap gap-2 mb-5">
        <?php 
            $cats = ['semua' => 'Semua', 'kegiatan' => 'Kegiatan', 'prestasi' => 'Prestasi', 'fasilitas' => 'Fasilitas', 'asrama' => 'Asrama'];
        ?>
        <?php foreach($cats as $key => $label): ?>
            <a href="<?= site_url('mts/galeri?kategori=' . $key) ?>" 
               class="btn rounded-pill px-4 fw-medium transition-btn <?= ($current_category == $key) ? 'btn-purple shadow' : 'btn-outline-purple' ?>">
                <?= $label ?>
            </a>
        <?php endforeach; ?>
    </div>

    <div class="row g-3">
        <?php if (!empty($galleries)): ?>
            <?php foreach ($galleries as $g): ?>
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="gallery-card position-relative overflow-hidden rounded-4 shadow-sm h-100 cursor-pointer group-hover"
                         onclick="openGalleryModal('<?= base_url($g['image_url']) ?>', '<?= esc($g['title']) ?>', '<?= esc(ucfirst($g['category'])) ?>')">
                        
                        <div class="ratio ratio-1x1">
                            <img src="<?= base_url($g['image_url']) ?>" 
                                 class="w-100 h-100 object-fit-cover transition-transform" 
                                 alt="<?= esc($g['title']) ?>"
                                 loading="lazy">
                        </div>

                        <div class="gallery-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-3">
                            <span class="badge bg-warning text-dark align-self-start mb-1 shadow-sm" style="font-size: 0.7rem;">
                                <?= esc(ucfirst($g['category'])) ?>
                            </span>
                            <h6 class="text-white fw-bold mb-0 small text-shadow text-truncate"><?= esc($g['title']) ?></h6>
                        </div>
                        
                        <div class="zoom-icon position-absolute top-50 start-50 translate-middle opacity-0 transition-opacity">
                            <div class="bg-white text-purple rounded-circle p-2 shadow">
                                <i class="bi bi-zoom-in fs-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <div class="bg-light rounded-4 p-5 border border-dashed">
                    <i class="bi bi-images fs-1 text-muted opacity-50 mb-3"></i>
                    <h5 class="text-muted fw-bold">Belum ada foto di kategori ini</h5>
                    <a href="<?= site_url('mts/galeri') ?>" class="btn btn-sm btn-outline-purple mt-3">Lihat Semua Foto</a>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="mt-5 d-flex justify-content-center">
        <?= $pager->links('gallery', 'default_full') ?>
    </div>
</div>

<div class="modal fade" id="galleryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-header border-0 p-0 mb-2">
                <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0 text-center position-relative">
                <img src="" id="modalImageSrc" class="img-fluid rounded-4 shadow-lg" style="max-height: 85vh;">
                <div class="position-absolute bottom-0 start-0 w-100 p-3" style="background: linear-gradient(to top, rgba(0,0,0,0.9), transparent);">
                    <h5 class="modal-title text-white fw-bold" id="modalImageTitle"></h5>
                    <span class="badge bg-purple" id="modalImageCat"></span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Reuse Style Konsisten */
    .text-purple { color: var(--mbs-purple) !important; }
    .bg-purple { background-color: var(--mbs-purple) !important; }
    .btn-purple { background-color: var(--mbs-purple); color: white; border: 1px solid var(--mbs-purple); }
    .btn-purple:hover { background-color: #1a253a; color: white; }
    
    .btn-outline-purple { color: var(--mbs-purple); border: 1px solid var(--mbs-purple); }
    .btn-outline-purple:hover { background-color: var(--mbs-purple); color: white; }
    
    .gallery-card img.transition-transform { transition: transform 0.5s ease; }
    .gallery-card:hover img.transition-transform { transform: scale(1.1); }
    
    .gallery-overlay {
        background: linear-gradient(to top, rgba(47, 63, 88, 0.8) 0%, transparent 100%);
        opacity: 0;
        transform: translateY(10px);
        transition: all 0.3s ease;
    }
    .gallery-card:hover .gallery-overlay { opacity: 1; transform: translateY(0); }
    
    .zoom-icon { transition: all 0.3s ease; }
    .gallery-card:hover .zoom-icon { opacity: 1 !important; }
    
    .text-shadow { text-shadow: 0 2px 4px rgba(0,0,0,0.5); }
    .cursor-pointer { cursor: pointer; }
    
    /* Pagination Style Override agar Ungu */
    .pagination .page-link { color: var(--mbs-purple); border: none; margin: 0 2px; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; }
    .pagination .page-item.active .page-link { background-color: var(--mbs-purple); color: white; }
    .pagination .page-link:hover { background-color: #e8ecf1; }
</style>

<script>
    function openGalleryModal(src, title, category) {
        document.getElementById('modalImageSrc').src = src;
        document.getElementById('modalImageTitle').innerText = title;
        document.getElementById('modalImageCat').innerText = category;
        new bootstrap.Modal(document.getElementById('galleryModal')).show();
    }
</script>

<?= $this->endSection() ?>