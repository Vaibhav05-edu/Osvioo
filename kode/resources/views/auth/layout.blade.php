<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Socialyt - Admin Portal')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- 1. Font Awesome Icons Import (Sabse Zaroori) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- 2. Bootstrap CSS (Spacing aur Layout ke liye) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/latest/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --rr-primary: #000000;
            --rr-accent: #6366f1;
            --rr-bg: #f8fafc;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--rr-bg);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Socialyt Clean Header */
        .rr-header {
            background: white;
            padding: 15px 0;
            border-bottom: 1px solid #e2e8f0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand-logo {
            font-size: 24px;
            font-weight: 800;
            color: var(--rr-primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .brand-dot {
            height: 6px;
            width: 6px;
            background: var(--rr-accent);
            border-radius: 50%;
        }

        /* Main Container */
        .main-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        /* Footer */
        .rr-footer {
            background: white;
            padding: 30px 0;
            border-top: 1px solid #e2e8f0;
            margin-top: auto;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            text-align: center;
            padding: 0 20px;
        }

        .footer-links {
            margin-bottom: 15px;
            display: flex;
            justify-content: center;
            gap: 25px;
        }

        .footer-links a {
            color: #64748b;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }

        .footer-links a:hover { color: var(--rr-primary); }

        .copyright {
            font-size: 13px;
            color: #94a3b8;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header-content { justify-content: center; }
            .footer-links { flex-wrap: wrap; gap: 15px; }
        }
    </style>
</head>
<body>

    <!-- Simple Header -->
    <header class="rr-header">
        <div class="header-content">
            <a href="/" class="brand-logo">
                Socialyt <span class="brand-dot"></span>
            </a>
            <div class="d-none d-md-block text-muted small fw-medium">
                <i class="fas fa-shield-check me-1"></i> Admin Security Environment
            </div>
        </div>
    </header>

    <!-- Content Area -->
    <main class="main-container">
        @yield('content')
    </main>

    <!-- Clean Footer -->
    <footer class="rr-footer">
        <div class="footer-content">
            <div class="footer-links">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="#">Support</a>
                <a href="#">Documentation</a>
            </div>
            <div class="copyright">
                © {{ date('Y') }} Socialyt HQ. All rights reserved.
                <br>
                <small>Secure Admin Access Module v2.1</small>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>