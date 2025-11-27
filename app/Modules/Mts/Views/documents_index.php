<?= $this->extend('layout/template_sekolah') ?>

<?= $this->section('content') ?>

<div class="bg-purple text-white py-5 mb-4 text-center">
    <div class="container">
        <h1 class="fw-bold display-6">Pusat Dokumen & Unduhan</h1>
        <p class="lead opacity-75 mb-0">Arsip Digital <?= esc($school['name']) ?></p>
    </div>
</div>

<div class="container pb-5">
    <div class="row">
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3 text-purple">Kategori</h6>
                    <div class="list-group list-group-flush">
                        <a href="<?= site_url('mts/dokumen') ?>" class="list-group-item list-group-item-action border-0 px-0 <?= !request()->getGet('kategori') ? 'text-purple fw-bold' : '' ?>">
                            <i class="bi bi-grid me-2"></i> Semua Dokumen
                        </a>
                        <?php foreach($nav_doc_categories as $cat): ?>
                            <a href="<?= site_url('mts/dokumen?kategori='.$cat['slug']) ?>" class="list-group-item list-group-item-action border-0 px-0 <?= request()->getGet('kategori') == $cat['slug'] ? 'text-purple fw-bold' : '' ?>">
                                <i class="bi bi-folder2 me-2"></i> <?= esc($cat['name']) ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0 text-dark"><?= esc($active_category) ?></h5>
                
                <div class="position-relative" style="min-width: 250px;">
                    <input type="hidden" id="filterCategory" value="<?= esc(request()->getGet('kategori')) ?>">
                    <input type="text" 
                           id="searchInput"
                           class="form-control form-control-sm rounded-pill px-4 border-secondary" 
                           placeholder="Ketik untuk mencari..." 
                           value="<?= esc(request()->getGet('cari')) ?>"
                           autocomplete="off">
                    <i class="bi bi-search position-absolute top-50 end-0 translate-middle-y me-3 text-muted small"></i>
                    
                    <div id="searchSpinner" class="spinner-border spinner-border-sm text-purple position-absolute top-50 end-0 translate-middle-y me-5 d-none" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>

            <div id="documentResult">
                <?= $this->include('Modules\Mts\Views\documents_data') ?>
            </div>
        </div>
    </div>
</div>

<style>
    .text-purple { color: var(--mbs-purple) !important; }
    .bg-purple { background-color: var(--mbs-purple) !important; }
    .btn-outline-purple { color: var(--mbs-purple); border-color: var(--mbs-purple); }
    .btn-outline-purple:hover { background-color: var(--mbs-purple); color: white; }
    .hover-purple:hover { color: var(--mbs-purple) !important; }
    
    /* Responsif Mobile */
    @media (max-width: 768px) {
        .table th, .table td { white-space: nowrap; }
        .text-truncate { max-width: 200px !important; }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const resultContainer = document.getElementById('documentResult');
    const categoryInput = document.getElementById('filterCategory');
    const spinner = document.getElementById('searchSpinner');
    
    let timeout = null; // Untuk debounce (jeda ketikan)

    searchInput.addEventListener('input', function() {
        const keyword = this.value;
        const category = categoryInput.value;

        // Tampilkan spinner loading
        spinner.classList.remove('d-none');

        // Bersihkan timeout sebelumnya (agar tidak spam request tiap huruf)
        clearTimeout(timeout);

        // Tunggu 500ms setelah user selesai mengetik baru kirim request
        timeout = setTimeout(function() {
            
            // Buat URL dengan parameter
            let url = '<?= site_url('mts/dokumen') ?>' + '?cari=' + encodeURIComponent(keyword);
            if(category) {
                url += '&kategori=' + encodeURIComponent(category);
            }

            // Fetch Data (AJAX)
            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest' // Tanda ini request AJAX
                }
            })
            .then(response => response.text())
            .then(html => {
                // Ganti isi tabel dengan hasil baru
                resultContainer.innerHTML = html;
                // Sembunyikan spinner
                spinner.classList.add('d-none');
            })
            .catch(error => {
                console.error('Error:', error);
                spinner.classList.add('d-none');
            });

        }, 500); // Waktu jeda 0.5 detik
    });
});
</script>

<?= $this->endSection() ?>