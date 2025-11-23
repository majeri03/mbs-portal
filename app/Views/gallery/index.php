<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<style>
    :root {
        --mbs-purple: #7c3aed;
        --mbs-purple-dark: #6d28d9;
    }

    /* Hover Effect pada Card */
    .gallery-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
        border-radius: 15px;
        overflow: hidden;
    }

    .gallery-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(124, 58, 237, 0.15) !important;
    }

    .gallery-overlay {
        background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .gallery-card:hover .gallery-overlay {
        opacity: 1;
    }
    
    .object-fit-cover {
        object-fit: cover;
    }

    /* Animasi Filter */
    .filter-item {
        animation: fadeIn 0.5s ease forwards;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.9); }
        to { opacity: 1; transform: scale(1); }
    }

    /* Style Tombol Filter Aktif */
    .btn-filter.active {
        background-color: var(--mbs-purple);
        color: white;
        border-color: var(--mbs-purple);
        box-shadow: 0 4px 10px rgba(124, 58, 237, 0.3);
    }
    
    .btn-filter {
        transition: all 0.3s ease;
    }
</style>

<div class="bg-purple text-white py-5 mb-5" style="background: linear-gradient(135deg, var(--mbs-purple) 0%, var(--mbs-purple-dark) 100%);">
    <div class="container text-center">
        <h1 class="fw-bold display-5">Galeri Pondok</h1>
        <p class="lead opacity-75 mb-0">Dokumentasi Aktivitas & Kegiatan Santri MBS</p>
    </div>
</div>

<div class="container pb-5">
    
    <div class="text-center mb-5 d-flex justify-content-center flex-wrap gap-2" id="portfolio-flters">
        <button class="btn btn-outline-secondary rounded-pill px-4 btn-filter active" data-filter="all">Semua</button>
        <button class="btn btn-outline-secondary rounded-pill px-4 btn-filter" data-filter="kegiatan">Kegiatan</button>
        <button class="btn btn-outline-secondary rounded-pill px-4 btn-filter" data-filter="fasilitas">Fasilitas</button>
        <button class="btn btn-outline-secondary rounded-pill px-4 btn-filter" data-filter="prestasi">Prestasi</button>
        <button class="btn btn-outline-secondary rounded-pill px-4 btn-filter" data-filter="asrama">Asrama</button>
    </div>

    <div class="row g-4" id="gallery-container">
        <?php if (!empty($galleries)) : ?>
            <?php foreach ($galleries as $item) : ?>
                <div class="col-md-6 col-lg-4 filter-item" data-category="<?= esc($item['category']) ?>">
                    <div class="card border-0 shadow-sm gallery-card h-100" onclick="showImageModal('<?= base_url($item['image_url']) ?>', '<?= esc($item['title']) ?>')">
                        <div class="position-relative" style="height: 280px;">
                            <img src="<?= base_url($item['image_url']) ?>" class="w-100 h-100 object-fit-cover" alt="<?= esc($item['title']) ?>">
                            
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-white text-purple shadow-sm text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">
                                    <?= esc($item['category']) ?>
                                </span>
                            </div>

                            <div class="gallery-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-4">
                                <h5 class="text-white fw-bold mb-1"><?= esc($item['title']) ?></h5>
                                <small class="text-white-50"><i class="bi bi-zoom-in me-1"></i> Klik untuk memperbesar</small>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="col-12 text-center py-5">
                <i class="bi bi-images fs-1 text-muted mb-3 d-block"></i>
                <p class="text-muted">Belum ada foto yang diunggah.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-header border-0 p-0 mb-2">
                <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0 text-center position-relative">
                <img src="" id="modalImageSrc" class="img-fluid rounded shadow-lg" style="max-height: 85vh;">
                <h5 class="modal-title text-white mt-3 fw-bold" id="modalImageTitle"></h5>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // 1. Script untuk Modal Gambar
        window.showImageModal = function(src, title) {
            document.getElementById('modalImageSrc').src = src;
            document.getElementById('modalImageTitle').innerText = title;
            var myModal = new bootstrap.Modal(document.getElementById('imageModal'));
            myModal.show();
        };

        // 2. Script untuk Filter Galeri
        const filters = document.querySelectorAll('.btn-filter');
        const items = document.querySelectorAll('.filter-item');

        filters.forEach(filter => {
            filter.addEventListener('click', function() {
                // Hapus class active dari semua tombol
                filters.forEach(btn => btn.classList.remove('active'));
                filters.forEach(btn => btn.classList.add('btn-outline-secondary')); // Reset ke outline
                
                // Tambah class active ke tombol yang diklik
                this.classList.add('active');
                this.classList.remove('btn-outline-secondary');

                const category = this.getAttribute('data-filter');

                items.forEach(item => {
                    // Reset animasi
                    item.style.animation = 'none';
                    item.offsetHeight; /* trigger reflow */
                    item.style.animation = null; 

                    if (category === 'all' || item.getAttribute('data-category') === category) {
                        item.style.display = 'block';
                        item.classList.add('filter-item'); // Re-trigger animation logic via CSS if needed
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    });
</script>

<?= $this->endSection() ?>