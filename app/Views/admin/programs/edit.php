<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-purple"><i class="bi bi-pencil-square me-2"></i>Edit Program</h4>
            <a href="<?= base_url('admin/programs') ?>" class="btn btn-light border shadow-sm">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>

        <div class="card border-0 shadow-lg rounded-4">
            <div class="card-body p-4 p-md-5">
                
                <form action="<?= base_url('admin/programs/update/' . $program['id']) ?>" method="POST">
                    <?= csrf_field() ?>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-secondary">Nama Program <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control form-control-lg bg-light border-0" value="<?= esc($program['title']) ?>" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-secondary">Deskripsi Singkat <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control bg-light border-0" rows="4" required><?= esc($program['description']) ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-8 mb-4">
                            <label class="form-label fw-bold text-secondary">Icon Bootstrap <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-purple text-white border-0">
                                    <i class="bi <?= esc($program['icon']) ?>" id="iconPreview"></i>
                                </span>
                                <input type="text" name="icon" id="iconInput" class="form-control form-control-lg bg-light border-0" value="<?= esc($program['icon']) ?>" required>
                            </div>
                            <div class="form-text mt-2">
                                Referensi: <a href="https://icons.getbootstrap.com/" target="_blank" class="text-purple fw-bold text-decoration-none">Bootstrap Icons</a>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <label class="form-label fw-bold text-secondary">Urutan Tampil</label>
                            <input type="number" name="order_position" class="form-control form-control-lg bg-light border-0" value="<?= esc($program['order_position']) ?>" min="0">
                        </div>
                    </div>

                    <div class="d-grid pt-3">
                        <button type="submit" class="btn btn-purple btn-lg shadow-sm rounded-pill">
                            <i class="bi bi-check-circle-fill me-2"></i>Simpan Perubahan
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
        iconPreview.className = '';
        const newClass = this.value.trim() || 'bi-question-circle';
        if(newClass.startsWith('bi-')) {
             iconPreview.className = 'bi ' + newClass;
        } else {
             iconPreview.className = 'bi bi-' + newClass;
        }
    });
</script>

<style>
    .text-purple { color: #582C83 !important; }
    .bg-purple { background-color: #582C83 !important; }
    
    .btn-purple {
        background-color: #582C83;
        color: white;
        border: none;
        transition: all 0.3s;
    }
    .btn-purple:hover {
        background-color: #3D1F5C;
        color: white;
        transform: scale(1.02);
    }
    
    .form-control:focus {
        box-shadow: 0 0 0 3px rgba(88, 44, 131, 0.1);
        background-color: white !important;
    }
</style>

<?= $this->endSection() ?>