<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-purple"><i class="bi bi-plus-circle me-2"></i>Tambah Program Baru</h4>
            <a href="<?= base_url('admin/programs') ?>" class="btn btn-light border shadow-sm">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>

        <div class="card border-0 shadow-lg rounded-4">
            <div class="card-body p-4 p-md-5">
                
                <form action="<?= base_url('admin/programs/store') ?>" method="POST">
                    <?= csrf_field() ?>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-secondary">Nama Program <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control form-control-lg bg-light border-0" placeholder="Contoh: Tahfidz Al-Qur'an" required autofocus>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-secondary">Deskripsi Singkat <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control bg-light border-0" rows="4" placeholder="Jelaskan keunggulan program ini secara singkat..." required></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-8 mb-4">
                            <label class="form-label fw-bold text-secondary">Icon Bootstrap <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-purple text-white border-0" id="icon-addon">
                                    <i class="bi bi-bookmarks-fill" id="iconPreview"></i>
                                </span>
                                <input type="text" name="icon" id="iconInput" class="form-control form-control-lg bg-light border-0" placeholder="bi-book-half" value="bi-bookmarks-fill" required>
                            </div>
                            <div class="form-text mt-2">
                                Cari nama icon di <a href="https://icons.getbootstrap.com/" target="_blank" class="text-purple fw-bold text-decoration-none">Bootstrap Icons</a>, lalu copy class-nya (contoh: <code>bi-laptop</code>).
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <label class="form-label fw-bold text-secondary">Urutan Tampil</label>
                            <input type="number" name="order_position" class="form-control form-control-lg bg-light border-0" value="0" min="0">
                        </div>
                    </div>

                    <div class="d-grid pt-3">
                        <button type="submit" class="btn btn-purple btn-lg shadow-sm rounded-pill">
                            <i class="bi bi-save me-2"></i>Simpan Program
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const iconInput = document.getElementById('iconInput');
    const iconPreview = document.getElementById('iconPreview');

    iconInput.addEventListener('input', function() {
        // Hapus semua class lama
        iconPreview.className = '';
        // Tambahkan class dasar bi dan class baru dari input
        // Jika input kosong, default ke bi-question-circle
        const newClass = this.value.trim() || 'bi-question-circle';
        
        // Cek apakah user mengetik 'bi-' atau tidak
        if(newClass.startsWith('bi-')) {
             iconPreview.className = 'bi ' + newClass;
        } else {
             iconPreview.className = 'bi bi-' + newClass;
        }
    });
</script>

<style>
    .text-purple { color: #2f3f58 !important; }
    .bg-purple { background-color: #2f3f58 !important; }
    
    .btn-purple {
        background-color: #2f3f58;
        color: white;
        border: none;
        transition: all 0.3s;
    }
    .btn-purple:hover {
        background-color: #1a253a;
        color: white;
        transform: scale(1.02);
    }
    
    /* Style Input Focus */
    .form-control:focus {
        box-shadow: 0 0 0 3px rgba(47, 63, 88, 0.1);
        background-color: white !important;
    }
</style>

<?= $this->endSection() ?>