<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('news') ?>">Berita</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Baca Berita</li>
                </ol>
            </nav>

            <span class="badge bg-purple mb-2"><?= esc($post['school_name'] ?? 'Informasi Umum') ?></span>
            <h1 class="fw-bold mb-3 display-6"><?= esc($post['title']) ?></h1>
            
            <div class="d-flex align-items-center text-muted small mb-4 border-bottom pb-3">
                <span class="me-3"><i class="bi bi-calendar3 me-1"></i> <?= date('d M Y', strtotime($post['created_at'])) ?></span>
                <span class="me-3"><i class="bi bi-person me-1"></i> <?= esc($post['author'] ?? 'Admin') ?></span>
                <span><i class="bi bi-eye me-1"></i> <?= $post['views'] ?>x dilihat</span>
            </div>

            <img src="<?= base_url($post['thumbnail']) ?>" class="w-100 rounded-4 mb-4 shadow-sm" alt="Thumbnail">

            <div class="article-content lh-lg text-dark">
                <?= $post['content'] ?> </div>
            
            <div class="mt-5 pt-4 border-top">
                <h6 class="fw-bold mb-3">Bagikan berita ini:</h6>
                
                <?php 
                    // 1. Ambil URL Halaman ini secara otomatis
                    $currentUrl = current_url(); 
                    
                    // 2. Ambil Judul Berita
                    $shareTitle = $post['title'];

                    // 3. Buat Link Share Facebook
                    // Format: https://www.facebook.com/sharer/sharer.php?u=[URL]
                    $fbLink = "https://www.facebook.com/sharer/sharer.php?u=" . urlencode($currentUrl);

                    // 4. Buat Link Share WhatsApp
                    // Format: https://api.whatsapp.com/send?text=[JUDUL] [URL]
                    $waText = "Assalamu'alaikum, ada kabar terbaru dari MBS: \n\n*" . $shareTitle . "*\n\nBaca selengkapnya disini: " . $currentUrl;
                    $waLink = "https://api.whatsapp.com/send?text=" . urlencode($waText);
                ?>

                <div class="d-flex gap-2">
                    <a href="<?= $fbLink ?>" target="_blank" class="btn btn-primary btn-sm px-4 shadow-sm">
                        <i class="bi bi-facebook me-2"></i> Share
                    </a>

                    <a href="<?= $waLink ?>" target="_blank" class="btn btn-success btn-sm px-4 shadow-sm">
                        <i class="bi bi-whatsapp me-2"></i> Kirim WA
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mt-5 mt-lg-0 ps-lg-5">
            <h5 class="fw-bold mb-4 text-purple">Berita Terbaru Lainnya</h5>
            <?php foreach($related_news as $rn): ?>
                <div class="d-flex gap-3 mb-4">
                    <img src="<?= base_url($rn['thumbnail']) ?>" class="rounded" style="width: 90px; height: 90px; object-fit: cover;">
                    <div>
                        <h6 class="fw-bold mb-1" style="font-size: 0.95rem;">
                            <a href="<?= base_url('news/'.$rn['slug']) ?>" class="text-decoration-none text-dark hover-purple">
                                <?= esc($rn['title']) ?>
                            </a>
                        </h6>
                        <small class="text-muted"><?= date('d M Y', strtotime($rn['created_at'])) ?></small>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<style>
    .text-purple { color: var(--mbs-purple); }
    .bg-purple { background-color: var(--mbs-purple); }
    .hover-purple:hover { color: var(--mbs-purple) !important; }
    /* Style khusus konten Summernote agar responsif */
    .article-content img { max-width: 100% !important; height: auto !important; border-radius: 10px; margin: 15px 0; }
</style>

<?= $this->endSection() ?>