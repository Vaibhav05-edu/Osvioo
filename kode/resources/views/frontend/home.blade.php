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
    <style>
      /* Temporary overrides for transitions */
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
                    {{ $settings->headline_2 ?? 'Automate Instagram & Facebook' }}
                </div>

                <!-- Typing Animation Section -->
                <div class="h-10 mb-4">
                    <span class="text-primary fw-bold fs-3" id="typing-text-welcome"></span>
                </div>

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
                <h2 class="fw-bold fs-1">How It Works</h2>
                <p class="text-muted">Three simple steps to automate your growth.</p>
                <div class="row mt-5 g-4">
                    <div class="col-md-4">
                        <div class="p-4 rounded-4 bg-white border h-100">
                            <div class="fs-1 text-primary mb-3"><i class="fas fa-link"></i></div>
                            <h4 class="fw-bold">1. Connect Account</h4>
                            <p class="text-muted">Link your Instagram or Facebook account with one click using official Meta APIs.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-4 rounded-4 bg-white border h-100">
                            <div class="fs-1 text-primary mb-3"><i class="fas fa-bolt"></i></div>
                            <h4 class="fw-bold">2. Set Triggers</h4>
                            <p class="text-muted">Choose keyword triggers or auto-reply to every comment with personalized DMs.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-4 rounded-4 bg-white border h-100">
                            <div class="fs-1 text-primary mb-3"><i class="fas fa-chart-line"></i></div>
                            <h4 class="fw-bold">3. Watch Growth</h4>
                            <p class="text-muted">Sit back as Socialyt turns every interaction into a potential sale or follower.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
                        <div class="textured-halo"></div>
                        <svg class="dashed-line-svg" viewBox="0 0 400 400" style="opacity: 0.5; position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
                            <path d="M280 200 Q380 200 380 300" stroke="#0084FF" stroke-width="2" stroke-dasharray="10 10" fill="transparent" />
                        </svg>
                        <div class="linkdm-phone-3d-card animate__animated animate__fadeInLeft">
                            <img src="{{ asset('hot_influencer_reel.jpg') }}" alt="Vibrant Content">
                        </div>
                        <div class="linkdm-floating-card profile-card animate__animated animate__fadeInRight">
                            <div class="notification-badge-red">1</div>
                            <img src="{{ asset('hot_influencer_reel.jpg') }}" style="height: 180px; object-fit: cover; width: 100%;" alt="Zoom">
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
                        <div class="textured-halo halo-gold"></div>
                        <div class="linkdm-phone-3d-card animate__animated animate__fadeInLeft">
                            <img src="{{ asset('hot_influencer_inbox.jpg') }}" alt="Inbox Content">
                        </div>
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
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-5">
        <div class="container">
            <div class="stats-container mb-5 pb-5 mt-5">
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="stats-glass-card primary-card text-center text-white p-4 rounded-4" style="background: var(--primary);">
                            <div class="stat-number fs-1 fw-bold">50K+</div>
                            <div class="stat-label text-white-50">Active Creators</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-glass-card text-center p-4 rounded-4 border bg-white">
                            <div class="stat-number fs-1 fw-bold text-primary">12M+</div>
                            <div class="stat-label text-muted">DMs Sent</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-glass-card text-center p-4 rounded-4 border bg-white">
                            <div class="stat-number fs-1 fw-bold text-primary">35%</div>
                            <div class="stat-label text-muted">Avg. CTR</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-glass-card text-center p-4 rounded-4 border bg-white">
                            <div class="stat-number fs-1 fw-bold text-primary">24/7</div>
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
                                <img src="{{ asset('storage/' . $stat->image) }}" alt="{{ $stat->title }}" class="img-fluid rounded-4 shadow-lg">
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

    <!-- Creators Section -->
    <section class="py-5 bg-light" id="creators">
        <div class="container py-5 text-center">
            <h2 class="fw-bold mb-4 fs-1">Trusted by the World's Best Creators</h2>
            <div class="row row-cols-2 row-cols-md-4 g-4 mb-5 justify-content-center">
                @foreach($creators as $creator)
                    <div class="col">
                        <div class="creator-badge-pro d-flex align-items-center p-3 bg-white rounded-pill border">
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
                                <h4 class="text-white fw-bold mb-0">{{ $video->title }}</h4>
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
                        <ul class="list-unstyled d-grid gap-3 my-4">
                            <li>100 Automated DMs/mo</li>
                            <li>Basic Comment Reply</li>
                        </ul>
                        <a href="#" class="btn btn-outline-premium w-100">Get Started</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-5 rounded-5 border h-100 text-center bg-primary text-white shadow-lg">
                        <h4 class="fw-bold">Pro</h4>
                        <div class="display-4 fw-bold my-3">$29</div>
                        <ul class="list-unstyled d-grid gap-3 my-4">
                            <li>5,000 Automated DMs/mo</li>
                            <li>Priority Support</li>
                        </ul>
                        <a href="#" class="btn btn-light w-100 fw-bold rounded-pill py-3">Try Pro Free</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-5 rounded-5 border h-100 text-center">
                        <h4 class="fw-bold">Agency</h4>
                        <div class="display-4 fw-bold my-3">$99</div>
                        <ul class="list-unstyled d-grid gap-3 my-4">
                            <li>Unlimited DMs</li>
                            <li>10 Account Slots</li>
                        </ul>
                        <a href="#" class="btn btn-outline-premium w-100">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-5 bg-light" id="faq">
        <div class="container py-5">
            <div class="row">
                <div class="col-md-4">
                    <h2 class="fw-bold fs-1 mb-4">Questions? <br><span class="text-primary">We have answers.</span></h2>
                    <a href="#" class="btn btn-outline-premium mt-3">Contact Support</a>
                </div>
                <div class="col-md-7 ms-auto">
                    @forelse($faqs as $faq)
                        <div class="p-4 bg-white rounded-4 mb-3 border">
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

    <!-- Footer -->
    <footer class="py-5 bg-white border-top mt-5">
        <div class="container text-center">
            <div class="footer-brand-title fs-2 fw-bold mb-3">Socialyt</div>
            <p class="text-muted mb-4">Turn DMs into Sales. Official Meta Business Partner.</p>
            <div class="d-flex justify-content-center gap-3 mb-4">
                <a href="#" class="text-muted"><i class="fab fa-instagram fs-4"></i></a>
                <a href="#" class="text-muted"><i class="fab fa-facebook fs-4"></i></a>
                <a href="#" class="text-muted"><i class="fab fa-linkedin fs-4"></i></a>
            </div>
            <p class="text-muted small">&copy; 2026 Socialyt. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const typingTexts = @json($settings->typing_texts ?? ['AI helps you grow', 'AI creates media kit', 'AI auto DM system']);
        const typingTarget = document.getElementById('typing-text-welcome');
        let textIndex = 0, charIndex = 0, isDeleting = false, typeSpeed = 100;

        function type() {
            if (!typingTexts || typingTexts.length === 0) return;
            const currentText = typingTexts[textIndex];
            if (isDeleting) {
                typingTarget.textContent = currentText.substring(0, charIndex - 1);
                charIndex--;
                typeSpeed = 50;
            } else {
                typingTarget.textContent = currentText.substring(0, charIndex + 1);
                charIndex++;
                typeSpeed = 100;
            }
            if (!isDeleting && charIndex === currentText.length) { isDeleting = true; typeSpeed = 2000; }
            else if (isDeleting && charIndex === 0) { isDeleting = false; textIndex = (textIndex + 1) % typingTexts.length; typeSpeed = 500; }
            setTimeout(type, typeSpeed);
        }

        document.addEventListener('DOMContentLoaded', type);
    </script>
  </body>
</html>