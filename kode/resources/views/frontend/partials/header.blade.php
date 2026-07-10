@php
    $currencies = site_currencies()->where("code",'!=',session()->get('currency')->code);
    $lastSegment = collect(request()->segments())->last();
    $lang         = $active_languages->where('code',session()->get('locale'));
    $code         = count(value: $lang)!=0 ? $lang->first()->code:"en";
    $languages    = $active_languages->where('status',App\Enums\StatusEnum::true->status())
                              ->where('code','!=', $code);
@endphp

<!-- PREMIUM ANNOUNCEMENT BAR -->
<div class="announcement-bar-wishlink">
    <div class="container-fluid text-center p-2">
        <p class="mb-0 fs-14 fw-semibold text-dark d-flex align-items-center justify-content-center gap-2">
            <span class="announcement-badge">OFFER</span>
            🔥 40% Extra Credits Every Month 💰 Limited Time Offer. 
            <a href="{{route('plan')}}" class="text-dark text-decoration-underline ms-2">Claim Now →</a>
        </p>
    </div>
</div>

<header class="header-wishlink animate__animated animate__fadeInDown">
    <div class="container-fluid px-lg-5">
        <nav class="navbar navbar-expand-lg border-0 bg-transparent">
            <div class="container-fluid px-0">
                <!-- Logo -->
                <a class="navbar-brand me-5" href="{{route('home')}}">
                    <span class="osvioo-logo-script">Osvioo</span>
                </a>

                <!-- Mobile Toggle -->
                <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#wishlinkNav">
                    <span class="bi bi-list fs-1"></span>
                </button>

                <!-- Nav Items -->
                <div class="collapse navbar-collapse" id="wishlinkNav">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-lg-4 align-items-center">
                        <li class="nav-item">
                            <a class="nav-link-wishlink {{ request()->routeIs('home') ? 'active-pill' : '' }}" href="{{route('home')}}">Creators</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-wishlink {{ request()->routeIs('plan') || request()->routeIs('user.plan') ? 'active-pill' : '' }}" href="{{ auth_user('web') ? route('user.plan') : route('plan') }}">Pricing</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-wishlink {{ request()->routeIs('affiliate') ? 'active-pill' : '' }}" href="{{route('affiliate')}}">Affiliate</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-wishlink d-lg-none" href="{{route('auth.login')}}">Login</a>
                        </li>
                    </ul>

                    <!-- Action Buttons -->
                    <div class="d-flex align-items-center gap-3">
                        @if(!auth_user('web'))
                            <a href="{{route('auth.login')}}" class="nav-link-wishlink d-none d-lg-block me-3">Login</a>
                            <a href="{{route('plan')}}" class="get-started-btn-wishlink">
                                Get Started Free
                            </a>
                        @else
                             <a href="{{route('user.home')}}" class="get-started-btn-wishlink">
                                Dashboard
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>

<style nonce="{{ csp_nonce() }}">
    /* GLOBAL MASTER HEADER & LOGO RESTORE */
    .osvioo-logo-script {
        font-family: 'Caveat', cursive !important;
        color: #0052FF !important;
        font-size: 1.8rem !important;
        vertical-align: middle !important;
        text-decoration: none !important;
    }

    .header-wishlink {
        position: sticky !important;
        top: 0 !important;
        z-index: 1050 !important;
        background: #FFFFFF !important;
        border-bottom: 1px solid rgba(0,0,0,0.05) !important;
        padding: 0 !important;
        margin: 0 !important;
        min-height: 48px !important;
        display: flex !important;
        align-items: center !important;
    }
    .header-wishlink .container-fluid {
        max-width: 1350px !important;
        margin: 0 auto !important;
        padding-top: 0 !important;
        padding-bottom: 0 !important;
    }

    .announcement-bar-wishlink {
        position: relative !important;
        z-index: 1060 !important;
        background: #FFFFFF !important;
        border-top: 5px solid #FFD200 !important;
        border-bottom: 5px solid #FFD200 !important;
        margin: 0 !important;
        padding: 4px 0 !important;
    }
    .announcement-bar-wishlink p {
        font-size: 0.95rem !important;
        font-weight: 700 !important;
        margin-bottom: 0 !important;
        color: #1A1A1A !important;
    }
    .announcement-badge {
        border: 1px solid #E2E8F0 !important;
        background: #F8FAFC !important;
        padding: 2px 10px !important;
        border-radius: 6px !important;
        color: #000 !important;
        font-weight: 900 !important;
        font-size: 0.7rem !important;
        margin-right: 10px !important;
        text-transform: uppercase;
    }

    .nav-link-wishlink {
        font-family: 'Inter', sans-serif !important;
        font-weight: 700 !important;
        font-size: 0.9rem !important;
        color: #1A1A1A !important;
        text-decoration: none !important;
        padding: 6px 12px !important;
        transition: all 0.3s ease;
    }
    .nav-link-wishlink:hover { color: #0052FF !important; }
    .nav-link-wishlink.blue-text { color: #0052FF !important; }

    .active-pill {
        background: #FFD200 !important;
        color: #000 !important;
        border-radius: 10px !important;
        padding: 6px 18px !important;
        font-weight: 800 !important;
        font-size: 0.85rem !important;
        box-shadow: 0 4px 10px rgba(255, 210, 0, 0.1) !important;
    }

    .get-started-btn-wishlink {
        background: #0052FF !important;
        color: #FFFFFF !important;
        padding: 8px 22px !important;
        border-radius: 50px !important;
        font-weight: 800 !important;
        font-size: 0.85rem !important;
        text-decoration: none !important;
        transition: all 0.3s ease !important;
    }
    .get-started-btn-wishlink:hover { transform: scale(1.05); color: #fff !important; }

    .navbar { padding: 0 !important; }

    @media (max-width: 991px) {
        .header-wishlink { min-height: auto !important; padding: 10px 0 !important; }
        .navbar-collapse {
            background: #FFFFFF;
            padding: 20px;
            border-radius: 20px;
            margin-top: 15px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
    }
</style>
