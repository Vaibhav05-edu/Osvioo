@php
   $authElements   = get_content("element_authentication_section");
@endphp

<div class="col-xl-5 col-lg-5 d-none d-lg-block">
    <div class="auth-left-new">
        <div class="auth-left-content">
            <div class="auth-slider-wrapper">
                <div class="swiper auth-slider">
                    <div class="swiper-wrapper">
                        @foreach ( $authElements  as $element )
                            <div class="swiper-slide">
                                <div class="auth-slider-item">
                                    <div class="hero-image-wrapper">
                                        <img
                                            src="{{ asset('assets/images/auth/login-hero.png') }}"
                                            alt="Osvioo Creator"
                                            loading="lazy"
                                            class="auth-hero-img" />
                                    </div>

                                    <h4 class="text-white mt-4">
                                        {{@$element->value->title}}
                                    </h4>
                                    <p class="text-white opacity-75">
                                        {!!@$element->value->description!!}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .auth-left-new {
        background: linear-gradient(135deg, #0052FF 0%, #003EB3 100%);
        height: 100%;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 50px;
        position: relative;
        overflow: hidden;
    }

    .auth-left-new::before {
        content: '';
        position: absolute;
        top: -10%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        filter: blur(80px);
        border-radius: 50%;
    }

    .hero-image-wrapper {
        position: relative;
        z-index: 2;
    }

    .auth-hero-img {
        width: 100%;
        max-width: 450px;
        height: auto;
        border-radius: 40px;
        box-shadow: 0 40px 80px rgba(0,0,0,0.3);
        border: 10px solid rgba(255,255,255,0.1);
        transition: transform 0.5s ease;
    }

    .auth-hero-img:hover {
        transform: translateY(-10px) scale(1.02);
    }

    .auth-slider-item h4 {
        font-family: 'Outfit', sans-serif !important;
        font-weight: 800;
        font-size: 2rem;
        letter-spacing: -0.5px;
    }

    .auth-slider-item p {
        font-family: 'Outfit', sans-serif !important;
        font-size: 1.1rem;
        max-width: 400px;
        margin: 0 auto;
    }

    .swiper-pagination-bullet {
        background: white !important;
        opacity: 0.5;
    }

    .swiper-pagination-bullet-active {
        opacity: 1;
        width: 30px !important;
        border-radius: 10px !important;
    }
</style>
