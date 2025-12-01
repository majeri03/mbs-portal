<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - MBS Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root { --mbs-purple: #582C83; --mbs-purple-dark: #3D1F5C; }
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
            min-height: 100vh; display: flex; align-items: center; justify-content: center;
            overflow: hidden; padding: 20px;
        }
        /* Background Animation */
        body::before, body::after {
            content: ''; position: absolute; border-radius: 50%; background: rgba(255, 255, 255, 0.05);
            animation: float 20s infinite ease-in-out;
        }
        body::before { width: 500px; height: 500px; top: -200px; left: -200px; }
        body::after { width: 400px; height: 400px; bottom: -150px; right: -150px; animation-delay: -10s; }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-30px); } }

        .login-wrapper { position: relative; z-index: 10; width: 100%; max-width: 450px; }
        .login-card { background: white; border-radius: 20px; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3); overflow: hidden; }
        .login-header { background: #f8f9fa; padding: 30px; text-align: center; border-bottom: 1px solid #eee; }
        .login-body { padding: 40px 30px; }
        
        .btn-purple {
            background: var(--mbs-purple); color: white; border: none; border-radius: 10px;
            height: 50px; font-weight: 600; letter-spacing: 0.5px; transition: all 0.3s;
        }
        .btn-purple:hover { background: var(--mbs-purple-dark); transform: translateY(-2px); color: white; }
    </style>
</head>
<body>

    <div class="login-wrapper">
        
        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger mb-4 shadow-sm border-0">
                <i class="bi bi-exclamation-circle-fill me-2"></i> <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success mb-4 shadow-sm border-0">
                <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <div class="login-card">
            <div class="login-header">
                <div class="mb-3">
                    <span class="bg-purple bg-opacity-10 text-purple p-3 rounded-circle d-inline-block" style="background-color: #f3e5f5; color: #582C83;">
                        <i class="bi bi-shield-lock-fill fs-1"></i>
                    </span>
                </div>
                <h4 class="fw-bold text-dark mb-1">Lupa Password?</h4>
                <p class="text-muted small mb-0">Masukkan email Anda untuk menerima link reset.</p>
            </div>

            <div class="login-body">
                <form action="<?= base_url('admin/forgot-password') ?>" method="post">
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Email Terdaftar</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope"></i></span>
                            <input type="email" name="email" class="form-control border-start-0 bg-light" placeholder="contoh@mbs.sch.id" required autofocus>
                        </div>
                    </div>

                    <div class="d-grid gap-3">
                        <button type="submit" class="btn btn-purple shadow-sm">
                            Kirim Link Reset <i class="bi bi-arrow-right ms-2"></i>
                        </button>
                        
                        <a href="<?= base_url('admin/login') ?>" class="btn btn-light text-muted">
                            <i class="bi bi-arrow-left me-2"></i> Kembali ke Login
                        </a>
                    </div>

                </form>
            </div>
        </div>
        
        <div class="text-center mt-4 text-white-50 small">
            &copy; <?= date('Y') ?> MBS Boarding School Admin System
        </div>
    </div>

</body>
</html>