<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="py-5 mb-5" style="background: linear-gradient(135deg, #2f3f58 0%, #1a253a 100%); margin-top: -1px;">
    <div class="container text-center">
        <h1 class="fw-bold display-5 text-white mb-3"><?= esc($page['title']) ?></h1>
        
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item">
                    <a href="<?= base_url() ?>" class="text-white-50 text-decoration-none">Beranda</a>
                </li>
                <li class="breadcrumb-item active text-white fw-bold" aria-current="page">
                    <?= esc($page['title']) ?>
                </li>
            </ol>
        </nav>
    </div>
</div>

<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm p-4 p-md-5 rounded-4">
                <div class="card-body content-body">
                    <?= $page['content'] ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Style untuk konten yang diinput Admin (Summernote) */
    .content-body { 
        line-height: 1.8; 
        color: #333; /* Teks hitam agar terbaca jelas di card putih */
        font-size: 1.05rem;
    }
    
    /* Heading dalam konten */
    .content-body h2, .content-body h3, .content-body h4 { 
        color: #2f3f58; /* Warna Ungu MBS */
        font-weight: bold; 
        margin-top: 2rem; 
        margin-bottom: 1rem;
    }
    
    /* Gambar dalam konten (Responsif) */
    .content-body img {
        max-width: 100% !important;
        height: auto !important;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        margin: 20px 0;
        display: block;
    }
    
    /* Tabel dalam konten */
    .content-body table {
        width: 100% !important;
        border-collapse: collapse;
        margin: 20px 0;
    }
    .content-body table td, .content-body table th {
        border: 1px solid #ddd;
        padding: 12px;
    }
    
    /* List (Bulleted/Numbered) */
    .content-body ul, .content-body ol {
        padding-left: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .content-body li {
        margin-bottom: 0.5rem;
    }
</style>

<?= $this->endSection() ?>