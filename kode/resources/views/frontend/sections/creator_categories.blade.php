@php
    $categories = [
        [
            'name' => 'Fashion',
            'img' => asset('assets/images/custom/fashion.png'),
            'overlay' => 'COLLEGE OUTFIT IDEAS',
            'rotate' => '-2deg'
        ],
        [
            'name' => 'Beauty & Wellness',
            'img' => asset('assets/images/custom/beauty.png'),
            'overlay' => 'Nykaa Haul',
            'rotate' => '1deg'
        ],
        [
            'name' => 'Home Decor',
            'img' => asset('assets/images/custom/homedecor.png'),
            'overlay' => 'Macrame Lamp',
            'rotate' => '-1deg'
        ],
        [
            'name' => 'Lifestyle',
            'img' => asset('assets/images/custom/lifestyle.png'),
            'overlay' => 'Feel the Magic',
            'rotate' => '2deg'
        ],
        [
            'name' => 'Travel',
            'img' => asset('assets/images/custom/travel.png'),
            'overlay' => 'Create Your Adventure',
            'rotate' => '-1.5deg'
        ]
    ];
@endphp

<section class="section-categories py-5" id="categories">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="display-3 fw-bold mb-3" style="font-family: 'Outfit', sans-serif !important;">Are you one of them?</h2>
            <p class="fs-4 opacity-90 mx-auto" style="max-width: 800px; font-family: 'Outfit', sans-serif !important;">
                We work with Creators big and small, up and comers, trendsetters and market leaders. 
                We look for creators with interesting stories and exceptional content across categories.
            </p>
        </div>

        <div class="row g-3 justify-content-center mt-4">
            @foreach($categories as $category)
                <div class="col-6 col-md-4 col-lg-2-4">
                    <div class="category-card" style="transform: rotate({{ $category['rotate'] }});">
                        <div class="category-img-wrapper">
                            <img src="{{ $category['img'] }}" alt="{{ $category['name'] }}">
                            <div class="img-overlay-svg">
                                <svg viewBox="0 0 350 250" preserveAspectRatio="xMidYMid meet">
                                    <path id="curve-{{ $loop->index }}" d="M 10,180 A 165,165 0 0,1 340,180" fill="transparent" />
                                    <text>
                                        <textPath href="#curve-{{ $loop->index }}" startOffset="50%" text-anchor="middle">
                                            {{ $category['overlay'] }}
                                        </textPath>
                                    </text>
                                </svg>
                            </div>
                        </div>
                        <div class="category-label">
                            {{ $category['name'] }}
                        </div>
                    </div>
                </div>
            @endforeach

    </div>
</section>

<style nonce="{{ csp_nonce() }}">
    .col-lg-2-4 {
        width: 100%;
    }
    @media (min-width: 992px) {
        .col-lg-2-4 {
            flex: 0 0 19.5%;
            max-width: 19.5%;
        }
    }

    .section-categories .container {
        max-width: 1450px !important; /* Expanded container width */
    }

    .section-categories {
        background: linear-gradient(180deg, #FF8A00 0%, #FF5C00 100%);
        color: #fff;
        padding: 120px 0;
    }

    .category-card {
        background: #FFD200; 
        border-radius: 50px; /* Slightly more rounded */
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 25px 50px rgba(0,0,0,0.2);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .category-card:hover {
        transform: scale(1.05) rotate(0deg) !important;
        box-shadow: 0 30px 60px rgba(0,0,0,0.25);
        z-index: 10;
    }

    .category-img-wrapper {
        position: relative;
        width: 100%;
        aspect-ratio: 4/7; /* Further increased height */
        overflow: hidden;
        border-radius: 40px 40px 0 0;
    }

    .category-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .img-overlay-svg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 220px; /* Further increased height */
        pointer-events: none;
        z-index: 1;
    }

    .img-overlay-svg svg {
        width: 100%;
        height: 100%;
    }

    .img-overlay-svg text {
        font-family: 'Caveat', cursive !important;
        font-weight: 700;
        font-size: 38px; /* Slightly adjusted for better scale */
        fill: rgba(0,0,0,0.8);
        letter-spacing: 0.5px;
    }

    .category-label {
        background: #FFD200;
        color: #000;
        padding: 25px 20px;
        font-weight: 800;
        font-size: 1.4rem;
        text-align: left;
        font-family: 'Outfit', sans-serif !important;
        border-top: 1px solid rgba(0,0,0,0.05);
    }

    .creator-cta-stripe {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 100px;
        padding: 15px 50px;
        box-shadow: 0 15px 40px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        backdrop-filter: blur(10px);
    }

    .cta-text {
        color: #E64A19; /* Deep orange */
        font-family: 'Outfit', sans-serif !important;
        font-weight: 700;
        font-size: 1.8rem;
    }

    .btn-stripe-signup {
        background: linear-gradient(90deg, #FF8A00 0%, #FF5C00 100%);
        color: #fff !important;
        padding: 12px 40px;
        border-radius: 50px;
        text-decoration: none !important;
        font-weight: 800;
        font-size: 1.3rem;
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(255, 92, 0, 0.3);
    }

    .btn-stripe-signup:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 25px rgba(255, 92, 0, 0.4);
    }

    @media (max-width: 768px) {
        .creator-cta-stripe {
            border-radius: 30px;
            padding: 20px;
        }
        .cta-text {
            font-size: 1.2rem;
            text-align: center;
            width: 100%;
        }
        .btn-stripe-signup {
            width: 100%;
            justify-content: center;
            font-size: 1rem;
        }
        .category-label {
            font-size: 1.1rem;
            padding: 15px;
        }
    }
</style>
