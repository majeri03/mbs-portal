<?= $this->extend('layout/template_sekolah') ?>
<?= $this->section('content') ?>
<div class="bg-purple text-white py-5 mb-4 text-center">
    <div class="container"><h1 class="fw-bold">Kabar & Informasi</h1><p class="lead opacity-75 mb-0">
            Berita terkini, artikel, dan update kegiatan dari <?= esc($school['name']) ?>
        </p></div>
</div>
<div class="container pb-5">
    <div class="row g-4">
        <?php foreach($news_list as $n): ?>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm hover-card">
                <img src="<?= esc($n['thumbnail']) ?>" class="card-img-top object-fit-cover" height="200">
                <div class="card-body">
                    <small class="text-muted"><?= date('d M Y', strtotime($n['created_at'])) ?></small>
                    <h5 class="fw-bold mt-2"><a href="<?= site_url('smk/kabar/'.$n['slug']) ?>" class="text-dark text-decoration-none"><?= esc($n['title']) ?></a></h5>
                    <p class="text-secondary small"><?= substr(strip_tags($n['content']), 0, 90) ?>...</p>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <div class="mt-4"><?= $pager->links('news', 'default_full') ?></div>
</div>
<?= $this->endSection() ?>