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
          padding: 12px 20px;
          border-radius: 12px;
          box-shadow: 0 10px 30px rgba(0,0,0,0.1);
          display: flex;
          align-items: center;
          gap: 12px;
          z-index: 9999;
          animation: slideUp 0.5s ease-out;
      }
      
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
                    <span id="typing-text-welcome" style="font-family: 'Syne', sans-serif !important; font-size: 1.8rem; font-weight: 800; color: #FF9500 !important; border-right: 3px solid #FF9500; padding-right: 5px; min-width: 10px; display: inline-block;"></span>
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
                    #typing-text-welcome { animation: blink-cursor 0.7s infinite; }
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
                        <div class="p-2 rounded-5 bg-white border h-100 shadow-sm transition-transform hover-scale">
                            <div class="rounded-5 overflow-hidden mb-4" style="background: #f8f9fa;">
                                <img src="https://static.wixstatic.com/media/cdc6f6_4d8a57e3f43b4e60803c4f74d4a46a81~mv2.png/v1/fill/w_500,h_500,al_c,q_85/connection.png" alt="Connect" class="img-fluid">
                            </div>
                            <div class="px-3 pb-4 text-center">
                                <h3 class="fw-bold fs-4 mb-2">1. Connect Account</h3>
                                <p class="text-muted small">Link your Instagram or Facebook account with one click using official Meta APIs.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Step 2 -->
                    <div class="col-md-4">
                        <div class="p-2 rounded-5 bg-white border h-100 shadow-sm transition-transform hover-scale">
                            <div class="rounded-5 overflow-hidden mb-4" style="background: #f8f9fa;">
                                <img src="https://static.wixstatic.com/media/cdc6f6_1777912440009.png/v1/fill/w_500,h_500,al_c,q_85/triggers.png" alt="Triggers" class="img-fluid">
                            </div>
                            <div class="px-3 pb-4 text-center">
                                <h3 class="fw-bold fs-4 mb-2">2. Set Triggers</h3>
                                <p class="text-muted small">Choose keyword triggers or auto-reply to every comment with personalized DMs.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Step 3 -->
                    <div class="col-md-4">
                        <div class="p-2 rounded-5 bg-white border h-100 shadow-sm transition-transform hover-scale">
                            <div class="rounded-5 overflow-hidden mb-4" style="background: #f8f9fa;">
                                <img src="https://static.wixstatic.com/media/cdc6f6_1777912536159.png/v1/fill/w_500,h_500,al_c,q_85/growth.png" alt="Growth" class="img-fluid">
                            </div>
                            <div class="px-3 pb-4 text-center">
                                <h3 class="fw-bold fs-4 mb-2">3. Watch Growth</h3>
                                <p class="text-muted small">Sit back as Socialyt turns every interaction into a potential sale or follower.</p>
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

            <!-- Stats/Numbers Section (Sleek Glassmorphism) -->
            <div class="stats-container mb-5 pb-5 mt-5">
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="stats-glass-card primary-card text-center text-white">
                            <div class="stat-number">50K+</div>
                            <div class="stat-label text-white-50">Active Creators</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-glass-card text-center">
                            <div class="stat-number text-primary">12M+</div>
                            <div class="stat-label text-muted">DMs Sent</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-glass-card text-center">
                            <div class="stat-number text-primary">35%</div>
                            <div class="stat-label text-muted">Avg. CTR</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-glass-card text-center">
                            <div class="stat-number text-primary">24/7</div>
                            <div class="stat-label text-muted">Response Rate</div>
                        </div>
                    </div>
                </div>
            </div>

            @php $count = 0; @endphp
            @foreach($stats as $stat)
                <div class="row align-items-center mb-5 pb-5 {{ $count % 2 == 0 ? '' : 'flex-row-reverse' }}">
                    <div class="col-md-6">
                        <div class="premium-3d-card-wrapper animate__animated {{ $count % 2 == 0 ? 'animate__fadeInLeft' : 'animate__fadeInRight' }}">
                            <div class="premium-3d-card">
                                <img src="{{ asset('storage/' . $stat->image) }}" alt="{{ $stat->title }}">
                            </div>
                            <!-- Floating UI Overlay matching the theme -->
                            <div class="linkdm-floating-card animate__animated {{ $count % 2 == 0 ? 'animate__fadeInRight' : 'animate__fadeInLeft' }}" 
                                 style="{{ $count % 2 == 0 ? 'top: 20%; right: -50px;' : 'bottom: 20%; left: -50px;' }}">
                                <div class="notification-badge-red">1</div>
                                <div class="d-flex align-items-center p-3">
                                    <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                        <i class="fas {{ $count % 2 == 0 ? 'fa-comment-dots text-primary' : 'fa-play text-primary' }} fs-4"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold small">{{ $stat->title }}</div>
                                        <div class="x-small text-muted">Automation Active</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 {{ $count % 2 == 0 ? 'ms-auto' : 'me-auto text-end' }}">
                        <div class="feature-text">
                            <h2 class="fw-bold mb-3 fs-1">{{ $stat->title }}</h2>
                            <p class="text-muted fs-5">{{ $stat->description }}</p>
                            <a href="#" class="btn btn-premium mt-3">Learn More</a>
                        </div>
                    </div>
                </div>
                @php $count++; @endphp
            @endforeach
        </div>
    </section>

    <!-- Creator Trust -->
    <section class="py-5 bg-light" id="creators">
        <div class="container py-5 text-center">
            <h2 class="fw-bold mb-4 fs-1">Trusted by the World's Best Creators</h2>
            <p class="text-muted mb-5 mx-auto" style="max-width: 800px">
                From micro-influencers to global icons, Socialyt is the secret weapon behind viral engagement.
            </p>
            
            <div class="row row-cols-2 row-cols-md-4 g-4 mb-5 justify-content-center">
                @foreach($creators as $creator)
                    <div class="col">
                        <div class="creator-badge-pro d-flex align-items-center">
                            <img src="{{ asset('storage/' . $creator->profile_pic) }}" 
                                 class="rounded-circle me-3" alt="{{ $creator->username }}" 
                                 style="width: 45px; height: 45px; object-fit: cover;">
                            <div class="text-start">
                                <div class="fw-bold text-truncate" style="max-width: 120px;">{{ $creator->username }}</div>
                                <div class="text-muted small">{{ $creator->followers }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <a href="#" class="btn btn-premium btn-lg">Join These Creators</a>
        </div>
    </section>

    <!-- Videos Grid -->
    <section class="py-5">
        <div class="container py-5">
            <h2 class="text-center fw-bold mb-5 fs-1">Engagement in Action</h2>
            <div class="row g-4">
                @foreach($videos as $video)
                    <div class="col-md-4">
                        <div class="position-relative overflow-hidden rounded-5 shadow-lg" style="height: 500px;">
                            @if(Str::contains($video->video_url, ['youtube.com', 'youtu.be']))
                                @php
                                    if (Str::contains($video->video_url, 'shorts/')) {
                                        $videoId = explode('shorts/', $video->video_url)[1];
                                    } elseif (Str::contains($video->video_url, 'youtu.be/')) {
                                        $videoId = explode('youtu.be/', $video->video_url)[1];
                                    } else {
                                        parse_str(parse_url($video->video_url, PHP_URL_QUERY), $params);
                                        $videoId = $params['v'] ?? '';
                                    }
                                @endphp
                                <iframe class="w-100 h-100" 
                                        src="https://www.youtube.com/embed/{{ $videoId }}?autoplay=1&mute=1&loop=1&playlist={{ $videoId }}" 
                                        frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                            @else
                                <video class="w-100 h-100" style="object-fit: cover;" autoplay muted loop playsinline>
                                    <source src="{{ asset('storage/' . $video->video_url) }}" type="video/mp4">
                                </video>
                            @endif
                            <div class="position-absolute bottom-0 start-0 w-100 p-4" style="background: linear-gradient(transparent, rgba(0,0,0,0.8));">
                                <h4 class="text-white fw-bold mb-0">
                                    @if(strtolower($video->title) == 'test')
                                        Creator Spotlight: Scaled 10x
                                    @elseif(strtolower($video->title) == 'er')
                                        Automation in Action
                                    @else
                                        {{ $video->title }}
                                    @endif
                                </h4>
                            </div>
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
    
    <!-- Dynamic Social Proof Popup -->
    <div id="dynamic-social-proof" class="social-proof d-none" style="position: fixed; bottom: 20px; left: 20px; background: #fff; padding: 15px 20px; border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.15); display: flex; align-items: center; gap: 15px; z-index: 9999; border: 1px solid rgba(0,0,0,0.05); min-width: 300px;">
        <img id="sp-img" src="https://i.pravatar.cc/150?u=1" alt="User" style="width: 45px; height: 45px; border-radius: 50%; object-fit: cover;">
        <div>
            <div id="sp-name" class="fw-bold text-dark mb-1" style="font-size: 0.95rem;">Manas 🇺🇸</div>
            <div id="sp-action" class="text-muted" style="font-size: 0.85rem;">Just signed up to Socialyt</div>
            <div id="sp-time" class="text-muted mt-1" style="font-size: 0.75rem;">Just now</div>
        </div>
        <button onclick="document.getElementById('dynamic-social-proof').style.display='none'" class="btn-close ms-auto" style="font-size: 0.7rem;" aria-label="Close"></button>
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