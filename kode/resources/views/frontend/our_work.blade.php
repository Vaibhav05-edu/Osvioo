@extends('layouts.master')

@section('content')
<div class="our-work-page">
    <!-- Hero Section -->
    <section class="work-hero">
        <div class="container-fluid px-0 h-100">
            <div class="row g-0 h-100 align-items-center">
                <!-- Left Content -->
                <div class="col-lg-6 ps-lg-5 pt-5 pt-lg-0 text-white z-index-10">
                    <div class="content-wrapper ps-lg-5">
                        <h1 class="display-1 fw-black mb-4">
                            Unlock next <br>
                            level growth <br>
                            with Creators
                        </h1>
                        <p class="fs-4 opacity-75 mb-5 pe-lg-5 fw-medium">
                            Osvioo is your new awareness and sales engine <br>
                            driven by Creators who genuinely love your Brand
                        </p>
                    </div>
                </div>

                <!-- Right Visual -->
                <div class="col-lg-6 position-relative h-100 d-flex align-items-center justify-content-end overflow-hidden">
                    <!-- The Big White Circle -->
                    <div class="wishlink-circle">
                        <!-- Logos on the rim -->
                        <div class="logo-on-rim" style="--angle: 0deg;"><img src="https://upload.wikimedia.org/wikipedia/commons/a/a9/Amazon_logo.svg" alt="Amazon"></div>
                        <div class="logo-on-rim" style="--angle: 45deg;"><img src="https://upload.wikimedia.org/wikipedia/commons/d/d5/H%26M_logo.svg" alt="H&M"></div>
                        <div class="logo-on-rim" style="--angle: 90deg;"><img src="https://www.vectorlogo.zone/logos/nykaa/nykaa-icon.svg" alt="Nykaa"></div>
                        <div class="logo-on-rim" style="--angle: 135deg;"><strong>LIBAS</strong></div>
                        <div class="logo-on-rim" style="--angle: 180deg;"><strong>SHOPSY</strong></div>
                        <div class="logo-on-rim" style="--angle: 225deg;"><strong>NEW ME</strong></div>
                        
                        <!-- Influencer Center -->
                        <div class="influencer-cutout">
                            <img src="{{asset('assets/images/our_work/hero.png')}}" alt="Influencers" class="main-influencer-img">
                        </div>
                    </div>
                    
                    <!-- Decorative S-Scroll -->
                    <div class="decorative-s">
                        <svg viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100,250 C100,100 400,100 400,250 C400,400 100,400 100,250" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="20" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Floating Bottom Bar -->
        <div class="floating-cta-bar">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center bg-white rounded-pill px-5 py-3 shadow-lg">
                    <p class="mb-0 fw-bold text-royal-blue">Partner with Osvioo to accelerate your growth</p>
                    <a href="{{route('auth.register')}}" class="btn btn-royal-blue rounded-pill px-4 fw-black">GET STARTED</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Numbers Section -->
    <section class="py-5 bg-light">
        <div class="container text-center py-5">
            <h2 class="display-3 fw-black mb-5">The proof is in the numbers</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="p-4">
                        <h4 class="display-4 fw-black text-royal-blue">100M+</h4>
                        <p class="text-muted">Combined Reach</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4">
                        <h4 class="display-4 fw-black text-royal-blue">50k+</h4>
                        <p class="text-muted">Monthly Conversions</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4">
                        <h4 class="display-4 fw-black text-royal-blue">15x</h4>
                        <p class="text-muted">Average ROI</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    :root {
        --royal-blue: var(--color-primary);
    }
    
    .work-hero {
        background-color: var(--royal-blue);
        height: 100vh;
        min-height: 800px;
        position: relative;
        overflow: hidden;
    }

    .fw-black { font-weight: 900; }
    .text-royal-blue { color: var(--royal-blue); }
    .btn-royal-blue { background-color: var(--royal-blue); color: white; }
    .btn-royal-blue:hover { background-color: #003EB3; color: white; }

    .z-index-10 { z-index: 10; }

    /* The White Circle Visual */
    .wishlink-circle {
        position: absolute;
        right: -150px;
        width: 800px;
        height: 800px;
        background: #FDF9F3; /* Slight off-white like wishlink */
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .logo-on-rim {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 120px;
        height: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
        transform: translate(-50%, -50%) rotate(var(--angle)) translateY(-340px) rotate(calc(-1 * var(--angle)));
        text-align: center;
        font-weight: 900;
        color: #000;
    }

    .logo-on-rim img {
        max-width: 80px;
        max-height: 40px;
        object-fit: contain;
    }

    .influencer-cutout {
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 100%;
        height: 80%;
        display: flex;
        align-items: flex-end;
        justify-content: center;
        overflow: hidden;
        border-radius: 0 0 400px 400px;
    }

    .main-influencer-img {
        width: 110%;
        height: auto;
        object-fit: cover;
        filter: drop-shadow(0 -20px 30px rgba(0,0,0,0.1));
    }

    .decorative-s {
        position: absolute;
        left: -100px;
        bottom: -50px;
        width: 600px;
        opacity: 0.5;
        pointer-events: none;
    }

    /* Floating Bar */
    .floating-cta-bar {
        position: absolute;
        bottom: 40px;
        width: 100%;
        z-index: 20;
    }

    @media (max-width: 991px) {
        .work-hero { height: auto; min-height: auto; padding-bottom: 150px; }
        .wishlink-circle {
            position: relative;
            right: 0;
            width: 400px;
            height: 400px;
            margin: 50px auto;
        }
        .logo-on-rim {
            width: 60px;
            height: 60px;
            transform: translate(-50%, -50%) rotate(var(--angle)) translateY(-170px) rotate(calc(-1 * var(--angle)));
        }
        .logo-on-rim img { max-width: 40px; }
        .display-1 { font-size: 3.5rem; }
        .floating-cta-bar p { font-size: 0.8rem; }
    }
</style>
@endsection
