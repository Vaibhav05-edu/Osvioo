@extends('layouts.master')
@section('content')

<!-- Hero Section -->
<style nonce="{{ csp_nonce() }}">
    .font-comic { font-family: "Comic Sans MS", "Comic Sans", cursive !important; }
    .font-outfit { font-family: 'Outfit', sans-serif !important; }
    
    .bg-white { background: #fff !important; }
    .bg-light-gray { background: #fbfbfb !important; }
    
    .text-dark-custom { color: #1A1A1A !important; }
    .text-gray-custom { color: #555 !important; }
    .text-light-gray { color: #444 !important; }
    .text-almost-black { color: #222 !important; }
    .text-gray-lightest { color: #333 !important; }
    .text-royal-dark { color: var(--royal-dark, #031B33) !important; }
    .text-white { color: white !important; }
    .text-royal-blue { color: var(--royal-blue) !important; }

    .max-w-600 { max-width: 600px; }
    .max-w-700 { max-width: 700px; }
    
    .letter-spacing-sm { letter-spacing: -0.03em; }
    .letter-spacing-md { letter-spacing: -0.04em; }

    .hero-gradient-wrapper {
        position: relative;
        background: #fff;
        overflow: hidden;
        padding-bottom: 60px;
    }
    .hero-gradient-wrapper::before {
        content: ''; position: absolute; top: 10%; left: -15%; width: 80%; height: 120%;
        background: radial-gradient(circle, rgba(59, 130, 246, 0.45) 0%, transparent 60%);
        filter: blur(120px); z-index: 1;
    }
    .hero-gradient-wrapper::after {
        content: ''; position: absolute; top: 10%; right: -15%; width: 80%; height: 120%;
        background: radial-gradient(circle, rgba(236, 72, 153, 0.4) 0%, transparent 60%);
        filter: blur(120px); z-index: 1;
    }
    
    .hero-content {
        position: relative; z-index: 10; min-height: 85vh;
        display: flex; align-items: center; padding-top: 80px;
    }
    
    .earnings-content { position: relative; z-index: 10; }
    
    .btn-pinkpurple-strip {
        background: linear-gradient(90deg, #D946EF 0%, #8B5CF6 100%);
        color: white !important; padding: 16px 0; width: 95%; max-width: 1000px;
        border-radius: 100px; font-size: 1.4rem; text-decoration: none;
        display: inline-block; box-shadow: 0 8px 25px rgba(217, 70, 239, 0.35);
        transition: transform 0.3s ease;
    }
    .btn-pinkpurple-strip:hover { transform: translateY(-3px); }

    .btn-royal-blue {
        background: var(--color-primary) !important; 
        color: white !important;
        box-shadow: 0 10px 30px rgba(0, 82, 255, 0.3) !important;
        transition: all 0.3s ease;
    }
    .btn-royal-blue:hover {
        background: #0040D0 !important;
        color: white !important;
        transform: translateY(-2px);
    }
    
    .steps-section { position: relative; z-index: 10; }
    
    .step-icon-base {
        width: 110px; height: 110px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem auto;
    }
    .step-icon-1 { background: linear-gradient(135deg, #FF6B6B, #D946EF); box-shadow: 0 15px 35px rgba(217, 70, 239, 0.3); }
    .step-icon-2 { background: linear-gradient(135deg, #3B82F6, #2DD4BF); box-shadow: 0 15px 35px rgba(59, 130, 246, 0.3); }
    .step-icon-3 { background: linear-gradient(135deg, #F59E0B, #FBBF24); box-shadow: 0 15px 35px rgba(245, 158, 11, 0.3); }

    .role-card {
        border-radius: 15px; transition: all 0.3s ease;
        border: 2px solid transparent; background: white;
    }
    .role-card:hover {
        transform: translateY(-5px); border-color: #D946EF;
        box-shadow: 0 15px 30px rgba(217, 70, 239, 0.15) !important;
    }
    .role-icon-dot {
        display: inline-block; width: 10px; height: 10px;
        border-radius: 50%; margin-right: 8px;
    }
    
    .fs-2-2rem { font-size: 2.2rem; }
    .fs-1-8rem { font-size: 1.8rem; }
    .fs-1-5rem { font-size: 1.5rem; }
    .fs-1-1rem { font-size: 1.1rem; }
    .fs-1-05rem { font-size: 1.05rem; }
    .fs-1rem { font-size: 1rem; }
    .fs-0-95rem { font-size: 0.95rem; }
    .fs-0-9rem { font-size: 0.9rem; }
    .fs-0-85rem { font-size: 0.85rem; }
    
    .icon-3-5rem { font-size: 3.5rem; }
    .icon-3rem { font-size: 3rem; }
</style>

<div class="hero-gradient-wrapper">
    <!-- Hero Section -->
    <section class="section-affiliate-hero hero-content">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-4 font-comic letter-spacing-md text-dark-custom">
                Join the <span class="font-comic text-royal-blue">Osvioo</span> Affiliate Program
            </h1>
            <p class="fs-5 text-muted mb-5 mx-auto font-comic max-w-700">
                Earn <strong class="text-dark">30% recurring commissions</strong> for every new customer you refer. 
                Partner with us and grow your income while helping creators succeed.
            </p>
            <a href="{{ auth_user('web') ? route('user.affiliate.index') : route('auth.register') }}" class="btn-pinkpurple-strip font-comic fw-bold">
                Apply Now &rarr;
            </a>
        </div>
    </section>

    <!-- Earnings Scale -->
    <section class="earnings-content py-5">
        <div class="container py-5 text-center">
            <h3 class="mb-5 font-outfit fs-1-5rem fw-normal text-gray-lightest">
                Scale your affiliate earnings with Osvioo
            </h3>
            <div class="row g-4 justify-content-center mt-2">
                <div class="col-md-4">
                    <h6 class="fw-bold mb-2 font-outfit fs-1rem text-almost-black">10 Person Lite Annual Plan</h6>
                    <p class="mb-1 font-outfit fs-0-85rem text-gray-custom">$326 x 10 = $3,260</p>
                    <p class="mb-0 font-outfit fs-0-9rem text-light-gray">You earn $978 💵</p>
                </div>
                <div class="col-md-4">
                    <h6 class="fw-bold mb-2 font-outfit fs-1rem text-almost-black">20 Person Premium Annual Plan</h6>
                    <p class="mb-1 font-outfit fs-0-85rem text-gray-custom">$425 x 20 = $8,500</p>
                    <p class="mb-0 font-outfit fs-0-9rem text-light-gray">You earn $2,550 💵</p>
                </div>
                <div class="col-md-4">
                    <h6 class="fw-bold mb-2 font-outfit fs-1rem text-almost-black">50 Person Enterprise Annual Plan</h6>
                    <p class="mb-1 font-outfit fs-0-85rem text-gray-custom">$2540 x 50 = $127,000</p>
                    <p class="mb-0 font-outfit fs-0-9rem text-light-gray">You earn $38,100 💵</p>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- 3 Easy Steps -->
<section class="py-5 bg-white steps-section">
    <div class="container py-5 text-center">
        <h2 class="fw-bold mb-5 font-outfit fs-1-8rem text-almost-black">
            Start earning in 3 easy steps
        </h2>
        <div class="row g-5 mt-4 justify-content-center">
            <div class="col-md-4">
                <div class="step-icon-base step-icon-1">
                    <i class="bi bi-person-fill text-white icon-3-5rem"></i>
                </div>
                <h6 class="fw-bold px-3 font-outfit fs-1-1rem text-almost-black">Register to be an affiliate</h6>
            </div>
            <div class="col-md-4">
                <div class="step-icon-base step-icon-2">
                    <i class="bi bi-megaphone-fill text-white icon-3rem"></i>
                </div>
                <h6 class="fw-bold px-3 font-outfit fs-1-1rem text-almost-black">Spread the word in your communities</h6>
            </div>
            <div class="col-md-4">
                <div class="step-icon-base step-icon-3">
                    <i class="bi bi-cash-coin text-white icon-3rem"></i>
                </div>
                <h6 class="fw-bold px-3 font-outfit fs-1-1rem text-almost-black">Start earning commissions</h6>
            </div>
        </div>
    </div>
</section>

<!-- Who Can Apply -->
<section class="py-5 bg-light-gray">
    <div class="container py-5">
        <h2 class="display-6 fw-bold text-center mb-5 font-outfit letter-spacing-sm text-dark">
            Who Can Apply?
        </h2>
        <div class="row g-4 justify-content-center">
            @php
                $roles = [
                    ['title' => 'Content Creators', 'color' => '#FF6B6B'],
                    ['title' => 'Coaches & Consultants', 'color' => '#D946EF'],
                    ['title' => 'Affiliate Marketers', 'color' => '#3B82F6'],
                    ['title' => 'Freelancers', 'color' => '#2DD4BF'],
                    ['title' => 'Entrepreneurs', 'color' => '#F59E0B'],
                    ['title' => 'Course Educators', 'color' => '#10B981'],
                    ['title' => 'Media Networks', 'color' => '#6366F1'],
                    ['title' => 'Bloggers & YouTubers', 'color' => '#EC4899']
                ];
            @endphp
            @foreach($roles as $index => $role)
            <style nonce="{{ csp_nonce() }}">
                .dot-{{ $index }} { background: {{ $role['color'] }}; }
            </style>
            <div class="col-md-3 col-6">
                <div class="card role-card shadow-sm text-center p-4 h-100 d-flex align-items-center justify-content-center">
                    <span class="fw-bold d-flex align-items-center text-start font-outfit fs-1-05rem text-royal-dark">
                        <span class="role-icon-dot dot-{{ $index }}"></span>
                        {{ $role['title'] }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5">
    <div class="container py-5 text-center">
        <h2 class="display-6 fw-bold mb-4 font-outfit letter-spacing-sm">
            Ready to start earning?
        </h2>
        <p class="fs-5 text-muted mb-5 mx-auto max-w-600 font-outfit">
            Join thousands of partners who are already earning recurring income with Osvioo.
        </p>
        <a href="{{ auth_user('web') ? route('user.affiliate.index') : route('auth.register') }}" class="btn btn-lg rounded-pill px-5 py-3 fw-bold btn-royal-blue font-outfit">
            {{ auth_user('web') ? 'Go to Affiliate Program →' : 'Get Started Free →' }}
        </a>
    </div>
</section>

<!-- Video Social Proof -->
@include('frontend.sections.video_social_proof')

<script nonce="{{ csp_nonce() }}">
    document.addEventListener('DOMContentLoaded', function() {
        const navLinks = document.querySelectorAll('.nav-link-wishlink');
        navLinks.forEach(link => {
            const text = link.innerText.trim();
            if (text === 'Affiliate') {
                link.classList.add('active-pill');
            } else {
                link.classList.remove('active-pill');
                link.classList.add('blue-text');
            }
        });
    });
</script>

@endsection
