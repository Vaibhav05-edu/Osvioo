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
        <p class="mb-0 fs-14 fw-semibold text-white d-flex align-items-center justify-content-center gap-2">
            <span class="announcement-badge">NEW</span>
            🔥 Join 10,000+ Top Creators & 10x your sales with AI-Automation. 
            <a href="{{route('auth.register')}}" class="text-white text-decoration-underline ms-2">Get Started Free →</a>
        </p>
    </div>
</div>

<header class="header-wishlink animate__animated animate__fadeInDown">
    <div class="container-fluid px-lg-5">
        <nav class="navbar navbar-expand-lg border-0 bg-transparent">
            <div class="container-fluid px-0">
                <!-- Logo -->
                <a class="navbar-brand me-5" href="{{route('home')}}">
                    <span class="socialyt-logo-script">Socialyt</span>
                </a>

                <!-- Mobile Toggle -->
                <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#wishlinkNav">
                    <span class="bi bi-list fs-1"></span>
                </button>

                <!-- Nav Items -->
                <div class="collapse navbar-collapse" id="wishlinkNav">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-lg-4 align-items-center">
                        <li class="nav-item">
                            <a class="nav-link-wishlink active-pill" href="#">Creators</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-wishlink" href="#">Brands</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-wishlink" href="#">Partnerships</a>
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
    .header-wishlink {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1000;
        background: transparent !important;
        border: none !important;
        padding: 20px 0;
    }

    .nav-link-wishlink {
        font-family: 'Outfit', sans-serif !important;
        font-weight: 600;
        font-size: 1.05rem;
        color: #1A1A1A !important;
        text-decoration: none;
        transition: all 0.3s ease;
        padding: 8px 15px;
    }

    .nav-link-wishlink:hover {
        color: var(--wishlink-orange) !important;
        transform: translateY(-1px);
    }

    /* THE YELLOW ACTIVE PILL */
    .active-pill {
        background: #FFD200 !important;
        border-radius: 12px;
        padding: 10px 25px !important;
        color: #000 !important;
        box-shadow: 0 4px 10px rgba(255, 210, 0, 0.2);
    }

    /* THE WHITE GET STARTED BUTTON */
    .get-started-btn-wishlink {
        background: #fff !important;
        color: #0066FF !important; /* Premium Blue or Orange as per user preference */
        padding: 12px 28px;
        border-radius: 50px;
        font-weight: 800;
        text-decoration: none;
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: none;
        display: inline-block;
    }

    .get-started-btn-wishlink:hover {
        transform: scale(1.05);
        box-shadow: 0 15px 30px rgba(0,0,0,0.12);
        color: #0052CC !important;
    }

    /* Sticky behavior override */
    .header.sticky {
        background: var(--wishlink-cream) !important;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        padding: 10px 0;
    }

    @media (max-width: 991px) {
        .header-wishlink {
            position: relative;
            background: var(--wishlink-cream) !important;
        }
        .navbar-collapse {
            background: var(--wishlink-cream);
            padding: 20px;
            border-radius: 20px;
            margin-top: 15px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
        .nav-link-wishlink {
            padding: 15px 0;
            display: block;
            text-align: center;
        }
        .active-pill {
            display: inline-block;
            margin-bottom: 10px;
        }
    }
</style>
