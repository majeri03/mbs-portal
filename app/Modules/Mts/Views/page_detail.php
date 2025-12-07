<?= $this->extend('layout/template_sekolah') ?>
<?= $this->section('content') ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h1 class="fw-bold text-purple mb-4 text-center"><?= esc($page['title']) ?></h1>
            <div class="card border-0 shadow-sm p-4">
                <div class="content-body lh-lg text-secondary">
                    <?= clean_content($page['content']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>