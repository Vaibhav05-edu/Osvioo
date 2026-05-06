@extends('layouts.master')
@section('content')

    @php
        $meta_data = [
            "title" => translate($settings->headline_1 ?? 'Home'),
            "description" => translate($settings->description ?? 'Socialyt - Instagram & Facebook DM Automation'),
            "meta_keywords" => [],
        ];
    @endphp

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

    <!-- Detailed Solutions with Mockups -->
    <section class="py-5 bg-white">
        <div class="container py-5">
            <div class="row align-items-center mb-5 pb-5" id="ecommerce">
                <div class="col-md-6">
                    <div class="premium-3d-card-wrapper animate__animated animate__fadeInLeft">
                        <div class="premium-3d-card">
                            <img src="{{ asset('fashion_influencer_ecommerce_red_1777912440009.png') }}" alt="Ecommerce Influencer Pro" class="img-fluid rounded-5 shadow-lg">
                        </div>
                    </div>
                </div>
                <div class="col-md-5 ms-auto">
                    <div class="feature-text">
                        <div class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill mb-3">E-Commerce</div>
                        <h2 class="fw-bold mb-3 fs-1">Turn Comments into Customers</h2>
                        <p class="text-muted fs-5">
                            Automatically send product links or discount codes to anyone who comments on your posts.
                        </p>
                        <ul class="list-unstyled mt-4 d-grid gap-2">
                            <li><i class="fas fa-check-circle text-primary me-2"></i> Instant product link delivery</li>
                            <li><i class="fas fa-check-circle text-primary me-2"></i> Automated discount code sharing</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row align-items-center mb-5 pb-5 flex-row-reverse" id="partnership">
                <div class="col-md-6">
                    <div class="premium-3d-card-wrapper animate__animated animate__fadeInRight">
                        <div class="premium-3d-card">
                            <img src="{{ asset('fashion_influencer_partnership_gold_1777912536159.png') }}" alt="Partnership Influencer Pro" class="img-fluid rounded-5 shadow-lg">
                        </div>
                    </div>
                </div>
                <div class="col-md-5 me-auto">
                    <div class="feature-text">
                        <div class="badge bg-warning-subtle text-warning px-3 py-2 rounded-pill mb-3">Partnerships</div>
                        <h2 class="fw-bold mb-3 fs-1">Collab Success Guaranteed</h2>
                        <p class="text-muted fs-5">
                            Display up to 4 conversation starters when a user navigates to your Instagram Inbox.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-5 bg-light">
        <div class="container py-5">
            <div class="row g-4 text-center mb-5">
                <div class="col-md-3">
                    <div class="p-4 bg-white rounded-4 border">
                        <div class="display-5 fw-bold text-primary">50K+</div>
                        <div class="text-muted">Creators</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-4 bg-white rounded-4 border">
                        <div class="display-5 fw-bold text-primary">12M+</div>
                        <div class="text-muted">DMs Sent</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-4 bg-white rounded-4 border">
                        <div class="display-5 fw-bold text-primary">35%</div>
                        <div class="text-muted">Avg CTR</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-4 bg-white rounded-4 border">
                        <div class="display-5 fw-bold text-primary">24/7</div>
                        <div class="text-muted">Support</div>
                    </div>
                </div>
            </div>

            @php $count = 0; @endphp
            @foreach($stats as $stat)
                <div class="row align-items-center mb-5 pb-5 {{ $count % 2 == 0 ? '' : 'flex-row-reverse' }}">
                    <div class="col-md-6">
                        <img src="{{ asset('storage/' . $stat->image) }}" class="img-fluid rounded-4 shadow-lg" alt="{{ $stat->title }}">
                    </div>
                    <div class="col-md-5 {{ $count % 2 == 0 ? 'ms-auto' : 'me-auto' }}">
                        <h2 class="fw-bold mb-3">{{ $stat->title }}</h2>
                        <p class="text-muted">{{ $stat->description }}</p>
                    </div>
                </div>
                @php $count++; @endphp
            @endforeach
        </div>
    </section>

    <!-- Videos Grid -->
    <section class="py-5" id="creators">
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

@endsection

@push('script-push')
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
@endpush