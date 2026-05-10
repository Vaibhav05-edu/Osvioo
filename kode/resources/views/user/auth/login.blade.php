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
            <div class="plixi-form-container">
                <!-- Sharp Vibrant Logo -->
                <div class="plixi-logo-row mb-5">
                    <svg width="42" height="42" viewBox="0 0 40 40" fill="none" style="filter: drop-shadow(0 2px 4px rgba(0,0,0,0.05));">
                        <path d="M28 12C25.2 12 22.8 13.3 21.2 15.4C19.6 17.5 18.6 20.2 18.6 23.1C18.6 26 19.6 28.7 21.2 30.8C22.8 32.9 25.2 34.2 28 34.2C33.3 34.2 37.6 29.9 37.6 24.6C37.6 19.3 33.3 15 28 15V12ZM12 12C6.7 12 2.4 16.3 2.4 21.6C2.4 26.9 6.7 31.2 12 31.2C14.8 31.2 17.2 29.9 18.8 27.8C20.4 25.7 21.4 23 21.4 20.1C21.4 17.2 20.4 14.5 18.8 12.4C17.2 10.3 14.8 9 12 9V12ZM28 31C26 31 24.4 30 23.3 28.5C22.2 27 21.5 25.1 21.5 23.1C21.5 21.1 22.2 19.2 23.3 17.7C24.4 16.2 26 15.2 28 15.2C31.9 15.2 35 18.3 35 22.2C35 26.1 31.9 29.2 28 29.2V31ZM12 29.4C8.1 29.4 5 26.3 5 22.4C5 18.5 8.1 15.4 12 15.4C14 15.4 15.6 16.4 16.7 17.9C17.8 19.4 18.5 21.3 18.5 23.3C18.5 25.3 17.8 27.2 16.7 28.7C15.6 30.2 14 31.2 12 31.2V29.4Z" fill="url(#plixi_grad_sharp)"/>
                        <defs>
                            <linearGradient id="plixi_grad_sharp" x1="0" y1="0" x2="40" y2="40" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#FF0080"/> <!-- Sharp Magenta -->
                                <stop offset="1" stop-color="#0066FF"/> <!-- Deep Vibrant Blue -->
                            </linearGradient>
                        </defs>
                    </svg>
                    <span class="plixi-text-logo" style="color: #0F172A !important;">socialyt</span>
                </div>

                <h2 class="plixi-form-title mb-4">Log in to Socialyt</h2>

                <!-- Google Button (Always Visible for UI fidelity) -->
                <a href="{{route('auth.social.login', 'google')}}" class="plixi-google-btn mb-4">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg" alt="G">
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
                            <input type="password" name="password" class="plixi-form-input" placeholder="Enter your password" required>
                            <i class="bi bi-eye position-absolute top-50 end-0 translate-middle-y me-3 text-muted" style="cursor:pointer"></i>
                        </div>
                    </div>

                    <button type="submit" class="plixi-btn-primary">Log In</button>
                </form>

                <p class="plixi-auth-footer mt-5 text-center">
                    Don't have an account? <a href="{{route('auth.register')}}">Start Growing</a>
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

                <div class="plixi-promo-footer">
                    <p class="plixi-trusted-label">TRUSTED BY 35,000+ INSTAGRAMMERS & BUSINESSES</p>
                    <div class="plixi-logo-grid">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/c/c5/Ikea_logo.svg" height="22" alt="IKEA">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/b/b1/Revolut_Logo.svg" height="22" alt="Revolut">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/e/e5/NASA_logo.svg" height="35" alt="NASA">
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
        padding: 12px 15px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.95rem;
        color: #111;
        transition: all 0.2s;
    }
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
        background: #5D5AF1 !important; /* Exact Plixi Violet-Blue */
        color: #ffffff !important;
    }

    .plixi-promo-content {
        max-width: 620px;
    }

    .plixi-promo-h1 {
        font-weight: 900;
        font-size: 4.2rem; /* Exact massive scale */
        line-height: 1.05;
        letter-spacing: -3px;
        margin-bottom: 45px;
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
