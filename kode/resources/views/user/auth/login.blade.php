@extends('layouts.master')

@section('content')

@php
    $authContent     =  get_content("content_authentication_section")->first();
    $loginAttributes =  json_decode(site_settings('login_with'),true);
    $socialProviders =  json_decode(site_settings('social_login_with'),true);
    $mediums = [];
    foreach($socialProviders as $key=>$login_medium){
        if($login_medium['status'] == App\Enums\StatusEnum::true->status()){
            array_push($mediums, str_replace('_oauth',"",$key));
        }
    }
    $socialAuth           =  (site_settings('social_login'));
@endphp

<section class="plixi-master-final">
    <div class="row g-0 min-vh-100">
        <!-- LEFT PANEL -->
        <div class="col-lg-6 d-flex align-items-center justify-content-center bg-white p-5">
            <div class="plixi-form-container glass-card p-5">
                <!-- Sharp Vibrant Logo -->
                <div class="plixi-logo-row mb-5">
                    <div class="logo-icon-wrapper d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; background: var(--primary-gradient); border-radius: 12px; box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM12 20C7.59 20 4 16.41 4 12C4 7.59 7.59 4 12 4C16.41 4 20 7.59 20 12C20 16.41 16.41 20 12 20Z" fill="white"/>
                        </svg>
                    </div>
                    <span class="gradient-text plixi-text-logo">osvioo</span>
                </div>

                <h2 class="plixi-form-title mb-4">Log in to Osvioo</h2>

                <!-- Google Button (Always Visible for UI fidelity) -->
                <a href="{{route('auth.social.login', 'google')}}" class="plixi-google-btn mb-4 frosted-btn-outline">
                    <i class="bi bi-google fs-5"></i>
                    <span>Sign in with Google</span>
                </a>

                <div class="plixi-divider-row mb-4">
                    <div class="plixi-line"></div>
                    <span>OR</span>
                    <div class="plixi-line"></div>
                </div>

                <form action="{{route('auth.authenticate')}}" method="POST" id="login-form">
                    @csrf
                    <div class="mb-4">
                        <label class="plixi-form-label">Email Address</label>
                        <input type="text" name="login_data" class="plixi-form-input" placeholder="Enter your email address" required>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between">
                            <label class="plixi-form-label">Password</label>
                            <a href="{{route('auth.password.request')}}" class="plixi-forgot-link">Forgot password?</a>
                        </div>
                        <div class="position-relative">
                            <input type="password" name="password" id="login-password" class="plixi-form-input pe-5" placeholder="Enter your password" required>
                            <i class="bi bi-eye position-absolute top-50 end-0 translate-middle-y me-4 text-muted" id="togglePassword" style="cursor:pointer; z-index: 10;"></i>
                        </div>
                    </div>

                    <button type="submit" class="plixi-submit-btn frosted-btn w-100 py-3">Log In</button>
                </form>

                <p class="plixi-auth-footer mt-5 text-center">
                    Don't have an account? <a href="{{route('auth.register')}}" class="gradient-text">Start Growing</a>
                </p>
            </div>
        </div>

        <!-- RIGHT PANEL -->
        <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center plixi-promo-panel p-5">
            <div class="plixi-promo-content">
                <h1 class="plixi-promo-h1">Your own Instagram team. Grow 10x faster automatically.</h1>
                
                <div class="plixi-promo-divider">
                    /////////////////////////////////////
                </div>

                <div class="plixi-features-list">
                    <div class="plixi-feature-row">
                        <div class="plixi-feature-icon">👍</div>
                        <div class="plixi-feature-text">
                            <h3>Guaranteed growth.</h3>
                            <p>Our patent-pending* growth engine attracts real people with a real interest in your account from day 1.</p>
                        </div>
                    </div>

                    <div class="plixi-feature-row">
                        <div class="plixi-feature-icon">⏳</div>
                        <div class="plixi-feature-text">
                            <h3>Faster & automated.</h3>
                            <p>Just sit back and let our experts do the Instagram growth for you. Focus on more important things.</p>
                        </div>
                    </div>

                    <div class="plixi-feature-row">
                        <div class="plixi-feature-icon">📮</div>
                        <div class="plixi-feature-text">
                            <h3>Get growth reports.</h3>
                            <p>We'll send you periodic updates via email. You can also come back and check the results every once in a while 😉</p>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</section>

