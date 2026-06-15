<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin') — {{ config('app.name', 'Osvioo') }}</title>

    <!-- Bootstrap 5 -->
    <link href="{{ asset('assets/global/css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/global/js/bootstrap.bundle.min.js') }}"></script>

    {{-- Fonts: Inter & Sora for Modern SaaS Look --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Sora:wght@600;700&display=swap" rel="stylesheet">

    {{-- Icons: Font Awesome 6 --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --rr-sidebar-w: 260px;
            --rr-primary: #6366f1; /* Indigo SaaS Color */
            --rr-dark: #0f172a;
            --rr-sidebar-bg: #0f172a;
            --rr-bg: #f8fafc;
            --rr-border: #e2e8f0;
            --rr-text-muted: #64748b;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--rr-bg);
            color: #1e293b;
            margin: 0;
        }

        .app-shell { display: flex; min-height: 100vh; }

        /* ─── Sidebar ────────────────────────────────────────── */
        .sidebar {
            width: var(--rr-sidebar-w);
            background: var(--rr-sidebar-bg);
            color: white;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            z-index: 1000;
            transition: all 0.3s;
        }

        .brand-section {
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .brand-logo-sq {
            width: 32px; height: 32px;
            background: var(--rr-primary);
            border-radius: 8px;
            display: grid; place-items: center;
            font-weight: bold; font-family: 'Sora';
        }

        .brand-name {
            font-family: 'Sora', sans-serif;
            font-weight: 700; font-size: 20px; letter-spacing: -0.5px;
        }

        .nav-link {
            color: #94a3b8 !important;
            padding: 12px 20px;
            margin: 4px 12px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            font-weight: 500;
            transition: 0.2s;
        }

        .nav-link i { font-size: 18px; width: 24px; text-align: center; }

        .nav-link:hover {
            color: white !important;
            background: rgba(255,255,255,0.05);
        }

        .nav-link.active {
            color: white !important;
            background: var(--rr-primary) !important;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .nav-section-title {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #475569;
            margin: 20px 24px 8px;
            font-weight: 700;
        }

        /* ─── Topbar ─────────────────────────────────────────── */
        .main-content {
            margin-left: var(--rr-sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            height: 70px;
            background: white;
            border-bottom: 1px solid var(--rr-border);
            display: flex;
            align-items: center;
            padding: 0 30px;
            position: sticky;
            top: 0;
            z-index: 900;
        }

        .breadcrumb-rr {
            font-size: 14px;
            font-weight: 500;
            color: var(--rr-text-muted);
        }

        .breadcrumb-rr .current { color: var(--rr-dark); font-weight: 600; }

        .topbar-actions {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .action-btn {
            width: 40px; height: 40px;
            border-radius: 10px;
            border: 1px solid var(--rr-border);
            background: transparent;
            color: var(--rr-text-muted);
            display: grid; place-items: center;
            cursor: pointer; transition: 0.2s;
        }

        .action-btn:hover { border-color: var(--rr-primary); color: var(--rr-primary); background: #f5f3ff; }

        .user-profile-btn {
            display: flex; align-items: center; gap: 10px;
            padding: 5px 5px 5px 15px;
            border-radius: 12px;
            border: 1px solid var(--rr-border);
            background: white;
            cursor: pointer;
        }

        /* ─── Responsive ─────────────────────────────────────── */
        @media (max-width: 992px) {
            .sidebar { transform: translateX(-100%); }
            .main-content { margin-left: 0; }
            .sidebar.show { transform: translateX(0); }
        }

<style>
    /* ─── Footer ─────────────────────────────────────────── */
    .app-footer {
        height: 46px;
        border-top: 1px solid var(--border, #e3e8f0);
        background: var(--surface, #fff);
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 28px;
        flex-shrink: 0;
    }
    .footer-left {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        color: var(--muted, #8892b0);
    }
    .footer-sep { opacity: .4; }
    .footer-version {
        font-family: 'JetBrains Mono', monospace;
        font-size: 11px;
        background: var(--accent-lt, #e8edff);
        color: var(--accent, #4f6ef7);
        padding: 1px 7px;
        border-radius: 20px;
    }
    .footer-right {
        display: flex;
        gap: 18px;
    }
    .footer-right a {
        font-size: 12px;
        color: var(--muted, #8892b0);
        text-decoration: none;
        transition: color .2s;
    }
    .footer-right a:hover { color: var(--accent, #4f6ef7); }

    @media (max-width: 600px) {
        .footer-right { display: none; }
    }
</style>
    </style>
    @stack('styles')
</head>
<body>

<div class="app-shell">
    {{-- ══════════════ SIDEBAR ══════════════ --}}
    <aside class="sidebar">
        <div class="brand-section">
            <div class="brand-logo-sq">S</div>
            <span class="brand-name">Osvioo</span>
        </div>

        <nav class="flex-grow-1 mt-3">
            <div class="nav-section-title">Core</div>
            <a href="{{ route('osvioo.dashboard') }}" class="nav-link {{ request()->routeIs('osvioo.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-line"></i> Analytics
            </a>


            <div class="nav-section-title">System</div>
            <!-- <a href="#" class="nav-link">
                <i class="fa-solid fa-users"></i> Users List
            </a> -->

            <a href="{{ route('osvioo-admin.faq.index') }}" class="nav-link">
                <i class="fa-solid fa-comments "></i> Faqs
            </a>

            <a href="{{ route('osvioo-admin.story.index') }}" class="nav-link">
                <i class="fa-solid fa-credit-card"></i> Storyboard
            </a>
            <a href="{{ route('osvioo-admin.stats.index') }}" class="nav-link">
                <i class="fa-solid fa-gears"></i> Stats
            </a>
            <a href="{{ route('osvioo-admin.creator.index') }}" class="nav-link">
                <i class="fa-solid fa-gears"></i> Creators
            </a>
            <a href="{{ route('osvioo-admin.video.index') }}" class="nav-link">
                <i class="fa-solid fa-gears"></i> Videos
            </a>
        </nav>

        <div class="p-4 mt-auto border-top border-secondary border-opacity-10">
            <form method="POST" action="{{ route('osvioo.logout') }}">
                @csrf
                <button type="submit" class="btn btn-dark w-100 py-2" style="border-radius: 10px; font-size: 14px;">
                    <i class="fa-solid fa-right-from-bracket me-2"></i> Sign Out
                </button>
            </form>
        </div>
    </aside>

    {{-- ══════════════ MAIN CONTENT ══════════════ --}}
    <div class="main-content">
        <header class="topbar">
            <div class="breadcrumb-rr">
                Osvioo <i class="fa-solid fa-chevron-right mx-2 text-muted" style="font-size: 10px;"></i>
                <span class="current">@yield('breadcrumb', 'Dashboard')</span>
            </div>

            <div class="topbar-actions">
                <button class="action-btn" title="System Logs" data-bs-toggle="modal" data-bs-target="#systemLogsModal">
                    <i class="fa-solid fa-terminal"></i>
                </button>
                <button class="action-btn" title="Notifications" data-bs-toggle="modal" data-bs-target="#notificationsModal">
                    <i class="fa-solid fa-bell"></i>
                </button>

                <!-- Modals for Header Actions -->
                <div class="modal fade" id="systemLogsModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content border-0 shadow" style="border-radius: 12px; overflow: hidden;">
                            <div class="modal-header bg-dark text-white border-0">
                                <h5 class="modal-title"><i class="fa-solid fa-terminal me-2"></i> System Logs</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-0 bg-dark text-success" style="font-family: monospace; font-size: 13px; height: 300px; overflow-y: auto;">
                                <div class="p-3">
                                    <div>> System initialized successfully...</div>
                                    <div>> Loading Osvioo dashboard...</div>
                                    <div>> Database connection stable.</div>
                                    <div>> No critical errors found.</div>
                                    <div class="text-muted mt-2">-- End of logs --</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="notificationsModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content border-0 shadow" style="border-radius: 12px; overflow: hidden;">
                            <div class="modal-header border-bottom">
                                <h5 class="modal-title"><i class="fa-solid fa-bell me-2 text-primary"></i> Notifications</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center p-5">
                                <div class="mb-3 text-muted">
                                    <i class="fa-regular fa-bell-slash fa-3x"></i>
                                </div>
                                <h6>No New Notifications</h6>
                                <p class="text-muted small mb-0">You're all caught up!</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
    
    @if(session('success'))
        <div class="toast align-items-center text-bg-success border-0 show" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="toast align-items-center text-bg-danger border-0 show" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('error') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    @endif

</div>
                <div class="dropdown">
                    
                    <div class="user-profile-btn" data-bs-toggle="dropdown">
                        <div class="text-end d-none d-md-block">
                            <div class="fw-bold" style="font-size: 13px; line-height: 1;">{{ auth()->user()->name }}</div>
                            <small class="text-muted" style="font-size: 11px;">Admin Account</small>
                        </div>
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; font-weight: bold;">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" style="border-radius: 12px; min-width: 200px;">
                        <li><a class="dropdown-item py-2" href="{{ route('osvioo.profile') }}"><i class="fa-solid fa-user-circle me-2 text-muted"></i> My Profile</a></li>
                        <li><a class="dropdown-item py-2" href="{{ route('osvioo.profile') }}"><i class="fa-solid fa-key me-2 text-muted"></i> API Keys</a></li>
                        <li><hr class="dropdown-divider opacity-50"></li>
                        <li>
                            <form method="POST" action="{{ route('osvioo.logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 text-danger"><i class="fa-solid fa-sign-out-alt me-2"></i> Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
        <script>
    document.addEventListener('DOMContentLoaded', function () {
        let toastElList = [].slice.call(document.querySelectorAll('.toast'))
        toastElList.forEach(function (toastEl) {
            let toast = new bootstrap.Toast(toastEl, {
                delay: 5000 // 5 seconds
            });
            toast.show();
        });
    });
</script>