<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{@site_settings("user_site_name",site_settings('site_name'))}} - Instagram & Facebook DM Automation</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playball&family=Syne:wght@700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}?v={{ time() }}" />
    <style>
      .navbar-custom { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); }
      .hero-title { font-family: 'Syne', sans-serif !important; font-weight: 800 !important; color: #111; }
      .playball-accent { font-family: 'Playball', cursive !important; color: #FF9500 !important; }
    </style>
  </head>
  <body>
    <!-- Navbar (Adarsh Style) -->
    <nav class="navbar navbar-expand-lg navbar-light navbar-custom sticky-top py-3">
      <div class="container">
        <a class="navbar-brand fw-bold fs-3" href="#" style="color: #FF1F1F;">Socialyt</a>
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
          <ul class="navbar-nav gap-2">
            <li class="nav-item"><a class="nav-link fw-semibold" href="#creators">Creators</a></li>
            <li class="nav-item"><a class="nav-link fw-semibold" href="#ecommerce">Ecommerce</a></li>
            <li class="nav-item"><a class="nav-link fw-semibold" href="#features">Features</a></li>
            <li class="nav-item"><a class="nav-link fw-semibold" href="#pricing">Pricing</a></li>
            <li class="nav-item"><a class="nav-link fw-semibold" href="#faq">FAQ</a></li>
          </ul>
        </div>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('auth.login') }}" class="text-dark text-decoration-none fw-semibold d-none d-md-block">Log in</a>
            <a href="#" class="btn btn-premium px-4 rounded-pill">Get Started Free</a>
        </div>
      </div>
    </nav>

    <!-- Hero Section -->
    <header class="section-hero py-5 overflow-hidden" id="home">
      <div class="container pt-5">
        <div class="row align-items-center">
            <div class="col-lg-6 text-center text-lg-start">
                <div class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill mb-4 animate__animated animate__fadeInDown">
                    🚀 {{ $settings->cta_text ?? '#1 Meta Automation Tool' }}
                </div>
                <h1 class="hero-title display-4 fw-bold mb-2">{{ $settings->headline_1 ?? 'AI that helps you grow' }}</h1>
                <div class="playball-accent display-6 mb-4">
                    {{ $settings->headline_2 ?? 'Automate Instagram & Facebook' }}
                </div>
                <div class="h-10 mb-4">
                    <span class="text-primary fw-bold fs-3" id="typing-text-welcome"></span>
                </div>
                <p class="lead text-muted mb-5">
                    {{ $settings->description ?? 'Engage your followers automatically. Reply to comments with personalized DMs, save time, and explode your conversion rates.' }}
                </p>
                <div class="d-flex justify-content-center justify-content-lg-start gap-3 mt-4">
                    <a href="{{ $settings->cta_url ?? '#' }}" class="btn btn-premium btn-lg px-5 py-3 rounded-pill shadow-lg">Start Automating Now</a>
                    <a href="#features" class="btn btn-outline-premium btn-lg px-5 py-3 rounded-pill">See How it Works</a>
                </div>
            </div>
            <div class="col-lg-6 mt-5 mt-lg-0">
                <img src="{{ $settings->hero_image ?? 'https://static.wixstatic.com/media/cdc6f6_0e9ea9a6ef58481b82bdc6a0442517c2~mv2.webp/v1/fill/w_1000,h_738,al_c,q_85/Group%201680482139.webp' }}" 
                     alt="Influencer" class="img-fluid mx-auto animate__animated animate__zoomIn">
            </div>
        </div>
      </div>
    </header>

    <!-- Sections (Features, Stats, Creators, Videos, FAQ) -->
    <section class="py-5 bg-white border-bottom text-center">
        <div class="container">
            <p class="text-muted small text-uppercase fw-bold mb-4">Official Meta Business Partner Capabilities</p>
            <div class="d-flex flex-wrap justify-content-center align-items-center gap-5 opacity-50 grayscale">
                <img src="https://upload.wikimedia.org/wikipedia/commons/b/b8/2021_Facebook_icon.svg" height="30" alt="FB">
                <img src="https://upload.wikimedia.org/wikipedia/commons/e/e7/Instagram_logo_2016.svg" height="30" alt="IG">
                <img src="https://upload.wikimedia.org/wikipedia/commons/7/7b/Meta_Platforms_Inc._logo.svg" height="25" alt="Meta">
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-5 bg-light">
        <div class="container py-5">
            <div class="row g-4 text-center">
                <div class="col-md-3"><div class="p-4 bg-white rounded-4 border"><div class="display-5 fw-bold text-primary">50K+</div><div class="text-muted">Creators</div></div></div>
                <div class="col-md-3"><div class="p-4 bg-white rounded-4 border"><div class="display-5 fw-bold text-primary">12M+</div><div class="text-muted">DMs Sent</div></div></div>
                <div class="col-md-3"><div class="p-4 bg-white rounded-4 border"><div class="display-5 fw-bold text-primary">35%</div><div class="text-muted">Avg CTR</div></div></div>
                <div class="col-md-3"><div class="p-4 bg-white rounded-4 border"><div class="display-5 fw-bold text-primary">24/7</div><div class="text-muted">Support</div></div></div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-5 bg-white" id="faq">
        <div class="container py-5">
            <h2 class="text-center fw-bold mb-5">Frequently Asked Questions</h2>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    @foreach($faqs as $faq)
                        <div class="p-4 bg-light rounded-4 mb-3 border">
                            <h5 class="fw-bold mb-2">{{ $faq->question }}</h5>
                            <p class="text-muted mb-0">{{ $faq->answer }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-5 bg-white border-top">
        <div class="container text-center">
            <div class="fs-2 fw-bold mb-3" style="color: #FF1F1F;">Socialyt</div>
            <p class="text-muted">&copy; 2026 Socialyt. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const typingTexts = {!! json_encode($settings->typing_texts ?? ['AI helps you grow', 'AI creates media kit', 'AI auto DM system']) !!};
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