<style nonce="{{ csp_nonce() }}">
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap');

    .plixi-master-final {
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        background: #fff;
    }

    .plixi-form-container {
        width: 100%;
        max-width: 420px;
    }

    .plixi-logo-row {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .plixi-text-logo {
        font-weight: 800;
        font-size: 2.2rem;
        color: #111;
        letter-spacing: -1.5px;
        line-height: 1;
    }

    .plixi-form-title {
        font-weight: 800;
        font-size: 1.4rem;
        color: #111;
        letter-spacing: -0.5px;
    }

    .plixi-google-btn {
        width: 100%;
        padding: 10px;
        border: 1px solid #7c3aed;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-decoration: none !important;
        font-weight: 700;
        font-size: 0.9rem;
        color: #4f46e5;
        transition: all 0.2s;
    }
    .plixi-google-btn:hover { background: #f5f3ff; }
    .plixi-google-btn img { width: 18px; }

    .plixi-divider-row {
        display: flex;
        align-items: center;
        gap: 15px;
        color: #ccc;
    }
    .plixi-line { flex: 1; height: 1px; background: #eee; }
    .plixi-divider-row span { font-size: 0.75rem; font-weight: 700; color: #999; }

    .plixi-form-label {
        font-weight: 600;
        font-size: 0.85rem;
        color: #333;
        margin-bottom: 5px;
        display: block;
    }

    .plixi-form-input {
        width: 100%;
        padding: 12px 45px 12px 15px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.95rem;
        color: #111;
        transition: all 0.2s;
        background: transparent;
    }
    #togglePassword {
        font-size: 1.1rem;
        right: 14px !important;
        transform: translateY(-50%);
        top: 50% !important;
        color: #888;
        user-select: none;
    }
    #togglePassword:hover { color: #7c3aed; }
    .plixi-form-input:focus { border-color: #7c3aed; outline: none; box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1); }

    .plixi-forgot-link {
        color: #7c3aed;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.8rem;
    }

    .plixi-submit-btn {
        width: 100%;
        background: #6D28D9; /* Vibrant Purple from Plixi */
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 15px;
        font-weight: 800;
        font-size: 1.05rem;
        transition: all 0.2s;
        margin-top: 10px;
    }
    .plixi-submit-btn:hover { 
        background: #5B21B6; 
        transform: translateY(-1px); 
        box-shadow: 0 10px 20px rgba(109, 40, 217, 0.2);
    }

    .plixi-auth-footer { font-size: 0.9rem; color: #666; font-weight: 600; }
    .plixi-auth-footer a { color: #7c3aed; text-decoration: none; font-weight: 700; }

    /* VIOLET SECTION MASTER CLONE */
    .plixi-promo-panel {
        background: var(--primary-gradient) !important;
        color: #ffffff !important;
    }

    .plixi-promo-content {
        max-width: 620px;
    }

    .plixi-promo-h1 {
        font-family: 'Outfit', sans-serif !important;
        font-weight: 500;
        font-size: 3.4rem;
        line-height: 1.2;
        letter-spacing: -1px;
        margin-bottom: 35px;
        color: #ffffff !important;
    }

    .plixi-promo-divider {
        color: rgba(255, 255, 255, 0.2);
        letter-spacing: 2px;
        font-size: 1.4rem;
        margin-bottom: 45px;
    }

    .plixi-feature-row {
        display: flex;
        gap: 25px;
        margin-bottom: 40px;
    }
    .plixi-feature-icon { 
        font-size: 2.8rem; 
        line-height: 1;
    }
    .plixi-feature-text h3 { 
        font-weight: 800; 
        font-size: 1.5rem; 
        margin-bottom: 6px; 
        color: #ffffff !important;
    }
    .plixi-feature-text p { 
        font-size: 1.15rem; 
        opacity: 0.85; /* Subtle description text */
        line-height: 1.5; 
        font-weight: 500;
        color: #ffffff !important;
    }

    .plixi-promo-footer {
        margin-top: 60px;
    }
    .plixi-trusted-label {
        font-weight: 900;
        font-size: 0.85rem;
        letter-spacing: 1.5px;
        color: rgba(255, 255, 255, 0.7);
        margin-bottom: 30px;
        text-transform: uppercase;
    }
    .plixi-logo-grid {
        display: flex;
        align-items: center;
        gap: 50px;
        filter: brightness(0) invert(1); /* Force White Logos */
        opacity: 0.9;
    }

    @media (max-width: 991px) {
        .plixi-promo-h1 { font-size: 2.8rem; letter-spacing: -1.5px; }
        .plixi-form-container { padding: 20px; }
    }
</style>
@endsection

@push('script-push')
<script nonce="{{ csp_nonce() }}">
    document.getElementById('togglePassword').addEventListener('click', function () {
        const password = document.getElementById('login-password');
        if (password) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        }
    });
</script>
@endpush
