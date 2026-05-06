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

    <!-- Content Sections (Restored influencers from Adarsh) -->
    <section class="section-feature" id="ecommerce">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="feature-image-wrapper">
                        <img src="{{ asset('fashion_influencer_ecommerce_red_1777912440009.png') }}" class="img-fluid" alt="E-commerce influencer">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="feature-text">
                        <h2 class="display-5 fw-bold mb-4">E-commerce <span class="text-primary">Growth</span></h2>
                        <p class="lead text-muted">Automate your sales funnel directly in the DMs. Convert interest into transactions instantly.</p>
                        <ul class="list-unstyled mt-4 gap-3 d-flex flex-column">
                            <li><i class="fas fa-check-circle text-primary me-2"></i> Instant Product Links</li>
                            <li><i class="fas fa-check-circle text-primary me-2"></i> Automated Discount Codes</li>
                            <li><i class="fas fa-check-circle text-primary me-2"></i> Cart Abandonment Recovery</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Scripts Section -->
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

    <script>
        const typingTexts = @json($settings->typing_texts ?? ['AI helps you grow', 'AI creates media kit', 'AI auto DM system']);
        const typingTarget = document.getElementById('typing-text-welcome');
        let textIndex = 0;
        let charIndex = 0;
        let isDeleting = false;
        let typeSpeed = 100;

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

            if (!isDeleting && charIndex === currentText.length) {
                isDeleting = true;
                typeSpeed = 2000;
            } else if (isDeleting && charIndex === 0) {
                isDeleting = false;
                textIndex = (textIndex + 1) % typingTexts.length;
                typeSpeed = 500;
            }

            setTimeout(type, typeSpeed);
        }

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
            type();
            setTimeout(() => {
                showNotification();
                setInterval(showNotification, 6000);
            }, 2000);
        });
    </script>
  </body>
</html>