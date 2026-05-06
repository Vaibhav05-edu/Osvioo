<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Socialyt - Instagram & Facebook DM Automation</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playball&family=Syne:wght@700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}?v={{ time() }}" />
    <style nonce="{{ csp_nonce() }}">
      .navbar-custom.sticky-top { top: 0; z-index: 1020; }

      .social-proof {
          position: fixed;
          bottom: 20px;
          left: 20px;
          background: white;
          padding: 8px 12px;
          border-radius: 10px;
          box-shadow: 0 10px 30px rgba(0,0,0,0.1);
          display: flex;
          align-items: center;
          gap: 10px;
          z-index: 9999;
          max-width: 250px;
          animation: slideUp 0.5s ease-out;
      }
      .social-proof img { width: 40px !important; height: 40px !important; border-radius: 8px; }
      .social-proof .text-content { font-size: 0.75rem; line-height: 1.2; }
      .social-proof .fw-bold { font-size: 0.8rem; }
      
      @keyframes slideUp {
          from { transform: translateY(100px); opacity: 0; }
          to { transform: translateY(0); opacity: 1; }
      }
    </style>
  </head>
  <body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top py-3">
      <div class="container">
        <a class="navbar-brand fw-bold fs-3" href="#" style="color: var(--primary);">Socialyt</a>
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
          <ul class="navbar-nav gap-2">
            <li class="nav-item"><a class="nav-link" href="#creators">Creators</a></li>
            <li class="nav-item"><a class="nav-link" href="#ecommerce">Ecommerce</a></li>
            <li class="nav-item"><a class="nav-link" href="#partnership">Partnership</a></li>
            <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
            <li class="nav-item"><a class="nav-link" href="#pricing">Pricing</a></li>
            <li class="nav-item"><a class="nav-link" href="#testimonials">Testimonials</a></li>
            <li class="nav-item"><a class="nav-link" href="#support">Support</a></li>
          </ul>
        </div>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('auth.login') }}" class="text-dark text-decoration-none fw-semibold d-none d-md-block">Log in</a>
            <a href="#" class="btn btn-premium">Get Started Free</a>
        </div>
      </div>
    </nav>

    <!-- Hero Section -->
    <header class="section-hero py-5 overflow-hidden" id="home">
      <div class="container pt-5">
        <div class="row align-items-center">
            <!-- Left Side: Text Content -->
            <div class="col-lg-6 text-center text-lg-start">
                <div class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill mb-4 animate__animated animate__fadeInDown">
                    🚀 {{ $settings->cta_text ?? '#1 Meta Automation Tool' }}
                </div>
                <!-- Line 1: Headline -->
                <h1 class="hero-title display-4 fw-bold mb-2">{{ $settings->headline_1 ?? 'AI that helps you grow' }}</h1>
                <!-- Line 2: Subheadline -->
                <div class="playball-accent display-6 mb-4" style="color: #FF9500; font-family: 'Playball', cursive;">
                    {{ $settings->headline_2 ?? 'That Grows You Faster' }}
                </div>

                <!-- Typing Animation Section -->
                <div class="mb-4" style="min-height: 50px; display: flex; align-items: center; justify-content: start;">
                    <span id="typing-text-welcome" class="premium-typing-text"></span>
                </div>

                <script nonce="{{ csp_nonce() }}">
                    (function() {
                        const texts = ["AI helps you grow", "AI creates media kit", "AI auto DM"];
                        const target = document.getElementById('typing-text-welcome');
                        let tIndex = 0, cIndex = 0, deleting = false;
                        
                        function doType() {
                            if(!target) return;
                            const fullText = texts[tIndex];
                            target.textContent = deleting ? fullText.substring(0, cIndex - 1) : fullText.substring(0, cIndex + 1);
                            cIndex = deleting ? cIndex - 1 : cIndex + 1;
                            
                            let speed = deleting ? 50 : 100;
                            if (!deleting && cIndex === fullText.length) { deleting = true; speed = 2000; }
                            else if (deleting && cIndex === 0) { deleting = false; tIndex = (tIndex + 1) % texts.length; speed = 500; }
                            setTimeout(doType, speed);
                        }
                        setTimeout(doType, 1000);
                    })();
                </script>

                <style nonce="{{ csp_nonce() }}">
                    .premium-typing-text {
                        font-family: 'Syne', sans-serif !important;
                        font-size: 2.2rem !important;
                        font-weight: 800 !important;
                        color: #FF9500 !important;
                        border-right: 3px solid #FF9500;
                        padding-right: 8px;
                        display: inline-block;
                        animation: blink-cursor 0.7s infinite;
                        line-height: 1.2;
                    }
                    @keyframes blink-cursor { 50% { border-color: transparent; } }
                </style>

                <!-- Dynamic Description -->
                <p class="lead text-muted mb-5" style="font-size: 1.1rem;">
                    {{ $settings->description ?? 'Engage your followers automatically. Reply to comments with personalized DMs, save time, and explode your conversion rates.' }}
                </p>

                <div class="d-flex justify-content-center justify-content-lg-start gap-3 mt-4">
                    <a href="{{ $settings->cta_url ?? '#' }}" class="btn btn-premium btn-lg px-5 py-3 rounded-pill shadow-lg">{{ $settings->cta_text ?? 'Start Automating Now' }}</a>
                    <a href="#features" class="btn btn-outline-premium btn-lg px-5 py-3 rounded-pill">See How it Works</a>
                </div>
            </div>

            <!-- Right Side: Influencer Image -->
            <div class="col-lg-6 mt-5 mt-lg-0">
                <div class="position-relative">
                    <img src="{{ $settings->hero_image ?? 'https://static.wixstatic.com/media/cdc6f6_0e9ea9a6ef58481b82bdc6a0442517c2~mv2.webp/v1/fill/w_1000,h_738,al_c,q_85/Group%201680482139.webp' }}" 
                         alt="Influencer" class="img-fluid mx-auto animate__animated animate__zoomIn">
                </div>
            </div>
        </div>
      </div>
    </header>

    <!-- Trusted By Section -->
    <section class="py-5 bg-white border-bottom">
        <div class="container text-center">
            <p class="text-muted small text-uppercase fw-bold mb-4" style="letter-spacing: 2px;">Official Meta Business Partner Capabilities</p>
            <div class="d-flex flex-wrap justify-content-center align-items-center gap-5 opacity-50 grayscale">
                <img src="https://upload.wikimedia.org/wikipedia/commons/b/b8/2021_Facebook_icon.svg" height="40" alt="Facebook">
                <img src="https://upload.wikimedia.org/wikipedia/commons/e/e7/Instagram_logo_2016.svg" height="40" alt="Instagram">
                <img src="https://upload.wikimedia.org/wikipedia/commons/7/7b/Meta_Platforms_Inc._logo.svg" height="30" alt="Meta">
                <img src="https://upload.wikimedia.org/wikipedia/commons/0/05/WhatsApp.svg" height="40" alt="WhatsApp">
                <div class="fs-4 fw-bold text-dark">Messenger</div>
            </div>
        </div>
    </section>

    <!-- Alternating Features (Stats & Stories) -->
    <section class="section-feature" id="features">
        <div class="container">
            <!-- How It Works Steps -->
            <div class="text-center mb-5 pb-5">
                <h2 class="fw-bold fs-1 mb-2">How It Works</h2>
                <p class="text-muted">Three simple steps to automate your growth.</p>
                
                <div class="row mt-5 g-4">
                    <!-- Step 1 -->
                    <div class="col-md-4">
                        <div class="p-4 rounded-4 bg-white border-0 shadow-sm h-100 transition-transform hover-scale">
                            <div class="mb-4 d-flex align-items-center justify-content-center">
                                <i class="fas fa-link fa-3x" style="color: #007AFF !important;"></i>
                            </div>
                            <div class="px-2 text-center">
                                <h3 class="fw-bold fs-4 mb-3">1. Connect Account</h3>
                                <p class="text-muted small px-3">Link your Instagram or Facebook account with one click using official Meta APIs.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Step 2 -->
                    <div class="col-md-4">
                        <div class="p-4 rounded-4 bg-white border-0 shadow-sm h-100 transition-transform hover-scale">
                            <div class="mb-4 d-flex align-items-center justify-content-center">
                                <i class="fas fa-bolt fa-3x" style="color: #007AFF !important;"></i>
                            </div>
                            <div class="px-2 text-center">
                                <h3 class="fw-bold fs-4 mb-3">2. Set Triggers</h3>
                                <p class="text-muted small px-3">Choose keyword triggers or auto-reply to every comment with personalized DMs.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Step 3 -->
                    <div class="col-md-4">
                        <div class="p-4 rounded-4 bg-white border-0 shadow-sm h-100 transition-transform hover-scale">
                            <div class="mb-4 d-flex align-items-center justify-content-center">
                                <i class="fas fa-chart-line fa-3x" style="color: #007AFF !important;"></i>
                            </div>
                            <div class="px-2 text-center">
                                <h3 class="fw-bold fs-4 mb-3">3. Watch Growth</h3>
                                <p class="text-muted small px-3">Sit back as Socialyt turns every interaction into a potential sale or follower.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <style nonce="{{ csp_nonce() }}">
                .hover-scale { transition: all 0.3s ease; }
                .hover-scale:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important; }
            </style>

    <!-- Detailed Solutions with Mockups (Restored Influencers) -->
    <section class="py-5 bg-white">
        <div class="container py-5">
            <div class="row align-items-center mb-5 pb-5" id="ecommerce">
                <div class="col-md-6">
                    <div class="premium-3d-card-wrapper animate__animated animate__fadeInLeft">
                        <div class="premium-3d-card">
                            <img src="{{ asset('fashion_influencer_ecommerce_red_1777912440009.png') }}" alt="Ecommerce Influencer Pro">
                        </div>
                    </div>
                </div>
                <div class="col-md-5 ms-auto">
                    <div class="feature-text">
                        <div class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill mb-3">E-Commerce</div>
                        <h2 class="fw-bold mb-3 fs-1">Turn Comments into Customers</h2>
                        <p class="text-muted fs-5">
                            Automatically send product links or discount codes to anyone who comments on your posts. Our 3D automation handles the scale while you handle the growth.
                        </p>
                        <ul class="list-unstyled mt-4 d-grid gap-2">
                            <li><i class="fas fa-check-circle text-primary me-2"></i> Instant product link delivery</li>
                            <li><i class="fas fa-check-circle text-primary me-2"></i> Automated discount code sharing</li>
                            <li><i class="fas fa-check-circle text-primary me-2"></i> 24/7 lead capture</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row align-items-center mb-5 pb-5 flex-row-reverse" id="partnership">
                <div class="col-md-6">
                    <div class="premium-3d-card-wrapper animate__animated animate__fadeInRight">
                        <div class="premium-3d-card">
                            <img src="{{ asset('fashion_influencer_partnership_gold_1777912536159.png') }}" alt="Partnership Influencer Pro">
                        </div>
                    </div>
                </div>
                <div class="col-md-5 me-auto">
                    <div class="feature-text">
                        <div class="badge bg-warning-subtle text-warning px-3 py-2 rounded-pill mb-3">Partnerships</div>
                        <h2 class="fw-bold mb-3 fs-1">Collab Success Guaranteed</h2>
                        <p class="text-muted fs-5">
                            Display up to 4 conversation starters when a user navigates to your Instagram Inbox. Designed for elite creators managing high-volume collab inquiries.
                        </p>
                        <ul class="list-unstyled mt-4 d-grid gap-2">
                            <li><i class="fas fa-check-circle text-primary me-2"></i> Dynamic FAQ starters</li>
                            <li><i class="fas fa-check-circle text-primary me-2"></i> Partnership inquiry routing</li>
                            <li><i class="fas fa-check-circle text-primary me-2"></i> Higher inbox response rates</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Feature Breakdown (LinkDM Exact Master Clone) -->
    <section class="linkdm-section">
        <div class="container">
            <div class="text-center mb-5 pb-5">
                <div class="linkdm-eyebrow">FEATURE FOCUS</div>
                <h2 class="linkdm-title-main">Feature Breakdown</h2>
                <p class="linkdm-subtitle">Dive into the specifics of each feature, understanding its functionality and how it can elevate your Instagram strategy.</p>
            </div>

            <!-- Auto-Reply to Instagram Reel Comments -->
            <div class="row align-items-center mb-5 pb-5">
                <div class="col-md-6">
                    <div class="linkdm-clone-wrapper">
                        <!-- Textured Halo -->
                        <div class="textured-halo"></div>
                        
                        <!-- Dashed Line -->
                        <svg class="dashed-line-svg" viewBox="0 0 400 400" style="opacity: 0.5;">
                            <path d="M280 200 Q380 200 380 300" stroke="#0084FF" stroke-width="2" stroke-dasharray="10 10" fill="transparent" />
                        </svg>
                        
                        <!-- 3D Phone Card -->
                        <div class="linkdm-phone-3d-card animate__animated animate__fadeInLeft">
                            <img src="{{ asset('hot_influencer_reel.jpg') }}" alt="Vibrant Content">
                        </div>
                        
                        <!-- Floating Zoom Card -->
                        <div class="linkdm-floating-card profile-card animate__animated animate__fadeInRight">
                            <div class="notification-badge-red">1</div>
                            <img src="{{ asset('hot_influencer_reel.jpg') }}" style="height: 180px; object-fit: cover;" alt="Zoom">
                            <div class="p-3 bg-white">
                                <div class="fw-bold small">DM Sent! 🚀</div>
                                <div class="x-small text-muted">Reply SHOP to get link</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 ms-auto">
                    <h2 class="linkdm-feature-heading">Auto-Reply to Instagram Reel Comments</h2>
                    <p class="linkdm-feature-text">
                        Reply to Instagram reel comments automatically with a DM sent straight to the users inbox. Add trigger keywords or respond to all comments.
                    </p>
                </div>
            </div>

            <!-- Inbox Starters -->
            <div class="row align-items-center mb-5 pb-5">
                <div class="col-md-6">
                    <div class="linkdm-clone-wrapper">
                        <!-- Textured Halo (Gold) -->
                        <div class="textured-halo halo-gold"></div>
                        
                        <div class="linkdm-phone-3d-card animate__animated animate__fadeInLeft">
                            <img src="{{ asset('hot_influencer_inbox.jpg') }}" alt="Inbox Content">
                        </div>
                        
                        <!-- Floating Inbox Thread -->
                        <div class="linkdm-floating-card inbox-card animate__animated animate__fadeInRight">
                            <div class="notification-badge-red">1</div>
                            <div class="p-3 bg-white">
                                <div class="fw-bold small mb-2 border-bottom pb-2">Inbox Starters</div>
                                <div class="d-grid gap-2">
                                    <div class="bg-light p-2 rounded small fw-bold text-primary">Visit website</div>
                                    <div class="bg-light p-2 rounded small fw-bold text-primary">View releases</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 ms-auto">
                    <h2 class="linkdm-feature-heading">Inbox Starters</h2>
                    <p class="linkdm-feature-text">
                        Display up to 4 conversation starters when a user navigates to your Instagram Inbox.
                    </p>
                </div>
            </div>

            <!-- Auto-Reply to Sponsored Ad Comments -->
            <div class="row align-items-center mb-5 pb-5 flex-row-reverse">
                <div class="col-md-6">
                    <div class="linkdm-clone-wrapper">
                        <!-- Textured Halo (Red) -->
                        <div class="textured-halo halo-red"></div>
                        
                        <div class="linkdm-phone-3d-card animate__animated animate__fadeInRight">
                            <img src="{{ asset('hot_influencer_ad.jpg') }}" style="filter: brightness(0.9) contrast(1.1);" alt="Ad Content">
                        </div>
                        
                        <!-- Floating Ad Card -->
                        <div class="linkdm-floating-card ad-card animate__animated animate__fadeInLeft">
                            <div class="notification-badge-red">1</div>
                            <img src="https://images.unsplash.com/photo-1511499767150-a48a237f0083?q=80&w=600&auto=format&fit=crop" style="height: 150px; object-fit: cover;" alt="Product">
                            <div class="p-3 bg-white text-center">
                                <div class="fw-bold small mb-2">Designer Sunglasses</div>
                                <button class="btn btn-dark btn-sm w-100 rounded-pill">Shop Now</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 me-auto text-end">
                    <h2 class="linkdm-feature-heading">Auto-Reply to Sponsored Ad Comments</h2>
                    <p class="linkdm-feature-text">
                        Auto-reply to post comments on your sponsored content with a DM sent directly to the users inbox. Respond to keywords or all comments.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <style nonce="{{ csp_nonce() }}">
        .premium-stats-banner {
            background: linear-gradient(90deg, #E91E63 0%, #9C27B0 50%, #673AB7 100%) !important;
            padding: 35px 0 !important;
            color: #fff !important;
            text-align: center !important;
            width: 100vw !important;
            position: relative !important;
            left: 50% !important;
            right: 50% !important;
            margin-left: -50vw !important;
            margin-right: -50vw !important;
            overflow: hidden !important;
        }
        .stat-val { font-size: 2.8rem !important; font-weight: 800 !important; margin-bottom: 0px !important; line-height: 1 !important; }
        .stat-val span { font-size: 1.2rem !important; vertical-align: top !important; }
        .stat-desc { font-weight: 700 !important; font-size: 0.95rem !important; opacity: 0.95 !important; }
        .stat-meta { font-size: 0.7rem !important; opacity: 0.7 !important; font-style: italic !important; margin-top: 2px !important; }
    </style>

    <!-- Premium Gradient Stats Banner -->
    <section class="premium-stats-banner">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="stat-val">92<span>%</span></div>
                    <div class="stat-desc">Average Open Rates*</div>
                    <div class="stat-meta">*As of December 2025</div>
                </div>
                <div class="col-md-4">
                    <div class="stat-val">74<span>%</span></div>
                    <div class="stat-desc">Average CTR*</div>
                    <div class="stat-meta">*As of December 2025</div>
                </div>
                <div class="col-md-4">
                    <div class="stat-val">65<span>%</span></div>
                    <div class="stat-desc">Increase Engagement*</div>
                    <div class="stat-meta">*As of December 2025</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Master Clone: Who's Using Socialyt? -->
    <section class="py-5 bg-white" id="creators">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold display-5 mb-2">Who's Using Socialyt?</h2>
                <div class="text-primary fw-bold small letter-spacing-2 mb-5">CREATORS</div>
                
                <!-- Creators Grid -->
                <div class="d-flex flex-wrap justify-content-center gap-3 mb-5 px-lg-5">
                    @php
                        $fakeCreators = [
                            ['name' => 'beautyxdanaplum', 'img' => 'https://i.pravatar.cc/100?u=1'],
                            ['name' => 'rachaelsgoodeats', 'img' => 'https://i.pravatar.cc/100?u=2'],
                            ['name' => 'sunsetsandstilettos', 'img' => 'https://i.pravatar.cc/100?u=3'],
                            ['name' => 'getschooledinfashion', 'img' => 'https://i.pravatar.cc/100?u=4'],
                            ['name' => 'mytexashouse', 'img' => 'https://i.pravatar.cc/100?u=5'],
                            ['name' => 'madeline_devaux', 'img' => 'https://i.pravatar.cc/100?u=6'],
                            ['name' => 'zee_styledit', 'img' => 'https://i.pravatar.cc/100?u=7'],
                            ['name' => 'eatingbirdfood', 'img' => 'https://i.pravatar.cc/100?u=8'],
                            ['name' => 'just.ingredients', 'img' => 'https://i.pravatar.cc/100?u=9'],
                            ['name' => 'snipestwins', 'img' => 'https://i.pravatar.cc/100?u=10'],
                            ['name' => 'danielle.donohue', 'img' => 'https://i.pravatar.cc/100?u=11'],
                            ['name' => 'bromabakery', 'img' => 'https://i.pravatar.cc/100?u=12'],
                            ['name' => 'everyday.holly', 'img' => 'https://i.pravatar.cc/100?u=13']
                        ];
                    @endphp
                    @foreach($fakeCreators as $creator)
                    <div class="creator-pill d-flex align-items-center bg-white border rounded-pill px-2 py-1 shadow-sm">
                        <img src="{{ $creator['img'] }}" class="rounded-circle me-2" style="width: 28px; height: 28px; object-fit: cover;">
                        <span class="small fw-bold text-dark me-1">&#64;{{ $creator['name'] }}</span>
                        <i class="fas fa-check-circle text-primary" style="font-size: 0.7rem;"></i>
                    </div>
                    @endforeach
                </div>

                <div class="text-primary fw-bold small letter-spacing-2 mb-5">BRANDS</div>

                <!-- Brands Grid -->
                <div class="d-flex flex-wrap justify-content-center gap-3 mb-5 px-lg-5">
                    @php
                        $fakeBrands = [
                            ['name' => 'enews', 'color' => '#001a34'],
                            ['name' => 'chatbooks', 'color' => '#f06292'],
                            ['name' => 'hauste', 'color' => '#e65100'],
                            ['name' => 'patpat_clothing', 'color' => '#ff5252'],
                            ['name' => 'shoptoday', 'color' => '#d32f2f'],
                            ['name' => 'nbcselect', 'color' => '#1976d2'],
                            ['name' => 'homebeautiful', 'color' => '#303f9f']
                        ];
                    @endphp
                    @foreach($fakeBrands as $brand)
                    <div class="creator-pill d-flex align-items-center bg-white border rounded-pill px-2 py-1 shadow-sm">
                        <div class="rounded-circle me-2 d-flex align-items-center justify-content-center text-white fw-bold" style="width: 28px; height: 28px; background: {{ $brand['color'] }}; font-size: 0.6rem;">{{ strtoupper(substr($brand['name'], 0, 1)) }}</div>
                        <span class="small fw-bold text-dark me-1">&#64;{{ $brand['name'] }}</span>
                        <i class="fas fa-check-circle text-primary" style="font-size: 0.7rem;"></i>
                    </div>
                    @endforeach
                </div>

                <div class="text-primary fw-bold small letter-spacing-2 mb-4">NICHES</div>
                
                <!-- Niches Grid -->
                <div class="d-flex flex-wrap justify-content-center gap-2 mb-4">
                    @php
                        $niches = ['Mavely Creators', 'Fashion Creators', 'Amazon Creators', 'LTK Creators', 'Food Creators', 'Beauty Creators', 'Travel Creators', 'DIY Home Creators', 'Designers', 'Musicians', 'Podcasters'];
                    @endphp
                    @foreach($niches as $niche)
                    <span class="badge border text-dark rounded-pill px-3 py-2 fw-normal bg-white" style="font-size: 0.8rem; border-color: #dee2e6 !important;">{{ $niche }}</span>
                    @endforeach
                </div>
            </div>
        </div>

        <style nonce="{{ csp_nonce() }}">
            .letter-spacing-2 { letter-spacing: 2px; }
            .creator-pill { transition: all 0.3s ease; cursor: default; }
            .creator-pill:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(0,0,0,0.1) !important; border-color: var(--primary) !important; }
            .badge.border:hover { border-color: var(--primary) !important; color: var(--primary) !important; }
        </style>
    </section>

    <!-- Videos Grid -->
    <!-- Engagement in Action -->
    <section class="py-5" id="engagement">
        <div class="container py-5">
            <h2 class="text-center fw-bold mb-5 fs-1">Engagement in Action</h2>
            
            <style nonce="{{ csp_nonce() }}">
                .reels-grid {
                    display: flex;
                    flex-wrap: wrap;
                    justify-content: center;
                    gap: 1.5rem;
                    padding: 0 1rem;
                }
                .reel-card {
                    position: relative;
                    width: 100%;
                    max-width: 280px;
                    aspect-ratio: 9/16;
                    background: #000;
                    border-radius: 2rem;
                    overflow: hidden;
                    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
                    transition: transform 0.3s ease;
                }
                .reel-card:hover { transform: translateY(-5px); }
                .reel-iframe {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    border: 0;
                    object-fit: cover;
                }
                .reel-overlay {
                    position: absolute;
                    bottom: 0;
                    left: 0;
                    width: 100%;
                    padding: 1.5rem;
                    background: linear-gradient(transparent, rgba(0,0,0,0.8));
                    pointer-events: none;
                }
                @media (max-width: 768px) {
                    .reel-card { max-width: 45%; }
                }
            </style>

            @php
                $automationVideos = [
                    ['id' => '-Nf5QNtFgkA', 'title' => 'DM Automation'],
                    ['id' => 'iYLkM9rNQUo', 'title' => 'Growth Strategy'],
                    ['id' => 'U-SvBBIr9Zc', 'title' => 'Comment Bot'],
                    ['id' => 'M6W29759k68', 'title' => 'Live Demo']
                ];
            @endphp

            <div class="reels-grid">
                @foreach($automationVideos as $video)
                    <div class="reel-card animate__animated animate__fadeInUp">
                        <iframe class="reel-iframe" 
                                src="https://www.youtube.com/embed/{{ $video['id'] }}?autoplay=1&mute=1&loop=1&playlist={{ $video['id'] }}&controls=0&modestbranding=1&rel=0" 
                                allow="autoplay; encrypted-media" allowfullscreen></iframe>
                        <div class="reel-overlay">
                            <div class="text-white fw-bold small">{{ $video['title'] }}</div>
                            <div class="text-primary small fw-bold" style="font-size: 0.6rem;">Socialyt AI</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="py-5 bg-white" id="pricing">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold fs-1">Simple, Transparent Pricing</h2>
                <p class="text-muted">Choose the plan that fits your growth stage.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="p-5 rounded-5 border h-100 text-center">
                        <h4 class="fw-bold">Free</h4>
                        <div class="display-4 fw-bold my-3">$0</div>
                        <p class="text-muted">For small creators starting out.</p>
                        <ul class="list-unstyled d-grid gap-3 my-4">
                            <li>100 Automated DMs/mo</li>
                            <li>Basic Comment Reply</li>
                            <li>Standard Support</li>
                        </ul>
                        <a href="#" class="btn btn-outline-premium w-100">Get Started</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-5 rounded-5 border h-100 text-center bg-primary text-white shadow-lg">
                        <h4 class="fw-bold">Pro</h4>
                        <div class="display-4 fw-bold my-3">$29</div>
                        <p class="text-white-50">For serious creators & brands.</p>
                        <ul class="list-unstyled d-grid gap-3 my-4">
                            <li>5,000 Automated DMs/mo</li>
                            <li>Advanced Keyword Triggers</li>
                            <li>Priority Support</li>
                            <li>Custom Inbox Starters</li>
                        </ul>
                        <a href="#" class="btn btn-light w-100 fw-bold rounded-pill py-3">Try Pro Free</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-5 rounded-5 border h-100 text-center">
                        <h4 class="fw-bold">Agency</h4>
                        <div class="display-4 fw-bold my-3">$99</div>
                        <p class="text-muted">For multiple accounts & teams.</p>
                        <ul class="list-unstyled d-grid gap-3 my-4">
                            <li>Unlimited DMs</li>
                            <li>10 Account Slots</li>
                            <li>Dedicated Account Manager</li>
                            <li>White Label Reporting</li>
                        </ul>
                        <a href="#" class="btn btn-outline-premium w-100">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-5 bg-light" id="testimonials">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold fs-1">Loved by Creators Everywhere</h2>
                <p class="text-muted">Join 50,000+ happy users growing their community.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="p-4 rounded-4 bg-white shadow-sm border h-100">
                        <div class="text-warning mb-3"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                        <p class="fst-italic">"Socialyt changed my life. I went from spending 4 hours a day replying to comments to 0 minutes, while my sales tripled!"</p>
                        <div class="d-flex align-items-center mt-4">
                            <div class="fw-bold">Alex Rivers</div>
                            <div class="text-muted small ms-2">- Tech Creator</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 rounded-4 bg-white shadow-sm border h-100">
                        <div class="text-warning mb-3"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                        <p class="fst-italic">"The easiest tool I've ever used. Set it up in 5 minutes and it's been running flawlessly for months."</p>
                        <div class="d-flex align-items-center mt-4">
                            <div class="fw-bold">Sarah Jenkins</div>
                            <div class="text-muted small ms-2">- Fashion Blogger</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 rounded-4 bg-white shadow-sm border h-100">
                        <div class="text-warning mb-3"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                        <p class="fst-italic">"Our agency handles 50+ clients and Socialyt is our go-to for automation. The API is rock solid."</p>
                        <div class="d-flex align-items-center mt-4">
                            <div class="fw-bold">Marcus Chen</div>
                            <div class="text-muted small ms-2">- Agency Owner</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Help Center / Support Section -->
    <section class="py-5 bg-white border-top" id="support">
        <div class="container py-5">
            <div class="text-center mb-5">
                <div class="text-primary fw-bold text-uppercase mb-2" style="letter-spacing: 2px;">Help Center</div>
                <h2 class="fw-bold fs-1">Support Topics</h2>
                <p class="text-muted mx-auto" style="max-width: 700px;">
                    Navigate through our extensive support resources, find answers to common questions, and reach out to our dedicated team for any assistance.
                </p>
                <div class="mt-4 mx-auto" style="max-width: 500px;">
                    <div class="input-group input-group-lg border rounded-pill overflow-hidden">
                        <span class="input-group-text bg-white border-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" class="form-control border-0 shadow-none" placeholder="Search for a help topic or issue">
                    </div>
                </div>
            </div>

            <div class="row g-4 mt-5">
                @php
                    $topics = [
                        ['icon' => 'fas fa-rocket', 'title' => 'Get Started with Socialyt', 'desc' => 'Understand the fundamentals and core components of Socialyt.'],
                        ['icon' => 'fas fa-star', 'title' => 'Socialyt Pro', 'desc' => 'Get help with Socialyt Pro features and advanced functionality.'],
                        ['icon' => 'fas fa-tools', 'title' => 'Troubleshooting', 'desc' => 'Common Meta permission issues and Instagram page access.'],
                        ['icon' => 'fab fa-meta', 'title' => 'Meta Permissions', 'desc' => 'Get assistance with Meta permission and account linking issues.'],
                        ['icon' => 'fas fa-film', 'title' => 'Post & Reel Automation', 'desc' => 'Get help with post and reel automation setup and common issues.'],
                        ['icon' => 'fas fa-circle-notch', 'title' => 'Story Automation', 'desc' => 'Having issues using automation on Instagram stories?'],
                        ['icon' => 'fas fa-random', 'title' => 'Flow Automation', 'desc' => 'Get support setting up and using Flow Automations on your accounts.'],
                        ['icon' => 'fas fa-clipboard-list', 'title' => 'Lead Generation', 'desc' => 'Get support setting up and using Lead Generation forms.'],
                    ];
                @endphp

                @foreach($topics as $topic)
                    <div class="col-md-3">
                        <div class="p-4 rounded-4 border h-100 hover-shadow transition">
                            <div class="fs-2 text-primary mb-3"><i class="{{ $topic['icon'] }}"></i></div>
                            <h5 class="fw-bold">{{ $topic['title'] }}</h5>
                            <p class="text-muted small mb-0">{{ $topic['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    <!-- FAQ Section -->
    <section class="py-5 bg-light" id="faq">
        <div class="container py-5">
            <div class="row">
                <div class="col-md-4">
                    <h2 class="fw-bold fs-1 mb-4">Questions? <br><span class="text-primary">We have answers.</span></h2>
                    <p class="text-muted">Can't find what you're looking for? Reach out to our 24/7 support team.</p>
                    <a href="#" class="btn btn-outline-premium mt-3">Contact Support</a>
                </div>
                <div class="col-md-7 ms-auto">
                    @forelse($faqs as $faq)
                        <div class="faq-item-modern">
                            <h4 class="fw-bold h5 mb-3">{{ $faq->question }}</h4>
                            <p class="text-muted mb-0">{{ $faq->answer }}</p>
                        </div>
                    @empty
                        <p class="text-muted">No FAQs available.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <!-- Meta Partner -->
    <section class="py-5">
        <div class="container">
            <div class="bg-white border rounded-5 p-5 text-center shadow-sm">
                <img src="https://upload.wikimedia.org/wikipedia/commons/7/7b/Meta_Platforms_Inc._logo.svg" 
                     height="60" class="mb-4" alt="Meta Partner">
                <h3 class="fw-bold mb-3">Official Meta Business Partner</h3>
                <p class="text-muted mx-auto mb-4" style="max-width: 700px">
                    Socialyt is officially certified by Meta. Your accounts are 100% safe, and your automation is built on official APIs.
                </p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="#" class="btn btn-dark rounded-pill px-4 py-2"><i class="fab fa-apple me-2"></i> iOS</a>
                    <a href="#" class="btn btn-success rounded-pill px-4 py-2" style="background-color: #34d399; border:none;"><i class="fab fa-android me-2"></i> Android</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Minimalist Footer Section -->
    <footer class="footer-banner-grey">
        <div class="container">
            <div class="row g-5">
                <!-- Brand Column -->
                <div class="col-lg-4">
                    <div class="footer-brand-title">Socialyt</div>
                    <div class="footer-brand-tagline">Turn DMs into Sales</div>
                    <p class="text-muted mb-4 pe-lg-5">
                        Enhance engagement with your followers by automatically sending personalized DMs in response to comments.
                        <br><br>
                        Save time, drive sales, and strengthen connections!
                    </p>
                    <a href="#" class="btn btn-dark rounded-pill px-4 py-2 mb-4">
                        Contact Us <i class="fas fa-paper-plane ms-2"></i>
                    </a>
                    <div class="d-flex gap-3">
                        <a href="#" class="social-icon-circle"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon-circle"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon-circle"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="social-icon-circle"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>

                <!-- Breakdown Column -->
                <div class="col-lg-3 footer-link-col">
                    <h5>Breakdown</h5>
                    <div class="row row-cols-2">
                        <div class="col">
                            <ul class="list-unstyled">
                                <li><a href="#">Vs. Manychat</a></li>
                                <li><a href="#">Vs. InstaChamp</a></li>
                                <li><a href="#">Vs. Mobile Monkey</a></li>
                                <li><a href="#">Vs. Stan AutoDM</a></li>
                                <li><a href="#">Vs. LTK DM</a></li>
                                <li><a href="#">Vs. Inro.Social</a></li>
                            </ul>
                        </div>
                        <div class="col">
                            <ul class="list-unstyled">
                                <li><a href="#">Vs. InstantDM</a></li>
                                <li><a href="#">Vs. SuperProfile.Bio</a></li>
                                <li><a href="#">Vs. Wishlink</a></li>
                                <li><a href="#">Vs. LinktoDM</a></li>
                                <li><a href="#">Vs. SendPulse</a></li>
                                <li><a href="#">Vs. DelightChat</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Support & Legal -->
                <div class="col-lg-2 footer-link-col">
                    <h5>Support & Legal</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">Terms & Conditions</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Return and Refund Policy</a></li>
                    </ul>
                    
                    <h5 class="mt-4">Review Us</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Trustpilot</a></li>
                        <li><a href="#">G2</a></li>
                        <li><a href="#">Capterra</a></li>
                    </ul>
                </div>

                <!-- Info & Solutions -->
                <div class="col-lg-2 footer-link-col">
                    <h5>Info</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Create Account</a></li>
                        <li><a href="#">Pricing</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">FAQs</a></li>
                        <li><a href="#">Meta Verified</a></li>
                    </ul>

                    <h5 class="mt-4">Solutions</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Creators</a></li>
                        <li><a href="#">E-Commerce</a></li>
                    </ul>
                </div>
            </div>

            <!-- Large Watermark -->
            <div class="footer-watermark">Socialyt</div>

            <div class="text-center mt-5 pt-4 border-top">
                <p class="text-muted small">&copy; Copyrights 2026. All rights reserved by Hexotix Private Limited.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <style nonce="{{ csp_nonce() }}">
        .premium-social-proof {
            position: fixed;
            bottom: 25px;
            left: 25px;
            background: #fff !important;
            padding: 8px 15px !important;
            border-radius: 50px !important;
            box-shadow: 0 10px 40px rgba(0,0,0,0.12) !important;
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            gap: 12px !important;
            z-index: 99999 !important;
            border: 1px solid rgba(0,0,0,0.05) !important;
            width: auto !important;
            max-width: 500px !important;
        }
        .premium-social-proof span {
            white-space: nowrap !important;
            display: inline-block !important;
        }
        .sp-img-box {
            width: 32px !important;
            height: 32px !important;
            border-radius: 50% !important;
            object-fit: cover !important;
            flex-shrink: 0 !important;
        }
    </style>

    <!-- Dynamic Social Proof Popup -->
    <div id="dynamic-social-proof" class="premium-social-proof d-none animate__animated">
        <img id="sp-img" src="https://i.pravatar.cc/150?u=1" alt="User" class="sp-img-box">
        <div class="d-flex align-items-center gap-2">
            <span id="sp-name" class="fw-bold text-dark" style="font-size: 0.8rem;">Manas 🇺🇸</span>
            <span id="sp-action" class="text-muted" style="font-size: 0.8rem;">Just signed up to Socialyt</span>
            <span id="sp-time" class="text-muted" style="font-size: 0.7rem; opacity: 0.7;">• Just now</span>
        </div>
        <button onclick="document.getElementById('dynamic-social-proof').classList.add('d-none')" class="btn-close ms-2" style="font-size: 0.5rem; opacity: 0.4; flex-shrink: 0;" aria-label="Close"></button>
    </div>

    <script nonce="{{ csp_nonce() }}">
        const notifications = [
            { name: 'Manas 🇺🇸', action: 'Just signed up to Socialyt', time: 'Just now', img: 'https://i.pravatar.cc/150?u=1' },
            { name: 'Sarah 🇬🇧', action: 'Upgraded to Pro', time: '2 mins ago', img: 'https://i.pravatar.cc/150?u=2' },
            { name: 'Alex 🇨🇦', action: 'Started automating comments', time: '5 mins ago', img: 'https://i.pravatar.cc/150?u=3' },
            { name: 'Priya 🇮🇳', action: 'Just signed up to Socialyt', time: '12 mins ago', img: 'https://i.pravatar.cc/150?u=4' },
            { name: 'Mike 🇦🇺', action: 'Upgraded to Agency', time: '1 hour ago', img: 'https://i.pravatar.cc/150?u=5' },
            { name: 'Elena 🇪🇸', action: 'Hit 10k DMs sent!', time: '3 hours ago', img: 'https://i.pravatar.cc/150?u=6' }
        ];

        function showNotification() {
            const popup = document.getElementById('dynamic-social-proof');
            if (!popup) return;
            const data = notifications[Math.floor(Math.random() * notifications.length)];
            document.getElementById('sp-img').src = data.img;
            document.getElementById('sp-name').textContent = data.name;
            document.getElementById('sp-action').textContent = data.action;
            document.getElementById('sp-time').textContent = data.time;
            popup.classList.remove('d-none', 'animate__fadeOutDown');
            popup.classList.add('animate__animated', 'animate__fadeInUp');
            setTimeout(() => {
                popup.classList.remove('animate__fadeInUp');
                popup.classList.add('animate__fadeOutDown');
            }, 4000);
        }

        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                showNotification();
                setInterval(showNotification, 6000);
            }, 2000);
        });
    </script>
  </body>
</html>