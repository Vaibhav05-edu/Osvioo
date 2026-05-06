@extends('auth.layout')

@section('title', 'Socialyt - Admin Access')

@section('content')
<style>
    :root {
        --rr-primary: #000000; /* Socialyt Theme Color */
        --rr-secondary: #6366f1; /* Accent Color */
        --rr-bg: #ffffff;
        --rr-muted: #64748b;
    }

    .split-container {
        display: flex;
        min-height: 70vh;
        max-width: 1000px;
        margin: 40px auto;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        background: #ffffff;
        border: 1px solid #f1f5f9;
    }

    /* Left Side: Modern Dark Theme */
    .info-side {
        flex: 1;
        background: var(--rr-primary);
        color: white;
        padding: 45px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .info-side::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(99,102,241,0.15) 0%, rgba(0,0,0,0) 70%);
        z-index: 1;
    }

    /* Right Side: Clean Form */
    .form-side {
        flex: 1.1;
        padding: 45px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        background: #ffffff;
    }

    .login-card {
        width: 100%;
        max-width: 360px;
        margin: 0 auto;
    }

    .brand-logo {
        font-size: 28px;
        font-weight: 800;
        letter-spacing: -1px;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .brand-dot {
        height: 8px;
        width: 8px;
        background: var(--rr-secondary);
        border-radius: 50%;
    }

    .input-wrapper {
        position: relative;
        margin-bottom: 20px;
    }

    .input-wrapper i {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 15px;
    }

    .custom-input {
        width: 100%;
        padding: 12px 16px 12px 48px;
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: #f8fafc;
    }

    .custom-input:focus {
        border-color: var(--rr-primary);
        background: #fff;
        box-shadow: 0 0 0 4px rgba(0, 0, 0, 0.05);
        outline: none;
    }

    .btn-login {
        width: 100%;
        background: var(--rr-primary);
        color: white;
        padding: 14px;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        font-size: 15px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: 0.3s;
        margin-top: 10px;
    }

    .btn-login:hover {
        background: #27272a;
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .info-side h1 {
        font-size: 32px;
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 15px;
        z-index: 2;
    }

    .info-side p {
        font-size: 15px;
        opacity: 0.8;
        z-index: 2;
        line-height: 1.6;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255,255,255,0.1);
        padding: 6px 12px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 20px;
        z-index: 2;
    }

    .pulse {
        height: 6px;
        width: 6px;
        background: #10b981;
        border-radius: 50%;
        box-shadow: 0 0 0 rgba(16, 185, 129, 0.4);
        animation: pulse-animation 2s infinite;
    }

    @keyframes pulse-animation {
        0% { box-shadow: 0 0 0 0px rgba(16, 185, 129, 0.7); }
        100% { box-shadow: 0 0 0 10px rgba(16, 185, 129, 0); }
    }

    /* Alerts Customization */
    .alert-message {
        padding: 12px 16px;
        border-radius: 12px;
        margin-bottom: 25px;
        font-size: 13px;
        font-weight: 500;
        border: 1px solid transparent;
    }

    .alert-error { background: #fff1f2; color: #e11d48; border-color: #ffe4e6; }
    .alert-success { background: #f0fdf4; color: #16a34a; border-color: #dcfce7; }

    @media (max-width: 850px) {
        .split-container { flex-direction: column; margin: 15px; }
        .info-side { display: none; }
        .form-side { padding: 40px 25px; }
    }
</style>

<div class="split-container">

    <!-- Left Side: Socialyt Context -->
    <div class="info-side">
        <div class="status-badge">
            <div class="pulse"></div>
            Admin System Online
        </div>
        <h1>Control the Flow <br> of Conversation.</h1>
        <p>
            Manage DM automations, monitor lead generations, and oversee the Socialyt ecosystem from your central command center.
        </p>

        <!-- Abstract Background Icon -->
        <i class="fas fa-bolt" style="position: absolute; bottom: -30px; right: -20px; font-size: 200px; opacity: 0.05; transform: rotate(15deg);"></i>
    </div>

    <!-- Right Side: Login Form -->
    <div class="form-side">
        <div class="login-card">
            <div class="brand-logo">
                Socialyt <span class="brand-dot"></span>
            </div>

            <div style="margin-bottom: 30px;">
                <h2 style="font-size: 22px; font-weight: 700; color: #1e293b; margin-bottom: 4px;">Admin Login</h2>
                <p style="font-size: 14px; color: var(--rr-muted);">Access restricted to authorized staff only.</p>
            </div>

            <!-- Error/Success Alerts -->
            @if(session('error'))
                <div class="alert-message alert-error" id="alertMessage">
                    <i class="fas fa-shield-halved me-2"></i> {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('socialyt.login.submit') }}">
                @csrf
                <div class="form-group mb-4">
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Admin Email</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user-shield"></i>
                        <input type="email" name="email" class="custom-input" placeholder="admin@socialyt.com" value="{{ old('email') }}" required autofocus>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Security Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-key"></i>
                        <input type="password" name="password" id="password" class="custom-input" placeholder="••••••••" required>
                        <i class="fas fa-eye" id="toggleIcon" onclick="togglePassword()" style="left: auto !important; right: 16px;"></i>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <label style="font-size: 13px; color: var(--rr-muted); cursor: pointer; display: flex; align-items: center; gap: 8px;">
                        <input type="checkbox" name="remember" style="accent-color: #000;"> Stay signed in
                    </label>
                    <a href="#" style="font-size: 13px; color: var(--rr-secondary); font-weight: 600; text-decoration: none;">Reset?</a>
                </div>

                <button type="submit" class="btn-login">
                    Authenticate <i class="fas fa-arrow-right"></i>
                </button>
            </form>

            <div style="text-align: center; margin-top: 30px; border-top: 1px solid #f1f5f9; padding-top: 20px;">
                <p style="font-size: 12px; color: #94a3b8;">&copy; 2026 Socialyt HQ. Secure Environment.</p>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const pwd = document.getElementById('password');
    const icon = document.getElementById('toggleIcon');
    if (pwd.type === 'password') {
        pwd.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        pwd.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}

// Simple alert auto-close
setTimeout(() => {
    const alert = document.getElementById('alertMessage');
    if (alert) alert.style.display = 'none';
}, 5000);
</script>
@endsection