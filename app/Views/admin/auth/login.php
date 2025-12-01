<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - MBS Portal</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Google Font: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <style>
        html,
        body {
            width: 100%;
            overflow-x: hidden;
        }

        :root {
            --mbs-purple: #582C83;
            --mbs-purple-light: #7A4E9F;
            --mbs-purple-dark: #3D1F5C;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--mbs-purple) 0%, var(--mbs-purple-dark) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
            overflow-y: auto;
            padding: 20px;
        }

        /* Animated Background Circles */
        body::before,
        body::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            animation: float 20s infinite ease-in-out;
        }

        body::before {
            width: 500px;
            height: 500px;
            top: -200px;
            left: -200px;
            animation-delay: -5s;
        }

        body::after {
            width: 400px;
            height: 400px;
            bottom: -150px;
            right: -150px;
            animation-delay: -10s;
            clip-path: inset(0);
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0) scale(1);
            }

            50% {
                transform: translateY(-30px) scale(1.1);
            }
        }

        /* Login Card */
        .login-wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 430px;
            padding: 0 15px;
        }

        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            background: linear-gradient(135deg, var(--mbs-purple), var(--mbs-purple-light));
            color: white;
            padding: 40px 30px;
            text-align: center;
        }

        .login-header .logo {
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .login-header .logo i {
            font-size: 2.5rem;
            color: var(--mbs-purple);
        }

        .login-header h3 {
            font-weight: 700;
            font-size: 1.5rem;
            margin-bottom: 5px;
        }

        .login-header p {
            opacity: 0.9;
            font-size: 0.9rem;
            font-weight: 300;
        }

        .login-body {
            padding: 30px 25px;
        }

        .form-floating {
            margin-bottom: 20px;
        }

        .form-floating>.form-control {
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            height: 60px;
            transition: all 0.3s;
        }

        .form-floating>.form-control:focus {
            border-color: var(--mbs-purple);
            box-shadow: 0 0 0 4px rgba(88, 44, 131, 0.1);
        }

        .form-floating>label {
            color: #888;
        }

        .btn-login {
            background: linear-gradient(135deg, var(--mbs-purple), var(--mbs-purple-light));
            color: white;
            border: none;
            border-radius: 10px;
            height: 55px;
            font-weight: 600;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(88, 44, 131, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        /* Alert Notification (Toast Style) */
        .alert-notification {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            /* supaya di tengah */
            width: calc(100% - 40px);
            /* 20px jarak kiri + 20px jarak kanan */
            max-width: 400px;
            min-width: auto;
            z-index: 9999;
            animation: slideInRight 0.5s ease-out;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }


        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100%);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .alert-notification.alert-success {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border: none;
        }

        .alert-notification.alert-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            border: none;
        }

        .alert-notification .alert-icon {
            font-size: 1.5rem;
            margin-right: 15px;
        }

        .alert-notification .btn-close {
            filter: brightness(0) invert(1);
        }

        /* Loading Spinner */
        .btn-login .spinner-border {
            width: 1.2rem;
            height: 1.2rem;
            border-width: 2px;
            display: none;
        }

        .btn-login.loading .spinner-border {
            display: inline-block;
        }

        .btn-login.loading .btn-text {
            display: none;
        }

        /* Footer */
        .login-footer {
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 0.85rem;
        }

        /* Responsive */
        @media (max-width: 576px) {
            body {
                padding: 10px;
            }

            .login-wrapper {
                padding: 0 10px;
                max-width: 100%;
            }

            .login-header h3 {
                font-size: 1.25rem;
            }

            .login-header p {
                font-size: 0.8rem;
            }

            .login-header,
            .login-body {
                padding: 20px 16px !important;
            }

            .form-floating>.form-control {
                height: 52px;
                font-size: 0.9rem;
            }

            .btn-login {
                padding: 12px 18px;
                font-size: 0.9rem;
            }

            .login-footer {
                padding: 15px 10px;
                font-size: 0.75rem;
            }

            .alert-notification {
                position: fixed;
                top: 10px;
                right: 10px;
                left: 10px;
                min-width: auto;
                max-width: 100%;
            }
        }
    </style>
</head>

<body>

    <!-- Alert Notification (Toast) -->
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger alert-notification alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-x-circle-fill alert-icon"></i>
                <div class="flex-grow-1">
                    <strong>Oops!</strong><br>
                    <?= session()->getFlashdata('error') ?>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-notification alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill alert-icon"></i>
                <div class="flex-grow-1">
                    <strong>Berhasil!</strong><br>
                    <?= session()->getFlashdata('success') ?>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    <?php endif; ?>

    <!-- Login Card -->
    <div class="login-wrapper">
        <div class="login-card">

            <!-- Header -->
            <div class="login-header">
                <div class="logo">
                    <i class="bi bi-shield-lock-fill"></i>
                </div>
                <h3>MBS Admin Panel</h3>
                <p>Masuk untuk mengelola website pondok</p>
            </div>

            <!-- Body / Form -->
            <div class="login-body">
                <form action="<?= base_url('admin/login/attempt') ?>" method="POST" id="loginForm">
                    <?= csrf_field() ?>

                    <!-- Username Input -->
                    <div class="form-floating">
                        <input type="text"
                            class="form-control"
                            id="username"
                            name="username"
                            placeholder="Username atau Email"
                            value="<?= old('username') ?>"
                            required
                            autofocus>
                        <label for="username">
                            <i class="bi bi-person-circle me-2"></i>Username / Email
                        </label>
                    </div>

                    <!-- Password Input -->
                    <div class="form-floating">
                        <input type="password"
                            class="form-control"
                            id="password"
                            name="password"
                            placeholder="Password"
                            required>
                        <label for="password">
                            <i class="bi bi-key-fill me-2"></i>Password
                        </label>
                    </div>

                    <!-- Remember Me (Optional) -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember">
                            <label class="form-check-label text-muted small" for="remember">
                                Ingat saya
                            </label>
                        </div>

                        <a href="<?= base_url('admin/forgot-password') ?>" class="text-decoration-none small fw-bold" style="color: var(--mbs-purple);">
                            Lupa Password?
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-login w-100">
                        <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                        <span class="btn-text">
                            <i class="bi bi-box-arrow-in-right me-2"></i>MASUK
                        </span>
                    </button>
                </form>
            </div>

            <!-- Footer -->
            <div class="login-footer">
                <i class="bi bi-c-circle"></i> <?= date('Y') ?> MBS Boarding School. All Rights Reserved.
            </div>

        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Script -->
    <script>
        // Auto hide alert setelah 5 detik
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert-notification');
            alerts.forEach(alert => {
                const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                bsAlert.close();
            });
        }, 5000);

        // Loading animation saat submit
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const btn = this.querySelector('.btn-login');
            btn.classList.add('loading');
            btn.disabled = true;
        });
    </script>

</body>

</html>