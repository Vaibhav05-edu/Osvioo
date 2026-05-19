@extends('layouts.master')
@section('content')

@php
    $authContent     =  get_content("content_authentication_section")->first();
    $socialProviders =  json_decode(site_settings('social_login_with'),true);
    $mediums = [];
    foreach($socialProviders as $key=>$login_medium){
        if($login_medium['status'] == App\Enums\StatusEnum::true->status()){
            array_push($mediums, str_replace('_oauth',"",$key));
        }
    }
    $socialAuth           = (site_settings('social_login'));
    $googleCaptcha        = (object) json_decode(site_settings("google_recaptcha"));
    $captcha              = (site_settings('captcha_with_registration'));
    $defaultcaptcha       = (site_settings('default_recaptcha'));
    $geoCountry           = Arr::get(get_ip_info() , "country",'');
    $countries            = get_countries();
    $termsPage            = App\Models\Admin\Page::active()
                                   ->where('slug',"terms-and-conditions")
                                   ->first();
@endphp

<section class="plixi-master-final">
    <div class="row g-0 min-vh-100">
        <!-- LEFT PANEL (Promo) -->
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

        <div class="col-lg-6 d-flex align-items-center justify-content-center bg-white p-lg-5 p-4">
            <div class="plixi-form-container glass-card p-lg-5 p-4">
                <!-- Sharp Vibrant Logo -->
                <div class="plixi-logo-row mb-4">
                    <div class="logo-icon-wrapper d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; background: var(--primary-gradient); border-radius: 12px; box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM12 20C7.59 20 4 16.41 4 12C4 7.59 7.59 4 12 4C16.41 4 20 7.59 20 12C20 16.41 16.41 20 12 20Z" fill="white"/>
                        </svg>
                    </div>
                    <span class="gradient-text plixi-text-logo">osvioo</span>
                </div>

                <h2 class="plixi-form-title mb-1">Create your Account</h2>
                <p class="text-muted mb-4 fs-0-9rem">Uncover the untapped potential of your growth to connect with clients.</p>

                <form action="{{route('auth.register.store')}}" method="POST" id="login-form">
                    @csrf
                    <input hidden type="text" name="referral_code" value="{{request()->route('referral_code')}}">
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="plixi-form-label">Full Name</label>
                            <div class="position-relative">
                                <input type="text" name="name" value="{{old('name')}}" class="plixi-form-input ps-5" placeholder="Enter name" required>
                                <i class="bi bi-person position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="plixi-form-label">Username</label>
                            <div class="position-relative">
                                <input type="text" name="username" value="{{old('username')}}" class="plixi-form-input ps-5" placeholder="Enter username" required>
                                <i class="bi bi-person-badge position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="plixi-form-label">Email Address</label>
                            <div class="position-relative">
                                <input type="email" name="email" value="{{old('email')}}" class="plixi-form-input ps-5" placeholder="Enter email" required>
                                <i class="bi bi-envelope position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="plixi-form-label">Phone Number</label>
                            <div class="position-relative">
                                <input type="text" name="phone" value="{{old('phone')}}" class="plixi-form-input ps-5" placeholder="Enter phone" required>
                                <i class="bi bi-telephone position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="plixi-form-label">Country</label>
                            <div class="position-relative">
                                <i class="bi bi-globe position-absolute top-50 translate-middle-y text-muted" style="left: 18px; z-index: 10;"></i>
                                <select class="plixi-form-input ps-5 select-two" name="country_id" id="country_id">
                                    <option value="">Select country</option>
                                    @foreach ($countries as $country)
                                        <option {{ strtolower($geoCountry) == strtolower($country->name) || old("country_id") == $country->id ? 'selected' :""}} value="{{$country->id}}">
                                            {{ $country->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="plixi-form-label">Password</label>
                            <div class="position-relative">
                                <input type="password" name="password" class="plixi-form-input ps-5" placeholder="Password" required>
                                <i class="bi bi-lock position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="plixi-form-label">Confirm Password</label>
                            <div class="position-relative">
                                <input type="password" name="password_confirmation" class="plixi-form-input ps-5" placeholder="Confirm" required>
                                <i class="bi bi-shield-check position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                            </div>
                        </div>
                    </div>

                    <div class="auth-checkbox mt-4 mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="terms_condition" value="1" name="terms_condition" required>
                            <label class="form-check-label fs-0-85rem fw-600 text-muted" for="terms_condition">
                                By completing the registration process, you agree and accept our
                                @if($termsPage)
                                    <a href="{{route('page',$termsPage->slug)}}" class="text-primary"> {{$termsPage->title}}</a>
                                @endif
                            </label>
                        </div>
                    </div>

                    @if($captcha == App\Enums\StatusEnum::true->status() && $defaultcaptcha == App\Enums\StatusEnum::true->status())
                        <div class="row align-items-center g-3 mb-4">
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center gap-2">
                                    <img class="rounded border" src="{{ route('captcha.genarate',1) }}" alt="" id="default-captcha">
                                    <button type="button" id="genarate-captcha" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-repeat"></i></button>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <input type="text" class="plixi-form-input" required name="default_captcha_code" placeholder="Enter captcha" autocomplete="off">
                            </div>
                        </div>
                    @endif

                    <button type="submit" class="plixi-submit-btn frosted-btn py-3">Register</button>
                </form>

                @if($socialAuth == App\Enums\StatusEnum::true->status())
                    <div class="plixi-divider-row mt-4 mb-4">
                        <div class="plixi-line"></div>
                        <span>OR</span>
                        <div class="plixi-line"></div>
                    </div>

                    <div class="d-flex flex-column gap-2">
                        @foreach($mediums as $medium)
                            <a href="{{route('auth.social.login', $medium)}}" class="plixi-google-btn frosted-btn-outline">
                                <i class="bi bi-{{$medium}} fs-5"></i>
                                <span>Sign up with {{ucfirst($medium)}}</span>
                            </a>
                        @endforeach
                    </div>
                @endif

                <p class="plixi-auth-footer mt-5 text-center">
                    Already Have An Account? <a href="{{route('auth.login')}}">Log In</a>
                </p>
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
        max-width: 520px; /* Slightly wider for registration grid */
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
    .plixi-form-input.ps-5 {
        padding-left: 65px !important;
    }
    .plixi-form-input:focus { border-color: #7c3aed; outline: none; box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1); }

    /* Fix for Select2 with Icon */
    .select2-container--default .select2-selection--single,
    .select2-container .select2-selection--single {
        height: 48px !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 8px !important;
        display: flex !important;
        align-items: center !important;
        background-color: transparent !important;
    }
    .select2-container .select2-selection--single .select2-selection__rendered,
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        padding-left: 65px !important;
        color: #111 !important;
        font-size: 0.95rem !important;
        line-height: 48px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 46px !important;
        top: 1px !important;
    }
    .select2-container {
        width: 100% !important;
    }
    select.ps-5 {
        padding-left: 65px !important;
        text-indent: 45px !important;
    }

    .form-check-input {
        width: 1.25rem !important;
        height: 1.25rem !important;
        cursor: pointer;
        border: 1px solid #cbd5e1 !important;
    }
    .form-check-input:checked {
        background-color: #7c3aed !important;
        border-color: #7c3aed !important;
    }

    .plixi-submit-btn {
        width: 100%;
        background: #6D28D9;
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
        opacity: 0.85;
        line-height: 1.5; 
        font-weight: 500;
        color: #ffffff !important;
    }

    .fs-0-85rem { font-size: 0.85rem; }
    .fs-0-9rem { font-size: 0.9rem; }
    .fw-600 { font-weight: 600; }

    @media (max-width: 991px) {
        .plixi-promo-h1 { font-size: 2.8rem; letter-spacing: -1.5px; }
        .plixi-form-container { padding: 20px; }
    }
</style>

@endsection

@if($captcha == App\Enums\StatusEnum::true->status() && $defaultcaptcha != App\Enums\StatusEnum::true->status() && $googleCaptcha->status == App\Enums\StatusEnum::true->status())
    @push('script-include')
        <script nonce="{{ csp_nonce() }}" src="https://www.google.com/recaptcha/api.js"></script>
    @endpush
@endif

@push('script-push')
  @if($captcha == App\Enums\StatusEnum::true->status() && $defaultcaptcha != App\Enums\StatusEnum::true->status() && $googleCaptcha->status == App\Enums\StatusEnum::true->status())
      <script nonce="{{ csp_nonce() }}" >
          'use strict'
          function onSubmit(token) {
            document.getElementById("login-form").submit();
          }
      </script>
    @endif
@endpush

