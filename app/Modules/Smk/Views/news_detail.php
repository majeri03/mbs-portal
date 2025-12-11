<?= $this->extend('layout/template_sekolah') ?>

<?= $this->section('content') ?>

<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= site_url('smk') ?>" class="text-decoration-none">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="<?= site_url('smk/kabar') ?>" class="text-decoration-none">Kabar Sekolah</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Baca Berita</li>
                    </ol>
                </nav>

                <div class="text-center mb-5">
                    <span class="badge bg-purple mb-2 px-3 py-2 rounded-pill"><?= esc($post['school_name'] ?? 'Kabar Sekolah') ?></span>
                    <h1 class="fw-bold display-6 text-dark mb-3"><?= esc($post['title']) ?></h1>
                    
                    <div class="d-flex justify-content-center gap-3 text-muted small">
                        <span><i class="bi bi-calendar3 me-1 text-purple"></i> <?= date('d M Y', strtotime($post['created_at'])) ?></span>
                        <span><i class="bi bi-person-circle me-1 text-purple"></i> <?= esc($post['author'] ?? 'Admin') ?></span>
                        <span><i class="bi bi-eye-fill me-1 text-purple"></i> <?= $post['views'] ?>x dilihat</span>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
                    <img src="<?= base_url($post['thumbnail']) ?>" 
                         class="w-100 object-fit-cover" 
                         style="max-height: 500px;"
                         alt="<?= esc($post['title']) ?>"
                         onerror="this.src='https://placehold.co/1200x600/eee/999?text=No+Image'">
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="article-content lh-lg text-secondary text-break">
                            <?= clean_content($post['content']) ?>
                        </div>

                        <div class="mt-5 pt-4 border-top d-flex justify-content-between align-items-center flex-wrap gap-3">
                            <a href="<?= site_url('smk/kabar') ?>" class="btn btn-outline-secondary rounded-pill px-4">
                                <i class="bi bi-arrow-left me-2"></i> Kembali
                            </a>
                            
                            <div class="d-flex gap-2">
                                <span class="fw-bold my-auto me-2 text-muted">Bagikan:</span>
                                <a href="https://wa.me/?text=<?= urlencode($post['title'] . ' - ' . current_url()) ?>" target="_blank" class="btn btn-success btn-sm rounded-circle" style="width: 38px; height: 38px;"><i class="bi bi-whatsapp"></i></a>
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(current_url()) ?>" target="_blank" class="btn btn-primary btn-sm rounded-circle" style="width: 38px; height: 38px;"><i class="bi bi-facebook"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<?php if(!empty($related)): ?>
<section class="py-5 bg-white">
    <div class="container">
        <h4 class="fw-bold mb-4 text-purple">Berita Lainnya</h4>
        <div class="row g-4">
            <?php foreach($related as $rn): ?>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm hover-top">
                        <div class="row g-0 align-items-center">
                            <div class="col-4">
                                <img src="<?= base_url($rn['thumbnail']) ?>" class="img-fluid rounded-start h-100 object-fit-cover" style="min-height: 100px;" alt="thumb">
                            </div>
                            <div class="col-8">
                                <div class="card-body py-2 pe-2">
                                    <h6 class="card-title fw-bold mb-1 small">
                                        <a href="<?= site_url('smk/kabar/'.$rn['slug']) ?>" class="text-decoration-none text-dark hover-purple text-clamp-2">
                                            <?= esc($rn['title']) ?>
                                        </a>
                                    </h6>
                                    <small class="text-muted" style="font-size: 0.75rem;">
                                        <i class="bi bi-calendar2 me-1"></i> <?= date('d M Y', strtotime($rn['created_at'])) ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<style>
    .text-clamp-2 { display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 2; line-clamp: 2; overflow: hidden; }
    .article-content img { max-width: 100% !important; height: auto !important; border-radius: 10px; margin: 1.5rem 0; }
    .hover-top { transition: transform 0.3s; }
    .hover-top:hover { transform: translateY(-3px); }
</style>

<?= $this->endSection() ?>