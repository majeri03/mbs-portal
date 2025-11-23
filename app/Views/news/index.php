<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="text-white py-5 mb-5" style="background: linear-gradient(135deg, #582C83 0%, #3D1F5C 100%); margin-top: -1px;">
    <div class="container text-center">
        <h1 class="fw-bold display-5">Kabar Pesantren</h1>
        <p class="lead opacity-75 mb-0">Berita Terbaru, Prestasi, dan Informasi MBS</p>
    </div>
</div>

<div class="container pb-5">
    <div class="row g-4">
        <?php foreach ($news_list as $news) : ?>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm hover-top">
                    <div class="position-relative overflow-hidden" style="height: 200px;">
                        <img src="<?= base_url($news['thumbnail']) ?>" class="w-100 h-100 object-fit-cover" alt="<?= esc($news['title']) ?>">
                        <span class="badge bg-purple position-absolute top-0 start-0 m-3 shadow-sm">
                            <?= esc($news['school_name'] ?? 'UMUM') ?>
                        </span>
                    </div>
                    <div class="card-body p-4">
                        <small class="text-muted d-block mb-2">
                            <i class="bi bi-calendar3 me-1"></i> <?= date('d M Y', strtotime($news['created_at'])) ?>
                        </small>
                        <h5 class="card-title fw-bold mb-3">
                            <a href="<?= base_url('news/' . $news['slug']) ?>" class="text-decoration-none text-dark hover-purple">
                                <?= esc($news['title']) ?>
                            </a>
                        </h5>
                        <p class="card-text text-muted small">
                            <?= substr(strip_tags($news['content']), 0, 100) ?>...
                        </p>
                    </div>
                    <div class="card-footer bg-white border-0 pt-0 pb-4 px-4">
                        <a href="<?= base_url('news/' . $news['slug']) ?>" class="btn btn-sm btn-outline-purple rounded-pill px-3">
                            Baca Selengkapnya
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="mt-5 d-flex justify-content-center">
        <?= $pager->links() ?>
    </div>
</div>

<style>
    .hover-top { transition: transform 0.3s; }
    .hover-top:hover { transform: translateY(-5px); }
    .bg-purple { background-color: var(--mbs-purple); }
    .text-dark.hover-purple:hover { color: var(--mbs-purple) !important; }
    .btn-outline-purple { color: var(--mbs-purple); border-color: var(--mbs-purple); }
    .btn-outline-purple:hover { background-color: var(--mbs-purple); color: white; }
</style>

<?= $this->endSection() ?>