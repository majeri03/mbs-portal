<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4><i class="bi bi-file-text me-2 text-purple"></i>Kelola Halaman Statis</h4>
    <a href="<?= base_url('admin/pages/create') ?>" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Halaman Baru</a>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-light">
        <h5 class="mb-0"><i class="bi bi-folder2 me-2"></i>Kelola Menu/Kategori</h5>
    </div>
    <div class="card-body">
        <?php
        // Group pages by menu_title
        $groupedPages = [];
        foreach ($pages as $p) {
            $menu = $p['menu_title'] ?? 'Tanpa Menu';
            $groupedPages[$menu][] = $p;
        }
        ?>
        
        <?php if (!empty($groupedPages)): ?>
            <?php foreach ($groupedPages as $menuName => $menuPages): ?>
                <div class="menu-group mb-4 p-3 border rounded">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-folder-fill text-purple fs-5"></i>
                            <h5 class="mb-0 fw-bold" id="menu-name-<?= md5($menuName) ?>">
                                <?= esc($menuName) ?>
                            </h5>
                            <span class="badge bg-primary"><?= count($menuPages) ?> halaman</span>
                        </div>
                        
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-outline-warning" onclick="editMenuName('<?= esc($menuName, 'js') ?>', '<?= md5($menuName) ?>')">
                                <i class="bi bi-pencil"></i> Edit Nama Menu
                            </button>
                            <button class="btn btn-outline-danger" onclick="deleteMenu('<?= esc($menuName, 'js') ?>', <?= count($menuPages) ?>)">
                                <i class="bi bi-trash"></i> Hapus Menu
                            </button>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Judul Halaman</th>
                                    <th>Slug</th>
                                    <th width="15%">Update</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($menuPages as $p): ?>
                                    <tr>
                                        <td><?= esc($p['title']) ?></td>
                                        <td>
                                            <a href="<?= base_url('page/'.$p['slug']) ?>" target="_blank" class="text-decoration-none small">
                                                /page/<?= esc($p['slug']) ?> <i class="bi bi-box-arrow-up-right"></i>
                                            </a>
                                        </td>
                                        <td><small class="text-muted"><?= date('d M Y', strtotime($p['updated_at'])) ?></small></td>
                                        <td>
                                            <a href="<?= base_url('admin/pages/edit/'.$p['id']) ?>" class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="<?= base_url('admin/pages/delete/'.$p['id']) ?>" 
                                               class="btn btn-sm btn-danger" 
                                               onclick="return confirm('⚠️ HAPUS HALAMAN?\n\nJudul: <?= esc($p['title'], 'js') ?>\n\n❌ Data tidak bisa dikembalikan!')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-center py-5 text-muted">
                <i class="bi bi-file-earmark-x fs-1 d-block mb-3"></i>
                <p>Belum ada halaman statis. Buat halaman pertama Anda!</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Edit Nama Menu -->
<div class="modal fade" id="editMenuModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title"><i class="bi bi-pencil me-2"></i>Edit Nama Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('admin/pages/renameMenu') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <input type="hidden" name="old_menu_name" id="oldMenuName">
                    <label class="form-label fw-bold">Nama Menu Baru:</label>
                    <input type="text" name="new_menu_name" id="newMenuName" class="form-control" required maxlength="30">
                    <small class="text-muted">Maksimal 30 karakter. Semua halaman dalam menu ini akan ikut berubah.</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-check-circle me-2"></i>Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Hapus Menu -->
<div class="modal fade" id="deleteMenuModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="bi bi-exclamation-triangle me-2"></i>Hapus Menu</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('admin/pages/deleteMenu') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <input type="hidden" name="menu_name" id="deleteMenuName">
                    <p class="alert alert-danger">
                        <strong>PERINGATAN!</strong> Menu "<span id="displayMenuName"></span>" memiliki <strong><span id="totalPages"></span> halaman</strong>.
                    </p>
                    <p class="mb-3">Apa yang ingin dilakukan dengan halaman-halaman tersebut?</p>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="action" id="actionMove" value="move" checked>
                        <label class="form-check-label" for="actionMove">
                            <strong>Pindahkan ke menu lain</strong>
                        </label>
                    </div>
                    
                    <div id="moveToDiv" class="mb-3 ms-4">
                        <select name="target_menu" class="form-select">
                            <option value="">Pilih menu tujuan...</option>
                            <?php foreach (array_keys($groupedPages) as $mn): ?>
                                <option value="<?= esc($mn) ?>"><?= esc($mn) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="action" id="actionDelete" value="delete">
                        <label class="form-check-label text-danger" for="actionDelete">
                            <strong>Hapus SEMUA halaman</strong> (tidak bisa dikembalikan!)
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-2"></i>Lanjutkan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function editMenuName(oldName, id) {
        document.getElementById('oldMenuName').value = oldName;
        document.getElementById('newMenuName').value = oldName;
        new bootstrap.Modal(document.getElementById('editMenuModal')).show();
    }
    
    function deleteMenu(menuName, totalPages) {
        document.getElementById('deleteMenuName').value = menuName;
        document.getElementById('displayMenuName').textContent = menuName;
        document.getElementById('totalPages').textContent = totalPages;
        new bootstrap.Modal(document.getElementById('deleteMenuModal')).show();
    }
    
    // Toggle move to div
    document.querySelectorAll('input[name="action"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.getElementById('moveToDiv').style.display = 
                this.value === 'move' ? 'block' : 'none';
        });
    });
</script>

<style>
    .menu-group {
        transition: all 0.3s;
    }
    .menu-group:hover {
        background-color: #f8f9fa;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
</style>

<?= $this->endSection() ?>