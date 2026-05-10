@php
    $bannerContent = get_content("content_banner")->first();
    $heroTitlePart1 = "Get Real Instagram";
    $heroTitlePart2 = "Followers";
    $heroTitlePart3 = "Using Organic AI-Growth & Automation";
    $heroDesc = "No bots, no fake followers, no passwords. Gain real targeted followers automatically using AI, Instagram Experts and <span class='underline'>our patent-pending* technology.</span>";
@endphp

<section class="section-wishlink-hero">
    <div class="container">
        <div class="hero-content-wishlink">
            <h1 class="animate-fade-in">
                <span class="text-gradient-pink">{{ $heroTitlePart1 }}</span> 
                <span class="text-gradient-blue">{{ $heroTitlePart2 }}</span>
                <span class="sub-heading">{{ $heroTitlePart3 }}</span>
            </h1>
            <p class="animate-fade-in" style="animation-delay: 0.2s;">
                {!! $heroDesc !!}
            </p>

            <div class="hero-btn-group animate-fade-in" style="animation-delay: 0.4s;">
                <a href="{{ route('auth.login') }}" class="btn-glowing-dark">
                    Get Started <i class="bi bi-chevron-right" style="font-size: 0.9rem;"></i>
                </a>
                <a href="#" class="btn-glowing-outline">
                    Preview your growth
                </a>
            </div>

            <div class="social-proof-hero animate-fade-in" style="animation-delay: 0.6s;">
                <div class="proof-item">
                    <i class="bi bi-check2"></i>
                    2-Minute Setup
                </div>
                <div class="proof-item">
                    <i class="bi bi-check2"></i>
                    100% Growth Guaranteed
                </div>
                <div class="proof-item">
                    <span>Rated 4.91/5</span>
                    <div class="stars-container">
                        <div class="star-box"><i class="bi bi-star-fill"></i></div>
                        <div class="star-box"><i class="bi bi-star-fill"></i></div>
                        <div class="star-box"><i class="bi bi-star-fill"></i></div>
                        <div class="star-box"><i class="bi bi-star-fill"></i></div>
                        <div class="star-box half"><i class="bi bi-star-fill"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
