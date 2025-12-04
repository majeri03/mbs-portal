<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Ulang Password - MBS Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root { --mbs-purple: #2f3f58; --mbs-purple-dark: #1a253a; }
        * { box-sizing: border-box; }
        
        html, body {
            margin: 0; 
            padding: 0;
            width: 100%;
            height: 100%; /* Paksa tinggi setara layar */
            overflow: hidden; /* KUNCI MATI scroll browser (Anti Geser) */
        }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--mbs-purple) 0%, var(--mbs-purple-dark) 100%);
            min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center;
            padding: 20px;
        }
        .login-wrapper { width: 100%; max-width: 450px; } /* Wrapper agar alert rapi */
        .login-card { background: white; border-radius: 20px; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3); overflow: hidden; }
        .login-header { background: #f8f9fa; padding: 30px; text-align: center; }
        .login-body { padding: 40px 30px; }
        .btn-purple { background: var(--mbs-purple); color: white; border: none; border-radius: 10px; height: 50px; font-weight: 600; width: 100%; transition: 0.3s; }
        .btn-purple:hover { background: var(--mbs-purple-dark); color: white; }
    </style>
</head>
<body>

    <div class="login-wrapper">
        
        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger mb-4 shadow-sm border-0 d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                <div><?= session()->getFlashdata('error') ?></div>
            </div>
        <?php endif; ?>
        <div class="login-card">
            <div class="login-header">
                <h4 class="fw-bold mb-1">Buat Password Baru</h4>
                <p class="text-muted small mb-0">Silakan masukkan password baru Anda.</p>
            </div>

            <div class="login-body">
                <form action="<?= base_url('admin/reset-password') ?>" method="post">
                    <input type="hidden" name="token" value="<?= esc($token) ?>">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Password Baru</label>
                        <input type="password" name="password" class="form-control" required minlength="6" placeholder="Minimal 6 karakter">
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold small">Konfirmasi Password</label>
                        <input type="password" name="pass_confirm" class="form-control" required placeholder="Ulangi password">
                    </div>
                    
                    <button type="submit" class="btn btn-purple">
                        Simpan Password
                    </button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>